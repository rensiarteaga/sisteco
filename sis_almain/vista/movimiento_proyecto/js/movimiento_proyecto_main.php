<?php
session_start();
?>
var movimiento;
//<script>
function main(){
	 <?php
		// obtenemos la ruta absoluta
		$host = $_SERVER['HTTP_HOST'];
		$uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$dir = "http://$host$uri/";
		echo "\nvar direccion=\"$dir\";";
		echo "var idContenedor='$idContenedor';";
		echo "var mov_estado='$mov_estado';";
		?>
	
var fa=false;
<?php if ($_SESSION["ss_filtro_avanzado"] != '') {	echo 'fa=' . $_SESSION["ss_filtro_avanzado"] . ';';}?>

var paramConfig={TamanoPagina:20,TiempoEspera:100000000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var elemento={pagina:new PaginaMovimientoProyecto(idContenedor,direccion,paramConfig,mov_estado),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main); 


/**
* Nombre:		  	    pagina_ingreso_proyecto.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		23-10-2014
*/
function PaginaMovimientoProyecto(idContenedor,direccion,paramConfig,mov_estado)
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
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/movimiento_proyecto/ActionListarMovimientoProyecto.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_movimiento_proyecto',
			totalRecords: 'TotalCount'

		}, [
		    'id_movimiento_proyecto','id_almacen'
		    ,'desc_almacen','id_tipo_movimiento','tipo','id_documento','id_contratista','desc_contratista'
		    ,'id_proveedor','desc_proveedor','id_institucion','desc_institucion','id_empleado','desc_empleado'
		    ,{name: 'fecha_ingreso',type:'date',dateFormat:'d-m-Y'}
		    ,'origen_ingreso','concepto_ingreso','observaciones','nro_contrato','nota_remision','entregado_por' 
		    ,'estado','usuario_reg',
		    {
				name : 'fecha_reg',
				type : 'date',
				dateFormat : 'd-m-Y'
			}	, 'peso_neto','codigo'
		]),remoteSort:true
	});
	
	ds.lastOptions = {
			params : {
				start : 0,
				limit : paramConfig.TamanoPagina,
				CantFiltros : paramConfig.CantFiltros
			}
		};

	
		var ds_almacen = new Ext.data.Store({
			proxy : new Ext.data.HttpProxy({
			url : direccion + '../../../control/almacen/ActionListarAlmacen.php'}),
			reader : new Ext.data.XmlReader
			({
				record : 'ROWS',
				id : 'id_almacen',
				totalRecords : 'TotalCount'
			}, [ 'id_almacen', 'codigo', 'nombre' ]) 
		});

		
		//ds_almacen
		function render_almacen(value, p, record){return String.format('{0}', record.data['desc_almacen']);}
		var tpl_almacen=new Ext.Template('<div class="search-item">','{nombre}<br>','<FONT COLOR="#B5A642">{codigo} - </FONT>','<FONT COLOR="#B5A642">{direccion}</FONT>','</div>');
		
	
		var TaskLocation = Ext.data.Record.create([ {
			name : "id_almacen"
		}, {
			name : "codigo"
		}, {
			name : "nombre"
		} ]); 
		
		var cbxSisAlma = new Ext.form.ComboBox({
			store : ds_almacen,
			fieldLabel : 'Almacen',
			displayField : 'nombre',
			typeAhead : true,
			loadMask : true,
			mode : 'remote',
			triggerAction : 'all',
			emptyText : 'Almacen...',
			selectOnFocus : true,
			queryParam : 'filterValue_0',
			filterCol : 'al.nombre',
			width : 180,
			valueField : 'id_almacen',
		});
		
		cbxSisAlma.on('select', function(combo, record, index) {
			cm_DesbloquearMenu();
			idAlmacen = cbxSisAlma.getValue();
			ds.baseParams.id_almacen = idAlmacen;
			cm_btnActualizar();
			combo.modificado = true;
		});
		
	//DATA STORE COMBOS
	var ds_proveedor = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_adquisiciones/control/proveedor/ActionListarProveedor.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_proveedor',totalRecords: 'TotalCount'}, ['id_proveedor','codigo','observaciones','fecha_reg','id_institucion','id_persona','desc_persona','nombre_proveedor'])});
	var ds_contratista = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/contratista/ActionListarContratista.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_contratista',totalRecords: 'TotalCount'}, ['id_contratista','codigo','observaciones','estado_registro','fecha_reg','id_institucion','id_persona','nombre_contratista','pagina_web','email','direccion'])});

	var ds_empleado = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado/ActionListarEmpleadoEP.php'}),
	reader: new Ext.data.XmlReader({
		record: 'ROWS',
		id: 'id_empleado',
		totalRecords: 'TotalCount'
	}, ['id_empleado','id_persona','codigo_empleado','desc_persona'])});

	var ds_institucion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/institucion/ActionListarInstitucion.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_institucion',totalRecords: 'TotalCount'}, ['id_institucion','direccion','doc_id','nombre','casilla','telefono1','telefono2','celular1','celular2','fax','email1','email2','pag_web','observaciones','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','estado_institucion','id_persona'])});
	
	function render_id_proveedor(value, p, record){return String.format('{0}', record.data['desc_proveedor']);}
	function render_id_contratista(value, p, record){return String.format('{0}', record.data['desc_contratista']);}
	function render_id_empleado(value, p, record){return String.format('{0}', record.data['desc_empleado']);}
	function render_id_institucion(value, p, record){return String.format('{0}', record.data['desc_institucion']);}
	
    function render_observaciones(value, p, record){return String.format('<b><font color="#FF0000">{0}</font></b>', record.data['observaciones'])}
	//TEMPLATE COMBOS
	
	var resultTplProveedor = new Ext.Template('<div class="search-item">','<b>{codigo}</b>','<br><FONT COLOR="#B5A642">{nombre_proveedor}</FONT>','</div>');
	var resultTplContratista = new Ext.Template('<div class="search-item">','<b>{nombre_contratista}</b>','<br><FONT COLOR="#B5A642">{codigo}','<br>{email}','<br>{direccion}</FONT>','</div>');
	var resultTplInstitucion = new Ext.Template('<div class="search-item">','<b>{nombre}</b>','<br><FONT COLOR="#B5A642">{email1}','<br>{pag_web}','<br>{direccion}</FONT>','</div>');
	var resultTplEmpleado = new Ext.Template('<div class="search-item">','<b>{codigo_empleado}</b>','<br><FONT COLOR="#B5A642">{desc_persona}</FONT>','</div>');

	/////////////////////////
	// Definición de datos //
	/////////////////////////
	vectorAtributos = [
	                   
		{
			validacion : {
				labelSeparator : '',
				name : 'id_movimiento_proyecto',
				inputType : 'hidden',
				grid_visible : false,
				grid_editable : false
			},
			tipo : 'Field',
			filtro_0:false,
			save_as : 'hidden_id_mov_proy'
		},
		{
			validacion:{
				fieldLabel: 'Identificador',
				name: 'id_movimiento_proyecto',
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
		{
			validacion : {
				name : 'codigo',
				fieldLabel : 'Codigo',
				align : 'center',
				lazyRender : true,
				grid_visible : true,
				grid_editable : false,
				width_grid : 130
				//renderer : renderEstado

			},
			tipo : 'TextField',
			filtro_0 : true,
			filterColValue : 'movpr.codigo',
			form : false
		},
		{
			validacion : {
				labelSeparator : '',
				name : 'id_almacen',
				inputType : 'hidden',
				grid_visible : false,
				grid_editable : false
			},
			tipo : 'Field',
			filtro_0 : false,
			save_as : 'hidden_id_almacen'
		},
		{
			validacion : {
				name : 'id_tipo_movimiento',
				fieldLabel : 'Documento',
				allowBlank : false,
				emptyText : 'Documento...',
				desc : 'tipo',
				store : new Ext.data.Store(
						{
							proxy : new Ext.data.HttpProxy(
									{
										url : direccion
												+ '../../../../sis_almain/control/tipo_movimiento/ActionListarTipoMovimiento.php'
									}),
							reader : new Ext.data.XmlReader({
								record : 'ROWS',
								id : 'id_tipo_movimiento',
								totalRecords : 'TotalCount'
							}, [ 'id_tipo_movimiento',
									'descripcion_documento',
									'codigo_documento','tipo','documento' ])
							,baseParams : {
									//filtro para mostrar solo documentos de proyectos registrados
									filtro_proy:'si'
								}
						}),
				valueField : 'id_tipo_movimiento',
				displayField : 'descripcion_documento',
				queryParam : 'filterValue_0',
				filterCol : 'tip.tipo',
				typeAhead : false,
				forceSelection : true,
				tpl : new Ext.Template('<div class="search-item">',
							'<b><i>{descripcion_documento}</i></b>',
							'<br><FONT COLOR="#B5A642">Codigo: {codigo_documento}</FONT>',
							'<br><FONT COLOR="#B5A642">Tipo: {tipo}</FONT>',
							'</div>'),
				mode : 'remote',
				queryDelay : 250,
				pageSize : 10,
				minListWidth : 380,
				width : 285,
				resizable : false,
				queryParam : 'filterValue_0',
				minChars : 2,
				triggerAction : 'all',
				grid_visible : false,
				grid_editable : false,
				width_grid : 200,
				grid_indice:3,
				CantFiltros : 2
			},
			tipo : 'ComboBox',
			form : true,
			save_as : 'hidden_id_tipo_movimiento',
			id_grupo:1
		},
		{
			validacion:{
				name:'concepto_ingreso', 
				fieldLabel:'Concepto Movimiento',
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
			save_as:'txt_concepto_ingreso',
			id_grupo:1
		},
		{
			validacion:{
				name:'fecha_ingreso',
				fieldLabel:'Fecha Movimiento',
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
			filterColValue:'movpr.fecha_ingreso',
			dateFormat:'m-d-Y',
			defecto:'',
			save_as:'txt_fecha_reg',
			id_grupo:1
		},
		{
			validacion : {
				name : 'estado',
				fieldLabel : 'Estado',
				align : 'center',
				lazyRender : true,
				grid_visible : true,
				grid_editable : false,
				width_grid : 130
				//renderer : renderEstado

			},
			tipo : 'TextField',
			filtro_0 : true,
			filterColValue : 'movpr.estado',
			form : false
		},
		{
			validacion: {
				name:'origen_ingreso',
				fieldLabel:'Origen',
				allowBlank:false,
				typeAhead: true,
				loadMask: true,
				triggerAction: 'all',
				store: new Ext.data.SimpleStore({
					fields: ['ID','valor'],
					data :[
					       	['contratista','Contratista'],
					       	['proveedor','Proveedor'],
					       	['empleado','Funcionario'],
					       	['institucion','Institucion']
						]
				}), 
				mode:'local',
				valueField:'ID',
				displayField:'valor',  
				lazyRender:true,
				forceSelection:true,
				grid_visible:true,
				grid_editable:false,
				width:300,
				width_grid:60 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			filtro_0:true,
			form:true,
			filterColValue:'movpr.origen_ingreso',
			save_as:'txt_origen_ingreso',
			id_grupo:0
		},
		{
			validacion: {
				name:'id_proveedor',
				fieldLabel:'Proveedor',
				allowBlank:true,
				emptyText:'Proveedor...',
				name: 'id_proveedor',
				desc: 'desc_proveedor',
				store:ds_proveedor,
				valueField: 'id_proveedor',
				displayField: 'nombre_proveedor',
				queryParam: 'filterValue_0',
				filterCol:'PROVEE.codigo#PROVEE.observaciones',
				tpl: resultTplProveedor,
				typeAhead:true,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:450,
				grow:true,
				width:300,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1,
				triggerAction:'all',
				editable:true,
				renderer:render_id_proveedor,
				grid_visible:true,
				grid_editable:false,
				width_grid:100, // ancho de columna en el gris
				disabled:false
			},
			tipo:'ComboBox',
			filtro_0:true,
			filterColValue:'prov.codigo',
			defecto: '',
			save_as:'txt_id_proveedor',
			id_grupo:0
		},
		{
			validacion: {
				name:'id_contratista',
				fieldLabel:'Contratista',
				allowBlank:true,
				emptyText:'Contratista...',
				name: 'id_contratista',
				desc: 'desc_contratista',
				store:ds_contratista,
				valueField: 'id_contratista',
				displayField: 'nombre_contratista',
				queryParam: 'filterValue_0',
				filterCol:'CONTRA.codigo#INSTIT.nombre#INSTIT.pag_web#INSTIT.email1#INSTIT.direccion#PERSON.pag_web#INSTIT.email1',
				tpl: resultTplContratista,
				typeAhead:true,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:10,
				minListWidth:450,
				grow:true,
				width:300,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_contratista,
				grid_visible:true,
				grid_editable:false,
				width_grid:100, // ancho de columna en el gris
				disabled:false
			},
			tipo:'ComboBox',
			filtro_0:true,
			filterColValue:'cont.codigo', 
			defecto: '',
			save_as:'txt_id_contratista',
			id_grupo:0
		},
		{
			validacion: {
				name:'id_empleado',
				fieldLabel:'Funcionario',
				allowBlank:true,
				emptyText:'Funcionario...',
				name: 'id_empleado',
				desc: 'desc_empleado',
				store:ds_empleado,
				valueField: 'id_empleado',
				displayField: 'desc_persona',
				queryParam: 'filterValue_0',
				filterCol:'EMPLEA.id_persona#EMPLEA.codigo_empleado#PERSON.nombre#PERSON.apellido_paterno#PERSON.apellido_materno',
				tpl: resultTplEmpleado,
				typeAhead:true,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:10,
				minListWidth:450,
				grow:true,
				width:300,
				//grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1,
				triggerAction:'all',
				editable:true,
				renderer:render_id_empleado,
				grid_visible:true,
				grid_editable:false,
				width_grid:100, // ancho de columna en el gris
				disabled:false
			},
			tipo:'ComboBox',
			filtro_0:true,
			filterColValue:'emp.id_persona',
			defecto: '',
			save_as:'txt_id_empleado',
			id_grupo:0
		},
		{
			validacion: {
				name:'id_institucion',
				fieldLabel:'Institucion',
				allowBlank:true,
				emptyText:'Institucion...',
				name: 'id_institucion',
				desc: 'desc_institucion',
				store:ds_institucion,
				valueField: 'id_institucion',
				displayField: 'nombre',
				queryParam: 'filterValue_0',
				filterCol:'INSTIT.nombre#INSTIT.pag_web#INSTIT.email1#INSTIT.direccion',
				tpl: resultTplInstitucion,
				typeAhead:true,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:10,
				minListWidth:450,
				grow:true,
				width:300,
				//grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1,
				triggerAction:'all',
				editable:true,
				renderer:render_id_institucion,
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				disabled:false
			},
			tipo:'ComboBox',
			filtro_0:true,
			filterColValue:'ins.nombre',
			defecto: '',
			save_as:'txt_id_institucion',
			id_grupo:0
		},
		{
			validacion:{
				name:'observaciones',
				fieldLabel:'Observaciones',
				allowBlank:true,
				maxLength:300,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				disabled:false,
				renderer:render_observaciones,
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%'
			},
			form:true,
			tipo:'TextArea',
			filtro_0:true,
			filterColValue:'movpr.observaciones',
			save_as:'txt_observaciones',
			id_grupo:1
		},
		{
			validacion : {
				name : 'entregado_por',
				fieldLabel : 'Entregado Por',
				align : 'left',
				grid_visible : true,
				grid_editable : false,
				width:300,
				width_grid : 200
			},
			tipo : 'TextField',
			save_as:'txt_entregado_por',
			id_grupo:2
		
		},
		{
			validacion : {
				name : 'nota_remision',
				fieldLabel : 'Nro. Remision',
				align : 'left',
				grid_visible : true,
				grid_editable : false,
				width:300,
				width_grid : 200
			},
			tipo : 'TextField',
			save_as:'txt_nota_remision',
			id_grupo:2
		
		},
		{
			validacion : {
				name : 'nro_contrato',
				fieldLabel : 'Nro. Contrato',
				align : 'left',
				grid_visible : true,
				grid_editable : false,
				width:300,
				width_grid : 200
			},
			tipo : 'TextField',
			save_as:'txt_nro_contrato',
			id_grupo:2
		
		},
		{
			validacion : {
				name : 'peso_neto',
				fieldLabel : 'Peso Neto Kg.',
				allowBlank : true,
				align : 'right',
				allowNegative: false,
				allowDecimals: true,
				minValue : '0',
				decimalPrecision : 2,
				grid_visible : true,
				grid_editable : false,
				width_grid : 80,
				width:250
			},
			tipo : 'NumberField',
			filtro_0 : false,
			filterColValue : 'movpr.peso_neto',
			form : true,
			id_grupo:2,
			save_as : 'txt_peso_neto'			
		},
		{
			validacion : {
				name : 'usuario_reg',
				fieldLabel : 'Responsable Registro',
				align : 'left',
				grid_visible : true,
				grid_editable : false,
				width_grid : 200
			},
			tipo : 'TextField',
			filtro_0 : false,
			filterColValue : 'movpr.usuario_reg',
			form : false
		},
		{
			validacion : {
				name : 'fecha_reg',
				fieldLabel : 'Fecha Registro',
				format : 'd/m/Y',
				minValue : '01/01/1900',
				grid_visible : true,
				grid_editable : false,
				renderer : formatDate,
				align : 'center',
				width_grid : 95
			},
			tipo : 'TextField',
			form : false,
			filtro_0 : false,
			filterColValue : 'movpr.fecha_reg',
			dateFormat : 'm-d-Y'
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
	if(mov_estado == 'borrador')
		var config = {titulo_maestro : 'movimiento',grid_maestro : 'grid-' + idContenedor,urlHijo : '../../../sis_almain/vista/movimiento_proyecto_det/movimiento_proyecto_det.php'};
	else
		var config = {titulo_maestro : 'movimiento',grid_maestro : 'grid-' + idContenedor,urlHijo : '../../../sis_almain/vista/movimiento_proyecto_det/movimiento_proyecto_detfin.php'};
	
	
	var layout_proyecto_ingreso=new DocsLayoutMaestroDeatalle(idContenedor);
	layout_proyecto_ingreso.init(config); 

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_proyecto_ingreso,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var cm_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
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
	var cm_conexionFailure = this.conexionFailure;

	
	ds_almacen.on('load', function(store, records, options) {ds_almacen.commitChanges();}, this);
	ds.baseParams.id_almacen = idAlmacen;
	
	if(mov_estado != '')
	{
		ds.baseParams.estado_movimiento_proy = mov_estado;
	}
	
	this.btnNew = function()
	{
		
		ClaseMadre_btnNew();
		cm_getComponente('id_almacen').setValue(idAlmacen);
		
		CM_mostrarComponente(cm_getComponente('id_contratista'));//contratista
		CM_ocultarComponente(cm_getComponente('id_proveedor'));//proveedor
		CM_ocultarComponente(cm_getComponente('id_empleado'));//funcionario
		CM_ocultarComponente(cm_getComponente('id_institucion'))//institucion
		
		//a�adido 12-05-2015
		CM_mostrarComponente(cm_getComponente('peso_neto'));
	
	}

	//Sobrecarga del edit, para desplegar el origen del ingreso
	this.btnEdit = function()
	{
		ClaseMadre_btnEdit();
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		if(NumSelect != 0)
		{
			var SelectionsRecord=sm.getSelected();
			
			if(SelectionsRecord.data.id_contratista!='')
			{
				CM_ocultarComponente(cm_getComponente('id_proveedor'));
				CM_ocultarComponente(cm_getComponente('id_empleado'));
				CM_ocultarComponente(cm_getComponente('id_institucion'));
				CM_mostrarComponente(cm_getComponente('id_contratista')); 
			}
			else if(SelectionsRecord.data.id_proveedor!='')
			{
				CM_ocultarComponente(cm_getComponente('id_contratista'));
				CM_ocultarComponente(cm_getComponente('id_empleado'));
				CM_ocultarComponente(cm_getComponente('id_institucion'));
				CM_mostrarComponente(cm_getComponente('id_proveedor'));
			}
			else if(SelectionsRecord.data.id_empleado!='')
			{
				CM_ocultarComponente(cm_getComponente('id_contratista'));
				CM_ocultarComponente(cm_getComponente('id_proveedor'));
				CM_ocultarComponente(cm_getComponente('id_institucion'));
				CM_mostrarComponente(cm_getComponente('id_empleado'));
			}
			else if(SelectionsRecord.data.id_institucion!='')
			{
				CM_ocultarComponente(cm_getComponente('id_contratista'));
				CM_ocultarComponente(cm_getComponente('id_proveedor'));
				CM_ocultarComponente(cm_getComponente('id_empleado'));
				CM_mostrarComponente(cm_getComponente('id_institucion'));
			}
			
			//a�adido 12-05-2015
			CM_ocultarComponente(cm_getComponente('peso_neto'));
		}
		cm_btnActualizar();
	}


	this.EnableSelect=function(sm,row,rec)
	{
		var record=rec.data;
		_CP.getPagina(layout_proyecto_ingreso.getIdContentHijo()).pagina.reload(rec.data);
		_CP.getPagina(layout_proyecto_ingreso.getIdContentHijo()).pagina.desbloquearMenu();
		
		if(mov_estado == 'borrador')
			cm_getBoton('carga_archivos-'+ idContenedor).enable();
		
		if(mov_estado == 'borrador' && record.tipo == 'salida_proyecto')
			cm_getBoton('carga_archivos-'+ idContenedor).disable();
				
		cm_EnableSelect(sm,row,rec)
	};
	
		
	if(mov_estado == 'borrador')
	{
		var paramMenu={
			nuevo:{crear:true,separador:false},
			editar:{crear:true,separador:false},
			eliminar:{crear:true,separador:false},
			actualizar:{crear:true,separador:false} 	};
	}
	else if(mov_estado == 'finalizado')
	{
		var paramMenu={ actualizar:{crear:true,separador:false} };
	}

	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	//datos necesarios para el filtro
	var paramFunciones = {
		btnEliminar:{url:direccion+'../../../control/movimiento_proyecto/ActionEliminarMovimientoProyecto.php'},
		Save:{url:direccion+'../../../control/movimiento_proyecto/ActionGuardarMovimientoProyecto.php'},
		ConfirmSave:{url:direccion+'../../../control/movimiento_proyecto/ActionGuardarMovimientoProyecto.php'},
		Formulario:{
					html_apply:'dlgInfo-'+idContenedor,height:'60%',width:'50%',
		columnas:['96%'],
		closable : true,
		grupos:[
				{tituloGrupo:'Origen Orden Ingreso',columna:0,id_grupo:0},
				{tituloGrupo:'Datos Ingreso',columna:0,id_grupo:1},
				{tituloGrupo:'Otros',columna:0,id_grupo:2}

				],
				minWidth:150,minHeight:200,	closable:true,titulo:'Ingreso de Proyectos'}
	}; 

	
	function iniciarEventosFormularios()
	{
		combo_solicitante = cm_getComponente('origen_ingreso');
		combo_proveedor = cm_getComponente('id_proveedor');
		combo_contratista = cm_getComponente('id_contratista');
		combo_empleado = cm_getComponente('id_empleado');
		combo_institucion = cm_getComponente('id_institucion');
		
		var onSolicitanteSelect = function(e) {
			var valor = combo_solicitante.getValue();
			if(valor == 'contratista'){
				CM_mostrarComponente(cm_getComponente('id_contratista'));
				CM_ocultarComponente(cm_getComponente('id_proveedor'));
				CM_ocultarComponente(cm_getComponente('id_empleado'));
				CM_ocultarComponente(cm_getComponente('id_institucion'))
				
				cm_getComponente('id_contratista').allowBlank=false;
				cm_getComponente('id_proveedor').allowBlank=true;
				cm_getComponente('id_empleado').allowBlank=true;
				cm_getComponente('id_institucion').allowBlank=true;

			}else if (valor == 'proveedor'){
				CM_mostrarComponente(cm_getComponente('id_proveedor'));
				CM_ocultarComponente(cm_getComponente('id_contratista'));
				CM_ocultarComponente(cm_getComponente('id_empleado'));
				CM_ocultarComponente(cm_getComponente('id_institucion'))
				
				cm_getComponente('id_proveedor').allowBlank=false;
				cm_getComponente('id_contratista').allowBlank=true;
				cm_getComponente('id_empleado').allowBlank=true;
				cm_getComponente('id_institucion').allowBlank=true;

			}else if(valor == 'empleado'){
				CM_mostrarComponente(cm_getComponente('id_empleado'));
				CM_ocultarComponente(cm_getComponente('id_contratista'));
				CM_ocultarComponente(cm_getComponente('id_proveedor'));
				CM_ocultarComponente(cm_getComponente('id_institucion'))
				
				cm_getComponente('id_empleado').allowBlank=false;
				cm_getComponente('id_contratista').allowBlank=true;
				cm_getComponente('id_proveedor').allowBlank=true;
				cm_getComponente('id_institucion').allowBlank=true;

			}else if(valor == 'institucion'){
				CM_mostrarComponente(cm_getComponente('id_institucion'));
				CM_ocultarComponente(cm_getComponente('id_contratista'));
				CM_ocultarComponente(cm_getComponente('id_empleado'));
				CM_ocultarComponente(cm_getComponente('id_proveedor'))
				
				cm_getComponente('id_institucion').allowBlank=false;
				cm_getComponente('id_contratista').allowBlank=true;
				cm_getComponente('id_proveedor').allowBlank=true;
				cm_getComponente('id_empleado').allowBlank=true;

			}
		};
		
		var onSolicitanteChange = function(e) {
			var valor = combo_solicitante.getValue();
			if(valor == 'contratista'){
				combo_proveedor.setValue('');
				combo_empleado.setValue('');
				combo_institucion.setValue('')

			}else if (valor == 'proveedor'){
				combo_contratista.setValue('');
				combo_empleado.setValue('');
				combo_institucion.setValue('')

			}else if(valor == 'empleado'){
				combo_proveedor.setValue('');
				combo_contratista.setValue('');
				combo_institucion.setValue('')

			}else if(valor == 'institucion'){
				combo_proveedor.setValue('');
				combo_empleado.setValue('');
				combo_contratista.setValue('')
			}
		};
		
		combo_solicitante.on('select',onSolicitanteSelect);
		combo_solicitante.on('change',onSolicitanteSelect);
		
		combo_proveedor.on('change',onSolicitanteChange);
		combo_contratista.on('change',onSolicitanteChange);
		combo_institucion.on('change',onSolicitanteChange);
		combo_empleado.on('change',onSolicitanteChange);
		
	}

	function btnLoadFiles()
	{
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect==1)
		{
			var SelectionsRecord=sm.getSelected();
			var data = '&id_proyecto='+SelectionsRecord.data.id_movimiento_proyecto;
			//if(confirm("Esta seguro de cargar los archivos del proyecto?"))
			//{
				var paramVentana={
						Ventana:{
							width:'40%',
				            height:'40%'
						}
					};
				layout_proyecto_ingreso.loadWindows(direccion+'../../../../sis_almain/vista/cargar_archivos/cargar_archivos.php?'+data,'Cargar items proyecto',paramVentana);
		
			//}
		}
		else if(NumSelect > 1)
		{
			Ext.MessageBox.alert('Estado', 'Debe seleccionar un registro a la vez');
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'No tiene seleccionado ningun registro.');
		}
	}
	
	function btn_fin_ord_ing()
	{
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		if(NumSelect==1)
		{
			var SelectionsRecord=sm.getSelected();
			if(confirm("Esta seguro de finalizar el movimiento ?"))
			{
			
				Ext.MessageBox.show({
					title: 'Procesando...',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Finalizando movimiento...</div>",
					width:300,
					height:200,
					closable:false
				}); 
				
				Ext.Ajax.request({
					url:direccion+"../../../control/movimiento_proyecto/ActionFinalizarMovimientoProyecto.php",
					method:'POST',
					params:{	cantidad_ids:'1'
								,id_movimiento_proy:SelectionsRecord.data.id_movimiento_proyecto
								,id_almacen:idAlmacen
								,accion:'finalizar_movimiento'
								
							},
					success:successMovimientoProyecto,
					failure:ClaseMadre_conexionFailure,
					timeout:100000000
				});
				
				/*
				cm_Save();
				*/
			}	
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Debe seleccionar un solo registro.')
		}
	}
	
	function successMovimientoProyecto(resp)
	{
		Ext.MessageBox.hide();
		if(resp.responseXML&&resp.responseXML.documentElement)
		{
			cm_btnActualizar();
		}
		else
		{
			ClaseMadre_conexionFailure();
		}
	}

	function esteSuccessCorregir(resp) 
	{
		Ext.MessageBox.hide();
		if(! resp.responseXML&&resp.responseXML.documentElement)
		{
			cm_conexionFailure();
		}
		else
		{
			cm_btnActualizar();
		}
	}

	function btn_corregir_mov_fin()
	{
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();

		if(NumSelect==1)
		{
			var SelectionsRecord=sm.getSelected();
			
			if(confirm("Esta seguro de corregir el movimiento seleccionado ?"))
			{
				Ext.MessageBox.show({
					title: 'Procesando...',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/>Procesando movimiento...</div>",
					width:300,
					height:200,
					closable:false
				}); 
				
				Ext.Ajax.request({
					url:direccion+"../../../control/movimiento_proyecto/ActionGuardarMovimientoProyecto.php",
					method:'POST',
					params:{	cantidad_ids:'1'
								,hidden_id_mov_proy_0:SelectionsRecord.data.id_movimiento_proyecto
								,accion:'corregir_movfin'
							},
					success:esteSuccessCorregir,
					failure:cm_conexionFailure,
					timeout:100000000
				});
			}	
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Debe seleccionar un solo registro.')
		}
	}

	function btn_costeo()
	{
		var sm=getSelectionModel();
		var filas = ds.getModifiedRecords();
		var NumSelect=sm.getCount();
		if(NumSelect!=0)
		{
			var SelectionsRecord  = sm.getSelected(); //es el primer registro selecionado
			var data = "m_id_mov_proy=" + SelectionsRecord.data.id_movimiento_proyecto;
			data = data +"&m_id_almacen=" +SelectionsRecord.data.id_almacen;
			
			var ParamVentana={Ventana:{width:'50%',height:'60%'}}
			layout_proyecto_ingreso.loadWindows(direccion+'../../../../sis_almain/vista/costeo/costeo.php?'+data,'Costeo Items',ParamVentana);
			layout_proyecto_ingreso.getVentana().on('resize',function(){
			layout_proyecto_ingreso.getLayout().layout();})
		}
		else
		{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un item');
		}
	}
	
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	var cm_BloquearMenu = this.BloquearMenu;
	var cm_DesbloquearMenu = this.DesbloquearMenu;
	var cm_getBoton = this.getBoton;
	
	 
	cm_BloquearMenu();
	
	this.AdicionarBotonCombo(cbxSisAlma, 'Almacen');

	 if(mov_estado == 'borrador')
	 {
		//para agregar botones
		this.AdicionarBoton("../../../lib/imagenes/list-proce.bmp",'Cargar Archivos',btnLoadFiles,true,'carga_archivos','Cargar Archivos');
		this.AdicionarBoton('../../../lib/imagenes/book_next.png','Finalizar Ingreso Proyecto',btn_fin_ord_ing,true,'term_solicitud','');
	 }
	 else if(mov_estado == 'finalizado')
	 {
		this.AdicionarBoton("../../../lib/imagenes/item.png",'<b>Costeo</b>',btn_costeo,true,'costeo_proyecto','Costeo Ingreso');
		this.AdicionarBoton('../../../lib/imagenes/cancel.png','<b>Corregir</b>',btn_corregir_mov_fin,true,'corregir_mov_fin','Corregir');		
	 }
	 
	iniciarEventosFormularios();

	layout_proyecto_ingreso.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}