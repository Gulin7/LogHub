<?php

  error_reporting(0);

  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include './function.php';

  $request_method = $_SERVER["REQUEST_METHOD"];

  if($request_method  == "POST"){

      $store_log = storeLog($_POST);
      echo $store_log;
      
  } else{
      $data = [
        'status' => 405,
        'message' => $request_method. 'Method Not Allowed',
      ];
      header("HTTP/1.0 405 Method Not Allowed");
      echo json_encode($data);
  }
?>