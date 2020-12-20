<?php
require_once 'koneksi.php';

if(ISSET($_POST['submit'])){
 if($_FILES['upload']['name'] != "") {
  $file = $_FILES['upload'];
  $id_group = $_POST['id_group'];
  
  $file_name = $file['name'];
  $file_temp = $file['tmp_name'];
  $name = explode('.', $file_name);
  $path = "files/".$file_name;
  
//   $conn->query("INSERT INTO `file` VALUES('', '$name[0]', '$path')") or die(mysqli_error());
  $sql = "INSERT INTO `tb_materi` VALUES('', '$name[0]', '$path', $id_group)";
  
  if (mysqli_query($conn,$sql)) {
        move_uploaded_file($file_temp, $path);
        header("location:list_file.php?id_group=".$id_group);     
  }else {
      echo 'error';
  }
  
  
 }else{
  echo "<script>alert('Required Field!')</script>";
  echo "<script>window.location='index.php'</script>";
 }
}
?>