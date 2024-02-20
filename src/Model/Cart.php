<?php
namespace App;
use PDO;

class Cart
{
    function __construct(
        private ?int $id = null,
        private ?int $id_user = null,
        ){

    }

        /**
         * Get the value of id
         *
         * @return ?int
         */
        public function getId(): ?int
        {
                return $this->id;
        }

        /**
         * Set the value of id
         *
         * @param ?int $id
         *
         * @return self
         */
        public function setId(?int $id): self
        {
                $this->id = $id;

                return $this;
        }

        /**
         * Get the value of id_user
         *
         * @return ?int
         */
        public function getIdUser(): ?int
        {
                return $this->id_user;
        }

        /**
         * Set the value of id_user
         *
         * @param ?int $id_user
         *
         * @return self
         */
        public function setIdUser(?int $id_user): self
        {
                $this->id_user = $id_user;

                return $this;
        }


        /**
         * Create a cart
         *
         * @param int $id_user
         * @return bool
         */
        public function createCart($id_user): bool{
            $req = "INSERT INTO cart (id_user) VALUE(:idUser)";
            $db = new Database();
            $req = $db->bdd->prepare($req);
            $req->bindParam(':idUser', $id_user, PDO::PARAM_INT);
            if($req->execute()){
                $this->id = $db->bdd->lastInsertId();
                return true;
            }
            return false;
        }

        /**
         * Get a cart
         *
         * @param int $idUser
         * @return Cart|null
         */
        public function getCart($idUser): Cart|null
        {
            $req = "SELECT * FROM cart WHERE id = :idUser";
            $db = new Database();
            $req = $db->bdd->prepare($req);
            $req->bindParam(":idUser", $idUser);
            $req->execute();
            $result = $req->fetch(PDO::FETCH_ASSOC);
            if($result){
                return new Cart($result['id'], $result['id_user']);
            }
            return null;
        }
        
        /**
         * Add/update a product to the cart
         *
         * @return ?void
         */
        public function addProduct($product_id, $quantity): void{
            $db = new Database();

            $req = "SELECT * FROM cart_product WHERE id = :id AND id_product = :id_product";
            $req = $db->bdd->prepare($req);
            $req->bindParam(":id", $this->id);
            $req->bindParam(":id_product", $product_id);
            $req->execute();
            $result = $req->fetch(PDO::FETCH_ASSOC);

            if($result){
                $quantity = $result['id_quantity'] + $quantity;
                if($quantity > 0) {
                    $this->updateProduct($product_id, $quantity);
                } else {
                    $this->deleteProduct($product_id);
                }
            } else {
                $req = "INSERT INTO cart_product (id, id_product, id_quantity) VALUES (:id, :id_product, :id_quantity)";
                $req = $db->bdd->prepare($req);
                $req->bindParam(":id", $this->id);
                $req->bindParam(":id_product", $product_id);
                $req->bindParam(":id_quantity", $quantity);
                $req->execute();
            }
        }

        /**
         * Update a product in the cart
         *
         * @return ?void
         */
        public function updateProduct($product_id, $quantity): void{
            $req = "UPDATE cart_product SET id_quantity = :id_quantity WHERE id = :id AND id_product = :id_product";
            $db = new Database();
            $req = $db->bdd->prepare($req);
            $req->bindParam(":id_product", $product_id);
            $req->bindParam(":id_quantity", $quantity);
            $req->bindParam(":id", $this->id);
            $req->execute();

        }

        /**
         * Delete a product from the cart
         *
         * @return ?void
         */
        public function deleteProduct($product_id): void {
            $req = "DELETE FROM cart_product WHERE id_product = :id_product AND id = :id";
            $db = new Database();
            $req = $db->bdd->prepare($req);
            $req->bindParam(":id_product", $product_id);
            $req->bindParam(":id", $this->id_user);
            $req->execute();
        }

        /**
         * Get all products in the cart
         *
         * @return array
         */
        public function getAllProducts(): array{
            $req = "SELECT 
            cart_product.*, 
            product.*, 
            category.*, 
            product.name AS product_name,
            category.name AS category_name
            FROM cart_product
            LEFT JOIN product ON cart_product.id_product = product.id
            INNER JOIN category ON product.category_id = category.id;";
          
            
             $db = new Database();
            $req = $db->bdd->prepare($req);
            $req->execute();
            $products = $req->fetchAll(PDO::FETCH_ASSOC);
            return $products;

        }

      



}
