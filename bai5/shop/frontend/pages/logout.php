<?php 
session_start(); 
if (isset($_SESSION['user_id'])) { 
unset($_SESSION['user_id']); 
unset($_SESSION['username']); 
header('location:/shop/frontend/index.php'); 
} else { 
die; 
} 