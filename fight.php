<?php
require_once 'config/autoload.php';
require_once 'config/db.php';
require_once 'classes/Hero.php'; // Ajouter l'inclusion de la classe Hero

$heroesManager = new HeroesManager($db);

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $heroId = $_GET['id'];
    $hero = $heroesManager->find($heroId);

    $monsters = array(
        'Cell' => 'cell.png',
        'Babidi' => 'babidi.png',
        'Buu' => 'buu.png'
    );
    $monsterName = array_rand($monsters, 1);
    $monster = new Monster($monsterName);
    
    // ... Effectuer le combat ...
    $fightsManager = new FightsManager();
    $fightsManager->setHero($hero); // Utiliser la méthode setHero pour définir le héros dans le gestionnaire de combats
    $fightsManager->setMonster($monster); // Utiliser la méthode setMonster pour définir le monstre dans le gestionnaire de combats
    $fightsResult = $fightsManager->fight();

    // Obtenir les health points et l'énergie finaux du héros après le combat
    $finalHeroHealth = $hero->getHealthPoint();
    $finalHeroEnergy = $hero->getEnergy();
    
    // Réinitialiser les health points et l'énergie du héros
    $heroesManager->update($hero);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combat</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<header>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand mx-auto" href="#">Budokaï Battle</a>
        </div>
    </nav>
</header>
<body>
    <section class="fightPage">
        <?php if ($hero && $monster): ?>
        <div class="row">
            <div class="col-md-4">
                <img src="<?php echo $hero->getAvatar(); ?>" class="card-img-top mt-5" >
                <div class="card-body text-center text-primary ">
                    <h5 class="card-title"><?php echo $hero->getName(); ?></h5>
                    <p class="card-text"><i class="fa-solid fa-heart" style="color: #e01b24;"></i> <span
                            id="heroHealth"><?php echo $hero->getHealthPoint() . " PV"; ?></span></p>
                    <p class="card-text"><i class="fa-solid fa-bolt" style="color: #ffcc00;"></i>
                        <span id="heroEnergy"><?php echo $hero->getEnergy() . " Énergie"; ?></span></p>
                </div>
            </div>
            <div class="col-md-4 mb-5">
                <h3><img src = "images/versus.png"></h3>
            </div>
            <div class="col-md-4">
                <img src="images/<?php echo $monsters[$monsterName]; ?>" class="card-img-top mt-5">
                <div class="card-body text-center text-primary ">
                    <h5 class="card-title"><?php echo $monster->getName(); ?></h5>
                    <p class="card-text"><i class="fa-solid fa-heart" style="color: #e01b24;"></i> <span
                            id="monsterHealth"><?php echo $monster->getHealthPoint() . " PV"; ?></span></p>
                </div>
            </div>
        </div>

        <h2>Résultat du combat :</h2>
        <div class="container d-flex justify-content-center">
            <table class="table table-striped table-bordered w-75 fightResult">
                <tbody>
                    <?php $index = 0; ?>
                    <?php foreach ($fightsResult as $result): ?>
                    <tr style="display: none;">
                        <td><?php echo $result; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
        <a href="index.php">Retour à l'accueil</a>
    </section>

    <div class="footer">
    <div class="battle">
    <audio id="getReady">
        <source src="sounds/getReady.mp3" type="audio/mpeg" >
    </audio>
    </div>
</div>
    </footer>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const getReady = document.getElementById("getReady");
        // Lancer automatiquement le son lors du chargement de la page
        getReady.play();
    });

    // Fonction pour afficher les résultats de combat progressivement
    function showFightResultsWithDelay() {
        const rows = document.querySelectorAll('.fightResult tr');
        let rowIndex = 0;

        function showNextRow() {
            if (rowIndex < rows.length) {
                rows[rowIndex].style.display = 'table-row';
                if (rowIndex % 2 === 0) {
                    rows[rowIndex].classList.add('even-row');
                } else {
                    rows[rowIndex].classList.add('odd-row');
                }
                rowIndex++;

                // Contrôlez ici le moment où l'audio doit être joué
                if (rowIndex === rows.length) {
                    const winAudio = document.getElementById('winAudio');
                    // Vérifiez si le héros est une instance de SonGokuHero
                    if (typeof hero !== 'undefined' && hero instanceof SonGokuHero) {
                        winAudio.play(); // Jouer l'audio lorsque le héros SonGoku remporte le combat
                    }
                }

                setTimeout(showNextRow, 1500);
            }
        }

        showNextRow();
    }

    // Appeler la fonction pour afficher les résultats de combat progressivement
    showFightResultsWithDelay();

    // Mettre à jour les health points et l'énergie
    function updateHealthAndEnergy(heroHealth, heroEnergy, monsterHealth) {
        const heroHealthElement = document.getElementById('heroHealth');
        const heroEnergyElement = document.getElementById('heroEnergy');
        const monsterHealthElement = document.getElementById('monsterHealth');

        heroHealthElement.textContent = heroHealth + ' PV';
        heroEnergyElement.textContent = heroEnergy + ' Énergie';
        monsterHealthElement.textContent = monsterHealth + ' PV';
    }

    // Mise à jour progressive des health points et de l'énergie
    function updateHealthAndEnergyWithDelay(
        initialHeroHealth, initialHeroEnergy, finalHeroHealth, finalHeroEnergy, finalMonsterHealth
    ) {
        const heroHealthIncrement = (finalHeroHealth - initialHeroHealth) / 10;
        const heroEnergyIncrement = (finalHeroEnergy - initialHeroEnergy) / 10;
        const monsterHealthIncrement = (finalMonsterHealth - initialMonsterHealth) / 10;

        let currentHeroHealth = initialHeroHealth;
        let currentHeroEnergy = initialHeroEnergy;
        let currentMonsterHealth = finalMonsterHealth; // Modified here, set to finalMonsterHealth

        function updateHealthAndEnergy() {
            currentHeroHealth += heroHealthIncrement;
            currentHeroEnergy += heroEnergyIncrement;
            currentMonsterHealth -= monsterHealthIncrement; // Modified here, decrement currentMonsterHealth

            updateHealthAndEnergy(
                Math.ceil(currentHeroHealth),
                Math.ceil(currentHeroEnergy),
                Math.ceil(currentMonsterHealth) // Modified here, set to currentMonsterHealth
            );

            if (
                currentHeroHealth < finalHeroHealth
                || currentHeroEnergy < finalHeroEnergy
                || currentMonsterHealth > initialMonsterHealth // Modified here, check if currentMonsterHealth > initialMonsterHealth
            ) {
                setTimeout(updateHealthAndEnergy, 150); // Définir le délai d'attente ici (0.15 seconde dans ce cas)
            }
        }

        updateHealthAndEnergy();
    }

    // Appeler la fonction pour mettre à jour les health points et l'énergie avec un délai
    updateHealthAndEnergyWithDelay(
        <?php echo $hero->getHealthPoint(); ?>,
        <?php echo $hero->getEnergy(); ?>,
        <?php echo $finalHeroHealth; ?>,
        <?php echo $finalHeroEnergy; ?>,
        <?php echo $monster->getHealthPoint(); ?>
    );
</script>

</html>