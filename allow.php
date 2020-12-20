<?php
// include database connection file
include_once("koneksi.php");

// Get id from URL to delete that user
$id = $_GET['id'];
$id_group = $_GET['id_group'];

// Delete user row from table based on given id
$result = mysqli_query($conn, "UPDATE tb_moderasi SET status_join = '1' WHERE id_user=$id and id_group=$id_group");

// After delete redirect to Home, so that latest user list will be displayed.
header("Location:waiting_list.php?id_group=".$id_group);
?>