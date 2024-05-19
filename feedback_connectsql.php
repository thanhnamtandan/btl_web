<?php
$conn = mysqli_connect('localhost', 'root', '', 'web_bankinh');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
session_start();
if(isset($_POST['submit-contact-form'])){
    $firstname = $_POST["firstname"];
    $lastname = $_POST["lastname"];
    $email = $_POST["email"];
    $phone_number = $_POST["phone_number"];
    $subject_name = $_POST["subject_name"];
    $note = $_POST["note"];

    // Sửa lỗi tên cột và bao quanh giá trị bằng dấu nháy đơn
    $insertfeedback = "INSERT INTO feedback(firstname, lastname, email, phone_number, subject_name, note) 
                       VALUES ('$firstname', '$lastname', '$email', '$phone_number', '$subject_name', '$note')";
    if(mysqli_query($conn, $insertfeedback)){
        header('Location: ./home.php');
        exit(); // Đảm bảo chương trình dừng tại đây sau khi chuyển hướng
    } else {
        echo "Lỗi: " . mysqli_error($conn); // Xử lý khi có lỗi xảy ra
    }
}
?>
