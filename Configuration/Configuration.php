<?php

namespace Senhung\Config;

class Configuration
{
    /** @var string $path */
    private static $path;
    /** @var array $configs */
    private static $configs;
    /** @var string $separator */
    private static $separator = '=';

    /**
     * @param string $dir
     */
    public static function setPath(string $dir)
    {
        self::$path = $_SERVER['DOCUMENT_ROOT'] . $dir;
    }

    /**
     * @param string $separator
     */
    public static function setSeparator(string $separator)
    {
        self::$separator = $separator;
    }

    /**
     * @return void
     */
    public static function initializeConfigs(): void
    {
        /* Check if file exists */
        if (!file_exists(self::$path)) {
            return;
        }

        /* Get content in config file */
        $lines = file(self::$path);

        /* Parse content to config array */
        foreach ($lines as $line) {
            $separatePosition = strpos($line, self::$separator);

            $configName = trim(substr($line, 0, $separatePosition));

            $configValue = trim(rtrim(substr($line, $separatePosition + 1), "\n"));

            /* Transfer config value to number */
            if (is_numeric($configValue)) {
                if ((int)$configValue == $configValue) { /* Is int */
                    $configValue = (int)$configValue;
                } else { /* Is float */
                    $configValue = (float)$configValue;
                }
            }

            self::$configs[$configName] = $configValue;
        }
    }

    /**
     * @param string $key
     * @return mixed
     */
    public static function read(string $key)
    {
        return self::$configs[$key];
    }
}
