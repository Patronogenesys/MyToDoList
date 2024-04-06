<?php

use App\Controllers\AdminController;
use App\Controllers\AppController;
use App\Controllers\HomeController;
use App\Controllers\LogInController;
use App\Controllers\PageNotFoundController;
use App\Controllers\RegisterController;
use App\Kernel\Router\Route;

return [

    // Редирект на home
    Route::createGet('/', function () {
        header('Location: /home');
        exit ();
    }),

    Route::createGet('/home', [HomeController::class, 'index']),

    Route::createGet('/404', [PageNotFoundController::class, 'index']),

    Route::createGet('/app', [AppController::class, 'index']),
    Route::createGet('/app/getAllTasks', [AppController::class, 'getAllTasks']),
    Route::createPost('/app/updateAllTasks', [AppController::class, 'updateAllTasks']),
    Route::createPost('/app/addTask', [AppController::class, 'addTask']),
    Route::createPost('/app/deleteTask', [AppController::class, 'deleteTask']),

    Route::createGet('/login', [LogInController::class, 'index']),

    Route::createGet('/login', [LogInController::class, 'index']),
    Route::createPost('/login', [LogInController::class, 'login']),

    Route::createPost('/logout', [LogInController::class, 'logout']),

    Route::createGet('/register', [RegisterController::class, 'index']),
    Route::createPost('/register', [RegisterController::class, 'register']),

    Route::createGet('/admin', [AdminController::class, 'index']),
    Route::createPost('/admin/deleteUser', [AdminController::class, 'deleteUser']),
    Route::createPost('/admin/switchUserType', [AdminController::class, 'switchUserType']),
];
