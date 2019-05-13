<?php

/*
 * This file is part of the "PHP Static Analyzer" project.
 *
 * (c) Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Greeflas\StaticAnalyzer\Analyzer;

/**
 * Shows class information in format:
 * Class: {{class_name}} is {{class_type}}
 * Properties:
 *     public: {{count}}
 *     protected: {{count}}
 *     private: {{count}}
 * Methods:
 *     public: {{count}}
 *     protected: {{count}}
 *     private: {{count}}
 *
 */

class ClassAnalyzer
{
    private $className;

    public function __construct(string $className)
    {
        $this->className=$className;
    }



    public function analyze() :array
    {
        $reflector = new \ReflectionClass($this->className);
        $reflection = new \Reflection();



        $classArray['class name'] = $reflector->getShortName();
        $classArray['class type'] = $reflection::getModifierNames($reflector->getModifiers());

        if(empty($classArray['class type'][0]))
        {
            $classArray['class type'][0] = 'normal';
        }

        $array = $this->count($reflector);

        return [$classArray,$array];
    }

    public function count(\ReflectionClass $reflector) : array
    {
        $properties = $reflector->getProperties();
        $methods = $reflector->getMethods();

        $array = [
            'Properties'=> [
                'public' => 0,
                'protected'=> 0,
                'private' => 0,
            ],
            'Methods' => [
                'public' => 0,
                'protected' => 0,
                'private' => 0, ],
        ];


        foreach ($properties as $property) {
            if ($property->isPublic()) {
                $array['Properties']['public']++;
            } elseif ($property->isProtected()) {
                $array['Properties']['protected']++;
            } else {
                $array['Properties']['private']++;
            }
        }

        foreach ($methods as $method) {
            if ($method->isPublic()) {
                $array['Methods']['public']++;
            } elseif ($method->isProtected()) {
                $array['Methods']['protected']++;
            } else {
                $array['Methods']['private']++;
            }
        }

        return $array;
    }
}
