/**
* Nombre:		  	    pagina_existencia_fisica.js
* Propósito: 			pagina objeto principal
* Autor:				JOSé Abraham Mita Huanca
* Fecha creación:		2007-10-26 15:20:26
*/
function pagina_existencia_ep(idContenedor,direccion,paramConfig)
{var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var sw=0;
	var data_id;
	var data_ep;
	var id_ep1;
	var dlgAlarmas;
	var configuracion_filtro;

	/////////////////
	//  DATA STORE //
	/////////////////

	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/existencia/ActionListarAlmacenEpVista.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_item',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_item',
		'codigo',
		'descripcion',
		'precio_venta_almacen',
		'costo_estimado',
		'stock_min',
		'observaciones',
		'nivel_convertido',
		'estado_registro',
		{name: 'fecha_reg', type: 'date', dateFormat: 'Y-m-d'},
		'id_unidad_medida_base',
		'id_id3',
		'id_id2',
		'id_id1',
		'id_subgrupo',
		'id_grupo',
		'id_supergrupo',
		'nombre',
		'nombre_id3',
		'nombre_id2',
		'nombre_id1',
		'nombre_subg',
		'nombre_grupo',
		'nombre_supg',
		'nombre_unid_base',
		'total',
		'id_almacen_ep'
		]),remoteSort:true});

		//carga datos XML
		//existencias();

		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_almacen_ep:id_ep1
				
			}
		};



		//FUNCIONES RENDER

		function render_id_item(value, p, record){return String.format('{0}', record.data['desc_item']);};
		
		/////////////////////////
		// Definición de datos //
		/////////////////////////


		var paramId_Item = {
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name:'id_item',
				inputType:'hidden',
				grid_visible:false, // se muestra en el grid
				grid_editable:false //es editable en el grid
			},
			tipo:'Field',
			filtro_0:false,
			filtro_1:false,
			save_as:'hidden_id_item'
		};
		vectorAtributos[0] = paramId_Item;
		
		/////////// hidden id_supergrupo //////
		var paramId_SuperGrupo = {
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name:'id_supergrupo',
				inputType:'hidden',
				grid_visible:false, // se muestra en el grid
				grid_editable:false //es editable en el grid
			},
			tipo:'Field',
			filtro_0:false,
			filtro_1:false,
			save_as:'hidden_id_supergrupo'
		};

		vectorAtributos[1]=paramId_SuperGrupo;
		
		/////////// hidden id_grupo //////
		var paramId_Grupo={
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name:'id_grupo',
				inputType:'hidden',
				grid_visible:false, // se muestra en el grid
				grid_editable:false //es editable en el grid
			},
			tipo:'Field',
			filtro_0:false,
			filtro_1:false,
			save_as:'hidden_id_grupo'
		};
		vectorAtributos[2] = paramId_Grupo;
		
		/////////// hidden id_subgrupo //////
		var paramId_SubGrupo={
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name:'id_subgrupo',
				inputType:'hidden',
				grid_visible:false, // se muestra en el grid
				grid_editable:false //es editable en el grid
			},
			tipo:'Field',
			filtro_0:false,
			filtro_1:false,
			save_as:'hidden_id_subgrupo'
		};
		vectorAtributos[3] = paramId_SubGrupo;
		
		/////////// hidden id_id1 //////
		var paramId_Id1={
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name:'id_id1',
				inputType:'hidden',
				grid_visible:false, // se muestra en el grid
				grid_editable:false //es editable en el grid
			},
			tipo:'Field',
			filtro_0:false,
			filtro_1:false,
			save_as:'hidden_id_id1'
		};
		vectorAtributos[4]=paramId_Id1;
		
		/////////// hidden id_id2 //////
		var paramId_Id2={
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name:'id_id2',
				inputType:'hidden',
				grid_visible:false, // se muestra en el grid
				grid_editable:false //es editable en el grid
			},
			tipo:'Field',
			filtro_0:false,
			filtro_1:false,
			save_as:'hidden_id_id2'
		};
		vectorAtributos[5] = paramId_Id2;
		
		/////////// hidden id_id3 //////
		var paramId_Id3={
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name:'id_id3',
				inputType:'hidden',
				grid_visible:false, // se muestra en el grid
				grid_editable:false //es editable en el grid
			},
			tipo:'Field',
			filtro_0:false,
			filtro_1:false,
			save_as:'hidden_id_id3'
		};
		vectorAtributos[6] = paramId_Id3;
		/////////// txt codigo //////
		var paramCodigo = {
			validacion:{
				name:'codigo',
				fieldLabel:'Codigo',
				allowBlank:false,
				maxLength:2,
				minLength:2,
				selectOnFocus:true,
				width:'50%',
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:80 // ancho de columna en el gris
			},
			tipo:'TextField',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'codigo',
			save_as:'txt_codigo'
		};
		vectorAtributos[7] = paramCodigo;
		/////////// txt nombre //////
		var paramNombre={
			validacion:{
				name:'nombre',
				fieldLabel:'Nombre',
				allowBlank:false,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				width:'60%',
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:120 // ancho de columna en el gris
			},
			tipo:'TextField',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'nombre',
			save_as:'txt_nombre'
		};
		vectorAtributos[8] = paramNombre;
		/////////// hidden id_unidad_medida_base //////
		var paramId_UnidadMB = {
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name:'id_unidad_medida_base',
				inputType:'hidden',
				grid_visible:false, // se muestra en el grid
				grid_editable:false //es editable en el grid
			},
			tipo:'Field',
			filtro_0:false,
			save_as:'hidden_id_unidad_medida_base'
		};
		vectorAtributos[9] = paramId_UnidadMB;
		/////////// txt descripcion //////
		var paramDescripcion={
			validacion:{
				name:'descripcion',
				fieldLabel:'Descripción',
				allowBlank:false,
				maxLength:200,
				minLength:0,
				selectOnFocus:true,
				width:'50%',
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:130 // ancho de columna en el gris
			},
			tipo:'TextField',
			filtro_0:false,
			filtro_1:false,
			filterColValue:'descripcion',
			save_as:'txt_descripcion'
		};
		vectorAtributos[10] = paramDescripcion;
		/////////// combo estado_registro  //////
		var paramEstadoReg={
			validacion:{
				name:'estado_registro',
				fieldLabel:'Estado',
				allowBlank:false,
				typeAhead:true,
				loadMask:true,
				triggerAction:'all',
				valueField:'ID',
				displayField:'valor',
				lazyRender:true,
				forceSelection:true,
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid
				width_grid:70 // ancho de columna en el grid
			},
			tipo:'TextField',
			filtro_0:false,
			filtro_1:false,
			filterColValue:'estado_registro',
			save_as:'txt_estado_registro'
		};
		vectorAtributos[11] = paramEstadoReg;
		/////////// txt precio_venta_almacen //////
		var paramPrecioVentaAlm = {
			validacion:{
				name:'precio_venta_almacen',
				fieldLabel:'Precio Venta',
				allowBlank:true,
				maxLength:30,
				minLength:0,
				selectOnFocus:true,
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:85  // ancho de columna en el gris

			},
			tipo:'TextField',//cambiar por TextArea(pero es muy grande...)
			filtro_0:true,
			filtro_1:true,
			filterColValue:'precio_venta_almacen',
			save_as:'txt_precio_venta_almacen'
		}
		vectorAtributos[12] = paramPrecioVentaAlm;
		////////// txt costo_estimado //////
		var paramCostoEstimado = {
			validacion:{
				name:'costo_estimado',
				fieldLabel:'Costo Estimado',
				allowBlank:true,
				maxLength:30,
				minLength:0,
				selectOnFocus:true,
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:100  // ancho de columna en el gris

			},
			tipo: 'TextField',//cambiar por TextArea(pero es muy grande...)
			filtro_0:true,
			filtro_1:true,
			filterColValue:'costo_estimado',
			save_as:'txt_costo_estimado'
		}
		vectorAtributos[13] = paramCostoEstimado;
		////////// txt stock_min //////
		var paramStockMin={
			validacion:{
				name:'stock_min',
				fieldLabel:'Stock Mínimo',
				allowBlank:true,
				maxLength:30,
				minLength:0,
				selectOnFocus:true,
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:90  // ancho de columna en el gris


			},
			tipo:'TextField',//cambiar por TextArea(pero es muy grande...)
			filtro_0:true,
			filtro_1:true,
			filterColValue:'stock_min',
			save_as:'txt_stock_min'
		}
		vectorAtributos[14] = paramStockMin;
		/////////// txt observaciones //////
		var paramObservaciones={
			validacion:{
				name:'observaciones',
				fieldLabel:'Observaciones',
				allowBlank:true,
				maxLength:100,
				minLength:0,
				selectOnFocus:true,
				width:'50%',
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:150 // ancho de columna en el gris
			},
			tipo:'TextField',
			filtro_0:false,
			filtro_1:false,
			filterColValue:'observaciones',
			save_as:'txt_observaciones'
		};
		vectorAtributos[15] = paramObservaciones;
		/////////// txt fecha_reg //////
		var paramFechaReg={
			validacion:{
				name:'fecha_reg',
				fieldLabel:'Fecha Registro',
				allowBlank:false,
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid
				renderer:formatDate,
				width_grid:85, // ancho de columna en el gris
				disabled:true
			},
			tipo:'TextField',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'fecha_reg',
			save_as:'txt_fecha_reg',

		};
		vectorAtributos[16] = paramFechaReg;
		/////////// txt nivel_convertido //////
		var paramNivelConvertido={
			validacion:{
				name:'nivel_convertido',
				fieldLabel:'Nivel',
				allowBlank:true,
				maxLength:1,
				minLength:0,
				selectOnFocus:true,
				width:'50%',
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:70 // ancho de columna en el gris
			},
			tipo:'TextField',
			filtro_0:false,
			filtro_1:false,
			save_as:'txt_nivel_convertido'

		};
		vectorAtributos[17] = paramNivelConvertido;

		/////////// txt nomnreid1 //////
		var paramNombreId1={
			validacion:{
				name:'nombre_id1',
				fieldLabel:'Nombre ID1',
				allowBlank:true,
				maxLength:1,
				minLength:0,
				selectOnFocus:true,
				width:'50%',
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:150 // ancho de columna en el gris
			},
			tipo:'TextField',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'nombre_id1',
			save_as:'txt_nombre_id1'
		};
		vectorAtributos[18] = paramNombreId1;

		/////////// txt nomnreid2 //////
		var paramNombreId2={
			validacion:{
				name:'nombre_id2',
				fieldLabel:'Nombre ID2',
				allowBlank:true,
				maxLength:1,
				minLength:0,
				selectOnFocus:true,
				width:'50%',
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:150 // ancho de columna en el gris
			},
			tipo:'TextField',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'nombre_id2',
			save_as:'txt_nombre_id2'
		};
		vectorAtributos[19] = paramNombreId2;

		/////////// txt nomnreid3 //////
		var paramNombreId3={
			validacion:{
				name:'nombre_id3',
				fieldLabel:'Nombre ID3',
				allowBlank:true,
				maxLength:1,
				minLength:0,
				selectOnFocus:true,
				width:'50%',
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:150 // ancho de columna en el gris
			},
			tipo:'TextField',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'nombre_id3',
			save_as:'txt_nombre_id3'
		};
		vectorAtributos[20] = paramNombreId3;

		/////////// txt nombre_supg //////
		var paramSuperG={
			validacion:{
				name:'nombre_supg',
				fieldLabel:'Nombre SuperGrupo',
				allowBlank:true,
				maxLength:1,
				minLength:0,
				selectOnFocus:true,
				width:'50%',
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:150 // ancho de columna en el gris
			},
			tipo:'TextField',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'nombre_supg',
			save_as:'txt_nombre_supg'
		};
		vectorAtributos[21] = paramSuperG;
		////////// txt nombre_grupo
		var paramGrupo={
			validacion:{
				name:'nombre_grupo',
				fieldLabel:'Nombre Grupo',
				allowBlank:true,
				maxLength:1,
				minLength:0,
				selectOnFocus:true,
				width:'50%',
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:150 // ancho de columna en el gris
			},
			tipo:'TextField',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'nombre_grupo',
			save_as:'txt_nombre_grupo'
		};
		vectorAtributos[22] = paramGrupo;

		/////////// txt nombre subgrupo
		var paramSubGrupo={
			validacion:{
				name:'nombre_subg',
				fieldLabel:'Nombre SubGrupo',
				allowBlank:true,
				maxLength:1,
				minLength:0,
				selectOnFocus:true,
				width:'50%',
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:150 // ancho de columna en el gris
			},
			tipo:'TextField',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'nombre_subg',
			save_as:'txt_nombre_subg'
		};
		vectorAtributos[23] = paramSubGrupo;
		//////////////////txt nombre_unidda_medida
		var paramNombreUniBas={
			validacion:{
				name:'nombre_unid_base',
				fieldLabel:'Nombre Unidad Base',
				allowBlank:true,
				maxLength:1,
				minLength:0,
				selectOnFocus:true,
				width:'50%',
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:150 // ancho de columna en el gris
			},
			tipo:'TextField',
			filtro_0:false,
			filtro_1:false,
			save_as:'txt_nombre_unid_base'
		};
		vectorAtributos[24] = paramNombreUniBas;
	
	
		/////txt total
		var paramTotal={
			validacion:{
				name:'total',
				fieldLabel:'Total',
				allowBlank:true,
				maxLength:1,
				minLength:0,
				selectOnFocus:true,
				width:'50%',
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:75 // ancho de columna en el gris
			},
			tipo:'TextField',
			filtro_0:false,
			filtro_1:false,
			save_as:'txt_total'
		};
		vectorAtributos[25] = paramTotal;
		
		/////id _almacen 

		var paramId_Almacen_ep = {
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name:'id_almacen_ep',
				inputType:'hidden',
				grid_visible:false, // se muestra en el grid
				grid_editable:false //es editable en el grid
			},
			tipo:'Field',
			filtro_0:false,
			save_as:'m_id_almacen_ep'
		};

		vectorAtributos[26]=paramId_Almacen_ep;
		
		
		
		

		// fin de definicion de daatos
		//----------- FUNCIONES RENDER

		function formatDate(value){
			return value ? value.dateFormat('d/m/Y') : '';
		};

		//////////////////////////////////////////////////////////////
		//---------         INICIAMOS LAYOUT MAESTRO     -----------//
		//////////////////////////////////////////////////////////////
		//Inicia Layout
		var config = {
			titulo_maestro:'Existencias Ep',
			grid_maestro:'grid-'+idContenedor
		};
		layout_existencia_ep=new DocsLayoutMaestro(idContenedor);
		layout_existencia_ep.init(config);




		//---------- INICIAMOS HERENCIA
		this.pagina = Pagina;
		this.pagina(paramConfig,vectorAtributos,ds,layout_existencia_ep,idContenedor);
		var getSelectionModel=this.getSelectionModel;
		var ClaseMadre_getComponente=this.getComponente;
		var ClaseMadre_conexionFailure=this.conexionFailure;
		var ClaseMadre_btnNew=this.btnNew;
		var ClaseMadre_onResize=this.onResize;
		var ClaseMadre_SaveAndOther=this.SaveAndOther;
		//-------- DEFINICIÓN DE LA BARRA DE MENÚ


		var paramMenu={
			//guardar:{crear:false,separador:false},
			//nuevo:{crear:false,separador:true},
			//editar:{crear:false,separador:false},
			//eliminar:{crear:false,separador:false},
			actualizar:{crear:true,separador:false}
		};



		//--------- DEFINICIÓN DE FUNCIONES
		//aquí se parametrizan las funciones que se ejecutan en la clase madre

		//datos necesarios para el filtro
		var paramFunciones={
			//btnEliminar:{url:direccion+'../../../control/kardex_logico/ActionEliminarKardexLogico.php',parametros:'&m_id_almacen_logico='+maestro.id_almacen_logico},
			//Save:{url:direccion+'../../../control/kardex_logico/ActionGuardarKardexLogico.php',parametros:'&m_id_almacen_logico='+maestro.id_almacen_logico},
			//ConfirmSave:{url:direccion+'../../../control/kardex_logico/ActionGuardarKardexLogico.php',parametros:'&m_id_almacen_logico='+maestro.id_almacen_logico},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,
			width:480,


			minWidth:150,minHeight:200,closable:true,titulo: 'Existencia Ep'}
		}

		//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
		function existencias()
		{
			
			var marcas="<div class='x-dlg-hd'>Existencias EP</div>";
			var otro = 'id_ven_'+idContenedor;
			var div_dlgAlarmas=Ext.DomHelper.append(document.body,{tag:'div',id:otro,html:marcas});

			var div_center=Ext.DomHelper.append(otro,{tag:'div',id:'centro'+idContenedor,class:'x-dlg-bd'});
			dlgAlarmas = new Ext.LayoutDialog(div_dlgAlarmas, {
				fittoframe:true,
				modal: true,
				autoTabs: true,
				resizable:false,
				width: 540,
				height: 330,
				shadow: false,
				fixedCenter:true,
				constraIntoviewport: true,
				draggable: true,
				proxyDrag: true,
				closable: true,
				center: {
					split: false,
					titlebar: false,
					autoScroll: true
				}

			});
			ext_formFil=Ext.DomHelper.append(document.body,{tag:'div',html:"<div align='center' class='x-dlg-bd'><br><div id='extEpformFil-"+config.nombre+"'></div></div>"});
			//ext_formFil=Ext.DomHelper.append(dlgAlarmas,{tag:'div',id:'extformFil-'+config.nombre,class:'x-dlg-bd'});
			//data store
			ds_almacen = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/almacen/ActionListarAlmacenEP.php'}),
				reader: new Ext.data.XmlReader({
				record: 'ROWS',
				id: 'id_almacen',
				totalRecords: 'TotalCount'
				}, ['id_almacen','nombre','descripcion'])
			});

			ds_almacen_logico = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/almacen_logico/ActionListarAlmacenLogicoFisEp.php'}),
				reader: new Ext.data.XmlReader({
				record: 'ROWS',
				id: 'id_almacen_logico',
				totalRecords: 'TotalCount'
				}, ['id_almacen_logico','nombre','descripcion','desc_tipo_almacen'])
			});
			
		//funciones render
		
		function render_id_almacen(value, p, record){return String.format('{0}', record.data['desc_almacen']);}
		function render_id_almacen_logico(value, p, record){return String.format('{0}', record.data['desc_almacen_logico']);}
		
		
	// hidden_id_financiador
			
		
	cmb_ep = new Ext.form.epField({
				fieldLabel: 'Estructura Programática',
				allowBlank: false,
				vtype:"texto",
				emptyText:'Estructura Programática',
				name: 'id_ep',     //indica la columna del store principal "ds" del que proviane el id
				minChars: 1,
				triggerAction: 'all',
				width:350
	});
	
			
	cmb_almacen=new Ext.form.ComboBox({
				fieldLabel: 'Almacén Físico',
				allowBlank: false,
				vtype:"texto",
				emptyText:'Almacén...',
				name: 'id_almacen',     //indica la columna del store principal "ds" del que proviane el id
				desc: 'nombre', //indica la columna del store principal "ds" del que proviane la descripcion
				store:ds_almacen,
				valueField: 'id_almacen',
				displayField: 'nombre',
				queryParam: 'filterValue_0',
				filterCol:'nombre',
				//filterCols:fC_actividad,
				//filterValues:fV_actividad,
				typeAhead:false,
				forceSelection : true,
				tpl:new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{codigo}</FONT>','</div>'),
				mode: 'remote',
				queryDelay: 50,
				pageSize: 10,
				width:350,
				resizable: true,
				queryParam: 'filterValue_0',
				minChars: 1,
				triggerAction: 'all',
				editable: true
			});
			
	
			
			var layout = dlgAlarmas.getLayout();
			layout.beginUpdate();
			layout.add('center', new Ext.ContentPanel(ext_formFil));
			
			var formFil=new Ext.form.Form({labelWidth:90});
			formFil.add(cmb_ep,cmb_almacen);
		    formFil.render('extEpformFil-'+config.nombre);
    		
    		
			dlgAlarmas.addKeyListener(27, dlgAlarmas.hide, dlgAlarmas); // ESC can also close the dialog
			dlgAlarmas.addButton('Ver', btn_ver_almacen_ep, dlgAlarmas);
			
			
			
			layout.endUpdate();
			dlgAlarmas.show();

			function formatDate(value){
				var dat=value?value.dateFormat('d/m/Y'):'';
				return dat
			};
			var onEpSelect = function(e){
					var ep=cmb_ep.getValue();
					data_ep='id_financiador='+ep['id_financiador']+'&id_regional='+ep['id_regional']+'&id_programa='+ep['id_programa']+'&id_proyecto='+ep['id_proyecto']+'&id_actividad='+ep['id_actividad'];
					actualizar_ds_almacen();
					cmb_almacen.modificado=true;
					get_id_ep();
					};
			var onFisicoSelect = function(e) {
					var id_almacen = cmb_almacen.getValue();
					if(id_almacen=='') id_almacen='x';
					data_id =  id_almacen;
					aux=1;
					var ep=cmb_ep.getValue();
					data_ep='id_financiador='+ep['id_financiador']+'&id_regional='+ep['id_regional']+'&id_programa='+ep['id_programa']+'&id_proyecto='+ep['id_proyecto']+'&id_actividad='+ep['id_actividad'];
			};
				
			
		    
		cmb_ep.on('change',onEpSelect);
		cmb_almacen.on('select', onFisicoSelect);
		//cmb_almacen.on('change', onFisicoSelect);
				
		}
		function actualizar_ds_almacen()
			{	//actualiza el data store de motivo ingreo en función de la EP seleccionada
				cmb_almacen.store.proxy = new Ext.data.HttpProxy({url: direccion+'../../../control/almacen/ActionListarAlmacenEP.php?'+data_ep});
				
			}
			
			
		function get_id_ep(){
			var ep=cmb_ep.getValue();
			var data ="id_financiador="+ep['id_financiador']+"&id_regional="+ep['id_regional']+"&id_programa="+ep['id_programa']+"&id_proyecto="+ep['id_proyecto']+"&id_actividad="+ep['id_actividad'];
				Ext.Ajax.request({url:direccion+"../../../../lib/lib_control/action/ActionObtenerIdEp.php",
				params:data,
				method:'GET',
				success:cargar_id_ep, 
				failure:ClaseMadre_conexionFailure,
				timeout:100000});
		}
		function cargar_id_ep(resp){
			if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
				var root = resp.responseXML.documentElement;
				id_ep1= root.getElementsByTagName('id_ep')[0].firstChild.nodeValue;
				
			}
		}
		
		
		
		
		///////////funcion boton
		function btn_ver_almacen_ep(){
			if(aux=1){
				
				//data_id=SelectionsRecord.data.id_ep;
				ds.lastOptions.params.m_id_ep=data_id;
				ds.lastOptions.params.id_ep= id_ep1;
				ds.load(ds.lastOptions);
				dlgAlarmas.hide();
				
				
				}
			else
			{
				Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
			}
		}
	

		function btn_existencia_ep(){
			dlgAlarmas.show();
		}

		/////////////////////
		//Para manejo de eventos
		function iniciarEventosFormularios()
		{
			//para iniciar eventos en el formulario
		}

		//para que los hijos puedan ajustarse al tamaño
		this.getLayout=function(){
			return layout_existencia_ep.getLayout();
		};




		//para el manejo de hijos
		this.getPagina=function(idContenedorHijo){
			var tam_elementos=elementos.length;
			for(i=0;i<tam_elementos;i++){
				if(elementos[i].idContenedor==idContenedorHijo){
					return elementos[i];
				}
			}
		};
		this.getElementos=function(){return elementos;};
		this.setPagina=function(elemento){elementos.push(elemento);};
		this.Init(); //iniciamos la clase madre
		//

		//
		this.InitBarraMenu(paramMenu);
		this.InitFunciones(paramFunciones);
		this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','',btn_existencia_ep,true,'existencia','Seleccionar Estructura Programática');

		//para agregar botones

		this.iniciaFormulario();
		iniciarEventosFormularios();
		existencias();
		
		layout_existencia_ep.getLayout().addListener('layout',this.onResize);
		ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}