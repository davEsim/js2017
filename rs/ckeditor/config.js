/**



 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.



 * For licensing, see LICENSE.html or http://ckeditor.com/license



 */







CKEDITOR.editorConfig = function( config ) {



	// Define changes to default configuration here. For example:



    config.language = 'cs';
    config.entities_latin = false;




	// config.uiColor = '#AADC6E';



	config.extraPlugins = 'youtube';



	config.width = 510;
	config.height = 400;


	config.toolbar = [



		{ name: 'document', groups: [ 'mode','find', 'selection', 'undo'], items: [ 'Source','Find', 'SelectAll','Undo', 'Redo'] },



		{ name: 'clipboard', groups: [ 'clipboard'], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord'] },



				{ name: 'links', items: [ 'Link', 'Unlink'] },



		{ name: 'insert', items: [ 'Image', 'Table','Youtube'] },







		'/',



		{ name: 'styles', items: [ 'Format'] },



		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },



		{ name: 'paragraph', groups: [ 'list', 'blocks' ], items: [ 'NumberedList', 'BulletedList', 'Blockquote'] }



	];	



};



