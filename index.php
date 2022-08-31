<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />
	<title>Administracija zaposlenika</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
	<link rel="stylesheet" media="screen" href="style.css">
	<link rel="shortcut icon" href="slike/favicon.ico" />
	<style>
		#table1 th {
			background-color: #337DFF;
			color: white;
		}

		.footer {
			text-align: center;
		}
	</style>
</head>

<body>
	<?php
		session_start();
		if (!isset($_SESSION["loggedIn"]) || ($_SESSION["loggedIn"] != true)) {
			header("Location: login.php");
			exit;
		}
		$username = $_SESSION["username"];
		$dozvola = $_SESSION["dozvola"];
		
		include "header.php";
		require_once "connection.php";
	?>

	<div class="container-fluid wrapper-pocetna">
		<div class="row wrapper-izbornik">
			<div class="col-6" style="padding-left: 2px;">
				<form class="d-flex" role="search" style="width: 400px;" action="index.php" method="GET" align="center">
					<input class="form-control" id="poduzece" name="poduzece" type="text" placeholder="Traži poduzeće..." autofocus>
					<button class="btn btn-success" style="margin-left:15px;" type="submit">Pretraži</button>
				</form>
			</div>
			<div class="col-6" style="padding-right: 2px;">
				<?php
					echo '<ul class="action-menu">';
					echo '<li><a class="btn btn-primary" href="novoPoduzece.php">Unos poduzeća</a></li>';
					echo '<li><a class="btn btn-primary" href="noviZaposlenik.php" style="margin-left:5px;">Unos zaposlenika</a></li>';
					echo '</ul>';
				?>
			</div>
		</div>

		<table id="table1" align="center">
			<?php
			if (!empty($_GET['poduzece'])) {
				$input = $_GET['poduzece'];
				//table zaposlenici
				echo "
							<tr>
								<th height='30' colspan='6'>Zaposlenici</th>
							</tr>
							<tr>
								<th>Poduzece</th>
								<th>Ime</th>
								<th>Prezime</th>
								<th>Email</th>
								<th>Kontakt broj</th>
								<th></th>
							</tr>";

				$sql = "SELECT *, zaposlenici.id AS zId, zaposlenici.kontaktBr AS kontaktBrZ
						FROM zaposlenici
						LEFT JOIN poduzeca ON zaposlenici.poduzeceId = poduzeca.id
						WHERE poduzeca.nazivPoduzeca LIKE '%$input%' ";

				$result = mysqli_query($conn, $sql) or die("Query Error");
				while ($row = mysqli_fetch_array($result)) {
					echo "<tr>";
					echo "<td style='text-align:left' width='300'>
								<a style='text-decoration:none;' href='?poduzece=" . $row["nazivPoduzeca"] . "'>" . $row["nazivPoduzeca"] . "</a>
							</td>";
					echo "<td>" . $row["ime"] . "</td>";
					echo "<td>" . $row["prezime"] . "</td>";
					echo "<td>
							<a style='text-decoration:none;' href='mailto:" . $row["email"] . "'>" . $row["email"] . "</a>
						</td>";
					echo "<td>" . $row["kontaktBrZ"] . "</td>";
					echo "<td>
							<a class='btn btn-outline-primary' href='urediZaposlenika.php?id=". $row["zId"]. "'>Uredi</a>
						</td>";
					echo "</tr>";
				}
			} else {
				//table poduzeca
				echo "
							<tr>
								<th height='30' colspan='5'>Poduzeća</th>
							</tr>
							<tr>
								<th>Poduzeće</th>
								<th>Adresa</th>
								<th>Mjesto</th>
								<th>Kontakt broj</th>
								<th></th>
							</tr>";

				$sql = "SELECT id, nazivPoduzeca, adresa, mjesto, kontaktBr
						FROM poduzeca
						ORDER BY nazivPoduzeca";

				$result = mysqli_query($conn, $sql) or die("Query Error");
				while ($row = mysqli_fetch_array($result)) {
					echo "<tr>";
					echo "<td style='text-align:left;' width='300'>
								<a style='text-decoration:none;' href='?poduzece=" . $row["nazivPoduzeca"] . "'>" . $row["nazivPoduzeca"] . "</a>
						</td>";
					echo "<td>" . $row["adresa"] . "</td>";
					echo "<td>" . $row["mjesto"] . "</td>";
					echo "<td>" . $row["kontaktBr"] . "</td>";
					echo "<td>
							<a class='btn btn-outline-primary' href='urediPoduzece.php?id=". $row["id"]. "'>Uredi</a>
						</td>";
					echo "</tr>";
				}
			}
			echo "</table>";
			mysqli_close($conn);
			?>
	</div>

	<?php readfile("footer.html"); ?>
	
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>
</html>