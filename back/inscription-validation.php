<?php

// Afficher les erreurs à l'écran
ini_set('display_errors', 1);
// Afficher les erreurs et les avertissements
error_reporting(E_ALL);

// insertion en bdd
if(isset($_POST["valid"])){
	if(isset($_POST["bca-mail"]) && $_POST["bca-mail"]!=''){
		require_once('env.php');
        $mail = $_POST["bca-mail"];
        // verif si mail existe pas déjà
		$selectall = $db->query('SELECT * FROM user WHERE mail="'.$mail.'"');
        $result = $selectall->fetch();
        $counttable = count((is_countable($result)?$result:[]));
        if($counttable==0){
            $res = $db->prepare('INSERT INTO user (mail,password) VALUES(:mail,:password)');
            $pwd = password_hash($_POST['bca-pwd'],PASSWORD_DEFAULT);
		    $res->execute(array('mail' => $_POST["bca-mail"],'password' => $pwd));
            $return = "Inscription validée !";
        }
        else{
            $return = '<span style="color:red">Mail déjà inscrit</span>';
        }		
    }
	else{
		$return = '<span style="color:red">Veuillez préciser un mail</span>';
	}
}
else{
	$return = '<span style="color:red">Formulaire non validé</span>';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<title>Espilon</title>
	<meta name="description" content="Epsilon">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
	<link rel="stylesheet" href="epsilon.css">
	<link href="assets/css/all.css" rel="stylesheet">
	<link href="assets/css/fontawesome.css" rel="stylesheet">
	<link href="assets/css/brands.css" rel="stylesheet">
	<link href="assets/css/solid.css" rel="stylesheet">
	<script defer src="assets/js/all.js"></script>
	<script defer src="assets/js/brands.js"></script>
	<script defer src="assets/js/solid.js"></script>
	<script defer src="assets/js/fontawesome.js"></script>
    <style type="text/css">
        #retour{float: left;}
        #return>a{color: rgb(70, 114, 70); text-decoration: none;}
        table{margin: auto;}
        td{float: left;}
        .label{min-width: 8em; text-align: left}
    </style>
</head>
<body>

<div class="container">
    <header>
        <nav>
            <ul id="connection">
                <a href="connexion.php"><i class="fas fa-sign-in-alt"></i> Connexion</a>
            </ul>
        </nav>
        <div class="cleared"></div>

        <h1><?php echo $return ?></h1>
    </header>

    <section>
        <ul id="retour">
            <li id="return">
                <a href="index.php">Retour</a></li>
        </ul>
    </section>

</div>
    
</body>
</html>