<?php
if (!isset($_SESSION['login'])) {
?>
    <div class="btn-group">
        <a href="index.php" class="btn btn-primary" aria-current="Accueil">Accueil</a>
        <div class="btn btn-outline-light"><a href="connexion.php">Se connecter</a></div>
        <div class="btn btn-outline-light"><a href="inscription.php">S'inscrire</a></div>
    </div>
<?php
}
?>
<?php
$pageSelected = 'profil';
if (isset($_SESSION['login'])) {
?>

    <div class="btn_center">
        <ul class="menu-nav">
            <?php if ($pageSelected == 'profil') { ?>
                <li class="btn"><a href="index.php">ACCUEIL</a></li>
            <?php } ?>
            <li class="btn"><a href="profil.php">PROFIL</a></li>
            <li class="btn"><a href="logout.php">DECONNEXION</a></li>
        </ul>
    </div>
<?php
}
?>
</nav>
<script src="https://kit.fontawesome.com/68a550b660.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css" />