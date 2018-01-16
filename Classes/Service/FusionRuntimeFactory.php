<?php
namespace Sitegeist\Typo3\Fusion\Renderer\Service;

use Sitegeist\Fusion\Standalone\Core\Runtime;
use Neos\Utility\Files;
use Neos\Utility\Arrays;

use TYPO3\CMS\Core\Utility\GeneralUtility;

class FusionRuntimeFactory
{
    /**
     * @var FusionRuntimeFactory
     */
    static protected $instance;

    /**
     * @var Runtime[]
     */
    protected $runtimes = [];

    /**
     * @return FusionRuntimeFactory
     */
    static public function getInstance() {
        if (self::$instance === null) {
            self::$instance = new FusionRuntimeFactory();
        }
        return self::$instance;
    }

    /**
     * FusionRuntimeFactory constructor.
     */
    private function __construct()
    {

    }

    /**
     * Get the runtime for the given astFile
     *
     * @param string $astFile filename for the fusion ast in json
     * @return Runtime
     */
    public function getRuntime($astFile) {
        if (array_key_exists($astFile, $this->runtimes) === false) {
            //
            // read fusion ast
            //
            $fusionAstFileName = GeneralUtility::getFileAbsFileName($astFile);
            $ast = json_decode(file_get_contents($fusionAstFileName), true);

            //
            // prepare ast with local implementations from conf vars
            //
            $fusionObjectImplementations = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['typo3_fusion_renderer']['fusionObjectImplementations'] ?: [];
            foreach ($fusionObjectImplementations as $fusionObjectName => $fusionObjectImplementation) {
                if (Arrays::getValueByPath($ast, ['__prototypes', $fusionObjectName])) {
                    $ast = Arrays::setValueByPath($ast, ['__prototypes', $fusionObjectName, '__meta', 'class'], $fusionObjectImplementation);
                }
            }

            //
            // create eel configuration from conf vars
            //
            Files::createDirectoryRecursively(PATH_site . 'typo3temp/typo3_fusion_renderer');
            $eelCacheDirectory = PATH_site . 'typo3temp/typo3_fusion_renderer/eel';
            $eelHelperConfiguration = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['typo3_fusion_renderer']['eelHelperImplementations'] ?: [];

            //
            // create runtime
            //
            $runtime = new Runtime($ast, $eelCacheDirectory, $eelHelperConfiguration);
            $this->runtimes[$astFile] = $runtime;
        }
        return $this->runtimes[$astFile];
    }
}
