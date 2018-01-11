<?php
namespace Sitegeist\Typo3\Fusion\Renderer\Service;

use Sitegeist\Fusion\Standalone\Core\Runtime;

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
     * Create and return the runtime for the given astFile
     *
     * @param $astFile
     * @return Runtime
     */
    public function createRuntime($astFile) {
        if (array_key_exists($astFile, $this->runtimes) === false) {
            $ast = json_decode(file_get_contents(PATH_typo3conf . $astFile), true);
            $runtime = new Runtime($ast);
            $this->runtimes[$astFile] = $runtime;
        }
        return $this->runtimes[$astFile];
    }
}
