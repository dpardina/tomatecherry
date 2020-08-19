<?php
// Checks if form has been submitted
    function post_captcha($user_response) {
        $fields_string = '';
        $fields = array(
            'secret' => '6LdQS7EZAAAAACstHTzQdZl_MxNs_ZLP8KVepL8J',
            'response' => $user_response
        );
        foreach($fields as $key=>$value)
        $fields_string .= $key . '=' . $value . '&';
        $fields_string = rtrim($fields_string, '&');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, True);

        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }

    // Call the function post_captcha
    $res = post_captcha($_POST['g-recaptcha-response']);

    if (!$res['success']) {
        // What happens when the CAPTCHA wasn't checked
        return print(json_encode('error'));
    } else {
        // What happens when the CAPTCHA was checked
        function validate($input) {
            $input = trim($input);
            $input = stripcslashes($input);
            $input = htmlspecialchars($input);

            return $input;
        }

        header('Content-type: application/json');

        if (isset($_POST["name"]) && !empty($_POST["name"]) &&
            isset($_POST["email"]) && !empty($_POST["email"]) &&
            isset($_POST["phone"]) && !empty($_POST["phone"]) &&
            isset($_POST["message"]) && !empty($_POST["message"])) {

            $emailDestination = "infotomatecherry@gmail.com";
            $name = validate($_POST["name"]);
            $email = validate($_POST["email"]);
            $phone = validate($_POST["phone"]);
            $message = validate($_POST["message"]);

            $messageContent = "Nombre: " . $name;
            $messageContent .= "\n Teléfono: " . $phone;
            $messageContent .= "\n Correo: " . $email;
            $messageContent .= "\n Mensaje: " . $message;

            mail($emailDestination, "Mensaje de Contacto del cliente ". $name, $messageContent);

            return print(json_encode('ok'));

        }

        return print(json_encode('error'));
    }
?>

