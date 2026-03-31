<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = 'Kategoriyalar Boshqaruvi';
?>

<div class="container-fluid py-4">
    <div class="row mb-4">
        <?php 
        $stats = [
            ['label' => 'Kategoriyalar', 'count' => $catCount, 'color' => 'primary', 'icon' => 'list'],
            ['label' => 'Mahsulotlar', 'count' => $prodCount, 'color' => 'success', 'icon' => 'shopping-cart'],
            ['label' => 'Buyurtmalar', 'count' => $orderCount, 'color' => 'info', 'icon' => 'check-square'],
            ['label' => 'Foydalanuvchilar', 'count' => $userCount, 'color' => 'warning', 'icon' => 'users'],
        ];
        foreach ($stats as $stat): ?>
        <div class="col-md-3">
            <div class="card shadow-sm border-left-<?= $stat['color'] ?> h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-<?= $stat['color'] ?> text-uppercase mb-1"><?= $stat['label'] ?></div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stat['count'] ?></div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">Mavjud kategoriyalar</h6>
                </div>
                <div class="card-body">
                    <table class="table table-hover border">
                        <thead class="bg-light">
                            <tr>
                                <th>ID</th>
                                <th>Nomi (UZ)</th>
                                <th>Slug</th>
                                <th>Status</th>
                                <th width="120">Amallar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $cat): ?>
                            <tr>
                                <td><?= $cat->id ?></td>
                                <td><strong><?= Html::encode($cat->name_uz) ?></strong></td>
                                <td><code><?= Html::encode($cat->slug) ?></code></td>
                                <td>
                                    <span class="badge badge-<?= $cat->status ? 'success' : 'danger' ?>">
                                        <?= $cat->status ? 'Faol' : 'Nofaol' ?>
                                    </span>
                                </td>
                                <td>
                                    <?= Html::a('✏️', ['catagory', 'id' => $cat->id], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                                    <?= Html::a('🗑', ['catagory', 'del' => $cat->id], [
                                        'class' => 'btn btn-sm btn-outline-danger',
                                        'data-confirm' => 'Haqiqatan ham o\'chirmoqchimisiz?',
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
        <div class="col-md-4">
            <div class="card shadow border-0">
                <div class="card-header bg-<?= $newCat->isNewRecord ? 'success' : 'primary' ?> text-white">
                    <h6 class="m-0 font-weight-bold"><?= $newCat->isNewRecord ? 'Yangi qo\'shish' : 'Tahrirlash: ' . $newCat->id ?></h6>
                </div>
                <div class="card-body">
                    <?php $form = ActiveForm::begin(); ?>
                    
                    <?= $form->field($newCat, 'parent_id')->dropDownList(
                        ArrayHelper::map($categories, 'id', 'name_uz'),
                        ['prompt' => 'Asosiy kategoriya (Parent)']
                    ) ?>

                    <?= $form->field($newCat, 'name_uz')->textInput(['placeholder' => 'Kategoriya nomi...']) ?>
                    <?= $form->field($newCat, 'slug')->textInput(['placeholder' => 'elektronika-jihozlari']) ?>
                    <?= $form->field($newCat, 'status')->checkbox() ?>

                    <div class="form-group mb-0">
                        <?= Html::submitButton($newCat->isNewRecord ? 'Saqlash' : 'Yangilash', ['class' => 'btn btn-block btn-' . ($newCat->isNewRecord ? 'success' : 'primary')]) ?>
                        <?php if(!$newCat->isNewRecord): ?>
                            <?= Html::a('Bekor qilish', ['catagory'], ['class' => 'btn btn-link btn-block btn-sm']) ?>
                        <?php endif; ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card { border-radius: 10px; }
    .border-left-primary { border-left: 4px solid #4e73df; }
    .border-left-success { border-left: 4px solid #1cc88a; }
    .border-left-info { border-left: 4px solid #36b9cc; }
    .border-left-warning { border-left: 4px solid #f6c23e; }
    .table thead th { border-top: none; text-transform: uppercase; font-size: 12px; color: #888; }
</style>
