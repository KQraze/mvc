<?php

use Src\Route;


Route::add('GET', '/', [Controller\Site::class, 'index']);

Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup']);
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);

Route::add('GET', '/employees', [Controller\Site::class, 'employees'])->middleware('auth', 'admin');
Route::add(['GET', 'POST'], '/employees/add', [Controller\Site::class, 'employeesAdd'])->middleware('auth', 'admin');

Route::add(['GET', 'POST'], '/groups', [Controller\Site::class, 'groups'])->middleware('auth', 'employee');
Route::add(['GET', 'POST'], '/groups/add', [Controller\Site::class, 'groupsAdd'])->middleware('auth', 'employee');