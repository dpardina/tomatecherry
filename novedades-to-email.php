<?php

function validate($input)
{
    $input = trim($input);
    $input = stripcslashes($input);
    $input = htmlspecialchars($input);

    return $input;
}

header('Content-type: application/json');

if (isset($_POST["novedades-email"]) && !empty($_POST["novedades-email"])) {

    $emailDestination = "infotomatecherry@gmail.com";
    $email = validate($_POST["novedades-email"]);

    $suscriptor = "Email Suscriptor: " . $email;

    mail($emailDestination, "Nuevo Suscriptor para recibir Novedades ", $suscriptor);
    
    return print(json_encode('ok'));

}

return print(json_encode('error'));