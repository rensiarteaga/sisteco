/**
 * Nombre:		  	    pagina_plantilla.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-16 12:20:40
 */
function pagina_plantilla(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;

	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/plantilla/ActionListarPlantilla.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_plantilla',totalRecords:'TotalCount'
		},[		
				'id_plantilla',
		'tipo_plantilla',
		'nro_linea',
		'desc_plantilla',
		'tipo',
		'sw_tesoro',
		'sw_compro'
		]),remoteSort:true});
	/*	function render_concepto_ingas(value)
	{
		if(value==1){value='Si'	}
		if(value==2){value='No'	}
		if(value==3){value='Viáticos'	}
		return value
	}
	1(Facturas),2(proformas),3(por definir)
sw_tesoro :1(Si Tesoro), 0(No Tesoro)
	
	*/
	
      function render_tipo(value){
      	var value1;
      	if  (value==1){value1='Facturas'}
      	if  (value==2){value1='Recibo'}
      	if  (value==3){value1='Proforma'}
      	if  (value==4){value1='Por Definir'}
      	return value1
      	
      }
      
      function render_sw_tesoro(value){
      	var value1;
      	if  (value==1){value1='Si Tesoro'}
      	if  (value==0){value1='No Tesoro'}
      	
      	return value1
      	
      }
       function render_sw_compro(value){
      	var value1;
      	if  (value==1){value1='Si Compro'}
      	if  (value==0){value1='No Compro'}
      	
      	return value1
      	
      }
      
     // function rendet
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_plantilla',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_plantilla'
	};
// txt tipo_plantilla
	Atributos[1]={
		validacion:{
			name:'tipo_plantilla',
			fieldLabel:'Código de Plantilla',
			allowBlank:false,
			maxLength:2,
			minLength:1,
			align:'right', 
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'93%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'PLANT.tipo_plantilla',
		save_as:'tipo_plantilla'
	};
	
	Atributos[2]= {
		validacion:{
			name:'desc_plantilla',
			fieldLabel:'Descripción',
			allowBlank:false,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:250
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'PLANT.desc_plantilla',
		save_as:'desc_plantilla'
	};
	
// txt nro_linea
	Atributos[3]={
		validacion:{
			name:'nro_linea',
			fieldLabel:'Número Linea',
			allowBlank:false,
			maxLength:2,
			minLength:1,
			align:'right', 
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'30%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'PLANT.nro_linea',
		save_as:'nro_linea'
	};

	Atributos[4]= {
		validacion:{
			name:'tipo',
			fieldLabel:'Tipo',
			allowBlank:false,
			typeAhead:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['1','Facturas'],
			                                  						  ['2','Recibos'],
			                                						  ['3','Proformas'],
			                                						  ['4','Por Definir'],
			                                						]}),
	        valueField:'ID',
	        displayField:'valor',
	        renderer:render_tipo,
	        lazyRender:true,
	        forceSelection:true,
	      	grid_visible:true,
			grid_editable:true,
			renderer:render_tipo,
			width:100,
			disable:false,
			minListWidth:100
		},
		tipo: 'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PLANT.tipo',
		save_as:'tipo'
	};
	
	Atributos[5]= {
		validacion:{
			name:'sw_tesoro',
			fieldLabel:'SW Tesoro',
			allowBlank:false,
			typeAhead:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['0','No Tesoro'],['1','Si Tesoro']]}),
	        valueField:'ID',
	        displayField:'valor',
	        renderer:render_sw_tesoro,
	        lazyRender:true,
	        forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width:100
		},
		tipo: 'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PLANT.sw_tesoro',
		save_as:'sw_tesoro'
	};
	Atributos[6]= {
		validacion:{
			name:'sw_compro',
			fieldLabel:'SW Compro',
			allowBlank:false,
			typeAhead:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['0','No Compro'],['1','Si Compro']]}),
	        valueField:'ID',
	        displayField:'valor',
	        renderer:render_sw_compro,
	        lazyRender:true,
	        forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width:100
		},
		tipo: 'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PLANT.sw_compro',
		save_as:'sw_compro'
	};
	// ----------            FUNCIONES RENDER    ---------------//
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Plantilla',grid_maestro:'grid-'+idContenedor};
	var layout_plantilla=new DocsLayoutMaestro(idContenedor);
	layout_plantilla.init(config);

	
	// INICIAMOS HERENCIA //
		
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_plantilla,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;

	// DEFINICIÓN DE LA BARRA DE MENÚ//
	
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
		
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/plantilla/ActionEliminarPlantilla.php'},
		Save:{url:direccion+'../../../control/plantilla/ActionGuardarPlantilla.php'},
		ConfirmSave:{url:direccion+'../../../control/plantilla/ActionGuardarPlantilla.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'plantilla'}};
	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function btn_plantilla_calculo(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_plantilla='+SelectionsRecord.data.id_plantilla;
			data=data+'&m_desc_plantilla='+SelectionsRecord.data.desc_plantilla;
			data=data+'&m_tipo_plantilla='+SelectionsRecord.data.tipo_plantilla; 
			
       		var ParamVentana={Ventana:{width:'70%',height:'50%'}}
			layout_plantilla.loadWindows(direccion+'../../../../sis_contabilidad/vista/plantilla_calculo/plantilla_calculo.php?'+data,'Plantilla de Calculo',ParamVentana);

		}
		else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}

	function btn_plantilla_bancariz(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_plantilla='+SelectionsRecord.data.id_plantilla;
			data=data+'&m_desc_plantilla='+SelectionsRecord.data.desc_plantilla;
			    			   			    
	   		var ParamVentana={Ventana:{width:'70%',height:'50%'}}
			layout_plantilla.loadWindows(direccion+'../../../../sis_contabilidad/vista/plantilla_rel/plantilla_rel.php?'+data,'Plantilla de Bancarizacion',ParamVentana);
	
		}
		else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_plantilla.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	
	//para agregar botones
	
	this.AdicionarBoton('../../../lib/imagenes/a_xp.png','Plantilla de Calculo',btn_plantilla_calculo,true,'plantilla_calculo','Plantilla');
	this.AdicionarBoton('../../../lib/imagenes/a_xp.png','Plantilla Bancarizacion',btn_plantilla_bancariz,true,'plantilla_bancariz','Bancarizacion');

	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_plantilla.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}