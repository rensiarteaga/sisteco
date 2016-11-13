/**
* Nombre:		  	    pagina_cotizacion_det.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-05-28 17:32:15
*/
function pag_cot_serv_dir_det(idContenedor,direccion,paramConfig,idContenedorPadre)
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
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cotizacion_det/ActionListarCotizacionServDet.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_cotizacion_det',
			totalRecords: 'TotalCount'

		}, ['id_cotizacion_det',
		// define el mapeo de XML a las etiquetas (campos)
				'servicio','tipo_servicio','codigo','id_servicio','tipo_servicio','cantidad_solicitada',
		'cantidad','garantia','id_servicio_cotizado','observaciones','precio','tiempo_entrega','observado','codigo','id_cotizacion','nombre_cotizado',
		'num_convocatoria','id_tipo_servicio','id_adjudicacion'
		,'estado','id_proceso_compra','precio_moneda_cotizada','desc_moneda','reg_cabecera','precio_cantidad','id_unidad_medidad_base','abreviatura','especificaciones_tecnicas','reformular'

		]),remoteSort:true});

	//carga datos XML
	
		//DATA STORE COMBOS

		 var ds_servicio = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/servicio/ActionListarServicio_det.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_servicio',totalRecords:'TotalCount'},['id_servicio','nombre','descripcion','fecha_reg','id_tipo_servicio'])
	});

	//FUNCIONES RENDER
	
	function render_id_servicio(value, p, record){return String.format('{0}', record.data['desc_servicio']);}
	var tpl_id_servicio=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');


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
		save_as:'id_cot_det'
	};
	
	
	Atributos[1]={
		validacion:{
			name:'codigo',
			fieldLabel:'Cod Servicio',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:90,
			width:'100%',
			disabled:true,
			grid_indice:1
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false,
		filterColValue:'servic.codigo',
		save_as:'item',
		id_grupo:1
	};
	
	
	Atributos[2]={
		validacion:{
			name:'tipo_servicio',
			fieldLabel:'Tipo Servicio',
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
			grid_indice:2	
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false,
		filterColValue:'',
		save_as:'tipo_servicio',
		id_grupo:0
	};
	
filterCols_servicio=new Array();
	filterValues_servicio=new Array();
	Atributos[3]={
		validacion:{
			name:'id_servicio_cotizado',
			desc:'desc_servicio',
			fieldLabel:'Servicio',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			store:ds_servicio,
			renderer:render_id_servicio,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:false,
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
		save_as:'id_servicio_cotizado',
		filtro_0:true,
		form:true,
		defecto:'',
		filterColValue:'SERVIC.codigo#SERVIC.nombre',
		id_grupo:2
	};
	
	
	
	
	Atributos[4]={
			validacion:{
			name:'cantidad_solicitada',
			fieldLabel:'Cant. Solicitada',
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:0,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:90,
			align:'right',
			width:'40%',
			disabled:true,
			grid_indice:6
		},
		tipo:'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'PROCOMET.cantidad',
		save_as:'cantidad_solicitada',
		id_grupo:1
	};
	
	
// txt cantidad
	Atributos[5]={
		validacion:{
			name:'cantidad',
			fieldLabel:'Cantidad Cotizada',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:0,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'40%',
			align:'right',
			disabled:false,
			grid_indice:7,
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
	Atributos[6]={
		validacion:{
			name:'precio_moneda_cotizada',
			fieldLabel:'Precio Unitario',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:6,//para numeros float
			allowNegative:false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:95,
			width:'40%',
			align:'right',
			disabled:false,
			grid_indice:8,
			renderer:cantidad_cotizada
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'COTDET.precio',
		save_as:'precio',
		id_grupo:3
	};
	
	// txt tiempo_entrega
	Atributos[7]={
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
			grid_indice:8
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'COTDET.tiempo_entrega',
		save_as:'tiempo_entrega',
		id_grupo:0
	};
	
	// txt garantia
	Atributos[8]={
		validacion:{
			name:'garantia',
			fieldLabel:'Garantia',
			allowBlank:false,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'100%',
			disabled:false,
			grid_indice:10,
			renderer:cadenas
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'COTDET.garantia',
		save_as:'garantia',
		id_grupo:3
	};
	
	// txt observado
	Atributos[9]={
			validacion: {
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
			width_grid:85,
			pageSize:100,
			minListWidth:'100%',
			align:'center',
			disabled:false,
			grid_indice:10
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		filterColValue:'COTDET.observado',
		defecto:'si',
		save_as:'observado',
		id_grupo:3
	};
	
		
// txt observaciones
	Atributos[10]={
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
			width_grid:110,
			width:'100%',
			disable:false,
			grid_indice:11
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'COTDET.observaciones',
		save_as:'observaciones',
		id_grupo:3
	};

// txt id_cotizacion
	Atributos[11]={
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
		//defecto:maestro.id_cotizacion,
		save_as:'id_cotizacion',
		id_grupo:0
	};
	
	
	Atributos[12]={
		validacion:{
			name:'servicio',
			fieldLabel:'Servicio',
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
			grid_indice:3
		},
		tipo: 'TextField',
		form:false,
		filtro_0:false,
		filterColValue:'',
		save_as:'tipo_servicio',
		id_grupo:0
	};
	
	
	Atributos[13]={
		validacion:{
			name:'nombre_cotizado',
			fieldLabel:'Servicio Cotizado',
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
			grid_indice:12
		},
		tipo: 'TextField',
		form: true,
		filtro_0:false,
		filterColValue:'',
		save_as:'nombre_cotizado',
		id_grupo:0
	};
	
		
		Atributos[14]={
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
			
		
		Atributos[15]={
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name: 'id_tipo_servicio',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'id_tipo_servicio',
			id_grupo:0
		};
	
		
		Atributos[16]={
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
		
		
		Atributos[17]={
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
		
		
		
		Atributos[18]={
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
			form: true,
			filtro_0:false,
			id_grupo:2
		};
		
		
		Atributos[19]={
			validacion:{
				name:'precio',
				fieldLabel:'Precio Unitario Bs.',
				allowBlank:true,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision:6,//para numeros float
				allowNegative:false,
				minValue:0,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:100,
				width:'40%',
				disabled:true,
				align:'right',
				grid_indice:13
			},
			tipo: 'NumberField',
			form: true,
			filtro_0:false,
			save_as:'precio_',
			id_grupo:2
		};
		
		
		Atributos[20]={
			validacion:{
				name:'precio_cantidad',
				fieldLabel:'Precio Total',
				allowBlank:false,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				
				allowNegative:false,
				minValue:0,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width_grid:85,
				width:'40%',
				disabled:false,
				align:'right',
				grid_indice:9,
				renderer:precio_cotizado
			},
			tipo: 'NumberField',
			form:false,
			filtro_0:false,
			filterColValue:'precio_cantidad',
			save_as:'precio_total',
			id_grupo:3
		};

		
	Atributos[21]={
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_servicio',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_servicio'
	};
	
	
	Atributos[22]={
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name: 'abreviatura',
				fieldLabel:'Unidad Medida',
				inputType:'hidden',
				grid_visible:true,
				grid_editable:false,
				grid_indice:5,
				width_grid:75
			},
			tipo: 'Field',
			filtro_0:true,
			filterColValue:'unimed.abreviatura',
			id_grupo:0
		};
		
	// txt observaciones
		Atributos[23]={
			validacion:{
				name:'especificaciones_tecnicas',
				fieldLabel:'Especificaciones Tecnicas',
				allowBlank:true,
				maxLength:500,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:150,
				width:'100%',
				disable:false,
				grid_indice:3
			},
			tipo: 'TextArea',
			form:true,
			filtro_0:true,
			filterColValue:'SOLDET.especificaciones_tecnicas',
			save_as:'especificaciones_tecnicas',
			id_grupo:0
		}
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
		var config={titulo_maestro:'Cotizaciones ',grid_maestro:'grid-'+idContenedor};
		var layout_cot_serv_dir_det = new DocsLayoutMaestro(idContenedor,idContenedorPadre);
		layout_cot_serv_dir_det.init(config);



		//---------- INICIAMOS HERENCIA
		this.pagina = Pagina;
		this.pagina(paramConfig,Atributos,ds,layout_cot_serv_dir_det,idContenedor);
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
			ConfirmSave:{url:direccion+'../../../control/cotizacion_det/ActionGuardarCotizacionDet.php',success:salta},
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



			function cargar_maestro(){
				data1=[['Nº Cotizacion',ds_maestro.getAt(0).get('num_cotizacion')],  ['Categoria',ds_maestro.getAt(0).get('desc_tipo_categoria_adq')],
				['Forma Pago',ds_maestro.getAt(0).get('forma_pago')],['Proveedor',ds_maestro.getAt(0).get('desc_proveedor')],   ['Lugar Entrega',ds_maestro.getAt(0).get('lugar_entrega')],['Moneda',ds_maestro.getAt(0).get('desc_moneda')]  ];
				Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data1));
			}

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
				iniciarEventosFormularios();


				Atributos[11].defecto=maestro.id_cotizacion;

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
//		var verificarCant=function(e){
//						if(e.column==4){
//							
//							if(parseFloat(e.record.data.cantidad_solicitada)>=parseFloat(e.record.data.cantidad)){
//					    	}else{
//					   			//if((parseFloat(e.value))>(parseFloat(e.record.data.cantidad))){
//					   			//getComponente('cantidad').markInvalid('Cantidad excesiva...'); 
//					   			Ext.MessageBox.alert('Cantidad','la cantidad a cotizar no debe ser mayor a '+e.record.data.cantidad_solicitada);
//						        	  e.record.set('cantidad', e.originalValue);
//								   }
//					   			//}
//				    	  }
//					}

                

                var verificarCant=function(e){
                    
					if(e.column==6){
                        if(parseFloat(e.record.data.reformular)==0){
						    if(parseFloat(e.record.data.cantidad_solicitada)>=parseFloat(e.record.data.cantidad)){
						      e.record.set('precio_cantidad',(e.record.data.cantidad*e.record.data.precio_moneda_cotizada));
						    }else{
							  Ext.MessageBox.alert('Cantidad','la cantidad a cotizar no debe ser mayor a '+e.record.data.cantidad_solicitada);
							 e.record.set('cantidad', e.originalValue);
						    }
                        }else{
                            Ext.MessageBox.alert('Cantidad','No se puede modificar el registro porque está en reformulación');
                            e.record.set('cantidad', e.originalValue);
                        }
					}
				}
				
				
				var verificarPrec=function(e){
				    
					if(e.column==7){
                      if(parseFloat(e.record.data.reformular)==0){
						if(parseFloat(e.record.data.precio_moneda_cotizada)>=0){
						    e.record.set('precio_cantidad',(e.record.data.cantidad*e.record.data.precio_moneda_cotizada));
						    
						}else{
							e.record.set('cantidad', e.originalValue);
						}
                      }else{
                          Ext.MessageBox.alert('Cantidad','No se puede modificar el registro porque está en reformulación');
                          e.record.set('cantidad', e.originalValue);
                      }
					}
				}
				
				var verificarPrecTot=function(e){
				    
					if(e.column==8){
                      if(parseFloat(e.record.data.reformular)==0){
						if((parseFloat(e.record.data.precio_cantidad)>=0) && parseFloat(e.record.data.cantidad)>0){
						    e.record.set('precio_moneda_cotizada',(e.record.data.precio_cantidad/e.record.data.cantidad));
						    
						}else{
							e.record.set('cantidad', e.originalValue);
						}
                      }else{
                          Ext.MessageBox.alert('Cantidad','No se puede modificar el registro porque está en reformulación');
                          e.record.set('cantidad', e.originalValue);
                      }
					}
				}

				gridG=getGrid();
				gridG.on('afteredit',verificarCant);
				gridG.on('afteredit',verificarPrec);
				gridG.on('afteredit',verificarPrecTot);
				
				//gridG=getGrid();
				//gridG.on('afteredit',verificarCant);
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

			function salta(resp){
			    ContenedorPrincipal.getPagina(idContenedorPadre).pagina.btnActualizar();
			}

			//para que los hijos puedan ajustarse al tamaño
			this.getLayout=function(){return layout_cot_serv_dir_det.getLayout()};
			//para el manejo de hijos

			this.Init(); //iniciamos la clase madre
			this.InitBarraMenu(paramMenu);
			this.InitFunciones(paramFunciones);
			//para agregar botones
			
			this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Otras Ofertas',btn_otro,true,'otro','Otras Ofertas');
			var CM_getBoton=this.getBoton;
			
			//CM_getBoton('cotizar_otro_item-'+idContenedor).enable();

			function  enable(sel,row,selected){
				var record=selected.data;
				if(selected&&record!=-1){
				    
 			    if(maestro.estado_vigente=='cotizado'){
				        
				   }else{
				       if(maestro.estado_vigente=='invitado'|| maestro.estado_vigente=='aperturado'){
				           if( maestro.id_moneda>0 && maestro.precio_total>0&&maestro.fecha_cotizacion!='' && parseFloat(record.reg_cabecera)>0){
				               CM_getBoton('guardar-'+idContenedor).enable();
    				           CM_getBoton('actualizar-'+idContenedor).enable();
				           }else{
				                CM_getBoton('guardar-'+idContenedor).disable();
    				            CM_getBoton('actualizar-'+idContenedor).disable();
				                alert('Antes se debe definir y guardar los datos de la propuesta en la cabecera marcados con rojo');
				                
				           }
				        }else{

				        }
				    }
				    
				}
				enableSelect(sel,row,selected);
			}

			
			
			this.iniciaFormulario();
			iniciarEventosFormularios();
			this.bloquearMenu();
			layout_cot_serv_dir_det.getLayout().addListener('layout',this.onResize);
			layout_cot_serv_dir_det.getVentana().addListener('beforehide',salta);
			ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);

}
