<?php

namespace snapcms\tests\unit;

class TestCase extends \yii\codeception\TestCase
{
    public $appConfig = '@snapcms/tests/unit/_config.php';
    
    protected static function getPrivateMethod($className, $methodName) 
    {
        $class = new \ReflectionClass($className);
        $method = $class->getMethod($methodName);
        $method->setAccessible(true);
        return $method;
    }
}
