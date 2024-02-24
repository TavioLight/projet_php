<?php


use Random\RandomException;

$db_host = 'localhost';
$db_name = 'utilisateurs';
$db_user = 'root';
$db_password = '';
$database = new PDO ("mysql:host=$db_host;dbname=$db_name", $db_user, $db_password);


/**
 * Vérifie si le nom d'utilisateur est déjà utilisé et retourne null si ce n'est pas déjà pris
 * @param $username string
 * @return mixed|null
 */
function checkUsername($username)
{
    global $database;
    $query = $database->prepare("select * from users where username=? limit 1");
    $query->execute([$username]);
    $data = $query->fetchAll(PDO::FETCH_OBJ);
    return $data[0] ?? null;
}


function upload_file($key)
{
    $uploads_dir = dirname('./') . '/uploads';

    $tmp_name = $_FILES[$key]["tmp_name"];

    if (file_exists($tmp_name)) {
        $name = random_int(111_111_111, 999_999_999) . substr($_FILES[$key]["name"], -10);
        $file_path = "$uploads_dir/$name";
        move_uploaded_file($tmp_name, $file_path);
        return $file_path;
    } else {
        return null;
    }

}


/**
 * Mis en cache du message pour le js
 * @param $message string
 * @param $type string
 * @return void
 */
function alert($message, $type = 'danger')
{
    echo "<script>
    
    localStorage.setItem('message', '$message');
    localStorage.setItem('type', '$type');
   
    </script> ";

}

function checkUserCandidature($username)
{
    global $database;
    $query = $database->prepare("select a.* from users u inner join applications a on u.id = a.user_id where username=? limit 1");
    $query->execute([$username]);
    $data = $query->fetchAll(PDO::FETCH_OBJ);
    return $data[0] ?? null;
}

function total_inscrit()
{
    global $database;
    $query = $database->prepare("select count(*) as total_inscrit from applications");
    $query->execute();
    $data = $query->fetchAll(PDO::FETCH_OBJ);
    return $data[0]->total_inscrit ?? 0;
}

function total_inscrit_par($column, $value)
{
    global $database;
    $data = $database->query("select count(*) as total from applications where $column='$value'")->fetchAll(PDO::FETCH_OBJ);
    return $data[0]->total ?? 0;
}


function get_inscrits()
{
    global $database;
    return $database->query("select * from applications")->fetchAll(PDO::FETCH_OBJ) ?? [];
}

function get_doublons()
{
    global $database;
    return $database->query("SELECT lastname,
       firstname,
       max(id) as id,
       max(photo) as photo,
       max(date_of_birth) as date_of_birth,
       max(gender) as gender,
       max(nationality) as nationality,
       max(year_of_bac2) as year_of_bac2,
       max(serie) as serie,
       max(naissance_pdf) as naissance_pdf,
       max(bac2_pdf) as bac2_pdf,
       max(nationality_pdf) as nationality_pdf,
       max(user_id) as user_id
FROM applications
group by lastname, firstname, date_of_birth having count(*)>1")->fetchAll(PDO::FETCH_OBJ) ?? [];
}

function get_omis()
{
    global $database;
    return $database->query("select * from applications where (bac2_pdf is null or bac2_pdf='') or (nationality_pdf is null or nationality_pdf='') or (naissance_pdf is null or naissance_pdf='')")->fetchAll(PDO::FETCH_OBJ) ?? [];
}

function get_inscrit_par($column, $value)
{
    global $database;
    return $database->query("select * from applications where $column='$value'")->fetchAll(PDO::FETCH_OBJ);
}

function get_application_date()
{
    global $database;
    $data = $database->query("SELECT id, application_date, application_max_date FROM settings")->fetchAll(PDO::FETCH_OBJ)[0] ?? null;
    if ($data === null) {
        try {
            $database->query("insert into settings (id,application_date, application_max_date) values (1,CURRENT_DATE,CURRENT_DATE)")->execute();
        } catch (Exception $e) {
            return $database->query("SELECT id, application_date, application_max_date FROM settings")->fetchAll(PDO::FETCH_OBJ)[0];
        }
    }
    return $database->query("SELECT id, application_date, application_max_date FROM settings")->fetchAll(PDO::FETCH_OBJ)[0];
}

function is_application_valable()
{
    $application_date = get_application_date();
    return $application_date->application_max_date >= date('Y-m-d');
}