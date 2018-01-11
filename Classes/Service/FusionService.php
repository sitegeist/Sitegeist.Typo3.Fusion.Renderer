<?php
namespace Sitegeist\Typo3\Fusion\Renderer\Service;

use Neos\Utility\Files;
use Sitegeist\Eel\Standalone\Helper as EelHelper;

class FusionService
{
    /**
     * @param $fusionAst
     * @param $fusionPath
     * @param array $fusionContext
     * @return string
     */
    static function renderFusion($fusionAst, $fusionPath, $fusionContext = []) {

        $defaultContextConfiguration = [
            'Array' => EelHelper\ArrayHelper::class,
            'Date' => EelHelper\DateHelper::class,
            'Json' => EelHelper\JsonHelper::class,
            'Math' => EelHelper\MathHelper::class,
            'String' => EelHelper\StringHelper::class,
            'Type' => EelHelper\TypeHelper::class
        ];

        $runtime = FusionRuntimeFactory::getInstance()->getRuntime($fusionAst, $defaultContextConfiguration);

        $runtime->pushContextArray($fusionContext);
        $output = $runtime->render($fusionPath);
        $runtime->popContext();

        return $output;
    }
}
