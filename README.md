# StrokerForm

ZF2 module for extending forms with live clientside validation without need to write js validation code.
For basic usage examples see the sandbox project [StrokerFormSandbox](https://github.com/bramstroker/zf2-form-sandbox).

## Installation

Installation of StrokerCache uses composer. For composer documentation, please refer to
[getcomposer.org](http://getcomposer.org/).

  1. `cd my/project/directory`
  2. create or modify the `composer.json` file within your ZF2 application file with
     following contents:

     ```json
     {
         "require": {
             "stroker/cache": "*"
         }
     }
     ```
  3. install composer via `curl -s https://getcomposer.org/installer | php` (on windows, download
     https://getcomposer.org/installer and execute it with PHP). Then run `php composer.phar install`
  4. open `my/project/directory/configs/application.config.php` and add the following key to your `modules`:

     ```php
     'StrokerCache',
     ```
  5. copy the assets to your public folder (my/project/directory/public).

## Usage

For the ajax validation to work inputfilters needs to be hooked to the form.
We need to create a serviceFactory and register it with a unique alias to the formManager (this is an pluginManager).
If the inputFilters are already set to the form (i.e. in your form constructor) it's enough to register the form as an invokable

```php
<?php
namespace MyProject\Service;

use Zend\ServiceManager\ServiceLocatorInterface;

class MyFormFactory implements \Zend\ServiceManager\FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $form = new MyForm();
        $model = new MyModel();
        $form->setInputFilter($model->getInputFilter());
        return $form;
    }
}
```

Now let's add our new factory to the formManager.

```php
<?php
return array(
    'stroker_form' => array(
        'forms' => array(
            'factories' => array(
                'my_form_alias' => 'MyProject\Service\MyFormFactory'
            )
        )
    )
);
```

TODO: describe view helper