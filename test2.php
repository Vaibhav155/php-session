<?php
// Start the session
session_start();
?>

<!DOCTYPE html>
<html>
<body>

<?php
// Echo session variables
echo "Favorite color is " . $_SESSION["favcolor"] . ".<br>";
echo "<a href='test3.php'> log out</a>";
?>

</body>
</html>

