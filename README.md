A command to generate the access-tokens for a product-api project.
===================================================================

This package is a command that will generate the access-token for a product-api project.

## Installation and setup

To get the latest version, simply require the package using [Composer](https://getcomposer.org):

```bash
$ composer require 64robots/products-api-accessor
```

Once installed, this package will automatically register its service provider.

Publish the config file to `config/products.php` run:

```bash
$ php artisan vendor:publish --provider="R64\ProductsApiAccessor\AccessorServiceProvider" --tag="config"
```

## Usage
- Use passport's command `php artisan passport:client` to generate new Client ID and Client Secret from [Products api](https://gitlab.com/64robots/products-api). Copy the Client ID and Client Secret and set it in this .env like so;

```
PRODUCTS_API_BASE_URI=http://url-to-products-api
PRODUCTS_API_CLIENT_ID=x
PRODUCTS_API_CLIENT_SECRET=xxxx
```

- Ran the command `php artisan generate:products-api-access-token` to generate access token. The token will be automatically set in the .env.

