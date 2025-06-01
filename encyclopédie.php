<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encyclopédie | EncycloNoMi</title>
    <link rel="stylesheet" href="encyclopédie.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/vnd.icon" href="Images/favicon-16x16.png">
</head>
<body>
    <header>
        <div class="header-contenu">
            <div class="titre">EncycloNoMi</div>

            <form class="recherche-header" action="encyclopédie.php" method="get"> 
                <label for="nom"></label>
                <input type="text" name="nom" id="nom" placeholder="Recherche">
            </form>
            <nav>
                <a href="index.php">Accueil</a>
                <a href="encyclopédie.php">Encyclopédie</a>
                <a href="formulaire.php">Formulaire</a>
                <a href="aboutme.html">About Me</a>
            </nav>
        </div>
    </header>

    <section>
    </section>

    <?php
    include('connexion.php');
if (isset($_GET["nom"]) && !empty($_GET["nom"])) {
    $search = $_GET["nom"];

    $join_query = "SELECT * 
        FROM utilisateur_fruit 
        JOIN fruit_démon ON fruit_démon.id_fruit = utilisateur_fruit.id_fruit
        JOIN classe ON classe.id_classe = fruit_démon.id_classe 
        WHERE 
            prenom_utilisateur LIKE :search 
            OR nom_classe LIKE :search";

    $stmt = $db-> prepare ($join_query);
    $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $stmt->execute();
} else {
    $stmt = $db->query("SELECT * FROM utilisateur_fruit");
}

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo '<div class="utilisateur-container">';
foreach ($result as $row) {
    echo '<a href="utilisateur.php?id='.$row["id_utilisateur"].'"> <div class="utilisateur"> <h3>'.$row["prenom_utilisateur"].'</h3> <h3>'.$row["nom_utilisateur"].'</h3>
    <img src = "'.$row["image"].'">';   
    echo '</div> </a>';
}
echo '</div>';
?>
    <footer>
        <small>Copyright © 2025 EncycloNoMi.com. Tous droits réservés.</small>
    </footer>
</body>