<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = 'Kategoriyalar Boshqaruvi';
?>

<style>
    /* Umumiy dizayn */
    .bg-main { background-color: #f8f9fc; min-height: 100vh; }
    .card-custom { border: none; border-radius: 16px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); background: #fff; overflow: hidden; }
    
    /* Stat kartalar */
    .stat-card { transition: transform 0.2s; border-left: 5px solid !important; }
    .stat-card:hover { transform: translateY(-5px); }
    .stat-icon { width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; border-radius: 12px; background: rgba(0,0,0,0.03); }
    
    /* Jadval */
    .table thead th { background: #fcfcfd; color: #8898aa; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; padding: 15px; border-bottom: 1px solid #edf2f7; }
    .table td { padding: 15px; vertical-align: middle !important; border-top: 1px solid #f4f7f6; }
    .cat-name { font-size: 15px; color: #2d3748; font-weight: 600; }
    .slug-badge { background: #f1f5f9; color: #64748b; padding: 4px 8px; border-radius: 6px; font-family: monospace; font-size: 12px; }
    
    /* Status Badge */
    .badge-soft-success { background: #d1fae5; color: #065f46; border-radius: 30px; padding: 5px 12px; font-size: 11px; }
    .badge-soft-danger { background: #fee2e2; color: #991b1b; border-radius: 30px; padding: 5px 12px; font-size: 11px; }
    
    /* Forma elementlari */
    .form-control-custom { border-radius: 10px; border: 1px solid #e2e8f0; padding: 12px 15px; transition: 0.3s; }
    .form-control-custom:focus { border-color: #4e73df; box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.1); }
    .btn-save { border-radius: 12px; padding: 12px; font-weight: 600; letter-spacing: 0.5px; transition: 0.3s; }
    .btn-save:hover { filter: brightness(1.1); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
</style>

<div class="bg-main py-4 px-3">
    <!-- Statistika qismi -->
    <div class="row mb-4">
        <?php 
        $stats = [
            ['label' => 'Kategoriyalar', 'count' => $catCount, 'color' => '#4e73df', 'icon' => '📁'],
            ['label' => 'Mahsulotlar', 'count' => $prodCount, 'color' => '#1cc88a', 'icon' => '📦'],
            ['label' => 'Buyurtmalar', 'count' => $orderCount, 'color' => '#36b9cc', 'icon' => '🛒'],
            ['label' => 'Foydalanuvchilar', 'count' => $userCount, 'color' => '#f6c23e', 'icon' => '👥'],
        ];
        foreach ($stats as $stat): ?>
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card card-custom stat-card h-100 py-2" style="border-left-color: <?= $stat['color'] ?> !important;">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: <?= $stat['color'] ?>; opacity: 0.8;"><?= $stat['label'] ?></div>
                            <div class="h4 mb-0 font-weight-bold text-gray-800"><?= number_format($stat['count']) ?></div>
                        </div>
                        <div class="stat-icon h3 mb-0"><?= $stat['icon'] ?></div>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <div class="row">
        <!-- Jadval -->
        <div class="col-lg-8">
            <div class="card card-custom mb-4">
                <div class="card-header bg-white py-3 d-flex align-items-center">
                    <h6 class="m-0 font-weight-bold text-dark">📂 Mavjud yo'nalishlar</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead>
                                <tr>
                                    <th class="text-center" width="60">ID</th>
                                    <th>Kategoriya Nomi</th>
                                    <th>Slug Manzili</th>
                                    <th>Status</th>
                                    <th class="text-right" width="130">Amallar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($categories as $cat): ?>
                                <tr>
                                    <td class="text-center text-muted small">#<?= $cat->id ?></td>
                                    <td>
                                        <div class="cat-name"><?= Html::encode($cat->name_uz) ?></div>
                                        <?php if($cat->parent_id): ?>
                                            <span class="badge badge-light text-muted font-weight-normal" style="font-size: 10px;">
                                                Sub-category
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td><span class="slug-badge"><?= Html::encode($cat->slug) ?></span></td>
                                    <td>
                                        <span class="badge <?= $cat->status ? 'badge-soft-success' : 'badge-soft-danger' ?>">
                                            <?= $cat->status ? '● Faol' : '○ Nofaol' ?>
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <?= Html::a('✏️', ['catagory', 'id' => $cat->id], ['class' => 'btn btn-sm btn-light border-0 shadow-sm mr-1']) ?>
                                        <?= Html::a('🗑', ['catagory', 'del' => $cat->id], [
                                            'class' => 'btn btn-sm btn-light text-danger border-0 shadow-sm',
                                            'data-confirm' => 'Kategoriyani o‘chirishni tasdiqlaysizmi?',
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

        <!-- Forma -->
        <div class="col-lg-4">
            <div class="card card-custom border-top-primary">
                <div class="card-header <?= $newCat->isNewRecord ? 'bg-success' : 'bg-primary' ?> py-3">
                    <h6 class="m-0 font-weight-bold text-white text-center">
                        <?= $newCat->isNewRecord ? '✨ Yangi Kategoriya' : '🔄 Tahrirlash: ID ' . $newCat->id ?>
                    </h6>
                </div>
                <div class="card-body p-4">
                    <?php $form = ActiveForm::begin([
                        'fieldConfig' => [
                            'options' => ['class' => 'form-group mb-3'],
                            'labelOptions' => ['class' => 'small font-weight-bold text-muted mb-1'],
                        ],
                    ]); ?>
                    
                    <?= $form->field($newCat, 'parent_id')->dropDownList(
                        ArrayHelper::map($categories, 'id', 'name_uz'),
                        ['prompt' => 'Asosiy (Ota) kategoriya tanlang', 'class' => 'form-control form-control-custom custom-select']
                    )->label('Kategoriya darajasi') ?>

                    <?= $form->field($newCat, 'name_uz')->textInput(['placeholder' => 'Masalan: Smartfonlar', 'class' => 'form-control form-control-custom'])->label('Nomi (UZ)') ?>
                    
                    <?= $form->field($newCat, 'slug')->textInput(['placeholder' => 'smartfonlar-bolimi', 'class' => 'form-control form-control-custom'])->label('URL manzili (Slug)') ?>

                    <div class="custom-control custom-switch my-3">
                        <?= $form->field($newCat, 'status')->checkbox(['class' => 'custom-control-input', 'id' => 'customSwitch1'])->label(false) ?>
                        <label class="custom-control-label small text-muted" for="customSwitch1">Kategoriyani faollashtirish</label>
                    </div>

                    <div class="pt-2">
                        <?= Html::submitButton($newCat->isNewRecord ? 'Saqlash' : 'O\'zgarishlarni saqlash', [
                            'class' => 'btn btn-block btn-save text-white ' . ($newCat->isNewRecord ? 'bg-success' : 'bg-primary')
                        ]) ?>
                        
                        <?php if(!$newCat->isNewRecord): ?>
                            <?= Html::a('Bekor qilish', ['catagory'], ['class' => 'btn btn-link btn-block btn-sm mt-2 text-muted']) ?>
                        <?php endif; ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            
            <div class="alert alert-info border-0 mt-3 rounded-lg shadow-sm">
                <small class="d-block">
                    <strong>Maslahat:</strong> Slug qismini lotin harflarida va orasida chiziqcha bilan yozing (masalan: <code>erkaklar-kiyimi</code>).
                </small>
            </div>
        </div>
    </div>
</div>
