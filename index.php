<?php session_start();
$pageSelected = 'index';
if (isset($_POST["deconnexion"])) {
    session_unset();
    session_destroy();
    header('Location:index.php');
}
?>

<!DOCTYPE html>
<html>

<head>
    <title> </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes" />

    <link rel="stylesheet" href="src/css/index.css">

    <link rel="shortcut icon" href="favicon/gamepad.png" type="image/x-icon">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

</head>

<body>


    <header>
        <?php include("include/header.php") ?>
    </header>
    <main>
        <div class="nav"></div>

        <div class="titre">
            <h1>BIENVENUE SUR LE FORUM DE MUSCULATION</h1>
            <img class="img" src="img/59553572_2655686341111264_2586880238562574336_o.jpg" alt="">

        </div>

        <br /><br />

        <?php
        $bdd = mysqli_connect('localhost', 'root', '');
        mysqli_select_db($bdd, 'forum');
        $sql = "SELECT t.*, u.* FROM topics as t, utilisateurs as u WHERE t.id_utilisateurs = u.id  ORDER BY t.date_heure DESC ";

        $req = mysqli_query($bdd, $sql) or die('Erreur SQL !<br />' . $sql . '<br />');

        $nb_sujets = mysqli_num_rows($req);

        if ($nb_sujets == 0) {
            echo 'Aucun sujet';
        } else {
        ?>

            <table class="table">

                <div>
                    <tr>
                        <th>
                            Auteur
                        </th>
                        <th>
                            Titre du sujet

                        </th>
                        <th>
                            Date de création
                        </th>
                        <?php if (isset($_SESSION['login']) == 'admin') { ?>
                            <th>
                                Visibilité
                            </th>
                        <?php } ?>
                    </tr>
                    <?php
                    //recuperer la visibilité du topic
                    try {
                        $bdd = new PDO("mysql:host=localhost;dbname=forum;charset=utf8", "root", "");
                    } catch (PDOException $e) {
                        echo 'Erreur : ' . $e->getMessage();
                    }
                    $recup_visibilite = $bdd->query("SELECT visibilite FROM topics");

                    $fetch_visiblite = $recup_visibilite->fetchAll(PDO::FETCH_ASSOC);
                    //echo 'test';

                    foreach ($fetch_visiblite as $key => $visibilite) {

                        $datas  = mysqli_fetch_all($req);

                        foreach ($datas as $key => $data) {

                            sscanf($data[2], "%4s-%2s-%2s %2s:%2s:%2s", $annee, $mois, $jour, $heure, $minute, $seconde);


                            echo '<tr>';
                            echo '<td>';

                            echo htmlentities(trim($data[3]));
                            echo '</td><td>';

                            echo '<a href="categorie.php?id_topics=', htmlspecialchars($data[0]), '">', htmlentities(trim($data[1])), '</a>';

                            echo '</td><td>';
                            echo $jour, '-', $mois, '-', $annee, ' ', $heure, ':', $minute;

                            if (isset($_SESSION['login']) == 'admin') {
                                echo '</td><td>
                        <form action="#" method="post">
                                    <label for="1">Privée:</label>
                                    <input type="radio" name="newVisibilite" value="1">
                                    <label for="0">Public:</label>
                                    <input type="radio" name="newVisibilite" value="0">
                                    <input class="button" type="submit" name="submit_visibilite" value="POSTER">
                                </form>';
                            }
                        }
                    }
                    if (isset($_POST['newVisibilite']) && isset($_POST['submit_visibilite'])) {
                        echo 'MAJ VISIBILITE';
                        try {
                            $bdd = new PDO("mysql:host=localhost;dbname=forum;charset=utf8", "root", "");
                        } catch (PDOException $e) {
                            echo 'Erreur : ' . $e->getMessage();
                        }
                        $newVisibilite = htmlspecialchars($_POST['newVisibilite']);

                        $visibilite_modif = $bdd->prepare("UPDATE topics SET visibilite=?");
                        $visibilite_modif->execute([$newVisibilite]);
                    } ?>

                    <?php

                    if (isset($_SESSION['login']) === 'admin') { ?>
                        <form action="#" method="post">
                            <label for="1">Privée:</label>
                            <input type="radio" name="newVisibilite" value="1">
                            <label for="0">Public:</label>
                            <input type="radio" name="newVisibilite" value="0">
                            <input class="button" type="submit" name="submit_visibilite" value="POSTER">
                        </form>

                    <?php
                        //traitement du form
                        if (isset($_POST['visiblite']) && isset($_POST['submit_visibilite'])) {
                            echo 'MAJ VISIBILITE';
                            try {
                                $bdd = new PDO("mysql:host=localhost;dbname=forum;charset=utf8", "root", "");
                            } catch (PDOException $e) {
                                echo 'Erreur : ' . $e->getMessage();
                            }
                            $newVisibilite = htmlspecialchars($_POST['newVisibilite']);

                            $visibilite_modif = $bdd->prepare("UPDATE topics SET visibilite=?");
                            $visibilite_modif->execute([[$newVisibilite]]);
                        }
                    } ?>

                    <?php echo '</td></tr>'; ?>




                    </td>
                    </tr>
            </table>
            </div>
        <?php
        }
        mysqli_free_result($req);
        ?>

        </div>

        <?php

        if (isset($_SESSION['login'])) {
            $login = $_SESSION['login'];
            if (isset($_POST['submit'])) {

                //SECURE TITRE
                $titre = htmlspecialchars($_POST['titre']);

                if (!empty($titre)) {

                    //connexion à la base de donne 
                    try {
                        $bdd = new PDO("mysql:host=localhost;dbname=forum;charset=utf8", "root", "");
                    } catch (PDOException $e) {
                        echo 'Erreur : ' . $e->getMessage();
                    }
                    $prepare = $bdd->prepare('SELECT * FROM utilisateurs WHERE login = ? ORDER BY ID DESC');
                    $prepare->execute([$_SESSION['login']]);
                    $user = $prepare->fetch(PDO::FETCH_ASSOC);
                    //inserer dans base de donne 
                    $insert = $bdd->prepare("INSERT INTO topics(id_utilisateurs, titre, date_heure, login,visibilite)
                                    VALUES(:id_utilisateurs, :titre, CURTIME(), :login, :visibilite)");
                    $insert->execute(array(
                        'id_utilisateurs' => (int)$user['id'],
                        'titre' => $titre,
                        'login' => $_SESSION['login'],
                        'visibilite' => $_POST['visibilite']
                    ));

                    header("location:index.php");
                } else echo "Veuillez saisir un titre.";
            }

            if ($_SESSION['login'] === 'admin' || $_SESSION['login'] === 'moderateur') {
        ?>
                <div class="center_form_topic">
                    <form id="form-add-topics" action="#" method="post">
                        <h4 class="title-form">AJOUTER UN TOPIC ICI !</h4>
                        <input type="text" name="titre" placeholder="Saisir un titre">

                        <?php if ($_SESSION['login'] === 'admin') { ?>
                            <label for="1">Privée:</label>
                            <input type="radio" name="visibilite" value="1">
                            <label for="0">Public:</label>
                            <input type="radio" name="visibilite" value="0">
                        <?php } ?>

                        <input class="button" type="submit" name="submit" value="POSTER">


                    </form>
                </div>
        <?php }
        } ?>


    </main>
    <footer>
        <?php include("include/footer.php") ?>
    </footer>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>