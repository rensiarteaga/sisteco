<?php 
/**
 * Nombre:		  	    formulacion_presupuesto_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-07-10 09:08:14
 *
 */
session_start();
?>
//<script>
function main(){
 	<?php
	//obtenemos la ruta absoluta
	$host  = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir = "http://$host$uri/";
	echo "\nvar direccion='$dir';";
    echo "var idContenedor='$idContenedor';";
	?>
var fa=false;
<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:true,FiltroAvanzado:fa};
var prestoConfig=
{s_tipo_pres:'<?php echo $s_tipo_pres;?>',
tipo_vista:'<?php echo $tipo_vista;?>',
estado_gral:'<?php echo $estado_gral;?>',
sw_colectivo:'<?php echo $sw_colectivo;?>',
sw_usuario:'<?php echo $sw_usuario;?>'};

 

var elemento={pagina:new pagina_presupuesto_vigente(idContenedor,direccion,paramConfig,prestoConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_formulacion_presupuesto.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-07-10 09:08:14
 */
function pagina_presupuesto_vigente(idContenedor,direccion,paramConfig,prestoConfig){
	var Atributos=new Array,sw=0;
	var data, data1;
	var componentes=new Array();
	var desc_moneda;
	var sw_cambio;
	
	var monedas_for=new Ext.form.MonedaField
	(
		{
			name:'mes_01',
			fieldLabel:'Enero',	
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:0,
			allowNegative:false,
			minValue:0,
		}
	); 	
	
		//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/presupuesto_vigente/ActionListarPresupuestoVigenteSuma.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_presupuesto',totalRecords:'TotalCount'
		},[		
		'id_presupuesto',
		'tipo_pres',
		'estado_pres',
		'id_financiador',
		'id_regional',
		'id_programa',
		'id_proyecto',
		'id_actividad',
		'nombre_financiador',
		'nombre_regional',
		'nombre_programa',
		'nombre_proyecto',
		'nombre_actividad',
		'codigo_financiador',
		'codigo_regional',
		'codigo_programa',
		'codigo_proyecto',
		'codigo_actividad',
		'id_unidad_organizacional',
		'desc_unidad_organizacional',
		'id_fuente_financiamiento',
		'denominacion',
		'id_parametro',
		'desc_parametro',
		'gestion_pres',
		'total',
		/*'id_moneda',
		'desc_moneda',*/
		'fecha_reg',
		'usuario',
		'estado'
		]),remoteSort:true});

	
	
	
	//DATA STORE COMBOS
	var ds_unidad_organizacional = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarUnidadOrganizacional.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_organizacional',totalRecords: 'TotalCount'},['id_unidad_organizacional','nombre_unidad','nombre_cargo','centro','cargo_individual','descripcion','fecha_reg','id_nivel_organizacional','estado_reg'])
	});
	
    var ds_unidad_organizacional = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarUnidadOrganizacional.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_organizacional',totalRecords: 'TotalCount'},['id_unidad_organizacional','nombre_unidad','nombre_cargo','centro','cargo_individual','descripcion','fecha_reg','id_nivel_organizacional','estado_reg'])
	});

    var ds_fuente_financiamiento = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/fuente_financiamiento/ActionListarFuenteFinanciamiento.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_fuente_financiamiento',totalRecords: 'TotalCount'},['id_fuente_financiamiento','codigo_fuente','denominacion'])
	});

    var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','gestion_pres','estado_gral','cod_institucional','porcentaje_sobregiro','cantidad_niveles'])
	});
	
	var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});	
	
	var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/gestion/ActionListarGestion.php?estado=abierto'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_gestion',totalRecords: 'TotalCount'},['id_gestion','gestion'])
	});
	
	/*var ds_moneda = new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../lib/lib_control/action/ActionObtenerMonedaBD.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad','tipo_actualizacion']),
			baseParams:{sw_combo_presupuesto:'si'}
	});*/
	
	var ds_estado = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/estado_autorizado/ActionListarEstadoAutorizado.php'}),
			reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_estado_autorizado',totalRecords: 'TotalCount'}, ['id_estado_autorizado','id_usuario_autorizado','id_concepto_colectivo','estado_autorizado','desc_estado_autorizado']),
			baseParams:{sw_comboPresupuesto:'si'}
	});
									
	//FUNCIONES RENDER
	
	function render_id_unidad_organizacional(value, p, record){return String.format('{0}', record.data['desc_unidad_organizacional']);}
	var tpl_id_unidad_organizacional=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{nombre_unidad}</FONT><br>','<FONT COLOR="#B5A642">{centro}</FONT>','</div>');

	function render_id_fuente_financiamiento(value, p, record){return String.format('{0}', record.data['denominacion']);}
	var tpl_id_fuente_financiamiento=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{codigo_fuente}</FONT><br>','<FONT COLOR="#B5A642">{denominacion}</FONT>','</div>');

	function render_id_parametro(value, p, record){return String.format('{0}', record.data['desc_parametro']);}
	var tpl_id_parametro=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{gestion_pres}</FONT><br>','<FONT COLOR="#B5A642">{estado_gral}</FONT>','</div>');
	
	//function render_id_moneda(value,p,record){return String.format('{0}', record.data['nombre'])}
	//var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');

	function render_id_moneda(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
	
	function render_estado(value,p,record){return String.format('{0}', record.data['estado_autorizado'])}
	var tpl_estado=new Ext.Template('<div class="search-item">' ,'<b>{desc_estado_autorizado}</b></FONT>','</div>');		
	
	function renderTipoPresupuesto(value, p, record){
		if(value == 0)
		{return "0. Administrativo"}
		if(value == 1)
		{return "1. Recurso"}
		if(value == 2)
		{return "2. Gasto"}
		if(value == 3)
		{return "3. Inversión"}
		if(value == 4)
		{return "4. PNO - Recurso"}
		if(value == 5)
		{return "5. PNO - Gasto"}
		if(value == 6)
		{return "6. PNO - Inversión"}
		if(value == 7)
		{return "7. Gasto - Bolsa RRHH"}
		return '';
	}
	
	function renderEstadoPresupuesto(value, p, record){
		if(value == 1){return "1. Formulación"}
		if(value == 2){return "2. Verificación Previa"}
		if(value == 3){return "3. Revisión Final"}
		if(value == 4){return "4. Anteproyecto"}
		if(value == 5){return "5. Aprobado"}
	}	
	
	function render_moneda(value)
	{
		if(value == 1){return "Bolivianos"}
		if(value == 2){return "Dólares Americanos"}
		if(value == 3){return "Unidad de Fomento a la Vivienda"}
		if(value == 4){return "Otros"}
	}
	
	function renderSeparadorDeMil(value,cell,record,row,colum,store)
	{		
			return monedas_for.formatMoneda(value)		 
	}
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_presupuesto
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_presupuesto',
			fieldLabel:'Identificador',
			inputType:'hidden',
			grid_visible:true, 
			grid_editable:false
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'PRESUP.id_presupuesto',
		id_grupo:0,
		save_as:'id_presupuesto'
	};
	
	Atributos[1]={
		validacion:{
			name:'tipo_pres',
			fieldLabel:'Tipo Presupuesto',
			allowBlank:true,
			allowDecimals:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			width:'95%',
			vtype:'texto',
			//renderer: renderTipoPresupuesto,
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:true,
		defecto: '1',
		filterColValue:'PRESUP.tipo_pres',
		save_as:'tipo_pres'
	};
	
 	/*Atributos[1] = {
		validacion: {
			name:'tipo_pres',
			//desc: 'tipo_conex_literal',
			fieldLabel:'Tipo Presupuesto',
			vtype:'texto',
			emptyText:'Tipo Presupue...',
			allowBlank: false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID', 'valor'],
				data :Ext.tipo_presupuesto_combo.tipo_pres // from states.js
			}),
			valueField:'ID',
			displayField:'valor',
			renderer: renderTipoPresupuesto,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:100, // ancho de columna en el gris
			width:150
		},
		tipo:'Field',
		filtro_0:false,
		defecto: '1',
		form: false,
		save_as:'tipo_pres',
		id_grupo:0
	};*/
 	
	// txt id_unidad_organizacional
	// txt estado
	Atributos[2]={
			validacion:{
			name:'estado_pres',
			fieldLabel:'Estado',
			allowBlank:true,			
			emptyText:'Etap...',
			desc: 'estado_pres', //indica la columna del store principal ds del que proviane la descripcion
			//desc: 'estado_autorizado', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_estado,
			valueField: 'estado_autorizado',
			displayField: 'desc_estado_autorizado',
			queryParam: 'filterValue_0',
			filterCol:'ESTAUT.estado_autorizado',
			//filterCol:'USUAUT.estado_autorizado',
			typeAhead:true,
			tpl:tpl_estado,
			forceSelection:true,
			mode:'remote',
			queryDelay:200,
			pageSize:100,
			minListWidth:200,
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',			
			editable:true,
			renderer:renderEstadoPresupuesto,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:200,
			disable:false		
		},
		tipo:'ComboBox',
		form: true,
		id_grupo:3,
		filtro_0:false,
		//filterColValue:'PRESUP.estado_autorizado',
		filterColValue:'PRESUP.estado_pres',
		save_as:'estado_pres'
	};
	
	Atributos[3]={
			validacion:{
			name:'id_unidad_organizacional',
			fieldLabel:'Unidad Organizacional',
			allowBlank:true,			
			emptyText:'Unidad Organizacio...',
			desc: 'desc_unidad_organizacional', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_unidad_organizacional,
			valueField: 'id_unidad_organizacional',
			displayField: 'nombre_unidad',
			queryParam: 'filterValue_0',
			filterCol:'presup.nombre_unidad#PRESUP.centro',
			typeAhead:true,
			tpl:tpl_id_unidad_organizacional,
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
			renderer:render_id_unidad_organizacional,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:'100%',
			disabled:true		
		},
		tipo:'ComboBox',
		form: false,
		filtro_0:true,
		id_grupo:0,
		filterColValue:'PRESUP.nombre_unidad',
		save_as:'id_unidad_organizacional'
	};
	
	// txt id_fina_regi_prog_proy_acti
	Atributos[4]={
		validacion:{
			fieldLabel:'Estructura Programatica',
			allowBlank:true,
			emptyText:'Estructura Programática',
			name:'id_fina_regi_prog_proy_acti',
			minChars:1,
			triggerAction:'all',
			editable:false,
			grid_visible:true,
			grid_editable:false,		
			width:300
			},
			tipo:'epField',
			save_as:'id_ep',
			id_grupo:2
		};
		
	// txt total
	Atributos[5]={
		validacion:{
			name:'total',
			fieldLabel:'Total Presupuestado',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			//decimalPrecision:0,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			//renderer: renderSeparadorDeMil,
			width_grid:120,
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PARDET.total',
		save_as:'total'
	};	
	
	// txt id_moneda
	Atributos[6]={
			validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:true,			
			emptyText:'Moneda...',
			desc: 'desc_moneda', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_moneda,
			valueField: 'id_moneda',
			displayField: 'valor',
			queryParam: 'filterValue_0',
			//filterCol:'MONEDA.nombre',
			typeAhead:true,
			tpl:tpl_id_moneda,
			forceSelection:true,
			mode:'remote',
			queryDelay:200,
			pageSize:100,
			minListWidth:200,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, //caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:false,
			grid_editable:false,
			width_grid:120,
			width:200,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		defecto: '1',
		//filterColValue:'MONEDA.nombre',
		save_as:'id_moneda'
	};	

	/*Atributos[6]={
		validacion:{
			labelSeparator:'',
			name: 'id_moneda',
			store:ds_moneda,						
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		id_grupo:0,
		save_as:'id_moneda'
	};*/
	
// txt id_fuente_financiamiento
	Atributos[7]={
			validacion:{
			name:'id_fuente_financiamiento',
			fieldLabel:'Fuente Financiamiento',
			allowBlank:true,			
			emptyText:'Fuente Financiamie...',
			desc: 'denominacion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_fuente_financiamiento,
			valueField: 'id_fuente_financiamiento',
			displayField: 'codigo_fuente',
			queryParam: 'filterValue_0',
			filterCol:'PRESUP.codigo_fuente#PRESUP.denominacion',
			typeAhead:true,
			tpl:tpl_id_fuente_financiamiento,
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
			renderer:render_id_fuente_financiamiento,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:'100%',
			disabled:true		
		},
		tipo:'ComboBox',
		form: false,
		filtro_0:true,
		id_grupo:0,
		filterColValue:'PRESUP.codigo_fuente',
		save_as:'id_fuente_financiamiento'
	};
	
	
	// txt id_parametro
	Atributos[8]={
			validacion:{
			name:'id_parametro',
			fieldLabel:'Gestión',
			allowBlank:true,			
			emptyText:'Parame...',
			desc: 'desc_parametro', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_parametro,
			valueField: 'id_parametro',
			displayField: 'gestion_pres',
			queryParam: 'filterValue_0',
			filterCol:'PARAMP.gestion_pres#PARAMP.estado_gral',
			typeAhead:true,
			tpl:tpl_id_parametro,
			forceSelection:true,
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
			renderer:render_id_parametro,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'50%',
			disabled:true		
		},
		tipo:'ComboBox',
		form: false,
		filtro_0:true,
		id_grupo:0,
		filterColValue:'PARAMP.gestion_pres',
		save_as:'id_parametro'
	};
	// txt gestion_pres
	Atributos[9]={
		validacion:{
			name:'gestion_pres',
			fieldLabel:'Gestión',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:false,
			grid_editable:false,
			width_grid:50,
			width:'50%',
			disabled:true		
		},
		tipo: 'NumberField',
		form: false,
		filtro_0:false,
		id_grupo:0,
		filterColValue:'PRESUP.gestion_pres',
		save_as:'gestion_pres'
	};
	
	/*Atributos[10]={
		validacion:{
			name: 'id_usuario_reg',
			labelSeparator:'',
			//inputType:'hidden',
			grid_visible:true,
			grid_editable:false,
		},
		tipo: 'Field',
		form: true,
		filtro_0:false,
		save_as:'id_usuario_reg'
	};*/
	
	Atributos[10]={
		validacion:{
			name:'usuario',
			fieldLabel:'Usuario Reg',
			allowBlank:true,
			allowDecimals:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			width:'95%',
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:200
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'PARDET.id_usuario_reg',
		save_as:'usuario'
	};

	Atributos[11]= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha de Registro',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			//renderer: formatDate,
			width_grid:105,
			//disabled:true	
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'PARDET.fecha_reg',
		dateFormat:'d-m-Y'
	};		

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'formulacion_presupuesto',grid_maestro:'grid-'+idContenedor};
	var layout_formulacion_presupuesto=new DocsLayoutMaestroEP(idContenedor);
	layout_formulacion_presupuesto.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_formulacion_presupuesto,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_save=this.Save;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var cm_EnableSelect=this.EnableSelect;
	
	/////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////
	var paramMenu={
		/*guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},*/
		actualizar:{crear:true,separador:false}
	};

	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	//datos necesarios para el filtro
	
	var paramFunciones=
	{
		//btnEliminar:{url:direccion+'../../../control/presupuesto/ActionEliminarFormulacionPresupuesto.php'},
		Save:{url:direccion+'../../../control/presupuesto/ActionGuardarFormulacionPresupuesto.php?sw_cambio_estado=si'},
		ConfirmSave:{url:direccion+'../../../control/presupuesto/ActionGuardarFormulacionPresupuesto.php'},
		Formulario:{
			html_apply:'dlgInfo-'+idContenedor,height:300,columnas:['90%'],
			grupos:
			[
				{tituloGrupo:'Datos',columna:0,id_grupo:0},
				{tituloGrupo:'Moneda',columna:0,id_grupo:1},
				{tituloGrupo:'Estructura Programatica',columna:0,id_grupo:2},
				{tituloGrupo:'Cambio',columna:0,id_grupo:3}
			],
			
			width:'30%',height:150,minWidth:150,minHeight:50,	
			closable:true,titulo:'Formulación del Presupuesto',
			guardar:abrirVentana
		}	
	};
	
	this.EnableSelect=function(sm,row,rec)
	{
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		enable(sm,row,rec);
	}
		
	function abrirVentana (){	
		if(sw_cambio=='si'){
			//paramFunciones.Save.parametros='&sw_cambiar_combo=si';
			ClaseMadre_save();
		}		
	}
	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	
	function btn_aprobar_pres_vigente()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect!=0)
		{			
			var sw=false;
			if(confirm('Esta seguro de APROBAR el presupuesto?'))
				sw=true
				
			if(sw)
			{
				var SelectionsRecord=sm.getSelections(); 			
	 			var arr_id_presupuesto = new Array;
	 			for(var i=0 ; i<NumSelect ; i++)
	 			{
					arr_id_presupuesto[i]=SelectionsRecord[i].data.id_presupuesto;
	 				
	 				Ext.Ajax.request({
					url:direccion+"../../../control/presupuesto_vigente/ActionEstadoPresupuesto.php",
					method:'POST',
					params:{cantidad_ids:NumSelect,id_presupuesto:arr_id_presupuesto[i],accion:'aprobar_pres_vigente'},
					success:cambio_Success,
					failure:ClaseMadre_conexionFailure,
					timeout:100000000
					});				
	 			}
			}		
		}
		else
		{
			Ext.MessageBox.alert('...', 'Antes debe seleccionar un registro.');
		}
	}	
	
	function btn_rechazar_pres_vigente()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect!=0)
		{				
			var sw=false;
			if(confirm('Esta seguro de RECHAZAR el presupuesto?'))
				sw=true
				
			if(sw)
			{
				var SelectionsRecord=sm.getSelections(); 			
	 			var arr_id_presupuesto = new Array;
	 			for(var i=0 ; i<NumSelect ; i++)
	 			{
					arr_id_presupuesto[i]=SelectionsRecord[i].data.id_presupuesto;
	 				
	 				Ext.Ajax.request({
					url:direccion+"../../../control/presupuesto_vigente/ActionEstadoPresupuesto.php",
					method:'POST',
					params:{cantidad_ids:NumSelect,id_presupuesto:arr_id_presupuesto[i],accion:'rechazar_pres_vigente'},
					success:cambio_Success,
					failure:ClaseMadre_conexionFailure,
					timeout:100000000
					});				
	 			}								
			}				
		}
		else
		{
			Ext.MessageBox.alert('...', 'Antes debe seleccionar un registro.');
		}
	}
	
	function cambio_Success(resp)
	{
		Ext.MessageBox.hide();
		if(resp.responseXML&&resp.responseXML.documentElement)
		{								
			ClaseMadre_btnActualizar();
		}
		else
		{
			ClaseMadre_conexionFailure();
		}
	}	
		
	function btn_detalle_presupuesto_vigente()
	{		
		sw_cambio="no";
		CM_ocultarGrupo('Datos');
		CM_ocultarGrupo('Estructura Programatica');
		CM_ocultarGrupo('Cambio');
		CM_mostrarGrupo('Moneda');
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var sm=getSelectionModel();
			var SelectionsRecord=sm.getSelected();
			data='m_id_presupuesto='+SelectionsRecord.data.id_presupuesto;
			data+='&m_id_parametro='+SelectionsRecord.data.id_parametro;
		 	data+='&m_nombre_financiador='+escape(SelectionsRecord.data.nombre_financiador);
			data+='&m_nombre_regional='+escape(SelectionsRecord.data.nombre_regional);
		 	data+='&m_nombre_programa='+escape(SelectionsRecord.data.nombre_programa);
		 	data+='&m_nombre_proyecto='+escape(SelectionsRecord.data.nombre_proyecto);
		 	data+='&m_nombre_actividad='+escape(SelectionsRecord.data.nombre_actividad);
		 	data+='&m_desc_unidad_organizacional='+escape(SelectionsRecord.data.desc_unidad_organizacional);
		 	
		 	if(prestoConfig.tipo_pres==undefined)
		 	{
		 		data+='&m_tipo_pres='+escape(SelectionsRecord.data.tipo_pres);
		 	}
		 	else
		 	{
		 		data+='&m_tipo_pres='+escape(prestoConfig.tipo_pres);
		 	}		 	
			
			data+='&m_id_moneda='+ds_moneda.getById(prueba.getValue()).data.id_moneda;
			data+='&m_desc_moneda='+ds_moneda.getById(prueba.getValue()).data.nombre;
			
			//Tipo de vista 2 es para solo consulta
			if(prestoConfig.tipo_vista==2){		 		
		 		data+='&m_tipo_vista='+prestoConfig.tipo_vista;
		 	}
		 	else
		 	{		 		
		 		data+='&m_tipo_vista=1';
		 	}
		 	
			//var ParamVentana={Ventana:{width:'90%',height:'80%'}}
			var ParamVentana={Ventana:{width:'100%',height:'100%'}}
			layout_formulacion_presupuesto.loadWindows(direccion+'../../../../sis_presupuesto/vista/detalle_presupuesto_vigente/detalle_presupuesto_vigente.php?'+data,'Detalle Presupuesto Vigente',ParamVentana);
					
		sm.clearSelections()
		}
		else
		{
			Ext.MessageBox.alert('...', 'Antes debe seleccionar un item.');
		}
	}
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	}
	
	function InitFormulacionPresupuesto()
	{
		grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		
		sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();
		for(i=0;i<Atributos.length;i++)
		{
			componentes[i]=ClaseMadre_getComponente(Atributos[i].validacion.name)
		}
	
	 	componentes[5].on('select',function (value,record,p)	//Obtenemos el id de la moneda
	 	{
			desc_moneda=record.data.nombre;
		})
		
	};
	
	
	var prueba = new Ext.form.ComboBox(
	{
			store: ds_moneda,
			displayField:'nombre',
			typeAhead: true,
			mode: 'remote',
			triggerAction: 'all',
			emptyText:'Seleccionar moneda...',
			selectOnFocus:true,
			width:135,
			valueField: 'id_moneda',
			editable:false,
			tpl:tpl_id_moneda		
	});
		
	var sw=1;
	ds_moneda.load({
			params:{
				start:0,
				limit: 1000000
			}
		}
	);
	
	ds_moneda.on('load',function(e,w)
	{
		if(sw==1)
		{			
			sw=0; 
			prueba.setValue(1)
	   	}
	});
	
	prueba.on('select',
		function(){		
			
			ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros: paramConfig.CantFiltros,
				s_tipo_pres:prestoConfig.s_tipo_pres,
				estado_gral:prestoConfig.estado_gral,
				estado_pres:prestoConfig.estado_gral,
				sw_colectivo:prestoConfig.sw_colectivo,
				sw_usuario:prestoConfig.sw_usuario,				 
				id_moneda: prueba.getValue(),
				id_gestion: gestion.getValue()
				}
			};	
		
		ClaseMadre_btnActualizar()		
	});	
	
	var gestion = new Ext.form.ComboBox(
	{
			store: ds_gestion,
			displayField:'gestion',
			typeAhead: true,
			mode: 'remote',
			triggerAction: 'all',
			emptyText:'Seleccionar gestión...',
			selectOnFocus:true,
			width:135,
			valueField: 'id_gestion',
			editable:false/*,
			tpl:tpl_id_moneda*/
	});
		
	var ban =1;
	ds_gestion.load({
			params:{
				start:0,
				limit: 1000000
			}
		}
	);
	
	ds_gestion.on('load',function(e,w)
	{
		if(ban == 1)
		{			
			ban = 0; 
			gestion.setValue(3)
	   	}
	});
	
	gestion.on('select',
		function(){		
			
			ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros: paramConfig.CantFiltros,
				s_tipo_pres:prestoConfig.s_tipo_pres,
				estado_gral:prestoConfig.estado_gral,
				estado_pres:prestoConfig.estado_gral,
				sw_colectivo:prestoConfig.sw_colectivo,
				sw_usuario:prestoConfig.sw_usuario,
				id_moneda: prueba.getValue(),				 
				id_gestion: gestion.getValue()
				}
			};	
		
		ClaseMadre_btnActualizar()		
	});	
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_formulacion_presupuesto.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
		
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	
	this.AdicionarBoton('../../../lib/imagenes/list-items.gif','Detalle de Presupuesto Vigente',btn_detalle_presupuesto_vigente,true,'detalle_presupuesto_vigente','Detalle de Presupuesto Vigente');
	
	this.AdicionarBotonCombo(prueba,'prueba');		//Adicionamos un combo para filtrar por moneda
	this.AdicionarBotonCombo(gestion,'gestion');		//Adicionamos un combo para filtrar por gestion
	
	this.AdicionarBoton('../../../lib/imagenes/ok.png','Aprobar el Presupuesto Vigente',btn_aprobar_pres_vigente,true,'aprobar_pres_vigente','Aprobar');
	//this.AdicionarBoton('../../../lib/imagenes/cross.gif','Rechazar el Presupuesto Vigente',btn_rechazar_pres_vigente,true,'rechazar_pres_vigente','Rechazar');
		
	var CM_getBoton=this.getBoton;		
	
	//carga datos XML
	
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros, 
			s_tipo_pres:prestoConfig.s_tipo_pres,
			estado_gral:prestoConfig.estado_gral,			
			estado_pres:prestoConfig.estado_gral,			
			sw_colectivo:prestoConfig.sw_colectivo,
			sw_usuario:prestoConfig.sw_usuario,
			id_moneda:'1',
			id_gestion:'3'
		}
	});
	
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	InitFormulacionPresupuesto();
		
	function enable(sm,row,rec)
	{		
		cm_EnableSelect(sm,row,rec);
		//alert(rec.data.estado_pres)
		
		if(rec.data.estado_pres == '5')//aprobado
		{
			CM_getBoton('aprobar_pres_vigente-'+idContenedor).disable();					
		}
		else
		{
			CM_getBoton('aprobar_pres_vigente-'+idContenedor).enable();
		}
	}
	
	layout_formulacion_presupuesto.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}