<?php
session_start();

  include './database/database.php';
  include './functions.php';

  $user_data = check_login($conn);

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
  <title>LogHub | AddLog</title>
</head>
<body>
  <header class="main-header">
  <div class="logo"><a href="index.php">LogHub</a>
  </div>
    <div class="links">
      <!-- <a href="signup.php">SignUp</a> -->
      <!-- <a href="login.php">LogIn</a> -->
      <!-- <a href="logout.php">LogOut</a> -->
      <a href="view-logs.php"> View Logs </a>
    </div>
  </header>
  <div class="container form-container">
    <h1> LogHub</h1>
    <p>Enter a log report.</p>
    <form class="form-control m-2 " action="./log-reports-api/create-log.php" method="POST">
      <div class="form-group form">
        <label for="log_type">Log Type</label>
        <input type="text" class="form-control" id="log_type" name="log_type" required>
      </div>
      <div class="form-group">
        <label for="log_severity">Log Severity</label>
        <select class="form-select" name="log_severity" required>
          <option value="0">Select severity</option>
          <option value="critical">Critical</option>
          <option value="debug">Debug</option>
          <option value="error">Error</option>
          <option value="notice">Notice</option>
        </select>
      </div>
      <div class="form-group">
        <label for="log_date">Log Date</label>
        <input type="date" class="form-control" id="log_date_display" value="<?php echo date('Y-m-d'); ?>" disabled>
        <input type="hidden" id="log_date" name="log_date" value="<?php echo date('Y-m-d'); ?>">
      </div>
      <div class="form-group">
        <label for="log_message">Log Message</label>
        <textarea class="form-control" id="log_message" name="log_message" required></textarea>
      </div>
      <!-- <div class="form-group">
        <label for="user_id">Your id</label>
        <input type="text" class="form-control" id="user_id" name="user_id"  value= disabled>
      </div> -->
      <div class="form-group form-button">
        <button button type="submit" class="btn btn-info">Create Log</button>
      </div>
    </form>
  </div>
</body>
</html>