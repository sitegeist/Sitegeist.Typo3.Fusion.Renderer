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

### Authors & Sponsors

* Martin Ficzel - ficzel@sitegeist.de
* Wilhelm Behncke - behncke@sitegeist.de

*The development and the public-releases of this package is generously sponsored
by our employer http://www.sitegeist.de.*

## Contribution

We will gladly accept contributions. Please send us pull requests.
