<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Shop';
?>

<div class="product-view py-4">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 mb-4" id="sidebar-container">
                <div class="sidebar shadow-sm p-4 rounded" style="background: #1e1e1e; color: #ccc; position: sticky; top: 20px;">
                    <h4 class="font-weight-bold border-bottom pb-3 mb-3 text-white">
                        <i class="fa fa-th-large mr-2 text-danger"></i> Category
                    </h4>
                    <ul class="list-unstyled">
                        <?php if (isset($active_cat) && $active_cat): ?>
                            <li class="mb-3">
                                <a href="<?= Url::to(['site/about', 'category_id' => $active_cat->parent_id]) ?>"
                                    class="category-filter text-info font-weight-bold text-decoration-none">
                                    <i class="fa fa-arrow-left mr-2"></i> Orqaga
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php foreach ($categories as $cat): ?>
                            <li class="mb-2 border-bottom border-secondary pb-2">
                                <a href="<?= Url::to(['site/about', 'category_id' => $cat->id]) ?>"
                                    class="category-filter text-light text-decoration-none d-flex justify-content-between align-items-center">
                                    <span><i class="fa fa-angle-right mr-2 text-secondary"></i> <?= Html::encode($cat->name_uz) ?></span>
                                    <i class="fa fa-chevron-right small opacity-50"></i>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <div class="col-md-9" id="product-container">
                <div class="row">
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="product-item shadow-sm border-0 bg-white rounded overflow-hidden h-100 transition-hover">
                                    <div class="product-title p-2 text-center" style="background: #ff7466;">
                                        <a href="<?= Url::to(['site/view', 'id' => $product->id]) ?>" class="text-white font-weight-bold text-truncate d-block" style="text-decoration: none;">
                                            <?= Html::encode($product->title) ?>
                                        </a>
                                    </div>

                                    <div class="product-image" style="height: 250px; background: #fff; position: relative; overflow: hidden;">
                                        <?php
                                        $images = !empty($product->image) ? explode(',', $product->image) : [];
                                        $carouselId = 'carousel-' . $product->id;
                                        ?>

                                        <?php if (count($images) > 1): ?>
                                            <div id="<?= $carouselId ?>" class="carousel slide h-100" data-ride="carousel" data-interval="3000">
                                                <div class="carousel-inner h-100">
                                                    <?php foreach ($images as $index => $img):
                                                        $img = trim($img);
                                                        $path = (strpos($img, 'http') === 0) ? $img : Url::to('@web/' . $img);
                                                    ?>
                                                        <div class="carousel-item h-100 <?= $index === 0 ? 'active' : '' ?> p-3">
                                                            <img src="<?= $path ?>" class="d-block w-100 h-100" style="object-fit: contain;" alt="Product image">
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>

                                                <a class="carousel-control-prev custom-nav" href="#<?= $carouselId ?>" role="button" data-slide="prev">
                                                    <i class="fa fa-chevron-left text-dark"></i>
                                                </a>
                                                <a class="carousel-control-next custom-nav" href="#<?= $carouselId ?>" role="button" data-slide="next">
                                                    <i class="fa fa-chevron-right text-dark"></i>
                                                </a>
                                            </div>
                                        <?php else: ?>
                                            <div class="d-flex align-items-center justify-content-center h-100 p-3">
                                                <?php
                                                $img = !empty($images) ? trim($images[0]) : 'img/no-image.png';
                                                $path = (strpos($img, 'http') === 0) ? $img : Url::to('@web/' . $img);
                                                ?>
                                                <img src="<?= $path ?>" style="max-height: 100%; max-width: 100%; object-fit: contain;" onerror="this.src='<?= Url::to('@web/img/no-image.png') ?>'">
                                            </div>
                                        <?php endif; ?>
                                        <div style="position: absolute; top: 10px; right: 10px; z-index: 10; display: flex; flex-direction: column; gap: 8px;">
                                            <?php
                                            $isInWishlist = false;
                                            if (!Yii::$app->user->isGuest) {
                                                $isInWishlist = \common\models\Wishlist::find()
                                                    ->where(['user_id' => Yii::$app->user->id, 'product_id' => $product->id])
                                                    ->exists();
                                            }
                                            $session = Yii::$app->session;
                                            $cart = $session->get('cart', []);
                                            $isInCart = isset($cart[$product->id]);
                                            ?>

                                            <a href="javascript:void(0)" class="btn btn-sm btn-light shadow-sm wishlist-btn" data-id="<?= $product->id ?>" style="border-radius: 50%; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fa fa-heart wishlist-icon-<?= $product->id ?>"
                                                    style="color: <?= $isInWishlist ? '#ff0000' : '#6c757d' ?>;"></i>
                                            </a>

                                            <!-- Agar stock 0 bo'lsa, tugma 'disabled' (o'lik) holatga keladi -->
                                            <a href="javascript:void(0)"
                                                data-id="<?= $product->id ?>"
                                                class="btn btn-sm btn-light shadow-sm <?= ($product->stock > 0) ? 'toggle-cart' : '' ?>"
                                                style="border-radius: 50%; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; 
          <?= ($product->stock <= 0) ? 'pointer-events: none; opacity: 0.6; cursor: not-allowed;' : '' ?>">

                                                <i class="fa <?= ($product->stock <= 0) ? 'fa-times' : 'fa-shopping-cart' ?> cart-icon-<?= $product->id ?>"
                                                    style="color: <?= ($product->stock <= 0) ? '#dc3545' : ($isInCart ? '#000dff' : '#6c757d') ?>;">
                                                </i>
                                            </a>

                                        </div>

                                    </div>

                                    <div class="product-price p-3 bg-dark d-flex justify-content-between align-items-center">
                                        <div class="text-white">
                                            <span class="font-weight-bold" style="font-size: 1.1rem;"><?= number_format($product->price, 0, '.', ' ') ?> UZS</span>
                                        </div>
                                        <a href="<?= Url::to(['site/buy-now', 'id' => $product->id]) ?>" class="btn btn-sm btn-danger px-3 font-weight-bold" style="background: #6d0b02; border: none; border-radius: 4px;">BUY NOW</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-center py-5">
                            <h4 class="text-muted font-italic">Ushbu kategoriyada mahsulotlar topilmadi.</h4>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .transition-hover {
        transition: transform 0.3s ease;
    }

    .transition-hover:hover {
        transform: translateY(-5px);
    }

    .custom-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 30px;
        height: 30px;
        background: rgba(255, 255, 255, 0.7);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 5;
        opacity: 0;
        transition: 0.3s;
    }

    .product-item:hover .custom-nav {
        opacity: 1;
    }

    .carousel-control-prev.custom-nav {
        left: 5px;
    }

    .carousel-control-next.custom-nav {
        right: 5px;
    }
</style>
<?php
$js = <<<JS
$(document).on('click', '.category-filter', function(e) {
    e.preventDefault();
    let url = $(this).attr('href');

    $.get(url, function(data) {
        let newContent = $(data);
        $('#product-container').html(newContent.find('#product-container').html());
        $('#sidebar-container').html(newContent.find('#sidebar-container').html());
        window.history.pushState(null, null, url);
    });
});
JS;
$this->registerJs($js);
?>

<?php
$aboutUrl = \yii\helpers\Url::to(['site/about']);
$wishlistUrl = \yii\helpers\Url::to(['site/wishlist']);
$cartUrl = \yii\helpers\Url::to(['site/toggle-cart']);
$csrfParam = Yii::$app->request->csrfParam;
$csrfToken = Yii::$app->request->csrfToken;

$js = <<<JS
$(document).on('click', '.category-filter', function(e) {
    e.preventDefault();
    let catId = $(this).data('id');

    $.ajax({
        url: '{$aboutUrl}',
        type: 'GET',
        data: { category_id: catId },
        success: function(res) {
            if (res.products) {
                $('#product-container').html(res.products);
            }
            if (res.sidebar) {
                $('#sidebar-container').html(res.sidebar);
            }
        },
        error: function(xhr) {
            console.error('Kategoriya yuklashda xato:', xhr.responseText);
        }
    });
});

$(document).on('click', '.wishlist-btn', function(e) {
    e.preventDefault();
    let productId = $(this).data('id');
    let icon = $('.wishlist-icon-' + productId);
    $.get('{$wishlistUrl}', { id: productId }, function(res) {
        if (res.status === 'added') icon.css('color', '#ff0000');
        else if (res.status === 'removed') icon.css('color', '#6c757d');
    });
});

$(document).on('click', '.toggle-cart', function(e) {
    e.preventDefault();
    let productId = $(this).data('id');
    let icon = $('.cart-icon-' + productId);
    $.post('{$cartUrl}', { id: productId, '{$csrfParam}': '{$csrfToken}' }, function(res) {
        if (res.status === 'added') icon.css('color', '#000dff');
        else icon.css('color', '#6c757d');
        if (res.cartCount !== undefined) $('.cart-count').text(res.cartCount);
    });
});
JS;
$this->registerJs($js);
?>