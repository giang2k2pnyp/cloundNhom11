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
  
<body>
<div class="container mt-3 mb-3">
  <h2 style="color: #03efd1;font-size: -webkit-xxx-large;
    font-family: cursive;">Book Book</h2>
    <div>
        <div class="nav nav-tabs" role="tablist">
            <button id="showListBtn" class="nav-link active" >Danh sách </button>
            <button id="showAddBtn" class="nav-link" >Thêm mới</button>
        </div>
    
    <div id="listForm" class="form-container active ">
      <table class="table text-center w-100">
        <tr>
            <th>STT</th>
            <th>Tên sản phẩm</th>
            <th>Hình ảnh</th>
            <th>Tên tác giả</th>
            <th>Giá</th>
            <th>Xóa</th>
        </tr>
          <?php
            $sql = "SELECT * FROM book"; // Thêm truy vấn ở đây
            $stmt = sqlsrv_query($conn, $sql);
            $i = 1;
            if ($stmt) {
              while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
          ?>
        <tr style="vertical-align: middle;">
            <td><?php echo $i++ ?></td>
            <td><?php echo $row['tensach'] ?></td>
            <td><img src="<?php echo $row['img'] ?>" width="70px" height="80px"></td>
            <td><?php echo $row['tacgia'] ?></td>
            <td><?php echo $row['gia'] ?></td>
            <td>
                <form method="post">
                    <input type='hidden' name='action' value='delete'>
                    <input type='hidden' name='id' value='<?php echo $row['id_book'] ?>'>
                    <input class="btn-input" type='submit' value='Xóa' onclick="return confirm('Are you want to delete?')">
                </form>
            </td>
        </tr>
        <?php
        }
        ?>
      </table>
    </div>

    <div id="addForm" class="form-container p-3">
      <form method="post" enctype="multipart/form-data">
        <input type='hidden' name='action' value='add'>
          <div class="form-group">
            <p>Tên Sách</p>
            <input
                class="form-control"
                type="text"
                name="tensach"  
            />
          </div>
          <div class="form-group">
            <p>Hình ảnh</p>
            <input
                class="form-control"
                type="file"
                name="img"
            />
          </div>
          <div class="form-group">
            <p>Tên tác giả</p>
            <input
                class="form-control"
                type="text"
                name="tacgia"  
            />
          </div>
          <div class="form-group">
            <p>Giá</p>
            <input
                class="form-control"
                type="text"
                name="gia"  
            />
          </div>
        <input class="btn-input" type="submit" value="Thêm" style="margin-top: 20px; padding: 10px 20px" />
      </form>
    </div>
  </div>
</div>

<script src="index.js"></script>
</body>
</html>
