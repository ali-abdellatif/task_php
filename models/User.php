<?php

class User {
    private $mysqli;

    public function __construct($mysqli) {
        $this->mysqli = $mysqli;
    }

    public function registerUser($username, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->mysqli->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->close();
            return false; // Email already exists
        }

        $stmt = $this->mysqli->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashedPassword);

        if ($stmt->execute()) {
            $stmt->close();
            return true; // Registration successful
        } else {
            $stmt->close();
            return false; // Registration failed
        }
    }

    public function loginUser($email, $password) {
        $stmt = $this->mysqli->prepare("SELECT id, username, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($user_id, $username, $hashedPassword);
        $stmt->fetch();
        $stmt->close();

        if (password_verify($password, $hashedPassword)) {
            return ['user_id' => $user_id, 'username' => $username];
        } else {
            return false; // Login failed
        }
    }


    public function getCreationDate($user_id) {
        $stmt = $this->mysqli->prepare("SELECT created_at FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($created_at);
        $stmt->fetch();
        $stmt->close();

        return $created_at;
    }

    // Add more methods as needed
}