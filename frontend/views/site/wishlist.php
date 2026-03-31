<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Sevimlilar (Wishlist)';
?>

<div class="wishlist-page py-5">
    <div class="container">
        <div class="section-header mb-4">
            <h2><i class="fa fa-heart text-danger"></i> Sevimli mahsulotlaringiz</h2>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive bg-white shadow-sm p-3">
                    <table class="table table-bordered text-center align-middle">
                        <thead class="thead-dark">
                            <tr>
                                <th>Mahsulot</th>
                                <th>Narxi</th>
                                <th>Savatga qo'shish</th>
                                <th>O'chirish</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($products)): ?>
                                <?php foreach ($products as $product): ?>
                                <tr>
                                    <td class="text-left">
                                        <div class="d-flex align-items-center">
                                            <img src="<?= Url::to('@web/' . $product->image) ?>" width="60" class="mr-3 border">
                                            <span><?= Html::encode($product->name) ?></span>
                                        </div>
                                    </td>
                                    <td><strong>$<?= number_format($product->price, 0) ?></strong></td>
                                    <td>
                                        <?= Html::a('<i class="fa fa-shopping-cart"></i> Savatga qo\'shish', 
                                            ['site/add-cart', 'id' => $product->id], 
                                            ['class' => 'btn btn-sm btn-dark']) ?>
                                    </td>
                                    <td>
                                        <?= Html::a('<i class="fa fa-trash"></i>', 
                                            ['site/wishlist', 'del' => $product->id], 
                                            ['class' => 'btn btn-sm btn-outline-danger', 'data-method' => 'post']) ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="py-5 text-muted">
                                        <h4>Hozircha sevimlilar ro'yxati bo'sh.</h4>
                                        <br>
                                        <?= Html::a('Xaridni boshlash', ['site/index'], ['class' => 'btn btn-danger']) ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
