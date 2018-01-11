<?php
namespace Sitegeist\Typo3\Fusion\Renderer\ViewHelpers;

use Sitegeist\Typo3\Fusion\Renderer\Service\FusionService;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Fluid\Core\ViewHelper\Facets\CompilableInterface;

class RenderViewHelper extends AbstractViewHelper implements CompilableInterface{

    use CompileWithRenderStatic;

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

    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $fusionAst = $arguments['ast'];
        $fusionPath = $arguments['path'];
        $fusionContext = $arguments['context'];
        $childrenProperty = $arguments['children'];

        if (is_array($fusionContext) && !array_key_exists($childrenProperty, $fusionContext)) {
            $fusionContext[$childrenProperty] = $renderChildrenClosure();
        }

        return FusionService::renderFusion($fusionAst, $fusionPath, $fusionContext);
    }

}
