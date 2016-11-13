
/**
* Nombre:		  	    pagina_proceso_compra_finalizado.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-05-13 18:03:05
*/
function pagina_procesoCompraFinalizado(idContenedor,direccion,paramConfig,tipo_vista){
	var Atributos=new Array,sw=0;
	var on,cotizacion;
	var obs;
	var bandera;
	var marcas_html,div_dlgFrm,dlgFrm,TipoReporte,txt_tipo_reporte,txt_id_proceso_compra;
	var dialog;
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/proceso_compra/ActionListarProcesoCompraFinalizado.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'id_proceso_compra',totalRecords:'TotalCount'
		},[	'id_proceso_compra','codigo_proceso',			
		    'proveedor',
		    'total_adj',
			'nro_contrato',
			'estado_vigente',
			'orden_compra',
			'num_sol_por_proc',
			'categoria',
			'observaciones',
			'moneda',
			'gestion',
			'id_cotizacion','por_adelanto','depto'
		
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
		
		Atributos[1]={
			validacion:{
				name:'depto',
				fieldLabel:'Unidad Compra',
				vtype:'texto',
				width_grid:105,
				width:'100%',
				grid_visible:true
			},
			tipo: 'Field',
			form:false,
			filtro_0:true,
			//filtro_1:false,
			//filtro_2:true,
			filterColValue:'depto.nombre_depto',
			save_as:'depto'
		};
		// txt codigo_proceso
		Atributos[2]={
			validacion:{
				name:'codigo_proceso',
				fieldLabel:'Código de Proceso',
				vtype:'texto',
				grid_visible:true,
				width_grid:120
			},
			tipo: 'Field',
			form:false,
			filtro_0:true,
			filtro_2:true,
			
			filterColValue:'PROCOM.codigo_proceso',
			save_as:'codigo_proceso'
		};
		Atributos[3]={
			validacion:{
				name:'categoria',
				fieldLabel:'Categoría',
				vtype:'texto',
				grid_visible:true,
				width_grid:120
			},
			tipo: 'Field',
			form:false,
			filtro_0:true,
			//filtro_1:false,
			//filtro_2:true,
			filterColValue:'CATADQ.nombre',
			save_as:'id_categoria_adq'
		};
		// txt id_moneda
		Atributos[4]={
			validacion:{
				name:'moneda',
				fieldLabel:'Moneda',
				vtype:'texto',
				width_grid:105,
				width:'100%',
				grid_visible:true
			},
			tipo: 'Field',
			form:false,
			filtro_0:true,
			//filtro_1:false,
			//filtro_2:true,
			filterColValue:'MONEDA.nombre',
			save_as:'id_moneda'
		};
		// txt num_proceso
		Atributos[5]={
			validacion:{
				name:'proveedor',
				fieldLabel:'Proveedor',
				allowBlank:true,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:false,
				decimalPrecision:2,//para numeros float
				allowNegative:false,
				minValue:0,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:true
			},
			tipo: 'NumberField',
			form: false,
			filtro_0:true,
			filtro_1:true,
			filterColValue:'PROVEE.desc_proveedor',
			save_as:'proveedor'
		};
		// txt num_cotizacion
		Atributos[7]={
			validacion:{
				name:'orden_compra',
				fieldLabel:'Nº Orden Compra',
				allowBlank:true,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:false,
				decimalPrecision:2,//para numeros float
				allowNegative:false,
				minValue:0,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				align:'center',
				width_grid:85,
				width:'100%',
				disabled:true
			},
			tipo: 'NumberField',
			form: false,
			filtro_0:true,
			filtro_1:true,
			filterColValue:'cotiza.num_orden_compra#period.periodo#depto.codigo_depto',
			save_as:'orden_compra'
			
		};
		// txt observaciones
		Atributos[8]={//16
			validacion:{
				name:'total_adj',
				fieldLabel:'Total Adjudicado',
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
				align:'right',
				width:'100%',
				disabled:true
			},
			tipo: 'NumberField',
			form: false,
			filtro_0:false
		};
		
		// txt estado_vigente//14
		Atributos[6]={
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
			filtro_0:true,
			filterColValue:'cotiza.estado_vigente'
		};
		
		Atributos[9]={
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
		Atributos[10]={//17
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
		Atributos[11]={
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
			//filtro_0:true,
			//filtro_1:true,
			//filtro_2:true,
			filterColValue:'PROCOM.gestion',
			save_as:'gestion'
		};
		Atributos[12]={
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
		
		 Atributos[13]={
			validacion:{
				labelSeparator:'',
				name: 'num_sol_por_proc',
				//inputType:'hidden',
				fieldLabel:'Periodo/NºSol.',
				grid_visible:true,
				grid_editable:false,
				grid_indice:1,
				width_grid:120
			},
			tipo: 'Field',
			filtro_0:true,
			filtro_1:true,
			filtro_2:true,
			filterColValue:'compro.f_ad_obtener_num_sol_x_proc(PROCOM.id_proceso_compra)',
			save_as:'num_sol_por_proc'
		};
		
		
		//////////////////////////////////////////////////////////////
		// ----------            FUNCIONES RENDER    ---------------//
		//////////////////////////////////////////////////////////////
		function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
		//---------- INICIAMOS LAYOUT DETALLE
		if(tipo_vista=='bien'){
		var config={titulo_maestro:'Procesos Finalizados de Bienes',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_adquisiciones/vista/proceso_compra_det/proceso_compra_mul_item_det.php'};}
		else{
		var config={titulo_maestro:'Procesos Finalizados de Bienes',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_adquisiciones/vista/proceso_compra_det/proceso_compra_mul_serv_det.php'};	
		}
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
				//dlgFrm.addButton('Enviar',TipoReporteOC,this);
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
//			function TipoReporteOC(){
//				var sm=getSelectionModel();
//				txt_tipo_reporte=TipoReporte.getValue();
//				dlgFrm.hide();
//				var SelectionsRecord=sm.getSelected();
//				txt_id_proceso_compra=SelectionsRecord.data.id_proceso_compra;
//				if (txt_tipo_reporte==1){
//					ListadoOC();
//				}
//				else{
//					verificarOCCotizacion();
//				}
//			}
			this.EnableSelect=function(sm,row,rec){
				
				_CP.getPagina(layout_procesoCompraFinalizado.getIdContentHijo()).pagina.reload(rec.data);
				_CP.getPagina(layout_procesoCompraFinalizado.getIdContentHijo()).pagina.desbloquearMenu();
				f_EnableSelect(sm,row,rec);
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
							//llamar al reporte de todas las cotizaciones para el proceso actual y luego cambiar de estado
								//var data='cantidad_ids=1&id_proceso_compra_0='+getComponente('id_proceso_compra').getValue();
								var sm=getSelectionModel();
								var NumSelect=sm.getCount();
								if(NumSelect!=0){
									var SelectionsRecord=sm.getSelected();
									var data='cantidad_ids=1&id_proceso_compra_0='+SelectionsRecord.data.id_proceso_compra+'&m_id_proceso_compra='+SelectionsRecord.data.id_proceso_compra;
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
			
			function btn_orden_compra_rep(){
				var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				var SelectionsRecord=sm.getSelected();
				
				if(NumSelect>0){
				    var data='m_id_cotizacion='+SelectionsRecord.data.id_cotizacion;
					pagina=direccion+'../../../control/cotizacion/reporte/ActionPDFOrdenCompra.php?'+data;
					window.open(pagina);
				}else{
				    Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
				}
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
			
			function btn_pagos(){
				on=1;
				var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				if(NumSelect!=0){
					var SelectionsRecord=sm.getSelected();
					/*var data='m_id_proceso_compra='+SelectionsRecord.data.id_proceso_compra;
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
					data=data+'&m_tipo=1'*/
					
					
					var data='m_id_cotizacion='+SelectionsRecord.data.id_cotizacion;
				data=data+'&m_observaciones='+SelectionsRecord.data.observaciones;
				data =data+'&m_num_pagos='+SelectionsRecord.data.num_pagos;
				data =data+'&m_factura_total='+SelectionsRecord.data.factura_total;
				data =data+'&vista=finalizado_prov';
				
				
					var ParamVentana={Ventana:{width:'90%',height:'50%'}}
					
					layout_procesoCompraFinalizado.loadWindows(direccion+'../../../../sis_adquisiciones/vista/plan_pago/plan_pago_com.php?'+data,'Detalle - Plan Pago',ParamVentana);
					
					layout_procesoCompraFinalizado.getVentana().on('resize',function(){
						layout_procesoCompraFinalizado.getLayout().layout();
					});

				}else{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
			
			function btn_resolucion_adjudicacion(){
				this.btnActualizar;
				var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				var SelectionsRecord=sm.getSelected();
				
					if(NumSelect!=0){

                        window.open(direccion+'../../../control/adjudicacion/ActionPDFAdjudicacion.php?m_id_cotizacion='+SelectionsRecord.data.id_cotizacion);

					}else{
							Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
						}
	}
			
			
			function btn_anticipo(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect>0){
		  var data='id_cotizacion_rep_anticipo='+SelectionsRecord.data.id_cotizacion;
			pagina=direccion+'../../../control/cotizacion/reporte/ActionPDFAnticipo.php?'+data;
			window.open(pagina);
			}else
		{
		    Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
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
			/*ds.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					estado:'finalizado',//
					tipo:'bien'
				}
			});*/
			
			this.iniciaFormulario();
			iniciarEventosFormularios();
			crearDialogOC();
			
			var ds_cmb_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/gestion/ActionListarGestion.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_gestion',totalRecords:'TotalCount'},['id_gestion','gestion','estado_ges_gral','id_empresa','desc_empresa','id_moneda_base','desc_moneda']),baseParams:{sw_partida_cuenta:'si',m_id_empresa:1}});
	   var tpl_gestion_cmb=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','</div>');
var gestion =new Ext.form.ComboBox({
			store:ds_cmb_gestion,
			displayField:'gestion',
			typeAhead:true,
			mode:'remote',
			triggerAction:'all',
			emptyText:'gestion...',
			selectOnFocus:true,
			width:100,
			valueField:'id_gestion',
			tpl:tpl_gestion_cmb
		});
  gestion.on('select',function (combo, record, index){g_id_gestion=gestion.getRawValue();
  ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_gestion:g_id_gestion,
			estado:'finalizado',//
					tipo:tipo_vista
		}
	});	
   });
     this.AdicionarBotonCombo(gestion,'gestion');
     this.AdicionarBoton('../../../lib/imagenes/print.gif','Nota Adjudicación',btn_resolucion_adjudicacion,true,'resolucion_adjudicacion','Nota de Adjudicación');	
	 this.AdicionarBoton('../../../lib/imagenes/print.gif','Cuadro Comparativo',btn_cuadro_comparativo,true,'cuadro_comparativo','Cuadro');		
     this.AdicionarBoton('../../../lib/imagenes/print.gif','Rep Orden Compra',btn_orden_compra_rep,true,'orden_compra_rep','OC');
	 this.AdicionarBoton('../../../lib/imagenes/print.gif','Anticipo',btn_anticipo,true,'anticipo','Anticipo');
	 this.AdicionarBoton('../../../lib/imagenes/copy.png','Pagos',btn_pagos,true,'pagos','Pagos');
	 
	 var CM_getBoton=this.getBoton;			
	 
	 function  f_EnableSelect(sel,row,selected){
		    var record=selected.data; 
			if(selected&&record!=-1){
				if(record.estado_vigente=='anulado'){
					CM_getBoton('resolucion_adjudicacion-'+idContenedor).disable();
					CM_getBoton('cuadro_comparativo-'+idContenedor).disable();
					CM_getBoton('orden_compra_rep-'+idContenedor).disable();
					CM_getBoton('anticipo-'+idContenedor).disable();
					CM_getBoton('pagos-'+idContenedor).disable();
				}else{
					if(parseFloat(record.por_adelanto)>0){
						CM_getBoton('anticipo-'+idContenedor).enable();
					}else{
						CM_getBoton('anticipo-'+idContenedor).disable();
					}
					CM_getBoton('resolucion_adjudicacion-'+idContenedor).enable();
					CM_getBoton('cuadro_comparativo-'+idContenedor).enable();
					CM_getBoton('orden_compra_rep-'+idContenedor).enable();
					
					CM_getBoton('pagos-'+idContenedor).enable();
				}
			}
	 }
	 
			layout_procesoCompraFinalizado.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
			ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}