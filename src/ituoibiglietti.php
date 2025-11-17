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
		<!-- header -->

		<div id="header">
			<a href="javascript:history.back()" style="text-decoration: none;"> <!--Funzione javascript per tornare indietro di una pagina-->
				<div id="pulsate">
					I100spettacoli
				</div>
			</a>
			<!--<input type="button" value="Go Back From Whence You Came!" onclick="history.back(-1)" />-->
		</div>

		<div class="split left" style="width: 100%; background-size: cover; background-repeat: no-repeat; height: 100%;">	
			<div class="ptext" style="background-color: rgba(17, 17, 17, 0.8); color: #fff;top: 25%; padding-top: 10px;">
				<?php
					$hostname = "127.0.0.1";
					$dbname = "i100spettacoli";
					$con = 0;
					$nome_teatro = "Eclissi";
					$user = $_SESSION['user'];
					$id_s = $user['id_s'];		//ottiene l' id dell' utente loggato
					$today = date('y-m-d');		//ottiene la data di oggi
					date_default_timezone_set("Europe/Rome");
					$time =  date("h:i:sa");	//ottiene l'orario corrente

					$con = new PDO("mysql:host=$hostname;dbname=$dbname", "root", "");	//collegamento con il db

					//mostra i biglietti acquistati dall'utente(solo se ancora si devono svolgere)
					$stmt = $con->prepare("SELECT dettagli.*, spettacoli.nome AS nomes, teatri.nome AS nomet, prenota.n_posto, prenota.balconata FROM dettagli, spettatori, prenota, spettacoli,teatri WHERE spettatori.id_s = prenota.id_s AND spettacoli.id_sp = dettagli.id_sp AND prenota.id_d = dettagli.id_d  AND dettagli.id_t = teatri.id_t AND spettatori.id_s = ? AND dettagli.data >= ?  AND dettagli.ora >= ?");
					$stmt->execute(array($id_s, $today, $time));
					$biglietti = $stmt->fetchall();

					if($biglietti){
						foreach ($biglietti as $key => $value) {
							echo $biglietti[$key]['nomes'] . " il giorno " . date("d-m-Y", strtotime($biglietti[$key]['data'])) . " alle ore " . substr($biglietti[$key]['ora'], 0, -3) . " al teatro " . $biglietti[$key]['nomet'] . "<br>";
							if($biglietti[$key]['balconata']){
								echo " Posto in balconata n: " . $biglietti[$key]['n_posto'] . "<br><br>";
							}else{
								echo " Posto n: " . $biglietti[$key]['n_posto'] . "<br><br>";
							}  
						}
					}else{
						echo "Non hai acquistato nessun biglietto!<br><a href=\"compra.php\" style=\"color: #fff; font-size: 15px;\">Acquista dei biglietti</a>";
					}
				?>
			</div>
		</div>
				
		<section class="dark" style="text-align: center; border-top: solid 1px #ffffff; padding-top: 5px; height: 10px;"> <!--footer-->
			Copyrigth @ I100spettacoli. All right reserved.
		</section>

	</body>
</html>