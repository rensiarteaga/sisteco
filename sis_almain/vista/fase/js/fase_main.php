<?php 
/**
 * Nombre:		  	    clasificacion_arb_main.php
 * Proposito: 			pagina que arranca la configuracion de la vista
 * Autor:				UNKNOW
 * Fecha creacion:		01-12-2014
 *
 */
session_start();
?>
//<script>
function main(){
	 	<?php
		//obtenemos la ruta absoluta
		$host  = $_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$dir = "http://$host$uri/";
		echo "\nvar direccion='$dir';";
	    echo "var idContenedor='$idContenedor';";
	?>
	var fa=false; 
	<?php if($_SESSION["ss_filtro_avanzado"]!=''){
		echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}
	?>
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:false};
var maestro={
				m_id_almacen:<?php echo $m_id_almacen;?>,
				m_codigo:'<?php echo $m_codigo;?>',
				m_nombre:decodeURIComponent('<?php echo $m_nombre;?>')
		};
idContenedorPadre='<?php echo $idContenedorPadre;?>';

var elemento={idContenedor:idContenedor,pagina:new pagina_fase(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};

ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

function pagina_fase(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var vectorAtributos = new Array();
	var layout_fase;
	var ds; 
	var maestroData;
	//////////////////////////////
	//							//
	//  DATA STORE      		//
	//							//
	//////////////////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/fase/ActionListarFase.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_fase',
			totalRecords: 'TotalCount'}
		,[
		  	// define el mapeo de XML a las etiquetas (campos)
			'id_fase',
			{name: 'descripcion', type: 'string'},
			'codigo',
			'observaciones',
			'estado',
			'sw_tramo',
			'id_almacen','desc_almacen','direccion','usuario_reg',
			'fecha_reg'
		]),

		remoteSort: true // metodo de ordenacion remoto
	});
	
	// PARAMETROS DEL FORMULARIO Y EL GRID//
	vectorAtributos = 
	[
	      {
	    	  validacion : {
					labelSeparator : '',
					name : 'id_fase',
					inputType : 'hidden',
					grid_visible : false,
					grid_editable : false
				},
				tipo : 'Field',
				filtro_0 : false,
				save_as : 'hidden_id_fase'
	      },
	      {
	    	  validacion : {
					labelSeparator : '',
					name : 'id_almacen',
					inputType : 'hidden',
					grid_visible : false,
					grid_editable : false
				},
				tipo : 'Field',
				filtro_0 : false,
				save_as : 'hidden_id_almacen'
	      },
	      {
	    	  validacion : {
					name : 'desc_almacen',
					fieldLabel : 'Almacen',	
					allowBlank : false,
					align : 'center',
					grid_visible : false,
					grid_editable : false,
					width_grid : 100,
					width : 285
				},
				tipo : 'TextField',
				filtro_0 : false,
				filterColValue : 'al.nombre',
				form : true
	     },
	     {
	    	  validacion : {
					name : 'codigo',
					fieldLabel : 'Codigo Fase',
					allowBlank : false,
					align : 'left',
					grid_visible : true,
					grid_editable : false,
					width_grid : 100,
					width : 285
				},
				tipo : 'TextField',
				filtro_0 : true,
				filterColValue : 'fa.codigo',
				form : true,
				save_as : 'txt_codigo'
	     },
	     {
	    	 validacion : {
					name : 'descripcion',
					fieldLabel : 'Descripcion',
					allowBlank : true,
					align : 'left',
					grid_visible : true,
					grid_editable : false,
					width_grid : 150,
					width : 285
				},
				tipo : 'TextArea',
				filtro_0 : true,
				filterColValue : 'fa.descripcion',
				form : true,
				save_as : 'txt_descripcion'
	     },
	     {
	    	 validacion : {
					name : 'observaciones',
					fieldLabel : 'Observaciones',
					allowBlank : true,
					align : 'left',
					grid_visible : true,
					grid_editable : false,
					width_grid : 150,
					width : 285
				},
				tipo : 'TextArea',
				filtro_0 : false,
				filterColValue : 'fa.observaciones',
				form : true,
				save_as : 'txt_observaciones'
	     },
	     {
				validacion : {
					name : 'sw_tramo',
					fieldLabel : 'SW/Tramo',
					emptyText : 'SW/Tramo...',
					allowBlank : false,
					typeAhead : true,
					loadMask : true,
					triggerAction : 'all',
					mode : "local",
					store : new Ext.data.SimpleStore({
						fields : [ 'valor', 'nombre' ],
						data : [ [ 'si', 'SI' ],
								[ 'no', 'NO' ] ]
					}),
					valueField : 'valor',
					displayField : 'valor',
					align : 'center',
					lazyRender : true,
					forceSelection : true,
					grid_visible : true,
					grid_editable : false,
					width_grid : 55,
					width : 120
				},
				tipo : 'ComboBox',
				filtro_0 : false,
				filterColValue : 'fa.estado',
				form : true,
				save_as : 'txt_sw_tramo'
		},
	     {
				validacion : {
					name : 'estado',
					fieldLabel : 'Estado',
					emptyText : 'Estado...',
					allowBlank : false,
					typeAhead : true,
					loadMask : true,
					triggerAction : 'all',
					mode : "local",
					store : new Ext.data.SimpleStore({
						fields : [ 'valor', 'nombre' ],
						data : [ [ 'activo', 'Activo' ],
								[ 'inactivo', 'Inactivo' ] ]
					}),
					valueField : 'valor',
					displayField : 'valor',
					align : 'center',
					lazyRender : true,
					forceSelection : true,
					grid_visible : true,
					grid_editable : false,
					width_grid : 55,
					width : 120
				},
				tipo : 'ComboBox',
				defecto:'activo',
				filtro_0 : false,
				filterColValue : 'fa.estado',
				form : true,
				save_as : 'txt_estado'
			},
			{
				validacion : {
					name :'usuario_reg',
					fieldLabel : 'Responsable Registro',
					align : 'left',
					grid_visible : true,
					grid_editable : false,
					width_grid : 150
				},
				tipo : 'TextField',
				filtro_0 : false,
				filterColValue : 'fa.usuario_reg',
				form : false
			},
			{
				validacion : {
					name :'fecha_reg',
					fieldLabel : 'Fecha Registro',
					format : 'd/m/Y',
					minValue : '01/01/1900',
					grid_visible : true,
					grid_editable : false,
					//renderer : formatDate,
					align : 'center',
					width_grid : 120
				},
				tipo : 'TextField',
				form : false,
				filtro_0 : false,
				filterColValue : 'fa.fecha_reg',
				dateFormat : 'm-d-Y'
			}
	    
	      
	];

	
	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////

	// ---------- Inicia Layout ---------------//

	var config={	titulo_maestro:' (Fase Almacen)',
					grid_maestro:'grid-'+idContenedor,
					urlHijo:'../../../sis_almain/vista/fase_tramo/fase_tramo.php'};

	layout_fase =new DocsLayoutMaestroDeatalle(idContenedor);
	layout_fase.init(config);

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS HERENCIA           -----------//
	//////////////////////////////////////////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_fase,idContenedor);

	var ClaseMadre_getComponente = this.getComponente;
	var getSelectionModel = this.getSelectionModel; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_conexionFailure = this.conexionFailure; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_btnNew = this.btnNew; // para heredar de la clase madre la funcion brnNew de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_btnActualizar = this.btnActualizar;
	var ClaseMadre_btnEdit=this.btnEdit;
	var enableSelect=this.EnableSelect;
	//////////////////////////////////////////////////////////////
	// -----------   DEFINICION DE LA BARRA DE MENU----------- //
	//////////////////////////////////////////////////////////////

	var paramMenu = {
			 
		nuevo: {
			crear : true, //para ver si se creara el boton
			separador:true
		},
		editar:{
			crear : true, //para ver si se creara el boton
			separador:false
		},
		eliminar:{
			crear : true, //para ver si se creara el boton
			separador:false
		},

		actualizar:{
			crear :true,
			separador:false
		}

	};
	function formatDate(value) {
		return value ? value.dateFormat('d/m/Y') : '';
	};

	//////////////////////////////////////////////////////////////////////////////
	//----------------------  	DEFINICION DE FUNCIONES ------------------------- //
	//  parametrizacion de las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	//datos necesarios para ell filtro

	var paramFunciones = {
		btnEliminar:{url:direccion+'../../../control/fase/ActionEliminaFase.php'},
		Save:{url:direccion+'../../../control/fase/ActionGuardarFase.php'},
		ConfirmSave:{url:direccion+'../../../control/fase/ActionGuardarFase.php'},
		
		Formulario:{
			titulo : 'Registro de Fase',
			html_apply : "dlgInfo-" + idContenedor,
			width : 500,
			height : 420,
			columnas : [ '95%' ],
			closable : true
		}
	};
	//Para manejo de eventos
	function iniciarEventosFormularios()
	{
	}
	this.btnNew = function()
	{
		ClaseMadre_btnNew();
		ClaseMadre_getComponente('id_almacen').setValue(maestro.m_id_almacen);
	
		ClaseMadre_getComponente('desc_almacen').setValue(maestro.m_codigo+' - '+maestro.m_nombre);
		ClaseMadre_getComponente('desc_almacen').disable();
	}
	this.btnEdit =function()
	{
		ClaseMadre_btnEdit();
		ClaseMadre_getComponente('desc_almacen').disable();
	}
	this.EnableSelect=function(sm,row,rec)
	{
		enableSelect(sm,row,rec);

		_CP.getPagina(layout_fase.getIdContentHijo()).pagina.desbloquearMenu();
		_CP.getPagina(layout_fase.getIdContentHijo()).pagina.reload(rec.data);
				
	};

	//-------------- FIN DEFINICION DE FUNCIONES PROPIAS --------------//
	this.reload=function(params)
	{
				var desc_almacen='';
				var datos=Ext.urlDecode(decodeURIComponent(params));
				maestro.m_id_almacen=datos.m_id_almacen;
				maestro.m_codigo=datos.m_codigo;
				maestro.m_nombre=datos.m_nombre;
							
				ds.lastOptions={ 
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros, 
						m_id_almacen:maestro.m_id_almacen
					}
				};
				
			//	_CP.getPagina(layout_fase.getIdContentHijo()).pagina.limpiarStore();
				this.btnActualizar();
				this.InitFunciones(paramFunciones);
	};

	//-------------- FIN DEFINICION DE FUNCIONES PROPIAS --------------//
	this.getLayout=function(){return layout_fase.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	
	this.InitFunciones(paramFunciones);
	
	//this.AdicionarBoton("../../../lib/imagenes/menu-show.gif",'<b>Transferencia de Componente<b>',btnTransferencia,true,'transferir','Transferencia de Componente');
	
	ds.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					m_id_almacen:maestro.m_id_almacen 
				}
			});
	
	this.iniciaFormulario();
	
	iniciarEventosFormularios();

	layout_fase.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}