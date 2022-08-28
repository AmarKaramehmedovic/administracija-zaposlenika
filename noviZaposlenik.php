<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
	<?php
		require_once "connection.php";
		session_start();
		if(!isset($_SESSION["loggedIn"])){
			header("Location: login.php");
			exit;
		}
	?>
    <form method="POST">
        <label>Naziv poduzeća kontakta:<br/>
        <select name="nazivPoduzeca">
		<?php		
		$query = "SELECT nazivPoduzeca FROM poduzeca ORDER BY nazivPoduzeca";
		$result = mysqli_query($conn, $query) or die ("Error");		
		while ($row = mysqli_fetch_array($result))
		{
			echo "<option value='".$row['nazivPoduzeca']."'>".$row['nazivPoduzeca']."</option>";
		}
		?>        
		</select>
        </label><br/><br/>

        <label>Ime:<br/>
        <input name="imeZaposlenika" type="text">
        </label><br/>
		
		<label>Prezime:<br/>
        <input name="prezimeZaposlenika" type="text">
        </label><br/>
		
		<label>Email:<br/>
        <input name="email" type="email">
        </label><br/>
		
		<label>Kontakt broj:<br/>
		<input type="tel" name="kontaktBr" pattern="[0-9\s\/\-\+]*">
        </label><br/><br/>
		
        <input name="submit" id="submit" type="submit" value="Unesi">
    </form>

    <?php
	echo '<p><a href="../administracija-zaposlenika">Povratak na početnu</a></p>';

    if (isset($_POST["submit"])) {
		$naziv = $_POST["nazivPoduzeca"];
        $ime = $_POST["imeZaposlenika"];
        $prezime = $_POST["prezimeZaposlenika"];
        $email = $_POST["email"];
        $kontakt = $_POST["kontaktBr"];
			
        $query = "SELECT ime, prezime FROM zaposlenici WHERE ime = '$ime' AND prezime = '$prezime';";
        $result = mysqli_query($conn, $query) or die ("Error");

        if(mysqli_num_rows($result) >= 1)
            echo "Zaposlenik sa unesenim imenom i prezimenom već postoji!";
        else {
            $sql = "INSERT INTO zaposlenici (nazivPoduzeca, ime, prezime, email, kontaktBr) values (?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);

            if (mysqli_stmt_prepare($stmt, $sql)) {
                mysqli_stmt_bind_param($stmt, 'sssss', $naziv, $ime, $prezime, $email, $kontakt);
                mysqli_stmt_execute($stmt);
                echo "Uspješan unos!";
            }
        }
    }

    mysqli_close($conn);

    ?>

</body>
</html>