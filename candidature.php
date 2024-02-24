<?php
session_start();


require_once "inc/functions.php";

if (!isset($_SESSION['username'])) {
    header('location:.');
}

if (!is_application_valable()) {
    header('location:home');
}

if (isset($_POST['submit'])) {
    extract($_POST);
    global $database;

    $photo = upload_file('photo');
    $naissance_pdf = upload_file('naissance_pdf');
    $bac2_pdf = upload_file('bac2_pdf');
    $nationality_pdf = upload_file('nationality_pdf');

    $user = checkUsername($_SESSION['username']);
    $query = $database->prepare("INSERT INTO applications( lastname, firstname, photo, date_of_birth, gender, nationality, year_of_bac2, serie,
                          naissance_pdf, bac2_pdf, nationality_pdf, user_id) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
    $ok = $query->execute(array($lastname, $firstname, $photo, $date_of_birth, $gender, $nationality, $year_of_bac2, $serie,
        $naissance_pdf, $bac2_pdf, $nationality_pdf, $user->id));
    if ($ok) {
        alert('Enregistrement réussi');
        echo "<script>location.href='./gestion-candidature'</script>";
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
                            <input type="text" name="lastname" required="required" class="form-control" id="lastname">
                        </div>
                        <div class="input-group">
                            <label for="firstname" class="input-group-text"> <i class="fa-regular fa-user"></i>
                                Prénom</label>
                            <input type="text" name="firstname" required="required" class="form-control" id="firstname">

                        </div>
                        <div class="input-group">
                            <label for="photo" class="input-group-text">Photo</label>
                            <input type="file" accept=".jpg,.png,.jpeg" name="photo" required="required"
                                   class="form-control"
                                   id="photo">
                        </div>
                        <div class="input-group">
                            <label for="date_of_birth" class="input-group-text">Date de naissance</label>
                            <input type="date" name="date_of_birth" required="required" class="form-control"
                                   id="date_of_birth"
                                   max='2010-01-01'>
                        </div>
                        <div class="input-group">
                            <label class="input-group-text" for="gender">Sexe</label>
                            <select name="gender" required class="form-select" id="gender">
                                <option value=""> ---</option>
                                <option value="M">Masculin</option>
                                <option value="F">Féminin</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <label class="input-group-text" for="nationality">Nationalité</label>
                            <select name="nationality" class="form-select" id="nationality" required>
                                <option value=""> ---</option>
                                <option value="Togolais">Togolais</option>
                                <option value="Beninois">Beninois</option>
                                <option value="Ghanen">Ghaneen</option>
                                <option value="Nigeria">Nigeriens</option>
                                <option value="Camerounais">Camerounais</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <label class="input-group-text" for="year_of_bac2">Année d'obtention du BAC</label>
                            <input type="number" name="year_of_bac2" class="form-control"
                                   max=2024 min=2021 id="year_of_bac2" required>
                        </div>
                        <div class="input-group">
                            <label class="input-group-text" for="serie">Série du BAC</label>
                            <select class="form-select" id="serie" name="serie" required>
                                <option value=""> ---</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                                <option value="F1">F1</option>
                                <option value="F2">F2</option>
                            </select>
                        </div>
                        <div class="input-group">
                            <label class="input-group-text" for="naissance_pdf">Naissance</label>
                            <input type="file" accept=".pdf" name="naissance_pdf" class="form-control"
                                   id="naissance_pdf">
                        </div>
                        <div class="input-group">
                            <label for="nationality_pdf" class="input-group-text">Nationnalité</label>
                            <input type="file" accept=".pdf" name="nationality_pdf"
                                   class="form-control" id="nationality_pdf">
                        </div>
                        <div class="input-group">
                            <label for="bac2_pdf" class="input-group-text">Attestation du BAC II</label>
                            <input type="file" accept=".pdf" name="bac2_pdf"
                                   class="form-control" id="bac2_pdf">
                        </div>

                        <div class="text-center">
                            <input type="submit" id="btn2" name="submit" value="Postuler"
                                   class="btn btn-success px-5 py-2"/>
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

