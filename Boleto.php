<?php
//inclui o arquivo de conexao com o banco de dados
include_once("conexao.php");

//recebe dados do comprador
$nome = $_POST['nome'];
$cpf = $_POST['cpf'];
$telefone = $_POST['telefone'];



//recebe o Id do produto
$idProduto = $_POST['id'];

//exibe nome e valor do produto com o Id buscado 
$select="select nome, valor from gn_vendas.produtos where Id=".$idProduto.";";

//salva o nome e valor vindos do banco de dados em variáveis
$query = $conn->query($select);
$exibir = $query->fetch_assoc();
$produto = $exibir['nome'];
$valor= $exibir['valor'];

//cálculo da data de vencimento (2 dias após o dia da compra) 
$emissao = new DateTime();
$intervalo = new DateInterval('P2D');
$validade = $emissao->add($intervalo);
$validade = $validade->format("Y-m-d");


//requisitos da API Gerencianet
require __DIR__ . '/vendor/autoload.php'; // caminho relacionado a SDK

   use Gerencianet\Exception\GerencianetException;
   use Gerencianet\Gerencianet;

   //chaves exclusivas geradas que garantem a permissão do acesso à API
   $clientId = 'Client_Id_4e4327e045ceb277ed5f62db8c46c399c309e0bf'; 
   $clientSecret = 'Client_Secret_bb1ad596c70e1c17089cd27ec860816670412681'; 

    $options = [
        'client_id' => $clientId,
        'client_secret' => $clientSecret,
        'sandbox' => true // (true = homologação e false = producao)
    ];
    
   $item_1 = [
       'name' => $produto, // nome do item, produto ou serviço
       'amount' => 1, // quantidade
       'value' => $valor*100 // valor (1000 = R$ 10,00) 
   ];
   $items = [
       $item_1
   ];
   
   $customer = [
       'name' => $nome, // nome do cliente
       'cpf' => $cpf, // cpf válido do cliente
       'phone_number' => $telefone,// telefone do cliente
   ];
   $discount = [ // configuração de descontos
       'type' => 'currency', // tipo de desconto a ser aplicado
       'value' => 599 // valor de desconto 
   ];
   $configurations = [ // configurações de juros e mora
       'fine' => 200, // porcentagem de multa
       'interest' => 33 // porcentagem de juros
   ];
   $conditional_discount = [ // configurações de desconto condicional
       'type' => 'percentage', // seleção do tipo de desconto 
       'value' => 500, // porcentagem de desconto
       'until_date' => $validade // data máxima para aplicação do desconto
   ];
   $bankingBillet = [
       'expire_at' => $validade, // data de vencimento do titulo 
       'message' => 'Processo seletivo Gerencianet\nCandidata: Yasmin Ank Alves Gonçalves', // mensagem a ser exibida no boleto
       'customer' => $customer,
       'discount' =>$discount,
       'conditional_discount' => $conditional_discount
   ];
   $payment = [
       'banking_billet' => $bankingBillet // forma de pagamento (banking_billet = boleto)
   ];
   $body = [
       'items' => $items,
       'payment' => $payment
   ];

   try {
     $api = new Gerencianet($options);
     $pay_charge = $api->oneStep([],$body);

     //armazena o link do boleto na variável "link"
     $link=$pay_charge["data"]["link"];
     ?>
        <!--Exibe o link clicável direcionando ao boleto gerado-->
        <a href="<?php echo $link?>">Clique aqui para acessar o link do seu boleto.</a>
    <?php
    
    //armazena o link do pdf e o id do boleto, para serem armazenados do banco de dados
     $pdf = $pay_charge["data"]["pdf"]["charge"];
     $idBoleto = $pay_charge["data"]["charge_id"];

     //query para armazenar os dados no banco
     $insert = "insert into gn_vendas.compras (Id_boleto, pdf, Id_produto) values('$idBoleto', '".$pdf."', '".$idProduto."');";
     $query = $conn->query($insert);

    } catch (GerencianetException $e) {
       print_r($e->code);
       print_r($e->error);
       print_r($e->errorDescription);
   } catch (Exception $e) {
       print_r($e->getMessage());
   }

   

    
?>