<?php
namespace <%= extensionNamespace %>\<%= viewHelperNamespace %>;

use \Sitegeist\Typo3\Fusion\Renderer\ViewHelpers\AbstractFusionComponentViewHelper;

class <%= viewHelperName %>ViewHelper extends AbstractFusionComponentViewHelper
{

    /**
     * @var string
     */
    protected static $fusionAst = 'EXT:<%= extensionKey %>/<%= astFile %>';

    /**
     * @var string
     */
    protected static $fusionPath =  '<%= renderPath %>';

    /**
     * Register the viewHelper Arguments
     */
    public function initializeArguments()
    {
    <% viewHelperArguments.forEach((viewHelperArgument) => { %>
        /* <%= viewHelperArgument.expression %>  */
        $this->registerArgument('<%= viewHelperArgument.name %>', '<%= viewHelperArgument.type %>', '', <%= (viewHelperArgument.required ? 'TRUE' : 'FALSE') %>);
    <% }); %>
    }
}
