/**
 * Nombre:		  	    pagina_empleado_cta.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-18 09:06:57
 */
function pagina_empleado_cta(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var layout_empleado_cta;
	var combo_persona,txt_codigo_empleado,txt_nombre_tipo_documento;
    var txt_doc_id,txt_email1;
    var maestro=new Array();
	var sw=0;
	var componentes=new Array;
	var dialog;
	var form;
	
	/////////////////
	//  DATA STORE //
	/////////////////
	ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/empleado_cta/ActionListarEmpleadoCta.php'}),
		// aqui se define la estructura del XML
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_empleado_cta',
			totalRecords:'TotalCount'
		},[
		// define el mapeo de XML a las etiquetas (campos)
		'id_empleado_cta',
		'id_empleado',
		'desc_persona',
		'id_gestion',
		'desc_gestion',	
		'id_cuenta',
		'nombre_cuenta',
		'id_auxiliar',
		'nombre_auxiliar',
		'estado_reg',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'}, 'id_cuenta_cobrar','nombre_cuenta_cobrar'
			
		]),remoteSort:true});

	//DATA STORE COMBOS   	
	
	var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/gestion/ActionListarGestion.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_gestion',totalRecords: 'TotalCount'},['id_gestion','denominacion','gestion','estado_ges_gral'])
	});
	
	var ds_cuenta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/cuenta/ActionListarCuenta.php'}),
	    reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta',totalRecords: 'TotalCount'},
	    ['id_cuenta','nro_cuenta','nombre_cuenta','desc_cta2','desc_cuenta','nivel_cuenta','tipo_cuenta',
	    'sw_transaccional','id_cuenta_padre','id_parametro','id_moneda','descripcion','sw_oec','sw_aux'])});
	
    var ds_auxiliar=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/auxiliar/ActionListarAuxiliar.php'}),
			reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_persona',
			totalRecords:'TotalCount'
		},['id_auxiliar','codigo_auxiliar','nombre_auxiliar','estado_auxiliar'])
	});
	
    ///17.04.2014
    var ds_cuenta_cobrar = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/cuenta/ActionListarCuenta.php'}),
	    reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta',totalRecords: 'TotalCount'},
	    ['id_cuenta','nro_cuenta','nombre_cuenta','desc_cta2','desc_cuenta','nivel_cuenta','tipo_cuenta',
	    'sw_transaccional','id_cuenta_padre','id_parametro','id_moneda','descripcion','sw_oec','sw_aux'])});
    function renderCuentaCobrar(value, p, record){return String.format('{0}', record.data['nombre_cuenta_cobrar']);}	
    var tpl_id_cuenta_cobrar=new Ext.Template('<div class="search-item">','<FONT COLOR="#000000">{desc_cta2}</FONT><br>','<b>Número: </b><FONT COLOR="#B5A642">{nro_cuenta}</FONT><br>','<b>Cuenta: </b><FONT COLOR="#B5A642">{nombre_cuenta}</FONT><br>','</div>'); 
 	
    
    
    
	function render_estado_reg(value)
	{
		if(value=='activo'){value='Activo'	}
		else{	value='Inactivo'		}
		return value
	}
    
	//FUNCIONES RENDER	
	function render_id_gestion(value,p,record){return String.format('{0}',record.data['desc_gestion'])}		
	function formatDate(value){return value ? value.dateFormat('d/m/Y') : '';};   
	function renderHaber(value, p, record){return String.format('{0}', record.data['nombre_cuenta']);}	
	function renderAuxiliar(value, p, record){return String.format('{0}', record.data['nombre_auxiliar']);}

//	var tpl_id_gestion=new Ext.Template('<div class="search-item">','<b>{gestion}</b><br>','<b>Estado: </b><FONT COLOR="#B5A642">{estado_ges_gral}</FONT><br>','</div>');
	var tpl_id_gestion=new Ext.Template('<div class="search-item">','<b><i>{gestion}</b></i>','<FONT COLOR="#B5A642">{denominacion}</FONT>','</div>'); //denominacion

	var tpl_id_cuenta=new Ext.Template('<div class="search-item">','<FONT COLOR="#000000">{desc_cta2}</FONT><br>','<b>Número: </b><FONT COLOR="#B5A642">{nro_cuenta}</FONT><br>','<b>Cuenta: </b><FONT COLOR="#B5A642">{nombre_cuenta}</FONT><br>','</div>'); 
 	var tpl_id_auxiliar=new Ext.Template('<div class="search-item">','<b>Código: </b><FONT COLOR="#B5A642">{codigo_auxiliar}</FONT><br>','<b>Auxiliar: </b><FONT COLOR="#B5A642">{nombre_auxiliar}</FONT><br>','</div>');
		
	
	
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_empleado_cta',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_empleado_cta'
	};
	
	// txt id_persona
	vectorAtributos[1]={
			validacion: {
			name:'id_gestion',
			fieldLabel:'Gestión',
			allowBlank:false,	
			//emptyText:'Gestión...',
			desc:'desc_gestion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_gestion,
			valueField:'id_gestion',
			displayField:'gestion',
			queryParam: 'filterValue_0',
			filterCol:'GESTIO.gestion',
			typeAhead:false,			
			tpl:tpl_id_gestion,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:15,
			minListWidth:350,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_gestion,
			grid_visible:true,
			grid_editable:false,
			width_grid:100, // ancho de columna en el gris
			width:'100%',
			disabled:false
		},
		tipo:'ComboBox',
		filtro_0:true,
		filterColValue:'GESTIO.desc_gestion',
		defecto: '',
		save_as:'id_gestion'
	};	
	
	vectorAtributos[2]= {
		validacion:{
			name:'id_cuenta',
			//desc:'desc_cuenta',
			desc: 'nombre_cuenta',
			allowBlank:true,
			fieldLabel:'Cuenta',
			tipo:'ingreso',//determina el action a llamar
			gestion:1,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true,
			grid_editable:false,
			renderer:renderHaber,
			width_grid:250,
			width:'90%',
			pageSize:10,
			disabled:true,
			onSelect:function(record){ 				
				//Ext.form.LovItemsAlm.superclass.setValue.call(this,v.desc)
				componentes[2].store.baseParams={m_id_partida:'',sw_reg_comp:'si'};
				componentes[2].setValue({id:record.data.id_cuenta,desc:record.data.desc_cuenta});				
				componentes[2].collapse();				
				ds_auxiliar.baseParams={cuenta:record.data.id_cuenta};				
				componentes[3].modificado=true;	
				componentes[3].setValue('');
				componentes[3].setDisabled(false);	
			},	
			direccion:direccion
		},
		tipo:'LovCuenta',
		filtro_0:true,
		filterColValue:'CUENTA.nombre_cuenta',
		save_as:'id_cuenta'		
	};	
	
	vectorAtributos[3]= {
		validacion: {
			name:'id_auxiliar',
			fieldLabel:'Auxiliar',
			allowBlank:true,			
			//emptyText:'Auxiliar...',
			name:'id_auxiliar',     //indica la columna del store principal ds del que proviane el id
			desc:'nombre_auxiliar', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_auxiliar,
			valueField:'id_auxiliar',
			displayField:'nombre_auxiliar',
			queryParam:'filterValue_0',
			filterCol:'AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar',
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:250,
			grow:true,
			width:'100%',
			resizable:true,
			queryParam:'filterValue_0',
			minChars:3, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:renderAuxiliar,
			grid_visible:true,
			grid_editable:false,
			disabled:true,
			width_grid:250 // ancho de columna en el grid
		},
		tipo:'ComboBox',
		filtro_0:true,	
		filterColValue:'AUXILI.nombre_auxiliar',
		defecto: '',
		save_as:'id_auxiliar'		
	};
	
	vectorAtributos[4]= {
		validacion: {
			name:'estado_reg',
			//emptyText:'Estado...',
			fieldLabel:'Estado',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',			
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','Activo'],['inactivo','Inactivo']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			renderer:render_estado_reg,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo:'ComboBox',
		filtro_0:true,	
		filterColValue:'',
		save_as:'estado_reg'
	};
	
	vectorAtributos[5]= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha Registro',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			//grid_indice:8,
		    renderer: formatDate,
			width_grid:100
		},
		form:false,
		tipo:'DateField',
		dateFormat:'m-d-Y'
		//id_grupo:0
	};
	
	vectorAtributos[6]={
		validacion:{
			labelSeparator:'',
			name:'id_empleado',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		defecto:maestro.id_empleado,
		save_as:'id_empleado'
	};
	
	
	vectorAtributos[7]= {
			validacion:{
				name:'id_cuenta_cobrar',
				//desc:'desc_cuenta',
				desc: 'nombre_cuenta',
				allowBlank:true,
				fieldLabel:'Cuenta x Cobrar',
				tipo:'ingreso',//determina el action a llamar
				gestion:1,
				maxLength:100,
				minLength:0,
				selectOnFocus:true,
				vtype:"texto",
				grid_visible:true,
				grid_editable:false,
				renderer:renderCuentaCobrar,
				width_grid:250,
				width:'90%',
				pageSize:10,
				disabled:true,
				onSelect:function(record){ 				
					//Ext.form.LovItemsAlm.superclass.setValue.call(this,v.desc)
					componentes[7].store.baseParams={m_id_partida:'',sw_reg_comp:'si'};
					componentes[7].setValue({id:record.data.id_cuenta,desc:record.data.desc_cuenta});				
					componentes[7].collapse();				
					
				},	
				direccion:direccion
			},
			tipo:'LovCuenta',
			filtro_0:true,
			filterColValue:'CUENTA.nombre_cuenta',
			save_as:'id_cuenta_cobrar'		
		};	
	
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};
	
	
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//Inicia Layout
	/*var config={
		titulo_maestro:'Empleado Cuenta',
		grid_maestro:'grid-'+idContenedor
	};*/
	var config={titulo_maestro:'Empleado (Maestro)',titulo_detalle:'Cuenta y Auxiliares (Detalle)',grid_maestro:'grid-'+idContenedor};
	
	
	layout_empleado_cta=new DocsLayoutMaestro(idContenedor);
	layout_empleado_cta.init(config);
	// INICIAMOS HERENCIA //
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_empleado_cta,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_onResize=this.onResize;
	var EstehtmlMaestro=this.htmlMaestro;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var getDialog=this.getDialog;
	var getForm=this.getFormulario;
	
	
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		//eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/empleado_cta/ActionEliminarEmpleadoCta.php',parametros:'&id_empleado='+maestro.id_empleado},
		Save:{url:direccion+'../../../control/empleado_cta/ActionGuardarEmpleadoCta.php',parametros:'&id_empleado='+maestro.id_empleado},
		ConfirmSave:{url:direccion+'../../../control/empleado_cta/ActionGuardarEmpleadoCta.php',parametros:'&id_empleado='+maestro.id_empleado},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:300,	//alto
		width:400,
		//minWidth:400,
		//minHeight:300,	
		closable:true,
		titulo:'Funcionario Cuenta'}
	};	
	
	this.reload=function(m)
	{
			maestro=m;			
	
			ds.lastOptions={
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					id_empleado:maestro.id_empleado					
				}
			};			
				
			this.btnActualizar();
			vectorAtributos[6].defecto=maestro.id_empleado;
			
			paramFunciones.btnEliminar.parametros='&id_empleado='+maestro.id_empleado;
			paramFunciones.Save.parametros='&id_empleado='+maestro.id_empleado;
			paramFunciones.ConfirmSave.parametros='&id_empleado='+maestro.id_empleado;			
			
			this.InitFunciones(paramFunciones)
	};
		
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//		
	//Para manejo de eventos
	function iniciarEventosFormularios()
	{
		for(var i=0; i<vectorAtributos.length; i++){
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}
		componentes[1].on('select',evento_gestion);	
		dialog=getDialog();
		form=getForm();
	}
	
	function evento_gestion( combo, record, index )
	{	
		//combo cuenta						
		componentes[2].store.baseParams={m_id_gestion:record.data.id_gestion};
		componentes[2].modificado=true;
		componentes[2].setValue('');			
		componentes[2].setDisabled(false);	

		//combo auxiliar
		componentes[3].modificado=true;
		componentes[3].setValue('');			
		componentes[3].setDisabled(true);	
		
		componentes[7].store.baseParams={m_id_gestion:record.data.id_gestion};
		componentes[7].modificado=true;
		componentes[7].setValue('');			
		componentes[7].setDisabled(false);	
 	} 	
	
	/*this.btnNew=function()
	{	
		ClaseMadre_btnNew()
	};*/
	
	this.btnNew=function()
	{
		ClaseMadre_btnNew()
		ds_gestion.load({callback:otraFuncion});
	}
	
	function otraFuncion()
	{
		var sm=getSelectionModel();			
		dialog.buttons[1].show();
		sm.clearSelections();//limpiar selecion
		form.reset();
		var cont=ds_gestion.getTotalCount();
			
		for(var i=0;i<cont;i++){
				
			if(ds_gestion.getAt(i).get('estado_ges_gral')=='abierto'){
					
				componentes[1].setValue(ds_gestion.getAt(i).get('id_gestion'));
			}
		}
			/*var filas=ds.getModifiedRecords();//recupera la catidad de modificaciones hechas
			var cont=filas.length;
			if(cont>0){//verifica si existen modificaciones hechas en los registros del grid
				if(confirm("Tiene registros pendientes sin guardar que se perderan, desea continuar?")){
					mostrarFormulario()
				}
			}
			else{
				mostrarFormulario()
			}*/
	}	
	
	this.btnEdit=function()
	{		
		ClaseMadre_btnEdit()
	};
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_empleado_cta.getLayout()
	};
	
	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo)
	{
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++)
		{
			if(elementos[i].idContenedor==idContenedorHijo)
			{
				return elementos[i]
			}
		}
	};
	
	this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};
	
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	ds_gestion.baseParams={estado:'abierto'};
	//para agregar botones
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_empleado_cta.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}