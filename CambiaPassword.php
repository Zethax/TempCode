<?php
session_start();
include("Check.php");
checkCitta();
checkLoginJumpToLogin();

//se uno dei due form precedenti è vuoto
if( empty($_POST['pass1']) || empty($_POST['pass2']) || empty($_POST['pass3']) ){
  include("../graphicsPhp/templateError.php");
  getTemplatePassFail();
  exit();
}

//se pass old e new coincidono
if ($_POST['pass1']==$_POST['pass3']) {
  include("../graphicsPhp/templateError.php");
  getTemplatePassFail2();
  exit();
}

//se pass la pass da confermare è diversa da quella inserita
if ($_POST['pass2']!=$_POST['pass3']) {
  include("../graphicsPhp/templateError.php");
  getTemplatePassFail3();
  exit();
}
//se arrivo qua i controlli sono andati a buon fine.verifico la vecchia psw nel db e creo la nuova
include("Connessione.php");
$sql= "SELECT *
       FROM docente
       WHERE idDocente=".$_SESSION['idDocente'];

$result=$conn->query($sql);
$result=$result->fetch(PDO::FETCH_ASSOC);


$DbPswMd5=$result['Pin'];//ps dal db
$newPswMd5=md5($_POST['pass3']);
$oldPswMd5=md5($_POST['pass1']);
//se la old psw non coincide con quella nel db
if($DbPswMd5!=$oldPswMd5){
  include("../graphicsPhp/templateError.php");
  getTemplatePassDbFail();
  exit();
}
//tutto è andato a buon fine, si inizia un update per la nuova ps
//conservo dei dati da spedire in una email al utente
$newPsw=$_POST['pass3'];
$email=$result['Email'];
//send email
include("SendMail.php");
sendMailPassword($newPsw,$email);

$sql= "UPDATE docente SET Pin='".$newPswMd5."'
      WHERE idDocente=".$_SESSION['idDocente'];
$result=$conn->query($sql);


header("refresh:3; url=logout.php");
echo "<h1>Password cambiata con successo <a href=logout.php>Torna indietro</a></h1>";

?>
