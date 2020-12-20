<?php 
require_once("auth.php"); 
include_once 'config.php';
include_once 'koneksi.php';

$id_user = $_SESSION['user']['id'];
$id_group = $_GET['id_group'];
$nama = $_GET['nama'];
$admin = $_GET['admin'];
$check_join = "SELECT tb_moderasi.id_user,users.name,tb_moderasi.id_group, tb_moderasi.status_join from tb_moderasi 
                JOIN users ON tb_moderasi.id_user = users.id
                WHERE id_user=$id_user and id_group = $id_group";

$join_check = $db->prepare($check_join);
$join_check->execute();
$hasil_check = $join_check->fetchAll();


?>
<!DOCTYPE html>
<head>
  <title>Pusher Test</title>
  <script src="https://js.pusher.com/7.0/pusher.min.js"></script>    
<script src="//cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.3.0/bootbox.min.js" type="text/javascript" ></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
  <nav class="navbar navbar-light bg-light">
    <span class="navbar-brand mb-0 h1">Pusher Chat App</span>
    <ul class="nav justify-content-end">
      <li class="nav-item">
        <span class="navbar-brand mb-0 h5"><?php echo $_SESSION["user"]["name"] ?></span>
      </li>
      <li class="nav-item">
        <a class="nav-link active" href="/logout.php">Log Out</a>
      </li>
     
    </ul>
  </nav>
  <div class = "container mt-4"> 
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <form action="validate_password.php" method="POST" >
                  <div class="form-group">
                    <label for="exampleInputEmail1">Nama :</label>
                    <input type="text" class="form-control" name="alias"  placeholder="Masukan nama sesuai format : nama_nim">
                  </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Password Grup</label>
                        <input type="password" class="form-control" name="password"  placeholder="Masukan password">
                        <input type="hidden" name="id_group" value='<?php echo $id_group; ?>'>
                        <input type="hidden" name="nama" value='<?php echo $nama; ?>'>
                        <input type="hidden" name="admin" value='<?php echo $admin; ?>'>
                        <input type="hidden" name="id_user" value='<?php echo $id_user; ?>'>
                      </div>
                      
                      <input type="submit" class="btn btn-primary btn-block" value="Submit">
                </form>
            </div>
            <div class="col-md-4"></div>
        </div>
  </div>
<!-- Footer -->

<!-- Footer -->
</body>
<script type="text/javascript">        
  $("#validate_form").submit(function(e){
      $('#modal_password').modal('show');
      return false;
  });
  </script>