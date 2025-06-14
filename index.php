<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <title>Accueil | EncycloNoMi</title>
    <link rel="stylesheet" href="accueil.css">

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
    
    <main>
        <section id="section1" class="section">
            <img src="Images/Sunny.webp" alt="">
            <div class="contenu">
                <h2>Bienvenue dans l'univers de One Piece</h2>
                <p>One Piece est une œuvre emblématique du manga japonais, imaginée par Eiichiro Oda en 1997. Depuis sa première publication, elle a captivé des millions de lecteurs et de spectateurs à travers le monde grâce à son univers riche, son humour unique, ses combats épiques et sa grande aventure maritime.</p>
            </div>
        </section>
        
        <section class="section">
            <img src="Images/grandline.webp" alt="">
            <div class="contenu">
                <h2>Un monde vaste et mystérieux</h2>
                <p>L'histoire se déroule dans un monde majoritairement composé d'océans. Quatre mers principales — East Blue, West Blue, North Blue et South Blue — entourent la mystérieuse et dangereuse Grand Line, l'axe central de ce monde où se trouvent les îles les plus étranges, les créatures les plus puissantes et les secrets les plus anciens.</p>
                <p>Au cœur de ce monde règne une lutte perpétuelle entre :</p>
                <ul>
                    <li>Les pirates, qui sillonnent les mers en quête de liberté et de trésors.</li>
                    <li>La Marine, bras armé du Gouvernement Mondial, chargée de maintenir l'ordre.</li>
                    <li>Les révolutionnaires, qui veulent renverser l'ordre établi.</li>
                </ul>
            </div>
        </section>
        
        <section id="section3" class="section">
            <img src="Images/GolDRoger.webp" alt="">
            <div class="contenu">
                <h2>Le rêve d'un trésor légendaire</h2>
                <p>Le point de départ de l'histoire est la mort du Roi des Pirates, Gol D. Roger. Avant d'être exécuté, il déclara que son trésor, le One Piece, était caché quelque part dans la Grand Line. Cette annonce déclencha une nouvelle ère de piraterie.
                Depuis, des milliers de pirates se sont lancés dans la mer, espérant devenir le prochain Roi des Pirates. Parmi eux, Monkey D. Luffy, un jeune garçon au chapeau de paille, qui possède un pouvoir étrange...</p>
            </div>
        </section>

        <section id="section4" class="section">
            <img src="Images/Primeonepiece.webp" alt="">
            <div class="contenu">
                <h2>Les primes dans One piece</h2>
                <p>Dans l’univers de One Piece, les primes représentent la somme d’argent que le Gouvernement Mondial offre pour la capture, vivante ou morte, d’un individu jugé dangereux. Elles ne reflètent pas seulement la force d’un pirate, mais aussi la menace qu’il représente pour l’ordre mondial.
                   Plus la prime est élevée, plus la personne est influente, puissante ou dérangeante pour le gouvernement. Les primes évoluent au fil des exploits et des méfaits des pirates, faisant de ce chiffre une véritable mesure de réputation dans le monde de One Piece.</p>
            </div>
        </section>
        
        <section id="section5" class="section">
            <img src="Images/fruitdudémon.jpg" alt="">
            <div class="contenu">
                <h2>Les Fruits du Démon</h2>
                <p>Dans cet univers, certaines personnes obtiennent des capacités surnaturelles en mangeant des fruits mystérieux appelés fruits du démon (Akuma no Mi en japonais). Ces fruits sont extrêmement rares et confèrent des pouvoirs très variés — mais ils ont un lourd prix : quiconque en mange perd la capacité de nager, un grand handicap dans un monde où tout se passe en mer.</p>
                <h3>🧬 1. Paramecia</h3>
                <p>Modifient le corps ou l'environnement de l'utilisateur.</p>             
                <h3>🐾 2. Zoan</h3>
                <p>Permettent de se transformer en animal ou créature hybride.</p>
                <h3>🔥 3. Logia</h3>
                <p>Permettent de contrôler et de devenir un élément naturel.</p>
            </div>
        </section>
        
        <section class="encyclopédie">
            <h2>Explorez l'encyclopédie des utilisateurs de fruits du démon</h2>
            <a href="encyclopédie.php">Accédez à l'encyclopédie !</a>
        </section>
            <h2 id="actualité">Actualité des derniers utilisateurs ajoutés</h2>
    </main>
    <?php
    include ("connexion.php");
    $stmt = $db->query('SELECT * FROM utilisateur_fruit 
                        JOIN fruit_demon ON fruit_demon.id_fruit = utilisateur_fruit.id_fruit
                        JOIN classe ON classe.id_classe = fruit_demon.id_classe 
                        ORDER BY id_utilisateur DESC LIMIT 3');
    $result = $stmt->fetchAll();

    echo '<div class="utilisateur-container">';
    foreach ($result as $row) {
        echo '<a href="utilisateur.php?id='.$row["id_utilisateur"].'">
                <div class="utilisateur">
                    <h3>'.$row["nom_utilisateur"].' '.$row["prenom_utilisateur"].'</h3>
                    <img src="'.$row["image"].'" alt="Utilisateur">
                </div>
              </a>';
    }
    echo '</div>';
    ?>

    <script src="script.js"></script>

    <footer>
        <small>Copyright © 2025 EncycloNoMi.com. Tous droits réservés - Alexis Charpentier</small>
    </footer>
</body>
</html>