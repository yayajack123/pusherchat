<?php
require_once("koneksi.php");

if(isset($_POST['password'])){

    $password = $_POST['password'];
    $id_group = $_POST['id_group'];
    $id_user = $_POST['id_user'];
    $nama = $_POST['nama'];
    $alias = $_POST['alias'];
    $admin = $_POST['admin'];
    $select_pass = "SELECT passcode from tb_group where id=$id_group";

    $print = mysqli_query($conn, $select_pass);
    $res = mysqli_fetch_assoc($print);
    $passcode = $res['passcode']; 
            if($password == $passcode ){
                $sql = "INSERT INTO `tb_moderasi` (`id_user`, `id_group`,`status`,`alias`)
                VALUES ($id_user, $id_group,'0','$alias')";

                if (mysqli_query($conn, $sql)) {
                    $success = 'TRUE';
                    header("Location: index.php?success=".$success);
                } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
                
            }else if($password != $passcode) {
                header("Location : password_group.php");
            }
               
}
?>