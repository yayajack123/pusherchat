<?php
    include_once 'config.php';
    $success  = "";
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "messages";
    if(isset($_POST['nama']))
    {  
        $name  = $_POST['nama'];
        $deskripsi = $_POST['deskripsi'];
        $id_admin   = $_POST['id_admin'];
        $passcode   = $_POST['passcode'];
        
        $conn = new mysqli($servername, $username, $password, $dbname);
        $sql = "INSERT INTO `tb_group` (`nama`, `deskripsi`,`id_admin`,`passcode`)
        VALUES ('$name', '$deskripsi',$id_admin, '$passcode')";

        if (mysqli_query($conn, $sql)) {
            $result = mysqli_query($conn,"SELECT * FROM `tb_group` WHERE `nama` = '$name' ");
            $row = mysqli_fetch_array($result);

            $id = $row['id'];
            
            // $detail = "INSERT INTO `tb_admin_group` (`id_group`,`id_admin`)
            // VALUES ($id,$id_admin)";
            // if (mysqli_query($conn, $detail)){
            //     echo 'success';
            //     header("Location: index.php");
            // } 

            $detail = "INSERT INTO `tb_moderasi` (`id_group`,`id_user`,`status_join`,`is_admin`)
            VALUES ($id,$id_admin,'1','1')";
            if (mysqli_query($conn, $detail)){
                echo 'success';
                header("Location: index.php");
            } 

           
        } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
?> 