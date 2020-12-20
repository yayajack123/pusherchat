<?php 
require_once("auth.php"); 
include_once 'config.php';

$id_user = $_SESSION["user"]["id"];
$id_group = $_GET['id_group'];
$nama = $_GET['nama'];
$admin = $_GET['admin'];

$anggota_grup = "SELECT tb_moderasi.id_user,users.name,tb_moderasi.id_group, tb_moderasi.alias from tb_moderasi 
                JOIN users ON tb_moderasi.id_user = users.id
                WHERE id_group = $id_group and is_admin = '0' and status_join ='1'";

$mute_user = "SELECT * FROM tb_moderasi WHERE id_group = $id_group AND status='1' and status_join='1'"; 
$anggota = "SELECT tb_moderasi.id_user,users.name,tb_moderasi.id_group, tb_moderasi.alias from tb_moderasi 
                JOIN users ON tb_moderasi.id_user = users.id
                WHERE id_group = $id_group and is_admin = '0' and status_join ='1'";
$query_admin = "SELECT * FROM users ";
$sql = "SELECT * FROM tb_chat_group WHERE id_chat = $id_group ORDER BY id_outbox ASC";
$query = "SELECT * FROM tb_moderasi where id_user = $id_user AND id_group = $id_group";
$check_admin = "SELECT tb_moderasi.id_user,users.name,tb_moderasi.id_group,tb_moderasi.alias from tb_moderasi 
                JOIN users ON tb_moderasi.id_user = users.id
                WHERE id_group = $id_group and is_admin = '1'"; 


$mute_data = $db->prepare($mute_user);
$statement = $db->prepare($query);
$chat_data = $db->prepare($sql);
$admin_data = $db->prepare($query_admin);
$anggota_data = $db->prepare($anggota);
$admin_check = $db->prepare($check_admin);



$mute_data->execute();
$statement->execute();
$chat_data->execute();
$admin_data->execute();
$anggota_data->execute();
$admin_check->execute();


$print_admin = $admin_check->fetchAll();
$is_mute = $mute_data->fetchAll();
$result = $statement->fetchAll();
$hasil = $chat_data->fetchAll();
$print = $admin_data->fetchAll();
$is_anggota = $anggota_data->fetchAll();




?>
<!------ Include the above in your HEAD tag ---------->

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Pusher Chat App</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js" type="text/javascript" ></script>
  <script src="https://js.pusher.com/7.0/pusher.min.js"></script>   
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js" type="text/javascript" ></script>  
<script src="//cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.3.0/bootbox.min.js" type="text/javascript" ></script>
<script src="https://kit.fontawesome.com/afca9bf6c3.js" crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="/chat.css">
</head>
<body>

<div class="messaging">
  <div class="inbox_msg">
	<div class="inbox_people">
	  <div class="headind_srch">
		<div class="recent_heading">
		  <h4>Recent</h4>
		</div>
		<div class="srch_bar">
		  <div class="stylish-input-group">
      <a href="/list_file.php?id_group=<?php echo $id_group; ?>" class="btn btn-info btn-sm" style="color: white;" ><i class="far fa-folder-open"></i></a>
      <?php
        $id_user = $_SESSION["user"]["id"];
          if($admin == $id_user){
            if (empty($is_mute)) {
              echo'
                <button type="submit" id="btn-mute" class="btn btn-danger btn-sm" style="color: white;"><i class="fas fa-comment-slash"></i></button>
                <button type="submit" id="btn-on" class="btn btn-primary btn-sm" style="color: white;" disabled><i class="far fa-keyboard"></i></button>
                            
            ';
            }else{

              echo'
              <button type="submit" id="btn-mute" class="btn btn-danger btn-sm" style="color: white;" disabled>Mute All</button>
              <button type="submit" id="btn-on" class="btn btn-primary btn-sm" style="color: white;">Unmute All</button>
              
              ';
            }

            
            }
          
      ?>
       
			</div>
		</div>
	  </div>
	  <div class="inbox_chat scroll">
		<div class="chat_list">
		  <div class="chat_people">
			<div class="chat_img"> <img src="/6274.jpg" alt="sunil"> </div>
			<div class="chat_ib">
        <?php
        if ($id_user == $admin) {?>
          <h5><?php echo $nama ?><span class="chat_date"><a class="btn btn-success btn-sm" href="waiting_list.php?id_group=<?php echo $id_group; ?>">
          <i class="fas fa-user-clock"></i></a></span></h5>

        <?php
        }
			  
          ?>
			  <p>Lihat pengumuman</p>
			</div>
		  </div>
    </div>
    
      <?php
        foreach($print_admin as $row)
          {
            echo '
            <div class="chat_list">
              <div class="chat_people">
                <div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                <div class="chat_ib">
                   
                    <h5>'.$row['alias'].'</h5>
                    <p>Admin Group</p>    
                </div>
              </div>
            </div>
          ';
        }
      ?>
      <?php
      foreach($is_anggota as $row)
        {
          foreach ($print_admin as $key ) {
           
          $admin_id = $key['id_user'];
          $anggota_id = $row['id_user'];
          ?>
          <div class="chat_list">
            <div class="chat_people">
              <div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
              <div class="chat_ib">
                <?php
                if ($id_user == $admin_id) {
                  echo'
                  <h5>'.$row['alias'].'<span class="chat_date" alt="user allow to typing"> 
                        <a class="mute_person" id="'.$anggota_id.'" ><i class="fas fa-comment-slash" style="color: red;"></i>
                          <a class="unmute_person"  id="'.$anggota_id.'" ><i class="fas fa-comment-dots" style="color: #0465ac;"></i>
                        </a></span>
                      </h5>
                          
                      <p>Anggota Grup</p>
                '; 
                }else{
                  echo'
                  <h5>'.$row['alias'].'<span class="chat_date" alt="user allow to typing"> 
                      </h5> 
                      <p>Anggota Grup</p>
                      
                '; 
                }
                
                ?>   
              </div>
            </div>
          </div>
        <?php
          }
      }
    ?>
		
	  </div>
	</div>
	<div class="mesgs">
	  <div class="msg_history" id="message_display">
    <?php
        $id_user = $_SESSION["user"]["id"];
        foreach ($hasil as $row ) {

          if ($row['id_sender'] == $id_user && $row['tipe_pesan'] == 'text' ) {
            
            echo '
            <div class="outgoing_msg">
              <div class="sent_msg">
              <p>'.$row['pesan'].'</p>
              <span class="time_date">'.$row['keterangan'].'</div>
            </div>
    
            ';

          }else if ($row['id_sender'] != $id_user && $row['tipe_pesan'] == 'text' ){
            echo'
            <div class="incoming_msg mt-4">
              <div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
              <div class="received_msg">
              <div class="received_withd_msg">
                <p>'.$row['pesan'].'</p>
                <span class="time_date">'.$row['keterangan'].'</div>
              </div>
            </div>
            
            
            ';
          }else if ($row['id_sender'] == $id_user && $row['tipe_pesan'] == 'file' ){

            echo '
            <div class="outgoing_msg">
              <div class="sent_msg">
              <a href="download.php?file='.$row['pesan'].'"><img src="/document.png" style="width: 100px;height :100px;" class="img-thumbnail"></a>
              <p>'.$row['pesan'].'</p>
              <span class="time_date">'.$row['keterangan'].'</div>
            </div>
    
            ';
          }else if ($row['id_sender'] != $id_user && $row['tipe_pesan'] == 'file' ){
            echo'
            <div class="incoming_msg mt-4">
              <div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
              <div class="received_msg">
              <div class="received_withd_msg">
                <a href="download.php?file='.$row['pesan'].'"><img src="/document.png" style="width: 100px;height :100px;" class="img-thumbnail"></a>
                <p>'.$row['pesan'].'</p>
                <span class="time_date">'.$row['keterangan'].'</div>
              </div>
            </div>
            
            ';
          }

        }

      ?>
        
    </div>
    <div class="type_msg">
		<div class="input_msg_write">
      
      <input type="number" id="id_user" style="display: none" value="<?php echo $_SESSION["user"]["id"] ?>"  />
        <input type="text" id="name" style="display: none" value="<?php echo $_SESSION["user"]["name"] ?>" />
        <input type="text" id="group" style="display: none" value="<?php echo $id_group ?>" />
        <input type="file" id="upload_file" name="upload" class="form-control" id="exampleFormControlFile1" style="display: none">
        <button class="file_btn" id="btn-file" type="file"><i class="fa fa-plus" aria-hidden="true"></i></button>
        <button class="cancel_btn" id="btn-cancel" type="submit" style="display: none;"><i class="fa fa-times" aria-hidden="true"></i></button>
      <?php
      
      $user_login = $_SESSION["user"]["id"];
      if (empty($is_mute) || $admin == $user_login) {
        echo'
        <input type="text" class="write_msg" id="input_message" placeholder="Type a message" />
        <button class="msg_send_btn" id="btn-send" type="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>

        ';
      }else{
        foreach ($is_mute as $value ) {
          if ($value['id_user'] == $user_login) {

            echo'
           
            <input type="text" class="write_msg" id="input_message" placeholder="Type a message" disabled/>
		        <button class="msg_send_btn" id="btn-send" type="submit" disabled><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
          
            ';
          }
      }
      }
      

      ?>
		  
		</div>
	  </div>
  </div>
</div>

</body>
<script type="text/javascript">
    var id = $('#id_user').val();
    console.log(id);
    var group = $('#group').val();
    console.log(group);
  
    // Enter your own Pusher App key
    var pusher = new Pusher('5ca5d1e4e0e74c0266f2', {
        cluster: 'ap1'
      });
    var btn = document.getElementById("btn-send");
    var btnmute = document.getElementById("btn-mute");
    var btnon = document.getElementById("btn-on");
    var layout_chat = document.getElementById("message_display");
    // Enter a unique channel you wish your users to be subscribed in.
    var channel = pusher.subscribe('test_channel');
    channel.bind('my_event', function(data) {
        console.log(data);
        if(data.file && data.id_sender == id){
          $('#message_display').append('<div class="outgoing_msg">' + 
                  '<div class="sent_msg">' +
                  '<a href="download.php?file='+data.file+'"><img src="/document.png" style="width: 100px;height :100px;" class="img-thumbnail"></a>'+
                  '<p>'+data.file+'</p>'+
                  '<span class="time_date">'+ data.keterangan +'</span> </div>'+
                  '</div>');
        }else if(data.file && data.id_sender != id){
          $('#message_display').append('<div class="incoming_msg mt-4">' +
                  '<div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div> '+
                  ' <div class="received_msg">' +
                  '<div class="received_withd_msg">'+
                  '<a href="download.php?file='+data.file+'"><img src="/document.png" style="width: 100px;height :100px;" class="img-thumbnail"></a>'+
                  '<p>'+data.file+'</p>'+
                  '<span class="time_date">'+ data.keterangan +'</span> </div>'+
                  '</div></div>');

        }

        else if(data.id_person_unmute == id && data.id_group == group){
          alert('Anda sudah bisa mengirim pesan');
          document.getElementById("input_message").disabled = false;
        
        
        }else if(data.id_person == id && data.id_group == group){
                alert('Anda telah di mute oleh admin');
                document.getElementById("input_message").disabled = true;
        
        }else if(data.unmute){
      
          $.each(data.unmute, function(k, v) {
              if(v.id_user == id && data.group == group){
                alert('Anda sudah bisa mengirim pesan');
                document.getElementById("input_message").disabled = false;
              }
          });
          
          }else if(data.id_anggota){
          $.each(data.id_anggota, function(k, v) {
              if(v.id_user == id && data.group == group){
                alert('Anda telah di mute oleh admin');
                document.getElementById("input_message").disabled = true;
              }
          });
        
        }else if(data.id_sender == id){
          $('#message_display').append('<div class="outgoing_msg">' + 
                  '<div class="sent_msg">' +
                  '<p>'+data.pesan+'</p>'+
                  '<span class="time_date">'+ data.keterangan +'</span> </div>'+
                  '</div>');
        }else if(data.id_sender > 0 && data.id_sender != id){
          $('#message_display').append('<div class="incoming_msg mt-4">' +
                  '<div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div> '+
                  ' <div class="received_msg">' +
                  '<div class="received_withd_msg">'+
                  '<p>'+data.pesan+'</p>'+
                  '<span class="time_date">'+ data.keterangan +'</span> </div>'+
                  '</div></div>');
        }
        
        // Display the send button
        document.getElementById("btn-send").disabled = false;
        // Scroll to the bottom of the container when a new message becomes available
        $("#message_display").animate({ scrollTop: $('#message_display').prop("scrollHeight")}, 1000);
    });
  
    
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
  
    
    // Trigger for the Enter key when clicked.
    $.fn.enterKey = function(fnc) {
        return this.each(function() {
            $(this).keypress(function(ev) {
                var keycode = (ev.keyCode ? ev.keyCode : ev.which);
                if (keycode == '13') {
                    fnc.call(this, ev);
                }
            });
        });
    }

    //Mute All

    $('body').on('click', '#btn-mute', function(e) {

      var obj = <?php echo json_encode($is_anggota); ?>;
      
      var mute = {
                id_anggota : obj, 
                group : $('#group').val(),
                status : '1',
            }
      console.log(mute);
      ajaxCall('mute_user.php', mute);
      document.getElementById("btn-mute").disabled = true;
      document.getElementById("btn-on").disabled = false;  

    });

    //UnMute All

    $('body').on('click', '#btn-on', function(e) {

      var obj = <?php echo json_encode($is_anggota); ?>;

      var mute = {
                id_anggota : obj, 
                group : $('#group').val(),
                status : '0',
            }

      ajaxCall('unmute_user.php', mute);

      document.getElementById("btn-mute").disabled = false;
      document.getElementById("btn-on").disabled = true;   

      });

      //Mute one person
      $('body').on('click', '.mute_person', function(e) {

      var id= $(this).attr('id');
      var mute = {
                id_anggota : id, 
                group : $('#group').val(),
                status : '0',
            }
      console.log(mute);

      ajaxCall('mute_person.php', mute);
 

      });

      //Mute one person
      $('body').on('click', '.unmute_person', function(e) {

          var id= $(this).attr('id');
          var mute = {
                    id_anggota : id, 
                    group : $('#group').val(),
                    status : '0',
                }
          console.log(mute);

          ajaxCall('unmute_person.php', mute);


          });
    
    //Mute one person
    $('body').on('click', '#btn-file', function(e) {

      $("#upload_file").show();
      $("#btn-file").hide();
      $("#btn-cancel").show();

    });

    $('body').on('click', '#btn-cancel', function(e) {

      $("#upload_file").hide();
      $("#btn-file").show();
      $("#btn-cancel").hide();

    });
    
    // Send the Message
    $('body').on('click', '#btn-send', function(e) {
        e.preventDefault();
       
        var message = $('#input_message').val();
        var name = $('#name').val();
        var group = $('#name').val();
        var files = $('#upload_file')[0].files;
        console.log(files.name);
       
        // Validate Name field
        if (name === '' && message === '' && files.length == 0) {
            alert('Pesan tidak boleh kosong boy');
       
        } else if (message !== '' && files.length == 0) {
            // Define ajax data
            var chat_message = {
                id_sender : id, 
                name: $('#name').val(),
                pesan : $('#input_message').val(),
                group : $('#group').val(),
                message: '<strong>' + $('#name').val() + '</strong>: ' + message
            }
            console.log(chat_message);
            // Send the message to the server
            
              ajaxCall('message_relay.php', chat_message);
            
            
            // Clear the message input field
            $('#input_message').val('');
            // Show a loading image while sending
            document.getElementById("btn-send").disabled = true;
        }else if(message === '' && files.length > 0){
          var fd = new FormData();
          var files = $('#upload_file')[0].files;
          
          fd.append('file',files[0]);
            //Define ajax data
            var chat_message = {
                id_sender : id, 
                name: $('#name').val(),
                file : files[0].name,
                group : $('#group').val(),
            }
            console.log(fd);
            //Send the message to the server
            
            $.ajax({
              url: 'message_server.php',
              type: 'post',
              data: fd,
              contentType: false,
              processData: false,
              success: function(response){
                 if(response != 0){
                   console.log(response);
                    alert('SUKSES');
                    ajaxCall('message_file.php', chat_message);
                 }else{
                    alert('file not uploaded');
                 }
              },
           });
            
            
            // Clear the message input field
            $('#input_message').val('');
            $('#upload_file').val('');
            // Show a loading image while sending
            document.getElementById("btn-send").disabled = true;

        }
    });
    
    // Send the message when enter key is clicked
    $('#input_message').enterKey(function(e) {
        e.preventDefault();
        $('#btn-send').click();
    });
    </script>
</html>





 