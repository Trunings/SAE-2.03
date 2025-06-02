    <?php
    include ("connexion.php");
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //classe

    $id_classe = $_POST["classe"];

        //fruit 

$stmt = $db->prepare(
    "SELECT id_fruit FROM fruit_demon
    WHERE pouvoir = ? ");

$stmt->execute([ $_POST["pouvoir"]]);
$fruit = $stmt->fetch(PDO::FETCH_ASSOC);

if ($fruit) {
   
    $id_fruit = $fruit["id_fruit"];}

else {
    $stmt = $db->prepare(
        "INSERT INTO fruit_demon (`pouvoir`, id_classe)
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Berkshire+Swash&family=DynaPuff:wght@400..700&display=swap" rel="stylesheet">
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
    <main class="form-container">
    <h1>Ajouter un utilisateur</h1>
    <form action="formulaire.php" method="post" enctype="multipart/form-data" class="formulaire-utilisateur">
        <div class="form-group">
            <label for="nom">Nom :</label>
            <input type="text" name="nom" id="nom">
        </div>

        <div class="form-group">
            <label for="prenom">Prénom <span aria-hidden="true">*</span> :</label>
            <input type="text" name="prenom" id="prenom" required>
        </div>

        <div class="form-group">
            <label for="file">Image :</label>
            <input type="file" name="file" id="file" aria-describedby="file-help" required>
            <small id="file-help">Format recommandé : 640 x 512</small>
        </div>

        <div class="form-group">
            <label for="pouvoir">Pouvoir <span aria-hidden="true">*</span> :</label>
            <input type="text" name="pouvoir" id="pouvoir" required aria-describedby="pouvoir-help">
            <small id="pouvoir-help">Décris le pouvoir du fruit du démon (ex : fruit du vent)</small>
        </div>

        <div class="form-group">
            <label for="classe">Classe :</label>
            <select name="classe" id="classe">
                <?php
                $stmt = $db->query('SELECT * FROM classe');
                foreach ($stmt->fetchAll() as $row) {
                    echo '<option value="' . $row["id_classe"] . '">' . $row["nom_classe"] . '</option>';
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <label for="prime">Prime :</label>
            <input type="number" name="prime" id="prime">
        </div>

        <div class="form-group">
            <label for="role">Rôle :</label>
            <select name="role" id="role">
                <?php
                $stmt = $db->query('SELECT * FROM `role`');
                foreach ($stmt->fetchAll() as $row) {
                    echo '<option value="' . $row["id_role"] . '">' . $row["nom_role"] . '</option>';
                }
                ?>
            </select>
        </div>

        <fieldset class="form-group sagas">
            <legend>Sagas d'apparition :</legend>
            <?php
            $stmt = $db->query('SELECT * FROM saga_apparition');
            foreach ($stmt->fetchAll() as $row) {
                echo '<label><input type="checkbox" name="sagas[]" value="' . $row['id_saga'] . '"> ' . $row['nom_saga'] . '</label>';
            }
            ?>
        </fieldset>

        <div class="form-group">
            <input type="submit" name="bouton" value="Ajouter l'utilisateur" class="submit-btn">
        </div>
    </form>
</main>
    
    <footer>
        <small>Copyright © 2025 EncycloNoMi.com. Tous droits réservés - Alexis Charpentier</small>
    </footer>
</body> 
</html>