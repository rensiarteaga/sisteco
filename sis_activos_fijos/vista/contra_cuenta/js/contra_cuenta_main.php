<?php 
/**
 * Nombre:		  	  contra_cuenta_main.php 
 * Propï¿½sito: 			
 * Autor:				
 * Fecha creaciï¿½n:		
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
<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var elemento={pagina:new pagina_contra_cuenta(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);


/**
 * Nombre:		 	contra_cuenta.js  	  
 * Proposito: 		vista,parametrizacion de las contra cuentas ACTIF-CONIN		
 * Autor:			Elmer Velasquez			
 * Fecha creacion:	01/02/2013  
 */
 
function pagina_contra_cuenta(idContenedor,direccion,paramConfig)
{	 
	var Atributos=new Array;  
	var componentes= new Array();  
	
	//---DATA STORE      
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/contra_cuenta/ActionListarContraCuenta.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_contra_cuenta',totalRecords:'TotalCount'
		},[		
		'id_contra_cuenta',
		'id_regional',
		'desc_regional',
		'id_gestion',
		'gestion', 
		'id_cuenta_titular','desc_cuenta',
		'id_cuenta_auxiliar','desc_cuenta_aux',
		'id_tipo_proceso','desc_proceso',
		'tipo_importe','fecha_reg','id_usuario_reg'
		]),remoteSort:true});
	//DATA STORE COMBOS
	var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/parametro/ActionListarParametro.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',
		id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','id_gestion','gestion','cantidad_nivel','estado_gestion','gestion_conta',
		'cantidad_nivel','estado_gestion']),
		baseParams:{m_estado:2}
		});
	function render_id_gestion(value, p, record){return String.format('{0}', record.data['gestion']);}
	var tpl_id_gestion=new Ext.Template('<div class="search-item">','<b>Gestion: </b><FONT COLOR="#B5A642">{gestion_conta}</FONT><br>','<b>Estado: </b><FONT COLOR="#B5A642">{estado_gestion}</FONT><br>','</div>');
	
	var ds_regional = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: '../../../sis_parametros/control/regional/ActionListaRegionalEP.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_regional',
			totalRecords: 'TotalCount'

		}, ['id_regional','nombre_regional'])//,
	});
	var tpl_id_regional=new Ext.Template('<div class="search-item">','<b>Regional: </b><FONT COLOR="#B5A642">{nombre_regional}</FONT><br>','</div>');
	function renderRegional(value, p, record){return String.format('{0}', record.data['desc_regional']);}
	
	
	var ds_cta = new Ext.data.Store({
		// asigna url de donde se cargarï¿½n los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_activo_cuenta/cuentas_contables_gestion/ActionListarCuentasContables.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta',totalRecords: 'TotalCount'},
		['id_cuenta','nro_cuenta','nombre_cuenta','descripcion'])});
	function renderCta(value, p, record){return String.format('{0}', record.data['desc_cuenta']);}
	var tpl_cuenta=new Ext.Template('<div class="search-item">','<b>Cuenta: </b><FONT COLOR="#0000ff">{nro_cuenta}</FONT> - ','<FONT COLOR="#0000ff">{nombre_cuenta}</FONT><br>','</div>');

	var ds_cta_auxiliar = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/auxiliar/ActionListarAuxiliar.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_auxiliar',totalRecords: 'TotalCount'},['id_auxiliar','codigo_auxiliar','nombre_auxiliar','estado_auxiliar'])});
	function renderCtaAux(value, p, record){return String.format('{0}', record.data['desc_cuenta_aux']);}
	var tpl_cta_aux=new Ext.Template('<div class="search-item">','<b>Código: </b><FONT COLOR="#0000ff">{codigo_auxiliar}</FONT><br>','<b>Auxiliar: </b><FONT COLOR="#0000ff">{nombre_auxiliar}</FONT><br>','</div>');
		
	
	var ds_proceso= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_activos_fijos/control/proceso/ActionListarProceso.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_proceso',totalRecords: 'TotalCount'},['id_proceso','codigo','descripcion'])
		});
	function render_id_proceso(value, p, record){return String.format('{0}', record.data['desc_proceso']);}
	var tpl_id_proceso=new Ext.Template('<div class="search-item">','<b>{descripcion}</b><br>','<FONT COLOR="#B5A642">{codigo}</FONT>','</div>');
	 
	
	///////////////////////// 
	// Definiciï¿½n de datos //
	/////////////////////////
	//en la posiciï¿½n 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_contra_cuenta',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false,
			width_grid:80 
		},
		tipo: 'Field',
		filtro_0:false
	};

	Atributos[1]={
		validacion:{
		fieldLabel: 'Gestion',
				allowBlank: true,
				vtype:"texto",
				emptyText:'Gestion...',
				name: 'id_gestion',     //indica la columna del store principal "ds" del que proviane el id
				desc: 'gestion',//'codigo', //indica la columna del store principal "ds" del que proviane la descripcion
				store:ds_gestion,
				valueField: 'id_gestion',
				displayField: 'gestion_conta',
				queryParam: 'filterValue_0',
				filterCol:'GESTIO.gestion',
				typeAhead: false,
				forceSelection : true,
				mode: 'remote',
				queryDelay: 50,
				pageSize: 10,
				minListWidth : 300,
				resizable: true,
				queryParam: 'filterValue_0',
				minChars : 1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
				triggerAction: 'all',
				renderer:render_id_gestion,
				grid_visible:true, // se muestra en el grid
				grid_editable:true, //es editable en el grid,
				width_grid:200, // ancho de columna en el gris
				width:200,
				tpl: tpl_id_gestion,
				//grid_indice:100
	},
	tipo:'ComboBox',
	id_grupo:0,
	filtro_0:false,
	form: true,
	save_as:'hidden_id_gestion'	
	};
	Atributos[2]={
			validacion:{
			fieldLabel: 'Regional',
					allowBlank: true,
					vtype:"texto",
					emptyText:'Regional...',
					name: 'id_regional',     //indica la columna del store principal "ds" del que proviane el id
					desc: 'desc_regional', //indica la columna del store principal "ds" del que proviane la descripcion
					store:ds_regional,
					valueField: 'id_regional',
					displayField: 'nombre_regional',
					queryParam: 'filterValue_0',
					filterCol:'REGION.codigo_regional#REGION.nombre_regional',
					typeAhead: false,
					forceSelection : true,
					mode: 'remote',
					queryDelay: 50,
					pageSize: 10,
					minListWidth : 300,
					resizable: true,
					queryParam: 'filterValue_0',
					minChars : 1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
					triggerAction: 'all',
					renderer:renderRegional ,
					grid_visible:true, // se muestra en el grid
					grid_editable:false, //es editable en el grid,
					width_grid:200, // ancho de columna en el gris
					width:200,
					tpl: tpl_id_regional,
					//grid_indice:100
		},
		tipo:'ComboBox',
		id_grupo:0,
		filtro_0:true,
		filterColValue:'vep.codigo_regional#vep.nombre_regional',
		form: true,
		save_as:'hidden_id_regional'	
		};
	Atributos[3]={
			validacion:{
			fieldLabel: 'Cuenta',
					allowBlank: true,
					vtype:"texto",
					emptyText:'Cuenta...',
					name: 'id_cuenta_titular',     //indica la columna del store principal "ds" del que proviane el id
					desc: 'desc_cuenta', //indica la columna del store principal "ds" del que proviane la descripcion
					store:ds_cta,
					valueField: 'id_cuenta',
					displayField: 'descripcion',
					queryParam: 'filterValue_0',
					filterCol:'CUENTA.nro_cuenta#CUENTA.nombre_cuenta',
					typeAhead: false,
					forceSelection : true,
					mode: 'remote',
					queryDelay: 50,
					pageSize: 10,
					minListWidth : 300,
					resizable: true,
					queryParam: 'filterValue_0',
					minChars : 1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
					triggerAction: 'all',
					renderer:renderCta ,
					grid_visible:true, // se muestra en el grid
					grid_editable:false, //es editable en el grid,
					width_grid:250, // ancho de columna en el gris
					width:300,
					tpl: tpl_cuenta,
					
		},
		tipo:'ComboBox',
		id_grupo:0,
		filtro_0:true,
		filterColValue:'cta.nro_cuenta#cta.nombre_cuenta',
		form: true,
		save_as:'hidden_id_cuenta'	
		};
	Atributos[4]={
			validacion:{
			fieldLabel: 'Cuenta Auxiliar',
					allowBlank: true,
					vtype:"texto",
					emptyText:'CuentaAuxiliar...',
					name: 'id_cuenta_auxiliar',     //indica la columna del store principal "ds" del que proviane el id
					desc: 'desc_cuenta_aux', //indica la columna del store principal "ds" del que proviane la descripcion
					store:ds_cta_auxiliar,
					valueField: 'id_auxiliar',
					displayField: 'nombre_auxiliar',
					queryParam: 'filterValue_0',
					filterCol:'AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar',
					typeAhead: false,
					onSelect: function(record)
					{
						ClaseMadre_getComponente('id_cuenta_auxiliar').setValue(record.data.id_auxiliar); 
						ClaseMadre_getComponente('ayuda_cuenta').setValue(record.data.id_auxiliar); 
						ClaseMadre_getComponente('id_cuenta_auxiliar').collapse();
					},
					forceSelection : true,
					mode: 'remote',
					queryDelay: 50,
					pageSize: 10,
					minListWidth : 300,
					resizable: true,
					queryParam: 'filterValue_0',
					minChars : 1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
					triggerAction: 'all',
					renderer:renderCtaAux ,
					grid_visible:true, // se muestra en el grid
					grid_editable:false, //es editable en el grid,
					width_grid:250, // ancho de columna en el gris
					width:300,
					tpl: tpl_cta_aux,
					
		},
		tipo:'ComboBox',
		id_grupo:0,
		filtro_0:true,
		filterColValue:'aux.codigo_auxiliar#aux.nombre_auxiliar',
		form: true,
		save_as:'hidden_id_cuenta_aux'	
		};
	Atributos[5] = {
			validacion:{
				labelSeparator:'',
				name: 'ayuda_cuenta',
				inputType:'hidden'
			},
			tipo: 'Field',
			filtro_0:false
			
		};
	Atributos[6] = {
			validacion:{
				fieldLabel: 'Proceso',
				allowBlank: false,
				vtype:"texto",
				emptyText:'Proceso...',
				name: 'id_tipo_proceso',     //indica la columna del store principal "ds" del que proviane el id
				desc: 'desc_proceso',//'codigo', //indica la columna del store principal "ds" del que proviane la descripcion
				store:ds_proceso,
				valueField: 'id_proceso',
				displayField: 'descripcion',
				queryParam: 'filterValue_0',
				filterCol:'descripcion',
				typeAhead: true,
				forceSelection : true,
				mode: 'remote',
				queryDelay: 50,
				pageSize: 10,
				minListWidth : 300,
				width:200,
				resizable: true,
				queryParam: 'filterValue_0',
				minChars : 1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
				triggerAction: 'all',
				renderer: render_id_proceso,
				tpl:tpl_id_proceso,
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,m	m	
				width_grid:200, // ancho de columna en el gris
				
			},
			tipo: 'ComboBox',
			filtro_0:true,
			filterColValue:'proc.descripcion',
			form: true,
			save_as:'hidden_id_proceso'	,
			id_grupo:0
		};
	Atributos[7] = {
			validacion: {
				name:'tipo_importe',
				fieldLabel: 'Tipo Importe',
				allowBlank:false,
				typeAhead:false,
				loadMask:true,
				triggerAction:'all',
				emptyText:'importe...',
				store:new Ext.data.SimpleStore({fields:['id_importe','desc_importe'],
													data:[
													      ['0','DEBE'],
													      ['1', 'HABER']
													       ]
												}),
				valueField:'desc_importe',
				displayField:'desc_importe',
				lazyRender:true,
				forceSelection:true,
				width_grid:100,
				triggerAction:'all',
				width:90,
				grid_visible:true,			
				disabled:false
			},
			form:true,
			id_grupo:0,
			tipo:'ComboBox',
			filtro_0:false,
			save_as:'id_importe',
			//defecto:' '
		};
	Atributos[8]={
			validacion:{
				name: 'id_contra_cuenta',
				fieldLabel: 'Identificador',
				allowBlank: false,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				width: 150,
				//vtype:"alphaLatino",
				vtype:"texto",		
				grid_visible:true, // se muestra en el grid
				grid_editable:false, //es editable en el grid,
				width_grid:60, // ancho de columna en el gris
				grid_indice:1
			},
			form:false,
			tipo: 'Field',//cambiar por TextArea(pero es muy grande...)
			filtro_0:false,
			filtro_1:false,
		};
	
	
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'param_gral',grid_maestro:'grid-'+idContenedor};
	var layout_contra_cta_actifconin=new DocsLayoutMaestro(idContenedor);
	layout_contra_cta_actifconin.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_contra_cta_actifconin,idContenedor);
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
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_btnEliminar=this.btnEliminar;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	
	///////////////////////////////////
	// DEFINICIï¿½N DE LA BARRA DE MENï¿½//
	///////////////////////////////////
	var paramMenu={
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIï¿½N DE FUNCIONES ------------------------- //
	//  aquï¿½ se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones={ 
		btnEliminar:{url:direccion+'../../../control/contra_cuenta/ActionEliminarContraCuenta.php'},
		Save:{url:direccion+'../../../control/contra_cuenta/ActionGuardarContraCuenta.php'},
		ConfirmSave:{url:direccion+'../../../control/contra_cuenta/ActionGuardarContraCuenta.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:450,columnas:['90%'],
			grupos:[
			        //{tituloGrupo:'Descripcion',columna:0,id_grupo:0},
			        {tituloGrupo:'Datos Contra Cuentas',columna:0,id_grupo:0}
			        ],
			width:'50%',
			minWidth:150,
			minHeight:200,	
			closable:true,
			titulo:' Contra Cuentas ACTIF-CONIN '
			//guardar:abrirVentana
			}
		};
	
	//-------------- DEFINICIï¿½N DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios()
	{
	//para iniciar eventos en el formulario
		for(var i=0;i<Atributos.length;i++)
		{
			componentes[i]=ClaseMadre_getComponente(Atributos[i].validacion.name);
		}
		combo_cta_aux=getComponente('id_cuenta_titular');
		function combo_cta_aux_onSelect()
		{
			var id_cta_aux=combo_cta_aux.getValue();
			componentes[4].store.baseParams={
											    m_id_cuenta:combo_cta_aux.getValue(), 
												sw_reg_comp:'si'
											};
			componentes[4].modificado=true;
		}
		combo_cta_aux.on('select',combo_cta_aux_onSelect);
		combo_cta_aux.on('change',combo_cta_aux_onSelect);
		
		
		combo_proceso=getComponente('id_tipo_proceso');
		function combo_proceso_onSelect()
		{
			if(combo_proceso.getValue()=='41' || combo_proceso.getValue()=='42' || combo_proceso.getValue()=='25')
			{
				combo_proceso.enable();
				combo_proceso.modificado=true;
				
			}	
			else
			{
				Ext.MessageBox.alert('Error','Debe Seleccionar un Proceso de: ALTA,DEPRECIACION o BAJA de Activos Fijos');
				combo_proceso.setValue('');
			}	
		}
		//combo_proceso.on('change',combo_proceso_onSelect);
		combo_proceso.on('select',combo_proceso_onSelect);
	}
	
	
	this.btnNew=function(){
	  	
		combo_proceso.setValue('');
		ClaseMadre_btnNew()
		};	
	this.btnEdit=function()
	{
				ClaseMadre_btnEdit()
			};
	//para que los hijos puedan ajustarse al tamaï¿½o
	this.getLayout=function(){return layout_contra_cta_actifconin.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARï¿½METROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	this.iniciaFormulario();
	//InitRegistroTransaccion();
	iniciarEventosFormularios();
	layout_contra_cta_actifconin.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}