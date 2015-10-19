<?php

/**
*
*	Car Classes
*
**/

class cl_car{

	private $make;
	private $model;
	private $trans;
	private $hPower;
	private $eCode;
	private $nCylin;

	public function __construct($aMake, $aModel, $aCylin, $aPow, $aEngine, $aTrans){

		$this->make = $aMake;
		$this->model = $aModel;
		$this->trans = $aTrans;
		$this->hPower = $aPow;
		$this->eCode = $aEngine;
		$this->nCylin = $aCylin;

	}


	public function getMakeAndModel(){

		return 'Make: ' . $this->make . ' | Model: ' . $this->model . ' | Transmission: ' . $this->trans;

	}


}

class cl_carFactory{

	public static function create($aMake, $aModel, $aPow, $aCylin, $aEngine, $aTrans){

		return new cl_car($aMake, $aModel, $aCylin, $aPow, $aEngine, $aTrans);

	}

}

/**
*
*	Page Classes
*
**/

class cl_main{

	private $cArray = [];

	public function __construct($aCSV){

		$this->cArray = $this->readCSV($aCSV);

		$page_request = 'cl_carChoose';

		if(!empty($_REQUEST)){

			$page_request = $_REQUEST['page'];
			if(!($page_request == "cl_carChoose") && !($page_request == "cl_carShow")){
				$page_request = "cl_carChoose";
			}
		}

		$page = new $page_request($this->getCSV());

		if($_SERVER['REQUEST_METHOD'] == 'GET'){
			
			$page->get();
		
		}else{
			
			//defaulting to post, pretty much
			$page->post();
		
		}

	}

	public function readCSV($aCsvFile){

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

	public function getCSV(){

		return $this->cArray;
	
	}

}

class cl_page{

	//This class doesn't get and post since, it isn't necessary
	private $array_of_cars;

	public function __construct($aArray){

		$this->array_of_cars = $aArray;

	}

	public function getArray(){

		return $this->array_of_cars;
	
	}

}

class cl_carChoose extends cl_page{

	private $make_array = [];
	private $model_array = [];
	private $cylin_array = [];
	private $horse_array = [];
	private $engine_array = [];
	private $trans_array = [];

	public function get(){

		$locArray = $this->getArray();

		foreach($locArray as $row => $car){

			$this->makeSelector($car, $this->make_array, 0);
			$this->makeSelector($car, $this->model_array, 1);
			$this->makeSelector($car, $this->cylin_array, 2);
			$this->makeSelector($car, $this->horse_array, 3);
			$this->makeSelector($car, $this->engine_array, 4);
			$this->makeSelector($car, $this->trans_array, 5);
		
		}

		$this->createForm($this->make_array,$this->model_array,$this->cylin_array,$this->horse_array,$this->engine_array,$this->trans_array);

	}

	public function post(){
		
		$locArray = $this->getArray();

		foreach($locArray as $row => $car){

			$this->make_array = $this->makeSelector($car, $this->make_array, 0);
			$this->model_array = $this->makeSelector($car, $this->model_array, 1);
			$this->cylin_array = $this->makeSelector($car, $this->cylin_array, 2);
			$this->horse_array = $this->makeSelector($car, $this->horse_array, 3);
			$this->engine_array = $this->makeSelector($car, $this->engine_array, 4);
			$this->trans_array = $this->makeSelector($car, $this->trans_array, 5);
		
		}

		$this->createForm($this->make_array,$this->model_array,$this->cylin_array,$this->horse_array,$this->engine_array,$this->trans_array);

	}

	public function makeSelector($aCSV, $aArrCh, $aIn){

		if(!in_array(strtoupper($aCSV[$aIn]), $aArrCh)){

			$aArrCh[] = strtoupper($aCSV[$aIn]);
		
		}

		return $aArrCh;

	}

	public function createForm($aMake, $aModel, $aHorse, $aCylin, $aEngine, $aTrans){

		echo '<div class="container">';
		echo '	<form method="post">';
		$this->createSelector("col-md-6", $aMake, "make");
		$this->createSelector("col-md-6", $aModel, "model");
		$this->createSelector("col-md-6", $aHorse, "horsepower");
		$this->createSelector("col-md-6", $aCylin, "cylinders");
		$this->createSelector("col-md-6", $aEngine, "engine");
		$this->createSelector("col-md-6", $aTrans, "transmission");
		echo ' 		<button type="submit" name="page" value="cl_carShow">Show Me Up</button>';
		echo ' 	</form>';
		echo '</div>';
	
	}

	public function createSelector($aClass, $aArray, $aName){
	
		echo '<div class="item '. $aClass . '">';
		echo '	<h1>Select ' . $aName . '</h1>';
		echo '	<select class="item-select" name="' . $aName . '">';
		echo ' 		<option value="*">All</option>';

		foreach($aArray as $row => $part){
			echo '	<option value="' . $part . '">' . $part . '</option>';
		}

		echo '	</select>';
		echo '</div>';
	
	}
}

class cl_carShow extends cl_page{

	private $cMake;
	private $cModel;
	private $cHorse;
	private $cCylin;
	private $cEngine;
	private $cTrans;

	public function get(){

		if(!empty($_REQUEST)){
			$this->cMake = $_REQUEST['make'];
			$this->cModel = $_REQUEST['model'];
			$this->cHorse = $_REQUEST['horsepower'];
			$this->cCylin = $_REQUEST['cylinders'];
			$this->cEngine = $_REQUEST['engine'];
			$this->cTrans = $_REQUEST['transmission'];
		}else{
			$this->cMake = "*";
			$this->cModel = "*";
			$this->cHorse = "*";
			$this->cCylin = "*";
			$this->cEngine = "*";
			$this->cTrans = "*";
		}

		$this->readCars("Make", $this->cMake, $this->getArray(), 0);
		$this->readCars("Model", $this->cMake, $this->getArray(), 1);
		$this->readCars("Horsepower", $this->cMake, $this->getArray(), 2);
		$this->readCars("Cylinder Count", $this->cMake, $this->getArray(), 3);
		$this->readCars("Engine Code", $this->cMake, $this->getArray(), 4);
		$this->readCars("Trasmission", $this->cMake, $this->getArray(), 5);
		echo '<form method="POST">';
		echo ' 	<button type="submit" name="page" value="cl_carChoose">Show Me Down</button>';
		echo '</form>';

	}

	public function post(){
		
		if(!empty($_REQUEST)){
			$this->cMake = $_REQUEST['make'];
			$this->cModel = $_REQUEST['model'];
			$this->cHorse = $_REQUEST['horsepower'];
			$this->cCylin = $_REQUEST['cylinders'];
			$this->cEngine = $_REQUEST['engine'];
			$this->cTrans = $_REQUEST['transmission'];
		}else{
			$this->cMake = "*";
			$this->cModel = "*";
			$this->cHorse = "*";
			$this->cCylin = "*";
			$this->cEngine = "*";
			$this->cTrans = "*";
		}

		$this->readCars("Make", $this->cMake, $this->getArray(), 0);
		$this->readCars("Model", $this->cModel, $this->getArray(), 1);
		$this->readCars("Horsepower", $this->cHorse, $this->getArray(), 2);
		$this->readCars("Cylinder Count", $this->cCylin, $this->getArray(), 3);
		$this->readCars("Engine Code", $this->cEngine, $this->getArray(), 4);
		$this->readCars("Transmission", $this->cTrans, $this->getArray(), 5);
		echo '<br/>';
		echo '<form class="container" method="POST">';
		echo ' 	<button type="submit" name="page" value="cl_carChoose">Show Me Down</button>';
		echo '</form>';
		echo '<br/>';
		echo '<br/>';
		echo '<br/>';
		echo '<br/>';

	}

	public function readCars($aName, $aVar, $aCars, $aInd){

		echo '<div class="container">';
		echo '<h1 class="col-md-12">By ' . $aName . ': ' . $aVar . '</h1>';

		foreach($aCars as $row => $comp){

			if( $aVar == "*" || ($aVar != "*" && $aVar == $comp[$aInd])){

				$car = cl_carFactory::create($comp[0], $comp[1], $comp[2], $comp[3], $comp[4], $comp[5]);
				echo '<div class="col-md-3">';
				print_r($car->getMakeAndModel());
				echo '<hr>';
				echo '</div>';
				unset($car);
			
			}

		}
		echo '</div>';
		echo '<br/>';

	}

}

?>