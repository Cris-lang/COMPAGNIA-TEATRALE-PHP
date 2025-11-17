<html>
	<head>
		<title>I100Spettacoli</title>
		<link rel="stylesheet" href="style.css?ts=<?=time()?>&quot">
		<meta charset="utf-8" />
	</head>

	<body>
		<?php
			$hostname = "127.0.0.1";
			$dbname = "i100spettacoli";
			$con = 0;

			$sunday = date('y-m-d', strtotime('sunday this week'));	//ottiene la data di sabato di questa settimanae
			$today = date('y-m-d');		//ottiene la data di oggi 

		?>
		<div id="header">
			<a href="javascript:history.back()" style="text-decoration: none;"> <!--Funzione javascript per tornare indietro di una pagina-->
				<div id="pulsate">
					I100spettacoli
				</div>
			</a>
		</div>

		<div class="pimg1" style="background-size: cover; background-repeat: no-repeat; height: 200%;">	
			<div class="ptext" style="background-color: rgba(17, 17, 17, 0.8); color: #fff; : 30%; padding-top: 10px; top: 10%;">
				<center>Teatro Eclissi</center><br>
				<?php
					$nome_teatro = "Eclissi";
					$con = new PDO("mysql:host=$hostname;dbname=$dbname", "root", ""); //collegamento al db

					//stampa gli spettacoli del teatro Eclissi
					$stmt = $con->prepare("SELECT DISTINCT spettacoli.* FROM dettagli, spettacoli, teatri WHERE spettacoli.id_sp = dettagli.id_sp AND dettagli.id_t = teatri.id_t AND teatri.nome = ? AND dettagli.data >= ? AND dettagli.data <= ?");
					$stmt->execute(array($nome_teatro, $today, $sunday));
					$rs = $stmt->fetchall();
					
					if($rs){
						foreach ($rs as $key => $value) {
							echo $rs[$key]['nome'] . "<br>	scritto da:	" . $rs[$key]['autore'] . "<br>		Trama: " . $rs[$key]['trama'] . "<br>";
							$stmt = $con->prepare("SELECT attori.nome, recita.ruolo FROM attori, recita, spettacoli WHERE attori.id_a = recita.id_a AND recita.id_sp = spettacoli.id_sp AND spettacoli.id_sp = ? ");
							$stmt->execute(array($rs[$key]['id_sp']));
							$attori = $stmt->fetchall();

							echo "<br>Attori: ";

							foreach ($attori as $key => $value) {
								echo $attori[$key]['nome'] . " nel ruolo di " . $attori[$key]['ruolo'] . ", ";
							}
							echo "<br><br><br>";
						}
					}else{
						echo "Nessun spettacolo in programma questa settimana.<br>";
					}
					
				?>

				<br><br>

				<center>Teatro Sisifone</center><br>
				<?php
					$nome_teatro = "Sisifone";

					//mostra gli spettacoli del cinema Sisifone
					$stmt = $con->prepare("SELECT DISTINCT spettacoli.* FROM dettagli, spettacoli, teatri WHERE spettacoli.id_sp = dettagli.id_sp AND dettagli.id_t = teatri.id_t AND teatri.nome = ? AND dettagli.data >= ? AND dettagli.data <= ?");
					$stmt->execute(array($nome_teatro, $today, $sunday));
					$rs = $stmt->fetchall();
					

					if($rs){
						foreach ($rs as $key => $value) {
							echo $rs[$key]['nome'] . "<br>	scritto da:	" . $rs[$key]['autore'] . "<br>		Trama: " . $rs[$key]['trama'] . "<br>";
							$stmt = $con->prepare("SELECT attori.nome, recita.ruolo FROM attori, recita, spettacoli WHERE attori.id_a = recita.id_a AND recita.id_sp = spettacoli.id_sp AND spettacoli.id_sp = ? ");
							$stmt->execute(array($rs[$key]['id_sp']));
							$attori = $stmt->fetchall();

							echo "<br>Attori: ";

							foreach ($attori as $key => $value) {
								echo $attori[$key]['nome'] . " nel ruolo di " . $attori[$key]['ruolo'] . ", ";
							}
							echo "<br><br><br>";
						}
					}else{
						echo "Nessun spettacolo in programma questa settimana.<br>";
					}
				?>
			</div>
		</div>
		
		<section class="dark" style="text-align: center; border-top: solid 1px #ffffff; padding-top: 5px; height: 10px;"> <!--footer-->
			Copyrigth @ I100spettacoli. All right reserved.
		</section>
	</body>
</html>