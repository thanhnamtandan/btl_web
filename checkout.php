<?php
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
?>

<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        body {
            font-family: Arial;
            font-size: 17px;
            padding: 8px;
        }

        * {
            box-sizing: border-box;
        }

        .row {
            display: -ms-flexbox;
            /* IE10 */
            display: flex;
            -ms-flex-wrap: wrap;
            /* IE10 */
            flex-wrap: wrap;
            margin: 0 -16px;
        }

        .col-25 {
            -ms-flex: 25%;
            /* IE10 */
            flex: 25%;
        }

        .col-50 {
            -ms-flex: 50%;
            /* IE10 */
            flex: 50%;
        }

        .col-75 {
            -ms-flex: 75%;
            /* IE10 */
            flex: 60%;
        }

        .col-25,
        .col-50,
        .col-75 {
            padding: 0 16px;
        }

        .container {
            background-color: #f2f2f2;
            padding: 5px 20px 15px 20px;
            border: 1px solid lightgrey;
            border-radius: 3px;
        }

        input[type=text] {
            width: 100%;
            margin-bottom: 20px;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 3px;
            background-color: #C0C0C0;
            color: grey;
        }

        textarea {
            width: 100%;
            margin-bottom: 20px;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 3px;
            background-color: #C0C0C0;
            color: grey;
        }

        label {
            margin-bottom: 10px;
            display: block;
        }

        .icon-container {
            margin-bottom: 20px;
            padding: 7px 0;
            font-size: 24px;
        }

        .btn {
            background-color: #04AA6D;
            color: white;
            padding: 12px;
            margin: 10px 0;
            border: none;
            width: 100%;
            border-radius: 3px;
            cursor: pointer;
            font-size: 17px;
        }

        .btn:hover {
            background-color: #45a049;
        }

        a {
            color: #2196F3;
        }

        hr {
            border: 1px solid lightgrey;
        }

        span.price {
            float: right;
            color: grey;
        }

        /* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other (also change the direction - make the "cart" column go on top) */
        @media (max-width: 800px) {
            .row {
                flex-direction: column-reverse;
            }

            .col-25 {
                margin-bottom: 20px;
            }
        }
    </style>
</head>

<body>


    <div class="row">
        <div class="col-75">
            <div class="container">
                <form action="./send_email.php" method="post">

                    <div class="row">
                        <div class="col-50">
                            <h3>Billing Address</h3>
                            <label for="fname"><i class="fa fa-user"></i> Full Name</label>
                            <input type="text" class="form-control" name="fullname" id="fullname" value="<?php echo $row['fullname']; ?>" readonly>
                            <label for="email"><i class="fa fa-envelope"></i> Email</label>
                            <input type="text" class="form-control" name="email" id="email" value="<?php echo $row['email']; ?>" readonly>
                            <label for="phone"><i class="fa fa-phone"></i> Phone</label>
                            <input type="text" class="form-control" name="phone" id="phone" value="<?php echo $row['phone_number']; ?>" readonly>
                            <label for="adr"><i class="fa fa-address-card-o"></i> Address</label>
                            <input type="text" class="form-control" name="address" id="address" value="<?php echo $row['address']; ?>" readonly>
                            <label for="city"><i class="fa fa-institution"></i> Note</label>
                            <textarea rows="4" name="note" id="note" placeholder="Nhập nội dung" required="required" class="form-control" style="height: auto;" readonly> <?php echo $row['note']; ?></textarea>
                        </div>


                    </div>
                    <label>
                        <input type="checkbox" checked="checked" name="sameadr"> Shipping address same as billing
                        <b style="margin-left: 50%;">Tổng tiền cần thanh toán <span class="price" style="color:black"><b><?php echo number_format($totalPrice, 0, '.', ','); ?> VND</b></span></b>
                    </label>
                    <input type="submit" value="Xác nhận thanh toán" class="btn" name="send">
                </form>
            </div>
        </div>

    </div>

</body>

</html>