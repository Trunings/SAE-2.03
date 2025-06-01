    <?php
    include ("connexion.php");
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //classe

    $id_classe = $_POST["classe"];

        //fruit 

$stmt = $db->prepare(
    "SELECT id_fruit FROM fruit_démon
    WHERE pouvoir = ? ");

$stmt->execute([ $_POST["pouvoir"]]);
$fruit = $stmt->fetch(PDO::FETCH_ASSOC);

if ($fruit) {
   
    $id_fruit = $fruit["id_fruit"];}

else {
    $stmt = $db->prepare(
        "INSERT INTO fruit_démon (`pouvoir`, id_classe)
         VALUES (?, ?)" );
    $stmt->execute([ $_POST["pouvoir"], $id_classe]);

    $id_fruit = $db->lastInsertId(); } 



    //rôle

    $id_role = $_POST["role"];

    //image

    if (isset($_FILES['file'])) {
        $tmpName = $_FILES['file']['tmp_name'];
        $name = $_FILES['file']['name'];
        move_uploaded_file($tmpName, 'Images/utilisateur/' . $name);
    }
    $image = 'Images/utilisateur/' . $name;

    //tableau principale

    $stmt = $db->prepare("SELECT * FROM utilisateur_fruit WHERE nom_utilisateur = ? or prenom_utilisateur = ?");
    $stmt->execute([$_POST["nom"], $_POST["prenom"]]);
    $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($utilisateur) {
        echo"L'utilisateur est déjà sur le site";
        $id_utilisateur = $utilisateur["id_utilisateur"]; }

    else {
   
        $stmt = $db->prepare("INSERT INTO utilisateur_fruit (nom_utilisateur,prenom_utilisateur, id_role , id_fruit, prime, `image`) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$_POST["nom"], $_POST["prenom"], $id_role, $id_fruit, $_POST["prime"], $image]);
     
   $id_utilisateur = $db->lastInsertId();
        echo"L'utilisateur a bien été ajouter";}



    //saga

     if (!empty($_POST['sagas'])) {
        $sagas = $_POST['sagas'];

        foreach ($sagas as $saga) {
            $stmt = $db->prepare("INSERT INTO utilisateur_saga (id_saga, id_utilisateur) VALUES (?, ?)");
            $stmt->execute([$saga, $id_utilisateur]);
        }

        echo "Options enregistrées.";
    } else {
        echo "Aucune option cochée.";
    }
}
    ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encyclopédie | EncycloNoMi</title>
    <link rel="stylesheet" href="formulaire.css">
    
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
    <form action="formulaire.php" method="post" enctype= "multipart/form-data">

        <label for="nom">Nom de l'utilisateur : </label>
        <input type="text" name="nom" id="nom">

        <br>
        <label for="prenom">Prénom de l'utilisateur : </label>
        <input type="text" name="prenom" id="prenom">

        <br>
        <label for="file">Image</label>
        <input type="file" name="file" required>

        <br>
        <label for="pouvoir">Pouvoir de l'utilisateur : </label>
        <input type="text" name="pouvoir" id="pouvoir">
        
    <?php
    echo '<br><label for="classe">Classe de l\'utilisateur : </label>
          <select name="classe" id="classe">';

    $stmt = $db->query('SELECT * FROM classe');
    $result = $stmt->fetchAll();
    foreach ($result as $row) {
    echo '<option value="' . $row["id_classe"] . '">' . $row["nom_classe"] . '</option>';
    }
    echo '</select>';
    ?>
        <br>
        <label for="prime">prime de l'utilisateur : </label>
        <input type="number" name="prime" id="prime">

    <?php
    echo '<br><label for="role">Rôle de l\'utilisateur : </label>
          <select name="role" id="role">';

    $stmt = $db->query('SELECT * FROM `role`');
    $result = $stmt->fetchAll();

    foreach ($result as $row) {
    echo '<option value="' . $row["id_role"] . '">' . $row["nom_role"] . '</option>';
    }

    echo '</select>';
    ?>

    <?php
    $stmt = $db->query('SELECT * FROM saga_apparition');
    $result = $stmt->fetchAll();

    echo '<p><strong>Sagas d\'apparition de l\'utilisateur :</strong></p>';

    foreach ($result as $row) {
    echo '<label>';
    echo '<input type="checkbox" name="sagas[]" value="' . $row['id_saga'] . '">';
    echo ' ' . ($row['nom_saga']);
    echo '</label><br>';
}    
?>
    <input type="submit" name="bouton" id="bouton">
    
    <footer>
        <small>Copyright © 2025 EncycloNoMi.com. Tous droits réservés.</small>
    </footer>
</body> 
</html>