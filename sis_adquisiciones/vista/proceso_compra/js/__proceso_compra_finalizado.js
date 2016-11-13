/**
* Nombre:		  	    pagina_proceso_compra_finalizado.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-05-13 18:03:05
*/
function pagina_procesoCompraFinalizado(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var on,cotizacion;
	var obs;
	var bandera;
	var marcas_html,div_dlgFrm,dlgFrm,TipoReporte,txt_tipo_reporte,txt_id_proceso_compra;
	var dialog;
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/proceso_compra/ActionListarProcesoCompra.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'id_proceso_compra',totalRecords:'TotalCount'
		},[
		'id_proceso_compra',
		'observaciones',
		'codigo_proceso',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'estado_vigente',
		'id_tipo_categoria_adq',
		'desc_tipo_categoria_adq',
		'id_categoria_adq',
		'desc_categoria_adq',
		'id_moneda',
		'desc_moneda',
		'num_cotizacion',
		'num_proceso',
		'siguiente_estado',
		'periodo',
		'gestion',
		'num_cotizacion_sis',
		'num_proceso_sis',
		{name: 'fecha_proc',type:'date',dateFormat:'Y-m-d'},
		'desc_tipo_adq',
		'tipo_adq',
		'id_tipo_adq','id_proceso_compra_ant','num_convocatoria','id_cotizacion','id_moneda_base','numeracion_periodo_proceso','num_sol_por_proc'
		]),remoteSort:true});

		/////////////////////////
		// Definición de datos //
		/////////////////////////
		// hidden id_ante_proyecto
		//en la posición 0 siempre esta la llave primaria
		Atributos[0]={
			validacion:{
				labelSeparator:'',
				name: 'id_proceso_compra',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'id_proceso_compra'
		};
		Atributos[1]={//18
			validacion:{
				name:'numeracion_periodo_proceso',
				fieldLabel:'Periodo/Nº Proc.',
				allowBlank:true,
				maxLength:30,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:95,
				width:'40%',
				disabled:false,
				grid_indice:1
			},
			tipo: 'TextField',
			form:false,
			filtro_0:true,
			filterColValue:'PROCOM.periodo#PROCOM.num_proceso',
			save_as:'numeracion_periodo'
		};
		// txt codigo_proceso
		Atributos[2]={
			validacion:{
				name:'codigo_proceso',
				fieldLabel:'Código de Proceso',
				allowBlank:false,
				maxLength:20,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:125,
				width:'100%',
				disabled:true,
				grid_indice:2
			},
			tipo: 'TextField',
			form:false,
			filtro_0:true,
			filterColValue:'PROCOM.codigo_proceso',
			save_as:'codigo_proceso'
		};
		Atributos[3]={
			validacion:{
				name:'desc_categoria_adq',
				fieldLabel:'Categoría',
				allowBlank:false,
				maxLength:300,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:120,
				width:'100%',
				disabled:true
			},
			tipo: 'TextField',
			form:false,
			filtro_0:true,
			filterColValue:'CATADQ.nombre',
			save_as:'id_categoria_adq'
		};
		// txt id_moneda
		Atributos[4]={
			validacion:{
				name:'desc_moneda',
				fieldLabel:'Moneda',
				allowBlank:false,
				maxLength:200,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:105,
				width:'100%',
				disabled:true
			},
			tipo: 'TextField',
			form:false,
			filtro_0:true,
			filterColValue:'MONEDA.nombre',
			save_as:'id_moneda'
		};
		// txt num_proceso
		Atributos[5]={
			validacion:{
				name:'num_proceso',
				fieldLabel:'Nº Proceso',
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
				disabled:true
			},
			tipo: 'NumberField',
			form: false,
			filtro_0:false,
			filterColValue:'PROCOM.num_proceso',
			save_as:'num_proceso'
		};
		// txt num_cotizacion
		Atributos[6]={
			validacion:{
				name:'num_cotizacion',
				fieldLabel:'Nº Cotización',
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
				align:'center',
				width_grid:85,
				width:'100%',
				disabled:true
			},
			tipo: 'NumberField',
			form: false,
			filtro_0:false,
			filterColValue:'PROCOM.num_cotizacion',
			save_as:'num_cotizacion'
		};
		// txt observaciones
		Atributos[7]={//16
			validacion:{
				name:'num_convocatoria',
				fieldLabel:'Nº Convocatoria',
				allowBlank:true,
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
				width_grid:95,
				align:'center',
				width:'100%',
				disabled:true
			},
			tipo: 'NumberField',
			form: false,
			filtro_0:true,
			filterColValue:'PROCOM.num_convocatoria',
			save_as:'num_convocatoria'
		};
		// txt fecha_reg
		Atributos[8]= {
			validacion:{
				name:'fecha_reg',
				fieldLabel:'Fecha registro',
				allowBlank:true,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Día no válido',
				grid_visible:false,
				grid_editable:false,
				renderer: formatDate,
				width_grid:85,
				disabled:true
			},
			form:false,
			tipo:'DateField',
			filtro_0:false,
			filterColValue:'PROCOM.fecha_reg',
			dateFormat:'m-d-Y',
			defecto:'',
			save_as:'fecha_reg'
		};
		// txt estado_vigente//14
		Atributos[9]={
			validacion:{
				name:'estado_vigente',
				fieldLabel:'Estado Vigente',
				allowBlank:false,
				maxLength:18,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:90,
				width:'100%',
				disabled:true
			},
			tipo: 'TextField',
			form: false,
			filtro_0:false,
			filterColValue:'PROCOM.estado_vigente',
			save_as:'estado_vigente'
		};
		Atributos[10]={
			validacion:{
				name:'desc_tipo_adq',
				fieldLabel:'Tipo de Adquisición',
				allowBlank:false,
				maxLength:300,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:120,
				width:'100%',
				disabled:true
			},
			tipo: 'TextField',
			form:false,
			filtro_0:false,
			filterColValue:'TIPADQ.nombre',
			save_as:'id_tipo_adq'
		};
		Atributos[11]={
			validacion:{
				name:'observaciones',
				fieldLabel:'Observaciones',
				maxLength:300,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:180,
				width:'100%',
				disabled:false
			},
			tipo: 'TextArea',
			form:false,
			filtro_0:true,
			filterColValue:'PROCOM.observaciones',
			save_as:'observaciones'
		};
		Atributos[12]={//17
			validacion:{
				name:'id_cotizacion',
				fieldLabel:'id_cotizacion',
				allowBlank:false,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:false,
				decimalPrecision:2,//para numeros float
				allowNegative:false,
				minValue:0,
				vtype:'texto',
				grid_visible:false,//modificado----
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:true
			},
			tipo: 'NumberField',
			form: false,
			filtro_0:false
		};
		Atributos[13]={
			validacion:{
				name:'gestion',
				fieldLabel:'Gestión',
				allowBlank:false,
				maxLength:4,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:55,
				width:'100%',
				disabled:true
				
			},
			tipo: 'TextField',
			form:false,
			filtro_0:true,
			filterColValue:'PROCOM.gestion',
			save_as:'gestion'
		};
		Atributos[14]={
			validacion: {
				name:'tipo_reporte',
				fieldLabel:'Tipo Reporte',
				allowBlank:true,
				typeAhead:true,
				loadMask:true,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[[1,'Listado'],[2,'Todos']]}),
				valueField:'ID',
				displayField:'valor',
				lazyRender:true,
				forceSelection:true,
				grid_visible:false,
				grid_editable:false,
				width:100,
				minListWidth:100,
				disable:false
			},
			tipo:'ComboBox',
			filtro_0:false,
			defecto:1
		};
		
		 Atributos[15]={
			validacion:{
				labelSeparator:'',
				name: 'num_sol_por_proc',
				//inputType:'hidden',
				fieldLabel:'Periodo/NºSolicitudes',
				grid_visible:true,
				grid_editable:false,
				grid_indice:1,
				width_grid:120
			},
			tipo: 'Field',
			filtro_0:true,
			filterColValue:'compro.f_ad_obtener_num_sol_x_proc(PROCOM.id_proceso_compra)',
			save_as:'num_sol_por_proc'
		};
		//////////////////////////////////////////////////////////////
		// ----------            FUNCIONES RENDER    ---------------//
		//////////////////////////////////////////////////////////////
		function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
		//---------- INICIAMOS LAYOUT DETALLE
		var config={titulo_maestro:'Procesos Finalizados de Bienes',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_adquisiciones/vista/proceso_compra_det/proceso_compra_mul_item_det.php'};
		var layout_procesoCompraFinalizado=new DocsLayoutMaestroDeatalle(idContenedor);
		layout_procesoCompraFinalizado.init(config);
		////////////////////////
		// INICIAMOS HERENCIA //
		////////////////////////
		this.pagina=Pagina;
		//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
		this.pagina(paramConfig,Atributos,ds,layout_procesoCompraFinalizado,idContenedor);
		var getComponente=this.getComponente;
		var getSelectionModel=this.getSelectionModel;
		var cm_EnableSelect=this.EnableSelect;
		var cm_btnActualizar = this.btnActualizar;
		var cm_btnEdit=this.btnEdit;
		var cm_ocultarTodosComponente=this.ocultarTodosComponente;
		var cm_mostrarComponente=this.mostrarComponente;
		var cm_conexionFailure=this.conexionFailure;
		//////////////////////////////////
		// DEFINICIÓN DE LA BARRA DE MENÚ//
		///////////////////////////////////
		var paramMenu={
			actualizar:{crear:true,separador:false}
		};
		//////////////////////////////////////////////////////////////////////////////
		//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
		//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
		//////////////////////////////////////////////////////////////////////////////
		//datos necesarios para el filtro
		var paramFunciones={
			Save:{url:direccion+'../../../control/proceso_compra/ActionGuardarProcesoCompraAnularaa.php'},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:150,width:300,minWidth:150,minHeight:200,	closable:true,titulo:'Tipo de Reporte',
			grupos:[{tituloGrupo:'Reporte',
			columna:0,
			id_grupo:0}]
			}};
			//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
			function crearDialogOC(){
				marcas_html="<div class='x-dlg-hd'>"+'Tipo de Reporte'+"</div><div class='x-dlg-bd'><div id='__form-ct2_"+idContenedor+"'></div></div>";
				
				div_dlgFrm=Ext.DomHelper.append(document.body,{tag:'div',id:'__dlgFrm'+idContenedor,html:marcas_html});
				var Formulario=new Ext.form.Form({
					id:'frm_'+idContenedor,
					name:'frm_'+idContenedor,
					labelWidth:100
				});
				dlgFrm=new Ext.BasicDialog(div_dlgFrm,{
					modal:true,
					labelWidth:100,
					width:300,
					height:150,
					minWidth:paramFunciones.Formulario.minWidth,
					minHeight:paramFunciones.Formulario.minHeight,
					closable:paramFunciones.Formulario.closable
				});
				dlgFrm.addKeyListener(27,paramFunciones.Formulario.cancelar);
				dlgFrm.addButton('Enviar',TipoReporteOC,this);
				dlgFrm.addButton('Cancelar',ocultarFrm,this);
				TipoReporte=new Ext.form.ComboBox({
					name:'tipo_reporte',
					fieldLabel:'Tipo Reporte',
					allowBlank:true,
					typeAhead:true,
					loadMask:true,
					triggerAction:'all',
					store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[[1,'Listado'],[2,'Todos']]}),
					valueField:'ID',
					displayField:'valor',
					lazyRender:true,
					forceSelection:true,
					grid_visible:false,
					grid_editable:false,
					width:100,
					minListWidth:100
				});
				Formulario.fieldset({legend:'Tipo de Reporte'},TipoReporte);
				Formulario.render("__form-ct2_"+idContenedor)
			}
			function ocultarFrm(){
				dlgFrm.hide()
			}
			function TipoReporteOC(){
				var sm=getSelectionModel();
				txt_tipo_reporte=TipoReporte.getValue();
				dlgFrm.hide();
				var SelectionsRecord=sm.getSelected();
				txt_id_proceso_compra=SelectionsRecord.data.id_proceso_compra;
				if (txt_tipo_reporte==1){
					ListadoOC();
				}
				else{
					verificarOCCotizacion();
				}
			}
			this.EnableSelect=function(sm,row,rec){
				cm_EnableSelect(sm,row,rec);
				_CP.getPagina(layout_procesoCompraFinalizado.getIdContentHijo()).pagina.reload(rec.data);
				_CP.getPagina(layout_procesoCompraFinalizado.getIdContentHijo()).pagina.desbloquearMenu();
			}
			function verificarCotizacion(){
				Ext.Ajax.request({
					url:direccion+"../../../control/cotizacion/ActionListarCotizacion.php?m_tipo=1&m_id_proceso_compra="+getComponente('id_proceso_compra').getValue(),
					method:'GET',
					success:verificar,
					failure:cm_conexionFailure,
					timeout:100000000
				})

			}

			function verificar(resp){
				if(resp.responseXML!=undefined && resp.responseXML!=null&& resp.responseXML.documentElement!=null &&resp.responseXML.documentElement!=undefined){
					var root=resp.responseXML.documentElement;
					if(root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue>0){
						if(on==2){//acta

							var sm=getSelectionModel();
							var NumSelect=sm.getCount();
							var SelectionsRecord=sm.getSelected();
							Ext.MessageBox.show({
								title: 'Observaciones',
								msg:'Ingrese observaciones a la solicitud:',
								width:300,
								buttons:Ext.MessageBox.OK,
								multiline: true,
								fn: getObservaciones
							});
							//}
						}else{

							if(on==3){

								//llamar al reporte de todas las cotizaciones para el proceso actual y luego cambiar de estado
								var data='cantidad_ids=1&id_proceso_compra_0='+getComponente('id_proceso_compra').getValue();
								var sm=getSelectionModel();
								var NumSelect=sm.getCount();
								if(NumSelect!=0){
									var SelectionsRecord=sm.getSelected();
									var data='m_id_proceso_compra='+SelectionsRecord.data.id_proceso_compra;
									data=data+'&m_tipo_adq='+SelectionsRecord.data.tipo_adq;
									data=data+'&tipo_vista=procesos_finalizados';
									window.open(direccion+'../../../control/cotizacion/reporte/ActionPDFCuadroComparativo.php?'+data);
									window.open(direccion+'../../../control/cotizacion/reporte/ActionPDFCuadroComparativo_x_Item.php?'+data)
								}
								else{
									Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un Proceso')
								}

							}


						}
					}
				}
			}
			function btn_orden_compra_rep(){
				var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				if(NumSelect!=0){
					dlgFrm.show()
				}else{
					Ext.MessageBox.alert('Estado','Antes debe seleccionar un item');
				}

			}
			function verificarOCCotizacion(){
				Ext.Ajax.request({
					url:direccion+"../../../control/cotizacion/ActionListarOCCotizacion.php?m_id_proceso_compra="+getComponente('id_proceso_compra').getValue(),
					method:'GET',
					success:verificarOC,
					failure:cm_conexionFailure,
					timeout:100000000
				})

			}
		//	alert (direccion)
			function verificarOC(resp){
				if(resp.responseXML!=undefined && resp.responseXML!=null&& resp.responseXML.documentElement!=null &&resp.responseXML.documentElement!=undefined){
					var root=resp.responseXML.documentElement;
					if(root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue>0){
						var i=0;
						for (i;i<root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue;i++){
							
							//llamar al reporte de todas las cotizaciones para el proceso actual y luego cambiar de estado
							data='m_id_cotizacion='+root.getElementsByTagName('id_cotizacion')[i].firstChild.nodeValue;
							var time_delay=i*7000;
							setTimeout("window.open('../../../sis_adquisiciones/control/cotizacion/reporte/ActionPDFOrdenCompra.php?'+data)",time_delay);
							//window.open(direccion+'../../../control/cotizacion/reporte/ActionPDFOrdenCompra.php?'+data)
							//setTimeout("alert('Hola '+i)",5000);
						}
					}
				}
			}
			
			function btn_adj_rep(){
				var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				if(NumSelect!=0){
					var SelectionsRecord=sm.getSelected();
					
					
					if(NumSelect!=0){
						window.open(direccion+'../../../control/adjudicacion/ActionPDFAdjudicacion.php?m_id_proceso_compra='+SelectionsRecord.data.id_proceso_compra);
					}else{
							Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
						}
	                
				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
			
			function ListadoOC(){
				window.open(direccion+'../../../control/cotizacion/reporte/ActionPDFListaOrdenCompra.php?m_id_proceso_compra='+getComponente('id_proceso_compra').getValue());
			}
			function btn_cuadro_comparativo(){
				var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				if(NumSelect!=0){
					//cuando ya se hayan realizado el registro de propuestas==> el estado sea cotizado
					on=3;
					cotizacion=false;
					verificarCotizacion();
				}else{
					Ext.MessageBox.alert('Estado','Antes debe seleccionar un item');
				}
			}
			
			function btn_orden_compra(){
				on=1;
				var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				if(NumSelect!=0){
					var SelectionsRecord=sm.getSelected();
					var data='m_id_proceso_compra='+SelectionsRecord.data.id_proceso_compra;
					data=data+'&m_codigo_proceso='+SelectionsRecord.data.codigo_proceso;
					data=data+'&m_num_proceso='+SelectionsRecord.data.num_proceso;
					data=data+'&m_tipo_adq='+SelectionsRecord.data.tipo_adq;
					data=data+'&m_id_tipo_categoria_adq='+SelectionsRecord.data.id_tipo_categoria_adq;
					data=data+'&m_lugar_entrega='+SelectionsRecord.data.lugar_entrega;
					data=data+'&m_id_moneda='+SelectionsRecord.data.id_moneda;
					data=data+'&m_desc_moneda='+SelectionsRecord.data.desc_moneda;
					data=data+'&m_num_cotizacion='+SelectionsRecord.data.num_cotizacion;
					data=data+'&m_num_cotizacion='+SelectionsRecord.data.num_cotizacion;
					data=data+'&m_ejecutado='+SelectionsRecord.data.ejecutado;
					data=data+'&m_id_depto='+SelectionsRecord.data.id_depto;
					data=data+'&m_avance='+SelectionsRecord.data.avance;
					data=data+'&m_tipo=1'
					var ParamVentana={Ventana:{width:'90%',height:'70%'}}
					if(SelectionsRecord.data.pago_variable=='si'){
						layout_procesoCompraFinalizado.loadWindows(direccion+'../../../../sis_adquisiciones/vista/orden_compra_det_com/orden_compra_tasa_com.php?'+data,'Detalle - Orden de Compra',ParamVentana);
					}
					else{
						layout_procesoCompraFinalizado.loadWindows(direccion+'../../../../sis_adquisiciones/vista/orden_compra_det_com/orden_compra_item_com.php?'+data,'Detalle - Orden de Compra',ParamVentana);
					}
					layout_procesoCompraFinalizado.getVentana().on('resize',function(){
						layout_procesoCompraFinalizado.getLayout().layout();
					});

				}else{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
			
			//Para manejo de eventos
			function iniciarEventosFormularios(){
				//para iniciar eventos en el formulario
				//evento de deselecion de una linea de grid
				getSelectionModel().on('rowdeselect',function(){
					if(_CP.getPagina(layout_procesoCompraFinalizado.getIdContentHijo()).pagina.limpiarStore()){
						_CP.getPagina(layout_procesoCompraFinalizado.getIdContentHijo()).pagina.bloquearMenu()
					}
				})
			}
			//para que los hijos puedan ajustarse al tamaño
			this.getLayout=function(){return layout_procesoCompraFinalizado.getLayout()};
			this.Init(); //iniciamos la clase madre
			this.InitBarraMenu(paramMenu);
			//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
			this.InitFunciones(paramFunciones);
			//carga datos XML
			ds.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					estado:'finalizado',//
					tipo:'bien'
				}
			});
//			this.AdicionarBoton('../../../lib/imagenes/print.gif','Rep Nota Adjudicacion',btn_adj_rep,true,'adjudicacion_rep','ADJ');
//			this.AdicionarBoton('../../../lib/imagenes/print.gif','Rep Orden Compra',btn_orden_compra_rep,true,'orden_compra_rep','OC');
			this.AdicionarBoton('../../../lib/imagenes/print.gif','Cuadro Comparativo',btn_cuadro_comparativo,true,'cuadro_comparativo','Cuadro');
			this.AdicionarBoton('../../../lib/imagenes/copy.png','Orden Compra',btn_orden_compra,true,'orden_compra','Orden de Compra');
			this.iniciaFormulario();
			iniciarEventosFormularios();
			crearDialogOC();
			layout_procesoCompraFinalizado.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
			ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}