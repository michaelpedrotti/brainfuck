<?php

/**
* Soma dois numero
* @param int $a
* @param int $b
* @return int A soma dos dois numeros
**/
function soma($a, $b) {
	$soma = $a + $b;
	
	return($soma);
}


/***** Teste 01 *****/
$a = "1";
$b = "1";
$resultadoEsperado = "2";
$resultado = soma($a, $b);
verificaResultado("01", $resultadoEsperado, $resultado);


/***** Teste 02 *****/
$a = "2";
$b = "3";
$resultadoEsperado = "5";
$resultado = soma($a, $b);
verificaResultado("02", $resultadoEsperado, $resultado);


/***** Teste 03 *****/
$a = "5";
$b = "9";
$resultadoEsperado = "14";
$resultado = soma($a, $b);
verificaResultado("03", $resultadoEsperado, $resultado);


function verificaResultado($nTeste, $resultadoEsperado, $resultado) {
	
	if($resultadoEsperado == $resultado) {
		echo "Teste $nTeste passou.\n";
	} 
	else {
		echo "Teste $nTeste NAO passou (Resultado esperado = $resultadoEsperado, Resultado obtido = $resultado).\n";
	}
}
