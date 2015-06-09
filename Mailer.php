<?php

class Mailer{
    public function mail($sender, $recipient, $subject, $sBody){
        $sReplyTo = $sender;
        // Identify the mail server, username, password, and port
        $url = "https://api.sendgrid.com/api/mail.send.json";
        $oCreds = json_decode(file_get_contents(__DIR__ . "/../../../creds/sendgrid.json"));
        $username = $oCreds->api_user;
        $password = $oCreds->api_key;
        // Set up the mail headers
        $fields = array(
            "from" => $sender,
            "to" => $recipient,
            "subject" => $subject,
            "html" => $sBody,
            "replyto" => $sReplyTo,
            "api_user" => $username,
            "api_key" => $password
        );
        //open connection
        $ch = curl_init();
        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_POST, count($fields));
        curl_setopt($ch,CURLOPT_POST, count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS, http_build_query($fields));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //execute post
        $oResult = json_decode(curl_exec($ch));
        //close connection
        curl_close($ch);
    }
}