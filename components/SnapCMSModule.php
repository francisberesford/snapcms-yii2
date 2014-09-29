<?php

namespace snapcms\components;
use Yii;

abstract class SnapCMSModule extends \yii\base\Module
{
    public $primaryMenu = [];
    public $secondaryMenu = [];
}