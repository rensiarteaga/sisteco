/**
 * Nombre:		  	    pagina_registro_transacion.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-09-16 17:57:09
 */
function pagina_ProcesoFacturacionCobranza(idContenedor,direccion,paramConfig,idContenedorPadre){

	 
 	
	//variables de eventos 
 
	var Atributos=new Array;
	var componentes=new Array();
	var componentes_grid=new Array();
	var datosRegistro;	
 
	 
	var maestro={id_parametro:0,id_comprobante:0,id_moneda_reg:0};	
 
 	
  var Trasaccion = Ext.data.Record.create([		
											'id_proceso_facturacion_cobranza' , 
											'id_sistema_distribucion' , 
											'nombre_sistema_distribucion' , 
											'id_periodo' , 
											{name: 'fecha_inicio',type:'date',dateFormat:'Y-m-d'},
											{name: 'fecha_final',type:'date',dateFormat:'Y-m-d'},
											'id_gestion' , 
											'gestion' , 
											'periodo' , 
											'desc_proceso' , 
											'id_tipo_facturacion_cobranza' , 
											'nombre_proceso', 
											'prioridad', 
											'nombre_estado',
											'id_estado_proceso' 


		]); 
 
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/ProcesoFacturacionCobranza/ActionListarProcesoFacturacionCobranza.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_proceso_facturacion_cobranza',totalRecords:'TotalCount'
		},Trasaccion),remoteSort:true});
		 
		
  
  
	//DATA STORE COMBOS
	 
	
	var ds_periodo = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/periodo/ActionListarPeriodo.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_periodo',totalRecords: 'TotalCount'}, ['id_periodo','id_gestion','desc_gestion','periodo',{name: 'fecha_inicio',type:'date',dateFormat:'Y-m-d'},{name: 'fecha_final',type:'date',dateFormat:'Y-m-d'},'estado_peri_gral'])});
	function render_periodo(value, p, record){return String.format('{0}', record.data['periodo'])};
	var tpl_periodo=new Ext.Template('<div class="search-item">','<b>Periodo: </b><FONT COLOR="#0000ff">{periodo}</FONT><br>', '</div>');

	var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/gestion/ActionListarGestion.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_gestion',totalRecords: 'TotalCount'},['id_gestion','denominacion','gestion'])});
	function render_gestion(value, p, record){return String.format('{0}', record.data['gestion'])};
	var tpl_gestion=new Ext.Template('<div class="search-item">','<b>Gestion: </b><FONT COLOR="#0000ff">{gestion}</FONT><br>', '</div>');

	var ds_id_tipo_facturacion_cobranza = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/TipoFacturacionCobranza/ActionListarTipoFacturacionCobranza.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_facturacion_cobranza',totalRecords: 'TotalCount'},['id_tipo_facturacion_cobranza','nombre_proceso','sw_periodo','sw_banco'])});
 	var tpl_id_tipo_facturacion_cobranza=new Ext.Template('<div class="search-item">','<b>Tipo Proceso de Facturacion o cobranza: </b><FONT COLOR="#B5A642">{nombre_proceso}</FONT> ></FONT>','</div>');
	function render_id_tipo_facturacion_cobranza(value, p, record){return String.format('{0}', record.data['nombre_proceso']);}
	
  
	

	Atributos[0]={
		validacion:{labelSeparator:'',
				name: 'id_proceso_facturacion_cobranza',
				inputType:'hidden',
				grid_visible:false,
				 grid_editable:false},
		tipo: 'Field',
		filtro_0:false,
		id_grupo:0,
		save_as:'id_proceso_facturacion_cobranza'
	};
	Atributos[1]={
		validacion:{
			name:'id_sistema_distribucion',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_sistema_distribucion,
		save_as:'id_sistema_distribucion'
	};
	Atributos[2]= {
		validacion:{
			name:'desc_proceso',
			fieldLabel:'Nombre Proceso',
			allowBlank:true,
			maxLength:250,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			width:250
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		id_grupo:1,
		filterColValue:'desc_proceso',
		save_as:'desc_proceso'
	};
	 
 Atributos[3]={
			validacion:{
			name:'id_tipo_facturacion_cobranza',
			fieldLabel:'Proceso',
			allowBlank:false,			
			emptyText:'proceso...',
			desc: 'nombre_proceso', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_id_tipo_facturacion_cobranza,
			valueField: 'id_tipo_facturacion_cobranza',
			displayField: 'nombre_proceso',
			queryParam: 'filterValue_0',
			filterCol:'nombre_proceso',
			typeAhead:false,
			tpl:tpl_id_tipo_facturacion_cobranza,
			forceSelection:true,
			mode:'remote',
			queryDelay:200,
			pageSize:10,
			minListWidth:200,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_tipo_facturacion_cobranza,
			grid_visible:true,
			grid_editable:true,
			width_grid:150,
			width:300,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		id_grupo:1,
		filterColValue:'id_tipo_facturacion_cobranza',
 		save_as:'id_tipo_facturacion_cobranza'
	};	
	
	Atributos[4]={
		validacion:{
				fieldLabel:'Gestión',
				allowBlank:false,
				emptyText:'Gestion...',
				name:'id_gestion',
				desc:'gestion',
				store:ds_gestion,
				valueField:'id_gestion',
				displayField:'gestion',
				queryParam:'filterValue_0',
				filterCol:'gestion',
				tpl:tpl_gestion,
				typeAhead:false,
				forceSelection:false,
				mode:'remote',
				queryDelay:250,
				pageSize:10,
				minListWidth:250,
				grow:false,
				resizable:true,
				minChars:3,
				triggerAction:'all',
				renderer:render_gestion,
				grid_visible:true,
				grid_editable:false,
				width:200,
				width_grid:400 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			filtro_0:true,
		    id_grupo:1,
			form: true,
	 		filterColValue:'gestion',
	  		save_as:'id_gestion'
	};
	Atributos[5]={
		validacion:{
				fieldLabel:'Periodo',
				allowBlank:false,
				emptyText:'Periodo...',
				name:'id_periodo',
				desc:'periodo',
				store:ds_periodo,
				valueField:'id_periodo',
				displayField:'periodo',
				queryParam:'filterValue_0',
				filterCol:'periodo',
				tpl:tpl_periodo,
				typeAhead:false,
				forceSelection:false,
				mode:'remote',
				queryDelay:250,
				pageSize:10,
				minListWidth:250,
				grow:false,
				resizable:true,
				minChars:3,
				triggerAction:'all',
				renderer:render_periodo,
				grid_visible:true,
				grid_editable:false,
				width:200,
				width_grid:400 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			filtro_0:true,
		    id_grupo:1,
			form: true,
	 		filterColValue:'periodo',
	  		save_as:'id_periodo'
	};
	// txt fecha_cbte
		Atributos[6]= {
			validacion:{
				name:'fecha_inicio',
				fieldLabel:'Fecha Inicio',
				allowBlank:false,
				format: 'd/m/Y', //formato para validacion
				minValue: '31/01/2001',
				//maxValue: '30/11/2008',
				disabledDaysText: 'Día no válido',
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width_grid:85,
				disabled:false
			},
			form:true,
			tipo:'DateField',
			filtro_0:true,
			filterColValue:'fecha_inicio',
			dateFormat:'m-d-Y',
			id_grupo:1,
			defecto:new Date(),
			save_as:'fecha_inicio'
		};	
		// txt fecha_final
		Atributos[7]= {
			validacion:{
				name:'fecha_final',
				fieldLabel:'Fecha Final',
				allowBlank:false,
				format: 'd/m/Y', //formato para validacion
				minValue: '31/01/2001',
				//maxValue: '30/11/2008',
				disabledDaysText: 'Día no válido',
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width_grid:85,
				disabled:false
			},
			form:true,
			tipo:'DateField',
			filtro_0:true,
			filterColValue:'fecha_final',
			dateFormat:'m-d-Y',
			id_grupo:1,
			defecto:new Date(),
			save_as:'fecha_final'
		};
		
	 	Atributos[8]= {
		validacion:{
			name:'nombre_estado',
			fieldLabel:'Estado',
			allowBlank:true,
			maxLength:250,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			width:250,
			disabled:true
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		id_grupo:0,
		filterColValue:'nombre_estado'
	};
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
 
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Registro de Comprobante (Maestro)',titulo_detalle:'Detalle Transacción (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_registro_proceso_facturacion_cobranza=new DocsLayoutMaestro(idContenedor,idContenedorPadre);
	layout_registro_proceso_facturacion_cobranza.init(config);	

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_registro_proceso_facturacion_cobranza,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente= this.mostrarComponente;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_getComponenteGrid=this.getComponenteGrid;
	var ClaseMadre_save=this.Save;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_conexionFailure=this.conexionFailure
	var cm_EnableSelect=this.EnableSelect;
	/*********modificacion para editar**************/
	/****************************/
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};

	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/ProcesoFacturacionCobranza/ActionEliminarProcesoFacturacionCobranza.php'},
		Save:{url:direccion+'../../../control/ProcesoFacturacionCobranza/ActionGuardarProcesoFacturacionCobranza.php'},
		ConfirmSave:{url:direccion+'../../../control/ProcesoFacturacionCobranza/ActionGuardarProcesoFacturacionCobranza.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,columnas:['90%'],
		grupos:[{tituloGrupo:'Datos',columna:0,id_grupo:0},{tituloGrupo:'Datos Proceso Facturacion Cobranza',columna:0,id_grupo:1}],
		width:'50%',
		minWidth:150,
		minHeight:200,	
		closable:true,
		titulo:'Registro Proceso Facturacion Cobranza'
		//guardar:abrirVentana
		}
		
	};
		//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.reload=function(params,sw_editar){
		
			maestro=params;
		   	paramFunciones.btnEliminar.parametros='&m_id_sistema_distribucion='+maestro.id_sistema_distribucion;
			paramFunciones.Save.parametros='&m_id_sistema_distribucion='+maestro.id_sistema_distribucion;
			paramFunciones.ConfirmSave.parametros='&m_id_sistema_distribucion='+maestro.id_sistema_distribucion;
			this.InitFunciones(paramFunciones);
			var_id_sistema_distribucion.setValue(maestro.id_sistema_distribucion); 
			
			ds.lastOptions={	params:{
									start:0,
									limit: paramConfig.TamanoPagina,
									CantFiltros:paramConfig.CantFiltros,
									m_id_sistema_distribucion:maestro.id_sistema_distribucion 
								}
							};
		   	this.btnActualizar();	
			this.desbloquearMenu();		
			estado.disable();
			estado.setValue('');
	};	
	
	function InitRegistroConceptoFactura()
	{
		grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		
		sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();

		var_id_sistema_distribucion=ClaseMadre_getComponente('id_sistema_distribucion');
		var_id_periodo=ClaseMadre_getComponente('id_periodo');
		var_id_gestion=ClaseMadre_getComponente('id_gestion');
		var_fecha_inicio=ClaseMadre_getComponente('fecha_inicio');
		var_fecha_final=ClaseMadre_getComponente('fecha_final');
		var_id_tipo_facturacion_cobranza=ClaseMadre_getComponente('id_tipo_facturacion_cobranza');
	 	
		var_id_tipo_facturacion_cobranza.on('select',f_filtrar_periodo_fechas);	 
		var_id_gestion.on('select',f_filtrar_periodo);	 
		var_id_periodo.on('select',f_filtrar_fechas);	 
 		
		getSelectionModel().on('rowselect',	function( SM,rowIndex){													
																	var_record=SM.getSelected().data;
																	var_rowIndex=rowIndex;})
		
		
 	};
 	function f_filtrar_periodo_fechas( combo, record, index ){
 				var_id_periodo.allowBlank=false;
				var_id_gestion.allowBlank=false;
				var_fecha_inicio.allowBlank=false;
				var_fecha_final.allowBlank=false;
				CM_mostrarComponente(var_fecha_inicio);
				CM_mostrarComponente(var_fecha_final);	
 				CM_mostrarComponente(var_id_periodo);
				CM_mostrarComponente(var_id_gestion);
				if (record.data.sw_periodo=='no'){
 				var_id_periodo.allowBlank=true;
				var_id_gestion.allowBlank=true;
				
				CM_ocultarComponente(var_id_periodo);
				CM_ocultarComponente(var_id_gestion);
 				}
 				if (record.data.sw_periodo=='si'){
				var_fecha_inicio.allowBlank=true;
				var_fecha_final.allowBlank=true;
				
				CM_ocultarComponente(var_fecha_inicio);
				CM_ocultarComponente(var_fecha_final);		  
 				}
	}
	function f_filtrar_periodo( combo, record, index ){
 		var_id_periodo.setValue('');
 		var_id_periodo.store.baseParams={sw_reg_proceso_facturacion_cobranza:'si',id_gestion:record.data.id_gestion};
		var_id_periodo.modificado=true;
		  
	}
	function f_filtrar_fechas( combo, record, index ){
		  var_fecha_inicio.setValue(record.data.fecha_inicio);
		var_fecha_final.setValue(record.data.fecha_final);
	}
 
			
	function btn_registro_ejecucion_facturacion(){
		 var sm=getSelectionModel();
		 var filas=ds.getModifiedRecords();
		 var cont=filas.length;
		 var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			data='m_id_concepto_factura='+SelectionsRecord.data.id_concepto_factura;
			data+='&m_nombre_concepto='+SelectionsRecord.data.nombre_concepto;
			data+='&m_id_lugar='+SelectionsRecord.data.id_lugar;
			data+='&m_id_sistema_distribucion='+SelectionsRecord.data.id_sistema_distribucion;
			data+='&m_tipo_concepto='+SelectionsRecord.data.tipo_concepto;
			data+='&m_id_categoria_cliente='+SelectionsRecord.data.id_categoria_cliente;
			data+='&m_nombre_lugar='+SelectionsRecord.data.nombre_lugar;
			data+='&m_nombre_categoria_cliente='+SelectionsRecord.data.nombre_categoria_cliente;
			data+='&m_id_depto_conta='+maestro.id_depto_conta;
			data+='&m_id_gestion='+maestro.id_gestion;

			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_registro_proceso_facturacion_cobranza.loadWindows(direccion+'../../../../sis_cobranza/vista/SistemaDistribucion/columna_valor.php?'+data,'Columna',ParamVentana);
			sm.clearSelections();
			}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
		
	
	}
 
 
	 
	
	this.btnNew=function(){
		ClaseMadre_btnNew();
		
		var_id_sistema_distribucion.setValue(maestro.id_sistema_distribucion); 
	};
	
	
	
	this.getLayout=function(){return layout_registro_proceso_facturacion_cobranza.getLayout()};
		var Documento = Ext.data.Record.create(['id_estado_proceso', 'id_tipo_facturacion_cobranza', 'nombre_proceso', 'accion_anterior', 'accion_siguiente', 'prioridad', 'sw_dblink_anterior', 'sw_dblink_siguiente','nombre_estado']);
	var ds_estado = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/EstadoProceso/ActionListarEstadoProceso.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',	id: 'id_estado_proceso',	totalRecords: 'TotalCount'}, Documento)}); 
 var tpl_estado=new Ext.Template('<div class="search-item">' ,' {nombre_estado} ','</div>');
 	this.EnableSelect=function(sm,row,rec){
			cm_EnableSelect(sm,row,rec);
			//edit_cbte= rec.data;
			estado.enable();
			estado.store.baseParams={sw_estado:'si',m_id_proceso_facturacion_cobranza:rec.data.id_proceso_facturacion_cobranza,m_prioridad:rec.data.prioridad};
			estado.modificado=true;
			datosRegistro=rec;
		}
	
//monedas
var estado =new Ext.form.ComboBox({
			store: ds_estado,
			displayField:'nombre_estado',
			typeAhead: false,
			mode: 'remote',
			triggerAction:'all',
			emptyText:'estado...',
			selectOnFocus:true,
			width:100,
			valueField: 'id_estado_proceso',
			tpl:tpl_estado
			
		});
 estado.on('select',
		function (combo, record, index){
			console.log(datosRegistro.data);
			console.log(record.data);
			
			if(datosRegistro.data.prioridad==record.data.prioridad){
						sm.clearSelections();
						estado.disable();
						estado.setValue('');
						alert('No puede cambiar al mismo estado');			
					}
			
		else{
			
				 Ext.MessageBox.confirm("Atención","Esta seguro de cambiar de estado de "+datosRegistro.data.nombre_estado+" a "+record.data.nombre_estado+"?",function(btn){if(btn=='yes'){
							Ext.MessageBox.show({
								title: 'Cambiando de estado al proceso...',
								msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/>  Cambiando de estado al proceso...</div>",
								width:150,
								height:200,
								closable:false
							});
							g_accion='';
							if(datosRegistro.data.prioridad > record.data.prioridad){
								g_accion='accion_anterior';				
							}
				 			if(datosRegistro.data.prioridad < record.data.prioridad){
								g_accion='accion_siguiente';				
							}
							
							
							Ext.Ajax.request({
								url:direccion+"../../../control/EstadoProceso/ActionCambioEstadoProceso.php",
								success:mostrar_respuesta,
								params:{accion:g_accion,m_id_proceso_facturacion_cobranza:datosRegistro.data.id_proceso_facturacion_cobranza,m_id_estado_proceso:datosRegistro.data.id_estado_proceso},
								failure:ClaseMadre_conexionFailure,
								timeout:paramConfig.TiempoEspera
							});
		
						} });
		}


				sm.clearSelections();
			
		});
function mostrar_respuesta(resp){
			console.log(resp.responseXML.documentElement.getElementsByTagName('mensaje'));
			console.log(resp.responseXML.documentElement);
			ds.lastOptions={	params:{
									start:0,
									limit: paramConfig.TamanoPagina,
									CantFiltros:paramConfig.CantFiltros,
									m_id_sistema_distribucion:maestro.id_sistema_distribucion 
								}
							};
		   	Ext.MessageBox.hide();
            ClaseMadre_btnActualizar();	
		   	
			/*Ext.MessageBox.confirm("Cambio de estado ",resp.responseXML.documentElement.getElementsByTagName('mensaje')[0].firstChild.nodeValue+"\n¿Imprimir comprobante?\n",
			function(btn){
				ds.lastOptions={	params:{
									start:0,
									limit: paramConfig.TamanoPagina,
									CantFiltros:paramConfig.CantFiltros,
									m_id_sistema_distribucion:maestro.id_sistema_distribucion 
								}
							};
		   	this.btnActualizar();	
				
				

			
		})*/
}
 
	//Para manejo de eventos
	
/**********************************************************************************/	
 
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	
	this.getLayout=function(){return layout_registro_proceso_facturacion_cobranza.getLayout()};
	this.InitFunciones(paramFunciones);
	//para agregar botones
	//this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Nuevo',btn_nuevo_grid,true,'nuevo_grid','Nuevo');
	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Columna',btn_registro_ejecucion_facturacion,true,'registro ejecucion facturacion ','Ejecucion Facturacion ');
 
	//this.AdicionarBoton('','Calculadora',btn_calculadora,true,'Caluladora','Calculadora');
	this.iniciaFormulario();
	this.bloquearMenu();	
	InitRegistroConceptoFactura();
	CM_ocultarGrupo('Datos');
	this.AdicionarBotonCombo(estado,'estado');
	estado.disable();
	layout_registro_proceso_facturacion_cobranza.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
   // ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
     _CP.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);


}