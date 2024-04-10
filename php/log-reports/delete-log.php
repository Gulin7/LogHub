<?php

  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: GET');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include './function.php';

  $request_method = $_SERVER["REQUEST_METHOD"];

  if($request_method == "DELETE"){

    if(!isset($_GET['log_id'])){
      $data = [
        'status' => 400,
        'message' => 'Log ID is required',
      ];
      header("HTTP/1.0 400 Bad Request");
      echo json_encode($data);
      exit;
    }
    
    $delete_log = deleteLog($_GET);
    echo $delete_log;

  } else {
      $data = [
        'status' => 405,
        'message' => $request_method. ' Method Not Allowed',
      ];
      header("HTTP/1.0 405 Method Not Allowed");
      echo json_encode($data);
  }
?>
