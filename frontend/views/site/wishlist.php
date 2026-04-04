<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Sevimli mahsulotlaringiz';
?>

<div class="container mt-5 mb-5">
    <h2 class="mb-4 text-center"><i class="fa fa-heart text-danger"></i> Sevimli mahsulotlaringiz</h2>

    <div class="table-responsive shadow-sm" style="background: #fff; border-radius: 12px; padding: 20px;">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Mahsulot</th>
                    <th>Narxi</th>
                    <th class="text-center">Savatga qo'shish</th>
                    <th class="text-center">O'chirish</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($wishlistItems)): ?>
                    <?php foreach ($wishlistItems as $item): ?>
                        <?php if ($item->product):  ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php 
                                            $img = $item->product->image;
                                            $imagePath = (strpos($img, 'http') === 0) ? $img : Yii::getAlias('@web/uploads/') . $img;
                                        ?>
                                        <img src="<?= $imagePath ?>" width="60" class="rounded mr-3" style="object-fit: cover;">
                                        <a href="<?= Url::to(['site/view', 'id' => $item->product->id]) ?>" class="font-weight-bold text-dark">
                                            <?= Html::encode($item->product->title) ?>
                                        </a>
                                    </div>
                                </td>
                                <td class="font-weight-bold text-danger">
                                    $<?= number_format($item->product->price, 0) ?>
                                </td>
                                <td class="text-center">
                                    <a href="<?= Url::to(['site/add-cart', 'id' => $item->product->id]) ?>" class="btn btn-sm btn-outline-danger px-3">
                                        <i class="fa fa-shopping-cart"></i> Qo'shish
                                    </a>
                                </td>
                                <td class="text-center">
                                    <?= Html::a('<i class="fa fa-trash"></i>', ['site/remove-wishlist', 'id' => $item->id], [
                                        'class' => 'btn btn-sm btn-outline-danger',
                                        'data' => [
                                            'method' => 'post',
                                            'confirm' => 'Are you sure you want to remove this item from your wishlist?'
                                        ]
                                    ]) ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center py-5">
                            <p class="text-muted">Hozircha sevimlilar ro'yxati bo'sh.</p>
                            <a href="<?= Url::to(['site/index']) ?>" class="btn btn-danger px-4">Xaridni boshlash</a>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
