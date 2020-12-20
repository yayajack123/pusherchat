<?php
require_once 'koneksi.php';

if(isset($_FILES['file']['name'])){

  $file = $_FILES['file'];
  // $name = $_POST['nama'];
  // $id_sender = $_POST['id_sender'];
  
  $file_name = $file['name'];
  $file_temp = $file['tmp_name'];
  $name = explode('.', $file_name);
  $path = "files/".$file_name;
  
//   $conn->query("INSERT INTO `file` VALUES('', '$name[0]', '$path')") or die(mysqli_error());
  $sql = "INSERT INTO `tb_materi` VALUES('', '$file_name', '$path', '')";
  
  if (mysqli_query($conn,$sql)) {
        move_uploaded_file($file_temp, $path);
        header("location:index.php");     
  }else {
      echo 'error';
  }
  
  
 }else{
  echo "<script>alert('Required Field!')</script>";
  echo "<script>window.location='index.php'</script>";
 }
?>