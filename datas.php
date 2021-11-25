<?php

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

function monthsToDays($month, $year){
	
	$result = 31; 
	
	switch(intval($month)){
				
		case 2:
			$result = isLeapYear($year) ? 29 : 28;
			break;

		case 4:// Abril
		case 6:// Junho
		case 9:// Setembro	
		case 11:// novembro
			$result = 30;
			break;
	}
		
	return $result;
}

/**
* Calcula o numero de dias entre 2 datas.
* As datas passadas sempre serao validas e a primeira data sempre sera menor que a segunda data.
* @param string $dataInicial No formato YYYY-MM-DD
* @param string $dataFinal No formato YYYY-MM-DD
* @return int O numero de dias entre as datas
**/
function calculaDias($dataInicial, $dataFinal) {

	//printf("\tbegin: %s\n", $dataInicial);
	//printf("\tend: %s\n", $dataFinal);
	
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

		//printf("\tlastMonth: %s\n", $lastMonth);
		//printf("\tfirstMonth: %s\n", $firstMonth);
		
		$result += monthsToDays($firstMonth, $beginYear) - $beginDay;

		//printf("\tbegin day: %s\n", var_export($result, true));
		
		$result += $endDay;

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
	
	return $result;	
}


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
