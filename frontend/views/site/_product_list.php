<div class="row">
    <?php if (!empty($products)): ?>
        <?php foreach ($products as $product): ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <!-- SIZ YUBORGAN CHUROYLI PRODUCT-ITEM KODI SHU YERGA TUSHADI -->
                <div class="product-item shadow-sm border-0 bg-white rounded overflow-hidden">
                    <div class="product-title p-2 text-center" style="background: #ff7466;">
                        <a href="<?= \yii\helpers\Url::to(['site/view', 'id' => $product->id]) ?>" class="text-white font-weight-bold">
                            <?= \yii\helpers\Html::encode($product->title) ?>
                        </a>
                    </div>
                    <!-- Karusel va rasm qismi shu yerda qoladi... -->
                    <!-- Narx va Buy Now qismi shu yerda qoladi... -->
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12 text-center py-5">
            <h4 class="text-muted">Bu kategoriyada mahsulot topilmadi.</h4>
        </div>
    <?php endif; ?>
</div>
