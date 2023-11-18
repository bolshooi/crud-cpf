<?php
    session_start();
    // print_r($_REQUEST);
    if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['cpf']) && !empty($_POST['senha'])){

        include_once('config.php');
        
        $cpf = $_POST['cpf'];
        $senha = $_POST['senha'];

        // print_r('CPF: ' . $cpf);
        // print_r('<br>');
        // print_r('Senha: ' . $senha);

        $sql = "SELECT * FROM usuarios WHERE cpf = '$cpf' and senha = '$senha'";

        $result = $conn->query($sql);
        // print_r($sql);
        // print_r($result);

        if(mysqli_num_rows($result) < 1){
            unset($_SESSION['cpf']);
            unset($_SESSION['senha']);
            header('Location: index.html');
        }
        else {
            $userData = mysqli_fetch_assoc($result);
            $_SESSION['cpf'] =  $cpf;
            $_SESSION['senha'] =  $senha;
            $_SESSION['userData'] = $userData;
            header('Location: userhome.php');
        }
    }
    else {
        // failed
        header('Location: index.php');
    }
?>