<?php

/** @var yii\web\View $this */

use yii\helpers\Html;

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
        <div class="col-md-3">
            <nav class="navbar bg-light">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-home"></i>Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-shopping-bag"></i>Best Selling</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-plus-square"></i>New Arrivals</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-female"></i>Fashion & Beauty</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-child"></i>Kids & Babies Clothes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-tshirt"></i>Men & Women Clothes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-mobile-alt"></i>Gadgets & Accessories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa fa-microchip"></i>Electronics & Accessories</a>
                    </li>
                </ul>
            </nav>
        </div>
        <div class="col-md-6">
            <div class="header-slider normal-slider">
                <?php foreach ($blogs as $blog): ?>
                    <div class="header-slider-item">
                        <img src="<?= Yii::getAlias('@web/') . $blog->image ?>" alt="<?= Html::encode($blog->title) ?>" style="object-fit: cover; height: 400px; width: 100%;" />

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

        <div class="col-md-3">
            <div class="header-img">
                <div class="img-item">
                    <img src="img/category-1.jpg" />
                    <a class="img-text" href="">
                        <p>Some text goes here that describes the image</p>
                    </a>
                </div>
                <div class="img-item">
                    <img src="img/category-2.jpg" />
                    <a class="img-text" href="">
                        <p>Some text goes here that describes the image</p>
                    </a>
                </div>
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
                    <img src="img/category-8.jpg" />
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

<!-- Recent Product Start -->
<div class="recent-product product">
    <div class="container-fluid">
        <div class="section-header mb-4">
            <h1 style="border-left: 5px solid #ff7466; padding-left: 15px;">Recent Products</h1>
        </div>
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="product-item shadow-sm border-0" style="background: #fff; transition: 0.3s; border-radius: 10px; overflow: hidden;">
                        <div class="product-title p-3 text-center" style="background: #222;">
                            <a href="#" class="text-white font-weight-bold" style="font-size: 14px; text-transform: uppercase;">
                                <?= \yii\helpers\Html::encode($product->name) ?>
                            </a>
                            <div class="ratting mt-1">
                                <?php for ($i = 0; $i < 5; $i++): ?> <i class="fa fa-star text-warning" style="font-size: 11px;"></i> <?php endfor; ?>
                            </div>
                        </div>
                        <div class="product-image position-relative" style="height: 280px; display: flex; align-items: center; justify-content: center; background: #fff;">
                            <img src="<?= Yii::getAlias('@web/') . $product->image ?>" alt="Product" style="max-height: 90%; max-width: 90%; object-fit: contain;">
                            <div class="product-action" style="position: absolute; bottom: 15px; width: 100%; text-align: center;">
                                <a href="<?= \yii\helpers\Url::to(['site/add-cart', 'id' => $product->id]) ?>" class="btn btn-outline-dark mx-1 shadow-sm bg-white">
                                    <i class="fa fa-shopping-cart"></i>
                                </a>
                                <a href="<?= \yii\helpers\Url::to(['site/add-wishlist', 'id' => $product->id]) ?>" class="btn btn-outline-danger mx-1 shadow-sm bg-white">
                                    <i class="fa fa-heart"></i>
                                </a>
                            </div>
                        </div>
                        <div class="product-price p-3 text-center" style="background: #f8f8f8;">
                            <h3 class="text-dark mb-2" style="font-weight: 800;">$<?= number_format($product->price, 0) ?></h3>
                            <a class="btn btn-block py-2" href="<?= \yii\helpers\Url::to(['site/add-cart', 'id' => $product->id]) ?>"
                                style="background: #ff7466; color: #fff; border-radius: 5px; font-weight: bold; font-size: 14px;">
                                <i class="fa fa-shopping-bag mr-2"></i> BUY NOW
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Recent Product End -->


<!-- Newsletter Start -->
<div class="newsletter">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <h1>Subscribe Our Newsletter</h1>
            </div>
            <div class="col-md-6">
                <div class="form">
                    <input type="email" value="Your email here">
                    <button>Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Newsletter End -->

<!-- Recent Product Start -->
<div class="recent-product product">
    <div class="container-fluid">
        <div class="section-header">
            <h1>Recent Product</h1>
        </div>
        <div class="row align-items-center product-slider product-slider-4">
            <div class="col-lg-3">
                <div class="product-item">
                    <div class="product-title">
                        <a href="#">Product Name</a>
                        <div class="ratting">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                    </div>
                    <div class="product-image">
                        <a href="product-detail.html">
                            <img src="img/product-6.jpg" alt="Product Image">
                        </a>
                        <div class="product-action">
                            <a href="<?= \yii\helpers\Url::to(['site/add-cart', 'id' => $product->id]) ?>"><i class="fa fa-cart-plus"></i></a>
                            <a href="#"><i class="fa fa-heart"></i></a>
                            <a href="#"><i class="fa fa-search"></i></a>
                        </div>
                    </div>
                    <div class="product-price">
                        <h3><span>$</span>99</h3>
                        <a class="btn" href=""><i class="fa fa-shopping-cart"></i>Buy Now</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="product-item">
                    <div class="product-title">
                        <a href="#">Product Name</a>
                        <div class="ratting">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                    </div>
                    <div class="product-image">
                        <a href="product-detail.html">
                            <img src="img/product-7.jpg" alt="Product Image">
                        </a>
                        <div class="product-action">
                            <a href="<?= \yii\helpers\Url::to(['site/add-cart', 'id' => $product->id]) ?>"><i class="fa fa-cart-plus"></i></a>
                            <a href="#"><i class="fa fa-heart"></i></a>
                            <a href="#"><i class="fa fa-search"></i></a>
                        </div>
                    </div>
                    <div class="product-price">
                        <h3><span>$</span>99</h3>
                        <a class="btn" href=""><i class="fa fa-shopping-cart"></i>Buy Now</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="product-item">
                    <div class="product-title">
                        <a href="#">Product Name</a>
                        <div class="ratting">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                    </div>
                    <div class="product-image">
                        <a href="product-detail.html">
                            <img src="img/product-8.jpg" alt="Product Image">
                        </a>
                        <div class="product-action">
                            <a href="<?= \yii\helpers\Url::to(['site/add-cart', 'id' => $product->id]) ?>"><i class="fa fa-cart-plus"></i></a>
                            <a href="#"><i class="fa fa-heart"></i></a>
                            <a href="#"><i class="fa fa-search"></i></a>
                        </div>
                    </div>
                    <div class="product-price">
                        <h3><span>$</span>99</h3>
                        <a class="btn" href=""><i class="fa fa-shopping-cart"></i>Buy Now</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="product-item">
                    <div class="product-title">
                        <a href="#">Product Name</a>
                        <div class="ratting">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                    </div>
                    <div class="product-image">
                        <a href="product-detail.html">
                            <img src="img/product-9.jpg" alt="Product Image">
                        </a>
                        <div class="product-action">
                            <a href="<?= \yii\helpers\Url::to(['site/add-cart', 'id' => $product->id]) ?>"><i class="fa fa-cart-plus"></i></a>
                            <a href="#"><i class="fa fa-heart"></i></a>
                            <a href="#"><i class="fa fa-search"></i></a>
                        </div>
                    </div>
                    <div class="product-price">
                        <h3><span>$</span>99</h3>
                        <a class="btn" href=""><i class="fa fa-shopping-cart"></i>Buy Now</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="product-item">
                    <div class="product-title">
                        <a href="#">Product Name</a>
                        <div class="ratting">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                    </div>
                    <div class="product-image">
                        <a href="product-detail.html">
                            <img src="img/product-10.jpg" alt="Product Image">
                        </a>
                        <div class="product-action">
                            <a href="<?= \yii\helpers\Url::to(['site/add-cart', 'id' => $product->id]) ?>"><i class="fa fa-cart-plus"></i></a>
                            <a href="#"><i class="fa fa-heart"></i></a>
                            <a href="#"><i class="fa fa-search"></i></a>
                        </div>
                    </div>
                    <div class="product-price">
                        <h3><span>$</span>99</h3>
                        <a class="btn" href=""><i class="fa fa-shopping-cart"></i>Buy Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Recent Product End -->

<!-- Review Start -->
<div class="review">
    <div class="container-fluid">
        <div class="row align-items-center review-slider normal-slider">
            <div class="col-md-6">
                <div class="review-slider-item">
                    <div class="review-img">
                        <img src="img/review-1.jpg" alt="Image">
                    </div>
                    <div class="review-text">
                        <h2>Customer Name</h2>
                        <h3>Profession</h3>
                        <div class="ratting">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vitae nunc eget leo finibus luctus et vitae lorem
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="review-slider-item">
                    <div class="review-img">
                        <img src="img/review-2.jpg" alt="Image">
                    </div>
                    <div class="review-text">
                        <h2>Customer Name</h2>
                        <h3>Profession</h3>
                        <div class="ratting">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vitae nunc eget leo finibus luctus et vitae lorem
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="review-slider-item">
                    <div class="review-img">
                        <img src="img/review-3.jpg" alt="Image">
                    </div>
                    <div class="review-text">
                        <h2>Customer Name</h2>
                        <h3>Profession</h3>
                        <div class="ratting">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vitae nunc eget leo finibus luctus et vitae lorem
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Review End -->