<?php
    // Inclure le fichier de connexion à la base de données
    include("functions.php");

    // Requête pour récupérer le nombre d'inscriptions par nationalité
    $query = "SELECT nationality, COUNT(*) AS nombre_inscriptions FROM applications GROUP BY nationality";
    $result = $bdd->query($query);
    
    // Initialisation du tableau des nationalités
    $nationality = array(); // Corrected variable name

    // Remplir le tableau avec les données de la base de données
    while ($row = $result->fetch()) {
        $nationality[$row['nationality']] = $row['nombre_inscriptions'];
    }

    // Largeur et hauteur de l'image
    $largeurImage = 800;
    $hauteurImage = 600;

    // Créer une nouvelle image
    $im = imagecreatetruecolor($largeurImage, $hauteurImage);

    // Couleurs
    $blanc = imagecolorallocate($im, 255, 255, 255);
    $noir = imagecolorallocate($im, 0, 0, 0);
    $bleu = imagecolorallocate($im, 0, 0, 255);

    // Remplir l'arrière-plan en blanc
    imagefilledrectangle($im, 0, 0, $largeurImage, $hauteurImage, $blanc);

    // Coordonnées du graphique
    $x = 50;
    $y = 50;
    $largeurBarre = 40;
    $espaceEntreBarres = 20;

    // Trouver la valeur maximale pour ajuster l'échelle
    $maxInscriptions = max($nationality);

    // Dessiner les barres
    foreach ($nationality as $nationalite => $inscriptions) {
        $hauteurBarre = ($inscriptions / $maxInscriptions) * ($hauteurImage - 100);
        imagefilledrectangle($im, $x, $hauteurImage - $hauteurBarre - $y, $x + $largeurBarre, $hauteurImage - $y, $bleu);
        imagestring($im, 5, $x, $hauteurImage - $hauteurBarre - $y - 20, $nationalite, $noir);
        imagestring($im, 5, $x, $hauteurImage - $y + 10, $inscriptions, $noir);
        $x += $largeurBarre + $espaceEntreBarres;
    }

    // En-tête HTTP pour indiquer que le contenu est une image PNG
    header("Content-type: image/png");

    // Afficher l'image PNG
    imagepng($im);

    // Libérer la mémoire
    imagedestroy($im);
?>
