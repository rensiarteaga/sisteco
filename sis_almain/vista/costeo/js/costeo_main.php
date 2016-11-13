<?php
session_start();
?>

var item;
//<script>
function main(){
	 <?php
		// obtenemos la ruta absoluta
		$host = $_SERVER['HTTP_HOST'];
		$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$dir = "http://$host$uri/";
		echo "\nvar direccion=\"$dir\";";
		echo "var idContenedor='$idContenedor';";
		echo "var cos_estado='$cos_estado';";
		?>
	//
	var fa;
	<?php
	if ($_SESSION["ss_filtro_avanzado"] != '') {
		echo 'fa=' . $_SESSION["ss_filtro_avanzado"] . ';';
	}
	?>
var fa=false;	
var paramConfig={TamanoPagina:20,TiempoEspera:100000000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};

var maestro={
				id_mov_proy:<?php echo $m_id_mov_proy;?>,
				id_almacen:'<?php echo $m_id_almacen;?>'
		};
				
idContenedorPadre='<?php echo $idContenedorPadre;?>';
	
//var elemento={pagina:new PaginaCosteo(idContenedor,direccion,paramConfig,maestro,cos_estado,idContenedorPadre)};
var elemento={idContenedor:idContenedor,pagina:new PaginaCosteo(idContenedor,direccion,paramConfig,maestro,cos_estado,idContenedorPadre)};
ContenedorPrincipal.setPagina(elemento);
//_CP.setPagina(elemento);
}
Ext.onReady(main,main); 

/**
* Nombre:		  	    costeo.js
* PropÃ³sito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creaciÃ³n:		05-05-2015
*/
function PaginaCosteo(idContenedor,direccion,paramConfig,maestro,cos_estado,idContenedorPadre) 
{
	var vectorAtributos=new Array;
	var componentes=new Array();
	var idAlmacen;
	var ds;
	var sw=0;
	
	var combo_solicitante,combo_proveedor,combo_contratista,combo_empleado;
	var combo_institucion,combo_motivo_ingreso,combo_motivo_ingreso_cuenta,cmb_ep;
	var txt_importacion,txt_flete,txt_seguro,txt_gastos_alm,txt_gastos_aduana,txt_iva,txt_rep_form,txt_peso_neto;
	var txt_tot_import,txt_tot_nacionaliz,txt_codigo_mot_ing;

	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/costeo/ActionListarCosteo.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_costeo',
			totalRecords: 'TotalCount'

		}, [
		    'id_costeo',
		    {name: 'fecha_ingreso',type:'date',dateFormat:'d-m-Y'},
		    {name: 'fecha_salida',type:'date',dateFormat:'d-m-Y'},
		    'estado','descripcion',
		    'usuario_reg','fecha_reg','id_movimiento_proyecto','desc_mov_proy','tipo_costeo' 
		]),remoteSort:true
	});
			
	
		
	var ds_proyecto= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_almain/control/movimiento_proyecto/ActionListarMovimientoProyecto.php?filtro_costeo=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_movimiento_proyecto',totalRecords: 'TotalCount'},['id_movimiento_proyecto','origen_ingreso','concepto_ingreso','estado','codigo','desc_contratista','desc_proveedor','desc_institucion','desc_empleado'])
	});
	function render_proyecto(value, p, record){return String.format('{0}', record.data['desc_mov_proy']);}
	var tpl_proyecto=new Ext.Template('<div class="search-item">','{codigo}<br>','<FONT COLOR="#B5A642">Concepto:{concepto_ingreso}</FONT>',
			'<br><FONT  SIZE="1" COLOR="#B5A642">Origen :{origen_ingreso}</FONT>',
			'<br><FONT  SIZE="1" COLOR="#B5A642">{desc_contratista}{desc_proveedor}{desc_institucion}{desc_empleado}</FONT>'
			,'</div>');
	
	
	// funciones render
	function renderTipoCosteo(component, value, record) {
		var tipo_costeo;
		if (record.data['tipo_costeo'] == 'peso') {
			tipo_costeo = 'Peso';
		} else if(record.data['tipo_costeo'] == 'precio_unitario')
		{
			tipo_costeo = 'Precio Unitario';
		}
		else
			tipo_costeo = '';
		return String.format('{0}', tipo_costeo);
	}
	
		
	/////////////////////////
	// DefiniciÃ³n de datos //
	/////////////////////////
	vectorAtributos = [
	                   
		{
			validacion : {
				labelSeparator : '',
				name : 'id_costeo',
				inputType : 'hidden',
				grid_visible : false,
				grid_editable : false
			},
			tipo : 'Field',
			filtro_0:false,
			save_as : 'hidden_id_costeo'
		},
		{
			validacion : {
				labelSeparator : '',
				name : 'id_movimiento_proyecto',
				inputType : 'hidden',
				grid_visible : false,
				grid_editable : false
			},
			tipo : 'Field',
			filtro_0 : false,
			save_as : 'h_id_mov_proyecto'
		},
		{
			validacion:{
				fieldLabel: 'Identificador',
				name: 'id_costeo',
				grid_visible:true, // se muestra en el grid
				grid_editable:false,
				align:'center',
				grid_indice:1
			},
			tipo:'Field',
			filtro_0:true,
			filterColValue:'movpr.id_movimiento_proyecto',
			form:false
		},
		/*{
			validacion:{
			fieldLabel: 'Proyecto',
					allowBlank: true,
					vtype:"texto",
					emptyText:'Proyecto...',
					name: 'id_movimiento_proyecto',     //indica la columna del store principal "ds" del que proviane el id
					desc: 'desc_mov_proy', //indica la columna del store principal "ds" del que proviane la descripcion
					store:ds_proyecto,
					valueField: 'id_movimiento_proyecto',
					displayField: 'codigo',//campo del store q se mostrara
					queryParam: 'filterValue_0',
					filterCol:'tram.codigo',
					typeAhead: false,
					forceSelection : true,
					mode: 'remote',
					queryDelay: 50,
					pageSize: 10,
					minListWidth : 300,
					resizable: true,
					queryParam: 'filterValue_0',
					minChars : 1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
					triggerAction: 'all',
					renderer:render_proyecto,
					grid_visible:true, // se muestra en el grid
					grid_editable:false, //es editable en el grid,
					width_grid:260, // ancho de columna en el gris
					width:250,
					tpl: tpl_proyecto
			},
			tipo:'ComboBox',
			filtro_0:true,
			form: true,
			filterColValue:'tram.codigo#tram.descripcion', 
			save_as:'h_id_mov_proyecto'	
		},*/
		{
			validacion:{
				name:'descripcion', 
				fieldLabel:'Descripcion',
				allowBlank:false,
				maxLength:200,
				minLength:0,
				width:'100%',
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:130
			},
			tipo: 'TextArea',
			filtro_0:true,
			filterColValue:'movpr.concepto_ingreso',
			save_as:'txt_descripcion',
			id_grupo:0
		},
		{
			validacion: {
				name:'tipo_costeo',
				fieldLabel:'Tipo Costeo',
				allowBlank:false,
				typeAhead: true,
				loadMask: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['peso','Peso'],['precio_unitario','Precio Unitario']]}),
				valueField:'ID',
				displayField:'valor',
				mode:'local',
				lazyRender:true,
				renderer:renderTipoCosteo,
				forceSelection:true,
				grid_visible:true,
				grid_editable:false,
				width_grid:100
			},
			form:true,
			tipo:'ComboBox',
			defecto:'peso',
			filtro_0:true,
			id_grupo:0,
			save_as:'txt_tipo_costeo',
			filterColValue:'cos.tipo_costeo'
		},
		{
			validacion:{
				name:'fecha_ingreso',
				fieldLabel:'Fecha Ingreso',
				allowBlank:true,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Día no válido',
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width_grid:85,
				disabled:false 
			},
			tipo:'DateField',
			filtro_0:false,
			filterColValue:'cos.fecha_ingreso',
			dateFormat:'m-d-Y',
			defecto:'',
			save_as:'txt_fecha_ingreso',
			id_grupo:0
		},
		{
			validacion:{
				name:'fecha_salida',
				fieldLabel:'Fecha Salida',
				allowBlank:true,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Día no válido',
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width_grid:85,
				disabled:false 
			},
			tipo:'DateField',
			filtro_0:false,
			filterColValue:'cos.fecha_salida',
			dateFormat:'m-d-Y',
			defecto:'',
			save_as:'txt_fecha_salida',
			id_grupo:0
		},
		{
			validacion : {
				name : 'estado',
				fieldLabel : 'Estado',
				align : 'left',
				lazyRender : true,
				grid_visible : true,
				grid_editable : false,
				width_grid : 130
				//renderer : renderEstado

			},
			tipo : 'TextField',
			filtro_0 : true,
			filterColValue : 'cos.estado',
			form : false
		},
		//si se presiona el boton para realizar el costeo del registro -> manda parametro txt_accion
		{
			validacion:{
				labelSeparator:'',
				name: 'txt_accion',
				inputType:'hidden',
				grid_visible:false, // se muestra en el grid
				grid_editable:false //es editable en el grid
			},
			tipo: 'Field'
		}
	    ];

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////
	//Inicia Layout
	var config = {
		titulo_maestro:'Costeo Proyectos',
		grid_maestro:'grid-'+idContenedor,
		urlHijo : '../../../sis_almain/vista/costeo_detalle/costeo_detalle.php'
	};
	layout_costeo=new DocsLayoutMaestroDeatalle(idContenedor);
	layout_costeo.init(config); 

	//layout_costeo =new DocsLayoutMaestro(idContenedor);
	//layout_costeo.init(config);
	
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_costeo,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var cm_getComponente=this.getComponente;
	var cm_conexionFailure = this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_onResize=this.onResize;
	var cm_btnActualizar = this.btnActualizar;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getFormulario=this.getFormulario;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var cm_EnableSelect=this.EnableSelect; 
	var cm_DeselectRow = this.DeselectRow;

	
	/*ds_almacen.on('load', function(store, records, options) {ds_almacen.commitChanges();}, this);
	ds.baseParams.id_almacen = idAlmacen;*/
	
	/*if(estado != '')
	{
			ds.baseParams.estado_movimiento_proy = estado;
	}*/

	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_mov_proy=datos.m_id_mov_proy;
		maestro.id_almacen=datos.m_id_almacen;
			
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_mov_proy:maestro.id_mov_proy
				
			}
		};
		
		//_CP.getPagina(layout_costeo.getIdContentHijo()).pagina.limpiarStore();
		
		this.btnActualizar();
		iniciarEventosFormularios();

		//gridMaestro.getDataSource().removeAll();

		//gridMaestro.getDataSource().loadData([['N� Proceso',maestro.num_proceso],['Codigo',maestro.codigo_proceso],['Observaciones',maestro.lugar_entrega]]);
// 		Atributos[5].defecto=maestro.id_activo_fijo;
// 		paramFunciones.btnEliminar.parametros='&hidden_id_activo_fijo='+maestro.id_activo_fijo;
// 		paramFunciones.Save.parametros='&hidden_id_activo_fijo='+maestro.id_activo_fijo;
// 		paramFunciones.ConfirmSave.parametros='&maestro_id_activo_fijo='+maestro.id_activo_fijo;
// 		this.iniciarEventosFormularios;
// 		this.InitFunciones(paramFunciones);
	};
	
	this.btnNew = function()
	{
		ClaseMadre_btnNew();		
		cm_getComponente('txt_accion').setValue('');
		cm_getComponente('id_movimiento_proyecto').setValue(maestro.id_mov_proy);
	}

	//Sobrecarga del edit, para desplegar el origen del ingreso
	this.btnEdit = function()
	{
		ClaseMadre_btnEdit();
		cm_getComponente('txt_accion').setValue('');
		cm_getComponente('id_movimiento_proyecto').setValue(maestro.id_mov_proy);
	}

	this.EnableSelect = function(selEvent, rowIndex, selectedRow) 
	{
		cm_EnableSelect(selEvent, rowIndex, selectedRow);

		_CP.getPagina(layout_costeo.getIdContentHijo()).pagina.reload(selectedRow.data);
		_CP.getPagina(layout_costeo.getIdContentHijo()).pagina.desbloquearMenu();

		cm_getBoton('corregir_costeo-'+idContenedor).enable();
		if (selectedRow.data.estado != "borrador")
		{
			//cm_getBoton('costeo_items-'+ idContenedor).disable();
			_CP.getPagina(layout_costeo.getIdContentHijo()).pagina.bloquearMenu();
			cm_getBoton('corregir_costeo-'+idContenedor).setText('Corregir Costeo');
			deshabilitaBotonesCosteo();
		}
		else if(selectedRow.data.estado == "borrador")
		{
			//cm_getBoton('costeo_items-'+ idContenedor).enable();
			_CP.getPagina(layout_costeo.getIdContentHijo()).pagina.desbloquearMenu();
			cm_getBoton('corregir_costeo-'+idContenedor).disable();
			habilitaBotonesCosteo()
		}	
	}

	function habilitaBotonesCosteo()
	{
		cm_getBoton('editar-'+idContenedor).enable();
		cm_getBoton('eliminar-'+idContenedor).enable();
		cm_getBoton('costeo_items-'+idContenedor).enable();
	}
	function deshabilitaBotonesCosteo()
	{
		cm_getBoton('editar-'+idContenedor).disable();
		cm_getBoton('eliminar-'+idContenedor).disable();
		cm_getBoton('costeo_items-'+idContenedor).disable();
	}
	
	/*this.DeselectRow = function(n, n1)
	{
		//cm_getBoton('FinalizarEnviarMovimiento-' + idContenedor).disable();
		cm_DeselectRow(n, n1);
		_CP.getPagina(layout_costeo.getIdContentHijo()).pagina.limpiarStore();
		_CP.getPagina(layout_costeo.getIdContentHijo()).pagina.bloquearMenu();
		
	};*/

	var paramMenu={
		nuevo:{crear:true,separador:false},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};

	
	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÃ“N DE FUNCIONES ------------------------- //
	//  aquÃ­ se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	//datos necesarios para el filtro
	var paramFunciones = {
		btnEliminar:{url:direccion+'../../../control/costeo/ActionEliminarCosteo.php'},
		Save:{url:direccion+'../../../control/costeo/ActionGuardarCosteo.php'},
		ConfirmSave:{url:direccion+'../../../control/costeo/ActionGuardarCosteo.php'},
		Formulario:{
					html_apply:'dlgInfo-'+idContenedor,height:'40%',width:'40%',
		columnas:['85%'],
		closable : true,parametros:'sdad',
		grupos:[
				{tituloGrupo:'Costeo de Materiales',columna:0,id_grupo:0}
				],
		minWidth:150,minHeight:200,	closable:true,titulo:' Costeo '}
	}; 
	
	function btn_costeo()
	{
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect==1)
		{
			if(confirm("Esta seguro de costear el registro seleccionado ?"))
			{
				cm_getComponente('txt_accion').setValue('costear');
				
				Ext.MessageBox.show({
					title: 'Procesando...',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Costeando</div>",
					width:300,
					height:200,
					closable:false
				});
				
				Ext.Ajax.request({
					url:direccion+"../../../control/costeo/ActionGuardarCosteo.php",
					method:'POST',
					params:{	cantidad_ids:'1',
								hidden_id_costeo_0:SelectionsRecord.data.id_costeo,
								p_tipo_costeo:SelectionsRecord.data.tipo_costeo, 
								id_mov_proy:maestro.id_mov_proy,
								accion_solicitud:'costear'
							},
					success:esteSuccess,
					failure:cm_conexionFailure,
					timeout:100000000
				});
			} 
		}
		else
		{
			Ext.MessageBox.alert('Atencion', 'Debe seleccionar un solo registro.')
		}
	}
	
	
	function iniciarEventosFormularios()
	{
		
	}
	
	function esteSuccess(resp)
	{
		Ext.MessageBox.hide();
		if(resp.responseXML&&resp.responseXML.documentElement)
		{
			//btn_reporte_movfin()
			cm_btnActualizar();
		}
		else
		{
			cm_conexionFailure();
		}
	}

	function btn_corregir_costeo()
	{
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect==1)
		{
			
				cm_getComponente('txt_accion').setValue('corregir_costeo');
				
				Ext.MessageBox.show({
					title: 'Procesando...',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Costeando</div>",
					width:300,
					height:200,
					closable:false
				});
				
				Ext.Ajax.request({
					url:direccion+"../../../control/costeo/ActionGuardarCosteo.php",
					method:'POST',
					params:{	cantidad_ids:'1',
								hidden_id_costeo_0:SelectionsRecord.data.id_costeo, 
								estado_costeo:SelectionsRecord.data.estado,
								id_mov_proy:maestro.id_mov_proy,
								accion_solicitud:'corregir_costeo'
							},
					success:esteSuccess,
					failure:cm_conexionFailure,
					timeout:100000000
				});
		}
		else
		{
			Ext.MessageBox.alert('Atencion', 'Debe seleccionar un solo registro.')
		}
	}

	this.getLayout=function(){return layout_costeo.getLayout()};
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	var cm_BloquearMenu = this.BloquearMenu;
	var cm_DesbloquearMenu = this.DesbloquearMenu;
	var cm_getBoton = this.getBoton;
	
	 
	
	//cm_BloquearMenu();
	
	//this.AdicionarBotonCombo(cbxSisAlma, 'Almacen');
	
	if(cos_estado =='borrador')
	{
		this.AdicionarBoton('../../../lib/imagenes/book_next.png','Costear',btn_costeo,true,'costeo_items','Costear');

		this.AdicionarBoton('../../../lib/imagenes/det.ico','Corregir',btn_corregir_costeo,true,'corregir_costeo','Corregir Costeo');
	}
 
	iniciarEventosFormularios();

	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_mov_proy:maestro.id_mov_proy
		}
	});
	
	layout_costeo.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}