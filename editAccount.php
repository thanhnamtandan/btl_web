<?php
// Kết nối đến cơ sở dữ liệu và kiểm tra session
$conn = mysqli_connect('localhost', 'root', '', 'web_bankinh');
session_start();

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if(isset($_SESSION['login']['username'])) {
    $email = $_SESSION['login']['username'];

    // Kiểm tra xem có dữ liệu được gửi từ form hay không
    if(isset($_POST['submit-contact-form'])) {
        // Lấy dữ liệu từ form
        $fullname = $_POST['fullname'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];

        // Cập nhật thông tin người dùng trong cơ sở dữ liệu
        $query = "UPDATE user SET fullname = '$fullname', phone_number = '$phone', address = '$address' WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        if($result) {
            // Nếu cập nhật thành công, chuyển hướng người dùng đến trang thông tin tài khoản
            header('Location: ./account.php');
            exit;
        } else {
            // Nếu không thành công, hiển thị thông báo lỗi
            echo "Có lỗi xảy ra khi cập nhật thông tin người dùng.";
        }
    }
}
?>
