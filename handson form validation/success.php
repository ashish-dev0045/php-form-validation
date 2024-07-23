
<?php 
session_start();
echo "Your name is ".$_SESSION['name']."</br>";
echo "Your email is ".$_SESSION['email']."</br>";
echo "Your gender is ".$_SESSION['gender']."</br>";
echo "Your interest is ".$_SESSION['interest']."</br>";
echo "Your live in ".$_SESSION['city']."</br>";
?>

