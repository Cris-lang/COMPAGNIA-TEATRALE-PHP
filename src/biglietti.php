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

					$sunday = date('y-m-d', strtotime('sunday this week'));	//ottiene la data di sabato nella settimana corrente
					$today = date('y-m-d');	//ottiene la data di oggi 
					date_default_timezone_set("Europe/Rome");
					$time =  date("h:i:sa");
					$time = date("G:i", strtotime($time));	//ottiene la data attuale e la converte in formato 24h
					$posti_max = 100;
				
					if(isset($_GET['submit'])){
						$var_sel = $_GET['teatro'];
						$con = new PDO("mysql:host=$hostname;dbname=$dbname", "root", "");

						if(strcmp($var_sel, "Eclissi") == 0){
							$nome_teatro = "Eclissi";

							$stmt = $con->prepare("SELECT spettacoli.*, dettagli.* FROM spettacoli, dettagli, teatri WHERE spettacoli.id_sp = dettagli.id_sp AND dettagli.id_t = teatri.id_t AND teatri.nome = ? AND dettagli.data >= ? AND dettagli.data <= ? AND dettagli.ora >= ? and dettagli.id_d NOT IN(SELECT dettagli.id_d FROM spettacoli, dettagli, prenota WHERE spettacoli.id_sp = dettagli.id_sp AND prenota.id_d = dettagli.id_d GROUP BY spettacoli.nome HAVING COUNT(prenota.id_d) >= ?)");
							$stmt->execute(array($nome_teatro, $today, $sunday, $time, $posti_max));
							$dettagli = $stmt->fetchall();

							if($dettagli){
								echo "<div class=\"select\"><form action=\"biglietti.php\" method=\"get\">". " Seleziona lo spettacolo che vuoi comprare<br>";

							echo "<select name=\"scelta\" class=\"scelta\">";
							foreach ($dettagli as $key => $value) {		//scorre tutti i risultati
								$temp = $dettagli[$key]['id_d'];	//salvo valore di ogni singolo dettaglio per distinguere le varie opzioni mostrate all'utente
								echo "<option value=\"$temp\">" . $dettagli[$key]['nome'] . " " . date("d-m-Y", strtotime($dettagli[$key]['data'])) . " " . substr($dettagli[$key]['ora'], 0, -3) . " " . $dettagli[$key]['costo'] . "€" . "</option>";
							}
							echo "</select><br><br>Scegli se acquistare un posto in balconata<br><select name=\"balconata\" class=\"scelta\"> <option value=\"yes\">Si (prezzo aumentato del 0.25%)</option>
						<option value=\"no\">No</option>
					</select><br><br><input type=\"submit\" name=\"submit2\" value= \"Compra\"></form></div>"; 
							}else{
								echo "Nessuno spettacolo disponibile";
							}
						}else if(strcmp($var_sel, "Sisifone") == 0){
							$nome_teatro = "Sisifone";

							$stmt = $con->prepare("SELECT spettacoli.*, dettagli.* FROM spettacoli, dettagli, teatri WHERE spettacoli.id_sp = dettagli.id_sp AND dettagli.id_t = teatri.id_t AND teatri.nome = ? AND dettagli.data >= ? AND dettagli.data <= ? AND dettagli.ora >= ? and dettagli.id_d NOT IN(SELECT dettagli.id_d FROM spettacoli, dettagli, prenota WHERE spettacoli.id_sp = dettagli.id_sp AND prenota.id_d = dettagli.id_d GROUP BY spettacoli.nome HAVING COUNT(prenota.id_d) >= ?)");
							$stmt->execute(array($nome_teatro, $today, $sunday, $time, $posti_max));
							$dettagli = $stmt->fetchall();

							if($dettagli){
								echo "<div class=\"select\"><form action=\"biglietti.php\" method=\"get\">". " Seleziona lo spettacolo che vuoi comprare<br>";

							echo "<select name=\"scelta\" class=\"scelta\">";
							foreach ($dettagli as $key => $value) {
								$temp = $dettagli[$key]['id_d'];
								echo "<option value=\"$temp\">" . $dettagli[$key]['nome'] . " " . date("d-m-Y", strtotime($dettagli[$key]['data'])) . " " . substr($dettagli[$key]['ora'], 0, -3) . " " . $dettagli[$key]['costo'] . "€" . "</option>";
							}
							echo "</select><br><br>Scegli se acquistare un posto in balconata<br><select name=\"balconata\" class=\"scelta\"> <option value=\"yes\">Si (prezzo aumentato del 0.25%)</option>
						<option value=\"no\">No</option>
					</select><br><br><input type=\"submit\" name=\"submit2\" value= \"Compra\"></form></div>"; 
							}else{
								echo "Nessuno spettacolo disponibile";
							}
						}else{
							echo"<scritp>alert('Inserire un opzione!');</script>";
						}
					
					}else if(isset($_GET['submit2'])){

						$con = new PDO("mysql:host=$hostname;dbname=$dbname", "root", "");

						$user = $_SESSION['user'];
						$id_s = (int)$user['id_s'];
						$scelta = $_GET['scelta'];
						$balconata = $_GET['balconata'];
						$moltiplicatore = (double)0.25;

						$balconata = filter_var($balconata, FILTER_VALIDATE_BOOLEAN); //trasforma la variabile in valore booleano 

						$stmt = $con->prepare("SELECT * FROM prenota WHERE n_posto = (SELECT MAX(n_posto) FROM prenota WHERE balconata = ? AND  prenota.id_d = ?)"); 	//resitituisce l' ultimo posto assegnato
						$stmt->execute(array($balconata, $scelta));
						$already_taken = $stmt->fetch();

						if($already_taken){		//calcola il posto successivo
							$next_seat = ++$already_taken['n_posto'];
						}else{
							$next_seat = "A0";	//nel caso sia il primo ad acquistare un biglietto
						}
						
						// POSTI NORMALI DA A0-G9, POSTI IN BALCONATA DA A0-C9 
						if($balconata AND strcmp($next_seat, "D0") == 0){
							echo "<script>alert('Biglietti in balconata finiti!');window.location.href='compra.php';</script>";
						}else if($balconata == false AND strcmp($next_seat, "H0") == 0){
							echo "<script>alert('Biglietti per posti normali finiti!');window.location.href='compra.php';</script>";
						}else{
							$con->prepare("INSERT INTO prenota (id_d, id_s, n_posto, balconata, moltiplicatore) VALUES (?,?,?,?,?)")->execute(array($scelta, $id_s, $next_seat, $balconata, $moltiplicatore));						

							echo "<script>alert('Hai acquistato il tuo biglietto!');window.location.href='account.php';</script>";
						}
					}
				?>
			</div>
		</div>

		<section class="dark" style="text-align: center; border-top: solid 1px #ffffff; padding-top: 5px; height: 10px;"> <!--footer-->
			Copyrigth @ I100spettacoli. All right reserved.
		</section>
	</body>
</html>