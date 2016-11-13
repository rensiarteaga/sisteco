/**
 * Nombre:		  	    pagina_solicitud_compra_det_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-16 09:53:33
 */
function pagina_solicitud_compra_det_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
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
		
		'id_item_antiguo',
		'cantidad',
		'precio_referencial_estimado',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_inicio_serv',type:'date',dateFormat:'Y-m-d'},
		{name: 'fecha_fin_serv',type:'date',dateFormat:'Y-m-d'},
		'descripcion',
		'partida_presupuestaria',
		'estado_reg',
		'pac_verificado',
		'id_solicitud_compra',
		'desc_solicitud_compra',
		'id_servicio',
		'desc_servicio',
		'id_item',
		'desc_item',
		'monto_aprobado',
		'especificaciones_tecnicas',
		'mat_bajo_responsabilidad','id_cuenta','desc_cuenta','id_partida','codigo_partida'

		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_solicitud_compra:maestro.id_solicitud_compra,
			m_tipo_adq:maestro.tipo_adq
		}
	});
	
	// DEFINICIÓN DATOS DEL MAESTRO

	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Num Sol.',maestro.num_solicitud],['localidad',maestro.localidad],['Solicitante',maestro.solicitante]]}),cm:cmMaestro});
	gridMaestro.render();
	//DATA STORE COMBOS

   
    /*var ds_servicio = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/servicio/ActionListarServicio.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_servicio',totalRecords:'TotalCount'},['id_servicio','nombre','descripcion','fecha_reg','id_tipo_servicio','desc_tipo_servicio'])
	});*/
   var ds_item = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../sis_almacenes/control/item/ActionListarItem.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_item',totalRecords:'TotalCount'},['id_item','codigo','nombre','descripcion','precio_venta_almacen','costo_estimado','stock_min','observaciones','nivel_convertido','estado_registro','fecha_reg','id_unidad_medida_base','id_id3','id_id2','id_id1','id_subgrupo','id_grupo','id_supergrupo','peso_kg'])
	});

	//FUNCIONES RENDER
	
	
//	function render_id_solicitud_compra(value, p, record){return String.format('{0}', record.data['desc_solicitud_compra']);}
//	var tpl_id_solicitud_compra=new Ext.Template('<div class="search-item">','<b><i>{localidad}</i></b>','<br><FONT COLOR="#B5A642">{num_solicitud}</FONT>','</div>');
//
//	function render_id_servicio(value, p, record){return String.format('{0}', record.data['desc_servicio']);}
//	var tpl_id_servicio=new Ext.Template('<div class="search-item">','<b><i>{desc_tipo_servicio}</i></b>','<br><FONT COLOR="#B5A642">{nombre}</FONT>','</div>');

	function render_id_item(value, p, record){return String.format('{0}', record.data['desc_item']);}
	var tpl_id_item=new Ext.Template('<div class="search-item">','<b><i>{codigo}</i></b>','<br><FONT COLOR="#B5A642">{nombre}</FONT>','</div>');

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
// txt id_item_antiguo
	Atributos[1]={
		validacion:{
			name:'id_item_antiguo',
			fieldLabel:'Item antiguo',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:false,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:18
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'SOLDET.id_item_antiguo',
		save_as:'id_item_antiguo',
		id_grupo:0
	};
// txt cantidad
	Atributos[2]={
		validacion:{
			name:'cantidad',
			fieldLabel:'Cantidad',
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
			width:'40%',
			disable:false,
			grid_indice:6
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'SOLDET.cantidad',
		id_grupo:3,
		save_as:'cantidad'
	};
 
	// txt precio_referencial_estimado
	Atributos[3]={
		validacion:{
			name:'precio_referencial_estimado',
			fieldLabel:'Precio Referencial ('+ maestro.simbolo +')',
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
			width_grid:180,
			width:'40%',
			disable:false,
			grid_indice:7
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'SOLDET.precio_referencial_estimado',
		save_as:'precio_referencial_estimado',
		id_grupo:3
	};
	
 // txt fecha_reg
	Atributos[4]= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha registro',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:85,
			disabled:true,
			grid_indice:21
		},
		form:false,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'SOLDET.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_reg',
		id_grupo:0
	};
// txt fecha_inicio_serv
	Atributos[6]= {
		validacion:{
			name:'fecha_inicio_serv',
			fieldLabel:'Inicio Servicio',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:85,
			disabled:false,
			grid_indice:4
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'SOLDET.fecha_inicio_serv',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_inicio_serv',
		id_grupo:2
	};
// txt fecha_fin_serv
	Atributos[12]= {
		validacion:{
			name:'fecha_fin_serv',
			fieldLabel:'Fin Servicio',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:85,
			disabled:false,
			grid_indice:5
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'SOLDET.fecha_fin_serv',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_fin_serv',
		id_grupo:2
	};
// txt descripcion
	Atributos[7]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripcion',
			allowBlank:false,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:8
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'SOLDET.descripcion',
		save_as:'descripcion',
		id_grupo:3
	};
// txt partida_presupuestaria
	Atributos[8]={
		validacion:{
			name:'partida_presupuestaria',
			fieldLabel:'Partida Presupuestaria',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:11
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false,
		filterColValue:'SOLDET.partida_presupuestaria',
		save_as:'partida_presupuestaria',
		id_grupo:4
	};
// txt estado_reg
	Atributos[9]={
		validacion:{
			name:'estado_reg',
			fieldLabel:'estado',
			allowBlank:true,
			maxLength:18,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:27
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'SOLDET.estado_reg',
		save_as:'estado_reg',
		id_grupo:0
	};
// txt pac_verificado
	Atributos[10]={
			validacion: {
			name:'pac_verificado',
			fieldLabel:'PAC Verificado',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','si'],['no','no']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:false,
			grid_editable:true,
			width_grid:100,
			pageSize:100,
			minListWidth:'100%',
			disable:false,
			grid_indice:9
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		filterColValue:'SOLDET.pac_verificado',
		defecto:'si',
		save_as:'pac_verificado',
		id_grupo:4
	};
// txt id_solicitud_compra
	Atributos[11]={
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
	
// txt id_servicio
	Atributos[5]={
			validacion:{
			name:'id_servicio',
			fieldLabel:'Servicio',
			allowBlank:true,			
			emptyText:'Servicio...',
			desc: 'desc_servicio', //indica la columna del store principal ds del que proviane la descripcion
			//store:ds_servicio,
			valueField: 'id_servicio',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'SERVIC.nombre',
			typeAhead:true,
			tpl:tpl_id_servicio,
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
			renderer:render_id_servicio,
			grid_visible:true,
			grid_editable:true,
			width_grid:180,
			width:'100%',
			disable:false,
			grid_indice:3
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'SERVIC.nombre',
		save_as:'id_servicio',
		id_grupo:2
	};
// txt id_item
	Atributos[13]={
		validacion:{
			name:'id_item',
			desc:'desc_item',
			fieldLabel:'Item',
			tipo:'ingreso',
			/*filterCols:fC,
			filterValues:fV,*/
			
			allowBlank:true,
			maxLength:100,
			minLength:0,
			store:ds_item,
			valueField: 'id_item',
			displayField: 'nombre',
			renderer:render_id_item,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true,
			grid_editable:true,
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
		filterColValue:'ITEM.codigo',
		id_grupo:1
	};
		
// txt monto_aprobado
	Atributos[14]={
		validacion:{
			name:'monto_aprobado',
			fieldLabel:'Monto Aprobado',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:false,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:10
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'SOLDET.monto_aprobado',
		save_as:'monto_aprobado',
		id_grupo:4
	};
// txt mat_bajo_responsabilidad
	Atributos[15]={
		validacion:{
			name:'mat_bajo_responsabilidad',
			fieldLabel:'Mat. Bajo Responsabilidad',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','si'],['no','no']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			pageSize:100,
			minListWidth:'100%',
			disable:false,
			grid_indice:2
		},
		tipo: 'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'SOLDET.mat_bajo_responsabilidad',
		save_as:'mat_bajo_responsabilidad',
		id_grupo:1
		
	};
	
	Atributos[16]={
		validacion:{
			name:'especificaciones_tecnicas',
			fieldLabel:'Especificaciones Tecnicas',
			allowBlank:false,
			maxLength:500,
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
		save_as:'especificaciones_tecnicas'
		
	};
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Solicitud Compra (MAESTRO)',titulo_detalle:'Detalle de Solicitud (DETALLE)',grid_maestro:'grid-'+idContenedor};
	var layout_solicitud_compra_det = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_solicitud_compra_det.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_solicitud_compra_det,idContenedor);
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
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/solicitud_compra_det/ActionEliminarSolicitudCompraDet.php',parametros:'&m_id_solicitud_compra='+maestro.id_solicitud_compra},
	Save:{url:direccion+'../../../control/solicitud_compra_det/ActionGuardarSolicitudCompraDet.php',parametros:'&m_id_solicitud_compra='+maestro.id_solicitud_compra},
	ConfirmSave:{url:direccion+'../../../control/solicitud_compra_det/ActionGuardarSolicitudCompraDet.php',parametros:'&m_id_solicitud_compra='+maestro.id_solicitud_compra},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'solicitud_compra_det',
	
	grupos:[{tituloGrupo:'Oculto',
			columna:0,
			id_grupo:0
			},{
				tituloGrupo:'Item',
				columna:0,
				id_grupo:1
			},{
				tituloGrupo:'Servicio',
				columna:0,
				id_grupo:2
			},{
				tituloGrupo:'Datos Pedido',
				columna:0,
				id_grupo:3
			},
			
			{
				tituloGrupo:'Informacion Presupuestaria',
				columna:0,
				id_grupo:4
			}
			]
	
	}};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_solicitud_compra=datos.m_id_solicitud_compra;
		maestro.num_solicitud=datos.m_num_solicitud;
		maestro.localidad=datos.m_localidad;
		maestro.id_tipo_adq=datos.m_id_tipo_adq;
		maestro.solicitante=datos.m_solicitante;
		maestro.tipo_adq=datos.m_tipo_adq;

		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_solicitud_compra:maestro.id_solicitud_compra
			}
		};
		this.btnActualizar();
		iniciarEventosFormularios();
	gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['Num.Solicitud ',maestro.num_solicitud],['localidad',maestro.localidad],['Solicitante',maestro.solicitante]]);
		Atributos[11].defecto=maestro.id_servicio_propuesto;
		paramFunciones.btnEliminar.parametros='&m_id_solicitud_compra='+maestro.id_solicitud_compra;
		paramFunciones.Save.parametros='&m_id_solicitud_compra='+maestro.id_solicitud_compra;
		paramFunciones.ConfirmSave.parametros='&m_id_solicitud_compra='+maestro.id_solicitud_compra;
		this.InitFunciones(paramFunciones)
	};
	
	
	function btn_caracteristica(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			//
			var data='m_id_solicitud_compra_det='+SelectionsRecord.data.id_solicitud_compra_det;
				data=data+'&m_descripcion='+SelectionsRecord.data.descripcion;
				if(maestro.tipo_adq=='Bien'){
					data=data+'&m_id_detalle='+SelectionsRecord.data.desc_item;
				}else{
					data=data+'&m_id_detalle='+SelectionsRecord.data.desc_servicio;
				}
				
				

			var ParamVentana={ventana:{width:'90%',height:'70%'}};
			layout_solicitud_compra_det.loadWindows(direccion+'../../../../sis_adquisiciones/vista/caracteristica/caracteristica_det.php?'+data,'Caracteristicas Adicionales',ParamVentana);
layout_solicitud_compra_det.getVentana().on('resize',function(){
			layout_solicitud_compra_det.getLayout().layout();
				})
		}
		else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
		}
 	}
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
		
	 /* if(maestro.tipo_adq=='Bien'){
	  	
	  		getGrid().getColumnModel().setHidden(2,true);
	  		getGrid().getColumnModel().setHidden(3,true);
	  		getGrid().getColumnModel().setHidden(4,true);
		  	getGrid().getColumnModel().setHidden(0,false);
		  	getGrid().getColumnModel().setHidden(1,false);
		  	
	  }
	  else{
	  	
	  	//servicio
	  		getGrid().getColumnModel().setHidden(0,true);
		  	getGrid().getColumnModel().setHidden(1,true);
		  	getGrid().getColumnModel().setHidden(2,false);
		  	getGrid().getColumnModel().setHidden(3,false);
		  	getGrid().getColumnModel().setHidden(4,false);
		  	ds_servicio.baseParams={id_tipo_adq:maestro.id_tipo_adq};
	    }
	    
	  */  
	   
	}

	
	this.btnNew=function(){
		CM_ocultarGrupo('Oculto');
		CM_ocultarGrupo('Informacion Presupuestaria');
		
		if(maestro.tipo_adq=='Bien'){
						
			CM_ocultarGrupo('Servicio');
			CM_mostrarGrupo('Item');
		  	getComponente('id_servicio').allowBlank=true;
		  	getComponente('fecha_inicio_serv').allowBlank=true;
		  	getComponente('fecha_fin_serv').allowBlank=true;
		  	getComponente('id_item').allowBlank=false;
		  	getComponente('mat_bajo_responsabilidad').allowBlank=false;
		}else{
			CM_ocultarGrupo('Item');
			CM_mostrarGrupo('Servicio');
		  	getComponente('id_servicio').allowBlank=false;
		  	getComponente('fecha_inicio_serv').allowBlank=false;
		  	getComponente('fecha_fin_serv').allowBlank=false;
		  	getComponente('id_item').allowBlank=true;
		  	getComponente('mat_bajo_responsabilidad').allowBlank=true;
		}
		
		CM_btnNew();
	}
	
	
	
	this.btnEdit=function(){
		CM_ocultarGrupo('Oculto');
		CM_ocultarGrupo('Informacion Presupuestaria');
		
		if(maestro.tipo_adq=='Bien'){
		
			CM_ocultarGrupo('Servicio');
			CM_mostrarGrupo('Item');
		  	getComponente('id_servicio').allowBlank=true;
		  	getComponente('fecha_inicio_serv').allowBlank=true;
		  	getComponente('fecha_fin_serv').allowBlank=true;
		  	getComponente('id_item').allowBlank=false;
		  	getComponente('mat_bajo_responsabilidad').allowBlank=false;
		}else{
			CM_ocultarGrupo('Item');
			CM_mostrarGrupo('Servicio');
		  	getComponente('id_servicio').allowBlank=false;
		  	getComponente('fecha_inicio_serv').allowBlank=false;
		  	getComponente('fecha_fin_serv').allowBlank=false;
		  	getComponente('id_item').allowBlank=true;
		  	getComponente('mat_bajo_responsabilidad').allowBlank=true;
		}
		
		CM_btnEdit();
	}
	
	
	function get_fecha_bd()
	{
		Ext.Ajax.request({
			url:direccion+"../../../../lib/lib_control/action/ActionObtenerFechaBD.php",
			method:'GET',
			success:cargar_fecha_bd,
			failure:Cm_conexionFailure,
			timeout:100000000//TIEMPO DE ESPERA PARA DAR FALLO
			});
	}

	function cargar_fecha_bd(resp)
	{
		Ext.MessageBox.hide();
		if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined)
		{
			var root = resp.responseXML.documentElement;
			if(getComponente('fecha_reg').getValue()=="")
			{
				getComponente('fecha_reg').setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
				
			}
		}
	}
	
	
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_solicitud_compra_det.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Caracteristicas Adicionales',btn_caracteristica,true,'caracteristica','');

	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_solicitud_compra_det.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}
