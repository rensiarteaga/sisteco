<?php 
/**
 * Nombre:		  	    formulacion_presupuesto_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-07-10 09:08:14
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
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:true,FiltroAvanzado:fa};
var estado_pres=<?php echo $estado_pres;?>;
var elemento={pagina:new pagina_modificacion_finansas(idContenedor,direccion,paramConfig,estado_pres),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_formulacion_presupuesto.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-07-10 09:08:14
 */
function pagina_modificacion_finansas(idContenedor,direccion,paramConfig,f_estado_pres){
	var Atributos=new Array,sw=0;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/presupuesto/ActionListarFormulacionPresupuesto.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_presupuesto',totalRecords:'TotalCount'
		},[		
				'id_presupuesto',
		'tipo_pres',
		'estado_pres',
'id_financiador','id_regional','id_programa','id_proyecto','id_actividad','nombre_financiador','nombre_regional','nombre_programa','nombre_proyecto','nombre_actividad','codigo_financiador','codigo_regional','codigo_programa','codigo_proyecto','codigo_actividad',
		'id_unidad_organizacional',
		'desc_unidad_organizacional',
		'id_fuente_financiamiento',
		'desc_fuente_financiamiento',
		'id_parametro',
		'desc_parametro',
		'gestion_pres'
		]),remoteSort:true});

		//alert ("tipo de presupuesto "+tipo_pres);
		
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			estado_pres:f_estado_pres
		}
	});
	//DATA STORE COMBOS

    var ds_unidad_organizacional = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarUnidadOrganizacional.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_organizacional',totalRecords: 'TotalCount'},['id_unidad_organizacional','nombre_unidad','nombre_cargo','centro','cargo_individual','descripcion','fecha_reg','id_nivel_organizacional','estado_reg'])
	});

    var ds_fuente_financiamiento = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/fuente_financiamiento/ActionListarFuenteFinanciamiento.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_fuente_financiamiento',totalRecords: 'TotalCount'},['id_fuente_financiamiento','codigo_fuente','denominacion'])
	});

    var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','gestion_pres','estado_gral','cod_institucional','porcentaje_sobregiro','cantidad_niveles'])
	});

	//FUNCIONES RENDER
	
		function render_id_unidad_organizacional(value, p, record){return String.format('{0}', record.data['desc_unidad_organizacional']);}
		var tpl_id_unidad_organizacional=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{nombre_unidad}</FONT><br>','<FONT COLOR="#B5A642">{centro}</FONT>','</div>');

		function render_id_fuente_financiamiento(value, p, record){return String.format('{0}', record.data['desc_fuente_financiamiento']);}
		var tpl_id_fuente_financiamiento=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{codigo_fuente}</FONT><br>','<FONT COLOR="#B5A642">{denominacion}</FONT>','</div>');

		function render_id_parametro(value, p, record){return String.format('{0}', record.data['desc_parametro']);}
		var tpl_id_parametro=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{gestion_pres}</FONT><br>','<FONT COLOR="#B5A642">{estado_gral}</FONT>','</div>');

	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_presupuesto
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_presupuesto',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_presupuesto'
	};
// txt tipo_pres
	Atributos[1]={
		validacion:{
			name:'tipo_pres',
			fieldLabel:'Tipo Presupuesto',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'80%',
			disabled:true		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'PRESUP.tipo_pres',
		save_as:'tipo_pres'
	};
// txt estado_pres
	Atributos[2]={
		validacion:{
			name:'estado_pres',
			fieldLabel:'Estado Presupuesto',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:'80%',
			disabled:true		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'PRESUP.estado_pres',
		save_as:'estado_pres'
	};
// txt id_fina_regi_prog_proy_acti
	Atributos[3]={
		validacion:{
			fieldLabel:'Estructura Programatica',
			allowBlank:true,
			emptyText:'Estructura Programática',
			name:'id_fina_regi_prog_proy_acti',
			minChars:1,
			triggerAction:'all',
			editable:false,
			grid_visible:true,
			grid_editable:false,		
			width:300
			},
			tipo:'epField',
			save_as:'id_ep',
			id_grupo:1
		};
// txt id_unidad_organizacional
	Atributos[4]={
			validacion:{
			name:'id_unidad_organizacional',
			fieldLabel:'Unidad Organizacional',
			allowBlank:true,			
			emptyText:'Unidad Organizacional...',
			desc: 'desc_unidad_organizacional', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_unidad_organizacional,
			valueField: 'id_unidad_organizacional',
			displayField: 'nombre_unidad',
			queryParam: 'filterValue_0',
			filterCol:'UNIORG.nombre_unidad#UNIORG.centro',
			typeAhead:true,
			tpl:tpl_id_unidad_organizacional,
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
			renderer:render_id_unidad_organizacional,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:'100%',
			disabled:true		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'UNIORG.nombre_unidad',
		save_as:'id_unidad_organizacional'
	};
// txt id_fuente_financiamiento
	Atributos[5]={
			validacion:{
			name:'id_fuente_financiamiento',
			fieldLabel:'Fuente Financiamiento',
			allowBlank:true,			
			emptyText:'Fuente Financiamiento...',
			desc: 'desc_fuente_financiamiento', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_fuente_financiamiento,
			valueField: 'id_fuente_financiamiento',
			displayField: 'codigo_fuente',
			queryParam: 'filterValue_0',
			filterCol:'FUNFIN.codigo_fuente#FUNFIN.denominacion',
			typeAhead:true,
			tpl:tpl_id_fuente_financiamiento,
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
			renderer:render_id_fuente_financiamiento,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:'100%',
			disabled:true		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'FUNFIN.codigo_fuente',
		save_as:'id_fuente_financiamiento'
	};
// txt id_parametro
	Atributos[6]={
			validacion:{
			name:'id_parametro',
			fieldLabel:'Parametro',
			allowBlank:true,			
			emptyText:'Parametro...',
			desc: 'desc_parametro', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_parametro,
			valueField: 'id_parametro',
			displayField: 'gestion_pres',
			queryParam: 'filterValue_0',
			filterCol:'PARAMP.gestion_pres#PARAMP.estado_gral',
			typeAhead:true,
			tpl:tpl_id_parametro,
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
			renderer:render_id_parametro,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'50%',
			disabled:true		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PARAMP.gestion_pres',
		save_as:'id_parametro'
	};
// txt gestion_pres
	Atributos[7]={
		validacion:{
			name:'gestion_pres',
			fieldLabel:'Gestión',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:50,
			width:'50%',
			disabled:true		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'PRESUP.gestion_pres',
		save_as:'gestion_pres'
	};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'formulacion_presupuesto',grid_maestro:'grid-'+idContenedor};
	var layout_formulacion_presupuesto=new DocsLayoutMaestroEP(idContenedor);
	layout_formulacion_presupuesto.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_formulacion_presupuesto,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

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
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/presupuesto/ActionEliminarFormulacionPresupuesto.php'},
		Save:{url:direccion+'../../../control/presupuesto/ActionGuardarFormulacionPresupuesto.php'},
		ConfirmSave:{url:direccion+'../../../control/presupuesto/ActionGuardarFormulacionPresupuesto.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,columnas:['90%'],grupos:[{tituloGrupo:'Datos',columna:0,id_grupo:0},{tituloGrupo:'Estructura Programatica',columna:0,id_grupo:1}],width:'50%',minWidth:150,minHeight:200,	closable:true,titulo:'formulacion_presupuesto'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
function btn_detalle_partida_formulacion(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_presupuesto='+SelectionsRecord.data.id_presupuesto;

			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_formulacion_presupuesto.loadWindows(direccion+'../../../../sis_presupuesto/vista/detalle_partida_formulacion/detalle_partida_formulacion.php?'+data,'Detalle de Partida Gasto',ParamVentana);

		}
	else
	{
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
	}
	}
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_formulacion_presupuesto.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
		this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Detalle de Partida Gasto',btn_detalle_partida_formulacion,true,'detalle_partida_formulacion','');

	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_formulacion_presupuesto.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}