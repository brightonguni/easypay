## PHP wrapper for Easypay API integration

This package provides wrapper methods to call Easypay payment system API.

This package was forked from [Easypay PHP-Wrapper](https://github.com/Easypay/PHP-Wrapper)
and allows you to integrate the wrapper with any PHP framework or project that uses Composer.

# Installation

Require the package in your `composer.json` file and update composer:

```php
"luismarto/easypay": "1.*"
```

# Basic usage

Require the package in your `composer.json` file and update composer:

```php

    <?php
    
    use Easypay\Easypay;
    
    /**
     * @var Easypay $easypay
     */
    protected $easypay;
    
    public function __construct() {
        $this->easypay = new Easypay([
            'user'   => 'ABCDEF',
            'entity' => '12345',
            'cin'    => '123456',
            'code'   => 'ABCDEFGJI',
        ]);
    }
    
    public function createReference() {
        $this->easypay->setValue('value', '43.18');
        $this->easypay->setValue('key', 1);
        
        $result = $this->client->createReference('normal');
        
    }

```

# Documentation & examples

In [examples/](examples/) you can find a sample database schema and fully functional code that integrates with Easypay and
uses this package.

For further details and documentation, you can read the following articles:

[Introduction to Easypay API integration (portuguese)](https://geekalicious.pt/blog/pt/php/introducao-integracao-servico-pagamentos-easypay-multibanco-mb-debito-direto-dd-setup)

[Multibanco integration - soon](https://geekalicious.pt/)

[Débito Direto integration - soon](https://geekalicious.pt/) 

## License

This package is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).