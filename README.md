# Yii 2 wrapper for inputmask multi
For JS plugin details refer to [official page](http://andr-04.github.io/inputmask-multi/en.html)

### Usage
```
use \inputmaskMulti\MaskedPhoneInput;
use yii\web\JsExpression;

$inputmaskOptions = [
    'showMaskOnHover' => false,
    'oncomplete' => new JsExpression('function(){ alert("inputmask complete");}'),
];

$clientOptions = [
    'onMaskChange' => new JsExpression('function(maskObj, completed) {console.log(maskObj, completed);}')
];

// without model
echo MaskedPhoneInput::widget([
    'name' => 'my-input-name',
    'inputmaskClientOptions' => $inputmaskOptions,
    'clientOptions' => $clientOptions,
]);

// with model
echo $form->field($model, 'title')
    ->widget(
        MaskedPhoneInput::className(),
        [
            'inputmaskClientOptions' => $inputmaskOptions,
            'clientOptions' => $clientOptions,
        ]
    );
```