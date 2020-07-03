<?php require APPROOT . '/views/inc/header.php'; ?>
<?php
$product = $data["product"];
$avgStar = $data["avgStar"];
$review = $data["review"];
$count_review = $review->num_rows;
?>
<div class="container">
    <div class="row justify-content-center main-content">
        <div id="main-image" class="col-lg-5 col-md-9 col-sm-10 col-12">
            <a href="<?php echo $product["image"] ?>">
                <img src="<?php echo $product["image"] ?>" class="product-detail-img" alt="test image"></a>
        </div>
        <div id="description" class="col-lg-7 col-md-9 col-sm-10 col-12">
            <?php flash('addReview_success');?>
            <div id="description-title" class="bd-bottom mt-3">
                <h3 class="bold-text"><?php echo $product["name"] ?></h3>
                <div class="mt-3 mb-3 rating-review">
                    <?php
                    echo printStar($avgStar);
                    ?>
                    <span class="color-red bold-text"><?php echo $avgStar ?>/5</span>&nbsp;
                    <a href="#review-container" class="link-in-detail">( Xem <?php echo $count_review ?> đánh giá )</a>
                </div>
            </div>
            <div id="product-price" class="bd-bottom mt-3">
                <h5 class="bold-text">Giá sản phẩm <i class="fas fa-tags color-blue"></i></h5>
                <ul class="color-red bold-text">
                    <?php
                    while ($price_row = $product["price_list"]->fetch_assoc()) {
                        $price = $price_row["price"];
                        $size_name = $price_row["size"];
                        echo "<li>Size $size_name : $price đ</li>";
                    }
                    ?>
                </ul>
            </div>
            <div id="description-content" class="bd-bottom mt-3">
                <h5 class="bold-text">Mô tả</h5>
                <ul class="list-description">
                    <?php
                    $arr_description = explode(";", $product["description"]);
                    for ($i = 0; $i < count($arr_description); $i++) {
                        echo "<li>$arr_description[$i]</li>";
                    }
                    ?>
                </ul>
            </div>
            <div id="order-aria" class="bd-bottom mt-3">
                <h5 class="bold-text">Đặt hàng ngay</h5>
                <?php if (isset($_SESSION['user_id'])) : ?>
                    <form class="mt-3 mb-3 d-flex justify-content-around" method="post">
                        <div>
                            <label for="quantity">Số lượng:</label>
                            <input class="form-control" type="number" id="quantity" name="quantity" min="1" max="10" value="1">
                        </div>
                        <button type="submit" id="order-button" class="btn btn-danger"><i class='fas fa-cart-plus'></i>&nbsp;&nbsp;CHỌN MUA</button>
                    </form>
                <?php else : ?>
                    <h6 class="mb-3 mt-3 text-danger">Bạn phải đăng nhập để thực hiện việc này</h6>
                <?php endif; ?>
            </div>
            <!-- <div id="description-address" class="mt-3">
                <h5 class="bold-text">Địa chỉ giao hàng dự kiến</h5>
                <p>Kí túc xá khu A, Đại học quốc gia</p>
            </div> -->
            <div class="d-flex justify-content-start mt-3 mb-3">
                <h5 class="bold-text mt-3">Thêm đánh giá cho sản phẩm này</h5>
                <button onclick=" displayRating();" class="btn btn-dark rounded-circle ml-3 button-hover"><i class="fas fa-plus"></i></button>
            </div>
            <?php if (isset($_SESSION['user_id'])) : ?>
            <div id="add-rating-container">
                <form action="<?php echo URLROOT;?>products/addReview" class="rating-box" method="post">
                    <input type="hidden" id="productId" name="productId" value=<?php echo $product["id"] ?>>
                    <input type="hidden" id="userId" name="userId" value=<?php echo $_SESSION["user_id"] ?>>
                    <div class="d-flex justify-content-start">
                        <div class="ratings mt-3">
                            <i class="fas fa-star icon-rating"></i>
                            <i class="fas fa-star icon-rating"></i>
                            <i class="fas fa-star icon-rating"></i>
                            <i class="fas fa-star icon-rating"></i>
                            <i class="far fa-star icon-rating"></i>
                        </div>
                        <span id="rating-description" class="mt-3 ml-3 bold-text">Tuyệt vời</span>
                        <input type="hidden" id="rating-value" name="rating-value" value="4">
                    </div>
                    <div class="form-group">
                        <label for="rating-content" class="bold-text mt-3">Đánh giá</label>
                        <textarea class="form-control" id="rating-content" name="rating-content" rows="2" placeholder="Vui lòng nhập đánh giá của bạn ở đây"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary button-hover mb-3" value="submit">Gửi đánh giá</button>
                </form>
            </div>
            <?php else : ?>
                <h6 class="mb-3 text-danger">Bạn phải đăng nhập để thực hiện việc này</h6>
            <?php endif; ?>
        </div>
    </div>
    <div class="row mb-5 p-1" id="review-container">
        <h3 class="bold-text mt-3">Đánh giá của khách hàng</h3>
        <?php while ($review_row = $review->fetch_assoc()) {
            $user_name = $review_row["name"];
            $datetime  =  $review_row["createdAt"];
            $content = $review_row["content"];
            $star_html = printStar($review_row["numberstar"]);
            echo
                "
                <div class='card mt-3 col-12'>
                    <div class='card-body'>
                        <h5 class='card-title bold-text'>$user_name</h5>
                        <p class='color-grey'>$datetime</p>
                        <div class='mt-2 mb-2'>"
                    . $star_html .
                    "</div>
                        <p class='card-text'>$content</p>
                    </div>
                </div>
                ";
        }
        ?>
    </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>