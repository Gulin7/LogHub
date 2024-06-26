<?php

  require '../database/database.php';

  function getLogReportsByType($parameters){
    global $conn;

    if($parameters['log_type']==null){
      $data = [
        'status' => 400,
        'message' => 'Log ID is required',
      ];
      header("HTTP/1.0 400 Bad Request");
      return json_encode($data);
    } 
    
    $log_type = mysqli_real_escape_string($conn, $parameters['log_type']);

    $query = "SELECT * FROM logs WHERE log_type = '$log_type'";
    $query_run = mysqli_query($conn, $query);

    if($query_run){
          
        if(mysqli_num_rows($query_run)>0){
  
          $response = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
          $data = [
            'status' => 200,
            'message' => 'Logs found',
            'data' => $response
          ];
          header("HTTP/1.0 200 OK");
          return json_encode($data);
  
        }else{
          $data = [
            'status' => 404,
            'message' => 'No logs found',
          ];
          header("HTTP/1.0 404 Not Found");
          return json_encode($data);
        }
  
      } else{
        $data = [
          'status' => 500,
          'message' => 'Server Error',
        ];
        header("HTTP/1.0 500 Server Error");
        return json_encode($data);
    }
  }

  function getLogReportsBySeverity($parameters){
    global $conn;

    if($parameters['log_severity']==null){
      $data = [
        'status' => 400,
        'message' => 'Log ID is required',
      ];
      header("HTTP/1.0 400 Bad Request");
      return json_encode($data);
    } 
    
    $log_severity = mysqli_real_escape_string($conn, $parameters['log_severity']);

    $query = "SELECT * FROM logs WHERE log_severity = '$log_severity'";
    $query_run = mysqli_query($conn, $query);

    if($query_run){
          
        if(mysqli_num_rows($query_run)>0){
  
          $response = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
          $data = [
            'status' => 200,
            'message' => 'Logs found',
            'data' => $response
          ];
          header("HTTP/1.0 200 OK");
          return json_encode($data);
  
        }else{
          $data = [
            'status' => 404,
            'message' => 'No logs found',
          ];
          header("HTTP/1.0 404 Not Found");
          return json_encode($data);
        }
  
      } else{
        $data = [
          'status' => 500,
          'message' => 'Server Error',
        ];
        header("HTTP/1.0 500 Server Error");
        return json_encode($data);
    }
  }

  function deleteLog($delete_parameter){
    global $conn;

    if($delete_parameter['log_id']==null){
      $data = [
        'status' => 400,
        'message' => 'Log ID is required',
      ];
      header("HTTP/1.0 400 Bad Request");
      return json_encode($data);
    }

    $log_id = mysqli_real_escape_string($conn, $delete_parameter['log_id']);

    $query = "DELETE FROM `logs` WHERE `log_id`='$log_id'";
    $query_run = mysqli_query($conn, $query);

    if($query_run){
      $data = [
        'status' => 204,
        'message' => 'Log deleted successfully',
      ];
      // header("HTTP/1.0 204 OK");
      return json_encode($data);
    } else{
      $data = [
        'status' => 500,
        'message' => 'Server Error',
      ];
      header("HTTP/1.0 500 Server Error");
      return json_encode($data);
    }
  }

  function updateLog($log_input, $log_parameters){
    global $conn;

    if(!isset($log_parameters['log_id'])){
      $data = [
        'status' => 400,
        'message' => 'Log ID is required',
      ];
      header("HTTP/1.0 400 Bad Request");
      return json_encode($data);

    } else if($log_parameters['log_id']==null){
      $data = [
        'status' => 400,
        'message' => 'Log ID is required',
      ];
      header("HTTP/1.0 400 Bad Request");
      return json_encode($data);
    } 

    $log_id = mysqli_real_escape_string($conn, $log_parameters['log_id']);
    $log_type = mysqli_real_escape_string($conn, $log_input['log_type']);
    $log_severity = mysqli_real_escape_string($conn, $log_input['log_severity']);
    $log_date = mysqli_real_escape_string($conn, $log_input['log_date']);
    $log_message = mysqli_real_escape_string($conn, $log_input['log_message']);
    $user_id = mysqli_real_escape_string($conn, $log_input['user_id']);

    if(empty(trim($log_id)) || empty(trim($log_type)) || empty(trim($log_severity)) || empty(trim($log_date)) || empty(trim($log_message)) || empty(trim($user_id))){
      $data = [
        'status' => 400,
        'message' => 'All fields are required',
      ];
      header("HTTP/1.0 400 Bad Request");
      return json_encode($data);
    } else{
      $query = "UPDATE `logs` SET `log_type`='$log_type',`log_severity`='$log_severity',`log_date`='$log_date',`log_message`='$log_message',`user_id`='$user_id' WHERE `log_id`='$log_id'";
      $query_run = mysqli_query($conn, $query);

      if($query_run){
        $data = [
          'status' => 201,
          'message' => 'Log updated successfully',
        ];
        header("HTTP/1.0 201 Updated");
        return json_encode($data);
      } else{
        $data = [
          'status' => 500,
          'message' => 'Server Error',
        ];
        header("HTTP/1.0 500 Server Error");
        return json_encode($data);
      }
    }
  }

  function getFirstFreeLogId(){
    global $conn;
    $query = "SELECT MAX(log_id) FROM logs";
    $query_run = mysqli_query($conn, $query);
    $response = mysqli_fetch_assoc($query_run);
    return $response['MAX(log_id)']+1;
  }

  function storeLog($log_input, $user_id){
    global $conn;

    $log_id = getFirstFreeLogId();
    $log_type = mysqli_real_escape_string($conn, $log_input['log_type']);
    $log_severity = mysqli_real_escape_string($conn, $log_input['log_severity']);
    $log_date = mysqli_real_escape_string($conn, $log_input['log_date']);
    $log_message = mysqli_real_escape_string($conn, $log_input['log_message']);

    if(empty(trim($log_id))){
      $data = [
        'status' => 400,
        'message' => 'Log ID is required',
      ];
      header("HTTP/1.0 400 Bad Request");
      return json_encode($data);
    }

    if(empty(trim($log_type))){
      $data = [
        'status' => 400,
        'message' => 'Log Type is required',
      ];
      header("HTTP/1.0 400 Bad Request");
      return json_encode($data);
    }

    if(empty(trim($log_severity))){
      $data = [
        'status' => 400,
        'message' => 'Log Severity is required',
      ];
      header("HTTP/1.0 400 Bad Request");
      return json_encode($data);
    }

    if(empty(trim($log_date))){
      $data = [
        'status' => 400,
        'message' => 'Log Date is required',
      ];
      header("HTTP/1.0 400 Bad Request");
      return json_encode($data);
    }

    if(empty(trim($log_message))){
      $data = [
        'status' => 400,
        'message' => 'Log Message is required',
      ];
      header("HTTP/1.0 400 Bad Request");
      return json_encode($data);
    }

    if(empty(trim($user_id))){
      $data = [
        'status' => 400,
        'message' => 'User ID is required',
      ];
      header("HTTP/1.0 400 Bad Request");
      return json_encode($data);
    }

      $query = "INSERT INTO `logs`(`log_id`, `log_type`, `log_severity`, `log_date`, `log_message`, `user_id`) VALUES ('$log_id', '$log_type', '$log_severity', '$log_date', '$log_message', '$user_id')";
      $query_run = mysqli_query($conn, $query);

      if($query_run){
        $data = [
          'status' => 201,
          'message' => 'Log created successfully',
        ];
        header("Location: ../view-logs.php");
        return json_encode($data);
      } else{
        $data = [
          'status' => 500,
          'message' => 'Server Error',
        ];
        header("HTTP/1.0 500 Server Error");
        return json_encode($data);
      }
    }

  function getLogReport($parameters){
    global $conn;

    if($parameters['log_id']==null){
      $data = [
        'status' => 400,
        'message' => 'Log ID is required',
      ];
      header("HTTP/1.0 400 Bad Request");
      return json_encode($data);
    } 
    
    $log_id = mysqli_real_escape_string($conn, $parameters['log_id']);

    $query = "SELECT * FROM logs WHERE log_id = '$log_id'";
    $query_run = mysqli_query($conn, $query);

    if($query_run){
      if(mysqli_num_rows($query_run) == 1){
        $response = mysqli_fetch_assoc($query_run);
        $data = [
          'status' => 200,
          'message' => 'Log found',
          'data' => $response
        ];
        header("HTTP/1.0 200 OK");
        return json_encode($data);
      }
      else{
        $data = [
          'status' => 404,
          'message' => 'Log not found',
        ];
        header("HTTP/1.0 404 Not Found");
        return json_encode($data);
      }
    } else{
      $data = [
        'status' => 500,
        'message' => 'Server Error',
      ];
      header("HTTP/1.0 500 Server Error");
      return json_encode($data);
    }
  }

  function getUserLogReports($parameters){

    global $conn;

    if($parameters['user_id']==null){
      $data = [
        'status' => 400,
        'message' => 'User ID is required',
      ];
      header("HTTP/1.0 400 Bad Request");
      return json_encode($data);
    }

    $user_id = mysqli_real_escape_string($conn, $parameters['user_id']);

    $query = "SELECT * FROM logs WHERE user_id = '$user_id'";
    $query_run = mysqli_query($conn, $query);

    if($query_run){
        
        if(mysqli_num_rows($query_run)>0){
  
          $response = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
          $data = [
            'status' => 200,
            'message' => 'Logs found',
            'data' => $response
          ];
          header("HTTP/1.0 200 OK");
          return json_encode($data);
  
        }else{
          $data = [
            'status' => 404,
            'message' => 'No logs found',
          ];
          header("HTTP/1.0 404 Not Found");
          return json_encode($data);
        }
  
      } else{
        $data = [
          'status' => 500,
          'message' => 'Server Error',
        ];
        header("HTTP/1.0 500 Server Error");
        return json_encode($data);
    }

  }
  
  function getLogReports(){
    global $conn;
    $query = "SELECT * FROM logs";
    $query_run = mysqli_query($conn, $query);

    if($query_run){

      if(mysqli_num_rows($query_run)>0){

        $response = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
        $data = [
          'status' => 200,
          'message' => 'Logs found',
          'data' => $response
        ];
        header("HTTP/1.0 200 OK");
        return json_encode($data);

      }else{
        $data = [
          'status' => 404,
          'message' => 'No logs found',
        ];
        header("HTTP/1.0 404 Not Found");
        return json_encode($data);
      }

    } else{
      $data = [
        'status' => 500,
        'message' => 'Server Error',
      ];
      header("HTTP/1.0 500 Server Error");
      return json_encode($data);
    }
  }

?>