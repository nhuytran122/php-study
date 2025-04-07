<?php
    class UserRepository {
        private $connection;

        public function __construct($connection) {
            $this->connection = $connection;
        }
        public function findByEmail(string $email): ?array {
            $sql = "SELECT * FROM users WHERE email = :email";
            try {
                /** @var PDO|null $connection */
                $statement = $this->connection->prepare($sql);
                $statement->execute(['email' => $email]);
                $user = $statement->fetch(PDO::FETCH_ASSOC);
                return $user ?? null; 
            } catch (PDOException $e) {
                error_log("Find user failed: " . $e->getMessage());
                return null;
            }
        }

        public function create(string $email, string $fullName, string $role = 'USER'): ?int {
            $sql = "INSERT INTO users (email, full_name, role) VALUES (:email, :full_name, :role)";
            try {
                /** @var PDO|null $connection */
                $statement = $this->connection->prepare($sql);
                $statement->execute([
                    'email' => $email,
                    'full_name' => $fullName,
                    'role' => $role
                ]);
                return $this->connection->lastInsertId(); 
            } catch (PDOException $e) {
                error_log("Create user failed: " . $e->getMessage());
                return null;
            }
        }
    }
?>