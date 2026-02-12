<?php

declare (strict_types= 1);

namespace App;

use App\Exceptions\Container\ContainerException;
use Psr\Container\ContainerInterface;
use ReflectionClass;

class Container implements ContainerInterface {

    private array $entries = [];

    public function get(string $id)
    {
        if($this->has($id)) {
            $entry = $this->entries[$id];

            return $entry($this);
        }

        return $this->resolve($id);
    }

    public function has(string $id): bool
    {
        return isset($this->entries[$id]);
    }

    public function set(string $id, callable $concrete)
    {
        $this->entries[$id] = $concrete;
    }
//throw new ContainerException('Class "' . $id . '" is not instantable');
    public function resolve(string $id) 
    {
        // исследуем класс

        $reflectionClass = new ReflectionClass($id);

        if(!$reflectionClass->isInstantiable()) {
            throw new ContainerException('Class "' . $id . '" is not instantable');
        }

        // исследуем конструктор

        $constructor = $reflectionClass->getConstructor();

        if(!$constructor) {
            return new $id;
        }

        // исследуем параметры конструктора

        $parameters = $constructor->getParameters();

        if(!$parameters) {
            return new $id;
        }

        // проверяем, являются ли параметры классом
        $dependencies = array_map(
            function(\ReflectionParameter $param) use ($id) {
            
            $name = $param->getName();
            $type = $param->getType();

            /* всего 3 случая, которые должны вызывать ошибку:
            1. типа нет
            2. тип встроенный
            3. тип объединенный
            */

            if(!$type) { // если типа нет, то getType возвращает null
                throw new ContainerException('Failed to resolve class "' . $id . '" beacuse param "' . $name . '" is missing type hint') ;
            }

            if($type instanceof \ReflectionUnionType) {
                throw new ContainerException('Failed to resolve class "' . $id . '" beacuse of using union type for param "' . $name) ;
            }

            if($type instanceof \ReflectionNamedType && !$type->isBuiltin() ) {
                return $this->get($type->getName());
            }

            throw new ContainerException('Failed to resolve class "' . $id . '" because of invalid param "' . $name . '"');
        }, $parameters);

        return $reflectionClass->newInstanceArgs($dependencies);
    }
}