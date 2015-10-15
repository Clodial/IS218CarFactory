<?php

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

?>