<?php

  namespace Bot;
  
  require_once 'constants.php';
  require_once 'TelegramConnector.php';

  class Bot extends TelegramConnector{

    public static function execute(){
      static::processRequest();
      static::executeCommand(static::$command);
    }

    public static function start () {
      if (static::isUserRegistered (static::$user['id'])) {
        static::apiRequest ("sendMessage", [
            'chat_id' => static::$chat['id'],
            "text"    => 'Добро пожаловать, ' . static::$user['first_name'] . '!',
          ]
        );
      } else {
        file_put_contents ('smth.txt',"start: isUserRegistered : \n <br>" . static::isUserRegistered (static::$user['id']) . "\n <br>",FILE_APPEND);
        static::apiRequest ("sendMessage", [
          'chat_id'      => static::$chat['id'],
          "text"         => 'Добро пожаловать, ' . static::$user['first_name'] . ', введите телефон для регистрации',
          'reply_markup' => [
            'keyboard' => [
              [
                [
                  'text'            => "SHOW PHONE",
                  'request_contact' => true,
                ],
              ],
            ],
            'one_time_keyboard' => true,
            'resize_keyboard'   => true,
          ],
        ]);

      }
    }

    public static function executeCommand($command){
      switch ($command){
        case C_START : {
          return static::start();
          break;
        }
        case C_GET_COMMANDS : {
          
          break;
        }
        case C_GET_USER_REQ : {
          
          break;
        }
        case C_ADD_REQ : {
          
          break;
        }
        case C_AUTH : {
          
          break;
        }
        default : {
          
          break;
        }
      }
    }
    
    
    public static function getUserCommands(){
      
    }
    
    
    public static function getUserRequests(){
      
    }
    
    public static function addUserRequest(){
      
    }
    
    
    public static function auth(){
      
    }
    
    public static function oAuth(){
      
    }
    
    public static function isUserAuthorized($useId){
      
    }

    public static function isUserRegistered($useId){
      return false;
    }

    public static function registerUser($arUser){

    }

    
    
    
    
    
  }