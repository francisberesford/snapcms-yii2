<?php

namespace snapcms\components;

use yii\validators\ExistValidator;
use yii\base\InvalidConfigException;

/**
 * Class SnapCMSListExistValidator
 *
 * Use this class to validate the values in
 * the input separate by defined separator (eg: ',')
 *
 * @author Jackson Tong <tongtoan2704@gmail.com>
 * @package snapcms\components
 */
class SnapCMSListExistValidator extends ExistValidator
{
    /**
     * input seperator default is ','
     * @var string
     */
    public $separator = ',';

    /**
     * @inheritdoc
     */
    protected function validateValue($value)
    {
        if (!is_string($this->separator)) {
            throw new InvalidConfigException('The "separator" property must be configured as a string.');
        }

        $values = array_map('trim', explode($this->separator, $value));

        return parent::validateValue($values);
    }
}