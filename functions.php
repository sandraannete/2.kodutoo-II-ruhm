
<?php
	// functions.php
	//var_dump($GLOBALS);
	require("../../config.php");
	//see fail peab olema kõigil lehtedel, kus tahan kasutada SESSION muutujat, tavaliselt luuakse "session_start()" ühte faili ning 
	//see tuuakse välja teistes failides, kus ühendus peab püsima
	session_start(); 
	
	function signUp ($email, $password, $firstname, $lastname) {
		
		$database = "if16_sandra_2";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password, firstname, lastname) VALUES (?, ?, ?, ?)");
	
		echo $mysqli->error;
		
		$stmt->bind_param("ssss", $email, $password, $firstname, $lastname);
		
		if($stmt->execute()) {
			echo "salvestamine õnnestus";
		} else {
		 	echo "ERROR ".$stmt->error;
		}
		
		$stmt->close();
		$mysqli->close();
	
	}
	
	function login ($email, $password){
		
		$error = "";
		
		$database = "if16_sandra_2";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database); 
		$stmt = $mysqli->prepare("
		SELECT id, email, password, created FROM user_sample WHERE email = ?");
		
		echo $mysqli->error;
		
		//asendad küsimärgi bind_param- võtab muutuja ja asendab selle väärtusesse, mida on kolm :"s", "i", "d"
		$stmt->bind_param("s", $email);
		
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
		$stmt->execute();
		
		if($stmt->fetch()){
			
			$hash = hash("sha512", $password);
			if ($hash == $passwordFromDb) {
				
				echo "kasutaja logis sisse".$id;
				
				//määran sessiooni muutujad, millele saan ligi teistelt lehtedelt
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				
				
				//$_SESSION["message"] = <h1>Tere tulemast</h1>;
				unset($_SESSION["message"]);
				
				header("Location: data.php");
				exit();
				
			}else {
				$error = "vale parool";
				
			}
		
			
		} else {
				$error = "ei ole sellist emaili";
				
		}	

		return $error;
		
	}
	
	function saveSeries ($seriesname) {
		
		$database = "if16_sandra_2";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		$stmt = $mysqli->prepare("INSERT INTO user_series (seriesname) VALUES (?)");
		
		//kirjutab ette kus täpselt viga on 
		echo $mysqli->error;
		
		$stmt->bind_param("s", $seriesname);
		
		if($stmt->execute()) {
			echo "salvestamine õnnestus";
		} else {
		 	echo "ERROR ".$stmt->error;
		}
		
	}

	function getAllSeries() {
		
		$database = "if16_sandra_2";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		$stmt = $mysqli->prepare("SELECT id, seriesname, FROM user_series");
		
		$stmt->bind_result($id, $seriesname);
		$stmt->execute();
		
		//tekitan massiivi
		$result = array();
		
		//while tingimus-tee seda kuni on rida andmeid
		//mis vastab select lausele
		// while järgne sulu sisu määrab kaua korratakse
		while($stmt->fetch()) {
			
			//tekitan objekti
			$series = new StdClass();
			$series->id = $id;
			$series->seriesname = $seriesname;
			
			//echo $plate."<br>";
			//igakord massiivi lisan juurde numbrimärgi
			array_push($result, $series);
			
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $result;
	}

	function saveCar ($plate, $color) {
		
		$database = "if16_sandra_2";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		$stmt = $mysqli->prepare("INSERT INTO cars_and_colors (plate, color) VALUES (?, ?)");
		
		//kirjutab ette kus täpselt viga on 
		echo $mysqli->error;
		
		$stmt->bind_param("ss", $plate, $color);
		
		if($stmt->execute()) {
			echo "salvestamine õnnestus";
		} else {
		 	echo "ERROR ".$stmt->error;
		}
		
	}
	

	function getAllCars() {
		
		$database = "if16_sandra_2";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		$stmt = $mysqli->prepare("SELECT id, plate, color FROM cars_and_colors");
		
		$stmt->bind_result($id, $plate, $color);
		$stmt->execute();
		
		//tekitan massiivi
		$result = array();
		
		//while tingimus-tee seda kuni on rida andmeid
		//mis vastab select lausele
		// while järgne sulu sisu määrab kaua korratakse
		while($stmt->fetch()) {
			
			//tekitan objekti
			$car = new StdClass();
			$car->id = $id;
			$car->plate = $plate;
			$car->color = $color;
			
			//echo $plate."<br>";
			//igakord massiivi lisan juurde numbrimärgi
			array_push($result, $car);
			
		}
		
		$stmt->close();
		$mysqli->close();
		
		return $result;
	}	
		
	function cleanInput ($input){

		$input = trim($input);
		$input = stripslashes($input);
		$input = htmlspecialchars($input);

		return $input;


	}	
		
		
	
	
	
	
	
	/*function sum($x, $y) {
		
		return $x + $y;
		
	}
	
	
	function hello($firsname, $lastname) {
		
		return "Tere tulemast ".$firsname." ".$lastname."!";
		
	}
	
	echo sum(5123123,123123123);
	echo "<br>";
	echo hello("Sandra", "Tagam");
	echo "<br>";
	echo hello("Sand", "Tagha");
	*/
?>