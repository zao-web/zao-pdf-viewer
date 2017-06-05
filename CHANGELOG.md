# Zao PDF Viewer Changelog

## 0.1.2 - 2017-06-05

* Added `zaopdf_file_url` filter to allow modifying the PDF file url for the iframe.
* Call `set_url_scheme()`on the PDF url after `wp_get_attachment_url` to compensate for bad wpengine url output buffer filtering.
* Do not encode URLS entered through shortcode UI (shortcake).

## 0.1.1 - 2017-05-31

* Added `'zaopdf_allowed_origins'` filter - Filters the allowed domain origins for PDF hosts. Default is `array( 'null', 'http://mozilla.github.io', 'https://mozilla.github.io', )`, but can be filtered to include additional domains which have the proper CORS settings on the server. See the [CORS/XHR FAQ entry on the PDF.js wiki](https://github.com/mozilla/pdf.js/wiki/Frequently-Asked-Questions#faq-xhr) for more info.

## 0.1.0 - 2016-12-22

* Initial Release
