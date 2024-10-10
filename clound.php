<!DOCTYPE html>
<html>
<head>
<title>Book Book</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

<style>
  body {
    /* background: linear-gradient(135deg, #9c9db7 0%, #2c2c54 100%); */
    background-color: #2c2c54;
  }
  .container {
    height: auto;
    width: 1000px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
    background: linear-gradient(135deg, #74759f 0%, #171737 100%);
    /* background-color: #9c9db7; */
    border-radius: 10px;
  }
  .form-container {
    display: none; /* Ẩn ban đầu */
  }
  .nav-tabs .nav-link{
    color: black;
  }
  .form-container.active {
    display: block; /* Hiển thị khi active */
    background-color: #9a8bb3;
  }
  .nav-tabs .nav-link.active {
    display: block;
    background-color: #9a8bb3;
  }
  .btn-input{
    padding: 5px 20px;
    border: none;
    border-radius: 10px ;
    background-color: #8369af;
  }
  .btn-input:hover {
    background-color: #74759f;
  }
</style>
<script src="notification.js"></script>
</head>
