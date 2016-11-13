/**
 * Nombre:		  	    pagina_gerencia_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-01-17 15:14:26
 */
function pagina_llamada(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
	var ds,layout_llamada;
	var elementos=new Array();
	var sw=0;
	//  DATA STORE //
	ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/llamada/ActionListarLlamada.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_llamada',totalRecords:'TotalCount'},
		[
		'id_llamada','fecha_llamada','hora_llamada',
		'numero_interno','numero_marcado','duracion_llamada',
		'saliente','transferido','origen_transferencia',
		'observaciones','fk_id_llamada','desc_origen',
		'id_linea','puerto_linea','id_tipo_llamada',
		'desc_tipo_llamada','id_empleado','id_persona','desc_empleado']),remoteSort:true});
	ds.load({params:{start:0,limit: paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros}});
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_llamada',
			inputType:'hidden'
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_llamada'
	};
// txt fecha_llamada
	vectorAtributos[3]={
		validacion:{
			name:'fecha_llamada',
			fieldLabel:'Fecha de Llamada',
			allowBlank:false,
			maxLength:60,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:'90%',
			grid_visible:true,
			grid_editable:false,
			width_grid:110
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'LLAMAD.fecha_llamada',
		save_as:'txt_fecha_llamada'
	};
// txt hora_llamada
	vectorAtributos[4]={
		validacion:{
			name:'hora_llamada',
			fieldLabel:'Hora de Llamada',
			allowBlank:true,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:110
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'LLAMAD.hora_llamada',
		save_as:'txt_hora_llamada'
	};
	// txt numero_interno
	vectorAtributos[5]={
		validacion:{
			name:'numero_interno',
			fieldLabel:'Interno',
			allowBlank:false,
			maxLength:60,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:'90%',
			grid_visible:true,
			grid_editable:false,
			width_grid:70
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'LLAMAD.numero_interno',
		save_as:'txt_numero_interno'
	};
// txt numero_marcado
	vectorAtributos[6]={
		validacion:{
			name:'numero_marcado',
			fieldLabel:'Número Marcado',
			allowBlank:true,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:110
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'LLAMAD.numero_marcado',
		save_as:'txt_numero_marcado'
	};
// txt duracion_llamada
	vectorAtributos[7]={
		validacion:{
			name:'duracion_llamada',
			fieldLabel:'Duración de Llamada',
			allowBlank:false,
			maxLength:60,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:'90%',
			grid_visible:true,
			grid_editable:false,
			width_grid:125
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'LLAMAD.duracion_llamada',
		save_as:'txt_duracion_llamada'
	};
// txt observaciones
	vectorAtributos[8]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:150
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'LLAMAD.observaciones',
		save_as:'txt_observaciones'
	};
// txt desc_origen
	vectorAtributos[9]={
		validacion:{
			name:'desc_origen',
			fieldLabel:'Origen de Transferencia',
			allowBlank:false,
			maxLength:60,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:'90%',
			grid_visible:true,
			grid_editable:false,
			width_grid:130
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'LLAMAD1.numero_interno',
		save_as:'txt_desc_origen'
	};
// txt puerto_linea
	vectorAtributos[10]={
		validacion:{
			name:'puerto_linea',
			fieldLabel:'Línea',
			allowBlank:true,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:60
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'LINEA.puerto_linea',
		save_as:'txt_puerto_linea'
	};
// txt desc_origen
	vectorAtributos[2]={
		validacion:{
			name:'desc_tipo_llamada',
			fieldLabel:'Tipo de Llamada',
			allowBlank:false,
			maxLength:60,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:'90%',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'TIPLLA.nombre_tipo_llamada',
		save_as:'txt_desc_tipo_llamada'
	};
// txt puerto_linea
	vectorAtributos[1]={
		validacion:{
			name:'desc_empleado',
			fieldLabel:'Funcionario',
			allowBlank:true,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:180
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
		save_as:'txt_desc_empleado'
	};
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	var config={titulo_maestro:'Llamadas',grid_maestro:'grid-'+idContenedor};
	layout_llamada=new DocsLayoutMaestro(idContenedor);
	layout_llamada.init(config);
	// INICIAMOS HERENCIA //
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_llamada,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_onResize=this.onResize;
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	var paramMenu={actualizar:{crear:true,separador:false}};
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	var paramFunciones={
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Llamada'}
	};
	this.getLayout=function(){return layout_llamada.getLayout()};
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
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init();
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
   	this.iniciaFormulario();
	layout_llamada.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}