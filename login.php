<?php 
	
	require("../../config.php");
	require("functions.php");
	
	//kui on juba sisse loginud siis suunan data lehele
	if (isset($_SESSION["userId"])){
		
			//suunan sisselogimise lehele
			header("Location: data.php");
	}
	
	//echo hash("sha512", "b");
	
	
	//GET ja POSTi muutujad
	//var_dump($_GET);
	//echo "<br>";
	//var_dump($_POST);
	
	//echo strlen("äö");
	
	// MUUTUJAD
	$signupEmailError = "";
	$signupPasswordError = "";
	$signupFirstNameError = "";
	$signupLastNameError = "";
	$signupEmail = "";
	$signupGender = "";
	$loginEmailError = "";
	$loginEmail = "";
	$FirstName = "";
	$LastName = "";



	if( isset( $_POST["loginEmail"] ) ){
		
		if( empty( $_POST["loginEmail"] ) ){
			
			$loginEmailError = "Email jäi tühjaks";
			
		} else {

			$loginEmail = $_POST["loginEmail"];
			
		}
		
	} 
	

	if( isset( $_POST["signupEmail"] ) ){
		
		if( empty( $_POST["signupEmail"] ) ){
			
			$signupEmailError = "See väli on kohustuslik";
			
		} else {
			
			// email olemas 
			$signupEmail = $_POST["signupEmail"];
			
		}
		
	} 
	


	if( isset( $_POST["signupPassword"] ) ){
		
		if( empty( $_POST["signupPassword"] ) ){
			
			$signupPasswordError = "Parool on kohustuslik";
			
		} else {
			
			if ( strlen($_POST["signupPassword"]) < 8 ) {
				
				$signupPasswordError = "Parool peab olema vähemalt 8 tähemärkki pikk";
			
			}
			
		}
	}

	if(isset($_POST["FirstName"]))
	{
		if(empty($_POST["FirstName"])) 
		{
			$signupFirstNameError = "See väli on kohustuslik";
		}else {
			
			// email olemas 
			$FirstName = $_POST["FirstName"];
			
		}
	}
	if(isset($_POST["LastName"]))
	{
		if(empty($_POST["LastName"]))
		{
			$signupLastNameError = "See väli on kohustuslik";
		}else {
			
			$LastName = $_POST["LastName"];
		}
	}
	
	if( isset( $_POST["signupGender"] ) ){
		
		if(!empty( $_POST["signupGender"] ) ){
		
			$signupGender = $_POST["signupGender"];
			
		}
		
	} 

	if ( isset($_POST["signupEmail"]) && 
		 isset($_POST["signupPassword"]) && 
		 isset($_POST["FirstName"]) &&
		 isset($_POST["LastName"]) &&
		 $signupEmailError == "" && 
		 empty($signupPasswordError)
		) {
		
		echo "Salvestan... <br>";
		
		echo "email: ".$signupEmail."<br>";
		echo "firstname: ".$FirstName."<br>";
		echo "lastname: ".$LastName."<br>";
		echo "password: ".$_POST["signupPassword"]."<br>";
		echo "";
		
		$password = hash("sha512", $_POST["signupPassword"]);
		
		echo "password hashed: ".$password."<br>";
		
		
		//echo $serverUsername;
		
		// KASUTAN FUNKTSIOONI
		$signupEmail = cleanInput($signupEmail);
		$FirstName = cleanInput($FirstName);
		$LastName = cleanInput($LastName);
		signUp($signupEmail, cleanInput($password), $FirstName, $LastName);

	}
	
	$error ="";
	if ( isset($_POST["loginEmail"]) && isset($_POST["loginPassword"]) &&
		!empty($_POST["loginEmail"]) && !empty($_POST["loginPassword"])
	) {
		$error = login(cleanInput($_POST["loginEmail"]), cleanInput($_POST["loginPassword"]));

	}

?>
<!DOCTYPE html>
<body style="background-color:palegreen;">
<html>
	<h1>Logi sisse või loo kasutaja</h1>
</head>
<body>
	<h2>Logi sisse</h2>
		<form method="POST"> 
			<p style="color:red;"><?=$error;?></p>
			
			<input name="loginEmail" placeholder="E-post" type="Email">
			<?php echo $loginEmailError; ?>
			<br><br>
			<input name="loginPassword" placeholder="Parool" type="password">
			<br><br>
			<input type="submit" value="Logi sisse">
			
		</form>
		
	<h2>Loo kasutaja</h2>
		<form method="POST">
			<input name="signupEmail" placeholder="E-post" type="text" value="<?=$signupEmail;?>" />
			<?php echo $signupEmailError; ?>
			
			<br><br>
			
			<input name="signupPassword" placeholder="Parool" type = "Password" /> 
			<?php echo $signupPasswordError; ?>
			<br><br>
			
			<input name="FirstName" placeholder="Eesnimi" type="name" />
			<?php echo $signupFirstNameError; ?>
			<br><br>
			
			<input name="LastName" placeholder="Perekonnanimi" type="surname" />
			<?php echo $signupLastNameError; ?>
			
<h3>Sugu</h3>
			<?php if($signupGender == "Mees") { ?>
			<input type="radio" name="signupGender" value="Mees" checked> Mees<br>
		<?php }else { ?>
			<input type="radio" name="signupGender" value="Mees"> Mees<br>
		<?php } ?>
		
		<?php if($signupGender == "Naine") { ?>
			<input type="radio" name="signupGender" value="Naine" checked> Naine<br>
		<?php }else { ?>
			<input type="radio" name="signupGender" value="Naine"> Naine<br>
		<?php } ?>
		
		<?php if($signupGender == "Muu") { ?>
			<input type="radio" name="signupGender" value="Muu" checked> Muu<br>
		<?php }else { ?>
			<input type="radio" name="signupGender" value="Muu"> Muu<br>
		<?php } ?>
			
			<br><br>
			
			<input type="submit" value="Loo kasutaja">
		</form>	
</body>
</html>
