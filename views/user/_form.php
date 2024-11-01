<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$form = ActiveForm::begin();
echo $form->field($model, 'username')->textInput(['maxlength' => true]);
echo $form->field($model, 'email')->textInput(['maxlength' => true]);
echo $form->field($model, 'password')->passwordInput(['maxlength' => true]);
echo $form->field($model, 'confirmPassword')->passwordInput(['maxlength' => true]);
echo $form->field($model, 'role')->dropDownList(['admin' => 'Admin', 'user' => 'User']);
echo Html::submitButton('Save', ['class' => 'btn btn-success']);
ActiveForm::end();