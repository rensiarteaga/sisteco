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
		,'plantilla','desc_plantilla','id_moneda','total_pagos_con_doc'
		]),remoteSort:true});

		//carga datos XML
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				sw_planilla_conta:'si'
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
			if(value=='pendiente'){
				return 'Pendiente';
			}
			if(value=='devengado_conta'){
				return 'Devengado en Contabilidad'		;
			}
			if(value=='devengado_validado'){
				return 'Devengado Validado'		;
			}
			if(value=='pagado_conta'){
				return 'Pagado en Contabilidad'		;
			}
			if(value=='pagado_validado'){
				return 'Pagado Validado'		;
			}
			if(value=='documento_imp'){
				return 'Documento Impreso'		;
			}
			if(value=='finalizado'){
				return 'Finalizado'		;
			}
		}

		var ds_planilla = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_adquisiciones/control/planilla/ActionListarPlanilla.php?plantilla=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_planilla',totalRecords: 'TotalCount'},['id_planilla','observaciones','periodo'])
		});
		
		function render_id_planilla(value, p, record){return String.format('{0}', record.data['desc_plantilla']);}
		var tpl_id_planilla=new Ext.Template('<div class="search-item">','<b><i>{periodo} </b></i>,<br><FONT COLOR="#B5A642">{observaciones}</FONT>','</div>');
		
		var ds_cuenta_bancaria = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_tesoreria/control/cuenta_bancaria/ActionListarCuentaBancaria.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta_bancaria',totalRecords: 'TotalCount'},
			['id_cuenta_bancaria','id_institucion','desc_institucion'
			,'id_cuenta','desc_cuenta','id_auxiliar'
			,'desc_auxiliar','nro_cheque','estado_cuenta'
			,'nro_cuenta_banco','id_moneda','nombre_moneda','gestion'
			]),baseParams:{m_sw_combo:'combo'}});		
			
		function render_transaccion(value, p, record){	
			if(value=='transferencia'){return 'TRANSFERENCIA';}
			if(value=='cheque'){return 'CHEQUE';}		
		}
			
		function render_id_cuenta_bancaria(value, p, record){rf = ds_cuenta_bancaria.getById(value);
			if(rf!=null){record.data['cuenta_bancaria'] =rf.data['desc_cuenta'];}
				return String.format('{0}', record.data['cuenta_bancaria']);
		}		
		
		var tpl_id_cuenta_bancaria=new Ext.Template('<div class="search-item">'
		,'<b>Cuenta: </b><FONT COLOR="#B5A642">{nro_cuenta_banco}</FONT><br>',
		'<b>Banco: </b><FONT COLOR="#B5A642">{desc_institucion}</FONT><br>',
		'<b>Auxiliar: </b><FONT COLOR="#B5A642">{desc_auxiliar}</FONT><br>',
		'<b>Gestión: </b><FONT COLOR="#B5A642">{gestion}</FONT>',
		'</div>');
		
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
				disabled:false,
				grid_indice:1
			},
			tipo: 'TextArea',
			form:false,
			filtro_0:true,
			filterColValue:'PLANIL.observaciones',
			save_as:'observaciones',
			id_grupo:0
			
		};
		
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
			form: false,
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
			form: false,
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
			form: false,
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
			form: false,
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
				desc: 'observaciones', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_planilla,
				valueField: 'id_planilla',
				displayField: 'observaciones',
				queryParam: 'filterValue_0',
				filterCol:'PLANIL.observaciones',
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
			form: false,
			filtro_0:true,
			filterColValue:'PLANIL.observaciones',
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
		
		Atributos[11]={
				validacion:{
				name:'id_cuenta_bancaria',
				fieldLabel:'Cuenta Bancaria',
				allowBlank:true,			
				emptyText:'Cuenta Bancaria...',
				desc: 'cuenta_bancaria', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_cuenta_bancaria,
				valueField: 'id_cuenta_bancaria',
				displayField: 'nro_cuenta_banco',
				queryParam: 'filterValue_0',
				filterCol:'CUENTA.nro_cuenta#CUENTA.descripcion#CUEBAN.nro_cuenta_banco',
				typeAhead:true,
				tpl:tpl_id_cuenta_bancaria,
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
				renderer:render_id_cuenta_bancaria,
				grid_visible:false,
				grid_editable:true,
				width_grid:100,
				width:250,
				disabled:false		
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'CUENTA_8.nro_cuenta#CUENTA_8.descripcion##CUEBAN_8.nro_cuenta_banco',
			save_as:'id_cuenta_bancaria',
			id_grupo:0
		};
		
		Atributos[12]={
			validacion:{
				name:'tipo_cheque',
				fieldLabel:'Transacción',
				allowBlank:true,
				align:'left', 
				emptyText:'Transacci...',
				loadMask:true,
				maxLength:50,
				minLength:0,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['transferencia','TRANSFERENCIA'],['cheque','CHEQUE']]}),
				valueField:'ID',
				displayField:'valor',
				mode:'local',
				lazyRender:true,			
				forceSelection:true,
				grid_visible:false,
				renderer:render_transaccion,
				grid_editable:true,
				width_grid:200,
				minListWidth:200,
				disabled:false
			},
			tipo:'ComboBox',
			form: true,
			save_as:'tipo_cheque',
			id_grupo:0
		};
	    //////////////////////////////////////////////////////////////
		// ----------            FUNCIONES RENDER    ---------------//
		//////////////////////////////////////////////////////////////
		function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

		//---------- INICIAMOS LAYOUT DETALLE
		var config={titulo_maestro:'Planilla',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_contabilidad/vista/planilla/planilla_det.php'};
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
		//var ClaseMadre_conexionFailure=this.conexionFailure;
		///////////////////////////////////
		// DEFINICIÓN DE LA BARRA DE MENÚ//
		///////////////////////////////////

		var paramMenu={
			/*guardar:{crear:true,separador:false},
			nuevo:{crear:true,separador:true},
			editar:{crear:true,separador:false},
			eliminar:{crear:true,separador:false},*/
			actualizar:{crear:true,separador:false}
		};


		//////////////////////////////////////////////////////////////////////////////
		//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
		//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
		//////////////////////////////////////////////////////////////////////////////

		//datos necesarios para el filtro
		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/planilla/ActionEliminarPlanilla.php'},
			//Save:{url:direccion+'../../../control/planilla/ActionGuardarPlanilla.php'},
			Save:{url:direccion+'../../../../sis_adquisiciones/control/planilla/ActionDefinirCuentaBancariaTransaccion.php'},
			ConfirmSave:{url:direccion+'../../../control/planilla/ActionGuardarPlanilla.php'},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:200,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Planilla',
				grupos:[{	
					tituloGrupo:'Planilla',
					columna:0,
					id_grupo:0
				}]
			}
		};
			
		//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
		//Para manejo de eventos
		function iniciarEventosFormularios(){
				//para iniciar eventos en el formulario
			dialog=Cm_getDialog();
			getSelectionModel().on('rowdeselect',function(){	
				if(_CP.getPagina(layout_planilla.getIdContentHijo()).pagina.limpiarStore()){}
			})
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
			CM_btnNew();
		}
			
		function btn_retroceder(){
			var sm=getSelectionModel();
			var filas=ds.getModifiedRecords();
			var cont=filas.length;
			var NumSelect=sm.getCount();
			
			if(NumSelect!=0){
				 var SelectionsRecord=sm.getSelected();
				 var data='id_planilla_0='+SelectionsRecord.data.id_planilla;
				 data=data+'&estado_reg_0=borrador';
					  
				 if(confirm("Está seguro de cambiar el estado a borrador?")){
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
				Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
			} 
		}
		
		function btn_cont_devengado(){
			var sm=getSelectionModel();
			var filas=ds.getModifiedRecords();
			var cont=filas.length;
			var NumSelect=sm.getCount();
			
			if(NumSelect!=0){
				 var SelectionsRecord=sm.getSelected();
				 var data='id_planilla_0='+SelectionsRecord.data.id_planilla;
				 data=data+'&estado_reg_0=devengado_conta';
					  
				 if(confirm("Está seguro de cambiar el estado a contabilizar devengado?")){
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
				Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
			} 
		}
	
	/****************************************Reporte Cheques ***********************/	
	function btn_imprimir_cheques(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();		
			if(NumSelect!=0){	
					Ext.Ajax.request({
					url:direccion+"../../../control/cheque/ActionListarCuentaBancariaChequePlanilla.php",
					success:cargar_respuesta,
					params:{'id_planilla':SelectionsRecord.data.id_planilla,'tipo_reporte':'cheques_x_cuenta_bancaria'},
					failure:CM_conexionFailure,
					timeout:paramConfig.TiempoEspera
				})
		      }
			else
			{
				Ext.MessageBox.alert('Estado','Debe seleccionar una planilla.')
		    }
		}
	
	function cargar_respuesta(resp){
		Ext.MessageBox.hide();
		if(resp.responseXML !=undefined && resp.responseXML !=null && resp.responseXML.documentElement !=null && resp.responseXML.documentElement !=undefined){
			var root=resp.responseXML.documentElement;
			var totalcuentas = root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue
			
			if (totalcuentas!=0){
				for (i = 0; i < totalcuentas; i++){ 
 					var id_cuenta_bancaria = root.getElementsByTagName('id_cuenta_bancaria')[i].firstChild.nodeValue; 
 					var data='id_cuenta_bancaria='+id_cuenta_bancaria;
 					//window.open(direccion+'../../../control/cheque/reporte/ActionPDFChequeVarios.php?'+data);
 					window.open(direccion+'../../../../sis_tesoreria/control/avance/reporte/ActionPDFChequePrueba.php?'+data);
				} 
			}else {
				Ext.MessageBox.alert('Mensaje','No existe cheques relacionados a la planilla')
			}
			
		}
	}			
	
	function btn_imprimir_cheque(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();		
		if(NumSelect!=0){	
				Ext.Ajax.request({
				url:direccion+"../../../control/cheque/ActionListarChequesMonedasPlanilla.php",
				success:cargar_respuesta_cheque,
				params:{'id_planilla':SelectionsRecord.data.id_planilla,'tipo_reporte':'cheques_x_planilla'},
				failure:CM_conexionFailure,
				timeout:paramConfig.TiempoEspera
			})
		}else{
			Ext.MessageBox.alert('Estado','Debe seleccionar una planilla.')
	    }
	}
	
	function cargar_respuesta_cheque(resp){
		Ext.MessageBox.hide();
		if(resp.responseXML !=undefined && resp.responseXML !=null && resp.responseXML.documentElement !=null && resp.responseXML.documentElement !=undefined){
			var root=resp.responseXML.documentElement;
			var totalcuentas = root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue
			
			if (totalcuentas!=0){	
				for (i = 0; i < totalcuentas; i++){ 
 					var id_cheque = root.getElementsByTagName('id_cheque')[i].firstChild.nodeValue; 
 					var id_moneda = root.getElementsByTagName('id_moneda')[i].firstChild.nodeValue; 
 					var data='m_id_cheque='+id_cheque;
 					    data=data+'&m_id_moneda='+id_moneda;
 					//window.open(direccion+'../../../control/cheque/reporte/ActionPDFChequeVarios.php?'+data);
 					window.open(direccion+'../../../../sis_tesoreria/control/avance/reporte/ActionPDFCheque.php?'+data);
				} 	
			}else {
				Ext.MessageBox.alert('Mensaje','No existe cheques relacionados a la planilla')
			}	
		}
	}			
	
	/****************************************fin Reportes de Cheques ***********************/
	function btn_cont_pago(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		 
		if(NumSelect!=0){
			 var SelectionsRecord=sm.getSelected();
			 var data='id_planilla_0='+SelectionsRecord.data.id_planilla;
			 data=data+'&estado_reg_0=pagado_conta';
			 
			 if(confirm("Está seguro de cambiar el estado a contabilizar pago?")){
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
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		} 
	}	
			
	function btn_planilla(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_planilla='+SelectionsRecord.data.id_planilla;
			  	data=data+'&m_sw_banco=no';
			  	data=data+'&id_planilla_0='+SelectionsRecord.data.id_planilla;
			  	data=data+'&estado_reg_0=pagado_conta';
		 	window.open(direccion+'../../../control/planilla/reporte/ActionPDFPlanilla.php?'+data);				
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	} 
	
	function btn_planilla_banco(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_planilla='+SelectionsRecord.data.id_planilla;
				data=data+'&id_planilla_0='+SelectionsRecord.data.id_planilla;
			  	data=data+'&m_sw_banco=si';
			  	data=data+'&estado_reg_0=documento_imp';
			  	
		 	window.open(direccion+'../../../control/planilla/reporte/ActionPDFPlanilla.php?'+data);
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
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
		
	function btn_finalizar(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){

			var SelectionsRecord=sm.getSelected();
			var data='id_planilla_0='+SelectionsRecord.data.id_planilla;
			  	data=data+'&estado_reg_0=finalizado';
			  	
		 	window.open(direccion+'../../../control/planilla/reporte/ActionPDFPlanilla.php?'+data);
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
		else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
		
	function terminado(resp){ 
		Ext.MessageBox.alert('Estado','Solicitud completada');		
		ds.load({
			params:{start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					sw_planilla_conta:'si'
					}
			});
	}
	
	function btn_cueban(){
		CM_btnEdit();
	}

	this.EnableSelect=function(x,z,y){
		//acciones hijo
	    _CP.getPagina(layout_planilla.getIdContentHijo()).pagina.reload(y.data);
		_CP.getPagina(layout_planilla.getIdContentHijo()).pagina.bloquearMenu();
		
	    if( y.data['estado_reg']=='pendiente'){ 
	    	_CP.getPagina(layout_planilla.getIdContentHijo()).pagina.desbloquearMenu();
	    }
	       
	    else if (y.data['estado_reg']=='devengado_conta' ||y.data['estado_reg']=='devengado_validado' ){		    	
	    	_CP.getPagina(layout_planilla.getIdContentHijo()).pagina.getBoton('guardar-'+layout_planilla.getIdContentHijo()).enable();			    	
    	}

	    _CP.getPagina(layout_planilla.getIdContentHijo()).pagina.getBoton('actualizar-'+layout_planilla.getIdContentHijo()).enable();			    					
		
	    //acciones padre	
	    enableSelect(x,z,y);	
	    _CP.getPagina(idContenedor).pagina.bloquearMenu();	
	    
		if( y.data['estado_reg']=='pendiente' ){
		 	 _CP.getPagina(idContenedor).pagina.getBoton('retroceder-'+idContenedor).enable();
			 _CP.getPagina(idContenedor).pagina.getBoton('cont_devengado-'+idContenedor).enable();	
			 _CP.getPagina(idContenedor).pagina.getBoton('cueban-'+idContenedor).enable();
		}
		
		else if( y.data['estado_reg']=='devengado_validado' ){
		 	 _CP.getPagina(idContenedor).pagina.getBoton('cont_pago-'+idContenedor).enable();
		}	
		
		else if( y.data['estado_reg']=='pagado_validado' ){
	 	 	_CP.getPagina(idContenedor).pagina.getBoton('imprimir_reporte_banco-'+idContenedor).enable();
	 	 	_CP.getPagina(idContenedor).pagina.getBoton('imprimir_reporte-'+idContenedor).enable();
	 	 	_CP.getPagina(idContenedor).pagina.getBoton('imprimir_cheque-'+idContenedor).enable();
	 	 	_CP.getPagina(idContenedor).pagina.getBoton('imprimir_cheques-'+idContenedor).enable();
 	 	}
		
 	 	else if(y.data['estado_reg']=='documento_imp'){
 	 		_CP.getPagina(idContenedor).pagina.getBoton('imprimir_reporte_banco-'+idContenedor).enable();
 		 	_CP.getPagina(idContenedor).pagina.getBoton('imprimir_reporte-'+idContenedor).enable();
 	 		_CP.getPagina(idContenedor).pagina.getBoton('imprimir_cheque-'+idContenedor).enable();
 	 		_CP.getPagina(idContenedor).pagina.getBoton('imprimir_cheques-'+idContenedor).enable();
 	 		_CP.getPagina(idContenedor).pagina.getBoton('finalizar-'+idContenedor).enable();	
 	 	}	
		_CP.getPagina(idContenedor).pagina.getBoton('actualizar-'+idContenedor).enable();				    						
    }
			
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_planilla.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	
	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/copy.png','Retroceder',btn_retroceder,true,'retroceder','Retroceder');
	this.AdicionarBoton('../../../lib/imagenes/copy.png','Contabilizar Devengado',btn_cont_devengado,true,'cont_devengado','Contabilizar Devengado');
	this.AdicionarBoton('../../../lib/imagenes/copy.png','Contabilizar Pago',btn_cont_pago,true,'cont_pago','Contabilizar Pago');
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprimir Reporte Planilla',btn_planilla,true,'imprimir_reporte','Planilla');
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprimir Reporte Planilla Banco',btn_planilla_banco,true,'imprimir_reporte_banco','Planilla Banco');
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprimir Cheques',btn_imprimir_cheques,true,'imprimir_cheques','Imprimir Cheques');
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprimir Cheque',btn_imprimir_cheque,true,'imprimir_cheque','Imprimir Cheque');
	//en esta funcion cont_cheque
	this.AdicionarBoton('../../../lib/imagenes/copy.png','Finalizar',btn_finalizar,true,'finalizar','Finalizar');
	this.AdicionarBoton('../../../lib/imagenes/copy.png','Permite establecer una Cuenta Bancaria para todas las personas de la Planilla',btn_cueban,true,'cueban','Cuenta Bancaria');
	
	var CM_getBoton=this.getBoton;
 
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_planilla.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
