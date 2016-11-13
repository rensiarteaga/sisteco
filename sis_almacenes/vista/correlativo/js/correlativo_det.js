/**
* Nombre:		  	    pagina_correlativo_det.js
* Propósito: 			pagina objeto principal
* Autor:				JoSé A. Mita H.
* Fecha creación:		2007-10-18 15:38:53
*/
function pagina_correlativo_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var vectorAtributos=new Array;
    var ds,layout_correlativo,h_txt_valor_actual,h_txt_incremento,h_txt_valor_siguiente;
	var elementos=new Array();
	var sw=0;
//  DATA STORE //
ds=new Ext.data.Store({
	proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/correlativo/ActionListarCorrelativo_det.php'}),
	reader:new Ext.data.XmlReader({
		record:'ROWS',
		id:'id_correlativo',
		totalRecords:'TotalCount'
	},[
	'id_correlativo',
	'codigo',
	'prefijo',
	'sufijo',
	'valor_actual',
	'valor_siguiente',
	'incremento',
	'desc_parametro_almacen',
	'id_parametro_almacen'
	]),remoteSort:true});
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_parametro_almacen:maestro.id_parametro_almacen
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO
	var cmMaestro=new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>'}
	function italic(value){return '<i>'+value+'</i>'}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields: ['atributo','valor'],data:[['Id Parametro Almacen',maestro.id_parametro_almacen],['Dias de Reserva',maestro.dias_reserva],['cierre',maestro.cierre]]}),cm:cmMaestro});
	gridMaestro.render();
	// hidden id_correlativo
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_correlativo',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_correlativo'
	};
	vectorAtributos[1]={
		validacion:{
			name:'codigo',
			fieldLabel:'Código',
			allowBlank:false,
			disabled:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'CORREL.codigo',
		save_as:'txt_codigo'
	};
	// txt prefijo
	vectorAtributos[2]={
		validacion:{
			name:'prefijo',
			fieldLabel:'Prefijo',
			allowBlank:false,
			maxLength:25,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'CORREL.prefijo',
		save_as:'txt_prefijo'
	};
	// txt sufijo
	vectorAtributos[3]={
		validacion:{
			name:'sufijo',
			fieldLabel:'Sufijo',
			allowBlank:false,
			maxLength:25,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'CORREL.sufijo',
		save_as:'txt_sufijo'
	};
	// txt valor_actual
	vectorAtributos[4]={
		validacion:{
			name:'valor_actual',
			fieldLabel:'Valor Actual',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			disabled:true,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:2,
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo:'NumberField',
		filtro_0:true,
		filterColValue:'CORREL.valor_actual',
		save_as:'txt_valor_actual'
	};
	// txt valor_siguiente
	vectorAtributos[6]={
		validacion:{
			name:'valor_siguiente',
			fieldLabel:'Siguiente Valor',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			disabled:true,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo:'NumberField',
		filtro_0:true,
		filterColValue:'CORREL.valor_siguiente',
		save_as:'txt_valor_siguiente'
	};
	// txt incremento
	vectorAtributos[5]={
		validacion:{
			name:'incremento',
			fieldLabel:'Incremento',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo:'NumberField',
		filtro_0:true,
		filterColValue:'CORREL.incremento',
		save_as:'txt_incremento'
	};
	// txt id_parametro_almacen
	vectorAtributos[7]={
		validacion:{
			name:'id_parametro_almacen',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_parametro_almacen,
		save_as:'txt_id_parametro_almacen'
	};
	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''}
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Parámetros de Gestión (Maestro)',titulo_detalle:'Correlativos (Detalle)',grid_maestro:'grid-'+idContenedor};
	layout_correlativo=new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_correlativo.init(config);
	//---------- INICIAMOS HERENCIA
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_correlativo,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	//-------- DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={editar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_parametro_almacen=datos.m_id_parametro_almacen;
		maestro.dias_reserva=datos.m_dias_reserva;
		maestro.cierre=datos.m_cierre;
		gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['Id Parametro Almacen',maestro.id_parametro_almacen],['Dias de Reserva',maestro.dias_reserva],['cierre',maestro.cierre]]);
		vectorAtributos[7].defecto=maestro.id_parametro_almacen;
		var paramFunciones={
			Save:{url:direccion+'../../../control/correlativo/ActionGuardarCorrelativo.php',parametros:'&m_id_parametro_almacen='+maestro.id_parametro_almacen},
			ConfirmSave:{url:direccion+'../../../control/correlativo/ActionGuardarCorrelativo.php',parametros:'&m_id_parametro_almacen='+maestro.id_parametro_almacen},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,closable:true,titulo:'Correlativo'}
		};
	    this.InitFunciones(paramFunciones);
	    ds.lastOptions={params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_parametro_almacen:maestro.id_parametro_almacen
			}
		};
		this.btnActualizar()
	}
	//--------- DEFINICIÓN DE FUNCIONES
	var paramFunciones={
		Save:{url:direccion+'../../../control/correlativo/ActionGuardarCorrelativo.php',parametros:'&m_id_parametro_almacen='+maestro.id_parametro_almacen},
		ConfirmSave:{url:direccion+'../../../control/correlativo/ActionGuardarCorrelativo.php',parametros:'&m_id_parametro_almacen='+maestro.id_parametro_almacen},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,closable:true,titulo:'Correlativo'}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios(){
		h_txt_valor_actual=ClaseMadre_getComponente('valor_actual');
		h_txt_incremento=ClaseMadre_getComponente('incremento');
		h_txt_valor_siguiente=ClaseMadre_getComponente('valor_siguiente');
	     function cargar_valor_sig(){
	     	h_txt_valor_siguiente.setValue(h_txt_valor_actual.getValue()+h_txt_incremento.getValue())
	}
    	h_txt_incremento.on('change',cargar_valor_sig);
	    h_txt_valor_actual.on('change',cargar_valor_sig)
	}
	this.getLayout=function(){
		return layout_correlativo.getLayout()
	};
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(var i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i]
			}
		}
	};
	this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};
	this.Init();
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_correlativo.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)
}