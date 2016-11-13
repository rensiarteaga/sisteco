//<script>
function main(){
	 <?php
	//obtenemos la ruta absoluta
	$host  = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir = "http://$host$uri/";
	echo "\nvar direccion=\"$dir\";";
	echo "var idContenedor='$idContenedor';";
	?>

var paramConfig={TiempoEspera:10000};
var elemento={pagina:new pagina_clasificacion_supergrupo(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

//view added

/**
 * Nombre:		  	    pagina_clasificacion_supergrupo.js
 * Propósito: 			pagina objeto principal
 * Autor:				
 * Fecha creación:		2007-11-26 
 */
function pagina_clasificacion_supergrupo(idContenedor,direccion,paramConfig)
{	var vectorAtributos=new Array;

	var datax;
   
	 ds_supergrupo= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../control/supergrupo/ActionListarSuperGrupo.php?origen=filtro'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_supergrupo',
			totalRecords: 'TotalCount'
		}, ['id_supergrupo','codigo','nombre','descripcion'])
	});
	
		
	function renderSupergrupo(value, p, record){return String.format('{0}', record.data['nombre']);}
		
	// Definición de datos //
	/////////////////////////
	//en la posición 0 siempre esta la llave primaria
	
	var param_id_supergrupo={
		validacion:{
			fieldLabel:'Supergrupos',
			allowBlank:false,
			vtype:'texto',
			emptyText:'Supergrupo...',
			name:'id_supergrupo',
			desc:'nombre',
			store:ds_supergrupo,
			valueField:'id_supergrupo',
			displayField:'nombre',
			queryParam:'filterValue_0',
			filterCol:'nombre',
			typeAhead:true,
			forceSelection:true,
			renderer:renderSupergrupo,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			width:200,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:0,
			triggerAction:'all',
			editable:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:180
		},
		
		save_as:'txt_id_supergrupo',
		tipo:'ComboBox',
		id_grupo:0
	};
	vectorAtributos[0] = param_id_supergrupo;
	
		
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
		titulo_maestro:'Clasificación de Supergrupos'
		
	};
	layout_clasificacion_supergrupo=new DocsLayoutProceso(idContenedor);
	layout_clasificacion_supergrupo.init(config);
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,layout_clasificacion_supergrupo,idContenedor);
	
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
    var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_save=this.Save;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_ocultarTodosComponente=this.ocultarTodosComponente;
	var CM_mostrarTodosComponente=this.mostrarTodosComponente;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_btnEliminar = this.btnEliminar;
	var ClaseMadre_btnActualizar = this.btnActualizar;
	var ClaseMadre_submit = this.submit;
	
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////
	
    //////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	
	function obtenerTitulo()
	{
		
		var titulo = "Clasificación de Supergrupos";
		return titulo;
	}
	
	//datos necesarios para el filtro
	var paramFunciones = {
		
		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:'70%',
		url:direccion+'../../../../../control/_reportes/clasificacion_supergrupo/ActionClasificacionSupergrupo.php?'+datax,
				
	//	window.open(direccion+'../../../../../control/_reportes/clasificacion_supergrupo/ActionClasificacionSupergrupo.php?txt_id_supergrupo='+combo_supergrupo.getValue()),
		abrir_pestana:true, //abrir pestana
		titulo_pestana:obtenerTitulo,
		
		fileUpload:true,
		width:'60%',
		columnas:['50%'],
		minWidth:150,minHeight:200,	closable:true,titulo:'Clasificacion Supergrupo',
		grupos:[{
			tituloGrupo:'Supergupo',
			columna: 0,
			id_grupo:0
		}
		]}};
		
		
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	
	//Para manejo de eventos

		function iniciarEventosFormularios(){	
		//para iniciar eventos en el formulario
		combo_supergrupo= ClaseMadre_getComponente('id_supergrupo');
		   				
		
		 function clasificacion(){
		    datax = "txt_id_supergrupo=" + combo_supergrupo.getValue();
				
		 }
		
		combo_supergrupo.on('select',clasificacion);
		combo_supergrupo.on('change',clasificacion);
		
	}
	
   //para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_clasificacion_supergrupo.getLayout();};
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
				//this.InitBarraMenu(paramMenu);
				//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
				
				
				this.InitFunciones(paramFunciones);
				//para agregar botones
				
				this.iniciaFormulario();
				iniciarEventosFormularios();
				//layout_almacen.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}