<?php
include_once('config.php');
session_set_cookie_params(0);
session_start();
if (isset($_SESSION['cpf'])) {
    $cpf = $_SESSION['cpf'];

    $sql = "DELETE FROM usuarios WHERE cpf = ?";
    
    $res = $conn->prepare($sql);
    $res->bind_param('s', $cpf);

    if ($res->execute()) {
        header('Location: index.html');
        exit;
    } else {
        header('Location: userhome.php?error=1');
        exit;
    }
} else {
    header('Location: index.html');
    exit;
}
?>
