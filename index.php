<!doctype html>
<?php
include("inc/db_credentials.php");	//This is getting ready for PHP funsies
include("app/app_class.php");
include("app/app_func.php");
include("app/db_connect.php");

$fFile = "files/carCSV.csv";

$array_of_cars = readCSV($fFile);

$make_array = [];
$model_array = [];
$cylin_array = [];
$horse_array = [];
$engine_array = [];
$trans_array = [];

foreach($array_of_cars as $row => $car){
	if(!in_array(strtoupper($car[0]), $make_array)){
		$make_array[] = strtoupper($car[0]);
	}
	if(!in_array(strtoupper($car[1]), $model_array)){
		$model_array[] = strtoupper($car[1]);
	}
	if(!in_array(strtoupper($car[2]), $horse_array)){
		$horse_array[] = strtoupper($car[2]);
	}
	if(!in_array(strtoupper($car[3]), $cylin_array)){
		$cylin_array[] = strtoupper($car[3]);
	}
	if(!in_array(strtoupper($car[4]), $engine_array)){
		$engine_array[] = strtoupper($car[4]);
	}
	if(!in_array(strtoupper($car[5]), $trans_array)){
		$trans_array[] = strtoupper($car[5]);
	}
}

?>
<html>
<head>
	<link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
	<div class="container">
	<form method="post">
	<div class="item col-md-6">
		<h1>Select Make</h1>
		<select class="item-select" name="make">
			<option value="*">All</option>
			<?php
				for($i = 0; $i < count($make_array); $i++){
					echo '<option value="' . $make_array[$i] . '">' . $make_array[$i] . '</option>';
				}
			?>
		</select>
	</div>
	<div class="item col-md-6">
		<h1>Select Model</h1>
		<select class="item-select" name="model">
			<option value="*">All</option>
			<?php
				for($i = 0; $i < count($model_array); $i++){
					echo '<option value="' . $model_array[$i] . '">' . $model_array[$i] . '</option>';
				}
			?>
		</select>
	</div>
	<div class="item col-md-6">
		<h1>Select Horsepower</h1>
		<select class="item-select" name="horse">
			<option value="*">All</option>
			<?php
				for($i = 0; $i < count($horse_array); $i++){
					echo '<option value="' . $horse_array[$i] . '">' . $horse_array[$i] . '</option>';
				}
			?>
		</select>
	</div>
	<div class="item col-md-6">
		<h1>Select Number of Cylinders</h1>
		<select class="item-select" name="cylin">
			<option value="*">All</option>
			<?php
				for($i = 0; $i < count($cylin_array); $i++){
					echo '<option value="' . $cylin_array[$i] . '">' . $cylin_array[$i] . '</option>';
				}
			?>
		</select>
	</div>
	<div class="item col-md-6">
		<h1>Select Engine Code</h1>
		<select class="item-select" name="engine">
			<option value="*">All</option>
			<?php
				for($i = 0; $i < count($engine_array); $i++){
					echo '<option value="' . $engine_array[$i] . '">' . $engine_array[$i] . '</option>';
				}
			?>
		</select>
	</div>
	<div class="item col-md-6">
		<h1>Select Transmission</h1>
		<select class="item-select" name="trans">
			<option value="*">All</option>
			<?php
				for($i = 0; $i < count($trans_array); $i++){
					echo '<option value="' . $trans_array[$i] . '">' . $trans_array[$i] . '</option>';
				}
			?>
		</select>
	</div>
	<br/>
	<br/>
	<input type="submit" class="col-md-8 container"/>
	</form>
	</div>
	<div class="container">
		<?php
if(isset($_POST["make"]) && isset($_POST["model"]) && isset($_POST["horse"]) && isset($_POST["cylin"]) && isset($_POST["engine"]) && isset($_POST["trans"])){

	$fMake = $_POST["make"];
	$fModel = $_POST["model"];
	$fHorse = $_POST["horse"];
	$fCylin = $_POST["cylin"];
	$fEngine = $_POST["engine"];
	$fTrans = $_POST["trans"];

	readCars("Make", $fMake, $array_of_cars, 0);
	readCars("Model", $fModel, $array_of_cars, 1);
	readCars("Horsepower", $fHorse, $array_of_cars, 2);
	readCars("Cylinder Count", $fCylin, $array_of_cars, 3);
	readCars("Engine Code", $fEngine, $array_of_cars, 4);
	readCars("Transmission", $fTrans, $array_of_cars, 5);

}
		?>
		<a href="index.php">Reset</a>
	</div>
</body>
</html>