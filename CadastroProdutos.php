<?php
    //incluindo a configuração da página (cabeçalho)
    include_once("config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de produtos</title>
    
    <!-- Boostrap 4 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src='https://kit.fontawesome.com/a076d05399.js'></script>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        
</head>

<body>
    <div style="padding: 20% ; text-align:center; font-size: 25px; background-color: lightgray">   
        <h2 >Cadastrar Produto</h2>

        <!--Preenchendo os dados do produto para cadastrar no banco-->
        <form action="inserirProduto.php"  method= "GET" style="padding:10px; ">
            <label for="nome" >Nome: </label>
            <input type="text" name = "nome" id="nome" style="font-size: 25px" required>
            <br><br>

            <label for="valor" >Valor: R$</label>
            <input  name = "valor"  id="valor" style="font-size: 25px" required>
            <br><br>

            <!--Botão que envia os dados para cadastro-->
            <a href="ListarProduto.php">
            <button type="submit" style="font-size: 25px; background-color: lightsalmon;" >Cadastrar </button></a>
        </form>
        
    </div>
    
</body>
</html>