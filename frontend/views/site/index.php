<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'e STORE';
?>
<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
        <strong>Rahmat!</strong> <?= Yii::$app->session->getFlash('success') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>
<div class="header">
    <div class="row">
        <div class="col-md-12">
            <div class="header-slider normal-slider">
                <?php foreach ($blogs as $blog): ?>
                    <div class="header-slider-item">
                        <img src="<?= Yii::getAlias('@web') . '/' . $blog->image ?>" alt="<?= Html::encode($blog->title) ?>" style="object-fit: cover; height: 400px; width: 100%;" />
                        <div class="header-slider-caption">
                            <p><?= Html::encode($blog->title) ?></p>
                            <a class="btn" href="<?= \yii\helpers\Url::to(['site/viewblog', 'id' => $blog->id]) ?>">
                                <i class="fa fa-shopping-cart"></i>Hozir sotib olish
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php if (empty($blogs)): ?>
                    <div class="header-slider-item">
                        <img src="img/slider-1.jpg" alt="Default Slider" />
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Main Slider End -->
<!-- Brand Start -->
<div class="brand">
    <div class="container-fluid">
        <div class="brand-slider">
            <div class="brand-item"><img src="img/brand-1.png" alt=""></div>
            <div class="brand-item"><img src="img/brand-2.png" alt=""></div>
            <div class="brand-item"><img src="img/brand-3.png" alt=""></div>
            <div class="brand-item"><img src="img/brand-4.png" alt=""></div>
            <div class="brand-item"><img src="img/brand-5.png" alt=""></div>
            <div class="brand-item"><img src="img/brand-6.png" alt=""></div>
        </div>
    </div>
</div>
<!-- Brand End -->
<!-- Feature Start-->
<div class="feature">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-6 feature-col">
                <div class="feature-content">
                    <i class="fab fa-cc-mastercard"></i>
                    <h2>Secure Payment</h2>
                    <p>
                        Lorem ipsum dolor sit amet consectetur elit
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 feature-col">
                <div class="feature-content">
                    <i class="fa fa-truck"></i>
                    <h2>Worldwide Delivery</h2>
                    <p>
                        Lorem ipsum dolor sit amet consectetur elit
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 feature-col">
                <div class="feature-content">
                    <i class="fa fa-sync-alt"></i>
                    <h2>90 Days Return</h2>
                    <p>
                        Lorem ipsum dolor sit amet consectetur elit
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 feature-col">
                <div class="feature-content">
                    <i class="fa fa-comments"></i>
                    <h2>24/7 Support</h2>
                    <p>
                        Lorem ipsum dolor sit amet consectetur elit
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Feature End-->
<!-- Category Start-->
<div class="category">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="category-item ch-400">
                    <img src="/img/category-3.jpg" />
                    <a class="category-name" href="">
                        <p>Some text goes here that describes the image</p>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="category-item ch-250">
                    <img src="/img/category-4.jpg" />
                    <a class="category-name" href="">
                        <p>Some text goes here that describes the image</p>
                    </a>
                </div>
                <div class="category-item ch-150">
                    <img src="/img/category-5.jpg" />
                    <a class="category-name" href="">
                        <p>Some text goes here that describes the image</p>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="category-item ch-150">
                    <img src="/img/category-6.jpg" />
                    <a class="category-name" href="">
                        <p>Some text goes here that describes the image</p>
                    </a>
                </div>
                <div class="category-item ch-250">
                    <img src="/img/category-7.jpg" />
                    <a class="category-name" href="">
                        <p>Some text goes here that describes the image</p>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="category-item ch-400">
                    <img src="/img/category-5.jpg" />
                    <a class="category-name" href="">
                        <p>Some text goes here that describes the image</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Category End-->
<!-- Call to Action Start -->
<div class="call-to-action">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1>call us for any queries</h1>
            </div>
            <div class="col-md-6">
                <a href="tel:+998970268087">+777 77 777 7777</a>
            </div>
        </div>
    </div>
</div>
<!-- Call to Action End -->
<div class="product-view py-5" style="background: #f4f6f9;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-9 col-md-8">
                <div class="section-header mb-4">
                    <h2 style="font-weight: 800; color: #333; border-left: 5px solid #ff7466; padding-left: 15px;">
                        <?= $active_category ? "Kategoriya mahsulotlari" : "Recent Products" ?>
                    </h2>
                </div>
                <div class="row">
                    <?php foreach ($products as $product): ?>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-4">
                            <div class="product-card shadow-sm border-0" style="background: #fff; border-radius: 8px; overflow: hidden; transition: 0.3s; position: relative;">
                                <div class="p-2 text-center" style="background: #ff7466;">
                                    <a href="<?= \yii\helpers\Url::to(['site/view', 'id' => $product->id]) ?>" class="text-white font-weight-bold" style="font-size: 13px; text-decoration: none; display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        <?= \yii\helpers\Html::encode($product->title) ?>
                                    </a>
                                </div>
                                <div class="product-img-box" style="height: 220px; background: #fff; position: relative;">
                                    <?php
                                    // Rasmlarni massivga ajratamiz
                                    $images = !empty($product->image) ? explode(',', $product->image) : [];
                                    $carouselId = 'carousel-' . $product->id;
                                    ?>
                                    <?php if (count($images) > 1): ?>
                                        <!-- Karusel boshlanishi -->
                                        <div id="<?= $carouselId ?>" class="carousel slide" data-ride="carousel" data-interval="3000" style="height: 100%;">
                                            <div class="carousel-inner" style="height: 100%;">
                                                <?php foreach ($images as $index => $img):
                                                    $img = trim($img);
                                                    if (empty($img)) continue;
                                                    $path = (strpos($img, 'http') === 0) ? $img : Yii::getAlias('@web/') . $img;
                                                ?>
                                                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>" style="height: 220px; padding: 15px;">
                                                        <img src="<?= $path ?>" class="d-block w-100" style="height: 100%; object-fit: contain;" alt="Product image">
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>
                                            <a class="carousel-control-prev" href="#<?= $carouselId ?>" role="button" data-slide="prev" style="width: 10%;">
                                                <span class="carousel-control-prev-icon" aria-hidden="true" style="filter: invert(1);"></span>
                                            </a>
                                            <a class="carousel-control-next" href="#<?= $carouselId ?>" role="button" data-slide="next" style="width: 10%;">
                                                <span class="carousel-control-next-icon" aria-hidden="true" style="filter: invert(1);"></span>
                                            </a>
                                        </div>
                                    <?php else: ?>
                                        <div class="p-3 text-center" style="height: 100%; display: flex; align-items: center; justify-content: center;">
                                            <?php
                                            $singleImg = !empty($images[0]) ? trim($images[0]) : '/img/product-5.jpg';
                                            $imagePath = (strpos($singleImg, 'http') === 0) ? $singleImg : Yii::getAlias('@web/') . $singleImg;
                                            ?>
                                            <img src="<?= $imagePath ?>" alt="Product" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                                        </div>
                                    <?php endif; ?>
                                    <div style="position: absolute; top: 10px; right: 10px; z-index: 10; display: flex; flex-direction: column; gap: 8px;">
                                        <?php
                                        $isGuest = Yii::$app->user->isGuest;
                                        $is_in_wishlist = false;

                                        // Foydalanuvchi tizimga kirgan bo'lsa, mahsulot sevimli ekanini tekshiramiz
                                        if (!$isGuest) {
                                            $is_in_wishlist = \common\models\Wishlist::find()
                                                ->where(['user_id' => Yii::$app->user->id, 'product_id' => $product->id])
                                                ->exists();
                                        }
                                        $cart = Yii::$app->session->get('cart', []);
                                        $cartActive = isset($cart[$product->id]);
                                        ?>
                                        <!-- Sevimlilar tugmasi -->
                                        <a href="javascript:void(0)"
                                            class="btn btn-sm btn-light shadow-sm wishlist-btn"
                                            data-id="<?= $product->id ?>"
                                            style="border-radius: 50%; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                            <i class="fa fa-heart wishlist-icon-<?= $product->id ?>"
                                                style="color: <?= $is_in_wishlist ? '#e74c3c' : '#6c757d' ?>;"></i>
                                        </a>
                                        <?php
                                        $cart = Yii::$app->session->get('cart', []);
                                        $is_in_cart = isset($cart[$product->id]);
                                        ?>
                                        <a href="javascript:void(0)"
                                            class="btn btn-sm btn-light shadow-sm toggle-cart"
                                            data-id="<?= $product->id ?>"
                                            style="border-radius: 50%; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; border: 1px solid #eee;">
                                            <i class="fa fa-shopping-cart cart-icon-<?= $product->id ?>"
                                                style="color: <?= $is_in_cart ? '#28a745' : '#6c757d' ?>; transition: 0.3s;"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="p-3 d-flex align-items-center justify-content-between" style="background: #222; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;">
                                    <span class="text-white" style="font-size: 18px; font-weight: 700;"><?= number_format($product->price, 0, '.', ' ') ?> UZS</span>
                                    <a href="<?= \yii\helpers\Url::to(['site/buy-now', 'id' => $product->id]) ?>"
                                        class="btn btn-sm btn-danger px-3 py-1"
                                        style="background: #6d0b02; border: none; font-size: 12px; font-weight: bold;">
                                        <i class="fa fa-shopping-cart mr-1"></i> Buy Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <style>
                    .carousel-control-prev-icon,
                    .carousel-control-next-icon {
                        width: 100%;
                        height: 100%;
                    }
                    .product-card:hover {
                        transform: translateY(-1px);
                    }
                </style>
            </div>
            <div class="col-lg-3 col-md-4">
                <div class="card border-0 shadow-sm" style="border-radius: 8px;">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0" style="font-weight: 700; color: #333;">Kategoriyalar</h5>
                        <?php if ($active_category): ?>
                            <a href="javascript:history.back()" class="btn btn-sm btn-outline-secondary" title="Orqaga">
                                <i class="fa fa-arrow-left"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                    <div class="card-body p-0">
                        <div class="list-group list-group-flush">
                            <!-- Barcha mahsulotlar -->
                            <a href="<?= Url::to(['site/index']) ?>" class="list-group-item list-group-item-action <?= !$active_category ? 'bg-light font-weight-bold text-danger' : '' ?>">
                                <i class="fa <?= !$active_category ? 'fa-folder-open' : 'fa-folder' ?> mr-2"></i> Barcha mahsulotlar
                            </a>
                            <?php foreach ($categories as $cat): ?>
                                <a href="<?= Url::to(['site/index', 'category_id' => $cat->id]) ?>"
                                    class="list-group-item list-group-item-action <?= $active_category == $cat->id ? 'bg-light font-weight-bold text-danger' : '' ?>">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>
                                            <i class="fa <?= count($cat->childs) > 0 ? 'fa-folder' : 'fa-file-o' ?> mr-2" style="color: #ffc107;"></i>
                                            <?= Html::encode($cat->name_uz) ?>
                                        </span>
                                        <?php if (count($cat->childs) > 0): ?>
                                            <small class="badge badge-pill badge-light"><?= count($cat->childs) ?></small>
                                        <?php endif; ?>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }
    .active-cat {
        background-color: #ff7466 !important;
        color: #fff !important;
        border: none;
    }
    .product-card .hover-buttons {
        opacity: 0;
        transition: 0.3s;
    }
    .product-card:hover .hover-buttons {
        opacity: 1;
    }
    .list-group-item {
        border: none;
        padding: 12px 20px;
        font-size: 14px;
        font-weight: 500;
        color: #555;
    }
    .list-group-item:hover {
        background: #f8f9fa;
        color: #ff7466;
    }
</style>
<?php
// PHP qismida kerakli manzillarni olamiz
$wishlistUrl = \yii\helpers\Url::to(['site/wishlist']);
$cartUrl = \yii\helpers\Url::to(['site/toggle-cart']);
$csrfParam = Yii::$app->request->csrfParam;
$csrfToken = Yii::$app->request->csrfToken;
$js = <<<JS
$(document).on('click', '.wishlist-btn', function(e) {
    e.preventDefault();
    let btn = $(this);
    let productId = btn.data('id');
    let icon = $('.wishlist-icon-' + productId);
    $.ajax({
        url: '{$wishlistUrl}',
        type: 'GET',
        data: { id: productId },
        success: function(res) {
            if (res.status === 'added') {
                icon.css('color', '#ff0000'); 
            } else if (res.status === 'removed') {
                icon.css('color', '#6c757d'); 
            } else if (res.status === 'error') {
                alert(res.message);
            }
        }
    });
});
$(document).on('click', '.toggle-cart', function(e) {
    e.preventDefault();
    let btn = $(this);
    let productId = btn.data('id');
    let icon = $('.cart-icon-' + productId); 
    $.ajax({
        url: '{$cartUrl}',
        type: 'POST',
        data: {
            id: productId,
            '{$csrfParam}': '{$csrfToken}'
        },
        success: function(res) {
            if (res.status === 'added') {
                icon.css('color', '#0011ff'); // Yashil
            } else if (res.status === 'removed') {
                icon.css('color', '#6c757d'); // Kulrang
            }
            if (res.cartCount !== undefined && $('.cart-count').length) {
                $('.cart-count').text(res.cartCount);
            }
        }
    });
});
JS;
$this->registerJs($js);
?>