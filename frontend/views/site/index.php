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

<!-- Main Slider Start -->
<div class="header">

    <div class="row">
        <div class="col-md-12">
            <div class="header-slider normal-slider">
                <?php foreach ($blogs as $blog): ?>
                    <div class="header-slider-item">
                        <img src="<?= Url::to('@web/' . ($blog->image ?? 'img/category-5.jpg')) ?>" alt="<?= Html::encode($blog->title) ?>" style="object-fit: cover; height: 400px; width: 100%;" />

                        <div class="header-slider-caption">
                            <p><?= Html::encode($blog->title) ?></p>

                            <a class="btn" href="<?= \yii\helpers\Url::to(['site/add-blog-to-cart', 'id' => $blog->id]) ?>">
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
                    <img src="img/category-3.jpg" />
                    <a class="category-name" href="">
                        <p>Some text goes here that describes the image</p>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="category-item ch-250">
                    <img src="img/category-4.jpg" />
                    <a class="category-name" href="">
                        <p>Some text goes here that describes the image</p>
                    </a>
                </div>
                <div class="category-item ch-150">
                    <img src="img/category-5.jpg" />
                    <a class="category-name" href="">
                        <p>Some text goes here that describes the image</p>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="category-item ch-150">
                    <img src="img/category-6.jpg" />
                    <a class="category-name" href="">
                        <p>Some text goes here that describes the image</p>
                    </a>
                </div>
                <div class="category-item ch-250">
                    <img src="img/category-7.jpg" />
                    <a class="category-name" href="">
                        <p>Some text goes here that describes the image</p>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="category-item ch-400">
                    <img src="img/category-5.jpg" />
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
                                    <a href="<?= Url::to(['site/view', 'id' => $product->id]) ?>" class="text-white font-weight-bold" style="font-size: 13px; text-decoration: none; display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        <?= Html::encode($product->title) ?>
                                    </a>
                                </div>

                                <div class="product-img-box" style="height: 220px; display: flex; align-items: center; justify-content: center; background: #fff; padding: 15px; position: relative;">
                                    <?php
                                    $imagePath = Yii::getAlias('@web/img/product-5.jpg');

                                    if ($product->image && file_exists(Yii::getAlias('@webroot/') . $product->image)) {
                                        $imagePath = Yii::getAlias('@web/') . $product->image;
                                    }
                                    ?>

                                    <img src="<?= $imagePath ?>" alt="Product" style="max-height: 100%; max-width: 100%; object-fit: contain;">


                                    <div class="hover-buttons" style="position: absolute; display: flex; gap: 5px;">
                                        <a href="<?= Url::to(['site/add-cart', 'id' => $product->id]) ?>" class="btn btn-sm btn-light shadow-sm">
                                            <i class="fa fa-shopping-cart text-danger"></i>
                                        </a>
                                        <a href="javascript:void(0)"
                                            class="btn btn-sm btn-light shadow-sm wishlist-btn"
                                            data-id="<?= $product->id ?>">
                                            <i class="fa fa-heart text-danger"></i>
                                        </a>
                                    </div>

                                </div>

                                <div class="p-3 d-flex align-items-center justify-content-between" style="background: #222; border-bottom-left-radius: 8px; border-bottom-right-radius: 8px;">
                                    <span class="text-white" style="font-size: 20px; font-weight: 700;">$<?= number_format($product->price, 0, '.', ',') ?></span>
                                    <a href="<?= Url::to(['site/add-cart', 'id' => $product->id]) ?>" class="btn btn-sm btn-danger px-3 py-1" style="background: #6d0b02; border: none; font-size: 12px; font-weight: bold;">
                                        <i class="fa fa-shopping-cart mr-1"></i> Buy Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="col-lg-3 col-md-4">
                <div class="card border-0 shadow-sm" style="border-radius: 8px;">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0" style="font-weight: 700; color: #333;">Category</h5>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <a href="<?= Url::to(['site/index']) ?>" class="list-group-item list-group-item-action <?= !$active_category ? 'active-cat' : '' ?>">
                                <i class="fa fa-chevron-right mr-2" style="font-size: 10px;"></i> Barcha mahsulotlar
                            </a>
                            <?php foreach ($categories as $cat): ?>
                                <a href="<?= Url::to(['site/index', 'category_id' => $cat->id]) ?>"
                                    class="list-group-item list-group-item-action <?= $active_category == $cat->id ? 'active-cat' : '' ?>">
                                    <i class="fa fa-chevron-right mr-2" style="font-size: 10px;"></i> <?= Html::encode($cat->name_uz) ?>
                                </a>
                            <?php endforeach; ?>
                        </ul>
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
$wishlistUrl = \yii\helpers\Url::to(['site/wishlist']);
$this->registerJs(
    <<<JS
    $('.wishlist-btn').on('click', function(e) {
        e.preventDefault();
        var btn = $(this);
        var productId = btn.data('id');

        $.ajax({
            url: '$wishlistUrl',
            type: 'GET',
            data: {id: productId},
            success: function(res) {
                if(res.status === 'success') {
                    btn.find('i').removeClass('fa-heart-o').addClass('fa-heart');
                    alert('Mahsulot saralanganga qo\'shildi!');
                } else {
                    alert(res.message || 'Xatolik yuz berdi');
                }
            },
            error: function() {
                alert('Server bilan aloqa yo\'q');
            }
        });
    });
JS
);
?>