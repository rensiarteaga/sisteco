<?php
/**
 * Nombre:		  	    caracteristica_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-13 09:57:27
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


var maestro={id_solicitud_compra_det:<?echo $m_id_solicitud_compra_det;?>}

idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_caracteristica_min(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);


/**
 * Nombre:		  	    pagina_caracteristica_min.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-13 09:57:27
 */
function pagina_caracteristica_min(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var data1;
	var tituloM;
	var gridMaestro;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/caracteristica/ActionListarCaracteristica_det.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_caracteristica',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_caracteristica',
		'caracteristica',
		'descripcion',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_solicitud_compra_det',
		'desc_solicitud_compra_det',
		'id_item_propuesto',
		'desc_item_propuesto',
		'desc_servicio_propuesto',
		'id_servicio_propuesto'

		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_solicitud_compra_det:maestro.id_solicitud_compra_det 
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO
	 var ds_maestro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_adquisiciones/control/solicitud_compra_det/ActionListarSolicitudCompraDet_det.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_solicitud_compra_det',totalRecords: 'TotalCount'},['id_solicitud_comrpa_det','num_solicitud','tipo_adq','desc_empleado_tpm_frppa','desc_servicio','desc_item','descripcion'])
			});
	
	ds_maestro.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			filtro_id_solicitud_compra_det:maestro.id_solicitud_compra_det
			
		},
		callback:cargar_maestro
	});
	function cargar_maestro(r,options,success){
		
		if(ds_maestro.getAt(0).get('tipo_adq')=='Bien'){		
			data1=[['Nro Solicitud',ds_maestro.getAt(0).get('num_solicitud')],['Solicitante',ds_maestro.getAt(0).get('desc_empleado_tpm_frppa')],['Tipo Solicitud',ds_maestro.getAt(0).get('tipo_adq')],['Item',ds_maestro.getAt(0).get('desc_item')],['Descripcion',ds_maestro.getAt(0).get('descripcion')]];
		}
		else{
			data1=[['Nro Solicitud',ds_maestro.getAt(0).get('num_solicitud')],['Solicitante',ds_maestro.getAt(0).get('desc_empleado_tpm_frppa')],['Tipo Solicitud',ds_maestro.getAt(0).get('tipo_adq')],['Servicio',ds_maestro.getAt(0).get('desc_servicio')],['Descripcion',ds_maestro.getAt(0).get('descripcion')]];
		}
		gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data: data1}),cm:cmMaestro});
	gridMaestro.render();
	}
	
	
	
	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	
	//DATA STORE COMBOS

    var ds_solicitud_compra_det = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/solicitud_compra_det/ActionListarSolicitudCompraDet.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_solicitud_compra_det',totalRecords:'TotalCount'},['id_solicitud_compra_det','id_item_antiguo','cantidad','precio_referencial_estimado','fecha_reg','fecha_inicio_serv','fecha_fin_serv','descripcion','partida_presupuestaria','estado_reg','pac_verificado','id_solicitud_compra','id_tipo_servicio','id_item','monto_aprobado','mat_bajo_responsabilidad'])
	});

    /*var ds_item_propuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/item_propuesto/ActionListarItemPropuesto.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_item_propuesto',totalRecords:'TotalCount'},['id_item_propuesto','nombre','descripcion','costo_estimado','observaciones','estado_reg','fecha_reg','id_unidad_medida_base','id_proveedor','id_moneda','id_usuario'])
	});*/

	//FUNCIONES RENDER
	
	function render_id_solicitud_compra_det(value, p, record){return String.format('{0}', record.data['desc_solicitud_compra_det']);}
	var tpl_id_solicitud_compra_det=new Ext.Template('<div class="search-item">','<b><i>{descripcion}</i></b>','<br><FONT COLOR="#B5A642">{id_item}</FONT>','</div>');

	/*function render_id_item_propuesto(value, p, record){return String.format('{0}', record.data['desc_item_propuesto']);}
	var tpl_id_item_propuesto=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
*/
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// id_caracteristica
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_caracteristica',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_caracteristica'
	};
// txt caracteristica
	Atributos[1]={
		validacion:{
			name:'caracteristica',
			fieldLabel:'Caracteristica',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:200,
			width:'50%',
			disable:false,
			grid_indice:2
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'CARACT.caracteristica',
		save_as:'caracteristica'
	};
// txt descripcion
	Atributos[2]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripcion',
			allowBlank:false,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:200,
			width:'50%',
			disable:false,
			grid_indice:3
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'CARACT.descripcion',
		save_as:'descripcion'
	};
// txt fecha_reg
	Atributos[3]= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha registro',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:85,
			disabled:true,
			grid_indice:5
		},
		form:false,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'CARACT.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_reg'
	};
// txt id_solicitud_compra_det
	/*Atributos[4]={
			validacion:{
			name:'id_solicitud_compra_det',
			fieldLabel:'Solicitud Compra Detalle',
			allowBlank:true,			
			emptyText:'Solicitud Compra Detalle...',
			desc: 'desc_solicitud_compra_det', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_solicitud_compra_det,
			valueField: 'id_solicitud_compra_det',
			displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'',
			typeAhead:true,
			tpl:tpl_id_solicitud_compra_det,
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
			renderer:render_id_solicitud_compra_det,
			grid_visible:false,
			grid_editable:false,
			width_grid:200,
			disable:false,
			grid_indice:4
		},
		tipo:'ComboBox',
		form: false,
		filtro_0:true,
		filterColValue:'SOLDET.descripcion',
		save_as:'id_solicitud_compra_det'
	};*/
// txt id_item_propuesto
/*	Atributos[5]={
			validacion:{
			name:'id_item_propuesto',
			fieldLabel:'Item Propuesto',
			allowBlank:true,			
			emptyText:'Item Propuesto...',
			desc: 'desc_item_propuesto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_item_propuesto,
			valueField: 'id_item_propuesto',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'',
			typeAhead:true,
			tpl:tpl_id_item_propuesto,
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
			renderer:render_id_item_propuesto,
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			disable:false,
			grid_indice:6
		},
		tipo:'ComboBox',
		form: false,
		filtro_0:false,
		filterColValue:'IPROPU.nombre',
		save_as:'id_item_propuesto'
	};*/
// txt id_servicio_propuesto
	Atributos[4]={
		validacion:{
			name:'id_servicio_propuesto',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'id_servicio_propuesto'
	};
	
	// txt id_item_propuesto
	Atributos[5]={
		validacion:{
			name:'id_item_propuesto',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'id_item_propuesto'
	};

	
	// txt id_solicitud_compra_det
	Atributos[6]={
		validacion:{
			name:'id_solicitud_compra_det',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_solicitud_compra_det,
		save_as:'id_solicitud_compra_det'
	};
	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	
		tituloM='Solicitud Detalle';
	
	
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:tituloM,titulo_detalle:'Características (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_caracteristica_min = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_caracteristica_min.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_caracteristica_min,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	
	var paramFunciones={
	};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
	
	maestro.id_solicitud_compra_det=datos.m_id_solicitud_compra_det;
	
		ds_maestro.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			filtro_id_solicitud_compra_det:maestro.id_solicitud_compra_det
			
		},
		callback:function(r,options,success){
			
		
		if(ds_maestro.getAt(0).get('tipo_adq')=='Bien'){		
			gridMaestro.getDataSource().loadData([['Nro Solicitud',ds_maestro.getAt(0).get('num_solicitud')],['solicitante',ds_maestro.getAt(0).get('desc_empleado_tpm_frppa')],['Tipo Solicitud',ds_maestro.getAt(0).get('tipo_adq')],['Item',ds_maestro.getAt(0).get('desc_item')],['Descripcion',ds_maestro.getAt(0).get('descripcion')]]);
		}
		else{
			gridMaestro.getDataSource().loadData([['Nro Solicitud',ds_maestro.getAt(0).get('num_solicitud')],['solicitante',ds_maestro.getAt(0).get('desc_empleado_tpm_frppa')],['Tipo Solicitud',ds_maestro.getAt(0).get('tipo_adq')],['Servicio',ds_maestro.getAt(0).get('desc_servicio')],['Descripcion',ds_maestro.getAt(0).get('descripcion')]]);
		}
		}
		
	});

		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_solicitud_compra_det:maestro.id_solicitud_compra_det
			}
		};
		this.btnActualizar();
		gridMaestro.getDataSource().removeAll();
		
		
		Atributos[6].defecto=maestro.id_solicitud_compra_det
		
		this.InitFunciones(paramFunciones)
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_caracteristica_min.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_caracteristica_min.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}