<?php
/**
 * Nombre:		  	    detalle_partida_formulacion_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-07-18 11:04:06
 *
 */
session_start();


			
			
		//	echo 'tipo_vista'.$tipo_vista.'    $nombre_regional'.$nombre_regional.'  $nombre_programa'.$nombre_programa;
		//	exit;



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


var maestro={		
	
			/*id_presupuesto:decodeURIComponent('<?php echo utf8_decode($id_presupuesto);?>'),
	     	nombre_financiador:decodeURIComponent('<?php echo utf8_decode($nombre_financiador);?>'),
	     	nombre_regional:decodeURIComponent('<?php echo utf8_decode($nombre_regional);?>'),
	     	nombre_programa:decodeURIComponent('<?php echo utf8_decode($nombre_programa);?>'),
	     	nombre_proyecto:decodeURIComponent('<?php echo utf8_decode($nombre_proyecto);?>'),
	     	nombre_actividad:decodeURIComponent('<?php echo utf8_decode($nombre_actividad);?>'),
	     	desc_unidad_organizacional:decodeURIComponent('<?php echo utf8_decode($desc_unidad_organizacional);?>'),
			tipo_pres:decodeURIComponent('<?php echo utf8_decode($tipo_pres);?>'),
			desc_moneda:decodeURIComponent('<?php echo utf8_decode($desc_moneda);?>'),
			id_moneda:decodeURIComponent('<?php echo utf8_decode($id_moneda);?>')*/
			
			/*id_presupuesto:'<?php echo utf8_decode($id_presupuesto);?>',
			id_parametro:'<?php echo utf8_decode($id_parametro);?>',
	     	nombre_financiador:'<?php echo utf8_decode($nombre_financiador);?>',
	     	nombre_regional:'<?php echo utf8_decode($nombre_regional);?>',
	     	nombre_programa:'<?php echo utf8_decode($nombre_programa);?>',
	     	nombre_proyecto:'<?php echo utf8_decode($nombre_proyecto);?>',
	     	nombre_actividad:'<?php echo utf8_decode($nombre_actividad);?>',
	     	desc_unidad_organizacional:'<?php echo utf8_decode($desc_unidad_organizacional);?>',
			tipo_pres:'<?php echo utf8_decode($tipo_pres);?>',
			desc_moneda:'<?php echo utf8_decode($desc_moneda);?>',
			id_moneda:'<?php echo utf8_decode($id_moneda);?>',
			tipo_vista:'<?php echo utf8_decode($tipo_vista);?>'*/
	
	
	

	
			
			id_presupuesto:decodeURI('<?php echo ($id_presupuesto);?>'),
			id_parametro:decodeURI('<?php echo ($id_parametro);?>'),
	     	nombre_financiador:decodeURI('<?php echo ($nombre_financiador);?>'),
	     	nombre_regional:decodeURI('<?php echo ($nombre_regional);?>'),
	     	nombre_programa:decodeURI('<?php echo ($nombre_programa);?>'),
	     	nombre_proyecto:decodeURI('<?php echo ($nombre_proyecto);?>'),
	     	nombre_actividad:decodeURI('<?php echo ($nombre_actividad);?>'),
	     	desc_unidad_organizacional:decodeURI('<?php echo ($desc_unidad_organizacional);?>'),
			tipo_pres:decodeURI('<?php echo ($tipo_pres);?>'),
			desc_moneda:decodeURI('<?php echo ($desc_moneda);?>'),
			id_moneda:decodeURI('<?php echo ($id_moneda);?>'),
			tipo_vista:decodeURI('<?php echo ($tipo_vista);?>')
			
			
			
		/*		id_presupuesto:'<?php echo ($id_presupuesto);?>',
			id_parametro:'<?php echo ($id_parametro);?>',
	     	nombre_financiador:'<?php echo ($nombre_financiador);?>',
	     	nombre_regional:'<?php echo ($nombre_regional);?>',
	     	nombre_programa:'<?php echo ($nombre_programa);?>',
	     	nombre_proyecto:'<?php echo ($nombre_proyecto);?>',
	     	nombre_actividad:'<?php echo ($nombre_actividad);?>',
	     	desc_unidad_organizacional:'<?php echo ($desc_unidad_organizacional);?>',
			tipo_pres:'<?php echo ($tipo_pres);?>',
			desc_moneda:'<?php echo ($desc_moneda);?>',
			id_moneda:'<?php echo ($id_moneda);?>',
			tipo_vista:'<?php echo ($tipo_vista);?>'*/
			
			
			
			/*id_presupuesto:decodeURIComponent('<?php echo utf8_decode($id_presupuesto);?>'),
	     	nombre_financiador:decodeURIComponent('<?php echo utf8_decode($nombre_financiador);?>'),
	     	nombre_regional:decodeURIComponent('<?php echo utf8_decode($nombre_regional);?>'),
	     	nombre_programa:decodeURIComponent('<?php echo utf8_decode($nombre_programa);?>'),
	     	nombre_proyecto:decodeURIComponent('<?php echo utf8_decode($nombre_proyecto);?>'),
	     	nombre_actividad:decodeURIComponent('<?php echo utf8_decode($nombre_actividad);?>'),
	     	desc_unidad_organizacional:decodeURIComponent('<?php echo utf8_decode($desc_unidad_organizacional);?>'),
			tipo_pres:decodeURIComponent('<?php echo utf8_decode($tipo_pres);?>'),
			desc_moneda:decodeURIComponent('<?php echo utf8_decode($desc_moneda);?>'),
			id_moneda:decodeURIComponent('<?php echo utf8_decode($id_moneda);?>')
			*/
			
};

 
idContenedorPadre='<?php echo utf8_decode($idContenedorPadre);?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_detalle_presupuesto_vigente(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_detalle_partida_formulacion.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-07-18 11:04:06
 */
function pagina_detalle_presupuesto_vigente(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var componentes=new Array();
	
	var monedas_for=new Ext.form.MonedaField(
		{
		name:'mes_01',
		fieldLabel:'Enero',	
		allowBlank:false,
		align:'right', 
		maxLength:50,
		minLength:0,
		selectOnFocus:true,
		allowDecimals:false,
		decimalPrecision:0,
		allowNegative:false,
		minValue:0}	
	); 	
	
	var marcas_html,div_dlgFrm,dlgFrm;
	var Moneda,tipoReporte;
	var id_moneda_rep,tipoRep;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/presupuesto_vigente/ActionListarDetallePresupuestoVigente.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_partida_presupuesto',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_partida_detalle_modificacion',
		'codigo_partida',
		'nombre_partida',
		'desc_presupuesto',
		'id_partida_detalle',
		'mes_01',
		'mes_02',
		'mes_03',
		'mes_04',
		'mes_05',
		'mes_06',
		'mes_07',
		'mes_08',
		'mes_09',
		'mes_10',
		'mes_11',
		'mes_12',
		'total',
		'id_moneda',
		'id_partida_presupuesto',
		'id_partida_modificacion',
		'id_partida',
		'id_presupuesto',
		'estado'
		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			id_presupuesto:maestro.id_presupuesto,
			id_moneda:'1'
		}	
		
	});
	
	
	// DEFINICIÓN DATOS DEL MAESTRO
	function tabular(n)
	{ if (n>=0)	{return "  "+tabular(n-1)}
	else return "  "
	}

	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	var data_maestro=[ ['Presupuesto de ',maestro.tipo_pres+tabular(70-maestro.tipo_pres.length)],['Moneda',maestro.id_moneda+". "+maestro.desc_moneda+tabular(70-maestro.desc_moneda.length)],
					   ['Unidad ',maestro.desc_unidad_organizacional],['Programa',maestro.nombre_programa], //nombre_programa
					   ['Regional',maestro.nombre_regional ],['SubPrograma',maestro.nombre_proyecto],
					   ['Financiador',maestro.nombre_financiador],['Actividad',maestro.nombre_actividad]]; 
	
	//DATA STORE COMBOS
    var ds_partida = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/partida/ActionListarPartida.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_partida',totalRecords: 'TotalCount'},['id_partida','codigo_partida','nombre_partida','desc_partida','nivel_partida','sw_transaccional','tipo_partida','id_parametro','id_partida_padre','tipo_memoria','sw_movimiento'])
	});

    var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/presupuesto/ActionListarPresupuesto.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','fecha_presentacion','tipo_pres','estado_pres','id_unidad_organizacional','id_fuente_financiamiento','id_parametro','id_fina_regi_prog_proy_acti'])
	});

    var ds_partida_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/partida_presupuesto/ActionListarPartidaPresupuesto.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_partida_presupuesto',totalRecords: 'TotalCount'},['id_partida_presupuesto','codigo_formulario','fecha_elaboracion','id_partida','id_presupuesto'])
	});

    var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});	
	

	//FUNCIONES RENDER
	
	function render_id_partida(value, p, record){return String.format('{0}', record.data['desc_partida']);}
	var tpl_id_partida=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{nombre_partida}</FONT><br>','</div>');

	function render_id_presupuesto(value, p, record){return String.format('{0}', record.data['desc_presupuesto']);}
	var tpl_id_presupuesto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{}</FONT><br>','</div>');

	function render_id_partida_presupuesto(value, p, record){return String.format('{0}', record.data['desc_partida_presupuesto']);}
	var tpl_id_partida_presupuesto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{}</FONT><br>','</div>');

	function render_id_moneda(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');

	function renderTipoMemoria(value, p, record)
	{
		if(value == 1){return "Recursos"}
		if(value == 2){return "Gastos x Item"}
		if(value == 3){return "Inversión"}
		if(value == 4){return "Pasajes"}
		if(value == 5){return "Viajes"}
		if(value == 6){return "RRHH"}
		if(value == 7){return "Servicios"}
		if(value == 8){return "Otros Gastos"}
		if(value == 9){return "Combustibles"}
	}

	function render_moneda(value)
	{
		if(value == 1){return "Bolivianos"}
		if(value == 2){return "Dólares Americanos"}
		if(value == 3){return "Unidad de Fomento a la Vivienda"}
	}
	
	function renderSeparadorDeMil(value,cell,record,row,colum,store)
	{		
			return monedas_for.formatMoneda(value)		 
	}
	
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_partida_presupuesto
	//en la posición 0 siempre esta la llave primaria
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_partida_detalle_modificacion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_partida_detalle_modificacion',
		id_grupo:0
	};
	
	Atributos[1]={
		validacion:{
			name:'codigo_partida',
			fieldLabel:'Código',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:50,
			width:100,
			disabled:true		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'PARTID.codigo_partida',
		save_as:'codigo_partida',
		id_grupo:1
	};
	
	Atributos[2]={
		validacion:{
			name:'nombre_partida',
			fieldLabel:'Nombre Partida',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:100,
			disabled:true		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'PARTID.nombre_partida',
		save_as:'nombre_partida',
		id_grupo:1
	};
	
	// txt mes_01
	Atributos[3]={
		validacion:{
			name:'mes_01',
			fieldLabel:'Enero',
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
			grid_editable:true,
			//renderer: renderSeparadorDeMil,
			width_grid:80,//100
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PADEMO.mes_01',
		save_as:'mes_01',
		id_grupo:0
	};
	// txt mes_02
	Atributos[4]={
		validacion:{
			name:'mes_02',
			fieldLabel:'Febrero',
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
			grid_editable:true,
			//renderer: renderSeparadorDeMil,
			width_grid:80,
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PADEMO.mes_02',
		save_as:'mes_02',
		id_grupo:0
	};
	// txt mes_03
	Atributos[5]={
		validacion:{
			name:'mes_03',
			fieldLabel:'Marzo',
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
			grid_editable:true,
			//renderer: renderSeparadorDeMil,
			width_grid:80,
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PADEMO.mes_03',
		save_as:'mes_03',
		id_grupo:0
	};
	// txt mes_04
	Atributos[6]={
		validacion:{
			name:'mes_04',
			fieldLabel:'Abril',
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
			grid_editable:true,
			//renderer: renderSeparadorDeMil,
			width_grid:80,
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PADEMO.mes_04',
		save_as:'mes_04',
		id_grupo:0
	};
	// txt mes_05
	Atributos[7]={
		validacion:{
			name:'mes_05',
			fieldLabel:'Mayo',
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
			grid_editable:true,
			//renderer: renderSeparadorDeMil,
			width_grid:80,
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PADEMO.mes_05',
		save_as:'mes_05',
		id_grupo:0
	};
	// txt mes_06
	Atributos[8]={
		validacion:{
			name:'mes_06',
			fieldLabel:'Junio',
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
			grid_editable:true,
			//renderer: renderSeparadorDeMil,
			width_grid:80,
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PADEMO.mes_06',
		save_as:'mes_06',
		id_grupo:0
	};
	// txt mes_07
	Atributos[9]={
		validacion:{
			name:'mes_07',
			fieldLabel:'Julio',
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
			grid_editable:true,
			//renderer: renderSeparadorDeMil,
			width_grid:80,
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PADEMO.mes_07',
		save_as:'mes_07',
		id_grupo:0
	};
	// txt mes_08
	Atributos[10]={
		validacion:{
			name:'mes_08',
			fieldLabel:'Agosto',
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
			grid_editable:true,
			//renderer: renderSeparadorDeMil,
			width_grid:80,
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PADEMO.mes_08',
		save_as:'mes_08',
		id_grupo:0
	};
	
	// txt mes_09
	Atributos[11]={
		validacion:{
			name:'mes_09',
			fieldLabel:'Septiembre',
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
			grid_editable:true,
			//renderer: renderSeparadorDeMil,
			width_grid:80,
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PADEMO.mes_09',
		save_as:'mes_09',
		id_grupo:0
	};
	
	// txt mes_10
	Atributos[12]={
		validacion:{
			name:'mes_10',
			fieldLabel:'Octubre',
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
			grid_editable:true,
			//renderer: renderSeparadorDeMil,
			width_grid:80,
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PADEMO.mes_10',
		save_as:'mes_10',
		id_grupo:0
	};
	
	// txt mes_11
	Atributos[13]={
		validacion:{
			name:'mes_11',
			fieldLabel:'Noviembre',
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
			grid_editable:true,
			//renderer: renderSeparadorDeMil,
			width_grid:80,
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PADEMO.mes_11',
		save_as:'mes_11',
		id_grupo:0
	};
	
	// txt mes_12
	Atributos[14]={
		validacion:{
			name:'mes_12',
			fieldLabel:'Diciembre',
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
			grid_editable:true,
			//renderer: renderSeparadorDeMil,
			width_grid:80,
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PADEMO.mes_12',
		save_as:'mes_12',
		id_grupo:0
	};
	
	// txt total
	Atributos[15]={
		validacion:{
			name:'total',
			fieldLabel:'Total Partida',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:0,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			//renderer: renderSeparadorDeMil,
			width_grid:80,
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'PADEMO.total',
		save_as:'total',
		id_grupo:0
	};
	
	Atributos[16]={
		validacion:{
			labelSeparator:'',
			name: 'id_partida_presupuesto',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_partida_presupuesto',
		id_grupo:0
	};
	
	Atributos[17]={
		validacion:{
			labelSeparator:'',
			name: 'id_moneda',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_moneda',
		id_grupo:0
	};
	
	Atributos[18]={
		validacion:{
			labelSeparator:'',
			name: 'id_partida_modificacion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_partida_modificacion',
		id_grupo:0
	};
	
	Atributos[19]={
		validacion:{
			labelSeparator:'',
			name: 'id_partida',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_partida',
		id_grupo:0
	};
	
	Atributos[20]={
		validacion:{
			labelSeparator:'',
			name: 'id_presupuesto',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_presupuesto',
		id_grupo:0
	};
	
	Atributos[21]={
		validacion:{
			labelSeparator:'',
			name: 'estado',
			//inputType:'hidden',
			grid_visible:true, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'estado'
	};
	
	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Presupuesto (Maestro)',titulo_detalle:'Reformulación - Presupuesto vigente (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_detalle_presupuesto_vigente = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_detalle_presupuesto_vigente.init(config);
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_detalle_presupuesto_vigente,idContenedor);
	var CM_ocultarGrupo=this.ocultarGrupo;	
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_btnEdit=this.btnEdit;
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var cm_EnableSelect=this.EnableSelect;
	
	//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={
		guardar:{crear:true,separador:false},
		/*nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},*/
		actualizar:{crear:true,separador:false}
	};	
	
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	
	
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/partida_presupuesto/ActionEliminarDetallePartidaFormulacion.php',parametros:'&m_id_presupuesto='+maestro.id_presupuesto},
		Save:{url:direccion+'../../../control/presupuesto_vigente/ActionGuardarPresupuestoVigente.php',parametros:'&m_id_presupuesto='+maestro.id_presupuesto},
		ConfirmSave:{url:direccion+'../../../control/presupuesto_vigente/ActionGuardarPresupuestoVigente.php',parametros:'&m_id_presupuesto='+maestro.id_presupuesto},
			
		Formulario:{
			html_apply:'dlgInfo-'+idContenedor,
			columnas:['95%'],
			grupos:[
				{tituloGrupo:'Oculto',columna:0,id_grupo:0},
				{tituloGrupo:'Datos',columna:0,id_grupo:1}		
			],
			height:300,		//altura
			width:500,		//anchura
			minHeight:200,	//altura
			minWidth:150,	//anchura	
			closable:true,
			titulo:'Justificación por Partida'			
		}
	};
	
	this.EnableSelect=function(sm,row,rec)
	{
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		enable(sm,row,rec);
	}
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params)
	{
		var datos=Ext.urlDecode(decodeURIComponent(unescape(params)));
		maestro.id_presupuesto=datos.m_id_presupuesto;
		maestro.id_parametro=datos.m_id_parametro;
		maestro.nombre_financiador=datos.m_nombre_financiador;
		maestro.nombre_regional=datos.m_nombre_regional;
		maestro.nombre_programa=datos.m_nombre_programa;
		maestro.nombre_proyecto=datos.m_nombre_proyecto;
		maestro.nombre_actividad=datos.m_nombre_actividad;
	 	maestro.desc_moneda=datos.m_desc_moneda;
	 	maestro.tipo_pres=datos.m_tipo_pres;
	 	maestro.desc_unidad_organizacional=datos.m_desc_unidad_organizacional;
		maestro.id_moneda=datos.m_id_moneda;
		maestro.tipo_vista=datos.m_tipo_vista;

		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				 id_presupuesto:maestro.id_presupuesto,
				 id_moneda:'1'
			}
		};
		prueba.setValue(maestro.id_moneda);
		
		this.btnActualizar();		
		data_maestro=[ ['Presupuesto de ',maestro.tipo_pres+tabular(70-maestro.tipo_pres.length)],['Moneda',maestro.id_moneda+". "+maestro.desc_moneda+tabular(70-maestro.desc_moneda.length)],
					   ['Unidad ',maestro.desc_unidad_organizacional],['Programa',maestro.nombre_programa], //nombre_programa
					   ['Regional',maestro.nombre_regional ],['SubPrograma',maestro.nombre_proyecto],
					   ['Financiador',maestro.nombre_financiador],['Actividad',maestro.nombre_actividad]];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		Atributos[3].defecto=maestro.id_presupuesto;

		paramFunciones.btnEliminar.parametros='&m_id_presupuesto='+maestro.id_presupuesto;
		paramFunciones.Save.parametros='&m_id_presupuesto='+maestro.id_presupuesto;
		paramFunciones.ConfirmSave.parametros='&m_id_presupuesto='+maestro.id_presupuesto;
		this.InitFunciones(paramFunciones)
				
	};
	
	this.btnEdit = function()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect!=0)
		{						
			CM_ocultarGrupo('Oculto');	
			CM_mostrarGrupo('Datos');			
			CM_btnEdit();			
		}
		else
		{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un registro.');
		}				
	}
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	}
	
	var prueba=new Ext.form.ComboBox({
			store: ds_moneda,
			displayField:'nombre',
			typeAhead: true,
			mode: 'local',
			triggerAction: 'all',
			emptyText:'Seleccionar moneda...',
			selectOnFocus:true,
			width:135,
			valueField: 'id_moneda',
			editable:false,
			tpl:tpl_id_moneda			
		});

	var sw=1;
		
	ds_moneda.load({
			params:{
				start:0,
				limit: 1000000
			}
		}
	);
	
	ds_moneda.on('load',function(e,w)
	{
		if(sw==1)
		{			
			sw=0; 
			prueba.setValue(1)
	   	}
	});
	
	prueba.on('select',
		function(){		
			
			ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros: paramConfig.CantFiltros,
				 id_presupuesto: maestro.id_presupuesto,
				 id_moneda: prueba.getValue()
			}
		};	
		data_maestro=[ ['Presupuesto de ',maestro.tipo_pres+tabular(70-maestro.tipo_pres.length)],['Moneda',prueba.getValue()+". "+render_moneda(prueba.getValue())+tabular(70-maestro.desc_moneda.length)],
					   ['Unidad ',maestro.desc_unidad_organizacional],['Programa',maestro.nombre_programa], //nombre_programa
					   ['Regional',maestro.nombre_regional ],['SubPrograma',maestro.nombre_proyecto],
					   ['Financiador',maestro.nombre_financiador],['Actividad',maestro.nombre_actividad]];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		ClaseMadre_btnActualizar()		
	});	
	
	
	function salta(){
		ContenedorPrincipal.getPagina(idContenedorPadre).pagina.btnActualizar();
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_detalle_presupuesto_vigente.getLayout()};
	//para el manejo de hijos
	
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);		
	
	//codigo para bloquear los botones de modificacion dependiendo del estado del presupuesto

	var CM_getBoton=this.getBoton;	
	
	this.InitFunciones(paramFunciones);
	
	this.AdicionarBotonCombo(prueba,'prueba');		//Adicionamos un combo para filtrar por moneda
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	
	function enable(sm,row,rec)
	{		
		cm_EnableSelect(sm,row,rec);
		//alert(rec.data.estado)
		
		if(rec.data.estado == 'concluido')//Borrador
		{
			CM_getBoton('guardar-'+idContenedor).disable();					
		}
		else
		{
			CM_getBoton('guardar-'+idContenedor).enable();
		}
	}
	
	//crearDialogMoneda();
	layout_detalle_presupuesto_vigente.getLayout().addListener('layout',this.onResize);
	layout_detalle_presupuesto_vigente.getVentana(idContenedor).on('resize',function(){layout_detalle_presupuesto_vigente.getLayout().layout()})

	layout_detalle_presupuesto_vigente.getVentana().addListener('beforehide',salta)
}