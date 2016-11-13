//<script>
<?php session_start(); ?>
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

var elemento={pagina:new pagina_activo_fijo_responsable(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);


/**
 * Nombre:		  	    activo_fijo_responsable.js
 * Propósito: 			pagina objeto principal
 * Autor:				Daniel Sanchez Torrico
 * Fecha creación:		18/10/2012
 */
function pagina_activo_fijo_responsable(idContenedor,direccion,paramConfig)
{	var vectorAtributos=new Array;
    var Atributos=new Array;
    var componentes= new Array();
    
    
    ds_activo_fijo = new Ext.data.Store({
		// asigna url de donde se cargarán los datos
	
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../../control/activo_fijo/ActionSimpleListaActivoFijo.php?origen=filtro&oc=si'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_activo_fijo',
			totalRecords: 'TotalCount'	
		}, ['id_activo_fijo','codigo'])	
	});

    
    
    ds_responsable = new Ext.data.Store({
    	// asigna url de donde se cargaran los datos
    	proxy: new Ext.data.HttpProxy({url:direccion+'../../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php?oc=no'}),
    	reader: new Ext.data.XmlReader({
    		record: 'ROWS',
    		id: 'id_empleado_res',
    		totalRecords: 'TotalCount'
    			
    	}, ['id_empleado_res',
    	    'id_persona',
    	    'apellido_paterno',
    	    'apellido_materno',
    	    'nombre',
    	    'desc_persona',
    	    'ci',
    	    'email'
    	    ])
    });
    
    ds_responsable = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url:direccion+'../../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php?oc=no'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_empleado',
			totalRecords: 'TotalCount'

		}, ['id_empleado',
		    'id_persona',
		    'apellido_paterno',
		    'apellido_materno',
		    'nombre',
		    'desc_persona',
		    'ci',
		    'email'
		    ])
	});
    
    ds_persona = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url:direccion+'../../../../../sis_seguridad/control/persona/ActionListarPersona.php?oc=no'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_persona',
			totalRecords: 'TotalCount'

		}, ['id_persona',
		    'apellido_paterno',
		    'apellido_materno',
		    'nombre',
		    'desc_per'
		    ])
	});
    
    
    vectorAtributos[0]={
			validacion:{
				name:'criterio_reporte',
				fieldLabel:'Buscar por',
				allowBlank:false,
				typeAhead:false,
				loadMask:true,
				triggerAction:'all',
				//store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['0','Activo Fijo'],['1','Responsable'],['2','Custodio'],['3','Reporte General XLS']]}),
				store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['0','Solo Activos del Responsable'],['1','Activos del Responsable/Custodio'],['2','Solo Activos del Custodio']]}),
				onSelect: function(record)
				{	ClaseMadre_getComponente('criterio_reporte').setValue(record.data.id);
				    ClaseMadre_getComponente('criterio_reporte').collapse();
				          
				    	   if(record.data.id == 0){
				    		    CM_mostrarGrupo('Responsable');
			           	    	CM_ocultarGrupo('Responsables');
			           	    	CM_ocultarGrupo('Custodios');
			           	    	NoBlancosGrupo(1);
			           	    	SiBlancosGrupo(2);
			           	    	SiBlancosGrupo(3);
				    	   }
				    	   if(record.data.id == 1){
				    		    CM_mostrarGrupo('Responsables');
			           	    	CM_ocultarGrupo('Responsable');
			           	    	CM_ocultarGrupo('Custodios');
			           	    	NoBlancosGrupo(2);
			           	    	SiBlancosGrupo(1);
			           	    	SiBlancosGrupo(3);
				    	   }
				    	   if(record.data.id == 2){
				    		   CM_mostrarGrupo('Custodios');
				    		   CM_ocultarGrupo('Responsable');
				    		   CM_ocultarGrupo('Responsables');
				    		   NoBlancosGrupo(3);
				    		   SiBlancosGrupo(1);
				    		   SiBlancosGrupo(2);
				    	   }
				    	  
				    	   
				    	   
				},		
				lazyRender:true,
				valueField:'id',
				displayField:'valor',
				grid_visible:true,
				grid_editable:false,
				forceSelection:true,
				width_grid:50,
				width:200
				
			},
			tipo:'ComboBox',
			save_as:'txt_criterio_reporte',
			id_grupo:0
	};
    /*vectorAtributos[1]={
    		validacion:{
    			name:'formato_reporte',
    			fieldLabel:'Formato',
    			allowBlank:false,
    			typeAhead:false,
    			loadMask:true,
    			triggerAction:'all',
    			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['0','PDF'],['1','EXCEL']]}),	
    			valueField:'id',
    			displayField:'valor',    			
    			grid_visible:true,
    			grid_editable:false,
    			forceSelection:true,
    			width_grid:50,
    			width:'50%'
    				
    		},
    		tipo:'ComboBox',
    		save_as:'txt_formato_reporte',
    		id_grupo:0
    };*/
    
    
    vectorAtributos[1] = {
    		validacion:{
    			fieldLabel: 'Responsable',
    			allowBlank: false,
    			vtype:"texto",
    			emptyText:'Responsable...',
    			name: 'id_empleado_res',     //indica la columna del store principal "ds" del que proviane el id
    			desc: 'empleado', //indica la columna del store principal "ds" del que proviane la descripcion
    			store:ds_responsable,
    			valueField: 'id_empleado',
    			displayField: 'desc_persona',
    			queryParam: 'filterValue_0',
    			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre#EMPLEA.codigo_empleado',
    			typeAhead: false,
    			forceSelection : true,
    			mode: 'remote',
    			queryDelay: 50,
    			pageSize: 10,
    			minListWidth : 300,
    			width:200,
    			resizable: true,
    			queryParam: 'filterValue_0',
    			minChars : 0, ///caracteres mínimos requeridos para iniciar la busqueda
    			triggerAction: 'all',
    			grid_editable : false,
    			grid_visible:true, // se muestra en el grid
    			grid_editable:false, //es editable en el grid,
    			width_grid:150
    			
    		},
    		id_grupo:1,
    		tipo: 'ComboBox',
    		save_as:'hidden_id_empleado_res'
		};
    
    
    vectorAtributos[2] = {
    		validacion:{
    			fieldLabel: 'Responsable',
    			allowBlank: false,
    			vtype:"texto",
    			emptyText:'Responsable...',
    			name: 'id_empleado',     //indica la columna del store principal "ds" del que proviane el id
    			desc: 'empleado', //indica la columna del store principal "ds" del que proviane la descripcion
    			store:ds_responsable,
    			valueField: 'id_empleado',
    			displayField: 'desc_persona',
    			queryParam: 'filterValue_0',
    			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre#EMPLEA.codigo_empleado',
    			typeAhead: false,
    			forceSelection : true,
    			mode: 'remote',
    			queryDelay: 50,
    			pageSize: 10,
    			minListWidth : 300,
    			width:200,
    			resizable: true,
    			queryParam: 'filterValue_0',
    			minChars : 0, ///caracteres mínimos requeridos para iniciar la busqueda
    			triggerAction: 'all',
    			grid_editable : false,
    			grid_visible:true, // se muestra en el grid
    			grid_editable:false, //es editable en el grid,
    			width_grid:150
    			
    		},
    		id_grupo:2,
    		tipo: 'ComboBox',
    		save_as:'hidden_id_empleado'
    	};
    vectorAtributos[3] = {
    		validacion:{
    			fieldLabel: 'Personas',
    			allowBlank: false,
    			vtype:"texto",
    			emptyText:'Persona...',
    			name: 'id_persona',     //indica la columna del store principal "ds" del que proviane el id
    			desc: 'desc_per', //indica la columna del store principal "ds" del que proviane la descripcion
    			store:ds_persona,
    			valueField: 'id_persona',
    			displayField: 'desc_per',
    			queryParam: 'filterValue_0',
    			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
    			typeAhead: false,
    			forceSelection : true,
    			mode: 'remote',
    			queryDelay: 50,
    			pageSize: 10,
    			minListWidth : 300,
    			width:200,
    			resizable: true,
    			queryParam: 'filterValue_0',
    			minChars : 0, ///caracteres mínimos requeridos para iniciar la busqueda
    			triggerAction: 'all',
    			grid_editable : false,
    			grid_visible:true, // se muestra en el grid
    			grid_editable:false, //es editable en el grid,
    			width_grid:150
    			
    		},
    		id_grupo:3,
    		tipo: 'ComboBox',
    		save_as:'hidden_id_persona'
    	};
    
    
    
//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////
	//Inicia Layout
	var config={
		titulo_maestro:'Parámetros Activos Fijos Empleado Detalle'
		
	};
	layout_activo_fijo_empleado=new DocsLayoutProceso(idContenedor);
	layout_activo_fijo_empleado.init(config);
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,layout_activo_fijo_empleado,idContenedor);
	
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
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;

	
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////
	
    //////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	
	function obtenerTitulo()
	{		
		var titulo = "Depositos";
		return titulo;
	}
	
	//datos necesarios para el filtro
	var paramFunciones = {
		
		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:'70%',
		url:direccion+'../../../../control/_reportes/activo_fijo_responsable/ActionReporteActivoFijoResponsableCustodio.php',
					
	    abrir_pestana:true, //abrir pestana
		titulo_pestana:obtenerTitulo,
		
		fileUpload:true,
		width:'60%',
		columnas:['350','350'],
		minWidth:150,minHeight:200,	closable:true,titulo:'Reporte Responsable Custodio',
		
		grupos:[
				{
					tituloGrupo:'Criterio de Selección',
					columna:0,
					id_grupo:0
				},{
					tituloGrupo:'Responsable',
					columna:0,
					id_grupo:1
				},{
					tituloGrupo:'Responsables',
					columna:1,
					id_grupo:2
				},{
					tituloGrupo:'Custodios',
					columna:1,
					id_grupo:3
				}
			]}
	};
	
//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	

	//Para manejo de eventos

	function iniciarEventosFormularios(){
		
	    for (var i=0;i<vectorAtributos.length;i++){
			
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name);
		}	
	    
	    CM_ocultarGrupo('Responsable');
		CM_ocultarGrupo('Responsables');	
		CM_ocultarGrupo('Custodios');	

	}
	
	function SiBlancosGrupo(grupo){
		for (var i=0;i<componentes.length;i++){
			if(vectorAtributos[i].id_grupo==grupo)
			componentes[i].allowBlank=true;
		}
		
	}
	function NoBlancosGrupo(grupo){
		for (var i=0;i<componentes.length;i++){
			if(vectorAtributos[i].id_grupo==grupo)
				componentes[i].allowBlank=vectorAtributos[i].validacion.allowBlank;
		}
	}
	
	
	
	
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_rep_asignacion_activo_fijo.getLayout();};
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