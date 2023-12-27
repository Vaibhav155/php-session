<?php
session_start();

$err=$_GET['error'];
if(isset($err))
{
  echo "<script>alert('Invalid oldpassword');</script>";
  header("refresh:0; url=verify.php");
}

$message=$_GET['msg'];
if(isset($message))
{
  echo "password updated";
}

if (!isset($_SESSION['uemail']))   // if someone is not logged in and opens the profile url it will redirect to login page
{
  header("refresh:0; url=login.php");
}

$usersemail = $_SESSION['uemail'];
$usersfname = $_SESSION['ufname'];
$userslname = $_SESSION['ulname'];
$usersbirthday = $_SESSION['ubday'];
$usersaddress = $_SESSION['uaddress'];
$userscourse = $_SESSION['ucourse'];
$userseducation = $_SESSION['ueducation'];
?>

<!DOCTYPE html>
    <html>
    <head>
    <title>User Profile Dashboard</title>
    <style>
  
    body {
     font-family: Arial, sans-serif;
     background-color: #9ed4d4;
    }
    .container {
     max-width: 800px;
     margin: 0 auto;
     padding: 20px;
     background-color: #9ed4d4;
     width:100%;
    }
    h1 {
     text-align: center;
    }
    .profile-card {
     background-color: lightgray;
     padding: 20px;
     border-radius: 5px;
     margin-bottom: 20px;
     border: 1px solid black;
    }
    .profile-card h2 {
     margin-top: 0;
     text-align: center;
    }
    .profile-card p {
     margin: 0;
     text-align: center;
    }
    .profile-card .info {
     margin-top: 10px;
    }
    .hi {
     display: block;
     text-align: center;
     margin-top: 5px;
    }
    .button{
      
      display: block;
      margin:auto;
      margin-top: 10px;
      background-color: #4CAF50;
      margin-bottom: 10px;
    }
    </style>
    </head>
    <body>
    <div class="container">
    <h1>User Profile Dashboard</h1>
  
    <div class="profile-card">
    <h2><?php echo $usersfname ."\n". $userslname; ?></h2>
    <p>Email: <?php echo $usersemail; ?>" </p>
    <p>Birthday: <?php echo $usersbirthday; ?></p>
    <div class="info">
      <p>Location: <?php echo $usersaddress; ?> </p>
      <p>Education: <?php echo $userseducation; ?></p>
      <p>Main Skill: <?php echo $userscourse; ?> </p>
      
      <a class="hi" href="login.php?e=<?php echo $usersemail; ?>">Logout</a>
      <button class="button" onclick="show()">Change Password</button>
      <form method="post" action="passwordchange.php">
       <div id="changePassword" style="display:none">
        <label for="oldPassword"> Oldpassword </label><br>
        <input type="password" id="oldPassword" name="oldpassword" ><br>
        <label for="newPassword"> Newpassword </label><br>
        <input type="password" id="newPassword" name="newpassword"><br>
        <input type="submit" name="submit" value="submit" onclick="return validate()">
       </div>
      </form>

     
    </div>
    </div>
    </div>
    </body>

    <script>
      function show() 
      {
          var a = document.getElementById("changePassword");
          a.style.display = "block";
          a.style.textAlign="center";
          var b = document.getElementById("oldPassword");
          b.style.border="1px solid black"
          b.style.marginBottom="10px";
          var c= document.getElementById("newPassword");
          c.style.border="1px solid black"
      }

      function validate()
      {
      
          var o = document.getElementById("oldPassword");
          var n = document.getElementById("newPassword");

          if (o.value == "") 
          {
          alert("password can't be empty");
          return false;
          } 
          else if (!o.value.match('((?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{6,}))|((?=.*[a-z])(?=.*[A-Z])(?=.*[^A-Za-z0-9])(?=.{8,}))')) 
          {
          alert("wrong format of old password");
            return false;
          }

          if (n.value == "") 
          {
          alert("password can't be empty");
          return false;
          } 
          else if (!n.value.match('((?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^A-Za-z0-9])(?=.{6,}))|((?=.*[a-z])(?=.*[A-Z])(?=.*[^A-Za-z0-9])(?=.{8,}))')) 
          {
          alert("wrong format of new password");
          return false;
          }

          else 
          {
            return true;
          }
      }
    </script>
    </html> 