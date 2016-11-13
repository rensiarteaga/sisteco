/**
* Nombre:		  	    pagina_existencia_fisica.js
* Propósito: 			pagina objeto principal
* Autor:				JOSé Abraham Mita Huanca
* Fecha creación:		2007-10-26 15:20:26
*/
function pagina_existencia_fisica(idContenedor,direccion,paramConfig)
{var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var sw=0;
	var data_id;
	var dlgAlarmas;
	var configuracion_filtro;

	/////////////////
	//  DATA STORE //
	/////////////////

	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/existencia/ActionListarAlmacenVista.php'}),
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
		'nombre_id3',
		'nombre_id2',
		'nombre_id1',
		'nombre_subg',
		'nombre_grupo',
		'nombre_supg',
		'nombre_unid_base',
		'total',
		'id_almacen',
		'nuevo',
		'usado'
		]),remoteSort:true});

		//carga datos XML
		//existencias();

		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_almacen:data_id
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
			save_as:'hidden_id_item'
		};
		vectorAtributos[0] = paramId_Item;
		filterCols_super_grupo=new Array();
		filterValues_super_grupo=new Array();
		filterCols_super_grupo[0]='estado_registro';
		filterValues_super_grupo[0]='activo';
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
			save_as:'hidden_id_supergrupo'
		};

		vectorAtributos[1]=paramId_SuperGrupo;
		filterCols_grupo=new Array();
		filterValues_grupo=new Array();
		filterCols_grupo[0]='supgru.id_supergrupo';
		filterValues_grupo[0]='%';
		filterCols_grupo[1]='g.estado_registro';
		filterValues_grupo[1]='activo';
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
			save_as:'hidden_id_grupo'
		};
		vectorAtributos[2] = paramId_Grupo;
		filterCols_subgrupo=new Array();
		filterValues_subgrupo=new Array();
		filterCols_subgrupo[0]='supgru.id_supergrupo';
		filterValues_subgrupo[0]='%';
		filterCols_subgrupo[1]='g.id_grupo';
		filterValues_subgrupo[1]='%';
		filterCols_subgrupo[2]='sub.estado_registro';
		filterValues_subgrupo[2]='activo';
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
			save_as:'hidden_id_subgrupo'
		};
		vectorAtributos[3] = paramId_SubGrupo;
		filterCols_id1=new Array();
		filterValues_id1=new Array();
		filterCols_id1[0]='supgru.id_supergrupo';
		filterValues_id1[0]='%';
		filterCols_id1[1]='g.id_grupo';
		filterValues_id1[1]='%';
		filterCols_id1[2]='sub.id_subgrupo';
		filterValues_id1[2]='%';
		filterCols_id1[3]='id1.estado_registro';
		filterValues_id1[3]='activo';
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
			save_as:'hidden_id_id1'
		};
		vectorAtributos[4]=paramId_Id1;
		filterCols_id2=new Array();
		filterValues_id2=new Array();
		filterCols_id2[0]='supgru.id_supergrupo';
		filterValues_id2[0]='%';
		filterCols_id2[1]='g.id_grupo';
		filterValues_id2[1]='%';
		filterCols_id2[2]='sub.id_subgrupo';
		filterValues_id2[2]='%';
		filterCols_id2[3]='id1.id_id1';
		filterValues_id2[3]='%';
		filterCols_id2[4]='id2.estado_registro';
		filterValues_id2[4]='activo';
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
			save_as:'hidden_id_id2'
		};
		vectorAtributos[5] = paramId_Id2;
		filterCols_id3=new Array();
		filterValues_id3=new Array();
		filterCols_id3[0]='supgru.id_supergrupo';
		filterValues_id3[0]='%';
		filterCols_id3[1]='g.id_grupo';
		filterValues_id3[1]='%';
		filterCols_id3[2]='sub.id_subgrupo';
		filterValues_id3[2]='%';
		filterCols_id3[3]='id1.id_id1';
		filterValues_id3[3]='%';
		filterCols_id3[4]='id2.id_id2';
		filterValues_id3[4]='%';
		filterCols_id3[5]='id3.estado_registro';
		filterValues_id3[5]='activo';
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
		/////////// txt id almacen //////
		var paramAlmacen={
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name:'id_almacen',
				inputType:'hidden',
				grid_visible:false, // se muestra en el grid
				grid_editable:false //es editable en el grid
			},
			tipo:'Field',
			filtro_0:false,
			save_as:'hidden_id_almacen'
		};
		vectorAtributos[8] = paramAlmacen;
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
		vectorAtributos[15] = paramEstadoReg;
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
				fieldLabel:'Cantidad',
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
		vectorAtributos[11] = paramObservaciones;
		/////////// txt fecha_reg //////
		var paramFechaReg={
			validacion:{
				name:'fecha_reg',
				fieldLabel:'Fecha Registro',
				allowBlank:false,
				grid_visible:false, // se muestra en el grid
				grid_editable:false, //es editable en el grid
				renderer:formatDate,
				width_grid:85, // ancho de columna en el gris
				disabled:true
			},
			tipo:'TextField',
			filtro_0:false,
			filtro_1:false,
			//filterColValue:'fecha_reg',
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
				grid_visible:false, // se muestra en el grid
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
				fieldLabel:'Nombre ID',
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
		vectorAtributos[24] = paramNombreId1;

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
				grid_visible:false, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:150 // ancho de columna en el gris
			},
			tipo:'TextField',
			filtro_0:false,
			filtro_1:false,
			//filterColValue:'nombre_id2',
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
				grid_visible:false, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:150 // ancho de columna en el gris
			},
			tipo:'TextField',
			filtro_0:false,
			filtro_1:false,
			//filterColValue:'nombre_id3',
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
		vectorAtributos[18] = paramNombreUniBas;
		//nuevo		
		var paramNuevo={
			validacion:{
				name:'nuevo',
				fieldLabel:'Nuevos',
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
			save_as:'txt_nuevo'
		};
		vectorAtributos[25] = paramNuevo;
		//usado
		var paramUsado={
			validacion:{
				name:'usado',
				fieldLabel:'Usado',
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
			save_as:'txt_usado'
		};
		vectorAtributos[26] = paramUsado;
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
		vectorAtributos[27] = paramTotal;
		

		
		
		

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
			titulo_maestro:'Almacenes Fisicos',
			grid_maestro:'grid-'+idContenedor
		};
		layout_existencia_fisica=new DocsLayoutMaestro(idContenedor);
		layout_existencia_fisica.init(config);




		//---------- INICIAMOS HERENCIA
		this.pagina = Pagina;
		this.pagina(paramConfig,vectorAtributos,ds,layout_existencia_fisica,idContenedor);
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


			minWidth:150,minHeight:200,closable:true,titulo: 'Existenciaa Físicas'}
		}

		//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

		function existencias()
		{

			var marcas="<div class='x-dlg-hd'>Existencias Fisicas</div>";
			var otro = 'id_ven_'+idContenedor;
			var div_dlgAlarmas=Ext.DomHelper.append(document.body,{tag:'div',id:otro,html:marcas});

			var div_center=Ext.DomHelper.append(otro,{tag:'div',id:'centro'+idContenedor,class:'x-dlg-bd'});
			ds_sec = new Ext.data.Store({
				//Asigna url de donde se cargaran los datos
				proxy: new Ext.data.HttpProxy({url: '../../../sis_almacenes/control/almacen/ActionListarAlmacen.php'}),
				/////////Se define la estructura del XML///////

				reader: new Ext.data.XmlReader({
					record: 'ROWS',
					id:'id_almacen',
					totalRecords: 'TotalCount'

				},[
				// define el mapeo de XML a las etiqutas (campos)
				'id_almacen',
				'codigo',
				'nombre',
				'descripcion',
				'direccion',
				'via_fil_max',
				'via_col_max',
				'bloquear',
				'cerrado',
				'nro_prest_pendientes',
				'nro_ing_no_finalizados',
				'nro_sal_no_finalizados',
				'observaciones',
				{name: 'fecha_ultimo_inventario', type: 'date', dateFormat: 'Y-m-d'},
				{name: 'fecha_reg', type: 'date', dateFormat: 'Y-m-d'},
				'id_regional'
				]),
				remoteSort: false // metodo de ordenacion remoto
			});

			//Carga los datos desde el archivo XML declarado en el Data Store
			ds_sec.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:1
					//filterCol_0:0,
					//filterValues_0:0
				}
			});
			//  COLUMN MODEL

			cm = new Ext.grid.DefaultColumnModel([
			{
				header: "Codigo",
				width: 80,
				dataIndex: 'codigo'

			},

			{
				header: "Almacenes Fisicos",
				width: 150,
				dataIndex: 'nombre'

			},

			{
				header: "Descripción",
				width: 180,
				dataIndex: 'descripcion'

			},
			{
				header: "Fecha de Registro",
				width: 110,
				dataIndex: 'fecha_reg',
				renderer: formatDate
			}
			]);
			cm.defaultSortable = true;
			//cm.resizable = false;
			sm = new Ext.grid.RowSelectionModel({singleSelect:false});

			var div_grid_Alarmas=Ext.DomHelper.append(div_dlgAlarmas,{tag:'div',id:'ext-grid-exis'+idContenedor});

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

			dlgAlarmas.addKeyListener(27, dlgAlarmas.hide, dlgAlarmas); // ESC can also close the dialog
			dlgAlarmas.addButton('Ver', btn_ver_almacen, dlgAlarmas);
			var layout = dlgAlarmas.getLayout();
			layout.beginUpdate();
			layout.add('center', new Ext.ContentPanel('ext-grid-exis'+idContenedor,{fitToFrame:true, closable: false}));
			layout.endUpdate();
			//Se crea un grid editable
			var grid = new Ext.grid.EditorGrid('ext-grid-exis'+idContenedor, {
				ds: ds_sec,
				cm: cm,
				selModel: sm,
				enableColLock:false

			});



			grid.render();
			var gridFoot = grid.getView().getFooterPanel(true);

			// add a paging toolbar to the grid's footer
			var paging = new Ext.PagingToolbar(gridFoot, ds_sec, {
				pageSize:10,
				displayInfo: true,
				displayMsg: 'Registros {0} - {1} de {2}',
				emptyMsg: "No hay Registros"
			});

			InitFiltro(paging);
			dlgAlarmas.show();

			function formatDate(value){
				var dat=value?value.dateFormat('d/m/Y'):'';
				return dat
			};

			///////filtro


			function InitFiltro(Barra)
			{
				configuracion_filtro = new Array();
				configuracion_filtro = {
					nombre: 'Existencia Fisica', //nombre del componente se utiliza para genera los sub nombres para los componentes
					url:'../../../sis_almacenes/control/almacen/ActionListarAlmacen.php', //direccion para generar el STORE
					title:'Existencia Fisica',   //titulo que va en el GRID
					datos: [
					{
						header: "Codigo",
						dataIndex: 'codigo',
						filterColValue: "ALMACE.codigo"

					},
					{
						header: "Nombre",
						dataIndex: 'nombre',
						filterColValue: "ALMACE.nombre"

					},

					{
						header: "Descripción",
						dataIndex: 'descripcion',
						filterColValue: "ALMACE.descripcion"

					},
					{
						header: "Fecha de Registro",
						dataIndex: 'fecha_reg',
						filterColValue: "ALMACE.fecha_reg",
					}
					],
					pageSize: 10
				};

				Barra.addSeparator();
				var quickMenuItems = new Array('<b class="menu-title">Filtrar Por</b>');
				// llena los elementos en el combo
				//var atributosLov = configuracion.datos.length;
				var atributosLov = 4;
				for(var j = 0; j < atributosLov ; j ++)
				{

					//cambio para filtrar por un valor diferente al nombre de columna
					value = configuracion_filtro.datos[j].dataIndex;
					if(configuracion_filtro.datos[j].filterColValue!==undefined){
						value=configuracion_filtro.datos[j].filterColValue;
					}

					text=configuracion_filtro.datos[j].header;
					if(j==0){
						quickMenuItems.push(new Ext.menu.CheckItem({value:value,text:text,checked:true}));
					}
					else{
						quickMenuItems.push(new Ext.menu.CheckItem({value:value,text:text,checked:false}));
					}
				}
				var quickMenu = new Ext.menu.Menu({
					id: 'quickMenu_'+configuracion_filtro.nombre,
					items: quickMenuItems
				});
				Barra.add({
					text: 'Filtro',
					tooltip: 'Columnas por las que se filtra',
					icon: '../../../lib/images/m.png',
					cls: 'x-btn-text-icon btn-search-icon',
					menu: quickMenu
				});
				var sftb = Barra.addDom({
					tag: 'input',
					id: 'quicksearch_'+configuracion_filtro.nombre,
					type: 'text',
					size: 15,
					value: '',
					style: 'background: #F0F0F9;'
				});

				var searchBox = new Ext.form.Field({
					//hideTrigger: true,
					//hideClearButton:true,
					//hideClearButton: true,
					emptyText: "Type to quicksearch"
					//rememberOn: 'all'
					//rememberOn: 'delay'
				});
				searchBox.applyTo('quicksearch_'+configuracion_filtro.nombre);

				var onFilteringBeforeQuery = function(e) {



					var sw = true; //primera vez que entra al for
					var filterCol ="";
					var cuentaCol = 0;
					for (var p=0,items=quickMenuItems,len=items.length; p<len; p++)
					{
						if (items[p].checked)
						{
							cuentaCol ++;
							if(sw)
							{
								filterCol = items[p].value;
								sw = false;
							}
							else
							{
								filterCol = filterCol+"#"+items[p].value;
							}

						}

					}
					if(cuentaCol===0){
						searchBox.setValue("");
						searchBox.disable();
					}
					else{
						searchBox.enable();
					}
					var value=searchBox.getValue();
					ds_sec.lastOptions.params["filterCol_0"]=filterCol;
					ds_sec.lastOptions.params.start = 0;
					ds_sec.lastOptions.params["filterValue_0"]=value;
					ds_sec.load(ds_sec.lastOptions);
				};
				quickMenu.on('click', onFilteringBeforeQuery);
				//searchBox.on("specialkey", onFilteringBeforeQuery);
				searchBox.el.on('keyup', onFilteringBeforeQuery,  searchBox);
			}
			///////fin filtro
		}
		
		
		
		///////////funcion boton
		function btn_ver_almacen(){
			//var getSelectionModel=this.getSelectionModel;
			var filas=ds_sec.getModifiedRecords();
			var cont=filas.length;
			var NumSelect=sm.getCount();


			if(NumSelect!=0){
				var SelectionsRecord=sm.getSelected();
				data_id=SelectionsRecord.data.id_almacen;
				ds.lastOptions.params.m_id_almacen=data_id;
				ds.load(ds.lastOptions);
				dlgAlarmas.hide();
				}
			else
			{
				Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
			}
		}


		function btn_existencia_fisicas(){
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
			return layout_existencia_fisica.getLayout();
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
		this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','',btn_existencia_fisicas,true,'existencia','Seleccionar Almacén Físico');

		//para agregar botones

		this.iniciaFormulario();
		iniciarEventosFormularios();
		existencias();
		layout_existencia_fisica.getLayout().addListener('layout',this.onResize);
		ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}