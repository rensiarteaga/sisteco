<?php 
/**
 * Nombre:		  	    tipo_doc_institucion_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-06 21:03:56
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
idContenedorPadre='<?php echo $idContenedorPadre;?>';

<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa,	idSub:decodeURI(idSub)};
var elemento={pagina:new pagina_tipo_doc_institucion(idContenedor,direccion,paramConfig,idContenedorPadre),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);
/**
 * Nombre:		  	    pagina_tipo_doc_institucion_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-06 21:03:56
 */
function pagina_tipo_doc_institucion(idContenedor,direccion,paramConfig,idContenedorPadre)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var sw=0;
	var maestro={id_parametro:0,id_comprobante:0,id_moneda_reg:0};	
	var	var_importe_debe;
	var	var_importe_haber;
	var	var_importe_gasto;
	var	var_importe_recurso;
	
	/////////////////
	//  DATA STORE //
	/////////////////
	var Transaccion = Ext.data.Record.create([		
		                                 		'id_transaccion',
		                                 		'id_comprobante','desc_comprobante',
		                                 		'id_partida_cuenta','desc_partida_cuenta',
		                                 		'id_cuenta', 'desc_cuenta',
		                                 		'id_partida','desc_partida',
		                                 	 	'id_auxiliar','desc_auxiliar',
		                                 		'id_orden_trabajo','desc_orden_trabajo',
		                                 		'id_oec','nombre_oec',
		                                 		'concepto_tran',
		                                 		'id_moneda','desc_moneda',
		                                 		'importe_debe','importe_haber',
		                                 		'importe_gasto','importe_recurso',
		                                 		'id_presupuesto','desc_presupuesto',
		                                 		'tipo_pres',
		                                 		'sw_aux',
		                                 		'sw_oec',
		                                 		'sw_deha',
		                                 		'id_moneda',
		                                 		'id_nombre',
		                                 		'sw_rega',
		                                 		'disponibilidad',
		                                 		'importe_gasto_flujo',
		                                 		'importe_recurso_flujo',
		                                 		'desc_cuenta_aux'
		                                 		]); 
		                                  
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/caiff/ActionListarCaiffAjusteTrans.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_transaccion',totalRecords:'TotalCount'
		},Transaccion),remoteSort:true});

	 var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/presupuesto/ActionListarPresupuestoDepto.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','desc_presupuesto','tipo_pres','estado_pres','id_fuente_financiamiento','nombre_fuente_financiamiento',
																										'id_unidad_organizacional','nombre_unidad','id_fina_regi_prog_proy_acti','desc_epe','nombre_financiador', 
																										'nombre_regional', 'nombre_programa', 'nombre_proyecto', 'nombre_actividad','id_parametro','gestion_pres',
																										'id_categoria_prog','cod_categoria_prog',   'cp_cod_programa','cp_cod_proyecto','cp_cod_actividad',
																										'cp_cod_organismo_fin','cp_cod_fuente_financiamiento','codigo_sisin' 
																										])});

	 function render_id_presupuesto(value, p, record){if(record.get('estado_regis')=='2'){return '<span style="color:red;font-size:8pt">' + record.data['desc_presupuesto']+ '</span>';}else {return record.data['desc_presupuesto'];}}
		

	 var tpl_id_presupuesto=new Ext.Template('<div class="search-item">',
				'<b><i>{nombre_unidad}</i></b>',
				'<br><b>Gestión: </b> <FONT COLOR="#0000ff">{gestion_pres} </FONT> ',
				'<br>   Tipo Presupuesto: </b> <FONT COLOR="#B50000">{tipo_pres} </FONT> ',
				'<br><b>Fuente de Financiamiento: </b><FONT COLOR="#0000ff">{nombre_fuente_financiamiento}</FONT>',		
				'<br>  <b>Estructura Programatica:  </b><FONT COLOR="#0000ff">{desc_epe}</FONT></b>',
				'<br>  <FONT COLOR="#B50000">{nombre_financiador}</FONT>',
				'<br>  <FONT COLOR="#0000ff">{nombre_regional}</FONT>',
				'<br>  <FONT COLOR="#0000ff">{nombre_programa}</FONT>',
				'<br>  <FONT COLOR="#B50000">{nombre_proyecto}</FONT>',
				'<br>  <FONT COLOR="#0000ff">{nombre_actividad}</FONT>',
				'<br><FONT COLOR="#B50000"><b>Cat. Programatica: </b>{cod_categoria_prog}</FONT>',  
				'<br><FONT COLOR="#B50000"><b>Identificador: </b>{id_presupuesto}</FONT>', 
				'</div>');	

	 var ds_partida_cuenta=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_presupuesto/control/partida_cuenta/ActionListarCuentaPartida.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_partida_cuenta',totalRecords:'TotalCount'},['id_partida_cuenta','id_cuenta','id_partida','partida_cuenta','sw_deha','sw_rega', 'id_parametro','desc_parametro','nro_cuenta','nombre_cuenta','codigo_partida','nombre_partida','id_gestion','id_moneda','desc_moneda','sw_movimiento'])});
		function render_id_partida_cuenta(value, p, record){return String.format('{0}', record.data['desc_partida_cuenta'])};
		var tpl_id_partida_cuenta=new Ext.Template('<div class="search-item">','<b>Partida: </b><FONT COLOR="#B50000">{codigo_partida}</FONT> - ','<FONT COLOR="#B50000">{nombre_partida}</FONT><br>','<b>Cuenta: </b><FONT COLOR="#0000ff">{nro_cuenta}</FONT> - ','<FONT COLOR="#0000ff">{nombre_cuenta}</FONT><br>','</div>');


	 var ds_auxiliar = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/auxiliar/ActionListarAuxiliar.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_auxiliar',totalRecords: 'TotalCount'},['id_auxiliar','codigo_auxiliar','nombre_auxiliar','estado_auxiliar'])});
     function render_id_auxiliar(value, p, record){return String.format('{0}',record.data['desc_auxiliar'])}
     var tpl_id_auxiliar=new Ext.Template('<div class="search-item">','<b>Código: </b><FONT COLOR="#0000ff">{codigo_auxiliar}</FONT><br>','<b>Auxiliar: </b><FONT COLOR="#0000ff">{nombre_auxiliar}</FONT><br>','</div>');

     function render_id_moneda(value, p, record){return String.format('{0}',record.data['desc_moneda'])}
  	function render_moneda_16(value,cell,record,row,colum,store){
  	 	if(record.data['disponibilidad'] == 1){
  		return  '<span style="color:blue;">' +var_importe_haber.formatMoneda(value)+'</span>'}	
  		if(record.data['disponibilidad'] == 0){return '<span style="color:red;">' +var_importe_haber.formatMoneda(value)+'</span>'}
   	}
     function render_moneda_17(value,cell,record,row,colum,store){
  	 	if(record.data['disponibilidad'] == 1){
  		return  '<span style="color:blue;">' +var_importe_haber.formatMoneda(value)+'</span>'}	
  		if(record.data['disponibilidad'] == 0){return '<span style="color:red;">' +var_importe_haber.formatMoneda(value)+'</span>'}
   	}	  

	//DATA STORE COMBOS

	//FUNCIONES RENDER
	
	
	
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_tipo_doc_institucion
	//en la posición 0 siempre esta la llave primaria

	vectorAtributos[0]= {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_transaccion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_transaccion'
	};
	vectorAtributos[1]= {
			validacion:{
				name:'desc_presupuesto',
				fieldLabel:'Presupuesto',
				allowBlank:true,
				maxLength:250,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:250,
				width:250
			},
			tipo: 'TextField',
			filtro_0:true,
			filterColValue:'desc_presupuesto',
			save_as:'desc_presupuesto'
		};

	vectorAtributos[2]= {
			validacion:{
				name:'desc_cuenta_aux',
				fieldLabel:'Cuenta-Auxiliar',
				allowBlank:true,
				maxLength:250,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:250,
				width:250
			},
			tipo: 'TextField',
			filtro_0:true,
			filterColValue:'desc_cuenta_aux',
			save_as:'desc_cuenta_aux'
		};
	vectorAtributos[3]= {
			validacion:{
				name:'desc_partida',
				fieldLabel:'Partida',
				allowBlank:true,
				maxLength:250,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:250,
				width:250
			},
			tipo: 'TextField',
			filtro_0:true,
			filterColValue:'desc_partida',
			save_as:'desc_partida'
		};
		

	vectorAtributos[4]={
			validacion:{
				name:'importe_debe',
				fieldLabel:'Importe Debe',
				allowBlank:true,
				align:'right', 
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision:2,//para numeros float
				allowNegative:false,
				allowMil:true,
				minValue:0,
				grid_visible:true,
				grid_editable:false,
				renderer:render_moneda_16,
				width_grid:100,
				width:100,
				disabled:false		
			},
			tipo: 'MonedaField',
			form: true,
			filtro_0:true,
			filterColValue:'importe_debe',
			save_as:'importe_debe'
		};
		
		vectorAtributos[5]={
			validacion:{
				name:'importe_haber',
				fieldLabel:'Importe Haber',
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
				renderer:render_moneda_17,
				width_grid:100,
				width:100,
				disabled:false		
			},
			tipo: 'MonedaField',
			form: true,
			filtro_0:true,
			filterColValue:'importe_haber',
			save_as:'importe_haber'
		};
		
		vectorAtributos[6]={
			validacion:{
				name:'importe_gasto',
				fieldLabel:'Importe Gasto',
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
				renderer:render_moneda_17,
				grid_editable:false,
				width_grid:100,
				width:100,
				disabled:false		
			},
			tipo: 'MonedaField',
			form: true,
			filtro_0:true,
			id_grupo:0,
			filterColValue:'importe_gasto',
			save_as:'importe_gasto'
		};
		
		vectorAtributos[7]={
			validacion:{
				name:'importe_recurso',
				fieldLabel:'Importe Recurso',
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
				renderer:render_moneda_17,
				grid_editable:false,
				width_grid:100,
				width:100,
				disabled:false		
			},
			tipo: 'MonedaField',
			form: true,
			filtro_0:true,
			id_grupo:0,
			filterColValue:'importe_recurso',
			save_as:'importe_recurso'
		};
			
		vectorAtributos[8]={
				validacion:{
					name:'importe_gasto_flujo',
					fieldLabel:'Importe Gasto Flujo',
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
					renderer:render_moneda_17,
					grid_editable:true,
					width_grid:100,
					width:100,
					disabled:false		
				},
				tipo: 'MonedaField',
				form: true,
				filtro_0:true,
				id_grupo:0,
				filterColValue:'importe_gasto_flujo',
				save_as:'importe_gasto_flujo'
			};
			
			vectorAtributos[9]={
				validacion:{
					name:'importe_recurso_flujo',
					fieldLabel:'Importe Recurso Flujo',
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
					renderer:render_moneda_17,
					grid_editable:true,
					width_grid:100,
					width:100,
					disabled:false		
				},
				tipo: 'MonedaField',
				form: true,
				filtro_0:true,
				id_grupo:0,
				filterColValue:'importe_recurso_flujo',
				save_as:'importe_recurso_flujo'
			};
				

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
	var config={titulo_maestro:'Registro de Comprobante (Maestro)',
			    titulo_detalle:'Detalle Transacción (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_registro_transacion=new DocsLayoutMaestro(idContenedor,idContenedorPadre);
	layout_registro_transacion.init(config);	
	
	//---------- INICIAMOS LAYOUT DETALLE
	


	
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_registro_transacion,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_getComponenteGrid=this.getComponenteGrid;
	

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu={
		guardar:{crear:true,separador:false},
		//nuevo:{crear:true,separador:true},
		//editar:{crear:true,separador:false},
		//eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones = {
		//btnEliminar:{url:direccion+'../../../control/tipo_doc_institucion/ActionEliminarTipoDocInstitucion.php'},
		Save:{url:direccion+'../../../control/tipo_doc_institucion/ActionGuardarTipoDocInstitucion.php'},
		ConfirmSave:{url:direccion+'../../../control/tipo_doc_institucion/ActionGuardarTipoDocInstitucion.php'},
		Formulario:{
			titulo:'Tipo de Documentacion de Institución',
			html_apply:"dlgInfo-"+idContenedor,
			width:'40%',
			height:'40%',
			minWidth:100,
			minHeight:150,
			columnas:['95%'],
			closable:true,
			grupos:[
			{
				tituloGrupo:'Datos de Documentación de Institución',
				columna:0,
				id_grupo:0
			}
			]
		}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function InitRegistroTransaccion(){
		grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		
		sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();

		/*var_id_transaccion=ClaseMadre_getComponente('id_transaccion');
		var_id_comprobante=ClaseMadre_getComponente('id_comprobante');
		var_id_presupuesto=ClaseMadre_getComponente('id_presupuesto');
		var_id_orden_trabajo=ClaseMadre_getComponente('id_orden_trabajo');
		var_id_partida_cuenta=ClaseMadre_getComponente('id_partida_cuenta');
		var_id_auxiliar=ClaseMadre_getComponente('id_auxiliar');
		var_id_oec=ClaseMadre_getComponente('id_oec');
		var_concepto_tran=ClaseMadre_getComponente('concepto_tran');*/
		var_importe_debe=ClaseMadre_getComponente('importe_debe');
		var_importe_haber=ClaseMadre_getComponente('importe_haber');
		var_importe_gasto=ClaseMadre_getComponente('importe_gasto');
		var_importe_recurso=ClaseMadre_getComponente('importe_recurso');
		/*var_id_partida=ClaseMadre_getComponente('id_partida');
		var_id_cuenta=ClaseMadre_getComponente('id_cuenta');
		var_id_presupuesto.on('select',f_filtrar_partida);	
		var_id_partida_cuenta.on('select',f_filtrar_auxiliar);	*/
		var_importe_debe.on('change',f_de_ha);
		var_importe_haber.on('change',f_ha_de);
		var_importe_gasto.on('change',f_ga_re);
		var_importe_recurso.on('change',f_re_ga);
		/*var_id_orden_trabajo.on('blur',f_vaciar_dato);*/
		
		getSelectionModel().on('rowselect',	function( SM,rowIndex){var_record=SM.getSelected().data; var_rowIndex=rowIndex;})
 	};
	
	this.reload=function(params,sw_editar){
		
		maestro=params;
		//alert(params.id_comprobante);
	   //	paramFunciones.btnEliminar.parametros='&m_id_combrobante='+maestro.id_comprobante+'&m_id_moneda='+maestro.id_moneda;
		paramFunciones.Save.parametros='&m_id_combrobante='+maestro.id_comprobante;
		paramFunciones.ConfirmSave.parametros='&m_id_combrobante='+maestro.id_comprobante;
		this.InitFunciones(paramFunciones);
				
		ds.lastOptions={params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						m_id_comprobante:params.id_comprobante,
						m_id_moneda:1
		}};
						
	   	this.btnActualizar();
	   	
	  	this.desbloquearMenu();
		
	};


	function f_de_ha(elemento, nuevo, antiguo){var_importe_haber.setValue('')}
	function f_ha_de(elemento, nuevo, antiguo){var_importe_debe.setValue('')}
	function f_ga_re(elemento, nuevo, antiguo){var_importe_recurso.setValue('')}
	function f_re_ga(elemento, nuevo, antiguo){var_importe_gasto.setValue('')}
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_registro_transacion.getLayout();};
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

				//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	InitRegistroTransaccion();
	
	layout_registro_transacion.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
	_CP.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
				
}
