<?php
$conn = mysqli_connect('localhost', 'root', '', 'web_bankinh');
session_start();
if(isset($_POST['submit'])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $accountCheck = "select * from user where email = '$username' and password = '$password'";
    
    $result = mysqli_query($conn, $accountCheck);
    $check = mysqli_num_rows($result);
    if($check == 1) {
        while($row = mysqli_fetch_row($result)) {
            $idAccount = $row[0];
            $fullname = $row[1];
        }
        $fullname = $_SESSION['login']['fullname'];
        $_SESSION['login']['username'] = $username;
        $_SESSION['login']['password'] = $password;
        $_SESSION['login']['idAccount'] = $idAccount;
        echo 
        "
        <script>
        alert('Đăng nhập thành công !!!');
        document.location.href = 'home.php';
        </script>
        ";
        // header('Location: ./home.php');
    }
    else{
        echo 
        "
        <script>
        alert('Tài khoản hoặc mật khẩu không đúng');
        document.location.href = 'home.php';
        </script>
        ";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kính mắt thời trang</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link rel="stylesheet" href="./style_full.css">
    <link rel="stylesheet" href="./style_gongkinh.css">
    <link rel="stylesheet" href="fontawesome-free-6.5.1-web/css/all.css">
    <link rel="stylesheet" href="./image/">
</head>
<body>

    <header class="header">
        <div class="container">
            <div class="header-mid">
                <!-- logo -->
                <div class="header-mid-logo">
                    <img src="https://hmkeyewear.com/wp-content/uploads/2023/09/logo.svg" alt="Mắt Kính HATO">
                </div>
                <!--thanh tim kiem-->
                <div class="header-mid-search"> 
                    <form action="/search">
                        <input type="hidden" name="type" value="product">
                        <input required="" name="q" autocomplete="off" type="text" placeholder="Nhập tên sản phẩm">
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </form>
                    <div class="header-mid-search-smart">
                    </div>
                </div>
                <!--dang ky, gio hang-->
                <div class="header-mid-nav" style="color: #fff;">
                   <?php
                        if(isset($_SESSION['login']['username'])) {
                            // Lấy địa chỉ email từ cột username
                            $email = $_SESSION['login']['username'];
                            // Tách chuỗi thành mảng dựa trên ký tự '@'
                            $parts = explode('@', $email);
                            // Lấy phần tử đầu tiên của mảng là phần trước của địa chỉ email
                            $username = $parts[0];
                            echo '<strong><a href="./account.php">'. $username.'</a></strong>';
                            echo' <a href="./logout.php"><button class="button-header"><strong>Đăng xuất</strong><i class="fa fa-sign-out"></i></button></a>';
                        } else {
                            echo '<button class="button-header button-header-login" id="username" name="username">';
                            echo '<strong>Tài khoản</strong><i class="fa fa-user"></i>';
                        }
                    ?>
                    </button>
                   <a href="./cart.php"><button class="button-header"><strong>Giỏ hàng</strong><i class="fas fa-shopping-bag"></i></button></a>
                </div>
                     
            </div>
            <div class="header-bot">
                <ul class="fHeader-menu0">
                    <li class="hasChild">
                        <a style="text-decoration: none" href="./home.php"><i class="fa fa-home"></i> TRANG CHỦ</li></a>
                    <li class="hasChild">
                        <a style="text-decoration: none" href="./gongkinh.php">GỌNG KÍNH</a>
                        <!-- <ul class="fHeader-menu1">
                            
                            <li>
                                <a href="">GỌNG KÍNH TRÒN</a>
                            </li>
                            <li class="">
                                <a href="">GỌNG KÍNH TITAN</a>
                            </li>                           
                            <li class="">
                                <a href="">GỌNG KÍNH MẠ VÀNG 18K</a>
                            </li>
                        </ul> -->
                    </li>
                   
                    <li class="hasChild" >
                    <a style="text-decoration: none" href="./kinhmat.php">KÍNH MẲT</a>
                        <!-- <ul class="fHeader-menu1">
                            
                            <li>
                                <a href="">KÍNH MẮT NAM</a>
                            </li>
                            <li class="">
                                <a href="">KÍNH MẮT NỮ</a>
                            </li>                           
                            <li>
                                <a href="">KÍNH LỌC ÁNH SÁNG XANH</a>
                            </li>
                        </ul> -->
                    </li>
                    <li class="hasChild">
                    <a style="text-decoration: none" href="./trongkinh.php">TRÒNG KÍNH</a>
                        <!-- <ul class="fHeader-menu1">
                            
                            <li class="">
                                <a href="">TRÒNG KÍNH ĐỔI MÀU</a>
                            </li>                           
                            <li class="">
                                <a href="">TRÒNG KÍNH MÀU</a>
                            </li>  
                            <li>
                                <a href="">TRÒNG KÍNH CHỐNG ÁNH SÁNG XANH</a>
                            </li> 

                        </ul>        -->
                    </li>
                    <!-- <li class="hasChild">VỀ QTV</li> -->
                    <li class="hasChild">KHUYẾN MÃI</li>
                    <li class="hasChild">
                    <a style="text-decoration: none" href="./feedback.php">LIÊN HỆ</li></a>
                    
                </ul>
            </div>
        </div>
    </header> 
    <!-- Popup Form-->
    <div class="blur-bg-overplay">
    <div class="form-popup">
        <span class="close-btn material-symbol-rounded"><i class="fas fa-times"></i></span>
        <div class="form-box login">
            <div class="form-details">
                <h2>Welcome Back</h2>
                <p>Please login in using your personal information to stay connected with us</p>
            </div>
            <div class="form-content">
                <h2>LOGIN</h2>
                <form action="./account.php" method="POST">
                    <div class="input-field">
                        <input type="text" id="username" name="username" required>
                        <label for="">Email</label>
                    </div>
                    <div class="input-field">
                        <input type="password" id="password" name="password" required>
                        <label for="">Password</label>
                    </div>
                    <a href="#" class="forgot-pass">Forgot Password</a>
                    <button type="submit" name="submit">LOGIN</button>
                </form>
                <div class="bottom-link">
                    Don't have account?
                    <a href="#" id="signup-link">Signup</a>
                </div>
            </div>
        </div>
        <div class="form-box signup">
            <div class="form-details">
                <h2>Create Account</h2>
                <p>To become a part of our community, please sign up using personal information </p>
            </div>
            <div class="form-content">
                <h2>SIGN UP</h2>
                <form action="./signup.php" method="post">
                <div class="input-field">
                        <input id="createName" name="createName" type="text" required>
                        <label for="">Enter your name</label>
                    </div>
                    <div class="input-field">
                        <input id="createEmail" name="createEmail" type="text" required>
                        <label for="">Enter your email</label>
                    </div>
                    <div class="input-field">
                        <input id="createPw" name="createPw" type="password" required>
                        <label for="">Create password</label>
                    </div> 
                    <div class="input-field">
                        <input id="confirmPw" name="confirmPw" type="password" required disabled>
                        <label for="">Confirm password</label>
                    </div> 
                    <div class="policy-text">
                        <input type="checkbox" id="policy" required>
                        <label for="policy">
                            I agree the
                            <a href="#">Terms & Conditions</a>
                        </label>
                    </div>
                    <button type="submit" id="submitBtn" name="submitBtn" required disabled>SIGN UP</button>
                </form>
                <div class="bottom-link">
                    Already have account?
                    <a href="#" id="login-link">Login</a>
                </div>
            </div>
        </div>
    </div> 
    </div>
    
    <script src="script.js">
       
    </script>
</body>
</html>
