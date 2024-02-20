<?php namespace App;

    class ShopController {

        public function __construct(
            private ?Cart $cart = null,
            private ?User $user = null,
        ) {

        }

        public function getCart(): Cart {
            return $this->cart;
        }
        public function setCart(Cart $cart): void {
            $this->cart = $cart;
        }
        public function getUser(): User {
            return $this->user;
        }
        public function setUser(User $user): void {
            $this->user = $user;
        }

        /**
         * Get all products paginated
         * @param int $page
         * @return array
         */
        public function index($page): array {
            
            $product = new Product();

            return $product->findPaginated($page);
        }

        /**
         * Show a product
         * @param int $idProduct
         * @param string $productType
         * @return AbstractProduct
         */
        public function showProduct($idProduct, $productType): AbstractProduct {
            
            $auth = new AuthenticationController();
            if ($auth->profile()) {
                $product = new $productType();
                return $product->findOneById($idProduct);
            } else {
                header('Location: /login');
            }
        }

        /**
         * Show the cart of the user
         * @return array
         */
        public function showCart(): array {
            $auth = new AuthenticationController();
            $this->user = $auth->profile();
            $cart = new Cart();
            $this->cart = $cart->getCart($this->user->getId());
            return $this->cart->getAllProducts();
        }

        /**
         * Add a product to the cart
         * @param int $quantity
         * @param int $productId
         * @return void
         */
        public function addProductToCart($quantity, $productId): void {
            
            $this->cart ??= new Cart();
            if ($this->user) {
                $this->cart->setIdUser($this->user->getId());
                $this->cart = $this->cart->getCart($this->user->getId());
            }
        
            
            if(!$this->cart) {
                $this->cart = new Cart();
                $this->cart->setIdUser($this->user->getId());
                $this->cart->createCart($this->user->getId());
            }
            
            $this->cart->addProduct($productId, $quantity);
        }

        /**
         * Delete a product from the cart
         * @param int $idProduct
         * @return void
         */
        public function deleteProductFromCart($idProduct): void {

            $this->cart ??= new Cart();
            if ($this->user) {
                $this->cart->setIdUser($this->user->getId());
                $this->cart = $this->cart->getCart($this->user->getId());
            }
            if($this->cart){
                $this->cart->deleteProduct($idProduct);
            }
        }
    }
    