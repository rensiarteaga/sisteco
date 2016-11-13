/**
 * Nombre:		  	    pagina_concepto_ingas.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-07-07 15:19:34
 */
function pagina_concepto_ingas(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var vectorAtributos=new Array,sw=0;
	var txt_id_concepto_ingas,txt_desc_ingas;
	var combo_item,combo_servicio,txt_desc_ingas_item_serv;
	//  DATA STORE //
		
	var ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/concepto_ingas/ActionListarConceptoIngas.php'}),
		// aqui se define la estructura del XML
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_concepto_ingas',
			totalRecords:'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_concepto_ingas',
		'desc_ingas',
		'id_partida',
		'desc_partida',
		'id_item',
		'desc_item',
		'id_servicio',
		'desc_servicio',
		'desc_ingas_item_serv',
		'id_oec','nombre_oec',
		'estado'
		]),remoteSort:true});
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_partida:maestro.id_partida
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>'}
	function italic(value){return '<i>'+value+'</i>'}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	var data_maestro=[['Partida ',' ' + maestro.codigo_partida + ' - ' + maestro.nombre_partida]];
	//DATA STORE COMBOS
   var ds_item=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_almacenes/control/item/ActionListarItem.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_item',totalRecords:'TotalCount'},['id_item','codigo','nombre','descripcion','stock_min','observaciones','estado_item'])
	});
	//FUNCIONES RENDER
		function render_id_item(value,p,record){return String.format('{0}', record.data['desc_ingas_item_serv'])}
		function render_desc(value,p,record){return String.format('{0}', record.data['desc_ingas_item_serv'])}
		function renderServicio(value,p,record){return String.format('{0}', record.data['desc_ingas_item_serv'])}
		var tpl_id_item=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Código: </b>{codigo}</FONT>','</div>');
		var tpl_id_servicio=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','</div>');
		
		 		var ds_oec = new Ext.data.Store({proxy: new Ext.data.HttpProxy({
		url: direccion+'../../../../sis_tesoreria/control/oec/ActionListarOecField.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_oec',totalRecords: 'TotalCount'},['id_oec','desc_oec', 'nro_oec','nombre_oec','sw_transaccional'])}); 
 

	function render_id_oec(value, p, record){return String.format('{0}', record.data['nombre_oec'])}
	
	
	var tpl_id_oec=new Ext.Template('<div class="search-item">','<b>OEC: </b><FONT COLOR="#B5A642">{nombre_oec}</FONT><br>','</div>');

	//alert (maestro.tipo_memoria);
	
		    
		   
	// Definición de datos //
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_concepto_ingas',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_concepto_ingas'
	};
// txt id_partida
	vectorAtributos[1]={
		validacion:{
			name:'id_partida',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_partida,
		save_as:'id_partida'
	};
	vectorAtributos[2]={
		validacion:{
			name:'id_item',
			desc:'desc_item',
			fieldLabel:'Item',
			allowBlank:true,
			tipo:'ingreso',//determina el action a llamar
			maxLength:100,
			renderer:render_id_item,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:false,
			grid_editable:false,
			width_grid:150,
			width:150,
			pageSize:10,
			direccion:direccion			
		},
		tipo:'LovItemsAlm',
		//filterColValue:'desc_ingas_item_serv',		
		filterColValue:'ite.codigo',
		filtro_0:false,
		save_as:'id_item'
		
	};
	vectorAtributos[3]={
		validacion:{
			name:'id_servicio',
			desc:'desc_servicio',
			fieldLabel:'Servicio',
			tipo:'ingreso',
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:false,
			grid_editable:false,
			renderer:renderServicio,
			width_grid:200,
			width:250,
			pageSize:10,
			direccion:direccion
		},
		tipo:'LovServicio',
		save_as:'id_servicio'
	};
	
	vectorAtributos[4]={
		validacion:{
			name:'desc_ingas_item_serv',
			fieldLabel:'Descripción',
			allowBlank:true,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:400,
			width:'75%',
			disable:false		
		},
		tipo:'TextArea',
		form:true,
		filtro_0:true,
		save_as:'desc_ingas_item_serv',
		filterColValue:'desc_ingas_item_serv'			
	};		
	// txt desc_ingas
	vectorAtributos[5]={
		validacion:{
			name:'desc_ingas',
			fieldLabel:'Descripción',
			allowBlank:true,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			renderer:render_desc,
			width_grid:400,
			width:'75%',
			disable:false		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:false,
		//filterColValue:'desc_ingas',
		filterColValue:'desc_ingas_item_serv',
		save_as:'desc_ingas'
	};
	vectorAtributos[6]={
			validacion:{
			name:'id_oec',
			fieldLabel:'OEC',
			allowBlank:true,			
			emptyText:'OEC...',
			desc: 'nombre_oec', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_oec,
			valueField: 'id_oec',
			displayField: 'desc_oec',
			queryParam: 'filterValue_0',
			filterCol: 'nro_oec#nombre_oec',
			typeAhead:false,
			tpl:tpl_id_oec,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_oec,
			grid_visible:true,
			grid_editable:true,
			width_grid:300,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: false,
		filtro_0:true,
	 
		filterColValue:'oec.id_oec',
		save_as:'id_oec'
	};	
	vectorAtributos[7]=
	{
		validacion:{
			name: 'estado',
			fieldLabel:'Estado',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['activo','Activo'],['inactivo','Inactivo']]}),				
			valueField:'id',
			displayField:'valor',
			lazyRender:true,								
			forceSelection:true,
			//emptyText:'Seleccione una opción...',
			width:'100%',
			grid_visible:true
		},
		tipo: 'ComboBox',
		filtro_0:true,			
		
		defecto:'activo',
		save_as:'estado'
	};
	
	
	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Clasificador Presupuestario por Objeto de Gasto (Maestro)',titulo_detalle:'Conceptos de Gasto (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_concepto_ingas=new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_concepto_ingas.init(config);
	//---------- INICIAMOS HERENCIA
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_concepto_ingas,idContenedor);
	var ClaseMadre_getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_btnEliminar=this.btnEliminar;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var EstehtmlMaestro=this.htmlMaestro;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_save=this.Save;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_btnActualizar=this.btnActualizar;
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
//DEFINICIÓN DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/concepto_ingas/ActionEliminarConceptoIngas.php',parametros:'&m_id_partida='+maestro.id_partida},
	Save:{url:direccion+'../../../control/concepto_ingas/ActionGuardarConceptoIngas.php',parametros:'&m_id_partida='+maestro.id_partida},
	ConfirmSave:{url:direccion+'../../../control/concepto_ingas/ActionGuardarConceptoIngas.php',parametros:'&m_id_partida='+maestro.id_partida},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:305,width:430,minWidth:150,minHeight:200,	closable:true,titulo:'Ingreso - Gasto'}};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
	   	maestro.id_partida=datos.m_id_partida;
       	maestro.codigo_partida=datos.m_codigo_partida;
       	maestro.nombre_partida=datos.m_nombre_partida;
       	maestro.nivel_partida=datos.m_nivel_partida;
       	maestro.tipo_partida=datos.m_tipo_partida;
       	maestro.estado_gral=datos.m_estado_gral;
       	maestro.tipo_memoria=datos.m_tipo_memoria; 
       	
       	
		data_maestro=[['Partida ',' ' + maestro.codigo_partida + ' - ' + maestro.nombre_partida]];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		vectorAtributos[1].defecto=maestro.id_partida;
	   	
		paramFunciones={
	   	btnEliminar:{url:direccion+'../../../control/concepto_ingas/ActionEliminarConceptoIngas.php',parametros:'&m_id_partida='+maestro.id_partida},
	   	Save:{url:direccion+'../../../control/concepto_ingas/ActionGuardarConceptoIngas.php',parametros:'&m_id_partida='+maestro.id_partida},
	   	ConfirmSave:{url:direccion+'../../../control/concepto_ingas/ActionGuardarConceptoIngas.php',parametros:'&m_id_partida='+maestro.id_partida},
       	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:205,width:430,minWidth:150,minHeight:200,	closable:true,titulo:'Ingreso - Gasto'}};
	   	this.InitFunciones(paramFunciones);
	   	ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_partida:maestro.id_partida
			}
		};
		this.btnActualizar()
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	 txt_id_concepto_ingas=ClaseMadre_getComponente ('id_concepto_ingas');
	 txt_desc_ingas=ClaseMadre_getComponente ('desc_ingas');
	 combo_item=ClaseMadre_getComponente ('id_item');
	 combo_servicio=ClaseMadre_getComponente ('id_servicio');
	 txt_desc_ingas_item_serv=ClaseMadre_getComponente ('desc_ingas_item_serv')
	}

	this.btnNew=function(){
		 if(maestro.tipo_memoria==1 || maestro.tipo_memoria==4 || maestro.tipo_memoria==5 || maestro.tipo_memoria==6 || maestro.tipo_memoria==8 || maestro.tipo_memoria==9){
	 	    CM_ocultarComponente(combo_item);
	 	    CM_ocultarComponente(combo_servicio);
	 	    CM_ocultarComponente(txt_desc_ingas_item_serv);
	 	    CM_mostrarComponente(txt_desc_ingas);
	 	    txt_desc_ingas.allowBlank=false;
	 	    txt_desc_ingas_item_serv.allowBlank=true;
	 	    combo_item.allowBlank=true;
	 	    combo_servicio.allowBlank=true;
	 	    combo_item.setValue('');
	 	    combo_servicio.setValue('');
	 	    txt_desc_ingas_item_serv.setValue('');
            txt_desc_ingas.setValue('')
		  }
	     if(maestro.tipo_memoria==2 || maestro.tipo_memoria==3){
	 	    CM_mostrarComponente(txt_desc_ingas);
	 	    CM_ocultarComponente(combo_servicio);
	 	    CM_ocultarComponente(txt_desc_ingas_item_serv);
	 	  /* alert (ClaseMadre_getComponente ('id_item'));
	 	    
	 	    if (ClaseMadre_getComponente ('id_item')!=null){
	 	    	CM_mostrarComponente(combo_item);	
	 	    }
	 	    */
	 	   // CM_mostrarComponente(combo_item);
	 	    txt_desc_ingas.allowBlank=true;
	 	    txt_desc_ingas_item_serv.allowBlank=true;
	 	    combo_item.allowBlank=true;
	 	    combo_servicio.allowBlank=true;
	 	    combo_item.setValue('');
	 	    combo_servicio.setValue('');
	 	    txt_desc_ingas_item_serv.setValue('');
            txt_desc_ingas.setValue('')
	     }
	      if(maestro.tipo_memoria==7){
	 	    CM_mostrarComponente(txt_desc_ingas);
	 	    CM_ocultarComponente(combo_item);
	 	    CM_ocultarComponente(txt_desc_ingas_item_serv);
	 	    CM_mostrarComponente(combo_servicio);
	 	    txt_desc_ingas.allowBlank=true;
	 	    txt_desc_ingas_item_serv.allowBlank=true;
	 	    combo_item.allowBlank=true;
	 	    combo_servicio.allowBlank=true;
	 	    combo_item.setValue('');
	 	    combo_servicio.setValue('');
	 	    txt_desc_ingas_item_serv.setValue('');
            txt_desc_ingas.setValue('')
	     }
		if(maestro.estado_gral==0 || maestro.estado_gral==1){
			ClaseMadre_btnNew()
		}
		else{
			Ext.MessageBox.alert('ESTADO', 'Para añadir mas datos, el estado de la Gestión debe ser de Formulación o Revisión.');
		}
	};
	this.btnEdit=function(){
		if(maestro.tipo_memoria==1 || maestro.tipo_memoria==4 || maestro.tipo_memoria==5 || maestro.tipo_memoria==6 || maestro.tipo_memoria==8 || maestro.tipo_memoria==9){
	 	    CM_ocultarComponente(combo_item);
	 	    CM_ocultarComponente(combo_servicio);
	 	    CM_ocultarComponente(txt_desc_ingas_item_serv);
	 	    CM_mostrarComponente(txt_desc_ingas);
	 	    txt_desc_ingas.allowBlank=false;
	 	    txt_desc_ingas_item_serv.allowBlank=true;
	 	    combo_item.allowBlank=true;
	 	    combo_servicio.allowBlank=true;
		  }
	     if(maestro.tipo_memoria==2 || maestro.tipo_memoria==3){
	 	    CM_mostrarComponente(txt_desc_ingas);
	 	    CM_ocultarComponente(combo_servicio);
	 	    CM_ocultarComponente(txt_desc_ingas_item_serv);
	 	    alert (ClaseMadre_getComponente ('id_item').getValue());
	 	    
	 	    if (ClaseMadre_getComponente ('desc_ingas').getValue()!=null || ClaseMadre_getComponente ('desc_ingas').getValue()!=''){
	 	    	CM_mostrarComponente(combo_item);	
	 	    }
	 	   
	 	    txt_desc_ingas.allowBlank=true;
	 	    txt_desc_ingas_item_serv.allowBlank=true;
	 	    combo_item.allowBlank=false;
	 	    combo_servicio.allowBlank=true;
	     }
	      if(maestro.tipo_memoria==7){
	 	    CM_mostrarComponente(txt_desc_ingas);
	 	    CM_ocultarComponente(combo_item);
	 	    CM_ocultarComponente(txt_desc_ingas_item_serv);
	 	    CM_mostrarComponente(combo_servicio);
	 	    txt_desc_ingas.allowBlank=true;
	 	    txt_desc_ingas_item_serv.allowBlank=true;
	 	    combo_item.allowBlank=true;
	 	    combo_servicio.allowBlank=true;
	 	    
	 	    
	     }
		if(maestro.estado_gral==0 || maestro.estado_gral==1){
			ClaseMadre_btnEdit()
		}
		else{
			Ext.MessageBox.alert('ESTADO', 'Para modificar los datos, el estado de la Gestión debe ser de Formulación o Revisión.');
		}
	};
	this.btnEliminar=function(){
		if(maestro.estado_gral==0 || maestro.estado_gral==1){
			ClaseMadre_btnEliminar()
		}
		else{
			Ext.MessageBox.alert('ESTADO', 'Para eliminar los datos, el estado de la Gestión debe ser de Formulación o Revisión.');
		}
	};
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_concepto_ingas.getLayout()};
	//para el manejo de hijos
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_concepto_ingas.getLayout().addListener('layout',this.onResize);
	layout_concepto_ingas.getVentana(idContenedor).on('resize',function(){layout_concepto_ingas.getLayout().layout()})
}