<?php

  echo '4!';

  $botToken = '448066609:AAFed17GD1yws3wV3AB4it_rWSt-yMdi6Ck';
  $webSite = 'https://api.telegram.org/bot'.$botToken;

//  $webSite = 'https://tgbot.test.maderwin.com/';

  $update = file_get_contents ($webSite . '/getupdates');

  echo '<pre>';
  $updateArray = json_decode ($update,true);
  $chatId = $updateArray['result'][0]['message']['chat']['id'];
  $string = $webSite . '/sendmessage?chat_id=' . $chatId . '&text=test';
  print_r($string);
  file_put_contents ($string);



  //