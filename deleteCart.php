<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'web_bankinh');

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Lấy id sản phẩm từ yêu cầu
    $productId = mysqli_real_escape_string($conn, $_GET['id']);

    // Xóa sản phẩm từ cơ sở dữ liệu
    $query = "DELETE FROM order_details WHERE product_id = $productId";
    $result = mysqli_query($conn, $query);

    // Kiểm tra và trả về kết quả xóa
    if ($result) {
        http_response_code(200); // Trạng thái thành công
        header('Location: ./cart.php');
    } else {
        http_response_code(500); // Lỗi máy chủ
        echo json_encode(array("message" => "Error deleting product."));
    }
}
?>
