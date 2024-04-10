<?php

$id = $_GET['id'];

$bd1=new PDO("mysql:host=localhost;dbname=atelier_web;charset=utf8","root","");
$sql1="SELECT * FROM photo WHERE id_employe=$id ";
$stat1=$bd1->prepare($sql1);
$stat1->execute();
$result1=$stat1->fetch(PDO::FETCH_ASSOC);

header("Content-type: image/jpeg");
  echo $result1['image'];
?>
