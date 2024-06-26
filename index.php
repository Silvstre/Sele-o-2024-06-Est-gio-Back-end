<!-- F) Uma possivel melhoria seria uma validacao da entrada do cep, verificando sua existencia no banco de dados da API    -->
<?php

class Address
{
//criacao das propriedades da classe//
public $bairro;
public $logradouro;
public $uf;
	//metodo para obter o endereco//
 	public static function get_address($cep){
	
	
	$cep = preg_replace("/[^0-9]/", "", $cep);
	$url = "http://viacep.com.br/ws/$cep/xml/";//Apos ws e necessario uma "/" para acessar a url com o valor atribuido a variavel

	$xml = simplexml_load_file($url);
	// Criando um objeto $address e inserindo valor em suas propriedades
	$address = new Address();
	//bairro de $address agora tera o valor do bairro de $xml, assim como logradouro e uf//
	$address->bairro =  $xml->bairro;
	$address->logradouro = $xml->logradouro;
	$address->uf =  $xml->uf;
	//Retornando a instancia preenchida com os dados adquiridos do cep
	return $address;
	}

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="style.css">
	<title>MEU CEP</title>
</head>
<body>
	<section id="container-modal">
		<div id="modal">
		<h2>Consulta de endereco pelo CEP</h2>
		<br><form action="index.php" method="post"><!-- O form Action estava com o nome do arquivo errado, nao enviando os dados do formulario para o index.php -->
		<label for="Insire o CEP"> Insira o CEP: </label>
		<input type="text" name="cep" id="text" placeholder="Digite o CEP aqui" autofocus/>
		<input type="submit" value="Enviar" id="btn">

		<?php
		if(!empty($_POST['cep'])){
	
			$cep = $_POST['cep'];
		
			$address = Address::get_address($cep);// o parametro da funcao nao estava correto, assim nao utilizava funcao //
		
			echo "<br><br><h1>CEP Informado: $cep</h1><br>";
			echo "<h1>Rua: $address->logradouro</h1><br>";//a variavel deve ser $address (falta de um "s" nao acessando as propriedades da classe) e o logradoro esta com a digitacao incorreta , 
			echo "<h1>Bairro: $address->bairro</h1><br>";
			echo "<h1>Estado: $address->uf</h1><br>";// Variavel com digitacao errada (falta de um "d" nao acessando as propriedades da classe)//
		}?>

		</div>

		
	</section>

</body>
</html>
