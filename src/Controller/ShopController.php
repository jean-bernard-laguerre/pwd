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
         * @return void
         */
        public function index($page = 1): void {
            
            $product = new Product();
            $products = $product->findPaginated($page);

            echo Renderer::render('shop')->view(['products' => $products, 'page' => $page]);
        }

        /**
         * Show a product 
         * @param int $idProduct
         * 
         * @return void
         */
        public function showProduct($id): void {

            $errorMessage = null;
            
            if(isset($id)) {
                
                $product = new Product();
                $product = $product->findOneById($id);
        
                if(!$product) {
                    $errorMessage = 'Le produit demandé n\'existe pas';
                } else{
                    $category = new Category();
                    $category = $category->findOneById($product->getIdCategory());
                    
                    $categoryName = __NAMESPACE__ . "\\" . $category->getName();
                    $product = new $categoryName;
                    $product = $product->findOneById($id);
        
                    if(!$product) {
                        $errorMessage = 'Le produit demandé n\'est pas disponible';
                    }
                }
            }
        
            else {
                $errorMessage = 'Aucun produit n\'a été demandé';
            }

            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                if(isset($_POST['quantity'])) {
                    $this->setUser($_SESSION['user']);
                    $this->addProductToCart($_POST['quantity'], $id);
                }
            }

            echo Renderer::render('product')->view(['product' => $product, 'errorMessage' => $errorMessage]);
        }

        /**
         * Show the cart of the user
         * @return void
         */
        public function showCart(): void {

            $this->user = $_SESSION['user'];
            
            if ($this->user) {
                $cart = new Cart();
                $this->cart = $cart->getCart($this->user->getId());
                $cartProducts = $this->cart->getAllProducts();

                if($_SERVER['REQUEST_METHOD'] === 'POST') {
                    if(isset($_POST['delete_product'])) {
                        $this->deleteProductFromCart(intval($_POST['delete_product']));
                    }
                    if(isset($_POST['add_product'])) {
                        $this->addProductToCart(1, intval($_POST['add_product']));
                    }
                    if(isset($_POST['remove_product'])) {
                        $this->addProductToCart(-1, intval($_POST['remove_product']));
                    }
                    header("Location: /pwd/cart");
                }
            
                echo Renderer::render('cart')->view(
                    ['products' => $cartProducts,
                    'profile' => $this->user]
                );
            } else {
                header("Location: /pwd/login");
            }
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
    