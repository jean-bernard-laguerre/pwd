<?php namespace App;
    use DateTime;
    use PDO;
    class Category {

        public function __construct(
            private ?int $id = null,
            private ?string $name = null,
            private ?string $description = null,
            private ?DateTime $created_at = null,
            private ?DateTime $updated_at = null
        ) {

        }

        public function getId(): int {
            return $this->id;
        }
        public function getName(): string {
            return $this->name;
        }
        public function getDescription(): string {
            return $this->description;
        }
        public function getCreatedAt(): DateTime {
            return $this->created_at;
        }
        public function getUpdatedAt(): DateTime {
            return $this->updated_at;
        }
        
        public function setName(string $name): void {
            $this->name = $name;
        }
        public function setDescription(string $description): void {
            $this->description = $description;
        }

        /**
         * Create a new category
         * @return array
         */
        public function create(): void {
            $db = new Database();
            $req = $db->bdd->prepare("INSERT INTO category (name, description, created_at, updated_at)
                VALUES (:name, :description, :created_at, :updated_at)");
            $req->bindParam(':name', $this->name);
            $req->bindParam(':description', $this->description);
            $req->bindValue(':created_at', $this->created_at->format('Y-m-d H:i:s'));
            $req->bindValue(':updated_at', $this->updated_at->format('Y-m-d H:i:s'));
            $req->execute();
        }

        /**
         * Get all products in the category
         * @return array
         */
        public function getProducts(): array {
            $db = new Database();
            $req = $db->bdd->prepare("SELECT * FROM product WHERE category_id = :id");
            $req->bindParam(':id', $this->id);
            $req->execute();
            $result = $req->fetchAll(PDO::FETCH_ASSOC);

            foreach ($result as $product) {
                $product = new AbstractProduct(
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
                $products[] = $product;
            }

            return $products;
        }

        /**
         * find a category by id
         * @return array
         */
        public function findOneById(int $id): Category|bool {
            $db = new Database();
            $req = $db->bdd->prepare("SELECT * FROM category WHERE id = :id");
            $req->bindParam(':id', $id);
            $req->execute();
            $result = $req->fetch(PDO::FETCH_ASSOC);

            if($result) {
                return new Category(
                    $result['id'],
                    $result['name'],
                    $result['description'],
                    new DateTime($result['created_at']),
                    new DateTime($result['updated_at'])
                );
            }
            return false;
        }
    }
