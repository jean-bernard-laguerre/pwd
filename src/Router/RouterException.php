<?php
    namespace App;

    class RouterException extends \Exception {
        public function __construct(
            private string $message,
            private int $code = 0,
            private \Throwable $previous
        ) {
            parent::__construct($message, $code, $previous);
        }
    }