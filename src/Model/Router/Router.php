<?php
    namespace App;
    use Exception;

    class Router {
        public function __construct(
            private string $url,
            private array $routes = []
        ) {

        }

        public function get($path, $callable) {
            $this->routes['GET'][] = new Route($path, $callable);
        }

        public function post($path, $callable) {
            $this->routes['POST'][] = new Route($path, $callable);
        }

        public function run() {
            if (!isset($this->routes[$_SERVER['REQUEST_METHOD']])) {
                throw new Exception('REQUEST_METHOD does not exist');
            }
            foreach ($this->routes[$_SERVER['REQUEST_METHOD']] as $route) {
                if ($route->getPath() === $this->url) {
                    return call_user_func($route->getCallable());
                }
            }
            throw new Exception('No matching routes');
        }
    }
            