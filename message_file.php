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

if(isset($_POST['file']) && !empty($_POST['file'])) {    
    $data['id_sender'] = $_POST['id_sender'];
    $data['keterangan'] = $_POST['name'];
    $data['group'] = $_POST['group'];
    $data['file'] = $_POST['file'];
    $id_user = $_POST['id_sender'];
    $file = $_POST['file'];
    $name = $_POST['name'];
    $group = $_POST['group'];

    // Return the received message
    if($pusher->trigger('test_channel', 'my_event', $data)) { 
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        $update = "UPDATE `tb_materi` SET id_group=$group where tb_materi.name LIKE '$file%'";

        if (mysqli_query($conn, $update)) {

            $sql = "INSERT INTO `tb_chat_group` (`id_chat`, `tgl`,`pesan`,`keterangan`,`id_sender`,`tipe_pesan`)
             VALUES ($group, now(), '$file', '$name',$id_user,'file')";

                if (mysqli_query($conn, $sql)) {
                echo "New record created successfully";
                } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
        
        } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
        
        


        mysqli_close($conn);             
        echo 'success';        
    } else {       
        echo 'error';  
    }
}