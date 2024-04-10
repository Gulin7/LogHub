<?php
session_start();

  include './database/database.php';
  include './functions.php';

  // $user_data = check_login($conn);

  if($_SERVER['REQUEST_METHOD'] =='POST'){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
    $result = mysqli_query($conn, $query);
    
    if($result && mysqli_num_rows($result) > 0){
      $user_data = mysqli_fetch_assoc($result);

      if(password_verify($password, $user_data['password'])){
        $_SESSION['user_id'] = $user_data['user_id'];
        header("Location: index.php");
        die;
      } else {
        echo "Invalid password!";
      }
    } else {
      echo "Invalid username or password!";
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
  <title>LogHub | LogIn</title>
</head>
<body>
<header class="main-header">
    <div class="logo">LogHub</div>
    <!-- <div class="links">
      <a href="logout.php">Log out</a>
    </div> -->
  </header>
  <div class="container form-container" style="width:50%">
    <h2> LogIn</h2>
    <form class="form-control m-2"  method="POST"> 
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" name="username" required>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
      <div class="form-group form-button">
      <button type="submit" class="btn btn-info">Login</button>
      </div>
      <div class="form-button">
        <p> Don't have an account? <a href="signup.php" style="color:#3d0e5d; font-weight:600;">SignUp</a></p>
        
      <div>
    </form>
  </div>
</body>
</html>