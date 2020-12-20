<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "messages";

// Check the receive message

if(isset($_POST['pesan']) && !empty($_POST['pesan'])) {    
  
    $id_user = $_POST['id_sender'];
    $pesan = $_POST['pesan'];

    // Return the received message
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        $sql = "INSERT INTO `tb_inbox` ( `tgl`,`pesan`,`id_sender`,`tipe_pesan`)
        VALUES (now(), '$pesan',$id_user, 'text')";

        if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
            $chat = "INSERT INTO `tb_chat` ( `pesan`,`id_sender`,`tipe_pesan`)
            VALUES ('$pesan',$id_user, '1')";
            if (mysqli_query($conn, $chat)) {echo "New record created successfully";}
            else{
                echo "error";
            }
        } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        mysqli_close($conn);             
        echo 'success';        
    
}