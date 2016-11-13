<?php
/**
 * Nombre:		  	    solicitud_compra_serv_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-16 09:53:33
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
var maestro={mi_gestion:<?php echo $mi_gestion;?>,id_solicitud_compra:<?php echo $m_id_solicitud_compra;?>,num_solicitud:<?php echo $m_num_solicitud;?>, localidad:'<?php echo $m_localidad;?>',solicitante:'<?php echo $m_solicitante;?>',id_tipo_adq:'<?php echo $m_id_tipo_adq;?>',tipo_adq:'<?php echo $m_tipo_adq;?>',simbolo:'<?php echo $m_simbolo;?>',fecha_reg:'<?php echo $m_fecha_reg;?>',tipo_cambio:'<?php echo $m_tipo_cambio;?>',id_moneda:'<?php echo $m_id_moneda;?>',id_moneda_base:'<?php echo $m_id_moneda_base;?>',id_empresa:<?php echo $_SESSION['ss_id_empresa'];?>,avance:'<?php echo $m_avance;?>',es_item:<?php echo $es_item;?>};
//
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_solicitud_compra_serv_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);


/**
 * Nombre:		  	    pagina_solicitud_compra_det_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-16 09:53:33
 */
function pagina_solicitud_compra_serv_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var data1;
	var tituloM;
	var gestion;
	var nombreEtiquetaTipo, nombreEtiquetaItem, mostrarGrid, unidadMedida;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/solicitud_compra_det/ActionListarSolicitudCompraDet_det.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_solicitud_compra_det',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_solicitud_compra_det',
		'cantidad',
		'precio_referencial_estimado',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_inicio_serv',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_fin_serv',type:'date',dateFormat:'Y-m-d'},
		'descripcion',
		'estado_reg',
		'id_solicitud_compra',
		'desc_solicitud_compra',
		'id_item','desc_item','item',
		'id_servicio',
		'desc_servicio',
		'tipo_servicio','precio_referencial_moneda_seleccionada',
		'abreviatura',
		'id_unidad_medida_base',
		'precio_total_moneda_seleccionada',
		'precio_total_referencial',
		'especificaciones_tecnicas','id_cuenta','desc_cuenta','id_partida','codigo_partida','precio_referencial_total_as','total_gestion','gestion'
		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_solicitud_compra:maestro.id_solicitud_compra,
			m_tipo_adq:maestro.tipo_adq,
			id_empresa:maestro.id_empresa,
			gestion:maestro.mi_gestion
			
		}
	});
	
	// DEFINICIÓN DATOS DEL MAESTRO

var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor},true);
		Ext.DomHelper.applyStyles(div_grid_detalle,"background-color:#FFFFFF");

	//DATA STORE COMBOS

//  
    var ds_servicio = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/servicio/ActionListarServicio_det.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_servicio',totalRecords:'TotalCount'},['id_servicio','nombre','descripcion','fecha_reg','id_tipo_servicio','desc_tipo_servicio'])
	});

   if(maestro.id_tipo_adq==4){
	   unidadMedida='%';
   }else{
		unidadMedida='Servicios';
	}
	   
	   

	
	var ds_unid_med_bas=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/unidad_medida_base/ActionListarUnidadMedidaBase_det.php?tipo_unidad_medida_nombre='+unidadMedida}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_medida_base',totalRecords:'TotalCount'},['id_unidad_medida_base','nombre','abreviatura'])
	});
   
//	var ds_tipo_servicio = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_servicio/ActionListarTipoServicio_det.php'}),
//			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_servicio',totalRecords:'TotalCount'},['id_tipo_servicio','nombre','descripcion','fecha_reg','id_tipo_adq','desc_tipo_adq'])
//	});

	//FUNCIONES RENDER
	function renderUnidMedBas(value,p,record){return String.format('{0}',record.data['abreviatura'])}
	function render_id_servicio(value, p, record){return String.format('{0}', record.data['desc_servicio']);}
	var tpl_id_servicio=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
	var resultTplUniMed=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abreviatura: </b>{abreviatura}</FONT>','</div>');

//	function render_id_tipo_servicio(value, p, record){return String.format('{0}', record.data['tipo_servicio']);}
//	var tpl_id_tipo_servicio=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');


	 var ds_item = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../sis_almacenes/control/item/ActionListarItem.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_item',totalRecords:'TotalCount'},['id_item','codigo','nombre','descripcion','precio_venta_almacen','costo_estimado','stock_min','observaciones','nivel_convertido','estado_registro','fecha_reg','id_unidad_medida_base','id_id3','id_id2','id_id1','id_subgrupo','id_grupo','id_supergrupo','peso_kg','mat_bajo_responsabilidad'])
			});

			//FUNCIONES RENDER

			function render_id_item(value, p, record){return String.format('{0}', record.data['desc_item']);}

	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_solicitud_compra_det
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_solicitud_compra_det',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_solicitud_compra_det',
		id_grupo:0
	};
	
	
	
    Atributos[1]={
		validacion:{
			name:'tipo_servicio',
			fieldLabel:'Tipo Compra',
			allowBlank:false,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:1
		},
		tipo: 'TextField',
		form: false,
		filtro_0:true,
		filterColValue:'TIPSER.nombre',
		id_grupo:0
	};


  
    
	filterCols_servicio=new Array();
	filterValues_servicio=new Array();
	Atributos[2]={
		validacion:{
			name:'id_servicio',
			desc:'desc_servicio',
			fieldLabel:'Item/Servicio',
			allowBlank:false,
			maxLength:200,
			minLength:0,
			store:ds_servicio,
			renderer:render_id_servicio,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true,
			grid_editable:false,
			width_grid:90,
			width:200,
			pageSize:10,
			direccion:direccion,
			filterCols:filterCols_servicio,
			filterValues:filterValues_servicio,
			grid_indice:2
			},
		tipo:'LovServicio',
		save_as:'id_servicio',
		filtro_0:true,
		defecto:'',
		filterColValue:'SERVIC.codigo#SERVIC.nombre',
		id_grupo:1
	};

   


	// txt id_item
	Atributos[3]={
		validacion:{
			name:'id_item',
			desc:'desc_item',
			fieldLabel:'Código Item',
			allowBlank:false,
			maxLength:500,
			minLength:0,
			store:ds_item,
			valueField: 'id_item',
			displayField: 'descripcion',
			renderer:render_id_item,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true,
			grid_editable:false,
			width_grid:90,
			width:200,
			pageSize:10,
			direccion:direccion,

			grid_indice:1
		},
		tipo:'LovItemsAlm',
		save_as:'id_item',
		filtro_0:true,
		defecto:'',
		filterColValue:'ITTEM.codigo#ITTEM.nombre',
		id_grupo:1
	};
  
	//-----unidad medida
	Atributos[4]={
			validacion:{
				name:'item',
				fieldLabel:'Item',
				allowBlank:false,
				maxLength:500,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				
				grid_indice:2
			},
			tipo: 'TextField',
			form: false,
			filterColValue:'ITTEM.codigo#ITTEM.nombre',
			filtro_0:true,
			id_grupo:1
		};
	
	Atributos[5]={
		validacion:{
			fieldLabel:'Unidad Medida',
			allowBlank:true,
			vtype:"texto",
			emptyText:'Unidad Medida...',
			name:'id_unidad_medida_base',
			desc:'abreviatura',
			store:ds_unid_med_bas,
			valueField:'id_unidad_medida_base',
			displayField:'nombre',
			filterCol:'UNMEDB.nombre#UNMEDB.abreviatura',
			typeAhead:false,
			forceSelection:false,
			tpl:resultTplUniMed,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:200,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer:renderUnidMedBas,
			grid_visible:true,
			grid_editable:false,
			width_grid:80,
			width:200,
			grid_indice:3
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'umb.nombre',
		id_grupo:1
	};



	
	// txt fecha_inicio_serv
	
	
	
	
	
// txt cantidad
	Atributos[6]={
		validacion:{
			name:'cantidad',
			fieldLabel:'Cantidad',
			allowBlank:false,
			maxLength:10,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:0,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			align:'right',
			grid_visible:true,
			grid_editable:false,
			width_grid:75,
			width:'62%',
			disable:false,
			grid_indice:5
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'SOLDET.cantidad',
		id_grupo:2,
		save_as:'cantidad'
	};
 
	

	
	Atributos[7]={
		validacion:{
			name:'precio_referencial_moneda_seleccionada',
			fieldLabel:'Precio Unitario',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			align:'right',
			decimalPrecision:4,//para numeros float
			width_grid:90,
			width:'62%',
			disabled:false,
			grid_indice:8
		},
		tipo: 'NumberField',
		filtro_0:false,
		filterColValue:'SOLDET.precio_referencial_estimado',
		filtro_0:false,
		id_grupo:2
	};
	
	
	Atributos[8]={
		validacion:{
			name:'precio_total_moneda_seleccionada',
			fieldLabel:'Precio Total',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			decimalPrecision:2,//para numeros float
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:40,
			width:'62%',
			align:'right',
			disabled:true,
			grid_indice:9
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		id_grupo:2
	};
	
	
	Atributos[9]={
		validacion:{
			name:'precio_referencial_total_as',
			fieldLabel:'Precio Total Gestion Siguiente',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:95,
			align:'right',
			width:'40%',
			disabled:false
			
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'SOLDET.precio_referencial_total_as',
		
		id_grupo:2
	};
	
	
	Atributos[10]={
		validacion:{
			name:'total_gestion',
			fieldLabel:'Precio Total Gestion Vigente',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			allowNegative:false,
			minValue:0.1,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:95,
			align:'right',
			width:'40%',
			disabled:true
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		id_grupo:2
	};
	
	
		Atributos[11]={
		validacion:{
			name:'especificaciones_tecnicas',
			fieldLabel:'Especificaciones Tecnicas',
			allowBlank:false,
			//maxLength:500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:160,
			width:'100%',
			disabled:false,
			grid_indice:2
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'SOLDET.especificaciones_tecnicas',
		save_as:'especificaciones_tecnicas',
		id_grupo:2
	};
	
	
	
	Atributos[12]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripcion',
			allowBlank:true,
			//maxLength:500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:10
		},
		tipo: 'TextArea',
		form: false,
		filtro_0:false,
		
		save_as:'descripcion',
		id_grupo:2
	};
	
// txt precio_referencial_estimado
	Atributos[13]={
		validacion:{
			name:'precio_referencial_estimado',
			fieldLabel:'Precio Unitario',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:6,//para numeros float
			allowNegative:false,
			minValue:0.1,
			vtype:'texto',
			grid_visible:false,
			grid_editable:true,
			width_grid:95,
			align:'right',
			width:'40%',
			disable:false,
			grid_indice:6
		},
		tipo: 'NumberField',
		form: false,
		filtro_0:false,
		filterColValue:'SOLDET.precio_referencial_estimado',
		save_as:'precio_referencial_estimado',
		id_grupo:2
	};
	
 
	Atributos[14]={
		validacion:{
			name:'precio_total_referencial',
			fieldLabel:'Precio Total',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			decimalPrecision:2,//para numeros float
			width_grid:80,
			width:'40%',
			align:'right',
			disabled:true,
			grid_indice:7
		},
		tipo: 'NumberField',
		form: false,
		filtro_0:false,
		id_grupo:2
	};
	
	
	
// txt id_solicitud_compra
	Atributos[15]={
		validacion:{
			name:'id_solicitud_compra',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_solicitud_compra,
		save_as:'id_solicitud_compra'
	};
	


	
	Atributos[16]={
		validacion:{
			name:'id_cuenta',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
	tipo:'Field',
	filtro_0:false,
	save_as:'id_cuenta'
	};
	
	
	Atributos[17]={
		validacion:{
			name:'id_partida',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'id_partida'
	};
	
	Atributos[18]={
		validacion:{
			name:'desc_cuenta',
			fieldLabel:'Cuenta',
			allowBlank:true,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false,
			grid_indice:11
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'CUENTA.desc_cuenta#CUENTA.nombre_cuenta',
		save_as:'desc_cuenta',
		id_grupo:0
	};
	
	
	Atributos[19]={
		validacion:{
			name:'codigo_partida',
			fieldLabel:'Partida',
			allowBlank:true,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false,
			grid_indice:12
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'PARTID.codigo_partida#PARTID.nombre_partida',
		save_as:'codigo_partida',
		id_grupo:0
	};
	

	Atributos[20]= {
			validacion:{
				name:'fecha_inicio_serv',
				fieldLabel:'Fecha Inicio',
				allowBlank:true,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Día no válido',
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width_grid:100,
				disabled:false,
				align:'center',
				//grid_indice:4,
				width:200
			},
			form:true,
			tipo:'DateField',
			filtro_0:true,
			filterColValue:'SOLDET.fecha_inicio_serv',
			dateFormat:'m-d-Y',
			defecto:'',
			save_as:'fecha_inicio_serv',
			id_grupo:1
		};
		
		
		// txt fecha_fin_serv
		Atributos[21]= {
			validacion:{
				name:'fecha_fin_serv',
				fieldLabel:'Fecha Fin',
				allowBlank:true,
				format: 'd/m/Y', //formato para validacion
				disabledDaysText: 'Día no válido',
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				
				width_grid:92,
				width:200,
				disabled:false,
				align:'center'
				//grid_indice:4
			},
			form:true,
			tipo:'DateField',
			filtro_0:true,
			filterColValue:'SOLDET.fecha_fin_serv',
			dateFormat:'m-d-Y',
			defecto:'',
			save_as:'fecha_fin_serv',
			id_grupo:1
		};
	

	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
    
	function formatBoolean(value){
        if(value=="true"){
        	return "si";
        }else{
        	return "no";
        }
    };
     tituloM='Solicitud Detalle';
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Solicitud Compra (Maestro)',titulo_detalle:'Detalle de Solicitud (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_solicitud_compra_serv_det = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_solicitud_compra_serv_det.init(config);
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_solicitud_compra_serv_det,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var getGrid=this.getGrid;
	var Cm_conexionFailure=this.conexionFailure;
	var EstehtmlMaestro=this.htmlMaestro;
	var CM_getColumnNum=this.getColumnNum;
	var CM_getColumnModel=this.getColumnModel;
	var getGrid=this.getGrid;
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/solicitud_compra_det/ActionEliminarSolicitudCompraDet.php',parametros:'&m_id_solicitud_compra='+maestro.id_solicitud_compra},
	Save:{url:direccion+'../../../control/solicitud_compra_det/ActionGuardarSolicitudCompraDet.php',parametros:'&m_id_solicitud_compra='+maestro.id_solicitud_compra},
	ConfirmSave:{url:direccion+'../../../control/solicitud_compra_det/ActionGuardarSolicitudCompraDet.php',parametros:'&m_id_solicitud_compra='+maestro.id_solicitud_compra},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Detalle de Solicitud',
	
	grupos:[{tituloGrupo:'Oculto',
			columna:0,
			id_grupo:0
			},{
				tituloGrupo:'Pedido',
				columna:0,
				id_grupo:1
			},{
				tituloGrupo:'Datos Pedido',
				columna:0,
				id_grupo:2
			},
			
			{
				tituloGrupo:'Informacion Presupuestaria',
				columna:0,
				id_grupo:3
			}
			]
	
	}};

		
	var ds_maestro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_adquisiciones/control/solicitud_compra/ActionListarSolicitudCompra.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_solicitud_compra',totalRecords: 'TotalCount'},['id_solicitud_compra',
		'observaciones',
		'localidad',
		'num_solicitud',
		'desc_tipo_categoria_adq',
		'solicitante',
		'id_moneda',
		'desc_moneda',
		'periodo',
		'gestion','tipo_adq','desc_tipo_adq'
		])
		});

		ds_maestro.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_solicitud_compra:maestro.id_solicitud_compra

			},
			callback:cargar_maestro
		});

		function cargar_maestro(){
			data1=[['Nro Solicitud',ds_maestro.getAt(0).get('num_solicitud')],['Solicitante',ds_maestro.getAt(0).get('solicitante')],['Tipo Solicitud',ds_maestro.getAt(0).get('tipo_adq')],['Descripcion',ds_maestro.getAt(0).get('observaciones')],['Tipo de Adquisicion',ds_maestro.getAt(0).get('desc_tipo_adq')],['Moneda',ds_maestro.getAt(0).get('desc_moneda')]];
			Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data1));
		}
	
	
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		
		var datos=Ext.urlDecode(decodeURIComponent(params));
		
		maestro.id_solicitud_compra=datos.m_id_solicitud_compra;
		maestro.num_solicitud=datos.m_num_solicitud;
		maestro.localidad=datos.m_localidad;
		maestro.id_tipo_adq=datos.m_id_tipo_adq;
		maestro.solicitante=datos.m_solicitante;
		maestro.tipo_adq=datos.m_tipo_adq;
		maestro.simbolo=datos.m_simbolo;
		maestro.fecha_reg=datos.m_fecha_reg;
		maestro.tipo_cambio=datos.m_tipo_cambio;
		maestro.id_moneda=datos.m_id_moneda;
		maestro.id_moneda_base=datos.m_id_moneda_base;
		
		maestro.mi_gestion=datos.mi_gestion;
		maestro.es_item=datos.es_item;
		ds_maestro.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					m_id_solicitud_compra:maestro.id_solicitud_compra

				},
				callback:cargar_maestro
			});
			
		
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_solicitud_compra:maestro.id_solicitud_compra,
				m_tipo_adq:maestro.tipo_adq,
				m_simbolo:maestro.simbolo,
				id_empresa:maestro.id_empresa,
				mi_gestion:maestro.mi_gestion,
				es_item:maestro.es_item
			}
		};

		 if( maestro.id_tipo_adq==4){
			   unidadMedida='%'; 
		   }else{
				unidadMedida='Servicios'; 
			}

		 ds_unid_med_bas.baseParams={
		   tipo_unidad_medida_nombre:unidadMedida
		}
		 ds_unid_med_bas.modificado=true;
		
		var serv =getComponente('id_servicio');
		getComponente('id_servicio').filterCols[0] = 'servic.id_tipo_adq';
		getComponente('id_servicio').filterValues[0] = maestro.id_tipo_adq;
		getComponente('id_servicio').filterCols[1] = 'servic.estado';
		getComponente('id_servicio').modificado = true;
		getComponente('id_servicio').filterValues[1] ='activo';
		getComponente('id_servicio').modificado = true;
		this.btnActualizar();
		iniciarEventosFormularios();

		Atributos[15].defecto=maestro.id_solicitud_compra;

		
		
		paramFunciones.btnEliminar.parametros='&m_id_solicitud_compra='+maestro.id_solicitud_compra;
		paramFunciones.Save.parametros='&m_id_solicitud_compra='+maestro.id_solicitud_compra;
		paramFunciones.ConfirmSave.parametros='&m_id_solicitud_compra='+maestro.id_solicitud_compra;
		this.InitFunciones(paramFunciones)
	};
	
	

	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
		cm=CM_getColumnModel();
		
	    filterValues_servicio[0]='%';
	    filterValues_servicio[1]='%';

		//txt_precio= getComponente('precio_referencial_estimado');
		txt_cantidad=getComponente('cantidad');
		//txt_costo_total=getComponente('precio_total_referencial');
		txt_precio_referencial_moneda_seleccionada=getComponente('precio_referencial_moneda_seleccionada');
		txt_precio_total_moneda_seleccionada=getComponente('precio_total_moneda_seleccionada');
		txt_id_servicio=getComponente('id_servicio');
		txt_total_gestion_as=getComponente('precio_referencial_total_as');
		
		txt_fecha_inicio=getComponente('fecha_inicio_serv');
		txt_fecha_fin=getComponente('fecha_fin_serv');
				
				
		txt_lim_sup_fecha=getComponente('fecha_fin_serv');
		txt_lim_inf_fecha=getComponente('fecha_inicio_serv');

	
		
		
	   filterCols_servicio[0]='servicio.id_tipo_adq';
	   filterValues_servicio[0]=maestro.id_tipo_adq;
	   filterCols_servicio[1]='servicio.estado';
	   filterValues_servicio[1]='activo';
	

	var CalcularCostoTotal = function(e) {
			
		    //if(maestro.id_moneda==maestro.id_moneda_base){
			 // var unit = txt_precio.getValue();
		    //}else{
		    	var unit=txt_precio_referencial_moneda_seleccionada.getValue();
			    txt_precio_referencial_moneda_seleccionada.setValue(unit);
		   // }
			var cant = txt_cantidad.getValue();

			if(unit!=undefined && unit!=null && cant!=undefined && cant!=null)
			{
				txt_precio_total_moneda_seleccionada.setValue(unit*cant);
				//txt_precio_total_moneda_seleccionada.setValue(unit*cant);
				if(txt_total_gestion_as!=undefined && txt_total_gestion_as!=null){
				
					getComponente('total_gestion').setValue(txt_precio_total_moneda_seleccionada.getValue()-txt_total_gestion_as.getValue());
				}else{
					getComponente('total_gestion').setValue(txt_precio_total_moneda_seleccionada.getValue());
				}
			}
			else
			{
				txt_precio_total_moneda_seleccionada.setValue('0');
				getComponente('total_gestion').setValue(txt_precio_total_moneda_seleccionada.getValue());
				//txt_precio_total_moneda_seleccionada.setValue('0');
			}
		};
		
		
	var onFecha=function(e){
	    
	    txt_fecha_fin.modificado=true;
		txt_fecha_fin.purgeListeners();
		txt_fecha_fin.isDirty();
		txt_fecha_fin.reset();
		if(txt_fecha_inicio.getValue()!=''){
		    
			txt_fecha_fin.enable();
			//txt_fecha_fin.modificado=true;
	
			txt_fecha_fin.minValue=txt_fecha_inicio.getValue();
			txt_fecha_fin.modificado=true;
			//txt_fecha_fin.setValue(txt_fecha_inicio.getValue().dateFormat('d/m/Y'));
			
		}
	};
	
	txt_fecha_inicio.on ('blur',onFecha);
		
		txt_cantidad.on('blur',CalcularCostoTotal);
	 	txt_precio_referencial_moneda_seleccionada.on('blur',CalcularCostoTotal);

	 	
	 	
		var onTotalGestion=function(e){
	 	    
		    if(parseFloat(txt_precio_total_moneda_seleccionada.getValue())>0){
		        getComponente('total_gestion').setValue(txt_precio_total_moneda_seleccionada.getValue()-txt_total_gestion_as.getValue());
		        if(parseFloat(getComponente('total_gestion').getValue())<0){
		        	
		        	//getComponente('total_gestion').setValue(0);
		        	 txt_precio_referencial_moneda_seleccionada.setValue(txt_total_gestion_as.getValue()/txt_cantidad.getValue());
		        	 txt_precio_total_moneda_seleccionada.setValue(txt_precio_referencial_moneda_seleccionada.getValue()* txt_cantidad.getValue());
		        	 getComponente('total_gestion').setValue(txt_precio_total_moneda_seleccionada.getValue()-txt_total_gestion_as.getValue());
		        }
		    }
		}
		txt_total_gestion_as.on('blur',onTotalGestion);
	 	
	 	if(maestro.es_item==1){ 
				    hideColumns([[CM_getColumnNum('id_servicio'),true]]);
			        hideColumns([[CM_getColumnNum('id_item'),false]]);
			    }else{ 
					hideColumns([[CM_getColumnNum('id_item'),true]]);
					hideColumns([[CM_getColumnNum('id_servicio'),false]]);
				}
    
	}



	function hideColumns(colIndexes){
		cm.totalWidth = null;
		grid=getGrid();
		vista_grid=grid.getView();
		for(var i=0;i<colIndexes.length;i++){
			cm.config[colIndexes[i][0]].hidden = colIndexes[i][1];
			
	        var cid = vista_grid.getColumnId(colIndexes[i][0]);
	        
	        if(colIndexes[i][1]){
	        	vista_grid.css.updateRule(vista_grid.tdSelector+cid, "display", "none");
	        	vista_grid.css.updateRule(vista_grid.splitSelector+cid, "display", "none");
	        }
	        else{
	        	vista_grid.css.updateRule(vista_grid.tdSelector+cid, "display", "");
	        	vista_grid.css.updateRule(vista_grid.splitSelector+cid, "display", "");
	        }
	        
		}
        if(Ext.isSafari){
            vista_grid.updateHeaders();
        }
        vista_grid.updateSplitters();
        vista_grid.layout();
    }

	

	
	this.btnNew=function(){
	
	    CM_ocultarGrupo('Oculto');
		CM_ocultarGrupo('Informacion Presupuestaria');
		CM_mostrarComponente(getComponente('precio_referencial_total_as'));
		CM_mostrarComponente(getComponente('total_gestion'));
		

		if(maestro.es_item==1){
			

			CM_ocultarComponente(getComponente('id_servicio'));
			
			CM_mostrarComponente(getComponente('id_item'));
			

			
			getComponente('id_servicio').allowBlank=true;
			getComponente('id_item').allowBlank=false;
			
			
		}else{
			
			
			CM_ocultarComponente(getComponente('id_item'));
			
			CM_mostrarComponente(getComponente('id_servicio'));
			
			getComponente('id_servicio').allowBlank=false;
			
			getComponente('id_item').allowBlank=true;
			
			//getComponente('fecha_ini_serv').enable();
			txt_fecha_inicio.setValue('');
			//getComponente('fecha_fin_serv').disable();
			get_fecha_adq();
		}


		if(maestro.id_tipo_adq==4){
			CM_ocultarComponente(txt_fecha_inicio);
			CM_ocultarComponente(txt_fecha_fin);
			
			getComponente('fecha_inicio_serv').allowBlank=true;
			getComponente('fecha_fin_serv').allowBlank=true;
		}else{
			
			CM_mostrarComponente(txt_fecha_inicio);
			CM_mostrarComponente(txt_fecha_fin);
			getComponente('fecha_inicio_serv').allowBlank=false;
		}
		
			
		CM_btnNew();
		
	}
	
	
	function get_fecha_adq(){
		
		//getComponente('fecha_inicio_serv').setValue(maestro.fecha_reg.('d/m/Y'));
		Ext.Ajax.request({
			url:direccion+"../../../../sis_adquisiciones/control/parametro_adquisicion/ActionObtenerGestionAdq.php?id_empresa="+maestro.id_empresa+"&m_gestion="+maestro.mi_gestion,
			method:'GET',
			success:cargar_fecha_adq,
			failure:Cm_conexionFailure,
			timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
			});
	}

	function cargar_fecha_adq(resp){
	   
		if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
			var root = resp.responseXML.documentElement;
				if((root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue)>0){
				        gestion=root.getElementsByTagName('gestion')[0].firstChild.nodeValue;
						txt_lim_inf_fecha.setValue('');
						//txt_lim_inf_fecha.setValue(root.getElementsByTagName('fecha_ini')[0].firstChild.nodeValue);
						txt_lim_inf_fecha.setValue('01/01/'+root.getElementsByTagName('gestion')[0].firstChild.nodeValue);
						txt_lim_sup_fecha.setValue('31/12/'+root.getElementsByTagName('gestion_sig')[0].firstChild.nodeValue);

							/**12-enero**/	
						txt_fecha_inicio.minValue=txt_lim_inf_fecha.getValue().dateFormat('d-m-Y');
						//txt_lim_inf_fecha.setValue(maestro.fecha_reg);
							/*******/
							
						txt_fecha_inicio.minValue=txt_lim_inf_fecha.getValue();
						
						txt_fecha_fin.minValue=txt_lim_inf_fecha.getValue();
					   // txt_fecha_inicio.setValue(txt_fecha_inicio.getValue());
    					
					   if(maestro.avance=='si'){
					        txt_lim_sup_fecha.setValue(root.getElementsByTagName('fecha_fin')[0].firstChild.nodeValue);
    					   
			             }
			           txt_fecha_fin.maxValue=txt_lim_sup_fecha.getValue();
    					
					   txt_fecha_fin.setValue(txt_fecha_fin.getValue());
    					
    					txt_lim_inf_fecha.setValue('');
    					txt_lim_sup_fecha.setValue('');
    					
    					
				}
		}
	}
	
	
	this.btnEdit=function(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			gestion=SelectionsRecord.data.gestion;
			CM_ocultarGrupo('Oculto');
			CM_ocultarGrupo('Informacion Presupuestaria');
		
			//getComponente('precio_total_referencial_as').setValue(getComponente('cantidad').getValue()*getComponente('precio_referencial_estimado').getValue());
			if(maestro.id_tipo_adq!=4){
				getComponente('fecha_fin_serv').minValue=SelectionsRecord.data.fecha_inicio_serv;
				getComponente('fecha_fin_serv').setValue(SelectionsRecord.data.fecha_fin_serv);
				getComponente('fecha_fin_serv').disable();
	
				CM_mostrarComponente(getComponente('fecha_inicio_serv'));	
				CM_mostrarComponente(getComponente('fecha_fin_serv'));
						
			}else{
				CM_ocultarComponente(getComponente('fecha_inicio_serv'));	
				CM_ocultarComponente(getComponente('fecha_fin_serv'));
			}

			if(maestro.es_item==1){
				 CM_ocultarComponente(getComponente('id_servicio'));
				 CM_ocultarComponente(getComponente('id_item'));
				 getComponente('id_servicio').allowBlank=true;
				 getComponente('id_item').allowBlank=true;
				 CM_ocultarComponente(getComponente('id_unidad_medida_base'));
			
			}else{
				 CM_ocultarComponente(getComponente('id_item'));
			 	 CM_mostrarComponente(getComponente('id_servicio'));
			 	 getComponente('id_servicio').allowBlank=false;
				 getComponente('id_item').allowBlank=true;
				 CM_mostrarComponente(getComponente('id_unidad_medida_base'));
			}

			CM_mostrarComponente(getComponente('precio_referencial_total_as'));
			CM_mostrarComponente(getComponente('total_gestion'));
			/*if(parseFloat(SelectionsRecord.data.precio_referencial_total_as)>0){
			    CM_mostrarComponente(getComponente('precio_referencial_total_as'));
			    CM_mostrarComponente(getComponente('total_gestion'));
			}else{
			    CM_ocultarComponente(getComponente('precio_referencial_total_as'));
			    CM_ocultarComponente(getComponente('total_gestion'));
			}*/
			CM_btnEdit();
		}else{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un item');
		}
	}
	
	
//	function get_fecha_bd(){
//		Ext.Ajax.request({
//			url:direccion+"../../../../lib/lib_control/action/ActionObtenerFechaBD.php",
//			method:'GET',
//			success:cargar_fecha_bd,
//			failure:Cm_conexionFailure,
//			timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
//			});
//	}
//
//	function cargar_fecha_bd(resp){
//		
//		if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
//			var root = resp.responseXML.documentElement;
//			if(getComponente('fecha_reg').getValue()==""){
//				getComponente('fecha_reg').setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
//			}
//		}
//	}
//	
	
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_solicitud_compra_serv_det.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	
	layout_solicitud_compra_serv_det.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}