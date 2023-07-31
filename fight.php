<?php
require_once 'config/autoload.php';
require_once 'classes/FightsManager.php';
require_once 'config/db.php';

// Créer une instance de HeroesManager
$heroesManager = new HeroesManager($db);

// Vérifier si un héros_id est passé en paramètre dans l'URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $heroId = $_GET['id'];

    // Utiliser la fonction find() du HeroesManager pour récupérer le héros en fonction de son id
    $hero = $heroesManager->find($heroId);

    // Vérifier si le héros a été trouvé
    if ($hero) {
        // Instancier un FightManager
        $fightManager = new FightsManager();

        // Créer un monstre en utilisant la fonction createMonster() du FightManager
        $monster = $fightManager->createMonster("Goblin"); // Vous pouvez spécifier le nom du monstre ici

        // Déclencher le combat en utilisant la fonction fight() du FightManager
        $fightResult = $fightManager->fight($hero, $monster);

        // Une fois le combat résolu, appelez la fonction update() du HeroesManager pour mettre à jour les informations du héros dans la base de données
        $heroesManager->update($hero);
    } else {
        echo "Héros introuvable.";
    }
} else {
    echo "Aucun ID de héros spécifié.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combat</title>
</head>
<body>
    <?php if (isset($fightResult) && !empty($fightResult)): ?>
        <h2>Résultat du combat :</h2>
        <ul>
            <?php foreach ($fightResult as $result): ?>
                <li><?php echo $result; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <a href="index.php">Retour à l'accueil</a>
</body>
</html>