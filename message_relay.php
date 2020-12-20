<?php
require __DIR__ . '/vendor/autoload.php';

// Change the following with your app details:
// Create your own pusher account @ www.pusher.com
$options = array(
    'cluster' => 'ap1',
    'useTLS' => true
);
$pusher = new Pusher\Pusher(
    '5ca5d1e4e0e74c0266f2',
    '55a786173c3b9d62e29f',
    '1107738',
    $options
);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "messages";



// Check the receive message

if(isset($_POST['pesan']) && !empty($_POST['pesan'])) {    
    $data['pesan'] = $_POST['pesan'];
    $data['id_sender'] = $_POST['id_sender'];
    $data['keterangan'] = $_POST['name'];
    $data['group'] = $_POST['group'];
    $id_user = $_POST['id_sender'];
    $pesan = $_POST['pesan'];
    $name = $_POST['name'];
    $group = $_POST['group'];

    // Return the received message
    if($pusher->trigger('test_channel', 'my_event', $data)) { 
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        $sql = "INSERT INTO `tb_chat_group` (`id_chat`, `tgl`,`pesan`,`keterangan`,`id_sender`,`tipe_pesan`)
        VALUES ($group, now(), '$pesan', '$name',$id_user,'text')";

        if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
        } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }


        mysqli_close($conn);                    
    } else {       
        echo 'error';  
    }
}