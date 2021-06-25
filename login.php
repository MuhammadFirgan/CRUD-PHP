<?php
session_start();
require "connect.php";

if (isset($_COOKIE["id"]) && isset($_COOKIE["cek"])) {
  $id = $_COOKIE["id"];
  $cek = $_COOKIE["cek"];
  $result = mysqli_query($conn, "SELECT * FROM user WHERE id=$id");
  $row = mysqli_fetch_assoc($result);
  if ($cek === hash('sha256', $row["username"])) {
    $_SESSION["login"] = true;
  }
}

if (isset($_SESSION["login"])) {
  header("Location: index.php");
  exit;
}

if (isset($_POST["login"])) {
  
  $username = $_POST["username"];
  $password = $_POST["password"];
  $query = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
  if (mysqli_num_rows($query) === 1) {
    $result = mysqli_fetch_array($query);
    $pass = password_verify($password, $result["password"]);
    
    if ($pass) {
      
      $_SESSION["login"] = true;
      
      if (isset($_POST["remember"])) {
        setcookie('id', $result["id"], time() + 60 );
        setcookie('cek', hash('sha256', $result["username"]), time() + 60 );
      }
      
      header("Location: index.php");
      exit;
    } else {
      $error = true;
    }
    
    
    
    
  }
    
  
}


?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <title>login</title>
    <style>
      div.box {
        border-radius: 10px;
      }
      button.btn, a.btn {
        padding: 10px 105px;
      }
    </style>
  </head>
  <body class="bg-primary text-center">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="box p-3 bg-white mt-5">
            <h1 class="mb-4 mt-3">Masuk</h1>
            <?php if(isset($error)) : ?>
              <p style="color:red;">Username atau password salah</p>
            <?php endif; ?>
            <form action="" method="post">
              <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Username.." name="username">
              </div>
              <div class="input-group mb-3">
                <input type="password" class="form-control" placeholder="Password.." name="password">
              </div>
              <div class="mb-3">
                <label>
                  <input type="checkbox" value="remember-me" class="mb-4" name="remember"> Remember me
                </label>
                
                <button type="submit" class="btn btn-primary text-center text-white mb-3" name="login">Login</button>
                <p>belum punya akun?</p>
                <a href="register.php" class="btn btn-primary">Daftar</a>
                <p class="mt-3 mb-2 text-muted">&copy; 2017–2021</p>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    
    
    
    
    

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
    -->
  </body>
</html>