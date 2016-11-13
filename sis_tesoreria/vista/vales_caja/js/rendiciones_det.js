/**
 * Nombre:		  	    pagina_rendiciones_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-11-06 19:01:08
 */
function pagina_rendiciones_det(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var componentes= new Array();
	var maestro;
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/caja_regis/ActionListarRendiciones.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_caja_regis',totalRecords:'TotalCount'
		},[		
		'id_caja_regis',
		'id_cajero',
		'apellido_paterno_persona',
		'apellido_materno_persona',
		'nombre_persona',
		'codigo_empleado_empleado',
		'desc_cajero',
		'id_fina_regi_prog_proy_acti',
		'id_unidad_organizacional',
		'desc_unidad_organizacional',
		'id_concepto_ingas',
		'desc_partida_partida',
		'desc_ingas_concepto_ingas',
		'desc_concepto_ingas',
		{name: 'fecha_regis',type:'date',dateFormat:'Y-m-d'},
		'importe_total',
		'nombre',
		'nombre_unidad',
		'desc_documento',
		'tipo_documento',
		{name: 'fecha_documento',type:'date',dateFormat:'Y-m-d'},
		'nro_documento',
		'razon_social',
		'nro_nit',
		'nro_autorizacion',
		'codigo_control',
		'desc_epe',
		'id_presupuesto',
		'desc_presupuesto',
		'concepto_regis',
		'estado_regis'
		
	
		]),remoteSort:true});

	
	//DATA STORE COMBOS

    var ds_cajero = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cajero/ActionListarCajero.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cajero',totalRecords: 'TotalCount'},['id_cajero','nombre_persona','apellido_paterno_persona','apellido_materno_persona','codigo_empleado_empleado','desc_empleado'])
	});

    /*var ds_unidad_organizacional = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarUnidadOrganizacionalEP.php?m_sw_presupuesto=si'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_organizacional',totalRecords: 'TotalCount'},['id_unidad_organizacional','nombre_unidad','nombre_cargo','centro','cargo_individual','descripcion','fecha_reg','id_nivel_organizacional','estado_reg','nombre_nivel']),baseParams:{m_sw_rendicion:'si'}
	});
*/	
    var ds_tipo_plantilla = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/plantilla/ActionListarPlantilla.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'tipo_plantilla',totalRecords: 'TotalCount'},['id_plantilla','tipo_plantilla','desc_plantilla','tipo'])});
    
	var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/presupuesto/ActionListarComboPresupuesto.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','tipo_pres','estado_pres','id_unidad_organizacional','nombre_unidad','id_fina_regi_prog_proy_acti','desc_epe','id_fuente_financiamiento','sigla','estado_gral','gestion_pres','id_parametro','id_gestion','desc_presupuesto','nombre_financiador', 'nombre_regional', 'nombre_programa', 'nombre_proyecto', 'nombre_actividad' ]),baseParams:{m_sw_rendicion:'si',sw_inv_gasto:'si'}
	});
 
 
 
	
    var ds_concepto_ingas = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/concepto_ingas/ActionListarConceptoIngas.php?'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_concepto_ingas',totalRecords: 'TotalCount'},['id_concepto_ingas','desc_partida','desc_ingas','desc_ingas_item_serv' ])
	});

	//FUNCIONES RENDER
	
		
		function render_id_cajero(value, p, record){if(record.get('estado_regis')=='2'){return '<span style="color:red;font-size:8pt">' + record.data['desc_cajero']+ '</span>';}else {return record.data['desc_cajero'];}}
		var tpl_id_cajero=new Ext.Template('<div class="search-item">','<b><i>{nombre_persona} </b></i>','<b><i>{apellido_paterno_persona} </b></i>','<b><i>{apellido_materno_persona} </b></i>','<br><FONT COLOR="#B5A642">{codigo_empleado_empleado}</FONT>','</div>');
 
		//function render_id_unidad_organizacional(value, p, record){return String.format('{0}', record.data['desc_unidad_organizacional']);}
		function render_id_presupuesto(value, p, record){if(record.get('estado_regis')=='2'){return '<span style="color:red;font-size:8pt">' + record.data['desc_presupuesto']+ '</span>';}else {return record.data['desc_presupuesto'];}}
		var tpl_id_presupuesto=new Ext.Template('<div class="search-item">',
		'<b>Gestión: </b><FONT COLOR="#B5A642">{gestion_pres}</FONT>',
		'<b>   Tipo Presupuesto: </b><FONT COLOR="#B5A642">{tipo_pres}</FONT>',
		'<br><b>Fuente de Financiamineto: </b><FONT COLOR="#B5A642">{sigla}</FONT>',
		'<br> <b>Unidad Organizacional: </b><FONT COLOR="#B5A642">{nombre_unidad}</FONT>',
		'<br>  <b>Estructura Programatica:  </b><FONT COLOR="#B5A642">{desc_epe}</FONT></b>',
		'<br>  <FONT COLOR="#B5A642">{nombre_financiador}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_regional}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_programa}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_proyecto}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_actividad}</FONT>',
		
		'</div>');

		function render_id_concepto_ingas(value, p, record){return String.format('{0}', record.data['desc_concepto_ingas']);}
		var tpl_id_concepto_ingas=new Ext.Template('<div class="search-item">','<b><i>{desc_ingas_item_serv}</b></i><br>','<FONT COLOR="#B5A642">{desc_partida}</FONT>','</div>');

		function render_tipo_plantilla(value, p, record){return String.format('{0}', record.data['desc_documento']);}
		var tpl_tipo_plantilla=new Ext.Template('<div class="search-item">','<b><i>{desc_plantilla}</i></b>','</div>');

		
		
		
		var ds_epe = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/asignacion_estructura/ActionListarEPusuarioSCI.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_fina_regi_prog_proy_acti',totalRecords: 'TotalCount'},['id_fina_regi_prog_proy_acti','id_financiador','codigo_financiador','nombre_financiador','id_regional','codigo_regional','nombre_regional','id_programa','codigo_programa','nombre_programa','id_proyecto','codigo_proyecto','nombre_proyecto','id_actividad','codigo_actividad','nombre_actividad','desc_epe']),	baseParams:{sw_rendicion:'si'}});	
		function render_id_epe(value, p, record){rf = ds_epe.getById(value);if(rf!=null){record.data['id_fina_regi_prog_proy_acti'] =rf.data['id_fina_regi_prog_proy_acti'];record.data['desc_epe'] =rf.data['desc_epe'];};return String.format('{0}',record.data['desc_epe'])}
var tpl_id_epe=new Ext.Template('<div class="search-item">','<b><i>{desc_epe}</i></b>','<br><FONT  SIZE="1" COLOR="#B5A642">{nombre_financiador}</FONT>','<br><FONT  SIZE="1" COLOR="#B5A642">{nombre_regional}</FONT>','<br><FONT  SIZE="1" COLOR="#B5A642">{nombre_programa}</FONT>','<br><FONT  SIZE="1" COLOR="#B5A642">{nombre_proyecto}</FONT>','<br><FONT  SIZE="1" COLOR="#B5A642">{nombre_actividad}</FONT>','</div>');

function negrita(val,cell,record,row,colum,store){
			if(record.get('estado_regis')=='2'){
					return '<span style="color:red;font-size:8pt">' + val + '</span>';
			}
			else{
				return val;
			}
		}
		
		function renderEstado(value, p, record){	//solo registros diferentes de tesoreria
			if(value == 1){return "Pendiente"}		
			if(value == 2){return "Marcado para contabilizar"}
			if(value == 3){return "En contabilizacion"}
			if(value == 4){return "Finalizado"}
		
		}	
		/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_caja_regis
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_caja_regis',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_caja_regis'
	};
// txt id_cajero
	Atributos[1]={
			validacion:{
			name:'id_cajero',
			fieldLabel:'Cajero',
			allowBlank:false,			
			emptyText:'Cajero...',
			desc: 'desc_cajero', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_cajero,
			valueField: 'id_cajero',
			displayField: 'desc_empleado',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre#EMPLEA.codigo_empleado',
			typeAhead:true,
			tpl:tpl_id_cajero,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_cajero,
			grid_visible:true,
			grid_editable:false,
			width_grid:130,
			width:'100%',
			disabled:false,
			grid_indice:1		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PERSON_1.apellido_paterno#PERSON_1.apellido_materno#PERSON_1.nombre#EMPLEA_1.codigo_empleado',
		save_as:'id_cajero',
		id_grupo:0
	};

 
Atributos[2]={
			validacion:{
			name:'id_presupuesto',
			fieldLabel:'Presupuesto',
			allowBlank:false,			
			emptyText:'Presupu....',
			desc: 'desc_presupuesto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_presupuesto,
			valueField: 'id_presupuesto',
			displayField: 'desc_presupuesto',
			queryParam: 'filterValue_0',
			filterCol:'presup.desc_presupuesto',
			typeAhead:false,
			tpl:tpl_id_presupuesto,
			forceSelection:true,
			mode:'remote',
			queryDelay:360,
			pageSize:10,
			minListWidth:400,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_presupuesto,
			grid_visible:true,
			grid_editable:false,
			width_grid:400,
			width:400,
			disabled:false,
			grid_indice:3		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'presup.desc_presupuesto',
		save_as:'id_presupuesto',
		id_grupo:0
	};
// txt id_concepto_ingas
	Atributos[3]={
			validacion:{
			name:'id_concepto_ingas',
			fieldLabel:'Concepto Ingreso Gasto',
			allowBlank:false,			
			emptyText:'Concepto Ingreso Gasto...',
			desc: 'desc_concepto_ingas', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_concepto_ingas,
			valueField: 'id_concepto_ingas',
			displayField: 'desc_ingas_item_serv',
			queryParam: 'filterValue_0',
			filterCol:'PARTID.desc_partida#CONING.desc_ingas',
			typeAhead:true,
			tpl:tpl_id_concepto_ingas,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_concepto_ingas,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:'100%',
			disabled:true,
			grid_indice:4		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PARTID_4.desc_partida#CONING_4.desc_ingas',
		save_as:'id_concepto_ingas',
		id_grupo:2
	};
// txt fecha_regis
	Atributos[4]= {
		validacion:{
			name:'fecha_regis',
			fieldLabel:'Fecha Registro',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false,
			grid_indice:5		
		},
		form:false,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'CAJREG.fecha_regis',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_regis'
	};
// txt importe_regis
	Atributos[5]={
		validacion:{
			name:'importe_total',
			fieldLabel:'Importe Registro',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'50%',
			disabled:false,
			grid_indice:12		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'CAJREG.importe_total',
		save_as:'importe_regis',
		id_grupo:2
	};
// txt nombre
	Atributos[6]={
		validacion:{
			name:'nombre',
			fieldLabel:'Moneda',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:100,
			disabled:false,
			grid_indice:5		
		},
		tipo: 'TextField',
		form: false,
		filtro_0:false,
		filterColValue:'MONEDA.nombre',
		save_as:'nombre'
	};
// txt nombre_unidad
	Atributos[7]={
		validacion:{
			name:'nombre_unidad',
			fieldLabel:'Caja',
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
			grid_indice:2,
			renderer:negrita		
		},
		tipo: 'TextArea',
		form: false,
		filtro_0:true,
		filterColValue:'UNIORG_1.nombre_unidad',
		save_as:'nombre_unidad'
	};
		var fCol=new Array();
		var fVal=new Array();
		fCol[0]='PLANT.sw_compro';
		fVal[0]='1';
	
	Atributos[8]={
			validacion:{
				name:'tipo_documento',
				fieldLabel:'Tipo Documento',
				allowBlank:false,
				emptyText:'Documento...',
				desc: 'desc_documento',
				store:ds_tipo_plantilla,
				valueField: 'tipo_plantilla',
				displayField: 'desc_plantilla',
				queryParam: 'filterValue_0',
				filterCol:'PLANT.tipo_plantilla#PLANT.desc_plantilla',
				filterCols:fCol,
				filterValues:fVal,
				typeAhead:true,
				tpl:tpl_tipo_plantilla,
				forceSelection:true,
				onSelect: function(record){componentes[8].setValue(record.data.tipo_plantilla);componentes[8].collapse();if(record.data.tipo=='1'){CM_mostrarGrupo('Datos Factura');NoBlancosGrupo(4);}else{CM_ocultarGrupo('Datos Factura');SiBlancosGrupo(4);}},		
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:'50%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_tipo_plantilla,
				align:'right',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'50%',
				grid_indice:6
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			save_as:'tipo_documento',
			filterColValue:'PLANTI.desc_plantilla',
			id_grupo:2
		};
// txt fecha_documento
	Atributos[9]= {
		validacion:{
			name:'fecha_documento',
			fieldLabel:'Fecha Documento',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false,
			grid_indice:8		
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'DOCUME.fecha_documento',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_documento',
		id_grupo:3
	};
// txt nro_documento
	Atributos[10]={
		validacion:{
			name:'nro_documento',
			fieldLabel:'No Documento',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false,
			grid_indice:9		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'DOCUME.nro_documento',
		save_as:'nro_documento',
		id_grupo:3
	};
// txt razon_social
	Atributos[11]={
		validacion:{
			name:'razon_social',
			fieldLabel:'Razon Social',
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
		form: true,
		filtro_0:true,
		filterColValue:'DOCUME.razon_social',
		save_as:'razon_social',
		id_grupo:3
	};
// txt nro_nit
	Atributos[12]={
		validacion:{
			name:'nro_nit',
			fieldLabel:'NIT',
			allowBlank:false,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false,
			grid_indice:11		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'DOCUME.nro_nit',
		save_as:'nro_nit',
		id_grupo:4
	};
// txt nro_autorizacion
	Atributos[13]={
		validacion:{
			name:'nro_autorizacion',
			fieldLabel:'No Autorización',
			allowBlank:false,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false,
			grid_indice:13		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'DOCUME.nro_autorizacion',
		save_as:'nro_autorizacion',
		id_grupo:4
	};
// txt codigo_control
	Atributos[14]={
		validacion:{
			name:'codigo_control',
			fieldLabel:'Código de control',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false,
			grid_indice:14		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'DOCUME.codigo_control',
		save_as:'codigo_control',
		id_grupo:4
	};
	
	Atributos[15]={
		validacion:{
			labelSeparator:'',
			name: 'fk_id_caja_regis',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'fk_id_caja_regis'
	};
	
	Atributos[16]={
		validacion:{
			name:'concepto_regis',
			fieldLabel:'Referencias',
			allowBlank:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:130,
			grid_indice:5	
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'CAJREG.concepto_regis',
		id_grupo:2		
	};
	
	Atributos[17]={
		validacion:{
			name:'estado_regis',
			fieldLabel:'Estado',
			grid_visible:true,
			grid_editable:false,
			width_grid:130,
			grid_indice:7,
			renderer:renderEstado	
		},
		tipo: 'TextArea',
		form: false,
		filtro_0:true,
		filterColValue:'CAJREG.estado_regis'
	};
	

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Vales de Caja(Maestro)',titulo_detalle:'Rendiciones(Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_rendiciones_det=new DocsLayoutMaestro(idContenedor);
	layout_rendiciones_det.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_rendiciones_det,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_getComponente=this.getComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_btnNew=this.btnNew;
	
	var CM_btnEdit=this.btnEdit;
	var CM_saveSuccess=this.saveSuccess;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	
	var cm_EnableSelect=this.EnableSelect;

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu={
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/caja_regis/ActionEliminarRendiciones.php'},
		Save:{url:direccion+'../../../control/caja_regis/ActionGuardarRendiciones.php'},
		ConfirmSave:{url:direccion+'../../../control/caja_regis/ActionGuardarRendiciones.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:420,columnas:['90%'],grupos:[{tituloGrupo:'Datos Generales',columna:0,id_grupo:0} ,{tituloGrupo:'epe',columna:0,id_grupo:1},{tituloGrupo:'Gasto',columna:0,id_grupo:2},{tituloGrupo:'Datos Documento',columna:0,id_grupo:3},{tituloGrupo:'Datos Factura',columna:0,id_grupo:4}],width:'60%',minWidth:150,minHeight:200,	closable:true,titulo:'rendiciones'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	
	this.reload=function(m){
				maestro=m;
				
				componentes[1].store.baseParams={m_id_caja:m.id_caja,estado:3};
				componentes[1].modificado=true;
				componentes[3].store.baseParams={m_sw_rendicion:'si'};
				componentes[3].modificado=true;
				ds.lastOptions={
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						m_fk_id_caja_regis:maestro.id_caja_regis

					}
				};
				this.btnActualizar();
				

				Atributos[15].defecto=maestro.id_caja_regis;
				paramFunciones.btnEliminar.parametros='&m_fk_id_caja_regis='+maestro.id_caja_regis;
				paramFunciones.Save.parametros='&m_fk_id_caja_regis='+maestro.id_caja_regis;
				paramFunciones.ConfirmSave.parametros='&m_fk_id_caja_regis='+maestro.id_caja_regis;
				this.InitFunciones(paramFunciones);
				botones_maestro();
				
				
			};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		for (var i=0;i<Atributos.length;i++){
			
			componentes[i]=CM_getComponente(Atributos[i].validacion.name);
		}
		componentes[2].on('select',filtrar_epe_concepto_ingas);
		CM_ocultarGrupo('Datos Factura');
		CM_ocultarGrupo('epe');
		
		
	}
	
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.EnableSelect=function(sm,row,rec){
		
				
				botones(sm,row,rec);
									
	}	
	this.btnNew=function(){
		componentes[3].setDisabled(true);
		ds_presupuesto.baseParams.m_sw_presupuesto='si';
		ds_presupuesto.baseParams.id_depto=maestro.id_depto;
		componentes[2].modificado=true
		
		if(maestro.estado_regis=='1'){
			Ext.MessageBox.alert('Estado', 'El vale debe estar en estado rendición.(El reporte debe ser impreso)');
		}
		else{
			CM_btnNew();
		}
	}	
	this.btnEdit=function(){
		componentes[3].setDisabled(true);
		ds_presupuesto.baseParams.m_sw_presupuesto='si';
		ds_presupuesto.baseParams.id_depto=maestro.id_depto;
		componentes[2].modificado=true
		componentes[8].reset();
		CM_btnEdit();
		}
		
	function btn_marcar()
	{
		
		var sm=getSelectionModel(); 
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect==1)
		{
			
				var sm=getSelectionModel();
				Ext.Ajax.request({
					url:direccion+"../../../control/caja_regis/ActionMarcarRendiciones.php",
					success:esteSuccess,
					params:{'id_caja_regis':sm.getSelected().data.id_caja_regis},
					failure:ClaseMadre_conexionFailure,
					timeout:paramConfig.TiempoEspera
				})
			
		}
		else
		{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar una Rendicion.')
		}		
	}
	
	function esteSuccess(resp){
		if(resp.responseXML&&resp.responseXML.documentElement){
			//btn_reporte_solicitud_compra();
			ClaseMadre_btnActualizar();
		}
		else{
			ClaseMadre_conexionFailure();
		}
	}
	
	

	
	
	function filtrar_epe_concepto_ingas(combo,record, index)
	{	componentes[3].store.baseParams={};
		
		componentes[3].setValue();
		componentes[3].store.baseParams={m_sw_rendicion:'si',m_id_unidad_organizacional:record.data.id_unidad_organizacional, m_id_presupuesto:record.data.id_presupuesto};
		componentes[3].modificado=true;
		componentes[3].setDisabled(false);
		
	}
	function SiBlancosGrupo(grupo){
		for (var i=0;i<componentes.length;i++){
			
			if(Atributos[i].id_grupo==grupo)
			componentes[i].allowBlank=true;
		}
	}
	function NoBlancosGrupo(grupo){
		for (var i=0;i<componentes.length;i++){
			if(Atributos[i].id_grupo==grupo)
				componentes[i].allowBlank=Atributos[i].validacion.allowBlank;
		}
	}
	

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_rendiciones_det.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	var CM_getBoton=this.getBoton;
	
	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Marcar/Desmarcar Rendicion',btn_marcar,true,'marcar','Marcar/Desmarcar Rendicion');
	
	 //var CM_getBoton=this.getBoton;
	function botones(sm,row,rec){
		cm_EnableSelect(sm,row,rec);		
		if(maestro.id_subsistema!=12 || maestro.estado_regis!=2){
					CM_getBoton('nuevo-'+idContenedor).disable();
					CM_getBoton('editar-'+idContenedor).disable();
					CM_getBoton('eliminar-'+idContenedor).disable();
					if(rec.data['estado_regis']==3||rec.data['estado_regis']==4){
						CM_getBoton('marcar-'+idContenedor).disable();
					}
					else{
						CM_getBoton('marcar-'+idContenedor).enable();
					}
		}
		else{
			if(rec.data['estado_regis']==3||rec.data['estado_regis']==4){
				CM_getBoton('marcar-'+idContenedor).disable();
				CM_getBoton('editar-'+idContenedor).disable();
				CM_getBoton('eliminar-'+idContenedor).disable();
				
			}
			else{
				CM_getBoton('nuevo-'+idContenedor).enable();
				CM_getBoton('marcar-'+idContenedor).enable();
				CM_getBoton('editar-'+idContenedor).enable();
				CM_getBoton('eliminar-'+idContenedor).enable();
			}
		}
		
		
	}
	
	function botones_maestro(){
		if(maestro.id_subsistema!=12 || maestro.estado_regis!=2){
			CM_getBoton('nuevo-'+idContenedor).disable();
		}
		else{
			CM_getBoton('nuevo-'+idContenedor).enable();
		}
		
	}
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	this.bloquearMenu();
	layout_rendiciones_det.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}