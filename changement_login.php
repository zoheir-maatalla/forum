<?php session_start();

$pageSelected = 'profil';


if (isset($_POST["deconnexion"])) {
    session_unset();
    session_destroy();
    header('Location:index.php');
}
?>
<?php
if (isset($_SESSION['login'])) {
    $username = $_SESSION['login'];
    if (isset($_POST['submit'])) {
        $login = htmlspecialchars($_POST['login']);
        $newlogin = htmlspecialchars($_POST['newlogin']);
        $repeatnewlogin = htmlspecialchars($_POST['repeatnewlogin']);
        if ($login && $newlogin && $repeatnewlogin) {
            if ($newlogin == $repeatnewlogin) {
                $db = mysqli_connect('localhost', 'root', '') or die('Erreur');
                mysqli_select_db($db, 'forum');
                $query = mysqli_query($db, "SELECT * FROM utilisateurs WHERE login = '$username' AND login = '$login'");
                $rows = mysqli_num_rows($query);
                if ($rows == 1) {
                    $newpass = mysqli_query($db, "UPDATE utilisateurs SET login='$newlogin' WHERE login='$username'");
                    die("Votre login a bien été modifié. Vous pouvez vous <a href='connexion.php'>connecter</a>.");
                } else {
                    echo "Votre ancien login est incorrect";
                }
            } else {
                echo "Les deux champs doivent être identiques";
            }
        } else {
            echo "Veuillez saisir tous les champs";
        }
    }


    echo '
	';
} else {
    header("Location:connexion.php");
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Changement de login</title>
    <link rel="stylesheet" type="text/css" href="src/css/index.css">
    <link rel="stylesheet" type="text/css" href="css/changement_login.css">
    <link rel="shortcut icon" href="favicon/gamepad.png" type="image/x-icon">
</head>

<body>
    <!-- Header -->
    <header>
        <?php include("include/header.php") ?>
    </header>

    <!-- Main -->
    <main>
        <form method="POST" action="changement_login.php">
            <p>Votre ancien login</p>
            <input class="input" type="text" name="login"></input>
            <p>Votre nouveau login</p>
            <input class="input" type="text" name="newlogin">
            <p>Répétez votre nouveau login</p>
            <input class="input" type="text" name="repeatnewlogin"></input>
            <input class="input" type="submit" value="Changer de login" name="submit"></input>
        </form>
    </main>
</body>

</html>