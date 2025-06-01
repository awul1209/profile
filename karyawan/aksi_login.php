<?php
session_start();

$conn = mysqli_connect('localhost', 'root', '', 'db_bkad');
if(isset($_POST['login'])){
$email = $_POST['email'];
$password = $_POST['password'];

$cekdatabase = mysqli_query($conn,"SELECT * FROM user where email='$email'");
$hitung = mysqli_num_rows($cekdatabase);
if($hitung > 0){
$_SESSION['admin'] = mysqli_fetch_assoc($cekdatabase)['id'];
header('location:admin/index.php');
}
else echo '<script>alert("Username atau Password Anda Salah")</script>';
};

if (isset($_SESSION['login'])) header('location:index.php');
?>