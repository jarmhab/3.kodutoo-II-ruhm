<?php
//Siia tuleb discgolfitabelid

//laeme funktsiooni faili
	require_once("function.php");
	
//kontrollin, kas kasutaja ei ole sisseloginud
	if(!isset($_SESSION["id_from_db"])){
		//suunan login lehele
		header("Location: login.php");
	}
	
//login v�lja
	if (isset($_GET["logout"])){
		//kustutab k�ik sessiooni muutujad
		session_destroy();
		
		header("Location: login.php");
	}
	
	$par = $result = $par_error = $result_error = "";
	
	if(isset($_POST["create"])){
			if ( empty($_POST["par"]) ) {
				$par = "See v�li on kohustuslik";
			}else{
				$par = cleanInput($_POST["par"]);
			}
			if ( empty($_POST["result"]) ) {
				$result = "See v�li on kohustuslik";
			} else {
				$result = cleanInput($_POST["result"]);
			}
	if(	$par_error == "" && $result_error == ""){
		// functions.php failis k�ivina funktsiooni
				//msg on message
				$msg = createResult ($par, $result);
				
				if($msg != ""){
					//salvestamine �nnestus
					//teen t�hjaks input v�ljad
					$par	= "";
					$result = "";
					
					echo $msg;
					
				}
			}
	}	// create if end
	
	function cleanInput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	  }
?>

<p>
	Tere, <?php echo $_SESSION["user_email"];?>
	<a href="?logout=1"> Logi v�lja</a>
</p>

<h1>Discgolf Park</h1><br>
<h2>Tulemuse lisamine</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<label for="par" >Raja par</label> <input id="par" name="par" type="text" value="<?=$par; ?>"> <?=$par_error; ?>
  	<label>Minu tulemus</label>	<input name="result" type="text" value="<?=$result; ?>"> <?=$result_error; ?><br><br>
  	<input type="submit" name="create" value="Salvesta">
  </form>