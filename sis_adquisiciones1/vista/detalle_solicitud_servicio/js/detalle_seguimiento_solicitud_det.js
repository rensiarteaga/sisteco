/**
 * Nombre:		  	    pagina_detalle_seguimiento_solicitud_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-16 11:58:28
 */
function pagina_detalle_seguimiento_solicitud_det(idContenedor,direccion,paramConfig,idContenedorPadre,refo)
{
	var Atributos=new Array,sw=0;
	var maestro;
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
		'desc_servicio_reformulado','precio_referencial_total_as','total_gestion'
		

		]),remoteSort:true});


	
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
				grid_indice:1
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
			    grid_indice:2
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
				grid_visible:true,
				width_grid:100,
				align:'right',
				grid_indice:6
				
			},
			tipo: 'Field',
			form: true,
			filtro_0:false
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
				grid_indice:3
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
			grid_visible:true,
			width_grid:100,
			grid_indice:11	
		},
		tipo:'Field',
		form: false,
		filtro_0:true,
		filterColValue:'SOLDET.reformular'
	};
		
			
			
	Atributos[14]={
		validacion:{
			name:'desc_servicio_reformulado',
			fieldLabel:'Servicio Reformulado',
			grid_visible:true,
			width_grid:100,
			grid_indice:12
		},
		tipo: 'TextArea',
		form: false
	};
		
	Atributos[15]={
		validacion:{
			name:'monto_ref_reformulado',
			fieldLabel:'Precio Total Reformulado',
			grid_visible:true,
			width_grid:110,
			grid_indice:13
		},
		tipo: 'Field',
		form: false,
		filtro_0:true,
		filterColValue:'SOLDET.monto_ref_reformulado'
	};
		
		Atributos[16]={
			validacion:{
				name:'motivo_ref',
				fieldLabel:'Motivo Reformulación',
				grid_visible:true,
				width_grid:100,
				grid_indice:14
			},
			tipo: 'TextArea',
			form: false,
			filtro_0:true,
			filterColValue:'SOLDET.motivo_ref'
		};
		
		Atributos[17]= {
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
		
		
		Atributos[18]={
			validacion:{
				name:'precio_referencial_total_as',
				fieldLabel:'Precio Total Gestion Siguiente',
				grid_visible:true,
				width_grid:100,
				align:'right',
				grid_indice:6
				
			},
			tipo: 'Field',
			form: false,
			filtro_0:false
		};
		
		Atributos[19]={
			validacion:{
				name:'total_gestion',
				fieldLabel:'Precio Total Gestion Actual',
				grid_visible:true,
				width_grid:100,
				align:'right',
				grid_indice:6
				
			},
			tipo: 'Field',
			form:false,
			filtro_0:false
		};
	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Seguimiento de Solicitudes Servicios (Maestro)',titulo_detalle:'Detalle Solicitud Servicios(Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_detalle_seguimiento_solicitud_serv = new DocsLayoutMaestro(idContenedor);
	layout_detalle_seguimiento_solicitud_serv.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_detalle_seguimiento_solicitud_serv,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_getCM=this.getColumnModel;
	
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
		
		
	var paramFunciones={
	};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(m){
		maestro=m;

		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_solicitud_compra:maestro.id_solicitud_compra,
				vista:1
			}
		};
		this.btnActualizar();
		
		
		
		//iniciarEventosFormularios();
		this.InitFunciones(paramFunciones)
	};
	function btn_caracteristica(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_solicitud_compra_det='+SelectionsRecord.data.id_solicitud_compra_det;
			
			var ParamVentana={ventana:{width:'90%',height:'70%'}};
			layout_detalle_seguimiento_solicitud_serv.loadWindows(direccion+'../../../vista/caracteristica/caracteristica_min.php?'+data,'Características Adicionales',ParamVentana);
layout_detalle_seguimiento_solicitud_serv.getVentana().on('resize',function(){
			layout_detalle_seguimiento_solicitud_serv.getLayout().layout();
				})
		}
		else{
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.')
	}
		}
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
		//alert('entra');
		if(refo=='0'){
			
				CM_getCM().setHidden(9,true);
				CM_getCM().setHidden(10,true);
				CM_getCM().setHidden(11,true);
				CM_getCM().setHidden(12,true);
			}
		
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_detalle_seguimiento_solicitud_serv.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
		this.AdicionarBoton('../../../lib/imagenes/list-items.gif','Características Adicionales',btn_caracteristica,true,'caracteristica','');

	this.iniciaFormulario();
	iniciarEventosFormularios();
	this.bloquearMenu();
	layout_detalle_seguimiento_solicitud_serv.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}