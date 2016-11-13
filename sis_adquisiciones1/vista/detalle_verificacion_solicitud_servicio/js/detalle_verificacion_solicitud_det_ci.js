/**
 * Nombre:		  	    pagina_detalle_verificacion_solicitud_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-16 11:58:28
 */
function pagina_detalle_verificacion_solicitud_det(idContenedor,direccion,paramConfig,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var componentes= new Array;
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
			if(record.get('reformular')=='verificado'){
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
				grid_visible:true,
				width_grid:100,
			    grid_indice:4	
			},
			tipo: 'Field',
			form: false,
			filtro_0:true,
			filterColValue:'SOLDET.cantidad'
		};
	
	Atributos[4]={
		validacion:{
			name:'precio_referencial_moneda_seleccionada',
			fieldLabel:'Precio Unitario',
			grid_visible:true,
			width_grid:115,
			align:'right',
			grid_indice:5	
		},
		tipo: 'Field',
		form: false,
		filtro_0:false
		
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
				width:'40%',
				align:'right',
				disabled:true,
				grid_indice:6
				
			},
			tipo: 'NumberField',
			form: true,
			filtro_0:false,
			id_grupo:2
		};


		// txt partida_presupuestaria
		Atributos[6]={
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



		Atributos[8]={
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
		Atributos[9]={
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
		Atributos[10]= {
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
		
		Atributos[11]= {
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
		Atributos[12]={
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
		Atributos[13]={
			validacion: {
			name:'reformular',
			fieldLabel:'Reformulación',
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['verificado','verificado'],['aprobado','aprobado']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:140,
			disabled:false,
			grid_indice:11	
		},
		tipo:'ComboBox',
		form: true,
		save_as:'reformular',
		id_grupo:2
	};
		
			
			
	Atributos[14]={
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
		
	Atributos[18]={
		validacion:{
			name:'monto_ref_reformulado',
			fieldLabel:'Precio Total Reformulado Gestión Actual',
			maxLength:18,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:110,
			width:'40%',
			disabled:true,
			grid_indice:13
		},
		tipo: 'NumberField',
		form: true,
		save_as:'monto_ref_reformulado',
		id_grupo:2
	};
		
		
		
		Atributos[16]= {
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
		
		Atributos[17]={
		validacion:{
			name:'monto_ref_reformulado_as',
			fieldLabel:'PT Reformulado Gestión Siguiente',
			allowBlank:false,
			maxLength:18,
			minLength:0,
			selectOnFocus:true,
			grid_visible:true,
			width_grid:100,
			width:'40%',
			align:'right',
			disabled:true
			
		},
		tipo: 'NumberField',
		form: true,
		defecto:0,
		filtro_0:false,
		id_grupo:2
		
	};
	
	Atributos[15]={
		validacion:{
			name:'monto_ref_reformulado_total',
			fieldLabel:'PT Reformulado',
			allowBlank:false,
			maxLength:18,
			minLength:0,
			selectOnFocus:true,
			grid_visible:true,
			width_grid:100,
			width:'40%',
			align:'right',
			disabled:true
			
		},
		tipo: 'NumberField',
		form: false,
		filtro_0:false,
		id_grupo:2
		
	};
	
	Atributos[19]={
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
				disabled:true,
				grid_indice:14
			},
			tipo: 'TextArea',
			form: true,
			filtro_0:true,
			filterColValue:'SOLDET.motivo_ref',
			id_grupo:2
		};
		
			Atributos[20]={
			validacion:{
				name:'precio_referencial_total_as',
				fieldLabel:'Precio Total Gestion Siguiente',
				grid_visible:true,
				width_grid:100,
				align:'right',
				grid_indice:6
				
			},
			tipo: 'Field',
			form:false,
			filtro_0:false
		};
		
		Atributos[21]={
			validacion:{
				name:'total_gestion',
				fieldLabel:'Precio Total Gestion Actual',
				grid_visible:true,
				width_grid:100,
				align:'right',
				grid_indice:6
				
			},
			tipo: 'Field',
			form: false,
			filtro_0:false
		};
		
	//----------- FUNCIONES RENDER
	
	function formatDate(val,cell,record,row,colum,store){
		
			return val?val.dateFormat('d/m/Y'):'';
		
	}

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Seguimiento de Solicitudes (Maestro)',titulo_detalle:'Detalle Solicitud (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_detalle_verificacion_solicitud = new DocsLayoutMaestro(idContenedor);
	layout_detalle_verificacion_solicitud.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_detalle_verificacion_solicitud,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_btnEdit=this.btnEdit;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_getComponente=this.getComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_enableSelect=this.EnableSelect;
	var CM_getBoton=this.getBoton;
	var CM_saveSuccess=this.saveSuccess;
	
//DEFINICIóN DE LA BARRA DE MENú
	var paramMenu={actualizar:{crear:true,separador:false}};
//DEFINICIóN DE FUNCIONES
	
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/solicitud_compra_det/ActionAnularSolicitudCompraDet.php'},
		Save:{url:direccion+'../../../control/detalle_seguimiento_solicitud/ActionGuardarDetalleSeguimientoSolicitud.php',
		success:miFuncionSuccess},
		ConfirmSave:{url:direccion+'../../../control/detalle_seguimiento_solicitud/ActionGuardarDetalleSeguimientoSolicitud.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,columnas:['90%'],grupos:[{tituloGrupo:'Datos',columna:0,id_grupo:0},{tituloGrupo:'Aprobación Presupuesto',columna:0,id_grupo:1},{tituloGrupo:'Verificación Reformulación',columna:0,id_grupo:2}],width:'50%',minWidth:150,minHeight:200,	closable:true,titulo:'Verificacion Presupuestaria de Reformulación'}};
	
		
		
		
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(m){
		maestro=m;
		
	
		//componentes[8].setValue(maestro.id_solicitud_compra);
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_solicitud_compra:maestro.id_solicitud_compra
			}
		};
		this.btnActualizar();
		componentes[7].setValue(maestro.id_solicitud_compra);
		Atributos[7].defecto=maestro.id_solicitud_compra;
		paramFunciones.Save.parametros='&m_id_solicitud_compra='+maestro.id_solicitud_compra;
		
		this.InitFunciones(paramFunciones)
	};
	
	
		
		function miFuncionSuccess(resp)
	{
		if(refo==1){
			
			if(componentes[13].getValue()=='aprobado')
				btn_reporte_solicitud_compra();
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
			layout_detalle_verificacion_solicitud.loadWindows(direccion+'../../../vista/caracteristica/caracteristica_min.php?'+data,'Características Adicionales',ParamVentana);
layout_detalle_verificacion_solicitud.getVentana().on('resize',function(){
			layout_detalle_verificacion_solicitud.getLayout().layout();
				})
		}
		else{
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
	}
		}
		
		
	function btn_reformulacion(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelections();
				CM_ocultarGrupo('Datos');
				CM_ocultarGrupo('Aprobación Presupuesto');
				CM_mostrarGrupo('Verificación Reformulación');
				
				if(CM_getComponente('desc_servicio_reformulado').getValue()==''){
					CM_ocultarComponente(CM_getComponente('desc_servicio_reformulado'));
				}
				if(CM_getComponente('monto_ref_reformulado').getValue()=='' || CM_getComponente('monto_ref_reformulado').getValue()=='0'){
					CM_ocultarComponente(CM_getComponente('monto_ref_reformulado'));
					
					
				}
				refo=1;
				
				if(parseFloat(SelectionsRecord[0].data['monto_ref_reformulado_as'])>0){
				  
				   CM_mostrarComponente(getComponente('monto_ref_reformulado_as'));
				}else{
				  
				   CM_ocultarComponente(getComponente('monto_ref_reformulado_as'));
				}
				
				
				CM_btnEdit();
	}
	
	
	
	function btn_aprobar(){
		
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelections();
		
			CM_ocultarGrupo('Datos');
			CM_ocultarGrupo('Verificación Reformulación');
			
			CM_mostrarGrupo('Aprobación Presupuesto');
			componentes[10].setDisabled(false);
				componentes[7].setDisabled(false);
				componentes[5].setDisabled(false);
				
				
			CM_btnEdit();
			
		
	}
	
	function btn_reporte_solicitud_compra(){
	    	var data='m_id_solicitud_compra='+componentes[7].getValue()+'&tipo_repo=1';
	  		window.open(direccion+'../../../control/solicitud_compra/reporte/ActionPDFSolicitudVerNuevo.php?'+data);
		
	
	}
	
	this.EnableSelect=function(x,z,y){
			
			enable(x,z,y);
				
			}	
		
		
		//Para manejo de eventos
	function iniciarEventosFormularios(){
		for (var i=0;i<Atributos.length;i++){
			
			componentes[i]=CM_getComponente(Atributos[i].validacion.name);
		}
		
	}
	
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_detalle_verificacion_solicitud.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	
	
	
	
	
	//para agregar botones
	
		this.AdicionarBoton("../../../lib/imagenes/list-items.gif",'Características Adicionales',btn_caracteristica,true,'caracteristica','');
		//this.AdicionarBoton('../../../lib/imagenes/cancel.png','Anular Detalle',this.btnEliminar,true,'anular_detalle','');
		this.AdicionarBoton('../../../lib/imagenes/gtuc/imagenes/ok.png','Aprobar Reformulación',btn_reformulacion,true,'reformular_detalle','');
	var CM_getBoton=this.getBoton;
	
	CM_getBoton('reformular_detalle-'+idContenedor).enable();
	//CM_getBoton('anular_detalle-'+idContenedor).enable();
	function salta(){
		ContenedorPrincipal.getPagina(idContenedorPadre).pagina.btnActualizar();
	}
	
	function  enable(sel,row,selected){
				
				var record=selected.data;

				if(selected&&record!=-1){
				       //CM_getBoton('aprobar_verificacion-'+idContenedor).enable();
			           CM_getBoton('reformular_detalle-'+idContenedor).enable();
        			   
					       if(record.reformular=='verificado'){
					       		CM_getBoton('reformular_detalle-'+idContenedor).enable();
					       }
					       else{
					       	 	if(record.monto_aprobado==0 || record.monto_aprobado==''){

					       	 		CM_getBoton('reformular_detalle-'+idContenedor).disable();
					       	 	}
					       	 	else{
					       	 		CM_getBoton('reformular_detalle-'+idContenedor).disable();
					       	 		
					       	 	}
					       }
				       		

				}
				CM_enableSelect(sel,row,selected);
				
			}

	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	this.bloquearMenu();
	layout_detalle_verificacion_solicitud.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}