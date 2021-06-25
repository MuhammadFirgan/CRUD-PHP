<?php
session_start();
require "connect.php";

if (!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}


if ( isset($_POST["register"])) {
  $username = strtolower(stripslashes($_POST["username"]));
  $password = mysqli_real_escape_string($conn, $_POST["password"]);
  $password2 = mysqli_real_escape_string($conn, $_POST["password2"]);
  
  if ($password !== $password2) {
    echo "<script>
            alert('konfirmasi password tidak sesuai')
            document.location.href = register.php
          </script>";
          
    return false;
  }
  
  
  
  $data = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
  
  if (mysqli_fetch_assoc($data)) {
    echo "<script>
            alert('user sudah terdaftar')
            document.location.href = register.php
          </script>";
          
          
    
    return false;
    
  }
  
  $password = password_hash("$password", PASSWORD_DEFAULT);
  
  $result = mysqli_query($conn, "INSERT INTO user (username, password) VALUES('$username', '$password')");
  
  if (mysqli_affected_rows($conn) > 0) {
    
    echo "<script>
            alert('Registrasi berhasil')
            document.location.href = login.php
          </script>";
    
          
    
    
  } else {
    echo "<script>
            alert('Registrasi gagal')
            document.location.href = register.php
          </script>";
          
    return false;
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

    <title>registrasi</title>
    <style>
      div.box {
        border-radius: 10px;
      }
      button.btn,a.btn {
        padding: 10px 105px;
      }
      
    </style>
  </head>
  <body class="bg-primary text-center">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="box p-3 bg-white mt-5">
            <h1 class="mb-4 mt-3">Registrasi</h1>
            <form action="" method="post">
              <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Username.." name="username">
              </div>
              <div class="input-group mb-3">
                <input type="password" class="form-control" placeholder="Password.." name="password">
              </div>
              <div class="input-group mb-3">
                <input type="password" class="form-control" placeholder="Konfirmasi password.." name="password2">
              </div>
              <div class="mb-3">
                <button type="submit" class="btn btn-primary text-center text-white mb-3" name="register">Daftar</button>

                <a href="login.php" class="btn btn-primary">Masuk</a>
                
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