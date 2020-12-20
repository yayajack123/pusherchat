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
     
        $data['id_person_unmute'] = $_POST['id_anggota'];
        $data['id_group'] = $_POST['group'];
        $id_user = $_POST['id_anggota'];
        $group = $_POST['group'];
        $conn = new mysqli($servername, $username, $password, $dbname);
        if($pusher->trigger('test_channel', 'my_event', $data)) {       
                $sql = "UPDATE `tb_moderasi` SET status='0' where id_group=$group AND id_user = $id_user";

                if (mysqli_query($conn, $sql)) {
                    
                } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            
        }
?> 