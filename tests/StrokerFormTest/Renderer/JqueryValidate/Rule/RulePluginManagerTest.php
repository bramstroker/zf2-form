<?php
/**
 * Description
 *
 * @category  StrokerFormTest
 * @package   StrokerFormTest\Renderer
 * @copyright 2012 Bram Gerritsen
 * @version   SVN: $Id$
 */

namespace StrokerFormTest\Renderer\JqueryValidate\Rule;

use stdClass;
use StrokerForm\Renderer\JqueryValidate\Rule\NotEmpty;
use StrokerForm\Renderer\JqueryValidate\Rule\RuleInterface;
use StrokerForm\Renderer\JqueryValidate\Rule\RulePluginManager;
use Zend\I18n\Translator\Translator;
use Zend\ServiceManager\ServiceManager;

class RulePluginManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var RulePluginManager
     */
    protected $pluginManager;

    public function setUp()
    {
        $this->pluginManager = new RulePluginManager();
        $serviceManager = new ServiceManager();
        $serviceManager->setService('MvcTranslator', new Translator());
        $this->pluginManager->setServiceLocator($serviceManager);
    }

    public function testInstancesCanBeCreated()
    {
        $services = $this->pluginManager->getRegisteredServices();
        $invokables = $services['invokableClasses'];
        foreach ($invokables as $alias) {
            $instance = $this->pluginManager->get($alias);
            $this->assertInstanceOf(
                RuleInterface::class,
                $instance
            );
        }
    }

    public function testTranslatorIsInjected()
    {
        $instance = $this->pluginManager->get('digits');
        $this->assertNotNull($instance->getTranslator());
    }

    public function testValidatePluginSuccess()
    {
        $rule = new NotEmpty();
        $this->pluginManager->validatePlugin($rule);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testValidatePluginFails()
    {
        $rule = new StdClass();
        $this->pluginManager->validatePlugin($rule);
    }
}
