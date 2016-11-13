/**
* Nombre:		  	    pagina_planilla_main.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-05-13 18:03:05
*/
function pagina_planilla(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var on, cotizacion;
	
	var dialog;
	var habilita_hijo='si';
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/planilla/ActionListarPlanilla.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'id_planilla',totalRecords:'TotalCount'
		},[
		'id_planilla',
		'observaciones',
		'estado_reg',
		{name: 'fecha_planilla',type:'date',dateFormat:'Y-m-d'},
		'id_cotizacion',
		'id_depto_tesoro',
		'id_gestion',
		'id_periodo',
		'id_plan_pago','gestion','periodo','id_depto_tesoro','depto_tesoro','tiene_pagos'
		,'plantilla','desc_plantilla','id_moneda','total_pagos_con_doc','descripcion','prov_sin_cta','periodo_rep','cod_depto_rep'
		]),remoteSort:true});

		//carga datos XML
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros
				
			}
		});
		
		var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/gestion/ActionListarGestion.php'}),
		reader: new Ext.data.XmlReader({record:'ROWS',id:'id_gestion',totalRecords:'TotalCount'},['id_gestion','id_empresa','desc_empresa','id_moneda_base','desc_moneda','gestion','estado_ges_gral'])
		});

		function render_id_gestion(value, p, record){return String.format('{0}', record.data['gestion']);}
		var tpl_id_gestion=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','<br><FONT COLOR="#B5A642">{gestion}</FONT>','</div>');

		
		var ds_periodo = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/periodo/ActionListarPeriodo.php'}),
		reader: new Ext.data.XmlReader({record:'ROWS',id:'id_periodo',totalRecords:'TotalCount'},['id_periodo','periodo','periodo_lite'])
		});

		function render_id_periodo(value, p, record){return String.format('{0}', record.data['periodo']);}
		var tpl_id_periodo=new Ext.Template('<div class="search-item">','<b><i>{periodo}</i></b>','<br><FONT COLOR="#B5A642">{periodo_lite}</FONT>','</div>');

		
		var ds_depto_tesoro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamento.php?tesoro=1'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_caja',totalRecords: 'TotalCount'},['id_depto','codigo_depto','nombre_depto'])
		});
		
		function render_id_depto_tesoro(value, p, record){return String.format('{0}', record.data['depto_tesoro']);}
		var tpl_id_depto_tesoro=new Ext.Template('<div class="search-item">','<b><i>{codigo_depto} </b></i>,<br><FONT COLOR="#B5A642">{nombre_depto}</FONT>','</div>');
	
		function render_estado(value, p, record){
			if(value=='borrador'){
				return 'Borrador';
			}
			if(value=='pendiente'){
				return 'Pendiente';
			}
			if(value=='devengado_conta'){
				return 'Devengado en Contabilidad';
			}
			if(value=='devengado_validado'){
				return 'Comprobante Validado';
			}
			if(value=='pagado_validado'){
				return 'Pago Validado';
			}
			if(value=='documento_imp'){
				return 'Documento Impreso';
			}else{
				return 'Finalizado';
			}
		}
		
		
		
		var ds_planilla = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_adquisiciones/control/planilla/ActionListarPlanilla.php?plantilla=si'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_planilla',totalRecords: 'TotalCount'},['id_planilla','descripcion','periodo'])
		});
		
		function render_id_planilla(value, p, record){return String.format('{0}', record.data['desc_plantilla']);}
		var tpl_id_planilla=new Ext.Template('<div class="search-item">','<b><i>{periodo} </b></i>,<br><FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
		
		/////////////////////////
		// Definición de datos //
		/////////////////////////
		// hidden id_proceso_compra
		//en la posición 0 siempre esta la llave primaria

	   Atributos[0]={
			validacion:{
				labelSeparator:'',
				name: 'id_planilla',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'id_planilla',
			id_grupo:0
		};
		
		
	   Atributos[1]={//18
			validacion:{
				name:'descripcion',
				fieldLabel:'Descripción',
				allowBlank:true,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:180,
				width:'60%',
				disabled:false,
				grid_indice:1
			},
			tipo: 'TextArea',
			form:true,
			filtro_0:true,
			filterColValue:'PLANIL.descripcion',
			save_as:'descripcion',
			id_grupo:0
			
		};
		
	
		
		// txt id_tipo_categoria_adq
	 Atributos[2]= {
			validacion:{
				name:'fecha_planilla',
				fieldLabel:'Fecha Planilla',
				allowBlank:true,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Día no válido',
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width_grid:85,
				disabled:true
			},
			form:false,
			tipo:'DateField',
			filtro_0:false,
			filterColValue:'PLANIL.fecha_planilla',
			dateFormat:'m-d-Y',
			defecto:'',
			save_as:'fecha_planilla',
			id_grupo:0
		};

						
	  Atributos[3]={
			validacion:{
				labelSeparator:'',
				name: 'id_cotizacion',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'id_cotizacion',
			id_grupo:0
		};
	    
	  
		
		Atributos[4]={
			validacion:{
				name:'id_gestion',
				fieldLabel:'Gestión',
				allowBlank:false,
				emptyText:'Gestión...',
				desc: 'gestion', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_gestion,
				valueField: 'id_gestion',
				displayField: 'gestion',
				queryParam: 'filterValue_0',
				filterCol:'GESTIO.gestion',
				typeAhead:false,
				tpl:tpl_id_gestion,
				forceSelection:true,
				mode:'remote',
				queryDelay:120,
				pageSize:100,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_gestion,
				grid_visible:true,
				grid_editable:false,
				width_grid:70,
				width:'100%',
				disabled:false,
				grid_indice:3
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'GESTIO.gestion',
			save_as:'id_gestion',
			id_grupo:0
			
		};
		
		
		
		Atributos[5]={
			validacion:{
				name:'id_periodo',
				fieldLabel:'Periodo',
				allowBlank:false,
				emptyText:'Periodo...',
				desc: 'periodo', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_periodo,
				valueField: 'id_periodo',
				displayField: 'periodo_lite',
				queryParam: 'filterValue_0',
				filterCol:'PERIOD.periodo',
				typeAhead:false,
				tpl:tpl_id_periodo,
				forceSelection:true,
				mode:'remote',
				queryDelay:120,
				pageSize:100,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_periodo,
				grid_visible:true,
				grid_editable:false,
				width_grid:80,
				width:'100%',
				disabled:false,
				grid_indice:3
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'PERIOD.periodo',
			save_as:'id_periodo',
			id_grupo:0
			
		};
		
	   
		Atributos[6]={//31
			validacion:{
				name:'id_depto_tesoro',
				fieldLabel:'Departamento encargado de Pago',
				allowBlank:false,
				emptyText:'Depto Tesoreria...',
				desc: 'depto_tesoro', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_depto_tesoro,
				valueField: 'id_depto',
				displayField: 'nombre_depto',
				queryParam: 'filterValue_0',
				filterCol:'DEPTO_TESORO.codigo_depto#DEPTO_TESORO.nombre_depto',
				typeAhead:true,
				tpl:tpl_id_depto_tesoro,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_depto_tesoro,
				grid_visible:true,
				grid_editable:false,
				width_grid:280,
				width:180,
				disabled:false

			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'DEPTO.nombre_depto#DEPTO.codigo_depto',
			save_as:'id_depto_tesoro',
			id_grupo:0
			
		};
		
		
		
		  Atributos[7]={
			validacion:{
				labelSeparator:'',
				fieldLabel:'Estado de Planilla',
				name: 'estado_reg',
				
				grid_visible:true,
				grid_editable:false,
				renderer:render_estado,
				width_grid:180
			},
			tipo: 'TextField',
			form:false,
			filtro_0:false,
			save_as:'estado_reg',
			id_grupo:0
		};
		
		
		Atributos[8]={//
			validacion: {
				name:'plantilla',
				fieldLabel:'Plantilla',
				allowBlank:true,
				typeAhead:true,
				loadMask:true,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','si'],['no','no']]}),
				valueField:'ID',
				displayField:'valor',
				//lazyRender:true,
				forceSelection:true,
				grid_visible:true,
				grid_editable:true,
				width_grid:70,
				//pageSize:100,
				//minListWidth:'100%',
				disabled:false
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:false,
			filterColValue:'PLANTIL.plantilla',
			defecto:'no',
			id_grupo:0
		};
		
		
		Atributos[9]={//31
			validacion:{
				name:'id_plantilla',
				fieldLabel:'Plantilla para Pago',
				allowBlank:true,
				emptyText:'Plantilla de Pago...',
				desc: 'descripcion', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_planilla,
				valueField: 'id_planilla',
				displayField: 'descripcion',
				queryParam: 'filterValue_0',
				filterCol:'PLANIL.descripcion',
				typeAhead:true,
				tpl:tpl_id_planilla,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_planilla,
				grid_visible:true,
				grid_editable:false,
				width_grid:280,
				width:180,
				disabled:false
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'PLANIL.descripcion',
			id_grupo:1
						
		};

		
		Atributos[10]={
			validacion:{
				labelSeparator:'',
				name: 'con_plantilla',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			defecto:'no',
			save_as:'con_plantilla',
			id_grupo:0
		};
		
		
		  Atributos[11]={//18
			validacion:{
				name:'observaciones',
				fieldLabel:'Observaciones',
				allowBlank:true,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:180,
				width:'60%',
				disabled:false
				
			},
			tipo: 'TextArea',
			form:true,
			filtro_0:true,
			filterColValue:'PLANIL.observaciones',
			save_as:'observaciones',
			id_grupo:0
			
		};
	    //////////////////////////////////////////////////////////////
		// ----------            FUNCIONES RENDER    ---------------//
		//////////////////////////////////////////////////////////////
		function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

		//---------- INICIAMOS LAYOUT DETALLE
		var config={titulo_maestro:'Planilla',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_adquisiciones/vista/planilla/planilla_det.php'};
	    layout_planilla=new DocsLayoutMaestroDeatalle(idContenedor);
		layout_planilla.init(config);

		////////////////////////
		// INICIAMOS HERENCIA //
		////////////////////////

		this.pagina=Pagina;
		//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
		this.pagina(paramConfig,Atributos,ds,layout_planilla,idContenedor);
		var getComponente=this.getComponente;
		var getSelectionModel=this.getSelectionModel;
		var CM_saveSuccess=this.saveSuccess;
		var CM_conexionFailure=this.conexionFailure;
		var CM_btnEdit=this.btnEdit;
		var CM_btnNew=this.btnNew;
		var CM_btnEliminar=this.btnEliminar;
		var cmbtnActualizar=this.btnActualizar;
		var Cm_getDialog=this.getDialog;
		var CM_ocultarComponente=this.ocultarComponente;
		var CM_mostrarComponente=this.mostrarComponente;
		var CM_mostrarGrupo=this.mostrarGrupo;
		var CM_ocultarGrupo=this.ocultarGrupo;
		var enableSelect=this.EnableSelect;
		///////////////////////////////////
		// DEFINICIÓN DE LA BARRA DE MENÚ//
		///////////////////////////////////

		var paramMenu={
			guardar:{crear:true,separador:false},
			nuevo:{crear:true,separador:true},
			editar:{crear:true,separador:false},
			eliminar:{crear:true,separador:false},
			actualizar:{crear:true,separador:false}
		};


		//////////////////////////////////////////////////////////////////////////////
		//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
		//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
		//////////////////////////////////////////////////////////////////////////////

		//datos necesarios para el filtro
		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/planilla/ActionEliminarPlanilla.php'},
			Save:{url:direccion+'../../../control/planilla/ActionGuardarPlanilla.php'},
			ConfirmSave:{url:direccion+'../../../control/planilla/ActionGuardarPlanilla.php'},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Planilla',
			grupos:[{	
					tituloGrupo:'Planilla',
					columna:0,
					id_grupo:0
				},
				{	
					tituloGrupo:'Plantilla',
					columna:0,
					id_grupo:0
				}
				]
			}
		};
			//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//



			
			
			//Para manejo de eventos
			function iniciarEventosFormularios(){
				//para iniciar eventos en el formulario
				dialog=Cm_getDialog();
				getSelectionModel().on('rowdeselect',function(){
					
					if(_CP.getPagina(layout_planilla.getIdContentHijo()).pagina.limpiarStore()){
						_CP.getPagina(layout_planilla.getIdContentHijo()).pagina.bloquearMenu()
					}
				})
				cmbGestion=getComponente('id_gestion');
				cmbPeriodo=getComponente('id_periodo');
				cmbPeriodo.disable();
				
				var onGestion =function (e){
					
					//if(parseFloat(e.value)>0){
						cmbPeriodo.modificado=true;
						cmbPeriodo.enable();
						ds_periodo.baseParams={id_gestion:e.value};
						cmbPeriodo.modificado=true;
					//}
				}
				
				cmbGestion.on('change', onGestion);
				cmbGestion.on('select', onGestion);
				
				
				
			}
			
			this.btnEliminar=function(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){
					
					var SelectionsRecord=sm.getSelected();
					if(parseFloat(SelectionsRecord.data.tiene_pagos)>0){
						alert("Para eliminar la planilla es necesario que no existan pagos para la misma");
					}else{
						CM_btnEliminar();
					}
						
				}else{
					Ext.MessageBox.alert('Estado','Antes debe seleccionar un item');
				}
			}
			
			
			this.btnEdit=function(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){
					
					CM_ocultarGrupo('Plantilla');
					CM_mostrarGrupo('Planilla');
					CM_ocultarComponente(getComponente('con_plantilla'));
					var SelectionsRecord=sm.getSelected();
					
					if(parseFloat(SelectionsRecord.data.tiene_pagos)>0){
						getComponente('id_depto_tesoro').disable();
						getComponente('id_gestion').disable();
					}else{
						getComponente('id_depto_tesoro').enable();
						getComponente('id_gestion').enable();
					}
					CM_btnEdit();	
				}else{
					Ext.MessageBox.alert('Estado','Antes debe seleccionar un item');
				}
			}
			
			this.btnNew=function(){
				CM_ocultarGrupo('Plantilla');
				CM_mostrarGrupo('Planilla');
				CM_ocultarComponente(getComponente('con_plantilla'));
				getComponente('id_gestion').enable();
				getComponente('id_depto_tesoro').enable();
				getComponente('id_periodo').disable();
				CM_btnNew();
			}
			
			
			
			function btn_sol_pago(){
				var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				if(NumSelect!=0){

					 var SelectionsRecord=sm.getSelected();
					 
					 if(parseFloat(SelectionsRecord.data.tiene_pagos)==parseFloat(SelectionsRecord.data.total_pagos_con_doc)){
					 
					   	  var data='id_planilla_0='+SelectionsRecord.data.id_planilla;
					   	  
					   	  if (parseFloat(SelectionsRecord.data.prov_sin_cta.length)==0){
					   	  	
					   	  	if(confirm("Está seguro de Solicitar Pago para la Planilla?")){
							Ext.MessageBox.show({
								title: 'Espere por favor...',
								msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Guardando...</div>",
								width:150,
								height:200,
								closable:false
							});

							Ext.Ajax.request({
								url:direccion+"../../../control/planilla/ActionGuardarPlanillaPago.php?"+data,
								method:'GET',
								success:terminado,
								failure:CM_conexionFailure,
								timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
							})
						}
					   	  }else{
					   	  	alert('Los contratistas \n '+( SelectionsRecord.data.prov_sin_cta)+' \n no tienen cuenta bancaria registrada');
					   	  }
						  
					 }else{
					 	Ext.MessageBox.alert('Estado', 'Falta registrar los documentos para '+(parseFloat(SelectionsRecord.data.tiene_pagos)-parseFloat(SelectionsRecord.data.total_pagos_con_doc))+' de los pagos de la plantilla ');
					 }
				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
			
			
			function btn_importar_planilla(){
				var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				if(NumSelect!=0){
					
					var SelectionsRecord=sm.getSelected();

					var data='id_planilla_0='+SelectionsRecord.data.id_planilla;
					getComponente('con_plantilla').setValue('si');
					CM_ocultarComponente(getComponente('con_plantilla'));
					CM_mostrarGrupo('Plantilla');
					CM_ocultarGrupo('Planilla');
					CM_btnEdit();
				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
			
			
			function terminado(resp){
       
					Ext.MessageBox.alert('Estado','Solicitud completada');		
						ds.load({
							params:{
								start:0,
								limit: paramConfig.TamanoPagina,
								CantFiltros:paramConfig.CantFiltros
							}
						});;
				
			}
			
			function btn_reporte_planilla(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					var data='m_id_planilla='+SelectionsRecord.data.id_planilla;
					    data=data+'&m_descripcion='+SelectionsRecord.data.descripcion;
					    data=data+'&m_periodo='+SelectionsRecord.data.periodo;
					    data=data+'&m_gestion='+SelectionsRecord.data.gestion;
					    data= data + '&en_planilla=si';
					    data=data+'&m_periodo_rep='+SelectionsRecord.data.periodo_rep;
					    data=data+'&m_codigo_depto_rep='+SelectionsRecord.data.cod_depto_rep;
					    data=data+'&m_depto_tesoro='+SelectionsRecord.data.depto_tesoro;
					window.open(direccion+'../../../control/cotizacion/reporte/ActionPDFListaPlanilla.php?'+data)
				}
				else{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
			function btn_reporte_planilla_excel(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					var data='m_id_planilla='+SelectionsRecord.data.id_planilla;
					    data=data+'&m_descripcion='+SelectionsRecord.data.descripcion;
					    data=data+'&m_periodo='+SelectionsRecord.data.periodo;
					    data=data+'&m_gestion='+SelectionsRecord.data.gestion;
					    data= data + '&en_planilla=si';
					    data=data+'&m_periodo_rep='+SelectionsRecord.data.periodo_rep;
					    data=data+'&m_codigo_depto_rep='+SelectionsRecord.data.cod_depto_rep;
					    data=data+'&m_depto_tesoro='+SelectionsRecord.data.depto_tesoro;
						data=data+'&reporte_excel=si';
					window.open(direccion+'../../../control/cotizacion/ActionPDFListaPlanilla.php?'+data)
				}
				
				else{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
			function btn_reporte_planilla_uo(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					var data='m_id_planilla='+SelectionsRecord.data.id_planilla;
				if(SelectionsRecord.data.desc_tipo_planilla=='sueldo'){
					window.open(direccion+'../../../control/planilla/ActionPDFSumPlanillaEmpleado.php?'+data)

				   }
				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
			
			
			
			/****************/
			
			var nombre_a='';
			function btn_archivo_pago_consultores(){
				
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					var data='id_planilla='+SelectionsRecord.data.id_planilla;
					var data=data+'&id_subsistema=4';
					//var data=data+'&id_cuenta_bancaria='+SelectionsRecord.data.id_cuenta_bancaria;
					var data=data+'&codigo='+SelectionsRecord.data.codigo;
					
					var data=data+'&nombre=pago_'+SelectionsRecord.data.descripcion+'-'+SelectionsRecord.desc_periodo+'-'+SelectionsRecord.gestion+'.txt';
					nombre='pago_'+SelectionsRecord.data.descripcion+'-'+SelectionsRecord.desc_periodo+'-'+SelectionsRecord.gestion+'.txt';
						Ext.Ajax.request({
						url:direccion+"../../../../sis_kardex_personal/control/planilla/ActionGenerarRPrincipal.php?"+data,
						success:successGenerar,
						failure:CM_conexionFailure,
						timeout:paramConfig.TiempoEspera
					});
					/*Ext.MessageBox.show({
					title: 'Espere Por Favor...',
					msg:"<div><img src='../../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Ejecutando...</div>",
					width:150,
					height:200,
					closable:false
				});*/
			  }
			}
			
	function successGenerar(resp){ 
			
		  window.open(direccion+'../../../../sis_kardex_personal/control/planilla/archivos/consultores/'+nombre);
	}
			

			this.EnableSelect=function(x,z,y){
				
			    _CP.getPagina(layout_planilla.getIdContentHijo()).pagina.reload(y.data);
			     _CP.getPagina(layout_planilla.getIdContentHijo()).pagina.desbloquearMenu();

				
				enable(x,z,y);
		    }
			//para que los hijos puedan ajustarse al tamaño
			this.getLayout=function(){return layout_planilla.getLayout()};
			this.Init(); //iniciamos la clase madre
			this.InitBarraMenu(paramMenu);
			//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
			this.InitFunciones(paramFunciones);
			//para agregar botones
			

			this.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte Resumen UO',btn_reporte_planilla_uo,true,'ver_reporte_planilla_uo','Reporte Resumen Planilla');
	
			
			this.AdicionarBoton('../../../lib/imagenes/copy.png','Importar Planilla',btn_importar_planilla,true,'importar_planilla','Importar Planilla');
			this.AdicionarBoton('../../../lib/imagenes/copy.png','Solicitar Pago',btn_sol_pago,true,'sol_pago','Solicitud de Pago');
			this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprimir Reporte Planilla',btn_reporte_planilla,true,'imprimir_reporte','Planilla');
			this.AdicionarBoton('../../../lib/imagenes/excel_16x16.gif','Imprimir Reporte Planilla',btn_reporte_planilla_excel,true,'imprimir_reporte','Planilla');
		//	this.AdicionarBoton('../../../lib/imagenes/copy.png','Archivo Pago',btn_archivo_pago_consultores,true,'archivo_pago','Archivo de Pago TXT');
			var CM_getBoton=this.getBoton;
			function  enable(sel,row,selected){
				CM_getBoton('sol_pago-'+idContenedor).enable();
				CM_getBoton('importar_planilla-'+idContenedor).enable();
				var record=selected.data; 
				
				if(record.estado_reg=='borrador'){
					habilita_hijo='si';
					if(parseFloat(record.tiene_pagos)>0){
						CM_getBoton('sol_pago-'+idContenedor).enable();
					}else{
						CM_getBoton('sol_pago-'+idContenedor).disable();
					}
					CM_getBoton('importar_planilla-'+idContenedor).enable();
				}else{
					habilita_hijo='no';
					CM_getBoton('sol_pago-'+idContenedor).disable();
					CM_getBoton('importar_planilla-'+idContenedor).disable();
				}
				
				if(habilita_hijo=='si'){
							_CP.getPagina(layout_planilla.getIdContentHijo()).pagina.desbloquearMenu();
						}else{
							_CP.getPagina(layout_planilla.getIdContentHijo()).pagina.bloquearMenu();
						}
				enableSelect(sel,row,selected);
			}
			this.iniciaFormulario();
			iniciarEventosFormularios();
			layout_planilla.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
			ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
