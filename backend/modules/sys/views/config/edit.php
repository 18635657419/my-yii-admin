<?php
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$form = ActiveForm::begin([
    'id' => $model->formName(),
    'enableAjaxValidation' => true,
    'validationUrl' => Url::toRoute(['edit','id' => $model['id']]),
    'fieldConfig' => [
        'template' => "<div class='col-sm-2 text-right'>{label}</div><div class='col-sm-10'>{input}\n{hint}\n{error}</div>",
    ]
]);
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">关闭</span></button>
    <h4 class="modal-title">基本信息</h4>
</div>
<div class="modal-body">
    <?= $form->field($model, 'title')->textInput() ?>
    <?= $form->field($model, 'name')->textInput()->hint('注意：标识唯一') ?>
    <?= $form->field($model, 'sort')->textInput()?>
    <?= $form->field($model, 'type')->dropDownList($configTypeList) ?>
    <?= $form->field($model, 'cate_id')->dropDownList($cates, ['prompt' => '请选择分类',]) ?>
    <?= $form->field($model, 'extra')->textarea()->hint('如果是枚举型 需要配置该项') ?>
    <?= $form->field($model, 'remark')->textarea() ?>
    <?= $form->field($model, 'is_hide_remark')->checkbox() ?>
    <?= $form->field($model, 'status')->radioList(['1' => '启用', '0' => '禁用']) ?>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
    <button class="btn btn-primary" type="submit">保存</button>
</div>
<?php ActiveForm::end(); ?>