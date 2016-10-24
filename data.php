<?php

	require("functions.php");
	
	//kui ei ole kasutaja id'd
	if (!isset($_SESSION["userId"])){
		
			//suunan sisselogimise lehele
			//iga header järgi peaks exit command tulema
			header("Location: login.php");
			exit();
	}
	
	//kui on ?logout aadressireal siis login välja
	if (isset($_GET["logout"])) {
		session_destroy();
		header("Location: login.php");
	//alguses paned functionsisse *70.s rida* kirja commandi, siis tood välja data.php-sse *alumised 3 rida	ja 
	//peale Data html-i järgmine rida.
	}
	$msg = "";
	if(isset($_SESSION["message"])){
		$msg = $_SESSION["message"];
	
	unset($_SESSION["message"]);
	}
	
	if ( isset($_POST["seriesname"]) && !empty($_POST["seriesname"])
	) {
		saveSeries(cleanInput($_POST["seriesname"]));
		
	}
	
	if ( isset($_POST["plate"]) && isset($_POST["color"]) &&
		!empty($_POST["plate"]) && !empty($_POST["color"])
	) {
		saveCar(cleanInput($_POST["plate"]), cleanInput($_POST["color"]));
			
	}
	//saan kõik auto andmed,  echo pre paneb kõik andmed var dumpis korralikult rivisse
	$carData = getAllcars();
	//echo "<pre>";
	//var_dump($carData);
	//echo "</pre>";
	
?>
<h1>Data</h1>
<?=$msg;?>


<p> Tere tulemast <?=$_SESSION ["userEmail"];?>!
<a href="data.php?logout=1">Logi välja </a>
</p>
	<br><br>
	<h2>Leia infot seriaali kohta </h2>
		<form method="POST">

			<select name="series">
				<option value="westworld">Westworld</option>
				<option value="ahs">American Horror Story</option>
				<option value="lukecage">Luke Cage</option>
				<option value="walkingdead">The Walking Dead</option>
				<option value="newgirl">New Girl</option>
				<option value="southpark">South Park</option>
				<option value="modernfamily">Modern Family</option>
				<option value="got">Game Of Thrones</option>
				<option value="vikings">Vikings</option>
				<option value="narcos">Narcos</option>
				<option value="supernatural">Supernatural</option>
				<option value="gotham">Gotham</option>
				<option value="mrrobot">Mr.Robot</option>
			</select>	
		
		<input type="submit" value="Otsi"> 
		<br><br>

	<h2>Salvesta oma lemmikseriaalid</h2>
		<form method="POST">
			<input name="seriesname" placeholder="Seriaali nimi" type="text">

		<input type="submit" value="Salvesta">

		<br><br><br><br>


	<h2>Salvesta auto</h2>
		<form method="POST">
		
			<input name="plate" placeholder="Auto number" type="text">
			<br><br>
			
			<label>Auto varv</label><br><br> 
			<input name="color" type="color">
			
			<br><br>
			<input type="submit" value="Salvesta">
			
			
</form>

<h2>Autod</h2>			
<?php
	
	$html = "<table>";
	$html .= "<tr>";
			$html .= "<th>id</th>";
			$html .= "<th>plate</th>";
			$html .= "<th>color</th>";
	$html .= "</tr>";
	
	// iga liikme kohta massiivis
	foreach ($carData as $c){
		//iga auto on $c
		//echo $c->plate."<br>";
		
		$html .= "<tr>";
			$html .= "<td>".$c->id."</td>";
			$html .= "<td>".$c->plate."</td>";
			$html .= "<td style='background-color:".$c->color."'>".$c->color."</td>";
	$html .= "</tr>";
	
		
	}
	
	$html .= "</table>";
	echo $html;
	
	$listHtml = "<br><br>";
	foreach ($carData as $c){
		
		$listHtml .= "<h1 style='color:".$c->color."'>".$c->plate."</h1>";
		$listHtml .="<p>color = ".$c->color."</p>";
		
	}
	echo $listHtml;
	
?>