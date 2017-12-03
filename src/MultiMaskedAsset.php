<?php
namespace inputmaskMulti;

use yii\web\AssetBundle;
use yii\widgets\MaskedInputAsset;

/**
 * Class MultiMaskedAsset
 */
class MultiMaskedAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@vendor/andr-04/jquery.inputmask-multi';

    /**
     * @var array
     */
    public $js = [
        YII_DEBUG
            ? 'js/jquery.inputmask-multi.js'
            : 'jquery.inputmask-multi.min.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        MaskedInputAsset::class,
    ];
}
