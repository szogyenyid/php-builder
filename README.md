# PHP Builder
A PHP trait to automagically create a Builder with fluent interface for any class.

------

## Why PHP Builder?

Builder is a creational design pattern, which allows constructing complex objects step by step. The intent of the builder design pattern is to separate the construction of a complex object from its representation. It is one of the Gang of Four design patterns.

As PHP does not support inner classes (like Java does), if you would like to create builders, you have to write a new class for every one you want to use a builder with, and maintain them when the base class changes. By using **PHP Builder** you do not need to create separate builder classes in your namespace.

PHP Builder may help preventing some bugs, as variables are only accessed once, when instantiating them with the property values already set. Alse, there is no need to write any public setters, which would make the class mutable or vulnerable. Before calling the `build()` method, no instance is accessible, after calling it, no properties can be changed from outside the instance (unless they are public, or have a public setter).

Instead of this, written without PHP Builder:

```php
class User
{
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

$user = new User();
$user->setName("John Doe");
$user->setEmail("john.doe@example.com");
```

You have to write this if using PHP Builder:

```php
class User
{
    use Builder;

    private string $name;
    private string $email;
}

$user = User::builder()
    ->withName("John Doe")
    ->withEmail("john.doe@example.com")
    ->build();
```

In the first case, you have to write public setters, which make your class mutable after creation. In the second case, there are no setters, and the properties are private, so there is no chance they will change after creation.

It can also increase the legibility of your code, as you get a fluent interface, and can get rid of the repetition of the variable name.

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

There are no rules for your class to follow to use `Builder`, no setters or public properties are necessary.

```php
class User
{
    use Builder;

    private string $name;
    private string $email;
}
```

The above example is a 100% valid class to use `Builder` with.

Having this provides access to the builder, like the following:

```php
$user = User::builder()
    ->withName("John Doe")
    ->withEmail("john.doe@example.com")
    ->build();
```

All of the builder's methods will follow the names of the properties prepending `with`. For more legibility, you can change the first letter of the property to capital (instead of `withname`, you can use `withName`).

### Possible errors

If Builder encounters any error, a `BuilderException` will be thrown.

If you call a builder method (except `build()` and `reset()`) that does not start with `with`, the an exception with the following message is thrown:

```
Builder method names must start with "with". Invalid method name: $methodName
```

If a property with the corresponding name is not found, the following message will be sent with a BuilderException:

```
No property with name "$property" found in class $class
```

## License

PHP Builder is licensed under [MIT License](LICENSE).
