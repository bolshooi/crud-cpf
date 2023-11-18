<?php
    session_set_cookie_params(0);
    session_start();
include_once('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $newEmail = $_POST['email']; 
    $newTelefone = $_POST['telefone']; 

    $sql = "UPDATE usuarios SET email = ?, telefone = ? WHERE cpf = ?";
    $_SESSION['userData']['email'] = $newEmail;
    $_SESSION['userData']['telefone'] = $newTelefone;
    
    $res = $conn->prepare($sql);
    $res->bind_param('sss', $newEmail, $newTelefone, $cpf);

    if ($res->execute()) {
    
        header('Location: userhome.php?success=1');
        exit;
    } else {
        header('Location: edit.php?error=1');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar</title>
    <link rel="stylesheet" href="stylecadastro.css">
</head>
<body>
    <div class="box">
        <form action="edit.php" method="POST">
            <fieldset>
                <legend><b>Edição de Usuário</b></legend>
                <br><br>
                <div class="inputBox">
                    <input type="email" name="email" id="email" class="inputEmail" placeholder="E-mail" required>
                    <label for="email" class="labelInput"></label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="text" name="telefone" id="telefone" oninput="formatarTel(this)" class="inputUser" required>
                    <label for="telefone" class="labelInput">Telefone</label>
                </div>
                <br><br>
                <input type="submit" value="Enviar" id="submit">
            </fieldset>
        </form>
    </div>
</body>
</html>
