
<?php
session_start() ;
require "../db.class.php" ;
$DB = new DB() ;
$erreur = false ;
if(isset($_POST["valider"])) {
    $_SESSION["firstname"]=$DB->securiteForm($_POST['firstname']);
    $_SESSION["lastname"]=$DB->securiteForm($_POST['lastname']);
    $_SESSION["age"]=$DB->securiteForm($_POST['age']);
    $_SESSION["telephone"]=$DB->securiteForm($_POST['telephone']);
    $_SESSION["adresse"]=$DB->securiteForm($_POST['adresse']);
    $_SESSION["email"]=$DB->securiteForm($_POST['email']);
    $_SESSION["etat_civil"]=$DB->securiteForm($_POST['etat_civil']);
    $_SESSION["document"]=$DB->securiteForm($_POST['document']);
    $_SESSION["nombre_copie"]=$DB->securiteForm($_POST['nombre_copie']);
}
if(isset($_POST["terminer"])) {
    if(!empty($_POST["numero_registre"]) && !empty($_POST["annee_enregistrement"]) && $_SESSION["document"]=="extrait naissance" && !empty($_SESSION["etat_civil"])){
        $etat_civil = $_SESSION["etat_civil"] ;
        $document = $_SESSION["document"] ;
        $requete_document_prepare = $DB->prepare("SELECT * FROM document as dc, type_document as td, etat_civil as ec  
        WHERE dc.fk_idtype_document = td.idtype_document
        AND td.libelle_type_document = '$document' 
        AND ec.idetat_civil=dc.fk_idetat_civil_document
        AND ec.libelle_etat_civil = '$etat_civil'") ;
        $requete_document_prepare->execute() ;
        $documents = $DB->fetchallobject($requete_document_prepare) ;
        foreach($documents as $document) {
            $numero_registre = $document->numero_registre ;
            $annee_enregistrement = $document->annee_enregistrement ;
            if($numero_registre == $_POST["numero_registre"]  && $annee_enregistrement == $_POST["annee_enregistrement"]) {
                $_SESSION["numero_registre"] = $_POST["numero_registre"];
                $_SESSION["annee_enregistrement"] = $_POST["annee_enregistrement"] ;
                $_SESSION['correcte'] = "extrait naissance" ;
                header("location:correcte.php") ;
            } else{$erreur = true ;}
        }

    }elseif(!empty($_POST["numero_registre"]) && !empty($_POST["annee_enregistrement"]) && $_SESSION["document"]=="certificat mariage"){
        $etat_civil = $_SESSION["etat_civil"] ;
        $document = $_SESSION["document"] ;
        $requete_document_prepare = $DB->prepare("SELECT * FROM doc_etat_civil as dc, type_doc_etat_civil as td, etat_civil as ec  
        WHERE dc.fk_idtype_doc = td.idtype_doc 
        AND td.libelle_doc = '$document' 
        AND ec.idetat_civil=dc.fk_idetat_civil
        AND ec.libelle_etat_civil = '$etat_civil'") ;
        $requete_document_prepare->execute() ;
        $documents = $DB->fetchallobject($requete_document_prepare) ;
        foreach($documents as $document) {
            $numero_registre = $document->numero_registre ;
            $annee_enregistrement = $document->annee_enregistrement ;
            $cni = $document->cni ;
            if($numero_registre == $_POST["numero_registre"] && $annee_enregistrement == $_POST["annee_enregistrement"]) {
                $_SESSION["numero_registre"] = $_POST["numero_registre"];
                $_SESSION["annee_enregistrement"] = $_POST["annee_enregistrement"] ;
                $_SESSION['correcte'] = "certificat mariage" ;
                header("location:correcte.php") ;
            } else{$erreur = true ;}
        }

    }elseif(!empty($_POST["numero_registre"]) && !empty($_POST["annee_enregistrement"]) && $_SESSION["document"]=="certificat deces"){
        $etat_civil = $_SESSION["etat_civil"] ;
        $document = $_SESSION["document"] ;
        $requete_document_prepare = $DB->prepare("SELECT * FROM document as dc, type_document as td, etat_civil as ec  
        WHERE dc.fk_idtype_document = td.idtype_document
        AND td.libelle_type_document = '$document' 
        AND ec.idetat_civil=dc.fk_idetat_civil_document
        AND ec.libelle_etat_civil = '$etat_civil'") ;
        $requete_document_prepare->execute() ;
        $documents = $DB->fetchallobject($requete_document_prepare) ;
        foreach($documents as $document) {
            $numero_registre = $document->numero_registre ;
            $annee_enregistrement = $document->annee_enregistrement ;
            if($numero_registre == $_POST["numero_registre"] && $annee_enregistrement == $_POST["annee_enregistrement"]) {
                $_SESSION["numero_registre"] = $_POST["numero_registre"];
                $_SESSION["annee_enregistrement"] = $_POST["annee_enregistrement"] ;
                $_SESSION['correcte'] = "certificat deces" ;
                header("location:correcte.php") ;
            } else{$erreur = true ;}
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="../assets-doc/img/apple-icon.png">
	<link rel="icon" type="image/png" href="../assets-doc/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>plateforme</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

	<!--     Fonts and icons     -->
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.css" rel="stylesheet">

	<!-- CSS Files -->
    <link href="../assets-doc/css/bootstrap.min.css" rel="stylesheet" />
	<link href="../assets-doc/css/gsdk-bootstrap-wizard.css" rel="stylesheet" />

	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link href="../assets-doc/css/demo.css" rel="stylesheet" />

    <!--L'autre template -->
    <!-- <link rel="stylesheet" media="screen" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700"> -->
   <!--  <link rel="stylesheet" href="../assets/css/bootstrap.min.css"> -->
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
        <!-- Custom styles for our template -->
    <link rel="stylesheet" href="../assets/css/bootstrap-theme.css" media="screen" >
    <link rel="stylesheet" href="../assets/css/main.css">
</head>

<body>
    <!-- Fixed navbar -->
    <div class="navbar navbar-inverse navbar-fixed-top headroom" >
        <div class="container">
            <div class="navbar-header">
                <!-- Button for smallest screens -->
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                <a class="navbar-brand" href="index.html"><img src="../assets/images/logo2.png" width="70px"><spand style="font-weight: bold;">  Etat Civil</spand></a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav pull-right">
                    <li class="active"><a href="index.php">Accueil</a></li>
                    <li><a href="apropos.php">A propos</a></li>
                    <li class="dropdown">
                        <!-- <a href="#" class="dropdown-toggle" data-toggle="dropdown">More Pages <b class="caret"></b></a> -->
                        <ul class="dropdown-menu">
                            <li><a href="#sidebar-left.html">Left Sidebar</a></li>
                            <li class="active"><a href="#sidebar-right.html">Right Sidebar</a></li>
                        </ul>
                    </li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a class="btn" href="form.php">Demander un document</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div> 
    <!-- /.navbar -->
    <p></p>
    <p></p>
    <p></p>
    <p></p>
    <p></p>
<div class="image-container set-full-height" style="background-image: url('../assets/images/logo2.png')">
    <!--   Etat civil brand Tim Branding   -->

    <!--   Big container   -->
    <div class="container">
        <div class="row">
        <div class="col-sm-12">

            <!--      Wizard container        -->
            <div class="wizard-container">

                <div class="card wizard-card" data-color="orange" id="wizardProfile">
                    <form action="" method="post">
                <!--        You can switch ' data-color="orange" '  with one of the next bright colors: "blue", "green", "orange", "red"          -->

                    	<div class="wizard-header">
                        	<h3>
                        	   <b>Demande de document administrative</b> <br> 
                        	   <small>Remplire les informations suivantes </small>
                        	</h3>
                    	</div>

						<div class="wizard-navigation">
							<ul>
                                <li><a href="#numero_registre" data-toggle="tab">Numero_registre registre <?=$_SESSION["document"]?></a></li>
	                            <!-- <li><a href="#address" data-toggle="tab">Paiemnt</a></li> -->
	                        </ul>

						</div>

                        <div class="tab-content">
                        <!-- debut Numero_registre registre -->
                        <?php
                        if(isset($_POST['valider']) || $erreur = true) :
                            if(isset($_SESSION['document'])) :
                                $docuemnt = $_SESSION['document'] ;
                                if($docuemnt == "extrait naissance") : ?>
                                    <!--debut cas extrait de naissance -->
                                    <div class="tab-pane" id="numero_registre">
                                        <h4 class="info-text"> Entrer les information du document concerné </h4>
                                        <div class="row">
                                            <div class="col-sm-7 col-sm-offset-1">
                                                <div class="form-group">
                                                <label>Numero_registre de registre ou CNI</label>
                                                <input type="text" name="numero_registre" class="form-control" placeholder="23**">
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                <label>Annee_enregistrement d'enregistrement</label>
                                                <input type="text" name="annee_enregistrement" class="form-control" placeholder="19**">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- fin cas extrait de naissance -->
                                <?php elseif($docuemnt == "certificat mariage" || $docuemnt == "certificat deces"): ?>
                                    <!--debut cas certificat de deces et mariage -->
                                    <div class="tab-pane" id="numero_registre">
                                        <h4 class="info-text"> Entrer les information du document concerné </h4>
                                        <div class="row">
                                            <div class="col-sm-7 col-sm-offset-1">
                                                    <div class="form-group">
                                                    <label>Numero_registre de registre</label>
                                                    <input type="text" name="numero_registre" class="form-control" placeholder="23**">
                                                    </div>
                                            </div>
                                            <div class="col-sm-3">
                                                    <div class="form-group">
                                                    <label>Annee_enregistrement d'enregistrement</label>
                                                    <input type="text" name="annee_enregistrement" class="form-control" placeholder="19**">
                                                    </div>
                                            </div>
                                            
                                    
                                        </div>
                                    </div>
                                    <!-- fin cas certificat de deces et mariage -->
                        <?php endif ; endif ; endif ?>
                        <?php if($erreur) : ?>
                                            <div class="col-sm-12 ">
                                                <div class="form-group">
                                                    <div class="alert alert-danger" role="alert">
                                                        <h6 align="center">document INTROUVABLE !!!  <br> veiller reseingner des information correctes svp </h6>
                                                    </div>
                                                </div>
                                            </div>
                        <?php endif ?>

                        </div>
                        <div class="wizard-footer height-wizard">
                            <div class="pull-right">
                                <input type='button' class='btn btn-next btn-fill btn-warning btn-wd btn-sm' name='suivant' value='suivant' />
                                <input type='submit' class='btn btn-finish btn-fill btn-warning btn-wd btn-sm' name='terminer' value='terminer' /></button>

                            </div>

                            <div class="pull-left">
                                <input type='button' class='btn btn-previous btn-fill btn-default btn-wd btn-sm' name='precedant' value='precedant' />
                            </div>
                            <div class="clearfix"></div>
                        </div>

                    </form>
                </div>
            </div> <!-- wizard container -->
        </div>
        </div><!-- end row -->
    </div> <!--  big container -->

    <div class="footer">
        <div class="container">
             Copyright &copy; 2019, Estim Work Group.
        </div>    
    </div>

                  

</div>

</body>

	<!--   Core JS Files   -->
	<script src="../assets-doc/js/jquery-2.2.4.min.js" type="text/javascript"></script>
	<script src="../assets-doc/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="../assets-doc/js/jquery.bootstrap.wizard.js" type="text/javascript"></script>

	<!--  Plugin for the Wizard -->
	<script src="../assets-doc/js/gsdk-bootstrap-wizard.js"></script>

	<!--  More information about jquery.validate here: http://jqueryvalidation.org/	 -->
	<script src="../assets-doc/js/jquery.validate.min.js"></script>

</html>
