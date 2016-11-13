<?php 
/**
 * Nombre:		  	    config_aprobador_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-06 21:05:13
 *
 */
session_start();
?>
//<script>
//var paginaTipoActivo;

	function main(){
	 	<?php
		//obtenemos la ruta absoluta
		$host  = $_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$dir = "http://$host$uri/";
		echo "\nvar direccion='$dir';";
	    echo "var idContenedor='$idContenedor';";
	?>
	var fa;
	<?php if($_SESSION["ss_filtro_avanzado"]!=''){
		echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}
	?>
var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var elemento={pagina:new pagina_config_aprobador(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_config_aprobador_main.js
 * Propï¿½sito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creaciï¿½n:		2007-11-06 21:05:13
 */
function pagina_config_aprobador(idContenedor,direccion,paramConfig)
{	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/config_aprobador/ActionListarConfigAprobador.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_config_aprobador',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_config_aprobador',
		'id_gestion',
		'gestion',
		'id_presupuesto',
		'desc_presupuesto',
		'id_uo',
		'nombre_unidad',
		'concepto',
		'min_monto',
		'max_monto',
		'id_empleado',
		'nombre_completo',
		
		//{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'prioridad',
		'estado',
		//'fecha_expiracion',
		{name: 'fecha_expiracion',type:'date',dateFormat:'Y-m-d'},
		'usuario_reg',
		'fecha_reg',
		'usuario_mod',
		'fecha_mod',
		]),remoteSort:true});
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	//DATA STORE COMBOS
    var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/gestion/ActionListarGestion.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_gestion',totalRecords:'TotalCount'},['id_gestion','gestion','estado_ges_gral','id_empresa','desc_empresa','id_moneda_base','desc_moneda']),baseParams:{estado:'abierto'}});
	   
    var ds_uo = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarUnidadOrganizacional.php?m_sw_presupuesto=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_organizacional',totalRecords: 'TotalCount'},
			['id_unidad_organizacional','nombre_unidad','nombre_cargo','centro','cargo_individual','descripcion','fecha_reg','id_nivel_organizacional','estado_reg','nombre_nivel']),baseParams:{start:0,limit: paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,sw_presto:1}
	});
	
	var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/presupuesto/ActionListarComboPresupuesto.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','tipo_pres','estado_pres','id_unidad_organizacional','nombre_unidad','id_fina_regi_prog_proy_acti',
																																								'desc_epe','id_fuente_financiamiento','sigla','estado_gral','gestion_pres','id_parametro','id_gestion','desc_presupuesto',
																																								'nombre_financiador', 'nombre_regional', 'nombre_programa', 'nombre_proyecto', 'nombre_actividad',
																																								'id_categoria_prog','cod_categoria_prog',   'cp_cod_programa','cp_cod_proyecto','cp_cod_actividad',
																																								'cp_cod_organismo_fin','cp_cod_fuente_financiamiento','codigo_sisin'
																																								 ]),baseParams:{m_sw_rendicion:'si',sw_inv_gasto:'si'}
	});
	var ds_empleado = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords: 'TotalCount'},['id_empleado','desc_persona','apellido_paterno','apellido_materno','nombre','codigo_empleado'])
	    });
	
	var tpl_gestion=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','</div>');
	var tpl_empleado=new Ext.Template('<div class="search-item">','{desc_persona}','</div>');
	var tpl_uo=new Ext.Template('<div class="search-item">','<b>{nombre_unidad}</b>','<br><FONT COLOR="#B5A642"><b>Unidad de Aprobaciï¿½n: </b>{centro}</FONT>','<br><FONT COLOR="#B5A642"><b>Jerarquia: </b>{nombre_nivel}</FONT>','</div>');
	var tpl_presupuesto=new Ext.Template('<div class="search-item">',
		'<b>{nombre_unidad}</b>',
		'<br><b>Gestiï¿½n: </b><FONT COLOR="#B5A642">{gestion_pres}</FONT>',
		'<br><b>Tipo Presupuesto: </b><FONT COLOR="#B50000">{tipo_pres}</FONT>',
		'<br><b>Fuente de Financiamiento: </b><FONT COLOR="#B5A642">{sigla}</FONT>',		
		'<br>  <b>EP:  </b><FONT COLOR="#B5A642">{desc_epe}</FONT></b>',
		'<br>  <FONT COLOR="#B50000">{nombre_financiador}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_regional}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_programa}</FONT>',
		'<br>  <FONT COLOR="#B50000">{nombre_proyecto}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_actividad}</FONT>',	
		'<br><FONT COLOR="#B50000"><b>Cat. Programatica: </b>{cod_categoria_prog}</FONT>',  
		'<br><FONT COLOR="#B50000"><b>Identificador: </b>{id_presupuesto}</FONT>',  
		'</div>'); 
	//FUNCIONES RENDER
    function render_gestion(value, p, record){return String.format('{0}', record.data['gestion']);}
	function render_uo(value, p, record){return String.format('{0}', record.data['nombre_unidad']);}
	function render_presupuesto(value, p, record){return String.format('{0}', record.data['desc_presupuesto']);}
	function render_empleado(value, p, record){return String.format('{0}', record.data['nombre_completo']);}
	function render_concepto(value){
		if(value=='compro'){value='Compro'}
		if(value=='viaticos'){value='Viaticos'}
		if(value=='cajas'){value='Cajas'}
		if(value=='avance'){value='Fondo en Avance'}
		if(value=='diesel'){value='Diesel'}
		if(value=='devengados'){value='TESORO - Pagos Devengados'}
		
		if(value=='todos'){value='Todos'}		
		return value
	}
	/////////////////////////
	// Definiciï¿½n de datos //
	/////////////////////////
	// hidden id_contratista
	//en la posiciï¿½n 0 siempre esta la llave primaria
	vectorAtributos[0]= {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_config_aprobador',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_config_aprobador'
	};
	 
// txt codigo1
	vectorAtributos[1]= {
		validacion:{
			fieldLabel:'Gestion',
		    allowBlank:false,
		    vtype:'texto',
		    emptyText:'Gestion...',
		    name:'id_gestion',
		    desc:'gestion',
		    store:ds_gestion,
		    valueField:'id_gestion',
		    displayField:'gestion',
		    queryParam:'filterValue_0',
		    filterCol:'GESTIO.gestion',
		    typeAhead:true,
		    forceSelection:true,
		    renderer:render_gestion,
		    tpl:tpl_gestion,
		    mode:'remote',
		    queryDelay:50,
		    pageSize:10,
		    minListWidth:230,
		    width:250,
		    resizable:true,
		    minChars:0,
		    triggerAction:'all',
		    editable:true,
		    grid_visible:true,
		    grid_editable:false,
		    width_grid:100
		},
		tipo:'ComboBox',
	    filtro_0:true,
	    filterColValue:'GESTI.gestion',
	    save_as:'txt_id_gestion'
	};
	
	// txt id_institucion5
	vectorAtributos[3]= {
			validacion: {
			name:'id_uo',
			fieldLabel:'UO',
			allowBlank:true,			
			emptyText:'UO...',
			desc:'nombre_unidad', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_uo,
			valueField:'id_unidad_organizacional',
			displayField:'nombre_unidad',
			queryParam:'filterValue_0',
			filterCol:'UNIORG.nombre_unidad',
			typeAhead:true,
			forceSelection:true,
			tpl:tpl_uo,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:250,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_uo,
			grid_visible:true,
			grid_editable:true,
			width_grid:200 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'UNIORG.nombre_unidad',
		defecto: '',
		save_as:'txt_id_uo'
	};
// txt id_institucion5
	vectorAtributos[4]= {
			validacion: {
			name:'id_presupuesto',
			fieldLabel:'Presupuesto',
			allowBlank:true,			
			emptyText:'Presupuesto...',
			desc:'desc_presupuesto', //indica la columna del store principal ds del que proviane la descripcion 
			store:ds_presupuesto,
			valueField:'id_presupuesto',
			displayField:'desc_presupuesto',
			queryParam:'filterValue_0',
			filterCol:'presup.desc_presupuesto#presup.id_presupuesto#CATPRO.cod_categoria_prog',
			typeAhead:true,
			forceSelection:true,
			tpl:tpl_presupuesto,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:250,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda 
			triggerAction:'all',
			editable:true,
			renderer:render_presupuesto,
			grid_visible:true,
			grid_editable:true,
			width_grid:160 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PRESU.desc_presupuesto',
		defecto: '',
		save_as:'txt_id_presupuesto'
	};	
// txt id_persona6
	vectorAtributos[5]= {
			validacion: {
			name:'id_empleado',
			fieldLabel:'Funcionario',
			allowBlank:true,			
			emptyText:'Funcionario...',
			desc:'nombre_completo', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_empleado,
			valueField:'id_empleado',
			displayField:'desc_persona',
			queryParam:'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			typeAhead:true,
			forceSelection:true,
			tpl:tpl_empleado,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:250,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_empleado,
			grid_visible:true,
			grid_editable:true,
			width_grid:230 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'EMPLEA.nombre_completo',
		defecto: '',
		save_as:'txt_id_empleado'
	};
	
	// txt estado_registro3
	vectorAtributos[2]= {
			validacion: {
			name:'concepto',			
			fieldLabel:'Concepto',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',			
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['compro','Compro'],['viaticos','Viaticos'],['cajas','Cajas'],['avance','Fondo en Avance'],['diesel','Diesel'],['devengados','Pagos Devengados'],['todos','Todos']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			renderer:render_concepto,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:100 
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'CONF.concepto',
		save_as:'txt_concepto'
	};
	
	// txt observaciones4
	vectorAtributos[6]= {
		validacion:{
			name:'min_monto',
			fieldLabel:'Monto Minimo',
			allowBlank:true,
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
			disabled:false
		},
		tipo:'NumberField',
		filtro_0:true,
		filterColValue:'CONF.min_monto',
		save_as:'txt_min_monto'
	};
	
	vectorAtributos[7]= {
		validacion:{
			name:'max_monto',
			fieldLabel:'Monto Maximo',
			allowBlank:true,
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
			width_grid:150,
			width:'50%',
			disabled:false
		},
		tipo:'NumberField',
		filtro_0:true,
		filterColValue:'CONF.max_monto',
		save_as:'txt_max_monto'
	};
	vectorAtributos[8]= {
		validacion:{
			name:'prioridad',
			fieldLabel:'Prioridad',
			allowBlank:true,
			selectOnFocus:true,
			grid_visible:true,
			grid_editable:false,
			align:'center',
			width_grid:100,
			width:'50%',
			disabled:false
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'CONF.prioridad',
		save_as:'txt_prioridad'
	};
	
	vectorAtributos[9]={
		validacion:{
			name:'estado',
			fieldLabel:'Estado',
			vtype:'texto',
			//emptyText:'Elija el Tipo...',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','Activo'],['inactivo','Inactivo']]}),
			valueField:'ID',
			displayField:'valor',
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			align:'center',
			width:200
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'CONF.estado',
		save_as: 'txt_estado'
	};
	
	vectorAtributos[10]= {
		validacion:{
			name:'fecha_expiracion',
			fieldLabel:'Fecha de Expiracion',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Dia no valido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			align:'center',
			width_grid:120,
			disabled:false	
		},
		form:true,
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'CONF.fecha_expiracion',
		save_as: 'txt_fecha_expiracion',
		dateFormat:'m-d-Y'		
	};
	
	vectorAtributos[11]= {
		validacion:{
			name:'usuario_reg',
				fieldLabel:'Usuario de Registro',
				allowBlank:true,
				selectOnFocus:true,
				grid_visible:true,
				grid_editable:false,
				width_grid:120,				
				disabled:true
			},
			tipo:'TextField',
			form:false
	};
	vectorAtributos[12]= {
		validacion:{
			name:'fecha_reg',
				fieldLabel:'Fecha de Registro',
				allowBlank:true,
				selectOnFocus:true,
				grid_visible:true,
				grid_editable:false,
				width_grid:120,				
				disabled:true
			},
			tipo:'TextField',
			form:false
	};
	vectorAtributos[13]= {
		validacion:{
			name:'usuario_mod',
				fieldLabel:'Usuario Modificacion',
				allowBlank:true,
				selectOnFocus:true,
				grid_visible:true,
				grid_editable:false,
				width_grid:120,				
				disabled:true
			},
			tipo:'TextField',
			form:false
	};
	vectorAtributos[14]= {
		validacion:{
			name:'fecha_mod',
				fieldLabel:'Fecha de Modificacion',
				allowBlank:true,
				selectOnFocus:true,
				grid_visible:true,
				grid_editable:false,
				width_grid:120,				
				disabled:true
			},
			tipo:'TextField',
			form:false
	};
	
	
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : ''
	};
	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////
	//Inicia Layout
	var config = {
		titulo_maestro:'config_aprobador',
		grid_maestro:'grid-'+idContenedor
	};
	var layout_config_aprobador=new DocsLayoutMaestro(idContenedor);
	layout_config_aprobador.init(config);
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_config_aprobador,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var ClaseMadre_btnEdit=this.btnEdit;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
   ///////////////////////////////////
	// DEFINICIï¿½N DE LA BARRA DE MENï¿½//
	///////////////////////////////////
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIï¿½N DE FUNCIONES ------------------------- //
	//  aquï¿½ se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	//datos necesarios para el filtro
	var paramFunciones = {
		btnEliminar:{url:direccion+'../../../control/config_aprobador/ActionEliminarConfigAprobador.php'},
		Save:{url:direccion+'../../../control/config_aprobador/ActionGuardarConfigAprobador.php'},
		ConfirmSave:{url:direccion+'../../../control/config_aprobador/ActionGuardarConfigAprobador.php'},
		Formulario:{
			titulo:'Configurar Aprobador',
			html_apply:"dlgInfo-"+idContenedor,
			width:500,
			height:450,
			minWidth:100,
			minHeight:150,
			closable:true
			
		}
	};
	//-------------- DEFINICIï¿½N DE FUNCIONES PROPIAS --------------//
	
	
	
	//Para manejo de eventos
	function iniciarEventosFormularios()
	{//para iniciar eventos en el formulario
		var cmpId_gestion=ClaseMadre_getComponente('id_gestion');
		var cmpPresupuesto=ClaseMadre_getComponente('id_presupuesto');
		var txt_concepto =ClaseMadre_getComponente('concepto');
		 
		 var onGestionSelect=function(e){
			var id=cmpId_gestion.getValue()
			 cmpPresupuesto.store.baseParams={m_sw_rendicion:'si',sw_inv_gasto:'si',id_gestion:id};
             cmpPresupuesto.modificado=true;
		};
		cmpId_gestion.on('select',onGestionSelect);
		cmpId_gestion.on('change',onGestionSelect);
		
		
		var onConcepto=function(e){
			if(e.value=='devengados'){
				  
				CM_ocultarComponente(ClaseMadre_getComponente('id_presupuesto'));
				CM_ocultarComponente(ClaseMadre_getComponente('id_uo'));
				
			}else{
				CM_mostrarComponente(ClaseMadre_getComponente('id_presupuesto'));
				CM_mostrarComponente(ClaseMadre_getComponente('id_uo'));
			}
		}
		
		
		txt_concepto.on('select',onConcepto);
		
	}
	//para que los hijos puedan ajustarse al tamaï¿½o
	this.getLayout=function(){return layout_config_aprobador.getLayout()};
	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i]
			}
		}
	};
	this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};
				//-------------- FIN DEFINICIï¿½N DE FUNCIONES PROPIAS --------------//
				this.Init(); //iniciamos la clase madre
				this.InitBarraMenu(paramMenu);
				//InitBarraMenu(array DE PARï¿½METROS PARA LAS FUNCIONES DE LA CLASE MADRE);
				this.InitFunciones(paramFunciones);
				//para agregar botones
				this.iniciaFormulario();
				iniciarEventosFormularios();
				
				//Adicionamos el combo de gestion	
	/*var ds_cmb_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','id_gestion','gestion_pres','estado_gral','cod_institucional','porcentaje_sobregiro','cantidad_niveles','desc_estado_gral'])
	});*/
	var ds_cmb_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/gestion/ActionListarGestion.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_gestion',totalRecords:'TotalCount'},['id_gestion','gestion','estado_ges_gral','id_empresa','desc_empresa','id_moneda_base','desc_moneda']),baseParams:{estado:'abierto'}});
	
	var tpl_gestion_cmb=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','</div>');
			
	var gestion =new Ext.form.ComboBox(
	{
		store:ds_cmb_gestion,
		displayField:'gestion',
		typeAhead:true,
		mode:'remote',
		triggerAction:'all',
		emptyText:'Gestion...',
		selectOnFocus:true,
		width:100,
		valueField:'id_gestion',
		tpl:tpl_gestion_cmb
	});
	
  	gestion.on('select',function (combo, record, index)
  	{
  		g_id_gestion=gestion.getValue();
	  	ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_gestion:g_id_gestion
			}
		});	
    });
    this.AdicionarBotonCombo(gestion,'gestion');
    //Fin adicion del combo de gestion
				
				layout_config_aprobador.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}