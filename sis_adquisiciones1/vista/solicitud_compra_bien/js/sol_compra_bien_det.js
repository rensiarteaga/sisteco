/**
* Nombre:		  	    pagina_solicitud_compra_det_det.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-05-16 09:53:33
*/
function pag_sol_compra_bien_det(idContenedor,direccion,paramConfig,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var tituloM,maestro,cmb_Item=getComponente,txt_unidad_medida,txt_precio,txt_cantidad,txt_mat_bajo_responsabilidad,txt_costo_total;
	var txt_precio_referencial_moneda_seleccionada,txt_precio_total_moneda_seleccionada;

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
		'descripcion',
		'estado_reg',
		'id_solicitud_compra',
		'desc_solicitud_compra',
		'id_item',
		'desc_item',
		'mat_bajo_responsabilidad',
		'supergrupo',
		'grupo',
		'subgrupo',
		'id1',
		'id2',
		'id3',
		'item',
		'abreviatura',
		'mat_bajo_responsabilidad',
		'precio_referencial_moneda_seleccionada',
		'precio_total_moneda_seleccionada',
		'precio_total_referencial',
		'especificaciones_tecnicas',
		'detalle','id_cuenta','desc_cuenta','id_partida','codigo_partida','almacenable','descripcion_item','precio_referencial_total_as'
		]),remoteSort:true});

		//	//DATA STORE COMBOS

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
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disable:false,
				grid_indice:9
			},
			tipo: 'NumberField',
			form: false,
			filtro_0:false,
			filterColValue:'SOLDET.id_item_antiguo',
			save_as:'id_item_antiguo',
			id_grupo:0
		};
		
		// txt id_item
		Atributos[2]={
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

		
		// txt cantidad
		Atributos[3]={
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
				grid_editable:true,
				width_grid:70,
				width:'40%',
				disabled:false,
				grid_indice:10
			},
			tipo: 'NumberField',
			form: true,
			filtro_0:true,
			filterColValue:'SOLDET.cantidad',
			id_grupo:2,
			save_as:'cantidad'
		};




		Atributos[4]={
			validacion:{
				name:'precio_referencial_moneda_seleccionada',
				fieldLabel:'Precio Unitario',
				allowBlank:true,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				grid_visible:true,
				grid_editable:true,
				decimalPrecision:6,//para numeros float
				width_grid:90,
				width:'40%',
				align:'right',
				disabled:false,
				grid_indice:11,
				//renderer:render_decimales,
				allowNegative:false,
				allowDecimals:true,
				allowMil:true
			},
			tipo: 'NumberField',
			filtro_0:false,
			save_as:'precio_referencial_moneda_seleccionada',
			id_grupo:2
		};

		// txt id_solicitud_compra
		Atributos[5]={
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

		Atributos[6]={
			validacion:{
				name:'precio_total_moneda_seleccionada',
				fieldLabel:'Precio Total',
				allowBlank:true,
				maxLength:50,
				minLength:0,
				decimalPrecision:2,//para numeros float
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:60,
				width:'40%',
				align:'right',
				disabled:true,
				grid_indice:12,
				//renderer:render_decimales,
				allowNegative:false,
				allowDecimals:true,
				allowMil:true
			},
			tipo: 'NumberField',
			filtro_0:false,
			save_as:'precio_total_moneda_seleccionada',
			id_grupo:2
		};

		

		Atributos[7]={
			validacion:{
				name:'abreviatura',
				fieldLabel:'Unid. Med.',
				allowBlank:true,
				maxLength:20,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:65,
				width:'40%',
				disabled:true,
				grid_indice:9
			},
			tipo: 'TextField',
			form: true,
			filtro_0:false,
			id_grupo:1
		};


		// txt mat_bajo_responsabilidad
		Atributos[8]={
			validacion:{
				name:'mat_bajo_responsabilidad',
				fieldLabel:'Mat. Bajo Resp.',
				allowBlank:true,
				maxLength:2,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:80,
				width:'40%',
				disabled:true,
				grid_indice:16
			},
			tipo: 'TextField',
			filtro_0:true,
			filterColValue:'ITTEM.mat_bajo_responsabilidad',
			id_grupo:1

		};

		
		Atributos[9]={
			validacion:{
				name:'supergrupo',
				fieldLabel:'Supergrupo',
				allowBlank:true,
				//maxLength:50,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:73,
				width:'100%',
				disable:false,
				grid_indice:3
			},
			tipo: 'TextArea',
			form: false,
			filtro_0:false,
			id_grupo:3
		};




		Atributos[10]={
			validacion:{
				name:'grupo',
				fieldLabel:'Grupo',
				allowBlank:true,
				//maxLength:50,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:65,
				width:'100%',
				disable:false,
				grid_indice:4
			},
			tipo: 'TextArea',
			form: false,
			filtro_0:false,
			id_grupo:3
		};



		Atributos[11]={
			validacion:{
				name:'subgrupo',
				fieldLabel:'Subgrupo',
				allowBlank:true,
				//maxLength:50,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:75,
				width:'100%',
				disable:false,
				grid_indice:5
			},
			tipo: 'TextArea',
			form: true,
			filtro_0:false,
			id_grupo:3
		};


		Atributos[12]={
			validacion:{
				name:'id1',
				fieldLabel:'ID1',
				allowBlank:true,
				//maxLength:50,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:40,
				width:'100%',
				disable:false,
				grid_indice:6
			},
			tipo: 'TextArea',
			form: false,
			filtro_0:false,
			id_grupo:3
		};


		Atributos[13]={
			validacion:{
				name:'id2',
				fieldLabel:'ID2',
				allowBlank:true,
				//maxLength:50,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:40,
				width:'100%',
				disable:false,
				grid_indice:7
			},
			tipo: 'TextArea',
			form: false,
			filtro_0:false,
			id_grupo:3
		};


		Atributos[14]={
			validacion:{
				name:'id3',
				fieldLabel:'ID3',
				allowBlank:true,
				//maxLength:50,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:40,
				width:'100%',
				disable:false,
				grid_indice:8
			},
			tipo: 'TextArea',
			form: false,
			filtro_0:false,
			id_grupo:3
		};

		


		Atributos[15]={
			validacion:{
				name:'item',
				fieldLabel:'Item',
				allowBlank:true,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:85,
				width:'100%',
				grid_indice:18
			},
			tipo: 'TextField',
			form: false,
			filtro_0:false,
			id_grupo:3
		};



// txt precio_referencial_estimado
		Atributos[16]={
			validacion:{
				name:'precio_referencial_estimado',
				fieldLabel:'Precio Unitario---',
				allowBlank:false,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision:6,//para numeros float
				allowNegative:false,
				minValue:0.1,
				vtype:'texto',
				grid_visible:false,
				grid_editable:true,
				width_grid:70,
				align:'right',
				width:'40%',
				grid_indice:13,
				//renderer:render_decimales,
				allowNegative:false,
				allowDecimals:true,
				allowMil:true
			},
			tipo: 'NumberField',
			filtro_0:false,
			form:false,
			filterColValue:'SOLDET.precio_referencial_estimado',
			save_as:'precio_referencial_estimado',
			id_grupo:2
		};


		Atributos[17]={
			validacion:{
				name:'precio_total_referencial',
				fieldLabel:'Precio Total',
				allowBlank:true,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:false,
				decimalPrecision:2,//para numeros float
				grid_editable:false,
				width_grid:75,
				width:'40%',
				align:'right',
				disabled:true,
				grid_indice:14,
				//renderer:render_decimales,
				allowNegative:false,
				allowDecimals:true,
				allowMil:true
			},
			tipo: 'NumberField',
			form: true,
			form:false,
			filtro_0:false,
			id_grupo:2
		};
		// txt descripcion
		Atributos[18]={
			validacion:{
				name:'detalle',
				fieldLabel:'Detalle',
				allowBlank:false,
				//maxLength:500,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:true,
				grid_indice:19
			},
			tipo: 'TextArea',
			filtro_0:false,
			filterColValue:'SOLDET.descripcion',
			save_as:'descripcion1',
			id_grupo:4
		};



		Atributos[19]={
			validacion:{
				name:'id_cuenta',
				labelSeparator:'',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false,
				disabled:true
			},
			tipo:'Field',
			filtro_0:false
		};


		Atributos[20]={
			validacion:{
				name:'id_partida',
				labelSeparator:'',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false,
				disabled:true
			},
			tipo:'Field',
			filtro_0:false
		};

		Atributos[21]={
			validacion:{
				name:'desc_cuenta',
				fieldLabel:'Cuenta',
				allowBlank:true,
				//maxLength:500,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false,
				grid_indice:20
			},
			tipo: 'TextArea',
			form: false,
			filtro_0:true,
			filterColValue:'CUENTA.desc_cuenta',
			id_grupo:0
		};


		Atributos[22]={
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
				width_grid:85,
				width:'100%',
				disabled:false,
				grid_indice:21
			},
			tipo: 'TextField',
			form: false,
			filtro_0:true,
			filterColValue:'PARTID.codigo_partida#PARTID.nombre_partida',
			id_grupo:0
		};


		Atributos[23]={
			validacion:{
				name:'especificaciones_tecnicas',
				fieldLabel:'Especificaciones Tecnicas',
				allowBlank:true,
				//maxLength:500,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width_grid:110,
				height:340,
				minHeight:300,
				width:'100%',
				disabled:false,
				grid_indice:3
			},
			tipo: 'TextArea',
			filtro_0:true,
			filterColValue:'SOLDET.especificaciones_tecnicas',
			id_grupo:2
		};
		
		
		Atributos[24]={
			validacion:{
				name:'almacenable',
				fieldLabel:'Almacenable',
				allowBlank:true,
				typeAhead:true,
				loadMask:true,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({
					fields:['ID', 'valor'],
					data:[['si','si'],['no','no']]
				}),
				valueField:'ID',
				displayField:'valor',
				lazyRender:true,
				forceSelection:true,
				grid_visible:true,
				width_grid:80,
				grid_indice:8,
				disabled:true,
				grid_editable:false
			},
			tipo:'ComboBox',
			defecto:'si',
			filterColValue:'SOLDET.almacenable',
			id_grupo:2
		};

		
		
		Atributos[25]={
			validacion:{
				name:'descripcion_item',
				fieldLabel:'Item',
				allowBlank:true,
				//maxLength:20,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:95,
				width:'40%',
				disabled:true,
				grid_indice:2
			},
			tipo: 'TextArea',
			form: true,
			filtro_0:true,
			filterColValue:'ittem.descripcion',
			id_grupo:0
		};
        Atributos[26]={
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
			
			width:'40%',
			disabled:false
			
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'SOLDET.precio_referencial_total_as',
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
	
		var layout_sol_com_bien_det = new DocsLayoutMaestro(idContenedor);
		layout_sol_com_bien_det.init({titulo_maestro:'Solicitud Compra (Maestro)',titulo_detalle:'Detalle de Solicitud (Detalle)',grid_maestro:'grid-'+idContenedor});



		//---------- INICIAMOS HERENCIA
		this.pagina = Pagina;
		this.pagina(paramConfig,Atributos,ds,layout_sol_com_bien_det,idContenedor);
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
		var dialog= this.getFormulario;
		var EstehtmlMaestro=this.htmlMaestro;
		//DEFINICIÓN DE LA BARRA DE MENÚ
		var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
		//DEFINICIÓN DE FUNCIONES

		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/solicitud_compra_det/ActionEliminarSolicitudCompraDet.php'},
			Save:{url:direccion+'../../../control/solicitud_compra_det/ActionGuardarSolicitudCompraDet.php'},
			ConfirmSave:{url:direccion+'../../../control/solicitud_compra_det/ActionGuardarSolicitudCompraDet.php'},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:'85%',minWidth:150,minHeight:200,columnas:['47%','47%'],closable:true,titulo:'Detalle de Item Solicitado',

			grupos:[{tituloGrupo:'Oculto',
			columna:0,
			id_grupo:0
			},{
				tituloGrupo:'Item',
				columna:0,
				id_grupo:1
			},{
				tituloGrupo:'Datos Pedido',
				columna:0,
				id_grupo:2
			},
			{
				tituloGrupo:'Grupo',
				columna:0,
				id_grupo:3
			},{
				tituloGrupo:'Caracteristicas Item',
				columna:1,
				id_grupo:4
			}
			]

			}};



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
				
				Atributos[5].defecto=maestro.id_solicitud_compra;
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
					data=data+'&m_id_detalle='+SelectionsRecord.data.desc_item;

					var ParamVentana={Ventana:{width:'90%',height:'70%'}};
					layout_sol_com_bien_det.loadWindows(direccion+'../../../../sis_adquisiciones/vista/caracteristica/caracteristica_det.php?'+data,'Caracteristicas Adicionales',ParamVentana);
					layout_sol_com_bien_det.getVentana().on('resize',function(){
						layout_sol_com_bien_det.getLayout().layout();
					})
				}
				else{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
				}
			}

			//Para manejo de eventos
			function iniciarEventosFormularios(){
				cmb_Item=getComponente('id_item');
				txt_unidad_medida=getComponente('abreviatura');
				txt_cantidad=getComponente('cantidad');
				txt_mat_bajo_responsabilidad=getComponente('mat_bajo_responsabilidad');

				txt_precio_referencial_moneda_seleccionada=getComponente('precio_referencial_moneda_seleccionada');
				txt_precio_total_moneda_seleccionada=getComponente('precio_total_moneda_seleccionada');
				txt_descripcion=getComponente('detalle');
				txt_descripcion.setSize(350,200);
				
				var onItemSelect=function(e){
					var rec='';
					rec=cmb_Item.lov.getSelect();

					
					txt_precio_referencial_moneda_seleccionada.setValue(rec["costo_estimado"]);
					
					txt_precio_referencial_moneda_seleccionada.markInvalid("Verificar Precio de Mercado");
					if(maestro.id_moneda==maestro.id_moneda_base){
						txt_precio_referencial_moneda_seleccionada.setValue(rec["costo_estimado"]);
					}
					txt_unidad_medida.setValue(rec["nombre_unid_base"]);
					txt_mat_bajo_responsabilidad.setValue(rec["mat_bajo_responsabilidad"]);
					txt_descripcion.setValue(rec["descripcion"] +'\n(Supergrupo: '+rec["nombre_supg"]+'\nGrupo:'+rec["nombre_grupo"]+'\nSubgrupo:'+rec["nombre_subg"]+'\nID1:'+rec["nombre_id1"]+'\nID2:'+rec["nombre_id2"]+'\nID3:'+rec["nombre_id3"]+')');
					if(rec["id_item"]>0){
						get_caracteristicas_item(rec["id_item"]);
						CalcularCostoTotal();
					}

				};


				function get_caracteristicas_item(id_item){
					Ext.Ajax.request({
						url:direccion+"../../../../sis_adquisiciones/control/caracteristica/ActionListarCaracteristicaItem.php?id_item="+id_item,
						method:'GET',
						success:cargar_caracteristicas,
						failure:Cm_conexionFailure,
						timeout:1000000000
					});
				}

				function cargar_caracteristicas(resp){
					var regreso = Ext.util.JSON.decode(resp.responseText)
					var cadena='';
					var cont=regreso.TotalCount;
					Ext.MessageBox.hide();//ocultamos el loading
					for(var k=0; k<cont; k++){
						cadena=cadena+"\n "+ regreso.ROWS[k]['nombre'] +": "+regreso.ROWS[k]['valor']+" "+regreso.ROWS[k]['unidad_medida'];
					}
					txt_descripcion.setValue(txt_descripcion.getValue()+' '+cadena);
				}


				var CalcularCostoTotal = function(e){
				 	var cant = txt_cantidad.getValue();
                    var unit=txt_precio_referencial_moneda_seleccionada.getValue();

					if(unit!=undefined && unit!=null && cant!=undefined && cant!=null){
						txt_precio_total_moneda_seleccionada.setValue(unit*cant);
					}



				};
				
				txt_precio_referencial_moneda_seleccionada.on('blur',CalcularCostoTotal);
				txt_cantidad.on('blur',CalcularCostoTotal);

				cmb_Item.on('change',onItemSelect);
				cmb_Item.on('select',onItemSelect);

			}

			

			this.btnNew=function(){
				CM_ocultarGrupo('Oculto');
				CM_ocultarGrupo('Grupo');
				CM_mostrarGrupo('Item');
				CM_mostrarGrupo('Datos Pedido');
				CM_btnNew();
			}



			this.btnEdit=function(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){
					var SelectionsRecord=sm.getSelected();
					CM_ocultarGrupo('Oculto');
					CM_ocultarGrupo('Grupo');
					CM_mostrarGrupo('Item');
					CM_mostrarGrupo('Datos Pedido');
					getComponente('detalle').setValue(SelectionsRecord.data.item+" \n("+SelectionsRecord.data.supergrupo+" -"+SelectionsRecord.data.grupo+" -"+SelectionsRecord.data.subgrupo+" -"+SelectionsRecord.data.id1+" -"+SelectionsRecord.data.id2+" -"+SelectionsRecord.data.id3+")\n\n"+SelectionsRecord.data.especificaciones_tecnicas);
					CM_btnEdit();
				}else{
					Ext.MessageBox.alert('Estado','Antes debe seleccionar un item');
				}
			}


			//para que los hijos puedan ajustarse al tamaño
			this.getLayout=function(){return layout_sol_com_bien_det.getLayout()};
			//para el manejo de hijos

			this.Init(); //iniciamos la clase madre
			this.InitBarraMenu(paramMenu);
			this.InitFunciones(paramFunciones);
			//para agregar botones

			this.iniciaFormulario();
			iniciarEventosFormularios();
			this.bloquearMenu();
			layout_sol_com_bien_det.getLayout().addListener('layout',this.onResize);
			ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);

}