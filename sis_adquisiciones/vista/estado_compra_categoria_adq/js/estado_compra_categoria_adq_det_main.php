<?php
/**
 * Nombre:		  	    estado_compra_categoria_adq_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-12 10:18:03
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
	?>
var fa=false;
<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>	
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var maestro={id_tipo_categoria_adq:<?php echo $m_id_tipo_categoria_adq;?>,tipo:decodeURIComponent('<?php echo $m_tipo;?>'),nombre:'<?php echo $m_nombre;?>'};
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_estado_compra_categoria_adq_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);


/**
 * Nombre:		  	    pagina_estado_compra_categoria_adq_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-12 10:18:03
 */
function pagina_estado_compra_categoria_adq_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/estado_compra_categoria_adq/ActionListarEstadoCompraCategoriaAdq_det.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_estado_compra_categoria_adq',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_estado_compra_categoria_adq',
		'dias_min',
		'dias_max',
		'orden',
		'id_estado_compra',
		'desc_estado_compra',
		'desc_tipo_categoria_adq',
		'id_tipo_categoria_adq'

		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_tipo_categoria_adq:maestro.id_tipo_categoria_adq
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO

    var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor},true);
	Ext.DomHelper.applyStyles(div_grid_detalle,"background-color:#FFFFFF");

	//DATA STORE COMBOS

    var ds_estado_compra = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/estado_compra/ActionListarEstadoCompra.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_estado_compra',totalRecords:'TotalCount'},['id_estado_compra','descripcion','proceso_sistema','cronometrable','nombre','tiempo_estimado'])
	});

	//FUNCIONES RENDER
	
	function render_id_estado_compra(value, p, record){return String.format('{0}', record.data['desc_estado_compra']);}
	var tpl_id_estado_compra=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');

	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_estado_compra_categoria_adq
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_estado_compra_categoria_adq',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_estado_compra_categoria_adq'
	};

	// txt id_tipo_categoria_adq
	Atributos[1]={
		validacion:{
			name:'id_tipo_categoria_adq',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_tipo_categoria_adq,
		save_as:'id_tipo_categoria_adq'
	};
	// txt id_estado_compra
	Atributos[2]={
			validacion:{
			name:'id_estado_compra',
			fieldLabel:'Estado Compra',
			allowBlank:false,			
			emptyText:'Estado Compra...',
			desc: 'desc_estado_compra', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_estado_compra,
			valueField: 'id_estado_compra',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'ESTCOM.descripcion#ESTCOM.nombre',
			typeAhead:true,
			tpl:tpl_id_estado_compra,
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
			renderer:render_id_estado_compra,
			grid_visible:true,
			grid_editable:true,
			width_grid:150,
			disable:false,
			grid_indice:2
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'ESTCOM.descripcion',
		save_as:'id_estado_compra'
	};
	// txt orden
	Atributos[3]={
		validacion:{
			name:'orden',
			fieldLabel:'Orden',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'50%',
			disable:false,
			grid_indice:3
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'ESCOCA.orden',
		save_as:'orden'
	};
	// txt dias_min
	Atributos[4]={
		validacion:{
			name:'dias_min',
			fieldLabel:'Dias Min',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'50%',
			disable:false,
			grid_indice:4
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'ESCOCA.dias_min',
		save_as:'dias_min'
	};
// txt dias_max
	Atributos[5]={
		validacion:{
			name:'dias_max',
			fieldLabel:'Dias Max',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'50%',
			disable:false,
			grid_indice:5
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'ESCOCA.dias_max',
		save_as:'dias_max'
	};


//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Tipo Categoría (Maestro)',titulo_detalle:'Estado Compra Categoria (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_estado_compra_categoria_adq = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_estado_compra_categoria_adq.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_estado_compra_categoria_adq,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/estado_compra_categoria_adq/ActionEliminarEstadoCompraCategoriaAdq.php',parametros:'&m_id_tipo_categoria_adq='+maestro.id_tipo_categoria_adq},
	Save:{url:direccion+'../../../control/estado_compra_categoria_adq/ActionGuardarEstadoCompraCategoriaAdq.php',parametros:'&m_id_tipo_categoria_adq='+maestro.id_tipo_categoria_adq},
	ConfirmSave:{url:direccion+'../../../control/estado_compra_categoria_adq/ActionGuardarEstadoCompraCategoriaAdq.php',parametros:'&m_id_tipo_categoria_adq='+maestro.id_tipo_categoria_adq},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:240,width:450,minWidth:150,minHeight:200,	closable:true,titulo:'Estado Compra Categoria'}};
	
	//-------------- Sobrecarga de funciones --------------------//
	var ds_maestro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_adquisiciones/control/tipo_categoria_adq/ActionListarTipoCategoriaAdq.php?m_id_tipo_categoria_adq='+maestro.id_tipo_categoria_adq}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_categoria_adq',totalRecords: 'TotalCount'},['id_tipo_categoria_adq',
		'desc_categoria_adq',
		'tipo',
		'nombre'
		])
		});
		
		ds_maestro.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_tipo_categoria_adq:maestro.id_tipo_categoria_adq
			},
			callback:cargar_maestro
		});

		function cargar_maestro(){
			Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro([['Tipo Categoria',ds_maestro.getAt(0).get('tipo')],['Nombre',ds_maestro.getAt(0).get('nombre')],['Descripcion',ds_maestro.getAt(0).get('desc_categoria_adq')]]));
		}
	
	
	
	
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_tipo_categoria_adq=datos.m_id_tipo_categoria_adq;
        maestro.tipo=datos.m_tipo

		ds_maestro.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					m_id_tipo_categoria_adq:maestro.id_tipo_categoria_adq
				},
				callback:cargar_maestro
			});
        
        ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_tipo_categoria_adq:maestro.id_tipo_categoria_adq
			}
		});
		
			
		Atributos[1].defecto=maestro.id_tipo_categoria_adq;
		paramFunciones.btnEliminar.parametros='&m_id_tipo_categoria_adq='+maestro.id_tipo_categoria_adq;
		paramFunciones.Save.parametros='&m_id_tipo_categoria_adq='+maestro.id_tipo_categoria_adq;
		paramFunciones.ConfirmSave.parametros='&m_id_tipo_categoria_adq='+maestro.id_tipo_categoria_adq;
		this.InitFunciones(paramFunciones)
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_estado_compra_categoria_adq.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_estado_compra_categoria_adq.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}