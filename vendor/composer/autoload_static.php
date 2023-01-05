<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit624f3ae57c1d1b165ed98d99c495494b
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit624f3ae57c1d1b165ed98d99c495494b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit624f3ae57c1d1b165ed98d99c495494b::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit624f3ae57c1d1b165ed98d99c495494b::$classMap;

        }, null, ClassLoader::class);
    }
}
