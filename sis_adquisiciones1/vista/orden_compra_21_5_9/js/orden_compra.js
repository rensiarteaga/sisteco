/**
* Nombre:		  	    pagina_orden_compra_main.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-05-13 18:03:05
*/
function pagina_orden_compra(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var on, cotizacion;
	var bandera;
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
		'id_tipo_adq','id_proceso_compra_ant','num_convocatoria','numeracion_periodo_proceso','numeracion_periodo_cotizacion','num_sol_por_proc','id_depto'
		]),remoteSort:true});

		//carga datos XML
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				adjudicacion:'si',
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
				width_grid:110,
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
		
		// txt id_tipo_categoria_adq
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
				width_grid:200,
				width:'100%',
				disabled:true
			},
			tipo: 'TextField',
			form:false,
			filtro_0:true,
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
				disabled:true
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
				disabled:true
			},
			tipo: 'TextField',
			form:false,
			filtro_0:true,
			filterColValue:'MONEDA.nombre',
			save_as:'id_moneda'
		};
		
		
		
		// txt observaciones
		Atributos[6]={
			validacion:{
				name:'observaciones',
				fieldLabel:'Observaciones',
				maxLength:300,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false
			},
			tipo: 'TextArea',
			form: true,
			filtro_0:true,
			filterColValue:'PROCOM.observaciones',
			save_as:'observaciones'
		};
		
		
		// txt num_proceso
		Atributos[7]={
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
		Atributos[8]={
			validacion:{
				name:'numeracion_periodo_cotizacion',
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
				align:'right',
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:true
			},
			tipo: 'NumberField',
			form: false,
			filtro_0:false,
			filterColValue:'PROCOM.num_cotizacion#PROCOM.periodo',
			save_as:'num_cotizacion'
		};

		Atributos[9]={//16
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
				width_grid:100,
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
		Atributos[10]= {
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
		Atributos[11]={
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
				grid_visible:false,
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
	 
		 Atributos[14]={
			validacion:{
				labelSeparator:'',
				name: 'num_sol_por_proc',
				inputType:'hidden',
				fieldLabel:'Periodo/NºSolicitudes',
				grid_visible:true,
				grid_editable:false,
				width_grid:120,
				grid_indice:1
			},
			tipo: 'Field',
			filtro_0:true,
			filterColValue:'SOLCOM.periodo#SOLCOM.num_solicitud',
			save_as:'num_sol_por_proc'
		};
	    //////////////////////////////////////////////////////////////
		// ----------            FUNCIONES RENDER    ---------------//
		//////////////////////////////////////////////////////////////
		function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

		//---------- INICIAMOS LAYOUT DETALLE
		var config={titulo_maestro:'Orden de Compra',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_adquisiciones/vista/proceso_compra_det/proceso_compra_mul_item_det.php'};
	    layout_orden_compra=new DocsLayoutMaestroDeatalle(idContenedor);
		layout_orden_compra.init(config);

		////////////////////////
		// INICIAMOS HERENCIA //
		////////////////////////

		this.pagina=Pagina;
		//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
		this.pagina(paramConfig,Atributos,ds,layout_orden_compra,idContenedor);
		var getComponente=this.getComponente;
		var getSelectionModel=this.getSelectionModel;
		var CM_saveSuccess=this.saveSuccess;
		var ClaseMadre_conexionFailure=this.conexionFailure;
		var ClaseMadre_btnEdit=this.btnEdit;
		var cmbtnActualizar=this.btnActualizar;
		var Cm_getDialog=this.getDialog;
		var CM_ocultarComponente=this.ocultarComponente;
		var CM_mostrarComponente=this.mostrarComponente;
		var CM_mostrarGrupo=this.mostrarGrupo;
		var CM_ocultarGrupo=this.ocultarGrupo;
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
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Orden de Compra',
			grupos:[{	
					tituloGrupo:'Oculto',
					columna:0,
					id_grupo:0
				}]
			}
		};
			//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
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
					var ParamVentana={Ventana:{width:'90%',height:'70%'}}
					
						layout_orden_compra.loadWindows(direccion+'../../../../sis_adquisiciones/vista/orden_compra_det/orden_compra_item.php?'+data,'Detalle - Orden de Compra',ParamVentana);
					
					layout_orden_compra.getVentana().on('resize',function(){
						layout_orden_compra.getLayout().layout();
					});

				}else{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}




			//Para manejo de eventos
			function iniciarEventosFormularios(){
				//para iniciar eventos en el formulario
				dialog=Cm_getDialog();
				getSelectionModel().on('rowdeselect',function(){
				
					if(_CP.getPagina(layout_orden_compra.getIdContentHijo()).pagina.limpiarStore()){
						_CP.getPagina(layout_orden_compra.getIdContentHijo()).pagina.bloquearMenu()
					}
				})
			}
			
			this.EnableSelect=function(x,z,y){
			 enable(x,z,y);
			 _CP.getPagina(layout_orden_compra.getIdContentHijo()).pagina.reload(y.data);
				_CP.getPagina(layout_orden_compra.getIdContentHijo()).pagina.desbloquearMenu();
		    }
			//para que los hijos puedan ajustarse al tamaño
			this.getLayout=function(){return layout_orden_compra.getLayout()};
			this.Init(); //iniciamos la clase madre
			this.InitBarraMenu(paramMenu);
			//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
			this.InitFunciones(paramFunciones);
			//para agregar botones

			this.AdicionarBoton('../../../lib/imagenes/copy.png','Orden Compra',btn_orden_compra,true,'orden_compra','Orden de Compra');
			function  enable(sel,row,selected){
				var record=selected.data; 
			}
			this.iniciaFormulario();
			iniciarEventosFormularios();
			layout_orden_compra.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
			ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
