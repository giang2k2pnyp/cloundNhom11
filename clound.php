<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        body {
            background-color: #2c2c54;
        }
        .container {
            height: auto;
            width: 1000px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            background: linear-gradient(135deg, #74759f 0%, #171737 100%);
            border-radius: 10px;
        }
        .form-container {
            display: none;
        }
        .nav-tabs .nav-link {
            color: black;
        }
        .form-container.active {
            display: block;
            background-color: #9a8bb3;
        }
        .nav-tabs .nav-link.active {
            background-color: #9a8bb3;
        }
        .btn-input {
            padding: 5px 20px;
            border: none;
            border-radius: 10px;
            background-color: #8369af;
        }
        .btn-input:hover {
            background-color: #74759f;
        }
    </style>
    <script src="notification.js"></script>
</head>
<body>

<?php 
$servername = "database-clound.database.windows.net";
$username = "clound"; 
$password = "giang2k2pnyp."; 
$dbname = "clound";

$connectionInfo = array("Database" => $dbname, "UID" => $username, "PWD" => $password);
$conn = sqlsrv_connect($servername, $connectionInfo);

if ($conn === false) {
    error_log(print_r(sqlsrv_errors(), true));
    die("<script> showNotification('Lỗi kết nối cơ sở dữ liệu!','error'); </script>");
}

if (isset($_POST['action'])) {
    $action = $_POST['action'];
    
    if ($action == 'add') {
        $ten_san_pham = trim($_POST['tensach']);
        $tacgia = trim($_POST['tacgia']);
        $gia = trim($_POST['gia']);
        
        if (empty($ten_san_pham) || empty($tacgia) || !is_numeric($gia)) {
            echo "<script> showNotification('Vui lòng điền đầy đủ thông tin và giá phải là số!','error'); </script>";
            return;
        }

        $target_dir = "uploads/"; 
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        $target_file = $target_dir . basename($_FILES["img"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if ($_FILES["img"]["size"] > 500000) {
            echo "<script> showNotification('Dung lượng file quá lớn!','error'); </script>";
            $uploadOk = 0;
        }

        if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
            echo "<script> showNotification('Định dạng file không hợp lệ!','error'); </script>";
            $uploadOk = 0;
        }

        if ($_FILES["img"]["error"] !== UPLOAD_ERR_OK) {
            echo "<script> showNotification('Có lỗi xảy ra khi upload file!','error'); </script>";
            $uploadOk = 0;
        }

        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
                $sql = "INSERT INTO book (tensach, img, tacgia, gia) VALUES (?, ?, ?, ?)";
                $params = array($ten_san_pham, $target_file, $tacgia, $gia);
                $stmt = sqlsrv_query($conn, $sql, $params);

                if ($stmt) {
                    echo "<script> showNotification('Thêm sản phẩm thành công!'); </script>";
                } else {
                    error_log(print_r(sqlsrv_errors(), true));
                    echo "<script> showNotification('Thêm sản phẩm thất bại!', 'error'); </script>";
                }
            } else {
                echo "<script> showNotification('Lỗi khi upload file!','error'); </script>";
            }
        }
    }

    if ($action == 'delete') {
        $id = $_POST['id_book'];

        $sql = "DELETE FROM book WHERE id_book = ?";
        $params = array($id);
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt) {
            echo "<script> showNotification('Xóa sản phẩm thành công!', 'warning'); </script>";
        } else {
            error_log(print_r(sqlsrv_errors(), true));
            echo "<script> showNotification('Lỗi khi xóa sản phẩm!', 'error'); </script>";
        }
    }
}

// Truy vấn tất cả các sản phẩm
$sql = "SELECT * FROM book";
$stmt = sqlsrv_query($conn, $sql);

if ($stmt === false) {
    error_log(print_r(sqlsrv_errors(), true));
    echo "<script> showNotification('Lỗi khi truy vấn sản phẩm!', 'error'); </script>";
} else {
    echo '<div class="container mt-3 mb-3">
        <h2 style="color: #03efd1; font-size: -webkit-xxx-large; font-family: cursive;">Book Book</h2>
        <div>
            <div class="nav nav-tabs" role="tablist">
                <button id="showListBtn" class="nav-link active">Danh sách</button>
                <button id="showAddBtn" class="nav-link">Thêm mới</button>
            </div>
            <div id="listForm" class="form-container active">
                <table class="table text-center w-100">
                    <tr>
                        <th>STT</th>
                        <th>Tên sản phẩm</th>
                        <th>Hình ảnh</th>
                        <th>Tên tác giả</th>
                        <th>Giá</th>
                        <th>Xóa</th>
                    </tr>';

    $i = 1;
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        echo "<tr style='vertical-align: middle;'>
                <td>{$i}</td>
                <td>{$row['tensach']}</td>
                <td><img src='{$row['img']}' width='70px' height='80px'></td>
                <td>{$row['tacgia']}</td>
                <td>{$row['gia']}</td>
                <td>
                    <form method='post'>
                        <input type='hidden' name='action' value='delete'>
                        <input type='hidden' name='id_book' value='{$row['id_book']}'>
                        <input class='btn-input' type='submit' value='Xóa' onclick=\"return confirm('Bạn có chắc chắn muốn xóa?')\">
                    </form>
                </td>
            </tr>";
        $i++;
    }
    echo '          </table>
                </div>
                <div id="addForm" class="form-container p-3">
                    <form method="post" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="add">
                        <div class="form-group">
                            <p>Tên Sách</p>
                            <input class="form-control" type="text" name="tensach" required />
                        </div>
                        <div class="form-group">
                            <p>Hình ảnh</p>
                            <input class="form-control" type="file" name="img" accept=".jpg,.png,.jpeg,.gif" required />
                        </div>
                        <div class="form-group">
                            <p>Tên tác giả</p>
                            <input class="form-control" type="text" name="tacgia" required />
                        </div>
                        <div class="form-group">
                            <p>Giá</p>
                            <input class="form-control" type="text" name="gia" required />
                        </div>
                        <input class="btn-input" type="submit" value="Thêm" style="margin-top: 20px; padding: 10px 20px" />
                    </form>
                </div>
            </div>
        </div>
    </div>';
}

sqlsrv_close($conn); // Đóng kết nối cơ sở dữ liệu
?>

<script src="index.js"></script>
</body>
</html>
