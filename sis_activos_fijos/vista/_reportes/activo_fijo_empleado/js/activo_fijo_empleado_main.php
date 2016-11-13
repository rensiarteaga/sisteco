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



var elemento={pagina:new pagina_activo_fijo_empleado(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);


/**
 * Nombre:		  	    GenerarReporteActivoFijoEmpleadoDetalle.js
 * Prop�sito: 			pagina objeto principal
 * Autor:				Silvia Ximena Ortiz Fern�ndez
 * Fecha creaci�n:		07/01/2011
 */
function pagina_activo_fijo_empleado(idContenedor,direccion,paramConfig)
{	var vectorAtributos=new Array;
    var Atributos=new Array;
    var componentes= new Array();
    //var desc_nombrecompleto_empleado='';
    //var nombre_deposito_deposito='';
	//var txt_reporte;
    
    
	var datax;
   //proxy:new Ext.data.HttpProxy({url:direccion+'../../../../../sis_parametros/control/depto/ActionListarDepartamento.php?oc=si'}),
		
	ds_empleado = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url:direccion+'../../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php'}),
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
		proxy: new Ext.data.HttpProxy({url:direccion+'../../../../../sis_seguridad/control/persona/ActionListarPersona.php'}),
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
	
	ds_deposito = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url:direccion+'../../../../../sis_activos_fijos/control/deposito/ActionListarDeposito.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_deposito',
			totalRecords: 'TotalCount'

		}, ['id_deposito',
		    'nombre_deposito',
		    'estado',
		    'id_empleado_responsable',
		    'id_depto_af',
		    'fecha_reg',
		    'desc_persona',
		    'nombre_depto'
		    ])

	});
	
	////////////////FUNCIONES RENDER ////////////
	function render_empleado(value, p, record){return String.format('{0}', record.data['empleado']);}
	function render_deposito(value, p, record){return String.format('{0}', record.data['deposito']);}
	function render_persona(value, p, record){return String.format('{0}', record.data['persona']);}
	// Definici�n de todos los tipos de datos que se maneja    //
	
	
	// Definici�n de datos //
	/////////////////////////
	//en la posici�n 0 siempre esta la llave primaria	
		
	vectorAtributos[0]={
			validacion:{
				name:'sw_activo_clasificacion',
				fieldLabel:'Tipo de Reporte',
				allowBlank:false,
				typeAhead:false,
				loadMask:true,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['0','Empleado'],['1','Deposito'],['2','Asignacion'],['3','Custodia']]}),
				onSelect: function(record)
				{	ClaseMadre_getComponente('sw_activo_clasificacion').setValue(record.data.id);
				    ClaseMadre_getComponente('sw_activo_clasificacion').collapse();
				           //if (record.data.id==1||record.data.id==2){
				           if (record.data.id==0||record.data.id==2||record.data.id==3){
				           	    if (record.data.id==3){
				           	    	CM_mostrarGrupo('Personas');
				           	    	CM_ocultarGrupo('Empleados');
				           	    	NoBlancosGrupo(3);
				           	    	SiBlancosGrupo(1);
				           	    	
				           	    }else{
				           	    	CM_mostrarGrupo('Empleados');
				           	    	CM_ocultarGrupo('Personas');
				           	    	NoBlancosGrupo(1);
				           	    	SiBlancosGrupo(3);
				           	    }
								
								CM_ocultarGrupo('Depositos');
								SiBlancosGrupo(2);
								//NoBlancosGrupo(1);
					
							}else{
								CM_mostrarGrupo('Depositos');
								CM_ocultarGrupo('Empleados');
								CM_ocultarGrupo('Personas');
								SiBlancosGrupo(1);
								NoBlancosGrupo(2);
								SiBlancosGrupo(3);
							}
				},		
				valueField:'id',
				displayField:'valor',
				lazyRender:true,
				grid_visible:true,
				grid_editable:false,
				forceSelection:true,
				width_grid:50,
				width:'50%'
				
			},
			tipo:'ComboBox',
			save_as:'sw_activo_clasificacion',
			id_grupo:0
			};

	vectorAtributos[1] = {
		validacion:{
			fieldLabel: 'Funcionario',
			allowBlank: false,
			vtype:"texto",
			emptyText:'Funcionario...',
			name: 'id_empleado',     //indica la columna del store principal "ds" del que proviane el id
			desc: 'empleado', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_empleado,
			valueField: 'id_empleado',
			displayField: 'desc_persona',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre#EMPLEA.codigo_empleado',
			typeAhead: false,
			forceSelection : true,
			renderer:render_empleado,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			width:200,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 0, ///caracteres m�nimos requeridos para iniciar la busqueda
			triggerAction: 'all',
			grid_editable : false,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:150
			
		},
		id_grupo:1,
		tipo: 'ComboBox',
		save_as:'hidden_id_empleado'
	};

	vectorAtributos[2] = {
			validacion:{
				fieldLabel: 'Deposito',
				allowBlank: false,
				vtype:"texto",
				emptyText:'Deposito...',
				name: 'id_deposito',     //indica la columna del store principal "ds" del que proviane el id
				desc: 'deposito', //indica la columna del store principal "ds" del que proviane la descripcion
				store:ds_deposito,
				valueField: 'id_deposito',
				displayField: 'nombre_deposito',
				queryParam: 'filterValue_0',
				//filterCol:'EMP.id_persona#EMP.codigo_empleado#PER.nombre#PER.apellido_paterno#PER.apellido_materno',
				filterCol:'DEPOSI.nombre_deposito',
				typeAhead: false,
				forceSelection : true,
				renderer:render_deposito,
				mode: 'remote',
				queryDelay: 50,
				pageSize: 10,
				minListWidth : 300,
				width:200,
				resizable: true,
				queryParam: 'filterValue_0',
				minChars : 0, ///caracteres m�nimos requeridos para iniciar la busqueda
				triggerAction: 'all',
				grid_editable : false,
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:150
			},
			id_grupo:2,
			tipo: 'ComboBox',
			save_as:'hidden_id_deposito'
		};
	
	vectorAtributos[3]={
		validacion:{
			labelSeparator:'',
			name:'desc_empleado',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'desc_empleado'
	};
		
		vectorAtributos[4]={
			validacion:{
				labelSeparator:'',
				name:'desc_deposito',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo:'Field',
			filtro_0:false,
			save_as:'desc_deposito'
		};
	vectorAtributos[5] = {
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
			renderer:render_persona,
			mode: 'remote',
			queryDelay: 50,
			pageSize: 10,
			minListWidth : 300,
			width:200,
			resizable: true,
			queryParam: 'filterValue_0',
			minChars : 0, ///caracteres m�nimos requeridos para iniciar la busqueda
			triggerAction: 'all',
			grid_editable : false,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:150
			
		},
		id_grupo:3,
		tipo: 'ComboBox',
		save_as:'id_persona'
	};
	vectorAtributos[6]={
		validacion:{
			labelSeparator:'',
			name:'desc_per',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'desc_per'
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
		titulo_maestro:'Par�metros Activos Fijos Empleado Detalle'
		
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
	// DEFINICI�N DE LA BARRA DE MEN�//
	///////////////////////////////////
	
    //////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICI�N DE FUNCIONES ------------------------- //
	//  aqu� se parametrizan las funciones que se ejecutan en la clase madre    //
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
		url:direccion+'../../../../control/_reportes/activo_fijo_empleado/ActionPDFActivoFijoEmpleado.php',
					
	    abrir_pestana:true, //abrir pestana
		titulo_pestana:obtenerTitulo,
		
		fileUpload:true,
		width:'60%',
		columnas:['47%','47%'],
		minWidth:150,minHeight:200,	closable:true,titulo:'Reporte Empleado Detalle',
		
		grupos:[
				{
					tituloGrupo:'Criterio de Seleccion',
					columna:0,
					id_grupo:0
				},{
					tituloGrupo:'Empleados',
					columna:0,
					id_grupo:1
				},{
					tituloGrupo:'Depositos',
					columna:1,
					id_grupo:2
				},{
					tituloGrupo:'Personas',
					columna:1,
					id_grupo:3
				}
			]}
	};
	
		
		
	//-------------- DEFINICI�N DE FUNCIONES PROPIAS --------------//
	

	//Para manejo de eventos

	function iniciarEventosFormularios(){
		
	    for (var i=0;i<vectorAtributos.length;i++){
			
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name);
		}	
		CM_ocultarGrupo('Depositos');
		CM_ocultarGrupo('Empleados');	
		CM_ocultarGrupo('Personas');	
		
		componentes[1].on('select',onEmpleadoSelect);
		componentes[2].on('select',onDepositoSelect);
		componentes[5].on('select',onPersonaSelect);
	}
	
	function onEmpleadoSelect(com,rec,ind) {
		componentes[3].setValue(rec.data.desc_persona);
			
	};
	function onPersonaSelect(com,rec,ind) {
		componentes[6].setValue(rec.data.desc_per);
			
	};
		
	function onDepositoSelect(com,rec,ind) {
		componentes[4].setValue(rec.data.nombre_deposito);
	};	
		
	
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


	//para que los hijos puedan ajustarse al tama�o
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
			//-------------- FIN DEFINICI�N DE FUNCIONES PROPIAS --------------//
			this.Init(); //iniciamos la clase madre
			//this.InitBarraMenu(paramMenu);
			//InitBarraMenu(array DE PAR�METROS PARA LAS FUNCIONES DE LA CLASE MADRE);
			
			
			this.InitFunciones(paramFunciones);
			//para agregar botones
			
			this.iniciaFormulario();
			iniciarEventosFormularios();
			//layout_almacen.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
			ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
