/**
 * Nombre:		  	    pagina_registro_transacion.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-09-16 17:57:09
 */
function pagina_ConceptoFactura(idContenedor,direccion,paramConfig,idContenedorPadre){

	 
 	
	//variables de eventos 
	var	var_id_transaccion;
	var	var_id_comprobante;
	var	var_id_presupuesto;
	var	var_id_orden_trabajo;
	var	var_id_partida_cuenta;
	var	var_id_auxiliar;
	var	var_id_oec;
	var	var_concepto_tran;
	var	var_importe_debe;
	var	var_importe_haber;
	var	var_importe_gasto;
	var	var_importe_recurso;
	var	var_id_cuenta;
	var	var_id_partida;
	var Atributos=new Array;
	var componentes=new Array();
	var componentes_grid=new Array();
	
	var var_id_sistema_distribucion;
	var var_id_lugar;
	var	var_id_categoria_cliente;

	var	var_nombre_lugar;
	var	var_nombre_categoria_cliente;
	 
	//variables para filtrar
 
	var sw_filtrar=' ';
	sw_ingreso=' ';
	//variables de clase madre
	var dialog;
	var data='';
	var grid;
	var var_record;
	var var_rowIndex;
	
	// clase de comprobante
	var  cont_dia='Contable Diario';
	var  cont_pre_dia='Contable Presupuestario Diario';
	var  cont_caja ='Contable Caja';
	var  cont_pre_caja ='Contable Presupuestario Caja';
	var  cont_pago= 'Contable Pago';
	var  cont_pre_pago='Contable Presupuestario Pago';
	var  pre='Presupuestario';
	// variables de funcionamiento
	var var_id_gestion='';	
	var var_id_fuente_financiamiento;
	var var_id_unidad_organizacional;
	var var_id_epe;
	var var_tipo_pres;
	

	var var_id_moneda;
	var var_fecha;
	var var_sw_tipo_cambio=true;
	var var_id_parametro_conta='';
	var var_id_depto_conta='';
	var var_fecha_trans;
	//var paginaPadre;
	
	var maestro={id_parametro:0,id_comprobante:0,id_moneda_reg:0};	
 
 	
  var Trasaccion = Ext.data.Record.create([		
			'id_concepto_factura'  ,
			'nombre_concepto'  ,
			'id_lugar'  ,
			'id_sistema_distribucion'  ,
			'tipo_concepto'  ,
			'id_categoria_cliente'  ,
			'nombre_lugar'  ,
			'nombre_categoria_cliente'  

		]); 
 
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/ConceptoFactura/ActionListarConceptoFactura.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_concepto_factura',totalRecords:'TotalCount'
		},Trasaccion),remoteSort:true});
		 
		
  
  
	//DATA STORE COMBOS
		function render_momento(value, p, record)
		{	if(value=='categoria'){return 'Categoria Cliente';}
			if(value=='lugar'){return 'Lugar';} 
			if(value=='global'){return 'Global';} 
 
		}
	
	var ds_id_lugar_dbl=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/Lugar/ActionListarLugar.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_lugar',totalRecords:'TotalCount'},['id_lugar','nombre_lugar','id_sistema_distribucion','nombre_sistema_distribucion'])});
	function render_id_lugar_dbl(value, p, record){return String.format('{0}', record.data['nombre_lugar'])};
	var tpl_id_lugar_dbl=new Ext.Template('<div class="search-item">','<b>Lugar: </b><FONT COLOR="#0000ff">{nombre_lugar}</FONT><br>', '<b>Sistema: </b><FONT COLOR="#0000ff">{nombre_sistema_distribucion}</FONT>','</div>');

	var ds_id_categoria_dbl=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/Categoria/ActionListarCategoria.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_categoria',totalRecords:'TotalCount'},['id_categoria','nombre_categoria','id_sistema_distribucion','nombre_sistema_distribucion'])});
	function render_id_categoria_dbl(value, p, record){return String.format('{0}', record.data['nombre_categoria_cliente'])};
	var tpl_id_categoria_dbl=new Ext.Template('<div class="search-item">','<b>Categoria: </b><FONT COLOR="#0000ff">{nombre_categoria}</FONT><br>', '<b>Sistema: </b><FONT COLOR="#0000ff">{nombre_sistema_distribucion}</FONT>','</div>');

	
	
	
  
	

	Atributos[0]={
		validacion:{labelSeparator:'',
				name: 'id_concepto_factura',
				inputType:'hidden',
				grid_visible:false,
				 grid_editable:false},
		tipo: 'Field',
		filtro_0:false,
		id_grupo:0,
		save_as:'id_concepto_factura'
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
			name:'nombre_concepto',
			fieldLabel:'Nombre Concepto',
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
		filterColValue:'nombre_concepto',
		save_as:'nombre_concepto'
	};
	Atributos[3]={
			validacion:{
				name:'tipo_concepto',
				fieldLabel:'Tipo Concepto',
				allowBlank:false,
				align:'left',
				emptyText:'Tipo Con...',
				loadMask:true,
				maxLength:50,
				minLength:0,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['categoria','Categoria Cliente'],['lugar','Lugar'],['global','Global']]}),
				valueField:'ID',
				displayField:'valor',
				mode:'local',
				lazyRender:true,
				forceSelection:true,
				grid_visible:true,
				renderer:render_momento,
				grid_editable:false,
				width_grid:200,
				minListWidth:200,
				disabled:false
			},
			tipo:'ComboBox',
			form: true,
			id_grupo:1,
			save_as:'tipo_concepto'
		};
	Atributos[4]={
		validacion:{
				fieldLabel:'Lugar',
				allowBlank:false,
				emptyText:'Lugar...',
				name:'id_lugar',
				desc:'nombre_lugar',
				store:ds_id_lugar_dbl,
				valueField:'id_lugar',
				displayField:'nombre_lugar',
				queryParam:'filterValue_0',
				filterCol:'nombre_lugar',
				tpl:tpl_id_lugar_dbl,
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
				renderer:render_id_lugar_dbl,
				grid_visible:true,
				grid_editable:false,
				width:200,
				width_grid:400 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			filtro_0:true,
		    id_grupo:1,
			form: true,
	 		filterColValue:'nombre_lugar',
	  		save_as:'id_lugar'
	};
	 	Atributos[5]={
		validacion:{
				fieldLabel:'Categoria Cliente',
				allowBlank:false,
				emptyText:'categoria...',
				name:'id_categoria_cliente',
				desc:'nombre_categoria',
				store:ds_id_categoria_dbl,
				valueField:'id_categoria',
				displayField:'nombre_categoria',
				queryParam:'filterValue_0',
				filterCol:'nombre_categoria',
				tpl:tpl_id_categoria_dbl,
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
				renderer:render_id_categoria_dbl,
				grid_visible:true,
				grid_editable:false,
				width:200,
				width_grid:400 // ancho de columna en el gris
			},
			tipo:'ComboBox',
			filtro_0:true,
		    id_grupo:1,
			form: true,
	 		filterColValue:'nombre_categoria_cliente',
	  		save_as:'id_categoria_cliente'
	};
		Atributos[6]={
			validacion:{
				name:'nombre_lugar',
				fieldLabel:'nombre_lugar',
				allowBlank:true,
				maxLength:150,
				minLength:0,
				selectOnFocus:true,
				
				grid_visible:false,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false
			},
			tipo: 'TextField',
			form: true,
			filtro_0:true,
			id_grupo:0,
			filterColValue:'confac.nombre_lugar',
			save_as:'nombre_lugar'
		};	
		Atributos[7]={
			validacion:{
				name:'nombre_categoria_cliente',
				fieldLabel:'nombre_categoria_cliente',
				allowBlank:true,
				maxLength:150,
				minLength:0,
				selectOnFocus:true,
				
				grid_visible:false,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false
			},
			tipo: 'TextField',
			form: true,
			filtro_0:true,
			id_grupo:0,
			filterColValue:'confac.nombre_categoria_cliente',
			save_as:'nombre_categoria_cliente'
		};
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
 
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Registro de Comprobante (Maestro)',titulo_detalle:'Detalle Transacción (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_registro_concepto_factura=new DocsLayoutMaestro(idContenedor,idContenedorPadre);
	layout_registro_concepto_factura.init(config);	

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_registro_concepto_factura,idContenedor);
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
		btnEliminar:{url:direccion+'../../../control/ConceptoFactura/ActionEliminarConceptoFactura.php'},
		Save:{url:direccion+'../../../control/ConceptoFactura/ActionGuardarConceptoFactura.php'},
		ConfirmSave:{url:direccion+'../../../control/ConceptoFactura/ActionGuardarConceptoFactura.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,columnas:['90%'],
		grupos:[{tituloGrupo:'Datos',columna:0,id_grupo:0},{tituloGrupo:'Datos Concepto Factura',columna:0,id_grupo:1}],
		width:'50%',
		minWidth:150,
		minHeight:200,	
		closable:true,
		titulo:'Registro Concepto Factura'
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
		   	
			var_id_lugar.store.baseParams={id_sistema_distribucion:maestro.id_sistema_distribucion};
			var_id_categoria_cliente.store.baseParams={id_sistema_distribucion:maestro.id_sistema_distribucion};
			var_id_lugar.modificado=true;   		   	
			var_id_categoria_cliente.modificado=true;   		   	
			this.desbloquearMenu();		
	};	
	
	function InitRegistroConceptoFactura()
	{
		grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		
		sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();

		var_id_sistema_distribucion=ClaseMadre_getComponente('id_sistema_distribucion');
		var_id_lugar=ClaseMadre_getComponente('id_lugar');
		var_id_categoria_cliente=ClaseMadre_getComponente('id_categoria_cliente');
		
		var_tipo_concepto=ClaseMadre_getComponente('tipo_concepto');
		var_nombre_lugar=ClaseMadre_getComponente('nombre_lugar');
		var_nombre_categoria_cliente=ClaseMadre_getComponente('nombre_categoria_cliente');
	 
		var_id_lugar.on('select',f_set_nombre_lugar);	
		var_id_categoria_cliente.on('select',f_set_nombre_categoria);	 
		var_tipo_concepto.on('select',f_sw_categoria_lugar);	 
		 
		
		 
		
		
		getSelectionModel().on('rowselect',	function( SM,rowIndex){													
																	var_record=SM.getSelected().data;
																	var_rowIndex=rowIndex;})
		
		
 	};

  function f_sw_categoria_lugar( combo, record, index ){
	  	
  		var_id_lugar.setValue('');
  		var_id_categoria_cliente.setValue('');
  		var_nombre_lugar.setValue('');
		var_nombre_categoria_cliente.setValue('');
  		var_id_categoria_cliente.allowBlank=true;
  		var_id_lugar.allowBlank=true;
  		if (record.data.ID=='categoria'){
  			var_id_lugar.allowBlank=true;
  			CM_ocultarComponente(var_id_lugar);
  			CM_mostrarComponente(var_id_categoria_cliente);
  			var_id_categoria_cliente.allowBlank=false;
  		}
		if (record.data.ID=='lugar'){
			var_id_categoria_cliente.allowBlank=true;
  			CM_ocultarComponente(var_id_categoria_cliente);
  			CM_mostrarComponente(var_id_lugar);
  			var_id_lugar.allowBlank=false;
  		}
	
	}
	function f_set_nombre_lugar( combo, record, index ){
	var_nombre_lugar.setValue(record.data.nombre_lugar);
	}
	function  f_set_nombre_categoria( combo, record, index ){
	var_nombre_categoria_cliente.setValue(record.data.nombre_categoria);
	
	}
			
	function btn_registro_columna_valor(){
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
			layout_registro_concepto_factura.loadWindows(direccion+'../../../../sis_cobranza/vista/SistemaDistribucion/columna_valor.php?'+data,'Columna',ParamVentana);
			sm.clearSelections();
			}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
		
	
	}
 
 
	 
	
	this.btnNew=function(){
		ClaseMadre_btnNew();
		CM_ocultarComponente(var_id_categoria_cliente); 
		CM_ocultarComponente(var_id_lugar);
		var_id_sistema_distribucion.setValue(maestro.id_sistema_distribucion); 
	};
	
	
	
	this.getLayout=function(){return layout_registro_concepto_factura.getLayout()};
	 

 
 
	//Para manejo de eventos
	
/**********************************************************************************/	
 
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	
	this.getLayout=function(){return layout_registro_concepto_factura.getLayout()};
	this.InitFunciones(paramFunciones);
	//para agregar botones
	//this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Nuevo',btn_nuevo_grid,true,'nuevo_grid','Nuevo');
	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Columna',btn_registro_columna_valor,true,'registro de columna valor','Columna');
 
	//this.AdicionarBoton('','Calculadora',btn_calculadora,true,'Caluladora','Calculadora');
	this.iniciaFormulario();
	this.bloquearMenu();	
	InitRegistroConceptoFactura();
	CM_ocultarGrupo('Datos');
	layout_registro_concepto_factura.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
   // ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
     _CP.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);


}