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
var elemento={idContenedor:idContenedor,pagina:new pagina_memoria_viaje(idContenedor,direccion,paramConfig,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
* Nombre:		  	    pag_descargo_detalle.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-05-16 09:53:33
*/
function pagina_memoria_viaje(idContenedor,direccion,paramConfig,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var tituloM,maestro,txt_sw_valida;
	var dialog;
	var componentes=new Array();
	var importe_viaticos ;
	var importe_hotel ;
	var sw_filtro="false";
	
	//DATA STORE//
	var ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/mem_viaje/ActionListarViajeGasto.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_mem_viaje',
			totalRecords:'TotalCount'
		},[
		'id_mem_viaje',
		'nombre_lugar',
		'ubicacion_lugar',
		'id_cobertura',
		'desc_cobertura',
		'nro_dias',
		'importe_viaticos',
		'total_viaticos',
		'importe_hotel',
		'total_hotel',
		'importe_pasajes',
		'importe_otros',
		'total_general',
		'id_moneda',
		'desc_moneda',
		'periodo_pres',
		'id_memoria_calculo',
		'desc_memoria_calculo',
		'porcentaje',
		'valor_porcentaje',
		'id_mem_pasaje',
		'desc_destino'
		]),remoteSort:true});
	// Definición de datos //
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var ds_destino=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/destino/ActionListarDestino.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_destino',totalRecords:'TotalCount'},['id_destino','importe_hotel','importe_viaticos','id_categoria','desc_categoria','id_lugar','desc_lugar','id_moneda','desc_moneda','imp_mon_pasaje','imp_mon_hotel','imp_mon_viatico'])
	});		
    var ds_cobertura=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/cobertura/ActionListarCobertura.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cobertura',totalRecords:'TotalCount'},['id_cobertura','porcentaje','sw_hotel','incluye_hotel','descripcion'])
	});
    var ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
			baseParams:{sw_combo_presupuesto:'si'}
	});

    var ds_memoria_calculo=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/memoria_calculo/ActionListarMemoriaCalculo.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_memoria_calculo',totalRecords:'TotalCount'},['id_memoria_calculo','justificacion','tipo_detalle','id_concepto_ingas','id_partida_presupuesto'])
	});
	var ds_pasaje=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/mem_pasaje/ActionListarMemoriaPasaje.php'}),
				reader: new Ext.data.XmlReader({record: 'ROWS',	id: 'id_mem_pasaje',totalRecords:'TotalCount'}, ['id_mem_pasaje','id_destino','nombre_lugar','desc_destino','id_moneda','desc_moneda','periodo_pres','total_general','id_memoria_calculo','desc_memoria_calculo','desc_categoria','id_categoria'])});
	//FUNCIONES RENDER
	function renderSwHotel(value, p, record){
		if(value == 1)
		{return "SI"}
		if(value == 2)
		{return "NO"}}
	function renderSeparadorDeMil(value,cell,record,row,colum,store){		
		var monedas_for=new Ext.form.MonedaField();
		return monedas_for.formatMoneda(value)		 
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
		{return "Diciembre"}}	
	function render_id_cobertura(value,p,record){return String.format('{0}',record.data['desc_cobertura']);}
	var tpl_id_cobertura=new Ext.Template('<div class="search-item">','<b><i>Porcentaje: {descripcion} </i></b>','<br><FONT COLOR="#B5A642"><b>Incluye Hotel: {incluye_hotel}</b></FONT>','</div>');
	function render_id_moneda(value,p,record){return String.format('{0}',record.data['desc_moneda']);}
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
	function render_id_memoria_calculo(value,p,record){return String.format('{0}',record.data['desc_memoria_calculo']);}
	var tpl_id_memoria_calculo=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{justificacion}</FONT><br>','</div>');
	function render_id_mem_pasaje(value,p,record){return String.format('{0}',record.data['desc_destino']);}
	var tpl_id_mem_pasaje=new Ext.Template('<div class="search-item">','<b>Destino: {desc_destino}</b>','<br><FONT COLOR="#B5A642"><b>Categoría: </b>{desc_categoria}</FONT>','<br><FONT COLOR="#B5A642"><b>Periodo: </b>{periodo_pres}</FONT>','</div>');
	//en la posición 0 siempre esta la llave primaria
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_mem_viaje',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_mem_viaje'
	};
	// txt id_cobertura
	Atributos[1]={
			validacion:{
			name:'id_mem_pasaje',
			fieldLabel:'Destino Pasaje',
			allowBlank:false,			
			emptyText:'Pasaje...',
			desc: 'desc_destino', 	
			store:ds_pasaje,
			valueField: 'id_mem_pasaje',
			displayField: 'desc_destino',
			queryParam: 'filterValue_0',
			filterCol:'LUGARR.nombre',
			typeAhead:true,
			onSelect:function(record){eventPasaje(record)},
			tpl:tpl_id_mem_pasaje,
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
			modificado:true,
			renderer:render_id_mem_pasaje,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:300,
			disabled:true
		},
		tipo:'ComboBox',
		form: true,
		mode:'remote',
		filtro_0:true,
		filterColValue:'MEMPAS.desc_destino',
		id_grupo:0,
		save_as:'id_mem_pasaje'
	};
// txt estado_gral
	Atributos[2]={
		validacion: {
			name:'periodo_pres',
			fieldLabel:'Periodo',
			allowBlank:true,
			emptyText:'Periodo...',
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['1','Enero'],['2','Febrero'],['3','Marzo'],['4','Abril'],['5','Mayo'],['6','Junio'],['7','Julio'],['8','Agosto'],['9','Septiembre'],['10','Octubre'],['11','Noviembre'],['12','Diciembre']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			decimalPrecision:0,//para numeros float
			renderer: renderPeriodo,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			minListWidth:100,
			width:200,
			disabled:true,
			grid_indice:2
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		filterColValue:'MEMVIA.periodo_pres',
		id_grupo:0,
		defecto:1,
		save_as:'periodo_pres'
	};		
// txt nro_dias
	Atributos[3]={
		validacion:{
			name:'nro_dias',
			fieldLabel:'Nro. Dias',
			allowBlank:false,
			maxLength:50,
			align:'right', 
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:1,
			grid_visible:true,
			grid_editable:false,
			width_grid:70,
			width:100,
			disabled:false
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'MEMVIA.nro_dias',
		id_grupo:0,
		save_as:'nro_dias'
	};		
	// txt id_cobertura
	Atributos[4]={
			validacion:{
			name:'id_cobertura',
			fieldLabel:'Cobertura (%)',
			allowBlank:false,			
			emptyText:'Cobertura...',
			desc: 'desc_cobertura', 	//	indica la columna del store principal ds del que proviane la descripcion
			store:ds_cobertura,			//	componentes[15].setValue(record.data.porcentaje);
			onSelect: function(record){eventCobertura(record)},
			valueField: 'id_cobertura',
			displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'COBERT.descripcion',
			typeAhead:true,
			tpl:tpl_id_cobertura,
			forceSelection:true,
			mode:'remote',
			align:'right', 
			queryDelay:200,
			pageSize:100,
			minListWidth:200,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_cobertura,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:200,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'COBERT.descripcion',
		id_grupo:0,
		save_as:'id_cobertura'
	};
// txt importe_viaticos
	Atributos[5]={
		validacion:{
			name:'importe_viaticos',
			fieldLabel:'Importe Viáticos por Día',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:0,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			//renderer: renderSeparadorDeMil,
			width_grid:100,
			width:100,
			disabled:true		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'MEMVIA.importe_viaticos',
		id_grupo:0,
		save_as:'importe_viaticos'
	};
// txt total_viaticos
	Atributos[6]={
		validacion:{
			name:'total_viaticos',
			fieldLabel:'Total Viáticos',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:0,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			//renderer: renderSeparadorDeMil,
			width_grid:100,
			width:150,
			disabled:true		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'MEMVIA.total_viaticos',
		id_grupo:0,
		save_as:'total_viaticos'
	};
// txt importe_hotel
	Atributos[7]={
		validacion:{
			name:'importe_hotel',
			fieldLabel:'Importe Hotel por Día',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:0,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			//renderer: renderSeparadorDeMil,
			width_grid:100,
			width:100,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'MEMVIA.importe_hotel',
		id_grupo:0,
		save_as:'importe_hotel'
	};
// txt total_hotel
	Atributos[8]={
		validacion:{
			name:'total_hotel',
			fieldLabel:'Total Hotel',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:0,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			//renderer: renderSeparadorDeMil,
			width_grid:100,
			width:150,
			disabled:true		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'MEMVIA.total_hotel',
		id_grupo:0,
		save_as:'total_hotel'
	};
// txt importe_otros
	Atributos[9]={
		validacion:{
			name:'importe_otros',
			fieldLabel:'Importe Otros Gastos',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:0,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			//renderer: renderSeparadorDeMil,
			width_grid:100,
			width:100,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'MEMVIA.importe_otros',
		id_grupo:0,
		save_as:'importe_otros'
	};
// txt total_general
	Atributos[10]={
		validacion:{
			name:'total_general',
			fieldLabel:'Total General',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:0,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			//renderer: renderSeparadorDeMil,
			width_grid:100,
			width:150,
			disabled:true		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'MEMVIA.total_general',
		id_grupo:0,
		save_as:'total_general'
	};
// txt id_moneda
	Atributos[11]={
			validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:true,			
			emptyText:'Moneda...',
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
			width_grid:160,
			width:200,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		id_grupo:1,
		save_as:'id_moneda'
	};
// txt id_memoria_calculo
	Atributos[12]={
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
		id_grupo:0,
		save_as:'id_memoria_calculo'
	};	
	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	tituloM='Memoria de Cálculo';
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Memoria de Cálculo (Maestro)',titulo_detalle:'Memoria de Viajes (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_memoria_viaje= new DocsLayoutMaestro(idContenedor);
	layout_memoria_viaje.init(config);
	//---------- INICIAMOS HERENCIA
	this.pagina=Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_memoria_viaje,idContenedor);
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
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}};
	//DEFINICIÓN DE FUNCIONES
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/mem_viaje/ActionEliminarViajeGasto.php'},
		Save:{url:direccion+'../../../control/mem_viaje/ActionGuardarViajeGasto.php'},
		ConfirmSave:{url:direccion+'../../../control/mem_viaje/ActionGuardarViajeGasto.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,titulo:'Memoria de Viáticos',height:400,width:480,minWidth:150,minHeight:200,closable:true,guardar:filtro,
		grupos:[{tituloGrupo:'Datos',columna:0,id_grupo:0},{tituloGrupo:'Filtrar',columna:0,id_grupo:1}]}};
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
		ds_pasaje.baseParams={m_id_moneda:maestro.id_moneda,m_id_memoria_calculo:maestro.id_memoria_calculo, sw_combo:'si'};
		prueba.setValue(maestro.id_moneda);
		this.btnActualizar();
		Atributos[12].defecto=maestro.id_memoria_calculo;
		Atributos[11].defecto=maestro.id_moneda;	
	
		paramFunciones.btnEliminar.parametros='&m_id_memoria_calculo='+maestro.id_memoria_calculo;
		paramFunciones.Save.parametros='&m_id_memoria_calculo='+maestro.id_memoria_calculo;
		paramFunciones.ConfirmSave.parametros='&m_id_memoria_calculo='+maestro.id_memoria_calculo;
		this.InitFunciones(paramFunciones);
		var CM_getBoton=this.getBoton;
		if(maestro.tipo_vista==2)
		{
			CM_getBoton('nuevo-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable();
		}
		else
		{
			CM_getBoton('nuevo-'+idContenedor).enable();
			CM_getBoton('eliminar-'+idContenedor).enable();
		}
	};
	this.btnNew=function(){
		ocultarComponentes();
		componentes[1].setDisabled(false);
		componentes[2].setDisabled(false);
		componentes[3].setDisabled(false);
		componentes[4].setDisabled(false);
		componentes[1].store.baseParams={m_id_moneda:maestro.id_moneda,m_id_memoria_calculo:maestro.id_memoria_calculo, sw_combo:'si'};
		
		sw_filtro="false";
		CM_ocultarGrupo('Filtrar');
		CM_mostrarGrupo('Datos');
		componentes[1].modificado=true;
		CM_btnNew();		
	};
	
	this.Save=function(){		
		CM_btnSave()			
	};
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		dialog=CM_getDialog()
		}
	function filtro(){	
		if (sw_filtro=="true"){	
			ds.baseParams={valor_filtro:parseFloat(componentes[11].getValue()),filtro:1}	
			ds.load({params:{start:0,limit:paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,m_id_memoria_calculo:maestro.id_memoria_calculo}});
			CM_getDialog().hide()
		}
		else{
			CM_btnSave()
		}
	}
	function InitPaginaViajeGasto(){		
		for(var i=0; i<Atributos.length; i++){
			componentes[i]=getComponente(Atributos[i].validacion.name)
		}
		componentes[1].on('select',eventPasaje);
		componentes[1].on('change',eventPasaje);
		componentes[3].on('change',eventDias);
		componentes[5].on('change',eventViatico);
		componentes[7].on('change',eventHotel);
		componentes[9].on('change',eventOtros)
	}
	function redondear(cantidad,decimales){
		var cantidad=parseFloat(cantidad);
		var decimales=parseFloat(decimales);
		decimales=(!decimales ? 2 : decimales);
		return Math.round(cantidad * Math.pow(10, decimales)) / Math.pow(10, decimales);0
	} 
	function ocultarComponentes(){
		for(var i=0;i<Atributos.length;i++){
			componentes[i].setDisabled(true)}
	}	
	function eventViatico(){
		componentes[6].setValue(parseFloat(componentes[5].getValue())*parseFloat(componentes[3].getValue()));
		componentes[10].setValue(parseFloat(componentes[6].getValue())+parseFloat(componentes[8].getValue())+parseFloat(componentes[9].getValue()));
	}
	function eventHotel(){
		componentes[8].setValue(parseFloat(componentes[7].getValue())*(parseFloat(componentes[3].getValue())-1));
		componentes[10].setValue(parseFloat(componentes[6].getValue())+parseFloat(componentes[8].getValue())+parseFloat(componentes[9].getValue()));
	}
	function eventOtros(){
		componentes[10].setValue(parseFloat(componentes[6].getValue())+parseFloat(componentes[8].getValue())+parseFloat(componentes[9].getValue()));
	}
	function eventCobertura(record){	
		ocultarComponentes();
		componentes[1].setDisabled(false);
		componentes[2].setDisabled(false);
		componentes[3].setDisabled(false);
		componentes[4].setDisabled(false);
		componentes[4].setValue(record.data.id_cobertura);
		componentes[5].setDisabled(false);
		componentes[5].setValue('');
		componentes[6].setValue('');
		componentes[7].setValue('');
		componentes[8].setValue('');
		componentes[9].setValue('');
		componentes[10].setValue('');
		var porcentaje=parseFloat(record.data.porcentaje);
		var swHotel=parseFloat(record.data.sw_hotel);
		componentes[5].setValue(redondear(importe_viaticos*porcentaje/100,2));
			if(swHotel==1 && componentes[3].getValue()>1){componentes[7].setDisabled(false);componentes[7].setValue(importe_hotel);}
			else {componentes[7].setValue(0);componentes[7].setDisabled(true);}
		componentes[6].setValue(parseFloat(componentes[5].getValue())*parseFloat(componentes[3].getValue()));
		componentes[8].setValue(parseFloat(componentes[7].getValue())*(parseFloat(componentes[3].getValue())-1));
		componentes[9].setValue(0);
		componentes[9].setDisabled(false);
		componentes[10].setValue(parseFloat(componentes[6].getValue())+parseFloat(componentes[8].getValue())+parseFloat(componentes[9].getValue()));
		componentes[4].collapse()
	}
	
	function eventDias(){	
		ocultarComponentes();
		componentes[1].setDisabled(false);
		componentes[2].setDisabled(false);
		componentes[3].setDisabled(false);
		componentes[4].setDisabled(false);
		componentes[5].setValue('');
		componentes[6].setValue('');
		componentes[7].setValue('');
		componentes[8].setValue('');
		componentes[9].setValue('');
		componentes[10].setValue('')
	}
	function eventPasaje(record){
		ocultarComponentes();
		componentes[1].setDisabled(false);
		componentes[2].setDisabled(false);
		componentes[3].setDisabled(false);
		componentes[4].setDisabled(false);
		componentes[3].setValue('');
		componentes[4].setValue('');
		componentes[5].setValue('');
		componentes[6].setValue('');
		componentes[7].setValue('');
		componentes[8].setValue('');
		componentes[9].setValue('');
		componentes[10].setValue('');
		componentes[2].setValue(record.data.periodo_pres);
		componentes[1].setValue(record.data.id_mem_pasaje); 
		ds_destino.load
		({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_destino:getId_Destino(componentes[1].getValue(),componentes[1].store),
				id_moneda:maestro.id_moneda
				},
			callback: function(){
				importe_viaticos=ds_destino.getAt(0).data['imp_mon_viatico'] ;
		  		importe_hotel=ds_destino.getAt(0).data['imp_mon_hotel'] ;			
			}
		});
	componentes[1].collapse()
	}
	function getId_Destino(id_mem_pasaje,ds){  	
		for(var i=0;i<ds.data.length;i++)
		{if(ds.getAt(i).data['id_mem_pasaje']==id_mem_pasaje){	return ds.getAt(i).data['id_destino'];};}}
var prueba=new Ext.form.ComboBox({
			store: ds_moneda,
			displayField:'nombre',
			typeAhead: true,
			mode: 'local',
			triggerAction: 'all',
			emptyText:'Seleccionar moneda...',
			selectOnFocus:true,
			width:135,
			valueField: 'id_moneda',	
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
	this.getLayout=function(){return layout_memoria_viaje.getLayout()};
	//para el manejo de hijos
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	//this.AdicionarBoton('../../../lib/imagenes/list-items.gif',' Insertar Documento',btn_documento,true,'Documento','Documento de Descargo');
	this.AdicionarBotonCombo(prueba,'prueba');
	this.iniciaFormulario();
	InitPaginaViajeGasto();
	iniciarEventosFormularios();
	this.bloquearMenu();
	layout_memoria_viaje.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)
}