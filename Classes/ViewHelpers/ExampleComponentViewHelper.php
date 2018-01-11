<?php
namespace Sitegeist\Typo3\Fusion\Renderer\ViewHelpers;

class ExampleComponentViewHelper extends AbstractFusionComponentViewHelper {

    /**
     * The Fusion AST as JSON File
     *
     * @var string
     */
    static protected $fusionAst = 'ext/typo3_fusion_renderer/Resources/Private/exampleAst.json';

    /**
     * The fusion path this viewHelper will render
     *
     * @var string
     */
    static protected $fusionPath = 'renderPrototype_Vendor_Site_Example';

    /**
     * Arguments Initialization
     */
    public function initializeArguments() {
        $this->registerArgument('content', 'string', '', FALSE);
        $this->registerArgument('attribute', 'string', '', FALSE);
        $this->registerArgument('augmentedAttribute', 'string', '', FALSE);
    }

}
