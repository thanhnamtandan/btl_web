<?php
    $conn = mysqli_connect('localhost', 'root', '', 'web_bankinh');
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    session_start();
    if(isset($_POST['submitBtn'])){
        $createName = $_POST["createName"];
        $createEmail = $_POST["createEmail"];
        $createPw = $_POST["createPw"];
        $role_id = 1;

        // Sử dụng Prepared Statements để tránh SQL Injection
        $select = "SELECT * FROM user WHERE email = ?";
        $stmt_select = $conn->prepare($select);
        $stmt_select->bind_param("s", $createEmail);
        $stmt_select->execute();
        $result = $stmt_select->get_result();

        if ($result->num_rows > 0) {
            // Email đã tồn tại, bạn có thể xử lý tại đây
            echo "Email already exists!";
        } else {
            // Mật khẩu chưa kiểm tra vì đã thực hiện ở phía client

            // Sử dụng Prepared Statements để thêm dữ liệu vào cơ sở dữ liệu
            $insert = "INSERT INTO user(fullname, email, password, role_id) VALUES(?, ?, ?, ?)";
            $stmt_insert = $conn->prepare($insert);
            $stmt_insert->bind_param("sssi", $createName, $createEmail, $createPw, $role_id);
            if ($stmt_insert->execute()) {
                // Đăng ký thành công, chuyển hướng đến trang home.php
                header('Location: ./home.php');
            } else {
                // Xử lý lỗi khi thêm vào cơ sở dữ liệu
                echo "Error: " . $insert . "<br>" . $conn->error;
            }
        }

        // Đóng kết nối
        $stmt_select->close();
        $stmt_insert->close();
        $conn->close();
    }
?>
