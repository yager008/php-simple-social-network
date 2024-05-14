<?php

class Router
{
    public static function handle($method = 'GET', $path ='/', $filename='')
    {
        $currentMethod = $_SERVER['REQUEST_METHOD'];
        $inputURI = $_SERVER['REQUEST_URI'];

        if ($currentMethod != $method)
        {
            return;
        }

        //echo "InputURI: {$inputURI}";

        $root = "/Projects/SimpleSN";

        $compareURI = $root . $path;

        if ($inputURI == $compareURI)
        {
            $novigateToURI = $filename;
            require_once $novigateToURI;
            exit();
        }
    }
}