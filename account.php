<?php
// Kết nối đến cơ sở dữ liệu và kiểm tra session
error_reporting(0);
$conn = mysqli_connect('localhost', 'root', '', 'web_bankinh');
session_start();

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if(isset($_SESSION['login']['username'])) {
    $email = $_SESSION['login']['username'];

    // Truy vấn cơ sở dữ liệu để lấy thông tin người dùng
    $query = "SELECT * FROM user WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/account/style_account.css">
    <link rel="stylesheet" href="/fontawesome-free-6.5.1-web/css/all.css">
    <style>
.main-layout {
    padding-top: 20px;
}
#account-page .account-page-wrap {
    display: flex;
    flex-wrap: wrap;
    margin-top: 2rem;
    margin-bottom: 2rem;
}
#account-page .account-page-wrap .account-page-sidebar {
    width: calc(25% - 2rem);
    margin-right: 2rem;
    position: relative;
    border-radius: 0px;
    background: #fff;
    box-shadow: 0 0 10px rgba(255, 255, 255, 0.75);
}
#account-page .account-page-wrap .account-page-sidebar .account-sidebar-header {
    text-align: center;
}
#account-page .account-page-wrap .account-page-sidebar .account-sidebar-header .account-sidevar-avatar i {
    font-size: 2rem;
    display: inline-block;
    padding: 10px;
    border-radius: 50%;
    background: rgba(0, 0, 0, 0.03);
}
#account-page .account-page-wrap .account-page-sidebar .account-sidebar-header > h3 {
    font-size: 1.1rem;
    font-weight: normal;
    margin-top: 0.5rem;
}
#account-page .account-page-wrap .account-page-sidebar .account-sidebar-menu {
    margin-top: 1.5rem;
}
#account-page .account-page-wrap .account-page-sidebar .account-sidebar-menu ul a.active {
    background: rgba(0, 0, 0, 0.03);
}
#account-page .account-page-wrap .account-page-sidebar .account-sidebar-menu ul a.active-logout {
    background: gainsboro;
}
#account-page .account-page-wrap .account-page-sidebar .account-sidebar-menu ul a {
    display: block;
    padding: 0.5rem 1rem;
    color: #4c4c4c;
    text-decoration: none;
}
#account-page .account-page-wrap .account-page-content {
    width: 75%;
    position: relative;
    border-radius: 0px;
    background: #fff;
    box-shadow: 0 0 10px rgba(255, 255, 255, 0.75);
}
#account-page .account-page-wrap .account-page-content > h1 {
    margin-top: 0;
    font-size: 1.2rem;
    margin-bottom: 2rem;
}
#account-page .account-page-wrap .account-page-content > h1 > span {
    position: relative;
}
.table {
    width: 100%;
    color: #212529;
}
.table td{
    padding: .75rem;
    vertical-align: top;
}
.form-control {
    display: block;
    width: 60%;
    height: calc(1.5em + .75rem + 2px);
    padding: .375rem .75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}
.btn-update{
    text-align: center;
}
.btn-outline-dark {
    cursor: pointer;
    margin: 10px 32px;
    padding: 10px 50px;
    background: white;
    color: black;
    border: 1px solid #333;
    border-radius: 20px;
    font-weight: 600;
    transition: .4s cubic-bezier(.5, 0, 0, 1.25);
}
.btn-outline-dark:hover {
    background: #333;
    color: #fff;
    transition: .4s cubic-bezier(.5, 0, 0, 1.25);
}
    </style>
</head>
<body>
        <?php include './style_header.php' ?>
        <div class="main-layout">
			<div id="account-page">
                <div class="container-account">
                    <div class="account-page-wrap">
                        <div class="account-page-sidebar">
                            <div class="account-sidebar-header">
                                <div class="account-sidevar-avatar">
                                    <i class="fa fa-user"></i>
                                </div>
                                <h3>Hi, <b><?php echo $row['fullname']; ?></b></h3>
                            </div>
                            <div class="account-sidebar-menu">
                                <ul>
                                    <li><a href="#" class="active">Thông tin tài khoản</a></li>
                                    <li><a href="./accountAddess.php" class="active">Thông tin nhận hàng</a></li>
                                    <li><a href="./logout.php" class="active-logout">Đăng xuất</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="account-page-content">
                            <h1>
                                <span>Thông tin tài khoản</span>
                            </h1>
                            <form action="./editAccount.php" method="post">
                            <div class="account-page-detail account-page-info">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>Họ tên</td>
                                                <td><input type="text" class="form-control" name="fullname" id="fullname" value="<?php echo $row['fullname']; ?>" readonly></td>
                                            </tr>
                                            <tr>
                                                <td>Email</td>
									            <td><input type="text" class="form-control" name="email" id="email" value="<?php echo $row['email']; ?>" readonly style="background-color: #C0C0C0; color:grey;"></td>
								            </tr>
								            <tr>
									            <td>Số điện thoại</td>
									            <td><input type="text" class="form-control" name="phone" id="phone" value="<?php echo $row['phone_number']; ?>"readonly></td>
								            </tr>
								            <tr>
									            <td>Địa chỉ</td>
									            <td><input type="text" class="form-control" name="address" id="address" value="<?php echo $row['address']; ?>"readonly></td>
								            </tr>
                                            <!-- <tr>
									            <td>Ghi chú</td>
									            <td><input type="text" class="form-control" id="note" readonly></td>
								            </tr> -->
                                        </tbody>
                                    </table>
                                </div>
                                <div class="btn-update">
                                    <button type="submit" class="btn btn-outline-dark" id="edit-btn" name="submit-contact-form">Sửa</button>
                                    <button type="submit" class="btn btn-outline-dark" id="save-btn" name="submit-contact-form">Lưu</button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
		</div>
        <?php include './style_footer.php'?>
        <script>
    document.getElementById("edit-btn").addEventListener("click", function(event) {
        event.preventDefault(); // Ngăn chặn mặc định hành vi của sự kiện click
        document.getElementById("fullname").readOnly = false;
        document.getElementById("phone").readOnly = false;
        document.getElementById("address").readOnly = false;
    });

    document.getElementById("save-btn").addEventListener("click", function() {
        document.getElementById("account-form").action = "./editAccount.php";
    });
    </script>
</body>
</html>