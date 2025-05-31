    <?php
    include ("connexion.php");
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

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
        "INSERT INTO fruit_démon (`pouvoir`)
         VALUES (?)" );
    $stmt->execute([ $_POST["pouvoir"]]);

    $id_fruit = $db->lastInsertId(); } 

    //classe

    $id_classe = $_POST["classe"];
$stmt = $db->prepare(
    "SELECT id_classe FROM classe
    WHERE nom_classe = ? ");

$stmt->execute([ $_POST["nom_classe"]]);
$classe = $stmt->fetch(PDO::FETCH_ASSOC);

if ($classe) {
   
    $id_classe = $classe["id_classe"];}

else {
    $stmt = $db->prepare(
        "INSERT INTO classe (`nom_classe`)
         VALUES (?)" );
    $stmt->execute([ $_POST["nom_classe"]]);

    $id_classe = $db->lastInsertId(); }

    //rôle

    $id_role = $_POST["role"];
    $stmt = $db->prepare(
    "SELECT id_role FROM `role`
    WHERE nom_role = ? ");

$stmt->execute([ $_POST["nom_role"]]);
$role = $stmt->fetch(PDO::FETCH_ASSOC);

if ($role) {
   
    $id_role = $role["id_role"];}

else {
    $stmt = $db->prepare(
        "INSERT INTO `role` (`nom_role`)
         VALUES (?)" );
    $stmt->execute([ $_POST["nom_role"]]);

    $id_role = $db->lastInsertId(); }

    //tableau principale

    $stmt = $db->prepare("SELECT * FROM utilisateur_fruit WHERE nom_utilisateur = ? or prenom_utilisateur = ?");
    $stmt->execute([$_POST["nom"], $_POST["prenom"]]);
    $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($utilisateur) {
        echo"L'utilisateur est déjà sur le site";
        $id_utilisateur = $utilisateur["id_utilisateur"]; }

    else {
   
        $stmt = $db->prepare("INSERT INTO utilisateur_fruit (nom_utilisateur,prenom_utilisateur, id_role , id_fruit, prime) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$_POST["nom"], $_POST["prenom"], $id_role, $id_classe, $id_fruit, $_POST["prime"]]);
     
   $id_utilisateur = $db->lastInsertId();
        echo"L'utilisateur a bien été ajouter";}

}
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire | EncycloNoMi</title>
</head>
<body>
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
    echo '<br><label for="rôle">Rôle de l\'utilisateur : </label>
          <select name="rôle" id="rôle">';

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
</body> 
</html>