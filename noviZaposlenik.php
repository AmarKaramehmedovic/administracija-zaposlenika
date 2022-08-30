<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administracija zaposlenika - Unos zaposlenika</title>
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
                <label class="col-8">Naziv poduzeća zaposlenika:
                    <select name="poduzeceId" class="form-select">
                        <?php
                        $query = "SELECT id, nazivPoduzeca FROM poduzeca ORDER BY nazivPoduzeca";
                        $result = mysqli_query($conn, $query) or die("Error");
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<option value='" . $row['id'] . "'>" . $row['nazivPoduzeca'] . "</option>";
                        }
                        ?>
                    </select>
                </label>
            </div>

            <div class="row" style="margin-top:7px">
                <label class="col-4">Ime:
                    <input class="form-control" name="imeZaposlenika" type="text" placeholder="Unesite ime">
                </label>
                <label class="col-4">Prezime:
                    <input class="form-control" name="prezimeZaposlenika" type="text" placeholder="Unesite prezime">
                </label>
            </div>

            <div class="row" style="margin-top:7px">
                <label class="col-4">Email:
                    <input class="form-control" name="email" type="email" placeholder="example@mail.com">
                </label>
                <label class="col-4">Kontakt broj:
                    <input class="form-control" type="tel" name="kontaktBr" pattern="[0-9\s\/\-\+]*"  placeholder="Unesite broj telefona">
                </label>
            </div>

            <div style="margin-top:20px">
                <input class="btn btn-success" name="submit" id="submit" type="submit" value="Unesi">
                <a class="btn btn-outline-secondary" style="margin-left:5px;" href="../administracija-zaposlenika">Povratak na početnu</a>
            </div>
        </form>

        <?php
        if (isset($_POST["submit"])) {

            $ime = $_POST["imeZaposlenika"];
            $prezime = $_POST["prezimeZaposlenika"];
            $email = $_POST["email"];
            $kontakt = $_POST["kontaktBr"];
            $poduzeceId = $_POST["poduzeceId"];

            $query = "SELECT ime, prezime FROM zaposlenici WHERE ime = '$ime' AND prezime = '$prezime';";
            $result = mysqli_query($conn, $query) or die("Error");

            if (mysqli_num_rows($result) >= 1)
                echo "Zaposlenik sa unesenim imenom i prezimenom već postoji!";
            else {
                $sql = "INSERT INTO zaposlenici (ime, prezime, email, kontaktBr, poduzeceId) values (?, ?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);

                if (mysqli_stmt_prepare($stmt, $sql)) {
                    mysqli_stmt_bind_param($stmt, 'ssssi', $ime, $prezime, $email, $kontakt, $poduzeceId);
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