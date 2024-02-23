<?php
    namespace App;

    class Route {
        public function __construct(
            private string $path,
            private string $callable
        ) {

        }

    }