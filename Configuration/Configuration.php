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
            /* Skip Empty Line */
            if (trim(rtrim($line, "\n")) == '') {
                continue;
            }

            $parsedConfig = self::parseContent($line);

            self::$configs[$parsedConfig['key']] = $parsedConfig['value'];
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

    public static function set(string $key, string $value)
    {
        /* Check if key exists */
        if (!self::$configs[$key]) {
            return;
        }

        /* Check if values are the same */
        if (self::$configs[$key] == $value) {
            return;
        }

        /* Write to current array */
        self::$configs[$key] = $value;

        /* Write to file */
        file_put_contents(self::$path, self::convertConfigsToFile());
    }

    /**
     * Parse a line to key and value
     *
     * @param string $line
     * @return array
     */
    private static function parseContent(string $line): array
    {
        /* Get position of separator */
        $separatePosition = strpos($line, self::$separator);

        /* Get config key */
        $configName = trim(substr($line, 0, $separatePosition));

        /* Get config value */
        $configValue = trim(rtrim(substr($line, $separatePosition + 1), "\n"));

        /* Transfer config value to number */
        if (is_numeric($configValue)) {
            if ((int)$configValue == $configValue) { /* Is int */
                $configValue = (int)$configValue;
            } else { /* Is float */
                $configValue = (float)$configValue;
            }
        }

        return ['key' => $configName, 'value' => $configValue];
    }

    /**
     * Convert current configs to one string
     *
     * @return string
     */
    private static function convertConfigsToFile(): string
    {
        $content = '';
        $separator = self::$separator;

        /* Convert array to strings */
        foreach (self::$configs as $configName => $configValue) {
            $content .= $configName . $separator . $configValue . "\n";
        }

        return $content;
    }
}
