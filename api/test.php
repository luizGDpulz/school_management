<?php
    require_once './index.php'; // ou o caminho correto até seu index
    
    require_once ROOT_PATH . '/utils/password_manager.php';
    require_once ROOT_PATH . '/controllers/user_controller.php'; 

    $controller = new UserController();
    $user_id = 1;
    $name = "root";
    $email = "root@root";
    $role = "root";
    $senha = "raiz@64";

    $x = 0;

    if($x == 0){
        $controller->updateUserPassword($user_id, $senha);
        $controller->updateUser($user_id, $name, $email, $role);
        $x++;
    }
?>