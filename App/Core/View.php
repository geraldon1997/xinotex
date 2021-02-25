<?php
namespace App\Core;

class View
{
    public static function renderView($layout, $view, $params = null)
    {
        $viewpage = self::importView($view, $params);
        $layoutpage = self::importLayout($layout, $params);

        if (http_response_code() == 404) {
            return 'page not found';
        }

        $display = self::injectContent($viewpage, $layoutpage);
        return $display;
    }

    public static function importLayout($layout, $params = null)
    {
        $layout = 'App/Layouts/'.$layout.'.php';

        if (!file_exists($layout)) {
            Response::code(404);
            return 'page not found';
        }

        Response::code(200);
        ob_start();
        include_once $layout;
        return ob_get_clean();
    }

    public static function importView($view, $params = null)
    {
        $file = "App/Views/$view.php";

        if (!file_exists($file)) {
            Response::code(404);
            return 'page not found';
        }

        Response::code(200);
        ob_start();
        include_once $file;
        return ob_get_clean();
    }

    public static function injectContent($view, $layout)
    {
        return str_replace('{{content}}', $view, $layout);
    }
}
