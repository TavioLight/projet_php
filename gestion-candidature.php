<?php
session_start();

require_once "inc/functions.php";
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Gestion candidataure</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
          integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="container my-5">
    <div class="row">
        <div class="col-md-6 col-12 offset-md-3">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center">Gestion candidature</h2>
                </div>
                <div class="card-body">
                    <form action="" method="post" class="row vstack gap-3" enctype="multipart/form-data">

                        <div class="p-5">
                            <div class="row vstack gap-2">

                                <a href="./consultation-candidature" class="btn btn-success px-3 py-2 mb-2">Consulter sa candidature</a>
                                <?php if (is_application_valable()) { ?>
                                    <a href="./suivi" type="submit" id="btn2"  class="btn btn-primary px-3 py-2 mb-2">Modifier candidature</a>
                                    <a href="#" class="btn btn-danger px-3 py-2 mb-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop"   >Supprimer
                                        candidature</a>

                                <?php } ?>
                                <a href="./home" class="btn btn-dark px-3 py-2 mb-2">Accueil</a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


</div>

<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-danger" id="staticBackdropLabel">Supprimer la candidature ?</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <strong class="text-danger py-2">Êtes-vous supprimer votre candidature ?</strong>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Annuler</button>
                <a type="button" class="btn btn-danger" href="suivi.php?delete=1">Ouï</a>
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

