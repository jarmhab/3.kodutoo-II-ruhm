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
//m�ngu lisamise errorid
	$game_name = $baskets = $game_name_error = $baskets_error = "";	
	
	if(isset($_POST["create_game"])){
			if ( empty($_POST["game_name"]) ) {
				$game_name = "See v�li on kohustuslik";
			}else{
				$game_name = cleanInput($_POST["game_name"]);
			}
			if ( empty($_POST["baskets"]) ) {
				$baskets = "See v�li on kohustuslik";
			} else {
				$baskets = cleanInput($_POST["baskets"]);
			}
	if(	$game_name_error == "" && $baskets_error == ""){
		// functions.php failis k�ivina funktsiooni
				//msg on message
				$msg = createGame ($game_name, $baskets);
				
				if($msg != ""){
					//salvestamine �nnestus
					//teen t�hjaks input v�ljad
					$game_name	= "";
					$baskets = "";
					
					echo $msg;
					
				}
			}
	}	// create if end
	
//tulemuse lisamise errorid	
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
	  
	  
	  $result_list = getGameData();
?>

<p>
	Tere, <?php echo $_SESSION["user_email"];?>
	<a href="?logout=1"> Logi v�lja</a>
</p>

<h1>Discgolf</h1><br>
<h2>M�ngu lisamine</h2><br>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<label for="game_name" >M�ngu nimetus</label> <input id="game_name" name="game_name" type="text" value="<?=$game_name; ?>"> <?=$game_name_error; ?>
  	<label for="baskets">Korvide arv</label> <input name="baskets" type="number" value="<?=$baskets; ?>"> <?=$baskets_error; ?><br><br>
  	<input type="submit" name="create_game" value="Salvesta">
  </form>
  <table border=1 >
<tr>
	<th>m�ngu id</th>
	<th>m�ngu nimetus</th>
	
</tr>
<?php for($i = 0; $i < count($result_list); $i++){
			

			
			echo "<tr>";
			
			echo "<td>".$result_list[$i]->id."</td>";
			echo "<td>".$result_list[$i]->name."</td>";
			echo "<td><a href='?add_result=".$result_list[$i]->id."&baskets=".$result_list[$i]->baskets."'>lisa tulemus</a></td>";
			
			echo "</tr>";
			
			
			
		}
?>
</table>
<?php 

if(isset($_GET["add_result"])){

?>

	<h2>Tulemuse lisamine</h2>
	  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
		
		<?php for($i=1; $i <= $_GET["baskets"]; $i++){ ?>
		<label for="basket" >Korv <?=$i;?></label> <input id="basket" name="basket" type="number"><input type="submit" name="add_result" value="Salvesta"><br>
		
	  
		<?php 
		}
		?>  
		</form>
	  
<?php 
}
?>  