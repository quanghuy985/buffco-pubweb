<?php

// autoload_real.php @generated by Composer

<<<<<<< .mine
class ComposerAutoloaderInit0ceb7dd2f63e07238221a30260514c48
=======
class ComposerAutoloaderInit4083aca84e50a85c57105b16419a4829
>>>>>>> .r92
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

<<<<<<< .mine
        spl_autoload_register(array('ComposerAutoloaderInit0ceb7dd2f63e07238221a30260514c48', 'loadClassLoader'), true, true);
=======
        spl_autoload_register(array('ComposerAutoloaderInit4083aca84e50a85c57105b16419a4829', 'loadClassLoader'), true, true);
>>>>>>> .r92
        self::$loader = $loader = new \Composer\Autoload\ClassLoader();
<<<<<<< .mine
        spl_autoload_unregister(array('ComposerAutoloaderInit0ceb7dd2f63e07238221a30260514c48', 'loadClassLoader'));
=======
        spl_autoload_unregister(array('ComposerAutoloaderInit4083aca84e50a85c57105b16419a4829', 'loadClassLoader'));
>>>>>>> .r92

        $vendorDir = dirname(__DIR__);
        $baseDir = dirname($vendorDir);

        $includePaths = require __DIR__ . '/include_paths.php';
        array_push($includePaths, get_include_path());
        set_include_path(join(PATH_SEPARATOR, $includePaths));

        $map = require __DIR__ . '/autoload_namespaces.php';
        foreach ($map as $namespace => $path) {
            $loader->set($namespace, $path);
        }

        $map = require __DIR__ . '/autoload_psr4.php';
        foreach ($map as $namespace => $path) {
            $loader->setPsr4($namespace, $path);
        }

        $classMap = require __DIR__ . '/autoload_classmap.php';
        if ($classMap) {
            $loader->addClassMap($classMap);
        }

        $loader->register(true);

        $includeFiles = require __DIR__ . '/autoload_files.php';
        foreach ($includeFiles as $file) {
<<<<<<< .mine
            composerRequire0ceb7dd2f63e07238221a30260514c48($file);
=======
            composerRequire4083aca84e50a85c57105b16419a4829($file);
>>>>>>> .r92
        }

        return $loader;
    }
}

<<<<<<< .mine
function composerRequire0ceb7dd2f63e07238221a30260514c48($file)
=======
function composerRequire4083aca84e50a85c57105b16419a4829($file)
>>>>>>> .r92
{
    require $file;
}
