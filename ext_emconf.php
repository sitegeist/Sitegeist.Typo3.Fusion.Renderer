<?php
$EM_CONF[$_EXTKEY] = array(
    'title' => 'sitegeist/typo3-fusion-renderer',
    'description' => '',
    'category' => 'plugin',
    'author' => 'Martin Ficzel',
    'author_email' => '',
    'author_company' => 'http://www.sitegeist.de',
    'shy' => '',
    'priority' => '',
    'module' => '',
    'state' => 'stable',
    'internal' => '',
    'uploadfolder' => '0',
    'createDirs' => '',
    'modify_tables' => '',
    'clearCacheOnLoad' => 1,
    'lockType' => '',
    'version' => '0.0.1',
    'constraints' => array(
        'depends' => array(
            'typo3' => '8.0.0-9.999.999',
        ),
    ),
    'autoload' =>
        array(
            'psr-4' =>
                array(
                    "Sitegeist\\Typo3\\Fusion\\Renderer\\" => "Classes/"
                )
        )
);
