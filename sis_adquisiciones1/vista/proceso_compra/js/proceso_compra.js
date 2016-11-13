/**
* Nombre:		  	    pagina_proceso_compra_main.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-05-13 18:03:05
*/
function pagina_proceso_compra(idContenedor,direccion,paramConfig,tipo,usr){
	
	var Atributos=new Array,sw=0;
	var componentes=new Array;
	
	var on, cotizacion;
	var obs;
	
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
		'id_tipo_adq',
		'id_proceso_compra_ant',
		'num_convocatoria',
		'id_cotizacion',
		'id_moneda_base',
		'numeracion_periodo_proceso',
		'proceso_cotizado',
		'ejecutado',
		'proceso_adjudicado',
		'observaciones_acta',
		'numeracion_periodo_cotizacion',
		'num_sol_por_proc',
		'cantidad_sol',
		'cant_se_adjudica',
		'pago_variable','sgte_gestion','con_ppto_sgte_gestion','gestion_ppto','avance',
		'hora_reg','usuario_reg'
		]),remoteSort:true});


		//DATA STORE COMBOS
		/////////////////////////
		// Definición de datos //
		/////////////////////////


		// hidden id_proceso_compra
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
				labelSeparator:'',
				name: 'num_sol_por_proc',
				inputType:'hidden',
				fieldLabel:'Periodo/NºSolicitudes',
				grid_visible:true,
				grid_editable:false,
				grid_indice:2

			},
			tipo: 'Field',
			filtro_0:true,
			filterColValue:'compro.f_ad_obtener_num_sol_x_proc(PROCOM.id_proceso_compra)',
			save_as:'num_sol_por_proc'
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
				width_grid:120,
				width:'100%',
				disabled:true,
				grid_indice:2,
				renderer:formatPpto
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
				fieldLabel:'Categoria',
				allowBlank:false,
				maxLength:300,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:120,
				width:'100%',
				disabled:true,
				grid_indice:3
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
				disabled:true,
				grid_indice:5
			},
			tipo: 'TextField',
			form:false,
			filtro_0:true,
			filterColValue:'MONEDA.nombre',
			save_as:'id_moneda'
		};

		// txt num_proceso
//		Atributos[5]={
//			validacion:{
//				name:'num_proceso',
//				fieldLabel:'Nº Proceso',
//				allowBlank:true,
//				maxLength:50,
//				minLength:0,
//				selectOnFocus:true,
//				allowDecimals:false,
//				decimalPrecision:2,//para numeros float
//				allowNegative:false,
//				minValue:0,
//				vtype:'texto',
//				grid_visible:false,
//				grid_editable:false,
//				width_grid:100,
//				width:'100%',
//				disabled:true
//			},
//			tipo: 'NumberField',
//			form: false,
//			filtro_0:false,
//			filterColValue:'PROCOM.num_proceso',
//			save_as:'num_proceso'
//		};

		// txt num_cotizacion
//		Atributos[6]={
//			validacion:{
//				name:'numeracion_periodo_cotizacion',
//				fieldLabel:'Nº Cotización',
//				allowBlank:true,
//				maxLength:50,
//				minLength:0,
//				selectOnFocus:true,
//				allowDecimals:false,
//				decimalPrecision:2,//para numeros float
//				allowNegative:false,
//				minValue:0,
//				vtype:'texto',
//				grid_visible:false,
//				grid_editable:false,
//				align:'right',
//				width_grid:85,
//				width:'100%',
//				disabled:true
//			},
//			tipo: 'NumberField',
//			form: false,
//			filtro_0:false,
//			filterColValue:'PROCOM.num_cotizacion#PROCOM.periodo',
//			save_as:'num_cotizacion'
//		};

		// txt observaciones
		Atributos[5]={//16
			validacion:{
				name:'num_convocatoria',
				fieldLabel:'Convocatoria',
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
				width_grid:85,
				align:'center',
				width:'100%',
				disabled:true,
				grid_indice:15
			},
			tipo: 'NumberField',
			form: false,
			filtro_0:true,
			filterColValue:'PROCOM.num_convocatoria',
			save_as:'num_convocatoria'
		};

		// txt fecha_reg
		Atributos[6]= {
			validacion:{
				name:'fecha_reg',
				fieldLabel:'Fecha Reg.',
				allowBlank:true,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Día no válido',
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width_grid:85,
				disabled:true,
				grid_indice:18
			},
			form:false,
			tipo:'DateField',
			filtro_0:false,
			filterColValue:'PROCOM.fecha_reg',
			dateFormat:'m-d-Y',
			defecto:'',
			save_as:'fecha_reg'
		};

//		Atributos[9]={
//			validacion:{
//				name:'desc_tipo_adq',
//				fieldLabel:'Tipo de Adquisición',
//				allowBlank:false,
//				maxLength:300,
//				minLength:0,
//				selectOnFocus:true,
//				vtype:'texto',
//				grid_visible:false,
//				grid_editable:false,
//				width_grid:120,
//				width:'100%',
//				disabled:true,
//				grid_indice:4
//			},
//			tipo: 'TextField',
//			form:false,
//			filtro_0:false,
//			filterColValue:'TIPADQ.nombre',
//			save_as:'id_tipo_adq'
//		};
		// txt estado_vigente//14
		Atributos[7]={
			validacion:{
				name:'estado_vigente',
				fieldLabel:'Estado Vigente',
				allowBlank:false,
				maxLength:18,
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
			form: false,
			filtro_0:false,
			filterColValue:'PROCOM.estado_vigente',
			save_as:'estado_vigente'
		};

		Atributos[8]={
			validacion:{
				name:'ejecutado',
				fieldLabel:'Presupuesto Ejecutado',
				allowBlank:false,
				maxLength:2,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				align:'center',
				width_grid:125,
				width:'100%',
				disabled:true,
				grid_indice:16
			},
			tipo: 'TextField',
			form: false,
			filtro_0:false,
			filterColValue:'PROCOM.ejecutado',
			save_as:'ejecutado'
		};

		Atributos[9]={
			validacion:{
				name:'observaciones',
				fieldLabel:'Observaciones',
				maxLength:25000,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:120,
				width:'100%',
				disabled:false,
				grid_indice:6
			},
			tipo: 'TextArea',
			form: true,
			filtro_0:true,
			filterColValue:'PROCOM.observaciones',
			save_as:'observaciones'
		};



//		Atributos[13]={//17
//			validacion:{
//				name:'id_cotizacion',
//				fieldLabel:'id_cotizacion',
//				allowBlank:false,
//				maxLength:50,
//				minLength:0,
//				selectOnFocus:true,
//				allowDecimals:false,
//				decimalPrecision:2,//para numeros float
//				allowNegative:false,
//				minValue:0,
//				vtype:'texto',
//				grid_visible:false,
//				grid_editable:false,
//				width_grid:100,
//				width:'100%',
//				disabled:true
//			},
//			tipo: 'NumberField',
//			form: false,
//			filtro_0:false
//		};


		Atributos[10]={
			validacion:{
				labelSeparator:'',
				name: 'obs',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'obs',
			defecto:0
		};


		Atributos[11]={
			validacion:{
				name:'observaciones_acta',
				fieldLabel:'Observaciones de Acta',
				maxLength:25000,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:120,
				width:'100%',
				disabled:false
			},
			tipo: 'TextArea',
			form:true,
			filtro_0:false,
			filterColValue:'PROCOM.observaciones_acta',
			save_as:'observaciones_acta'
		};

		Atributos[12]={
			validacion:{
				name:'gestion',
				fieldLabel:'Gestión',
				allowBlank:true,
				maxLength:20,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:55,
				align:'right',
				width:'40%',
				disabled:true,
				grid_indice:17

			},
			tipo: 'TextField',
			form: false,
			filtro_0:true,
			filterColValue:'PROCOM.gestion'

		};

		Atributos[13]={//18
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
		Atributos[14]={
			validacion:{
				name:'pago_variable',
				fieldLabel:'Pago Variable',
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				grid_indice:6
			},
			tipo: 'TextField',
			form:false,
			filtro_0:true
		};
		
		Atributos[15]={
			validacion:{
				name:'comprometido_pg',
				fieldLabel:'Comp. 1ra gestión',
				decimalPrecision:2,//para numeros float
				grid_visible:false,
				width:'60%',
				disabled:true
			},
			tipo: 'NumberField',
			form: true,
			save_as:'comprometido_pg',
			id_grupo:1
		};
		
		Atributos[16]={
			validacion:{
				name:'ejecutado_pg',
				fieldLabel:'Ejec. 1ra gestión',
				decimalPrecision:2,//para numeros float
				grid_visible:false,
				width:'60%',
				disabled:true
			},
			tipo: 'NumberField',
			form: true,
			save_as:'ejecutado_pg',
			id_grupo:1
		};
		
		Atributos[17]={
			validacion:{
				name:'revertir_pg',
				fieldLabel:'Revertir 1ra gestión',
				allowDecimals:true,
				decimalPrecision:2,//para numeros float
				allowNegative:false,
				grid_visible:false,
				width:'60%',
				disabled:false,
				allowBlank:true
			},
			tipo: 'NumberField',
			form: true,
			save_as:'revertir_pg',
			id_grupo:1
		};
		
		Atributos[18]={
			validacion:{
				name:'comprometido_sg',
				fieldLabel:'Comp. 2da gestión',
				decimalPrecision:2,//para numeros float
				grid_visible:false,
				width:'60%',
				disabled:true
			},
			tipo: 'NumberField',
			form: true,
			save_as:'comprometido_sg',
			id_grupo:1
		};
		
		Atributos[19]={
			validacion:{
				name:'ejecutado_sg',
				fieldLabel:'Ejec. 2da gestión',
				decimalPrecision:2,//para numeros float
				grid_visible:false,
				width:'60%',
				disabled:true
			},
			tipo: 'NumberField',
			form: true,
			save_as:'ejecutado_sg',
			id_grupo:1
		};
		
		Atributos[20]={
			validacion:{
				name:'revertir_sg',
				fieldLabel:'Revertir 2da gestión',
				allowDecimals:true,
				decimalPrecision:2,//para numeros float
				allowNegative:false,
				grid_visible:false,
				width:'60%',
				disabled:false,
				allowBlank:true
			},
			tipo: 'NumberField',
			form: true,
			save_as:'revertir_sg',
			id_grupo:1
		};
		
		
		
		Atributos[21]={
				validacion:{
				name:'hora_reg',
				fieldLabel:'Hora Reg.',
				grid_visible:true,
				width_grid:70,
				grid_indice:21
					
			},
			tipo: 'Field',
			form: false,
			filtro_0:false
		};
		
		Atributos[22]={
				validacion:{
				name:'usuario_reg',
				fieldLabel:'Usuario Reg.',
				grid_visible:true,
				width_grid:120,
				grid_indice:22
					
			},
			tipo: 'Field',
			form: false,
			filtro_0:false
		};
		
		Atributos[23]={
				validacion:{
				name:'tipo_adq',
				grid_visible:false,
				width_grid:120,
				grid_indice:22
					
			},
			tipo: 'Field',
			form: false,
			filtro_0:false
		};
		//////////////////////////////////////////////////////////////
		// ----------            FUNCIONES RENDER    ---------------//
		//////////////////////////////////////////////////////////////
		function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
		
		function formatPpto(val,cell,record,row,colum,store){
		    
		    if(tipo=='servicio_pendiente' || tipo=='bien_pendiente'){
		    
		    	if(record.data.sgte_gestion>0){
			  		return '<span style="color:brown;font-size:8pt">' + val + '</span>';
	       		}else{
	          		return val;
	    		}
			
		    }else{
		    	return val;
		    }
	   };
	
	 
	  //---------- INICIAMOS LAYOUT DETALLE
		if(tipo=='bien_orden' || tipo=='bien_adjudicacion'||tipo=='bien_pendiente'){
			var config={titulo_maestro:'Orden de Compra',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_adquisiciones/vista/proceso_compra_det/proceso_compra_mul_item_det.php'};
		}
		else
		{
			var config={titulo_maestro:'Orden de Compra',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_adquisiciones/vista/proceso_compra_det/proceso_compra_mul_serv_det.php'};
		}
		var layout_proceso_compra=new DocsLayoutMaestroDeatalle(idContenedor);
		layout_proceso_compra.init(config);

		////////////////////////
		// INICIAMOS HERENCIA //
		////////////////////////


		this.pagina=Pagina;
		//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
		this.pagina(paramConfig,Atributos,ds,layout_proceso_compra,idContenedor);
		var getComponente=this.getComponente;
		var getSelectionModel=this.getSelectionModel;
		var CM_saveSuccess=this.saveSuccess;
		var cm_conexionFailure=this.conexionFailure;
		var ClaseMadre_btnEdit=this.btnEdit;
		var cmbtnActualizar=this.btnActualizar;
		var Cm_getDialog=this.getDialog;
		var CM_ocultarComponente=this.ocultarComponente;
		var CM_mostrarComponente=this.mostrarComponente;
		var CM_ocultarGrupo=this.ocultarGrupo;
		var CM_getFormulario=this.getFormulario;
		var CM_mostrarGrupo=this.mostrarGrupo;
		var CM_ocultarGrupo=this.ocultarGrupo;


		var enableSelect=this.EnableSelect;
		///////////////////////////////////
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
			Save:{url:direccion+'../../../control/proceso_compra/ActionGuardarProcesoCompraAnular.php'},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:250,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'proceso_compra',
			grupos:[{
				tituloGrupo:'Proceso',
				columna:0,
				id_grupo:0
			},{
				tituloGrupo:'Reversion',
				columna:0,
				id_grupo:1
			}]
			}};


			//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

			function btn_lista_compras(){
				this.btnActualizar;
				var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				if(NumSelect!=0){
					var SelectionsRecord=sm.getSelected();
					var data='m_id_proceso_compra='+SelectionsRecord.data.id_proceso_compra;
					
					var ParamVentana={Ventana:{width:'90%',height:'70%'}}
					window.open(direccion+'../../../control/proceso_compra/reporte/ActionPDFListaCompras.php?'+data)
					layout_proceso_compra.getVentana().on('resize',function(){
						layout_proceso_compra.getLayout().layout();
					})
				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}




			function btn_anular_proceso(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){
					var SelectionsRecord=sm.getSelected();
					var data=SelectionsRecord.data.id_proceso_compra;

					if(SelectionsRecord.data.proceso_adjudicado>0&&SelectionsRecord.data.proceso_adjudicado!=''&& SelectionsRecord.data.proceso_adjudicado!=undefined){
						Ext.MessageBox.alert('Estado','No es posible anular el proceso, tiene adjudicaciones en curso');
					}else{
						if(confirm("¿Está seguro de anular el proceso?")){
							Ext.MessageBox.hide();
							dialog.setTitle("Anular Proceso");
							CM_ocultarGrupo('Reversion');
							CM_mostrarGrupo('Proceso');
							CM_ocultarComponente(getComponente('observaciones_acta'));
							CM_ocultarComponente(getComponente('num_sol_por_proc'));
							CM_mostrarComponente(getComponente('observaciones'));
							getComponente('observaciones').setValue('');
							getComponente('observaciones').allowBlank=false;
							dialog.buttons[0].enable();
							dialog.buttons[0].setText("Solicitar Anulacion");
							getComponente('id_proceso_compra').setValue(data);
							getComponente('obs').setValue(0);
							Ext.MessageBox.hide();
							ClaseMadre_btnEdit();

						}
					}
				}
				else{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}



			function btn_cotizacion(){
				this.btnActualizar;
				on=1;


				var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				if(NumSelect!=0){


					var SelectionsRecord=sm.getSelected();
					var data='m_id_proceso_compra='+SelectionsRecord.data.id_proceso_compra;
					data=data+'&m_codigo_proceso='+SelectionsRecord.data.codigo_proceso;
					data=data+'&m_tipo_adq='+SelectionsRecord.data.tipo_adq;
					data=data+'&m_id_tipo_categoria_adq='+SelectionsRecord.data.id_tipo_categoria_adq;
					data=data+'&m_lugar_entrega='+SelectionsRecord.data.lugar_entrega;
					data=data+'&m_id_moneda='+SelectionsRecord.data.id_moneda;
					data=data+'&m_desc_moneda='+SelectionsRecord.data.desc_moneda;
					data=data+'&m_num_cotizacion='+SelectionsRecord.data.num_cotizacion;
					data=data+'&m_id_moneda_base='+SelectionsRecord.data.id_moneda_base;
					data=data+'&m_ejecutado='+SelectionsRecord.data.ejecutado;
					data=data+'&m_periodo='+SelectionsRecord.data.periodo;
					var ParamVentana={Ventana:{width:'90%',height:'70%'}}

					if(SelectionsRecord.data.tipo_adq!='Servicio'){
						layout_proceso_compra.loadWindows(direccion+'../../../../sis_adquisiciones/vista/cotizacion/cotizacion_dir.php?'+data,'Cotizacion de Proceso',ParamVentana);}else{
						layout_proceso_compra.loadWindows(direccion+'../../../../sis_adquisiciones/vista/cotizacion/cotizacion_serv_dir.php?'+data,'Cotizacion de Proceso',ParamVentana);			
					}

					layout_proceso_compra.getVentana().on('resize',function(){
						layout_proceso_compra.getLayout().layout();
					});

				}else{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}

			}


			function verificarCotizacion(){
				Ext.Ajax.request({
					url:direccion+"../../../control/cotizacion/ActionListarCotizacion.php?m_id_proceso_compra="+getComponente('id_proceso_compra').getValue(),
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
								msg: 'Ingrese observaciones a la solicitud:',
								width:300,
								buttons: Ext.MessageBox.OK,
								multiline: true,
								fn: getObservaciones
							});
							
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
									//	alert (data);
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

			function getObservaciones(btn,text){
				if(btn!='cancel'){
					observaciones=text;
					var data='cantidad_ids=1&id_proceso_compra_0='+getComponente('id_proceso_compra').getValue()+'&id_cotizacion_0=0&figura_acta_0=&observaciones_acta_0='+observaciones;
					Ext.Ajax.request({url:direccion+"../../../control/cotizacion/ActionGuardarEstadoCotizacion.php",
					params:data,
					method:'POST',
					success:acta,
					failure:cm_conexionFailure,
					timeout:100000000});
				}
			}







			function btn_acta_apertura(){//cuando el estado de la cotizacion es invitado
				var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				if(NumSelect!=0){
					var SelectionsRecord=sm.getSelected();
					this.btnActualizar;
					on=2;
					cotizacion=false;
					verificarCotizacion();
				}else{
					Ext.MessageBox.alert('Estado','Antes debe seleccionar un item');
				}

			}


			function acta(resp){
				var data='cantidad_ids=1&id_proceso_compra_0='+getComponente('id_proceso_compra').getValue();
				var sm=getSelectionModel();
				var NumSelect=sm.getCount();


				if(NumSelect!=0){
					var SelectionsRecord=sm.getSelected();
					var data='m_id_proceso_compra='+SelectionsRecord.data.id_proceso_compra;
					window.open(direccion+'../../../control/cotizacion/reporte/ActionPDFActaApertura.php?'+data)
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

			//N-esima convocatoria
			function btn_n_conv(){
				var sm=getSelectionModel();
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					if(confirm('¿Esta seguro de crear una nueva convocatoria para este proceso?')){
						obs=1;
						
						var record=sm.getSelected();
						Ext.MessageBox.show({
							title: 'Espere Por Favor...',
							msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Verificando...</div>",
							width:150,
							height:200,
							closable:false
						});



						Ext.Ajax.request(
						{url:direccion+"../../../control/proceso_compra/ActionNuevaConvocatoria.php",
						params:{id_proceso_compra:record.data.id_proceso_compra},
						argument:{sm:sm,men:'Fue Creada la nueva convocatoria'},
						method:'POST',
						success:s_proc,
						failure:cm_conexionFailure,
						timeout:100000000
						})


					}

				}
				else{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un Proceso')
				}
			}



			//Revertir presuuesto
			function btn_revertir(){
				var sm=getSelectionModel();
				var NumSelect=sm.getCount();
				if(NumSelect=getSelectionModel().getCount()!=0){
					var record=sm.getSelected();
					if(record.data.pago_variable=='si'){
					
						/*CM_getFormulario().url=direccion+'../../../control/proceso_compra/ActionGuardarRevVariable.php?';
						CM_mostrarGrupo('Reversion');
						CM_ocultarGrupo('Proceso');
						dialog.setTitle("Revertir Prespuesto Variable");
						dialog.buttons[0].enable();
						dialog.buttons[0].setText("Revertir");
						
						Ext.Ajax.request({
							url:direccion+"../../../control/proceso_compra/ActionVerificarDatosReversion.php",
							success:datosReversion,
							params:{'id_proceso_compra':record.data.id_proceso_compra},
							failure:cm_conexionFailure,
							timeout:paramConfig.TiempoEspera
						});*/
						var record=sm.getSelected();
						var data='id='+record.data.id_proceso_compra;
						var ParamVentana={Ventana:{width:'90%',height:'70%'}}
						data=data+'&vista=revertido';
						layout_proceso_compra.loadWindows(direccion+'../../../../sis_adquisiciones/vista/detalle_ejecucion/detalle_ejecucion_revertido.php?'+data,'Detalle Ejecucion',ParamVentana);
						
						
						
							
					}
					else{
						 var m_msje='<span style="font-size:12pt; font">' + usr + '</span>';
						 
						 
						 Ext.MessageBox.show({
								title: 'MENSAJE',
								msg:m_msje+'¿Esta seguro de revertir el presupuesto  no  ejectutado? \n Ya no se podran realizar adjudicaciones ni pagos \n y serán anulados los detalles de solicitud involucrados que no se adjudicaron',
								width:400,
								height:70,
								buttons: Ext.Msg.OKCANCEL,
   								fn: processResult,
								closable:false
							});
							
							
//						if(confirm('MENSAJE'+m_msje,m_msje +' ¿Esta seguro de revertir el presupuesto  no  ejectutado? \n Ya no se podran realizar adjudicaciones ni pagos \n y serán anulados los detalles de solicitud involucrados que no se adjudicaron')){
							
//							Ext.MessageBox.show({
//								title: 'Espere Por Favor...',
//								msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Verificando...</div>",
//								width:150,
//								height:200,
//								
//								closable:false
//							});
//							Ext.Ajax.request(
//							{url:direccion+"../../../control/proceso_compra/ActionRevertirPresupuesto.php",
//							params:{num_convocatoria:record.data.num_convocatoria,id_proceso_compra:record.data.id_proceso_compra},
//							argument:{sm:sm,men:'El presupuesto fue revertido con exito'},
//							method:'POST',
//							success:s_proc,
//							failure:cm_conexionFailure,
//							timeout:100000000
//							})
						}
					//}
				}else{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un Proceso')
				}
			}
			
			function processResult(v){
				
						if(v!='cancel'){
							Ext.MessageBox.show({
								title: 'Espere Por Favor...',
								msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Verificando...</div>",
								width:150,
								height:200,
								
								closable:false
							});
							
							var sm=getSelectionModel();
							var NumSelect=sm.getCount();
				
							var record=sm.getSelected();
							Ext.Ajax.request(
							{url:direccion+"../../../control/proceso_compra/ActionRevertirPresupuesto.php",
							params:{num_convocatoria:record.data.num_convocatoria,id_proceso_compra:record.data.id_proceso_compra},
							argument:{sm:sm,men:'El presupuesto fue revertido con exito'},
							method:'POST',
							success:s_proc,
							failure:cm_conexionFailure,
							timeout:100000000
							})
						}
			}
			
			function datosReversion(resp){
				
				Ext.MessageBox.hide();
				if(resp.responseXML !=undefined && resp.responseXML !=null && resp.responseXML.documentElement !=null && resp.responseXML.documentElement !=undefined)
				{
					var root=resp.responseXML.documentElement;
					
					componentes[15].setValue(root.getElementsByTagName('comp_pg')[0].firstChild.nodeValue);
					componentes[16].setValue(root.getElementsByTagName('eje_pg')[0].firstChild.nodeValue);
					componentes[18].setValue(root.getElementsByTagName('comp_sg')[0].firstChild.nodeValue);
					componentes[19].setValue(root.getElementsByTagName('eje_sg')[0].firstChild.nodeValue);
													
				}
				ClaseMadre_btnEdit();
				
			}



			function s_proc(resp){
				var sm=resp.argument.sm;
				Ext.MessageBox.hide();
				var regreso = Ext.util.JSON.decode(resp.responseText);
				if(regreso.success){
					alert(resp.argument.men);
					cmbtnActualizar()
				}
			}
			
			function s_procC(resp){
				var sm=resp.argument.sm;
				Ext.MessageBox.hide();
				var regreso = Ext.util.JSON.decode(resp.responseText);
				if(regreso.success){
					alert(resp.argument.men);
					
					var data='m_id_proceso_compra='+ sm.data.id_proceso_compra+'&tipo=solicitud';
					window.open(direccion+'../../../control/proceso_compra/ActionPDFCertificacionPpto.php?'+data)
					cmbtnActualizar();
					
				}
			}


			function btn_finalizar_proceso(){
				if(NumSelect=getSelectionModel().getCount()!=0){
					var SelectionsRecord=getSelectionModel().getSelected();
					if(SelectionsRecord.data.ejecutado=='si' || SelectionsRecord.data.pago_variable=='si' ){
						if(confirm('¿Esta seguro de finalizar el proceso?')){
							var sm=getSelectionModel();
							var record=sm.getSelected();
							Ext.Ajax.request({url:direccion+"../../../control/proceso_compra/ActionFinalizarProcesoCompra.php",
							params:{id_proceso_compra:record.data.id_proceso_compra},
							argument:{sm:sm,men:'Finalizado con exito'},
							method:'POST',
							success:s_proc,
							failure:cm_conexionFailure,
							timeout:100000000
							})
						}
					}else{
						Ext.MessageBox.alert('Estado', 'Antes debe revertir el presupuesto que no se ejecutó para este proceso');
					}
				}
				else{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un Proceso');
				}
			}

			function btn_apertura_ofertas(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					var data='m_id_proceso_compra='+SelectionsRecord.data.id_proceso_compra;
					window.open(direccion+'../../../control/cotizacion/reporte/ActionPDFAperturaOfertas.php?'+data)
				}
				else{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}

			}



			//Para manejo de eventos
			function iniciarEventosFormularios(){
				
				//para iniciar eventos en el formulario
				dialog=Cm_getDialog();
				obs=0;
				//para iniciar eventos en el formulario
				for (var i=0;i<Atributos.length;i++)
				{
					
					componentes[i]=getComponente(Atributos[i].validacion.name);
				}

				getSelectionModel().on('rowdeselect',function(){

					if(_CP.getPagina(layout_proceso_compra.getIdContentHijo()).pagina.limpiarStore()){
						_CP.getPagina(layout_proceso_compra.getIdContentHijo()).pagina.bloquearMenu()
					}
				})
			}



			this.EnableSelect=function(x,z,y){
				enable(x,z,y);
				_CP.getPagina(layout_proceso_compra.getIdContentHijo()).pagina.reload(y.data);
				_CP.getPagina(layout_proceso_compra.getIdContentHijo()).pagina.desbloquearMenu();

			}

			function btn_reporte_cotizacion(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					var data='m_id_proceso_compra='+SelectionsRecord.data.id_proceso_compra;
					window.open(direccion+'../../../control/cotizacion/reporte/ActionPDFCotizacion.php?'+data)
				}
				else{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}

			function btn_adjudicacion(){
				var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				if(NumSelect!=0){
					var SelectionsRecord=sm.getSelected();
					var data='m_id_proceso_compra='+SelectionsRecord.data.id_proceso_compra;
					data=data+'&m_codigo_proceso='+SelectionsRecord.data.codigo_proceso;
					
					data=data+'&m_tipo_adq='+SelectionsRecord.data.tipo_adq;
					data=data+'&m_id_tipo_categoria_adq='+SelectionsRecord.data.id_tipo_categoria_adq;
					data=data+'&m_lugar_entrega='+SelectionsRecord.data.lugar_entrega;
					data=data+'&m_id_moneda='+SelectionsRecord.data.id_moneda;
					data=data+'&m_desc_moneda='+SelectionsRecord.data.desc_moneda;
					data=data+'&m_num_cotizacion='+SelectionsRecord.data.num_cotizacion;
					data=data+'&m_id_moneda_base='+SelectionsRecord.data.id_moneda_base;
					data=data+'&m_ejecutado='+SelectionsRecord.data.ejecutado;

					var ParamVentana={title:'Cotizaciones Recepcionadas',Ventana:{width:'90%',height:'70%'}}
					if(SelectionsRecord.data.tipo_adq=='Bien'){
						layout_proceso_compra.loadWindows(direccion+'../../../../sis_adquisiciones/vista/proceso_adjudicacion_det/proceso_adjudicacion_dir_det.php?'+data,'Cotizacion de Proceso',ParamVentana);
					}else{
						layout_proceso_compra.loadWindows(direccion+'../../../../sis_adquisiciones/vista/proceso_adjudicacion_det/proceso_adjudicacion_serv_dir_det.php?'+data,'Cotizacion de Proceso',ParamVentana);
					}

					layout_proceso_compra.getVentana().on('resize',function(){
						lay_proc_adj_dir.getLayout().layout();
					});

				}
				else{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
			
			function btn_orden_compra(){
				on=1;
				var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				if(NumSelect!=0){
					var SelectionsRecord=sm.getSelected();
					var data='m_id_proceso_compra='+SelectionsRecord.data.id_proceso_compra;
					data=data+'&m_codigo_proceso='+SelectionsRecord.data.codigo_proceso;
					
					data=data+'&m_tipo_adq='+SelectionsRecord.data.tipo_adq;
					data=data+'&m_id_tipo_categoria_adq='+SelectionsRecord.data.id_tipo_categoria_adq;
					data=data+'&m_lugar_entrega='+SelectionsRecord.data.lugar_entrega;
					data=data+'&m_id_moneda='+SelectionsRecord.data.id_moneda;
					data=data+'&m_desc_moneda='+SelectionsRecord.data.desc_moneda;
					data=data+'&m_num_cotizacion='+SelectionsRecord.data.num_cotizacion;
					
					data=data+'&m_ejecutado='+SelectionsRecord.data.ejecutado;
					data=data+'&m_id_depto='+SelectionsRecord.data.id_depto;
					data=data+'&m_avance='+SelectionsRecord.data.avance;
					var ParamVentana={Ventana:{width:'90%',height:'70%'}}
					if(SelectionsRecord.data.pago_variable=='si'){
						layout_proceso_compra.loadWindows(direccion+'../../../../sis_adquisiciones/vista/orden_compra_det/orden_compra_tasa.php?'+data,'Detalle - Orden de Compra',ParamVentana);
					}
					else{
						layout_proceso_compra.loadWindows(direccion+'../../../../sis_adquisiciones/vista/orden_compra_det/orden_compra_item.php?'+data,'Detalle - Orden de Compra',ParamVentana);
					}
					layout_proceso_compra.getVentana().on('resize',function(){
						layout_proceso_compra.getLayout().layout();
					});

				}else{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
	
			function btn_comprometer(){
				if(NumSelect=getSelectionModel().getCount()!=0){
					var SelectionsRecord=getSelectionModel().getSelected();
					
					if(parseFloat(SelectionsRecord.data.con_ppto_sgte_gestion)>0){
						var data='m_id_proceso_compra='+SelectionsRecord.data.id_proceso_compra+'&tipo=solicitud';
						window.open(direccion+'../../../control/proceso_compra/ActionPDFCertificacionPpto.php?'+data)
					}else{
						
							
							Ext.Ajax.request({url:direccion+"../../../control/proceso_compra/ActionComprometerPpto.php?tipo=iud",
							params:{id_proceso_compra:SelectionsRecord.data.id_proceso_compra},
							argument:{sm:SelectionsRecord,men:'Compromiso de Presupuesto Efectuado'},
							method:'POST',
							success:s_procC,
							failure:cm_conexionFailure,
							timeout:100000000
							})
						
					}
					
				}
				else{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un Proceso');
				}
			}


			
			
			
			
			//para el manejo de hijos
			this.getPagina=function(idContenedorHijo){
				var tam_elementos=elementos.length;
				for(i=0;i<tam_elementos;i++){
					if(elementos[i].idContenedor==idContenedorHijo){
						return elementos[i];
					}
				}
			};

			this.getElementos=function(){return elementos;};
			this.setPagina=function(elemento){elementos.push(elemento);};

			//para que los hijos puedan ajustarse al tamaño
			this.getLayout=function(){return layout_proceso_compra.getLayout()};
			this.Init(); //iniciamos la clase madre
			this.InitBarraMenu(paramMenu);
			//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
			this.InitFunciones(paramFunciones);
			//para agregar botones
			if(tipo=='servicio_pendiente' || tipo=='bien_pendiente'){
				this.AdicionarBoton('../../../lib/imagenes/cancel.png','Anulación de Proceso',btn_anular_proceso,true,'anular_proceso','Anular');
				this.AdicionarBoton('../../../lib/imagenes/copy.png','Cotizaciones',btn_cotizacion,true,'cotizacion','Cotizaciones');
				this.AdicionarBoton('../../../lib/imagenes/nuevo.png','Nueva Convocatoria',btn_n_conv,true,'n_conv','Nueva Conv.');
				this.AdicionarBoton('../../../lib/imagenes/volver.png','Revertir Presupuesto Sobrante',btn_revertir,true,'n_rever','Revertir');
				this.AdicionarBoton('../../../lib/imagenes/book_next.png','Finalizar Proceso',btn_finalizar_proceso,true,'finalizar_proceso','Finalizar');

				//this.AdicionarBoton('../../../lib/imagenes/print.gif','Lista de Compra',btn_lista_compras,true,'lista_compra','Lista');
				this.AdicionarBoton('../../../lib/imagenes/print.gif','Cotizaciones para Invitación',btn_reporte_cotizacion,true,'reporte_cotizacion','Cotizaciones');
				//this.AdicionarBoton('../../../lib/imagenes/print.gif','Acta de Apertura',btn_acta_apertura,true,'acta_apertura','Acta');
				this.AdicionarBoton('../../../lib/imagenes/print.gif','Cuadro Comparativo',btn_cuadro_comparativo,true,'cuadro_comparativo','Cuadro');
				//this.AdicionarBoton('../../../lib/imagenes/print.gif','Apertura de Ofertas',btn_apertura_ofertas,true,'apertura_ofertas','Apertura');
				this.AdicionarBoton('../../../lib/imagenes/nodo_edit.png','Comprometer Ppto',btn_comprometer,true,'comprometer','Comprometer Ppto');
			}
			if(tipo=='servicio_adjudicacion' || tipo=='bien_adjudicacion'){

				this.AdicionarBoton('../../../lib/imagenes/copy.png','Adjudicaciones',btn_adjudicacion,true,'adjudicacion','Cotizaciones Recepcionadas');

			}
			
			if(tipo=='servicio_orden' || tipo=='bien_orden'){

				this.AdicionarBoton('../../../lib/imagenes/copy.png','Orden Compra',btn_orden_compra,true,'orden_compra','Orden de Compra');

			}
				

			var CM_getBoton=this.getBoton;
			if(tipo=='servicio_pendiente' || tipo=='bien_pendiente'){
				CM_getBoton('anular_proceso-'+idContenedor).enable();
				CM_getBoton('cotizacion-'+idContenedor).enable();
				
				CM_getBoton('cuadro_comparativo-'+idContenedor).enable();
				CM_getBoton('finalizar_proceso-'+idContenedor).enable();
				CM_getBoton('n_conv-'+idContenedor).enable();
			}

			function  enable(sel,row,selected){
				var record=selected.data;

				if(selected&&record!=-1){


					if(tipo=='servicio_pendiente' || tipo=='bien_pendiente'){

						CM_getBoton('anular_proceso-'+idContenedor).enable();
						CM_getBoton('cotizacion-'+idContenedor).enable();
					
						CM_getBoton('cuadro_comparativo-'+idContenedor).enable();
				
						CM_getBoton('finalizar_proceso-'+idContenedor).enable();
						CM_getBoton('n_rever-'+idContenedor).enable();
						CM_getBoton('n_conv-'+idContenedor).enable();
						if(record.ejecutado=='no'){
							if(record.estado_vigente=='anulado'){
								CM_getBoton('anular_proceso-'+idContenedor).disable();
								CM_getBoton('cotizacion-'+idContenedor).disable();
							
								CM_getBoton('cuadro_comparativo-'+idContenedor).disable();
								CM_getBoton('finalizar_proceso-'+idContenedor).enable();
								CM_getBoton('n_rever-'+idContenedor).disable();
								CM_getBoton('n_conv-'+idContenedor).disable();

							}else{
								CM_getBoton('n_rever-'+idContenedor).enable();
								if(record.proceso_cotizado>0){
									CM_getBoton('cuadro_comparativo-'+idContenedor).enable();
									
								}else{
									CM_getBoton('cuadro_comparativo-'+idContenedor).disable();
									
								}
								if(record.id_cotizacion>0){
									CM_getBoton('n_rever-'+idContenedor).enable();
									CM_getBoton('anular_proceso-'+idContenedor).enable();
									

								}else{
									CM_getBoton('anular_proceso-'+idContenedor).enable();
									
									CM_getBoton('cuadro_comparativo-'+idContenedor).disable();
									

								}
							}
						}else{
							CM_getBoton('anular_proceso-'+idContenedor).disable();
							CM_getBoton('cotizacion-'+idContenedor).disable();
							
							CM_getBoton('cuadro_comparativo-'+idContenedor).disable();
							
							CM_getBoton('finalizar_proceso-'+idContenedor).enable();
							CM_getBoton('n_rever-'+idContenedor).disable();
							CM_getBoton('n_conv-'+idContenedor).disable();
						}
						
						if(parseFloat(record.sgte_gestion)>0){
							CM_getBoton('comprometer-'+idContenedor).enable();
						}else{
							CM_getBoton('comprometer-'+idContenedor).disable();
						}

					}
					enableSelect(sel,row,selected);
				}

			}
			
			if(tipo=='bien_orden'){
				ds.load({
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						adjudicacion:'si',
						tipo:'bien'
					}
				});
			}
			else if(tipo=='servicio_orden'){
				ds.load({
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						adjudicacion:'si',
						tipo:'servicio'
					}
				});
			}
			else if(tipo=='bien_adjudicacion'){
				ds.load({
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						estado_cotizacion:'cotizado',/////////////para listar solo los procesos que esten cotizados==> listos para adjudicacion
						estado:'en_proceso',
						tipo:'bien'
					}
				});
			}
			
			else if(tipo=='servicio_adjudicacion'){
				ds.load({
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						estado_cotizacion:'cotizado',/////////////para listar solo los procesos que esten cotizados==> listos para adjudicacion
						estado:'en_proceso',
						tipo:'servicio'
					}
				});
			}
			
			else if(tipo=='servicio_pendiente'){
				ds.load({
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						estado:'en_proceso',/////////////el estado debe ser en_proceso....
						estado_proceso:'inicio',
						tipo:'servicio'
					}
				});
			}
			else if(tipo=='bien_pendiente'){
				ds.load({
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						estado:'en_proceso',/////////////el estado debe ser en_proceso....
						estado_proceso:'inicio',
						tipo:'bien',
						usr:usr
					}
				});
			}

			
			this.iniciaFormulario();
			iniciarEventosFormularios();


			layout_proceso_compra.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout

			ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);

}