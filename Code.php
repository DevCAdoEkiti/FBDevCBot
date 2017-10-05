<?php
// parameters
$hubVerifyToken = '12345ABCD';
$accessToken = "xxx";

// Check token at Setup
if ($_REQUEST['hub_verify_token'] === $hubVerifyToken) {
  echo $_REQUEST['hub_challenge'];
  exit;
}

// Handle Bot's Anwser
$input = json_decode(file_get_contents('php://input'), true);

$senderID = $input['entry'][0]['messaging'][0]['sender']['id'];
$messageText = $input['entry'][0]['messaging'][0]['message']['text'];


$answer = "I cannot get an answer to your keyword. Type 'hi' instead. :) ";

if($messageText == "hi") {
    $answer = "Hello dear, Welcome. I'm just a Facebook bot built to answer queries. Make your request!";
}
if($messageText == "pray for me") {
    $answer = "Success in your exams, dear";
}

if($messageText == "amen thanks") {
    $answer = "Anytime dear";
}

if($messageText == "bye") {
    $answer = "Yeah, thanks for reaching out. Bye! :* ";
}

$response = [
    'recipient' => [ 'id' => $senderID ],
    'message' => [ 'text' => $answer ]
];
$ch = curl_init('https://graph.facebook.com/v2.6/me/messages?access_token='.$accessToken);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_exec($ch);
curl_close($ch);
