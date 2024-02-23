<?php
    namespace App;
    use PDO;

    class User {

        public function __construct(
            private ?int $id = null,
            private ?string $fullname = null,
            private ?string $email = null,
            private ?string $password = null,
            private ?array $role = ['ROLE_USER'],
        ) {

        }

        public function getId(): int {
            return $this->id;
        }
        public function setId(int $id): void {
            $this->id = $id;
        }
        public function getFullname(): string {
            return $this->fullname;
        }
        public function setFullname(string $fullname): void {
            $this->fullname = $fullname;
        }
        public function getEmail(): string {
            return $this->email;
        }
        public function setEmail(string $email): void {
            $this->email = $email;
        }
        public function getPassword(): string {
            return $this->password;
        }
        public function setPassword(string $password): void {
            $this->password = $password;
        }
        public function getRole(): array {
            return $this->role;
        }
        public function setRole(array $role): void {
            $this->role = $role;
        }

        /**
         * Find a user by id
         * @param int $id
         * @return User|bool
         */
        public function findOneById(int $id): User|bool {
            $db = new Database();
            $sql = "SELECT * FROM user WHERE id = :id";

            $stmt = $db->bdd->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if($user) {
                return new User(
                    $user['id'],
                    $user['fullname'],
                    $user['email'],
                    $user['password'],
                    json_decode($user['role'])
                );
            }
            return false;
        }

        /**
         * Find a user by email
         * @param string $email
         * @return User|bool
         */
        public function findOnebyEmail(string $email): User|bool {
            $db = new Database();
            $sql = "SELECT * FROM user WHERE email = :email";

            $stmt = $db->bdd->prepare($sql);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if($user) {
                return new User(
                    $user['id'],
                    $user['fullname'],
                    $user['email'],
                    $user['password'],
                    json_decode($user['role'])
                );
            }
            return false;
        }

        /**
         * Find all users
         * @return array
         */
        public function findAll(): array {
            $db = new Database();
            $sql = "SELECT * FROM user";

            $stmt = $db->bdd->prepare($sql);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $usersList = [];
            foreach ($users as $user) {
                array_push($usersList, new User(
                    $user['id'],
                    $user['fullname'],
                    $user['email'],
                    $user['password'],
                    json_decode($user['role'])
                ));
            }
            return $usersList;
        }

        /**
         * Create a user
         * @return User|bool
         */
        public function create(): User|bool {
            $db = new Database();
            $sql = "INSERT INTO user (fullname, email, password, role)
                    VALUES (:fullname, :email, :password, :role)";

            $stmt = $db->bdd->prepare($sql);
            $stmt->bindValue(':fullname', $this->fullname, PDO::PARAM_STR);
            $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindValue(':password', $this->password, PDO::PARAM_STR);
            $stmt->bindValue(':role', json_encode($this->role), PDO::PARAM_STR);
            if($stmt->execute()) {
                $this->id = $db->bdd->lastInsertId();
                return $this;
            }
            return false;
        }

        /**
         * Update a user
         * @return User|bool
         */
        public function update() {
            $db = new Database();

            $sql = "UPDATE user SET fullname = :fullname, email = :email, password = :password, role = :role WHERE id = :id";

            $stmt = $db->bdd->prepare($sql);
            $stmt->bindValue(':fullname', $this->fullname, PDO::PARAM_STR);
            $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindValue(':password', $this->password, PDO::PARAM_STR);
            $stmt->bindValue(':role', json_encode($this->role), PDO::PARAM_STR);
            $stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
            if($stmt->execute()) {
                return $this;
            }
        }

        /**
         * Delete a user
         * @param int $id
         * @return bool
         */
        public function delete(int $id): bool {
            $db = new Database();
            $sql = "DELETE FROM user WHERE id = :id";

            $stmt = $db->bdd->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        }

        /**
         * Save a user
         * @return User|bool
         */
        public function save() {
            if($this->id) {
                return $this->update();
            }
            return $this->create();
        }
    };
