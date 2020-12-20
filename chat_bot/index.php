<?php 
require_once("../auth.php"); 
include_once '../config.php';

$id_user = $_SESSION["user"]["id"];
$name = $_SESSION["user"]["name"];

$user = "SELECT * FROM users ";
$sql = "SELECT * FROM tb_chat WHERE id_sender = $id_user ORDER BY id ASC";
$inbox = "SELECT * FROM tb_inbox WHERE id_sender = $id_user ORDER BY id ASC";


$chat_data = $db->prepare($sql);
$admin_data = $db->prepare($user);
$inbox_data = $db->prepare($inbox);

$chat_data->execute();
$admin_data->execute();
$inbox_data->execute();

$hasil = $chat_data->fetchAll();
$print = $admin_data->fetchAll();
$data_inbox = $inbox_data->fetchAll();

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
<link rel="stylesheet" href="/../chat.css">
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
       
			</div>
		</div>
	  </div>
	  <div class="inbox_chat scroll">
		<div class="chat_list">
		  <div class="chat_people">
			<div class="chat_img"> <img src="/6274.jpg" alt="sunil"> </div>
			<div class="chat_ib">
			  <p>Lihat pengumuman</p>
			</div>
		  </div>
    </div>
    
      
            <div class="chat_list">
              <div class="chat_people">
                <div class="chat_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
                <div class="chat_ib">
                   
                    <h5>Bot Chat</h5>
                    <p>Auto Reply</p>    
                </div>
              </div>
            </div>
		
	  </div>
	</div>
	<div class="mesgs">
	  <div class="msg_history" id="message_display">
    <?php
        foreach ($hasil as $row ) {

          if ($row['id_sender'] == $id_user && $row['tipe_pesan'] == '1' ) {
            
            echo '
            <div class="outgoing_msg">
              <div class="sent_msg">
              <p>'.$row['pesan'].'</p>
              <span class="time_date">'.$name.'</div>
            </div>
            
            ';
          }else{
            echo'
            <div class="incoming_msg mt-4">
              <div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div>
              <div class="received_msg">
              <div class="received_withd_msg">
                <p>'.$row['pesan'].'</p>
                <span class="time_date">Bot</div>
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
      <input type="text" id="username" style="display: none" value="<?php echo $_SESSION["user"]["name"] ?>"  />
        <input type="file" id="upload_file" name="upload" class="form-control" id="exampleFormControlFile1" style="display: none">
        <button class="file_btn" id="btn-file" type="file"><i class="fa fa-plus" aria-hidden="true"></i></button>
        <button class="cancel_btn" id="btn-cancel" type="submit" style="display: none;"><i class="fa fa-times" aria-hidden="true"></i></button>
      
        <input type="text" class="write_msg" id="input_message" placeholder="Type a message" />
        <button class="msg_send_btn" id="btn-send" type="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
		  
		</div>
	  </div>
  </div>
</div>

</body>
<script type="text/javascript">
    var id = $('#id_user').val();
    console.log(id);
    var username = $('#username').val();
    console.log(username);
   
  
    // Enter your own Pusher App key
    var pusher = new Pusher('5ca5d1e4e0e74c0266f2', {
        cluster: 'ap1'
      });
    var btn = document.getElementById("btn-send");
    var layout_chat = document.getElementById("message_display");
    // Enter a unique channel you wish your users to be subscribed in.
    var channel = pusher.subscribe('bot_channel');
    channel.bind('bot_event', function(data) {
        console.log(data.data.id_sender);
        if(data.data.id_sender == id){
        
          $('#message_display').append('<div class="incoming_msg mt-4">' +
                  '<div class="incoming_msg_img"> <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil"> </div> '+
                  ' <div class="received_msg">' +
                  '<div class="received_withd_msg">'+
                  '<p>'+data.data.pesan+'</p>'+
                  '<span class="time_date">Bot</span> </div>'+
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

        $('#message_display').append('<div class="outgoing_msg">' + 
                  '<div class="sent_msg">' +
                  '<p>'+message+'</p>'+
                  '<span class="time_date">'+ username +'</span> </div>'+
                  '</div>');
       
        // Validate Name field
        if ( message === '' ) {
            alert('Pesan tidak boleh kosong boy');
       
        } else if (message !== '' ) {
            // Define ajax data
            var chat_message = {
                id_sender : id,
                name : username, 
                pesan : message,
            }
            console.log(chat_message);
            // Send the message to the server
            
            ajaxCall('server_bot.php', chat_message);
            
            
            // Clear the message input field
            $('#input_message').val('');
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





 