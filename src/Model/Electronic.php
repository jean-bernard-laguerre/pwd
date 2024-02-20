<?php namespace App;
    use DateTime;
    use PDO;
    class Electronic extends AbstractProduct implements StockableInterface {

        public function __construct(
            ?int $id = null,
            ?string $name = null,
            ?array $photo = null,
            ?int $price = null,
            ?string $description = null,
            ?int $quantity = null,
            ?DateTime $created_at = null,
            ?DateTime $updated_at = null,
            ?int $id_category = null,
            private ?string $brand = null,
            private ?int $warranty_fee = null
        ) {
            $this->id_category = 6;
            parent::__construct(
                $id,
                $name,
                $photo,
                $price,
                $description,
                $quantity,
                $created_at,
                $updated_at,
                $id_category
            );
        }

        public function getBrand(): string {
            return $this->brand;
        }
        public function setBrand(string $brand): void {
            $this->brand = $brand;
        }
        public function getWarrantyFee(): int {
            return $this->warranty_fee;
        }
        public function setWarrantyFee(int $warranty_fee): void {
            $this->warranty_fee = $warranty_fee;
        }

        /**
         * find all products in the category
         *
         * @param string $brand
         *
         * @return array
         */
        public function findAll(): array {
            $db = new Database();
            $req = $db->bdd->prepare("SELECT * FROM electronic
                INNER JOIN product ON electronic.product_id = product.id");
            $req->execute();
            $products = $req->fetchAll(PDO::FETCH_ASSOC);
            $electronics = [];
            foreach ($products as $product) {
                $electronic = new Electronic(
                    $product['id'],
                    $product['name'],
                    json_decode($product['photo']),
                    $product['price'],
                    $product['description'],
                    $product['quantity'],
                    new DateTime($product['created_at']),
                    new DateTime($product['updated_at']),
                    $product['category_id'],
                    $product['brand'],
                    $product['warranty_fee']
                );
                array_push($electronics, $electronic);
            }
            return $electronics;
        }

        /**
         * find all products in the category paginated
         *
         * @param int $page
         *
         * @return array
         */
        public function findPaginated($page): array
        {
            $db = new Database();
            $req = $db->bdd->prepare("SELECT * FROM electronic
                INNER JOIN product ON electronic.product_id = product.id LIMIT 10 OFFSET :offset");
            $req->bindValue(':offset', ($page - 1) * 10, PDO::PARAM_INT);
            $req->execute();
            $products = $req->fetchAll(PDO::FETCH_ASSOC);
            $electronics = [];
            foreach ($products as $product) {
                $electronic = new Electronic(
                    $product['id'],
                    $product['name'],
                    json_decode($product['photo']),
                    $product['price'],
                    $product['description'],
                    $product['quantity'],
                    new DateTime($product['created_at']),
                    new DateTime($product['updated_at']),
                    $product['category_id'],
                    $product['brand'],
                    $product['warranty_fee']
                );
                array_push($electronics, $electronic);
            }
            return $electronics;
        }

        /**
         * find a product by id
         *
         * @param int $id
         *
         * @return Electronic|bool
         */
        public function findOneById(int $id): Electronic|bool {
            $db = new Database();
            $req = $db->bdd->prepare("SELECT * FROM electronic
                INNER JOIN product ON electronic.product_id = product.id
                WHERE electronic.product_id = :id");
            $req->bindParam(':id', $id);
            $req->execute();
            $product = $req->fetch(PDO::FETCH_ASSOC);
            if($product) {
                return new Electronic(
                    $product['id'],
                    $product['name'],
                    json_decode($product['photo']),
                    $product['price'],
                    $product['description'],
                    $product['quantity'],
                    new DateTime($product['created_at']),
                    new DateTime($product['updated_at']),
                    $product['category_id'],
                    $product['brand'],
                    $product['warranty_fee']
                );
            }
            return false;
        }

        /**
         * Create a product
         *
         * @return self
         */
        public function create(): Electronic {
            
            parent::create();
            $db = new Database();
            $req = $db->bdd->prepare("INSERT INTO electronic (product_id, brand, warranty_fee)
                VALUES (:product_id, :brand, :warranty_fee)");
            $req->bindParam(':product_id', $this->id);
            $req->bindParam(':brand', $this->brand);
            $req->bindParam(':warranty_fee', $this->warranty_fee);
            if($req->execute()) {
                return $this;
            }
            return false;
        }

        /**
         * Update a product
         *
         * @return self
         */
        public function update(): Electronic {
            parent::update();
            $db = new Database();
            $req = $db->bdd->prepare("UPDATE electronic SET brand = :brand, warranty_fee = :warranty_fee
                WHERE product_id = :id");
            $req->bindParam(':brand', $this->brand);
            $req->bindParam(':warranty_fee', $this->warranty_fee);
            $req->bindParam(':id', $this->id);
            if($req->execute()) {
                return $this;
            }
            return false;
        }


        /**
         * Add stock to the product
         *
         * @return void
         */
        public function addStock(int $quantity): void {
            $this->quantity += $quantity;
        }

        /**
         * Remove stock to the product
         *
         * @return void
         */
        public function removeStock(int $quantity): void {
            $this->quantity -= $quantity;
        }
    }