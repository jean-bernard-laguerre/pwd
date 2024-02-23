<?php
    namespace App;

    class Renderer {

        const BASE_PATH  = 'src/Views/';

        public function __construct(
            private string $path
        ) {        }

        /**
         * Render a view
         * @param array $props
         * @return string
         */
        public function view(array $props = []): string {

            ob_start();
            extract($props, EXTR_SKIP);

            $fullPath = self::BASE_PATH . $this->path . '.php';

            require_once 'src/Includes/header.php';
            if ($this->pageIsAdmin()) {
                require_once 'src/Includes/adminHeader.php';
            }
            require_once $fullPath;
            require_once 'src/Includes/footer.php';

            return ob_get_clean();
        }

        /**
         * Check if the page is admin 
         * @return bool
         */
        public function pageIsAdmin(): bool {
            // check if the url is admin
            return strpos($_SERVER['REQUEST_URI'], '/admin') !== false;
        }

        public static function render(string $path): static{
            
            return new static($path);
        }

        public function __toString(): string {
            return $this->view();
        }
    }
