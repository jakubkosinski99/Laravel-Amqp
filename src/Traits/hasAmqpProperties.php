<?php

namespace Kosinski\Amqp\Traits;

use Doctrine\Common\Annotations\AnnotationException;
use Doctrine\Common\Annotations\AnnotationReader;
use Illuminate\Support\Arr;
use Kosinski\Amqp\Annotations\AmqpProperty;
use Kosinski\Amqp\Annotations\PropertyAccessor;
use Kosinski\Amqp\Exceptions\ClassPropertyAccessorNotFound;
use ReflectionClass;
use ReflectionException;

/**
 * Trait hasAmqpProperties
 * @package Kosinski\Amqp\Traits
 */
trait hasAmqpProperties
{
    /**
     * @var array
     */
    protected $allProperties = array();

    /**
     * hasAmqpProperties constructor.
     *
     * @param array $data
     *
     * @throws ClassPropertyAccessorNotFound
     * @throws AnnotationException
     * @throws ReflectionException
     */
    public function __construct(array $data = [])
    {
        $this->bindProperties($data);
    }

    /**
     * @param array $data
     *
     * @throws ClassPropertyAccessorNotFound
     * @throws AnnotationException
     * @throws ReflectionException
     */
    private function bindProperties(array $data = []): void
    {
        $reader = new AnnotationReader();
        $class = new ReflectionClass($this);

        $propertyAccessor = $reader->getClassAnnotation($class, PropertyAccessor::class);
        if($propertyAccessor) {
            foreach ($class->getProperties() as $index => $property) {
                $amqpProperty = $reader->getPropertyAnnotation($property, AmqpProperty::class);

                if ($amqpProperty) {
                    $dotNotation =  $this->dotNotation($propertyAccessor->name, $amqpProperty->name);

                    $configValue = Arr::get($data, $dotNotation) ?? $amqpProperty->default;
                    $propertyName = $property->name;

                    $this->allProperties[$amqpProperty->name] = $configValue;
                    $this->$propertyName = $configValue;
                }
            }
        }
        else {
            throw new ClassPropertyAccessorNotFound($class->getName());
        }

    }

    private function dotNotation(string ...$toDot) {
        $return = '';
        $lastIndex = array_key_last($toDot);

        foreach ($toDot as $index => $string) {
            if($string) {
                $return .= $string;

                if ($lastIndex !== $index) {
                    $return .= '.';
                }
            }
        }

        return $return;
    }

    /**
     * @param string $key
     * @param null $default
     *
     * @return mixed
     */
    public function property(string $key, $default = null)
    {
        return Arr::get($this->allProperties, $key, $default);
    }

    /**
     * @return string
     * @throws ClassPropertyAccessorNotFound
     * @throws AnnotationException
     * @throws ReflectionException
     */
    public function getPropertyAccessor(): string {
        $reader = new AnnotationReader();
        $class = new ReflectionClass($this);

        $propertyAccessor = $reader->getClassAnnotation($class, PropertyAccessor::class);
        if(!$propertyAccessor) {
            throw new ClassPropertyAccessorNotFound($class->getName());
        }
        return $propertyAccessor->name;
    }

    /**
     * @param string $key
     * @param $value
     */
    public function setProperty(string $key, $value) {
        $this->allProperties[$key] = $value;
    }

}
