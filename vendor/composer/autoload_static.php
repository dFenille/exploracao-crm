<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf67f017d4178fc721443de67b8b0d005
{
    public static $files = array (
        '0e6d7bf4a5811bfa5cf40c5ccd6fae6a' => __DIR__ . '/..' . '/symfony/polyfill-mbstring/bootstrap.php',
    );

    public static $prefixLengthsPsr4 = array (
        'Z' => 
        array (
            'Zend\\' => 5,
        ),
        'S' => 
        array (
            'Symfony\\Polyfill\\Mbstring\\' => 26,
            'Symfony\\Component\\Console\\' => 26,
        ),
        'D' => 
        array (
            'Doctrine\\Instantiator\\' => 22,
            'Doctrine\\Common\\Cache\\' => 22,
            'Doctrine\\Common\\' => 16,
        ),
        'A' => 
        array (
            'Abraham\\TwitterOAuth\\' => 21,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Zend\\' => 
        array (
            0 => __DIR__ . '/..' . '/zendframework/zendframework/library/Zend',
        ),
        'Symfony\\Polyfill\\Mbstring\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/polyfill-mbstring',
        ),
        'Symfony\\Component\\Console\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/console',
        ),
        'Doctrine\\Instantiator\\' => 
        array (
            0 => __DIR__ . '/..' . '/doctrine/instantiator/src/Doctrine/Instantiator',
        ),
        'Doctrine\\Common\\Cache\\' => 
        array (
            0 => __DIR__ . '/..' . '/doctrine/cache/lib/Doctrine/Common/Cache',
        ),
        'Doctrine\\Common\\' => 
        array (
            0 => __DIR__ . '/..' . '/doctrine/common/lib/Doctrine/Common',
        ),
        'Abraham\\TwitterOAuth\\' => 
        array (
            0 => __DIR__ . '/..' . '/abraham/twitteroauth/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'Z' => 
        array (
            'ZendXml\\' => 
            array (
                0 => __DIR__ . '/..' . '/zendframework/zendxml/library',
            ),
            'ZendDiagnostics\\' => 
            array (
                0 => __DIR__ . '/..' . '/zendframework/zenddiagnostics/src',
            ),
            'ZendDiagnosticsTest\\' => 
            array (
                0 => __DIR__ . '/..' . '/zendframework/zenddiagnostics/tests',
            ),
            'ZendDeveloperTools' => 
            array (
                0 => __DIR__ . '/..' . '/zendframework/zend-developer-tools/src',
            ),
            'ZFTool\\' => 
            array (
                0 => __DIR__ . '/..' . '/zendframework/zftool/src',
            ),
        ),
        'R' => 
        array (
            'Realestate\\MssqlBundle' => 
            array (
                0 => __DIR__ . '/..' . '/realestateconz/mssql-bundle',
            ),
        ),
        'D' => 
        array (
            'Doctrine\\ORM\\' => 
            array (
                0 => __DIR__ . '/..' . '/doctrine/orm/lib',
            ),
            'Doctrine\\DBAL\\' => 
            array (
                0 => __DIR__ . '/..' . '/doctrine/dbal/lib',
            ),
            'Doctrine\\Common\\Lexer\\' => 
            array (
                0 => __DIR__ . '/..' . '/doctrine/lexer/lib',
            ),
            'Doctrine\\Common\\Inflector\\' => 
            array (
                0 => __DIR__ . '/..' . '/doctrine/inflector/lib',
            ),
            'Doctrine\\Common\\Collections\\' => 
            array (
                0 => __DIR__ . '/..' . '/doctrine/collections/lib',
            ),
            'Doctrine\\Common\\Annotations\\' => 
            array (
                0 => __DIR__ . '/..' . '/doctrine/annotations/lib',
            ),
            'DoctrineORMModule\\' => 
            array (
                0 => __DIR__ . '/..' . '/doctrine/doctrine-orm-module/src',
            ),
            'DoctrineModule\\' => 
            array (
                0 => __DIR__ . '/..' . '/doctrine/doctrine-module/src',
            ),
        ),
        'B' => 
        array (
            'BjyProfiler' => 
            array (
                0 => __DIR__ . '/..' . '/bjyoungblood/bjy-profiler/src',
            ),
        ),
    );

    public static $classMap = array (
        'BjyProfiler\\Module' => __DIR__ . '/..' . '/bjyoungblood/bjy-profiler/Module.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf67f017d4178fc721443de67b8b0d005::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf67f017d4178fc721443de67b8b0d005::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInitf67f017d4178fc721443de67b8b0d005::$prefixesPsr0;
            $loader->classMap = ComposerStaticInitf67f017d4178fc721443de67b8b0d005::$classMap;

        }, null, ClassLoader::class);
    }
}
