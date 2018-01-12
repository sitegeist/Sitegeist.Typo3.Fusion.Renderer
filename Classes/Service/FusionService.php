<?php
namespace Sitegeist\Typo3\Fusion\Renderer\Service;

class FusionService
{
    /**
     *
     *
     * @param string $content
     * @param array $arguments
     * @return string
     */
    static function userFunc($content, $arguments) {
        $fusionAst = $arguments['ast'];
        $fusionPath = $arguments['path'];

        $fusionContext = $arguments['context.'];
        if (!$fusionContext) {
            $fusionContext = [];
        }
        if ($content) {
            $fusionContext['content'] = $content;
        }

        return static::renderFusion($fusionAst, $fusionPath, $fusionContext);
    }

    /**
     *
     *
     * @param string $fusionAst
     * @param string $fusionPath
     * @param array $fusionContext
     * @return string
     */
    static function renderFusion($fusionAst, $fusionPath, $fusionContext = []) {
        $runtime = FusionRuntimeFactory::getInstance()->getRuntime($fusionAst);

        $runtime->pushContextArray($fusionContext);
        $output = $runtime->render($fusionPath);
        $runtime->popContext();

        return $output;
    }
}
