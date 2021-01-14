<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyInfo\PropertyInfoExtractorInterface;
use Symfony\Component\Routing\Annotation\Route;

class BasicController
{
    private $propertyInfo;
    public function __construct(PropertyInfoExtractorInterface $propertyInfo) {
        $this->propertyInfo = $propertyInfo;
    }

    /**
     * @Route("/basic", name="app_basic")
     */
    public function basic(): Response
    {
        $property = new \ReflectionProperty(get_class($this->propertyInfo), 'listExtractors');
        $property->setAccessible(true);

        $extractors = [];
        foreach ($property->getValue($this->propertyInfo) as $extractor)
        {
            $extractors[] = get_class($extractor);
        }

        return new JsonResponse($extractors);
    }
}

