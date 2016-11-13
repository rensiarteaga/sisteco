<?php
/**
 * Nombre:		  	    solicitud_compra_item_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-16 09:53:33
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
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_memoria_combustible(idContenedor,direccion,paramConfig,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
* Nombre:		  	    pag_descargo_detalle.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-05-16 09:53:33
*/
function pagina_memoria_combustible(idContenedor,direccion,paramConfig,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var tituloM,maestro,txt_sw_valida;
	var dialog;
	var sw_filtro;
	var cantidadPreferencial;
	//DATA STORE//
	var ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/mem_combustible/ActionListarMemoriaCombustible.php'}),
		reader:new Ext.data.XmlReader({
		record:'ROWS',id:'id_mem_combustible',totalRecords:'TotalCount'
		},[		
		'id_mem_combustible',
		'id_memoria_calculo',
		'id_moneda',
		'id_combustible',
		'periodo_pres',
		'cantidad_combustible',
		'cantidad_preferencial',
		'precio_preferencial',
		'cantidad_mercado',
		'precio_mercado',
		'costo_preferencial',
		'costo_mercado',
		'costo_total',
		'desc_moneda',
		'porcentaje',
		'total_general',
		'descripcion',
		'tipo_insercion'
		]),remoteSort:true});
	// Definición de datos //
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
			baseParams:{sw_combo_presupuesto:'si'}
	});
	var ds_combustible=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/combustible/ActionListarCombustible.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_combustible',totalRecords:'TotalCount'},['id_combustible','descripcion','id_parametro','desc_parametro','id_moneda','desc_moneda','consumo_preferencial','precio_preferencial','precio_mercado'])});	
	//FUNCIONES RENDER	
	function render_id_moneda(value,p,record){return String.format('{0}',record.data['desc_moneda']);}
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
	function render_id_combustible(value,p,record){return String.format('{0}',record.data['descripcion']);}
	var tpl_id_combustible=new Ext.Template('<div class="search-item">','<b><i>{descripcion}</i></b>','<br><FONT COLOR="#B5A642"><b>Consumo Preferencial: </b>{consumo_preferencial}</FONT>','<br><FONT COLOR="#B5A642"><b>Precio. Preferencial: </b>{precio_preferencial}</FONT>','<br><FONT COLOR="#B5A642"><b>Moneda: </b>{desc_moneda}</FONT>','</div>');
	function renderSeparadorDeMil(value,cell,record,row,colum,store){		
		var monedas_for=new Ext.form.MonedaField();
		return monedas_for.formatMoneda(value)		 
	}
	function renderSeparadorDeMil4(value,cell,record,row,colum,store){		
		var monedas_4=new Ext.form.MonedaField({
			allowDecimals:true,
			decimalPrecision:4//para numeros float
		});
		return monedas_4.formatMoneda(value)		 
	}
	function renderPeriodo(value,p,record){
		if(value == 1)
		{return "Enero"}
		if(value == 2)
		{return "Febrero"}
		if(value == 3)
		{return "Marzo"}
		if(value == 4)
		{return "Abril"}
		if(value == 5)
		{return "Mayo"}
		if(value == 6)
		{return "Junio"}
		if(value == 7)
		{return "Julio"}
		if(value == 8)
		{return "Agosto"}
		if(value == 9)
		{return "Septiembre"}
		if(value == 10)
		{return "Octubre"}
		if(value == 11)
		{return "Noviembre"}
		if(value == 12)
		{return "Diciembre"}
	}
	//en la posición 0 siempre esta la llave primaria
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_mem_combustible',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_mem_combustible'
	};
	
	// txt id_memoria_calculo
	Atributos[1]={
		validacion:{
			name:'id_memoria_calculo',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'id_memoria_calculo'
	};


// txt id_moneda
	Atributos[2]={
			validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:false,			
			emptyText:'Mon...',
			desc: 'desc_moneda', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_moneda,
			valueField: 'id_moneda',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'MONEDA.nombre',
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
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:200,
			disabled:false		
		},
		tipo:'ComboBox',
		filtro_0:false,
		id_grupo:1,
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda'
	};	
	
	// txt id_combustible
	Atributos[3]={
			validacion:{
			name:'id_combustible',
			fieldLabel:'Combustible',
			allowBlank:false,			
			emptyText:'Combusti...',
			desc: 'descripcion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_combustible,
			onSelect:
			function(record)
			{
				resetearValores();
				componentes[6].setValue(0);	
				desabilitarComponentes();
				
				if(componentes[16].getValue()==1)
				{
					cantidadPreferencial=0;
					componentes[7].setValue(cantidadPreferencial);					
					componentes[8].setValue(0);
					componentes[10].setValue(0);
					componentes[10].setDisabled(false);					
				}
				else
				{										
					componentes[7].setValue(record.data.consumo_preferencial);
					cantidadPreferencial=componentes[7].getValue();
					componentes[8].setValue(record.data.precio_preferencial);
					componentes[10].setValue(record.data.precio_mercado);
					componentes[10].setDisabled(true);					
				}				
				componentes[3].setValue(record.data.id_combustible);
				componentes[3].collapse(); 
			},
			valueField: 'id_combustible',
			displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'COMBUS.id_combustible',
			typeAhead:true,
			tpl:tpl_id_combustible,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:100,
			minListWidth:300,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_combustible,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:300,
			disabled:false		
		},
		tipo:'ComboBox',
		filtro_0:false,
		id_grupo:2,
		filterColValue:'COMBUS.id_combustible',
		save_as:'id_combustible'
	};
	
	// txt estado_gral
	Atributos[4]={
		validacion: {
			name:'tipo_insercion',
			fieldLabel:'Tipo Inserción',
			allowBlank:false,
			emptyText:'Tipo Inserc...',
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['1','En un mes especifico'],['2','En los doce meses']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,			
			forceSelection:true,
			grid_visible:false,
			grid_editable:false,
			width_grid:150,
			minListWidth:200,
			disable:false			
		},
		tipo:'ComboBox',
		filtro_0:false,
		id_grupo:2,
		filterColValue:'MEMSER.periodo_pres',
		defecto:1,
		save_as:'tipo_insercion'
	};	
	
// txt periodo_pres
	Atributos[5]={
		validacion: {
			name:'periodo_pres',
			fieldLabel:'Periodo',
			allowBlank:false,
			emptyText:'Peri...',
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['1','Enero'],['2','Febrero'],['3','Marzo'],['4','Abril'],['5','Mayo'],['6','Junio'],['7','Julio'],['8','Agosto'],['9','Septiembre'],['10','Octubre'],['11','Noviembre'],['12','Diciembre']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			renderer: renderPeriodo,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			minListWidth:100,
			disable:false	
		},
		tipo:'ComboBox',
		filtro_0:false,
		id_grupo:2,
		filterColValue:'MEMCOM.periodo_pres',
		defecto:1,
		save_as:'periodo_pres'
	};			
	
// txt cantidad_combustible
	Atributos[6]={
		validacion:{
			name:'cantidad_combustible',
			fieldLabel:'Cantidad Combustible',
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
			//renderer: renderSeparadorDeMil,
			width_grid:130,
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		filtro_0:true,
		id_grupo:2,
		filterColValue:'MEMCOM.cantidad_combustible',
		save_as:'cantidad_combustible'
	};
// txt cantidad_preferencial
	Atributos[7]={
		validacion:{
			name:'cantidad_preferencial',
			fieldLabel:'Cantidad Preferencial',
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
			//renderer: renderSeparadorDeMil,
			width_grid:130,
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		filtro_0:true,
		id_grupo:2,
		filterColValue:'MEMCOM.cantidad_preferencial',
		save_as:'cantidad_preferencial'
	};
	
	// txt precio_mercado
	Atributos[8]={
		validacion:{
			name:'precio_preferencial',
			fieldLabel:'Precio Preferencial',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:4,//para numeros float
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
		filtro_0:false,
		id_grupo:2,
		filterColValue:'MEMCOM.precio_preferencial',
		save_as:'precio_preferencial'
	};
	
// txt cantidad_mercado
	Atributos[9]={
		validacion:{
			name:'cantidad_mercado',
			fieldLabel:'Cantidad Mercado',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:true,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			//renderer: renderSeparadorDeMil,
			width_grid:120,
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		filtro_0:true,
		id_grupo:2,
		filterColValue:'MEMCOM.cantidad_mercado',
		save_as:'cantidad_mercado'
	};
// txt precio_mercado
	Atributos[10]={
		validacion:{
			name:'precio_mercado',
			fieldLabel:'Precio de Mercado',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:4,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			//renderer: renderSeparadorDeMil4,
			width_grid:120,
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		filtro_0:true,
		id_grupo:2,
		filterColValue:'MEMCOM.precio_mercado',
		save_as:'precio_mercado'
	};
// txt costo_preferencial
	Atributos[11]={
		validacion:{
			name:'costo_preferencial',
			fieldLabel:'Costo Preferencial',
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
			//renderer: renderSeparadorDeMil,
			width_grid:120,
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		filtro_0:true,
		id_grupo:2,
		filterColValue:'MEMCOM.costo_preferencial',
		save_as:'costo_preferencial'
	};
// txt costo_mercado
	Atributos[12]={
		validacion:{
			name:'costo_mercado',
			fieldLabel:'Costo de Mercado',
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
			//renderer: renderSeparadorDeMil,
			width_grid:120,
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		filtro_0:true,
		id_grupo:2,
		filterColValue:'MEMCOM.costo_mercado',
		save_as:'costo_mercado'
	};
// txt costo_total
	Atributos[13]={
		validacion:{
			name:'costo_total',
			fieldLabel:'Costo Total',
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
			//renderer: renderSeparadorDeMil,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		filtro_0:true,
		id_grupo:2,
		filterColValue:'MEMCOM.costo_total',
		save_as:'costo_total'
	};
// txt porcentaje
	Atributos[14]={
		validacion:{
			name:'porcentaje',
			fieldLabel:'Porcentaje (%)',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			//onSelect:eventPorcentaje(),
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		filtro_0:false,
		id_grupo:2,
		filterColValue:'MEMCOM.porcentaje',
		save_as:'porcentaje'
	};
// txt total_general
	Atributos[15]={
		validacion:{
			name:'total_general',
			fieldLabel:'Importe Total',
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
			//renderer: renderSeparadorDeMil,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		filtro_0:true,
		id_grupo:2,
		filterColValue:'MEMCOM.total_general',
		save_as:'total_general'
	};	
	
	// txt estado_gral
	Atributos[16]={
		validacion: {
			name:'tipo_combustible',
			fieldLabel:'Tipo de Combustible',
			allowBlank:false,
			emptyText:'Tipo de Combusti...',
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',			
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['1','Con precio de mercado'],['2','Con precio preferencial']]}),		
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,			
			forceSelection:true,
			grid_visible:false,
			grid_editable:false,
			width_grid:150,
			minListWidth:200,
			disable:false			
		},
		tipo:'ComboBox',
		filtro_0:false,
		id_grupo:0,		
		save_as:'tipo_combustible'
	};		
	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	tituloM='Memoria de Cálculo';
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Memoria de Cálculo (Maestro)',titulo_detalle:'Memoria de Combustibles o Lubricantes (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_memoria_combustible= new DocsLayoutMaestro(idContenedor);
	layout_memoria_combustible.init(config);
	//---------- INICIAMOS HERENCIA
	this.pagina=Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_memoria_combustible,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarTodosComponente=this.ocultarTodosComponente;
	var CM_mostrarTodosComponente=this.motrarTodosComponente;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var CM_btnEliminar=this.btnEliminar;
	var CM_btnActualizar=this.btnActualizar;
	var CM_btnSave=this.Save;
	var CM_getDialog=this.getDialog;
	var getGrid=this.getGrid;
	var Cm_conexionFailure=this.conexionFailure;
	var getFormulario=this.getFormulario;
	var enableSelect=this.EnableSelect;
	var ClaseMadre_clearSelections=this.clearSelections;
	//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={
		nuevo:{crear:true,separador:true},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}};
	//DEFINICIÓN DE FUNCIONES
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/mem_combustible/ActionEliminarMemoriaCombustible.php'},
		Save:{url:direccion+'../../../control/mem_combustible/ActionGuardarMemoriaCombustible.php'},
		ConfirmSave:{url:direccion+'../../../control/mem_combustible/ActionGuardarMemoriaCombustible.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:500,width:480,minWidth:150,minHeight:200,closable:true,titulo:'Memoria de Combustibles o Lubricantes',guardar:filtro,
		grupos:[{tituloGrupo:'Formulario',columna:0,id_grupo:0},{tituloGrupo:'Filtrar',columna:0,id_grupo:1},{tituloGrupo:'Datos',columna:0,id_grupo:2}]}};
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(m){
		maestro=m;
		// alert (maestro.id_avance);
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_memoria_calculo:maestro.id_memoria_calculo
			}
		};
		
		ds.baseParams={valor_filtro:parseFloat(maestro.id_moneda),filtro:1};	
        ds_combustible.baseParams={id_parametro:maestro.id_parametro};
		prueba.setValue(maestro.id_moneda);
		this.btnActualizar();
		Atributos[1].defecto=maestro.id_memoria_calculo;
		Atributos[2].defecto=maestro.id_moneda;
		CM_mostrarComponente(componentes[5]);
		paramFunciones.btnEliminar.parametros='&m_id_memoria_calculo='+maestro.id_memoria_calculo;
		paramFunciones.Save.parametros='&m_id_memoria_calculo='+maestro.id_memoria_calculo;
		paramFunciones.ConfirmSave.parametros='&m_id_memoria_calculo='+maestro.id_memoria_calculo;
		var CM_getBoton=this.getBoton;
		iniciarEventosFormularios();
		this.InitFunciones(paramFunciones);
		if(maestro.tipo_vista==2){
			CM_getBoton('nuevo-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable()
		}
		else{
			CM_getBoton('nuevo-'+idContenedor).enable();
			CM_getBoton('eliminar-'+idContenedor).enable()
		}
	};
	this.btnNew=function(){
		sw_filtro="false";		
		CM_mostrarGrupo('Formulario');
		CM_ocultarGrupo('Filtrar');
		CM_ocultarGrupo('Datos');
		CM_btnNew()
	};
	
	this.Save=function(){		
		CM_btnSave()			
	};	
	function filtro(){	
		if (sw_filtro=="true"){	
			ds.baseParams={valor_filtro:parseFloat(componentes[2].getValue()),filtro:1}	
			ds.load({params:{start:0,limit:paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,m_id_memoria_calculo:maestro.id_memoria_calculo}});
			dialog.hide()
		}
		else{
			componentes[2].setValue(maestro.id_moneda);
			CM_btnSave()
		}
	}
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
		dialog=CM_getDialog();		
		function insercion(){
			if(componentes[4].getValue()=='1'){
				CM_mostrarComponente(componentes[5])
			}
			else{				
				CM_ocultarComponente(componentes[5])
			}
		}
		componentes[4].on('change',insercion);	
		componentes[4].on('select',insercion);
		componentes[16].on('change',eventTipoCombustible);
		componentes[16].on('select',eventTipoCombustible);
		componentes[6].on('change',eventCantidadCombustible);
		componentes[14].on('change',eventPorcentaje);
		componentes[10].on('change',eventPrecioMercado)
	}
	function eventTipoCombustible(){
		desabilitarComponentes();
		if(componentes[16].getValue()=='1'){
				CM_mostrarGrupo('Datos');
				CM_ocultarGrupo('Filtrar');
				componentes[10].setDisabled(false);
				componentes[10].setValue(0);
				ocultarCompPreferencial();
				resetearValores()										
			}
			else{
				CM_mostrarGrupo('Datos');				
				CM_ocultarGrupo('Filtrar');
				componentes[10].setDisabled(true);
				componentes[10].setValue(0);
				mostrarCompPreferencial();
				resetearValores()
			} 
	}
	function InitPaginaCombustible(){		
		for(var i=0; i<Atributos.length; i++){
			componentes[i]=getComponente(Atributos[i].validacion.name)
		}		
	}
	function resetearValores(){		
		componentes[7].setValue(0);
		componentes[8].setValue(0);
		componentes[9].setValue(0);
		componentes[11].setValue(0);
		componentes[12].setValue(0);
		componentes[13].setValue(0);
		componentes[14].setValue(100);
		componentes[15].setValue(0)
	}
	function desabilitarComponentes(){
		componentes[7].setDisabled(true);
		componentes[8].setDisabled(true);
		componentes[9].setDisabled(true);
		componentes[11].setDisabled(true);
		componentes[12].setDisabled(true);
		componentes[13].setDisabled(true);
		componentes[15].setDisabled(true)
	}
	function mostrarCompPreferencial(){		
		CM_mostrarComponente(componentes[7]);
		CM_mostrarComponente(componentes[8]);
		CM_mostrarComponente(componentes[9]);
		CM_mostrarComponente(componentes[11]);
		CM_mostrarComponente(componentes[12]);		
		CM_mostrarComponente(componentes[13]);
		CM_mostrarComponente(componentes[14])
	}
	function ocultarCompPreferencial(){
		CM_ocultarComponente(componentes[7]);
		CM_ocultarComponente(componentes[8]);
		CM_ocultarComponente(componentes[9]);
		CM_ocultarComponente(componentes[11]);
		CM_ocultarComponente(componentes[12]);		
		CM_ocultarComponente(componentes[13]);
		CM_ocultarComponente(componentes[14])
	}	
	function eventCantidadCombustible(){	
		componentes[7].setValue(cantidadPreferencial);
		if(componentes[16].getValue()=='1'){			
			componentes[7].setValue(0);
			componentes[15].setValue(componentes[6].getValue() * componentes[10].getValue())
		}
		else{
			if(parseFloat(componentes[6].getValue()) > parseFloat(componentes[7].getValue())){
				componentes[9].setValue(componentes[6].getValue() - componentes[7].getValue())
			}
			else{
				componentes[7].setValue(componentes[6].getValue());
				componentes[9].setValue(0)
			}
			componentes[11].setValue(componentes[7].getValue() * componentes[8].getValue());
			componentes[12].setValue(componentes[9].getValue() * componentes[10].getValue());
			componentes[13].setValue(parseFloat(componentes[11].getValue()) + parseFloat(componentes[12].getValue()));
			componentes[15].setValue((componentes[13].getValue() * componentes[14].getValue())/100);
		}		
		desabilitarComponentes()
	}
	function eventPrecioMercado(){
		componentes[15].setValue(componentes[6].getValue() * componentes[10].getValue())
	}
	function eventPorcentaje(){			
		componentes[15].setValue((componentes[13].getValue() * componentes[14].getValue())/100)
	}	
	var prueba=new Ext.form.ComboBox({
			store:ds_moneda,
			displayField:'nombre',
			typeAhead:true,
			mode:'local',
			triggerAction:'all',
			emptyText:'Seleccionar moneda...',
			selectOnFocus:true,
			width:135,
			valueField:'id_moneda',
			editable:false,			
			tpl:tpl_id_moneda			
	});
	ds_moneda.load({
			params:{
				start:0,
				limit: 1000000
			}
	});
	prueba.on('select',	function(){				
			ds.baseParams={valor_filtro:parseFloat(prueba.getValue()),filtro:1};	
			ds.load({params:{start:0,limit:paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,m_id_memoria_calculo:maestro.id_memoria_calculo}});			
	});	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_memoria_combustible.getLayout()};
	//para el manejo de hijos
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	var CM_getBoton=this.getBoton;
	this.InitFunciones(paramFunciones);
	//para agregar botones
	//this.AdicionarBoton('../../../lib/imagenes/list-items.gif',' Insertar Documento',btn_documento,true,'Documento','Documento de Descargo');
	this.AdicionarBotonCombo(prueba,'prueba');
	this.iniciaFormulario();
	InitPaginaCombustible();
	iniciarEventosFormularios();
	this.bloquearMenu();
	layout_memoria_combustible.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)
}