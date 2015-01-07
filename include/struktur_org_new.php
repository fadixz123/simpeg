<!--
/*
 * lib_gg_orgchart 0.4 - JavaScript Organizational Chart Drawing Library
 *
 * SAMPLE HTML USAGE FILE
 *
 * Copyright (c) 2012 Gorka G Llona (GG) - http://www.fluxus.com.ve/gorka.
 * Licensed under the GNU Lesser General Public License.
 * Project home: http://www.fluxus.com.ve/gorka/lib_gg_orgchart.
 */
-->

<html>
<head>

	<!-- first include these two library files -->
        <script type="text/javascript" src="../Scripts/raphael-min.js"></script>  
        <script type="text/javascript" src="../Scripts/lib_gg_orgchart_v04.js"></script>  

	<!-- now define the organizational chart content and style -->
	<script type="text/javascript">


		// there are provided three sample organizational charts
		// change this variable to show any of these
		//
		var oc_sample_data_to_use = 1;
		//var oc_sample_data_to_use = <?= ! isset($_GET['sample']) ? 1 : ($_GET['sample'] == 2 ? 2 : ($_GET['sample'] == 3 ? 3 : 1)) ?>;


		// SAMPLE DATA #1
		// in this sample nodes haven't 'id', so define oc_style.box_click_handler : null
		// "type" attribute for nodes can be: "subordinate", "staff", "collateral"
		//
		var oc_data_1 = {
			title : 'Mi organigrama',   // not used
			root : {
				title : 'Sede central',
				subtitle: 'Pedro Perez',
				children : [
					{ title : 'CCCP', subtitle: '(collateral node)', type : 'collateral' },
					{ title : 'Consultoría\nJurídica', type : 'staff' },
					{ title : 'Informática', type : 'staff' },
					{ title : 'Inteligencia', subtitle: '(staff node)', type : 'staff' },
					{
						title : 'CCP Los Ruices',
						children : [
							{ title : 'Coordinación de\nPolicía Comunal' },
							{ title : 'Coordinación de\nPolicía Montada' },
							{ title : 'Oficina de\nAtención a\nla Víctima 1', subtitle : 'Juan López' }
						]
					},
					{
						title : 'CCP Catia', subtitle: '(subordinate node)',
						children : [
							{ title : 'Coordinación de\nPolicía Marítima' },
							{ title : 'Coordinación de\nPolicía Aérea' },
							{ title : 'Oficina de\nAtención a\nla Víctima 2', subtitle : 'Gorka LLona' }
						]
					},
					{
						title : 'Servicios Generales',
						children: [
							{ title : 'Mantenimiento' },
							{ title : 'Vehículos' },
						]
					}
				]
			}	
		}


		// SAMPLE DATA #2
		// title is mandatory, subtitle is optional
		// id is mandatory unless you don't want activate click event on boxes
		// using no subtitles compacts the box size
		//
		var oc_data_2 = {
			title : 'Mi organigrama',   // not used
			root : {
				id : '1',
				title : '10',
				//subtitle : '10',
				children : [
					{ id : '10A', title : '10A', type : 'collateral' },
					{ id : '10B', title : '10B', type : 'collateral' },
					{
						id : '11', title : '11',
						children : [
							{ id : '111', title : '111' },
							{ id : '112', title : '112',
								children : [
									{ id : '1121', title : '1121' },
									{ id : '1122', title : '1122' }
								]
							},
						]
					},
					{ id : '12', title : '12',
						children : [
							{ id : '12A', title : '12A', type : 'collateral' },
							{ id : '12B', title : '12B', type : 'collateral' },
						]
					},
					{
						id : '13', title : '13',
						children : [
							{ id : '130A', title : '130A', type : 'collateral' },
							{ id : '130B', title : '130B', type : 'collateral' },
							{ id : '131', title : '131', type : 'staff',
								children : [
									{ id : '1311', title : '1311' },
									{ id : '1312', title : '1312' }
								]
							},
							{ id : '132', title : '132', type : 'staff' },
							{ id : '133', title : '133', type : 'staff' },
							{ id : '134', title : '134' },
							{ id : '135', title : '135' },
							{ id : '136', title : '136' },
							{ id : '137', title : '137',
								children : [
									{ id : '1371', title : '1371' },
									{ id : '1372', title : '1372' }
								]
							},
						]
					}
				]
			}
		};


		// SAMPLE DATA #3
		//
		var oc_data_3 = {
			"title" : "Nosotros",
			"root" : {
				"id" : "107",
				"title" : "Familia",
				"children" : [
					{ "id" : "140", "title" : "Abuela", "type" : "staff" },
					{ "id" : "139", "title" : "Abuelo", "type" : "staff", "children": [] },
					{ "id" : "108", "title" : "Padre",
						"children" : [
						    { "id" : "111", "title" : "Hijo" , "children" : [] }
						]
					},
					{ "id" : "109" , "title" : "Madre",
						"children" : [
							{ "id" : "146" , "title" : "Ahijada" , "type" : "collateral" },
							{ "id" : "147" , "title" : "Ahijado" , "type" : "collateral" },
							{ "id" : "110" , "title" : "Hija" , "type" : "staff",
						        "children" : [
						            { "id" : "151", "title" : "Nieto",
						                "children" : [
						                    { "id" : "153", "title" : "Bisnieto",
						                        "children" : [
						                            { "id" : "171", "title" : "Tataranieto", "children" : [] }
												]
											}
										]
									}
								]
							}
						]
					}
				]
			}
		};


		// ORG CHART CONTENT
		// must be in 'oc_data' global variable
		var oc_data = (oc_sample_data_to_use == 1 ? oc_data_1 : (oc_sample_data_to_use == 2 ? oc_data_2 : oc_data_3));


		// ORG CHART STYLES
		// must be in 'oc_style' global variable
		//
		var oc_style = {
			container          : 'oc_container',         // name of the DIV where the chart will be drawn
			vline              : 10,                     // size of the smallest vertical line of connectors
			hline              : 10,                     // size of the smallest horizontal line of connectors
			inner_padding      : 10,                     // space from text to box border
			box_color          : '#aaf',                 // fill color of boxes
			box_color_hover    : '#faa',                 // fill color of boxes when mouse is over them
			box_border_color   : '#008',                 // stroke color of boxes
			line_color         : '#f44',                 // color of connectors
			title_color        : '#000',                 // color of titles
			subtitle_color     : '#707',                 // color of subtitles
			title_font_size    : 12,                     // size of font used for displaying titles inside boxes
			subtitle_font_size : 10,                     // size of font used for displaying subtitles inside boxes
			title_char_size    : [ 6, 12 ],              // size (x, y) of a char of the font used for displaying titles
			subtitle_char_size : [ 5, 10 ],              // size (x, y) of a char of the font used for displaying subtitles
			max_text_width     : 15,                     // max width (in chars) of each line of text ('0' for no limit) 
			box_click_handler  : oc_box_click_handler,   // handler (function) called on click on boxes (set to null if no handler)
		};


		// set to true if you want to debug the library
		//
		var OC_DEBUG = false;


		// box click handlers
		//
		function oc_box_click_handler (event, box) {
			if (box.oc_id !== undefined)
				alert('clicked on node with ID = ' + box.oc_id);
		}


		// call function 'oc_render()' when you are ready to draw the chart
		// chart will be rendered into a DIV with id = 'oc_container' (or as specified in oc_style)
		//
		window.onload = oc_render;


	</script>

</head>  
<body>  

	<div id="oc_container"></div>  

</body>  
</html>