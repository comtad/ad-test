<?php

// Категории
\AdminSection::registerModel(\App\Category::class, function (\SleepingOwl\Admin\Model\ModelConfiguration $model) {
    $model->setTitle('Категории');

    // Таблица
    $model->onDisplay(function () {
        return \App\Admin\Sections\Categories::display();
    });

    // Формы
    $model->onCreate(function () {
        return \App\Admin\Sections\Categories::form();
    });
    $model->onEdit(function ($id) {
        return \App\Admin\Sections\Categories::form();
    });

    $model->addToNavigation(100, function () {
        return \App\Category::count();
    });
    $model->setIcon('fas fa-folder');
});

// Товары
\AdminSection::registerModel(\App\Product::class, function (\SleepingOwl\Admin\Model\ModelConfiguration $model) {
    $model->setTitle('Товары');

    // Таблица
    $model->onDisplay(function () {
        return \App\Admin\Sections\Products::display();
    });

    // Формы
    $model->onCreate(function () {
        return \App\Admin\Sections\Products::form();
    });
    $model->onEdit(function ($id) {
        return \App\Admin\Sections\Products::form();
    });

    $model->addToNavigation(200, function () {
        return \App\Product::count();
    });
    $model->setIcon('fas fa-box');
});
