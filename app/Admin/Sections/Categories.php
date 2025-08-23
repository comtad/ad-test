<?php

namespace App\Admin\Sections;

use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;

class Categories
{
    /** Таблица */
    public static function display(): DisplayInterface
    {
        return \AdminDisplay::datatables()
            ->setHtmlAttribute('class', 'table-default')
            ->setColumns(
                \AdminColumn::text('id', '#')->setWidth('60px'),
                \AdminColumn::link('name', 'Название'),
                \AdminColumn::text('slug', 'Slug'),
                \AdminColumn::count('products', 'Товаров')
            )
            ->paginate(25);
    }

    /** Форма создания/редактирования */
    public static function form(): FormInterface
    {
        return \AdminForm::panel()->addBody([
            \AdminFormElement::text('name', 'Название')->required(),
            \AdminFormElement::text('slug', 'Slug')
        ]);
    }
}
