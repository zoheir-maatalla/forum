<?php session_start();
$pageSelected = 'profil';
if (isset($_POST["deconnexion"])) {
    session_unset();
    session_destroy();
    header('Location:index.php');
}

?>

<head>
    <title></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes" />

    <link rel="stylesheet" href="src/css/index.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
    <header>
        <?php include("include/header.php") ?>
    </header>
    <main>

        <?php

        $bdd = mysqli_connect("localhost", "root", "", "forum");
        $myid = $_GET['id_topics'];
        $requete = "SELECT c.*, u.*,t.* 
                    FROM categories as c, utilisateurs as u, topics as t
                    WHERE c.id_utilisateurs = u.id AND t.id = c.id_topics  AND t.id = $myid";
        $query = mysqli_query($bdd, $requete);
        $datas = mysqli_fetch_all($query);
        $nb_sujets = mysqli_num_rows($query);

        if ($nb_sujets == 0) {
            echo 'Aucune catégorie';
        } else {
        ?>
            <div class="table">
                <div class="table">

                    <table width="900" border="4">
                        <tr>
                            <th>
                                Titre topics
                            </th>
                            <th>
                                Titre catégorie
                            </th>
                            <th>
                                Login
                            </th>
                            <th>
                                Date, heure de poste
                            </th>
                        </tr>
                        <?php


                        foreach ($datas as $key => $data) {
                            echo '<tr>';
                            echo '<td>';
                            echo htmlentities(trim($datas[$key][9]));


                            echo '</td>';
                            echo '<td>';

                            // echo htmlentities(trim($datas[$key][2]));
                            echo '<a href="message.php?id_categorie= ', htmlspecialchars($data[0]), '" >', htmlentities(trim($datas[$key][3])), '</a>';
                            echo '</td>';
                            echo '<td>';
                            echo htmlentities(trim($datas[$key][6]));



                            echo '</td>';
                            echo '<td>';
                            echo htmlentities(trim($datas[$key][2]));

                            echo '</td>';
                            echo '</tr>'; ?>
                        <?php
                        } ?>

                    </table>
                </div>
            </div>
        <?php
        }
        mysqli_free_result($query);
        ?>
        <?php if (isset($_SESSION['login'])) {

            if (isset($_POST['submit'])) {

                //SECURE TITRE
                $titre = htmlspecialchars($_POST['titre']);

                if (!empty($titre)) {

                    //connexion à la bdd
                    try {
                        $bdd = new PDO("mysql:host=localhost;dbname=forum;charset=utf8", "root", "");
                    } catch (PDOException $e) {
                        echo 'Erreur : ' . $e->getMessage();
                    }
                    $prepare = $bdd->prepare('SELECT * FROM utilisateurs WHERE login = ? ORDER BY ID DESC'); # Pourquoi order si c'est déjà ordonné dans l'index ? Pourquoi demander un login si l'admin est le seul a pouvoir ajouter des catégories.
                    $prepare->execute([$_SESSION['login']]);
                    $user = $prepare->fetch(PDO::FETCH_ASSOC);
                    //inserer dans bdd
                    $insert = $bdd->prepare("INSERT INTO categories(id_topics, id_utilisateurs, titre, date_heure) 
                                VALUES(:id_topics, :id_utilisateurs, :titre, CURTIME())");
                    $insert->execute(array(
                        'id_topics' => $myid,
                        'id_utilisateurs' => (int)$user['id'],
                        'titre' => $titre
                    ));

                    header("location: categorie.php?id_topics=" . $myid);
                } else echo "Veuillez saisir un titre.";
            }
        ?>
            <div class="table">
                <form id="form-add-topics" action="categorie.php?id_topics=<?= $myid ?>" method="post">
                    <h4 class="title-form">AJOUTER UNE CATEGORIE ICI !</h4>
                    <input type="text" name="titre" placeholder="Saisir un titre">
                    <input class="button" type="submit" name="submit" value="POSTER">
                </form>
            </div>
        <?php } ?>
        </div>
    </main>
    <br> </br>
    <footer>
        <?php include("include/footer.php") ?>
    </footer>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>