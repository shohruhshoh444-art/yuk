<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

$this->title = 'Aksiyalar (Blog) Boshqaruvi';
?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-white font-weight-bold text-primary">Mavjud Aksiyalar</div>
                <div class="card-body">
                    <table class="table table-hover border">
                        <thead>
                            <tr>
                                <th>Rasm</th>
                                <th>Sarlavha</th>
                                <th>Muddati</th>
                                <th>Amallar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($blogs as $blog): ?>
                            <tr>
                                <td>
                                    <?php if($blog->image): ?>
                                        <img src="<?= 'http://shop.loc' . $blog->image ?>" width="60" class="rounded">
                                    <?php endif; ?>
                                </td>
                                <td><strong><?= Html::encode($blog->title) ?></strong></td>
                                <td><small><?= $blog->start_date ?> / <?= $blog->end_date ?></small></td>
                                <td>
                                    <?= Html::a('✏️', ['blog', 'id' => $blog->id], ['class' => 'btn btn-sm btn-outline-primary']) ?>
                                    <?= Html::a('🗑', ['blog', 'del' => $blog->id], ['class' => 'btn btn-sm btn-outline-danger', 'data-method' => 'post']) ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-header bg-dark text-white font-weight-bold">Aksiya yaratish / Tahrirlash</div>
                <div class="card-body">
                    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

                    <?= $form->field($newBlog, 'title')->textInput(['placeholder' => 'Aksiya nomi...']) ?>
                    
                    <?= $form->field($newBlog, 'category_id')->dropDownList(
                        ArrayHelper::map($categories, 'id', 'name_uz'),
                        ['prompt' => 'Ushbu aksiya qaysi kategoriya uchun?', 'class' => 'form-control select2']
                    ) ?>

                    <div class="row">
                        <div class="col-md-6"><?= $form->field($newBlog, 'start_date')->textInput(['type' => 'date']) ?></div>
                        <div class="col-md-6"><?= $form->field($newBlog, 'end_date')->textInput(['type' => 'date']) ?></div>
                    </div>

                    <?= $form->field($newBlog, 'content')->textarea(['rows' => 4]) ?>

                    <?= $form->field($newBlog, 'imageFile')->fileInput() ?>

                    <?= $form->field($newBlog, 'status')->checkbox() ?>

                    <?= Html::submitButton('Aksiyani saqlash', ['class' => 'btn btn-success btn-block']) ?>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
