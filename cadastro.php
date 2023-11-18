<?php

    if ($_SERVER["REQUEST_METHOD"] === "POST")
    {
        include_once('config.php');

        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $cpf = $_POST['cpf'];
        $telefone = $_POST['telefone'];
        $senha = $_POST['senha'];
        $genero = $_POST['genero'];
        $dataNasc = $_POST['dataNasc'];
        $estado = $_POST['estado'];
        $cidade = $_POST['cidade'];

        $sql = "SELECT * FROM usuarios WHERE email = '$email'";
        $sql2 = "SELECT * FROM usuarios WHERE cpf = '$cpf'";
        $r = $conn->query($sql);
        $r2 = $conn->query($sql2);

        if (mysqli_num_rows($r) > 0) {
            echo "E-mail já cadastrado!";
            exit;
        }

        if (mysqli_num_rows($r2) > 0) {
            echo "CPF já cadastrado!";
            exit;
        }

        if (!validarCPF($cpf)) {
            echo "CPF inválido. Por favor, insira um CPF válido.";
            exit; 
        }

        $result = mysqli_query($conn, "INSERT INTO usuarios(nome, email, cpf, telefone, senha, genero, dataNasc, estado, cidade) VALUES ('$nome', 
        '$email', '$cpf', '$telefone', '$senha', '$genero', '$dataNasc', '$estado', '$cidade')");


        if ($result) {
        $affectedRows = mysqli_affected_rows($conn);
        if ($affectedRows > 0) {
            echo "Inserção bem-sucedida. $affectedRows linha(s) inserida(s).";
            header('Location: index.html');
        } else {
            echo "Inserção bem-sucedida, mas nenhuma linha foi afetada.";
        }
        } else {
             echo "Erro na inserção: " . mysqli_error($conn);
        }
    }

    //função criada para saber se o CPF inserido possui os digitos verificadores válidos
    function validarCPF($cpf) {
        $cpf = preg_replace('/[^0-9]/', '', $cpf); //remove os caracteres da formatação

        if (strlen($cpf) != 11) { //retorna o tamanho da variavel 
         return false; 
        }

        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        $soma = 0;
        for ($i = 0; $i < 9; $i++) {
         $soma += ($cpf[$i] * (10 - $i)); // faz a soma dos 9 primeiros digitos baseado na multipliação descrescente 
        }
        $resto = $soma % 11; //calcula o resto da soma
        $digito1 = ($resto < 2) ? 0 : 11 - $resto; //subtrai o resto por 11, se o resto for 1 ou 0, digito1= 0, caso contrario, é o valor do resto subtraido por 11


        $soma = 0; //repete todo o processo anterior, mas adicionando o digito1 na multiplicação e soma
        for ($i = 0; $i < 9; $i++) { 
            $soma += ($cpf[$i] * (11 - $i));
        }
        $soma += ($digito1 * 2); 
        $resto = $soma % 11; //calcula o resto da divisão da soma por 11, e aplica as mesmas regras
        $digito2 = ($resto < 2) ? 0 : 11 - $resto;

        if ($cpf[9] == $digito1 && $cpf[10] == $digito2) {
            return true; //verifica se o CPF é válido
        } else {
            return false;//ou inválido
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <script>
        function formatarCPF(cpfInput) {
            let cpf = cpfInput.value.replace(/\D/g, '');
            
            if (cpf.length === 11) {
                cpfInput.value = cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
            } else {
                cpfInput.value = cpf;
            }
        }

        function formatarTel(telefoneInput) {
            let tel = telefoneInput.value.replace(/\D/g, '');

            if (tel.length === 11) {
                telefoneInput.value = tel.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
            } else {
                telefoneInput.value = tel;
            }
        }
    </script> 
    <link rel="stylesheet" href="csscadastro.css">
</head>
<body>
    <div class="box">
        <form action="cadastro.php" method="POST">
            <fieldset>
                <legend><b>Cadastro de Usuário</b></legend>
                <br>
                <div class="inputBox">
                    <input type="text" name="nome" id="nome" class="inputUser" required>
                    <label for="nome" class="labelInput">Nome Completo</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="email" name="email" id="email" class="inputEmail" placeholder="E-mail" required>
                    <label for="email" class="labelInput"></label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="text" name="cpf" id="cpf" oninput="formatarCPF(this)" class="inputUser" required>
                    <label for="cpf" class="labelInput">CPF</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="text" name="telefone" id="telefone" oninput="formatarTel(this)" class="inputUser" required>
                    <label for="telefone" class="labelInput">Telefone</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="password" name="senha" id="senha" class="inputUser" required>
                    <label for="senha" class="labelInput">Senha</label>
                </div>
                <br><br>
                <p>Sexo:</p>
                <input type="radio" name="genero" id="masculino" value="Masculino" required>
                <label for="masculino">Masculino</label>
                <input type="radio" name="genero" id="feminino" value="Feminino" required>
                <label for="feminino">Feminino</label>
                <br><br><br>
                <div class="inputBox">
                    <label for="dataNasc"><b>Data de Nascimento:</b></label>
                    <input type="date" name="dataNasc" id="dataNasc" class="inputUser" required>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="text" name="estado" id="estado" class="inputUser" required>
                    <label for="estado" class="labelInput">Estado</label>
                </div>
                <br><br>
                <div class="inputBox">
                    <input type="text" name="cidade" id="cidade" class="inputUser" required>
                    <label for="cidade" class="labelInput">Cidade</label>
                </div>
                <br><br>
                <input type="submit" value="Enviar" id="submit">
            </fieldset>
        </form>
    </div>
</body>
</html>