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
					// {
					// 	text: 'Box with Title and Content',
					// 	onclick: function(e) {
					// 		editor.windowManager.open({
					// 			title: 'Box with Title and Content',
					// 			body: [
					// 				{
					// 					type: 'textbox',
					// 					label: 'Title',
					// 					name: 'title',
					// 					value: ''
					// 				},
					// 				{
					// 					type: 'textbox',
					// 					label: 'Content',
					// 					name: 'content',
					// 					value: '',
					// 				},
					// 			],
					// 			onsubmit: function(e ) {
					// 				var e_data = e.data;
					// 				editor.insertContent('[box_title_content title="' + e_data.title + '"]' + e_data.content + '[/box_title_content]')
					// 			}
					// 		});
					// 	}
					// },
					// {
					// 	text: 'Bullet',
					// 	menu: [
					// 		{
					// 			text: 'Bullet',
					// 			onclick: function() {
					// 				editor.insertContent('[bullet][/bullet]');
					// 			}
					// 		},
					// 		{
					// 			text: 'Bullet Big',
					// 			onclick: function() {
					// 				editor.insertContent('[bullet_big][/bullet_big]');
					// 			}
					// 		},
					// 		{
					// 			text: 'Bullet Gray',
					// 			onclick: function() {
					// 				editor.insertContent('[bullet_gray][/bullet_gray]');
					// 			}
					// 		},
					// 		{
					// 			text: 'Bullet 2 Column with gray Dot',
					// 			onclick: function() {
					// 				editor.windowManager.open({
					// 					title: "Bullet Info",
					// 					body: [
					// 						{
					// 							type: 'textbox',
					// 							label: 'Title',
					// 							name: 'title'
					// 						},
					// 						{
					// 							type: 'textbox',
					// 							label: 'Content',
					// 							name: 'Content'
					// 						}
					// 					],
					// 					onsubmit: function(e) {
					// 						var e_data = e.data;
					// 						editor.insertContent('[bullet_2_column_gray title="' + e_data.title + '"]' + e_data.content + '[/bullet_2_column_gray]')
					// 					}
					// 				})
					// 			}
					// 		},
					// 		{
					// 			text: 'Bullet 2 Column with Check',
					// 			onclick: function() {
					// 				editor.windowManager.open({
					// 					title: "Bullet Info",
					// 					body: [
					// 						{
					// 							type: 'textbox',
					// 							label: 'Title',
					// 							name: 'title'
					// 						},
					// 						{
					// 							type: 'textbox',
					// 							label: 'Content',
					// 							name: 'Content'
					// 						}
					// 					],
					// 					onsubmit: function(e) {
					// 						var e_data = e.data;
					// 						editor.insertContent('[bullet_2_column_check title="' + e_data.title + '"]' + e_data.content + '[/bullet_2_column_check]')
					// 					}
					// 				})
					// 			}
					// 		},
					// 		{
					// 			text: 'Bullet List',
					// 			onclick: function() {
					// 				editor.insertContent('[bullet_list][/bullet_list]');
					// 			}
					// 		},
					// 	]
					// },
					// {
					// 	text: 'Button Links',
					// 	menu: [
					// 		{
					// 			text: 'Button Standard',
					// 			onclick: function() {
					// 				editor.windowManager.open({
					// 					title: 'Button Standard',
					// 					body: [
					// 						{
					// 							type: 'listbox',
					// 							label: 'Button Size',
					// 							name: 'button_size',
					// 							values: [
					// 								{ text: 'Normal', value: 'normal' },
					// 								{ text: 'Large', value: 'large' },
					// 							],
					// 						},
					// 						{
					// 							type: 'listbox',
					// 							label: 'Button Color',
					// 							name: 'button_color',
					// 							values: [
					// 								{ text: 'Default', value: 'default' },
					// 								{ text: 'Blue', value: 'blue' },
					// 							],
					// 						},
					// 						{
					// 							type: 'textbox',
					// 							label: 'Link URL',
					// 							name: 'link_url',
					// 							value: '',
					// 						},
					// 						{
					// 							type: 'textbox',
					// 							label: 'Link Text',
					// 							name: 'link_text',
					// 							value: '',
					// 						},
					// 						{
					// 							type: 'listbox',
					// 							label: 'Open in New Tab?',
					// 							name: 'open_in_new_tab',
					// 							values: [
					// 								{ text: 'No', value: 'false' },
					// 								{ text: 'Yes', value: 'true' },
					// 							],
					// 						},
					// 					],
					// 					onsubmit: function(e) {
					// 						var e_data = e.data;
					// 						editor.insertContent('[button_standard button_size="' + e_data.button_size + '" button_color="' + e_data.button_color + '" open_in_new_tab="' + e_data.open_in_new_tab + '" link_url="' + e_data.link_url + '" link_text="' + e_data.link_text + '"][/button_standard]');
					// 					},
					// 				});
					// 			},
					// 		},
					// 		{
					// 			text: 'Button Plain with Arrow',
					// 			onclick: function() {
					// 				editor.windowManager.open({
					// 					title: 'Button Plain with Arrow',
					// 					body: [
					// 						{
					// 							type: 'textbox',
					// 							label: 'Link URL',
					// 							name: 'link_url',
					// 							value: '',
					// 						},
					// 						{
					// 							type: 'textbox',
					// 							label: 'Link Text',
					// 							name: 'link_text',
					// 							value: '',
					// 						},
					// 						{
					// 							type: 'listbox',
					// 							label: 'Open in New Tab?',
					// 							name: 'open_in_new_tab',
					// 							values: [
					// 								{ text: 'No', value: 'false' },
					// 								{ text: 'Yes', value: 'true' },
					// 							],
					// 						},
					// 					],
					// 					onsubmit: function(e) {
					// 						var e_data = e.data;
					// 						editor.insertContent('[button_plain_arrow open_in_new_tab="' + e_data.open_in_new_tab + '" link_url="' + e_data.link_url + '" link_text="' + e_data.link_text + '"][/button_plain_arrow]');
					// 					},
					// 				});
					// 			},
					// 		},
					// 		{
					// 			text: 'Button Outline',
					// 			onclick: function() {
					// 				editor.windowManager.open({
					// 					title: 'Button Outline',
					// 					body: [
					// 						{
					// 							type: 'textbox',
					// 							label: 'Link URL',
					// 							name: 'link_url',
					// 							value: '',
					// 						},
					// 						{
					// 							type: 'textbox',
					// 							label: 'Link Text',
					// 							name: 'link_text',
					// 							value: '',
					// 						},
					// 						{
					// 							type: 'listbox',
					// 							label: 'Open in New Tab?',
					// 							name: 'open_in_new_tab',
					// 							values: [
					// 								{ text: 'No', value: 'false' },
					// 								{ text: 'Yes', value: 'true' },
					// 							],
					// 						},
					// 					],
					// 					onsubmit: function(e) {
					// 						var e_data = e.data;
					// 						editor.insertContent('[button_outline open_in_new_tab="' + e_data.open_in_new_tab + '" link_url="' + e_data.link_url + '" link_text="' + e_data.link_text + '"][/button_outline]');
					// 					},
					// 				});
					// 			},
					// 		},
					// 		{
					// 			text: 'Link',
					// 			onclick: function() {
					// 				editor.windowManager.open({
					// 					title: 'Link',
					// 					body: [
					// 						{
					// 							type: 'textbox',
					// 							label: 'Link URL',
					// 							name: 'link_url',
					// 							value: '',
					// 						},
					// 						{
					// 							type: 'textbox',
					// 							label: 'Link Text',
					// 							name: 'link_text',
					// 							value: '',
					// 						},
					// 						{
					// 							type: 'listbox',
					// 							label: 'Open in New Tab?',
					// 							name: 'open_in_new_tab',
					// 							values: [
					// 								{ text: 'No', value: 'false' },
					// 								{ text: 'Yes', value: 'true' },
					// 							],
					// 						},
					// 					],
					// 					onsubmit: function(e) {
					// 						var e_data = e.data;
					// 						editor.insertContent('[link open_in_new_tab="' + e_data.open_in_new_tab + '" link_url="' + e_data.link_url + '" link_text="' + e_data.link_text + '"][/link]');
					// 					},
					// 				});
					// 			},
					// 		},
					// 	],
					// },
					// {
					// 	text: 'Clear',
					// 	onclick: function() {
					// 		editor.insertContent('[clear][/clear]');
					// 	},
					// },
					{
						text: 'Column',
						menu: [
							{
								text: 'Column Container',
								onclick: function(e) {
									editor.windowManager.open({
										title: 'Column Container',
										body: [
											{
												type: 'listbox',
												label: 'Column Option',
												name: 'column_option',
												values: [
													{ text: '2 Columns', value: '2' },
													{ text: '3 Columns', value: '3' },
													{ text: '4 Columns', value: '4' },
												],
											},
										],
										onsubmit: function(e) {
											var e_data = e.data;
											editor.insertContent('[column_container colcount="' + e_data.column_option + '"][/column_container]');
										}
									});
								}
							},
							{
								text: 'Column Item',
								onclick: function(e) {
									editor.windowManager.open({
										title: 'Column Item',
										body: [
											{
												type: 'textbox',
												label: 'Content',
												name: 'content',
												value: '',
											},
										],
										onsubmit: function(e) {
											var e_data = e.data;
											editor.insertContent('[column_item]' + e_data.content + '[/column_item]');
										},
									});
								}
							}
						]
					},
					// {
					// 	text: 'Highlight',
					// 	onclick: function() {
					// 		editor.windowManager.open({
					// 			title: 'Highlight',
					// 			body: [
					// 				{
					// 					type: 'listbox',
					// 					label: 'Highlight Color',
					// 					name: 'highlight_color',
					// 					values: [
					// 						{ text: 'White', value: 'white' },
					// 						// { text: 'Blue', value: 'blue' },
					// 					],
					// 				},
					// 				{
					// 					type: 'textbox',
					// 					label: 'Content',
					// 					name: 'content',
					// 					value: '',
					// 				},
					// 			],
					// 			onsubmit: function(e) {
					// 				var e_data = e.data;
					// 				editor.insertContent('[highlight highlight_color="' + e_data.highlight_color + '"]' + e_data.content + '[/highlight]');
					// 			},
					// 		});
					// 	},
					// },
					// {
					// 	text: 'Drop Cap Background',
					// 	onclick: function() {
					// 		editor.windowManager.open({
					// 			title: 'Drop Cap Background',
					// 			body: [
					// 				{
					// 					type: 'textbox',
					// 					label: 'Letter',
					// 					name: 'letter',
					// 					value: '',
					// 				},
					// 			],
					// 			onsubmit: function(e) {
					// 				var e_data = e.data;
					// 				editor.insertContent('[drop_cap_background letter="' + e_data.letter + '"][/drop_cap_background]');
					// 			},
					// 		});
					// 	},
					// },
					// {
					// 	text: 'Excerpt Container',
					// 	onclick: function() {
					// 		editor.insertContent('[excerpt_container][/excerpt_container]');
					// 	}
					// },
					// {
					// 	text: 'Highlight Box',
					// 	onclick: function() {
					// 		editor.windowManager.open({
					// 			title: 'Highlight Box',
					// 			body: [
					// 				{
					// 					type: 'textbox',
					// 					label: 'Title',
					// 					name: 'title',
					// 					value: '',
					// 				},
					// 				{
					// 					type: 'listbox',
					// 					label: 'HTML Tag',
					// 					name: 'html_title_tag',
					// 					values: [
					// 						{ text: 'span', value: 'span' },
					// 						{ text: 'div', value: 'div' },
					// 						{ text: 'h2', value: 'h2' },
					// 						{ text: 'h3', value: 'h3' },
					// 						{ text: 'h4', value: 'h4' },
					// 						{ text: 'h5', value: 'h5' },
					// 					],
					// 				},
					// 			],
					// 			onsubmit: function(e) {
					// 				var e_data = e.data;
					// 				editor.insertContent('[highlight_box html_title_tag="' + e_data.html_title_tag + '" title="' + e_data.title + '"][/highlight_box]');
					// 			},
					// 		});
					// 	},
					// },
					// {
					// 	text: 'Paragraph Row',
					// 	menu: [
					// 		{
					// 			text: 'Title Float',
					// 			onclick: function() {
					// 				editor.windowManager.open({
					// 					title: 'Title Float',
					// 					body: [
					// 						{
					// 							type: 'textbox',
					// 							label: 'Title Text',
					// 							name: 'title_text',
					// 							value: '',
					// 						},
					// 						{
					// 							type: 'listbox',
					// 							label: 'Title HTML Tag',
					// 							name: 'title_html_tag',
					// 							values: [
					// 								{ text: 'span', value: 'span' },
					// 								{ text: 'div', value: 'div' },
					// 								{ text: 'h1', value: 'h1' },
					// 								{ text: 'h2', value: 'h2' },
					// 								{ text: 'h3', value: 'h3' },
					// 								{ text: 'h4', value: 'h4' },
					// 								{ text: 'h5', value: 'h5' },
					// 								{ text: 'h6', value: 'h6' },
					// 							],
					// 						},
					// 					],
					// 					onsubmit: function(e) {
					// 						var e_data = e.data;
					// 						editor.insertContent('[paragraph_row_title_float title_text="' + e_data.title_text + '" title_html_tag="' + e_data.title_html_tag + '"][/paragraph_row_title_float]');
					// 					},
					// 				});
					// 			},
					// 		},
					// 	],
					// },
					// {
					// 	text: 'Separator',
					// 	onclick: function() {
					// 		editor.insertContent('[separator][/separator]');
					// 	},
					// },
				],
			});
		},
	});
	tinymce.PluginManager.add( 'shortcodes', tinymce.plugins.MyButtons );
})();