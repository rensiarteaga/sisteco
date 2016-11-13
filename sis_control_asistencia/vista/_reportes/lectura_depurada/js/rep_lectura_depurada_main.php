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
var elemento={pagina:new GenerarReporteLecturaDepurada(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);
function GenerarReporteLecturaDepurada(idContenedor,direccion,paramConfig)
{

	var vectorAtributos = new Array;
	var ContPes = 1;
    var ds_empleado;
    var h_txt_fecha_ini;
	var	h_txt_fecha_fin;
	var txt_nombre_completo,txt_id_empleado, txt_codigo,txt_button,combo_empleado,txt_rol;
	 
	//////////////////////////////////////////////////////////////
	// ------------------  PARÁMETROS --------------------------//
	// Definición de todos los tipos de datos que se maneja    //
	//////////////////////////////////////////////////////////////

	/////////// hidden id_tipo_activo//////
	//en la posición 0 siempre tiene que estar la llave primaria
	/////DATA STORE////////////
	ds_empleado=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../../sis_kardex_personal/control/empleado/ActionListarFuncionario.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords:'TotalCount'},['id_empleado','id_persona','desc_persona'])
	});
	//Define las columnas a desplegar
	/////////// txt codigo//////
    /*var filterCols_funcionario=new Array();
	var filterValues_funcionario=new Array();
	filterCols_funcionario[0]='EMPEXT.id_gerencia';
	filterValues_funcionario[0]='%';*/
	vectorAtributos[0]={
		validacion:{
			fieldLabel:'Funcionario',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Funcionario...',
			name:'id_empleado',
			desc:'desc_persona',
			store:ds_empleado,
			valueField:'id_empleado',
			displayField:'desc_persona',
			queryParam:'filterValue_0',
			filterCol:'FUNCIO.desc_persona',
			/*filterCols:filterCols_funcionario,
			filterValues:filterValues_funcionario,*/
			typeAhead:false,
			forceSelection:true,
			//tpl:resultTplEmp,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			minChars:0,
			triggerAction:'all',
			editable:true
		},
		id_grupo:2,
		save_as:'txt_id_empleado',
		tipo:'ComboBox'
	};

///////// fecha_ini /////////
	var paramFechaIni = {
		validacion:{
			name:'fecha_ini',
			fieldLabel:'Fecha',
			allowBlank:false,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			//disabledDays:[0, 6],
			disabledDaysText:'Día no válido',
			grid_visible:true,// se muestra en el grid
			grid_editable:false,//es editable en el grid,
			renderer:formatDate,
			width_grid:120,// ancho de columna en el grid
			disabled:false
		},
		id_grupo:0,
		tipo:'DateField',
		save_as:'txt_fecha_ini',
		dateFormat:'m/d/Y', //formato de fecha que envía para guardar
		defecto:"" // valor por default para este campo
	};
	vectorAtributos[1] = paramFechaIni;
	///////// fecha /////////
	var paramFechaFin = {
		validacion:{
			name:'fecha_fin',
			fieldLabel:'Fecha',
			allowBlank:false,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			//disabledDays:[0, 6],
			disabledDaysText:'Día no válido',
			grid_visible:true,// se muestra en el grid
			grid_editable:false,//es editable en el grid,
			renderer:formatDate,
			width_grid:120,// ancho de columna en el grid
			disabled:false
		},
		id_grupo:1,
		tipo:'DateField',
		save_as:'txt_fecha_fin',
		dateFormat:'m/d/Y', //formato de fecha que envía para guardar
		defecto:"" // valor por default para este campo
	};
	vectorAtributos[2] = paramFechaFin;
	
		/////////////////////////////////////////////////////////////
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
		titulo_maestro:"Marcas Depuradas"
	};
	layout_rep_lectura_depurada=new DocsLayoutProceso(idContenedor);
	layout_rep_lectura_depurada.init(config);

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS HERENCIA           -----------//
	//////////////////////////////////////////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
    this.pagina(paramConfig,vectorAtributos,layout_rep_lectura_depurada,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//


	var ClaseMadre_conexionFailure = this.conexionFailure; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_getComponente = this.getComponente;


	ds_empleado.addListener('loadexception',  ClaseMadre_conexionFailure); //se recibe un error
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	function iniciarEventosFormularios()
	{
		h_txt_fecha_ini = ClaseMadre_getComponente('fecha_ini');
		h_txt_fecha_fin = ClaseMadre_getComponente('fecha_fin');
		combo_empleado=ClaseMadre_getComponente('id_empleado');
		var $mes = new Date();
		$mes = $mes.getMonth();
		$mes=$mes+1;
		var $primera_fecha = new Date();
		$primera_fecha ='01/0'+$mes+'/'+$primera_fecha.getFullYear();
		h_txt_fecha_ini.setValue($primera_fecha);
		var $fecha_actual = new Date();
		$fecha_actual =$fecha_actual.getDate()+'/0'+$mes+'/'+$fecha_actual.getFullYear();
		h_txt_fecha_fin.setValue($fecha_actual);


	}
function eventosAjax(){
		Ext.lib.Ajax.request('POST','../../../sis_telefonico/control/_reportes/llamadas_gerencia/ActionGerenciaFuncionario.php',
		                     {success:gerencia_dep,failure:this.conexionFailure})
	}
	var InitFunciones=this.InitFunciones;
    //Se agrega el botón para la generación del reporte
	var iniciaFormulario=this.iniciaFormulario;
	//------  sobrecargo la clase madre obtenerTitulo  para las pestanas-----------------//
	function obtenerTitulo()
	{
		//var combo_financiador = ClaseMadre_getComponente('id_financiador');
		var titulo = "Marcas Depuradas "+ ContPes;
		ContPes ++;
		return titulo;
	}


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	function gerencia_dep(resp){
		var regreso=Ext.util.JSON.decode(resp.responseText);
		txt_nombre_completo=regreso.nombre_completo;
		txt_id_empleado=regreso.id_empleado;
		txt_rol=regreso.rol;
		var paramFunciones={
 		    Formulario:{
			labelWidth: 75, //ancho del label
			url:direccion+'../../../../../sis_control_asistencia/control/_reportes/lectura_depurada/LecturaDepurada.php',
			abrir_pestana:true, //abrir pestana
			titulo_pestana:obtenerTitulo,
			fileUpload:false,
			columnas:[320,280],
			grupos:[
			{
				tituloGrupo:'Fecha Inicio',
				columna:0,
				id_grupo:0
			},
			{
				tituloGrupo:'Fecha Fin',
				columna:0,
				id_grupo:1
			},
			{
				tituloGrupo:'Funcionario',
				columna:1,
				id_grupo:2
			}],
			parametros: ''
		}
	};
		InitFunciones(paramFunciones);
		iniciaFormulario();
		iniciarEventosFormularios();
		/*if(txt_codigo=='null'){
			Ext.Msg.show({
			title:'Estado',
			msg:'El Usuario no pertenece a ninguna Gerencia.',
			minWidth:300,
			maxWidth :800,
			buttons: Ext.Msg.OK
		})
		 txt_button=ClaseMadre_getForm();
		 txt_button.buttons[0].disable()
		}*/
		/*if(txt_codigo=='GGN' || txt_codigo=='GTI' || txt_rol==1){
			
			combo_empleado.enable()
		}
		else{
			
			combo_empleado.modificado=true
		}*/
		if(txt_rol==1){
			combo_empleado.setValue('');
			combo_empleado.enable();
		}
		else{
			combo_empleado.setValue(txt_id_empleado);
			combo_empleado.setRawValue(txt_nombre_completo);
			combo_empleado.modificado=true;
			combo_empleado.disable();
		}
		
	}
	


//InitBarraMenu(array BOTONES DISPONIBLES);
	this.Init(); //iniciamos la clase madre
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	eventosAjax();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}