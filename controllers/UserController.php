<?php

include_once 'models/User.php';
require_once 'helpers/DateConverter.php';

class UserController {
    private $userModel;

    public function __construct($mysqli) {
        $this->userModel = new User($mysqli);
    }


    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $errors = $this->validateForm($username, $email, $password);
            $result = $this->userModel->registerUser($username, $email, $password);

            if ($result) {
                echo json_encode(['success' => true,'redirect' => '?action=login']);
            } else {
                echo json_encode(['error' => 'Registration failed.']);
            }
        } else {
            include 'views/register.php';
        }
    }

    private function validateForm($username, $email, $password)
    {
        $errors = [];

        if (empty($username)) {
            $errors[] = "Username is required";
        }

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Valid email is required";
        }

        if (strlen($password) < 6) {
            $errors[] = "Password must be at least 6 characters long";
        }

        return $errors;
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $result = $this->userModel->loginUser($email, $password);

            if ($result) {
                session_start();
                $_SESSION['user_id'] = $result['user_id'];
                $_SESSION['username'] = $result['username'];


                // Retrieve creation date
                $creationDate = $this->userModel->getCreationDate($result['user_id']);
                echo json_encode(['success' => true,'redirect' => '?action=dashboard','username' => $result['username'],'createdAt' => $creationDate]);
            } else {
                echo json_encode(['error' => 'Login failed.']);
            }
        } else {
            include 'views/login.php';
        }
    }

    public function dashboard() {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php");
            exit;
        }

        // Retrieve creation date
        $creationDate = $this->userModel->getCreationDate($_SESSION['user_id']);
        $hijriDate = DateConverter::convertToHijri($creationDate);
        include 'views/dashboard.php';
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header("Location: ?action=login");
        exit;
    }
}