/**
* Nombre:		  	    pagina_componente_tramo.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-10-24 16:45:44
*/
function pagina_componente_tramo(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/componente_tramo/ActionListarComponenteTramo.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_componente_tramo',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_componente_tramo',
		'cantidad',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_item',
		'desc_item',
		'id_tramo',
		'desc_tramo',
		'supergrupo',
		'grupo',
		'subgrupo',
		'id1',
		'id2',
		'id3',
		'codigo',
		'descripcion'
		]),remoteSort:true});


		// DEFINICIÓN DATOS DEL MAESTRO


		function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
		function italic(value){return '<i>'+value+'</i>';}
		var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
		Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
		var data_maestro=[['id_tramo',maestro.id_tramo],['Código',maestro.codigo],['Nombre',maestro.nombre]];

		//DATA STORE COMBOS

		var ds_tramo = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tramo/ActionListarTramo.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tramo',totalRecords: 'TotalCount'},['id_tramo','id_tramo','codigo','nombre','descripcion','fecha_reg','id_ante_proyecto'])
		});

		//FUNCIONES RENDER

		function render_id_tramo(value, p, record){return String.format('{0}', record.data['desc_tramo']);}
		function render_id_item(value, p, record){return String.format('{0}', record.data['desc_item']);};
		var tpl_id_tramo=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{codigo}</FONT><br>','<FONT COLOR="#B5A642">{nombre}</FONT>','</div>');



		/////////////////////////
		// Definición de datos //
		/////////////////////////

		// hidden id_componente_tramo
		//en la posición 0 siempre esta la llave primaria

		Atributos[0]={
			validacion:{
				labelSeparator:'',
				name: 'id_componente_tramo',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false
		};
		// txt cantidad
		Atributos[1]={
			validacion:{
				name:'cantidad',
				fieldLabel:'Cantidad',
				allowBlank:false,
				maxLength:50,
				align:'right',
				minLength:0,
				selectOnFocus:true,
				allowDecimals:false,
				allowNegative:false,
				minValue:0,
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'50%',
				disabled:false,
				grid_indice:4
			},
			tipo: 'NumberField',
			form: true,
			filtro_0:true,
			filterColValue:'COMTRA.cantidad'
		};
		// txt fecha_reg
		Atributos[2]= {
			validacion:{
				name:'fecha_reg',
				fieldLabel:'Fecha de Registro',
				allowBlank:true,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Día no válido',
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width_grid:85,
				disabled:true,
				grid_indice:11
			},
			form:false,
			tipo:'DateField',
			filtro_0:true,
			filterColValue:'COMTRA.fecha_reg',
			dateFormat:'m-d-Y',
			defecto:''
		};
		// txt id_item
		Atributos[3]={
			validacion:{
				name:'id_item',
				//desc:'desc_item',
				fieldLabel:'Item',
				tipo:'ingreso',
				allowBlank:true,
				maxLength:100,
				minLength:0,
				selectOnFocus:true,
				vtype:"texto",
				grid_visible:true,
				grid_editable:false,
				width_grid:90,
				width:200,
				pageSize:10,
				direccion:direccion,
				grid_indice:2		,
				renderer:render_id_item
			},
			tipo:'LovItemsAlm',
			filtro_0:true,
			filterColValue:'ITEM.nombre'

		};
		// txt id_tramo
		Atributos[4]={
			validacion:{
				name:'id_tramo',
				labelSeparator:'',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false,
				disabled:true
			},
			tipo:'Field',
			filtro_0:false,
			defecto:maestro.id_tramo
		};
		// txt nombre
		Atributos[5]={
			validacion:{
				name:'supergrupo',
				fieldLabel:'SuperGrupo',
				allowBlank:false,
				maxLength:100,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false,
				grid_indice:5
			},
			tipo: 'TextArea',
			form: false,
			filtro_0:true,
			filterColValue:'SUPGRU.nombre'
		};
		// txt nombre
		Atributos[6]={
			validacion:{
				name:'grupo',
				fieldLabel:'Grupo',
				allowBlank:false,
				maxLength:100,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false,
				grid_indice:6
			},
			tipo: 'TextArea',
			form: false,
			filtro_0:true,
			filterColValue:'GRUPO.nombre'
		};
		// txt nombre
		Atributos[7]={
			validacion:{
				name:'subgrupo',
				fieldLabel:'SubGrupo',
				allowBlank:false,
				maxLength:100,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false,
				grid_indice:7
			},
			tipo: 'TextArea',
			form: false,
			filtro_0:true,
			filterColValue:'SUBGRU.nombre'
		};
		// txt nombre
		Atributos[8]={
			validacion:{
				name:'id1',
				fieldLabel:'ID1',
				allowBlank:false,
				maxLength:100,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false,
				grid_indice:8
			},
			tipo: 'TextArea',
			form: false,
			filtro_0:true,
			filterColValue:'IDENT1.nombre'
		};
		// txt nombre
		Atributos[9]={
			validacion:{
				name:'id2',
				fieldLabel:'ID2',
				allowBlank:false,
				maxLength:100,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false,
				grid_indice:9
			},
			tipo: 'TextArea',
			form: false,
			filtro_0:true,
			filterColValue:'IDENT2.nombre'
		};
		// txt nombre
		Atributos[10]={
			validacion:{
				name:'id3',
				fieldLabel:'ID3',
				allowBlank:false,
				maxLength:100,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false,
				grid_indice:10
			},
			tipo: 'TextArea',
			form: false,
			filtro_0:true,
			filterColValue:'IDENT3.nombre'
		};

		/////////// txt desc_nombre //////
		Atributos[11] = {
			validacion: {
				name: 'codigo',
				fieldLabel: 'Código',
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:100, // ancho de columna en el grid
				grid_indice:1

			},
			form:false,
			tipo: 'Field',
			filtro_0:false
		};
		
		/////////// txt desc_nombre //////
		Atributos[12] = {
			validacion: {
				name: 'descripcion',
				fieldLabel: 'Descripción Item',
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:170, // ancho de columna en el grid
				grid_indice:3

			},
			form:false,
			tipo: 'Field',
			filtro_0:false
		};




		//----------- FUNCIONES RENDER

		function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

		//---------- INICIAMOS LAYOUT DETALLE
		var config={titulo_maestro:'Tramos (Maestro)',titulo_detalle:'componente_tramo (Detalle)',grid_maestro:'grid-'+idContenedor};
		var layout_componente_tramo = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
		layout_componente_tramo.init(config);



		//---------- INICIAMOS HERENCIA
		this.pagina = Pagina;
		this.pagina(paramConfig,Atributos,ds,layout_componente_tramo,idContenedor);
		var getComponente=this.getComponente;
		var getSelectionModel=this.getSelectionModel;
		var EstehtmlMaestro=this.htmlMaestro;
		//DEFINICIÓN DE LA BARRA DE MENÚ
		var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
		//DEFINICIÓN DE FUNCIONES
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/componente_tramo/ActionEliminarComponenteTramo.php',parametros:'&id_tramo='+maestro.id_tramo},
			Save:{url:direccion+'../../../control/componente_tramo/ActionGuardarComponenteTramo.php',parametros:'&id_tramo='+maestro.id_tramo},
			ConfirmSave:{url:direccion+'../../../control/componente_tramo/ActionGuardarComponenteTramo.php',parametros:'&id_tramo='+maestro.id_tramo},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'componente_tramo'}};

			//-------------- Sobrecarga de funciones --------------------//
			this.reload=function(params){
				var datos=Ext.urlDecode(decodeURIComponent(params));

				maestro.id_tramo=datos.id_tramo;
				maestro.codigo=datos.codigo;
				maestro.nombre=datos.nombre;

				ds.lastOptions={
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						id_tramo:maestro.id_tramo
					}
				};
				this.btnActualizar();
				data_maestro=[['id_tramo',maestro.id_tramo],['Código',maestro.codigo],['Nombre',maestro.nombre]];
				Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
				Atributos[4].defecto=maestro.id_tramo;

				paramFunciones.btnEliminar.parametros='&id_tramo='+maestro.id_tramo;
				paramFunciones.Save.parametros='&id_tramo='+maestro.id_tramo;
				paramFunciones.ConfirmSave.parametros='&id_tramo='+maestro.id_tramo;
				this.InitFunciones(paramFunciones)
			};

			//Para manejo de eventos
			function iniciarEventosFormularios(){
				//para iniciar eventos en el formulario
			}

			//para que los hijos puedan ajustarse al tamaño
			this.getLayout=function(){return layout_componente_tramo.getLayout()};
			//para el manejo de hijos

			this.Init(); //iniciamos la clase madre
			this.InitBarraMenu(paramMenu);
			this.InitFunciones(paramFunciones);
			//carga datos XML
			ds.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					id_tramo:maestro.id_tramo
				}
			});

			//para agregar botones

			this.iniciaFormulario();
			iniciarEventosFormularios();
			layout_componente_tramo.getLayout().addListener('layout',this.onResize);
			layout_componente_tramo.getVentana(idContenedor).on('resize',function(){layout_componente_tramo.getLayout().layout()})

}