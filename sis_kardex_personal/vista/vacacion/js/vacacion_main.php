<?php 
/**
 * Nombre:		  	    vacacion_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2010-08-17 09:25:59
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


//var elemento={pagina:new pagina_vacacion(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={pagina:new pagina_vacacion(idContenedor,direccion,paramConfig,idContenedorPadre),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);
/**
 * Nombre:		  	    pagina_vacacion.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2010-08-17 09:25:59
 */
function pagina_vacacion(idContenedor,direccion,paramConfig,idContenedorPadre){
	var Atributos=new Array,sw=0;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/vacacion/ActionListarVacacion.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_vacacion',totalRecords:'TotalCount'
		},[		
		'id_vacacion',
		'id_gestion',
		'desc_gestion',
		'id_empleado',
		'id_categoria_vacacion',
		'desc_categoria_vacacion',
		'total_dias'
		]),remoteSort:true});

	
	//DATA STORE COMBOS
	var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/gestion/ActionListarGestion.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_gestion',totalRecords: 'TotalCount'},['id_gestion','denominacion','gestion','estado_ges_gral'])
	});
	
	var ds_categoria_vacacion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/categoria_vacacion/ActionListarCategoriaVacacion.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_categoria_vacacion',totalRecords: 'TotalCount'},['id_categoria_vacacion','nombre','descripcion','estado_reg'])
	});
	
	

	//FUNCIONES RENDER
	
	function render_id_gestion(value,p,record){return String.format('{0}',record.data['desc_gestion'])}
	function render_id_categoria_vacacion(value,p,record){return String.format('{0}',record.data['desc_categoria_vacacion'])}
	
	var tpl_id_gestion=new Ext.Template('<div class="search-item">','<b><i>{gestion}</b></i>','<FONT COLOR="#B5A642">{denominacion}</FONT>','</div>'); //
	var tpl_id_categoria_vacacion=new Ext.Template('<div class="search-item">','<b><i>{nombre}</b></i>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>'); //denominacion

	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_vacacion
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_vacacion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false		
	};
	
	Atributos[1]={
		validacion:{
			labelSeparator:'',
			name: 'id_empleado',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
		
	};
// txt id_gestion
	
	Atributos[2]={
			validacion: {
			name:'id_gestion',
			fieldLabel:'Gestión',
			allowBlank:false,	
			//emptyText:'Gestión...',
			desc:'desc_gestion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_gestion,
			valueField:'id_gestion',
			displayField:'gestion',
			queryParam: 'filterValue_0',
			filterCol:'GESTIO.gestion',
			typeAhead:false,			
			tpl:tpl_id_gestion,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:15,
			minListWidth:350,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_gestion,
			grid_visible:true,
			grid_editable:true,
			width_grid:100, // ancho de columna en el gris
			width:'100%',
			disabled:false
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'GESTIO.gestion',
		defecto: '',
		save_as:'id_gestion'
	};	

	Atributos[3]={
			validacion: {
			name:'id_categoria_vacacion',
			fieldLabel:'Categoría Vacación',
			allowBlank:true,	
			//emptyText:'Categoría...',
			desc:'desc_categoria_vacacion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_categoria_vacacion,
			valueField:'id_categoria_vacacion',
			displayField:'nombre',
			queryParam: 'filterValue_0',
			filterCol:'CATVAC.nombre',
			typeAhead:false,			
			tpl:tpl_id_categoria_vacacion,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:15,
			minListWidth:350,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_categoria_vacacion,
			grid_visible:true,
			grid_editable:true,
			width_grid:250, // ancho de columna en el gris
			width:'100%',
			disabled:true
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'CATVAC.nombre',
		defecto: '',
		save_as:'id_categoria_vacacion'
	};
	
// txt total_dias
	Atributos[4]={
		validacion:{
			name:'total_dias',
			fieldLabel:'Total Dias',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disabled:true		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'VACACI.total_dias'
		
	};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Vacación',grid_maestro:'grid-'+idContenedor};
	var layout_vacacion=new DocsLayoutMaestro(idContenedor,idContenedorPadre);
	layout_vacacion.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_vacacion,idContenedor);
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
		btnEliminar:{url:direccion+'../../../control/vacacion/ActionEliminarVacacion.php'},
		Save:{url:direccion+'../../../control/vacacion/ActionGuardarVacacion.php'},
		ConfirmSave:{url:direccion+'../../../control/vacacion/ActionGuardarVacacion.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Vacación'}};
	
	this.reload=function(m)
	{
		maestro=m;
		
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_empleado:maestro.id_empleado
			}
		};
		this.btnActualizar();
		//data_maestro=[['Nro.Documento',maestro.nro_documento],['Razón social',maestro.razon_social],['Fecha documento',maestro.fecha_documento],['Importe factura',maestro.importe_total],['Moneda',maestro.desc_moneda]];
		//Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		Atributos[1].defecto=maestro.id_empleado;

		paramFunciones.btnEliminar.parametros='&m_id_empleado='+maestro.id_empleado;
		paramFunciones.Save.parametros='&m_id_empleado='+maestro.id_empleado;
		paramFunciones.ConfirmSave.parametros='&m_id_empleado='+maestro.id_empleado;			
		
		this.InitFunciones(paramFunciones);
	};	

	function btnProgramar()
	{
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0)
		{

			var SelectionsRecord=sm.getSelected();

			var data='id_vacacion='+SelectionsRecord.data.id_vacacion;
			data=data+'&id_empleado='+SelectionsRecord.data.id_empleado;					

			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			
			layout_vacacion.loadWindows(direccion+'../../../../sis_tesoreria/vista/cuenta_doc_rendicion_cab/cuenta_doc_rendicion_cab.php?'+data,'Rendiciones',ParamVentana);
									
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	function btnReporte()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0)
		{
			var SelectionsRecord=sm.getSelected();
			var data='m_id_vacacion='+SelectionsRecord.data.id_vacacion;
			if(reporte==2)
			{
				data = data +'&estado=oficial';
			}else
			{
				data = data +'&estado='+ SelectionsRecord.data.estado;
			}
			
			Ext.MessageBox.show({
				title: 'Imprimiendo',
				msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Generando reporte ...</div>",
				width:300,
				height:200,
				closable:false
			});
			
			window.open(direccion+'../../../control/vacacion/reportes/ActionPDFReciboProvisionalFondosEfectivo.php?'+data);
					
			Ext.MessageBox.hide();
		
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un registro.');
		}
	}
		
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_vacacion.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	
	
	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/detalle.png','Registrar el detalle de la programación de vacaciones',btnProgramar,true,'programar_vacacion','Programar Vacación'); //tucrem
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprime el detalle de vacaciones',btnReporte,true,'reporte','Reporte');
	
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_vacacion.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}