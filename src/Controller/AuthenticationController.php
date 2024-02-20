<?php namespace App;

    class AuthenticationController {

        public function __construct(
            private ?string $email = null,
            private ?string $password = null,
            private ?string $fullname = null,
        ) {
            
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
        public function getFullname(): string {
            return $this->fullname;
        }
        public function setFullname(string $fullname): void {
            $this->fullname = $fullname;
        }

        /**
         * Register a new user
         * @return bool
         */
        public function register(): bool {
            $newUser = new User();
            $user = $newUser->findOneByEmail($this->email);
            if(!$user) {
                $newUser->setEmail($this->email);
                $newUser->setPassword($this->password);
                $newUser->setFullname($this->fullname);
                $newUser->save();
            }
            return false;
        }

        /**
         * Login a user
         * @return bool
         */
        public function login(): bool {
            $user = new User();
            $user = $user->findOneByEmail($this->email);
            if(!$user) {
                return false;
            }
            if($this->password === $user->getPassword()) {
                $_SESSION['user'] = $user;
                return true;
            }
            return false;
        }

        /**
         * Logout a user
         * @return void
         */
        public function logout(): void {
            unset($_SESSION['user']);
        }

        /**
         * Get the profile of the user
         * @return User|bool
         */
        public function profile(): User|bool {
            if(isset($_SESSION['user'])) {
                return $_SESSION['user'];
            }
            return false;
        }

        /**
         * Update the profile of the user
         * @return bool
         */
        public function updateProfile(): bool {
            $user = new User();
            $user = $user->findOneByEmail($this->email);
            if(!$user) {
                return false;
            }
            $user->setEmail($this->email);
            $user->setPassword($this->password);
            $user->setFullname($this->fullname);

            $user->save();
            $_SESSION['user'] = $user;
            
            return true;
        }
    }
