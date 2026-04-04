<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $product->title;
?>

<div class="container mt-5 mb-5" style="background: #fff; padding: 30px; border-radius: 16px;">
    <div class="row">
       <div class="main-image-box" style="border: 1px solid #f2f2f2; border-radius: 12px; padding: 20px; height: 500px; display: flex; align-items: center; justify-content: center; background: #fff;">
    <?php 
        $img = $product->image;
        
        if (empty($img)) {
            $imagePath = "/images/no-image.png"; 
        } elseif (strpos($img, 'http') === 0) {
            $imagePath = $img;
        } else {

            $baseUrl = Yii::$app->request->baseUrl;
            
            if (strpos($img, 'uploads') === 0) {
                $imagePath = $baseUrl . '/' . $img;
            } else {
                $imagePath = $baseUrl . '/uploads/' . $img;
            }
        }
    ?>
    
    <img src="<?= $imagePath ?>" 
         class="img-fluid" 
         style="max-height: 100%; max-width: 100%; object-fit: contain;" 
         alt="<?= \yii\helpers\Html::encode($product->title) ?>"
         onerror="this.src='https://placeholder.com'">
</div>


        <!-- O'ng tomonda: Ma'lumotlar -->
        <div class="col-md-6">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="background: transparent; padding: 0;">
                    <li class="breadcrumb-item"><a href="/" style="color: #767676;">Bosh sahifa</a></li>
                    <li class="breadcrumb-item active"><?= Html::encode($product->title) ?></li>
                </ol>
            </nav>

            <h1 style="font-size: 28px; font-weight: 700; color: #1f1f1f; margin-bottom: 15px;">
                <?= Html::encode($product->title) ?>
            </h1>

            <div class="price-box mb-4" style="background: #fdf2f2; padding: 20px; border-radius: 12px;">
                <p style="margin: 0; color: #767676; font-size: 14px;">Mahsulot narxi:</p>
                <div class="d-flex align-items-center">
                    <span style="font-size: 32px; font-weight: 800; color: #ff7466;">
                        $<?= number_format($product->price, 0) ?>
                    </span>
                    <?php if($product->discount_price): ?>
                        <span class="ml-3" style="text-decoration: line-through; color: #b5b5b5; font-size: 18px;">
                            $<?= number_format($product->discount_price + 100, 0) ?>
                        </span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="short-info mb-4">
                <p><strong>Omborda:</strong> <span class="text-success"><?= $product->stock ?> dona bor</span></p>
                <p><strong>Yetkazib berish:</strong> <span style="color: #00b067;"><i class="fa fa-truck"></i> 1 kun, bepul</span></p>
            </div>

            <div class="actions d-flex gap-3 mt-5">
                <a href="<?= Url::to(['cart/add', 'id' => $product->id]) ?>" class="btn btn-lg px-5 py-3" style="border: 2px solid #ff7466; color: #ff7466; font-weight: bold; border-radius: 12px; flex: 1; margin-right: 10px;">
                    Savatchaga qo'shish
                </a>
                <a href="<?= Url::to(['site/add-cart', 'id' => $product->id]) ?>" class="btn btn-lg px-5 py-3" style="background: #ff7466; color: #fff; font-weight: bold; border-radius: 12px; flex: 1;">
                    Hoziroq sotib olish
                </a>
            </div>
        </div>
    </div>

    <!-- Pastki qism: Tavsif va Xususiyatlar -->
    <div class="row mt-5 pt-5 border-top">
        <div class="col-md-8">
            <h3 style="font-weight: 700; margin-bottom: 20px;">Mahsulot tavsifi</h3>
            <div style="color: #4d4d4d; line-height: 1.8; font-size: 16px;">
                <?= nl2br(Html::encode($product->description)) ?>
            </div>
        </div>
        <div class="col-md-4">
            <h3 style="font-weight: 700; margin-bottom: 20px;">Xususiyatlari</h3>
            <table class="table table-borderless">
                <?php 
                    $specs = json_decode($product->specifications, true);
                    if ($specs): 
                        foreach ($specs as $key => $value): ?>
                        <tr style="border-bottom: 1px dashed #eee;">
                            <td class="pl-0" style="color: #767676;"><?= Html::encode($key) ?></td>
                            <td class="text-right font-weight-bold"><?= Html::encode($value) ?></td>
                        </tr>
                <?php endforeach; endif; ?>
            </table>
        </div>
    </div>
</div>

<style>
    .btn:hover { opacity: 0.9; transform: translateY(-2px); transition: 0.3s; }
    .breadcrumb-item + .breadcrumb-item::before { content: ">"; }
</style>
