<?php
/**
 * Nombre:		  	    detalle_cortes_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-23 16:34:14
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
var maestro={id_caja_arqueo:<?php echo $m_id_caja_arqueo;?>,desc_caja:decodeURIComponent('<?php echo $m_desc_caja;?>'),desc_cajero:decodeURIComponent('<?php echo $m_desc_cajero;?>'),fecha_arqueo:decodeURIComponent('<?php echo $m_fecha_arqueo;?>'),sw_resultado:decodeURIComponent('<?php echo $m_sw_resultado;?>')};
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_detalle_cortes(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

//sub view added

/**
 * Nombre:		  	    pagina_detalle_cortes.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-23 16:34:14
 */
function pagina_detalle_cortes(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/corte_arqueo/ActionListarDetalleCortes.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_corte_arqueo',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_corte_arqueo',
		'id_caja_arqueo',
		'desc_caja_arqueo',
		'id_corte',
		'nombre_moneda',
		'importe_valor_corte_moneda',
		'tipo_corte_corte_moneda',
		'desc_corte_moneda',
		'cantidad_corte',
		'importe_total'
		]),remoteSort:true});

	
	// DEFINICIÓN DATOS DEL MAESTRO

	
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	var data_maestro=[['id_caja_arqueo',maestro.id_caja_arqueo],['caja',maestro.desc_caja],['cajero',maestro.desc_cajero],['Fecha Arqueo',new Date(maestro.fecha_arqueo).dateFormat('d/m/Y')],['Resultado',maestro.sw_resultado]];
	
	//DATA STORE COMBOS

    var ds_caja_arqueo = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/caja_arqueo/ActionListarCajaArqueo.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_caja_arqueo',totalRecords: 'TotalCount'},['id_caja_arqueo','nombre_unidad','nombre_unidad','apellido_paterno','apellido_materno','nombre','codigo_empleado','estado_cajero','fecha_arqueo'])
	});

    var ds_corte_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/corte_moneda/ActionListarCorteMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_corte',totalRecords: 'TotalCount'},['id_corte','desc_moneda','importe_valor','tipo_corte'])
	});

	//FUNCIONES RENDER
	
		function render_id_caja_arqueo(value, p, record){return String.format('{0}', record.data['desc_caja_arqueo']);}
		var tpl_id_caja_arqueo=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{nombre_unidad}</FONT><br>','<FONT COLOR="#B5A642">{nombre_unidad}</FONT><br>','<FONT COLOR="#B5A642">{apellido_paterno}</FONT><br>','<FONT COLOR="#B5A642">{apellido_materno}</FONT><br>','<FONT COLOR="#B5A642">{nombre}</FONT><br>','<FONT COLOR="#B5A642">{codigo_empleado}</FONT><br>','<FONT COLOR="#B5A642">{estado_cajero}</FONT><br>','<FONT COLOR="#B5A642">{fecha_arqueo}</FONT>','</div>');

		function render_id_corte(value, p, record){return String.format('{0}', record.data['desc_corte_moneda']);}
		var tpl_id_corte=new Ext.Template('<div class="search-item">','<b><i>{desc_moneda}</b></i><br>','<FONT COLOR="#B5A642">{importe_valor}</FONT><br>','<FONT COLOR="#B5A642">{tipo_corte}</FONT>','</div>');

	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_corte_arqueo
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_corte_arqueo',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_corte_arqueo'
	};
// txt id_caja_arqueo
	Atributos[1]={
		validacion:{
			name:'id_caja_arqueo',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_caja_arqueo,
		save_as:'id_caja_arqueo'
	};
// txt id_corte
	Atributos[2]={
			validacion:{
			name:'id_corte',
			fieldLabel:'Corte',
			allowBlank:false,			
			emptyText:'id_corte...',
			desc: 'desc_corte_moneda', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_corte_moneda,
			valueField: 'id_corte',
			displayField: 'desc_moneda',
			queryParam: 'filterValue_0',
			filterCol:'MONEDA.nombre',
			typeAhead:true,
			tpl:tpl_id_corte,
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
			renderer:render_id_corte,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false,
			grid_indice:1		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'MONEDA_2.nombre',
		save_as:'id_corte'
	};
// txt cantidad_corte
	Atributos[3]={
		validacion:{
			name:'cantidad_corte',
			fieldLabel:'Cantidad',
			allowBlank:false,
			maxLength:50,
			align:'right', 
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'CORARQ.cantidad_corte',
		save_as:'cantidad_corte',
			grid_indice:3
	};
// txt importe_total
	Atributos[4]={
		validacion:{
			name:'importe_total',
			fieldLabel:'Importe Total',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false,
			grid_indice:4		
		},
		tipo: 'NumberField',
		form: false,
		filtro_0:true,
		filterColValue:'CORARQ.importe_total',
		save_as:'importe_total'
	};
	
	// txt cantidad_corte
	Atributos[5]={
		validacion:{
			name:'importe_valor_corte_moneda',
			fieldLabel:'Valor Corte',
			allowBlank:false,
			maxLength:50,
			align:'right', 
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false,
			grid_indice:2		
		},
		tipo: 'NumberField',
		form: false,
		filtro_0:true,
		filterColValue:'MONEDA_2.importe_valor'
	};

	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Arqueo (Maestro)',titulo_detalle:'detalle_cortes (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_detalle_cortes = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_detalle_cortes.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_detalle_cortes,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/corte_arqueo/ActionEliminarDetalleCortes.php',parametros:'&id_caja_arqueo='+maestro.id_caja_arqueo},
	Save:{url:direccion+'../../../control/corte_arqueo/ActionGuardarDetalleCortes.php',parametros:'&id_caja_arqueo='+maestro.id_caja_arqueo},
	ConfirmSave:{url:direccion+'../../../control/corte_arqueo/ActionGuardarDetalleCortes.php',parametros:'&id_caja_arqueo='+maestro.id_caja_arqueo},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'detalle_cortes'}};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		
	maestro.id_caja_arqueo=datos.m_id_caja_arqueo;
maestro.desc_caja=datos.m_desc_caja;
maestro.desc_cajero=datos.m_desc_cajero;
maestro.fecha_arqueo=datos.m_fecha_arqueo;
maestro.sw_resultado=datos.m_sw_resultado;

		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_caja_arqueo:maestro.id_caja_arqueo
			}
		};
		this.btnActualizar();
		data_maestro=[['id_caja_arqueo',maestro.id_caja_arqueo],['caja',maestro.desc_caja],['cajero',maestro.desc_cajero],['Fecha Arqueo',new Date(maestro.fecha_arqueo).dateFormat('d/m/Y')],['Resultado',maestro.sw_resultado]];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		Atributos[1].defecto=maestro.id_caja_arqueo;

		paramFunciones.btnEliminar.parametros='&id_caja_arqueo='+maestro.id_caja_arqueo;
		paramFunciones.Save.parametros='&id_caja_arqueo='+maestro.id_caja_arqueo;
		paramFunciones.ConfirmSave.parametros='&id_caja_arqueo='+maestro.id_caja_arqueo;
		this.InitFunciones(paramFunciones)
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_detalle_cortes.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madree
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			id_caja_arqueo:maestro.id_caja_arqueo
		}
	});
	
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_detalle_cortes.getLayout().addListener('layout',this.onResize);
	layout_detalle_cortes.getVentana(idContenedor).on('resize',function(){layout_detalle_cortes.getLayout().layout()})
	
}