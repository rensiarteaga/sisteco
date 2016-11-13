<?php 
/**
 * Nombre:		  	    eeff_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-13 16:28:12
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
	var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
	var elemento={pagina:new pagina_eeff_compara(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
	_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
* Nombre:		  	    pagina_eeff_compara.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2013-03-13 18:03:05
*/
function pagina_eeff_compara(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var on, cotizacion;
	var componentes=new Array();
	var dialog;
	var habilita_hijo='si';
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/eeff_compara/ActionListarEeffCom.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'id_eeff',totalRecords:'TotalCount'
		},[
		   'id_eeff',
			'id_gestion_act',
			'desges_act',
			'id_gestion_ant',
			'desges_ant',
			'id_moneda',
			'nombre_moneda',
			'sw_eeff',
			'eeff_fecha',
			
		]),remoteSort:true});
	
	/*DATA STORE COMBOS */
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	
	var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/gestion/ActionListarGestion.php?tipo_vista=cobra_sis'}),
		reader: new Ext.data.XmlReader({record:'ROWS',id:'id_gestion',totalRecords:'TotalCount'},['id_gestion','id_empresa','desc_empresa','id_moneda_base','desc_moneda','gestion','estado_ges_gral'])
	});
	
	var ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
    	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
    });
	

	/*FUNCIONES RENDER*/
	function render_id_gestion(value, p, record){return String.format('{0}', record.data['desges_act']);}
	var tpl_id_gestion=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','</div>');	
	
	function render_id_moneda(value,p,record){return String.format('{0}', record.data['nombre_moneda']);}
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<FONT COLOR="#B50000"><b> - </b>{simbolo}</FONT>','</div>');
	
	
	function render_eeff(value, p, record){	
		if(value=='anual'){return 'ANUAL';}
		if(value=='afecha_ambos'){return 'A FECHA AMBOS';}	
		if(value=='afecha_anual'){return 'A FECHA ANUAL';}	
	}
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	//en la posición 0 siempre esta la llave primaria

   Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_eeff',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_eeff',
		id_grupo:0
   };
   
 
   
   Atributos[1]={
		validacion:{
			name:'id_gestion_act',
			fieldLabel:'Gestión Vigente',
			allowBlank:false,
			emptyText:'Gestión...',
			desc: 'desges_act', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_gestion,
			valueField: 'id_gestion',
			displayField: 'gestion',
			queryParam: 'filterValue_0',
			filterCol:'GES.gestion',
			typeAhead:false,
			tpl:tpl_id_gestion,
			forceSelection:true,
			mode:'remote',
			queryDelay:150,
			pageSize:100,
			minListWidth:150,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_gestion,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:100,
			align:'center',
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'GES.gestion',
		save_as:'id_gestion_act',
		id_grupo:0			
   };
   
   Atributos[2]={
		validacion:{
			labelSeparator:'',
			name: 'id_gestion_ant',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_gestion_ant',
		id_grupo:0
   };
   
   Atributos[3]={
		validacion:{
			name:'desges_ant',
			fieldLabel:'Gestión Anterior',
			allowBlank:true,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:100,
			align:'center',
			disabled:false
		},
		tipo: 'TextField',
		form:false,
		filtro_0:true,
		filterColValue:'GEA.gestion',
		save_as:'desges_ant',
		id_grupo:0
	};
   Atributos[4]={
			validacion:{
				name:'sw_eeff',
				fieldLabel:'EEFF',
				allowBlank:false,
				align:'center', 
				emptyText:'...',
				loadMask:true,
				maxLength:50,
				minLength:0,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['anual','ANUAL'],['afecha_ambos','A FECHA AMBOS'],['afecha_anual','A FECHA ANUAL']]}),
				valueField:'ID',
				displayField:'valor',
				mode:'local',
				lazyRender:true,			
				forceSelection:true,
				grid_visible:true,
				grid_editable:false,
				renderer:render_eeff,
				width_grid:100,
				minListWidth:100,
				width:100,
				disabled:false
			},
			tipo:'ComboBox',
			form: true,
			save_as:'sw_eeff'
		};
	   	
   	Atributos[5]={
		validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:false,			
			emptyText:'Moneda...',
			desc: 'nombre_moneda', //indica la columna del store principal ds del que proviane la descripcion
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
			pageSize:100,
			minListWidth:200,
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:200,
			disable:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'MON.nombre',
		save_as:'id_moneda',
		id_grupo:0
	};
   
 	Atributos[6]= {
 			validacion:{
 				name:'eeff_fecha',
 				fieldLabel:'Generado el',
 				allowBlank:true,
 				format :'d/m/Y',
   				minValue :'01/01/1900',
   				//renderer :formatDate,
   				selectOnFocus:true,
 				grid_visible:true,
 				grid_editable:true,
 				width_grid:120,				
 				disabled:false
 			},
 			id_grupo :0,
   			tipo :'DateField',
   			save_as :'eeff_fecha',
   			dateFormat :'m/d/Y',
   			defecto :""
 			
 		};
   	
 
    //////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	//function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	// ---------- FUNCIONES RENDER ---------------//
	function formatDate(value) {
		return value ? value.dateFormat('d/m/Y') : ''
	}
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'EEFF',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_presupuesto/vista/eeff_compara/eeff_linea.php'};
	//var config={titulo_maestro:'EEFF',grid_maestro:'grid-'+idContenedor};
    layout_eeff=new DocsLayoutMaestroDeatalle(idContenedor);
	layout_eeff.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	this.pagina=Pagina;
	
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_eeff,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_saveSuccess=this.saveSuccess;
	var CM_conexionFailure=this.conexionFailure;
	var CM_btnEdit=this.btnEdit;
	var CM_btnNew=this.btnNew;
	var CM_btnEliminar=this.btnEliminar;
	var cmbtnActualizar=this.btnActualizar;
	var Cm_getDialog=this.getDialog;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var enableSelect=this.EnableSelect;

	var ClaseMadre_getComponente = this.getComponente;	
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////
	var paramMenu={
		//guardar:{crear:true,separador:false},
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
		btnEliminar:{url:direccion+'../../../control/eeff_compara/ActionEliminarEeffCom.php'},
		Save:{url:direccion+'../../../control/eeff_compara/ActionGuardarEeffCom.php'},
		ConfirmSave:{url:direccion+'../../../control/eeff_compara/ActionGuardarEeffCom.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:500,width:480,minWidth:150,minHeight:200,closable:true,titulo:'EEFF Comparativo',
			grupos:[{	
				tituloGrupo:'Datos Generales',
				columna:0,
				id_grupo:0
			}]
		}
	};
			
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		//para iniciar eventos en el formulario
		eeff_fecha = ClaseMadre_getComponente('eeff_fecha');
		dialog=Cm_getDialog();
		getSelectionModel().on('rowdeselect',function(){	
			if(_CP.getPagina(layout_eeff.getIdContentHijo()).pagina.limpiarStore()){}
		})
		for(var i=0; i<Atributos.length; i++)
		{
			componentes[i]=ClaseMadre_getComponente(Atributos[i].validacion.name)
		}
		
		CM_ocultarComponente(eeff_fecha);
		//componentes[1].on('select',evento_parametro);		//parametro	
		componentes[4].on('select',evento_sw_eeff);	
	}
	
	
	function evento_parametro( combo, record, index )
	{
		
		
		//Validación de fechas
		var id = componentes[0].getValue();
		CM_mostrarComponente(eeff_fecha);
		if(componentes[0].store.getById(id)!=undefined){
			
			var intGestion=componentes[0].store.getById(id).data.gestion;
			var dte_fecha_ini_valid=new Date('01/01/'+intGestion+' 00:00:00');
			var dte_fecha_fin_valid=new Date('12/31/'+intGestion+' 00:00:00');
				
			//Aplica la validación en la fecha
			componentes[6].minValue=dte_fecha_ini_valid; //Fecha inicio
			componentes[6].maxValue=dte_fecha_fin_valid;
			//Define un valor por defecto
			componentes[6].setValue(dte_fecha_ini_valid);
				
		}
		
		
	}	

	function evento_sw_eeff( combo, record, index )
	{
		
		//Validación de fechas
		var sw_eeff = componentes[4].getValue();
		if (sw_eeff=='afecha_ambos' || sw_eeff=='afecha_anual'){
			CM_mostrarComponente(eeff_fecha);
			var id = componentes[1].getValue();
			//var intGestion=componentes[0].store.getById(id).data.gestion_pres;
			var intGestion=componentes[1].store.getById(id).data.gestion;
			var dte_fecha_ini_valid=new Date('01/01/'+intGestion+' 00:00:00');
			var dte_fecha_fin_valid=new Date('12/31/'+intGestion+' 00:00:00');
				
			//Aplica la validación en la fecha
			componentes[6].minValue=dte_fecha_ini_valid; //Fecha inicio
			componentes[6].maxValue=dte_fecha_fin_valid;
				//Define un valor por defecto
			componentes[6].setValue(dte_fecha_ini_valid);
		}else{

			CM_ocultarComponente(eeff_fecha);
			}
		
	}	
	this.EnableSelect=function(x,z,y){
		//acciones hijo
	    _CP.getPagina(layout_eeff.getIdContentHijo()).pagina.reload(y.data);
		_CP.getPagina(layout_eeff.getIdContentHijo()).pagina.bloquearMenu();
	    _CP.getPagina(layout_eeff.getIdContentHijo()).pagina.desbloquearMenu();
	    
	    //acciones padre	
	    enableSelect(x,z,y);	
	    _CP.getPagina(idContenedor).pagina.bloquearMenu();
	    _CP.getPagina(idContenedor).pagina.desbloquearMenu();
	}
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_eeff.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	
	//para agregar botones
	/*this.AdicionarBoton('../../../lib/imagenes/a_xp.png','Notas al Estado Financiero',btn_nota,true,'eeff_nota','Notas');
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Emisión del EEFF Comparativo',btn_eeff_jasper,true,'eeff_jasper','EEFF');
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Emisión de Notas al EEFF',btn_nota_jasper,true,'eeff_nota_jasper','Notas');
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Emisión del EEFF Comparativo por Nivel',btn_eeffniv_jasper,true,'eeff_jasper','EEFF x Nivel');
	*/
	var CM_getBoton=this.getBoton;
 
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_eeff.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
