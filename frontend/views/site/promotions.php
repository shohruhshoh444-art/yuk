<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $promotions common\models\Blog[] */
?>

<style>
    .promotions-page {
        padding: 60px 0;
        background: #f8f9fa;
    }

    .promo-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .promo-header h1 {
        font-weight: 800;
        color: #2d3436;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .promo-header .underline {
        width: 80px;
        height: 4px;
        background: #7000ff;
        margin: 15px auto;
        border-radius: 2px;
    }

    /* Grid Dizayni */
    .promo-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 30px;
    }

    /* Karta dizayni */
    .promo-card {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.4s ease;
        border: none;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        position: relative;
    }

    .promo-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
    }

    .promo-img-wrapper {
        height: 220px;
        overflow: hidden;
        position: relative;
    }

    .promo-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .promo-card:hover .promo-img-wrapper img {
        transform: scale(1.1);
    }

    .promo-body {
        padding: 25px;
    }

    .promo-card-title {
        font-size: 20px;
        font-weight: 700;
        color: #333;
        margin-bottom: 12px;
        height: 56px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .promo-btn {
        display: inline-block;
        width: 100%;
        padding: 12px;
        background: #ff2f2f;
        color: #fff !important;
        text-align: center;
        border-radius: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: 0.3s;
        border: 2px solid transparent;
    }

    .promo-btn:hover {
        background: transparent;
        color: #ff2f2f !important;
        border-color: #ff2f2f;
    }

    .promo-date {
        position: absolute;
        top: 15px;
        left: 15px;
        background: rgba(255, 47, 47, 0.9);
        color: white;
        padding: 5px 15px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 500;
        z-index: 2;
    }
</style>

<div class="promotions-page">
    <div class="container">
        <div class="promo-header">
            <h1>Maxsus Aksiyalar</h1>
            <div class="underline"></div>
            <p class="text-muted">Faqat siz uchun eng sara takliflar va chegirmalar</p>
        </div>

        <div class="promo-grid">
            <?php foreach ($promotions as $promo): ?>
                <?php
                $images = explode(',', $promo->image);
                $img = !empty($images[0]) ? trim($images[0]) : 'no-image.png';
                ?>
                <div class="promo-card">
                    <div class="promo-date">
                        <i class="fa fa-calendar-alt"></i> Aksiya faol
                    </div>

                    <div class="promo-img-wrapper">
                        <img src="<?= Yii::getAlias('@web/') . $img ?>"
                            alt="<?= Html::encode($promo->title) ?>"
                            onerror="this.src='<?= Yii::getAlias('@web/img/no-image.png') ?>'">
                    </div>

                    <div class="promo-body">
                        <h3 class="promo-card-title"><?= Html::encode($promo->title) ?></h3>

                        <p class="text-muted mb-4" style="height: 45px; overflow: hidden; font-size: 14px;">
                            <?= isset($promo->content) ? Html::encode($promo->content) : 'Ushbu aksiya doirasida ajoyib mahsulotlarni arzon narxlarda xarid qiling.' ?>
                        </p>
                        <?= Html::a(
                            'Aksiyani ko\'rish <i class="fa fa-arrow-right ml-2"></i>',
                            ['site/view-blog', 'id' => $promo->id], // 'view-blog' bu actionViewBlog ga mos keladi
                            ['class' => 'promo-btn']
                        )
                        ?>


                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (empty($promotions)): ?>
            <div class="text-center py-5">
                <i class="fa fa-gift fa-4x text-muted mb-3"></i>
                <h3>Hozircha faol aksiyalar yo'q</h3>
                <a href="/" class="btn btn-primary mt-3">Bosh sahifaga qaytish</a>
            </div>
        <?php endif; ?>
    </div>
</div>