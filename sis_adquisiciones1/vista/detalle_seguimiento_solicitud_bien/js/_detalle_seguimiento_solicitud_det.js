/**
 * Nombre:		  	    pagina_detalle_seguimiento_solicitud_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-16 11:58:28
 */ 
function pagina_detalle_seguimiento_solicitud_det(idContenedor,direccion,paramConfig,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var maestro;
	var refo;
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
		'desc_solicitud_compra_det',
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
		'id_item',
		'desc_item',
		'monto_aprobado',
		'supergrupo',
		'grupo',
		'subgrupo',
		'id1',
		'id2',
		'id3',
		'id_item_reformulado',
		'monto_ref_reformulado',
		'reformular',
		'desc_item_reformulado','descripcion_item','especificaciones_tecnicas', 'precio_referencial_moneda_seleccionada',
		'precio_total_moneda_seleccionada',
		'precio_total_referencial'

		]),remoteSort:true});

	
	// DEFINICIÓN DATOS DEL MAESTRO

	
	function negrita1(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	
	//DATA STORE COMBOS

    var ds_solicitud_compra_det = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/solicitud_compra_det/ActionListarSolicitudCompraDet_det.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_solicitud_compra_det',totalRecords:'TotalCount'},['id_solicitud_compra_det','cantidad','precio_referencial_estimado','fecha_reg','fecha_inicio_serv','fecha_fin_serv','descripcion','partida_presupuestaria','estado_reg','pac_verificado','id_solicitud_compra','id_servicio','id_item','monto_aprobado'])
	});

    var ds_item = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../sis_almacenes/control/item/ActionListarItem.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_item',totalRecords:'TotalCount'},['id_item','codigo','nombre','descripcion','precio_venta_almacen','costo_estimado','stock_min','observaciones','nivel_convertido','estado_registro','fecha_reg','id_unidad_medida_base','id_id3','id_id2','id_id1','id_subgrupo','id_grupo','id_supergrupo','peso_kg','mat_bajo_responsabilidad'])
	});

	//FUNCIONES RENDER
	
	
	
	function render_id_item(value, p, record){if(record.get('reformular')=='pendiente'){return '<span style="color:blue;font-size:8pt">' + record.data['desc_item']+ '</span>';}else {return record.data['desc_item'];}}
	var tpl_id_servicio=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');

	function negrita(val,cell,record,row,colum,store){
			if(record.get('reformular')=='pendiente'){
								
				if(colum=='1' || colum=='2'){
					return '<span style="color:blue;font-size:8pt">' + val + '</span>';
				}
				else{
					return val;
				}
			}
			else
			{
				return val;
			}
		}
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
		save_as:'id_solicitud_compra_det'
	};
	
	
	Atributos[1]={
		validacion:{
			name:'desc_item',
			desc:'desc_item',
			fieldLabel:'Código',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			store:ds_item,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true,
			grid_editable:false,
			renderer:render_id_item,
			width_grid:90,
			width:150,
			pageSize:10,
			direccion:direccion,
			grid_indice:1,
			renderer:render_id_item	
			},
		tipo:'LovItemsAlm',
		save_as:'id_item',
		filtro_0:true,
		filterColValue:'ITEM.codigo'
	};
		
	Atributos[2]={
			validacion: {
			name:'reformular',
			fieldLabel:'Reformulación',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['pendiente','pendiente'],['aprobado','aprobado']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:95,
			disabled:false,
			grid_indice:1,
			renderer:negrita 	
		},
		tipo:'ComboBox',
		form: true,
		save_as:'reformular',
		id_grupo:1
		
	};
		
	
	
	// txt descripcion
	Atributos[3]={
		validacion:{
			name:'descripcion_item',
			fieldLabel:'Descripción',
			allowBlank:true,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			width:'100%',
			disable:false,
			grid_indice:2,
			renderer:negrita 		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'ittem.descripcion',
		save_as:'descripcion'
	};

	
	// txt cantidad
	Atributos[4]={
		validacion:{
			name:'cantidad',
			fieldLabel:'Cantidad',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:60,
			width:'100%',
			disable:false,
			grid_indice:3,
			renderer:negrita 		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'SOLDET.cantidad',
		save_as:'cantidad'
	};
// txt precio_referencial_estimado
	Atributos[5]={
		validacion:{
			name:'precio_referencial_moneda_seleccionada',
			fieldLabel:'Precio Unitario',
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
			grid_editable:false,
			width_grid:115,
			width:'100%',
			disabled:false,
			grid_indice:4,
			renderer:negrita 		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'SOLDET.precio_referencial_estimado',
		save_as:'precio_referencial_estimado'
	};
	
	
	
		
Atributos[6]={
			validacion:{
				name:'precio_total_moneda_seleccionada',
				fieldLabel:'Precio Total',
				allowBlank:true,
				maxLength:10,
				minLength:0,
				decimalPrecision:2,//para numeros float
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'40%',
				align:'right',
				disabled:true,
				grid_indice:5,
				//renderer:render_decimales,
				allowNegative:false,
				allowDecimals:true,
				allowMil:true
			},
			tipo: 'NumberField',
			filtro_0:false,
			save_as:'precio_total_moneda_seleccionada',
			id_grupo:1
		};
	
// txt partida_presupuestaria
	Atributos[7]={
		validacion:{
			name:'partida_presupuestaria',
			fieldLabel:'Partida Presupuestaria',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:133,
			width:'100%',
			disable:false,
			grid_indice:6,
			renderer:negrita 	
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'SOLDET.partida_presupuestaria',
		save_as:'partida_presupuestaria'
	};
	// txt pac_verificado
	Atributos[9]={
			validacion: {
			name:'pac_verificado',
			fieldLabel:'PAC Verificado',
			allowBlank:true,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','si'],['no','no']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			pageSize:100,
			minListWidth:'100%',
			disable:false,
			grid_indice:7,
			renderer:negrita 	
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'SOLDET.pac_verificado',
		defecto:'si',
		save_as:'pac_verificado'
	};
// txt fecha_reg
	Atributos[10]= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha Registro',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:true,
			grid_indice:16,
			renderer:negrita 		
		},
		form:false,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'SOLDET.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_reg'
	};


// txt estado_reg
	Atributos[11]={
		validacion:{
			name:'estado_reg',
			fieldLabel:'Estado',
			allowBlank:true,
			maxLength:18,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:15,
			renderer:negrita 	
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'SOLDET.estado_reg',
		save_as:'estado_reg'
	};

// txt id_solicitud_compra
	Atributos[8]={
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
		save_as:'id_solicitud_compra'
	};

// txt id_item
	
	

	
	Atributos[12]={
		validacion:{
			name:'supergrupo',
			fieldLabel:'Supergrupo',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:7,
			renderer:negrita 
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false
	};
	
	
	
	
	Atributos[13]={
		validacion:{
			name:'grupo',
			fieldLabel:'Grupo',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:8,
			renderer:negrita 
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false
	};
	
	
	
	Atributos[14]={
		validacion:{
			name:'subgrupo',
			fieldLabel:'Subgrupo',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:9,
			renderer:negrita 
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false
	};
	
	
	Atributos[15]={
		validacion:{
			name:'id1',
			fieldLabel:'ID1',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:10,
			renderer:negrita 
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false
	};
	
	
	Atributos[16]={
		validacion:{
			name:'id2',
			fieldLabel:'ID2',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:11,
			renderer:negrita 
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false
	};
	
	
	Atributos[17]={
		validacion:{
			name:'id3',
			fieldLabel:'ID3',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disable:false,
			grid_indice:12,
			renderer:negrita 
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false
	};
	
	

	
	// txt reformular
	Atributos[18]={
		validacion:{
			name:'desc_item_reformulado',
			fieldLabel:'Item Reformulado',
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'70%',
			disabled:true,
			grid_indice:13,
			renderer:negrita,
			growMin:100 		
		},
		tipo: 'TextArea',
		form: true,
		save_as:'desc_item_reformulado',
		id_grupo:1
		
	};
	
		
	// txt monto ref reformulado
	Atributos[19]={
		validacion:{
			name:'monto_ref_reformulado',
			fieldLabel:'Precio Total Reformulado',
			maxLength:18,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:110,
			width:'75%',
			disabled:false,
			grid_indice:14,
			renderer:negrita 		
		},
		tipo: 'NumberField',
		form: true,
		save_as:'monto_ref_reformulado',
		id_grupo:1
		
	};

	Atributos[20]={
		validacion:{
			name:'especificaciones_tecnicas',
			fieldLabel:'Especificaciones Tecnicas',
			allowBlank:true,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:true,
			width_grid:160,
			width:'100%',
			disabled:false,
			grid_indice:2
		},
		tipo: 'TextArea',
		form: true,
		defecto:' ',
		filtro_0:true,
		filterColValue:'SOLDET.especificaciones_tecnicas',
		save_as:'especificaciones_tecnicas'
		
	};
	
	// txt precio_referencial_estimado
		Atributos[21]={
			validacion:{
				name:'precio_referencial_estimado',
				fieldLabel:'Precio Unitario',
				allowBlank:false,
				maxLength:10,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision:6,//para numeros float
				allowNegative:false,
				minValue:0.1,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:100,
				align:'right',
				width:'40%',
				grid_indice:5,
				//renderer:render_decimales,
				allowNegative:false,
				allowDecimals:true,
				allowMil:true
			},
			tipo: 'NumberField',
			filtro_0:true,
			filterColValue:'SOLDET.precio_referencial_estimado',
			save_as:'precio_referencial_estimado'
		};


		Atributos[22]={
			validacion:{
				name:'precio_total_referencial',
				fieldLabel:'Precio Total',
				allowBlank:true,
				maxLength:10,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:false,
				decimalPrecision:2,//para numeros float
				grid_editable:false,
				width_grid:100,
				width:'40%',
				align:'right',
				disabled:true,
				grid_indice:5,
				//renderer:render_decimales,
				allowNegative:false,
				allowDecimals:true,
				allowMil:true
			},
			tipo: 'NumberField',
			form: true,
			filtro_0:false
		};
	
	
	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Seguimiento de Solicitudes (Maestro) Bienes',titulo_detalle:'Detalle Solicitud (Detalle) Bienes',grid_maestro:'grid-'+idContenedor};
	var layout_detalle_seguimiento_solicitud = new DocsLayoutMaestro(idContenedor);
	layout_detalle_seguimiento_solicitud.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_detalle_seguimiento_solicitud,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	
	var CM_btnEdit=this.btnEdit;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_getComponente=this.getComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	
	var CM_enableSelect=this.EnableSelect;
	var CM_saveSuccess=this.saveSuccess;
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES

		
		
	
	var paramFunciones={
		Save:{url:direccion+'../../../control/solicitud_compra_det/ActionGuardarSolicitudDetRef.php',
		success:miFuncionSuccess},
		btnEliminar:{url:direccion+'../../../control/solicitud_compra_det/ActionAnularSolicitudCompraDet.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,columnas:['90%'],grupos:[{tituloGrupo:'Datos',columna:0,id_grupo:0},{tituloGrupo:'Datos Reformulacion',columna:0,id_grupo:1}],width:'50%',minWidth:150,minHeight:200,	closable:true,titulo:'Detalle Solicitud(Bienes)'}};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(m){
		maestro=m;

		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_solicitud_compra:maestro.id_solicitud_compra
			}
		};
		this.btnActualizar();
		
		Atributos[8].defecto=maestro.id_solicitud_compra;
		paramFunciones.Save.parametros='&m_id_solicitud_compra='+maestro.id_solicitud_compra;
		paramFunciones.btnEliminar.parametros='&m_id_solicitud_compra='+maestro.id_solicitud_compra;
		paramFunciones.btnEliminar.mensaje='Esta seguro de anular el detalle?';
		this.InitFunciones(paramFunciones)
	};
	
	function btn_reformulacion(){
		var sm=getSelectionModel();var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelections();
		if(NumSelect==1){
			if(SelectionsRecord[0].data['reformular']=='pendiente'){
				CM_ocultarGrupo('Datos');
				CM_mostrarGrupo('Datos Reformulacion');
				if(CM_getComponente('desc_item_reformulado').getValue()==''){
					CM_ocultarComponente(CM_getComponente('desc_item_reformulado'));
				}
				if(CM_getComponente('monto_ref_reformulado').getValue()==''){
					CM_ocultarComponente(CM_getComponente('monto_ref_reformulado'));
				}
				refo=1;
				CM_btnEdit();}
			else{
				Ext.MessageBox.alert('Estado', 'Seleccione un registro con Reformulación pendiente.')
			}
		}
		else{
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un solo item.');
		}
	}
	
	
	
	
	
		function miFuncionSuccess(resp)
	{
		if(refo==1){
			salta();
		}
		refo=0;
		CM_saveSuccess(resp);
		
		
	}
	function btn_caracteristica(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_solicitud_compra_det='+SelectionsRecord.data.id_solicitud_compra_det;
			
			var ParamVentana={ventana:{width:'90%',height:'70%'}};
			layout_detalle_seguimiento_solicitud.loadWindows(direccion+'../../../vista/caracteristica/caracteristica_min.php?'+data,'Características Adicionales',ParamVentana);
layout_detalle_seguimiento_solicitud.getVentana().on('resize',function(){
			layout_detalle_seguimiento_solicitud.getLayout().layout();
				})
		}
		else{
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
	}
		}
		
	this.EnableSelect=function(x,z,y){
			
			enable(x,z,y);
				
			}	
		
		
		
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
		
	}
	function salta(){
		ContenedorPrincipal.getPagina(idContenedorPadre).pagina.btnActualizar();
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_detalle_seguimiento_solicitud.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
		this.AdicionarBoton("../../../lib/imagenes/list-items.gif",'Características Adicionales',btn_caracteristica,true,'caracteristica','');
		this.AdicionarBoton('../../../lib/imagenes/gtuc/images/book.gif','Aprobar Reformulación',btn_reformulacion,true,'reformular_detalle','');
		this.AdicionarBoton('../../../lib/imagenes/cancel.png','Anular Detalle',this.btnEliminar,true,'anular_detalle','');
	
	var CM_getBoton=this.getBoton;
	CM_getBoton('anular_detalle-'+idContenedor).enable();
	CM_getBoton('reformular_detalle-'+idContenedor).enable();
	
	
	function  enable(sel,row,selected){
				
				var record=selected.data;

				if(selected&&record!=-1){
				       	CM_getBoton('anular_detalle-'+idContenedor).enable();
						CM_getBoton('reformular_detalle-'+idContenedor).enable();
        			   
					       if(record.reformular=='pendiente' ){
					       		CM_getBoton('anular_detalle-'+idContenedor).disable();
					       }
					       else if(record.estado_reg=='anulado' || record.estado_reg=='finalizado'){
					       		CM_getBoton('anular_detalle-'+idContenedor).disable();
					       		CM_getBoton('reformular_detalle-'+idContenedor).disable();
					       	}
					       	else{
					       		
					       	 	CM_getBoton('reformular_detalle-'+idContenedor).disable();
					       	 	
					       }
				}
		
				CM_enableSelect(sel,row,selected);
				
			}
		
	this.iniciaFormulario();
	iniciarEventosFormularios();
	this.bloquearMenu();
	layout_detalle_seguimiento_solicitud.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}
