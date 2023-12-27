<?php
session_start();

if (!isset($_SESSION['uemail']))   // if someone is not logged in and opens the password update url it will redirect to login page
{
  header("refresh:0; url=login.php");
}
else 
{
require 'connect_object.php';
$db = new database('localhost','root','123456','object');
$db->toconnect();

$opassword=$_POST['oldpassword'];
$npassword=$_POST['newpassword'];

$tabv="stu";
$colv=array("*");
$conditionv="`password`='$opassword'";
$v=$db->fetchdatatoform($tabv,$colv,$conditionv);

if($v==0)
  {
   header("location: verify.php?error=t"); 
  }

else{
 $col=array("password");
 $row=array("$npassword");
 $db->update($tabv,$conditionv,$col,$row);
 $tabv2="times";
 $db->update($tabv2,$conditionv,$col,$row);
}
header("refresh:0; url=verify.php?msg=0");
}
?>

