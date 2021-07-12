/**
 * @license Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
  // config.removeButtons = 'Flash';
  // config.removeButtons = 'Form';
  // config.removeButtons = 'Checkbox';
  // config.removeButtons = 'Flash', 'Form', 'Checkbox';
  // config.entities_latin = false;
  // config.entities_greek = false;
  // config.entities = false;
  // config.basicEntities = false;
  config.enterMode = CKEDITOR.ENTER_BR;
  config.shiftEnterMode = CKEDITOR.ENTER_P;
  config.removePlugins = 'easyimage, cloudservices, exportpdf';
	config.allowedContent = false;
};
