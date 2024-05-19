<?php
error_reporting(0);
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
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./style_full.css">
    <link rel="stylesheet" href="./style_gongkinh.css">
    <link rel="stylesheet" href="fontawesome-free-6.5.1-web/css/all.css">
    <style>
        .product-detail{
    padding-top: 46px;
    padding-bottom: 46px;
        }
        .container-detail-product{
    display: flex;
    flex-wrap: wrap;
    width: 100%;
    padding-left: 16px;
    padding-right: 16px;
    margin-left: auto;
    margin-right: auto;
        }
        .productName{
        width: 90%;
        font-size: 20px;
        font-weight: 700;
        }
        .productPrice{
    border-top: 1px dotted #dee2e6;
    border-bottom: 1px dotted #dee2e6;
    padding: 15px 0 !important;
    font-size: 13px;
        }
        .productPrice .productPriceCompare{
    margin-left: 0;
    font-size: 14px;
    color: #777a7b;
    padding-right: 10px;
    font-weight: 500;
        }
        .productPrice .productPriceMain{
    font-size: 18px;
    opacity: .92;
    font-weight: bold;
    color: #F30;
        }
        .productActionMain .groupAdd{
    display: block;
    align-items: center;
    justify-content: flex-start;
    width: 100%;
        }
        .productActionMain .groupAdd  .itemQuantity{
    display: flex;
    flex-wrap: nowrap;
    justify-content: flex-start;
    align-items: flex-start;
    width: 25%;
        }
        .productActionMain .groupAdd  .itemQuantity .qtyBtn{
    min-width: 35px !important;
    height: 45px !important;
    background: none;
    border: 1px solid #ccc;
    width: 25px;
    padding: 0;
        }
        .productActionMain .groupAdd  .itemQuantity .qtyBtn:hover{
    outline: 0 !important;
    text-decoration: none;
    opacity: .9;
    box-shadow: none !important;
    cursor: pointer;
        }
        .groupAdd .itemQuantity .qtyBtn.minusQuan {
    border-radius: 5px 0 0 5px;
    }
        .groupAdd .itemQuantity .qtyBtn.plusQuan {
    border-radius: 0 5px 5px 0;
}
        .productActionMain .groupAdd  .itemQuantity input{
    width: 70px !important;
    height: 45px !important;
    background-color: transparent;
    border: 1px solid #ccc;
    border-left: none;
    border-right: none;
    border-radius: 0;
    text-align: center;
        }
        .productActionMain .groupAdd  .itemQuantity .quantitySelector:hover{
    outline: 0 !important;
    text-decoration: none;
    opacity: .9;
    box-shadow: none !important;
        }
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
    opacity: 0;
    pointer-events: none;
    }
        .productAction{
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    flex: 1;
        }
        #addToCart{
    cursor: pointer;
    width: 74%;
    margin-left: unset;
    height: 45px;
    color: #212121;
    border: 1px solid #212121;
    border-radius: 5px;
    background: #fff;
    min-width: 180px;
    font-weight: 500;
    text-transform: uppercase;
    white-space: nowrap;
    text-align: center;
    max-width: 48%;
        }
        #addToCart:hover{
    background: #000;
    border: 1px solid #fff;
    color: #fff;
    border-radius: 3px;
        }
        #buyNow{
    cursor: pointer;
    width: 49%;
    height: 45px;
    color: #fff;
    border: none;
    background: #4a90e2;
    min-width: 180px;
    font-weight: 500;
    text-transform: uppercase;
    white-space: nowrap;
    text-align: center;
    border-radius: 5px;
    max-width: 48%;
        }
        .detail-img{
    padding: 0 20px;
    width: 50%;
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    align-items: flex-start;
        }
        .productInfomation{
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <?php include './style_header.php' ?>
    <section class="product-detail">
        <div class="container-detail-product">
            <div class="detail-img">
                <img src="<?php echo $product['thumbnail']; ?>" alt="">
            </div>
            <div class="detai-content">
                <h1 class="productName"><?php echo $product['title']; ?></h1>
                <div class="productPrice">
                    <del class="productPriceCompare"><?php echo number_format($product['price'],0,'.', ','); ?> VND</del>
                    <span id="productPrice" class="productPriceMain"><?php echo  number_format($product['discount'],0,'.', ','); ?> VND</span>
                </div>
                <div class="productActionMain">
                    <div class="groupAdd">
                        <div class="itemQuantity">
                            <button class="qtyBtn minusQuan" data-type="minus">-</button>
							<input type="number" id="quantity" name="quantity" value="1" min="1" class="quantitySelector">
							<button class="qtyBtn plusQuan" data-type="plus">+</button>
                            <label class="mb-4 text-muted" style="margin-left:20px;color: #868e96 !important;">Còn hàng</label>
                        </div>
                        <br>
                        <div class="productAction">
                            <form action="./AddToCart.php" method="post">
                                <input type="hidden" name="productId" value="<?php echo $productId; ?>">
                                <input type="hidden" name="productPrice" value="<?php echo $product['discount']; ?>">
                                <input type="hidden" id="quantityHidden" name="quantity" class="quantitySelector">
                                 <!-- Sử dụng Javascript để cập nhật giá trị của input hidden khi giá trị của input number thay đổi -->
                                <script>
                                document.getElementById("quantity").addEventListener("change", function() {
                                document.getElementById("quantityHidden").value = this.value;
                                });
                                
                                </script>
                                <?php echo' <a href="./AddToCart.php?id='.$productId.'"><button class="hoverOpacity" id="addToCart">Thêm vào giỏ hàng</button></a>'?>
                            </form>
                            <button class="hoverOpacity" id="buyNow">Mua ngay</button>
                        </div>
                    </div>
                </div>
                <div class="productInfomation">
                    <div class="productInfomation-role">
                        <label style="color: #2b6800 !important; font-size: 18px !important;">THÔNG TIN SẢN PHẨM</label>
                    </div>
                    <div class="productInfomation-detail" style="max-width: 593px;">
                        <label style="color: #111 !important; font-size: 15px !important;"><?php echo $product['description']; ?></label>
                    </div>
                </div>
            </div>
        </div>
    </section>
   
    <?php include './style_footer.php'?>
    <script>
  // Lấy element input và các nút tăng giảm
var quantityInput = document.getElementById('quantity');
var quantityInputHidden = document.getElementById('quantityHidden');
var minusBtn = document.querySelector('.minusQuan');
var plusBtn = document.querySelector('.plusQuan');

// Thiết lập sự kiện click cho nút tăng giảm
minusBtn.addEventListener('click', function() {
    // Giảm giá trị của input khi nút "-" được nhấn
    if (quantityInput.value > 1) {
        quantityInput.value = parseInt(quantityInput.value) - 1;
        quantityInputHidden.value = quantityInput.value; // Cập nhật giá trị vào input ẩn
    }
});

plusBtn.addEventListener('click', function() {
    // Tăng giá trị của input khi nút "+" được nhấn
    quantityInput.value = parseInt(quantityInput.value) + 1;
    quantityInputHidden.value = quantityInput.value; // Cập nhật giá trị vào input ẩn
});
    </script>
</body>
</html>