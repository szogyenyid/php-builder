# PHP Builder
A PHP trait to automagically create a Builder with fluent interface for any class.

------

## Why PHP Builder?

Builder is a creational design pattern, which allows constructing complex objects step by step. The intent of the builder design pattern is to separate the construction of a complex object from its representation. It is one of the Gang of Four design patterns.

As PHP does not support inner classes (like Java does), if you would like to create builders, you have to write a new class for every one you want to use a builder with. By using **PHP Builder** you do not need to create separate builder classes in your namespace.

PHP Builder may help preventing some bugs, as a variable is only accessed once, when instantiating it with the property values already set.

Instead of this, written without PHP Builder:

```php
$user = new User();
$user->setName("John Doe");
$user->setEmail("john.doe@example.com");
```

You have to write this if using PHP Builder:

```php
$user = User::builder()
    ->withName("John Doe")
    ->withEmail("john.doe@example.com")
    ->build();
```

It can also increase the legibility of your code, as you get a fluent interface for your setters, and can get rid of the repetition of the variable name.

## Installation

Installation is the easiest via [Composer](https://getcomposer.org/):

```bash
$ composer require szogyenyid/php-builder
```

or add it by hand to your `composer.json` file.

## Upgrading

PHP Builder follows [semantic versioning](https://semver.org/), which means breaking changes may occur between major releases. As the current highest version is V1, you do not need to worry about versions at this moment.


## Usage

To automagically gain access to a builder, all you need to do is adding the trait to your class:

```php
class User
{
    use Builder;
    
    //...
}
```

To be able to use the Builder methods, you most follow these simple rules:

1. You must have `public` setter methods for the properties you would like to use in the builder.
2. The names of the setter methods must follow the structure "set" + "Propertyname".

```php
class User
{
    use Builder;

    private string $name;
    private string $email;

    public function setName(string $newName): void
    {
        $this->name = $newName;
    }
    public function setEmail(string $newEmail): void
    {
        $this->email = $newEmail;
    }
}
```

Having this provides access to the builder, like the following:

```php
$user = User::builder()
    ->withName("John Doe")
    ->withEmail("john.doe@example.com")
    ->build();
```

All of the builder's methods will follow the names of the setters with `set` changed to `with`.

### Possible errors

If Builder encounters a violation of the above rules, a `BuilderException` will be thrown.

If you call a builder method (except `build()` and `reset()`) that does not start with `with`, the an exception with the following message is thrown:

```
Builder method names must start with "with". Invalid method name: $methodName
```

If a setter with the corresponding name as builder method is not found, the following message will be sent with a BuilderException:

```
No method with name "$methodName" found in class $className
```

## License

PHP Builder is licensed under [MIT License](LICENSE).
