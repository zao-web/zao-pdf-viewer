# Zao PDF Viewer

PDF Viewer shortcode plugin. Uses [Mozilla's pdf.js](https://github.com/mozilla/pdf.js) for displaying a beautiful native-feeling PDF viewer.

The `pdfviewer` shortcode supports either an `id` attribute for displaying a viewer for a pdf in the media library, or `url` for displaying any pdf URL (as long as it is on the same domain), and a `height` attribute for determining the height ratio of the viewer iframe. The plugin has an options page to define the default fallback height ratio.

If you prefer to use in your template or plugin, you can do so like:

```php
echo ZPDF_Viewer_Frontend::get_instance()->output( 'url' => 'URL_TO_PDF.pdf' );
```

### Screenshots

Shortcode:
![admin shortcode](https://raw.githubusercontent.com/zao-web/zao-pdf-viewer/master/screenshot-1.png)

Frontend output:
![Frontend output](https://raw.githubusercontent.com/zao-web/zao-pdf-viewer/master/screenshot-2.png)
