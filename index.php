<?php

include 'config/database.php';
include 'controllers/UserController.php';

$userController = new UserController($mysqli);

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'register':
            $userController->register();
            break;
        case 'login':
            $userController->login();
            break;
        case 'dashboard':
            $userController->dashboard();
            break;
        case 'logout':
            $userController->logout();
            break; // Add this case for logout
        // Add more actions as needed
    }
}