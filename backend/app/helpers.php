<?php

use Faker\Factory;
use Faker\Generator;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;


if (!function_exists('tinker')) {
    function tinker(...$args)
    {
        /*
         * Thank you Caleb
         * See: https://github.com/calebporzio/awesome-helpers/blob/master/src/helpers/tinker.php
         */
        $namedParameters = Collection::make(debug_backtrace())
            ->where('function', 'tinker')->take(1)
            ->map(function ($slice) {
                return array_values($slice);
            })
            ->mapSpread(function ($filePath, $lineNumber, $function, $args) {
                return file($filePath)[$lineNumber - 1];
                // "    tinker($post, new User);"
            })->map(function ($carry) {
                return Str::before(Str::after($carry, 'tinker('), ');');
                // "$post, new User"
            })->flatMap(function ($carry) {
                return array_map('trim', explode(',', $carry));
                // ["post", "new User"]
            })->map(function ($carry, $index) {
                return strpos($carry, '$') === 0
                    ? Str::after($carry, '$')
                    : 'temp' . $index;
                // ["post", "temp1"]
            })
            ->combine($args)
            ->all();

        exec('open "tinkerwell://?cwd=' . base64_encode(base_path()) . '&scope=' . base64_encode(serialize($namedParameters)) . '"');
    }
}

function faker(): Generator
{
    return Factory::create();
}

function svg($filename): HtmlString
{
    return new HtmlString(
        file_get_contents(resource_path("svg/{$filename}.svg"))
    );
}

function gravatar_img(string $name): HtmlString
{
    $gravatarId = md5(strtolower(trim($name)));

    return new HtmlString('<img src="https://gravatar.com/avatar/' . $gravatarId . '?s=240">');
}
