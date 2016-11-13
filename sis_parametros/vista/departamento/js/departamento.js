/**
* Nombre:		  	    pagina_departamento.js
* Propï¿½sito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creaciï¿½n:		2009-01-23 11:04:01
*/
function pagina_departamento(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	// MODIFICACION 23/03/2011 aayaviri
	var componentes= new Array();
	var cmb_proceso,txt_susbsistema;
	//---------------
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/depto/ActionListarDepartamento.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'id_depto',totalRecords:'TotalCount'
		},[
		'id_depto',
		'codigo_depto',
		'nombre_depto',
		'estado',
		'id_subsistema',
		'nombre_corto',
		'nombre_largo',
		//MODIFICACION 23/03/2010 aayaviri
		'id_lugar',
		'desc_lugar',
		'id_tipo_proceso','desc_tipo_proceso',
		'codificacion' //mflores 03-10-11
		//---------
		]),remoteSort:true
	});


	//DATA STORE COMBOS
	var ds_subsis = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/subsistema/ActionListarSubsistema.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_subsistema',totalRecords: 'TotalCount'},['id_subsistema','nombre_corto','nombre_largo'])
	});

	//MODIFICACION 23/03/2011
	var ds_lugar= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/lugar/ActionListarLugar.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_lugar',totalRecords: 'TotalCount'},['id_lugar','nombre','ubicacion','codigo'])
		});

		var ds_tipo_proceso = new Ext.data.Store({
			// asigna url de donde se cargaran los datos
			proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_flujo/control/tipo_proceso/ActionListarTipoProceso.php'}),
			// aqui se define la estructura del XML
			reader: new Ext.data.XmlReader({
				record: 'ROWS',
				id: 'id_tipo_proceso',
				totalRecords: 'TotalCount'
			}, [
			// define el mapeo de XML a las etiquetas (campos)
				'id_tipo_proceso',
				'codigo',
				'id_usuario_reg',
				'nombre_proceso',
				{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
				'estado',
				'id_nodo_inicio',
				'id_formulario_inicio'
				]),remoteSort:true});
		
		function render_lugar(value, p, record){return String.format('{0}', record.data['desc_lugar']);}
		var tpl_lugar=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{nombre}</FONT><br>','<b>{codigo}</b>','</div>');
		
		function render_id_tipo_proceso(value, p, record){return String.format('{0}', record.data['desc_tipo_proceso']);}
		var tpl_id_tipo_proceso=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{codigo}</FONT><br>','<FONT COLOR="#000000">{nombre_proceso}</FONT>','</div>');

	//------------------
	function render_subsis(value, p, record){return String.format('{0}', record.data['nombre_largo']);}
	var tpl_subsis=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{nombre_corto}</FONT><br>','<b>{nombre_largo}</b>','</div>');

	//FUNCIONES RENDER


	/////////////////////////
	// Definiciï¿½n de datos //
	/////////////////////////

	// hidden id_depto
	//en la posiciï¿½n 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_depto',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false

	};
	// txt codigo_depto
	Atributos[1]={
		validacion:{
			name:'codigo_depto',
			fieldLabel:'Codigo',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:80,
			width:'100%',
			disabled:false
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'DEPTO.codigo_depto'

	};
	// txt nombre_depto
	Atributos[2]={
		validacion:{
			name:'nombre_depto',
			fieldLabel:'Nombre',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:300,
			width:'100%',
			disabled:false
		},
		tipo: 'TextArea',
		form: true,
		filtro_0:true,
		filterColValue:'DEPTO.nombre_depto'

	};
	// txt estado
	Atributos[3]={
		validacion:{
			name:'estado',
			fieldLabel:'Estado',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['activo','Activo'],['inactivo','Inactivo']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			grid_visible:true,
			grid_editable:false,
			forceSelection:true,
			width:100
		},
		tipo:'ComboBox',
		defecto:'activo',
		form: true,
		filtro_0:true,
		filterColValue:'DEPTO.estado'

	};

	Atributos[4]={
		validacion:{
			name:'id_subsistema',
			fieldLabel:'Subsistema',
			allowBlank:false,
			emptyText:'Subsistema...',
			desc: 'nombre_largo', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_subsis,
			valueField: 'id_subsistema',
			displayField: 'nombre_largo',
			queryParam: 'filterValue_0',
			filterCol:'SUBSIS.nombre_corto#SUBSIS.nombre_largo',
			tpl:tpl_subsis,
			mode:'remote',
			queryDelay:250,
			pageSize:30,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_subsis,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:200
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'SUBSIS.nombre_corto#SUBSIS.nombre_largo'
	};

	//MODIFICACION 23/03/2011
	//id_tipo_proceso
	Atributos[5]= {
		validacion:{
			fieldLabel:'Nombre de Proceso',
			name:'id_tipo_proceso',
			allowBlank:true,
			desc:'desc_tipo_proceso',//es el nombre del departamento
			store:ds_tipo_proceso,//agregado
			valueField:'id_tipo_proceso',
			displayField:'nombre_proceso',
			queryParam:'filterValue_0',
			filterCol:'TIPPRO.nombre_proceso',
			typeAhead:false,
			forceSelection:false,
			tpl:tpl_id_tipo_proceso,
			mode:'remote',
			renderer:render_id_tipo_proceso,
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			minChars:1,
			triggerAction:'all',
			editable:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:180,
			width:300,
			disabled:false
		},
		tipo: 'ComboBox',
		form: true,
		filtro_0:true,			
		filterColValue:'TIPPRO.nombre_proceso',
		save_as:'id_tipo_proceso'
	};
	
	
	Atributos[6]={
		validacion:{
			name:'id_lugar',
			fieldLabel:'Lugar',
			allowBlank:false,
			emptyText:'Lugar...',
			desc: 'desc_lugar', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_lugar,
			valueField: 'id_lugar',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'LUGARR.nombre',
			tpl:tpl_subsis,
			mode:'remote',
			queryDelay:250,
			pageSize:30,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			tpl:tpl_lugar,
			renderer:render_lugar,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:200
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'LUGAR.nombre'
	};
	
	//mflores 03-10-11
	Atributos[7]={
		validacion:{
			name:'codificacion',
			fieldLabel:'Codificacion AF',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['0','normal'],['1','abierto']]}),
			valueField:'valor',
			displayField:'valor',
			lazyRender:true,
			grid_visible:true,			
			grid_editable:false,
			forceSelection:true,
			width:100
		},
		tipo:'ComboBox',
		defecto:'normal',
		form: true,
		filtro_0:true,
		filterColValue:'DEPTO.codificacion'
	};
	//---------------
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

//	function renderEstado(value){
//		if(value==1){value='Activo' }
//		if(value==2){value='Inactivo' }
//
//		return value
//	}
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Departamento',grid_maestro:'grid-'+idContenedor};
	var layout_departamento=new DocsLayoutMaestro(idContenedor);
	layout_departamento.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////


	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_departamento,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	//MODIFICADO 23/03/2011
	var CM_btnNew=this.btnNew;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var ClaseMadre_getComponente=this.getComponente;
	var CM_conexionFailure=this.conexionFailure;
	var CM_btnEdit=this.btnEdit;
	//---------------------
	///////////////////////////////////
	// DEFINICIï¿½N DE LA BARRA DE MENï¿½//
	///////////////////////////////////

	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIï¿½N DE FUNCIONES ------------------------- //
	//  aquï¿½ se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/depto/ActionEliminarDepartamento.php'},
		Save:{url:direccion+'../../../control/depto/ActionGuardarDepartamento.php'},
		ConfirmSave:{url:direccion+'../../../control/depto/ActionGuardarDepartamento.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Departamento'}
	};
	//-------------- DEFINICIï¿½N DE FUNCIONES PROPIAS --------------//
	function btn_departamentoEP(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='id_depto='+SelectionsRecord.data.id_depto;
			data=data+'&codigo_depto='+SelectionsRecord.data.codigo_depto;
			data=data+'&nombre_depto='+SelectionsRecord.data.nombre_depto;

			var ParamVentana={Ventana:{width:'60%',height:'70%'}}
			layout_departamento.loadWindows(direccion+'../../../../sis_parametros/vista/departamentoEP/departamentoEP.php?'+data,'Departamento EP',ParamVentana);

		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	function btn_departamentoUsuario(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='id_depto='+SelectionsRecord.data.id_depto;
			data=data+'&codigo_depto='+SelectionsRecord.data.codigo_depto;
			data=data+'&nombre_depto='+SelectionsRecord.data.nombre_depto;

			var ParamVentana={Ventana:{width:'60%',height:'70%'}}
			layout_departamento.loadWindows(direccion+'../../../../sis_parametros/vista/departamentoUsuario/departamentoUsuario.php?'+data,'Usuario porDepartamento',ParamVentana);
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}

	function btn_departamentoConta(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='id_depto='+SelectionsRecord.data.id_depto;
			data=data+'&codigo_depto='+SelectionsRecord.data.codigo_depto;
			data=data+'&nombre_depto='+SelectionsRecord.data.nombre_depto;

			var ParamVentana={Ventana:{width:'90%',height:'50%'}}
			layout_departamento.loadWindows(direccion+'../../../../sis_parametros/vista/departamento_conta/departamento_conta.php?'+data,'Departamento Conta',ParamVentana);
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	function btn_deptoFirAut(){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='id_depto='+SelectionsRecord.data.id_depto;
			data=data+'&codigo_depto='+SelectionsRecord.data.codigo_depto;
			data=data+'&nombre_depto='+SelectionsRecord.data.nombre_depto;

			var ParamVentana={Ventana:{width:'60%',height:'70%'}}
			layout_departamento.loadWindows(direccion+'../../../../sis_parametros/vista/depto_firma_autoriz/depto_firma_autoriz.php?'+data,'Firmas Auotorizadas',ParamVentana);
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	function btn_actualizacion(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='id_depto='+SelectionsRecord.data.id_depto;
			data=data+'&codigo_depto='+SelectionsRecord.data.codigo_depto;
			data=data+'&nombre_depto='+SelectionsRecord.data.nombre_depto;

			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_departamento.loadWindows(direccion+'../../../../sis_parametros/vista/actualizacion/actualizacion.php?'+data,'Actualizacion',ParamVentana);
		}else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	//MODIFICACION 23/03/2011 aayaviri
	function btn_departamentoUo(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='id_depto='+SelectionsRecord.data.id_depto;
			data=data+'&codigo_depto='+SelectionsRecord.data.codigo_depto;
			data=data+'&nombre_depto='+SelectionsRecord.data.nombre_depto;
			data=data+'&nombre_largo='+SelectionsRecord.data.nombre_largo;

			var ParamVentana={Ventana:{width:'50%',height:'50%'}}
			layout_departamento.loadWindows(direccion+'../../../../sis_parametros/vista/departamentoUo/departamentoUo.php?'+data,'Departamento UO',ParamVentana);
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	function btn_departamentoDiv(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='id_depto='+SelectionsRecord.data.id_depto;
			data=data+'&codigo_depto='+SelectionsRecord.data.codigo_depto;
			data=data+'&nombre_depto='+SelectionsRecord.data.nombre_depto;
			data=data+'&nombre_largo='+SelectionsRecord.data.nombre_largo;

			var ParamVentana={Ventana:{width:'50%',height:'50%'}}
			layout_departamento.loadWindows(direccion+'../../../../sis_parametros/vista/departamentoDiv/departamentoDiv.php?'+data,'División',ParamVentana);
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	this.btnNew=function()
	{		
		CM_ocultarComponente(getComponente('id_tipo_proceso'));
		CM_btnNew();
	}
	
	this.btnEdit=function()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0)
		{
			var SelectionsRecord=sm.getSelected();
			
			CM_ocultarComponente(getComponente('id_tipo_proceso'));
			
				if(SelectionsRecord.data.nombre_corto=='FLUJO'){ 
					CM_mostrarComponente(getComponente('id_tipo_proceso'));
					getComponente('id_tipo_proceso').allowBlank=false;				
				}
				else{
					CM_ocultarComponente(getComponente('id_tipo_proceso'));
					getComponente('id_tipo_proceso').reset();
					getComponente('id_tipo_proceso').allowBlank=true;
				}
				CM_btnEdit()
		}else{
			alert('Antes debe seleccionar un item');
		}
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){//para iniciar eventos en el formulario
	
		 txt_susbsistema=ClaseMadre_getComponente('id_subsistema');
		 cmb_proceso=ClaseMadre_getComponente('id_tipo_proceso');
		 
		function onEstadoSelect(com,rec,ind){
			var id=txt_susbsistema.getValue();
			var c=cmb_proceso.getValue();
				
			if(rec.data.nombre_corto=='FLUJO'){
				CM_mostrarComponente(cmb_proceso);
				getComponente('id_tipo_proceso').allowBLank=false;
			}
			else{
				getComponente('id_tipo_proceso').allowBLank=true;
				getComponente('id_tipo_proceso').reset();
				CM_ocultarComponente(cmb_proceso);
			}
		 } 	 
		 txt_susbsistema.on('select',onEstadoSelect);  
	}
	//--------------------------
	
	//para que los hijos puedan ajustarse al tamaï¿½o
	this.getLayout=function(){return layout_departamento.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARï¿½METROS PARA LAS FUNCIONES DE LA CLASE MADRE);
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
	
	//MODIFICADO 23/03/2011
	this.AdicionarBoton('../../../lib/imagenes/a_xp.png','Relacion de Unidad Organizacional',btn_departamentoUo,true,'departamentoUO','UO');
	this.AdicionarBoton('../../../lib/imagenes/a_xp.png','División por Departamento',btn_departamentoDiv,true,'departamentoDiv','División');
	this.AdicionarBoton('../../../lib/imagenes/a_xp.png','Relacion de EPs',btn_departamentoEP,true,'departamentoEP','EP');

	this.AdicionarBoton('../../../lib/imagenes/a_xp.png','Relacion de Usuarios',btn_departamentoUsuario,true,'departamentoUsuario','Usuario');
	this.AdicionarBoton('../../../lib/imagenes/a_xp.png','Firmas Autorizadas',btn_deptoFirAut,true,'deptoFirAut','Firma');
	this.AdicionarBoton('../../../lib/imagenes/a_xp.png','Departamento Contable',btn_departamentoConta,true,'departamentoConta','Contable');
	this.AdicionarBoton('../../../lib/imagenes/a_table_gear.png','Proceso de Actualización',btn_actualizacion,true,'actualizacion','');

	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_departamento.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}