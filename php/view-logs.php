<?php 
  session_start();

  include './database/database.php';
  include './functions.php';

  $user_id = $_SESSION['user_id'];

  if($_SESSION['user_id'] == null){
    header("Location: login.php");
    die;
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/styles.css">
  <link rel="stylesheet" href="./css/view-logs.css">
  <title>LogHub | ViewLogs</title>
</head>
<body onload="getLogReports()">
  <header class="main-header">
    <div class="logo"><a href="index.php">LogHub</a></div>
    <div class="links">
      <a href="add-log.php"> Add Log</a>
      <!-- <a href="view-logs.php"> View Logs</a> -->
      <a href="logout.php"> LogOut</a>
    </div>
  </header>
  <div class="container">
    <h1> LogHub</h1>
    <div class="view-options">
      <button id="view-all-logs" class="m-2 btn btn-primary" action="getLogReports" >View All Logs</button>
      <button id="view-my-logs" class="m-2 btn btn-primary">View My Logs</button>
      <select id="view-severity-logs" class="m-2 form-select">
        <option value="all">Select severity</option>
        <option value="critical">Critical</option>
        <option value="debug">Debug</option>
        <option value="error">Error</option>
        <option value="notice">Notice</option>
      </select>
      <select id="view-type-logs" class="m-2 form-select">
        <option value="all">Select type</option>
        <option value="database">Database</option>
        <option value="server">Server</option>
        <option value="client">Client</option>
        <option value="test">Test</option>
      </select>
    </div>
    <table>
      <thead>
        <tr>
          <th>Log Type</th>
          <th>Log Severity</th>
          <th>Log Date</th>
          <th>Log Message</th>
        </tr>
      </thead>
      <tbody id="logs-table">
        
      </tbody>
    </table>
  </div>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
      <?php 
       echo "const user_id = $user_id;";
      ?>
    </script>
    <script src="./ajax.js"></script>
  </body>
</html>