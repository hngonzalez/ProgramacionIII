<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1b186e0715b5980407b9b245a9bca98c
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit1b186e0715b5980407b9b245a9bca98c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit1b186e0715b5980407b9b245a9bca98c::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
