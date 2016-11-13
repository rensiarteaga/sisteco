//<script>


function main(){
	 <?php
	//obtenemos la ruta absoluta
	$host   = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir  = "http://$host$uri/";
	echo "\nvar direccion =\"$dir\";";
	echo "var idContenedor ='$idContenedor';";
	?>

	
	
var paramConfig ={TamanoPagina:20,TiempoEspera:10000};


var configConsolidacion ={sw_vista:'<?php echo utf8_decode($sw_vista);?>'};

var elemento ={pagina:new EstadisticasSistema(idContenedor,direccion,paramConfig,configConsolidacion),idContenedor:idContenedor};

ContenedorPrincipal.setPagina(elemento);

}
Ext.onReady(main,main);

function EstadisticasSistema(idContenedor,direccion,paramConfig,configConsolidacion)
{
	var vectorAtributos=new Array();
	/*var parametro;
	var gestion;
	var periodo;*/
	var componentes=new Array();
		
	//DATA STORE 		
 		var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_parametros/control/gestion/ActionListarGestion.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_gestion',totalRecords: 'TotalCount'},['id_gestion','gestion'])
			});	
		
		function render_id_gestion(value,cell,record,row,colum,store){return String.format('{0}', record.data['gestion']);}
		var tpl_id_gestion=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','</div>');
		
		
		var ds_usuario=new Ext.data.Store({
				proxy:new Ext.data.HttpProxy({url:direccion+'../../../../../sis_seguridad/control/usuario/ActionListarUsuario.php?oc=si'}),
				reader:new Ext.data.XmlReader({record:'ROWS',id:'id_usuario',totalRecords:'TotalCount'},['id_usuario','desc_persona'])
				});
		var resultTplUsuario=new Ext.Template('<div class="search-item">','<b><i>{desc_persona}</i></b>','</div>');
		
		
		var ds_subsistema=new Ext.data.Store({
				proxy:new Ext.data.HttpProxy({url:direccion+'../../../../../sis_seguridad/control/subsistema/ActionListarSubsistema.php?oc=si'}),
				reader:new Ext.data.XmlReader({record:'ROWS',id:'id_usuario',totalRecords:'TotalCount'},['id_subsistema','nombre_largo'])
				});
		var resultTplSubsistema=new Ext.Template('<div class="search-item">','<b><i>{nombre_largo}</i></b>','</div>');
		
						
		
				
	vectorAtributos[0]={
		validacion:{
			name:'gestion',
			fieldLabel:'Gestión',
			allowBlank:false,			
			//emptyText:'Gestion...',
			desc: 'gestion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_gestion,
			valueField: 'gestion',
			displayField: 'gestion',
			queryParam: 'filterValue_0',
			filterCol:'GESTIO.gestion',
			typeAhead:true,
			tpl:tpl_id_gestion,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'50%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_gestion,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:250,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'GESTIO.gestion',
		save_as:'gestion'
	}; 
	
	
	vectorAtributos[1]={
		validacion:{
			fieldLabel:'Usuario',
			allowBlank:false,
			vtype:"texto",
			//emptyText:'Usuario...',
			name:'id_usuario',
			desc:'desc_persona',
			store:ds_usuario,
			valueField:'id_usuario',
			displayField:'desc_persona',
			queryParam:'filterValue_0',
			filterCol :'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			typeAhead:false,
			forceSelection:true,
			tpl:resultTplUsuario,
			mode:'remote',
			queryDelay:50,
			pageSize:20,
			minListWidth:300,
			width:250,
			resizable:true,
			minChars:0,
			triggerAction:'all',
			editable:true
		},
		id_grupo:0,
		save_as:'id_usuario',
		tipo:'ComboBox'
	};
	
	vectorAtributos[2]={
		validacion:{
			fieldLabel:'Subsistema',
			allowBlank:false,
			vtype:"texto",
			//emptyText:'Subsistema...',
			name:'id_subsistema',
			desc:'nombre_largo',
			store:ds_subsistema,
			valueField:'id_subsistema',
			displayField:'nombre_largo',
			queryParam:'filterValue_0',
			filterCol :'SUBSIS.nombre_largo',
			typeAhead:false,
			forceSelection:true,
			tpl:resultTplSubsistema,
			mode:'remote',
			queryDelay:50,
			pageSize:20,
			minListWidth:300,
			width:250,
			resizable:true,
			minChars:0,
			triggerAction:'all',
			editable:true
		},
		id_grupo:0,
		save_as:'id_subsistema',
		tipo:'ComboBox'
	};
	
	vectorAtributos[3]={
		validacion:{
			fieldLabel:'Usuario',
			allowBlank:false,
			vtype:"texto",
			//emptyText:'Usuario...',
			name:'usuario'						
		},
		id_grupo:0,		
		save_as:'usuario',
		tipo:'TextField'
	};
	
	
	
	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////

	function formatDate(value){	return value ? value.dateFormat('d/m/Y'):''}
	
	// ---------- Inicia Layout ---------------//
	var config=
	{
		titulo_maestro:"Estadisticas Sistema"
	};
	layout_estadisticas_sistema=new DocsLayoutProceso(idContenedor);
	layout_estadisticas_sistema.init(config);

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS HERENCIA           -----------//
	//////////////////////////////////////////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,layout_estadisticas_sistema,idContenedor);

	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//

	var ClaseMadre_conexionFailure = this.conexionFailure; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_getComponente = this.getComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_ocultarGrupo=this.ocultarGrupo;

	//ds_parametro.addListener('loadexception',  ClaseMadre_conexionFailure); //se recibe un error	
	
	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	var paramFunciones={
		Formulario:{labelWidth:75,
		            url:direccion+'../../../../../sis_presupuesto/control/_reportes/estadisticas/ActionListarEstadisticasSistema.php',
		            abrir_pestana:true,
		            titulo_pestana:'Estadisticas de transacciones por sistema',
		            fileUpload:false,
		            columnas:[420,420],
			        grupos:[{tituloGrupo:'Datos para el reporte Estadisticas por Sistema',
			        		 columna:0,
			        		 id_grupo:0
			        		}],
			        parametros:''}
	};
	
	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	function iniciarEventosFormularios()
	{
		for(var i=0; i<vectorAtributos.length; i++)
		{
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}
		CM_ocultarComponente(componentes[3]);
		componentes[1].on('select',evento_usuario);		
	}
	
	function evento_usuario( combo, record, index )
	{		
		componentes[3].setValue(record.data.desc_persona);
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
