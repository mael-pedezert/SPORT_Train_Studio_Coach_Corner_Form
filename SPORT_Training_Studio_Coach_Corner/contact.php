<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  // Récupérer les données du formulaire
  $name = strip_tags(trim($_POST["name"]));
  $name = str_replace(array("\r","\n"),array(" "," "),$name);
  $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
  $message = trim($_POST["message"]);

  // Vérifier que les données sont valides
  if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo "Veuillez renseigner tous les champs du formulaire.";
    exit;
  }

  // Configurer l'e-mail
  $to = "mael.p2r@hotmail.com";
  $subject = "Nouveau message depuis le formulaire de contact";
  $body = "Nom: $name\n\nEmail: $email\n\nMessage:\n$message";

  // Envoyer l'e-mail
  if (mail($to, $subject, $body)) {
    http_response_code(200);
    echo "Merci ! Votre message a été envoyé.";
  } else {
    http_response_code(500);
    echo "Une erreur est survenue lors de l'envoi du message. Veuillez réessayer.";
  }
} else {
  http_response_code(403);
  echo "Une erreur est survenue lors de l'envoi du message. Veuillez réessayer.";
}
