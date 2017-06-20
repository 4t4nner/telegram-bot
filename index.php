<?php

  require_once 'Bot.php';

  echo 'BOOooOT!';

  $botToken = '448066609:AAFed17GD1yws3wV3AB4it_rWSt-yMdi6Ck';
  $webSite = 'https://api.telegram.org/bot'.$botToken;

//  $webSite = 'https://tgbot.test.maderwin.com/';

  $update = file_get_contents ('php://input');


  $updateArray = json_decode ($update,true);
  $chatId = $updateArray['message']['chat']['id'];
  $string = $webSite . '/sendmessage?chat_id=' . $chatId . '&text=test';

  if($update){
//    webhook
    file_put_contents ('smth.txt',print_r($updateArray,true) . "<br><br>\n\n".'string= '.$string );

    \Bot\Bot::execute();
  } else {
    //OUTPUT_SECTION
    echo '<pre>';
    if(file_exists('smth.txt')){
      var_dump(file_get_contents('smth.txt'));
      print_r( 'file_exists: ' .file_exists('smth.txt'));
    }
  }


  //https://api.telegram.org/bot448066609:AAFed17GD1yws3wV3AB4it_rWSt-yMdi6Ck/sendmessage?chat_id=304219410&text=test
  //https://api.telegram.org/bot448066609:AAFed17GD1yws3wV3AB4it_rWSt-yMdi6Ck/sendmessage?chat_id=304219410&text=blabla




