<?php
error_reporting(0);
session_start();

// Kiểm tra xem người dùng đã đăng nhập hay chưa
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
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./style_full.css">
    <link rel="stylesheet" href="fontawesome-free-6.5.1-web/css/all.css">
    <style>
        section {
            display: block;
            box-sizing: border-box;
        }

        * {
            box-sizing: border-box;
        }

        .collection-wrap-product {
            margin: 10px 0;
            border-radius: 10px;
        }

        .collection-wrap-product .collection-wrap-product-header .section-title-all {
            padding: 15px 0;
            border-bottom: 1px solid #ccc;
        }

        .section-title-all {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 10px;
            padding: 15px 0;
            border-bottom: 1px solid #ccc;
        }

        .section-title-all h2 {
            position: relative;
        }

        .section-title-all h2 {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 0;
            position: relative;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
        }

        .container-cart {

            width: 100%;
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
            max-width: 1140px;
            box-sizing: border-box;
        }

        .col-lg-8 {
            position: relative;
            width: 100%;
            min-height: 1px;
            padding-right: 15px;
            text-align: center;
            flex: 0 0 66.66667%;
            max-width: 66.66667%;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }

        .cart-header {
            text-transform: uppercase;
            letter-spacing: 0.2em;
            font-weight: bold;
            padding: 1.2rem 2rem;
            background: #f8f9fa;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }

        .col-5 {
            flex: 0 0 41.66667%;
            max-width: 41.66667%;
        }

        .col-2 {
            flex: 0 0 16.66667%;
            max-width: 16.66667%;
        }

        .col-1 {
            flex: 0 0 8.33333%;
            max-width: 8.33333%;
        }

        .col-lg-4 {
            position: relative;
            width: 100%;
            min-height: 1px;
            padding-right: 15px;
            text-align: center;
            flex: 0 0 33.33333%;
            max-width: 33.33333%;
        }

        .block-header {
            padding: 1.2rem 1.5rem;
            background: #f8f9fa;
        }

        .block-body {
            padding: 1.2rem 1.5rem;
        }

        .pt-1 {
            padding-top: 0.25rem !important;
        }

        .bg-light {
            background-color: #f8f9fa;
        }

        .text-sm {
            font-size: 0.7875rem;
        }

        .mb-0,
        .my-0 {
            margin-bottom: 0 !important;
        }

        .order-summary-item {
            display: flex;
            justify-content: space-between;
            padding-top: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #eee;
        }

        .list-unstyled {
            padding-left: 0;
            list-style: none;
        }

        .block-body ul {
            margin-top: 0;
            margin-bottom: 1rem;
        }

        .block-header h6 {
            font-size: 0.9rem;
            font-family: "HK Grotesk", sans-serif;
            font-weight: 700;
            line-height: 1.1;
            color: inherit;
        }

        .my-5 {
            margin-top: 3rem !important;
        }

        .btn-dark {
            color: #fff;
            cursor: pointer;
            background-color: #2b6800 !important;
            border: 5px solid #2b6800 !important;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: .3em;
            padding: 0.6rem 0.75rem;
            font-size: 0.6875rem;
            line-height: 1.5;
            border-radius: 2;
            text-decoration: none;
        }

        .cart-item {
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }

        .cart-item-img {
            max-width: 80px;
        }

        .align-items-center {
            -ms-flex-align: center !important;
            align-items: center !important;
        }

        .d-flex {
            display: -ms-flexbox !important;
            display: flex !important;
        }

        .col-5 {
            flex: 0 0 41.66667%;
            max-width: 41.66667%;
            width: 100%;
            min-height: 1px;
            padding-right: 15px;
            padding-left: 15px;
        }

        .cart-title {
            margin-left: 1rem;
        }

        .text-left {
            text-align: left !important;
        }

        .text-center {
            text-align: center !important;
        }

        .itemQuantity {
            display: flex;
            flex-wrap: nowrap;
            justify-content: flex-start;
            align-items: flex-start;
            width: 25%;
        }

        .itemQuantity .qtyBtn {
            min-width: 30px !important;
            height: 45px !important;
            background: none;
            border: 1px solid #ccc;
            width: 25px;
            padding: 0;
        }

        .itemQuantity .qtyBtn:hover {
            outline: 0 !important;
            text-decoration: none;
            opacity: .9;
            box-shadow: none !important;
            cursor: pointer;
        }

        .itemQuantity .qtyBtn.minusQuan {
            border-radius: 5px 0 0 5px;
        }

        .itemQuantity .qtyBtn.plusQuan {
            border-radius: 0 5px 5px 0;
        }

        .itemQuantity input {
            width: 50px !important;
            height: 45px !important;
            background-color: transparent;
            border: 1px solid #ccc;
            border-left: none;
            border-right: none;
            border-radius: 0;
            text-align: center;
        }

        .itemQuantity .quantitySelector:hover {
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

        .cart-remove {
            color: gray;
            font-size: 15px;
        }
    </style>
</head>

<body>
    <?php include './style_header.php' ?>
    <div class="collection-wrap-product-header">
        <div class="section-title-all">
            <h2>Giỏ hàng</h2>
        </div>
    </div>
    <form action="./update_quantity.php" method="POST">
        <section>
            <div class="container-cart">
                <div class="row mb-5">
                    <div class="col-lg-8">
                        <div class="cart">
                            <div class="cart-wrapper">
                                <div class="cart-header text-center">
                                    <div class="row">
                                        <div class="col-5">Sản Phẩm</div>
                                        <div class="col-2">Giá</div>
                                        <div class="col-2">Số Lượng</div>
                                        <div class="col-2">Tổng</div>
                                        <div class="col-1"></div>
                                    </div>
                                </div>
                                <div class="cart-body">
                                    <?php
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                            <div class="cart-item" data-product-id="<?php echo $row['product_id']; ?>">
                                                <div class="row d-flex align-items-center text-center">
                                                    <div class="col-5">
                                                        <div class="d-flex align-items-center">
                                                            <img src="<?php echo $row['thumbnail']; ?>" alt="<?php echo $row['product_title']; ?>" class="cart-item-img">
                                                            <div class="cart-title text-left">
                                                                <a href="#" class="text-uppercase text-dark">
                                                                    <strong><?php echo $row['product_title']; ?></strong>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-2" data-price="<?php echo $row['price']; ?>"><?php echo number_format($row['price'], 0, '.', ','); ?></div>
                                                    <div class="col-2">
                                                        <div class="itemQuantity">
                                                            <button class="qtyBtn minusQuan" data-type="minus">-</button>
                                                            <input type="number" id="quantity_<?php echo $row['product_id']; ?>" name="quantities[<?php echo $row['product_id']; ?>]" value="<?php echo $row['num']; ?>" min="1" class="quantitySelector">
                                                            <button class="qtyBtn plusQuan" data-type="plus">+</button>
                                                            <input type="hidden" name="product_ids[]" value="<?php echo $row['product_id']; ?>">
                                                            <!-- Sử dụng Javascript để cập nhật giá trị của input hidden khi giá trị của input number thay đổi -->
                                                            <script>
                                                                document.getElementById("quantity_<?php echo $row['product_id']; ?>").addEventListener("change", function() {
                                                                    document.getElementById("quantityHidden_<?php echo $row['product_id']; ?>").value = this.value;
                                                                });
                                                            </script>

                                                        </div>
                                                    </div>
                                                    <div class="col-2 text-center" data-total="<?php echo $row['total_money']; ?>"><?php echo number_format($row['total_money'], 0, '.', ','); ?></div>
                                                    <div class="col-1 text-center">
                                                        <a href="./deleteCart.php?id=<?php echo $row['product_id']; ?>" class="cart-remove" onclick="deleteCart(<?php echo $row['product_id']; ?>)"><i class="fa-solid fa-trash"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php
                                        }
                                    } ?>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="my-5 d-flex justify-content-between flex-column flex-lg-row">
                        <a href="" class="btn btn-dark">Thanh Toán <i class="fa fa-chevron-right"></i> </a>
                    </div> -->
                    </div>
                    <div class="col-lg-4">
                        <div class="block mb-5">
                            <div class="block-header">
                                <h6 class="text-uppercase mb-0">Tóm Tắt Đơn Hàng</h6>
                            </div>
                            <div class="block-body bg-light pt-1">
                                <p class="text-sm">Chi phí đơn hàng = Giá trị đơn hàng</p>
                                <ul class="order-summary mb-0 list-unstyled">
                                    <li class="order-summary-item border-0">
                                        <span>Tổng Chi Phí</span>
                                        <strong class="order-summary-total"></strong>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="my-5 d-flex justify-content-between flex-column flex-lg-row" style="margin-left: 13rem; margin-top:1rem !important;">
                            <button type="submit" class="btn btn-dark">Thanh Toán <i class="fa fa-chevron-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var minusBtns = document.querySelectorAll('.cart-item .minusQuan');
            var plusBtns = document.querySelectorAll('.cart-item .plusQuan');
            var quantityInputs = document.querySelectorAll('.cart-item .quantitySelector');

            function updateTotal(quantityInput) {
                var cartItem = quantityInput.closest('.cart-item');
                var price = parseFloat(cartItem.querySelector('[data-price]').getAttribute('data-price'));
                var quantity = parseInt(quantityInput.value);
                var total = price * quantity;

                var totalElement = cartItem.querySelector('[data-total]');
                totalElement.innerText = total.toLocaleString('vi-VN', {
                    style: 'currency',
                    currency: 'VND'
                });
                totalElement.setAttribute('data-total', total);

                updateOrderSummaryTotal();
            }

            function updateOrderSummaryTotal() {
                var totalElements = document.querySelectorAll('[data-total]');
                var overallTotal = 0;
                totalElements.forEach(function(element) {
                    overallTotal += parseFloat(element.getAttribute('data-total'));
                });

                var orderSummaryTotalElement = document.querySelector('.order-summary-total');
                orderSummaryTotalElement.innerText = overallTotal.toLocaleString('vi-VN', {
                    style: 'currency',
                    currency: 'VND'
                });
            }

            minusBtns.forEach(function(minusBtn) {
                minusBtn.addEventListener('click', function() {
                    var quantityInput = this.parentElement.querySelector('.quantitySelector');
                    if (quantityInput.value > 1) {
                        quantityInput.value = parseInt(quantityInput.value) - 1;
                        updateTotal(quantityInput);
                    }
                });
            });

            plusBtns.forEach(function(plusBtn) {
                plusBtn.addEventListener('click', function() {
                    var quantityInput = this.parentElement.querySelector('.quantitySelector');
                    quantityInput.value = parseInt(quantityInput.value) + 1;
                    updateTotal(quantityInput);
                });
            });

            quantityInputs.forEach(function(quantityInput) {
                quantityInput.addEventListener('change', function() {
                    if (quantityInput.value < 1) {
                        quantityInput.value = 1;
                    }
                    updateTotal(quantityInput);
                });
            });

            updateOrderSummaryTotal();
        });
        var minusButtons = document.querySelectorAll('.minusQuan');
        var plusButtons = document.querySelectorAll('.plusQuan');

        minusButtons.forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Ngăn chặn hành vi mặc định của button
                // Thực hiện các hành động khác nếu cần
            });
        });

        plusButtons.forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Ngăn chặn hành vi mặc định của button
                // Thực hiện các hành động khác nếu cần
            });
        });
    </script>
</body>

</html>