<?php
session_start();

  include './database/database.php';
  include './functions.php';

  // $user_data = check_login($conn);

  if($_SERVER['REQUEST_METHOD'] == "POST"){
    $username = filter_input(INPUT_POST,'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST,'email', FILTER_VALIDATE_EMAIL,  FILTER_SANITIZE_SPECIAL_CHARS);

    $password = filter_input(INPUT_POST,'password', FILTER_SANITIZE_SPECIAL_CHARS);

    //check if username exists
    $query = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
    $result = mysqli_query($conn, $query);
    $query2 = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
    $result2 = mysqli_query($conn, $query2);

    if($result && mysqli_num_rows($result) > 0){
      echo "Username already exists!";
      die;
    }

    if($result2 && mysqli_num_rows($result2) > 0){
      echo "Email already exists!";
      die;
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);

    if(!empty($username) && !empty($email) && !empty($hash)){

      $user_id = rand(1, 1000);

      while(true){
        $query_user_id = "SELECT * FROM users WHERE user_id = '$user_id' LIMIT 1";
        $result_user_id = mysqli_query($conn, $query_user_id);
        if($result_user_id && mysqli_num_rows($result_user_id) > 0){
          $user_id = rand(1, 1000);
        } else {
          break;
        }
      }

      $query = "INSERT INTO users (user_id, username, email, password) VALUES ('$user_id','$username', '$email', '$hash')";
      $result = mysqli_query($conn, $query);
      if($result){
        header("Location: login.php");
        die;
      } else {
        echo "Error: ". $query. "<br>". mysqli_error($conn);
      }
    } else {
      echo "Please enter some valid information!";
    }

  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/styles.css">
  <title>LogHub | SignUp</title>
</head>
<body>
<header class="main-header">
  <div class="logo">LogHub</div>
    <!-- <div class="links">
      <a href="logout.php">Log out</a>
    </div> -->
  </header>
  <div class="container form-container" style="width:50%">
    <h2> SignUp</h2>
    <form class="form-control m-2"  method="POST"> 
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" name="username" required>
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
      <div class="form-group form-button">
      <button type="submit" class="btn btn-info">SignUp</button>
      </div>
      <div class="form-button">
        <p> Already have an account? <a href="login.php" style="color:#3d0e5d; font-weight:600;">LogIn</a></p>
        
      <div>
    </form>
  </div>
</body>
</html>