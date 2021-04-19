<?php session_start();

$pageSelected = 'profil';


if (isset($_POST["deconnexion"])) {
    session_unset();
    session_destroy();
    header('Location:index.php');
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Profil</title>
    <link rel="stylesheet" type="text/css" href="src/css/index.css">

    <link rel="stylesheet" type="text/css" href="src/css/profil.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

</head>

<body>
    <!-- Header -->
    <header id="header">
        <?php include("include/header.php") ?>
    </header>
    <!-- Main -->
    <main id="milieu">
        <?php
        if ($_SESSION['login']) {
            echo "<div class='center_pProfil'> <p>Bienvenue " . $_SESSION['login'] . " ! <br/><br/>

					<a href='changement_mdp.php'>Changer de mot de passe</a><br/>

					<a href='changement_login.php'>Changer de login</a><br/>

					<a href='logout.php'>Se déconnecter</a></p></div>";
        } else {
            header("Location:connexion.php");
        }
        ?>
    </main>

    <!-- Footer -->
    <footer>
        <?php include("include/footer.php") ?>
    </footer>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>