# Zao PDF Viewer

PDF Viewer shortcode plugin. Uses [Mozilla's pdf.js](https://github.com/mozilla/pdf.js) for displaying a beautiful native-feeling PDF viewer.

The `pdfviewer` shortcode supports either an `id` attribute for displaying a viewer for a pdf in the media library, or `url` for displaying any pdf URL (as long as it is on the same domain), and a `height` attribute for determining the height ratio of the viewer iframe. The plugin has an options page to define the default fallback height ratio.

The plugin also supports [Shortcake (Shortcode UI)](https://github.com/wp-shortcake/shortcake), so if you have that installed, you will also have a handy shortcode UI for setting the shortcode parameters and selecting a media library PDF.

If you prefer to use in your template or plugin, you can do so like:

```php
echo ZPDF_Viewer_Frontend::get_instance()->output( 'url' => 'URL_TO_PDF.pdf' );
```

### Screenshots

Frontend output:
![Frontend output](https://raw.githubusercontent.com/zao-web/zao-pdf-viewer/master/screenshot-2.png)

Shortcode:
![admin shortcode](https://raw.githubusercontent.com/zao-web/zao-pdf-viewer/master/screenshot-1.png)

With Shortcode UI:
![With Shortcode UI](https://raw.githubusercontent.com/zao-web/zao-pdf-viewer/master/screenshot-3.gif)

### Developer Features

#### Custom viewer stylesheet or javascript.

To load your own additional stylesheet to the viewer, add a `style.css` file to a new `/zao-pdf-viewer/` directory in your theme.
To load your own additional javascript file to the viewer, add a `viewer-custom.js` file to that same `/zao-pdf-viewer/` directory in your theme.

To override the viewer's stylesheet completely, you would use the `zaopdf_stylesheet` filter, documented below.

#### Hooks

##### Filters

* `shortcode_atts_pdfviewer` - This is the default filter provided by the `shortcode_atts()` function. It runs with each shortcode, and allows you to override the shortcode parameters after they are parsed.
* `zaopdf_iframe_css` - Runs with each shortcode, and allows you to override the output of a specific shortcode's inline css.
* `zaopdf_iframe_markup` - Runs with each shortcode, and allows you to override the output of a specific shortcode's iframe markup.
* `zaopdf_stylesheet` - Filters the main Zao PDF Viewer stylesheet. Replace with a URL to your own stylesheet to override.
* `zaopdf_js` - Filters the main Zao PDF Viewer javascript URL. Replace with a URL to your own javascript file to override. This is the main functionality of the viewer, so proceed with caution.
* `zaopdf_worker_js` - Filters the Zao PDF Viewer worker javascript URL. Replace with a URL to your own javascript file to override. This is primary functionality of the viewer, so proceed with caution.
* The following filters can each be used to [disable a button in the Zao PDF Viewer](https://github.com/zao-web/zao-pdf-viewer/blob/master/README.md#sample-snippets).
	* `zaopdf_button_enable_viewThumbnail`
	* `zaopdf_button_enable_viewOutline`
	* `zaopdf_button_enable_viewAttachments`
	* `zaopdf_button_enable_viewThumbnail`
	* `zaopdf_button_enable_presentationMode`
	* `zaopdf_button_enable_openFile`
	* `zaopdf_button_enable_print`
	* `zaopdf_button_enable_download`
	* `zaopdf_button_enable_viewBookmark`
	* `zaopdf_button_enable_firstPage`
	* `zaopdf_button_enable_lastPage`
	* `zaopdf_button_enable_pageRotateCw`
	* `zaopdf_button_enable_pageRotateCcw`
	* `zaopdf_button_enable_toggleHandTool`
	* `zaopdf_button_enable_documentProperties`
	* `zaopdf_button_enable_sidebarToggle`
	* `zaopdf_button_enable_viewFind`
	* `zaopdf_button_enable_pagination`
	* `zaopdf_button_enable_paginationInput`
	* `zaopdf_button_enable_paginationInput`
	* `zaopdf_button_enable_presentationMode`
	* `zaopdf_button_enable_openFile`
	* `zaopdf_button_enable_print`
	* `zaopdf_button_enable_download`
	* `zaopdf_button_enable_viewBookmark`
	* `zaopdf_button_enable_secondaryToolbarToggle`
	* `zaopdf_button_enable_zoomToggles`
	* `zaopdf_button_enable_scaleSelect`

##### Actions

* `zaopdf_init` - Fires when the plugin objects are initiated.
* `zaopdf_head` - Hook in the head of the viewer html document, similar to `wp_head`.
* `zaopdf_footer` - Hook just before the closing `</body>` tag in the viewer html document, similar to `wp_footer`.

#### Sample Snippets

* Disable the download, print, and open-file buttons:

```php
add_filter( 'zaopdf_button_enable_download', '__return_false' );
add_filter( 'zaopdf_button_enable_print', '__return_false' );
add_filter( 'zaopdf_button_enable_openFile', '__return_false' );
```

* Make all links in the PDF open a new tab:

```php
function zao_make_all_pdf_links_open_in_new_tab() {
	echo '<base target="_blank">';
}
add_action( 'zaopdf_footer', 'zao_make_all_pdf_links_open_in_new_tab' );
```

* Disable shortcode completely, and create a theme template tag instead (please replace `themeprefix_` with something unique to your project):

```php
add_action( 'zaopdf_init', function() {
	remove_shortcode( ZPDFV_SHORTCODE_TAG, array( ZPDF_Viewer_Frontend::get_instance(), 'output' ) );
	remove_action( 'register_shortcode_ui', array( ZPDF_Viewer_Admin::get_instance(), 'shortcode_ui' ) );
} );

/**
 * Wrapper for ZPDF_Viewer_Frontend::output.
 * Use like:
 *
 * themeprefix_zpdf( array(
 *		'url'    => 'URL_TO_PDF.pdf',
 *		// 'id'  => 1234, // OR a PDF attachment ID.
 *		'height' => 129, // (8.5x11 paper)
 *	) )
 *
 * @param  array  $args An 'id' or 'url' are the minimum requirements, (where 'id' is an pdf attachment ID).
 * @return string       PDF Viewer output (if successful).
 */
function themeprefix_zpdf( $args ) {
	return ZPDF_Viewer_Frontend::get_instance()->output( $args );
}
```

