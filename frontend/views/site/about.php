<?php

use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="product-view py-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9">
                <div class="row">
                    <?php if (!empty($products)): ?>
                        <?php foreach ($products as $product): ?>
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="product-item shadow-sm border-0 bg-white rounded overflow-hidden">
                                    <div class="product-title p-2 text-center" style="background: #ff7466;">
                                        <a href="#" class="text-white font-weight-bold"><?= Html::encode($product->name) ?></a>
                                    </div>
                                    <div class="product-image d-flex align-items-center justify-content-center" style="height: 250px;">
                                        <img src="<?= Url::to('@web/' . ($product->image ?? 'img/product-1.jpg')) ?>" style="max-height: 90%; max-width: 90%;">

                                        <div class="product-action" style="position: absolute; top: 10px; left: 10px;">
                                            <a href="<?= Url::to(['site/add-cart', 'id' => $product->id]) ?>" class="btn btn-sm btn-light border mb-1"><i class="fa fa-shopping-cart"></i></a><br>
                                            <a href="<?= Url::to(['site/add-wishlist', 'id' => $product->id]) ?>" class="btn btn-sm btn-light border"><i class="fa fa-heart text-danger"></i></a>
                                        </div>
                                    </div>
                                    <div class="product-price p-3 d-flex justify-content-between align-items-center bg-dark">
                                        <h3 class="m-0 text-white">$<?= number_format($product->price, 0) ?></h3>
                                        <a class="btn btn-danger btn-sm" href="<?= Url::to(['site/add-cart', 'id' => $product->id]) ?>">
                                            <i class="fa fa-shopping-cart"></i> Buy Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-center py-5">
                            <h4 class="text-muted">Ushbu kategoriyada mahsulotlar topilmadi.</h4>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="sidebar shadow-sm p-4 bg-white rounded">
                    <h4 class="font-weight-bold border-bottom pb-2 mb-3">Category</h4>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <a href="<?= Url::to(['site/index']) ?>" class="text-dark <?= !$active_category ? 'font-weight-bold text-danger' : '' ?>">
                                <i class="fa fa-angle-right mr-2"></i>Barcha mahsulotlar
                            </a>
                        </li>
                        <?php foreach ($categories as $cat): ?>
                            <li class="mb-2">
                                <a href="<?= Url::to(['site/index', 'category_id' => $cat->id]) ?>"
                                    class="text-dark <?= $active_category == $cat->id ? 'font-weight-bold text-danger' : '' ?>">
                                    <i class="fa fa-angle-right mr-2"></i><?= Html::encode($cat->name_uz) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


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

