# StrokerForm

[![Build Status](https://travis-ci.org/bramstroker/zf2-form.png?branch=master)](https://travis-ci.org/bramstroker/zf2-form)
[![Coverage Status](https://coveralls.io/repos/bramstroker/zf2-form/badge.png)](https://coveralls.io/r/bramstroker/zf2-form)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/bramstroker/zf2-form/badges/quality-score.png?s=bee62dce9b727e4cd660b0470ac228aaf4b6353c)](https://scrutinizer-ci.com/g/bramstroker/zf2-form/)
[![Total Downloads](https://poser.pugx.org/stroker/form/downloads.svg)](https://packagist.org/packages/stroker/form)
[![HHVM Status](http://hhvm.h4cc.de/badge/stroker/form.png)](http://hhvm.h4cc.de/package/stroker/form)

ZF2 module for extending forms with live clientside validation without need to write js validation code. 
You only need to define your validation rules server side with ZF2 and this module automaticaly adds the same rules with [jQueryValidate](http://docs.jquery.com/Plugins/Validation). 
In case a client side version of the validation rule doesn't exist a fallback is done using ajax.
For basic usage examples see the sandbox project [StrokerFormSandbox](https://github.com/bramstroker/zf2-form-sandbox).

## BC Breaks since 0.1.0

For the new version you need to copy `config/strokerform.global.php.dist` to your projects `config/autoload` dir.

## Installation

Installation of StrokerForm uses composer. For composer documentation, please refer to
[getcomposer.org](http://getcomposer.org/).

  1. `cd my/project/directory`
  2. create or modify the `composer.json` file within your ZF2 application file with
     following contents:

     ```json
     {
         "require": {
             "stroker/form": "*"
         }
     }
     ```
  3. install composer via `curl -s https://getcomposer.org/installer | php` (on windows, download
     https://getcomposer.org/installer and execute it with PHP). Then run `php composer.phar install`
  4. open `my/project/directory/configs/application.config.php` and add the following key to your `modules`:

     ```php
     'StrokerForm',
     ```
  6. copy the file `config/strokerform.global.php.dist` from `vendor\stroker\zf2-form` to your projects `config/autoload` directory and rename it to `strokerform.global.php`.
  5. copy the assets to your public folder (my/project/directory/public).

## Usage

First we need to make sure jquery is loaded by our application and the headScript() and inlineScript() view helpers are called. If you already have this in place you can skip this step.

```html
<head>
  <?php echo $this->headLink() ?>
	<?php echo $this->headScript()->prependFile('//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js') ?>
</head>
<body>
<div class="container">
	<?php echo $this->content; ?>
</div>
<?php echo $this->inlineScript() ?>
</body>
```

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

Last thing we need to do is invoking the StrokerFormPrepare view helper where you are rendering your form.
This view helper add all the needed javascripts to the headScript view helper

```php
<?php
echo $this->strokerFormPrepare('my_form_alias');

// Do your normal form rendering here
```

## Renderers

A renderer should implement the RendererInterface and is responsible for modifying the form rendering (setting inline javascript, modifying the form element attributes, view helpers etc.). 
Currently only the jqueryValidate renderer is available. Support for other validation libraries can be implemented as a seperate renderer. 

### JqueryValidate

#### Options

- `include_assets`: Whether you want the view helper to include the needed assets or you like to do it yourself using a asset manager
- `use_twitter_bootstrap`: Set this to true if you are using twitter bootstrap. 
- `validate_options`: Options for the jquery validate plugin. See [jqueryValidate options](http://docs.jquery.com/Plugins/Validation/validate#toptions) for all possible options. i.e. if you also want to validate on keypress you can set onkeyup to true. 

#### Styling

If you are using twitter bootstrap and the recommended form structure the styling works out of the box. 
When you are using the ZF2 view helpers for your form you could style the input fields `error` and `valid` classes which are added on the fly by the jquery plugin.

## Excluding elements from clientside validation

You can set the option `strokerform-exclude` on a form element

```php
$name = new Element('name');
$name->setLabel('Your name');
$name->setOption('strokerform-exclude', true);
```
