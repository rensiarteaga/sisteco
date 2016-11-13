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
	var ds_unid_med_bas=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/unidad_medida_base/ActionListarUnidadMedidaBase_det.php?tipo_unidad_medida_nombre=Servicios'}),
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
			fieldLabel:'Tipo de Servicio',
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
			fieldLabel:'Servicio',
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
	
	
	//-----unidad medida
	
	
	Atributos[3]={
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
	Atributos[4]= {
		validacion:{
			name:'fecha_inicio_serv',
			fieldLabel:'Inicio del Servicio',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:100,
			disabled:false,
			align:'center',
			grid_indice:4,
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
	Atributos[5]= {
		validacion:{
			name:'fecha_fin_serv',
			fieldLabel:'Fin del Servicio',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			onBlur:function(e){
			var ffin=getComponente('fecha_fin_serv').getValue(); var afin= ffin.dateFormat('Y');
			var fini=getComponente('fecha_inicio_serv').getValue();
			if(parseFloat(gestion)>0){
			    if(afin!=gestion){
			        
			        CM_mostrarComponente(getComponente('precio_referencial_total_as'));
			        CM_mostrarComponente(getComponente('total_gestion'));
			        getComponente('precio_referencial_total_as').allowBlank=false;
			        getComponente('precio_referencial_total_as').setValue('');
			    }else{
			        getComponente('precio_referencial_total_as').setValue(0);
			        getComponente('total_gestion').setValue(0);
			        CM_ocultarComponente(getComponente('precio_referencial_total_as'));
			        CM_ocultarComponente(getComponente('total_gestion'));
			        getComponente('precio_referencial_total_as').allowBlank=true;
			        
			    }
			 }
			},onChange:function(e){
			var ffin=getComponente('fecha_fin_serv').getValue(); var afin= ffin.dateFormat('Y');
			var fini=getComponente('fecha_inicio_serv').getValue();
			if(parseFloat(gestion)>0){
			    if(afin!=gestion){
			        
			        CM_mostrarComponente(getComponente('precio_referencial_total_as'));
			        CM_mostrarComponente(getComponente('total_gestion'));
			        getComponente('precio_referencial_total_as').allowBlank=false;
			        getComponente('precio_referencial_total_as').setValue('');
			    }else{
			        getComponente('precio_referencial_total_as').setValue(0);
			        getComponente('total_gestion').setValue(0);
			        CM_ocultarComponente(getComponente('precio_referencial_total_as'));
			        CM_ocultarComponente(getComponente('total_gestion'));
			        getComponente('precio_referencial_total_as').allowBlank=true;
			        
			    }
			 }
			},
			width_grid:92,
			width:200,
			disabled:true,
			align:'center',
			grid_indice:4
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
			grid_visible:true,
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
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/solicitud_compra_det/ActionEliminarSolicitudCompraDet.php',parametros:'&m_id_solicitud_compra='+maestro.id_solicitud_compra},
	Save:{url:direccion+'../../../control/solicitud_compra_det/ActionGuardarSolicitudCompraDet.php',parametros:'&m_id_solicitud_compra='+maestro.id_solicitud_compra},
	ConfirmSave:{url:direccion+'../../../control/solicitud_compra_det/ActionGuardarSolicitudCompraDet.php',parametros:'&m_id_solicitud_compra='+maestro.id_solicitud_compra},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Detalle de Servicio Solicitado',
	
	grupos:[{tituloGrupo:'Oculto',
			columna:0,
			id_grupo:0
			},{
				tituloGrupo:'Servicio',
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
				mi_gestion:maestro.mi_gestion
			}
		};
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
		
		
	    filterValues_servicio[0]='%';
	    filterValues_servicio[1]='%';

		//txt_precio= getComponente('precio_referencial_estimado');
		txt_cantidad=getComponente('cantidad');
		//txt_costo_total=getComponente('precio_total_referencial');
		txt_precio_referencial_moneda_seleccionada=getComponente('precio_referencial_moneda_seleccionada');
		txt_precio_total_moneda_seleccionada=getComponente('precio_total_moneda_seleccionada');
		txt_id_servicio=getComponente('id_servicio');
		
		txt_fecha_inicio=getComponente('fecha_inicio_serv');
		txt_fecha_fin=getComponente('fecha_fin_serv');
		
		
		txt_lim_sup_fecha=getComponente('fecha_fin_serv');
		txt_lim_inf_fecha=getComponente('fecha_inicio_serv');
		
		
		txt_total_gestion_as=getComponente('precio_referencial_total_as');
		
		
		
		
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
				txt_precio_total_moneda_seleccionada.setValue(unit*cant);
			}
			else
			{
				txt_precio_total_moneda_seleccionada.setValue('0');
				txt_precio_total_moneda_seleccionada.setValue('0');
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
	
	
		
		txt_cantidad.on('blur',CalcularCostoTotal);
	 	txt_precio_referencial_moneda_seleccionada.on('blur',CalcularCostoTotal);

	 	txt_fecha_inicio.on('blur',onFecha);
	 	
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
	 	
	    
	}

	
	this.btnNew=function(){
	
	    CM_ocultarGrupo('Oculto');
		CM_ocultarGrupo('Informacion Presupuestaria');
		txt_fecha_inicio.setValue('');
		CM_ocultarComponente(getComponente('precio_referencial_total_as'));
		getComponente('precio_referencial_total_as').allowBlank=true;
		getComponente('precio_referencial_total_as').reset();
		CM_ocultarComponente(getComponente('total_gestion'));
		getComponente('fecha_fin_serv').disable();
		get_fecha_adq();
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
			getComponente('fecha_fin_serv').minValue=SelectionsRecord.data.fecha_inicio_serv;
			getComponente('fecha_fin_serv').setValue(SelectionsRecord.data.fecha_fin_serv);
			getComponente('fecha_fin_serv').disable();
			if(parseFloat(SelectionsRecord.data.precio_referencial_total_as)>0){
			    CM_mostrarComponente(getComponente('precio_referencial_total_as'));
			    CM_mostrarComponente(getComponente('total_gestion'));
			}else{
			    CM_ocultarComponente(getComponente('precio_referencial_total_as'));
			    CM_ocultarComponente(getComponente('total_gestion'));
			}
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