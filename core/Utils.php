<?php
namespace Core;

class Utils {
    public static function toCamelCase($string)
    {
        $result = strtolower($string);

        preg_match_all('/_[a-z]/', $result, $matches);
        foreach($matches[0] as $match)
        {
            $c = str_replace('_', '', strtoupper($match));
            $result = str_replace($match, $c, $result);
        }
        return $result;
    }
    public static function toSnakeCase($string)
    {
        if ( preg_match ('/[A-Z]/', $string ) === 0 ) {
            return $string;
        }
        $pattern = '/([a-z])([A-Z])/';
        return strtolower ( preg_replace_callback ( $pattern,
            function ($a) {
                return $a[1] . "_" . strtolower ( $a[2] );
            }, $string ) );
    }
}