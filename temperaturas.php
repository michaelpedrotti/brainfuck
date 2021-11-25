<?php

/**
* Retorna a temperatura mais proxima de zero.
* Se duas temperaturas com o mesmo valor absouto (uma positiva e outra negativa) serem igualmente proxima a zero, deve ser dada a preferencia para o valor positivo.
* @param array $temperaturas Lista de temperaturas
* @return int A temperatura mais proxima de zero
**/
function menorTemperatura($temperaturas) {
	
	// Coloca na ordem crescente
	sort($temperaturas);// Só por capricho...
		
	// Achou 0, caso este exista então retorna ele mesmo
	if(in_array(0, $temperaturas)){
		
		return 0;
	}
	
	// Tenta achar se tem algum número negativo
	$negatives = array_filter($temperaturas, function($value){
		
		return $value < 0;
	});

	// Se não tem nenhum negativo é só fazer um min()
	if(empty($negatives)){
		
		return min($temperaturas);
	}
	// Possui números negativos
	else {
		
		// Extraimos os positivos
		$positives = array_diff($temperaturas, $negatives);
		
		// Só tem números negativos, então é só fazer um max()
		if(empty($positives)){
			
			return max($negatives);
		}
		// Então existem números negativos e positivos e temos que comparar o mais
		// próximo de 0 de cada;
		else {
			
			// Pega o menor valor negativo
			$negative = max($negatives);

			// Pega o menor valor positivo
			$positive = min($positives);

			if(abs($negative) >=  $positive){

				return $positive;
			}
			else {
				return $negative;
			}	
		}		
	}
}


/***** Teste 01 *****/
$temperaturas = array( 17, 32, 14, 21 );
$resultadoEsperado = 14;
$resultado = menorTemperatura($temperaturas);
verificaResultado("01", $resultadoEsperado, $resultado);


/***** Teste 02 *****/
$temperaturas = array( 27, -8, -12, 9 );
$resultadoEsperado = -8;
$resultado = menorTemperatura($temperaturas);
verificaResultado("02", $resultadoEsperado, $resultado);


/***** Teste 03 *****/
$temperaturas = array( -6, 14, 42, 6, 25, -18 );
$resultadoEsperado = 6;
$resultado = menorTemperatura($temperaturas);
verificaResultado("03", $resultadoEsperado, $resultado);


/***** Teste 04 *****/
$temperaturas = array( 34, 11, 13, -23, -11, 18 );
$resultadoEsperado = 11;
$resultado = menorTemperatura($temperaturas);
verificaResultado("04", $resultadoEsperado, $resultado);


/***** Teste 05 *****/
$temperaturas = array( 17, 0, 28, -4 );
$resultadoEsperado = 0;
$resultado = menorTemperatura($temperaturas);
verificaResultado("05", $resultadoEsperado, $resultado);

/***** Teste 06 *****/
$temperaturas = array( -10, 27, 9, -12 );
$resultadoEsperado = 9;
$resultado = menorTemperatura($temperaturas);
verificaResultado("06", $resultadoEsperado, $resultado);

/***** Teste 07 *****/
$temperaturas = array( -47, -14, -5, -12, -8 );
$resultadoEsperado = -5;
$resultado = menorTemperatura($temperaturas);
verificaResultado("07", $resultadoEsperado, $resultado);

/***** Teste 08 *****/
$temperaturas = array( -47, -14, -5, -12, -5 );
$resultadoEsperado = -5;
$resultado = menorTemperatura($temperaturas);
verificaResultado("08", $resultadoEsperado, $resultado);

/***** Teste 09 *****/
$temperaturas = array( -7, 12, -13, 8 );
$resultadoEsperado = -7;
$resultado = menorTemperatura($temperaturas);
verificaResultado("09", $resultadoEsperado, $resultado);


function verificaResultado($nTeste, $resultadoEsperado, $resultado) {
	
	if(intval($resultadoEsperado) === intval($resultado)) {
		echo "Teste $nTeste passou.\n";
	}
	else {
		echo "Teste $nTeste NAO passou (Resultado esperado = $resultadoEsperado, Resultado obtido = $resultado).\n";
	}
}