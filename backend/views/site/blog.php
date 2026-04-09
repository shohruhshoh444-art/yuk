<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = 'Aksiyalar Boshqaruvi';
?>

<style>
    /* Umumiy fon va karta stili */
    .promo-container { background-color: #f0f2f5; min-height: 100vh; padding: 30px 15px; }
    .glass-card { border: none; ; box-shadow: 0 8px 32px rgba(31, 38, 135, 0.07);  overflow: hidden; }
    
    /* Jadval qismi */
    .table thead th { background: #f8f9fa; color: #4a5568; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; border: none; padding: 15px; }
    .promo-thumb { width: 80px; height: 50px; object-fit: cover; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
    .promo-title { font-size: 15px; font-weight: 700; color: #2d3748; margin-bottom: 2px; }
    
    /* Muddati (Date Range) stili */
    .date-range { font-size: 12px; background: #e2e8f0; color: #4a5568; padding: 4px 10px; border-radius: 6px; display: inline-flex; align-items: center; }
    .date-separator { margin: 0 5px; color: #cbd5e0; }
    
    /* Forma elementlari */
    .form-label-bold { font-weight: 700; font-size: 13px; color: #4a5568; text-transform: uppercase; margin-bottom: 8px; display: block; }
    .input-modern { border-radius: 12px; padding: 12px 15px; border: 1px solid #e2e8f0; transition: 0.3s; background: #fcfcfd; }
    .input-modern:focus { border-color: #667eea; box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1); background: #fff; }
    
    /* Tugmalar */
    .btn-gradient { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; color: white; border-radius: 12px; padding: 12px; font-weight: 600; transition: 0.3s; }
    .btn-gradient:hover { transform: translateY(-2px); box-shadow: 0 7px 14px rgba(118, 75, 162, 0.3); color: white; }
    
    .action-btn { width: 35px; height: 35px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; transition: 0.2s; border: 1px solid #edf2f7; background: white; }
    .action-btn:hover { background: #f8f9fa; transform: scale(1.1); }
</style>

<div class="promo-container">
    <div class="row">
        <!-- Ro'yxat -->
        <div class="col-lg-7">
            <div class="card glass-card mb-4">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="m-0 font-weight-bold text-dark">📣 Mavjud Aksiyalar</h5>
                    <span class="badge badge-pill badge-light text-muted border"><?= count($blogs) ?> ta faol</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    
                                    <th>Aksiya Ma'lumoti</th>
                                    <th>Amal qilish muddati</th>
                                    <th class="text-right">Boshqarish</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($blogs as $blog): ?>
                                <tr>
                                   
                                    <td>
                                        <div class="promo-title"><?= Html::encode($blog->title) ?></div>
                                        <small class="text-primary font-weight-bold">
                                            <i class="fa fa-tag"></i> <?= $blog->category ? $blog->category->name_uz : 'Umumiy' ?>
                                        </small>
                                    </td>
                                    <td>
                                        <div class="date-range">
                                            <span>📅 <?= date('d.m', strtotime($blog->start_date)) ?></span>
                                            <span class="date-separator">—</span>
                                            <span>🏁 <?= date('d.m.Y', strtotime($blog->end_date)) ?></span>
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <div class="d-flex justify-content-end gap-2">
                                            <?= Html::a('✏️', ['blog', 'id' => $blog->id], ['class' => 'action-btn text-primary mr-2', 'title' => 'Tahrirlash']) ?>
                                            <?= Html::a('🗑', ['blog', 'del' => $blog->id], [
                                                'class' => 'action-btn text-danger',
                                                'data-method' => 'post',
                                                'data-confirm' => 'Haqiqatan ham o\'chirmoqchimisiz?',
                                                'title' => 'O\'chirish'
                                            ]) ?>
                                        </div>
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
        <div class="col-lg-5">
            <div class="card glass-card">
                <div class="card-header bg-dark text-white py-3 border-0">
                    <h6 class="m-0 font-weight-bold">🚀 Aksiya Kontentini Yarating</h6>
                </div>
                <div class="card-body p-4">
                    <?php $form = ActiveForm::begin([
                        'options' => ['enctype' => 'multipart/form-data'],
                        'fieldConfig' => [
                            'template' => "{label}\n{input}\n{error}",
                            'labelOptions' => ['class' => 'form-label-bold'],
                            'inputOptions' => ['class' => 'form-control input-modern'],
                        ],
                    ]); ?>

                    <?= $form->field($newBlog, 'title')->textInput(['placeholder' => 'Katta chegirmalar...']) ?>
                    
                    <?= $form->field($newBlog, 'category_id')->dropDownList(
                        ArrayHelper::map($categories, 'id', 'name_uz'),
                        ['prompt' => 'Kategoriyani tanlang...', 'class' => 'form-control input-modern custom-select']
                    )->label('Maqsadli kategoriya') ?>

                    <div class="row">
                        <div class="col-6">
                            <?= $form->field($newBlog, 'start_date')->textInput(['type' => 'date']) ?>
                        </div>
                        <div class="col-6">
                            <?= $form->field($newBlog, 'end_date')->textInput(['type' => 'date']) ?>
                        </div>
                    </div>

                    <?= $form->field($newBlog, 'content')->textarea(['rows' => 4, 'placeholder' => 'Aksiya shartlari va tavsifi...']) ?>

                    <div class="upload-area p-3 border rounded-lg bg-light mb-3 text-center">
                        <label class="form-label-bold">Banner rasmini yuklang</label>
                        <?= $form->field($newBlog, 'imageFile')->fileInput(['class' => 'small'])->label(false) ?>
                        <small class="text-muted">Tavsiya etilgan o'lcham: 1200x600 px</small>
                    </div>

                    <div class="custom-control custom-switch mb-4">
                        <?= $form->field($newBlog, 'status')->checkbox(['class' => 'custom-control-input', 'id' => 'statusSwitch'])->label(false) ?>
                        <label class="custom-control-label font-weight-bold text-muted" for="statusSwitch">Saytda ko'rsatish (Status)</label>
                    </div>

                    <?= Html::submitButton('<i class="fa fa-save mr-2"></i> Aksiyani E\'lon Qilish', ['class' => 'btn btn-block btn-gradient']) ?>

                    <?php if(!$newBlog->isNewRecord): ?>
                        <?= Html::a('Bekor qilish', ['blog'], ['class' => 'btn btn-link btn-block btn-sm mt-2 text-muted']) ?>
                    <?php endif; ?>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
