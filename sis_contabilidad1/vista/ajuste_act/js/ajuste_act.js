/**
* Nombre:		  	    pagina_ajuste_act.js
* Propósito: 			pagina objeto principal
* Autor:				RCM
* Fecha creación:		01/12/2008
*/
function pagina_ajuste_act(idContenedor,direccion,paramConfig)
{
	var Atributos=new Array;
	var cmb_gestion,cmb_periodo,intGestion,intPeriodo,dte_fecha_ini,dte_fecha_fin;

	//STORE's
	var ds_depto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamento.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_depto',totalRecords:'TotalCount'},['id_depto','codigo_depto','nombre_depto','estado','id_subsistema','nombre_corto','nombre_largo']),baseParams:{m_id_subsistema:9}});
	var	ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_parametro',totalRecords: 'TotalCount'}, ['id_parametro','id_gestion','desc_gestion','estado_gestion','gestion_conta'])});
	var ds_periodo_subsis = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/periodo_subsistema/ActionListarPeriodoGestionSubsis.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_periodo_subsistema',totalRecords: 'TotalCount'}, ['id_periodo_subsistema','id_periodo','desc_periodo','estado_periodo','periodo'])});
	var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),baseParams:{sw_reg_comp:'si'}});

	//FUNCIONES RENDER

	function formatDate(value){return value ? value.dateFormat('d/m/Y') : '';};
	function render_id_depto(value, p, record){return String.format('{0}', record.data['nombre_depto']);}
	function render_id_moneda(value, p, record){rf = ds_moneda.getById(value);	 
	if(rf!=null){record.data['id_moneda'] =rf.data['id_moneda'];record.data['desc_moneda'] =rf.data['nombre'];}
		return String.format('{0}',record.data['desc_moneda'])}
	
	var tpl_id_depto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642"><b>Departamento Contable: </b></FONT"><br><FONT COLOR="#000000">{nombre_depto}</FONT>','</div>');				
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b>{nombre}</b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
	

	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	Atributos[0]={
			validacion:{
			name:'id_depto',
			fieldLabel:'Departamento',
			allowBlank:false,			
			emptyText:'Departamento...',
			desc: 'nombre_depto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_depto,
			valueField: 'id_depto',
			displayField: 'nombre_depto',
			queryParam: 'filterValue_0',
			//filterCol:'MONEDA.nombre',
			typeAhead:false,
			tpl:tpl_id_depto,
			forceSelection:false,
			mode:'remote',
			queryDelay:50,
			pageSize:20,
			//minListWidth:'50%',
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_depto,
			grid_visible:false,
			grid_editable:true,
			width_grid:50,
			width:300,
			disable:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		//filterColValue:'MONEDA.nombre',
		save_as:'id_depto'
	};	

	filterCols_parametro=new Array();
	filterValues_parametro=new Array();
	filterCols_parametro[0]='estado_gestion';
	filterValues_parametro[0]='2';
	Atributos[1]= {
		validacion: {
			name: 'gestion',
			fieldLabel:'Gestión',
			allowBlank:false,
			emptyText:'Gestión...',
			desc: 'gestion',
			store:ds_gestion,
			valueField: 'id_parametro',
			displayField: 'desc_gestion',
			queryParam: 'filterValue_0',
			filterCols:filterCols_parametro,
			filterValues:filterValues_parametro,
			typeAhead:false,
			forceSelection:false,
			mode:'remote',
			queryDelay:250,
			pageSize:20,
			minListWidth:250,
			grow:true,
			width:150,
			minChars:1,
			triggerAction:'all',
			editable:true
		},
		tipo:'ComboBox',
		save_as:'id_parametro'
	};


	filterCols_periodo=new Array();
	filterValues_periodo=new Array();
	filterCols_periodo[0]='PERIOD.id_gestion';
	filterValues_periodo[0]='x';
	filterCols_periodo[1]='PERSIS.estado_periodo';
	filterValues_periodo[1]='abierto';
	filterCols_periodo[2]='PERSIS.id_subsistema';
	filterValues_periodo[2]='12';
	//filterCols_periodo[4]='PERIOD.estado_peri_gral';
	//filterValues_periodo[4]='abierto';

	Atributos[2]= {
		validacion: {
			name: 'id_periodo_subsis',
			fieldLabel:'Período',
			allowBlank:false,
			emptyText:'Período...',
			desc: 'desc_periodo',
			store:ds_periodo_subsis,
			valueField: 'id_periodo_subsistema',
			displayField: 'desc_periodo',
			filterCols:filterCols_periodo,
			filterValues:filterValues_periodo,
			typeAhead:false,
			forceSelection:false,
			mode:'remote',
			queryDelay:250,
			pageSize:20,
			minListWidth:250,
			grow:true,
			width:150,
			minChars:1,
			triggerAction:'all',
			editable:true
		},
		tipo:'ComboBox',
		save_as:'id_periodo_subsis'
	};

	/*Atributos[1]={
	validacion:{
	name:'periodo',
	fieldLabel:'Período',
	allowBlank:false,
	typeAhead:false,
	loadMask:true,
	triggerAction:'all',
	store:new Ext.data.SimpleStore({fields:['ID','valor'],data:Ext.ajuste_actCombo.periodo}),
	valueField:'ID',
	displayField:'valor',
	lazyRender:true
	},
	tipo:'ComboBox',
	save_as:'periodo'
	};*/
	
	Atributos[3]= {
		validacion:{
			name:'fecha_ini',
			fieldLabel:'Fecha Inicio',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/2000',
			disabledDaysText: 'Día no válido',
			renderer: formatDate
		},
		tipo:'DateField',
		dateFormat:'m-d-Y',
		save_as:'fecha_ini'
	};

	Atributos[4]= {
		validacion:{
			name:'fecha_fin',
			fieldLabel:'Fecha Fin',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/2000',
			disabledDaysText: 'Día no válido',
			renderer: formatDate
		},
		tipo:'DateField',
		dateFormat:'m-d-Y',
		save_as:'fecha_fin'
	};
	
	Atributos[5]={
			validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda Cuentas',
			allowBlank:false,			
			emptyText:'Moneda...',
			desc: 'desc_moneda', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_moneda,
			valueField: 'id_moneda',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'MONEDA.nombre',
			typeAhead:false,
			tpl:tpl_id_moneda,
			forceSelection:true,
			mode:'remote',
			queryDelay:200,
			pageSize:10,
			minListWidth:200,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:true,
			grid_editable:true,
			width_grid:150,
			width:200,
			disabled:false		
		},
		tipo:'ComboBox',
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda'
	};
	
	/*Atributos[3]= {
		validacion:{
			name:'fecha_ini',
			inputType:'hidden',
			format: 'd/m/Y',
			labelSeparator:''
		},
		tipo:'DateField',
		dateFormat:'m-d-Y',
		save_as:'fecha_ini'
	};
	
	Atributos[4]= {
		validacion:{
			name:'fecha_fin',
			labelSeparator:'',
			inputType:'hidden',
			format: 'd/m/Y'
		},
		tipo:'DateField',
		dateFormat:'m-d-Y',
		save_as:'fecha_fin'
	};*/


	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};
	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////
	//Inicia Layout
	var config={
		titulo_maestro:'Ajuste por Actualización'

	};
	layout=new DocsLayoutProceso(idContenedor);
	layout.init(config);
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,layout,idContenedor);

	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_ocultarTodosComponente=this.ocultarTodosComponente;
	var CM_mostrarTodosComponente=this.mostrarTodosComponente;

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	function obtenerTitulo()
	{
		//var combo_financiador = ClaseMadre_getComponente('id_financiador');
		var titulo = "Ajuste por Actualización";

		return titulo;
	}

	//datos necesarios para el filtro
	var paramFunciones = {

		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:'70%',
		url:direccion+'../../../control/ajuste_act/ActionAjusteAct.php',
		abrir_pestana:false, //abrir pestana
		titulo_pestana:obtenerTitulo,
		fileUpload:false,
		width:'70%',
		columnas:['50%'],
		minWidth:150,minHeight:200,	closable:true,titulo:'Almacen',
		grupos:[
		{	tituloGrupo:'Parámetros',
		columna:0,
		id_grupo:0
		}


		]}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios(){
		cmb_gestion = ClaseMadre_getComponente('gestion');
		cmb_periodo = ClaseMadre_getComponente('id_periodo_subsis');
		dte_fecha_ini = ClaseMadre_getComponente('fecha_ini');
		dte_fecha_fin = ClaseMadre_getComponente('fecha_fin');

		var onGestionSelect = function(e) {
			var id = cmb_gestion.getValue();
			if(cmb_gestion.store.getById(id)!=undefined){
				id_gestion=cmb_gestion.store.getById(id).data.id_gestion;
				intGestion=cmb_gestion.store.getById(id).data.desc_gestion;
				
				cmb_periodo.filterValues[0]=id_gestion;
				cmb_periodo.modificado = true;
				cmb_periodo.setValue('');
			}
		};

		var onPeriodoSelect = function(e) {
			var id = cmb_periodo.getValue();
			if(cmb_periodo.store.getById(id)!=undefined){
				intPeriodo=cmb_periodo.store.getById(id).data.periodo;
				
				//Define límites de la fecha
				if(intPeriodo==1||intPeriodo==3||intPeriodo==5||intPeriodo==7||intPeriodo==8||intPeriodo==10||intPeriodo==12){
					dte_fecha_fin_valid = intPeriodo+'/31/'+intGestion;
				}
				else if(intPeriodo==2){
					if((intGestion%4==0)&((intGestion%100!=0)||(intGestion%400==0))){
						dte_fecha_fin_valid = intPeriodo+'/29/'+intGestion;
					}
					else {
						dte_fecha_fin_valid = intPeriodo+'/28/'+intGestion;
					}
				}
				else{ //4,6,9,11
					dte_fecha_fin_valid = intPeriodo+'/30/'+intGestion;
				}
				
				dte_fecha_ini_valid = intPeriodo+'/01/'+intGestion+' 00:00:00';
				dte_fecha_fin_valid = dte_fecha_fin_valid+' 00:00:00';
				
				//Instancia un objeto fecha con los datos obtenidos para que el DateFIeld los acepte sin problema
				dte_fecha_ini_valid=new Date(dte_fecha_ini_valid);
				dte_fecha_fin_valid=new Date(dte_fecha_fin_valid);
		
				//Aplica la validación en la fecha
				dte_fecha_ini.minValue=dte_fecha_ini_valid;
				dte_fecha_ini.maxValue=dte_fecha_fin_valid;
				dte_fecha_fin.minValue=dte_fecha_ini_valid;
				dte_fecha_fin.maxValue=dte_fecha_fin_valid;
				
				//Define una fecha por defecto para ambas fechas
				dte_fecha_ini.setValue(dte_fecha_ini_valid);
				dte_fecha_fin.setValue(dte_fecha_fin_valid);
			
			}
		};
		
		var onFechaFinChange=function(e){
			dte_fecha_ini.maxValue=dte_fecha_fin.getValue();
		}

		cmb_gestion.on('select',onGestionSelect);
		cmb_gestion.on('change',onGestionSelect);
		//cmb_periodo.on('select',onPeriodoSelect);
		cmb_periodo.on('change',onPeriodoSelect);
		dte_fecha_fin.on('change',onFechaFinChange);
		
	}

	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init(); //iniciamos la clase madre
	//this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones

	this.iniciaFormulario();
	iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
