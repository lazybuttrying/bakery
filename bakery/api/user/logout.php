<?php
session_start();
if (session_destroy()){
  header('Location: ../../../html2/main.html');
}
?>