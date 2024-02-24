<?php
session_start();

require_once "inc/functions.php";

if (isset($_GET['logout'])) {
    unset($_SESSION['username']);
}

if (!isset($_SESSION['username'])) {
    header('location:.');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/information.css">
    <style>
        /* CSS global */

        * {
            margin: 0;
            padding: 0;
            /* box-sizing: border-box; */
        }

        body {
            /* background: linear-gradient(#084f25, #d2d20e, rgb(198, 199, 191)); */
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            background-size: cover;
            line-height: 1.5;
        }

        html {
            font-size: 62.5%;
            scroll-behavior: smooth;
            scroll-padding-top: 9px;
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #ccc;
        }

        h1 {
            font-size: 2.6rem;
        }

        h2 {
            font-size: 4.8rem;
        }

        h3 {
            font-size: 3rem;
        }

        h4, h5 {
            font-size: 2.8rem;
        }

        li {
            font-size: 2rem;
        }

        a {
            color: #ffffff;
            text-decoration: none;
            border: 1px;

        }

        a:hover {
            color: #ece640;
        }

        section {
            margin-top: 50px;
        }

        /*HEADER*/

        header {
            background: #0a2b19;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .main-head {
            /* background: #0a2b19; */
            color: #ffffff;
        }

        nav {
            min-height: 10vh;
            display: flex;
            align-items: center;
            width: 98%;
            margin: auto;
            padding: 1rem;
            /* position: fixed; */
        }

        nav ul {
            display: flex;
            flex: 1 1 40rem;
            /* justify-content: space-around; */
            padding-left: 19%;
            align-items: center;
            list-style: none;
        }

        header .logos a {
            font-size: 15px;
            color: #fff;
            text-decoration: 0;
        }

        header .logos a span {
            color: yellow;
            font-size: 35px;
        }

        ul li {
            padding-left: 40px;
        }

        .btn-con {
            color: aquamarine;
            font-size: 20px;
            border: 2px solid aquamarine;
            padding: 5px 20px;
            transition: 0.5tts;
        }

        .btn-con:hover {
            background-color: aquamarine;
            color: #000;
            font-weight: bold;
        }

        /* Accueil CSS */

        #home {
            background: linear-gradient(rgba(0, 0, 0, 0.1), #333), url("img/drapeau.jpg");
            background-position: center;
            height: calc(100vh - 50px);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            position: relative;
            /* bottom: 10%; */
            color: #ffffff;
        }

        .btn {
            margin-bottom: 20px;
        }

        #home p {
            font-size: 50px;
            font-weight: bold;
        }

        #home h1 {
            font-size: 100px;
            line-height: 120px;
            margin-left: -3px;
            color: transparent;
            -webkit-text-stroke: 1px #0a2b19;
            background: url('img/verte j.jpeg');
            -webkit-background-clip: text;
            background-position: 0 0;
            animation: animate 18s linear 2s infinite alternate;
        }

        @keyframes animate {
            100% {
                background-position: -500px 0;
            }
        }

        #home h3 {
            font-size: 40px;
            font-weight: 500;
        }

        #home .row {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 40px;
        }

        /* .row a {
            font-size: 18px;
            display: flex;
            align-items: center;
            padding: 5px 20px;
            text-decoration: none;
            color: #0a2b19;
            border: 1px solid #0a2b19;
            margin-right: 10%;
            transition: 0.3s;
        } */

        div a {
            margin-right: 25%;
        }

        .row a:hover {
            background-color: #ece640;
            color: #0a2b19;
        }

        #home span {
            font-size: 18px;
        }

        /* A propos CSS */

        #propos {
            /* margin-top: 0px; */
            /* margin-bottom: 30px; */
            /* padding: 0 10%; */
            width: 100%;
            padding: 0 5%;
            margin-bottom: 50px;
            height: 90vh;
        }

        .title {
            text-transform: capitalize;
            margin: 60px 0;
            font-weight: bold;
            color: darkgreen;
            position: relative;
            margin-left: 50px;
            font-size: 35px;
        }

        .title::after {
            position: absolute;
            left: -15px;
            content: "";
            height: 100%;
            background-color: #000;
            width: 5px;
        }

        .img-desc {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }

        .img-desc .left {
            position: relative;
            margin-left: 10px;
            height: 260px;
            width: 35%;
        }

        .img-desc .right {
            width: 60%;
        }

        .img-desc .left img {
            width: 100%;
            height: 100%;
            position: relative;
            box-shadow: 0 0 10px green;
        }

        .img-desc .left::after {
            position: absolute;
            bottom: -5px;
            right: 0px;
            left: 5px;
            content: "";
            height: 100%;
            background-color: #000;
            width: 100%;
            z-index: -1;
        }

        /*
        .img-desc .right h3{
            color: #000;
            font-size: 25px;
            margin-bottom: 185px;
        } */

        .img-desc .right p {
            color: #999;
            font: 200px;
            margin-bottom: 5px;
            font-size: 20px;
        }

        .img-desc .right a {
            border: 1px solid darkgreen;
            /* padding-top: 150px; */
            color: darkgreen;
            font-size: 14px;
            padding: 8px 25px;
            font-weight: bold;
        }

        /* Contact CSS */

        #contact {
            padding: 0 4%;
            margin-bottom: 50px;
            height: 90vh;
        }

        #contact form {
            background-color: #ffffff;
            margin: auto;
            display: flex;
            flex-direction: column;
            padding: 10px;
        }

        .left-right {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .left-right .left, .left-right .right {
            display: flex;
            flex-direction: column;
            width: 49%;
        }

        #contact form label {
            font-size: 14px;
            padding: 10px 0;
            font-weight: 600;
        }

        #contact form input {
            padding: 8px;
            outline: 0;
            border: 1px solid #999;
        }

        textarea {
            height: 150px;
            resize: none;
            outline: 0;
            width: 100%;
            padding: 10px;
        }

        #contact form input:focus, textarea:focus {
            border: 1px solid darkgreen;
        }

        iframe {
            height: 150px;
            width: 100%;
        }

        #contact button {
            width: fit-content;
            padding: 8px 40px;
            background-color: #111;
            border: 1px solid #111;
            color: #fff;
            cursor: pointer;
            transition: 0.5s;
        }

        #contact button:hover {
            letter-spacing: 1px;
        }

        /* Responsive */
        @media (max-width: 750px) {
            header .menu {
                display: none;
            }

            /* Home responsive */
            #home h2 {
                font-size: 18px;
                -webkit-text-stroke: 0;
                color: fff;
            }

            #home h4 {
                font-size: 28px;
            }

            #home p {
                text-align: center;
                font-size: 10px;
            }

        }

        .contain {
            max-width: 95%;
            margin: auto;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
        }

        ul {
            list-style: none;
        }

        .footer {
            background-color: rgb(255, 255, 124);
            padding: 70px 0;
        }

        .footer-col {
            width: 22%;
            padding: 0 10px;
        }

        .footer-col h4 {
            font-size: 18px;
            color: hsl(134, 64%, 12%);
            text-transform: capitalize;
            margin-bottom: 35px;
            font-weight: 500;
            position: relative;
        }

        .footer-col h4::before {
            content: "";
            position: absolute;
            left: 0;
            bottom: -10px;
            background-color: #ece640;
            height: 2px;
            box-sizing: border-box;
            width: 50px;
        }

        .footer-col ul li:not(:last-child) {
            margin-bottom: 10px;
        }

        .footer-col ul li a {
            font-size: 16px;
            text-transform: capitalize;
            color: #000000;
            text-decoration: none;
            font-weight: 300;
            color: #000000;
            display: block;
            transition: all 0.3s ease;
        }

        .footer-col ul li:hover {
            color: #ffffff;
            padding-left: 8px;
        }

        .footer-col .social-links a {
            display: inline-block;
            height: 40px;
            width: 40px;
            background-color: rgba(255, 255, 255, 0.2);
            margin: 0 10px 0 10px;
            text-align: center;
            line-height: 40px;
            border-radius: 50%;
        }

        .footer-col .social-links a:hover {
            color: #24262b;
            background-color: #ffffff;
        }

        /* responsive */


        @media (max-width: 767px) {
            .footer-col {
                width: 50%;
                margin-bottom: 30px;
            }
        }

        @media (max-width: 574px) {
            .footer-col {
                width: 100%;
            }
        }

    </style>
    <title>Page d'acceuil</title>
</head>
<body>
<header class="main-head">
    <nav>
        <div class="logos">
            <a href="/"><h1 id="logo"><span>IAI-Togo</span></h1></a>
        </div>
        <ul class="menu">
            <li><a href="./home">Acceuil</a></li>
            <li><a href="./about">A propos</a></li>
            <li><a href="./information">description</a></li>
            <li><a href="./contact">Contact</a></li>

            <li><a href="#" class="fst-italic"><?php echo $_SESSION['username']; ?></a></li>

            <li><a href="#" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="btn-con">Déconnexion</a></li>
        </ul>
    </nav>
</header>

<!-- Section accueil -->
<section id="home">
    <p>Soit la bienvenue !</p>
    <h1>IAI-Togo</h1>
    <h4>Site de concours de l'Institut Africain Informatique du Togo</h4>

    <?php if (!is_application_valable()) { ?>
        <div class="p-3 px-5 bg-danger mx-auto">
            <h5>
                La date limite des candidatures est atteinte.
            </h5>
        </div>

    <?php } ?>

    <div class="row">
        <?php if ((checkUserCandidature($_SESSION['username']) === null)) {
            if (is_application_valable()) { ?>
                <a href="./candidature.php" class="btn-con btn">Postuler au concours</a>
            <?php }
        } else { ?>
            <a href="./suivi" class="btn-con btn">Consulter candidature</a>
        <?php } ?>
    </div>
</section>

<!-- Footer -->

<footer class="footer">
    <div class="contain">
        <div class="row">
            <div class="footer-col">
                <h4>Contact</h4>
                <ul>
                    <li><a href="#">iaitogo@iai-togo.tg</a></li>
                    <li><a href="#">(00228) 22 20 47 00</a></li>
                    <li><a href="#">59 rue de la Kozah Nyékonakpoè <br> 07 BP:12456 Lomé 07, Togo</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>A propos</h4>
                <ul>
                    <li><a href="#">Newsletter</a></li>
                    <li><a href="#">Contact & Support</a></li>
                    <li><a href="#">Paramètres et confidentialité</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Liens rapides</h4>
                <ul>
                    <li><a href="#">Inscription</a></li>
                    <li><a href="#">Concours d'entrée à IAI-TOGO</a>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Suivez-nous sur</h4>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
        </div>
    </div>
</footer>


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

<script>
    $(document).ready(function () {

        $('i.icon').click(function () {
            $('.nav-list').slideToggle()
        });
    })
</script>
</body>
</html>
