<?php

namespace Szogyenyid\PhpBuilder\Tests\Unit;

use Szogyenyid\PhpBuilder\Builder;
use Szogyenyid\PhpBuilder\BuilderException;

class TestClass
{
    use Builder;

    private string $name;
    public function getName(): string
    {
        return $this->name;
    }
}

it('creates a builder', function () {
    $builder = TestClass::builder();
    expect($builder)->toBeObject();
});

it('creates an instance of the class', function () {
    $builder = TestClass::builder();
    $instance = $builder->build();
    expect($instance)->toBeInstanceOf(TestClass::class);
});

it('sets the property', function () {
    $builder = TestClass::builder();
    $instance = $builder->withName('test')->build();
    expect($instance->getName())->toBe('test');
});

it('throws exception if invalid method is called', function () {
    $builder = TestClass::builder();
    $builder->invalidMethod();
})->throws(BuilderException::class);

it('throws exception if tries to set non-existing property', function () {
    $builder = TestClass::builder();
    $builder->withNonExistingProperty('test');
})->throws(BuilderException::class);
