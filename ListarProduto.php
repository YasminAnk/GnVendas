<?php
        //inclui o arquivo de conexao com o banco
        include_once("conexao.php");

        //inclui a configuração da página (cabeçalho)
        include_once("config.php");

        //query para exibir os produtos, ordenados por ordem alfabética dos nomes
        $sql = "select *from gn_vendas.produtos order by nome;";
        $query = $conn->query($sql);
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Produtos</title>

        <!-- Boostrap 4 -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src='https://kit.fontawesome.com/a076d05399.js'></script>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        
        <style>
        table, th, td {
                border: 1px solid black;
                border-collapse: collapse;
                padding: 5px;
        }
        div{
            font-size: 25px;
        }
        </style>
        <script type="text/javascript">
          
          //função chamada no botão de realizar a compra
            function salvarId(id){
                //Completa o input hidden com o valor do id buscado no banco
                document.getElementById('id').value = id;
            }
        </script>
    </head>

    <body style="background-color:lightgray "> 
    
    <div class="container">

        <!-- Configurando o modal -->
        <div class="modal fade" id="myModal">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">

                    <!-- Cabeçalho do modal -->
                    <div class="modal-header">
                        <h4 class="modal-title">Dados do Comprador</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <!-- Conteúdo do modal -->
                    <div class="modal-body">
                        <p style="color:red; font-size: 18px; margin-top:0%">Preenchimengo obrigatório</p>

                        <!-- Formulário referente aos dados do cliente -->
                        <form name="form" class="need-validation" action="Boleto.php" method= "POST">
                            <label for="nome">Nome completo: </label>
                            <input type="text" name="nome" id="nome" 
                            Placeholder= "João Maurício dos Santos" style="font-size: 21px"required>
                            <br><br>

                            <label for="cpf">CPF: </label>
                            <input type="text" name="cpf" id="cpf" 
                            Placeholder= "12332112235" style="font-size: 21px" maxlength= "11"required >                            
                            <br><br>

                            <label for="telefone">Telefone (com o ddd): </label>
                            <input type="text" name="telefone" id="telefone" 
                            Placeholder= "31901234556" style="font-size: 21px" maxlength= "11"required ><br>

                            <input type="hidden" name="id" id="id" >
                           
                                    
                    </div>

                    <!-- Pé do modal -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" >Ir para boleto</button>
                    </div>

                </div>
            </div>
        </div>
                
        <br>     
        <h2 class="bg-secondary text-white" style="font-family: sans-serif;"> Tabela de produtos</h2>
        <br> 
        <!--Tabela onde serão exibidos os produtos --> 
        <table class="table table-hover " style="background-color: rgb(229, 233, 233)">
            <thead class="thead-light">
                <tr>
                    <th>Nome</th>
                    <th>Preço (R$)</th>
                </tr>
            </thead>
            <tbody id="table">
                <?php
                    //preenche os dados da tabela com o resultado da sql de exibição
                    while($exibir = $query->fetch_assoc()){

                ?> 
                <tr>
                    <td>
                        <?php echo $exibir["nome"] ?> <!--Nome do produto-->
                    </td>
                    <td>
                        <?php 
                            $valor = str_replace('.', ',', $exibir['valor']); 
                            echo $valor?> <!-- Valor do produto-->
                    </td>
                    <td>
                        <!--Botão para realizar compra-->
                        <button type="submit" class="btn btn-success btn-block"
                        onclick="salvarId('<?php echo $exibir['Id']?>')" data-toggle="modal" data-target="#myModal">Comprar
                        <i class="far fa-shopping-cart"></i></button>
                    </td>
                </tr>
                <?php }
                ?>
            </tbody>
        </table>
        </form>
    </div>
    </body>
</html>