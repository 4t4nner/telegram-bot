<?php

  echo '3!!!!!!!!!!!!!!!!!';

  $botToken = '448066609:AAFed17GD1yws3wV3AB4it_rWSt-yMdi6Ck';
  $webSite = 'https://api.telegram.org/bot'.$botToken;

//  $webSite = 'https://tgbot.test.maderwin.com/';

  $update = file_get_contents ($webSite . '/getupdates');
  print_r ($update);
  $updateArray = json_decode ($update);
  print_r ($updateArray);
  $chatId = $updateArray['result'][0]['message']['chat']['id'];
//  file_put_contents ($webSite . '/sendmessage?chat_id=' . $chatId . '&text=test');
  //    chat_id

  print_r ($update);
  print_r ($updateArray);
  print_r ($chatId);



  //