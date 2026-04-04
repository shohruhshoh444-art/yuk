<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = 'Mahsulotlar Boshqaruvi';
?>

<div class="container-fluid py-4">
    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success"><?= Yii::$app->session->getFlash('success') ?></div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-white d-flex justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Barcha mahsulotlar</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover border">
                            <thead class="bg-light">
                                <tr>
                                    <th>Nomi</th>
                                    <th>Kategoriya</th>
                                    <th>Narxi</th>
                                    <th>Status</th>
                                    <th>Amallar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $prod): ?>
                                    <tr>
                                        <td>
                                            <strong><?= Html::encode($prod->title) ?></strong><br>
                                            <small class="text-muted">ID: <?= $prod->id ?></small>
                                        </td>
                                        <td><?= $prod->category ? $prod->category->name_uz : 'Kategoriyasiz' ?></td>
                                        <td>
                                            <span class="text-success"><?= number_format($prod->discount_price, 0, '.', ' ') ?> so'm</span><br>
                                            <?php if ($prod->discount_price): ?>
                                                <del class="small text-danger"><?= number_format($prod->price, 0, '.', ' ') ?></del>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge badge-<?= $prod->status ? 'success' : 'secondary' ?>">
                                                <?= $prod->status ? 'Sotuvda' : 'Yo\'q' ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?= Html::a('✏️', ['product', 'id' => $prod->id], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                                            <?= Html::a('🗑', ['product', 'del' => $prod->id], [
                                                'class' => 'btn btn-sm btn-outline-danger',
                                                'data-confirm' => 'Mahsulotni o\'chirmoqchimisiz?',
                                                'data-method' => 'post'
                                            ]) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow border-0">
                <div class="card-header bg-<?= $newProd->isNewRecord ? 'info' : 'primary' ?> text-white">
                    <h6 class="m-0 font-weight-bold"><?= $newProd->isNewRecord ? 'Yangi mahsulot' : 'Tahrirlash: ' . $newProd->name ?></h6>
                </div>
                <div class="card-body">
                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

                    <?= $form->field($newProd, 'category_id')->dropDownList(
                        ArrayHelper::map($categories, 'id', 'name_uz'),
                        ['prompt' => 'Kategoriyani tanlang...']
                    ) ?>

                    <?= $form->field($newProd, 'title')->textInput(['placeholder' => 'Mahsulot nomi...']) ?>

                    <?= $form->field($newProd, 'imageFile')->fileInput() ?>

                    <?php if (!$newProd->isNewRecord && $newProd->image): ?>
                        <div class="mb-2">
                            <p class="small text-muted mb-1">Hozirgi rasm:</p>
                            <?php
                            $img = $newProd->image;
                            $imagePath = (strpos($img, 'http') === 0) ? $img : Yii::getAlias('@frontend/web/') . $img;
                            ?>
                            <img src="<?= $imagePath ?>" width="100" class="img-thumbnail">
                        </div>
                    <?php endif; ?>

                    <!-- Narxlar va Stock bir qatorda -->
                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($newProd, 'price')->textInput(['type' => 'number', 'placeholder' => '0']) ?>
                        </div>
                        <div class="col-md-5">
                            <?= $form->field($newProd, 'discount_price')->textInput(['type' => 'number', 'placeholder' => '0']) ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <!-- STOCK MAYDONI SHU YERDA -->
                        <?= $form->field($newProd, 'stock')->textInput(['type' => 'number', 'placeholder' => 'Soni...']) ?>
                    </div>

                    <?= $form->field($newProd, 'description')->textarea(['rows' => 3]) ?>

                    <?= $form->field($newProd, 'specifications')->textarea([
                        'rows' => 2,
                        'placeholder' => 'Rang: Qora, Hajm: 128GB...'
                    ]) ?>

                    <?= $form->field($newProd, 'status')->dropDownList([1 => 'Sotuvda', 0 => 'Yo\'q']) ?>

                    <div class="form-group mb-0">
                        <?= Html::submitButton($newProd->isNewRecord ? '➕ Qo\'shish' : '💾 Yangilash', [
                            'class' => 'btn btn-block btn-' . ($newProd->isNewRecord ? 'info' : 'primary')
                        ]) ?>
                        <?php if (!$newProd->isNewRecord): ?>
                            <?= Html::a('Bekor qilish', ['product'], ['class' => 'btn btn-link btn-block btn-sm']) ?>
                        <?php endif; ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>

            </div>
        </div>

    </div>
</div>