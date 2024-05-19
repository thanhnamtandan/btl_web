<?php
$conn = mysqli_connect('localhost', 'root', '', 'web_bankinh');
session_start();
if(isset($_GET['id'])) {
    // Lấy ID của sản phẩm từ tham số URL
    $productId = mysqli_real_escape_string($conn, $_GET['id']); // Bảo vệ khỏi SQL Injection

    // Truy vấn để lấy thông tin chi tiết của sản phẩm
    $query = "SELECT * FROM product WHERE id = $productId";
    $result = mysqli_query($conn, $query);

    // Kiểm tra xem có sản phẩm nào được trả về không
    if(mysqli_num_rows($result) > 0) {
        // Lấy thông tin chi tiết của sản phẩm
        $product = mysqli_fetch_assoc($result);
        // Chuyển hướng đến trang chi tiết sản phẩm và truyền thông tin sản phẩm qua URL
        header("Location: ./detailProduct.php?id=$productId");
        exit; // Dừng kịch bản để chuyển hướng có thể thực hiện
    } else {
        // Nếu không tìm thấy sản phẩm, có thể xử lý thông báo lỗi hoặc thực hiện hành động khác
        echo "Không tìm thấy sản phẩm!";
    }
} else {
    // Nếu không có ID sản phẩm được cung cấp, có thể xử lý thông báo lỗi hoặc thực hiện hành động khác
    echo "Không có ID sản phẩm!";
}
?>
