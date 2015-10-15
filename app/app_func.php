<?php

function readCSV($aCsvFile){
	$loc_LoT = array();
	$i = 0;
	$loc_handle = fopen($aCsvFile, 'r');
	while(($row = fgetcsv($loc_handle, 1024)) !== false){
		foreach($row as $k=> $value){
			$loc_LoT[$i][$k] = strtoupper($value);
		}
		$i++;
	}
	fclose($loc_handle);
	return $loc_LoT;

}

function readCars($aName, $aVar, $aCars, $aInd){
	echo '<h1>By ' . $aName . ': ' . $aVar . '</h1>';
	foreach($aCars as $row => $comp){
		if( $aVar == "*" || ($aVar != "*" && $aVar == $comp[$aInd])){
			$car = cl_carFactory::create($comp[0], $comp[1], $comp[2], $comp[3], $comp[4], $comp[5]);
			print_r($car->getMakeAndModel());
			echo '<hr>';
			unset($car);
		}
	}
}
?>