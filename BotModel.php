<?php

  class DBAPi{
    protected static $instance;
    public static function getInstance(){
      if(!static::$instance){
        static::$instance = new DBAPi();
      }
      return static::$instance;
    }

    protected static function initialize(){
      $mysqli = new mysqli("jdbc:mysql://localhost:3306/tgbot", "tgbot", "tgbot", "tgbot");

      if ($mysqli->connect_errno) {
        echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
      }


    }
  }

  class BotModel {
    public static function getUser($phone){
      
    }
  }