<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['login']['username'])) {
        if (isset($_POST['product_ids']) && isset($_POST['quantities'])) {
            $username = $_SESSION['login']['username'];
            $productIds = $_POST['product_ids']; // Đảm bảo rằng $productIds là một mảng
            $newQuantities = $_POST['quantities']; // Đảm bảo rằng $newQuantities là một mảng

            // Kết nối cơ sở dữ liệu
            $conn = mysqli_connect('localhost', 'root', '', 'web_bankinh');
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            foreach ($productIds as $productId) {
                $newQuantity = $newQuantities[$productId];

                // Cập nhật cột num trong bảng order_details
                $query = "UPDATE order_details od
                          JOIN orders o ON od.order_id = o.id
                          JOIN user u ON o.user_id = u.id
                          SET od.num = '$newQuantity',
                              od.total_money = od.price * '$newQuantity'
                          WHERE u.email = '$username' AND od.product_id = '$productId'";
                          
                if (!mysqli_query($conn, $query)) {
                    echo "Update failed for product ID $productId. Please try again later.";
                }
            }

            // Đóng kết nối
            mysqli_close($conn);
            // Chuyển hướng đến trang checkout.php sau khi cập nhật thành công
            header('location:./checkout.php');
            exit; // Kết thúc script để đảm bảo không có mã PHP nào được thực thi sau khi chuyển hướng
        } else {
            echo "Product ID or Quantity is missing.";
        }
    } else {
        echo "User not logged in.";
    }
} else {
    echo "Invalid request method.";
}
?>
