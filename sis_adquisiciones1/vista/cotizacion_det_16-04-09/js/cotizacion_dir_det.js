/**
* Nombre:		  	    pagina_cotizacion_det.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-05-28 17:32:15
*/
function pag_cot_dir_det(idContenedor,direccion,paramConfig,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var sw_grup=true,gridG,gSm,id_SCD,ds_g,gDlg,maestro;
	var cantidad=0;
	var adj=0;
	var bandera=false;

	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cotizacion_det/ActionListarCotizacionDet.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_cotizacion_det',
			//id:'id_item',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_cotizacion_det',

		'supergrupo', 'gru','subgrupo','id1','id2','id3','codigo','id_item','cantidad_solicitada',
		'cantidad','garantia','id_item_cotizado','observaciones','precio','tiempo_entrega','observado','item','id_cotizacion','nombre_cotizado',
		'num_convocatoria','id_adjudicacion'
		,'id_item_aprobado','estado','id_proceso_compra','desc_moneda', 'precio_moneda_cotizada','descripcion_item','reg_cabecera','precio_cantidad','id_unidad_medida','abreviatura'

		]),remoteSort:true});


		//DATA STORE COMBOS

		var ds_item = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../sis_almacenes/control/item/ActionListarItem.php'}),
		reader: new Ext.data.XmlReader({record:'ROWS',id:'id_item',totalRecords:'TotalCount'},['id_item','codigo','nombre','descripcion','precio_venta_almacen','costo_estimado','stock_min','observaciones','nivel_convertido','estado_registro','fecha_reg','id_unidad_medida_base','id_id3','id_id2','id_id1','id_subgrupo','id_grupo','id_supergrupo','peso_kg','mat_bajo_responsabilidad'])
		});

		//FUNCIONES RENDER

		function render_id_item(value, p, record){return String.format('{0}', record.data['desc_item']);}
		var tpl_id_item=new Ext.Template('<div class="search-item">','<b><i>{codigo}</i></b>','<br><FONT COLOR="#B5A642">{nombre}</FONT>','</div>');


		/////////////////////////
		// Definición de datos //
		/////////////////////////

		// hidden id_cotizacion_det
		//en la posición 0 siempre esta la llave primaria

		Atributos[0]={
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name: 'id_cotizacion_det',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'id_cot_det',
			id_grupo:0
		};


		Atributos[1]={
			validacion:{
				name:'codigo',
				fieldLabel:'Codigo Item',
				allowBlank:true,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:90,
				width:'100%',
				disable:false,
				grid_indice:1
			},
			tipo: 'TextField',
			form:false,
			filtro_0:false,
			id_grupo:3
		};


		/********/
		Atributos[2]={
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
				width_grid:80,
				width:'100%',
				disable:false,
				grid_indice:8
			},
			tipo: 'TextField',
			form: false,
			filtro_0:false,
			id_grupo:0
		};


		Atributos[3]={
			validacion:{
				name:'gru',
				fieldLabel:'Grupo',
				allowBlank:true,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:75,
				width:'100%',
				disable:false,
				grid_indice:9
			},
			tipo: 'TextField',
			form:false,
			filtro_0:false,
			id_grupo:0
		};



		Atributos[4]={
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
				width_grid:85,
				width:'100%',
				disable:false,
				grid_indice:10
			},
			tipo: 'TextField',
			form:false,
			filtro_0:false,
			id_grupo:0
		};


		Atributos[5]={
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
				width_grid:40,
				width:'100%',
				disable:false,
				grid_indice:11
			},
			tipo: 'TextField',
			form:false,
			filtro_0:false,
			id_grupo:0
		};


		Atributos[6]={
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
				width_grid:40,
				width:'100%',
				disable:false,
				grid_indice:12
			},
			tipo: 'TextField',
			form:false,
			filtro_0:false,
			id_grupo:0
		};


		Atributos[7]={
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
				width_grid:40,
				width:'100%',
				disable:false,
				grid_indice:13
			},
			tipo: 'TextField',
			form:false,
			filtro_0:false,
			id_grupo:0
		};



		Atributos[8]={
			validacion:{
				name:'item',
				fieldLabel:'Item',
				allowBlank:false,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:50,
				width:'100%',
				disabled:true,
				grid_indice:14
			},
			tipo: 'TextField',
			form:true,
			filtro_0:true,
			filterColValue:'item.nombre',
			save_as:'item',
			id_grupo:1
		};



		Atributos[9]={
			validacion:{
				name:'cantidad_solicitada',
				fieldLabel:'Cant. Sol.',
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:false,
				decimalPrecision:0,//para numeros float
				allowNegative:false,
				minValue:0,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				align:'right',
				width_grid:70,
				width:'40%',
				disabled:true,
				grid_indice:2
			},
			tipo:'NumberField',
			form: true,
			filtro_0:true,
			filterColValue:'PRODET.cantidad',
			save_as:'cantidad_solicitada',
			id_grupo:1
		};


		// txt cantidad
		Atributos[10]={
			validacion:{
				name:'cantidad',
				fieldLabel:'Cant. Cot.',
				allowBlank:false,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:false,
				decimalPrecision:0,//para numeros float
				allowNegative:false,
				minValue:0,
				vtype:'texto',
				align:'right',
				grid_visible:true,
				grid_editable:true,
				width_grid:70,
				width:'40%',
				disabled:false,
				grid_indice:3,
				renderer:cantidad_cotizada
			},
			tipo: 'NumberField',
			form: true,
			filtro_0:true,
			filterColValue:'COTDET.cantidad',
			save_as:'cantidad',
			id_grupo:3
		};

		// txt precio
		Atributos[11]={
			validacion:{
				name:'precio_moneda_cotizada',
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
				grid_editable:true,
				width_grid:85,
				width:'40%',
				disabled:false,
				align:'right',
				grid_indice:4,
				renderer:precio_cotizado
			},
			tipo: 'NumberField',
			form:true,
			filtro_0:true,
			filterColValue:'COTDET.precio',
			save_as:'precio',
			id_grupo:3
		};

		// txt tiempo_entrega
		Atributos[12]={
			validacion:{
				name:'tiempo_entrega',
				fieldLabel:'Tiempo Entrega Pedido(dias)',
				allowBlank:true,
				maxLength:3,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:false,
				decimalPrecision:0,
				allowDecimals:false,
				grid_editable:false,
				width_grid:100,
				width:'40%',
				disabled:false,
				grid_indice:12
			},
			tipo: 'NumberField',
			form:true,
			filtro_0:false,
			filterColValue:'COTDET.tiempo_entrega',
			save_as:'tiempo_entrega',
			id_grupo:0
		};

		// txt garantia
		Atributos[13]={
			validacion:{
				name:'garantia',
				fieldLabel:'Garantia',
				allowBlank:true,
				maxLength:300,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width_grid:90,
				width:'100%',
				disabled:false,
				grid_indice:13//,
				//renderer:cadenas
			},
			tipo: 'TextArea',
			form:true,
			defecto:' ',
			filtro_0:true,
			filterColValue:'COTDET.garantia',
			save_as:'garantia',
			id_grupo:3
		};

		// txt observado
		Atributos[14]={
			validacion:{
				name:'observado',
				fieldLabel:'Observado',
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
				width_grid:70,
				align:'center',
				pageSize:100,
				minListWidth:'100%',
				disabled:false,
				grid_indice:15
			},
			tipo:'ComboBox',
			form:true,
			filtro_0:true,
			filterColValue:'COTDET.observado',
			defecto:'si',
			save_as:'observado',
			id_grupo:3
		};


		// txt observaciones
		Atributos[15]={
			validacion:{
				name:'observaciones',
				fieldLabel:'Observaciones',
				allowBlank:true,
				maxLength:500,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width_grid:100,
				width:'100%',
				disable:false,
				grid_indice:6
			},
			tipo: 'TextArea',
			form:true,
			filtro_0:true,
			filterColValue:'COTDET.observaciones',
			save_as:'observaciones',
			id_grupo:3
		};

		// txt id_cotizacion
		Atributos[16]={
			validacion:{
				name:'id_cotizacion',
				labelSeparator:'',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false,
				disabled:true
			},
			tipo:'Field',
			filtro_0:false,
			save_as:'id_cotizacion',
			id_grupo:0
		};
		//	 txt id_item_aprobado
		Atributos[17]={
			validacion:{
				name:'id_item_aprobado',
				fieldLabel:'Id Item',
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
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disable:false
			},
			tipo: 'NumberField',
			form:true,
			filtro_0:false,
			filterColValue:'COTDET.id_item_aprobado',
			save_as:'id_item_aprobado',
			id_grupo:0
		};


		Atributos[18]={
			validacion:{
				name:'id_item_cotizado',
				desc:'nombre_cotizado',
				fieldLabel:'Codigo Item',
				allowBlank:true,
				maxLength:100,
				minLength:0,
				store:ds_item,
				valueField: 'id_item',
				displayField: 'nombre',
				renderer:render_id_item,
				selectOnFocus:true,
				vtype:"texto",
				grid_visible:false,
				grid_editable:false,
				width_grid:90,
				width:200,
				pageSize:10,
				direccion:direccion,
				grid_indice:20,
				disabled:false
			},
			tipo:'LovItemsAlm',
			save_as:'id_item_cotizado',
			form:true,
			filtro_0:false,
			defecto:'',
			filterColValue:'item_cotizado.nombre',
			id_grupo:2
		};


		Atributos[19]={
			validacion:{
				name:'nombre_cotizado',
				fieldLabel:'Item Cotizado',
				allowBlank:true,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false
			},
			tipo: 'TextField',
			form: false,
			filtro_0:false,
			filterColValue:'',
			save_as:'nombre_cotizado',
			id_grupo:0
		};



		Atributos[20]={
			validacion:{
				name:'detalle',
				fieldLabel:'Detalle',
				allowBlank:true,
				maxLength:500,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:true,
				grid_indice:15
			},
			tipo: 'TextArea',
			form:true,
			filtro_0:false,
			save_as:'detalle',
			id_grupo:2
		};

		/*
		Atributos[25]={
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

		Atributos[26]={
		validacion:{
		//fieldLabel: 'Id',
		labelSeparator:'',
		name: 'monto_aprobado',
		allowBlank:true,
		maxLength:50,
		minLength:0,
		selectOnFocus:true,
		allowDecimals:true,
		decimalPrecision:2,//para numeros float
		allowNegative:false,

		vtype:'texto',
		grid_visible:false,
		grid_editable:false,
		width_grid:100,
		disabled:false,
		},
		tipo: 'NumberField',
		filtro_0:false,
		save_as:'monto_aprobado',
		id_grupo:0
		};
		*/
		Atributos[21]={
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name: 'num_convocatoria',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'num_convocatoria',
			id_grupo:0
		};


		Atributos[22]={
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name: 'estado',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'estado',
			id_grupo:0
		};

		Atributos[23]={
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name: 'id_proceso_compra',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'id_proceso_compra',
			id_grupo:0
		};


		Atributos[24]={
			validacion:{
				name:'desc_moneda',
				fieldLabel:'Moneda',
				allowBlank:true,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:true
			},
			tipo: 'TextField',
			form:true,
			filtro_0:false,
			id_grupo:1
		};


		Atributos[25]={
			validacion:{
				name:'precio',
				fieldLabel:'Precio Unitario Bs.',
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
				grid_editable:false,
				width_grid:70,
				align:'right',
				width:'40%',
				disabled:true
			},
			tipo: 'NumberField',
			form:true,
			filtro_0:false,
			save_as:'precio_',
			id_grupo:1
		};

		Atributos[26]={
			validacion:{
				name:'descripcion_item',
				fieldLabel:'Descripcion Item',
				allowBlank:true,
				maxLength:20,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:200,
				width:'40%',
				disabled:true,
				grid_indice:1
			},
			tipo: 'TextField',
			form: true,
			filtro_0:true,
			filterColValue:'item.descripcion',
			id_grupo:0
		};
		
		
		Atributos[27]={
			validacion:{
				name:'precio_cantidad',
				fieldLabel:'Precio Total',
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
				width_grid:85,
				width:'40%',
				disabled:false,
				align:'right',
				grid_indice:5,
				renderer:precio_cotizado
			},
			tipo: 'NumberField',
			form:false,
			filtro_0:true,
			filterColValue:'precio_cantidad',
			save_as:'precio_total',
			id_grupo:3
		};
		
		
		Atributos[28]={
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name: 'id_item',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'item.id_item',
			id_grupo:0
		};

	Atributos[29]={
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name: 'abreviatura',
				label:'Unidad Medida',
				inputType:'hidden',
				grid_visible:true,
				grid_editable:false,
				grid_indice:2
			},
			tipo: 'Field',
			filtro_0:true,
			filterColValue:'unimed.abreviatura',
			id_grupo:0
		};
		//----------- FUNCIONES RENDER

		function formatDate(value){return value?value.dateFormat('d/m/Y'):''};




		//---------- INICIAMOS LAYOUT DETALLE
		var config={titulo_maestro:'Cotizaciones ',grid_maestro:'grid-'+idContenedor};
		var layout_cotizacion_det = new DocsLayoutMaestro(idContenedor,idContenedorPadre);
		layout_cotizacion_det.init(config);



		//---------- INICIAMOS HERENCIA
		this.pagina = Pagina;
		this.pagina(paramConfig,Atributos,ds,layout_cotizacion_det,idContenedor);
		var getComponente=this.getComponente;
		var getSelectionModel=this.getSelectionModel;
		var CM_btnNew=this.btnNew;
		var CM_btnEdit=this.btnEdit;
		var CM_ocultarGrupo=this.ocultarGrupo;
		var CM_mostrarGrupo=this.mostrarGrupo;
		var CM_ocultarComponente=this.ocultarComponente;
		var CM_mostrarComponente=this.mostrarComponente;
		var Cm_conexionFailure=this.conexionFailure;
		var getDialog=this.getDialog;
		var getGrid=this.getGrid;
		var enableSelect=this.EnableSelect;
		var EstehtmlMaestro=this.htmlMaestro;
		//DEFINICIÓN DE LA BARRA DE MENÚ
		var paramMenu={
			guardar:{crear:true,separador:true},
			actualizar:{crear:true,separador:false}
		};
		//DEFINICIÓN DE FUNCIONES

		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/cotizacion_det/ActionEliminarCotizacionDet.php'},
			Save:{url:direccion+'../../../control/cotizacion_det/ActionGuardarCotizacionDet.php'},
			ConfirmSave:{url:direccion+'../../../control/cotizacion_det/ActionGuardarCotizacionDet.php',success:ActualizarPadre},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:560,minHeight:222,	closable:true,titulo:'Detalle de Cotización',
			grupos:[{
				tituloGrupo:'Oculto',
				columna:0,
				id_grupo:0
			},{
				tituloGrupo:'Detalle Solicitud',
				columna:0,
				id_grupo:1
			},
			{	tituloGrupo:'Reformular',
			columna:0,
			id_grupo:3
			},
			{	tituloGrupo:'Detalle de Cotización',
			columna:0,
			id_grupo:4
			},
			{	tituloGrupo:'Adjudicacion',
			columna:0,
			id_grupo:2
			}]}};



//			function cargar_maestro(){
//				data1=[['Nº Cotizacion',ds_maestro.getAt(0).get('num_cotizacion')],  ['Categoria',ds_maestro.getAt(0).get('desc_tipo_categoria_adq')],
//				['Forma Pago',ds_maestro.getAt(0).get('forma_pago')],['Proveedor',ds_maestro.getAt(0).get('desc_proveedor')],   ['Lugar Entrega',ds_maestro.getAt(0).get('lugar_entrega')],['Moneda',ds_maestro.getAt(0).get('desc_moneda')]  ];
//				Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data1));
//			}

			//-------------- Sobrecarga de funciones --------------------//
			this.reload=function(m){
			    maestro=m;
				ds.lastOptions={
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						m_id_cotizacion:maestro.id_cotizacion,
						id_proveedor:maestro.id_proveedor
						
						
					}
				};
				this.btnActualizar();
				//iniciarEventosFormularios();


				Atributos[16].defecto=maestro.id_cotizacion;

				paramFunciones.btnEliminar.parametros='&m_id_cotizacion='+maestro.id_cotizacion;
				paramFunciones.Save.parametros='&m_id_cotizacion='+maestro.id_cotizacion;
				paramFunciones.ConfirmSave.parametros='&m_id_cotizacion='+maestro.id_cotizacion;

				this.iniciarEventosFormularios;
				this.InitFunciones(paramFunciones)
			};


			function cantidad_cotizada(val,cell,record,row,colum,store){
				if(record.data.cantidad==0){
					return '<span style="color:red;font-size:8pt">' + val + '</span>';
				}else{
					return val;
				}

			}

			function precio_cotizado(val,cell,record,row,colum,store){
            	if(record.data.precio_moneda_cotizada>0){
					return val;
				}else {
					return '<span style="color:red;font-size:8pt">' + val + '</span>';
				}
			}


			function cadenas(val,cell,record,row,colum,store){
			    var cadena='sin garantia';
				if(record.data.garantia=='falta_definir'){
					return '<span style="color:red;font-size:8pt">' + val + '</span>';
				}else{
					return val;
				}
            }



			//Para manejo de eventos
			function iniciarEventosFormularios(){
				//para iniciar eventos en el formulario

				txt_cantidad_solicitada=getComponente('cantidad_solicitada');
				txt_cantidad=getComponente('cantidad');
				var txt_cantidad_adjudicada;
				txt_descripcion=getComponente('detalle');
				cmb_Item=getComponente('id_item_cotizado');


				var verificarCant=function(e){
					if(e.column==2){

						if(parseFloat(e.record.data.cantidad_solicitada)>=parseFloat(e.record.data.cantidad)){
						    e.record.set('precio_cantidad',(e.record.data.cantidad*e.record.data.precio_moneda_cotizada));
						    
						}else{
							Ext.MessageBox.alert('Cantidad','la cantidad a cotizar no debe ser mayor a '+e.record.data.cantidad_solicitada);
							e.record.set('cantidad', e.originalValue);
						}
					}
				}
				
				
				var verificarPrec=function(e){
					if(e.column==3){

						if(parseFloat(e.record.data.precio_moneda_cotizada)>=0){
						    e.record.set('precio_cantidad',(e.record.data.cantidad*e.record.data.precio_moneda_cotizada));
						    
						}else{
							e.record.set('cantidad', e.originalValue);
						}
					}
				}
				
				var verificarPrecTot=function(e){
					if(e.column==4){

						if((parseFloat(e.record.data.precio_cantidad)>=0) && parseFloat(e.record.data.cantidad)>0){
						    e.record.set('precio_moneda_cotizada',(e.record.data.precio_cantidad/e.record.data.cantidad));
						    
						}else{
							e.record.set('cantidad', e.originalValue);
						}
					}
				}

				gridG=getGrid();
				gridG.on('afteredit',verificarCant);
				gridG.on('afteredit',verificarPrec);
				gridG.on('afteredit',verificarPrecTot);


				var onItemSelect=function(e){
					rec=cmb_Item.lov.getSelect();
					txt_descripcion.setValue(rec["descripcion"] +'\n(Supergrupo: '+rec["nombre_supg"]+' -  Grupo:'+rec["nombre_grupo"]+' -  Subgrupo:'+rec["nombre_subg"]+' -  ID1:'+rec["nombre_id1"]+' -  ID2:'+rec["nombre_id2"]+' -  ID3:'+rec["nombre_id3"]+')');
                    get_caracteristicas_item(rec["id_item"]);

				};

				function get_caracteristicas_item($id_item){
					Ext.Ajax.request({
						url:direccion+"../../../../sis_almacenes/control/caracteristica_item/ActionListarCaracteristicaItem.php?maestro_id_item="+$id_item,
						method:'GET',
						success:cargar_caracteristicas,
						failure:Cm_conexionFailure,
						timeout:1000000000
					});
				}

				function cargar_caracteristicas(resp){
				if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
						var root = resp.responseXML.documentElement;
						if(root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue >0){
							txt_descripcion.setValue(txt_descripcion.getValue()+ '\n\nTipo Caracteristica:'+ root.getElementsByTagName('desc_tipo_caracteristica')[0].firstChild.nodeValue+ '\nCaracteristica:'+ root.getElementsByTagName('desc_caracteristica')[0].firstChild.nodeValue);
						}
					}
				}


				var onCantidad=function(){
                    if(txt_cantidad.getValue() >txt_cantidad_solicitada.getValue()){
						txt_cantidad.markInvalid("La cantidad cotizada no puede ser mayor a la solicitada");
					}
					else{
						txt_cantidad.clearInvalid();
					}
				}


				var onCantidadAdj=function(){
					if(txt_cantidad_adjudicada.getValue() >txt_cantidad.getValue()){
                    	txt_cantidad_adjudicada.markInvalid("La cantidad adjudicada no puede ser mayor a "+txt_cantidad.getValue());
    					txt_cantidad_adjudicada.allowBlank=false;
					}
					else{
						txt_cantidad_adjudicada.clearInvalid();
					}
				}
				
				//getComponente('id_item_cotizado').on('change',onItemSelect);
				cmb_Item.on('change',onItemSelect);
				cmb_Item.on('select',onItemSelect);
			}





			this.btnNew=function(){
				CM_ocultarGrupo('Oculto');
				CM_ocultarGrupo('Adjudicacion');
				CM_ocultarGrupo('Reformular');
				CM_btnNew();
			}

			this.btnEdit=function(){
				CM_ocultarGrupo('Oculto');
				CM_ocultarGrupo('Adjudicacion');
				CM_ocultarGrupo('Reformular');
				
				CM_btnEdit();
			}







//			function btn_cotizar_otro(){
//
//				var sm=getSelectionModel();
//				var filas=ds.getModifiedRecords();
//				var cont=filas.length;
//				var NumSelect=sm.getCount();
//				if(NumSelect!=0){
//					var SelectionsRecord=sm.getSelected();
//					//if(maestro.estado_vigente=='aperturado' || SelectionsRecord.data.estado=='cotizado'){   ////descomentar, esta verificación debe ser contemplada
//
//					//verificar si ya fué ape
//
//					CM_ocultarGrupo('Oculto');
//					CM_ocultarGrupo('Adjudicacion');
//					CM_mostrarGrupo('Detalle Solicitud');
//					CM_mostrarGrupo('Detalle de Cotización');
//					CM_mostrarGrupo('Reformular');
//
//					getComponente('id_item_cotizado').allowBlank=false;
//					getComponente('precio_moneda_cotizada').enable();
//					getComponente('cantidad').enable();
//					getComponente('tiempo_entrega').enable();
//					getComponente('cantidad').maxValue=getComponente('cantidad_solicitada').getValue();
//					CM_mostrarComponente(getComponente('cantidad_solicitada'));
//					CM_mostrarComponente(getComponente('garantia'));
//					CM_mostrarComponente(getComponente('observado'));
//					CM_mostrarComponente(getComponente('observaciones'));
//					if(SelectionsRecord.data.precio>0){
//						CM_mostrarComponente(getComponente('precio'));
//						getComponente('precio').disable();
//					}else{
//						CM_ocultarComponente(getComponente('precio'));
//					}
//					CM_btnEdit();
//					
//				}
//				else{
//					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
//				}
//			}


			function btn_otro(){
				
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){
				    var SR=sm.getSelected();
					var data='id_cotizacion_det='+SR.data.id_cotizacion_det+'&id_moneda='+maestro.id_moneda+'&desc_moneda='+maestro.desc_moneda+'&desc_item='+SR.data.descripcion_item+'&id_item='+SR.data.id_item+'&cantidad_sol='+SR.data.cantidad_solicitada;
					var ParamVentana={Ventana:{width:'90%',height:'70%'}}
					layout_cotizacion_det.loadWindows(direccion+'../../../../sis_adquisiciones/vista/detalle_propuesta/detalle_propuesta.php?'+data,'Detalle de Propuesta',ParamVentana);
					
				}
				else{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
				}
			}

			this.EnableSelect=function(x,z,y){
				enable(x,z,y)
			}

	
			function ActualizarPadre(resp){
				_CP.getPagina(idContenedorPadre).pagina.btnActualizar();
			}
			this.ActualizarPadre=ActualizarPadre;

			//para que los hijos puedan ajustarse al tamaño
			this.getLayout=function(){return layout_cotizacion_det.getLayout()};
			//para el manejo de hijos

			this.Init(); //iniciamos la clase madre
			this.InitBarraMenu(paramMenu);
			this.InitFunciones(paramFunciones);
			//para agregar botones
			
			//this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Cotizar Otro Item',btn_cotizar_otro,true,'cotizar_otro_item','Cotizar Otro Item');
			
			this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Otras Ofertas',btn_otro,true,'otro','Otras Ofertas');
			
			
			var CM_getBoton=this.getBoton;
			
			//CM_getBoton('cotizar_otro_item-'+idContenedor).enable();

			function  enable(sel,row,selected){
				var record=selected.data;
				if(selected&&record!=-1){
				    if(maestro.estado_vigente=='cotizado'){
				        gridG.getColumnModel().setEditable(13,false);
				        gridG.getColumnModel().setEditable(9,false);
				        gridG.getColumnModel().setEditable(10,false);
				        gridG.getColumnModel().setEditable(11,false);
				        gridG.getColumnModel().setEditable(12,false);
				   }else{
				     
				        if(maestro.id_moneda>0 && maestro.precio_total>0 && maestro.fecha_cotizacion!=''&& parseFloat(record.reg_cabecera)>0){
				                gridG.getColumnModel().setEditable(9,true);
    				            gridG.getColumnModel().setEditable(10,true);
    				            gridG.getColumnModel().setEditable(11,true);
    				            gridG.getColumnModel().setEditable(12,true);
    				            gridG.getColumnModel().setEditable(13,true);
    				            CM_getBoton('guardar-'+idContenedor).enable();
    				            //CM_getBoton('cotizar_otro_item-'+idContenedor).enable();
    				            CM_getBoton('actualizar-'+idContenedor).enable();
				        }else{
				                gridG.getColumnModel().setEditable(13,false);
    				            gridG.getColumnModel().setEditable(9,false);
    				            gridG.getColumnModel().setEditable(10,false);
    				            gridG.getColumnModel().setEditable(11,false);
    				            gridG.getColumnModel().setEditable(12,false);
    				            CM_getBoton('guardar-'+idContenedor).disable();
    				            //CM_getBoton('cotizar_otro_item-'+idContenedor).disable();
    				            CM_getBoton('actualizar-'+idContenedor).disable();
				            alert('Antes se debe definir y guardar los datos de la propuesta en la cabecera marcados con rojo');
				        }
				    }
				    
				}
				enableSelect(sel,row,selected);
			}

			
			
			this.iniciaFormulario();
			iniciarEventosFormularios();
			this.bloquearMenu();
			layout_cotizacion_det.getLayout().addListener('layout',this.onResize);
			layout_cotizacion_det.getVentana().addListener('beforehide',ActualizarPadre);
			ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);

}
