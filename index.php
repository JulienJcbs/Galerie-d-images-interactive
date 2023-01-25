<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Micro | Gallerie</title>
    <style>
        .container {
            top: 0;
            left: 0;
            max-width: 1080px;
            margin: auto;
            text-align: center;
        }

        body {
            top: 0;
            left: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        header {
            text-align: center;
        }

        .img {
            width: 100px;
            height: auto;
        }

        .cont-img {
            text-align: center;
            display: grid;
            grid-template-columns: 135px 135px 135px 135px 135px 135px 135px 135px;
        }

        .dir {
            text-align: center;
        }

        .nomImage {
            font-size: 16px;
        }

        .sliderContaint {
            width: <?php echo ((compterImages()) * 400) . 'px'; ?>;
            display: flex;
            overflow: hidden;
            position: absolute;
            animation: moveSlide <?php
                                    echo (compterImages()) * 5;
                                    ?>s infinite;
        }

        .hidden {
            visibility: hidden;
        }

        .slider {
            overflow: hidden;
            height: 500px;
            width: 400px;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .elementContaint {
            cursor: pointer;
        }

        .slidable {
            width: 400px;
            height: auto;
            min-width: 100%;
        }

        .slider-scroll {
            position: relative;
        }

        .imgSlide {
            width: 400px;
            height: auto;
        }

        .noSlidable {
            width: 400px;
            height: auto;
        }

        @keyframes moveSlide {
            form {}

            50% {
                margin-left: -<?php
                                echo ((compterImages() - 1) * 400) . 'px';
                                ?>;
            }

            100% {}
        }
    </style>
</head>

<body>
    <main>
        <div class="container">
            <header>
                <h1>
                    Ma gallerie photos.
                </h1>
            </header>
            <div class="cont-img">
                <?php
                /**
                 * Affiche les éléments du répertoire
                 */
                displayDir();
                ?>
            </div>
        </div>
        <div class="slider hidden" id="slider">
            <div class="sliderContaint">
                <?php
                /**
                 * Affiche le slider si nécéssaire
                 */
                if (isset($_GET['dir'])) {
                    displaySlider();
                }
                ?>
            </div>
        </div>
    </main>
    <script>
        /**
         * Element slider
         */
        const slideElement = document.getElementById('slider');

        /**
         * Récupère l'URL
         */
        const URL = window.location.search;

        // Paramètres de l'url
        const params = new URLSearchParams(URL);

        //Affiche L'élémént s'il y en a un de sélectionné
        function deHiddeSlider() {
            slideElement.classList.toggle('hidden');
        }


        /**
         * Appelle la méthode qui affiche l'élément
         * si une image ou un répertoire a été demandé dans l'URL
         */
        if (params.get('dir') != undefined) {
            deHiddeSlider();
        }
    </script>
</body>

</html>

<?php

/**
 * Affiche le contenu du répertoire
 */
function displayDir()
{
    $link = './img';
    $scandir = scandir($link);
    foreach ($scandir as $fichier) {
        $infos = new SplFileInfo($fichier);
        $src = 'ico-dir.svg';
        if ($infos->getExtension() != '') {
            $src = './img/' . $fichier;
        }
?>
        <?php if ($fichier != '.' && $fichier != '..') { ?>
            <a href="index.php?dir=<?= $fichier; ?>">
                <div class="dir elementContaint">
                    <span class="nomImage"><?= $fichier ?></span>
                    <img class="img" src="<?= $src; ?>" alt="Img : <?= $fichier ?>">
                </div>
            </a>
        <?php }
    }
}

/**
 * Affiches les éléments contenus dans le slider
 */
function displaySlider()
{
    $infos = new SplFileInfo($_GET['dir']);
    /**
     * Image direct
     */
    if ($infos->getExtension() != '') {
        ?>
        <div class="noSlidable">
            <img src="./img/<?= $_GET['dir'] ?>" alt="Img : <?= $_GET['dir'] ?>" class="imgSlide">
        </div>
        <?php
    }
    /**
     * Répertoire d'images
     */
    else {
        $scandir = scandir('./img/' . $_GET['dir']);
        foreach ($scandir as $fichier) {
            if ($fichier != '.' && $fichier != '..') {
        ?>
                <div class="slider-scroll imgS">
                    <img src="./img/<?php echo $_GET['dir'] . '/' . $fichier ?>" alt="Img : <?php echo $_GET['dir'] . '/' . $fichier ?>" class="imgSlide">
                </div>
<?php
            }
        }
    }
}

/**
 * Compte les fichiers qui se trouvent dans un répertoire
 */
function compterImages()
{
    $scandir = scandir('./img/' . $_GET['dir']);
    $i = 0;
    foreach ($scandir as $fichier) {
        if ($fichier != '.' && $fichier != '..') {
            ++$i;
        }
    }
    return $i;
}
