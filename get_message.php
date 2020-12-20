<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "messages";


$conn = new mysqli($servername, $username, $password, $dbname);
$sql = "SELECT * FROM tb_outbox ORDER BY id_outbox ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0){

	while($row = $result->fetch_assoc()) {

?>
<div id="chat_data" class="alert alert-primary " role="alert" style="display:inline-block;">
    <span><strong><?php echo $row['keterangan']; ?></strong></span>:
    <span><?php echo $row['pesan']; ?></span><br>
    <span><?php echo $row['tgl']; ?></span>
    
</div>
<br>
<?php
  } 
}
else 
{
	?>
    <div id="chat_data" class="alert alert-primary" role="alert">
		<center>
    <span><strong><?php echo 'Tidak Ada Riwayat Pesan'; ?></strong></span><br>
    <span><?php echo 'Mulai chat dengan yang lain'; ?></span>
		</center>
</div>
<?php
}
?>