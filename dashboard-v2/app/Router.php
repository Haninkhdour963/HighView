<?php

class Router
{
    private $routes = [];

    public function add($method, $route, $callback)
    {
        // Convert route patterns with {param} to regex
        $routePattern = preg_replace('/\{[a-zA-Z]+\}/', '([a-zA-Z0-9_-]+)', $route);
        $this->routes[$method]['#^' . $routePattern . '$#'] = $callback;
    }

    public function get($route, $callback)
    {
        $this->add('GET', $route, $callback);
    }

    public function post($route, $callback)
    {
        $this->add('POST', $route, $callback);
    }

    public function resource($resource, $controller)
    {
        $this->get("/$resource", "$controller@show");
        $this->get("/$resource/create", "$controller@create");
        $this->post("/$resource/create", "$controller@store");
        $this->get("/$resource/edit", "$controller@edit");
        $this->post("/$resource/update", "$controller@update");
        $this->post("/$resource/delete", "$controller@delete");

        $this->get("/$resource/order-history", "$controller@orderHistory");
        $this->get("/$resource/view", "$controller@view");
        // $this->get("/$resource", "$controller@viewOrder");
        // $this->get("/$resource", "$controller@viewOrder");

        // $this->get('/customers/view', 'CustomerController@view');
        // Add route for toggling coupon active status
        $this->post("/$resource/update-status", "$controller@updateStatus");
        $this->post("/$resource/update-reply-status", "$controller@updateReplyStatus");
    }

    public function dispatch($requestedRoute)
    {
        $method = $_SERVER['REQUEST_METHOD'];

        if (isset($this->routes[$method])) {
            foreach ($this->routes[$method] as $route => $callback) {
                // Update pattern to capture {id} as a parameter
                $routePattern = preg_replace('#\{(\w+)\}#', '(\d+)', $route);
                $routePattern = "#^" . trim($routePattern, '#') . "$#";

                if (preg_match($routePattern, $requestedRoute, $matches)) {
                    array_shift($matches); // Remove the full match

                    if (is_string($callback) && strpos($callback, '@') !== false) {
                        list($controllerName, $methodName) = explode('@', $callback);
                        $controllerFile = 'controllers/' . $controllerName . '.php';

                        if (file_exists($controllerFile)) {
                            require_once $controllerFile;
                            $controller = new $controllerName();
                            call_user_func_array([$controller, $methodName], $matches); // Pass matched parameters
                            return;
                        }
                    } elseif (is_callable($callback)) {
                        call_user_func_array($callback, $matches); // Call if callback is directly callable
                        return;
                    }
                }
            }
        }

        // Default to 404 page if route is not found
        require 'views/pages/404.view.php';
    }
}
