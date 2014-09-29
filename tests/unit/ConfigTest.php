<?php
//use Codeception\Util\Stub;
use snapcms\models\Config;
use snapcms\tests\fixtures\ConfigFixture;

class ConfigTest extends \snapcms\tests\unit\TestCase
{
   /**
    * @var \CodeGuy
    */
    protected $codeGuy;
    
    public function fixtures()
    {
        return [
            'configs' => ConfigFixture::className(),
        ];
    }

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testGetData()
    {
        //This gets data from our Config fixture
        $title = Config::getData('general/site.title');
        $this->assertEquals('A test title from the DB', $title);
        
        //This gets data from the actual projects /config/snapcms/general.php file
        $tagline = Config::getData('general/site.tag_line');
        $this->assertTrue(is_string($tagline), 'Tagline is a string');
        
        try {
            $die = Config::getData('something/that.doesnt.exist');
            $this->assertTrue(false, 'Exception was not thrown');
        } catch (\yii\base\ErrorException $e) {
            $this->assertTrue(true, 'Exception Thrown');
        }
    }
    
    public function testGetFileData()
    {
        $general = Config::getFileData('general');
        $this->assertTrue(is_array($general));
        
        try {
            $die = Config::getFileData('doesnt_exist');
            $this->assertTrue(false, 'Exception was not thrown');
        } catch (\yii\base\ErrorException $e) {
            $this->assertTrue(true, 'Exception Thrown');
        }
    }
    
    public function testGetOverrideArrayTree()
    {
        $tree = Config::getOverrideArrayTree();
        $this->assertTrue(is_array($tree));
    }
    
    public function testFillCache()
    {
        $fullConf = Config::getFileData('general');
        
        $fillCache = self::getPrivateMethod('snapcms\models\Config', 'fillCache');
        $Config = new Config;
        $cacheArray = $fillCache->invokeArgs($Config, array($fullConf, 'general/'));
        
        $this->assertTrue(is_array($cacheArray));
    }
}