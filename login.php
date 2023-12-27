<?php
session_start();

require 'connect_object.php';
$db = new database('localhost','root','123456','object');
$db->toconnect();
$time=date("y-m-d h:i:s");

$f=$_GET['e'];
if(isset($f))
{
  $tablev2="times";
  $colv3=array("outtime");
  $rowv3=array("$time");
  $conditionv2="`email`='$f'";
  $db->update($tablev2,$conditionv2,$colv3,$rowv3);
  
  session_unset();
  session_destroy();
  header("refresh:0; url=login.php?refreshed=0");
}
$ref=$_GET['refreshed'];
if(isset($ref))
{
  echo " session expired";
}

if (isset($_SESSION['uemail']))            // if already logged in resist to open login form again and send to its profile
{                  
   header("refresh:0; url=verify.php");
}

$err=$_GET['error'];
if(isset($err))
{
  echo "<script>alert('Invalid credentials');</script>";
  header("refresh:0; url=login.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST')    // this is basically done to receive value of form on this page only
{
    $useremail = $_POST['email'];
    $userpassword = $_POST['password'];
   
    $tabv="stu";
    $colv=array("*");
    $conditionv="`email`='$useremail' AND `password`='$userpassword'";
    
    $v=$db->fetchdatatoform($tabv,$colv,$conditionv);
    $newfname = $v['fname'];    
    $newlname = $v['lname'];
    $newbirthday = $v['dob'];
    $newaddress = $v['address'];
    $newcourse = $v['course'];
    $neweducation = $v['education'];   
  
  if($v==0)
  {
   header("location: login.php?error=t"); 
  }
  
  else
  {
    $colv2=array("email","password","intime","count");
    $tablev2="times";
    $conditionv2="`email`='$useremail' AND `password`='$userpassword'";
    $v2=$db->fetchdatatoform($tablev2,$colv2,$conditionv2);

      if($v2==0)
      { 
          $ri=$v2['count'];
          $ri++;
          $rowv2=array("$useremail","$userpassword","$time","$ri");
          $db->insertdata($tablev2,$colv2,$rowv2);
      }

      else
      { 
          $showemail=$v2['email'];
          $ru=$v2['count'];
          $ru++; 
          $colv3=array("intime","count");
          $rowv3=array("$time","$ru");
          $db->update($tablev2,$conditionv2,$colv3,$rowv3);
      }

    $_SESSION['ufname'] = $newfname;
    $_SESSION['ulname'] = $newlname;
    $_SESSION['ubday'] = $newbirthday;
    $_SESSION['uaddress'] = $newaddress;
    $_SESSION['ucourse'] = $newcourse;
    $_SESSION['ueducation'] = $neweducation;
    $_SESSION['uemail'] = $useremail;
  }
  
  header("refresh:0; url=verify.php");
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login Form</title>
  
  <style>
    
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
    }
    
    .container {
      max-width: 400px;
      margin: 0 auto;
      padding: 20px;
      background-color: #D2B48C;
      border-radius: 5px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
      border: 2px solid black;
    }
    
    h2 {
      text-align: center;
    }
    
    .form-group {
      margin-bottom: 20px;
    }
    
    .form-group label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px;
    }
    
    .form-group input,button {
      width: 95%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .form-group input,button {
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    
    .form-group input[type="submit"] {
      background-color: #8B4513;
      color: white;
      cursor: pointer;
      margin-right: 2px;
    }
    
    .form-group input[type="submit"]:hover {
      background-color: aqua;
      color: black;
    }

    .form-group button[type="button"] {
      background-color: #9370DB;
      color: white;
      cursor: pointer;
      margin-right: 2px;
    }
    
    .form-group button[type="button"]:hover {
      background-color: aqua;
      color: black;
    }
  </style>

</head>
<body>
  <div class="container">
    <h2>Login Form</h2>
    <form  method="POST" action="">
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email">
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password">
      </div>
      <div class="form-group">
        <input type="submit" value="Login" onclick="return validate()">
        <a href="form_object.php"><button type="button">Sign Up</button> 
      </div>
    </form>
  </div>
</body>

<script>

    function validate()
    {
      var email = document.getElementById("email");
      var password = document.getElementById("password");

      if (email.value == "") 
      {
      alert("email can't be empty");
      return false; 
      } 
      else if (!email.value.match(/^[a-zA-Z]+[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+[.]+[a-zA-Z0-9]+(?:\.[a-zA-Z0-9-]+)*$/)) 
      {
      alert("wrong format of email");
      return false; 
      }
      else if (password.value == "") 
      {
      alert("password can't be empty");
      return false;
      } 
      else if (!password.value.match('((?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{6,}))|((?=.*[a-z])(?=.*[A-Z])(?=.*[^A-Za-z0-9])(?=.{8,}))')) 
      {
      alert("wrong format of password");
      return false;
      }
      else 
      {
        return true;
      }
    }

</script>
</html>





