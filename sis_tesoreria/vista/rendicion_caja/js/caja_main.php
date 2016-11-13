<?php 
/**
 * Nombre:		  	    caja_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-21 09:30:44
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
    echo "var cajero='$cajero';";
	?>
var fa=false;
<?php if($_SESSION["ss_filtro_avanzado"]!='')
{echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>

var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,
				 TiempoEspera:_CP.getConfig().ss_tiempo_espera,
				 CantFiltros:1,
				 FiltroEstructura:false,
				 FiltroAvanzado:fa};
			
var elemento={pagina:new pagina_caja(idContenedor,direccion,paramConfig,cajero),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

//view added

/**
 * Nombre:		  	    pagina_caja.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-21 09:30:44
 */
function pagina_caja(idContenedor,direccion,paramConfig,cajero){
	var Atributos=new Array,sw=0;
	var componentes=new Array();
	
	var monedas_for=new Ext.form.MonedaField(
			{
				name:'importe',
				fieldLabel:'valor',	
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
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/caja/ActionListarCaja.php?cajero='+cajero}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_caja',totalRecords:'TotalCount'
		},[		
				'id_caja',
		'tipo_caja',
		'id_unidad_organizacional',
		'desc_unidad_organizacional',
		'id_moneda',
		'desc_moneda',
		'id_dosifica',
		'desc_dosifica',
		{name: 'fecha_inicio',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_cierre',type:'date',dateFormat:'Y-m-d'},
		'sw_factura',
		'importe_maximo',
		'porcentaje_compra',
		'porcentaje_rinde',
		'nro_recibo',
		'estado_caja',
		'id_partida_cuenta',
		'desc_parcta',
		'id_auxiliar',
		'desc_auxiliar',
		'id_fina_regi_prog_proy_acti',
		'epe',
		'id_depto',
		'nombre_depto',
		'codigo_caja'
		]),remoteSort:true});

	//DATA STORE COMBOS
		
	//FUNCIONES RENDER
	function render_id_unidad_organizacional(value, p, record){return String.format('{0}', record.data['desc_unidad_organizacional']);}
	
	function render_id_moneda(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
				
	function render_id_depto(value, p, record){return String.format('{0}', record.data['nombre_depto']);}

	function render_total(value,cell,record,row,colum,store){
		if(value < 0){return  '<span style="color:red;">' + monedas_for.formatMoneda(value)+'</span>'}	
		if(value >= 0){return monedas_for.formatMoneda(value)}
	}
	
	function render_tipo_caja(value){
		if(value==1){value='Caja' }
		if(value==2){value='Caja Chica' }
		if(value==3){value='Fondo Rotatorio' }
		
		return value
	}
	
	function render_estado_caja(value){
		if(value==1){value='Abierto' }
		if(value==2){value='Cerrado' }
		
		return value
	}
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	// hidden id_caja
	//en la posición 0 siempre esta la llave primaria
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_caja',
			fieldLabel:'ID',
			inputType:'hidden',
			align:'right',
			grid_visible:true,
			width_grid:60,
			grid_indice:-1
		},
		tipo: 'Field',
		filtro_0:true,
		save_as:'id_caja'
	};
	
	Atributos[1]={
		validacion:{
			name:'codigo_caja',
			fieldLabel:'Código Caja',
			allowBlank:true,
			maxLength:40,
			minLength:0,
			selectOnFocus:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:110,
			width:'100%',
			disabled:false,
			grid_indice:1					
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'codigo_caja',
		id_grupo:0
	};
	
	Atributos[2]={
		validacion:{
			name:'tipo_caja',
			fieldLabel:'Tipo Caja',
			grid_visible:true,
			renderer:render_tipo_caja,
			grid_editable:false,
			grid_indice:2
		},
		tipo:'Field',
		save_as:'tipo_caja',
		form: false,
		id_grupo:0
	};
		
	Atributos[3]={
		validacion:{
			name:'nombre_depto',
			fieldLabel:'Departamento de Tesorería',
			grid_visible:true,
			grid_editable:false,
			width_grid:220,
			grid_indice:3
		},
		tipo:'Field',
		form: false,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'DEP.nombre'
	};
	
	Atributos[4]={
		validacion:{
			name:'desc_unidad_organizacional',
			fieldLabel:'Unidad Organizacional',
			grid_visible:true,
			grid_editable:false,
			width_grid:300,
			grid_indice:4
		},
		tipo:'Field',
		form: false,
		filtro_0:true,
		filterColValue:'UNIORG.nombre_unidad'
	};
	
	Atributos[5]={
		validacion:{
			name:'desc_moneda',
			fieldLabel:'Moneda',
			grid_visible:true,
			grid_editable:false,
			width_grid:80		
		},
		tipo:'Field',
		form: false,
		filtro_0:true,
		filterColValue:'MONEDA.nombre'
	};
	
	Atributos[6]={
		validacion:{
			name:'importe_maximo',
			fieldLabel:'Importe Máximo',
			align:'right', 
			renderer: render_total,
			grid_visible:true,
			grid_editable:false,
			width_grid:100	
		},
		tipo:'NumberField',
		form:false,
		filtro_0:true,
		filterColValue:'CAJA.importe_maximo'
	};
	
	Atributos[7]={
		validacion:{
			name:'porcentaje_compra',
			fieldLabel:'% Compra',
			align:'right', 
			grid_visible:true,
			grid_editable:false,
			width_grid:100	
		},
		tipo: 'NumberField',
		form:false,
		filtro_0:true,
		filterColValue:'CAJA.porcentaje_compra'
	};

	Atributos[8]={
		validacion:{
			name:'porcentaje_rinde',
			fieldLabel:'% Rendición',
			align:'right', 
			grid_visible:true,
			grid_editable:false,
			width_grid:100	
		},
		tipo: 'NumberField',
		form:false,
		filtro_0:true,
		filterColValue:'CAJA.porcentaje_rinde'
	};
	
	Atributos[9]={
		validacion:{
			name:'estado_caja',
			fieldLabel:'Estado Caja',
			grid_visible:true,
			renderer:render_estado_caja,
			grid_editable:false
		},
		tipo:'Field',
		form:false
	};
		
			
	//---------- INICIAMOS LAYOUT DETALLE
	if (cajero==2){
		var config={titulo_maestro:'Cajas',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_tesoreria/vista/rendicion_documento/rendicion_documento.php'};
	}else{
 		var config={titulo_maestro:'Cajas',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_tesoreria/vista/rendicion_caja/rendicion.php'};		
	}
	
	var layout_caja=new DocsLayoutMaestroDeatalle(idContenedor);
	layout_caja.init(config);

	// INICIAMOS HERENCIA //
	this.pagina=Pagina;
	
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_caja,idContenedor);
	var cm_EnableSelect=this.EnableSelect;

	// DEFINICIÓN DE LA BARRA DE MENÚ//
	
	var paramMenu={
		actualizar:{crear:true,separador:false}
	};

	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
		
	//datos necesarios para el filtro
	var paramFunciones={
		Formulario:{
		html_apply:'dlgInfo-'+idContenedor,
		height:400,width:480,
		minWidth:150,minHeight:200,
		closable:true,titulo:'caja'
	}};
	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	//Para manejo de eventos
	function iniciarEventosFormularios(){//para iniciar eventos en el formulario
		
	}
	
	this.EnableSelect=function(sm,row,rec){
		cm_EnableSelect(sm,row,rec);
		datas_edit=rec.data;
		_CP.getPagina(layout_caja.getIdContentHijo()).pagina.desbloquearMenu()
		_CP.getPagina(layout_caja.getIdContentHijo()).pagina.reload(rec.data);		
	}	
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_caja.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			cajero:cajero
		}
	});
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_caja.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}