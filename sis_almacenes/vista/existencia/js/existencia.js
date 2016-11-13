/**
* Nombre:		  	    pagina_kardex_logico_det.js
* Propósito: 			pagina objeto principal
* Autor:				JOSé Abraham Mita Huanca
* Fecha creación:		2007-10-26 15:20:26
*/
function pagina_existencia(idContenedor,direccion,paramConfig)
{


	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var sw=0;
	var data_id;
	var data_ep;
	var dlgAlarmas;
	var configuracion_filtro;
	var aux;

	/////////////////
	//  DATA STORE //
	/////////////////

	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/kardex_logico/ActionListarAlmacenLogicoID.php'}),
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
		'nuevo',
		'usado',
		'id_almacen_logico'


		]),remoteSort:true});

		//carga datos XML
		//existencias();

		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_almacen_logico:data_id
			}
		};



		//FUNCIONES RENDER

		function render_id_item(value, p, record){return String.format('{0}', record.data['desc_item']);};
		function render_id_almacen_logico(value, p, record){return String.format('{0}', record.data['desc_almacen_logico']);};
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
		//////txt nuevo
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
		//////txt usado
		var paramUsado={
			validacion:{
				name:'usado',
				fieldLabel:'Usados',
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
		/////id _almacen logico

		var paramId_AlmacenLogico = {
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name:'id_almacen_logico',
				inputType:'hidden',
				grid_visible:false, // se muestra en el grid
				grid_editable:false //es editable en el grid
			},
			tipo:'Field',
			filtro_0:false,
			save_as:'m_id_almacen_logico'
		};

		vectorAtributos[28]=paramId_AlmacenLogico;

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
			titulo_maestro:'Almacenes Lógicos',
			grid_maestro:'grid-'+idContenedor
		};
		layout_existencia=new DocsLayoutMaestro(idContenedor);
		layout_existencia.init(config);




		//---------- INICIAMOS HERENCIA
		this.pagina = Pagina;
		this.pagina(paramConfig,vectorAtributos,ds,layout_existencia,idContenedor);
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


			minWidth:150,minHeight:200,closable:true,titulo: 'Existencia'}
		}

		//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

		function existencias()
		{

			var marcas="<div class='x-dlg-hd'>Existencias Lógicas</div>";
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
			ext_formFil=Ext.DomHelper.append(document.body,{tag:'div',html:"<div align='center' class='x-dlg-bd'><br><div id='extformFil-"+config.nombre+"'></div></div>"});
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
				fieldLabel: 'EP',
				allowBlank: false,
				vtype:"texto",
				emptyText:'Estructura Programática',
				name: 'id_ep',     //indica la columna del store principal "ds" del que proviane el id
				minChars: 1,
				triggerAction: 'all',
				width:350
	});
	
			
	cmb_almacen=new Ext.form.ComboBox({
				fieldLabel: 'Almacen Fisico',
				allowBlank: false,
				vtype:"texto",
				emptyText:'Almacen...',
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
			
	cmb_almacen_ep=new Ext.form.ComboBox({
				fieldLabel: 'Almacen Logico',
				allowBlank: false,
				vtype:"texto",
				emptyText:'Almacen Logico...',
				name: 'id_almacen_ep',     //indica la columna del store principal "ds" del que proviane el id
				desc: 'nombre', //indica la columna del store principal "ds" del que proviane la descripcion
				store:ds_almacen_logico ,
				valueField: 'id_almacen_logico',
				displayField: 'nombre',
				queryParam: 'filterValue_0',
				filterCol:'nombre',
				//filterCols:fC_actividad,
				//filterValues:fV_actividad,
				typeAhead:false,
				forceSelection : true,
				tpl:new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>'),
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
			formFil.add(cmb_ep,cmb_almacen, cmb_almacen_ep);
		    formFil.render('extformFil-'+config.nombre);
    		
    		
			dlgAlarmas.addKeyListener(27, dlgAlarmas.hide, dlgAlarmas); // ESC can also close the dialog
			dlgAlarmas.addButton('Ver', btn_ver_kardex, dlgAlarmas);
			
			
			
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
					cmb_almacen_ep.modificado=true;
					cmb_almacen.setValue('');
					cmb_almacen_ep.setValue('');
					};
			var onFisicoSelect = function(e) {
					var id = cmb_almacen.getValue();
 					if(id=='') id='x';
					cmb_almacen_ep.modificado = true;
					cmb_almacen_ep.setValue('');
					actualizar_ds_almacenEp();
					
				};
				
			var onLogicoSelect = function(e) {
					var id_ep = cmb_almacen_ep.getValue();
					if(id_ep=='') id_ep='x';
					data_id =  id_ep;
					aux=1;
					
					
				};

		    
		cmb_ep.on('change',onEpSelect);
		cmb_almacen.on('select', onFisicoSelect);
		//cmb_almacen.on('change', onFisicoSelect);
		cmb_almacen_ep.on('select', onLogicoSelect);
		//cmb_almacen_ep.on('change', onLogicoSelect);
		
		
		}
		
		function actualizar_ds_almacen()
			{	//actualiza el data store de motivo ingreo en función de la EP seleccionada
				cmb_almacen.store.proxy = new Ext.data.HttpProxy({url: direccion+'../../../control/almacen/ActionListarAlmacenEP.php?'+data_ep});
				
			}
		function actualizar_ds_almacenEp()
			{						
				cmb_almacen_ep.store.proxy = new Ext.data.HttpProxy({url: direccion+'../../../control/almacen_logico/ActionListarAlmacenLogicoFisEP.php?'+data_ep});
			}
		///////////funcion boton
				
		
		
		function btn_ver_kardex(){
			//var getSelectionModel=this.getSelectionModel;
			
			//alert(data_id);
			if(aux=1){
				
				//data_id=SelectionsRecord.data.id_ep;
				//ds.lastOptions.params.m_id_ep=data_id;
				ds.lastOptions.params.m_id_almacen_logico=data_id;
				ds.load(ds.lastOptions);
				dlgAlarmas.hide();
				
				}
			else
			{
				Ext.MessageBox.alert('Estado', 'Antes debe seleccionar todos los Almacenes.');
			}
		}


		function btn_existencia(){
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
			return layout_existencia.getLayout();
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
		this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','',btn_existencia,true,'existencia','Seleccionar Almacen Lógico');

		//para agregar botones

		this.iniciaFormulario();
		iniciarEventosFormularios();
		existencias();
		layout_existencia.getLayout().addListener('layout',this.onResize);
		ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}