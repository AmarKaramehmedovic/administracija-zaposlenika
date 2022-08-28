<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
	<style>
		
	</style>
</head>
<body align="center">
	<div class="header" style="font-family: Trebuchet MS, Arial, Helvetica, sans-serif;">
		<h1><a href="/administracija-zaposlenika">Administracija zaposlenika:</a></h1>
		<form method="POST">
			<label>Korisničko ime:<br>
				<input name="username" type="text" required>
			</label> <br>

			<label>Lozinka:<br>
				<input name="password" type="password" required>
			</label> <br><br>

			<input name="submit" type="submit" value="Prijava">
		</form>
	</div>

    <?php
		require_once "connection.php";
		
		session_start();
		if(isset($_SESSION["loggedIn"])){
			if($_SESSION["loggedIn"] == true){
				header("Location: ../administracija-zaposlenika");
				exit;
			}
		}

		if (isset($_POST["submit"])) {

			$username = $_POST["username"];
			$password = $_POST["password"];
				
			$query = "SELECT korisnicko_ime, lozinka FROM korisnici WHERE korisnicko_ime = ?;";
			$stmt = mysqli_stmt_init($conn);
			if (mysqli_stmt_prepare($stmt, $query)) {
				mysqli_stmt_bind_param($stmt, 's', $username);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_store_result($stmt);
				mysqli_stmt_bind_result($stmt, $korisnicko_ime, $hash);
				mysqli_stmt_fetch($stmt);
				
				if (password_verify($password, $hash)) {
					echo "Prijava je uspjela";
						
					$queryRow = "SELECT korisnicko_ime, dozvola FROM korisnici WHERE korisnicko_ime = '$username';";
					$result = mysqli_query($conn, $queryRow) or die("Error");           
					$row = mysqli_fetch_array($result);
						
					$dozvola = $row["dozvola"];
					$username = $row["korisnicko_ime"];
						
					$_SESSION["loggedIn"] = true;
					$_SESSION["username"] = $username;
					$_SESSION["dozvola"] = $dozvola;
						
					header("Location: ../administracija-zaposlenika");
					exit;
				} else {
					echo "Unijeli ste pogrešno korisničko ime ili lozinku";
				}

				mysqli_stmt_close($stmt);
			}
		}

		mysqli_close($conn);

    ?>

</body>
</html>