<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administracija zaposlenika - Unos poduzeća</title>
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
        $_SESSION["editSuccess"] = false;
        $id = $_GET["id"];

        include "header.php";
        require_once "connection.php";

        $query = "SELECT * FROM poduzeca WHERE id = '$id'";
        $result = mysqli_query($conn, $query) or die("Query Error");
        $row = mysqli_fetch_array($result);

        $naziv = $row['nazivPoduzeca'];
        $adresa = $row['adresa'];
        $postBr = $row['postBr'];
        $mjesto = $row['mjesto'];
        $kontakt = $row['kontaktBr'];

        if (isset($_POST["submit"])) {

            $naziv = $_POST["nazivPoduzeca"];
            $adresa = $_POST["adresaPoduzeca"];
            $postBr = $_POST["postBr"];
            $mjesto = $_POST["mjesto"];
            $kontakt = $_POST["kontaktBr"];

            $query = "SELECT nazivPoduzeca FROM poduzeca WHERE nazivPoduzeca = '$naziv' AND nazivPoduzeca != '". $row['nazivPoduzeca'] ."'";
            $result = mysqli_query($conn, $query) or die("Query Error");

            if (mysqli_num_rows($result) == 0){
                $sql = "UPDATE poduzeca
                        SET nazivPoduzeca = ?,
                            adresa = ?,
                            postBr = ?,
                            mjesto = ?,
                            kontaktBr = ?
                        WHERE id = ?";

                $stmt = mysqli_stmt_init($conn);

                if (mysqli_stmt_prepare($stmt, $sql)) {
                    mysqli_stmt_bind_param($stmt, 'ssissi', $naziv, $adresa, $postBr, $mjesto, $kontakt, $id);
                    mysqli_stmt_execute($stmt);
                    $_SESSION["editSuccess"] = true;
                } else{
                    echo "<br/>Greška, poduzeće nije uređeno!";
                }
            }
        }
    ?>

    <div class="container-fluid wrapper">
        <h4 style="font-size: 1.6rem;">Uređivanje poduzeća: 
        "<?php
            if(isset($_POST["submit"]) && $_SESSION["editSuccess"] == false){
                echo $row['nazivPoduzeca'];
            }else{
                echo $naziv;
            }
        ?>"</h4>
        <br />
        <form method="POST">
            <div class="row">
                <label class="col-8">Naziv poduzeća:
                    <input class="form-control" value="<?php echo $naziv; ?>" name="nazivPoduzeca" type="text" placeholder="Unesite naziv" required>
                </label>
            </div>

            <div class="row form-spacing">
                <label class="col-4">Adresa:
                    <input class="form-control" value="<?php echo $adresa; ?>" name="adresaPoduzeca" type="text" placeholder="Unesite adresu">
                </label>
                <label class="col-4">Poštanski broj:
                    <input class="form-control" value="<?php echo $postBr; ?>" name="postBr" type="number" placeholder="Unesite poštanski broj">
                </label>
            </div>

            <div class="row form-spacing">
                <label class="col-4">Mjesto:
                    <input class="form-control" value="<?php echo $mjesto; ?>" name="mjesto" type="text" placeholder="Unesite mjesto">
                </label>

                <label class="col-4">Kontakt broj:
                    <input class="form-control" value="<?php echo $kontakt; ?>" type="tel" name="kontaktBr" pattern="[0-9\s\/\-\+]*" placeholder="Unesite broj telefona">
                </label>
            </div>

            <div style="margin-top:20px">
                <input class="btn btn-primary" name="submit" id="submit" type="submit" value="Spremi">
                <a class="btn btn-outline-secondary" style="margin-left:5px;" href="../administracija-zaposlenika">Povratak na početnu</a>
            </div>
            <?php
                if(isset($_POST["submit"]) && $_SESSION["editSuccess"] == true){
                    echo "<br/><span class='text-success'>Poduzeće uspješno uređeno!</span>";
                    $_SESSION["editSuccess"] = false;
                }
                else if(isset($_POST["submit"]) && $_SESSION["editSuccess"] == false){
                    echo "</br><span class='text-danger'>Greška, provjerite da niste unijeli naziv poduzeća koji već postoji!</span>";
                }
                mysqli_close($conn);
            ?>
        </form>
    </div>

    <?php readfile("footer.html"); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</body>

</html>