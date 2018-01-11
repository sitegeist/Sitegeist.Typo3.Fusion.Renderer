# Sitegeist.Typo3.Fusion.Renderer

## Render fusion inside Typo3Fluid ViewHelpers

```xml
{namespace fusion=Sitegeist\Typo3\Fusion\Renderer\ViewHelpers}

<!-- render a fusion path with the given context -->
<fusion:render ast="ext/typo3_fusion_renderer/Resources/Private/exampleAst.json" path="renderPrototype_Vendor_Site_Example" context="{content: 'Example Content',  attribute:'example'}" />

<!-- pass fluid-children to a component as prop -->
<fusion:render ast="ext/typo3_fusion_renderer/Resources/Private/exampleAst.json" path="renderPrototype_Vendor_Site_Example" context="{attribute:'example'}" children="content">
    this is fluid inside a fusion component
    <f:for each="{1:1,2:2,3:3}" as="item">
        <fusion:render ast="ext/typo3_fusion_renderer/Resources/Private/exampleAst.json" path="renderPrototype_Vendor_Site_Example" context="{content: 'Item {item}',  attribute:'example'}" />
    </f:for>
</fusion:render>
```

### Component-ViewHelpers for maximized Convenience

For higher convenience the package comes with an abstract class `\Sitegeist\Typo3\Fusion\Renderer\ViewHelpers\AbstractFusionComponentViewHelper` that allows to 
easily implement convenient viewHelpers for fusion components that use the viewHelper-attributes as interface. 

```xml
{namespace fusion=Sitegeist\Typo3\Fusion\Renderer\ViewHelpers}

<fusion:exampleComponent attribute="example" content="This is some content"/>

<fusion:exampleComponent attribute="example">
    Fluid code that is passed to the component as content 
</fusion:exampleComponent>
```

See `\Sitegeist\Typo3\Fusion\Renderer\ViewHelpers\ExampleComponentViewHelper` as reference if you want to use this.

### Authors & Sponsors

* Martin Ficzel - ficzel@sitegeist.de

*The development and the public-releases of this package is generously sponsored
by our employer http://www.sitegeist.de.*

### Installation

To install this package add the following configuttaion to the `composer.json` and run `composer update`.
 
```json
{
    "repositories": [
        { "type": "vcs", "url": "ssh://git@git.sitegeist.de:40022/sitegeist/Sitegeist.Typo3.Fusion.Renderer.git" },
        { "type": "vcs", "url": "ssh://git@git.sitegeist.de:40022/neos-packages/Sitegeist.Eel.Standalone.git" },
        { "type": "vcs", "url": "ssh://git@git.sitegeist.de:40022/neos-packages/Sitegeist.Fusion.Standalone.git" }
    ],
    "require": {
        "sitegeist/typo3-fusion-renderer": "dev-master",
        "sitegeist/eel-standalone": "dev-master",
        "sitegeist/fusion-standalone": "dev-master"
    }
}
```

## Contribution

We will gladly accept contributions. Please send us pull requests.
