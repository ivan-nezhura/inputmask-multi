<?php
namespace inputmaskMulti;

use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\JsExpression;

/**
 * Class MaskedPhoneInput
 */
class MaskedPhoneInput extends \yii\widgets\InputWidget
{
    /**
     * The name of the jQuery plugin to use for this widget.
     */
    const PLUGIN_NAME = 'inputmasks';

    /**
     * @var array
     * To provide options for core plugin - supply them to key 'inputmask'
     * @see https://github.com/RobinHerbots/Inputmask
     */
    public $clientOptions = [
        'inputmask' => [
            'definitions' => [
                '#' => [
                    'validator' => '[0-9]',
                    'cardinality' => 1,
                ]
            ],
            'showMaskOnHover' => true,
            'autoUnmask' => true
        ],
        'match' => '/[0-9]/',
        'replace' => '#',
        'listKey' => 'mask',
    ];

    /**
     * @var array the HTML attributes for the input tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = ['class' => 'form-control'];

    /**
     * @var string the type of the input tag. Currently only 'text' and 'tel' are supported.
     * @see https://github.com/RobinHerbots/Inputmask
     * @since 2.0.6
     */
    public $type = 'text';

    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->_registerClientScript();
        echo $this->renderInputHtml($this->type);
    }

    /**
     * Registers code base json file in assets
     *
     * @return string web path to code base
     */
    protected function _getCodeBaseWebPath()
    {
        $codeBasePath = \Yii::getAlias(
            '@vendor/andr-04/jquery.inputmask-multi/data/phone-codes.json'
        );

        $codeBaseAssetPath = $this->view
            ->getAssetManager()
            ->publish($codeBasePath);

        return $codeBaseAssetPath[1];

    }

    /**
     * Initializes client options.
     */
    protected function _initClientOptions()
    {
        $options = [
            'list' => new JsExpression(
                '$.masksSort($.masksLoad("' . $this->_getCodeBaseWebPath() . '"), ["#"], /[0-9]|#/, "mask")'),
        ];

        $this->clientOptions = ArrayHelper::merge(
            $options,
            $this->clientOptions
        );

        if (
            isset($this->clientOptions['match'])
            && !($this->clientOptions['match'] instanceof JsExpression)
        ) {
            $this->clientOptions['match'] =
                new JsExpression($this->clientOptions['match']);
        }
    }

    /**
     * Registers the needed client script and options.
     */
    protected function _registerClientScript()
    {
        $js = '';
        $view = $this->getView();
        $this->_initClientOptions();

        $id = $this->options['id'];
        $js .= 'jQuery("#' . $id . '").'
            . self::PLUGIN_NAME . '(' . Json::encode($this->clientOptions) . ');';

        MultiMaskedAsset::register($view);
        $view->registerJs($js);
    }
}
