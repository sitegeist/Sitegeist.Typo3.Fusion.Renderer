<?php
namespace Sitegeist\Typo3\Fusion\Renderer\ViewHelpers;

use Sitegeist\Fusion\Standalone\Core\Runtime;
use Sitegeist\Typo3\Fusion\Renderer\Service\FusionRuntimeFactory;

class RenderViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

    /**
     * As this ViewHelper renders HTML, the output must not be escaped.
     *
     * @var bool
     */
    protected $escapeOutput = false;
    protected $escapeChildren = false;

    /**
     * Arguments Initialization
     */
    public function initializeArguments() {
        $this->registerArgument('ast', 'string', 'The filename for the fusion ast in json format', TRUE);
        $this->registerArgument('path', 'string', 'The path to render', TRUE);
        $this->registerArgument('context', 'array', 'The context that will be set', FALSE, []);
        $this->registerArgument('children', 'string', 'The property the children will be mapped to', FALSE, 'content');
    }

    public function render() {

        $fusionAst = $this->arguments['ast'];
        $fusionPath = $this->arguments['path'];
        $fusionContext = $this->arguments['context'];
        $childrenProperty = $this->arguments['children'];

        if (is_array($fusionContext) && !array_key_exists($childrenProperty, $fusionContext)) {
            $fusionContext[$childrenProperty] = $this->renderChildren();
        }

        $fusionRuntimeFactory = FusionRuntimeFactory::getInstance();
        $runtime = $fusionRuntimeFactory->createRuntime($fusionAst);

        $runtime->pushContextArray($fusionContext);
        $output = $runtime->render($fusionPath);
        $runtime->popContext();

        return $output;
    }

}
