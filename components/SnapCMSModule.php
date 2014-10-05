<?php

namespace snapcms\components;
use Yii;

abstract class SnapCMSModule extends \yii\base\Module
{
    static $primaryMenu = [];
    public static $secondaryMenu = [];
}