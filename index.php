<?php

include("config/config.php");
include("config/bd.php"); // commentaire
include("divers/balises.php");
include("config/actions.php");
session_start();
ob_start(); // Je démarre le buffer de sortie : les données à afficher sont stockées

if (isset($_SESSION['id']) == false && isset ($_COOKIE['remember'])) {
    $sql = "SELECT * FROM user WHERE remember=?";
    $q = $pdo->prepare($sql);
    $q -> execute(array($_COOKIE['remember']));
    
    $l = $q->fetch();
    if($l != false) {
        $_SESSION['id'] = $l['id'];
        $_SESSION['login'] = $l['login'];
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>IMA</title>

    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="./css/ie10.css" rel="stylesheet">


    <!-- Ma feuille de style à moi -->
    <link href="./css/style.css" rel="stylesheet">

    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>

<body>

<?php
if (isset($_SESSION['info'])) {
    echo "<div class='alert alert-info alert-dismissible' role='alert'>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
        <span aria-hidden='true'>&times;</span></button>
        <strong>Information : </strong> " . $_SESSION['info'] . "</div>";
    unset($_SESSION['info']);
}
?>

    

<header class="header">

    <div id="main-header">

        

        <a href="index.php?action=accueil"><img src="img/ima.png"></a>
         <?php
        if (isset($_SESSION['id'])) {
          
            echo "  <div class='bar-recherche'> 
            <form action = 'index.php' method = 'get'>
                <input type = 'hidden' name='action' value='recherche'>
                <input type = 'search' name = 'recherche'>
                <button type = 'submit' name = 'go'>Rechercher</button>
            </form>
        </div>";
        }
        ?>
        
        
        <div id="amis">

        <?php
        if (isset($_SESSION['id'])) {
          
            echo "<a href='index.php?action=amis'><strong>Mes amis</strong></a>";
        }
        ?>

        </div>

        <div id="profil">

        <?php
        if (isset($_SESSION['id'])) {
          
            echo "<a href='index.php?action=profil&id=" .$_SESSION['id'] ."'><strong>Mon profil</strong></a>";
        }
        ?>

        </div>
        
        <div id="persid">
        <?php
if (isset($_SESSION['id'])) 

{
    echo "<div class='persid'>";
    echo "<p>Bonjour <strong>" . $_SESSION['login'] . "</strong></p><a href='index.php?action=deconnexion'>   Deconnexion</a>";
    echo "</div>";
} 
?>
       </div>
       

    </div>

</header>
   
    



<div class="container-fluid">

    <div class="row">

        <!--<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">-->
        <div class="col-md-12 main">

            <?php

                // Quelle est l'action à faire ?
                if (isset($_GET["action"])) {
                    $action = $_GET["action"];
                } else {
                    $action = "accueil";
                }

                // Est ce que cette action existe dans la liste des actions
                if (array_key_exists($action, $listeDesActions) == false) {
                    include("vues/404.php"); // NON : page 404
                } else {
                    include($listeDesActions[$action]); // Oui, on la charge
                }

                ob_end_flush(); // Je ferme le buffer, je vide la mémoire et affiche tout ce qui doit l'être

            ?>


        </div>

    </div>

</div>

<footer>
    
    <div class="footer">

        <div class="footer-categorie">

            <nav>

                <ul>

                    <li><a href="/vues/aide.php"><strong>Aide</strong></a></li>
                    <li><a href="/vues/aide.php"><strong>À propos</strong></a></li>
                    <li><a href="/vues/aide.php"><strong>Conditions générales</strong></a></li>  

                </ul>

            </nav>

        </div>
    
        <div class="footer-copyright">

            <p>© Tous droits réservés - 2020 / <a href="#"><strong>ima.fr</strong></a></p>

        </div>

    </div>


</footer>
</body>
</html>
