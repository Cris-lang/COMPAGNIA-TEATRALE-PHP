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
		<div class="teatribg" style="background-image: url('img/diagonalHover/img2.jpg');">
			<div class="ptext" style="background-color: rgba(17, 17, 17, 0.8);
	color: #fff;top: 30%; padding-top: 10px;">
					<?php
						$hostname = "127.0.0.1";
						$dbname = "i100spettacoli";
						$con = 0;
						$nome_teatro = "Sisifone";

						$con = new PDO("mysql:host=$hostname;dbname=$dbname", "root", "");	//collegamento con il db

						$stmt = $con->prepare("SELECT * FROM teatri WHERE nome = ?");	//ottiene tutti i valori del teatro x
						$stmt->execute(array($nome_teatro));
						$teatro = $stmt->fetch();

						$sunday = date('y-m-d', strtotime('sunday this week'));	//ottiene la data di sabato di questa settimana
						$today = date('y-m-d');	//ottiene la data di oggi

						if($teatro){
							//substr($teatro['orario'], 0, -3) rimossi i secondi dall' orario 
							echo "Il teatro " . $teatro['nome'] . " si trova a " . $teatro['citta'] . " in via " . $teatro['via'] . " " .  $teatro['n_civico'] . ".<br>Apertura dalle: " . substr($teatro['orario_apertura'], 0, -3) . " alle " . substr($teatro['orario_chiusura'], 0, -3) . ".<br>Spettacoli in programma per questa settimana: <br><br>";
							
							/*Ottiene e stampa tutti i dettagli */
							$stmt = $con->prepare("SELECT dettagli.*, spettacoli.nome FROM dettagli, spettacoli, teatri WHERE spettacoli.id_sp = dettagli.id_sp AND dettagli.id_t = teatri.id_t AND teatri.nome = ? AND dettagli.data >= ? AND dettagli.data <= ?");
							$stmt->execute(array($nome_teatro, $today, $sunday));
							$spettacolo = $stmt->fetchall();

							if($spettacolo){
								foreach ($spettacolo as $key => $value) {
									echo date("d-m-Y", strtotime($spettacolo[$key]['data'])) . "  " . $spettacolo[$key]['nome'] . " alle ore " . substr($spettacolo[$key]['ora'], 0, -3) . "  a partire da: " . $spettacolo[$key]['costo'] . "€. <br></br>";
								}
							}else{
								echo "Nessuno spettacolo in programma per questa settimana.<br><br>";
							}
						}

					?>

					<a href="infoSpettacoli.php" style="color: #fff; font-size: 15px;">Scopri di più sugli spettacoli</a><br>
					<a href="compra.php" style="color: #fff; font-size: 15px;">Acquista dei biglietti</a>
			</div>
		</div>
		<section class="dark" style="text-align: center; border-top: solid 1px #ffffff; padding-top: 5px; height: 10px;"> <!--footer-->
			Copyrigth @ I100spettacoli. All right reserved.
		</section>
	</body>
</html>