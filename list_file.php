<?php 
require_once("auth.php"); 
include_once 'config.php';
include_once 'koneksi.php';

$id_user = $_SESSION['user']['id'];
$id_group = $_GET['id_group'];
$all_file = "SELECT * FROM tb_materi WHERE id_group = $id_group";
$all_admin = "SELECT id_user FROM tb_moderasi WHERE id_group = $id_group and is_admin = '1'";

$file = $db->prepare($all_file);
$admin = $db->prepare($all_admin);

$file->execute();
$admin->execute();

$data_file = $file->fetchAll();
$data_admin = $admin->fetchAll();


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
    <?php
        foreach ($data_admin as $row ) {
            $is_admin = $row['id_user'];
            if ($id_user == $is_admin ) {?>

                <form method="POST" action="upload.php" enctype="multipart/form-data">
                    <div class="form-group">
                    <label for="exampleFormControlFile1">Upload File disini</label>
                    <input type="hidden" name="id_group" value="<?php echo $id_group ?>">
                    <input type="file" name="upload" class="form-control-file" id="exampleFormControlFile1">
                    <button type="submit" class="btn btn-success mt-2" name="submit"><span class="glyphicon glyphicon-upload"></span> Upload</button>
                    </div>
                </form> 
            <?php
            }
        }
    ?>
    
  
       <br /><br />
       <div class="form-group">
       
         <table id="example" class="table-bordered" style="width:100%">
           <thead>
             <tr>  
               <th>File Name</th>
               <th>Action</th>
             </tr>
           </thead>
           <tbody >
             <?php
             foreach ($data_file as $fetch) {
              ?>
              <tr>
               <?php 
               $name = explode('/', $fetch['file']);
               ?>
               <td><?php echo $fetch['name']?></td>
               <td><a href="download.php?file=<?php echo $name[1]?>" class="btn btn-primary"><span class="glyphicon glyphicon-download"></span> Download</a></td>
       
             </tr>
             <?php
           }
           ?>
         </tbody>
        </table>
       
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