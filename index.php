<?php
$content = file_get_contents("php://input");
$token = '<token_bot>';
$apiLink = "https://api.telegram.org/bot$token/"; 
$update = json_decode($content, true);
if(!@$update["message"]) $val = $update['callback_query'];
else $val = $update;
$chat_id = $val['message']['chat']['id'];
$text = $val['message']['text'];
$update_id = $val['update_id'];
$sender = $val['message']['from'];

if ($text == "/start") {
    file_get_contents($apiLink . "sendmessage?chat_id=$chat_id&text=Halo, saya Simi. Yuk mulai ngobrolnya..");
    return false;
} else if ($text == "/donasi") {
    file_get_contents($apiLink . "sendmessage?chat_id=$chat_id&text=Untuk donasi developer, silahkan kunjungi: https://trakteer.id/ihsan.devs");
    return false;
} else if ($text == "/about") {
    file_get_contents($apiLink . "sendmessage?chat_id=$chat_id&text=Bot ini dibuat oleh Ihsan Devs. Bot ini diintegrasikan dengan API SimSimi langsung.");
    return false;
} else if ($text == "/versi") {
    file_get_contents($apiLink . "sendmessage?chat_id=$chat_id&text=Bot ini versi 1.0.0");
    return false;
} else {
    $endpointSimSimi = file_get_contents("https://simsumi.herokuapp.com/api?text=".urlencode($text)."&lang=id");
    $pesan = json_decode($endpointSimSimi);
    $pesan = $pesan->success;
    if (!empty($pesan)) {
        file_get_contents($apiLink . "sendmessage?chat_id=$chat_id&text=$pesan");
    } else {
        file_get_contents($apiLink . "sendmessage?chat_id=$chat_id&text=Maaf. Simi tidak mengerti apa yang kamu katakan :(");
    }
    
}