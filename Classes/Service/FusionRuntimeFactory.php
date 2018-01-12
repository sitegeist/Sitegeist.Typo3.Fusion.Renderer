<?php
namespace Sitegeist\Typo3\Fusion\Renderer\Service;

use Sitegeist\Fusion\Standalone\Core\Runtime;
use Neos\Utility\Files;
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
            $fusionAstFileName = GeneralUtility::getFileAbsFileName($astFile);
            $defaultContextConfiguration = $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['typo3_fusion_renderer']['defaultContextConfiguration'];
            $ast = json_decode(file_get_contents($fusionAstFileName), true);
            Files::createDirectoryRecursively(PATH_site . 'typo3temp/typo3_fusion_renderer');
            $runtime = new Runtime($ast,PATH_site . 'typo3temp/typo3_fusion_renderer/eel', $defaultContextConfiguration);
            $this->runtimes[$astFile] = $runtime;
        }
        return $this->runtimes[$astFile];
    }
}
