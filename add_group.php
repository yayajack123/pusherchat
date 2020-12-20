<?php require_once("auth.php"); ?>
<!DOCTYPE html>
<head>
  <title>Pusher Test</title>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js" type="text/javascript" ></script>
  <script src="https://js.pusher.com/7.0/pusher.min.js"></script>   
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js" type="text/javascript" ></script>  
<script src="//cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.3.0/bootbox.min.js" type="text/javascript" ></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

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
        
    <div class = "col-md-4">
        <div class="card">
            <div class="card-header">Tambah Grup</div>
            <div class="card-body">
                <form method="post" action="/insert_group.php">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Nama Group</label>
                      <input type="test" class="form-control" name="nama" placeholder="Masukan nama group">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Deskripsi</label>
                      <input type="text" class="form-control" name="deskripsi" id="exampleInputPassword1" placeholder="Deskripsi">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Passcode</label>
                      <input type="password" class="form-control" name="passcode" id="exampleInputPassword1" placeholder="Passcode">
                    </div>
                    <input type="text" style="display: none" class="form-control" value="<?php echo $_SESSION["user"]["id"] ?>" name="id_admin" id="exampleInputPassword1" placeholder="Deskripsi" >
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </form>

            </div>
            
        </div>                                
      </div>
      <div class = "col-md-4">
                                      
      </div>
     
    
    </div>     
    
    </div>
</body>
<script type="text/javascript">        

  </script>