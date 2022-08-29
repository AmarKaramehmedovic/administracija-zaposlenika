<html>
    <head>
    <title>Administracija zaposlenika</title>
	<link rel="stylesheet" media="screen" href="style.css">
	<link rel="shortcut icon" href="slike/favicon.ico"/>
	<meta charset="utf-8"/>	
	<style>
		#table1 th {
		  background-color: #337DFF;
		  color: white;
		}
		
		.footer{
			text-align: center;	
		}
	</style>
    </head>
        
	<body>
		<?php
			require_once "connection.php";
			
			session_start();
			if($_SESSION["loggedIn"] != true){
				header("Location: login.php");
				exit;
			}
			
			$username = $_SESSION["username"];
			$dozvola = $_SESSION["dozvola"];
		?>
		
		<div class="header">
			<h5 style="margin-top:10px; top:0; position: absolute; width:100%;"><a href="/administracija-zaposlenika">Administracija zaposlenika:</a></h5>
			<?php
				echo '<div class="info" style="font-size:15px; text-align:left; margin-top:10px;">';
				echo '<p>Pozdrav, ' . $username . '! <br> Vaša tip dozvole je ' . $dozvola . '.</p>';
				echo "<hr></hr>";
				if($dozvola == 'administrator'){
					echo '<p><a href="registracija.php">Novi korisnik aplikacije</a></p>';
				}
				echo '<p><a href="novoPoduzece.php">Novo poduzeće</a></p>';
				echo '<p><a href="noviZaposlenik.php">Novi zaposlenik poduzeća</a></p>';
				echo '<p><a href="logout.php">Odjava</a></p>';
				echo '</div>';
			?>
			<form style="margin-top:-5%;" action="index.php" method="GET" align="center">
				<input id="poduzece" type="text" name="poduzece" placeholder="Traži poduzeće" size="25" autofocus>
			</form>
		</div>
		
		
		
        <table id="table1" align="center">   
            <?php
				if (!empty($_GET['poduzece'])) {
					$input = $_GET['poduzece'];
					
					//table zaposlenici
					echo "
						<tr>
							<th height='30' colspan='5'>Zaposlenici</th>
						</tr>
						<tr>
							<th>Poduzece</th>
							<th>Ime</th>
							<th>Prezime</th>
							<th>Email</th>
							<th>Kontakt broj</th>
						</tr>";

					$sql= "SELECT *, zaposlenici.kontaktBr AS kontaktBrZ
					FROM zaposlenici
					LEFT JOIN poduzeca ON zaposlenici.poduzeceId = poduzeca.id
					WHERE poduzeca.nazivPoduzeca LIKE '%$input%' ";
					
					$result = mysqli_query($conn, $sql) or die("Error"); 
					while($row = mysqli_fetch_array($result)){
						echo "<tr>";
						echo "<td align='left' width='300'>
								<a name='click' href='?poduzece=".$row["nazivPoduzeca"]."'>".$row["nazivPoduzeca"]."</a>
							</td>";
						echo "<td align='center'>" . $row["ime"] . "</td>";
						echo "<td align='center'>" . $row["prezime"] . "</td>";
						echo "<td align='center'>" . $row["email"] . "</td>";
						echo "<td align='center'>" . $row["kontaktBrZ"] . "</td>";			
						echo "</tr>";               
					}
				}else{
					//table poduzeca
					echo "
						<tr>
							<th height='30' colspan='2'>Poduzeća</th>
						</tr>
						<tr>
							<th>Poduzece</th>
							<th>Kontakt broj</th>
						</tr>";
					
					$sql= "SELECT nazivPoduzeca, kontaktBr
					FROM poduzeca
					ORDER BY nazivPoduzeca";				
					
					$result = mysqli_query($conn, $sql) or die("Error");                   
					while($row = mysqli_fetch_array($result)){
						echo "<tr>";
						echo "<td align='left' width='300'>
								<a name='click' href='?poduzece=".$row["nazivPoduzeca"]."'>".$row["nazivPoduzeca"]."</a>
							</td>";
						echo "<td align='center'>" . $row["kontaktBr"] . "</td>";			
						echo "</tr>";               
					}
				}
			echo "</table>";
			mysqli_close($conn);
            ?>
	
	<div class="footer" style="text-align: center;margin-top: 180px; bottom:0; position: absolute; width:100%;">
		<hr></hr>
	  <p>Copyright© Amar Karamehmedović</p>
	</div>
    </body>
</html>
