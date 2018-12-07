<?php

function sendMailPassword($newPsw,$Email){
  //definisco generalità e corpo email
  $nomeMittente="AFAMsis servizio docenti";
  $mailMittente="non-rispondere@prova.it";
  $mailDestinatario=$Email;

  $mailOggetto="Cambiamento password";
  $mailCorpo="Di recente hai cambiato la tua password al portale docenti,
              per non dimenticarla eccola :".$newPsw;

        // aggiusto un po' le intestazioni della mail
        // E' in questa sezione che deve essere definito il mittente (From)
        // ed altri eventuali valori come Cc, Bcc, ReplyTo e X-Mailer
        $mail_headers = "From: " .  $nomeMittente . " <" .  $mailMittente . ">\r\n";
        $mail_headers .= "Reply-To: " .  $mailMittente . "\r\n";
        $mail_headers .= "X-Mailer: PHP/" . phpversion();



  if(!(mail($mailDestinatario, $mailOggetto, $mailCorpo, $mail_headers) )){
    print("email non inviata a ".$mailDestinatario);


    exit();
  };
}

 ?>
