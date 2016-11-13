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
function CargaArchivo(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
	var ContPes=1;
	var layout_carga_archivo,carga_archivo;
  //// Archivo /////////
	vectorAtributos[0]={
		validacion:{
			name:'archivo',
			fieldLabel:'Archivo',
			allowBlank:false,
			inputType:'file'		
		},
		id_grupo:0,
		tipo:'Field',
		save_as:'txt_archivo'	
	};
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	var config={titulo_maestro:"Carga de Archivo"};
	layout_carga_archivo=new DocsLayoutProceso(idContenedor);
	layout_carga_archivo.init(config);
	//---------         INICIAMOS HERENCIA           -----------//
	this.pagina=BaseParametrosReporte;
    this.pagina(paramConfig,vectorAtributos,layout_carga_archivo,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_getComponente=this.getComponente;
	//------  sobrecargo la clase madre obtenerTitulo  para las pestanas-----------------//
	function obtenerTitulo(){
		var titulo="Carga de Archivos "+ContPes;
		ContPes ++;
		return titulo
	}	
	function retorno(){
		Ext.MessageBox.hide();
		carga_archivo=ClaseMadre_getComponente('archivo');
		carga_archivo.reset();
		Ext.Msg.show({
			title:'Estado',
			msg:'Proceso ejecutado satisfactoriamente.',
			minWidth:300,
			maxWidth :800,
			buttons: Ext.Msg.OK
		})
	}
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	var paramFunciones={
		Formulario:{labelWidth:75,
		url:direccion+'../../../../sis_telefonico/control/carga_archivo/ActionGuardarArchivo.php',
		abrir_pestana:false,
		titulo_pestana:obtenerTitulo,
		argument:'',
		fileUpload:true,
		success:retorno,
		columnas:[320,280],
		grupos:[{tituloGrupo:'Carga de Archivo',columna:0,id_grupo:0}],parametros:''}
	};
	this.Init();
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}