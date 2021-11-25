<?php

$GLOBALS['leapYearLength'] = 0;

function isLeapYear($year){
	
	if($year % 100 == 0){

		if($year % 400 == 0){

			return true;
		}
	}
	else {

		if($year % 4 == 0){

			return true;
		}
	}
	
	return false;
}

//function yearsToDays($year){
//	
//	return ($year % 4 == 0) ? 366 : 365;
//}

function monthsToDays($month, $year){
	
	$result = 31; 
	
	switch(intval($month)){
				
		case 2:
			$result = isLeapYear($year) ? 29 : 28;
			break;

		case 4:// abril
		case 6:// junho
		case 9:// junho
			$result = 30;
			break;
	}
		
	return $result;
}

//function getMonthsRange($begin = 1, $end = 3){
//	
//	$array = array();
//	
//	for($i = $begin; $i <= $end; $i++){
//		
//		if($i == 12){
//			
//			$i = 1;
//		}
//		
//		$array[]  = $i;
//	}
//	
//	printf("\tgetMonthsRange: %s\n", implode(', ', $array));
//	
//	array_shift($array);
//	array_pop($array);
//	
//	return $array;
//}

//function getYearsRange($begin = 1, $end = 3){
//	
//	$array = range($begin, $end);
//	
//	foreach($array as $year){
//		
//		if($year % 100 == 0){
//			
//			if($year % 400 == 0){
//				
//				$GLOBALS['leapYearLength']++;
//			}
//		}
//		else {
//		
//			if($year % 4 == 0){
//
//				$GLOBALS['leapYearLength']++;
//			}
//		}
//	}
//	
//	
//	
//	array_shift($array);
//	array_pop($array);
//	print "\t".__FUNCTION__.': '.implode(', ', $array).PHP_EOL;
//	
//	return $array;
//}

/**
* Calcula o numero de dias entre 2 datas.
* As datas passadas sempre serao validas e a primeira data sempre sera menor que a segunda data.
* @param string $dataInicial No formato YYYY-MM-DD
* @param string $dataFinal No formato YYYY-MM-DD
* @return int O numero de dias entre as datas
**/
function calculaDias($dataInicial, $dataFinal) {

	printf("\tbegin: %s\n", $dataInicial);
	printf("\tend: %s\n", $dataFinal);
	
	$result = 0;
	
	list($beginYear, $beginMonth, $beginDay) = explode('-', $dataInicial);

	list($endYear, $endMonth, $endDay) = explode('-', $dataFinal);	
	
	$datetime = array();
	
	foreach(range($beginYear, $endYear) as $year){
		
		$datetime[$year] = range(1, 12);
	}
	
	$datetime[$beginYear] = array_filter($datetime[$beginYear], function($month) use($beginMonth){
		
		return $month >= $beginMonth;
	});
	
	$datetime[$endYear] = array_filter($datetime[$endYear], function($month) use($endMonth){
		
		return $month <= $endMonth;
	});
	//---------------------------------------------
	$firstMonth = array_shift($datetime[$beginYear]);
	$lastMonth = array_pop($datetime[$endYear]);
	
	
	//dprintf("\tbeginYear: %s\n", $beginYear);
	//printf("\tendYear: %s\n", $endYear);
	
	if($beginYear == $endYear && ($firstMonth == $lastMonth || empty($lastMonth))){
		
		$result += ($endDay - $beginDay);
	}
	else {

		printf("\tlastMonth: %s\n", $lastMonth);
		printf("\tfirstMonth: %s\n", $firstMonth);
		
		
		
		// ano bisexto
		$result += monthsToDays($firstMonth, $beginYear) - $beginDay;

		//printf("\tbegin day: %s\n", var_export($result, true));
		
		if($firstMonth != $lastMonth){
			$result += $endDay;
		}
		


		//printf("\tend day: %s\n", var_export($endDay, true));
	
	}
	//---------------------------------------------
	
	foreach($datetime as $year => $months){

		foreach($months as $month){
			
			
			$count = monthsToDays($month, $year);
			
			$result += $count;
			
			//printf("\tyear: %s, month: %s, count: %s, result: %s\n", $year, $month, $count, $result);
		}
	}
	
	var_export($result);
	return $result;
	
}
//
//function _calculaDias($dataInicial, $dataFinal) {
//	
//
//	$result = 0;
//	$leapYearLength = 0;
//	$yearsLength = 1;
//	
//	list($beginYear, $beginMonth, $beginDay) = explode('-', $dataInicial);
//
//	list($endYear, $endMonth, $endDay) = explode('-', $dataFinal);
//	
//	printf("\tbegin: %s\n", $dataInicial);
//	printf("\tend: %s\n", $dataFinal);
//	
//	// Quando é o mesmo ano não precisa calcular o intervalo
//	if($beginYear != $endYear){
//		
//		$yearsLength = count(range($beginYear, $endYear));
//		
//		printf("\tyearsLength: %s\n", $yearsLength);
//		
//		// Calculo de um ano para o outro
//		if($yearsLength > 2){
//						
//			// Retorna os anos dentro do intervalo fechados
//			$years = getYearsRange($beginYear, $endYear);
//
//			foreach($years as $year){
//				
//				// Transforma o ano em dias
//				$result += yearsToDays($year);
//			}
//		}
//		
//		printf("\tyear result: %s\n", $result);
//	}
//	
//	// Quando é o mesmo mês não precisa calcular o intervalo
//	if($beginMonth != $endMonth){
//		
//		// Calcula o números de dias até o final do mês
//		$result += (monthsToDays($beginMonth) - $beginDay ) + $endDay;
//		
//		// Retorna os meses dentro de intervalo fechado
//		foreach(getMonthsRange($beginMonth, $endMonth) as $month){
//			 
//			// Transforma o mês em dias
//			$result += monthsToDays($month);
//		}
//		
//
////		if($yearsLength == 2 || $yearsLength == 3){
////
////			//$result += yearsToDays($beginYear);
////			$result += yearsToDays($endYear);
////		}
//		
//		printf("\tmouth result: %s\n", $result);
//	}
//	
//	if($beginMonth == $endMonth){
//		
//		if($beginDay == $endDay){
//			
//			if($yearsLength == 1){
//			
//				$result += yearsToDays($beginYear);
//			}
//			if($yearsLength == 2 || $yearsLength == 3){
//				
//				//$result += yearsToDays($beginYear);
//				$result += yearsToDays($endYear);
//			}
//			
//			$result -= $GLOBALS['leapYearLength'];
//		}
//		else {
//			
//			$result += $endDay - $beginDay;
//		}		
//	}
//	
//
//	
//	return $result;
//
//	
//	/*
//		- Setembro, abril, junho e novembro tem 30 dias, todos os outros meses tem 31 exceto fevereiro que tem 28, exceto nos anos bissextos nos quais ele tem 29.
//		- Os anos bissexto tem 366 dias e os demais 365.
//		- Todo ano divisivel por 4 e um ano bissexto.
//		- A regra acima não e valida para anos divisiveis por 100. 
//	 		Estes anos devem ser divisiveis por 400 para serem anos bissextos. 
//			Assim, o ano 1700, 1800, 1900 e 2100 nao sao bissextos, mas 2000 e bissexto.
//		- Não e permitido o uso de classes e funcoes de data da linguagem (DateTime, mktime, strtotime, etc).
//	*/
//	
//
//}
//



/***** Teste 01 *****/
$dataInicial = "2018-01-01";
$dataFinal = "2018-01-02";
$resultadoEsperado = 1;
$resultado = calculaDias($dataInicial, $dataFinal);
verificaResultado("01", $resultadoEsperado, $resultado);

/***** Teste 02 *****/
$dataInicial = "2018-01-01";
$dataFinal = "2018-02-01";
$resultadoEsperado = 31;
$resultado = calculaDias($dataInicial, $dataFinal);
verificaResultado("02", $resultadoEsperado, $resultado);

/***** Teste 03 *****/
$dataInicial = "2018-01-01";
$dataFinal = "2018-02-02";
$resultadoEsperado = 32;
$resultado = calculaDias($dataInicial, $dataFinal);
verificaResultado("03", $resultadoEsperado, $resultado);

/***** Teste 04 *****/
$dataInicial = "2018-01-01";
$dataFinal = "2018-02-28";
$resultadoEsperado = 58;
$resultado = calculaDias($dataInicial, $dataFinal);
verificaResultado("04", $resultadoEsperado, $resultado);

/***** Teste 05 *****/
$dataInicial = "2018-01-15";
$dataFinal = "2018-03-15";
$resultadoEsperado = 59;
$resultado = calculaDias($dataInicial, $dataFinal);
verificaResultado("05", $resultadoEsperado, $resultado);

/***** Teste 06 *****/
$dataInicial = "2018-01-01";
$dataFinal = "2019-01-01";
$resultadoEsperado = 365;
$resultado = calculaDias($dataInicial, $dataFinal);
verificaResultado("06", $resultadoEsperado, $resultado);

/***** Teste 07 *****/
$dataInicial = "2018-01-01";
$dataFinal = "2020-01-01";
$resultadoEsperado = 730;
$resultado = calculaDias($dataInicial, $dataFinal);
verificaResultado("07", $resultadoEsperado, $resultado);

/***** Teste 08 *****/
$dataInicial = "2018-12-31";
$dataFinal = "2019-01-01";
$resultadoEsperado = 1;
$resultado = calculaDias($dataInicial, $dataFinal);
verificaResultado("08", $resultadoEsperado, $resultado);

/***** Teste 09 *****/
$dataInicial = "2018-05-31";
$dataFinal = "2018-06-01";
$resultadoEsperado = 1;
$resultado = calculaDias($dataInicial, $dataFinal);
verificaResultado("09", $resultadoEsperado, $resultado);

/***** Teste 10 *****/
$dataInicial = "2018-05-31";
$dataFinal = "2019-06-01";
$resultadoEsperado = 366;
$resultado = calculaDias($dataInicial, $dataFinal);
verificaResultado("10", $resultadoEsperado, $resultado);

/***** Teste 11 *****/
$dataInicial = "2016-02-01";
$dataFinal = "2016-03-01";
$resultadoEsperado = 29;
$resultado = calculaDias($dataInicial, $dataFinal);
verificaResultado("11", $resultadoEsperado, $resultado);

/***** Teste 12 *****/
$dataInicial = "2016-01-01";
$dataFinal = "2016-03-01";
$resultadoEsperado = 60;
$resultado = calculaDias($dataInicial, $dataFinal);
verificaResultado("12", $resultadoEsperado, $resultado);

/***** Teste 13 *****/
$dataInicial = "1981-09-21";
$dataFinal = "2009-02-12";
$resultadoEsperado = 10006;
$resultado = calculaDias($dataInicial, $dataFinal);
verificaResultado("13", $resultadoEsperado, $resultado);

/***** Teste 14 *****/
$dataInicial = "1981-07-31";
$dataFinal = "2009-02-12";
$resultadoEsperado = 10058;
$resultado = calculaDias($dataInicial, $dataFinal);
verificaResultado("14", $resultadoEsperado, $resultado);

/***** Teste 15 *****/
$dataInicial = "2004-03-01";
$dataFinal = "2009-02-12";
$resultadoEsperado = 1809;
$resultado = calculaDias($dataInicial, $dataFinal);
verificaResultado("15", $resultadoEsperado, $resultado);

/***** Teste 16 *****/
$dataInicial = "2004-03-01";
$dataFinal = "2009-02-12";
$resultadoEsperado = 1809;
$resultado = calculaDias($dataInicial, $dataFinal);
verificaResultado("16", $resultadoEsperado, $resultado);

/***** Teste 17 *****/
$dataInicial = "1900-02-01";
$dataFinal = "1900-03-01";
$resultadoEsperado = 28;
$resultado = calculaDias($dataInicial, $dataFinal);
verificaResultado("17", $resultadoEsperado, $resultado);

/***** Teste 18 *****/
$dataInicial = "1899-01-01";
$dataFinal = "1901-01-01";
$resultadoEsperado = 730;
$resultado = calculaDias($dataInicial, $dataFinal);
verificaResultado("18", $resultadoEsperado, $resultado);

/***** Teste 19 *****/
$dataInicial = "2000-02-01";
$dataFinal = "2000-03-01";
$resultadoEsperado = 29;
$resultado = calculaDias($dataInicial, $dataFinal);
verificaResultado("19", $resultadoEsperado, $resultado);

/***** Teste 20 *****/
$dataInicial = "1999-01-01";
$dataFinal = "2001-01-01";
$resultadoEsperado = 731;
$resultado = calculaDias($dataInicial, $dataFinal);
verificaResultado("20", $resultadoEsperado, $resultado);


function verificaResultado($nTeste, $resultadoEsperado, $resultado) {
	
	//printf("expected: %s\n", $resultadoEsperado);
	//printf("result: %s\n", $resultado);
	
	if(intval($resultadoEsperado) == intval($resultado)) {
		
		echo "Teste $nTeste passou.\n";
	}
	else {
		
		echo "Teste $nTeste NAO passou (Resultado esperado = $resultadoEsperado, Resultado obtido = $resultado).\n";
	}
}
