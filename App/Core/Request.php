<?php
namespace App\Core;

class Request
{
    public static function method()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        return strtolower($method);
    }

    public static function isPost()
    {
        $method = self::method();

        if ($method === 'post') {
            return true;
        }
    }

    public static function isGet()
    {
        $method = self::method();

        if ($method === 'get') {
            return true;
        }
    }

    public static function postData()
    {
        $post = self::isPost();

        if ($post) {
            return $_POST;
        }
    }

    public static function path()
    {
        $url = $_SERVER['REQUEST_URI'];

        $slashposition = strrpos($url, '/');
        $queryposition = strrpos($url, '?');

        if ($slashposition) {
            if ($queryposition) {
                $path = substr($url, 0, $queryposition);
                return rtrim(ltrim($path, '/'), '/');
            }
            return rtrim(ltrim($url, '/'), '/');
        }
        
        return $url;
    }
}
