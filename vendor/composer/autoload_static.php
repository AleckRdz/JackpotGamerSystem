<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit950bcf0360d509f1c43695286ee91317
{
    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit950bcf0360d509f1c43695286ee91317::$classMap;

        }, null, ClassLoader::class);
    }
}