<?php 
/**
 * Nombre:		  	    pagina_interfaz_siet_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				A.V.Q.
 * Fecha creación:		2015/11/12
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
	echo "var id='$id';";
	echo "var idSub='$idSub';";
	echo "var vista='$vista';";
    ?>
var fa=false;

<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>

var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,
TiempoEspera:_CP.getConfig().ss_tiempo_espera,
CantFiltros:1,
FiltroEstructura:false,
FiltroAvanzado:fa};
  var result = "";
  var pestana=_CP.getPestana(id);
var maestro={
	        id_moneda:'<?php echo utf8_decode($m_id_moneda);?>',
			id_gestion:'<?php echo utf8_decode($m_id_gestion);?>',
	     	desc_moneda:'<?php echo utf8_decode($m_desc_moneda);?>'
	     	};
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={pagina:new pagina_interfaz_siet(idContenedor,direccion,paramConfig,maestro,idContenedorPadre),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
* Nombre:		  	    pagina_interfaz_siet.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-09-16 17:55:38
*/
function pagina_interfaz_siet(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var Atributos=new Array,sw=0;
	var g_comprobante;
	var filtro;
	
	var monedas_for=new Ext.form.MonedaField({
		name:'importe',
		fieldLabel:'Importe',	
		allowBlank:false,
		align:'right', 
		maxLength:50,
		minLength:0,
		selectOnFocus:true,
		allowDecimals:true,
		decimalPrecision:2,
		allowNegative:true,
		minValue:-1000000000000}	
	);
	//alert (maestro.vista);
	//---DATA STORE
	 var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/interfaz_siet/ActionListarInterfazSiet.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_documento',totalRecords:'TotalCount'
		},[
		'id_comprobante',
		'partida',
		'codigo_oec',		
		'glosa_cbte',
		'nro_cheque',
		'importe_total',
		{name: 'fecha_cbte',type:'date',dateFormat:'Y-m-d'}
		'
		]),remoteSort:true
	 });
	 
	//--RENDER
	function render_total(value,cell,record,row,colum,store){
		if(value < 0){
		return  '<span style="color:red;">' +monedas_for.formatMoneda(value)+'</span>'}	
		if(value >= 0){return monedas_for.formatMoneda(value)}
	}
	 
	//carga datos XML
	// txt desc_comprobate
	Atributos[0]={
		validacion:{
			name:'id_comprobante',
			fieldLabel:'ID CBTE',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:100,
			disabled:true
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'id_comprobante',
		save_as:'id_comprobante'
	};
	
	Atributos[1]={
		validacion:{
			name:'partida',
			fieldLabel:'Partida',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:true,
			width_grid:100, 
			width:100,
			disabled:false
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'partida',
		save_as:'partida'
	};
	
	
	Atributos[2]={
		validacion:{
			name:'codigo_oec',
			fieldLabel:'OEC',
			allowBlank:false,
			align:'left',
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:true,
			width_grid:110,
			width:100,
			disabled:false
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'codigo_oec',
		save_as:'codigo_oec'
	};
	
	Atributos[3]={
		validacion:{
			name:'glosa_cbte',
			fieldLabel:'Comprobante',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:true,
			width_grid:110,
			width:100,
			disabled:false
		},
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'DOC.poliza_dui',
		save_as:'poliza_dui'
	};
	
	Atributos[4]={
		validacion:{
			name:'nro_cheque',
			fieldLabel:'N° Cheque',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:100,
			disabled:false
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'nro_cheque',
		save_as:'nro_cheque'
	};

	Atributos[5]= {
		validacion:{
			name:'fecha_cbte',
			fieldLabel:'Fecha',
			allowBlank:false,
			align:'right',
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:85,
			disabled:false
		},
		tipo:'DateField',
		filtro_0:false,
		filterColValue:'fecha_cbte',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_cbte'
	};

	Atributos[6]={
		validacion:{
			name:'importe_total',
			fieldLabel:'Importe Total',
			allowBlank:false, 
			align:'right',
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:100,
			width:100,
			disabled:true
		},
		tipo: 'NumberField',
		filtro_0:true,
		filterColValue:'DOCVAL.importe_total',
		save_as:'importe_avance'
	};

	/*Atributos[8]={
		validacion:{
			name:'importe_ice',
			fieldLabel:'Importe ICE',
			allowBlank:false,
			align:'right',
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:100,
			width:100,
			disabled:true
		},
		tipo: 'NumberField',
		filtro_0:false,
		filterColValue:'DOCVAL.importe_ice',
		save_as:'importe_ice'
	};
		
	Atributos[9]={
		validacion:{
			name:'importe_no_gravado',
			fieldLabel:'Importe No Gravado',
			allowBlank:false,
			align:'right',
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:130,
			width:100,
			disabled:true
		},
		tipo: 'NumberField',
		filtro_0:false,
		filterColValue:'DOCVAL.importe_no_gravado',
		save_as:'importe_no_gravado'
	};
	
	Atributos[10]={
		validacion:{
			name:'importe_sujeto',
			fieldLabel:'Importe Sujeto',
			allowBlank:false,
			align:'right',
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:100,
			width:100,
			disabled:true
		},
		tipo: 'NumberField',
		filtro_0:false,
		filterColValue:'DOCVAL.importe_sujeto',
		save_as:'importe_sujeto'
	};
	
	Atributos[11]={
		validacion:{
			name:'importe_credito',
			fieldLabel:'Crédito Fiscal',
			allowBlank:false,
			align:'right',
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:100,
			width:100,
			disabled:true
		},
		tipo: 'NumberField',
		filtro_0:false,
		filterColValue:'DOCVAL.importe_credito',
		save_as:'importe_credito'
	};
	
	Atributos[12]={
		validacion:{
			name:'importe_debito',
			fieldLabel:'Débito Fiscal',
			allowBlank:false,
			align:'right',
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:100,
			width:100,
			disabled:true
		},
		tipo: 'NumberField',
		filtro_0:false,
		filterColValue:'DOCVAL.importe_debito',
		save_as:'importe_debito'
	};
		
	Atributos[13]={
		validacion:{
			name:'codigo_control',
			fieldLabel:'Código de Control',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:true,
			width_grid:140,
			width:100,
			disabled:false
		},
		tipo: 'TextField',
		filtro_0:false,
		filterColValue:'DOC.codigo_control',
		save_as:'codigo_control'
	};
	
	Atributos[14]={
		validacion:{
			labelSeparator:'',
			name: 'id_documento',
			fieldLabel:'ID Documento',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_documento'
	};
 */
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	//---------- INICIAMOS LAYOUT DETALLE
	var config = {
		titulo_maestro:'Documentos IVA',
		grid_maestro:'grid-'+idContenedor
	};
    layout_interfaz_siet_detalle=new DocsLayoutMaestro(idContenedor,idContenedorPadre);
	layout_interfaz_siet_detalle.init(config);

	// INICIAMOS HERENCIA //
	this.pagina=Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_interfaz_siet_detalle,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var CM_saveSuccess=this.saveSuccess;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente= this.mostrarComponente;
	var Cm_conexionFailure=this.conexionFailure;
	var Cm_btnActualizar=this.btnActualizar;
	var getGrid=this.getGrid;
	var getDialog= this.getDialog;
	
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	var paramMenu={
		guardar:{crear:true,separador:false},	
		actualizar:{crear:true,separador:false}
		//excel:{crear:true,separador:false}
	};
	
	var paramFunciones={
		btnEliminar:{
			url:direccion+"../../../control/categoria/ActionEliminarDocumento.php"
		},
		Save:{
			url:direccion+"../../../control/documento/ActionGuardarDocumentoIva.php"
		},
		ConfirmSave:{
			url:direccion+"../../../control/documento/ActionGuardarDocumentoIva.php"
		},
		Formulario:{
			titulo:'Interfaz SIET',
			html_apply:"dlgInfo-"+idContenedor,
			width:'40%',
			height:'50%',
			minWidth:150,
			minHeight:100,
			columnas:['95%'],
			closable:true
		}
	};
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //

	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	//Para manejo de eventos
	this.reload=function(m){
		var datos=Ext.urlDecode(decodeURIComponent(m));
		maestro=datos;
		
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_moneda:maestro.id_moneda,
				m_id_depto:maestro.id_depto,
				m_gestion:maestro.desc_gestion,
				m_periodo:maestro.id_periodo,
				m_desc_usuario:maestro.desc_usuario,
				sw_debito_credito:maestro.sw_debito_credito,
				por_comprobante:maestro.por_comprobante,
				toda_gestion:maestro.toda_gestion,
				tipo_documento:maestro.tipo_documento,
				sw_totales:maestro.sw_totales
			}
		};
		//alert (maestro.vista);
		this.btnActualizar();
	};
	
	function iniciarEventosFormularios(){}
		
	function btn_reporte_libro_compras(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
		if (maestro.sw_totales == 'false'){
			if (maestro.por_comprobante!='false'){			
				window.open(direccion+'../../../control/documento/reporte/ActionPDFLibroComprasA.php?id_moneda='+maestro.id_moneda+'&txt_gestion='+maestro.desc_gestion+'&txt_desc_moneda='+maestro.desc_moneda+'&m_periodo='+maestro.id_periodo+'&sw_debito_credito='+maestro.sw_debito_credito+'&id_depto='+maestro.id_depto+'&codigo_depto='+maestro.codigo_depto+'&desc_periodo='+maestro.desc_periodo+'&desc_usuario='+maestro.desc_usuario+'&vista_reporte='+maestro.vista+'&por_comprobante='+maestro.por_comprobante+'&doc_id='+maestro.doc_id+'&m_gestion='+maestro.desc_gestion+'&id_usuario='+maestro.id_usuario+'&tipo_documento='+maestro.tipo_documento+'&toda_gestion='+maestro.toda_gestion);
	     	}
		}
	}
	
	function btn_reporte_libro_compras_jasper(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
		if (maestro.sw_totales == 'false'){
			window.open(direccion+'../../../control/documento/reporte/ActionPDFLibroComprasJasper.php?id_moneda='+maestro.id_moneda+
				'&txt_gestion='+maestro.desc_gestion+'&txt_desc_moneda='+maestro.desc_moneda+'&m_periodo='+maestro.id_periodo+
				'&sw_debito_credito='+maestro.sw_debito_credito+'&id_depto='+maestro.id_depto+'&codigo_depto='+maestro.codigo_depto+
				'&desc_periodo='+maestro.desc_periodo+'&desc_usuario='+maestro.desc_usuario+'&vista_reporte='+maestro.vista+
				'&por_comprobante='+maestro.por_comprobante+'&tipo_reporte='+maestro.tipo_reporte+'&desc_depto='+maestro.desc_depto+
				'&doc_id='+maestro.doc_id+'&desc_gestion='+maestro.desc_gestion+'&id_usuario='+maestro.id_usuario+
				'&tipo_documento='+maestro.tipo_documento+'&toda_gestion='+maestro.toda_gestion);
		}
	}
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_interfaz_siet_detalle.getLayout()};
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Libro de Compras/Ventas (pdf, xls, csv)',btn_reporte_libro_compras_jasper,true,'reporte_libro_compras_jasper','Reporte');
	//this.AdicionarBoton('../../../lib/imagenes/print.gif','Libro de Compras/Ventas x Comprobante',btn_reporte_libro_compras,true,'reporte_libro_compras','Por Cbte');
	
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_moneda:maestro.id_moneda,
			m_id_depto:maestro.id_depto,
			m_gestion:maestro.desc_gestion,
			m_periodo:maestro.id_periodo,
			m_desc_usuario:maestro.desc_usuario,
			sw_debito_credito:maestro.sw_debito_credito,
			por_comprobante:maestro.por_comprobante,
			toda_gestion:maestro.toda_gestion,
			tipo_documento:maestro.tipo_documento,
			sw_totales:maestro.sw_totales
		}
	});
	
	layout_interfaz_siet_detalle.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
