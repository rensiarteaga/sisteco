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
var elemento={pagina:new CargaArchivo(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

function CargaArchivo(idContenedor,direccion,paramConfig)
{var vectorAtributos = new Array;
	var ContPes = 1;
    //////////////////////////////////////////////////////////////
	// ------------------  PARÁMETROS --------------------------//
	// Definición de todos los tipos de datos que se maneja    //
	//////////////////////////////////////////////////////////////	 
///////// Archivo /////////
	var paramarchivo={
		validacion:{
			name:'txt_archivo',
			fieldLabel:'Archivo',
			allowBlank:false,
			inputType:'file'		
		},
		id_grupo:0,
		tipo:'Field',
		save_as:'txt_archivo'	
	};
	vectorAtributos[0]=paramarchivo;
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
	var config={
		titulo_maestro:"Lectura de Marcas"
	};
	layout_rep_carga=new DocsLayoutProceso(idContenedor);
	layout_rep_carga.init(config);
	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS HERENCIA           -----------//
	//////////////////////////////////////////////////////////////
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
    this.pagina(paramConfig,vectorAtributos,layout_rep_carga,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var ClaseMadre_conexionFailure = this.conexionFailure; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_getComponente = this.getComponente;
	//------  sobrecargo la clase madre obtenerTitulo  para las pestanas-----------------//
	function obtenerTitulo()
	{
		//var combo_financiador = ClaseMadre_getComponente('id_financiador');
		var titulo="Lectura de Marcas "+ContPes;
		ContPes ++;
		return titulo;
	}	
	function retorno(resp){
		console.log('dddddddddddddddd',resp)
		Ext.MessageBox.hide();//ocultamos el loading
		//var ParamVentana={Ventana:{width:'90%',height:'70%'}}
		//layout_rep_carga.loadWindows(direccion+'../../../vista/lectura_depurada/lectura_depurada.php',"Depuración de Marcas",ParamVentana)	
		Ext.MessageBox.alert('Estado','Los registros se cargaron satisfactoriamente');	
	}
	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	var paramFunciones={
		Formulario:{
			labelWidth:75, //ancho del label
			url:direccion+'../../../../sis_control_asistencia/control/carga/ActionSubirCsvArchivo.php',
			abrir_pestana:false, //abrir pestana
			titulo_pestana:obtenerTitulo,
			argument:'',
			//navegador_pestana:false,
			fileUpload:true,
		//	success:retorno,
			columnas:[320,280],
			grupos:[
			{
				tituloGrupo:'Lectura de Marcas',
				columna:0,
				id_grupo:0
			}
			],
			parametros:''
		}
	}
//InitBarraMenu(array BOTONES DISPONIBLES);
	this.Init(); //iniciamos la clase madre
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
    //Se agrega el botón para la generación del reporte
	this.iniciaFormulario();
	//iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
