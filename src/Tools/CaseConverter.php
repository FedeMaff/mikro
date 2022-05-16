<?php

/**
 * CaseConverter.php
 * Mikro\Tools\CaseConverter
 *
 * PHP version 7.4
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */

namespace Mikro\Tools;

/**
 * Converter dedicato al CASE delle proprietà.
 * Questa utility, data una stringa, comprende il tipo di case in ingresso e
 * la converte nel case desiderato.
 *
 * Le stringhe in ingresso devono essere in 1 dei seguenti formati:
 * kebab-case, snake_case, PascalCase o camelCase
 *
 * @category  Class
 * @package   Mikro
 * @author    Federico Maffucci <m4ffucci@gmail.com>
 */
class CaseConverter
{
    /**
     * Convertire una stringa in formato: KebabCase
     *
     * @param string $string Stringa kebab-case, snake_case, PascalCase o camelCase
     *
     * @return string
     */
    public static function toKebabCase(string $string): string
    {
        $segments = self::stringToSegments($string);
        return implode('-', $segments);
    }

    /**
     * Convertire una stringa in formato: SnakeCase
     *
     * @param string $string Stringa kebab-case, snake_case, PascalCase o camelCase
     *
     * @return string
     */
    public static function toSnakeCase(string $string): string
    {
        $segments = self::stringToSegments($string);
        return implode('_', $segments);
    }

    /**
     * Convertire una stringa in formato: ascalCase
     *
     * @param string $string Stringa kebab-case, snake_case, PascalCase o camelCase
     *
     * @return string
     */
    public static function toPascalCase(string $string): string
    {
        $segments = self::stringToSegments($string);
        $segments = array_map(function ($segment) {
            return ucfirst($segment);
        }, $segments);
        return implode('', $segments);
    }

    /**
     * Convertire una stringa in formato: CamelCase
     *
     * @param string $string Stringa kebab-case, snake_case, PascalCase o camelCase
     *
     * @return string
     */
    public static function toCamelCase(string $string): string
    {
        $segments = self::stringToSegments($string);
        $segments = array_map(function ($segment) {
            return ucfirst($segment);
        }, $segments);
        $string = implode('', $segments);
        return strtolower(substr($string, 0, 1)) . substr($string, 1);
    }

    /**
     * Estrapola un array di stringhe ( segmenti ) data una stringa
     *
     * @param string $string Stringa kebab-case, snake_case, PascalCase o camelCase
     *
     * @return array
     */
    private static function stringToSegments(string $string): array
    {
        if (strpos($string, '-') !== false) {
            \preg_match_all('/([A-Za-z][A-Za-z0-9]+)-?/', $string, $matches);
            $segments = isset($matches[1]) ? $matches[1] : [];
            if (!empty($segments)) {
                return self::sanitizeStrings($segments);
            }
        }

        if (strpos($string, '_') !== false) {
            \preg_match_all('/([A-Za-z][A-Za-z0-9]+)_?/', $string, $matches);
            $segments = isset($matches[1]) ? $matches[1] : [];
            if (!empty($segments)) {
                return self::sanitizeStrings($segments);
            }
        }

        \preg_match_all('/(^[a-z][a-z0-9]+|^[a-z]$)|([A-Z][a-z0-9]+|^[A-Z]$)/', $string, $matches);
        $matches1 = isset($matches[1]) ? $matches[1] : [];
        $segments = isset($matches[2]) ? $matches[2] : [];
        $segments[0] = isset($matches1[0]) && !empty($matches1[0]) ? $matches1[0] : $segments[0];
        return self::sanitizeStrings($segments);
    }

    /**
     * Sanificazione stringhe di segmento
     *
     * @param array $strings Elenco di stringhe segmento
     *
     * @return string[]
     */
    private static function sanitizeStrings(array $strings): array
    {
        $strings = array_map(function ($string) {
            return strtolower($string);
        }, $strings);
        return $strings;
    }
}
