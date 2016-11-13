<?php 
/**
 * Nombre:		  	    solicitud_compra_personal_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-09 09:11:12
 *
 */
session_start();
?>
//<script>
var paginaTipoActivo;
function main(){
 	<?php
	//obtenemos la ruta absoluta
	$host  = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir = "http://$host$uri/";
	echo "\nvar direccion='$dir';";
    echo "var idContenedor='$idContenedor';";
    echo "id_usuario='$id_usuario';";
	?>
var fa=false;
<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>
var paramConfig={TamanoPagina:ContenedorPrincipal.getConfig().ss_tam_pag,TiempoEspera:ContenedorPrincipal.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var empleado={
	    	id_empleado:<?php echo $id_empleado;?>, rol_adm:'<?php echo $rol_adm;?>',nombre_usuario:'<?php echo $nombre_usuario;?>'}
var elemento={pagina:new pagina_asistencia_sup(idContenedor,direccion,empleado,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);


}
Ext.onReady(main,main);
function pagina_asistencia_sup(idContenedor,direccion,empleado,paramConfig)
{
	var vectorAtributos = new Array;
	var ContPes = 1;
	var cmp_fecha_ini;
	var	cmp_fecha_fin;
	 var cmp_tipo_reporte,cmp_id_empleado,cmp_nombre_usuario;
	 var layout_rep_asistencia;
	//////////////////////////////////////////////////////////////
	// ------------------  PARÁMETROS --------------------------//
	// Definición de todos los tipos de datos que se maneja    //
	//////////////////////////////////////////////////////////////

	/////////// hidden id_tipo_activo//////
	//en la posición 0 siempre tiene que estar la llave primaria
	/////DATA STORE////////////
	//Define las columnas a desplegar
	/////////// txt codigo//////
	var ds_empleado=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../../sis_kardex_personal/control/empleado/ActionListarFuncionario.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords:'TotalCount'},['id_empleado','desc_persona','nombre_cargo'])
	});
	var tpl_empleado=new Ext.Template('<div class="search-item">','{desc_persona}</b>','</div>');
	vectorAtributos[0]={
		validacion:{
			name:'tipo_reporte',
			fieldLabel:'Tipo Reporte',
			vtype:'texto',
			emptyText:'Elija el Tipo de Reporte...',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['dispositivo','Marcas en Dispositivo'],['depurada','Marcas Depuradas']]}),
			valueField:'ID',
			displayField:'valor',
			forceSelection:true,
			width:200
		},
		tipo:'ComboBox',
		id_grupo:0,
		//defecto:'PDF',
		save_as:'txt_tipo_reporte'
	};
///////// fecha_ini /////////
	 vectorAtributos[1] = {
		validacion:{
			name:'fecha_ini',
			fieldLabel:'Fecha Inicio',
			allowBlank:false,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/2000',
			disabledDaysText:'Día no válido',
			grid_visible:true,// se muestra en el grid
			grid_editable:false,//es editable en el grid,
			renderer:formatDate,
			width_grid:120,// ancho de columna en el grid
			disabled:false
		},
		id_grupo:1,
		tipo:'DateField',
		save_as:'txt_fecha_ini',
		dateFormat:'m/d/Y', //formato de fecha que envía para guardar
		defecto:"" // valor por default para este campo
	};
	///////// fecha /////////
	vectorAtributos[2] = {
		validacion:{
			name:'fecha_fin',
			fieldLabel:'Fecha Fin',
			allowBlank:false,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/2000',
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
	
		vectorAtributos[3]={
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
			typeAhead:false,
			forceSelection:true,
			tpl:tpl_empleado,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			minChars:0,
			triggerAction:'all',
			editable:true,
			width:300
		},
		id_grupo:2,
		save_as:'txt_id_empleado',
		tipo:'ComboBox'
	}
	
	
 
	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////

	function formatDate(value){	return value ? value.dateFormat('d/m/Y'):''}
	
	// ---------- Inicia Layout ---------------//
	var config=
	{
		titulo_maestro:"Resumen de Asistencia"
	};
	layout_rep_asistencia=new DocsLayoutProceso(idContenedor);
	layout_rep_asistencia.init(config);

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS HERENCIA           -----------//
	//////////////////////////////////////////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,layout_rep_asistencia,idContenedor);

	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//

	var ClaseMadre_conexionFailure = this.conexionFailure; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_getComponente = this.getComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;

	//ds_parametro.addListener('loadexception',  ClaseMadre_conexionFailure); //se recibe un error	
	
	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	var paramFunciones = {

		Formulario:{
			labelWidth: 75, //ancho del label
		 	url:direccion+'../../../../control/_reportes/seguimiento/asistencia.php',
			abrir_pestana:true, //abrir pestana
			titulo_pestana:'Resumen Asistencia',
			fileUpload:false,
			columnas:['40%','40%'],			
			grupos:[
			{
				tituloGrupo:'Elija el Tipo de Reporte',
				columna:0,
				id_grupo:0
			},
			
			{
				tituloGrupo:'Rango de Fechas',
				columna:0,
				id_grupo:1
			},
			{
				tituloGrupo:'Funcionario',
				columna:1,
				id_grupo:2
			}
			],
			parametros:'',
			
		}
	}

	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	function iniciarEventosFormularios(){			
		cmp_tipo_reporte = ClaseMadre_getComponente('tipo_reporte');	 	 			
		cmp_fecha_ini = ClaseMadre_getComponente('fecha_ini');
		cmp_fecha_fin = ClaseMadre_getComponente('fecha_fin');
		cmp_id_empleado = ClaseMadre_getComponente('id_empleado');
		
		
		var $mes = new Date();
		$mes = $mes.getMonth();
		$mes=$mes+1;
		var $primera_fecha = new Date();
		$primera_fecha ='01/0'+$mes+'/'+$primera_fecha.getFullYear();
		cmp_fecha_ini.setValue($primera_fecha);
		var $fecha_actual = new Date();
		$fecha_actual =$fecha_actual.getDate()+'/0'+$mes+'/'+$fecha_actual.getFullYear();
		cmp_fecha_fin.setValue($fecha_actual);
		
		
	}

	//InitBarraMenu(array BOTONES DISPONIBLES);
	this.Init(); //iniciamos la clase madre
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
    //Se agrega el botón para la generación del reporte
	this.iniciaFormulario();
	iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
