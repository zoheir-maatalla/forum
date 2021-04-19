<?php
//SECURE PASSWORD N VERIF IF LOGIN ALREADY EXIST
session_start();
if (isset($_POST['submit'])) {
    $login = htmlentities(trim($_POST['login']));
    $password = htmlentities(trim($_POST['password']));
    $repeatpassword = htmlentities(trim($_POST['repeatpassword']));

    if ($login && $password && $repeatpassword) {
        if ($password == $repeatpassword) {
            //CRYPTAGE MDP
            $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 15));

            $db = mysqli_connect('localhost', 'root', '') or die('Erreur');
            mysqli_select_db($db, 'forum');

            //VERIFIER SI LE LOGIN EXISTE DEJA
            $request = " SELECT login FROM utilisateurs WHERE login = '" . $_POST['login'] . "' ";
            $query = mysqli_query($db, $request);
            $test_login = mysqli_fetch_array($query);

            if (!empty($test_login)) {
                echo "Ce login existe déjà ! Veuillez en choisir un autre.";
            } else {
                $query = mysqli_query($db, "INSERT INTO utilisateurs (login, password) VALUES('$login', '$password');");

                die("Inscription terminée. <a href='connexion.php'>Connectez-vous</a>.");
            }
        } else {
            echo "Les mots de passes doivent être identiques";
        }
    } else {
        echo "Veuillez saisir tous les champs";
    }
}
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Inscription</title>
    <link rel="stylesheet" type="text/css" href="src/css/index.css">
    <link rel="stylesheet" type="text/css" href="src/css/inscription.css">
    <link rel="shortcut icon" href="favicon/gamepad.png" type="image/x-icon">
</head>

<body class="color">
    <!-- Header -->
    <header id="header">
        <?php include("include/header.php") ?>
    </header>


    <!-- Main -->
    <main>
        <h1>Inscription</h1><br />
        <form method="post" action="inscription.php">
            <p>Login</p>
            <input class="input" type="text" name="login">
            <p>Mot de passe</p>
            <input class="input" type="password" name="password">
            <p>Répétez votre mot de passe</p>
            <input class="input" type="password" name="repeatpassword"><br><br>
            <input class="input" type="submit" name="submit" value="Valider">
        </form>
    </main>

</body>

</html>