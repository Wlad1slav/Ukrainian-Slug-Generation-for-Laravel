<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait SlugGenerationTrait
{

    const TRANSLITERATION = [
        // Літери, правильну транслітерацію яких,
        // метод Str::slug не підтримує
        'г' => 'h', 'ґ' => 'g',
        'е' => 'e', 'є' => 'ie',
        'и' => 'y', 'і' => 'i',
        'й' => 'j', 'ї' => 'ji',
        'х' => 'kh',
    ];

    private static function transliterationUkrainianCharacters(string $str): string {
        // Замінює усі українські літери,
        // що не підтримують методом Str::slug
        return str_replace(
            array_keys(self::TRANSLITERATION),
            array_values(self::TRANSLITERATION),
            mb_strtolower($str)
        );
    }

    private static function getSlug(string $str): string {
        // Str::slug перетворює усі кириличні символи,
        // які не зачепив метод transliterationUkrainianCharacters
        return Str::slug(self::transliterationUkrainianCharacters($str));
    }

    private static function createOriginalSlug(string $str, $model, string $column='slug'): string
    {   // Створення оригінального slug

        $slug = self::getSlug($str); // Генерація slug
        $duplicates = $model::where($column, $slug)->get()->count(); // Отримання кількості рядків з таким же slug

        // Метод отримує екземпляр певної моделі та перевіряє,
        // чи існує в таблиці цієї моделі ще один рядок з таким же slug, як в згенерованої вище змінної.
        if ($duplicates > 0) { // Якщо кількість slug більше нуля, то додається номер з таким же slug
            while (true) {
                if ($model::where($column, "$slug-$duplicates")->get()->count() > 0)
                    $duplicates++;
                else return "$slug-$duplicates";
            }
        }

        return $slug;
    }

}
