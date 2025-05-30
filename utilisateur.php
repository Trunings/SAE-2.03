<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="utilisateur.css"> 
</head>
<body>    
<?php
include("connexion.php");

if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);

    $join_query = "SELECT * FROM 
                        utilisateur_fruit 
                        JOIN fruit_démon ON fruit_démon.id_fruit = utilisateur_fruit.id_fruit
                        JOIN classe ON classe.id_classe = fruit_démon.id_classe 
                        JOIN role ON role.id_role = utilisateur_fruit.id_role
                        JOIN utilisateur_saga ON utilisateur_saga.id_utilisateur = utilisateur_fruit.id_utilisateur
                        JOIN saga_apparition ON saga_apparition.id_saga = utilisateur_saga.id_saga
                   WHERE utilisateur_fruit.id_utilisateur = :id";

    $stmt = $db->prepare($join_query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

foreach ($rows as $row) {
    echo '<h1>' . $row["prenom_utilisateur"] . '</h1>
          <h1>' . $row["nom_utilisateur"] . '</h1>
          <img src="' . $row["image"] . '">
          <p>' . $row["pouvoir"] . '</p>
          <p>' . $row["nom_classe"] . '</p>
          <p>' . $row["prime"] . '</p>
          <p>' . $row["nom_role"] . '</p>';
    break;
}

echo '<h3>Sagas :</h3><ul>';
foreach ($rows as $row) {
    echo '<li>' . $row["nom_saga"] . '</li>';
}
echo '</ul>';
?>
</body>
</html>