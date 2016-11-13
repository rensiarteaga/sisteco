<?php 
/**
 * Nombre:		  	    partida_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-07-07 11:38:59
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
    echo "var idSub='$idSub';";
	?>
var fa=false;
<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>
var paramConfig={TamanoPagina:20,TiempoEspera:1000000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa,idSub:decodeURI(idSub)};
var elemento={pagina:new pagina_partida_cuenta(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_partida.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-07-07 11:38:59
 */
function pagina_partida_cuenta(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var cmpSwDeha,cmpDebe,cmpSwRega;
	var	cmpHaber,cmpRecurso;
	var	cmpGasto,cmpDescParametro;
	var cmpNroCuenta,cmpNombreCuenta;
	var	cmpCodigoPartida,cmpNombrePartida;
	var cmpId_gestion;
	var g_id_gestion='';
	//---DATA STORE
	var ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/partida_cuenta/ActionListarPartidaCuenta.php'}),
		reader:new Ext.data.XmlReader({
		record:'ROWS',id:'id_partida_cuenta',totalRecords:'TotalCount'
		},[		
		'id_partida_cuenta',
		'id_debe',
		'debe',
		'id_haber',
		'haber',
		'id_recurso',
		'recurso',
		'id_gasto',
		'gasto',
		'sw_deha',
		'sw_rega',
		'id_parametro',
		'desc_parametro',
		'nro_cuenta',
		'nombre_cuenta',
		'codigo_partida',
		'nombre_partida'
		]),remoteSort:true});
	//carga datos XML
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	 var ds_gestion=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/gestion/ActionListarGestion.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_gestion',totalRecords:'TotalCount'},['id_gestion','id_empresa','id_moneda_base','gestion','estado_ges_gral'])
	});
	var tpl_id_gestion=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','<br><FONT COLOR="#B5A642"><b>Estado: </b>{estado_ges_gral}</FONT>','</div>');
	function renderDebe(value, p, record){return String.format('{0}', record.data['debe']);}
	function renderHaber(value, p, record){return String.format('{0}', record.data['haber']);}
	function renderRecurso(value, p, record){return String.format('{0}', record.data['recurso']);}
	function renderGasto(value, p, record){return String.format('{0}', record.data['gasto']);}
	// hidden id_partida
	//en la posición 0 siempre esta la llave primaria
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_partida_cuenta',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'id_partida_cuenta'
	};
// txt cargo_individual
	Atributos[1]={
		validacion:{
			name:'sw_deha',
			fieldLabel:'Tipo de Cuenta',
			allowBlank:false,
			typeAhead:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Debe'],['2','Haber']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			width:100
		},
		tipo:'ComboBox',
		save_as:'sw_deha'
		};
	Atributos[2]={
		validacion:{
			name:'id_debe',
			desc:'debe',
			fieldLabel:'Debe',
			tipo:'ingreso',//determina el action a llamar
			maxLength:100,
			minLength:0,
			gestion:2008,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true,
			grid_editable:false,
			renderer:renderDebe,
			width_grid:300,
			width:200,
			pageSize:50,
			direccion:direccion
		},
		tipo:'LovCuenta',
		save_as:'id_cuenta_debe'
		};
	Atributos[3]={
		validacion:{
			name:'id_haber',
			desc:'haber',
			fieldLabel:'Haber',
			tipo:'ingreso',//determina el action a llamar
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			gestion:2008,
			grid_visible:true,
			grid_editable:false,
			renderer:renderHaber,
			width_grid:300,
			width:200,
			pageSize:5,
			direccion:direccion
		},
		tipo:'LovCuenta',
		save_as:'id_cuenta_haber'
	};
	// txt cargo_individual
	Atributos[4]={
		validacion:{
			name:'sw_rega',
			fieldLabel:'Tipo de Partida',
			allowBlank:false,
			typeAhead:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Recurso'],['2','Gasto']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			width:100
		},
		tipo:'ComboBox',
		save_as:'sw_rega'
		};
	Atributos[5]={
		validacion:{
			name:'id_recurso',
			desc:'recurso',
			fieldLabel:'Recurso',
			tipo:'ingreso',//determina el action a llamar
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true,
			grid_editable:false,
			renderer:renderRecurso,
			width_grid:300,
			width:200,
			pageSize:5,
			direccion:direccion
		},
		tipo:'LovPartida',
		save_as:'id_partida_recurso'
	};
	Atributos[6]={
		validacion:{
			name:'id_gasto',
			desc:'gasto',
			fieldLabel:'Gasto',
			tipo:'gasto',//determina el action a llamar
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true,
			grid_editable:false,
			renderer:renderGasto,
			width_grid:300,
			width:200,
			pageSize:5,
			direccion:direccion
		},
		tipo:'LovPartida',
		save_as:'id_partida_gasto'
	};
    Atributos[7]={
		validacion:{
			labelSeparator:'',
			name:'id_parametro',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'id_parametro'
	};
  Atributos[8]={
		validacion:{
			name:'desc_parametro',
			desc:'desc_parametro',
			fieldLabel:'Gestión',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			width_grid:100,
			vtype:"texto",
			grid_visible:true,
			grid_editable:false
			},
		tipo:'TextField'
	};
	 Atributos[9]={
		validacion:{
			name:'nro_cuenta',
			desc:'nro_cuenta',
			fieldLabel:'Número de Cuenta',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:false,
			grid_editable:false
			},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'CUENTA.nro_cuenta',
	};
	 Atributos[10]={
		validacion:{
			name:'nombre_cuenta',
			desc:'nombre_cuenta',
			fieldLabel:'Cuenta',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:false,
			grid_editable:false
			},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'CUENTA.nombre_cuenta',
	};
	 Atributos[11]={
		validacion:{
			name:'codigo_partida',
			desc:'codigo_partida',
			fieldLabel:'Código de Partida',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:false,
			grid_editable:false
			},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'PARTID.codigo_partida',
	};
	Atributos[12]={
		validacion:{
			name:'nombre_partida',
			desc:'nombre_partida',
			fieldLabel:'Partida',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:false,
			grid_editable:false
			},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'PARTID.nombre_partida',
	};
	Atributos[13]={
		validacion:{
			labelSeparator:'',
			name:'id_gestion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		defecto:g_id_gestion,
		tipo:'Field',
		filtro_0:false,
		save_as:'id_gestion'
	};
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'partida',grid_maestro:'grid-'+idContenedor};
	var layout_partida_cuenta=new DocsLayoutMaestro(idContenedor);
	layout_partida_cuenta.init(config);
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_partida_cuenta,idContenedor);
	var ClaseMadre_getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_btnEliminar=this.btnEliminar;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_save=this.Save;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////
	var paramMenu={
		//guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false},
		excel:{crear:true,separador:false}
	};
	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/partida_cuenta/ActionEliminarPartidaCuenta.php'},
		Save:{url:direccion+'../../../control/partida_cuenta/ActionGuardarPartidaCuenta.php'},
		ConfirmSave:{url:direccion+'../../../control/partida_cuenta/ActionGuardarPartidaCuenta.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:280,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Partida - Cuenta'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
	    cmpSwDeha=ClaseMadre_getComponente('sw_deha');
	    cmpSwRega=ClaseMadre_getComponente('sw_rega');
		cmpDebe=ClaseMadre_getComponente('id_debe');
		cmpHaber=ClaseMadre_getComponente('id_haber');
		cmpRecurso=ClaseMadre_getComponente('id_recurso');
		cmpGasto=ClaseMadre_getComponente('id_gasto');
		cmpDescParametro=ClaseMadre_getComponente('desc_parametro');
		cmpNroCuenta=ClaseMadre_getComponente('nro_cuenta');
		cmpNombreCuenta=ClaseMadre_getComponente('nombre_cuenta');
		cmpCodigoPartida=ClaseMadre_getComponente('codigo_partida');
		cmpNombrePartida=ClaseMadre_getComponente('nombre_partida');
		cmpId_gestion=ClaseMadre_getComponente('id_gestion');
		
		var onSwDehaSelect=function(e){
			
			var id=cmpSwDeha.getValue();
			//alert(id+"es sw debe haber ")
			if(id==1){
				cmpSwRega.enable();
				CM_mostrarComponente(cmpDebe);
				cmpDebe.store.baseParams={m_sw_partida_cuenta:'si',m_id_gestion:g_id_gestion};
				cmpDebe.modificado=true; 
				//componentes[7].store.baseParams={sw_reg_comp:'si',m_id_presupuesto:var_id_presupuesto};	
				
				CM_ocultarComponente(cmpHaber);
				cmpDebe.setValue('');
				cmpHaber.setValue('');
				cmpHaber.allowBlank=true;
				cmpDebe.allowBlank=false
			}
			else{
				cmpSwRega.enable();
				CM_mostrarComponente(cmpHaber);
				cmpHaber.store.baseParams={m_sw_partida_cuenta:'si',m_id_gestion:g_id_gestion};
				cmpHaber.modificado=true;
				CM_ocultarComponente(cmpDebe);
				cmpDebe.setValue('');
				cmpHaber.setValue('');
				cmpHaber.allowBlank=false;
				cmpDebe.allowBlank=true
			}
		};
		var onSwRegaSelect=function(e){
			var id=cmpSwRega.getValue()
			if(id==1){
				CM_mostrarComponente(cmpRecurso);
				CM_ocultarComponente(cmpGasto);
				cmpRecurso.store.baseParams={m_sw_partida_cuenta:'si',m_id_gestion:g_id_gestion};
				cmpRecurso.modificado=true;
				cmpRecurso.setValue('');
				cmpGasto.setValue('');
				cmpGasto.allowBlank=true;
				cmpRecurso.allowBlank=false
			}
			else{
				CM_mostrarComponente(cmpGasto);
				CM_ocultarComponente(cmpRecurso);
				cmpGasto.store.baseParams={m_sw_partida_cuenta:'si',m_id_gestion:g_id_gestion};
				cmpGasto.modificado=true;
				cmpRecurso.setValue('');
				cmpGasto.setValue('');
				cmpGasto.allowBlank=false;
				cmpRecurso.allowBlank=true
			}
		};
		cmpSwDeha.on('select',onSwDehaSelect);
	    cmpSwDeha.on('change',onSwDehaSelect);
	    cmpSwRega.on('select',onSwRegaSelect);
	    cmpSwRega.on('change',onSwRegaSelect)
	}
   this.btnNew=function(){
   	cmpSwRega.disable();
   	CM_ocultarComponente(cmpDescParametro);
   	CM_ocultarComponente(cmpDebe);
   	CM_ocultarComponente(cmpHaber);
   	CM_ocultarComponente(cmpRecurso);
   	CM_ocultarComponente(cmpGasto);
   	CM_ocultarComponente(cmpNroCuenta);
   	CM_ocultarComponente(cmpNombreCuenta);
   	CM_ocultarComponente(cmpCodigoPartida);
   	CM_ocultarComponente(cmpNombrePartida);
   	ClaseMadre_btnNew()
   };
  
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_partida_cuenta.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones		
	this.iniciaFormulario();
	iniciarEventosFormularios();
	
   var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/gestion/ActionListarGestion.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_gestion',totalRecords:'TotalCount'},['id_gestion','gestion','estado_ges_gral','id_empresa','desc_empresa','id_moneda_base','desc_moneda']),baseParams:{sw_partida_cuenta:'si',m_id_empresa:1}});
   var tpl_gestion=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','</div>');
   var gestion =new Ext.form.ComboBox({
		store: ds_gestion,
		displayField:'gestion',
		typeAhead: true,
		mode: 'remote',
		triggerAction: 'all',
		emptyText:'gestion...',
		selectOnFocus:true,
		width:100,
		valueField: 'id_gestion',
		tpl:tpl_gestion
	});
  
   gestion.on('select',function (combo, record, index){g_id_gestion=gestion.getValue();
   ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_gestion:g_id_gestion,
			m_sw_partida_cuenta:'si'
			}
		});	
   		cmpId_gestion.setValue(g_id_gestion);
   });
   
   this.AdicionarBotonCombo(gestion,'gestion');														
   layout_partida_cuenta.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
   ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}