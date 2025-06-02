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
        <label for="tri-prenom">Trier par prénom :</label>
        <select id="tri-prenom">
            <option value="prenom_asc">A-Z</option>
            <option value="prenom_desc">Z-A</option>
        </select>

        <label for="filtre-fruit">Type de fruit :</label>
        <select id="filtre-fruit">
            <option value="">Tous</option>
            <option value="Logia">Logia</option>
            <option value="Paramecia">Paramecia</option>
            <option value="Zoan naturel">Zoan naturel</option>
            <option value="Zoan mythique">Zoan mythique</option>
            <option value="Zoan antique">Zoan antique</option>
        </select>

        <label for="filtre-role">Rôle :</label>
        <select id="filtre-role">
            <option value="">Toutes</option>
            <option value="Pirate">Pirate</option>
            <option value="Marine">Marine</option>
            <option value="Revolutionnaire">Révolutionnaire</option>
            <option value="Gouvernement">Gouvernement</option>
        </select>
    </section>

    <?php
    include('connexion.php');
if (isset($_GET["nom"]) && !empty($_GET["nom"])) {
    $search = $_GET["nom"];

    $join_query = "SELECT * 
        FROM utilisateur_fruit 
        JOIN fruit_demon ON fruit_demon.id_fruit = utilisateur_fruit.id_fruit
        JOIN classe ON classe.id_classe = fruit_demon.id_classe 
        WHERE 
            prenom_utilisateur LIKE :search 
            OR nom_classe LIKE :search";

    $stmt = $db-> prepare ($join_query);
    $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $stmt->execute();
} else {
    $stmt = $db->query("
        SELECT utilisateur_fruit.*, fruit_demon.*, classe.nom_classe, role.nom_role
        FROM utilisateur_fruit
        JOIN fruit_demon ON utilisateur_fruit.id_fruit = fruit_demon.id_fruit
        JOIN classe ON fruit_demon.id_classe = classe.id_classe
        JOIN role ON utilisateur_fruit.id_role = role.id_role
    ");
}

$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo '<div class="utilisateur-container">';
foreach ($result as $row) {
echo '<div class="utilisateur" data-classe="'.$row["nom_classe"].'" data-role="'.$row["nom_role"].'">';
echo '<a href="utilisateur.php?id='.$row["id_utilisateur"].'">';
echo '<h3>'.$row["prenom_utilisateur"].'</h3><h3>'.$row["nom_utilisateur"].'</h3>';
echo '<img src="'.$row["image"].'" alt="image utilisateur">';
echo '</a></div>';  
}
echo '</div>';
?>
    <footer>
        <small>Copyright © 2025 EncycloNoMi.com. Tous droits réservés - Alexis Charpentier</small>
    </footer>
    <script src="trie.js"></script>
</body>