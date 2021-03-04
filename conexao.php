<?php

//dados da conexão
$servername = "127.0.0.1";
$username = "root";
$password = "senha";
$db = "gn_vendas";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $db);

// Conferindo se há algum erro
if ($conn->connect_error) {
    echo "connection failed";
} 



?>
