
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
.feedback {
    background: lavender;
    padding-top: 6rem !important;
    padding-top: 100px;
    padding-bottom: 120px;
}
.container-feedback {
    width: 100%;
    padding-left: 16px;
    padding-right: 16px;
    margin-left: auto;
    margin-right: auto;
    max-width: 1140px;
}
.col-md-7{
    flex: 0 0 58.33333%;
    max-width: 58.33333%;
    margin-bottom: 0 !important;
    position: relative;
    width: 100%;
    min-height: 1px;
    padding-right: 15px;
    padding-left: 15px;
}
.mb-5, .my-5 {
    margin-bottom: 3rem !important;
}
.text-uppercase {
    letter-spacing: 0.1em;
}
.mb-md-0, .my-md-0 {
        margin-bottom: 0 !important;
    }
.row {
    display: flex;
    flex-wrap: wrap;
    margin-right: -15px;
    margin-left: -15px;
}
.col-sm-6 {
        -ms-flex: 0 0 50%;
        flex: 0 0 50%;
        max-width: 50%;
    }
.form-group {
    margin-bottom: 1rem;
}
.form-label {
    color: black;
    font-size: 0.7875rem;
    text-transform: uppercase;
    letter-spacing: 0.1em;
}
.form-control {
    display: block;
    width: 100%;
    height: calc(2.55rem + 2px);
    padding: 0.6rem 0.75rem;
    font-size: 0.9rem;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
}
.col-sm-6{
    position: relative;
    width: 100%;
    min-height: 1px;
    padding-right: 15px;
    padding-left: 15px;
}
textarea.form-control {
    height: auto;
}
.btn-outline-dark{
    cursor: pointer;
    padding: 10px 50px;
    background: 0 0;
    color: #333;
    border: 1px solid #333;
    border-radius: 48px;
    font-weight: 600;
    transition: .4s cubic-bezier(.5, 0, 0, 1.25);
}
.btn-outline-dark:hover{
    background: #333;
    color: #fff;
    transition: .4s cubic-bezier(.5, 0, 0, 1.25);
}
.btn-center{
    text-align: center;
}
.col-md-5 {
    -ms-flex: 0 0 41.66667%;
    flex: 0 0 41.66667%;
    max-width: 41.66667%;
    position: relative;
    width: 100%;
    min-height: 1px;
    padding-right: 15px;
    padding-left: 15px;
    }
    </style>
</head>
<body>
    <?php include './style_header.php' ?>

    <section class="feedback">
        <div class="container-feedback">
            <header class="mb-5">
                <h2 class="text-uppercase h5">Gửi Phản Hồi</h2>
            </header>
            <div class="row">
                <div class="col-md-7 mb-5 mb-md-0">
                    <form action="./feedback_connectsql.php" id="contact-form" method="post" class="contact-form">
                        <div class="controls">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="firstname" class="form-label">Tên *</label>
                                        <input type="text" name="firstname" id="firstname" placeholder="Nhập Tên" required="required" class="form-control">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="lastname" class="form-label">Họ *</label>
                                        <input type="text" name="lastname" id="lastname" placeholder="Nhập họ" required="required" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="form-label">Địa Chỉ Email *</label>
                                <input type="email" name="email" id="email" placeholder="Nhập địa chỉ email" required="required" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="phone_number" class="form-label">Số Điện Thoại *</label>
                                <input type="telno" name="phone_number" id="phone_number" placeholder="Nhập số điện thoại" required="required" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="subject_name" class="form-label">Tiêu Đề *</label>
                                <input type="text" name="subject_name" id="subject_name" placeholder="Nhập tiêu đề" required="required" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="note" class="form-label">Nội Dung Tin Nhắn *</label>
                                <textarea rows="4" name="note" id="note" placeholder="Nhập nội dung" required="required" class="form-control"></textarea>
                            </div>
                            <div class="btn-center">
                                <button type="submit" class="btn btn-outline-dark" id="submit-contact-form" name="submit-contact-form">Gửi</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-5">
                    <span style="font-size: 18px; letter-spacing: 1.8px; text-transform: uppercase;">
                        <b>Liên hệ công ty mắt kính 3 AE</b>
                    </span>
                    <br>
                    <br>
                    <b>Địa chỉ :&nbsp;</b>
                    Trường Đại Học Kinh Tế Kĩ Thuật Công Nghiệp, Ngõ 218 Đường Lĩnh Nam, Hoàng Mai, Hà Nội
                    <div>
                        <b>Số điện thoại:</b>
                        0123.456.789
                    </div>
                    <div>
                        <br>
                            <div>Chúng tôi luôn trân trọng và mong đợi nhận được mọi ý kiến đóng góp từ khách hàng để có thể nâng cấp trải nghiệm dịch vụ và sản phẩm tốt hơn nữa.</div>
                        </br>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <?php include './style_footer.php' ?>
</body>
</html>