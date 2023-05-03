<?php

function locale()
{
    return Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale();
}

function locales()
{
    $arr = [];
    foreach (Mcamara\LaravelLocalization\Facades\LaravelLocalization::getSupportedLocales() as $key => $value) {
        $arr[$key] = __('' . $value['name']);
    }
    return $arr;
}

?>