/**
 * Nombre:		  	    pagina_tipo_adq.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-05-16 11:47:21
 */
function pagina_tipo_adq(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_adq/ActionListarTipoAdq.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_tipo_adq',totalRecords:'TotalCount'
		},[		
				'id_tipo_adq',
		'nombre',
		'observaciones',
		'tipo_adq',
		'descripcion',
		'codigo','estado',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'}

		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	//DATA STORE COMBOS

	//FUNCIONES RENDER
	
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_tipo_adq
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_tipo_adq',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_tipo_adq'
	};
	
	// txt tipo_aadq
	Atributos[1]={
		validacion:{
			name:'tipo_adq',
			fieldLabel:'Tipo de Adquisición',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({
				fields:['ID', 'valor'],
				data:Ext.tipo_adq_combo.tipo_adq
				
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true, 
			grid_indice:5,
			width_grid:75,
			grid_editable:false 
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'TIPADQ.tipo_adq',
		defecto:'Bien',
		save_as:'tipo_adq'
	};
	
// txt nombre
	Atributos[2]={
		validacion:{
			name:'nombre',
			fieldLabel:'Nombre',
			allowBlank:false,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:200,
			width:'85%',
			disable:false,
			grid_indice:2		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'TIPADQ.nombre',
		save_as:'nombre'
	};
	
	// txt codigo
	Atributos[3]={
		validacion:{
			name:'codigo',
			fieldLabel:'Codigo',
			allowBlank:false,
			maxLength:2,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:60,
			width:40,
			disabled:false,
			grid_indice:1		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'TIPADQ.codigo',
		save_as:'codigo'
	};

	// txt descripcion
	Atributos[4]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:false,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:150,
			width:'100%',
			disable:false,
			grid_indice:3		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'TIPADQ.descripcion',
		save_as:'descripcion'
	};
// txt observaciones
	Atributos[5]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:false,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:150,
			width:'100%',
			disable:false,
			grid_indice:4		
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		defecto:' - ',
		filterColValue:'TIPADQ.observaciones',
		save_as:'observaciones'
	};
	

// txt fecha_reg
	Atributos[6]= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha de Registro',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			renderer: formatDate,
			width_grid:105,
			disabled:true,
			grid_indice:6		
		},
		form:false,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'TIPADQ.fecha_reg',
		dateFormat:'m-d-Y'
	};
	// txt codigo
	Atributos[7]={
		validacion:{
			name:'estado',
			fieldLabel:'Estado',
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
		store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','Activo'],['inactivo','Inactivo']]}),
			valueField:'ID',
			displayField:'valor',
   	        allowBlank:false,
			maxLength:10,
			align:'center',
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:60,
			align:'right',
			width:80,
			disable:true,
			grid_indice:7	
		},
		tipo: 'ComboBox',
		defecto:'activo',
		form: true,
		filtro_0:true,
		filterColValue:'TIPADQ.estado',
		save_as:'estado'
	};
	
	
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	//var config={titulo_maestro:'tipo_adq',grid_maestro:'grid-'+idContenedor};
	var config={titulo_maestro:'tipo_adq',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_adquisiciones/vista/tipo_servicio/tipo_servicio_det.php'};
	//var layout_tipo_adq=new DocsLayoutMaestro(idContenedor);
	var layout_tipo_adq=new DocsLayoutMaestroDeatalle(idContenedor);
	layout_tipo_adq.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_tipo_adq,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_conexionFailure=this.conexionFailure;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var Cm_getDialog=this.getDialog;

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/tipo_adq/ActionEliminarTipoAdq.php'},
		Save:{url:direccion+'../../../control/tipo_adq/ActionGuardarTipoAdq.php'},
		ConfirmSave:{url:direccion+'../../../control/tipo_adq/ActionGuardarTipoAdq.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:450,minWidth:150,minHeight:200,	closable:true,titulo:'Tipo de Adquisición'}};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
function btn_tipo_servicio(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_tipo_adq='+SelectionsRecord.data.id_tipo_adq;
			data=data+'&m_nombre='+SelectionsRecord.data.nombre;
			data=data+'&m_descripcion='+SelectionsRecord.data.descripcion;
            data=data+'&m_codigo='+SelectionsRecord.data.codigo;
			var ParamVentana={Ventana:{width:'85%',height:'70%'}}
			layout_tipo_adq.loadWindows(direccion+'../../../../sis_adquisiciones/vista/tipo_servicio/tipo_servicio_det.php?'+data,'Tipos de Servicio',ParamVentana);
			layout_tipo_adq.getVentana().on('resize',function(){
			layout_tipo_adq.getLayout().layout();
			})
		}
	else
	{
		Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
	}
	}
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
				dialog=Cm_getDialog();
				getSelectionModel().on('rowdeselect',function(){
				
					if(_CP.getPagina(layout_tipo_adq.getIdContentHijo()).pagina.limpiarStore()){
						_CP.getPagina(layout_tipo_adq.getIdContentHijo()).pagina.bloquearMenu()
					}
				})
	}
	this.EnableSelect=function(x,z,y){
			 enable(x,z,y);
			 _CP.getPagina(layout_tipo_adq.getIdContentHijo()).pagina.reload(y.data);
				_CP.getPagina(layout_tipo_adq.getIdContentHijo()).pagina.desbloquearMenu();
		    }
	//para llamar al boton New
this.btnEdit=function(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data=SelectionsRecord.data.id_proceso_compra;
        		
			verificar_NumTipServicios();
			verificar_NumTipSolicitudes();
			
			CM_btnEdit();
			}
				else{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
		}
		
	//para verificar
function verificar_NumTipServicios()
		{
	   		var sm=getSelectionModel();
	   		var filas=ds.getModifiedRecords();
	   		var cont=filas.length;
	   		var NumSelect=sm.getCount();
	   		var SelectionsRecord=sm.getSelected();
	   		var data='m_id_tipo_adq='+SelectionsRecord.data.id_tipo_adq;
	
		Ext.Ajax.request({
			url:direccion+"../../../control/tipo_servicio/ActionListarTipoServicio_det.php?"+data,
			method:'GET',
			success:verificar,
			failure:CM_conexionFailure,
			timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
			});
		}

	function verificar(resp){
		//	Ext.MessageBox.hide();
			if(resp.responseXML!=undefined && resp.responseXML!=null&& resp.responseXML.documentElement!=null &&resp.responseXML.documentElement!=undefined){
				var root=resp.responseXML.documentElement;
				num_tipo_servicios=root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue;
				
				//if(on==0){
					
				  if((root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue)>0){
				  	
				  	 
				  	// getComponente('codigo').setValue(root.getElementsByTagName('codigo')[0].firstChild.nodeValue);
				  	 getComponente('codigo').disable();
				    //CM_ocultarComponente(getComponente('fecha_venc'));	
				  	
				  }else{
				 	 getComponente('codigo').enable();
				 	 
				}
				
			}
		}		
/* para verificar si el tipo de adquisición se encuentra en  en solicitudes */ 
 function verificar_NumTipSolicitudes()
		{
	   		var sm=getSelectionModel();
	   		var filas=ds.getModifiedRecords();
	   		var cont=filas.length;
	   		var NumSelect=sm.getCount();
	   		var SelectionsRecord=sm.getSelected();
	   		var data='m_id_tipo_adq='+SelectionsRecord.data.id_tipo_adq+'&tipo=tipo_adq';
	
		Ext.Ajax.request({
			url:direccion+"../../../control/solicitud_compra/ActionListarSolicitudCompra.php?"+data,
			method:'GET',
			success:verificarSol,
			failure:CM_conexionFailure,
			timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
			});
		}

	function verificarSol(resp){
		//	Ext.MessageBox.hide();
			if(resp.responseXML!=undefined && resp.responseXML!=null&& resp.responseXML.documentElement!=null &&resp.responseXML.documentElement!=undefined){
				var root=resp.responseXML.documentElement;
				num_tipo_servicios=root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue;
				
				//if(on==0){
					
				  if((root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue)>0){
				  	
				  	 
				  	// getComponente('codigo').setValue(root.getElementsByTagName('codigo')[0].firstChild.nodeValue);
				  	 getComponente('tipo_adq').disable();
				    //CM_ocultarComponente(getComponente('fecha_venc'));	
				  	
				  }else{
				 	 getComponente('tipo_adq').enable();
				 	 
				}
				
			}
		}				
//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_tipo_adq.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	//	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Tipos de Servicio',btn_tipo_servicio,true,'tipo_servicio','');

	function  enable(sel,row,selected){
				var record=selected.data; 
			}	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_tipo_adq.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}