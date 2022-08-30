<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administracija zaposlenika - Registracija</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
	<link rel="stylesheet" media="screen" href="style.css">
    <link rel="shortcut icon" href="slike/favicon.ico" />
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

    <div class="container-fluid" style="width: 850px;">
        <form method="POST">
            <div class="row">
                <label class="col-8">Korisničko ime:
                    <input class="form-control"  name="username" id="username" type="text" placeholder="Unesite korisničko ime" required>
                    <span id="porukaUsername" class="error"></span>
                </label>
            </div>

            <div class="row">
                <label class="col-4">Lozinka:
                    <input class="form-control"  name="password" id="password" type="password" placeholder="Unesite lozinku" required>
                    <span id="porukaLozinka" class="error"></span>
                </label>
                
                <label class="col-4">Ponovljena lozinka:
                    <input class="form-control"  name="repeatPassword" id="repeatPassword" type="password" placeholder="Ponovite lozinku" required>
                    <span id="porukaPonovljenaLozinka" class="error"></span>
                </label>
            </div>
            
            <div class="row">
                <label class="col-4">Dozvola:
                    <select class="form-select" name="dozvola">
                        <option value="administrator">Administrator</option>
                        <option value="editor">Editor</option>
                    </select>
                </label>
            </div>
            
            <div style="margin-top:20px">
                <input class="btn btn-success" name="submit" id="submit" type="submit" value="Unesi">
                <a class="btn btn-outline-secondary" style="margin-left:5px;" href="../administracija-zaposlenika">Povratak na početnu</a>
            </div>
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
    </div>

    <?php include "footer.php"; ?>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>
</html>