<?php 
session_start(); 

if (isset($_SESSION['id'])) { 
  unset($_SESSION['id']); 
  unset($_SESSION['username']); 
  unset($_SESSION['role']); // xoá role luôn để clear phân quyền
  
  header('Location: /shop/frontend/index.php'); 
  exit(); 
} else { 
  header('Location: /shop/frontend/index.php'); // nếu chưa login vẫn về trang chủ
  exit();
}
