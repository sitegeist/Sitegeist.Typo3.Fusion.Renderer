<?php
use Sitegeist\Eel\Standalone\Helper as EelHelper;

//
// register default fusion context configurations
// the classes defined for each key will be instantiated
// and added to the default context of the fusion runtime
//
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['typo3_fusion_renderer']['defaultContextConfiguration'] = [
    'Array' => EelHelper\ArrayHelper::class,
    'Date' => EelHelper\DateHelper::class,
    'Json' => EelHelper\JsonHelper::class,
    'Math' => EelHelper\MathHelper::class,
    'String' => EelHelper\StringHelper::class,
    'Type' => EelHelper\TypeHelper::class
];
