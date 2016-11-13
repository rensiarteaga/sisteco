/**
 * Nombre:		  	    pagina_detalle_seguimiento_solicitud_det.js
 * Propï¿½sito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creaciï¿½n:		2008-05-16 11:58:28
 */
function pagina_detalle_seguimiento_solicitud_det(idContenedor,direccion,paramConfig,idContenedorPadre,id_rol)
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
		'descripcion_item',
		'partida_presupuestaria',
		'estado_reg',
		'pac_verificado',
		'id_solicitud_compra',
		'desc_solicitud_compra',
		'id_servicio',
		'desc_servicio',
		'id_item',
		'item',
		'desc_item',
		'monto_aprobado',
		'supergrupo',
		'grupo',
		'subgrupo',
		'id1',
		'id2',
		'id3', 'precio_referencial_moneda_seleccionada',
		'precio_total_moneda_seleccionada',
		'precio_total_referencial',
		'especificaciones_tecnicas',
		'abreviatura',
		'codigo_partida',
		'desc_cuenta',
		'reformular',
		'desc_item_reformulado',
		'monto_ref_reformulado',
		'motivo_ref',
		'tipo_servicio',
		'desc_servicio_reformulado','precio_referencial_total_as',
		'total_gestion','gestion','monto_ref_reformulado_as'
		

		]),remoteSort:true});


		// DEFINICIÓN DATOS DEL MAESTRO
	function negrita(val,cell,record,row,colum,store){
			if(record.get('reformular')=='pendiente'){
					return '<span style="color:blue;font-size:8pt">' + val + '</span>';
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
				inputType:'hidden'
				
			},
			tipo: 'Field',
			filtro_0:false
		};

		Atributos[1]={
			validacion:{
				name:'tipo_servicio',
				fieldLabel:'Tipo Servicio',
				grid_visible:true,
				width_grid:100,
				grid_indice:1,
				renderer:negrita
			},
			tipo: 'Field',
			form: false,
			filtro_0:true,
			filterColValue:'TIPSER.nombre'
		};

		Atributos[2]={
			validacion:{
				name:'desc_servicio',
				fieldLabel:'Servicio',
				grid_visible:true,
				width_grid:250,
			    grid_indice:2,
				renderer:negrita	
			},
			tipo: 'Field',
			form: false,
			filtro_0:true,
			filterColValue:'SERVIC.codigo#SERVIC.nombre'
		};

		// txt cantidad
		Atributos[3]={
			validacion:{
				name:'cantidad',
				fieldLabel:'Cantidad',
				allowBlank:false,
				maxLength:18,
				minLength:0,
				decimalPrecision:2,//para numeros float
				selectOnFocus:true,
				grid_visible:true,
				width_grid:100,
				width:'70%',
				align:'right',
				disabled:true,
			    grid_indice:4	
			},
			tipo: 'NumberField',
			form: true,
			filtro_0:true,
			filterColValue:'SOLDET.cantidad'
		};
	
	Atributos[4]={
		validacion:{
			name:'precio_referencial_moneda_seleccionada',
			fieldLabel:'Precio Unitario',
			allowBlank:false,
			maxLength:18,
			minLength:0,
			decimalPrecision:4,//para numeros float
			selectOnFocus:true,
			grid_visible:true,
			width_grid:100,
			width:'70%',
			align:'right',
			disabled:true,
			grid_indice:5	
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
			id_grupo:1
		
	};

		// txt monto_aprobado
		Atributos[5]={
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
				width:'70%',
				align:'right',
				disabled:true,
				grid_indice:6
				
			},
			tipo: 'NumberField',
			form: true,
			filtro_0:false,
			id_grupo:1
		};


		
	Atributos[6]={
		validacion:{
			name:'precio_referencial_total_as',
			fieldLabel:'Precio Total Gestion Siguiente',
			allowBlank:true,
			maxLength:18,
			minLength:0,
			
			selectOnFocus:true,
			grid_visible:true,
			width_grid:100,
			width:'70%',
			align:'right',
			disabled:true
			
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		id_grupo:1
		
	};
	
	
	Atributos[8]={
		validacion:{
			name:'total_gestion',
			fieldLabel:'Precio Total Gestion Actual',
			allowBlank:false,
			maxLength:18,
			minLength:0,
			selectOnFocus:true,
			grid_visible:true,
			width_grid:100,
			width:'70%',
			align:'right',
			disabled:true
			
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		id_grupo:1
		
	};
		
		
		
		
		// txt partida_presupuestaria
		Atributos[9]={
			validacion:{
				name:'codigo_partida',
				fieldLabel:'Partida',
				grid_visible:true,
				width_grid:130,
				grid_indice:9
			},
			tipo: 'Field',
			form: false,
			filtro_0:true,
			filterColValue:'PARTID.codigo_partida#PARTID.nombre_partida'
		};

		
		// txt id_solicitud_compra
		Atributos[7]={
			validacion:{
				name:'id_solicitud_compra',
				labelSeparator:'',
				inputType:'hidden'
			},
			tipo:'Field',
			filtro_0:false
		};



		Atributos[10]={
			validacion:{
				name:'fecha_fin_serv',
				fieldLabel:'Fecha Fin',
				grid_visible:true,
				width_grid:80,
				grid_indice:8,
				renderer:formatDate
			},
			form:false,
			tipo:'Field',
			filtro_0:false
		};

	
	
		// txt estado_reg
		Atributos[11]={
			validacion:{
				name:'estado_reg',
				fieldLabel:'Estado',
				grid_visible:true,
				width_grid:100,
				grid_indice:15
			},
			tipo: 'Field',
			form: false,
			filtro_0:true,
			filterColValue:'SOLDET.estado_reg'
		};
		// txt fecha_reg
		Atributos[12]= {
			validacion:{
				name:'especificaciones_tecnicas',
				fieldLabel:'Especificaciones Técnicas',
				grid_visible:true,
				width_grid:115,
				grid_indice:3,
				renderer:negrita
			},
			form:false,
			tipo:'Field',
			filtro_0:true,
			filterColValue:'SOLDET.especificaciones_tecnicas'
		};
		
		Atributos[13]= {
			validacion:{
				name:'fecha_inicio_serv',
				fieldLabel:'Fecha Inicio',
				grid_visible:true,
				width_grid:80,
				grid_indice:7,
				renderer:formatDate
			},
			form:false,
			tipo:'Field',
			filtro_0:false
		};
		
		// txt partida_presupuestaria
		Atributos[14]={
			validacion:{
				name:'desc_cuenta',
				fieldLabel:'Cuenta',
				grid_visible:true,
				width_grid:130,
				grid_indice:10
			},
			tipo: 'Field',
			form: false,
			filtro_0:true,
			filterColValue:'CUENTA.desc_cuenta'
		};
		
		// txt partida_presupuestaria
		Atributos[15]={
			validacion: {
			name:'reformular',
			fieldLabel:'Reformulación',
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
			width_grid:100,
			disabled:false,
			width:170,
			grid_indice:11	
		},
		tipo:'ComboBox',
		form: true,
		save_as:'reformular',
		id_grupo:2
	};
		
			
			
	Atributos[16]={
		validacion:{
			name:'desc_servicio_reformulado',
			fieldLabel:'Servicio Reformulado',
			maxLength:18,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'70%',
			disabled:true,
			grid_indice:12
		},
		tipo: 'TextArea',
		form: true,
		save_as:'desc_servicio_reformulado',
		id_grupo:2
	};
	
	Atributos[17]={
		validacion:{
			name:'precio_unitario_refo',
			fieldLabel:'Precio Unitario Reformulado',
			allowBlank:false,
			maxLength:18,
			minLength:0,
			decimalPrecision:4,//para numeros float
			selectOnFocus:true,
			grid_visible:false,
			width:'70%',
			align:'right'	
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		id_grupo:2
		
	};
		
	Atributos[18]={
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
			width:'70%',
			disabled:false,
			grid_indice:13
		},
		tipo: 'NumberField',
		form: true,
		
		save_as:'monto_ref_reformulado',
		id_grupo:2
	};
	
	
	 Atributos[19]={
		validacion:{
			name:'monto_ref_reformulado_as',
			fieldLabel:'PT Reformulado Gestión Siguiente',
			allowBlank:false,
			maxLength:18,
			minLength:0,
			selectOnFocus:true,
			grid_visible:true,
			width_grid:100,
			width:'70%',
			align:'right',
			disabled:false
			
		},
		tipo: 'NumberField',
		form: true,
		defecto:0,
		filtro_0:false,
		id_grupo:2
		
	};
	
	
	Atributos[20]={
		validacion:{
			name:'monto_ref_reformulado_ac',
			fieldLabel:'PT Reformulado Gestión Actual',
			allowBlank:false,
			maxLength:18,
			minLength:0,
			selectOnFocus:true,
			grid_visible:true,
			width_grid:100,
			width:'70%',
			align:'right',
			disabled:true
			
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		id_grupo:2
		
	};
		
		Atributos[21]={
			validacion:{
				name:'motivo_ref',
				fieldLabel:'Motivo Reformulación',
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'70%',
				disabled:false,
				grid_indice:14
			},
			tipo: 'TextArea',
			form: true,
			filtro_0:true,
			filterColValue:'SOLDET.motivo_ref',
			id_grupo:2
		};
		Atributos[22]= {
			validacion:{
				name:'abreviatura',
				fieldLabel:'Unid. Med.',
				grid_visible:true,
				width_grid:80,
				grid_indice:3
			},
			form:false,
			tipo:'Field',
			filtro_0:false
		};
	
 
	//----------- FUNCIONES RENDER
	
		function formatDate(val,cell,record,row,colum,store){
		
			return val?val.dateFormat('d/m/Y'):'';
		
	}

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Seguimiento de Solicitudes (Maestro) SErvicios',titulo_detalle:'Detalle Solicitud (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_detalle_seguimiento_solicitud_serv = new DocsLayoutMaestro(idContenedor);
	layout_detalle_seguimiento_solicitud_serv.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_detalle_seguimiento_solicitud_serv,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_btnEdit=this.btnEdit;
	
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_getComponente=this.getComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_enableSelect=this.EnableSelect;
	var CM_saveSuccess=this.saveSuccess;
	
//DEFINICIóN DE LA BARRA DE MENú
	var paramMenu={actualizar:{crear:true,separador:false}};
//DEFINICIóN DE FUNCIONES
	
	var paramFunciones={
		Save:{url:direccion+'../../../control/solicitud_compra_det/ActionGuardarSolicitudDetRef.php',
		success:miFuncionSuccess},
		btnEliminar:{url:direccion+'../../../control/solicitud_compra_det/ActionAnularSolicitudCompraDet.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,columnas:['90%'],grupos:[{tituloGrupo:'Datos',columna:0,id_grupo:0},{tituloGrupo:'Datos Solicitud',columna:0,id_grupo:1},{tituloGrupo:'Datos Reformulacion',columna:0,id_grupo:2}],width:420,minWidth:120,minHeight:200,closable:true,titulo:'Detalle Solicitud(Servicios)'}};
		
	
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(m){
		maestro=m;

		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_solicitud_compra:maestro.id_solicitud_compra,
				vista:1
			}
		};
		this.btnActualizar();
		
		Atributos[7].defecto=maestro.id_solicitud_compra;
		paramFunciones.Save.parametros='&m_id_solicitud_compra='+maestro.id_solicitud_compra;
		paramFunciones.btnEliminar.parametros='&m_id_solicitud_compra='+maestro.id_solicitud_compra;
		paramFunciones.btnEliminar.mensaje='Esta seguro de anular el detalle?';
		this.InitFunciones(paramFunciones)
	};
	function btn_caracteristica(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_solicitud_compra_det='+SelectionsRecord.data.id_solicitud_compra_det;
			
			var ParamVentana={ventana:{width:'90%',height:'70%'}};
			layout_detalle_seguimiento_solicitud_serv.loadWindows(direccion+'../../../vista/caracteristica/caracteristica_min.php?'+data,'Características Adicionales',ParamVentana);
layout_detalle_seguimiento_solicitud_serv.getVentana().on('resize',function(){
			layout_detalle_seguimiento_solicitud_serv.getLayout().layout();
				})
		}
		else{
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
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
	
	function btn_reformulacion(){
		var sm=getSelectionModel();var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelections();
		if(NumSelect==1){
			if(SelectionsRecord[0].data['reformular']=='pendiente'){
				CM_ocultarGrupo('Datos');
				CM_mostrarGrupo('Datos Reformulacion');
				CM_mostrarGrupo('Datos Solicitud');
				if(CM_getComponente('desc_servicio_reformulado').getValue()==''){
					CM_ocultarComponente(CM_getComponente('desc_servicio_reformulado'));
					calPrecio();
				}
				if(CM_getComponente('monto_ref_reformulado').getValue()==''){
					
					CM_ocultarComponente(CM_getComponente('monto_ref_reformulado'));
					CM_ocultarComponente(txt_precio);
					CM_ocultarComponente(txt_cantidad);
					CM_ocultarComponente(txt_precio_total);
					
				}
				
				if(parseFloat(SelectionsRecord[0].data['precio_referencial_total_as'])>0){
				    CM_mostrarComponente(getComponente('total_gestion'));
				    CM_mostrarComponente(getComponente('precio_referencial_total_as'));
				    CM_mostrarComponente(getComponente('monto_ref_reformulado_as'));
				    CM_mostrarComponente(getComponente('monto_ref_reformulado_ac'));
				    getComponente('monto_ref_reformulado_as').reset();
				    getComponente('monto_ref_reformulado_as').allowBlank=false;
				    
				    getComponente('monto_ref_reformulado_as').setValue(getComponente('precio_referencial_total_as').getValue());
				    getComponente('monto_ref_reformulado_ac').setValue(getComponente('monto_ref_reformulado').getValue()-getComponente('monto_ref_reformulado_as').getValue());
				}else{
				    CM_ocultarComponente(getComponente('total_gestion'));
				    CM_ocultarComponente(getComponente('precio_referencial_total_as'));
				    CM_ocultarComponente(getComponente('monto_ref_reformulado_as'));
				    CM_ocultarComponente(getComponente('monto_ref_reformulado_ac'));
				    getComponente('monto_ref_reformulado_as').allowBlank=true;
				    getComponente('monto_ref_reformulado_as').reset();
                    getComponente('monto_ref_reformulado_as').setValue(0);
				    
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
	
	this.EnableSelect=function(x,z,y){
			
			enable(x,z,y);
				
			}	
	function salta(){
		ContenedorPrincipal.getPagina(idContenedorPadre).pagina.btnActualizar();
	}

	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		
				txt_precio=getComponente('precio_unitario_refo');
				txt_precio_total=getComponente('monto_ref_reformulado');
				txt_cantidad=getComponente('cantidad');	
				txt_precio_referencial_total_as=getComponente('precio_referencial_total_as');
				txt_monto_ref_reformulado_ac=getComponente('monto_ref_reformulado_ac');
				txt_monto_ref_reformulado_as=getComponente('monto_ref_reformulado_as');

				var CalPrecioTotal = function(e) {
					var cant = txt_cantidad.getValue();
					var unit = txt_precio.getValue();				
					var tot = txt_precio_total.getValue();

					if(unit!=undefined && unit!=null && cant!=undefined && cant!=null){
						txt_precio_total.setValue(unit*cant);
						txt_precio_total.isValid()
					}
					else{
						
						if(tot!=undefined && tot!=null && cant!=undefined && cant!=null&& cant!=null&& cant!=0){
							txt_precio.setValue(tot/cant);
							txt_precio.isValid()							
						}
						else{
							//txt_precio.setValue('0');
							txt_precio_total.setValue('0');
							
						

						}

					}
				};

				var CalPrecio = function(e) {

					var cant = txt_cantidad.getValue();
					var tot = txt_precio_total.getValue();

					if(tot!=undefined && tot!=null && cant!=undefined && cant!=null&& cant!=null&& cant!=0){
            			txt_precio.setValue(tot/cant);
						txt_precio.isValid()
					}
					else{
						txt_precio.setValue('0');
					}
				};

				txt_precio.on('change',CalPrecioTotal);
				txt_precio_total.on('change',CalPrecio);
				txt_cantidad.on('change',CalPrecioTotal);
				
				
				/*04/05/2009*/
//				if(parseFloat(txt_precio_referencial_total_as)>0){
//				    CM_mostrarComponente(getComponente('precio_referencial_total_as'));
//				    //CM_mostrarComponente(getComponente('precio_referencial_total_ac'));
//				    CM_mostrarComponente(getComponente('total_gestion'));
//				    
//				    getComponente('precio_referencial_total_as').allowBlank=false;
//				    getComponente('precio_referencial_total_as').minValue=0.1;
//				}else{
//				    CM_ocultarComponente(getComponente('precio_referencial_total_as'));
//				    //CM_ocultarComponente(getComponente('precio_referencial_total_ac'));
//				    CM_ocultarComponente(getComponente('total_gestion'));
//                    getComponente('precio_referencial_total_as').allowBlank=true;
//                    getComponente('precio_referencial_total_as').reset();
//				}
				var CalPrecioTotalRef=function(e){
				    var PTgestion_as=txt_monto_ref_reformulado_as.getValue();
				    var PT=txt_precio_total.getValue();
				    if(PT!=null &&PT!=undefined && PTgestion_as!=null&&PTgestion_as!=undefined){
				        txt_monto_ref_reformulado_ac.setValue(PT-PTgestion_as);
				    }
				}
				
		
				txt_monto_ref_reformulado_as.on('change',CalPrecioTotalRef);
				
				
	}
	function calPrecio(){
		var cant = txt_cantidad.getValue();
		var tot = txt_precio_total.getValue();
		txt_precio.setValue(tot/cant);
		txt_precio.isValid()
		
	}

	//para que los hijos puedan ajustarse al tamaï¿½o
	this.getLayout=function(){return layout_detalle_seguimiento_solicitud_serv.getLayout()};
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
				       	//CM_getBoton('anular_detalle-'+idContenedor).enable();
						CM_getBoton('reformular_detalle-'+idContenedor).disable();
        			   if(id_rol==1){
        			   	   		CM_getBoton('anular_detalle-'+idContenedor).enable();
        			   }else{
        			   	   		CM_getBoton('anular_detalle-'+idContenedor).disable();
        			   }
					       if(record.reformular=='pendiente' ){
					    		CM_getBoton('reformular_detalle-'+idContenedor).enable();
					       }
					       {
					       //else 
						       if(record.estado_reg=='anulado' || record.estado_reg=='finalizado'){
						       	//	CM_getBoton('anular_detalle-'+idContenedor).disable();
						       		CM_getBoton('reformular_detalle-'+idContenedor).disable();
						       	}
						       	else{
						       	//	CM_getBoton('anular_detalle-'+idContenedor).enable();
						       	 	
						       	 	
						       }
					       }
				}
		
				CM_enableSelect(sel,row,selected);
				
			}
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	this.bloquearMenu();
	layout_detalle_seguimiento_solicitud_serv.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}