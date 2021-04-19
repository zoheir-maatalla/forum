<?php session_start();

$bdd = mysqli_connect("localhost", "root", "", "moduleconnexion");
$requete = "SELECT * FROM utilisateurs";
$query = mysqli_query($bdd, $requete);
$user = mysqli_fetch_all($query);

?>

<table>
    <tr>
        <th>Id</th>
        <th>Login</th>
        <th>Prenom</th>
        <th>Nom</th>
        <th>Password</th>
    <tr>
        <?php foreach ($user as $valeur) { ?>
    <tr>
        <td> <?php echo $valeur[0]; ?> </td>
        <td> <?php echo $valeur[1]; ?> </td>
        <td> <?php echo $valeur[2]; ?> </td>
        <td> <?php echo $valeur[3]; ?> </td>
        <td> <?php echo $valeur[4]; ?> </td>
    </tr>
<?php } ?>


<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>ADMIN</title>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900" rel="stylesheet" />
    <link href="default.css" rel="stylesheet" type="text/css" media="all" />
    <link href="fontawesome-templategit.css" rel="stylesheet" type="text/css" media="all" />
    <link rel="shortcut icon" href="favicon/gamepad.png" type="image/x-icon">
</head>

<body class="color">
    <header>
        <div id="header-wrapper">
            <div id="header" class="container">
                <div id="logo">
                    <h1><a href="#">Botanique</a></h1>
                </div>
                <div id="menu">
                    <ul>
                        <li><a href="index.php" accesskey="1" title="">Page d'accueil</a></li>
                        <li><a href="inscription.php" accesskey="2" title="">Inscription</a></li>
                        <!-- <li><a href="connexion.php" accesskey="3" title="">Connexion</a></li> -->
                        <li><a href="profil.php" accesskey="4" title="">Profil</a></li>
                        <li><a href='logout.php'>Se déconnecter</a></p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <main>
        <h1 class="title"> Bienvenue Admin ! </h1>
</body>

</html>

<?php echo '<style>


.title {
	text-align: center;
	color: white;
	margin-bottom: 2%;
	margin-top: 1%;

}

table {
	border: medium solid #17202A;
	border-collapse: collapse;
	width: 15%;
	margin: auto;

	}

th {
	
	border: thin solid #17202A;
	padding: 5px;
	background-color: #FFFF;

}

td {
	border: thin solid #17202A;
	background-color: #117A65;
	padding: 5px;
	text-align: center;

}

<style>' ?>