<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require("PHPMailer-master/PHPMailer-master/src/PHPMailer.php");
require("PHPMailer-master/PHPMailer-master/src/SMTP.php");
require("PHPMailer-master/PHPMailer-master/src/Exception.php");
session_start();
if (isset($_SESSION['login']['username'])) {
    $username = $_SESSION['login']['username'];

    // Kết nối cơ sở dữ liệu
    $conn = mysqli_connect('localhost', 'root', '', 'web_bankinh');
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Truy vấn các sản phẩm trong giỏ hàng của người dùng hiện tại
    $query = "SELECT p.title AS product_title, p.thumbnail, od.price, od.num, od.total_money, od.product_id
              FROM order_details od
              JOIN product p ON od.product_id = p.id
              JOIN orders o ON od.order_id = o.id
              JOIN user u ON o.user_id = u.id
              WHERE u.email = '$username'";
    $result = mysqli_query($conn, $query);

    $queryOrders = "SELECT * FROM orders WHERE user_id = (SELECT id FROM user WHERE email = '$username')";
    $resultOrders = mysqli_query($conn, $queryOrders);
    $row = mysqli_fetch_assoc($resultOrders);

    // Khởi tạo biến tổng số lượng sản phẩm và tổng giá
    $totalQuantity = 0;
    $totalPrice = 0;

    // Duyệt qua các sản phẩm trong giỏ hàng để tính tổng số lượng và tổng giá
    $cartItems = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row1 = mysqli_fetch_assoc($result)) {
            $totalQuantity += $row1['num'];
            $totalPrice += $row1['total_money'];
            $cartItems[] = $row1;
        }
    }
}
if (isset($_POST["send"])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $note = $_POST['note'];

    // Tạo đối tượng PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Cấu hình SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'thoitrangkinhmat24@gmail.com'; // Thay bằng địa chỉ email của bạn
        $mail->Password = 'eybpglgdznybytxk'; // Thay bằng mật khẩu email của bạn
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Người gửi
        $mail->setFrom('thoitrangkinhmat24@gmail.com', 'KINH MAT THOI TRANG');

        // Người nhận
        $mail->addAddress($email, $fullname);

        // Nội dung email
        $mail->isHTML(true);
        $mail->Subject = 'Payment confirmation';
        $mail->Body = "Chào $fullname,<br><br>Cảm ơn bạn đã thanh toán.<br><br>Thông tin đơn hàng:<br>
                       Full Name: $fullname<br>
                       Email: $email<br>
                       Phone: $phone<br>
                       Address: $address<br>
                       Note: $note<br>
                       Tổng tiền: " . number_format($totalPrice, 0, '.', ',') . " VND<br>
                       Cảm ơn bạn đã đồng hành cùng chúng tôi ";
                       

        $mail->send();
        echo 
        "
        <script>
        alert('Xác nhận đơn hàng thành công !!!');
        document.location.href = 'home.php';
        </script>
        ";
    } catch (Exception $e) {
        echo "Email không thể gửi. Lỗi: {$mail->ErrorInfo}";
    }
    // $mail->IsSMTP(); // enable SMTP

    // $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
    // $mail->SMTPAuth = true; // authentication enabled
    // $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
    // $mail->Host = "smtp.gmail.com";
    // $mail->Port = 465; // or 587
    // $mail->IsHTML(true);
    // $mail->Username = 'thoitrangkinhmat24@gmail.com';
    // $mail->Password = 'eybpglgdznyb ytxk';
    // $mail->SetFrom('thoitrangkinhmat24@gmail.com');
    // $mail->Subject = "Test";
    // $mail->Body = "hello";
    // $mail->AddAddress($email);

    //  if(!$mail->Send()) {
    //     echo "Mailer Error: " . $mail->ErrorInfo;
    //  } else {
    //     echo "Message has been sent";
    //  } 
}
