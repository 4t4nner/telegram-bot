<?php

  namespace Bot;
  
  require_once 'constants.php';
  
  class TelegramConnector {

    protected static $arMes = [];
    protected static $chat = [];
    protected static $command = '';
    protected static $text = '';
    protected static $user = [];

    protected static function processRequest(){
      $update = file_get_contents ('php://input');
      $updateArray = json_decode ($update,true);
      static::$arMes = $updateArray['message'];
      static::$chat = static::$arMes['chat'];
      static::$user = static::$arMes['from'];

      $inputs = static::getCommand(static::$arMes['text']);
      static::$command = $inputs['command'];
      static::$text = $inputs['text'];
    }

    protected static function getCommand($text){
      $res = [];

      $matches = [];
      preg_match ('/^(?:(?:\s*(\/(?P<command>[^\s]+)))(?:\s+(?P<arg>.*[^\s])\s*)?|(?:\s*(?P<text>[^\/].*[^\s])\s*))$/', $text, $matches);
      $res['command'] = $matches['command'];
      $res['text'] = $matches['text']
        ? $matches['text']
        : ($matches['arg']
          ? $matches['arg']
          : '');

      return $res;
    }

    protected static function sendMessage ($text) {
      file_get_contents (API_URL . CA_SEND_MESSAGE . '?chat_id=' . static::$chat['id'] . '&text=' . $text);
    }

    protected static function apiRequestWebhook($method, $parameters) {
      if (!is_string($method)) {
        error_log("Method name must be a string\n");
        return false;
      }

      if (!$parameters) {
        $parameters = array();
      } else if (!is_array($parameters)) {
        error_log("Parameters must be an array\n");
        return false;
      }

      $parameters["method"] = $method;

      header("Content-Type: application/json");
      echo json_encode($parameters);
      return true;
    }

    protected static function exec_curl_request($handle) {
      $response = curl_exec($handle);

      if ($response === false) {
        $errno = curl_errno($handle);
        $error = curl_error($handle);
        error_log("Curl returned error $errno: $error\n");
        curl_close($handle);
        return false;
      }

      $http_code = intval(curl_getinfo($handle, CURLINFO_HTTP_CODE));
      curl_close($handle);

      if ($http_code >= 500) {
        // do not wat to DDOS server if something goes wrong
        sleep(10);
        return false;
      } else if ($http_code != 200) {
        $response = json_decode($response, true);
        error_log("Request has failed with error {$response['error_code']}: {$response['description']}\n");
        if ($http_code == 401) {
          throw new \Exception('Invalid access token provided');
        }
        return false;
      } else {
        $response = json_decode($response, true);
        if (isset($response['description'])) {
          error_log("Request was successfull: {$response['description']}\n");
        }
        $response = $response['result'];
      }

      return $response;
    }

    /**
     * @param string $method
     * @param array $parameters
     * @return bool|mixed
     * @throws \Exception
     */
    protected static function apiRequest($method, $parameters) {
      file_put_contents ('smth.txt',"apiRequest: $method\n <br>" . print_r($parameters,true)."\n <br>",FILE_APPEND);
      if (!is_string($method)) {
        error_log("Method name must be a string\n");
        return false;
      }

      if (!$parameters) {
        $parameters = array();
      } else if (!is_array($parameters)) {
        error_log("Parameters must be an array\n");
        return false;
      }

      foreach ($parameters as $key => &$val) {
        // encoding to JSON array parameters, for example reply_markup
        if (!is_numeric($val) && !is_string($val)) {
          $val = json_encode($val);
        }
      }
      $url = API_URL.$method.'?'.http_build_query($parameters);

      $handle = curl_init($url);
      curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
      curl_setopt($handle, CURLOPT_TIMEOUT, 60);

      file_put_contents ('smth.txt',"exec_curl_request: \n <br>" . print_r($handle,true) . "\n <br>",FILE_APPEND);
      return static::exec_curl_request($handle);
    }

    protected static function apiRequestJson($method, $parameters) {
      if (!is_string($method)) {
        error_log("Method name must be a string\n");
        return false;
      }

      if (!$parameters) {
        $parameters = array();
      } else if (!is_array($parameters)) {
        error_log("Parameters must be an array\n");
        return false;
      }

      $parameters["method"] = $method;

      $handle = curl_init(API_URL);
      curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
      curl_setopt($handle, CURLOPT_TIMEOUT, 60);
      curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($parameters));
      curl_setopt($handle, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));

      return static::exec_curl_request($handle);
    }

  }