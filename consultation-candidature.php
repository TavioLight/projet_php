<?php
session_start();


require_once "inc/functions.php";

if (!isset($_SESSION['username'])) {
    header('location:.');
}

$old_application = checkUserCandidature($_SESSION['username']);

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Candidature</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
          integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="container my-5">
    <div class="row">
        <div class="col-md-8 col-12 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center">Candidature</h2>
                </div>

                <?php

                $application = $old_application;

                if (empty($application->naissance_pdf)) {
                    $n = "Aucun fichier";
                } else {
                    $n = "<a target='_blank' href='$application->naissance_pdf'>Télécharger</a>";
                }

                if (empty($application->bac2_pdf)) {
                    $b = "Aucun fichier";
                } else {
                    $b = "<a target='_blank' href='$application->bac2_pdf'>Télécharger</a>";
                }

                if (empty($application->nationality_pdf)) {
                    $n2 = "Aucun fichier";
                } else {
                    $n2 = "<a target='_blank' href='$application->nationality_pdf'>Télécharger</a>";
                }


                ?>
                <div class="card-body">
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>Nom</td>
                            <td><?php echo $old_application->lastname ?></td>
                        </tr>
                        <tr>
                            <td>Prénom</td>
                            <td><?php echo $old_application->firstname ?></td>
                        </tr>
                        <tr>
                            <td>Photo</td>
                            <td><img src="<?php echo $old_application->photo ?>" alt="" width="100px"></td>
                        </tr>
                        <tr>
                            <td>Date de naissance</td>
                            <td><?php echo $old_application->date_of_birth ?></td>
                        </tr>
                        <tr>
                            <td>Sexe</td>
                            <td><?php echo $old_application->gender ?></td>
                        </tr>
                        <tr>
                            <td>Nationalité</td>
                            <td><?php echo $old_application->nationality ?></td>
                        </tr>
                        <tr>
                            <td>Année d'obtention du BAC</td>
                            <td><?php echo $old_application->year_of_bac2 ?></td>
                        </tr>
                        <tr>
                            <td>Série du BAC</td>
                            <td><?php echo $old_application->serie ?></td>
                        </tr>
                        <tr>
                            <td>Naissance</td>
                            <td><?php echo $n ?></td>
                        </tr>
                        <tr>
                            <td>Nationnalité</td>
                            <td><?php echo $n2 ?></td>
                        </tr>
                        <tr>
                            <td>Attestation du BAC II</td>
                            <td><?php echo $b ?></td>
                        </tr>
                        </tbody>
                    </table>

                    <div class="text-center">
                        <a href="./gestion-candidature" class="btn btn-primary px-5 py-2 mb-2">Retour</a>
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>


<div class="container">
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong class="me-auto fs-6" id="message">Bootstrap</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

</div>

<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/script.js"></script>
<script src="js/forms.js"></script>
</body>

</html>

