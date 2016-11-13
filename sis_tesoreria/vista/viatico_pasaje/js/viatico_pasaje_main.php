<?php 
/**
 * Nombre:		  	    viatico_pasaje_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				TSL
 * Fecha creación:		2006.11.12
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
	var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
	var elemento={pagina:new pagina_viatico_pasaje(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
	_CP.setPagina(elemento);
}
Ext.onReady(main,main);

//view added

/**
* Nombre:		  	    pagina_viatico_pasaje.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-10-21 15:59:44
*/
function pagina_viatico_pasaje(idContenedor,direccion,paramConfig,tipoFormDev){
	var Atributos=new Array,sw=0;
	var componentes=new Array();
	var g_id_gestion, g_sw_mod;
	var dif;
	
	var comp_pasaje_fecha, comp_nota_debito, comp_pasaje_nro, comp_importe_nuevo, comp_id_presupuesto, comp_importe_actual, comp_pasaje_orden;
	
	var monedas_for=new Ext.form.MonedaField({
		name:'numero',
		fieldLabel:'Importe',	
		allowBlank:false,
		align:'right', 
		maxLength:50,
		minLength:0,
		selectOnFocus:true,
		allowDecimals:true,
		decimalPrecision:2,
		allowNegative:false,
		minValue:0}	
	); 

	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/viatico_pasaje/ActionListarViaPasaje.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'id_cuenta_doc_det',totalRecords:'TotalCount'
		},['id_cuenta_doc_det',
		'sw_confirma',
		'nro_documento',
		'id_presupuesto',
		'desc_presupuesto',
		{name: 'fecha_ini',type:'date',dateFormat:'Y-m-d'},
		'importe',
		'importe_ant',
		'pasaje_cobrar',
		'pasaje_credito',
		'importe_total',
		'pasaje_orden',
		'nota_debito',
		'pasaje_utilizado',
		'recorrido',
		'observaciones',
		'desc_concepto_ingas',
		'partida',
		'solicitante',
		{name: 'fecha_sol',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_fin',type:'date',dateFormat:'Y-m-d'},
		'importe_actual',
		'importe_nuevo',
		'no_utilizado',
		'id_devengado',
		'pasaje_nro',
		{name: 'pasaje_fecha',type:'date',dateFormat:'Y-m-d'},
		'responsable'
		]),remoteSort:true
	});

	//DATA STORE COMBOS
	var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/gestion/ActionListarGestion.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_gestion',totalRecords:'TotalCount'},
			['id_gestion','gestion','estado_ges_gral','id_empresa','desc_empresa','id_moneda_base','desc_moneda']),baseParams:{sw_vigente:'si'}}); 
	
	var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/presupuesto/ActionListarComboPresupuesto.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','tipo_pres','estado_pres','id_unidad_organizacional','nombre_unidad',
																																									'id_fina_regi_prog_proy_acti','desc_epe','id_fuente_financiamiento','sigla','estado_gral',
																																									'gestion_pres','id_parametro','id_gestion','desc_presupuesto','nombre_financiador', 
																																									'nombre_regional', 'nombre_programa', 'nombre_proyecto', 'nombre_actividad',
																																									'id_categoria_prog','cod_categoria_prog',   'cp_cod_programa','cp_cod_proyecto',
																																									'cp_cod_actividad','cp_cod_organismo_fin','cp_cod_fuente_financiamiento','codigo_sisin' ]),baseParams:{m_sw_rendicion:'si',sw_inv_gasto:'si'}});
	//FUNCIONES RENDER
	var tpl_gestion=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','</div>');
	
	function render_id_presupuesto(value, p, record){if(record.get('estado_regis')=='2'){return '<span style="color:red;font-size:8pt">' + record.data['desc_presupuesto']+ '</span>';}else {return record.data['desc_presupuesto'];}}
	var tpl_id_presupuesto=new Ext.Template('<div class="search-item">',
		'<b>{nombre_unidad}</b>',
		'<br><b>Gestión: </b><FONT COLOR="#B5A642">{gestion_pres}</FONT>',
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
		'</div>'
	);
	
	function renderSeparadorDeMil(value,cell,record,row,colum,store){		
		return monedas_for.formatMoneda(value)		 
	}
	
	function render_total(value,cell,record,row,colum,store){
		if(store.getAt(row).data['sw_confirma'] == 'si'){
		return  '<span style="color:blue;">' +monedas_for.formatMoneda(value)+'</span>'}	
		if(store.getAt(row).data['sw_confirma'] != 'si'){return monedas_for.formatMoneda(value)}
	}
	
	function render_total_txt(value,cell,record,row,colum,store){
		if(store.getAt(row).data['sw_confirma'] == 'si'){
		return  '<span style="color:green;">' +value+ '</span>'}	
		if(store.getAt(row).data['sw_confirma'] != 'si'){return value}
	}
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	
	function formatValida(value){
		if (value=='si') return 'SI';
		else return 'NO'
	};
	
	function formatValida1(value){
		if (value==1) return 'Si';
		else return 'No'
	};
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////

	//en la posición 0 siempre esta la llave primaria
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_cuenta_doc_det',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_cuenta_doc_det'
	};

	Atributos[1]={
		validacion:{
			fieldLabel:'Confirmado',
			name:'sw_confirma',
			checked:true,
			renderer:formatValida,
			selectOnFocus:true,
			grid_visible:true,
			grid_editable:false,
			align:'center',
			width_grid:73
		},
		tipo:'Checkbox',
		form:true,
		id_grupo:2
	};
	
	Atributos[2]= {
		validacion:{
			name:'no_utilizado',
			fieldLabel:'Utilizado',
			checked:false,
			renderer:formatValida1,
			grid_visible:true,
			grid_editable:true,
			align:'center',
			width_grid:70
		},
		tipo:'Checkbox',
		form:false
	};
	
	Atributos[3]= {
		validacion:{
			name:'pasaje_fecha',
			fieldLabel:'Presentar al',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false	
		},
		form:true,
		tipo:'DateField',
		filtro_0:false,
		dateFormat:'m-d-Y',
		id_grupo:0		
	};
	
	Atributos[4]={
		validacion:{
			labelSeparator:'',
			name: 'pasaje_orden',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'NumberField',
		filtro_0:false
	};
	
	Atributos[5]={
		validacion:{
			fieldLabel:'Nota(s) de Débito',
			name: 'nota_debito',
			grid_visible:true,
			grid_editable:false,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			width_grid:120,
			width:250,
			allowBlank:false,
			renderer: render_total_txt
		},
		tipo: 'Field',
		filtro_0:false,
		form:true,
		id_grupo:0
	};
	
	Atributos[6]={
		validacion:{
			fieldLabel:'Nro. de Boleto(s)',
			name: 'pasaje_nro',
			grid_visible:true,
			grid_editable:true,
			maxLength:250,
			minLength:0,
			selectOnFocus:true,
			width_grid:130,
			width:250,
			allowBlank:false
		},
		tipo: 'TextArea',
		filtro_0:false,
		form:true,
		id_grupo:0
	};
	
	Atributos[7]={
		validacion:{
			fieldLabel:'Importe Actual',
			name: 'importe',
			grid_visible:true,
			align:'right',
			width_grid:100,
			grid_editable:false,
			renderer: render_total,
			disabled:true
		},
		tipo: 'NumberField',
		filtro_0:false,
		form:false
	};
	
	Atributos[8]={
		validacion:{
			fieldLabel:'Importe anterior',
			name: 'importe_ant',
			grid_visible:false,
			align:'right',
			grid_editable:false,
			renderer: render_total,
			allowBlank:false
		},
		tipo: 'NumberField',
		form:false,
		filtro_0:false
	};
	
	Atributos[9]={
		validacion:{
			fieldLabel:'Importe actual',
			name: 'importe_actual',
			grid_visible:false,
			align:'right',
			width_grid:100,
			grid_editable:false,
			renderer: render_total,
			disabled:true,
			width:150
		},
		tipo: 'NumberField',
		filtro_0:false,
		form:true,
		id_grupo:0
	};
	
	Atributos[10]={
		validacion:{
			fieldLabel:'Importe Nuevo',
			name: 'importe_nuevo',
			grid_visible:false,
			align:'right',
			width_grid:100,
			grid_editable:false,
			renderer: render_total,
			width:150,
			allowBlank:false
		},
		tipo: 'NumberField',
		filtro_0:false,
		form:true,
		id_grupo:0
	};

	Atributos[11]={
		validacion:{
			fieldLabel:'Por Cobrar',
			name: 'pasaje_cobrar',
			grid_visible:true,
			align:'right',
			width_grid:100,
			grid_editable:false,
			renderer: render_total,
			width:150,
			allowBlank:false
		},
		tipo: 'NumberField',
		filtro_0:false,
		form:true,
		id_grupo:0
	};
	
	Atributos[12]={
		validacion:{
			fieldLabel:'Sin Credito',
			name: 'pasaje_credito',
			grid_visible:true,
			align:'right',
			width_grid:100,
			grid_editable:false,
			renderer: render_total,
			width:150,
			allowBlank:false
		},
		tipo: 'NumberField',
		filtro_0:false,
		form:true,
		id_grupo:0
	};
	
	Atributos[13]={
		validacion:{
			fieldLabel:'Importe Total',
			name: 'importe_total',
			grid_visible:true,
			align:'right',
			grid_editable:false,
			renderer: render_total,
			allowBlank:false
		},
		tipo: 'NumberField',
		form:false,
		filtro_0:false
	};
	
	Atributos[14]={
		validacion:{
			name:'id_presupuesto',
			fieldLabel:'Presupuesto',
			allowBlank:false,			
			desc: 'desc_presupuesto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_presupuesto,
			valueField: 'id_presupuesto',
			displayField: 'desc_presupuesto',
			queryParam: 'filterValue_0',
			filterCol:'presup.desc_presupuesto#PRESUP.nombre_unidad#PRESUP.nombre_fuente_financiamiento#PRESUP.nombre_financiador#PRESUP.nombre_regional#PRESUP.nombre_programa#PRESUP.nombre_proyecto#PRESUP.nombre_actividad#PRESUP.id_presupuesto#CATPRO.cod_categoria_prog',
			typeAhead:false,
			tpl:tpl_id_presupuesto,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:10,
			minListWidth:300,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:2, 
			triggerAction:'all',
			editable:true,
			renderer:render_id_presupuesto,
			grid_visible:true,
			grid_editable:false,
			width_grid:400,
			width:300,
			disabled:false	
		},
		tipo:'ComboBox',
		form:true,
		filtro_0:true,
		filterColValue:'desc_presupuesto',
		save_as:'id_presupuesto',
		id_grupo:1		
	};
	
	Atributos[15]={
		validacion:{
			fieldLabel:'Solicitud de Viaje',
			name: 'nro_documento',
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			renderer: render_total_txt
		},
		tipo:'Field',
		filtro_0:true,
		form:false,
		filterColValue:'nro_documento',
	};
	
	Atributos[16]={
		validacion:{
			fieldLabel:'Fecha Solicitud',
			name: 'fecha_sol',
			grid_visible:true,
			grid_editable:false,
			width_grid:90,
			renderer: formatDate
		},
		tipo: 'Field',
		filtro_0:false,
		form:false
	};

	Atributos[17]={
		validacion:{
			fieldLabel:'Solicitante',
			name: 'solicitante',
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			renderer: render_total_txt
		},
		tipo: 'Field',
		filtro_0:true,
		filterColValue:'nombre_completo',
		form:false
	};
	
	Atributos[18]={
		validacion:{
			fieldLabel:'Ruta',
			name: 'recorrido',
			grid_visible:true,
			grid_editable:false,
			width_grid:200
		},
		tipo: 'Field',
		filtro_0:false,
		form:false
	};
	
	Atributos[19]={
		validacion:{
			fieldLabel:'Fecha Ini',
			name: 'fecha_ini',
			align:'center',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			renderer: formatDate
		},
		tipo: 'Field',
		filtro_0:false,
		form:false
	};
	
	Atributos[20]={
		validacion:{
			fieldLabel:'Fecha Fin',
			name: 'fecha_fin',
			align:'center',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			renderer: formatDate
		},
		tipo: 'Field',
		filtro_0:false,
		form:false
	};
	
	Atributos[21]={
		validacion:{
			fieldLabel:'Partida',
			name: 'partida',
			grid_visible:true,
			grid_editable:false,
			width_grid:200
		},
		tipo: 'Field',
		filtro_0:false,
		form:false
	};
	
	Atributos[22]={
		validacion:{
			fieldLabel:'Concepto',
			name: 'desc_concepto_ingas',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo: 'Field',
		filtro_0:false,
		form:false
	};
	
	Atributos[23]={
		validacion:{
			fieldLabel:'Observaciones',
			name: 'observaciones',
			grid_visible:true,
			grid_editable:true,
			maxLength:250,
			minLength:0,
			width_grid:300
		},
		tipo: 'TextArea',
		filtro_0:false,
		form:false
	};
	
	Atributos[24]={
		validacion:{
			fieldLabel:'Reportado por',
			name: 'responsable',
			grid_visible:true,
			grid_editable:false,
			width_grid:200
		},
		tipo: 'Field',
		filtro_0:false,
		form:false
	};
	
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Pasajes por Agencia',grid_maestro:'grid-'+idContenedor};
	var layout_viatico_pasaje=new DocsLayoutMaestro(idContenedor);
	layout_viatico_pasaje.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_viatico_pasaje,idContenedor);
	
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_getComponente=this.getComponente;
	var EstehtmlMaestro=this.htmlMaestro;
	var CM_save=this.Save;
	var CM_btnEdit=this.btnEdit;
	var CM_btnNew=this.btnNew;
	var CM_btnActualizar = this.btnActualizar;
	var CM_conexionFailure = this.conexionFailure;
	var cm_EnableSelect=this.EnableSelect;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu={
		//editar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false},
		guardar:{crear:true,separador:false}
	};

	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

 	var SaveX=function(){
 		var mensaje;
 		mensaje = 'Falta completar los datos.';
 		
 		if (g_sw_mod == 'pago') {
	 		var res=verificarImportes();
	 		//Verifica si la diferencia fue por más o por menos para desplegar mensaje de confirmación
	 		if(res=='MAYOR'){
	 			mensaje = 'El Importe Nuevo introducido es MAYOR al Importe Actual por: '+dif+'. Si guarda esta información se realizarán los movimientos presupuestarios necesarios para Comprometer el nuevo importe y Revertir al actual.\n\n¿Está seguro de continuar?';
	 		} else if(res=='MENOR'){
	 			mensaje = 'El Importe Nuevo introducido es MENOR al Importe Actual por: '+dif+'. Si guarda esta información se realizarán los movimientos presupuestarios necesarios para Comprometer el nuevo importe y Revertir al actual.\n\n¿Está seguro de continuar?';
	 		} else if(res=='IGUAL'){
	 			mensaje = 'El Importe Nuevo es IGUAL al Importe Actual, por lo que no se realizará ningún movimiento presupuestario.\n\n¿Está seguro de continuar?'
	 		}
 		} else{
 			if (g_sw_mod == 'ppto'){
 				mensaje = 'Al Cambiar de Presupuesto se realizarán los movimientos presupuestarios necesarios para Revertir y Comprometer el Importe de la Solicitud.\n\n¿Está seguro de continuar?';
 			} else{
 				mensaje = 'Cancelara la solicitud de pago.\n\n¿Está seguro de continuar?';
 			}
 		}
 		if(confirm(mensaje)){
		  	CM_save();
		}
  	}

	//datos necesarios para el filtro
	var paramFunciones={
		Save:{url:direccion+'../../../control/viatico_pasaje/ActionGuardarViaPasaje.php?tipo=pago'},
		ConfirmSave:{url:direccion+'../../../control/viatico_pasaje/ActionGuardarViaPasaje.php?tipo=utilizado'},
		Formulario:{
			html_apply:'dlgInfo-'+idContenedor,height:370,width:470,minWidth:150,minHeight:200,	closable:true,
			titulo:'Pasajes por Agencia',
			guardar: SaveX,
			grupos:[{
						tituloGrupo:'Pago de Pasajes',
						columna:0,
						id_grupo:0
					},{
						tituloGrupo:'Cambio de Presupuesto',
						columna:0,
						id_grupo:1
					},{
						tituloGrupo:'Cancelar el Pago',
						columna:0,
						id_grupo:2
					}]
		}
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		comp_pasaje_fecha = ClaseMadre_getComponente('pasaje_fecha');
		comp_nota_debito = ClaseMadre_getComponente('nota_debito');
		comp_pasaje_nro = ClaseMadre_getComponente('pasaje_nro');
		comp_importe_actual = ClaseMadre_getComponente('importe_actual');
		comp_importe_nuevo = ClaseMadre_getComponente('importe_nuevo');
		comp_id_presupuesto = ClaseMadre_getComponente('id_presupuesto');
		comp_pasaje_orden = ClaseMadre_getComponente('pasaje_orden');
	}

	function InitPaginaViaPasaje(){
		/*for(var i=0; i<Atributos.length; i++){	
			componentes[i]=ClaseMadre_getComponente(Atributos[i].validacion.name)
		}*/
	}
	
	this.EnableSelect=function(sm,row,rec){
		enable(sm,row,rec);
	}
	
	//Verificación de los importes
	function verificarImportes(){
		var imp_orig = comp_importe_actual.getValue();
		var imp_mod = comp_importe_nuevo.getValue();
		
		var resultado;
		
		if(imp_mod > 0){
			if(imp_orig > imp_mod){
				dif=imp_orig-imp_mod;
				resultado='MENOR';
			} else if(imp_orig < imp_mod){
				dif=imp_mod-imp_orig;
				resultado='MAYOR';
			} else{
				resultado='IGUAL';
			}
		}else{
			resultado='CERO';
		}
		return resultado;
	}
	
	var gestion = new Ext.form.ComboBox({
			store: ds_gestion,
			displayField:'gestion',
			typeAhead: false,
			mode: 'remote',
			triggerAction: 'all',
			emptyText:'gestion...',
			selectOnFocus:true,
			width:100,
			valueField: 'id_gestion',
			tpl:tpl_gestion
		});

	gestion.on('select',function (combo, record, index){
		g_id_gestion=gestion.getValue();	
		
		ds.baseParams={m_gestion:g_id_gestion};
	
  		ds.load({
			params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_gestion:g_id_gestion
			}
		});
  		
  		comp_id_presupuesto.store.baseParams = {m_sw_rendicion:'si',sw_inv_gasto:'si',id_gestion:g_id_gestion};
  		comp_id_presupuesto.modificado = true;			
  		comp_id_presupuesto.setValue('');
  	});
  	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_viatico_pasaje.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	var CM_getBoton=this.getBoton;	
	
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});

	//para agregar botones
	function btnPagaPasaje(){
		CM_mostrarGrupo('Pago de Pasajes');
		CM_ocultarGrupo('Cambio de Presupuesto');
		CM_ocultarGrupo('Cancelar el Pago');
		comp_pasaje_fecha.allowBlank = false;
		comp_pasaje_orden.allowBlank = false;
		comp_nota_debito.allowBlank = false;
		comp_pasaje_nro.allowBlank = false;
		comp_importe_nuevo.allowBlank = false;
		comp_id_presupuesto.allowBlank = true;
		comp_id_presupuesto.setValue('');
		g_sw_mod = 'pago';
		CM_btnEdit();
	}
	
	function btnPptoPasaje(){
		CM_ocultarGrupo('Pago de Pasajes');
		CM_mostrarGrupo('Cambio de Presupuesto');
		CM_ocultarGrupo('Cancelar el Pago');
		comp_pasaje_fecha.allowBlank = true;
		comp_pasaje_orden.allowBlank = true;
		comp_nota_debito.allowBlank = true;
		comp_pasaje_nro.allowBlank = true;
		comp_importe_nuevo.allowBlank = true;
		comp_id_presupuesto.allowBlank = false;
		comp_id_presupuesto.setValue('');
		g_sw_mod = 'ppto';
		CM_btnEdit();
	}
	
	function btnDelPasaje(){
		CM_ocultarGrupo('Pago de Pasajes');
		CM_ocultarGrupo('Cambio de Presupuesto');
		CM_mostrarGrupo('Cancelar el Pago');
		comp_pasaje_fecha.allowBlank = true;
		comp_pasaje_orden.allowBlank = true;
		comp_nota_debito.allowBlank = true;
		comp_pasaje_nro.allowBlank = true;
		comp_importe_nuevo.allowBlank = true;
		comp_id_presupuesto.allowBlank = true;
		comp_id_presupuesto.setValue('0');
		g_sw_mod = 'cancela';
		CM_btnEdit();
	}
	
	function btn_RepPasaje() {
		var sm = getSelectionModel();
		if(sm.getCount()!=0){
			var id_cuenta_doc_det = sm.getSelected().data.id_cuenta_doc_det;
			window.open(direccion+'../../../../sis_tesoreria/control/_reportes/devengado/ActionPasajeVia_Jasper.php?id_cuenta_doc_det='+id_cuenta_doc_det)
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un registro')
		}
	}
	
	function exito_cont(resp){
		Ext.MessageBox.hide();
		var root = resp.responseXML.documentElement;
		var error = root.getElementsByTagName('error')[0].firstChild.nodeValue;
		if(error==1){
			Ext.MessageBox.alert('Alerta', root.getElementsByTagName('mensaje_error')[0].firstChild.nodeValue);
		}else{
			Ext.MessageBox.alert('Estado', root.getElementsByTagName('mensaje')[0].firstChild.nodeValue);
			CM_btnActualizar()
		}
	}


	function btn_finPasaje() {
		CM_ocultarGrupo('Pago de Pasajes');
		CM_ocultarGrupo('Cambio de Presupuesto');
		CM_mostrarGrupo('Cancelar el Pago');
		comp_pasaje_fecha.allowBlank = true;
		comp_pasaje_orden.allowBlank = true;
		comp_nota_debito.allowBlank = true;
		comp_pasaje_nro.allowBlank = true;
		comp_importe_nuevo.allowBlank = true;
		comp_id_presupuesto.allowBlank = true;
		comp_id_presupuesto.setValue('-1');
		
		CM_btnEdit();
	}
	
	this.AdicionarBotonCombo(gestion,'gestion');
	this.AdicionarBoton("../../../lib/imagenes/a_table_gear.png",'Cambiar el Presupuesto',btnPptoPasaje,true, 'ppto','Cambiar Presupuesto');
	this.AdicionarBoton("../../../lib/imagenes/list-items.gif",'Confirmar el Pago',btnPagaPasaje,true, 'pasaje','Confirmar Pago');
	this.AdicionarBoton('../../../lib/imagenes/cancel.png','Cancelar el Pago',btnDelPasaje,true,'cancela','Cancelar Pago');
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Detalle de Pagos Confirmados',btn_RepPasaje,false,'reporte','Reporte Detalle');
	this.AdicionarBoton('../../../lib/imagenes/cancel.png','Finalizar el Pago',btn_finPasaje,false,'finalizar_pasaje','Finalizar Pasaje');

	
	function enable(sm,row,rec){
		cm_EnableSelect(sm,row,rec);
		CM_getBoton('pasaje-'+idContenedor).disable();
		CM_getBoton('ppto-'+idContenedor).disable();
		CM_getBoton('cancela-'+idContenedor).disable();
		//CM_getBoton('reporte-'+idContenedor).disable();
		if(rec.data['id_devengado']=='' || rec.data['id_devengado']==undefined){
			CM_getBoton('pasaje-'+idContenedor).enable();
			CM_getBoton('ppto-'+idContenedor).enable();
			if(rec.data['sw_confirma']=='si' ){
				CM_getBoton('cancela-'+idContenedor).enable();
				CM_getBoton('reporte-'+idContenedor).enable();
			}
		}
	}
	
	this.iniciaFormulario();
	InitPaginaViaPasaje();
	iniciarEventosFormularios();
	
	layout_viatico_pasaje.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}