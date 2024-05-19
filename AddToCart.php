<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if(isset($_SESSION['login']['username'])) {
    // Kết nối cơ sở dữ liệu
    $conn = mysqli_connect('localhost', 'root', '', 'web_bankinh');
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Lấy thông tin người dùng từ session
    $username = $_SESSION['login']['username'];

    // Truy vấn để lấy order_id từ bảng orders
    $orderQuery = "SELECT id FROM orders WHERE user_id = (SELECT id FROM user WHERE email = '$username') ORDER BY id DESC LIMIT 1";
    $orderResult = mysqli_query($conn, $orderQuery);

    if ($orderResult) {
        // Lấy order_id từ kết quả truy vấn
        $orderRow = mysqli_fetch_assoc($orderResult);
        $orderId = $orderRow['id'];
        if($order_id == NULL){
            echo 
            "
            <script>
            alert('Vui lòng thêm thông tin cho tài khoản');
            document.location.href = 'accountAddess.php';
            </script>
            ";
        }

        // Lấy thông tin sản phẩm từ dữ liệu gửi đi bằng phương thức POST
        if(isset($_POST['productId']) && isset($_POST['quantity']) && isset($_POST['productPrice'])) {
            $productId = $_POST['productId'];
            $quantity = $_POST['quantity'];
            $productPrice = $_POST['productPrice'];
            $total_money = intval($productPrice) * intval($quantity);
            // Thêm sản phẩm vào bảng order_details với order_id từ bước trước
            $query = "INSERT INTO order_details (order_id, product_id, price, num,total_money) VALUES ('$orderId', '$productId', '$productPrice','$quantity','$total_money')";
            
            if(mysqli_query($conn, $query)) {
                header('location:./kinhmat.php');
            } else {
                echo "Đã xảy ra lỗi khi thêm sản phẩm vào giỏ hàng: " . mysqli_error($conn);
            }
        } else {
            echo "Dữ liệu không hợp lệ.";
        }
    } else {
        echo "Đã xảy ra lỗi khi lấy order_id từ bảng orders: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    // Nếu người dùng chưa đăng nhập, chuyển hướng đến trang đăng nhập hoặc thực hiện hành động khác
    echo 
    "
    <script>
    alert('Vui lòng đăng nhập để thêm vào giỏ hàng');
    document.location.href = 'home.php';
    </script>
    ";
}
?>
