<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit06ec8fcd258c5ec429154d28d49707cc
{
    public static $files = array (
        '7166494aeff09009178f278afd86c83f' => __DIR__ . '/..' . '/yahnis-elsts/plugin-update-checker/load-v4p13.php',
        'd5afeacfe11f422b161ec2bf0bc6940f' => __DIR__ . '/../..' . '/includes/Classifai/Helpers.php',
        'dd5471419f4d492e4967fd310ef99d1b' => __DIR__ . '/../..' . '/includes/Classifai/Blocks.php',
    );

    public static $prefixLengthsPsr4 = array (
        'U' => 
        array (
            'UAParser\\' => 9,
        ),
        'C' => 
        array (
            'Composer\\CaBundle\\' => 18,
            'Classifai\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'UAParser\\' => 
        array (
            0 => __DIR__ . '/..' . '/ua-parser/uap-php/src',
        ),
        'Composer\\CaBundle\\' => 
        array (
            0 => __DIR__ . '/..' . '/composer/ca-bundle/src',
        ),
        'Classifai\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes/Classifai',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit06ec8fcd258c5ec429154d28d49707cc::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit06ec8fcd258c5ec429154d28d49707cc::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit06ec8fcd258c5ec429154d28d49707cc::$classMap;

        }, null, ClassLoader::class);
    }
}
