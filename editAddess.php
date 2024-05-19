<?php
// Kết nối đến cơ sở dữ liệu và kiểm tra session
$conn = mysqli_connect('localhost', 'root', '', 'web_bankinh');
session_start();

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if(isset($_SESSION['login']['username'])) {
    $email = $_SESSION['login']['username'];

    // Truy vấn cơ sở dữ liệu để lấy thông tin người dùng
    $query = "SELECT * FROM user WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        // Lấy thông tin từ form
        $fullname = $_POST['fullname'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $note = $_POST['note'];
        $user_id = $row['id']; // Lấy user_id từ thông tin đã lấy được

        // Kiểm tra xem thông tin nhận hàng đã tồn tại trong bảng orders của người dùng hay chưa
        $check_query = "SELECT * FROM orders WHERE user_id = $user_id";
        $check_result = mysqli_query($conn, $check_query);
        if(mysqli_num_rows($check_result) > 0) {
            // Thực hiện cập nhật thông tin
            $update_query = "UPDATE orders SET fullname = '$fullname',email = '$email' ,phone_number = '$phone', address = '$address', note = '$note' WHERE user_id = $user_id";
            mysqli_query($conn, $update_query);
        } else {
            // Thực hiện thêm mới thông tin
            $insert_query = "INSERT INTO orders (user_id, fullname, email, phone_number, address, note) VALUES ('$user_id', '$fullname','$email', '$phone', '$address', '$note')";
            mysqli_query($conn, $insert_query);
        }

        // Sau khi thực hiện, điều hướng người dùng đến trang accountAddress.php
        header("Location: ./accountAddess.php");
        exit(); // Ngăn chặn mã HTML bên dưới được thực thi
    }
}
?>