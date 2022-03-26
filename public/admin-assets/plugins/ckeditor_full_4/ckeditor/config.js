/**
 * @license Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	//config.contentsCss = [ CKEDITOR.getUrl('contents.css'), '/path/to/fonts.css' ];
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.removePlugins = 'easyimage, cloudservices';
	config.font_names = 'ProximaSoft-Bold;ProximaSoft-ExtraBold;ProximaSoft-Regular;ProximaSoft-SemiBold;' + config.font_names;
};
