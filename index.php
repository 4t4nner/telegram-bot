<?php

  echo '4!';

  $botToken = '448066609:AAFed17GD1yws3wV3AB4it_rWSt-yMdi6Ck';
  $webSite = 'https://api.telegram.org/bot'.$botToken;

//  $webSite = 'https://tgbot.test.maderwin.com/';

  $update = file_get_contents ($webSite . '/getupdates');

  echo '<pre>';
  var_dump($update);
  echo '<br/>';
  echo '<br/>';
  $updateArray = json_decode ($update);
  print_r ($updateArray);
  echo '<br/>';
  echo '<br/>';
  $chatId = $updateArray['result'][0]['message']['chat']['id'];
//  file_put_contents ($webSite . '/sendmessage?chat_id=' . $chatId . '&text=test');
  //    chat_id

  var_dump ($update);
  echo '<br/>';
  echo '<br/>';
  var_dump ($updateArray);
  echo '<br/>';
  echo '<br/>';
  var_dump ($chatId);
  echo '<br/>';
  echo '<br/>';



  //