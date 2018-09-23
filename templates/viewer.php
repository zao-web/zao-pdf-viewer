<!DOCTYPE html>
<!--
Copyright 2012 Mozilla Foundation

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

	http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.

Adobe CMap resources are covered by their own copyright but the same license:

	Copyright 1990-2015 Adobe Systems Incorporated.

See https://github.com/adobe-type-tools/cmap-resources
-->
<html dir="ltr" mozdisallowselectionprint moznomarginboxes>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="google" content="notranslate">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php _e( 'Zao PDF Viewer', 'zpdfv' ); ?></title>

	<?php if ( $css = apply_filters( 'zaopdf_stylesheet', ZPDFV_URL . 'pdfjs/web/viewer.css?v='. ZPDFV_VERSION ) ) : ?>
		<link rel="stylesheet" href="<?php echo $css; ?>">
	<?php endif; ?>

	<!-- This snippet is used in production (included from viewer.html) -->
	<link rel="resource" type="application/l10n" href="<?php echo ZPDFV_URL . 'pdfjs/web/locale/locale.properties'; ?>">
	<script type="text/javascript">
		window.PDFJS = window.PDFJS || {};
		window.PDFJS.workerSrc = '<?php echo apply_filters( 'zaopdf_worker_js', ZPDFV_URL . 'pdfjs/build/pdf.worker.js?v='. ZPDFV_VERSION ); ?>';
		window.PDFJS.allowedOrigins = <?php echo wp_json_encode( apply_filters( 'zaopdf_allowed_origins' /* since 0.1.0 */, array(
			'null',
			'http://mozilla.github.io',
			'https://mozilla.github.io',
		) ) ); ?>;
	</script>
	<script src="<?php echo apply_filters( 'zaopdf_js', ZPDFV_URL . 'pdfjs/web/pdf.viewer.js?v='. ZPDFV_VERSION ); ?>"></script>

	<?php do_action( 'zaopdf_head' ); ?>
</head>

<body tabindex="1" class="loadingInProgress">
	<div id="outerContainer">
		<div id="sidebarContainer">
			<div id="toolbarSidebar">
				<div class="splitToolbarButton toggled">
					<button id="viewThumbnail" class="<?php if ( ! apply_filters( 'zaopdf_button_enable_viewThumbnail', true ) ) :?>hidden<?php endif; ?> toolbarButton group toggled" title="<?php esc_attr_e( 'Show Thumbnails', 'zpdfv' ); ?>" tabindex="2" data-l10n-id="thumbs">
						<span data-l10n-id="thumbs_label"><?php _e( 'Thumbnails', 'zpdfv' ); ?></span>
					</button>
					<button id="viewOutline" class="<?php if ( ! apply_filters( 'zaopdf_button_enable_viewOutline', true ) ) :?>hidden<?php endif; ?> toolbarButton group" title="<?php esc_attr_e( 'Show Document Outline (double-click to expand/collapse all items)', 'zpdfv' ); ?>" tabindex="3" data-l10n-id="document_outline">
						<span data-l10n-id="document_outline_label"><?php _e( 'Document Outline', 'zpdfv' ); ?></span>
					</button>
					<button id="viewAttachments" class="<?php if ( ! apply_filters( 'zaopdf_button_enable_viewAttachments', true ) ) :?>hidden<?php endif; ?> toolbarButton group" title="<?php esc_attr_e( 'Show Attachments', 'zpdfv' ); ?>" tabindex="4" data-l10n-id="attachments">
						<span data-l10n-id="attachments_label"><?php _e( 'Attachments', 'zpdfv' ); ?></span>
					</button>
				</div>
			</div>
			<div id="sidebarContent">
				<div id="thumbnailView" <?php if ( ! apply_filters( 'zaopdf_button_enable_viewThumbnail', true ) ) :?>class="hidden"<?php endif; ?>></div>
				<div id="outlineView" class="hidden"></div>
				<div id="attachmentsView" class="hidden"></div>
			</div>
		</div>  <!-- sidebarContainer -->

		<div id="mainContainer">
			<div class="findbar hidden doorHanger hiddenSmallView" id="findbar">
				<label for="findInput" class="toolbarLabel" data-l10n-id="find_label"><?php _e( 'Find:', 'zpdfv' ); ?></label>
				<input id="findInput" class="toolbarField" tabindex="91">
				<div class="splitToolbarButton">
					<button class="toolbarButton findPrevious" title="" id="findPrevious" tabindex="92" data-l10n-id="find_previous">
						<span data-l10n-id="find_previous_label"><?php _e( 'Previous', 'zpdfv' ); ?></span>
					</button>
					<div class="splitToolbarButtonSeparator"></div>
					<button class="toolbarButton findNext" title="" id="findNext" tabindex="93" data-l10n-id="find_next">
						<span data-l10n-id="find_next_label"><?php _e( 'Next', 'zpdfv' ); ?></span>
					</button>
				</div>
				<input type="checkbox" id="findHighlightAll" class="toolbarField" tabindex="94">
				<label for="findHighlightAll" class="toolbarLabel" data-l10n-id="find_highlight"><?php _e( 'Highlight all', 'zpdfv' ); ?></label>
				<input type="checkbox" id="findMatchCase" class="toolbarField" tabindex="95">
				<label for="findMatchCase" class="toolbarLabel" data-l10n-id="find_match_case_label"><?php _e( 'Match case', 'zpdfv' ); ?></label>
				<span id="findResultsCount" class="toolbarLabel hidden"></span>
				<span id="findMsg" class="toolbarLabel"></span>
			</div>  <!-- findbar -->

			<div id="secondaryToolbar" class="secondaryToolbar hidden doorHangerRight">
				<div id="secondaryToolbarButtonContainer">
					<button id="secondaryPresentationMode" class="<?php if ( ! apply_filters( 'zaopdf_button_enable_presentationMode', true ) ) :?>hidden<?php endif; ?> secondaryToolbarButton presentationMode visibleLargeView" title="<?php esc_attr_e( 'Switch to Presentation Mode', 'zpdfv' ); ?>" tabindex="51" data-l10n-id="presentation_mode">
						<span data-l10n-id="presentation_mode_label"><?php _e( 'Presentation Mode', 'zpdfv' ); ?></span>
					</button>

					<button id="secondaryOpenFile" class="<?php if ( ! apply_filters( 'zaopdf_button_enable_openFile', true ) ) :?>hidden<?php endif; ?> secondaryToolbarButton openFile visibleLargeView" title="<?php esc_attr_e( 'Open File', 'zpdfv' ); ?>" tabindex="52" data-l10n-id="open_file">
						<span data-l10n-id="open_file_label"><?php _e( 'Open', 'zpdfv' ); ?></span>
					</button>

					<button id="secondaryPrint" class="<?php if ( ! apply_filters( 'zaopdf_button_enable_print', true ) ) :?>hidden<?php endif; ?> secondaryToolbarButton print visibleMediumView" title="<?php esc_attr_e( 'Print', 'zpdfv' ); ?>" tabindex="53" data-l10n-id="print">
						<span data-l10n-id="print_label"><?php _e( 'Print', 'zpdfv' ); ?></span>
					</button>

					<button id="secondaryDownload" class="<?php if ( ! apply_filters( 'zaopdf_button_enable_download', true ) ) :?>hidden<?php endif; ?> secondaryToolbarButton download visibleMediumView" title="<?php esc_attr_e( 'Download', 'zpdfv' ); ?>" tabindex="54" data-l10n-id="download">
						<span data-l10n-id="download_label"><?php _e( 'Download', 'zpdfv' ); ?></span>
					</button>

					<a href="#" id="secondaryViewBookmark" class="<?php if ( ! apply_filters( 'zaopdf_button_enable_viewBookmark', true ) ) :?>hidden<?php endif; ?> secondaryToolbarButton bookmark visibleSmallView" title="<?php esc_attr_e( 'Current view (copy or open in new window)', 'zpdfv' ); ?>" tabindex="55" data-l10n-id="bookmark">
						<span data-l10n-id="bookmark_label"><?php _e( 'Current View', 'zpdfv' ); ?></span>
					</a>

					<div class="horizontalToolbarSeparator visibleLargeView"></div>

					<button id="firstPage" class="<?php if ( ! apply_filters( 'zaopdf_button_enable_firstPage', true ) ) :?>hidden<?php endif; ?> secondaryToolbarButton firstPage" title="<?php _e( 'Go to First Page', 'zpdfv' ); ?>" tabindex="56" data-l10n-id="first_page">
						<span data-l10n-id="first_page_label"><?php _e( 'Go to First Page', 'zpdfv' ); ?></span>
					</button>
					<button id="lastPage" class="<?php if ( ! apply_filters( 'zaopdf_button_enable_lastPage', true ) ) :?>hidden<?php endif; ?> secondaryToolbarButton lastPage" title="<?php esc_attr_e( 'Go to Last Page', 'zpdfv' ); ?>" tabindex="57" data-l10n-id="last_page">
						<span data-l10n-id="last_page_label"><?php _e( 'Go to Last Page', 'zpdfv' ); ?></span>
					</button>

					<div class="horizontalToolbarSeparator"></div>

					<button id="pageRotateCw" class="<?php if ( ! apply_filters( 'zaopdf_button_enable_pageRotateCw', true ) ) :?>hidden<?php endif; ?> secondaryToolbarButton rotateCw" title="<?php esc_attr_e( 'Rotate Clockwise', 'zpdfv' ); ?>" tabindex="58" data-l10n-id="page_rotate_cw">
						<span data-l10n-id="page_rotate_cw_label"><?php _e( 'Rotate Clockwise', 'zpdfv' ); ?></span>
					</button>
					<button id="pageRotateCcw" class="<?php if ( ! apply_filters( 'zaopdf_button_enable_pageRotateCcw', true ) ) :?>hidden<?php endif; ?> secondaryToolbarButton rotateCcw" title="<?php esc_attr_e( 'Rotate Counterclockwise', 'zpdfv' ); ?>" tabindex="59" data-l10n-id="page_rotate_ccw">
						<span data-l10n-id="page_rotate_ccw_label"><?php _e( 'Rotate Counterclockwise', 'zpdfv' ); ?></span>
					</button>

					<div class="horizontalToolbarSeparator"></div>

					<button id="toggleHandTool" class="<?php if ( ! apply_filters( 'zaopdf_button_enable_toggleHandTool', true ) ) :?>hidden<?php endif; ?> secondaryToolbarButton handTool" title="<?php esc_attr_e( 'Enable hand tool', 'zpdfv' ); ?>" tabindex="60" data-l10n-id="hand_tool_enable">
						<span data-l10n-id="hand_tool_enable_label"><?php _e( 'Enable hand tool', 'zpdfv' ); ?></span>
					</button>

					<div class="horizontalToolbarSeparator"></div>

					<button id="documentProperties" class="<?php if ( ! apply_filters( 'zaopdf_button_enable_documentProperties', true ) ) :?>hidden<?php endif; ?> secondaryToolbarButton documentProperties" title="<?php esc_attr_e( 'Document Properties…', 'zpdfv' ); ?>" tabindex="61" data-l10n-id="document_properties">
						<span data-l10n-id="document_properties_label"><?php _e( 'Document Properties…', 'zpdfv' ); ?></span>
					</button>
				</div>
			</div>  <!-- secondaryToolbar -->

			<div class="toolbar">
				<div id="toolbarContainer">
					<div id="toolbarViewer">
						<div id="toolbarViewerLeft">
							<button id="sidebarToggle" class="<?php if ( ! apply_filters( 'zaopdf_button_enable_sidebarToggle', true ) ) :?>hidden<?php endif; ?> toolbarButton" title="<?php esc_attr_e( 'Toggle Sidebar', 'zpdfv' ); ?>" tabindex="11" data-l10n-id="toggle_sidebar">
								<span data-l10n-id="toggle_sidebar_label"><?php _e( 'Toggle Sidebar', 'zpdfv' ); ?></span>
							</button>

							<div class="toolbarButtonSpacer"></div>

							<button id="viewFind" class="<?php if ( ! apply_filters( 'zaopdf_button_enable_viewFind', true ) ) :?>hidden<?php endif; ?> toolbarButton group hiddenSmallView" title="<?php esc_attr_e( 'Find in Document', 'zpdfv' ); ?>" tabindex="12" data-l10n-id="findbar">
								<span data-l10n-id="findbar_label"><?php _e( 'Find', 'zpdfv' ); ?></span>
							</button>

							<div class="<?php if ( ! apply_filters( 'zaopdf_button_enable_pagination', true ) ) :?>hidden<?php endif; ?> splitToolbarButton">
								<button class="toolbarButton pageUp" title="<?php esc_attr_e( 'Previous Page', 'zpdfv' ); ?>" id="previous" tabindex="13" data-l10n-id="previous">
									<span data-l10n-id="previous_label"><?php _e( 'Previous', 'zpdfv' ); ?></span>
								</button>
								<div class="splitToolbarButtonSeparator"></div>
								<button class="toolbarButton pageDown" title="<?php esc_attr_e( 'Next Page', 'zpdfv' ); ?>" id="next" tabindex="14" data-l10n-id="next">
									<span data-l10n-id="next_label"><?php _e( 'Next', 'zpdfv' ); ?></span>
								</button>
							</div>

							<input type="number" id="pageNumber" class="<?php if ( ! apply_filters( 'zaopdf_button_enable_paginationInput', true ) ) :?>hidden<?php endif; ?> toolbarField pageNumber" title="<?php esc_attr_e( 'Page', 'zpdfv' ); ?>" value="1" size="4" min="1" tabindex="15" data-l10n-id="page">
							<span id="numPages" class="<?php if ( ! apply_filters( 'zaopdf_button_enable_paginationInput', true ) ) :?>hidden<?php endif; ?> toolbarLabel"></span>
						</div>
						<div id="toolbarViewerRight">
							<button id="presentationMode" class="<?php if ( ! apply_filters( 'zaopdf_button_enable_presentationMode', true ) ) :?>hidden<?php endif; ?> toolbarButton presentationMode hiddenLargeView" title="<?php esc_attr_e( 'Switch to Presentation Mode', 'zpdfv' ); ?>" tabindex="31" data-l10n-id="presentation_mode">
								<span data-l10n-id="presentation_mode_label"><?php _e( 'Presentation Mode', 'zpdfv' ); ?></span>
							</button>

							<button id="openFile" class="<?php if ( ! apply_filters( 'zaopdf_button_enable_openFile', true ) ) :?>hidden<?php endif; ?> toolbarButton openFile hiddenLargeView" title="<?php esc_attr_e( 'Open File', 'zpdfv' ); ?>" tabindex="32" data-l10n-id="open_file">
								<span data-l10n-id="open_file_label"><?php _e( 'Open', 'zpdfv' ); ?></span>
							</button>

							<button id="print" class="<?php if ( ! apply_filters( 'zaopdf_button_enable_print', true ) ) :?>hidden<?php endif; ?> toolbarButton print hiddenMediumView" title="<?php esc_attr_e( 'Print', 'zpdfv' ); ?>" tabindex="33" data-l10n-id="print">
								<span data-l10n-id="print_label"><?php esc_attr_e( 'Print', 'zpdfv' ); ?></span>
							</button>

							<button id="download" class="<?php if ( ! apply_filters( 'zaopdf_button_enable_download', true ) ) :?>hidden<?php endif; ?> toolbarButton download hiddenMediumView" title="<?php esc_attr_e( 'Download', 'zpdfv' ); ?>" tabindex="34" data-l10n-id="download">
								<span data-l10n-id="download_label"><?php _e( 'Download', 'zpdfv' ); ?></span>
							</button>
							<a href="#" id="viewBookmark" class="<?php if ( ! apply_filters( 'zaopdf_button_enable_viewBookmark', true ) ) :?>hidden<?php endif; ?> toolbarButton bookmark hiddenSmallView" title="<?php esc_attr_e( 'Current view (copy or open in new window)', 'zpdfv' ); ?>" tabindex="35" data-l10n-id="bookmark">
								<span data-l10n-id="bookmark_label"><?php _e( 'Current view', 'zpdfv' ); ?></span>
							</a>

							<div class="verticalToolbarSeparator hiddenSmallView"></div>

							<button id="secondaryToolbarToggle" class="<?php if ( ! apply_filters( 'zaopdf_button_enable_secondaryToolbarToggle', true ) ) :?>hidden<?php endif; ?> toolbarButton" title="<?php esc_attr_e( 'Tools', 'zpdfv' ); ?>" tabindex="36" data-l10n-id="tools">
								<span data-l10n-id="tools_label"><?php _e( 'Tools', 'zpdfv' ); ?></span>
							</button>
						</div>
						<div id="toolbarViewerMiddle">
							<div class="<?php if ( ! apply_filters( 'zaopdf_button_enable_zoomToggles', true ) ) :?>hidden<?php endif; ?> splitToolbarButton">
								<button id="zoomOut" class="toolbarButton zoomOut" title="<?php esc_attr_e( 'Zoom Out', 'zpdfv' ); ?>" tabindex="21" data-l10n-id="zoom_out">
									<span data-l10n-id="zoom_out_label"><?php _e( 'Zoom Out', 'zpdfv' ); ?></span>
								</button>
								<div class="splitToolbarButtonSeparator"></div>
								<button id="zoomIn" class="toolbarButton zoomIn" title="<?php esc_attr_e( 'Zoom In', 'zpdfv' ); ?>" tabindex="22" data-l10n-id="zoom_in">
									<span data-l10n-id="zoom_in_label"><?php _e( 'Zoom In', 'zpdfv' ); ?></span>
								</button>
							</div>
							<span id="scaleSelectContainer" class="<?php if ( ! apply_filters( 'zaopdf_button_enable_scaleSelect', true ) ) :?>hidden<?php endif; ?> dropdownToolbarButton">
								<select id="scaleSelect" title="<?php esc_attr_e( 'Zoom', 'zpdfv' ); ?>" tabindex="23" data-l10n-id="zoom">
									<option id="pageAutoOption" title="" value="auto" selected="selected" data-l10n-id="page_scale_auto"><?php _e( 'Automatic Zoom', 'zpdfv' ); ?></option>
									<option id="pageActualOption" title="" value="page-actual" data-l10n-id="page_scale_actual"><?php _e( 'Actual Size', 'zpdfv' ); ?></option>
									<option id="pageFitOption" title="" value="page-fit" data-l10n-id="page_scale_fit"><?php _e( 'Fit Page', 'zpdfv' ); ?></option>
									<option id="pageWidthOption" title="" value="page-width" data-l10n-id="page_scale_width"><?php _e( 'Full Width', 'zpdfv' ); ?></option>
									<option id="customScaleOption" title="" value="custom" disabled="disabled" hidden="true"></option>
									<option title="" value="0.5" data-l10n-id="page_scale_percent" data-l10n-args='{ "scale": 50 }'>50%</option>
									<option title="" value="0.75" data-l10n-id="page_scale_percent" data-l10n-args='{ "scale": 75 }'>75%</option>
									<option title="" value="1" data-l10n-id="page_scale_percent" data-l10n-args='{ "scale": 100 }'>100%</option>
									<option title="" value="1.25" data-l10n-id="page_scale_percent" data-l10n-args='{ "scale": 125 }'>125%</option>
									<option title="" value="1.5" data-l10n-id="page_scale_percent" data-l10n-args='{ "scale": 150 }'>150%</option>
									<option title="" value="2" data-l10n-id="page_scale_percent" data-l10n-args='{ "scale": 200 }'>200%</option>
									<option title="" value="3" data-l10n-id="page_scale_percent" data-l10n-args='{ "scale": 300 }'>300%</option>
									<option title="" value="4" data-l10n-id="page_scale_percent" data-l10n-args='{ "scale": 400 }'>400%</option>
								</select>
							</span>
						</div>
					</div>
					<div id="loadingBar">
						<div class="progress">
							<div class="glimmer">
							</div>
						</div>
					</div>
				</div>
			</div>

			<menu type="context" id="viewerContextMenu">
				<menuitem id="contextFirstPage" label="<?php esc_attr_e( 'First Page', 'zpdfv' ); ?>"
				data-l10n-id="first_page"></menuitem>
				<menuitem id="contextLastPage" label="<?php esc_attr_e( 'Last Page', 'zpdfv' ); ?>"
				data-l10n-id="last_page"></menuitem>
				<menuitem id="contextPageRotateCw" label="<?php esc_attr_e( 'Rotate Clockwise', 'zpdfv' ); ?>"
				data-l10n-id="page_rotate_cw"></menuitem>
				<menuitem id="contextPageRotateCcw" label="<?php esc_attr_e( 'Rotate Counter-Clockwise', 'zpdfv' ); ?>"
				data-l10n-id="page_rotate_ccw"></menuitem>
			</menu>

			<div id="viewerContainer" tabindex="0">
				<div id="viewer" class="pdfViewer"></div>
			</div>

			<div id="errorWrapper" hidden='true'>
				<div id="errorMessageLeft">
					<span id="errorMessage"></span>
					<button id="errorShowMore" data-l10n-id="error_more_info">
						<?php _e( 'More Information', 'zpdfv' ); ?>
					</button>
					<button id="errorShowLess" data-l10n-id="error_less_info" hidden='true'>
						<?php _e( 'Less Information', 'zpdfv' ); ?>
					</button>
				</div>
				<div id="errorMessageRight">
					<button id="errorClose" data-l10n-id="error_close">
						<?php _e( 'Close', 'zpdfv' ); ?>
					</button>
				</div>
				<div class="clearBoth"></div>
				<textarea id="errorMoreInfo" hidden="true" readonly="readonly"></textarea>
			</div>
		</div> <!-- mainContainer -->

		<div id="overlayContainer" class="hidden">
			<div id="passwordOverlay" class="container hidden">
				<div class="dialog">
					<div class="row">
						<p id="passwordText" data-l10n-id="password_label"><?php _e( 'Enter the password to open this PDF file:', 'zpdfv' ); ?></p>
					</div>
					<div class="row">
						<!-- The type="password" attribute is set via script, to prevent warnings in Firefox for all http:// documents. -->
						<input id="password" class="toolbarField">
					</div>
					<div class="buttonRow">
						<button id="passwordCancel" class="overlayButton"><span data-l10n-id="password_cancel"><?php _e( 'Cancel', 'zpdfv' ); ?></span></button>
						<button id="passwordSubmit" class="overlayButton"><span data-l10n-id="password_ok"><?php _e( 'OK', 'zpdfv' ); ?></span></button>
					</div>
				</div>
			</div>
			<div id="documentPropertiesOverlay" class="container hidden">
				<div class="dialog">
					<div class="row">
						<span data-l10n-id="document_properties_file_name"><?php _e( 'File name:', 'zpdfv' ); ?></span> <p id="fileNameField">-</p>
					</div>
					<div class="row">
						<span data-l10n-id="document_properties_file_size"><?php _e( 'File size:', 'zpdfv' ); ?></span> <p id="fileSizeField">-</p>
					</div>
					<div class="separator"></div>
					<div class="row">
						<span data-l10n-id="document_properties_title"><?php _e( 'Title:', 'zpdfv' ); ?></span> <p id="titleField">-</p>
					</div>
					<div class="row">
						<span data-l10n-id="document_properties_author"><?php _e( 'Author:', 'zpdfv' ); ?></span> <p id="authorField">-</p>
					</div>
					<div class="row">
						<span data-l10n-id="document_properties_subject"><?php _e( 'Subject:', 'zpdfv' ); ?></span> <p id="subjectField">-</p>
					</div>
					<div class="row">
						<span data-l10n-id="document_properties_keywords"><?php _e( 'Keywords:', 'zpdfv' ); ?></span> <p id="keywordsField">-</p>
					</div>
					<div class="row">
						<span data-l10n-id="document_properties_creation_date"><?php _e( 'Creation Date:', 'zpdfv' ); ?></span> <p id="creationDateField">-</p>
					</div>
					<div class="row">
						<span data-l10n-id="document_properties_modification_date"><?php _e( 'Modification Date:', 'zpdfv' ); ?></span> <p id="modificationDateField">-</p>
					</div>
					<div class="row">
						<span data-l10n-id="document_properties_creator"><?php _e( 'Creator:', 'zpdfv' ); ?></span> <p id="creatorField">-</p>
					</div>
					<div class="separator"></div>
					<div class="row">
						<span data-l10n-id="document_properties_producer">PDF Producer:</span> <p id="producerField">-</p>
					</div>
					<div class="row">
						<span data-l10n-id="document_properties_version">PDF Version:</span> <p id="versionField">-</p>
					</div>
					<div class="row">
						<span data-l10n-id="document_properties_page_count">Page Count:</span> <p id="pageCountField">-</p>
					</div>
					<div class="buttonRow">
						<button id="documentPropertiesClose" class="overlayButton"><span data-l10n-id="document_properties_close"><?php _e( 'Close', 'zpdfv' ); ?></span></button>
					</div>
				</div>
			</div>
			<div id="printServiceOverlay" class="container hidden">
				<div class="dialog">
					<div class="row">
						<span data-l10n-id="print_progress_message"><?php _e( 'Preparing document for printing…', 'zpdfv' ); ?></span>
					</div>
					<div class="row">
						<progress value="0" max="100"></progress>
						<span data-l10n-id="print_progress_percent" data-l10n-args='{ "progress": 0 }' class="relative-progress">0%</span>
					</div>
					<div class="buttonRow">
						<button id="printCancel" class="overlayButton"><span data-l10n-id="print_progress_close"><?php _e( 'Cancel', 'zpdfv' ); ?></span></button>
					</div>
				</div>
			</div>
		</div>  <!-- overlayContainer -->
	</div> <!-- outerContainer -->
	<div id="printContainer"></div>
	<?php do_action( 'zaopdf_footer' ); ?>
</body>
</html>

