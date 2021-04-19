<?php session_start();

if (isset($_POST["deconnexion"])) {
    session_unset();
    session_destroy();
    header('Location:index.php');
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Conversation</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=yes" />
    <script src="https://kit.fontawesome.com/5a25ce672a.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Mukta&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="src/css/index.css">
    <link rel="shortcut icon" href="favicon/gamepad.png" type="image/x-icon">
</head>

<body>
    <header>
        <?php include("include/header.php") ?>
    </header>
    <main>

        <?php
        $link = mysqli_connect("localhost", "root", "", "forum");


        $myid = $_GET['id_categorie'];


        $requete = "SELECT topics.titre as topics_titre, categories.titre as categories_titre, utilisateurs.login, messages.contenu, messages.date_heure FROM messages INNER JOIN utilisateurs ON(messages.id_utilisateurs=utilisateurs.id) INNER JOIN categories ON (categories.id=id_categorie) INNER JOIN topics ON (categories.id_topics = topics.id) where categories.id=$myid";
        $query = mysqli_query($link, $requete);
        $results = mysqli_fetch_all($query, MYSQLI_ASSOC);

        ?>
        <div class="center">
            <div class="table-center">
                <table width="500" border="1">
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
                            Contenu
                        </th>
                        <th>
                            Date, heure de poste
                        </th>
                        <th>
                            Like / Dislike
                        </th>
                    </tr>
                    <tr>



                        <?php
                        foreach ($results as $key => $data) {
                            echo '<tr>';

                            echo '<td>';
                            echo htmlentities(trim($data['topics_titre']));
                            echo '</td>';

                            echo '<td>';
                            echo htmlentities(trim($data['categories_titre']));
                            echo '</td>';

                            echo '<td>';
                            echo htmlentities(trim($data['login']));
                            echo '</td>';

                            echo '<td>';
                            echo htmlentities(trim($data['contenu']));
                            echo '</td>';

                            echo '<td>';
                            echo  htmlentities(trim($data['date_heure']));
                            echo '</td>';

                            echo '<td>';
                            echo '<div class="vote_btn">
                    <button class="vote_like"><i class="fas fa-thumbs-up"></i> 55</button>
                    <button class="vote_dislike"><i class="fas fa-thumbs-down"></i> 5</button>';
                            echo '</td>';

                            echo '</tr>';
                        ?>
                        <?php } ?>

                </table>
            </div>
        </div>
        <?php
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
                    $insert = $bdd->prepare("INSERT INTO messages(id_categorie, id_utilisateurs, date_heure, contenu) 
                                VALUES(:id_topics, :id_utilisateurs, CURTIME(), :contenu)");
                    $insert->execute(array(
                        'id_topics' => $myid,
                        'id_utilisateurs' => (int)$user['id'],
                        'contenu' => $titre
                    ));

                    header("location: message.php?id_categorie=" . $myid);
                } else echo "Veuillez saisir un titre.";
            }
        ?>

            <div class="center_form_topic">
                <form id="form-add-topics" action="message.php?id_categorie=<?= $myid ?>" method="post">
                    <h4 class="title-form">AJOUTER UN MESSAGE ICI !</h4>
                    <input type="text" name="titre" placeholder="Saisir un titre">
                    <input class="button" type="submit" name="submit" value="POSTER">
                </form>
            </div>
        <?php } ?>
        </div>
    </main>
    <footer>
        <?php include("include/footer.php") ?>
    </footer>
</body>
</body>

</html>