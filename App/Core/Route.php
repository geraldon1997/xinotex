<?php
namespace App\Core;

class Route
{
    public static function init()
    {
        $requestpath = Request::path();
        $post = Request::isPost();

        $defaultclass = 'App\\Controllers\\Page';
        
        if ($requestpath !== '/') {
            $patharray = explode('/', $requestpath);
            $class = 'App\\Controllers\\'.ucfirst($patharray[0]);
            unset($patharray[0]);

            if (!class_exists($class)) {
                Response::code(404);
                return call_user_func([new $defaultclass, 'default']);
            }

            $method = $patharray[1];
            unset($patharray[1]);

            if (!method_exists(new $class, $method)) {
                Response::code(404);
                return call_user_func([new $class, 'default']);
            }

            if ($post) {
                $params = Request::postData();
            }

            $params = array_values($patharray);

            Response::code(200);
            return call_user_func([new $class, $method], $params);
        }

        if ($requestpath === '') {
            Response::code(200);
            return call_user_func([new $defaultclass, 'default']);
        }
        
        $requestpath = '/';
        Response::code(200);
        return call_user_func([new $defaultclass, 'default']);
    }
}
