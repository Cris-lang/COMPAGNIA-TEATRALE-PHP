<?php
	session_start();
	if(!isset($_SESSION['user'])){		//controlla se non si ha gia effettuato l'accesso
		header("Location: accedi.php");
		exit;
	}
?>

<html>
	<head>
		<title>I100Spettacoli</title>
		<link rel="stylesheet" href="style.css?ts=<?=time()?>&quot">
		<meta charset="utf-8" />
	</head>

	<body>
		<div id="header">
			<a href="javascript:history.back()" style="text-decoration: none;"> <!--Funzione javascript per tornare indietro di una pagina-->
				<div id="pulsate">
					I100spettacoli
				</div>
			</a>
		</div>
		
		<div class="pimg4" style="background-size: cover; background-repeat: no-repeat; height: 100%;">	
			<div class="ptext" style="background-color: rgba(17, 17, 17, 0.8);color: #fff;top: 30%; padding-top: 10px;">
				
				<?php
					$hostname = "127.0.0.1";
					$dbname = "i100spettacoli";
					$con = 0;

					$saturday = date('y-m-d', strtotime('saturday this week'));	//controlla se si ha gia effettuato l'accesso
					$today = date('y-m-d');	//ottiene la data di oggi 

				?>
				<div class="select">
					<form action="biglietti.php" method="get">
						Scegli il teatro dove acquistare i biglietti<br>
						<select name="teatro" class="scelta">
							<option value="Eclissi">Teatro Eclissi</option>
							<option value="Sisifone">Teatro Sisifone</option>
						</select>
						<input type="submit" name="submit" value="Invia">
					</form>
				</div>
			</div>
		</div>

		<section class="dark" style="text-align: center; border-top: solid 1px #ffffff; padding-top: 5px; height: 10px;"> <!--footer-->
			Copyrigth @ I100spettacoli. All right reserved.
		</section>
	</body>
</html>