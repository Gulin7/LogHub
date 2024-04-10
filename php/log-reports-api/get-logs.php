<?php

  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: GET');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include './log-functions.php';

  session_start();
  $user_id = $_SESSION['user_id'];

  $request_method = $_SERVER["REQUEST_METHOD"];

  if($request_method  == "GET"){

    if(isset($_GET['log_id'])){
      $log = getLogReport($_GET);
      echo $log;
    } else if(isset($_GET['user_id'])){
      $log_list = getUserLogReports($_GET);
    } else if(isset($_GET['log_type'])){
      $log_list = getLogReportsByType($_GET);
    } else if(isset($_GET['log_severity'])){
      $log_list = getLogReportsBySeverity($_GET);
    } else{
      $log_list = getLogReports();
    }

    echo json_encode($log_list);


  } else{
      $data = [
        'status' => 405,
        'message' => $request_method. 'Method Not Allowed',
      ];
      header("HTTP/1.0 405 Method Not Allowed");
      echo json_encode($data);
  }

?>