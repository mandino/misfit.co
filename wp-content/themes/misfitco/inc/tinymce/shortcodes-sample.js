
// SOURCES
// https://codex.wordpress.org/Plugin_API/Filter_Reference/mce_external_plugins
// https://gist.github.com/vielhuber/4ffedf803506220a59a0734f0584aaa0
// https://jsfiddle.net/aeutaoLf/2/
// https://wordpress.stackexchange.com/questions/239044/add-drop-down-in-wordpress-tiny-mce-editor-pop-up/239048#239048
// http://www.derby-web-design-agency.co.uk/blog-post/how-to-create-a-dropdown-box-in-wordpress-3-9-and-tinymce-4/28/
// https://madebydenis.com/adding-shortcode-button-to-tinymce-editor/
// https://www.gavick.com/blog/wordpress-tinymce-custom-buttons

(function() {

	tinymce.create('tinymce.plugins.MyButtons', {
		init : function(editor, url) {
			editor.addButton('shortcodes', {
				title: 'Shortcodes',
				type: 'menubutton',
				image: '../wp-includes/images/media/code.png',
				menu: [
					{
						text: 'Accordion',
						menu: [
							{
								text: 'Accordion Box',

								onclick: function() {
									editor.insertContent('[accbox][/accbox]');
								}
							},
							{
								text: 'Accordion Item',
								onclick: function() {
									editor.windowManager.open({
										title: 'Accordion Item',
										body: [
											{
												type: 'textbox',
												label: 'Title',
												name: 'title',
												value: '',
											},
											{
												type: 'textbox',
												label: 'Content',
												name: 'content',
												value: '',
											},
										],
										onsubmit: function(e) {
											editor.insertContent('[accbox_item title="' + e.data.title + '"]' + e.data.content + '[/accbox_item]');
										},
									});
								}
							}
						]
					},
					{
						text: 'Column',
						menu: [
							{
								text: 'Column Container',

								onclick: function() {
									editor.windowManager.open({
										title: 'Column Item',
										body: [
											{
												type: 'checkbox',
												label: 'Container Class (Uncheck value is Desktop)',
												name: 'col_class',
												checked: false,
												text: 'Mobile',
											},
										],
										onsubmit: function(e) {
											editor.insertContent('[column_container col_class="' + e.data.col_class + '"][/column_container]');
										},
									});
								}
							},

							{
								text: 'Column Item',

								onclick: function() {
									editor.windowManager.open({
										title: 'Column Item',
										body: [
											{
												type: 'textbox',
												label: 'Column Width 1 - 100',
												name: 'col',
												value: '',
											},
											{
												type: 'checkbox',
												label: 'Set as Parent Container',
												name: 'parent_container',
												checked: false,
												value: '',
											},
											{
												type: 'checkbox',
												label: 'Vertical Align',
												name: 'valign_top',
												checked: false,
												text: 'Vertical Align Top',
											},
											{
												type: 'checkbox',
												label: 'Vertical Align',
												name: 'valign_mid',
												checked: false,
												text: 'Vertical Align Middle',
											},
											{
												type: 'checkbox',
												label: 'Vertical Align',
												name: 'valign_bot',
												checked: false,
												text: 'Vertical Align Bottom',
											},
											{
												type: 'checkbox',
												label: 'Margin',
												name: 'margin_bottom',
												checked: false,
												text: 'Bottom',
											},
											{
												type: 'textbox',
												label: 'Content',
												name: 'content',
												value: '',
											},
										],
										onsubmit: function(e) {
											var valign = '';

											if (e.data.valign_top == true) {
												valign = 'valign="valign-top"';
											} else if (e.data.valign_mid == true) {
												valign = 'valign="valign-middle"';
											} else if (e.data.valign_bot == true) {
												valign = 'valign="valign-bottom"';
											} else {
												valign = 'valign=""';
											}

											if (e.data.margin_bottom == true) {
												margin_bottom = 'col-margin-bottom';
											} else {
												margin_bottom = '';
											}

											if (e.data.parent_container) {
												$internal_col = '';
											} else {
												$internal_col = '_internal';
											}

											editor.insertContent('[column_col' + $internal_col + ' ' + valign + ' col-width="' + e.data.col + '" col-margin-bottom="' + margin_bottom + '"]' + e.data.content + '[/column_col' + $internal_col + ']');
										},
									});
								}
							}
						]
					},
					{
						text: 'Two Column Paragraph',
						onclick: function() {
							editor.insertContent('[two_column][/two_column]');
						}
					},
					{
						text: 'Bullet',
						menu: [
							{
								text: 'Bullet Container',

								onclick: function() {
									editor.windowManager.open({
										title: 'Accordion Item',
										body: [
											{
												type: 'checkbox',
												label: 'Bullet Color',
												name: 'bullet_blue',
												checked: false,
												text: 'Blue',
											},
										],
										onsubmit: function(e) {
											var bulletColor = '';
											if (e.data.bullet_blue == true) {
												bulletColor = ' bullet-class-color="bulleted-list--blue"';
											} else {
												bulletColor = '';
											}

											editor.insertContent('[bullet_list' + bulletColor + '][/bullet_list]');
										},
									});
								}
							},
						]
					},
					{
						text: 'Sub Text',
						menu: [
							{
								text: 'Sub Text',

								onclick: function() {
									editor.insertContent('[sub_text][/sub_text]');
								}
							},
						]
					},
					{
						text: 'Button',
						onclick: function() {
							editor.windowManager.open({
								title: 'Button Info',
								body: [
									{
										type: 'checkbox',
										label: 'Color',
										name: 'blue',
										checked : false,
										text: 'Blue'
									},
									{
										type: 'checkbox',
										label: 'Color',
										name: 'pink',
										checked : false,
										text: 'Pink'
									},
									{
										type: 'checkbox',
										label: 'Light',
										name: 'light',
										checked : false,
										text: 'Light'
									},
									{
										type: 'checkbox',
										label: 'Lighter',
										name: 'lighter',
										checked : false,
										text: 'Lighter'
									},
									{
										type: 'checkbox',
										label: 'Dark',
										name: 'dark',
										checked : false,
										text: 'Dark'
									},
									{
										type: 'checkbox',
										label: 'Darker',
										name: 'darker',
										checked : false,
										text: 'Darker'
									},
									{
										type: 'textbox',
										label: 'Link',
										name: 'link',
										value: '',
									},
									{
										type: 'textbox',
										label: 'Text',
										name: 'text',
										value: '',
									},
								],
								onsubmit: function(e) {

									var color = '';
									if( e.data.blue == true ) {
										color = 'blue';
									} else if( e.data.pink == true ) {
										color = 'pink';
									} else {
										color = '';
									}

									var light = '';
									if( e.data.light == true ) {
										light = 'light';
									} else if( e.data.lighter == true ) {
										light = 'lighter';
									} else if( e.data.dark == true ) {
										light = 'dark';
									} else if( e.data.darker == true ) {
										light = 'darker';
									} else {
										light = '';
									}

									editor.insertContent('[button link="' + e.data.link + '" color="' + color + '" light="' + light + '"]' + e.data.text + '[/button]');
								},
							});
						}
					},
					{
						text: 'Link',
						onclick: function() {
							editor.windowManager.open({
								title: 'Link Info',
								body: [
									{
										type: 'textbox',
										label: 'Link',
										name: 'link',
										value: '',
									},
									{
										type: 'textbox',
										label: 'Text',
										name: 'text',
										value: '',
									},
								],
								onsubmit: function(e) {
									editor.insertContent('[link link="' + e.data.link + '" long="' + e.data.long + '"]' + e.data.text + '[/link]');
								},
							});
						}
					},
				],
			});
		},
	});
	tinymce.PluginManager.add( 'shortcodes', tinymce.plugins.MyButtons );
})();