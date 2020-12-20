<?php 
require_once("auth.php"); 
include_once 'config.php';
include_once 'koneksi.php';

$id_group = $_GET['id_group'];
$check_join = "SELECT tb_moderasi.id_user,users.name,tb_moderasi.id_group, tb_moderasi.status_join from tb_moderasi 
                JOIN users ON tb_moderasi.id_user = users.id
                WHERE id_group=$id_group and status_join = '0'";

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
                <?php
                foreach ($hasil_check as $key ) {?>
                     <form class="form-inline">
                        <div class="form-group mb-2">
                          <label for="staticEmail2" class="sr-only">Email</label>
                          <input type="text" readonly class="form-control-plaintext" id="staticEmail2" value="<?php echo $key['name']; ?>">
                        </div>
        
                        <div class="form-group mx-sm-3 mb-2">
                            <a id="allow" href="allow.php?id=<?php echo $key['id_user']; ?>&id_group=<?php echo $id_group; ?>" class="btn btn-primary" >Allow</a>
                        </div>
                          <a id="decline" href="decline.php?id=<?php echo $key['id_user']; ?>&id_group=<?php echo $id_group; ?>" class="btn btn-danger mb-2">Decline</a>
                      </form>
                 <?php
                }

                ?>
               
            </div>
           
        </div>
  </div>
<!-- Footer -->

<!-- Footer -->
</body>
<script type="text/javascript">        
  // AJAX request
  function ajaxCall(ajax_url, ajax_data) {
        $.ajax({
            type: "POST",
            url: ajax_url,
            dataType: "json",
            data: ajax_data,
            success: function(response, textStatus, jqXHR) {
                console.log(jqXHR.responseText);
            },
            error: function(msg) {}
        });
    }


  </script>