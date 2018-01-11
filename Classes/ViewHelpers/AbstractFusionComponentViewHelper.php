<?php
namespace Sitegeist\Typo3\Fusion\Renderer\ViewHelpers;

use Sitegeist\Typo3\Fusion\Renderer\Service\FusionService;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Fluid\Core\ViewHelper\Facets\CompilableInterface;

abstract class AbstractFusionComponentViewHelper extends AbstractViewHelper implements CompilableInterface{

    use CompileWithRenderStatic;

    /**
     * The Fusion AST as JSON File
     *
     * @var string
     */
    static protected $fusionAst = null;

    /**
     * The fusion path this viewHelper will render
     *
     * @var string
     */
    static protected $fusionPath = null;

    /**
     * As this ViewHelper renders HTML, the output must not be escaped.
     *
     * @var bool
     */
    protected $escapeOutput = false;
    protected $escapeChildren = false;

    /**
     * Render the path and fusion ast with the arguments that were passed to this viewHelper
     *
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        if (!array_key_exists('content', $arguments) || !$arguments['content'] ) {
            $arguments['content'] = $renderChildrenClosure();
        }

        return FusionService::renderFusion(static::$fusionAst, static::$fusionPath, $arguments);
    }

}
