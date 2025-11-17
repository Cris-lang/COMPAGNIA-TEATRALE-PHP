<?php
	session_start();
  	if(!isset($_SESSION['user'])){   //controlla se non si ha gia effettuato l'accesso
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

  <!--css per questa pagina-->
	<style type="text/css">    

 	* {
        box-sizing: border-box;
      }
      .openBtn {
       float: center;
      }
      .openButton {
        border: none;
        border-radius: 5px;
        background-color: rgb(199, 18, 18);
        color: white;
        padding: 14px 20px;
        cursor: pointer;
      }
      .Popup {
        position: relative;
        text-align: center;
        width: 100%;
      }
      .formPopup {
        display: none;
        position: fixed;
        left: 50%;
        top: 15%;
        transform: translate(-50%, 5%);
        z-index: 9;
      }
      .formContainer {
        max-width: 300px;
        padding: 20px;
        background-color: #F9F9F3;  
        border-radius: 20px;
        border: 3px solid black;
      }
      .formContainer input[type=text],
      .formContainer input[type=password] {
        width: 100%;
        padding: 15px;
        margin: 5px 0 20px 0;
        border: none;
        border-radius: 10px;
        text-align: center;
        font-size: 15px;
        background: #eee;
      }
      .formContainer input[type=text]:focus,
      .formContainer input[type=password]:focus {
        background-color: #ddd;
        outline: none;
      }
      .formContainer .btn {
        padding: 12px 20px;
        border: none;
        background-color: rgb(0, 161, 112);
        border-radius: 10px;
        color: #fff;
        cursor: pointer;
        width: 100%;
        margin-bottom: 15px;
        opacity: 0.8;
      }
      .formContainer .cancel {
        background-color: rgb(188, 36, 60);
      }
      .formContainer .btn:hover,
      .openButton:hover {
        opacity: 1;
      }
      h2{
      	color: black;
      }
	</style>

	<body>
		<!-- header -->

		<div id="header">
			<a href="javascript:history.back()" style="text-decoration: none;"> <!--Funzione javascript per tornare indietro di una pagina-->
				<div id="pulsate">
					I100spettacoli
				</div>
			</a>

		</div>

		<div class="pimg3" style="background: url('img/container/img3v10.jpg'); background-size: cover; background-repeat: no-repeat; height: 100%;">	
			<div class = "ptext" style="background-color: rgba(17, 17, 17, 0.8); color: #fff;top: 30%; padding-top: 20px;">
				<!--Popup cambio email-->
        <div class="openBtn">
      				<button class="openButton" onclick="openFormE()"><strong>Modifica email</strong></button>
   				</div><br>

			    <div class="Popup">
			      <div class="formPopup" id="popupFormEmail">
			        <form action="modifica.php" class="formContainer" method="post">
			          <h2>Inserisci la tua nuova email</h2>
			          
			          <input type="text" id="email" placeholder="Nuova Email" name="newemail" required>
			          <button type="submit" class="btn" name="email">Salva</button>

			          <button type="button" class="btn cancel" onclick="closeFormE()">Annulla</button>
			        </form>
			      </div>
			    </div>

          <!--Popup cambio password-->
			    <div class="openBtn">
      				<button class="openButton" onclick="openFormP()"><strong>Modifica password</strong></button>
   				</div><br>

   				<div class="Popup">
			      <div class="formPopup" id="popupFormPass">
			        <form action="modifica.php" class="formContainer" method="post">
			          <h2>Inserisci la tua nuova password</h2>
			          
			          <input type="text" id="pass" placeholder="Nuova password" autocomplete = "off" name="newpass" required>
			          <button type="submit" class="btn" name="pass">Salva</button>

			          <button type="button" class="btn cancel" onclick="closeFormP()">Annulla</button>
			        </form>
			      </div>
			    </div>

          <!--Popup logout-->
			    <div class="openBtn">
      				<button class="openButton" onclick="openFormExit()"><strong>Esci dal tuo account</strong></button>
   				</div><br>

   				<div class="Popup">
			      <div class="formPopup" id="popupFormExit">
			        <form action="modifica.php" class="formContainer" method="post">
			          <h2>Sei sicuro di voler uscire dal tuo account?</h2>
			         
			          <button type="submit" class="btn" name="logoff">Si</button>

			          <button type="button" class="btn cancel" onclick="closeFormExit()">No</button>
			        </form>
			      </div>
			    </div>

			    <?php
					$hostname = "127.0.0.1";
					$dbname = "i100spettacoli";
					$con = 0;
					$user = $_SESSION['user'];
					$id_s = $user['id_s'];

					$con = new PDO("mysql:host=$hostname;dbname=$dbname", "root", "");

					if(isset($_POST['email'])){
						$nuova_email = $_POST['newemail'];

            $stmt = $con->prepare("SELECT * FROM spettatori WHERE email= ?"); //controlla se l'email è stata gia usata 
            $stmt->execute(array($nuova_email));
            $already_exist = $stmt->fetch();

						if (!filter_var($nuova_email, FILTER_VALIDATE_EMAIL) or empty($nuova_email)) {	//contollo validità email
  							echo"<script>alert('Email inserita non valida')</script>";
						}else if($already_exist){
                echo"<script>alert('Email inserita gia in uso da un altro account')</script>";
            }else{
              //aggiorna l'email
							$con->prepare("UPDATE spettatori SET email = ?  WHERE id_s = ?")->execute(array($nuova_email, $id_s));
							echo"<script>alert('Email modificata');window.location.href='account.php';</script>";
						}
					}else if(isset($_POST['pass'])){
						$nuova_password = $_POST['newpass'];
						if(strlen($nuova_password) < 3 or strlen($nuova_password) > 15 or empty($nuova_password)){  //controllo validità password
							echo"<script>alert('Inserire una password di almeno 3 caratteri e minore di 15 caratteri')</script>";
						}else{
							$nuova_password = password_hash($nuova_password, PASSWORD_BCRYPT); //crypta la password
              //aggiorna la password
							$con->prepare("UPDATE spettatori SET password = ?  WHERE id_s = ?")->execute(array($nuova_password, $id_s));
							echo"<script>alert('Password modificata');window.location.href='account.php';</script>";
						}
					}else if(isset($_POST['logoff'])){
            //distrugge la sessione eliminando la variabile dell'utente loggato dalla sessione
						session_destroy();
						echo"<script>alert('sei uscito dal tuo account');window.location.href='index.html';</script>";
					}
				?>
			</div>
		</div>


    <!--Funzioni Javascript per l'apertura dei from popup-->
		<script>
      function openFormE() {
        document.getElementById("popupFormEmail").style.display = "block";
      }
      function openFormP() {
        document.getElementById("popupFormPass").style.display = "block";
      }
       function openFormExit() {
        document.getElementById("popupFormExit").style.display = "block";
      }
      function closeFormExit() {
        document.getElementById("popupFormExit").style.display = "none";
      }
      function closeFormE() {
        document.getElementById("popupFormEmail").style.display = "none";
      }
       function closeFormP() {
        document.getElementById("popupFormPass").style.display = "none";
      }

    </script>
				
		<section class="dark" style="text-align: center; border-top: solid 1px #ffffff; padding-top: 5px; height: 10px;"> <!--footer-->
			Copyrigth @ I100spettacoli. All right reserved.
		</section>

	</body>
</html>