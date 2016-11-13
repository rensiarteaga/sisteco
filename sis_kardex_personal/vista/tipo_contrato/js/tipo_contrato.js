/**
 * Nombre:		  	    pagina_tipo_contrato_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-18 09:06:57
 */
function pagina_tipo_contrato(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var layout_tipo_contrato;
	var txt_codigo,txt_nombre,txt_fecha_reg;
	var sw=0;
	var componentes=new Array;
	
	/////////////////
	//  DATA STORE //
	/////////////////
	ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/tipo_contrato/ActionListarTipoContrato.php'}),
		// aqui se define la estructura del XML
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_tipo_contrato',
			totalRecords:'TotalCount'
		},[
		// define el mapeo de XML a las etiquetas (campos)
		'id_tipo_contrato',
		'codigo',
		'nombre',	
		'estado_reg',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'usuario_reg'
		]),remoteSort:true});
		
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	//Definición de datos
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_tipo_contrato',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_tipo_contrato'
	};
	

	// txt codigo
	vectorAtributos[1]={
		validacion:{
			name:'codigo',
			fieldLabel:'Código',
			allowBlank:false,
			maxLength:5,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:150
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TIPCON.codigo',
		save_as:'txt_codigo'	
	};
	
	// txt nombre
	vectorAtributos[2]={
		validacion:{
			name:'nombre',
			fieldLabel:'Nombre',
			allowBlank:false,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:150
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TIPCON.nombre',
		save_as:'txt_nombre'
	};	
	
	
	vectorAtributos[3]={
			validacion:{
				labelSeparator:'',
				name:'estado_reg',
				inputType:'hidden',
				grid_visible:true, 
				grid_editable:false
			},
			tipo:'Field',
			filtro_0:false,
			save_as:'estado_reg',
			form:false
		};
	
	vectorAtributos[4]= {	
			validacion:{
				name:'fecha_reg',
				fieldLabel:'Fecha Registro',
				allowBlank:true,
				format:'d/m/Y', //formato para validacion
				minValue:'01/01/1900',
				disabledDaysText:'Día no válido',
				grid_visible:true,
				grid_editable:false,
				renderer:formatDate,
				width_grid:100
			},
			form:false,
			filtro_0:true,
			
			filterColValue:'TIPCON.fecha_reg',
			tipo:'DateField',
			dateFormat:'m-d-Y',
			save_as:'txt_fecha_reg'	
		};
	
	vectorAtributos[5]={
			validacion:{
				labelSeparator:'',
				name:'usuario_reg',
				//inputType:'hidden',
				grid_visible:true, 
				grid_editable:false
			},
			tipo:'Field',
			filtro_0:false,
			save_as:'usuario_reg',
			form:false
		};
	
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};
	
	
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//	
	var config={titulo_maestro:'Tipo de Contrato',grid_maestro:'grid-'+idContenedor};
	var layout_tipo_contrato=new DocsLayoutMaestro(idContenedor);
	layout_tipo_contrato.init(config);
	
	// INICIAMOS HERENCIA //
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_tipo_contrato,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_onResize=this.onResize;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var cm_EnableSelect=this.EnableSelect;
	
	
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/tipo_contrato/ActionEliminarTipoContrato.php'},
		Save:{url:direccion+'../../../control/tipo_contrato/ActionGuardarTipoContrato.php'},
		ConfirmSave:{url:direccion+'../../../control/tipo_contrato/ActionGuardarTipoContrato.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:300,	//alto
		width:400,		
		closable:true,
		titulo:'Tipo Contrato'}
	};	
		
	
	
	//Para manejo de eventos
	function iniciarEventosFormularios()
	{
		for(var i=0; i<vectorAtributos.length; i++){
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}
		
	    txt_codigo=ClaseMadre_getComponente ('codigo');
        txt_nombre=ClaseMadre_getComponente ('nombre');
       
		
	}
	
	
	
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_tipo_contrato.getLayout()
	};
	
	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo)
	{
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++)
		{
			if(elementos[i].idContenedor==idContenedorHijo)
			{
				return elementos[i]
			}
		}
	};
	
	this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};
	
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_tipo_contrato.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}