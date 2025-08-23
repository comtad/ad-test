<?php

namespace App\Admin\Sections;

use App\Category;
use SleepingOwl\Admin\Contracts\Display\DisplayInterface;
use SleepingOwl\Admin\Contracts\Form\FormInterface;
use Illuminate\Http\UploadedFile;

class Products
{
    public static function display(): DisplayInterface
    {
        return \AdminDisplay::datatables()
            ->setHtmlAttribute('class', 'table-default')
            ->setColumns(
                \AdminColumn::text('id', '#')->setWidth('60px'),
                \AdminColumn::link('name', 'Название'),
                \AdminColumn::text('category.name', 'Категория'),
                \AdminColumn::text('slug', 'Slug'),
                \AdminColumn::text('price', 'Цена'),
                \AdminColumn::image('image', 'Картинка')->setWidth('80px'),
            )
            ->paginate(25);
    }

    public static function form(): FormInterface
    {
        return \AdminForm::panel()->addBody([
            \AdminFormElement::select('category_id', 'Категория', Category::class)
                ->setDisplay('name')->required(),

            \AdminFormElement::text('name', 'Название')->required(),
            \AdminFormElement::text('slug', 'Slug')
                ->setHelpText('Пусто — сгенерится из названия'),

            \AdminFormElement::number('price', 'Цена')->setStep(0.01)->required(),

            \AdminFormElement::image('image', 'Картинка')
                ->setUploadPath(function (UploadedFile $file) {
                    return 'products';
                }),

            \AdminFormElement::textarea('description', 'Описание')->setRows(5),
        ]);
    }
}
