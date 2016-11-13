/**
 * Nombre:		  	    pagina_detalle_verificacion_solicitud_det.js
 * Propï¿½sito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creaciï¿½n:		2008-05-16 11:58:28
 */
function pagina_detalle_verificacion_solicitud_det(idContenedor,direccion,paramConfig,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var componentes= new Array;
	var data1;
	var maestro
	
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
		'id_servicio',
		'desc_servicio',
		'id_item',
		'desc_item',
		'monto_aprobado',
		'supergrupo',
		'id_servicio_reformulado',
		'monto_ref_reformulado',
		'tipo_servicio',
		'reformular',
		'desc_servicio_reformulado',
		'id_partida'
,'especificaciones_tecnicas', 'precio_referencial_moneda_seleccionada',
		'precio_total_moneda_seleccionada',
		'precio_total_referencial'
		]),remoteSort:true});

	
	// DEFINICIï¿½N DATOS DEL MAESTRO

	
	function negrita1(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	
	
	
	
	//DATA STORE COMBOS

   var ds_servicio = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/servicio/ActionListarServicio.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_servicio',totalRecords:'TotalCount'},['id_servicio','nombre','descripcion','fecha_reg','id_tipo_servicio'])
	});

	//FUNCIONES RENDER
	
	function render_id_servicio(value, p, record){if(record.get('reformular')=='verificado'){return '<span style="color:red;font-size:8pt">' + record.data['desc_servicio']+ '</span>';}else {return record.data['desc_servicio'];}}
	function renderRecurso(value, p, record){return String.format('{0}', record.data['partida_presupuestaria']);}
	var tpl_id_servicio=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');

	function negrita(val,cell,record,row,colum,store){
			if(record.get('reformular')=='verificado'){
								
				if(colum=='0'){
					return '<span style="color:blue;font-size:8pt">Reformulación Pendiente</span>';
				}
				else{
					return '<span style="color:blue;font-size:8pt">' + val + '</span>';
				}
			}
			else
			{
				return val;
			}
		}
	
	/////////////////////////
	// Definiciï¿½n de datos //
	/////////////////////////
	
	// hidden id_solicitud_compra_det
	//en la posiciï¿½n 0 siempre esta la llave primaria

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
	
	
 
Atributos[1]={//3
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
		filtro_0:false,
		id_grupo:1,filtro_0:false,filtro_0:true,
		filterColValue:'TIPSER.nombre'
	};
	
	Atributos[2]={//3
		validacion:{
			name:'desc_servicio',
			fieldLabel:'Servicio',
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
		filtro_0:false,filtro_0:true,
		filterColValue:'SERVIC.codigo#SERVIC.nombre',
		id_grupo:1
	};
//	
//	Atributos[2]={//1
//		validacion:{
//			name:'id_servicio',
//			desc:'desc_servicio',
//			fieldLabel:'Servicio',
//			allowBlank:false,
//			maxLength:100,
//			minLength:0,
//			store:ds_servicio,
//			renderer:render_id_servicio,
//			selectOnFocus:true,
//			vtype:"texto",
//			grid_visible:true,
//			grid_editable:false,
//			width_grid:90,
//			width:200,
//			pageSize:10,
//			direccion:direccion,
//			grid_indice:2
//			},
//		tipo:'LovServicio',
//		save_as:'id_servicio',
//		filtro_0:true,
//		defecto:'',
//		filterColValue:'SERVIC.codigo#SERVIC.nombre',
//		id_grupo:1
//	};
	
	// txt fecha_inicio_serv
	Atributos[3]= {//4
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
			width_grid:75,
			disabled:false,
			grid_indice:3	
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'SOLDET.fecha_inicio_serv',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_inicio_serv',
		id_grupo:0
	};
	
	
// txt fecha_fin_serv
	Atributos[4]= {//5
		validacion:{
			name:'fecha_fin_serv',
			fieldLabel:'Fecha Fin',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'DÃ­a no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:70,
			disabled:false,
			grid_indice:4	
		},
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'SOLDET.fecha_fin_serv',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_fin_serv',
		id_grupo:0
	};	
	
	
	
// txt cantidad
	Atributos[5]={//1
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
			disabled:true,
			grid_indice:5,
			renderer:negrita 		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'SOLDET.cantidad',
		save_as:'cantidad',
		id_grupo:1
	};
// txt precio_referencial_estimado
	// txt precio_referencial_estimado
	Atributos[6]={
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
			disable:false,
			grid_indice:4,
			renderer:negrita 		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'SOLDET.precio_referencial_estimado',
		save_as:'precio_referencial_estimado'
	};
	
	Atributos[7]={
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
			id_grupo:2
		};


// txt fecha_fin_serv
	Atributos[8]={//7
		validacion:{
			name:'id_partida',
			desc:'partida_presupuestaria',
			fieldLabel:'Partida Presupuestaria',
			tipo:'gasto',//determina el action a llamar
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true,
			grid_editable:false,
			renderer:renderRecurso,
			width_grid:200,
			width:200,
			pageSize:10,
			grid_indice:8,
			direccion:direccion
		},
		tipo:'LovPartida',
		save_as:'id_partida',
		filtro_0:true,
		filterColValue:'SOLDET.partida_presupuestaria',
		id_grupo:1
		
	};
	
	
	Atributos[9]={//9
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
			grid_visible:true,
			grid_editable:false,
			width_grid:94,
			disabled:false,
			grid_indice:9,
			renderer:negrita 	
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'SOLDET.pac_verificado',
		defecto:'si',
		save_as:'pac_verificado',
		id_grupo:1
	};

	/*Atributos[5]={
		validacion:{
			name:'id_partida',
			desc:'partida',
			fieldLabel:'Partida Presupuestaria',
			tipo:'ingreso',//determina el action a llamar
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true,
			grid_editable:false,
			renderer:renderRecurso,
			width_grid:200,
			width:200,
			pageSize:10,
			direccion:direccion
		},
		tipo:'LovPartida',
		save_as:'id_partida'
	};*/
	
// txt estado_reg
	Atributos[11]={//8
		validacion:{
			name:'estado_reg',
			fieldLabel:'Estado',
			allowBlank:true,
			maxLength:18,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false,
			grid_indice:11,
			renderer:negrita 		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'SOLDET.estado_reg',
		save_as:'estado_reg',
		id_grupo:0
	};
// txt pac_verificado
	
// txt id_solicitud_compra
	Atributos[10]={
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
		save_as:'id_solicitud_compra',
		id_grupo:0
	};



	
	Atributos[12]={//13
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
			width_grid:90,
			disabled:false,
			grid_indice:10,
			renderer:negrita 	
		},
		tipo:'ComboBox',
		form: true,
		save_as:'reformular',
		id_grupo:2
	};
	

	
	// txt reformular
	Atributos[13]={//14
		validacion:{
			name:'desc_servicio_reformulado',
			fieldLabel:'Servicio Reformulado',
			maxLength:18,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'70%',
			disabled:true,
			grid_indice:11,
			renderer:negrita 		
		},
		tipo: 'TextArea',
		form: true,
		save_as:'desc_servicio_reformulado',
		id_grupo:2
	};
	
	// txt monto ref reformulado
	Atributos[14]={//15
		validacion:{
			name:'monto_ref_reformulado',
			fieldLabel:'Precio Total Reformulado',
			maxLength:18,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:115,
			width:'75%',
			disabled:true,
			grid_indice:12,
			renderer:negrita 		
		},
		tipo: 'NumberField',
		form: true,
		save_as:'monto_ref_reformulado',
		id_grupo:2
	};
	
	// txt descripcion
	Atributos[15]={//
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
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
			grid_indice:13,
			renderer:negrita 		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'SOLDET.descripcion',
		save_as:'descripcion',
		id_grupo:0
	};
// txt fecha_reg
	Atributos[16]= {//3
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
			grid_indice:14		
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
	

	
	Atributos[17]={
		validacion:{
			name:'especificaciones_tecnicas',
			fieldLabel:'Especificaciones Tecnicas',
			allowBlank:true,
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
		defecto:' ',
		filterColValue:'SOLDET.especificaciones_tecnicas',
		save_as:'especificaciones_tecnicas'
		
	};
	//----------- FUNCIONES RENDER
	
		function formatDate(val,cell,record,row,colum,store){
		
			return val?val.dateFormat('d/m/Y'):'';
		
	}


	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Seguimiento de Solicitudes (Maestro)',titulo_detalle:'Detalle Solicitud (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_detalle_verificacion_solicitud_serv = new DocsLayoutMaestro(idContenedor);
	layout_detalle_verificacion_solicitud_serv.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_detalle_verificacion_solicitud_serv,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_btnEdit=this.btnEdit;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_getComponente=this.getComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var EstehtmlMaestro=this.htmlMaestro;
	var CM_enableSelect=this.EnableSelect;
	var CM_saveSuccess=this.saveSuccess;
//DEFINICIï¿½N DE LA BARRA DE MENï¿½
	var paramMenu={actualizar:{crear:true,separador:false}};
//DEFINICIï¿½N DE FUNCIONES
	
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/seguimiento_solicitud/ActionEliminarSeguimientoSolicitud.php'},
		Save:{url:direccion+'../../../control/detalle_seguimiento_solicitud/ActionGuardarDetalleSeguimientoSolicitud.php',
		success:miFuncionSuccess},
		ConfirmSave:{url:direccion+'../../../control/detalle_seguimiento_solicitud/ActionGuardarDetalleSeguimientoSolicitud.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,columnas:['90%'],grupos:[{tituloGrupo:'Datos',columna:0,id_grupo:0},{tituloGrupo:'Aprobación Presupuesto',columna:0,id_grupo:1},{tituloGrupo:'Verificación Reformulación',columna:0,id_grupo:1}],width:'50%',minWidth:150,minHeight:200,	closable:true,titulo:'verificacion_presupuestaria'}};
	
	
		

		
		
		
		
		
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
		
		componentes[10].setValue(maestro.id_solicitud_compra);
		Atributos[10].defecto=maestro.id_solicitud_compra;
		paramFunciones.Save.parametros='&m_id_solicitud_compra='+maestro.id_solicitud_compra;
		
		//iniciarEventosFormularios();
		this.InitFunciones(paramFunciones)
	};
	function btn_caracteristica(){
		
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_solicitud_compra_det='+SelectionsRecord.data.id_solicitud_compra_det;
			
			var ParamVentana={ventana:{width:'90%',height:'70%'}};
			layout_detalle_verificacion_solicitud_serv.loadWindows(direccion+'../../../vista/caracteristica/caracteristica_min.php?'+data,'Características Adicionales',ParamVentana);
layout_detalle_verificacion_solicitud_serv.getVentana().on('resize',function(){
			layout_detalle_verificacion_solicitud_serv.getLayout().layout();
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
	
	function btn_aprobar(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelections();
			CM_ocultarGrupo('Datos');
			CM_mostrarGrupo('Aprobación Presupuesto');
			CM_ocultarGrupo('Verificación Reformulación');
			getComponente('precio_total_moneda_seleccionada').setDisabled(false);
			getComponente('id_partida').setDisabled(false);
			getComponente('pac_verificado').setDisabled(false);
			/*componentes[12].setDisabled(false); //monto_aprobado
			componentes[7].setDisabled(false);//id_partida
			componentes[9].setDisabled(false);//pac_verificado*/
			
			CM_btnEdit();
			
		
	}
	function btn_reformulacion(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelections();
				CM_ocultarGrupo('Datos');
				CM_ocultarGrupo('Aprobación Presupuesto');
				CM_mostrarGrupo('Verificación Reformulación');
				/*componentes[12].setDisabled(true);//monto_aprobado
				componentes[7].setDisabled(true);//id_partida
				componentes[9].setDisabled(true);//pac_verificado*/
				
				getComponente('precio_total_moneda_seleccionada').setDisabled(true);
			    getComponente('id_partida').setDisabled(true);
			    getComponente('pac_verificado').setDisabled(true);
				
				if(CM_getComponente('desc_servicio_reformulado').getValue()==''){
					CM_ocultarComponente(CM_getComponente('desc_servicio_reformulado'));
				}
				if(CM_getComponente('monto_ref_reformulado').getValue()==''){
					
					CM_ocultarComponente(CM_getComponente('monto_ref_reformulado'));
				}
				refo=1;
				CM_btnEdit();
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
	this.getLayout=function(){return layout_detalle_verificacion_solicitud_serv.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
		this.AdicionarBoton("../../../lib/imagenes/list-items.gif",'Características Adicionales',btn_caracteristica,true,'caracteristica','');
		//this.AdicionarBoton('../../../lib/imagenes/det.ico','Cambiar Partida',btn_aprobar,true,'aprobar_verificacion','');
		this.AdicionarBoton('../../../lib/imagenes/ok.png','Aprobar Reformulación',btn_reformulacion,true,'reformular_detalle','');
	
	var CM_getBoton=this.getBoton;
	//CM_getBoton('aprobar_verificacion-'+idContenedor).enable();
	CM_getBoton('reformular_detalle-'+idContenedor).enable();	
	
	function salta(){
		ContenedorPrincipal.getPagina(idContenedorPadre).pagina.btnActualizar();
	}
	function  enable(sel,row,selected){
			
			var record=selected.data;

				if(selected&&record!=-1){
				       //CM_getBoton('aprobar_verificacion-'+idContenedor).enable();
			           CM_getBoton('reformular_detalle-'+idContenedor).enable();
        			   
					       if(record.reformular=='verificado'){
					       		//CM_getBoton('aprobar_verificacion-'+idContenedor).disable();
					       }
					       else{
					       	 	if(record.monto_aprobado==0 || record.monto_aprobado==''){

					       	 		CM_getBoton('reformular_detalle-'+idContenedor).disable();
					       	 	}
					       	 	else{
					       	 		CM_getBoton('reformular_detalle-'+idContenedor).disable();
					       	 		//CM_getBoton('aprobar_verificacion-'+idContenedor).disable();
					       	 	}
					       }
				       		

				}
				CM_enableSelect(sel,row,selected);
				
			}	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	this.bloquearMenu();
	layout_detalle_verificacion_solicitud_serv.getLayout().addListener('layout',this.onResize);
	
		//layout_verificacion_presupuestaria.getVentana().addListener('beforehide',salta);
	
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}