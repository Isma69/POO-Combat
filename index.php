<?php
require_once('config/autoload.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<?php
        $db = new PDO('mysql:host=127.0.0.1;dbname=FinalBattle;charset=utf8', 'root');
        $heroManager = new HeroesManager($db);
        $heroes = $heroManager->findAllAlive();
        ?>
<header>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand mx-auto" href="#">Budokaï Battle</a>
        </div>
    </nav>
</header>
<body>
<main>
<div class="col-6 mx-auto p-3">
    <div class="row">
        <form method="POST" class="text-center text-light" id="formHero">
            <h4>Créer votre Personnage</h4>
            <div class="col-4">
                <label for="name">Pseudo</label>
                <input type="text" id="name" name="name">
                <label for="avatar">Changez votre avatar :</label>
                <select id="avatar" name="avatar" onchange="updateAvatar()">
                    <option value="images/goku.png" class="SonGoku" selected>SonGoku</option>
                    <option value="images/vegeta.png" class="Vegeta">Vegeta</option>
                    <option value="images/yajirobe.png" class="Yajirobe">Yajirobe</option>
                </select>
            </div>
            <div class="col-4">
                <img src="images/goku.png" id="avatarImage" />
                <input type="submit" value="Envoyer">
            </div>
        </form>
    </div>
</div>
    <?php
    if (isset($_POST['name']) && isset($_POST['avatar']) && !empty($_POST['name']) && !empty($_POST['avatar'])) {
        $name = $_POST['name'];
        $avatar = $_POST['avatar'];
    
        // Instanciation de la classe correspondante en fonction de l'avatar choisi
        if ($avatar === "images/goku.png") {
            $hero = new SonGokuHero($name, $avatar);
        } elseif ($avatar === "images/vegeta.png") {
            $hero = new VegetaHero($name, $avatar);
        } elseif ($avatar === "images/yajirobe.png") {
            $hero = new YajirobeHero($name, $avatar);
        }
        $heroManager->add($hero);
        // Après l'ajout du héros, redirigez l'utilisateur vers la page d'accueil pour afficher le nouveau héros.
        header("Location: index.php");
        exit();
    }
    ?>
        <script>
            let image = document.querySelector('img');
            document.querySelector("select").addEventListener("change", function(e) {
                let src = e.target.value;
                image.setAttribute("src", src);
            });
        </script>
        <div id="carousel" class="carousel">
            <div class="container ">
                <div class="row">
                    <div class="col-9">
                        <div id="carouselExampleAutoplaying" class="carousel slide d-flex center" data-bs-ride="carousel">
                            <div class="carousel-inner rounded">
                                <?php $totalHeroes = count($heroes); ?>
                                <?php for ($i = 0; $i < $totalHeroes; $i += 3) : ?>
                                    <div class="carousel-item <?php if ($i === 0) echo 'active'; ?>">
                                        <div class="row">
                                            <?php for ($j = $i; $j < min($i + 3, $totalHeroes); $j++) : ?>
                                                <?php $hero = $heroes[$j]; ?>
                                                <div class="col-md-4">
                                                    <img src="<?php echo ($hero->getAvatar()); ?>" class="card-img-top mt-3" height="350px">
                                                    <div class="card-body text-center text-primary">
                                                        <h5 class="card-title"><?php echo ($hero->getName()); ?></h5>
                                                        <p class="card-text"><i class="fa-solid fa-heart" style="color: #e01b24;"></i> <?php echo ($hero->getHealthpoint() . " PV"); ?></p>
                                                        <a href="fight.php?id=<?php echo $hero->getId(); ?>" class="btn btn-primary">Choisir</a>
                                                    </div>
                                                </div>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>

                    </div>


                </div>


            </div>


        </div>
    </main>
    <footer>
<div class="footer">
    <div class="son">
    <audio id="backgroundMusic" loop>
        <source src="sounds/dbzMusic.mp3" type="audio/mpeg" >
    </audio><i class="fa-solid fa-music"><button id="toggleSoundButton">Activer le son</button></i>
    </div>
</div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const backgroundMusic = document.getElementById("backgroundMusic");
        const toggleSoundButton = document.getElementById("toggleSoundButton");

        // Fonction pour activer ou désactiver le son
        function toggleSound() {
            if (backgroundMusic.paused) {
                backgroundMusic.play();
                toggleSoundButton.textContent = "Couper le son";
            } else {
                backgroundMusic.pause();
                toggleSoundButton.textContent = "Activer le son";
            }
        }

        // Écouteur d'événement pour le clic sur le bouton
        toggleSoundButton.addEventListener("click", toggleSound);

        // Lancer automatiquement le son lors du chargement de la page
        backgroundMusic.play();
        toggleSoundButton.textContent = "Couper le son";
    });
</script>

<script>
    function updateAvatar() {
        const selectElement = document.getElementById('avatar');
        const selectedAvatar = selectElement.value;
        const avatarImageElement = document.getElementById('avatarImage');
        avatarImageElement.src = selectedAvatar;
    }

    // Appel initial pour afficher l'avatar correspondant à l'option par défaut
    updateAvatar();
</script>
</body>

</html>