
<?php
	// functions.php
	//var_dump($GLOBALS);
	require("../../config.php");
	//see fail peab olema kõigil lehtedel, kus tahan kasutada SESSION muutujat, tavaliselt luuakse "session_start()" ühte faili ning 
	//see tuuakse välja teistes failides, kus ühendus peab püsima
	session_start(); 
	
	
	//***************
	//**** SIGNUP ***
	//***************
	
	function signUp ($email, $password) {
		
		$database = "if16_sandra_2";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES (?, ?)");
	
		echo $mysqli->error;
		
		$stmt->bind_param("ss", $email, $password);
		
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
		
		
		//määran väärtused muutujasse
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
		$stmt->execute();
		
		//tõene kui on vähemalt üks vaste
		//andmed tulid andmebaasist v ei
		if($stmt->fetch()){
			
			//oli sellise meiliga kasutaja
			//password millega kasutaja tahab sisse logida
			$hash = hash("sha512", $password);
			if ($hash == $passwordFromDb) {
				
				echo "kasutaja logis sisse".$id;
				
				//määran sessiooni muutujad, millele saan ligi teistelt lehtedelt
				$_SESSION["userId"] = $id;
				$_SESSION["userEmail"] = $emailFromDb;
				
				
				//$_SESSION["message"] = <h1>Tere tulemast</h1>;
				//kui ühe näitame siis kustuta ära, et pärast refreshi ei näitaks
				unset($_SESSION["message"]);
				
				header("Location: data.php");
				
			}else {
				$error = "vale parool";
				
			}
		
			
		} else {
				//ei leidnud kasutajat sellise meiliga
				$error = "ei ole sellist emaili";
				
		}	

		return $error;
		
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