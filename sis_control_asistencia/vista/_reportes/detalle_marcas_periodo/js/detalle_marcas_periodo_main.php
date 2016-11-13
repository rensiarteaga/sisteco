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
var elemento={pagina:new GenerarDetalleMarcasPeriodo(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);
function GenerarDetalleMarcasPeriodo(idContenedor,direccion,paramConfig)
{

	var vectorAtributos = new Array;
	var ContPes = 1;
	var ds_empleado;
	var h_txt_fecha_ini;
	var	h_txt_fecha_fin;
	 var txt_id_gerencia,txt_nombre,txt_descripcion_gerencia,txt_codigo,txt_button,combo_empleado,txt_rol;
	 var  t_gestion, t_periodo;
	//////////////////////////////////////////////////////////////
	// ------------------  PARÁMETROS --------------------------//
	// Definición de todos los tipos de datos que se maneja    //
	//////////////////////////////////////////////////////////////

	/////////// hidden id_tipo_activo//////
	//en la posición 0 siempre tiene que estar la llave primaria
	/////DATA STORE////////////


	 var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_parametros/control/gestion/ActionListarGestion.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_gestion',totalRecords: 'TotalCount'},['id_gestion','gestion'])
		});


	 var ds_periodo = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../../sis_parametros/control/periodo/ActionListarPeriodo.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_periodo',totalRecords: 'TotalCount'},['id_periodo','periodo','fecha_inicio','fecha_final','periodo_lite'])
		});


	  function render_id_gestion(value, p, record){return String.format('{0}', record.data['gestion']);}
		var tpl_id_gestion=new Ext.Template('<div class="search-item">','{gestion}','</div>');
		
		
		function render_id_periodo(value, p, record){return String.format('{0}', record.data['periodo_lite']);}
		var tpl_id_periodo=new Ext.Template('<div class="search-item">','{periodo} - {periodo_lite}','</div>');
	
	 vectorAtributos[0]={
				validacion:{
				name:'id_gestion',
				fieldLabel:'Gestión',
				allowBlank:false,			
				//emptyText:'id_gestion...',
				desc: 'desc_gestion', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_gestion,
				valueField: 'id_gestion',
				displayField: 'gestion',
				queryParam: 'filterValue_0',
				filterCol:'GESTIO.gestion',
				typeAhead:true,
				tpl:tpl_id_gestion,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:'100%',
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
				width:150,
				disabled:false		
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'GESTIO.gestion',
			id_grupo:0
			
		};

	 vectorAtributos[1]={
				validacion:{
				name:'id_periodo',
				fieldLabel:'Periodo',
				allowBlank:false,			
				emptyText:'periodo...',
				desc: 'periodo_lite', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_periodo,
				valueField: 'id_periodo',
				displayField: 'periodo_lite',
				queryParam: 'filterValue_0',
				filterCol:'PERIOD.periodo',
				typeAhead:false,
				tpl:tpl_id_periodo,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_periodo,
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				grid_indice:3	
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filtro_1:true,
			filterColValue:'PERIOD.periodo_lite',
			id_grupo:0
			
		};
	 vectorAtributos[2]={
				validacion:{
					name:'tipo_impresion',
					fieldLabel:'Tipo de Impresión',
					vtype:'texto',
					emptyText:'Elija el Tipo de Impresion...',
					allowBlank:false,
					loadMask:true,
					triggerAction:'all',
					store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['0','PDF'],['1','Excel']]}),
				
					valueField:'ID',
					displayField:'valor',
					forceSelection:true,
					width:200
				},
				tipo:'ComboBox',
				id_grupo:0,
				//defecto:'PDF',
				save_as:'tipo_impresion'
			};					
		
		
	 vectorAtributos[3] = {
				validacion : {
					labelSeparator :'',
					name :'t_gestion',
					inputType :'hidden',
					grid_visible :false,
					grid_editable :false
				},
				tipo :'Field',
				filtro_0 :false,
				save_as :'t_gestion'
			};
	 vectorAtributos[4] = {
				validacion : {
					labelSeparator :'',
					name :'t_periodo',
					inputType :'hidden',
					grid_visible :false,
					grid_editable :false
				},
				tipo :'Field',
				filtro_0 :false,
				save_as :'t_periodo'
			};
	
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
		titulo_maestro:"Resumen de Marcas"
	};
	layout_rep_detalle_marcas_periodo=new DocsLayoutProceso(idContenedor);
	layout_rep_detalle_marcas_periodo.init(config);

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS HERENCIA           -----------//
	//////////////////////////////////////////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
    this.pagina(paramConfig,vectorAtributos,layout_rep_detalle_marcas_periodo,idContenedor);

	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//


	var ClaseMadre_conexionFailure = this.conexionFailure; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_getComponente = this.getComponente;


	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	function iniciarEventosFormularios()
	{
		cmbGestion=getComponente('id_gestion');
		cmbPeriodo=getComponente('id_periodo');
		t_periodo=getComponente('t_periodo');
		t_gestion=getComponente('t_gestion');

		var filtrar_periodo = function( combo, record, index )
		{		
			//Filtramos los presupuestos segun la gestion seleccionada
			cmbPeriodo.store.baseParams={id_gestion:record.data.id_gestion};
			t_gestion.setValue(record.data.gestion);
			cmbPeriodo.modificado=true;			
			cmbPeriodo.setValue('');	
				
		}
		
		cmbGestion.on('select',filtrar_periodo);


		var obtener_lite = function( combo, record, index )
		{

		  t_periodo.setValue(record.data.periodo_lite);
		}
		cmbPeriodo.on('select',obtener_lite);	
		/*var $mes = new Date();
		$mes = $mes.getMonth();
		$mes=$mes+1;
		var $primera_fecha = new Date();
		$primera_fecha ='01/0'+$mes+'/'+$primera_fecha.getFullYear();
		h_txt_fecha_ini.setValue($primera_fecha);
		var $fecha_actual = new Date();
		$fecha_actual =$fecha_actual.getDate()+'/0'+$mes+'/'+$fecha_actual.getFullYear();
		h_txt_fecha_fin.setValue($fecha_actual);*/


	}
function eventosAjax(){
		Ext.lib.Ajax.request('POST','../../../sis_telefonico/control/_reportes/llamadas_gerencia/ActionGerencia.php?asistencia=si',
		                     {success:gerencia,failure:this.conexionFailure})
	}
	var InitFunciones=this.InitFunciones;
    //Se agrega el botón para la generación del reporte
	var iniciaFormulario=this.iniciaFormulario;
	//------  sobrecargo la clase madre obtenerTitulo  para las pestanas-----------------//
	function obtenerTitulo()
	{
		//var combo_financiador = ClaseMadre_getComponente('id_financiador');
		var titulo = "Resumen de Marcas"+ ContPes;
		ContPes ++;
		return titulo;
	}


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	function gerencia(resp){
		var regreso=Ext.util.JSON.decode(resp.responseText);
		txt_id_gerencia=regreso.id_gerencia;
		txt_nombre=regreso.nombre_gerencia;
		txt_codigo=regreso.codigo;
		txt_descripcion_gerencia=regreso.descripcion;
		txt_rol=regreso.rol;
		var paramFunciones={
 		    Formulario:{
			labelWidth: 75, //ancho del label
			url:direccion+'../../../../../sis_control_asistencia/control/_reportes/resumen_marcas/DetalleMarcas.php',
			abrir_pestana:true, //abrir pestana
			titulo_pestana:obtenerTitulo,
			fileUpload:false,
			columnas:[320,280],
			grupos:[
			{
				tituloGrupo:'Fecha Inicio',
				columna:0,
				id_grupo:0
			}/*,
			{
				tituloGrupo:'Fecha Fin',
				columna:0,
				id_grupo:1
			}*/],
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
		}
		if(txt_codigo=='GGN' || txt_codigo=='GTI' || txt_rol==1){
			
			combo_empleado.enable()
		}
		else{
			combo_empleado.filterValues[0]=txt_id_gerencia;
			combo_empleado.modificado=true
		}*/
	}
	


//InitBarraMenu(array BOTONES DISPONIBLES);
	this.Init(); //iniciamos la clase madre
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	eventosAjax();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
