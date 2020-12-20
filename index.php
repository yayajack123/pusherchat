<?php 
require_once("auth.php"); 
include_once 'config.php';
include_once 'koneksi.php';


$id_user = $_SESSION['user']['id'];

$query = "SELECT * FROM tb_group ORDER BY id DESC";
$not_admin = "SELECT * FROM users WHERE id != $id_user";
$check_join = "SELECT tb_moderasi.id_user,users.name,tb_moderasi.id_group, tb_moderasi.status_join from tb_moderasi 
                JOIN users ON tb_moderasi.id_user = users.id
                WHERE id_user=$id_user";

$join_check = $db->prepare($check_join);
$anggota = $db->prepare($not_admin);
$statement = $db->prepare($query);

$anggota->execute();
$statement->execute();
$join_check->execute();

$result_check = $join_check->fetchAll();
$hasil = $anggota->fetchAll();
$result = $statement->fetchAll();


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
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Pusher Chat</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="/chat_bot/index.php">Chat Bot <span class="sr-only">(current)</span></a>
        </li>
      </ul>
      <span class="navbar-text">
        <a class="btn btn-danger" href="/logout.php">Log out </a>
      </span>
    </div>
  </nav>
  <div class ="container mt-4"> 
    <?php
    if(isset($_GET['success'])){
         ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Selamat!</strong> Tunggu admin untuk mengijinkan anda masuk ke group chat.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
      <?php
        }

    ?>
    
    <div class="row">   
    
      <?php
          foreach ($result as $row ) {
            $id_admin = $row['id_admin'];
            $id_group = $row['id'];

            if ($id_user == $id_admin ) {?>
              
            <div class="col-md-4 mt-4">
              <div class="card">
                <img class="card-img-top" src="/6274.jpg" alt="Card image cap">
                <div class="card-body">
                  <h5 class="card-title"><?php echo $row['nama']; ?></h5>
                  <p class="card-text"><?php echo $row['deskripsi']; ?></p>
                  <form method="get" action="chat.php">
                    <input type="hidden" name="id_group" value='<?php echo $row['id']; ?>'>
                    <input type="hidden" name="nama" value='<?php echo $row['nama']; ?>'>
                    <input type="hidden" name="admin" value='<?php echo $row['id_admin']; ?>'>
                    <input type="submit" class="btn btn-primary btn-block" value ="Join Chat">
                </form>
                <button type="button" class="btn btn-primary btn-block mt-2" data-toggle="modal" data-target="#myModal<?php echo $row['id']; ?>">Add Admin</button>
                </div>
              </div>  
              </div>
              <?php
            
          }else{?>
            <div class="col-md-4 mt-4">
              <div class="card">
                <img class="card-img-top" src="/6274.jpg" alt="Card image cap">
                <div class="card-body">
                  <h5 class="card-title"><?php echo $row['nama']; ?></h5>
                  <p class="card-text"><?php echo $row['deskripsi']; ?></p>
                  <form method="get" action="check_join.php">
                    <input type="hidden" name="id_group" value='<?php echo $row['id']; ?>'>
                    <input type="hidden" name="nama" value='<?php echo $row['nama']; ?>'>
                    <input type="hidden" name="admin" value='<?php echo $row['id_admin']; ?>'>
                    <input type="submit" class="btn btn-primary btn-block" value ="Join Chat">
                </form>
                 </div>
              </div>  
              </div>
          <?php
          }?>
            <div class="modal" id="myModal<?php echo $row['id']; ?>" >
              <div class="modal-dialog">
                <div class="modal-content">

                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Tambah Admin</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>


                  <!-- Modal body -->
                  <div class="modal-body">
                    <form method="post" action="/insert_admin.php">

                      <?php
                      $id = $row['id']; 
                      $query_edit = mysqli_query($conn,"SELECT * FROM tb_group WHERE id='$id'");
                      //$result = mysqli_query($conn, $query);
                      while ($row = mysqli_fetch_array($query_edit)) {  
                      ?>

                      <div class="form-group">
                        <input type="hidden" name="id_group" value="<?php echo $row['id']; ?>">
                        <label for="exampleInputEmail1">Nama Group</label>
                        <input type="text" class="form-control" name="nama" value="<?php echo $row['nama']; ?>" placeholder="Masukan nama group">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword1">Admin Baru</label>
                          <select class="form-control" id="sel1" name="user">
                            <?php
                            foreach ($hasil as $row ) {?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                            <?php
                            }?>
                          </select>
                      </div>
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                  </div>
                  <?php
               
                }
                ?>
                  <!-- Modal footer -->
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>

                </div>
              </div>
            </div>
            
            
            
          <?php
          }
      ?>                                
    </div> 
    <div class="text-center mt-4">
      <a href="/add_group.php" class="btn btn-primary">Tambah Group</a>
    
    </div> 
    <!-- Modal -->
  <div class="modal fade" id="modal_password" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Masukan Passcode</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p>Some text in the modal.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>
</div>

<!-- The Modal -->

<!-- Footer -->
<footer class="page-footer font-small blue">

  <!-- Copyright -->
  <div class="footer-copyright text-center py-3">© 2020 Copyright:
    <a href="https://mdbootstrap.com/">Juliarta Arya</a>
  </div>
  <!-- Copyright -->

</footer>
<!-- Footer -->
</body>
<script type="text/javascript">        
  $("#validate_form").submit(function(e){
      $('#modal_password').modal('show');
      return false;
  });
  </script>