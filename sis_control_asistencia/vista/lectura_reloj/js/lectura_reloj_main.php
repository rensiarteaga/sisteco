<?php 
session_start();
?>
//<script>
var paginaLecturaReloj;

function main(){
	 <?php
	//obtenemos la ruta absoluta
	$host  = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir = "http://$host$uri/";
	echo "\nvar direccion=\"$dir\";";
	echo "var idContenedor='$idContenedor';";
	?>

var paramConfig={TamanoPagina:24,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:<?php echo $_SESSION["ss_filtro_avanzado"];?>};



var elemento={pagina:new PaginaLecturaReloj(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);
function PaginaLecturaReloj(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	var ds,ds_empleado;
	var fecha;
	var combo_empleado;
	var combo_observaciones;
	var combo_tipo_movimiento;
	var combo_turno;
	var h_txt_hora;
	var h_txt_fecha;
	//////////////////////////////
	//							//
	//  DATA STORE      		//
	//							//
	//////////////////////////////
	ds=new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/lectura_reloj/ActionListarLecturaReloj.php'}),
		// aqui se define la estructura del XML
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_lectura_reloj',
			totalRecords:'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
		{name:'descripcion', type:'string'},
		'id_lectura_reloj',
		'codigo_empleado',
		{name:'fecha', type:'date', dateFormat:'Y-m-d'},
		'hora',
		'tipo_movimiento',
		'observaciones',
		'turno'
		]),
		remoteSort:true // metodo de ordenacion remoto
	});
	//carga los datos desde el archivo XML declaraqdo en el Data Store
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
			}
	});
/////DATA STORE COMBOS////////////
	ds_empleado=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url: direccion+'../../../control/lectura_reloj/ActionListarDistintoLecturaReloj.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			totalRecords:'TotalCount'
		}, ['codigo_empleado'])
	});
	function renderEmpleado(value, p, record){return String.format('{0}', record.data['codigo_empleado']);}
	//////////////////////////////////////////////////////////////
	// ------------------  PARÁMETROS --------------------------//
	// Definición de todos los tipos de datos que se maneja    //
	//////////////////////////////////////////////////////////////
    /////////// hidden id_lectura_reloj //////
	//en la posición 0 siempre tiene que estar la llave primaria
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_lectura_reloj',
			inputType:'hidden',
			grid_visible:false, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			width_grid:40 // ancho de columna en el grid
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_lectura_reloj'
	}
	///////// txt codigo_empleado//////
	vectorAtributos[1]={
		validacion:{
			fieldLabel:'Funcionario',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Empleado...',
			name:'codigo_empleado',     //indica la columna del store principal "ds" del que proviane el id
			desc:'codigo_empleado', //indica la columna del store principal "ds" del que proviane la descripcion
			store:ds_empleado,
			valueField:'codigo_empleado',
			displayField:'codigo_empleado',
			queryParam:'filterValue_0',
			filterCol:'codigo_empleado',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:renderEmpleado,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:135,  // ancho de columna en el gris
			grid_indice:0
		},
		tipo: 'ComboBox',
		filtro_0:true,
		save_as:'txt_codigo_empleado'
	}
	///////// fecha /////////
	vectorAtributos[2]={
		validacion:{
			name:'fecha',
			fieldLabel:'Fecha',
			allowBlank:true,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:true,// se muestra en el grid
			grid_editable:false,//es editable en el grid,
			renderer:formatDate,
			width_grid:120,// ancho de columna en el grid
			disabled:false,
			grid_indice:1
		},
		tipo:'DateField',
		filtro_0:true,
		save_as:'txt_fecha',
		dateFormat:'m-d-Y', //formato de fecha que envía para guardar
		defecto:"" // valor por default para este campo
	};
   /////////// txt observaciones //////
	vectorAtributos[3]={
		validacion:{
			name: 'observaciones',
			fieldLabel: 'Observaciones',
			typeAhead:true,
			loadMask:true,
			allowBlank:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({
				fields:['ID', 'nombre'],
				data: [
				        ['Vacacion', 'Vacacion'],
				        ['Comision de Viaje', 'Comision de Viaje'],
					    ['Comision Sindical', 'Comision Sindical'],
					    ['Baja Medica', 'Baja Medica'],
					    ['Capacitacion', 'Capacitacion'],
				        ['Otro', 'Otro'],
				        ['Ninguna', 'Ninguna']                        
				    ] // from states.js
			}),
			valueField:'ID',
			displayField:'nombre',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:150, // ancho de columna en el grid
			grid_indice:4 
		},
		tipo: 'ComboBox',//cambiar por TextArea(pero es muy grande...)
		filtro_0:true,
		filterColValue:'observaciones',
		save_as:'txt_observaciones',
		defecto:""
	}
	/////////// txt turno //////
	vectorAtributos[4]={
		validacion:{
			name: 'turno',
			fieldLabel: 'Turno',
			typeAhead: true,
			loadMask: true,
			allowBlank: true,
			triggerAction: 'all',
			disabled: true,
			store: new Ext.data.SimpleStore({
				fields: ['ID', 'nombre'],
				data : [
				        ['Mañana', 'Mañana'],
				        ['Tarde', 'Tarde'],
				        ['Jornada Completa', 'Jornada Completa']                
				    ] // from states.js
			}),
			valueField:'ID',
			displayField:'nombre',
			lazyRender:true,
			forceSelection:true,
			grid_visible:false, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:150, // ancho de columna en el grid
			grid_indice:5
		},
		tipo: 'ComboBox',//cambiar por TextArea(pero es muy grande...)
		filtro_0:false,
		filterColValue:'turno',
		save_as:'txt_turno',
		defecto:""
	}
	/////////// txt hora //////
	vectorAtributos[5]={
		validacion:{
			name: 'hora',
			fieldLabel: 'Hora',
			emptyText:'Hora...',
			allowBlank: true,
			maxLength:15,
			minLength:2,
			selectOnFocus:true,
			disabled: false,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid,
			width_grid:120, // ancho de columna en el gris
			grid_indice:2 
		},
		tipo: 'TextField',//cambiar por TextArea(pero es muy grande...)
		filtro_0:true,
		save_as:'txt_hora',
		defecto:""
	}
   ///////// txt tipo_movimiento //////
	vectorAtributos[6]={
		validacion:{
			name: 'tipo_movimiento',
			fieldLabel: 'Tipo Movimiento',
			typeAhead: true,
			emptyText:'Movimiento...',
			loadMask: true,
			allowBlank: true,
			disabled: false,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID', 'nombre'],
				data :[
				        ['Entrada', 'Entrada'],
				        ['Salida', 'Salida']        
				    ] // from states.js
			}),
			valueField:'ID',
			displayField:'nombre',
			lazyRender:true,
			//forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:120, // ancho de columna en el grid
			grid_indice:3
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'tipo_movimiento',
		save_as:'txt_tipo_movimiento',
		defecto:""
	}
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};
	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////
	// ---------- Inicia Layout ---------------//
	var config = {
		titulo_maestro:"Depuración de Registros de Marcas",
		grid_maestro:"grid-"+idContenedor
	};
	layout_lectura_reloj = new DocsLayoutMaestro(idContenedor);
	layout_lectura_reloj.init(config);
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_lectura_reloj,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	//////////////////////////////////////////////////////////////
	// -----------   DEFINICIÓN DE LA BARRA DE MENÚ ----------- //
	//////////////////////////////////////////////////////////////
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	//datos necesarios para el filtro
	parametrosFiltro = "&filterValue_0="+ds.lastOptions.params.filterValue_0+"&filterCol_0="+ds.lastOptions.params.filterCol_0;

	var paramFunciones = {
		btnEliminar:{
			url:direccion+"../../../control/lectura_reloj/ActionEliminarLecturaReloj.php"
		},
		Save:{
			url:direccion+"../../../control/lectura_reloj/ActionGuardarLecturaReloj.php"
		},
		ConfirmSave:{
			url:direccion+"../../../control/lectura_reloj/ActionGuardarLecturaReloj.php"
		},
		
	Formulario:{
			html_apply:"dlgInfo"+idContenedor,
			width:485,
			height:295,
			minWidth:150,
			minHeight:200,
			fileUpload:true,
			labelWidth: 78, 
			closable:true
						
		}
	};
	function get_fecha_bd()
	{
	  var postData;
	  	Ext.Ajax.request({
					url:'../../../lib/lib_control/action/ActionObtenerFechaBD.php',
					params:postData,
					method:'POST',
					success:cargar_fecha_bd,
					failure: ClaseMadre_conexionFailure,
					timeout:paramConfig.TiempoEspera
				});		
	}
	//Carga la fecha obtenida
	function cargar_fecha_bd(resp){
		if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
			var root = resp.responseXML.documentElement;
			if(h_txt_fecha.getValue()==""){
				h_txt_fecha.setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue)
			}
		}
	}
	//sobrecarga
this.btnNew=function(){
		h_txt_hora.enable();
		combo_empleado.enable();
		combo_tipo_movimiento.enable();
		combo_turno.disable();
		ClaseMadre_btnNew()
	}
this.btnEdit=function(){
		combo_empleado.disable();
		h_txt_hora.enable();
		combo_tipo_movimiento.enable();
		combo_turno.disable();
		ClaseMadre_btnEdit();
	}
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios()
	{
		combo_empleado=ClaseMadre_getComponente('codigo_empleado');
		combo_observaciones=ClaseMadre_getComponente('observaciones');
		combo_tipo_movimiento=ClaseMadre_getComponente('tipo_movimiento');
		combo_turno=ClaseMadre_getComponente('turno');
		h_txt_hora=ClaseMadre_getComponente('hora');
		h_txt_fecha=ClaseMadre_getComponente('fecha');		
		function opcion_obs()
		{
			if(combo_observaciones.getValue()=='Vacacion' || combo_observaciones.getValue()=='Comision de Viaje' || combo_observaciones.getValue()=='Comision Sindical' || combo_observaciones.getValue()=='Baja Medica' || combo_observaciones.getValue()=='Capacitacion' || combo_observaciones.getValue()=='Otro')
			{
				combo_tipo_movimiento.allowBlank=true;
				combo_tipo_movimiento.disable();
				combo_turno.enable();
				h_txt_hora.allowBlank=true;
				h_txt_hora.disable();
			}
			else 
			{
			if (combo_observaciones.getValue()=='Ninguna')
			{
				combo_tipo_movimiento.allowBlank=false;////true
				combo_tipo_movimiento.enable();
				combo_tipo_movimiento.setValue('');
				combo_observaciones.setValue('');
				combo_turno.disable();
				h_txt_hora.allowBlank=false;////true
				h_txt_hora.enable();
				h_txt_hora.setValue('');

			}
			}
		}
		//Define los eventos de los componentes para ejecutar acciones
		combo_observaciones.on('change',opcion_obs);
		combo_observaciones.on('select',opcion_obs);
	}
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	iniciarEventosFormularios()
	layout_lectura_reloj.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}