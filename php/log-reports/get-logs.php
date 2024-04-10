<?php

  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: GET');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include './function.php';

  $request_method = $_SERVER["REQUEST_METHOD"];

  if($request_method  == "GET"){

    if(isset($_GET['log_id'])){
      $log = getLogReport($_GET);
      echo $log;
    } else if(isset($_GET['user_id'])){
      $log_list = getUserLogReports($_GET);
      echo $log_list;
    } else{
      $log_list = getLogReports();
      echo $log_list;
    }

  } else{
      $data = [
        'status' => 405,
        'message' => $request_method. 'Method Not Allowed',
      ];
      header("HTTP/1.0 405 Method Not Allowed");
      echo json_encode($data);
  }

?>