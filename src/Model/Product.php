<?php namespace App;
    use DateTime;
    use PDO;

    class Product extends AbstractProduct implements StockableInterface{

        public function __construct(
            protected ?int $id = null,
            protected ?string $name = null,
            protected ?array $photo = null,
            protected ?int $price = null,
            protected ?string $description = null,
            protected ?int $quantity = null,
            protected ?\DateTime $created_at = null,
            protected ?\DateTime $updated_at = null,
            protected ?int $id_category = null
        ) {
            parent::__construct($id, $name, $photo, $price, $description, $quantity, $created_at, $updated_at, $id_category);
        }


        /**
         * Find all products in the category with pagination
         * @return array
         */
        public function findPaginated($page): array
        {
            $db = new Database();
            $req = $db->bdd->prepare("SELECT * FROM product LIMIT 10 OFFSET :offset");
            $req->bindValue(':offset', ($page - 1) * 10, PDO::PARAM_INT);
            $req->execute();
            $products = $req->fetchAll(PDO::FETCH_ASSOC);
            $productsList = [];
            foreach ($products as $product) {
                array_push($productsList, new Product(
                    $product['id'],
                    $product['name'],
                    json_decode($product['photo']),
                    $product['price'],
                    $product['description'],
                    $product['quantity'],
                    new DateTime($product['created_at']),
                    new DateTime($product['updated_at']),
                    $product['category_id']
                ));
            }
            return $productsList;
        }

        /**
         * Find a product by id
         * @return AbstractProduct|bool
         */
        public function findOneById(int $id): AbstractProduct|bool
        {
            $db = new Database();
            $req = $db->bdd->prepare("SELECT * FROM product WHERE id = :id");
            $req->bindParam(':id', $id, PDO::PARAM_INT);
            $req->execute();
            $product = $req->fetch(PDO::FETCH_ASSOC);
            if($product) {
                return new Product(
                    $product['id'],
                    $product['name'],
                    json_decode($product['photo']),
                    $product['price'],
                    $product['description'],
                    $product['quantity'],
                    new DateTime($product['created_at']),
                    new DateTime($product['updated_at']),
                    $product['category_id']
                );
            }
            return false;
        }

        /**
         * Find all products
         * @return array
         */
        public function findAll(): array
        {
            $db = new Database();
            $req = $db->bdd->prepare("SELECT * FROM product");
            $req->execute();
            $products = $req->fetchAll(PDO::FETCH_ASSOC);
            $productsList = [];
            foreach ($products as $product) {
                array_push($productsList, new Product(
                    $product['id'],
                    $product['name'],
                    json_decode($product['photo']),
                    $product['price'],
                    $product['description'],
                    $product['quantity'],
                    new DateTime($product['created_at']),
                    new DateTime($product['updated_at']),
                    $product['category_id']
                ));
            }
            return $productsList;
        }

        /**
         * Add stock to the product
         * @return void
         */
        public function addStock(int $quantity): void {
            $this->quantity += $quantity;
            $this->save();
        }

        /**
         * Remove stock from the product
         * @return void
         */
        public function removeStock(int $quantity): void {
            $this->quantity -= $quantity;
            $this->save();
        }
    }