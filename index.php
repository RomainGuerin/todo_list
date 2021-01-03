<?php
    // Connexion à la base de donnée
    $dsn='mysql:host=localhost;dbname=todolist; charset=utf8';
    $user='root';
    $password='';
    try{
        $dbh= mysqli_connect('localhost', 'root', '', 'todolist');
        mysqli_query($dbh,'SET NAMES utf8');
    }catch(PDOException $e){
        echo'Connexion échouée:'.$e->getMessage(); 
    }

    // Choix de la table
    $listeafaire = mysqli_query($dbh, "SELECT * FROM listeafaire");

    // Ajout de la Tâche à la base de donnée
    if(isset($_POST['ajouter'])){
        $tache=$_POST['tache'];
        mysqli_query($dbh, "INSERT INTO listeafaire (tache) VALUES ('$tache')");
        header('location: index.php');
    }

    // Suppression de la Tâche dans la base de donnée
    if(isset($_GET['tache_supp'])){
        $id = $_GET['tache_supp'];
        mysqli_query($dbh, "DELETE FROM listeafaire WHERE id=$id");
        header('location: index.php');
    }

    // Changement de la valeur du statut de la Tâche
    if(isset($_GET['tache_fini'])){
        $id = $_GET['tache_fini'];
        mysqli_query($dbh, "UPDATE listeafaire SET fini=1 WHERE id=$id");
        header('location: index.php');
    }
?>


<!DOCTYPE html>
<html lang="fr">
<head>
	<!-- Encodage pour les caractères spéciaux -->
    <meta charset="utf-8">
    <!-- Adaptation de la page aux différents formats -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Description du site -->
	<meta name="description" content="To-Do List" />
	<!-- Nom de l'auteur du site -->
	<meta name="author" content="Romain Guérin" />
	<!-- Titre de la page du site -->
	<title>To-do List</title>
    <!-- Lien vers la feuille de style CSS -->
    <link rel="stylesheet" type="text/css" href="styles.css">
    <!-- Lien pour les Icones -->
    <script src="https://use.fontawesome.com/releases/v5.15.1/js/all.js" crossorigin="anonymous"></script>
    <!-- Icone de la page -->
    <link rel="icon" type="image/png" sizes="16x16" href="favicon.png">
</head>

<body>
    <div class="header">
        <div class="textetop">
            <h2>To-Do List</h2>
            <form method="POST" type="POST" action="index.php">
                <!-- Texte inférieur à 50 caractères -->
                <input id="NewTache" class="form-control" placeholder="Tâche à faire..." name="tache" type="text" required> 
                <button type="submit" name="ajouter">Ajouter</button>
            </form>
        </div>

        <hr class="tab">
        
        <div class="textebottom anime-bas">
            <ul>
                <?php
                    // Affichage des tâches inscrit dans la base de donnée
                    while ($reponse = mysqli_fetch_array($listeafaire)){
                ?>
                    <li class="<?php echo $reponse['fini'] ? ' fini' : ''?>">
                        <a href="index.php?tache_fini=<?php echo $reponse['id'];?>" class="btn_fini"><i class="fas fa-check"></i></a>
                        <?php echo $reponse['tache']; ?>
                        <a href="index.php?tache_supp=<?php echo $reponse['id'];?>" class="fermer"><i class="fas fa-times"></i></a>
                    </li>
                <?php
                   }
                ?>
            </ul>
        </div>
    </div>
</body>
</html>