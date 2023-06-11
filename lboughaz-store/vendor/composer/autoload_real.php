<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInite18263ec6172e53bc97d4d60ab1ec03e
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInite18263ec6172e53bc97d4d60ab1ec03e', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInite18263ec6172e53bc97d4d60ab1ec03e', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInite18263ec6172e53bc97d4d60ab1ec03e::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
