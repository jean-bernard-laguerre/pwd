<?php
    namespace App;

    class AdminController {

        public function __construct(
            private User $user = new User(),
            private Product $product = new Product(),
            private Category $category = new Category(),
            private Cart $cart = new Cart(),
        ) {

        }

        /**
         * Show the admin page
         * @return void
         */
        public function index() {
            echo Renderer::render('admin');
        }

        // User management
        /**
         * Get the list of users
         * @return void
         */
        public function getUsersList() {
            $users = $this->user->findAll();
            echo Renderer::render('Admin/Users/List')->view(['users' => $users]);
        }
        /**
         * Get the details of a user
         * @param int $id
         * @return void
         */
        public function getUserDetails(int $id) {
            $user = $this->user->findOneById($id);
            echo Renderer::render('Admin/Users/Details')->view(['user' => $user]);
        }
        /**
         * Delete a user
         * @param int $id
         * @return void
         */
        public function deleteUser(int $id) {
            return $this->user->delete($id);
        }
        /**
         * Edit a user
         * @param int $id
         * @return void
         */
        public function editUser(
            int $id
        ) {
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $role = $_POST['role'];

            return $this->user->update($id, $fullname, $email, $password, $role);
        }

        // Product management
        /**
         * Get the list of products
         * @return void
         */
        public function getProductList() {
            $products = $this->product->findAll();
            echo Renderer::render('Admin/Products/List')->view(['products' => $products]);
        }
        /**
         * Get the details of a product
         * @param int $id
         * @return void
         */
        public function getProductDetails(int $id) {
            $product = $this->product->findOneById($id);
            echo Renderer::render('Admin/Products/Details')->view(['product' => $product]);
        }
        /**
         * Delete a product
         * @param int $id
         * @return void
         */
        public function deleteProduct(int $id) {
            return $this->product->delete($id);
        }
        /**
         * Edit a product
         * @param int $id
         * @return void
         */
        public function editProduct(
            int $id
        ) {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $image = $_POST['image'];

            return $this->product->update($id, $name, $description, $price, $image);
        }

        // Category management
        /**
         * Get the list of categories
         * @return void
         */
        public function getCategoriesList() {
            $categories = $this->category->findAll();
            echo Renderer::render('Admin/Categories/List')->view(['categories' => $categories]);
        }
        /**
         * Get the details of a category
         * @param int $id
         * @return void
         */
        public function getCategoryDetails(int $id) {
            $category = $this->category->findOneById($id);
            echo Renderer::render('Admin/Categories/Details')->view(['category' => $category]);
        }
        /**
         * Delete a category
         * @param int $id
         * @return void
         */
        public function deleteCategory(int $id) {
            return $this->category->delete($id);
        }
        /**
         * Edit a category
         * @param int $id
         * @return void
         */
        public function editCategory(
            int $id
        ) {
            $name = $_POST['name'];
            $description = $_POST['description'];

            return $this->category->update($id, $name, $description);
        }

        // Cart management
        /**
         * Get the list of carts
         * @return void
         */
        public function getCartList() {
            $carts = $this->cart->findAll();
            echo Renderer::render('Admin/Carts/List')->view(['carts' => $carts]);
        }
        /**
         * Get the details of a cart
         * @param int $id
         * @return void
         */
        public function getCartDetails(int $id) {
            echo Renderer::render('Admin/Carts/Details')->view(['cart' => $this->cart->findOneById($id)]);
        }
        /**
         * Delete a cart
         * @param int $id
         * @return void
         */
        public function deleteCart(int $id) {
            return $this->cart->delete($id);
        }
        /**
         * Edit a cart
         * @param int $id
         * @return void
         */
        public function editCart(int $id) {

            $product_id = $_POST['product_id'];
            $quantity = $_POST['quantity'];

            $cart = $this->cart->findOneById($id);

            if ($quantity !== 0) {
                return $cart->addProduct($product_id, $quantity);
            } else {
                return $cart->deleteProduct($product_id);
            }
        }
    }