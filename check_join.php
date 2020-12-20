<?php
require_once("auth.php");
include_once 'config.php';
include_once 'koneksi.php';


if (isset($_GET['id_group'])) {

$id_user = $_SESSION["user"]["id"];
$id_group = $_GET['id_group'];
$nama = $_GET['nama'];
$admin = $_GET['admin'];

$not_anggota_grup = "SELECT tb_moderasi.id_user,users.name,tb_moderasi.id_group, status_join from tb_moderasi 
                JOIN users ON tb_moderasi.id_user = users.id
                WHERE id_group = $id_group and id_user = $id_user";

$print = mysqli_query($conn, $not_anggota_grup);
$res = mysqli_fetch_assoc($print);
$status = $res['status_join'];

    if (empty($res)) {
        echo 'belum daftar';
        echo "<script type='text/javascript'> document.location = 'password_group.php?id_group=$id_group&nama=$nama&admin=$admin'; </script>";
    }else if($status == '0'){
        echo 'belum diverifikasi';
        echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
    }else if($status == '1'){
        echo "<script type='text/javascript'> document.location = 'chat.php?id_group=$id_group&nama=$nama&admin=$admin'; </script>";
    }
}
