<?php

    $dbHost = 'Localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'projeto_cpf';

    $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

   //if ($conn->connect_errno){
   //     die("Erro na conexão: " . $conn->connect_error);
   // }
   // else {
   //     echo "Conexão efetuada.";
   //}

?>
