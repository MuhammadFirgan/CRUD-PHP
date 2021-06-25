<?php
require "connect.php";

$keyword = $_GET["keyword"];


$result = mysqli_query($conn, "SELECT * FROM peserta WHERE nama LIKE '%".$keyword."%' OR
    email LIKE '%".$keyword."%' OR
    nomerhp LIKE '%".$keyword."%'");


?>

<table class="table table-bordered table-striped">
  <tr>
    <th>No.</th>
    <th>Nama</th>
    <th>Email</th>
    <th>No.hp</th>
    <th>Aksi</th>
  </tr>
         
  <?php $i = 1; ?>
  <?php while ($row = mysqli_fetch_assoc($result)) : 
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

