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
     * Set Path of Config File
     *
     * @param string $dir
     * @return void
     */
    public static function setPath(string $dir): void
    {
        self::$path = $_SERVER['DOCUMENT_ROOT'] . $dir;
    }

    /**
     * Change Config Key & Value Separator (Default: '=')
     *
     * @param string $separator
     * @return void
     */
    public static function setSeparator(string $separator): void
    {
        self::$separator = $separator;
    }

    /**
     * Parse File to Config Array
     *
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
            /* Skip Empty Line and Comment Line */
            if (trim(rtrim($line, "\n")) == '' || trim($line)[0] == '#') {
                continue;
            }

            /* Parse */
            $parsedConfig = self::parseContent($line);

            /* Set Config Array */
            self::$configs[$parsedConfig['key']] = $parsedConfig['value'];
        }
    }

    /**
     * Read Config Value with Key
     *
     * @param string $key
     * @return mixed
     */
    public static function read(string $key)
    {
        return self::$configs[$key];
    }

    /**
     * Set Config Value with Key
     * (Will Overwrite Comments and Empty Lines)
     *
     * @param string $key
     * @param string $value
     * @return void
     */
    public static function set(string $key, string $value): void
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
     * Parse a Line to Key and Value
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
        $configValue = trim(rtrim(substr($line, $separatePosition + strlen(self::$separator)), "\n"));

        /* Transform config value to number */
        if (is_numeric($configValue)) {
            /* Is int */
            if ((int)$configValue == $configValue) {
                $configValue = (int)$configValue;
            }

            /* Is float */
            else {
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
