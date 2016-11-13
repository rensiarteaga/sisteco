/**
* Nombre:		  	    pagina_orden_compra_np.js
* Propósito: 			pagina objeto principal
* Autor:				AMVQ
* Fecha creación:		08/03/2010
*/
function pagina_prestacion_servicios(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	//var data_ep;
	var componentes=new Array();
   // var txt_emp=0;
	//DATA STORE's
	
	var ds_departamento=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../../sis_parametros/control/depto/ActionListarDepartamentoEPUsuario.php?subsistema=compro'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto',totalRecords:'TotalCount'},['id_depto','codigo_depto','nombre_depto','estado','id_subsistema','nombre_corto','nombre_largo'])
	});
    	
	//FUNCIONES RENDER
	
		
	function formatDate(value){return value ? value.dateFormat('d/m/Y') : '';};
	
   var resultTplDepto=new Ext.Template('<div class="search-item">','<b><i>{nombre_depto}</i></b>','<br><FONT COLOR="#B5A642">Código:{codigo_depto}</FONT>','</div>');
  
vectorAtributos[0]={
		validacion:{
			fieldLabel:'Departamento',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Depto...',
			name:'departamento',
			desc:'nombre_depto',
			store:ds_departamento,
			valueField:'id_depto',
			displayField:'nombre_depto',
			queryParam:'filterValue_0',
			filterCol :'DEPTO.nombre_depto#DEPTO.codigo_depto',
			typeAhead:false,
			forceSelection:true,
			tpl:resultTplDepto,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:200,
			resizable:true,
			minChars:0,
			triggerAction:'all',
			width:200,
			editable:true
		},
		id_grupo:0,
		save_as:'departamento',
		tipo:'ComboBox'
	};
	vectorAtributos[1]={
		validacion:{
			labelSeparator:'',
			name:'desc_depto',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'desc_depto'
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
	var config={
		titulo_maestro:'Parametros de Reporte Prestacion de Servicios'

	};
	layout=new DocsLayoutProceso(idContenedor);
	layout.init(config);
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,layout,idContenedor);

	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	function obtenerTitulo()
	{
		//var combo_financiador = ClaseMadre_getComponente('id_financiador');
		var titulo = "Reporte Orden de Compra";

		return titulo;
	}

	//datos necesarios para el filtro
	var paramFunciones = {

		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:'100%',
		url:direccion+'../../../../control/_reportes/prestacion_servicios/ActionPDFPrestacionServicios.php',
		abrir_pestana:true, //abrir pestana
		titulo_pestana:obtenerTitulo,
		fileUpload:false,
		width:'50%',
		columnas:['50%'],
		minWidth:150,minHeight:200,	closable:true,titulo:'nose donde sale',
		grupos:[
		{tituloGrupo:'Departamento',columna:0,id_grupo:0}
		
		
		]}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	
	function iniciarEventosFormularios(){
		for(var i=0; i<vectorAtributos.length; i++)
		{
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}
				
		componentes[0].on('select',evento_departamento);		//departamento
			
	}
	
	function evento_departamento( combo, record, index )
		{		
			componentes[1].setValue(record.data.codigo_depto+'-'+record.data.nombre_depto);
		}
	
	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init(); //iniciamos la clase madre
	//this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
  
	this.iniciaFormulario();
	iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
