<?php
session_start();
require "connect.php";

if (!isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

#tampilkan data

// $tampil = mysqli_query($conn, "SELECT * FROM peserta ORDER BY id DESC LIMIT 5");

#masukkan data
if ( isset($_POST["submit"]) ) {
   
  if ($_GET["act"] === "edit") {
    $id = $_GET["id"];
    $nama = htmlspecialchars($_POST["nama"]);
    $email = htmlspecialchars($_POST["email"]);
    $nohp = htmlspecialchars($_POST["nomerhp"]);
    
    $update = mysqli_query($conn, "UPDATE peserta SET nama = '$nama', email = '$email', nomerhp = '$nohp' WHERE id = $id");
    
    if ($update) {
      echo'
        <div class="alert alert-success" role="alert">
          Data berhasil diubah
        </div>';
    } else {
      echo'
        <div class="alert alert-danger" role="alert">
        Data gagal diubah</div>';
    }

  } else {
    $nama = htmlspecialchars($_POST["nama"]);
    $email = htmlspecialchars($_POST["email"]);
    $nohp = htmlspecialchars($_POST["nomerhp"]);
      
    $insert = mysqli_query($conn, "INSERT INTO peserta (nama, email, nomerhp) VALUES ('$nama', '$email', '$nohp')");
    
    if ($insert) {
      echo'
        <div class="alert alert-success" role="alert">
          Data berhasil ditambah
        </div>';
    } else {
      echo'
        <div class="alert alert-danger" role="alert">
        Data gagal ditambah</div>';
    }
  }
  
}

#hapus Data
if ($_GET["act"] === "hapus") {

  $id = $_GET["id"];
  $hapus = mysqli_query($conn, "DELETE FROM peserta WHERE id=$id");
}

#update Data

if ($_GET["act"] === "edit") {
  $data = $_GET["id"];
  $peserta = mysqli_query($conn, "SELECT * FROM peserta WHERE id=$data");
  $pes = mysqli_fetch_assoc($peserta);
  
  $vnama = $pes["nama"];
  $vemail = $pes["email"];
  $vnohp = $pes["nomerhp"];
  
}

#Cari

if (isset($_POST["keyword"])) {
  $keyword = $_POST["keyword"];
  $data = mysqli_query($conn, "SELECT * FROM peserta WHERE nama LIKE '%".$keyword."%' OR
    email LIKE '%".$keyword."%' OR
    nomerhp LIKE '%".$keyword."%'");
} else {
  $data = mysqli_query($conn, "SELECT * FROM peserta ORDER BY id DESC");
}

#pagination












?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

    <title>CRUD PHP & MySQL</title>
  </head>
  <body>
    <div class="container">
      
      <a href="logout.php" class="btn btn-success mt-4">Logout</a>
      
      <h1 class="text-center mt-3 mb-3">CRUD PHP & MySQL</h1>
      <div class="card mb-3">
        <div class="card-header bg-primary text-white">
          Tambah Data Peserta
        </div>
        <div class="card-body">
          <form action="" method="get">
            
            <input type="text" class="form-control mb-3" placeholder="Masukkan nama.." value="<?= $vnama; ?>" name="nama" required>
            <input type="text" class="form-control mb-3" placeholder="Masukkan email.." value="<?= $vemail; ?>" name="email" required>
            <input type="text" class="form-control mb-3" placeholder="Masukkan nomer hp.." value="<?= $vnohp; ?>" name="nomerhp" required>
            <button type="submit" name="submit" class="btn btn-success">Tambahkan Data</button>
          </form>
        </div>
      </div>
      
      
      <hr>
      <br>
      
      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Cari peserta..." aria-describedby="button-addon2" autofocus autocomplete="off" name="keyword" id="keyword">
          <button class="btn btn-primary" type="submit" id="tcari" name="cari">Cari</button>
        </div>
      </form>
      
     <br>
     <div id="content">
       <table class="table table-bordered table-striped">
        <tr>
          <th>No.</th>
          <th>Nama</th>
          <th>Email</th>
          <th>No.hp</th>
          <th>Aksi</th>
        </tr>
         
        <?php $i = 1; ?>
        <?php while ($row = mysqli_fetch_assoc($data)) : 
        ?>
        <tr>
          <td><?= $i; ?></td>
          <td><?= $row["nama"]; ?></td>
          <td><?= $row["email"]; ?></td>
          <td><?= $row["nomerhp"]; ?></td>
          <td>
            <a href="index.php?act=edit&id=<?= $row["id"]; ?>" class="btn btn-warning" name="edit" >Edit</a>
            <a href="index.php?act=hapus&id=<?= $row["id"]; ?>" onclick="return confirm('Apakah anda yakin untuk menghapus data ini?')" class="btn btn-danger">Hapus</a>
          </td>
        </tr>
          
        <?php $i++ ?>
        <?php endwhile; ?> 
          
      </table>
     </div>
        

    </div>
    
    
    
    
    
    
    
    
    

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    
    <script src="script.js"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
    -->
  </body>
</html>