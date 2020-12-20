<?php
    include_once 'config.php';

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

    $success  = "";
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "messages";
    if(isset($_POST['id_anggota']))
    { 
        $data['id_anggota'] = $_POST['id_anggota'];
        $data['group'] = $_POST['group'];  
        $anggota  = $_POST['id_anggota'];
        $group = $_POST['group'];
        $conn = new mysqli($servername, $username, $password, $dbname);
        if($pusher->trigger('test_channel', 'my_event', $data)) { 
            foreach ($anggota as $row) {
                $id = $row['id_user'];
                $sql = "UPDATE `tb_moderasi` SET status='1' where id_group=$group AND id_user = $id";

                if (mysqli_query($conn, $sql)) {
                echo "New record created successfully";
                } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            }
        }
    }
?> 