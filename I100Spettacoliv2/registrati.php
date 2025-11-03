<?php
	session_start();
	if(isset($_SESSION['user'])){		//controlla se si ha gia effettuato l'accesso
		header("Location: account.php");
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
			<a href="index.html" style="text-decoration: none;">
				<div id="pulsate">
					I100spettacoli
				</div>
			</a>
		</div>

		<div class="pimg2" style="background-size: cover; background-repeat: no-repeat; height: 100%;">	
			<br>		
			<div id="logInForm">
				REGISTRATI<br><br>
				<form action="registrati.php" method="post">
					<input type="text" name="nome" placeholder="Nome" autocomplete="off" required pattern="^[a-zA-Z]*$" oninvalid="this.setCustomValidity('Inserire solo lettere')" oninput="this.setCustomValidity('')">
					<br></br>
					<input type="text" name="cognome" placeholder="Cognome" autocomplete="off" required pattern="^[a-zA-Z]*$" oninvalid="this.setCustomValidity('Inserire solo lettere')" oninput="this.setCustomValidity('')">
					<br></br>
					<input type="text" name="email" placeholder="Email" autocomplete="off" required pattern="^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$" oninvalid="this.setCustomValidity('Email non valida')" oninput="this.setCustomValidity('')">
					<br></br>
					<input type="password" name="pass" id = "pass" placeholder="Password" autocomplete="off" required pattern=".{3,15}" oninvalid="this.setCustomValidity('Lunghezza minima 3 caratteri, lunghezza massima 15 caratteri')" oninput="this.setCustomValidity('')">
					<br>
					<img src="img/mini/eye.png" onclick = "showpassword()" style ="width: 20px; height: 20px; cursor: pointer; margin-right: 150px;">
					<br>
					<input type="date" name="data_nas" placeholder="Data nascita">
					<br></br>
					<input type="text" name="cod_f" placeholder="Codice fiscale" autocomplete = "off" required pattern=".{16,16}" oninvalid="this.setCustomValidity('Il codice fiscale deve essere lungo 16 caratteri')" oninput="this.setCustomValidity('')">
					<br></br>
					<input type="submit" name="submit" value="Registrati"><br>
				</form>
			</div>
		</div>
		
		<section class="dark" style="text-align: center; border-top: solid 1px #ffffff; padding-top: 5px; height: 10px;"> <!--footer-->
			Copyrigth @ I100spettacoli. All right reserved.
		</section>

		<?php
			
			$hostname = "127.0.0.1";
			$dbname = "i100spettacoli";
			$con = 0;

			if(isset($_POST['submit'])){
				//estrapolazione dei dati inseriti nel form
				$nome = $_POST['nome'];
				$cognome = $_POST['cognome'];
				$data_nas = $_POST['data_nas'];
				$email = $_POST['email'];
				$password = $_POST['pass'];
				$cod_f = $_POST['cod_f'];

				$flag = true;	

				try{
					$con = new PDO("mysql:host=$hostname;dbname=$dbname", "root", "");	//collegamento al db


					$nome = $nome . " " . $cognome;		// unione nome e cognome
					

					$temp = explode("-", $data_nas);
					if($temp[0] > 2002 or $temp[0] < 1900 or empty($data_nas)){		//controllo validità data di nascita
						echo"<script>alert('Devi essere maggiorenne per poterti registrare')</script>";
						$flag = false;
					}
					
					if($flag){	//se tutti i valori sono validi
						$password = password_hash($password, PASSWORD_BCRYPT);		//criptazione della password

						$stmt = $con->prepare("SELECT * FROM spettatori WHERE email = ? OR cod_f = ?");	//controlla se l'email o il codice fiscale sono gia stati inseriti da un altro utente
						$stmt->execute(array($email, $cod_f));
						$utente = $stmt->fetch();

						if(!$utente){
							$con->prepare("INSERT INTO spettatori (nome, cod_f, data_nas, email, password) VALUES(?,?,?,?,?)")->execute(array($nome, $cod_f, $data_nas, $email, $password));  //inserimento nuovo utente

							/*Ricerca dell' utente che ha effettuato la registrazione per salvarne il valore in una sessione*/
							$stmt = $con->prepare("SELECT * FROM spettatori WHERE email = ?");		//ricerca utente appena registrato

							$stmt->execute(array($email));		//esegui la query con il valore contenuto in  $email

							$user = $stmt->fetch();				//estrapolazione del risultato 

							$_SESSION['user'] = $user;
							header("Location: account.php");
						}else{
							echo "<script>alert('Sei gia registrato!');window.location.href='accedi.php';</script>";
						}
						
					}
				}catch(PDOException $e){
					echo("<script>alert('Database Connection Error!'".$e->getMessage()."')</script>");
				}
			}
		?>
		
		<script>function showpassword(){
			var input = document.getElementById('pass');
			if(input.type === "password"){
				input.type = "text";
			}else{
				input.type = "password";
			}
		}</script>

	</body>
</html>