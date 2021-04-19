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
        $password = htmlspecialchars($_POST['password']);
        $newpassword = htmlspecialchars($_POST['newpassword']);
        $repeatnewpassword = htmlspecialchars($_POST['repeatnewpassword']);
        if ($password && $newpassword && $repeatnewpassword) {
            if ($newpassword == $repeatnewpassword) {
                $db = mysqli_connect('localhost', 'root', '') or die('Erreur');
                mysqli_select_db($db, 'forum');
                $query = mysqli_query($db, "SELECT * FROM utilisateurs WHERE login = '$username' AND password = '$password'");
                $rows = mysqli_num_rows($query);
                if ($rows == 1) {
                    $newpass = mysqli_query($db, "UPDATE utilisateurs SET password='$newpassword' WHERE login='$username'");
                    die("Votre mot de passe a bien été modifié. Vous pouvez vous <a href='connexion.php'>connecter</a>.");
                } else {
                    echo "Votre ancien mot de passe est incorrect";
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
    <link rel="stylesheet" type="text/css" href="css/index.css">
    <link rel="stylesheet" type="text/css" href="css/changement_mdp.css">
    <script src="https://kit.fontawesome.com/5a25ce672a.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="src/css/index.css">
    <link rel="shortcut icon" href="favicon/gamepad.png" type="image/x-icon">
</head>

<body>
    <!-- Header -->
    <header>
        <?php include("include/header.php") ?>
    </header>
    <!-- Main -->
    <main>
        <form method="POST" action="changement_mdp.php">
            <p>Votre ancien mot de passe</p>
            <input class="input" type="password" name="password"></input>
            <p>Votre nouveau mot de passe</p>
            <input class="input" type="password" name="newpassword"></input>
            <p>Répétez votre nouveau mot de passe</p>
            <input class="input" type="password" name="repeatnewpassword"></input>
            <input class="input" type="submit" value="Submit" name="submit"></input>
        </form>
    </main>
</body>

</html>