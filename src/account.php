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
			<a href="index.html" style="text-decoration: none;">
				<div id="pulsate">
					I100spettacoli
				</div>
			</a>
		</div>

		<div class="pimg3" style="background-size: cover; background-repeat: no-repeat; height: 100%;">	
			<div class="container">
				<div class= "split left">
					<div class="ptext">
						<a href="ituoibiglietti.php">
							<span class="border">
								I tuoi spettacoli
							</span>
						</a>
					</div>
				</div>
				<div class="split center">
					<div class="ptext">
						<a href="compra.php">
							<span class="border">
								Compra biglietti
							</span>
						</a>
					</div>
				</div>
				<div class="split right">
					<div class="ptext">
						<a href="modifica.php">
							<span class="border">
								Impostazioni
							</span>
						</a>
					</div>
				</div>
		</div>
				
		<section class="dark" style="text-align: center; border-top: solid 1px #ffffff; padding-top: 5px; height: 10px;"> <!--footer-->
			Copyrigth @ I100spettacoli. All right reserved.
		</section>

	</body>
</html>