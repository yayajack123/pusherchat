<?php
    include_once 'config.php';
    $success  = "";
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "messages";
    if(isset($_POST['id_group']))
    {  
        $id_group  = $_POST['id_group'];
        $new_admin = $_POST['user'];
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        $detail = "UPDATE `tb_moderasi`  SET is_admin = '1' where id_group = $id_group and id_user = $new_admin";
        if (mysqli_query($conn, $detail)){
            echo 'success';
            header("Location: index.php");
               
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
?> 