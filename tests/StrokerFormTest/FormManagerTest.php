<?php
/**
 * FormManagerTest
 *
 * @category  StrokerFormTest
 * @package   StrokerFormTest
 * @copyright 2014 ACSI Holding bv (http://www.acsi.eu)
 * @version   SVN: $Id$
 */


namespace StrokerFormTest;


use StrokerForm\FormManager;

class FormManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var FormManager
     */
    protected $manager;

    public function setUp()
    {
        $this->manager = new FormManager();
    }

    public function testIfValidatePluginValidatesCorrect()
    {
        $plugin = \Mockery::mock('Zend\Form\FormInterface');
        $this->assertNull($this->manager->validatePlugin($plugin));
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Form of type stdClass is invalid; must implement FormInterface
     */
    public function testIsValidatePluginValidatesIncorrect()
    {
        $plugin = new \StdClass();
        $this->manager->validatePlugin($plugin);
    }

    public function testIfFormElementManagerUsed()
    {
        $formMock = \Mockery::mock('Zend\Form\FormInterface');

        $formElementManagerMock = \Mockery::mock('\Zend\Form\FormElementManager');
        $formElementManagerMock->shouldReceive('has')->with('Foobar')->andReturn(true);
        $formElementManagerMock->shouldReceive('get')->with('Foobar')->andReturn($formMock);

        $serviceManagerMock = \Mockery::mock('Zend\ServiceManager\ServiceManager');
        $serviceManagerMock->shouldReceive('has')->with('FormElementManager')->andReturn(true);
        $serviceManagerMock->shouldReceive('get')->with('FormElementManager')->andReturn($formElementManagerMock);
        $this->manager->setServiceLocator($serviceManagerMock);

        $this->manager->get('Foobar');
    }

    public function testIfFormElementManagerNotUsed()
    {
        $formMock = \Mockery::mock('Zend\Form\FormInterface');

        $formElementManagerMock = \Mockery::mock('\Zend\Form\FormElementManager');
        $formElementManagerMock->shouldReceive('has')->with('Foobar')->andReturn(false);

        $serviceManagerMock = \Mockery::mock('Zend\ServiceManager\ServiceManager');
        $serviceManagerMock->shouldReceive('has')->with('FormElementManager')->andReturn(true);
        $serviceManagerMock->shouldReceive('get')->with('FormElementManager')->andReturn($formElementManagerMock);
        $this->manager->setServiceLocator($serviceManagerMock);

        $this->manager->setService('Foobar', $formMock);

        $this->manager->get('Foobar');
    }
}
 