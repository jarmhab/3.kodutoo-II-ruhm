<?php

//laeme funktsiooni faili
	require_once("function.php");
	
//kontrollin, kas kasutaja ei ole sisseloginud
	if(!isset($_SESSION["id_from_db"])){
		//suunan login lehele
		header("Location: login.php");
	}
	
//login välja
	if (isset($_GET["logout"])){
		//kustutab kõik sessiooni muutujad
		session_destroy();
		
		header("Location: login.php");
	}
	
	$basket = $basket_error = "";
	
	if(isset($_POST["save"])){
			if ( empty($_POST["basket"]) ) {
				$basket_error = "Palun sisesta tulemus";
			}else{
				$basket = cleanInput($_POST["basket"]);
			}
			
	if(	$basket_error == ""){
				
				
				// functions.php failis käivina funktsiooni
				//msg on message
				$msg = saveBasket(1,$basket,$id);
				
				if($msg != ""){
					//salvestamine õnnestus
					//suunan 2. korvi lehele
					header("Location: raama_basket_2.php");
					
					
					
				}
			}
	}
	
	function cleanInput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	  }
?>
<p>
	Tere, <?php echo $_SESSION["user_email"];?>
	<a href="?logout=1"> Logi välja</a>
</p>
<h1>Rääma Discgolf</h1>
<h2>1. korv</h2>
<p>Par=3</p>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<label for="basket" >Minu tulemus</label>
	<input id="basket" name="basket" type="number" value="<?=$basket; ?>"> <?=$basket_error; ?><br>	
  	<input type="submit" name="save" value="Salvesta">
  </form>