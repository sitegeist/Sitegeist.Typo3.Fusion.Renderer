<?php

use Sitegeist\Eel\Standalone\Helper as EelHelper;
use Sitegeist\Fusion\Standalone\FusionObjects as FusionObjects;

//
// register default fusion context configurations
// the classes defined for each key will be instantiated
// and added to the default context of the fusion runtime
//
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['typo3_fusion_renderer']['eelHelperImplementations'] = [
    'Array' => EelHelper\ArrayHelper::class,
    'Date' => EelHelper\DateHelper::class,
    'Json' => EelHelper\JsonHelper::class,
    'Math' => EelHelper\MathHelper::class,
    'String' => EelHelper\StringHelper::class,
    'Type' => EelHelper\TypeHelper::class
];

//
// register default fusion-object implementations
// the classes defined for each key will be instantiated
// and added to the default context of the fusion runtime
//
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['typo3_fusion_renderer']['fusionObjectImplementations'] = [
    'Neos.Fusion:Array' => FusionObjects\ArrayImplementation::class,
    'Neos.Fusion:Value' => FusionObjects\ValueImplementation::class,
    'Neos.Fusion:Component' => FusionObjects\ComponentImplementation::class,
    'Neos.Fusion:Collection' => FusionObjects\CollectionImplementation::class,
    'Neos.Fusion:Augmenter' => FusionObjects\AugmenterImplementation::class,
    'Neos.Fusion:Attributes' => FusionObjects\AttributesImplementation::class,
    'Neos.Fusion:Tag' => FusionObjects\TagImplementation::class,
    'Neos.Fusion:RawArray' => FusionObjects\RawArrayImplementation::class,
    'Neos.Fusion:RawCollection' =>  FusionObjects\RawCollectionImplementation::class,
    'PackageFactory.AtomicFusion:Component' => FusionObjects\ComponentImplementation::class,
    'PackageFactory.AtomicFusion:Augmenter' => FusionObjects\AugmenterImplementation::class
];
