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
         * @return void
         */
        public function register(): void {

            $errorMessage = null;

            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                $name = $_POST['name'];
                $email = $_POST['email'];
                $password = $_POST['password'];
        
                $newUser = new User();
                $user = $newUser->findOneByEmail($email);
                if(!$user) {
                    $newUser->setEmail($email);
                    $newUser->setPassword($password);
                    $newUser->setFullname($name);
                    if($newUser->save()) {
                        header('Location: /pwd/login');
                    }
                }
                else {
                    $errorMessage = 'Un utilisateur avec cet email existe déjà';
                }
            }

            echo Renderer::render('register')->view(['errorMessage' => $errorMessage]);
        }

        /**
         * Login a user
         * @return bool
         */
        public function login(): void {

            $errorMessage = null;

            if($_SERVER['REQUEST_METHOD'] === 'POST') {

                $email = $_POST['email'];
                $password = $_POST['password'];

                $user = new User();
                $user = $user->findOneByEmail($email);
                if(!$user) {
                    $errorMessage = 'Les identifiants fournis ne correspondent à aucun utilisateur';
                }
                if($password === $user->getPassword()) {
                    $_SESSION['user'] = $user;
                    header('Location: /pwd/shop');
                }
            }
            echo Renderer::render('login')->view(['errorMessage' => $errorMessage]);
        }

        /**
         * Logout a user
         * @return void
         */
        public function logout(): void {
            unset($_SESSION['user']);
            header('Location: /pwd/login');
        }

        /**
         * Get the profile of the user
         * @return void
         */
        public function showProfile(): void {

            $errorMessage = null;

            if(isset($_SESSION['user'])) {
                $profile = $_SESSION['user'];

                if(!$profile) {
                    header('Location: /pwd/login');
                }

                if($_SERVER["REQUEST_METHOD"] == "POST") {
                    $name = $_POST['name'];
                    $email = $_POST['email'];
                    $password = $_POST['password'];

                    $this->setFullname($name);
                    $this->setEmail($email);
                    $this->setPassword($password);

                    if($this->updateProfile()) {
                        header('Location: /pwd/profile.php');
                    }
                    else {
                        $errorMessage = 'Echec de la mise à jour du profil';
                    }
                }
            } else {
                header('Location: /pwd/login');
            }
            
            echo Renderer::render('profile')->view(['profile' => $profile, 'errorMessage' => $errorMessage]);
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
