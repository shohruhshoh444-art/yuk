<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = 'Mahsulotlar Boshqaruvi';
?>

<style>
    /* Zamonaviy interfeys uchun qo'shimcha stillar */
    .main-card { border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); overflow: hidden; }
    .card-header { background: #fff !important; border-bottom: 1px solid #f0f2f5 !important; padding: 1.25rem; }
    .table thead th { background-color: #f8f9fa; text-transform: uppercase; font-size: 11px; letter-spacing: 1px; color: #8898aa; border-top: none; }
    .table td { vertical-align: middle !important; border-top: 1px solid #f4f7f6; padding: 1rem 0.75rem; }
    .product-img-slot { width: 45px; height: 45px; border-radius: 10px; object-fit: cover; background: #eee; margin-right: 12px; }
    .badge-soft-success { background: #e6fffa; color: #38b2ac; border: 1px solid #b2f5ea; }
    .badge-soft-secondary { background: #f7fafc; color: #718096; border: 1px solid #edf2f7; }
    .price-tag { font-weight: 700; color: #2d3748; }
    .btn-action { width: 32px; height: 32px; padding: 0; line-height: 32px; border-radius: 8px; transition: all 0.2s; }
    .form-control { border-radius: 10px; padding: 12px; border: 1px solid #e2e8f0; }
    .form-control:focus { box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.15); border-color: #3182ce; }
    .img-preview-container { display: flex; gap: 8px; flex-wrap: wrap; margin-top: 10px; }
    .img-preview-item { width: 55px; height: 55px; border-radius: 8px; border: 2px solid #edf2f7; object-fit: cover; }
    .sticky-form { position: sticky; top: 20px; }
</style>
<div class="container-fluid py-4 bg-light" style="min-height: 100vh;">
    <!-- Xabarnomalar -->
    <div class="row mb-3">
        <div class="col-12">
            <?php if (Yii::$app->session->hasFlash('success')): ?>
                <div class="alert alert-success border-0 shadow-sm rounded-pill px-4">
                    <i class="fas fa-check-circle mr-2"></i> <?= Yii::$app->session->getFlash('success') ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="row">
        <!-- Jadval qismi -->
        <div class="col-lg-8">
            <div class="card main-card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 font-weight-bold" style="color: #2d3748;">Omborxonadagi Mahsulotlar</h5>
                    <span class="badge badge-pill badge-primary px-3"><?= count($products) ?> ta</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th class="pl-4">Mahsulot</th>
                                    <th>Kategoriya</th>
                                    <th>Narx / Chegirma</th>
                                    <th>Status</th>
                                    <th class="text-right pr-4">Amallar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $prod): ?>
                                    <tr>
                                        <td class="pl-4">
                                            <div class="d-flex align-items-center">
                                                <?php 
                                                
                                                    $thumb = (!empty($firstImg)) ? ((strpos($firstImg, 'http') === 0) ? $firstImg : '/frontend/web/' . $firstImg) : 'https://placeholder.com';
                                                ?>
                                              
                                                <div>
                                                    <div class="font-weight-bold text-dark"><?= Html::encode($prod->title) ?></div>
                                                    <small class="text-muted">ID: #<?= $prod->id ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="text-muted small font-weight-600"><?= $prod->category ? $prod->category->name_uz : '—' ?></span></td>
                                        <td>
                                            <div class="price-tag"><?= number_format($prod->discount_price, 0, '.', ' ') ?> <small>so'm</small></div>
                                            <?php if ($prod->price > $prod->discount_price): ?>
                                                <del class="text-muted small"><?= number_format($prod->price, 0, '.', ' ') ?></del>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="badge badge-pill <?= $prod->status ? 'badge-soft-success' : 'badge-soft-secondary' ?> py-1 px-3">
                                                <?= $prod->status ? '● Sotuvda' : '○ To\'xtatilgan' ?>
                                            </span>
                                        </td>
                                        <td class="text-right pr-4">
                                            <?= Html::a('✏️', ['product', 'id' => $prod->id], ['class' => 'btn btn-action btn-outline-primary mr-1', 'title' => 'Tahrirlash']) ?>
                                            <?= Html::a('🗑', ['product', 'del' => $prod->id], [
                                                'class' => 'btn btn-action btn-outline-danger',
                                                'data-confirm' => 'Haqiqatan ham o‘chirmoqchimisiz?',
                                                'data-method' => 'post',
                                                'title' => 'O‘chirish'
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
        
        <!-- Forma qismi -->
        <div class="col-lg-4">
            <div class="card main-card sticky-form">
                <div class="card-header bg-gradient-primary">
                    <h6 class="mb-0 font-weight-bold <?= $newProd->isNewRecord ? 'text-info' : 'text-primary' ?>">
                        <?= $newProd->isNewRecord ? '✨ Yangi qo\'shish' : '🔄 Tahrirlash' ?>
                    </h6>
                </div>
                <div class="card-body">
                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

                    <?= $form->field($newProd, 'category_id')->dropDownList(
                        ArrayHelper::map($categories, 'id', 'name_uz'),
                        ['prompt' => 'Kategoriyani tanlang...', 'class' => 'form-control custom-select']
                    )->label('Kategoriya') ?>

                    <?= $form->field($newProd, 'title')->textInput(['placeholder' => 'Nomi...', 'class' => 'form-control'])->label('Mahsulot nomi') ?>

                    <div class="upload-box p-3 border rounded-lg bg-light mb-3">
                        <label class="small font-weight-bold mb-2 d-block">Rasmlar to'plami</label>
                        <?= $form->field($newProd, 'imageFiles[]')->fileInput(['multiple' => true, 'accept' => 'image/*', 'class' => 'small'])->label(false) ?>
                        
                        <?php if (!$newProd->isNewRecord && $newProd->image): ?>
                            <div class="img-preview-container">
                                <?php 
                                $images = explode(',', $newProd->image);
                                foreach ($images as $img): 
                                    if(empty($img)) continue;
                                    $path = (strpos($img, 'http') === 0) ? $img : '/frontend/web/' . $img;
                                ?>
                                    <img src="<?= $path ?>" class="img-preview-item">
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <?= $form->field($newProd, 'price')->textInput(['type' => 'number', 'class' => 'form-control', 'placeholder' => '0'])->label('Asl narxi') ?>
                        </div>
                        <div class="col-6">
                            <?= $form->field($newProd, 'discount_price')->textInput(['type' => 'number', 'class' => 'form-control', 'placeholder' => '0'])->label('Sotuv narxi') ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <?= $form->field($newProd, 'stock')->textInput(['type' => 'number', 'class' => 'form-control'])->label('Soni') ?>
                        </div>
                        <div class="col-6">
                            <?= $form->field($newProd, 'status')->dropDownList([1 => 'Sotuvda', 0 => 'Yo\'q'], ['class' => 'form-control custom-select'])->label('Holati') ?>
                        </div>
                    </div>

                    <?= $form->field($newProd, 'specifications')->textarea(['rows' => 2, 'placeholder' => 'Xususiyatlari...', 'class' => 'form-control'])->label('Qisqa ma\'lumot') ?>

                    <div class="mt-4">
                        <?= Html::submitButton($newProd->isNewRecord ? '➕ Saqlash' : '💾 O\'zgarishlarni saqlash', [
                            'class' => 'btn btn-block py-3 font-weight-bold ' . ($newProd->isNewRecord ? 'btn-info shadow-info' : 'btn-primary shadow-primary'),
                            'style' => 'border-radius: 12px;'
                        ]) ?>
                        
                        <?php if (!$newProd->isNewRecord): ?>
                            <?= Html::a('Bekor qilish', ['product'], ['class' => 'btn btn-link btn-block btn-sm mt-2 text-muted']) ?>
                        <?php endif; ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
