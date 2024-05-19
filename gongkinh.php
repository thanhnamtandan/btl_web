<?php
$conn = mysqli_connect('localhost', 'root', '', 'web_bankinh');
// if(isset($_GET['id'])) {
//     $data = $_GET['id'];
//     $querySanPham = "select * from product Where category_id=1";
// }
$priceFilters = isset($_GET['price']) ? $_GET['price'] : [];
$priceQueryPart = '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';

if (!empty($priceFilters)) {
    $priceConditions = [];
    if (in_array('under500k', $priceFilters)) {
        $priceConditions[] = 'price < 500000';
    }
    if (in_array('500kto1m', $priceFilters)) {
        $priceConditions[] = 'price BETWEEN 500000 AND 1000000';
    }
    if (in_array('above1m', $priceFilters)) {
        $priceConditions[] = 'price > 1000000';
    }
    if (!empty($priceConditions)) {
        $priceQueryPart = ' AND (' . implode(' OR ', $priceConditions) . ')';
    }
}

$orderBy = '';
if ($sort == 'asc') {
    $orderBy = ' ORDER BY price ASC';
} elseif ($sort == 'desc') {
    $orderBy = ' ORDER BY price DESC';
}

// $querySanPham = "SELECT * FROM product WHERE category_id=1" . $priceQueryPart . $orderBy;
// $result = mysqli_query($conn, $querySanPham);


$totalQuery = "SELECT COUNT(*) as total FROM product WHERE category_id=1" . $priceQueryPart;
$totalResult = mysqli_query($conn, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalProducts = $totalRow['total'];
$productsPerPage = 12;
$totalPages = ceil($totalProducts / $productsPerPage);
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page > $totalPages) {
    $page = $totalPages;
}
if ($page < 1) {
    $page = 1;
}
$offset = ($page - 1) * $productsPerPage;

$querySanPham = "SELECT * FROM product WHERE category_id=1" . $priceQueryPart . $orderBy . " LIMIT $offset, $productsPerPage";
$result = mysqli_query($conn, $querySanPham);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style_full.css">
    <link rel="stylesheet" href="./style_gongkinh.css">
    <link rel="stylesheet" href="fontawesome-free-6.5.1-web/css/all.css">
    <title>Document</title>
    <style>
        .filter-button {
            background-color: #ff5722;
            /* Màu nền */
            color: white;
            /* Màu chữ */
            border: none;
            /* Bỏ viền */
            padding: 10px 20px;
            /* Khoảng cách bên trong nút */
            text-align: center;
            /* Căn giữa chữ */
            text-decoration: none;
            /* Bỏ gạch chân */
            display: inline-block;
            /* Hiển thị dưới dạng khối nội tuyến */
            font-size: 16px;
            /* Kích thước chữ */
            margin: 10px 0;
            /* Khoảng cách bên ngoài nút */
            cursor: pointer;
            /* Thay đổi con trỏ chuột khi hover */
            border-radius: 4px;
            /* Bo góc */
            transition: background-color 0.3s;
            /* Hiệu ứng chuyển màu */
            width: 100%;
        }

        .filter-button:hover {
            background-color: #e64a19;
            /* Màu nền khi hover */
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }

        .pagination a {
            color: black;
            padding: 8px 16px;
            text-decoration: none;
            border: 1px solid #ddd;
            margin: 0 4px;
        }

        .pagination a.active {
            background-color: #4CAF50;
            color: white;
            border: 1px solid #4CAF50;
        }

        .pagination a:hover:not(.active) {
            background-color: #ddd;
        }
    </style>
</head>

<body>
    <?php include './style_header.php' ?>

    <div class="collection-wrap-product">
        <div class="collection-wrap-product-header">
            <div class="section-title-all">
                <h2>GỌNG KÍNH</h2>
            </div>
        </div>
        <div class="KcXmcC">
            <div class="container-shoppe fiCAD6">
                <div class="shopee-filter-panel">
                    <div class="shopee-search-filter-status">
                        <h2 class="shopee-search-filter-status__text">
                            Bộ lọc tìm kiếm
                        </h2>
                    </div>
                    <form method="GET">
                        <fieldset class="shopee-filter-group shopee-facet-filter">
                            <legend class="shopee-filter-group__header">Sắp xếp</legend>
                            <div class="shopee-filter shopee-checkbox-filter">
                                <lable class="shopee-checkbox">
                                    <div class="shopee-checkbox__box">
                                        <input type="checkbox" name="sort" value="asc">
                                    </div>
                                    <span class="shopee-checkbox__label">Giá từ thấp đến cao</span>
                                </lable>
                            </div>
                            <div class="shopee-filter shopee-checkbox-filter">
                                <lable class="shopee-checkbox">
                                    <div class="shopee-checkbox__box">
                                        <input type="checkbox" name="sort" value="desc">
                                    </div>
                                    <span class="shopee-checkbox__label">Giá từ cao xuống thấp</span>
                                </lable>
                            </div>
                        </fieldset>


                        <fieldset class="shopee-filter-group shopee-facet-filter">
                            <legend class="shopee-filter-group__header">Theo giá</legend>
                            <div class="shopee-filter shopee-checkbox-filter">
                                <lable class="shopee-checkbox">
                                    <div class="shopee-checkbox__box">
                                        <input type="checkbox" name="price[]" value="under500k">
                                    </div>
                                    <span class="shopee-checkbox__label">Dưới 500.000</span>
                                </lable>
                            </div>
                            <div class="shopee-filter shopee-checkbox-filter">
                                <lable class="shopee-checkbox">
                                    <div class="shopee-checkbox__box">
                                        <input type="checkbox" name="price[]" value="500kto1m">
                                    </div>
                                    <span class="shopee-checkbox__label">Từ 500.000-1.000.0000</span>
                                </lable>
                            </div>
                            <div class="shopee-filter shopee-checkbox-filter">
                                <lable class="shopee-checkbox">
                                    <div class="shopee-checkbox__box">
                                        <input type="checkbox" name="price[]" value="above1m">
                                    </div>
                                    <span class="shopee-checkbox__label">Trên 1.000.000</span>
                                </lable>
                            </div>
                        </fieldset>
                        <button type="submit" class="filter-button">Lọc</button>
                    </form>
                </div>
                <div role="main" class="u37UBO">
                    <section class="home-product p-section" style="padding: 0;">
                        <div class="container1">
                            <div class="tabs tabs-main">
                                <div class="tabs-panel">
                                    <div class="tabs-panel-item active">
                                        <div class="card-list">
                                            <?php
                                            if (!isset($querySanPham)) {
                                                $querySanPham = "select * from product where category_id=1";
                                            }
                                            $result = mysqli_query($conn, $querySanPham);
                                            while ($row = mysqli_fetch_row($result)) {
                                                echo '
                                            <div class="card"> 
                                                <div class="card-img">
                                                    <a href="./detailProduct.php" class="swiper-container swiper-container-initialized swiper-container-horizontal" title="Kính Mát KM823">
                                                        <div class="swiper-wrapper" style="transform: translate3d(0px, 0px, 0px);">
                                                            <div class="card-img-item swiper-slide swiper-slide-active" style="width: 278px; margin-right: 16px;">
                                                                <img loading="lazy" src=" ' . $row[5] . ' " alt="Kính Mát KM823">
                                                            </div>
                                        
                                                        </div>
                                                        <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
                                                    </a>
                                                    <a href="./detailProduct_connectsql.php? id=' . $row[0] . '" class="btn-main">Xem chi tiết</a>
                                                </div>
                                                <div class="card-content">
                                                     <div class="card-thumb swiper-pagination-clickable swiper-pagination-bullets">
                                                        <div class="card-thumb-pagination card-thumb-item active" tabindex="0" role="button" aria-label="Go to slide 1">
                                                            <img src="https://hmkeyewear.com/wp-content/uploads/2022/11/23-1-800x800.png">
                                                        </div>
                                                         <div class="card-thumb-pagination card-thumb-item" tabindex="0" role="button" aria-label="Go to slide 2">
                                                            <img src="https://hmkeyewear.com/wp-content/uploads/2022/11/23-3-800x800.png">
                                                        </div>
                                                        <div class="card-thumb-pagination card-thumb-item" tabindex="0" role="button" aria-label="Go to slide 3">
                                                            <img src="https://hmkeyewear.com/wp-content/uploads/2022/11/23-5-800x800.png">
                                                        </div> 
                                                    </div>    
                                                    <div class="card-content-box">
                                                        <a href="https://hmkeyewear.com/san-pham/kinh-mat-km823/" class="title" title="Kính Mát KM823">' . $row[2] . '</a>
                                                        <div class="price">
				                                            <span class="woocommerce-Price-amount amount"><bdi>' . number_format($row[3], 0, '.', ',') . '<span class="woocommerce-Price-currencySymbol"> VNĐ</span></bdi></span>
                                                        </div>
		                                            </div>
                                                </div>
                                            </div>';
                                            };
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <div class="pagination">
                        <?php
                        // Tạo liên kết phân trang
                        $queryString = $_GET;
                        if ($page > 1) {
                            $queryString['page'] = $page - 1;
                            echo '<a href="?' . http_build_query($queryString) . '">&laquo; Trang trước</a>';
                        }
                        for ($i = 1; $i <= $totalPages; $i++) {
                            $queryString['page'] = $i;
                            echo '<a href="?' . http_build_query($queryString) . '" class="' . ($i == $page ? 'active' : '') . '">' . $i . '</a>';
                        }

                        if ($page < $totalPages) {
                            $queryString['page'] = $page + 1;
                            echo '<a href="?' . http_build_query($queryString) . '">Trang sau &raquo;</a>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>