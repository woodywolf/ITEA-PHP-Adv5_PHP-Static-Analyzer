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

class ClassAnalyzer
{
    private $className;

    public function __construct(string $className)
    {
        $this->className=$className;
    }



    public function analyze()
    {
        $reflector = new \ReflectionClass($this->className);
        $reflection = new \Reflection();

        $classArray = [];

        $classArray['class name'] = $reflector->getShortName();
        $classArray['class type'] = $reflection::getModifierNames($reflector->getModifiers());


        $array = $this->count($reflector);

        return $finalArray = [$classArray,$array];
    }

    public function count($reflector)
    {
        $properties = $reflector->getProperties();
        $methods = $reflector->getMethods();

        $array = ['Properties'=>
            ['public' => 0,
                'protected'=> 0,
                'private' => 0, ],
            'Methods' =>
                ['public' => 0,
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
