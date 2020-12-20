<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "messages";


$conn = new mysqli($servername, $username, $password, $dbname);
$sql = "SELECT * FROM tb_outbox ORDER BY id_outbox ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0){
  $response = array();
	while($row = $result->fetch_assoc()) {
    $h['id_outbox'] = $row["id_outbox"];
    $h['tgl'] = $row["tgl"];
    $h['pesan'] = $row["pesan"];
    $h['keterangan'] = $row["keterangan"];
    $h['id_sender'] = $row["id_sender"];
    array_push($response, $h);
  }
}else {
  $response["message"]="tidak ada data"; 
}

echo json_encode($response);
    