<?php

namespace appName\Routing;

class Router{
    private $url;
    private $routes= [];
    private $namedRoute = [];
    public function __construct($url){
        $this->url = $url;;
    }

    public function get($path, $callable, $name = null){
        return $this->add($path, $callable, $name, 'GET');
    }

    public function post($path, $callable, $name = null){
        return $this->add($path, $callable, $name, 'POST');
    }

    private function add($path, $callable, $name, $method){
        $route = new Route($path, $callable);
        $this->routes[$method][] = $route;
        if (is_string($callable && $name === null)) {
            $name = $callable;
        }
        if ($name) {
            $this->namedRoute[$name] = $route;
        }
        return $route;
    }

    public function run(){
        if (!isset($this->routes[$_SERVER['REQUEST_METHOD']])) {
            throw new RouterException('REQUEST_METHOD does not exist');
        }
        // echo '<pre>';
        // echo print_r($this->namedRoute);
        // echo '</pre>';

        foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
            if ($route->match($this->url)) {
                return $route->call();
            }
        }
        throw new RouterException("No matching routes");
    }

    public function url($name, $params = []){
        if (!isset($this->namedRoute[$name])) {
            throw new RouterException("N?o route matches this name");
        }
        return $this->namedRoute[$name]->getUrl($params);
    }
}