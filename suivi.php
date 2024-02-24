<?php
session_start();

require_once "inc/functions.php";


$old_application = checkUserCandidature($_SESSION['username']);

if (isset($_GET['delete'])) {
    global $database;
    $ok = $database->prepare('delete from applications where id=?')->execute(array($old_application->id));
    if ($ok) {
        header('location:home');
    } else {
        alert("Une erreur s'est produite");
    }

}

if (!isset($_SESSION['username']) || ($old_application === null)) {
    header('location:home');
}

if (!is_application_valable()) {
    header('location:home');
}

if (isset($_POST['submit'])) {

    extract($_POST);
    global $database;

    if (!is_application_valable()) {
        header('location:suivi');
    }


    $photo = upload_file('photo') ?? $old_application->photo;
    $naissance_pdf = upload_file('naissance_pdf') ?? $old_application->naissance_pdf;
    $bac2_pdf = upload_file('bac2_pdf') ?? $old_application->bac2_pdf;
    $nationality_pdf = upload_file('nationality_pdf') ?? $old_application->nationality_pdf;

    $query = $database->prepare("UPDATE applications SET lastname=?, firstname=?, photo=?, date_of_birth=?, gender=?, nationality=?, year_of_bac2=?, serie=?, naissance_pdf=?, bac2_pdf=?, nationality_pdf=? WHERE id=?");
    $ok = $query->execute(array($lastname, $firstname, $photo, $date_of_birth, $gender, $nationality, $year_of_bac2, $serie,
        $naissance_pdf, $bac2_pdf, $nationality_pdf, $old_application->id));
    if ($ok) {
        alert("Votre candidature a été bien mis à jour", 'success');
    } else {
        alert("Une erreur s'est produite");
    }
}

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
        <div class="col-md-6 col-12 offset-md-3">
            <div class="card">
                <div class="card-header">
                    <h2 class="text-center">Candidature</h2>
                </div>
                <div class="card-body">
                    <form action="" method="post" class="row vstack gap-3" enctype="multipart/form-data">

                        <div class="input-group">
                            <label for="lastname" class="input-group-text"><i class="fa-regular fa-user"></i>
                                Nom</label>
                            <input type="text" name="lastname" required="required" class="form-control" id="lastname"
                                   value="<?php echo $old_application->lastname ?>">
                        </div>
                        <div class="input-group">
                            <label for="firstname" class="input-group-text"> <i class="fa-regular fa-user"></i>
                                Prénom</label>
                            <input type="text" name="firstname" required="required" class="form-control" id="firstname"
                                   value="<?php echo $old_application->firstname ?>">

                        </div>
                        <div class="input-group">
                            <label for="photo" class="input-group-text">Photo</label>
                            <input type="file" accept=".jpg,.png,.jpeg" name="photo"
                                   class="form-control" value="<?php echo $old_application->photo ?>"
                                   id="photo">
                        </div>
                        <div class="input-group">
                            <label for="date_of_birth" class="input-group-text">Date de naissance</label>
                            <input type="date" name="date_of_birth" required="required" class="form-control"
                                   id="date_of_birth"
                                   value="<?php echo $old_application->date_of_birth ?>"
                                   max='2010-01-01'>
                        </div>
                        <div class="input-group">
                            <label class="input-group-text" for="gender">Sexe</label>
                            <select name="gender" required class="form-select" id="gender">
                                <option value=""> ---</option>
                                <option value="M" <?php echo ($old_application->gender === 'M') ? 'selected' : '' ?> >
                                    Masculin
                                </option>
                                <option value="F" <?php echo ($old_application->gender === 'F') ? 'selected' : '' ?> >
                                    Féminin
                                </option>
                            </select>
                        </div>
                        <div class="input-group">
                            <label class="input-group-text" for="nationality">Nationalité</label>
                            <select name="nationality" class="form-select" id="nationality" required>
                                <option value=""> ---</option>
                                <option value="Togolais" <?php echo ($old_application->nationality === 'Togolais') ? 'selected' : '' ?>>
                                    Togolais
                                </option>
                                <option value="Beninois" <?php echo ($old_application->nationality === 'Beninois') ? 'selected' : '' ?>>
                                    Beninois
                                </option>
                                <option value="Ghanen" <?php echo ($old_application->nationality === 'Ghanen') ? 'selected' : '' ?>>
                                    Ghaneen
                                </option>
                                <option value="Nigeria" <?php echo ($old_application->nationality === 'Nigeria') ? 'selected' : '' ?>>
                                    Nigeriens
                                </option>
                                <option value="Camerounais" <?php echo ($old_application->nationality === 'Camerounais') ? 'selected' : '' ?>>
                                    Camerounais
                                </option>
                            </select>
                        </div>
                        <div class="input-group">
                            <label class="input-group-text" for="year_of_bac2">Année d'obtention du BAC</label>
                            <input type="number" name="year_of_bac2" class="form-control"
                                   max=2024 min=2021 id="year_of_bac2" required
                                   value=<?php echo $old_application->year_of_bac2 ?>>
                        </div>
                        <div class="input-group">
                            <label class="input-group-text" for="serie">Série du BAC</label>
                            <select class="form-select" id="serie" name="serie" required>
                                <option value=""> ---</option>
                                <option value="C" <?php echo ($old_application->serie === 'C') ? 'selected' : '' ?>>C
                                </option>
                                <option value="D" <?php echo ($old_application->serie === 'D') ? 'selected' : '' ?>>D
                                </option>
                                <option value="E" <?php echo ($old_application->serie === 'E') ? 'selected' : '' ?>>E
                                </option>
                                <option value="F1" <?php echo ($old_application->serie === 'F1') ? 'selected' : '' ?>>
                                    F1
                                </option>
                                <option value="F2" <?php echo ($old_application->serie === 'F2') ? 'selected' : '' ?>>
                                    F2
                                </option>
                            </select>
                        </div>
                        <div class="input-group">
                            <label class="input-group-text" for="naissance_pdf">Naissance</label>
                            <input type="file" accept=".pdf" name="naissance_pdf" class="form-control"
                                   id="naissance_pdf" value="<?php echo $old_application->naissance_pdf ?>">
                        </div>
                        <div class="input-group">
                            <label for="nationality_pdf" class="input-group-text">Nationnalité</label>
                            <input type="file" accept=".pdf" name="nationality_pdf"
                                   class="form-control" id="nationality_pdf"
                                   value="<?php echo $old_application->nationality_pdf ?>">
                        </div>
                        <div class="input-group">
                            <label for="bac2_pdf" class="input-group-text">Attestation du BAC II</label>
                            <input type="file" accept=".pdf" name="bac2_pdf"
                                   class="form-control" id="bac2_pdf" value="<?php echo $old_application->bac2_pdf ?>">
                        </div>

                        <div class="p-5">
                            <div class="row vstack gap-2">

                                <?php if (is_application_valable()) { ?>
                                    <input type="submit" id="btn2" name="submit" value="Mettre à jour ma candidature"
                                           class="btn btn-success px-3 py-2 mb-2"/>

                                <?php } ?>
                                <a href="./gestion-candidature" class="btn btn-primary px-3 py-2 mb-2">Retour</a>
                            </div>
                        </div>
                    </form>

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

