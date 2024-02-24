<?php
session_start();

require_once "inc/functions.php";


if (isset($_GET['logout'])) {
    unset($_SESSION['admin']);
}

if (isset($_POST['username'])) {
    extract($_POST);
    if ($username === 'admin' && $password === 'admin') {
        $_SESSION['admin'] = true;
    }else{
        alert("Identifiants invalides");
    }
}


if (isset($_POST['application_date'], $_POST['application_max_date'])) {
    extract($_POST);
    $database->prepare("UPDATE settings SET application_date=?, application_max_date=? WHERE id=1")->execute(array($application_date, $application_max_date));
    alert('Mise à jour réussi', 'success');
}

$application_date = get_application_date();

if (isset($_GET['column'])) {
    extract($_GET);
    if ($column === 'all') {
        $applications = get_inscrits();
    } elseif ($column === 'doublons') {
        $applications = get_doublons();
    } elseif ($column === 'omis') {
        $applications = get_omis();
    } elseif (isset($value)) {
        $applications = get_inscrit_par($column, $value);
    }

}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Administration</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>



<?php if (isset($_SESSION['admin'])) { ?>

    <h3 class="text-center mt-5">Administrateur</h3>

    <div class="row">
        <div class="col-8 offset-2">
            <div class="d-flex justify-content-between">
                <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop2">Paramètres
                    de la candidature </a>
                <a href="#" class="btn btn-danger" data-bs-toggle="modal"
                   data-bs-target="#staticBackdrop">Déconnexion</a>
                <a href="./statistic.php" class="btn btn-success" 
                   >graphe</a>
            </div>
        </div>
    </div>


    <div class="container mt-5 h5">
        <div class="row">
            <div class="col"><b>Total d’inscrit : </b><?php echo total_inscrit() ?> </div>
        </div>

        <hr>

        Nombre d'inscrits par nationalité
        <ul>
            <li><b>Togolais : </b><?php echo total_inscrit_par('nationality', 'Togolais') ?></li>
            <li><b>Beninois : </b><?php echo total_inscrit_par('nationality', 'Beninois') ?></li>
            <li><b>Ghaneen : </b><?php echo total_inscrit_par('nationality', 'Ghanen') ?></li>
            <li><b>Nigeriens : </b><?php echo total_inscrit_par('nationality', 'Nigeria') ?></li>
            <li><b>Camerounais : </b><?php echo total_inscrit_par('nationality', 'Camerounais') ?></li>
        </ul>

        <hr>
        Nombre d'inscrits par série
        <ul>
            <li><b>C : </b><?php echo total_inscrit_par('serie', 'C') ?></li>
            <li><b>D : </b><?php echo total_inscrit_par('serie', 'D') ?></li>
            <li><b>E : </b><?php echo total_inscrit_par('serie', 'E') ?></li>
            <li><b>F1 : </b><?php echo total_inscrit_par('serie', 'F1') ?></li>
            <li><b>F2 : </b><?php echo total_inscrit_par('serie', 'F2') ?></li>
        </ul>

        <hr>
        Nombre d'inscrits par sexe
        <ul>
            <li><b>Masculin : </b><?php echo total_inscrit_par('gender', 'M') ?></li>
            <li><b>Féminin : </b><?php echo total_inscrit_par('gender', 'F') ?></li>
        </ul>

        <hr>
        <br>
        <b>Liste des candidats</b>
        <ul>
            <li style="list-style: none"><b><a href="admin.php?column=all">Tous</a></b></li>
            <li style="list-style: none">
                Par nationalité
                <ul>
                    <li><a href="admin.php?column=nationality&value=Togolais">Togolais</a></li>
                    <li><a href="admin.php?column=nationality&value=Beninois">Beninois</a></li>
                    <li><a href="admin.php?column=nationality&value=Ghanen">Ghaneen</a></li>
                    <li><a href="admin.php?column=nationality&value=Nigeriens">Nigeriens</a></li>
                    <li><a href="admin.php?column=nationality&value=Camerounais">Camerounais</a></li>
                </ul>

                <hr>
                Par Sexe
                <ul>
                    <li><a href="admin.php?column=gender&value=M">Masculin</a></li>
                    <li><a href="admin.php?column=gender&value=F">Féminin</a></li>
                </ul>

                <hr>

                <a href="admin.php?column=doublons">Ayant double candidature</a>

                <hr>
                <a href="admin.php?column=omis">Ayant omis d’uploader un document</a>

            </li>
        </ul>

        <?php
        if (isset($applications)) {
            ?>
            <table class="table table-responsive" width="100%">
                <thead>
                <tr>
                    <th scope="col">nom</th>
                    <th scope="col">prénom</th>
                    <th scope="col">photo</th>
                    <th scope="col">date de naissance</th>
                    <th scope="col">sexe</th>
                    <th scope="col">nationalité</th>
                    <th scope="col">année d’obtention du BAC II</th>
                    <th scope="col">série</th>
                    <th scope="col">naissance</th>
                    <th scope="col">nationalité</th>
                    <th scope="col">attestation du BAC II</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($applications as $application) { ?>
                    <tr>
                        <td><?php echo $application->lastname ?></td>
                        <td><?php echo $application->firstname ?></td>
                        <td><img src="<?php echo $application->photo ?>" alt=""
                                 width="100px"></td>
                        <td><?php echo($application->date_of_birth) ?></td>
                        <td><?php echo $application->gender ?></td>
                        <td><?php echo $application->nationality ?></td>
                        <td><?php echo $application->year_of_bac2 ?></td>
                        <td><?php echo $application->serie ?></td>

                        <?php

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

                        <td><?php echo $n ?></td>
                        <td><?php echo $b ?></td>
                        <td><?php echo $n2 ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>


<?php } else { ?>
<div class="container my-5">
    <div class="row">
        <form class="col-md-6 col-12 offset-md-3" method="post">
            <div class="card">
                <div class="card-header text-center fw-bold text-primary fs-4">
                    Identifiez-vous
                </div>
                <div class="card-body">
                    <div class="form-floating mt-3">
                        <input type="text" name="username" id="username" class="form-control" placeholder=" " required>
                        <label for="username">Nom d'utilisateur</label>
                    </div>
                    <div class="form-floating mt-3">
                        <input type="password" name="password" id="password" class="form-control" placeholder=" "
                               required>
                        <label for="password">Mot de passe</label>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <button class="btn btn-success px-5 py-2">Se connecter</button>
                </div>
            </div>
        </form>
    </div>
    <?php } ?>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-danger" id="staticBackdropLabel">Se déconnecter ?</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <strong class="text-danger py-2">Êtes-vous sûr de fermer cette session ?</strong>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Annuler</button>
                    <a type="button" class="btn btn-danger" href="admin.php?logout=1">Ouï</a>
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


    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-danger" id="staticBackdropLabel">Se déconnecter ?</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <strong class="text-danger py-2">Êtes-vous sûr de fermer cette session ?</strong>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Annuler</button>
                    <a type="button" class="btn btn-danger" href="home.php?logout=1">Ouï</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop2" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" method="post">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-primary" id="staticBackdropLabel">Paramètres</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating mt-3">
                        <input type="date" name="application_date" id="application_date" class="form-control"
                               placeholder=" " required value="<?php echo $application_date->application_date ?>">
                        <label for="date">Date du concours</label>
                    </div>

                    <div class="form-floating mt-3">
                        <input type="date" name="application_max_date" id="application_max_date" class="form-control"
                               placeholder=" " required value="<?php echo $application_date->application_max_date ?>">
                        <label for="username">Date limite du concours</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/forms.js"></script>

</body>
</html>

