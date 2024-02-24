<?php
session_start();

require_once "inc/functions.php";

if (isset($_SESSION['username'])) {
    header('location:home');
}

if (isset($_POST['action'])) {
    extract($_POST);

    global $database;

    if ($action === 'register') {

        if (checkUsername($username) === null) {
            $query = $database->prepare("INSERT INTO users (username, password) VALUES(?,?)");
            $ok = $query->execute(array($username, password_hash($password, PASSWORD_BCRYPT)));
            if ($ok) {
                $_SESSION['username'] = $username;
                header('location:home');
            } else {
                alert("Une erreur s'est produite");
            }
        } else {
            alert("Ce nom d'utilisateur existe déjà ! ");
        }

    } elseif ($action === 'login') {

        $user = checkUsername($username);
        if ($user !== null && password_verify($password, $user->password)) {
            $_SESSION['username'] = $username;
            header('location:home');
        } else {
            alert("Identifiants invalides");
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/home.css">
    <title>page de connexion </title>
</head>

<body>

<div class="ct" id="ct">


    <div class="form-ct sign-up">
        <form action="" method="post">
            <h1>Suivre</h1>
            <div class="social-icons">
                <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
            </div>
            <span>ou connectez-vous</span>


            <input type="hidden" name="action" value="login">
            <input type="text" name="username" placeholder="nom d'utilisateur" class="form-control"
                   value="<?php echo $username ?? '' ?>" required><br>
            <input type="password" name="password" placeholder="mot de passe" class="form-control"
                   required><br>

            <button type="submit">connexion</button>
        </form>
    </div>
    <div class="form-ct sign-in">
        <form action="" method="post">
            <h1>Suivre</h1>
            <div class="social-icons">
                <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#" class="icon"><i class="fa-brands fa-github"></i></a>
                <a href="#" class="icon"><i class="fa-brands fa-linkedin-in"></i></a>
            </div>
            <h2>Ou inscrivez-vous</h2>


            <input type="hidden" name="action" value="register">
            <input type="text"
                   name="username"
                   class="form-control"
                   value="<?php echo $username ?? '' ?>"
                   placeholder="nom d'utilisateur" required><br>

            <input type="password"
                   name="password"
                   class="form-control"
                   value="<?php echo $password ?? '' ?>"
                   placeholder="mot de passe" required><br>
            <input type="password"
                   name="confirm"
                   class="form-control"
                   value="<?php echo $confirm ?? '' ?>"
                   placeholder="confirmez votre mot de passe" required><br>
            <button type="submit">s'inscrire</button>
        </form>
    </div>
    <div class="toggle-ct">
        <div class="toggle">
            <div class="toggle-panel toggle-left">
                <h1>Bon retour parmi nous !</h1>
                <p>Entre tes informations personnelles</p>
                <button class="hidden" id="login">Creer</button>
            </div>
            <div class="toggle-panel toggle-right">
                <h1>Bienvenue, l'ami !</h1>
                <p>Entre tes informations personnelles</p>
                <button class="hidden" id="register">Se connecter</button>
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

