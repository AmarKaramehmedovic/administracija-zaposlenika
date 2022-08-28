<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body>
    <form method="POST">
        <label>Korisničko ime:<br/>
        <input name="username" id="username" type="text" required>
        </label>
		<span id="porukaUsername" class="error"></span><br>

        <label>Lozinka:<br/>
        <input name="password" id="password" type="password" required>
        </label>
		<span id="porukaLozinka" class="error"></span><br>
		
		<label>Ponovljena lozinka:<br/>
        <input name="repeatPassword" id="repeatPassword" type="password" required>
        </label><br/>
		<span id="porukaPonovljenaLozinka" class="error"></span>
		
		<label>Dozvola:<br/>
		<select name="dozvola">
		  <option value="administrator">Administrator</option>
		  <option value="editor">Editor</option>
		</select>
		</label><br/><br/>
		
        <input name="submit" id="submit" type="submit" value="Registriraj">
    </form>
	
	<script type="text/javascript">
        document.getElementById("submit").onclick = function(event) {
        var slanje_forme = true;

        var poljeUsername = document.getElementById("username");
        var username = document.getElementById("username").value;

        if(username.length < 4 || username.length > 15 || username == "") {
            slanje_forme = false;
            document.getElementById("porukaUsername").innerHTML = "Korisničko ime ne smije biti prazno, mora imati više od 4, a najviše 15 znakova!<br>";
            document.getElementById("porukaUsername").style.color = "red";
			poljeUsername.style.border = "1px solid red";
        } else {
            document.getElementById("porukaUsername").innerHTML = "";
            poljeUsername.style.border = "";
        }


        var poljeLozinka = document.getElementById("password");
        var lozinka = document.getElementById("password").value;

        if(lozinka == "") {
			slanje_forme = false;
			document.getElementById("porukaLozinka").innerHTML = "Lozinka ne smije biti prazna!</br>";
			document.getElementById("porukaLozinka").style.color = "red";
			poljeLozinka.style.border = "1px solid red";
        } else {
			document.getElementById("porukaLozinka").innerHTML = "";
			poljeLozinka.style.border = "";
		}


        var poljePonovljenaLozinka = document.getElementById("repeatPassword");
        var ponovljenaLozinka = document.getElementById("repeatPassword").value;

        if(ponovljenaLozinka == "") {
			slanje_forme = false;
            document.getElementById("porukaPonovljenaLozinka").innerHTML = "Ponovljena lozinka ne smije biti prazna!</br>";
			document.getElementById("porukaPonovljenaLozinka").style.color = "red";
            poljePonovljenaLozinka.style.border = "1px solid red";
        } else {
			document.getElementById("porukaPonovljenaLozinka").innerHTML = "";
			poljePonovljenaLozinka.style.border = "";
        }

        if(lozinka != ponovljenaLozinka) {
            slanje_forme = false;
            document.getElementById("porukaPonovljenaLozinka").innerHTML = "Lozinke moraju biti iste!</br>";
			document.getElementById("porukaLozinka").innerHTML = "Lozinke moraju biti iste!</br>";
			poljeLozinka.style.border = "1px solid red";
			poljePonovljenaLozinka.style.border = "1px solid red";
			document.getElementById("porukaPonovljenaLozinka").style.color = "red";
			document.getElementById("porukaLozinka").style.color = "red";
        }


        if(slanje_forme != true) {
            event.preventDefault();
        }
    }
    </script>

    <?php
	echo '<p><a href="../administracija-zaposlenika">Povratak na početnu</a></p>';
	
	require_once "connection.php";
	
	session_start();
	if(!isset($_SESSION["loggedIn"])){
		header("Location: login.php");
		exit;
	}
	
	if($_SESSION["dozvola"] != 'administrator'){
		header("Location: ../administracija-zaposlenika");
		exit;
	}

    if (isset($_POST["submit"])) {
		$username = $_POST["username"];
        $password = $_POST["password"];
        $dozvola = $_POST["dozvola"];
        $hashPassword = password_hash($password, CRYPT_BLOWFISH);
			
        $query = "SELECT korisnicko_ime FROM korisnici WHERE korisnicko_ime = '$username';";
        $result = mysqli_query($conn, $query) or die ("Error");

        if(mysqli_num_rows($result) >= 1)
            echo "Korisničko ime već postoji!";
        else {
            $sql = "INSERT INTO korisnici (korisnicko_ime, lozinka, dozvola) values (?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);

            if (mysqli_stmt_prepare($stmt, $sql)) {
                mysqli_stmt_bind_param($stmt, 'sss', $username, $hashPassword, $dozvola);
                mysqli_stmt_execute($stmt);
                echo "Uspješan unos!";
            }
        }
    }

    mysqli_close($conn);

    ?>

</body>
</html>