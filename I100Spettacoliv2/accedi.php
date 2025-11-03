<?php
	session_start();
	if(isset($_SESSION['user'])){			//controlla se si ha gia effettuato l'accesso
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
			<a href="javascript:history.back()" style="text-decoration: none;"> <!--Funzione javascript per tornare indietro di una pagina-->				
				<div id="pulsate">
					I100spettacoli
				</div>
			</a>
		</div>

		<div class="pimg2" style="background-size: cover; background-repeat: no-repeat; height: 100%;">	
			<br>		
			<div id="logInForm">
				ACCEDI<br><br>
					<form  action="accedi.php" method="post">
						<input type="text" name="email" placeholder="Inserisci email" autocomplete="off">
						<br></br>
						<input type="password" name="pass" id="pass" placeholder="Inserisci password" autocomplete="off">
						<br>
						<img src="img/mini/eye.png" onclick = "showpassword()" style ="width: 20px; height: 20px; cursor: pointer; margin-right: 150px;">
						<br><br>
						<input type="submit" name="submit" value="Accedi"><br>
					</form>
				Ancora non sei registrato? <div id="pulsate"><a href="registrati.php" style="color: rgb(29, 128, 214); text-decoration: none;"> Clicca qui</a></div>
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
				$email = $_POST['email'];
				$password = $_POST['pass'];

				try{
					$con = new PDO("mysql:host=$hostname;dbname=$dbname", "root", "");	//stabilisce la connessione
					
					$stmt = $con->prepare("SELECT * FROM spettatori WHERE email= ?");	//prepara la query

					$stmt->execute(array($email));	//esegue la query con il valore email inserito

					$user = $stmt->fetch(); //estrapola i risultati

					if($user){
						if(password_verify($password, $user['password'])){  //confrata il valore nel db con l'email
							echo "<script>alert('login');</script>";

							$_SESSION['user'] = $user;	//salva l'utente loggato in una sessione
							header("Location: account.php");
						}
					}else{
						echo "<script>alert('Impossibile accedere verificare che email e password siano corrette.');</script>";
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