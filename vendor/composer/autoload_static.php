<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit11b86a5ac7313d88ba34f6bf0706099e
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Picqer\\Barcode\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Picqer\\Barcode\\' => 
        array (
            0 => __DIR__ . '/..' . '/picqer/php-barcode-generator/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit11b86a5ac7313d88ba34f6bf0706099e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit11b86a5ac7313d88ba34f6bf0706099e::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
