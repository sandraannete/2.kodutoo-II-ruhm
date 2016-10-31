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
		<h2>Salvesta oma lemmikseriaalid</h2>
		<form method="POST">
			<input name="seriesname" placeholder="Seriaali nimi" type="text">

		<input type="submit" value="Salvesta">

		<br>
	<body style="background-color:palegreen;">
	<h2>Leia infot seriaali kohta </h2>
		<form method="POST">

		<form name="series">
			<select name="menu" onChange="window.document.location.href=this.options[this.selectedIndex].value;" 
			<option selected="selected">Vali üks</option>
				<option value="http://www.imdb.com/title/tt0475784/episodes?ref_=tt_ov_epl">Westworld</option>
				<option value="http://www.imdb.com/title/tt1844624/episodes?ref_=tt_ov_epl">American Horror Story</option>
				<option value="http://www.imdb.com/title/tt1520211/episodes?ref_=tt_ov_epl">The Walking Dead</option>
				<option value="http://www.imdb.com/title/tt1826940/episodes?ref_=tt_ov_epl">New Girl</option>
				<option value="http://www.imdb.com/title/tt1442437/episodes?ref_=tt_ov_epl">Modern Family</option>
				<option value="http://www.imdb.com/title/tt0944947/episodes?ref_=tt_ov_epl">Game Of Thrones</option>
				<option value="http://www.imdb.com/title/tt2306299/episodes?season=4">Vikings</option>
				<option value="http://www.imdb.com/title/tt2707408/episodes?ref_=tt_ov_epl">Narcos</option>
				<option value="http://www.imdb.com/title/tt4158110/episodes?season=2">Mr.Robot</option>
			</select>
		</form>	
		<br><br>

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