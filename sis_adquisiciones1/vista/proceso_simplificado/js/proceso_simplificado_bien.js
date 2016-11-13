/**
* Nombre:		  	    pagina_proceso_adjudicacion_main.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-05-13 18:03:05
*/
function pag_proc_simplif_bien(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var on;
	var sw_grup=true,gridG,gSm,ds_g,gDlg;
	var bandera;
	var dialog;
	var adj;
	var id;
	var cont_se_adj;
	var acepta_finalizar;
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/proceso_compra/ActionListarProcesoCompraDir.php'}),
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
		'id_tipo_adq','id_proceso_compra_ant','num_convocatoria','id_cotizacion','id_moneda_base','numeracion_periodo_proceso','proceso_adjudicado','ejecutado','cantidad_sol','cant_se_adjudica','numeracion_periodo_cotizacion','id_caja','caja','id_cajero','cajero','id_comprador','comprador','monto_proceso','cantidad_cotizaciones','cantidad_rendiciones','solicitante','tipo_recibo','num_sol_por_proc','id_caja_regis','id_depto','no_adjudicado','id_cuenta_doc','usuario_reg'
		]),remoteSort:true});

		
			var ds_caja = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_tesoreria/control/caja/ActionListarCaja.php?estado=1'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_caja',totalRecords: 'TotalCount'},['id_caja','desc_moneda','tipo_caja','desc_unidad_organizacional'])
	       });

            var ds_cajero = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_tesoreria/control/cajero/ActionListarCajero.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cajero',totalRecords: 'TotalCount'},['id_cajero','nombre_persona','apellido_paterno_persona','apellido_materno_persona','codigo_empleado_empleado','desc_empleado'])
	       });
	       
	       function render_id_caja(value, p, record){return String.format('{0}', record.data['caja']);}
		   var tpl_id_caja=new Ext.Template('<div class="search-item">','<b><i>{desc_unidad_organizacional}</i></b>','<br><FONT COLOR="#B5A642">{desc_moneda}</FONT>','</div>');

		   function render_id_cajero(value, p, record){return String.format('{0}', record.data['cajero']);}
		   var tpl_id_cajero=new Ext.Template('<div class="search-item">','<b><i>{nombre_persona} </b></i>','<b><i>{apellido_paterno_persona} </b></i>','<b><i>{apellido_materno_persona} </b></i>','<br><FONT COLOR="#B5A642">{codigo_empleado_empleado}</FONT>','</div>');
            
		   
		
		//carga datos XML
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				directo:'si',
				tipo:'bien'
				
			}
		});

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

		Atributos[2]={//18
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
		Atributos[1]={
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
				width_grid:110,
				width:'100%',
				disabled:true,
				grid_indice:3
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
				grid_visible:false,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:true
		
			},
			tipo: 'TextField',
			form:false,
			filtro_0:false,
			filterColValue:'CATADQ.nombre',
			save_as:'id_categoria_adq'
		};
		
		
		Atributos[4]={
			validacion:{
				name:'desc_tipo_adq',
				fieldLabel:'Tipo de Adquisicion',
				allowBlank:false,
				maxLength:300,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:false,
				grid_editable:false,
				width_grid:115,
				width:'100%',
				disabled:true,
				grid_indice:4
			},
			tipo: 'TextField',
			form:false,
			filtro_0:false,
			filterColValue:'TIPADQ.nombre',
			save_as:'id_tipo_adq'
		};
		
		
		// txt id_moneda
		
		Atributos[5]={
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
				width_grid:100,
				width:'100%',
				disabled:true,
				grid_indice:6
			},
			tipo: 'TextField',
			form:false,
			filtro_0:true,
			filterColValue:'MONEDA.nombre',
			save_as:'id_moneda'
		};
	
		// txt num_proceso
		Atributos[6]={
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
				grid_indice:2,
				disabled:true
			},
			tipo: 'NumberField',
			form: false,
			filtro_0:false,
			filterColValue:'PROCOM.num_proceso',
			save_as:'num_proceso'
		};
		
		// txt num_cotizacion
//		Atributos[7]={
//			validacion:{
//				name:'numeracion_periodo_cotizacion',
//				fieldLabel:'Periodo/NºCot.',
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
//				align:'right',
//				width:'100%',
//				disabled:true
//			},
//			tipo: 'NumberField',
//			form: false,
//			filtro_0:true,
//			filterColValue:'PROCOM.num_cotizacion#PROCOM.periodo',
//			save_as:'num_cotizacion'
//		};
//
//		Atributos[8]={//16
//			validacion:{
//				name:'num_convocatoria',
//				fieldLabel:'Nº Convocatoria',
//				allowBlank:true,
//				maxLength:50,
//				minLength:0,
//				selectOnFocus:true,
//				allowDecimals:false,
//				decimalPrecision:0,//para numeros float
//				allowNegative:false,
//				minValue:0,
//				vtype:'texto',
//				grid_visible:false,
//				grid_editable:false,
//				width_grid:100,
//				align:'center',
//				width:'100%',
//				disabled:true
//			},
//			tipo: 'NumberField',
//			form: false,
//			filtro_0:true,
//			filterColValue:'PROCOM.num_convocatoria',
//			save_as:'num_convocatoria'
//		};

		// txt fecha_reg
		Atributos[7]= {
			validacion:{
				name:'fecha_reg',
				fieldLabel:'Fecha registro',
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
			filterColValue:'PROCOM.fecha_reg',
			dateFormat:'m-d-Y',
			defecto:'',
			save_as:'fecha_reg'
		};

	
		// txt estado_vigente//14
		Atributos[8]={
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

		// txt observaciones
		Atributos[9]={
			validacion:{
				name:'observaciones',
				fieldLabel:'Observaciones',
			
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false,
				grid_indice:11
			},
			tipo: 'TextArea',
			form:true,
			filtro_0:true,
			filterColValue:'PROCOM.observaciones',
			save_as:'observaciones',
			id_grupo:1
		};
		

//		Atributos[10]={//17
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
//	    };
//	    
	    Atributos[10]={
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
				width:'40%',
				align:'right',
				disabled:true
				
			},
			tipo: 'TextField',
			form: false,
			filtro_0:true,
			filterColValue:'PROCOM.gestion'
			
		};
	 
		Atributos[11]={
			validacion:{
			name:'id_caja',
			fieldLabel:'Caja',
			allowBlank:false,			
			emptyText:'Caja...',
			desc: 'caja', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_caja,
			valueField: 'id_caja',
			displayField: 'desc_unidad_organizacional',
			queryParam: 'filterValue_0',
			filterCol:'MONEDA.nombre#UNIORG.nombre_unidad',
			typeAhead:true,
			tpl:tpl_id_caja,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:150,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_caja,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'100%',
			disabled:false,
			grid_indice:9
			
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'UO.nombre_unidad',
		save_as:'id_caja'
	};
// txt id_cajero
	Atributos[12]={
			validacion:{
			name:'id_cajero',
			fieldLabel:'Cajero',
			allowBlank:false,			
			emptyText:'Cajero...',
			desc:'cajero', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_cajero,
			valueField: 'id_cajero',
			displayField: 'desc_empleado',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			typeAhead:true,
			tpl:tpl_id_cajero,
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
			renderer:render_id_cajero,
			grid_visible:true,
			grid_editable:false,
			width_grid:130,
			width:'100%',
			disabled:false,
			grid_indice:10
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PER.apellido_paterno#PER.apellido_materno#PER.nombre',
		save_as:'id_cajero',
		id_grupo:0
	};
	
        
	    Atributos[13]={
			validacion:{
				name:'comprador',
				fieldLabel:'Comprador',
				allowBlank:true,
				maxLength:120,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:150,
				width:'100%',
				disabled:true,
				grid_indice:8
			},
			tipo: 'TextField',
			form:true,
			filtro_0:true,
			filterColValue:'PER_COM.nombre#PER_COM.apellido_paterno#PER_COM.apellido_materno',
			id_grupo:0
		};
		
		
		Atributos[14]={
			validacion:{
				labelSeparator:'',
				name: 'id_comprador',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'id_comprador'
		};
		
		
		
		Atributos[15]={
			validacion:{
				labelSeparator:'',
				fieldLabel:'Precio Total',
				name: 'monto_proceso',
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				//renderer:render_decimales,
				disabled:true,
				allowDecimals:true,
			    decimalPrecision:2,//para numeros float
			    allowNegative:false,
			    allowMil:true,
			    maxLength:50,
			    grid_indice:5,
			    width_grid:80,
				align:'right'
			},
			tipo: 'NumberField',
			form:true,
			filtro_0:false,
			save_as:'monto_proceso',
			id_grupo:0
		};
		
		Atributos[16]={
			validacion:{
				labelSeparator:'',
				fieldLabel:'Solicitante',
				name: 'solicitante',
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				disabled:true,
				width:'100%',
				grid_indice:4,
				width_grid:180
				
			},
			tipo: 'Field',
			form:true,
			filtro_0:true,
			filterColValue:'PER_SOL.nombre#PER_SOL.apellido_paterno#PER_SOL.apellido_materno',
			save_as:'solicitante',
			id_grupo:0
		};
		
		
		Atributos[17]={
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
			defecto:1
		};
		
		Atributos[18]={
			validacion:{
				labelSeparator:'',
				name: 'num_sol_por_proc',
				inputType:'hidden',
				fieldLabel:'Periodo/NºSolicitudes',
				grid_visible:true,
				grid_editable:false,
				grid_indice:1
			},
			tipo: 'Field',
			form:false,
			filtro_0:true,
			filterColValue:'SOLCOM.periodo#SOLCOM.num_solicitud',
			save_as:'num_sol_por_proc'
		};
		
		Atributos[19]={
			validacion:{
				labelSeparator:'',
				name: 'id_depto',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'id_depto'
		};
		
		
		Atributos[20]={
			validacion:{
				labelSeparator:'',
				fieldLabel:'Tipo de Recibo',
				name: 'tipo_recibo',
				inputType:'hidden',
				grid_visible:true,
				grid_editable:false,
				grid_indice:6
			},
			tipo: 'Field',
			form:false,
			filtro_0:false,
			save_as:'tipo_recibo',
			grid_indice:6
		};
		
		Atributos[21]={
			validacion:{
				labelSeparator:'',
				name: 'usuario_reg',
				//inputType:'hidden',
				grid_visible:true,
				grid_editable:false
			},
			tipo: 'TextField',
			filtro_0:false,
			form:false,
			save_as:'usuario_reg'
		};
		
		//////////////////////////////////////////////////////////////
		// ----------            FUNCIONES RENDER    ---------------//
		//////////////////////////////////////////////////////////////
		function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

		//---------- INICIAMOS LAYOUT DETALLE
		var config={titulo_maestro:'Vale de Compra',grid_maestro:'grid-'+idContenedor,
		urlHijo:'../../../sis_adquisiciones/vista/proceso_compra_det/proceso_compra_mul_item_det.php'};
		lay_proc_simplif_factura=new DocsLayoutMaestroDeatalle(idContenedor);
		lay_proc_simplif_factura.init(config);

		////////////////////////
		// INICIAMOS HERENCIA //
		////////////////////////


		this.pagina=Pagina;
		//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
		this.pagina(paramConfig,Atributos,ds,lay_proc_simplif_factura,idContenedor);
		var getComponente=this.getComponente;
		var getSelectionModel=this.getSelectionModel;
		var CM_saveSuccess=this.saveSuccess;
		var cm_conexionFailure=this.conexionFailure;
		var ClaseMadre_btnEdit=this.btnEdit;
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
	        
	    	actualizar:{crear:true,separador:false}
		};

        //////////////////////////////////////////////////////////////////////////////
		//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
		//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
		//////////////////////////////////////////////////////////////////////////////

		//datos necesarios para el filtro
		var paramFunciones={
		    Save:{url:direccion+'../../../control/proceso_compra/ActionGuardarProcesoCompraVale.php'},
		    ConfirmSave:{url:direccion+'../../../control/proceso_compra/ActionGuardarProcesoCompraVale.php'},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:260,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Vale de Compra',
			grupos:[{	tituloGrupo:'Vale de Compra',
			        columna:0,
			        id_grupo:0
			     },
			     {	tituloGrupo:'Observaciones para Anulación',
			        columna:0,
			        id_grupo:1
			     }]
			}};
			//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
			
			function btn_vale(){
				var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				if(NumSelect!=0){
					var SelectionsRecord=sm.getSelected();
					getComponente('id_caja').allowBlank=false;
					getComponente('id_cajero').allowBlank=false;
					if(SelectionsRecord.data.tipo_recibo=='pago'){
					    CM_ocultarComponente(getComponente('comprador'));
					}else{
					    CM_mostrarComponente(getComponente('comprador'));
					}
					cmb_id_caja.modificado=true;
					ds_caja.baseParams={
						estado:1,id_proceso_compra:SelectionsRecord.data.id_proceso_compra
					}
					CM_mostrarGrupo('Vale de Compra');
					CM_ocultarGrupo('Observaciones para Anulación');
					getComponente('comprador').setValue(SelectionsRecord.data.comprador);
					getComponente('id_comprador').setValue(SelectionsRecord.data.id_comprador);
					getComponente('obs').setValue(1);
					   ClaseMadre_btnEdit(); 
				}
				else{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
			
			function btn_reg_factura(){
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
    					data=data+'&m_id_moneda_base='+SelectionsRecord.data.id_moneda_base;
    					data=data+'&m_ejecutado='+SelectionsRecord.data.ejecutado;
    					data=data+'&m_monto_proceso='+SelectionsRecord.data.monto_proceso;
						data=data+'&m_tipo_recibo='+SelectionsRecord.data.tipo_recibo;
						data=data+'&m_id_depto='+SelectionsRecord.data.id_depto;
    
    					var ParamVentana={title:'Cotizaciones Recepcionadas',Ventana:{width:'85%',height:'85%'}}
    					 if(((SelectionsRecord.data.id_caja_regis>0|| SelectionsRecord.data.id_cuenta_doc>0) &&SelectionsRecord.data.tipo_recibo=='provisorio')||SelectionsRecord.data.tipo_recibo=='pago'){
                                lay_proc_simplif_factura.loadWindows(direccion+'../../../../sis_adquisiciones/vista/proceso_simplificado/proceso_simplificado_factura_item.php?'+data,'Registro de Factura',ParamVentana);
						        lay_proc_simplif_factura.getVentana().on('resize',function(){
							    lay_proc_simplif_factura.getLayout().layout();
						  });
                    	 }else{
						   alert('Antes se debe emitir Vale de Compra');
					     } 
    					
				}
				else{
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

					
						if(confirm("¿Está seguro de anular el proceso?")){
							
							dialog.setTitle("Anular Proceso");
							CM_ocultarGrupo('Vale de Compra');
							getComponente('id_caja').allowBlank=true;
							getComponente('id_cajero').allowBlank=true;
					        CM_mostrarGrupo('Observaciones para Anulación');
							
							getComponente('obs').setValue(0);
							
							ClaseMadre_btnEdit();

						}
					
				}
				else{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
			
			function btn_lista_compras(){
				this.btnActualizar;
				var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				if(NumSelect!=0){
					var SelectionsRecord=sm.getSelected();
					var data='m_id_proceso_compra='+SelectionsRecord.data.id_proceso_compra;
					var ParamVentana={Ventana:{width:'90%',height:'70%'}}
	                   window.open(direccion+'../../../control/proceso_compra/reporte/ActionPDFListaCompras.php?'+data)
					   
				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}
			function btn_fin_proceso(){
				var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
				if(NumSelect!=0){
					var SelectionsRecord=sm.getSelected();
					if(SelectionsRecord.data.no_adjudicado!='' &&  SelectionsRecord.data.no_adjudicado!=null && SelectionsRecord.data.no_adjudicado!=undefined){
						  if(confirm('Algunos detalles no fueron adjudicados, si finaliza el proceso, se REVERTIRÁ EL PRESUPUESTO para su compra \n'+ SelectionsRecord.data.no_adjudicado)){
						     acepta_finalizar='si';
						  }else{
						  	acepta_finalizar='no';
						  }
					}else{
						acepta_finalizar='si';
					}
					if(SelectionsRecord.data.cantidad_cotizaciones>=SelectionsRecord.data.cantidad_rendiciones){
						if(acepta_finalizar=='si'){
    						var data='m_id_proceso_compra='+SelectionsRecord.data.id_proceso_compra;
    					 	if(confirm('¿Esta seguro de finalizar el proceso?')){
						   		var sm=getSelectionModel();
						   		var record=sm.getSelected();
						      	   Ext.Ajax.request({url:direccion+"../../../control/proceso_compra/ActionFinalizarProcesoCompraDir.php",
						            params:{id_proceso_compra:record.data.id_proceso_compra},
            						argument:{sm:sm,men:'Finalizado con exito'},
            						method:'POST',
            						success:s_proc,
            						failure:cm_conexionFailure,
            						timeout:100000000
            						})
    					 	}
					   }
					}else{
					    alert('Existen facturas que no pasaron por proceso de Rendición');
					}
				}
				else{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
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

			function Actualizar(){
				ds.load(ds.lastOptions);//actualizar
				ds.rejectChanges()//vacia el vector de records modificados
			}
			//Para manejo de eventos
			function iniciarEventosFormularios(){
			    CM_getBoton('vale-'+idContenedor).disable();
				CM_getBoton('reg_factura-'+idContenedor).disable();
				CM_getBoton('fin_proceso-'+idContenedor).disable();
				
				
				cmb_id_caja=getComponente('id_caja');
				cmb_id_cajero=getComponente('id_cajero');
				
				var onCaja=function(e){
					cmb_id_cajero.reset();
					ds_cajero.baseParams={m_id_caja:getComponente('id_caja').getValue(), estado:'3'};
					cmb_id_cajero.modificado=true;
			}
				
				
				cmb_id_caja.on('select',onCaja);
				cmb_id_caja.on('change',onCaja);
				//para iniciar eventos en el formulario
				cont_se_adj=0;
				dialog=Cm_getDialog();
				getSelectionModel().on('rowdeselect',function(){
					CM_getBoton('vale-'+idContenedor).disable();
					CM_getBoton('reg_factura-'+idContenedor).disable();
					CM_getBoton('fin_proceso-'+idContenedor).disable();
				if(_CP.getPagina(lay_proc_simplif_factura.getIdContentHijo()).pagina.limpiarStore()){
						_CP.getPagina(lay_proc_simplif_factura.getIdContentHijo()).pagina.bloquearMenu()
					}	
				})
				
				
				
				
					
				
			}
            
			this.EnableSelect=function(x,z,y){
			 enable(x,z,y);
			 _CP.getPagina(lay_proc_simplif_factura.getIdContentHijo()).pagina.reload(y.data);
				_CP.getPagina(lay_proc_simplif_factura.getIdContentHijo()).pagina.desbloquearMenu();
		    }

			//para que los hijos puedan ajustarse al tamaño
			this.getLayout=function(){return lay_proc_simplif_factura.getLayout()};
			this.Init(); //iniciamos la clase madre
			this.InitBarraMenu(paramMenu);
			//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
			this.InitFunciones(paramFunciones);
			//para agregar botones

            this.AdicionarBoton('../../../lib/imagenes/copy.png','Crear Vale de Compra',btn_vale,true,'vale','Vale de Compra');		
            this.AdicionarBoton('../../../lib/imagenes/print.gif','Lista de Compras',btn_lista_compras,true,'lista_compra','Lista');
            	
			this.AdicionarBoton('../../../lib/imagenes/copy.png','Registrar Factura',btn_reg_factura,true,'reg_factura','Registrar Factura');
			this.AdicionarBoton('../../../lib/imagenes/book_next.png','Finalizar Proceso',btn_fin_proceso,true,'fin_proceso','Finalizar Proceso');
			
            this.AdicionarBoton('../../../lib/imagenes/cancel.png','Anulación de Proceso',btn_anular_proceso,true,'anular_proceso','Anular');
			var CM_getBoton=this.getBoton;
			
			function  enable(sel,row,selected){
				var record=selected.data; 
			
				if(selected&&record!=-1){
				    
				    CM_getBoton('vale-'+idContenedor).enable();
					CM_getBoton('reg_factura-'+idContenedor).enable();
				    CM_getBoton('fin_proceso-'+idContenedor).enable();
				     
				    if(record.tipo_recibo=='pago'){
				        CM_getBoton('vale-'+idContenedor).disable();
				    }else{
				        CM_getBoton('vale-'+idContenedor).enable();
				    }
				    if(parseFloat(record.cantidad_cotizaciones)>0){
				        CM_getBoton('anular_proceso-'+idContenedor).disable();
				    }else{
				        CM_getBoton('anular_proceso-'+idContenedor).enable();
				       
				    }  if(parseFloat(record.id_caja_regis)>0 || (parseFloat(record.id_cuenta_doc)>0)){
				            //CM_getBoton('anular_proceso-'+idContenedor).disable();
					    		  if(parseFloat(record.cantidad_cotizaciones)>=parseFloat(record.cantidad_rendiciones)){
					                   CM_getBoton('fin_proceso-'+idContenedor).enable();
					                   CM_getBoton('vale-'+idContenedor).disable();
					              }else{
					                   CM_getBoton('fin_proceso-'+idContenedor).disable();
					                   CM_getBoton('reg_factura-'+idContenedor).enable();
					        
					                   if(record.tipo_recibo=='pago'){
					                       CM_getBoton('vale-'+idContenedor).disable();
					                   }else{
					                       CM_getBoton('vale-'+idContenedor).enable();
					                   }
					        
					               }
				                   CM_getBoton('reg_factura-'+idContenedor).enable();
				            }else{
				                 //CM_getBoton('anular_proceso-'+idContenedor).enable();
				                   CM_getBoton('reg_factura-'+idContenedor).disable();
				                   CM_getBoton('fin_proceso-'+idContenedor).disable();
				                   
				                   
                                    if(record.tipo_recibo=='pago'){
                                           CM_getBoton('vale-'+idContenedor).disable();
                                           CM_getBoton('reg_factura-'+idContenedor).enable();
					                       if(parseFloat(record.cantidad_rendiciones)>0){
                                               CM_getBoton('fin_proceso-'+idContenedor).enable();
                                           }else{
                                               CM_getBoton('fin_proceso-'+idContenedor).disable();
                                           }
                                    }else{
				                        CM_getBoton('vale-'+idContenedor).enable();
                                    }
				       	    }
				        
				   
				}
			    enableSelect(sel,row,selected);
			}
            
			this.iniciaFormulario();
			iniciarEventosFormularios();
			lay_proc_simplif_factura.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
			ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}