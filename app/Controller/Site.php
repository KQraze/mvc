<?php

namespace Controller;

use Model\Group;
use Model\Mark;
use Model\Role;
use Model\StudentMark;
use Model\User;
use Src\Auth\Auth;
use Src\Request;
use Src\View;
use Src\Validator\Validator;

class Site
{

    public static function registerValidator(Request $request): Validator
    {
        return new Validator(
            $request->all(),
            [
                'name' => ['required'],
                'login' => ['required', 'unique:users,login'],
                'password' => ['required'],
            ],
            [
                'required' => 'Поле :field пусто',
                'unique' => 'Поле :field должно быть уникально'
            ]
        );
    }


    /** `Guest` users */
    public function index(Request $request): string
    {
        return (new View())->render('site.index');
    }
    public function signup(Request $request): string
    {
        if ($request->method === 'POST') {
            $validator = self::registerValidator($request);

            if ($validator->fails()) {
                return new View('site.signup', ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]);
            }

            if (User::create([...$request->all(), 'role_id' => 1])) {
                app()->route->redirect('/login');
            }
        }

        return new View('site.signup');
    }
    public function login(Request $request): string
    {
        if ($request->method === 'GET') {
            return new View('site.login');
        }

        if (Auth::attempt($request->all())) {
            app()->route->redirect('/');
        }

        return new View('site.login', ['message' => 'Неправильные логин или пароль']);
    }

    /** `Admin` */
    public function employeesAdd(Request $request): string
    {
        if ($request->method === 'POST') {
            $validator = self::registerValidator($request);

            if ($validator->fails()) {
                return new View('site.employeesAdd', ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]);
            }

            if (User::create([...$request->all(), 'role_id' => 2])) {
                app()->route->redirect('/employees');
            }
        }


        return (new View())->render('site.employeesAdd');
    }
    public function employees(Request $request): string
    {
        $data = User::query()->where('role_id', 2)->get()->map(function ($employee) {
            return [
                'id' => $employee->id,
                'name' => $employee->name,
                'role' => Role::where('id', $employee->role_id)->first()['name']
            ];
        });

        $localize = ['id' => 'Номер сотрудника', 'name' => 'Имя сотрудника'];

        return (new View())->render('site.employees', [
            'employees' => $data->toArray(),
            'localize' => $localize
        ]);
    }

    /** `Employee` */
    public function groups(Request $request): string
    {
        $groups = Group::query()
            ->with('groupStudents.student.studentMarks.mark')
            ->with('groupDisciplines.discipline')
            ->get()->map(function ($group) {
                return [
                    'title' => $group->title,
                    'semester' => $group->semester,
                    'course' => $group->course,
                    'students' => $group->groupStudents,
                    'disciplines' => $group->groupDisciplines
                ];
            });

        $marks = Mark::all()->all();

        $reducedGroups = array_reduce($groups->toArray(), function ($acc, $group) {
            if (!key_exists($group['title'], $acc)) {
                $acc[$group['title']] = [$group];
            } else {
                $acc[$group['title']] = [...$acc[$group['title']], $group];
            }
            return $acc;
        }, []);

        $localize = [
            'title' => 'Группа',
            'course' => 'Курс',
            'semester' => 'Семестр',
            'students_count' => 'Кол-во студентов'
        ];

        $data = ['groups' => $reducedGroups, 'localize' => $localize, 'marks' => $marks];


        if ($request->method === 'POST') {
            $validator = new Validator($request->all(),
                [
                    'mark_id' => ['required'],
                ],
                [
                    'required' => 'Поле :field пусто',
                ]);

            if ($validator->fails()) {
                return new View('site.groups', [...$data, 'message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]);
            }

            // Обновляем существующую оценку или создаём новую
            StudentMark::updateOrCreate(
                [
                    'student_id' => $request->get('student_id'),
                    'discipline_id' => $request->get('discipline_id')
                ],
                [
                    'mark_id' => $request->get('mark_id'),
                ]
            );
        }

        return (new View())->render('site.groups', $data);
    }
    public function groupsAdd(Request $request): string
    {
        if ($request->method === 'POST') {
            $validator = new Validator($request->all(),
            [
                'title' => ['required'],
                'course_count' => ['required']
            ],
            [
                'required' => 'Поле :field пусто',
            ]);

            for ($i = 1; $i <= (int)$request->get('course_count'); $i++) {
                if (
                    Group::create([
                    'title' => $request->get('title'),
                    'course' => $i,
                    'semester' => 1
                    ])
                    &&
                    Group::create([
                        'title' => $request->get('title'),
                        'course' => $i,
                        'semester' => 2
                    ])) {
                    app()->route->redirect('/groups');
                }
            }

            if ($validator->fails()) {
                return new View('site.groupsAdd', ['message' => json_encode($validator->errors(), JSON_UNESCAPED_UNICODE)]);
            }
        }

        return (new View())->render('site.groupsAdd');
    }

    /** `Auth` */
    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/');
    }
}