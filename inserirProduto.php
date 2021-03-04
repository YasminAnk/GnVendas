<?php
//inclui o arquivo de conexao com o banco de dados
include_once("conexao.php");

//recebe os dados do produto e faz o tratamento
$nome = $_GET['nome'];
$valor = str_replace('.', '', $_GET['valor']);//caso o numero seja superior a 1000, garante que nao ficará 1.000 e sim 1000.0
$valor = str_replace(',', '.', $valor); //substitui a vírgula por ponto.


//criando e executando a query sql
$sql = "insert into gn_vendas.produtos (nome, valor) values ('$nome', '".$valor."');";
   


    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Produto cadastrado com sucesso.');</script>";
        echo "<script>window.location = 'ListarProduto.php';</script>";
    } else {
            echo "Erro: " . $sql . "<br>" . $conn->error;
        }
    $conn->close();


?>