/**
* Nombre:		  	    pagina_metaproceso_det.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2007-10-26 16:42:31
*/
function pagina_metaproceso_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)

{



	var Atributos=[];
	var ds;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
	var cmpNivel,cmpDhijo,cmpCon_ep,cmpOlogico,cmpPrefijo,cmpCP,cmpNT,cmpCB;

	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Subsistema',maestro.id_subsistema],['Nombre Corto',maestro.nombre_corto],['Descripción',maestro.descripcion]]}),cm:cmMaestro});
	gridMaestro.render();
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////

	// hidden id_metaproceso
	//en la posición 0 siempre esta la llave primaria

	Atributos[0] = {
		validacion:{
			labelSeparator:'',
			name: 'id_metaproceso',
			inputType:'hidden'
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_metaproceso'
	};

	// txt id_subsistema
	Atributos[1]={
		validacion:{
			name:'id_subsistema',
			labelSeparator:'',
			inputType:'hidden',
			disabled:true
		},
		tipo:'Field',
		defecto:maestro.id_subsistema,
		save_as:'txt_id_subsistema'
	};

	// txt fk_id_metaproceso
	Atributos[2] = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name:'fk_id_metaproceso',
			inputType:'hidden'
		},
		tipo: 'Field',
		defecto:maestro.id_subsistema,
		save_as:'hidden_id_metaproceso'
	};


	// txt nivel
	Atributos[3]= {
		validacion:{
			name:'nivel',
			fieldLabel:'nivel',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision :2,//para numeros float
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			width:'70%',
			disabled:true
		},
		tipo: 'NumberField',

		filterColValue:'METPRO.nivel',
		save_as:'txt_nivel',
		id_grupo:1
	};

	// txt nombre
	Atributos[4]= {
		validacion:{
			name:'nombre',
			fieldLabel:'Nombre',
			allowBlank:false,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:'100%'
		},
		tipo: 'TextArea',

		filterColValue:'METPRO.nombre',
		save_as:'txt_nombre',
		id_grupo:0
	};

	// txt codigo_procedimiento
	Atributos[5]= {
		validacion:{
			name:'codigo_procedimiento',
			fieldLabel:'Codigo Proc',
			allowBlank:false,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',

			width:'70%'
		},
		tipo: 'TextField',
		filterColValue:'METPRO.codigo_procedimiento',
		save_as:'txt_codigo_procedimiento',
		id_grupo:0
	};

	// txt nombre_achivo
	Atributos[6]= {
		validacion:{
			name:'nombre_archivo',
			fieldLabel:'Archivo',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:'100%'
		},
		tipo: 'TextArea',

		filterColValue:'METPRO.nombre_archivo',
		save_as:'txt_nombre_archivo',
		id_grupo:2
	};

	// txt ruta_archivo
	Atributos[7]= {
		validacion:{
			name:'ruta_archivo',
			fieldLabel:'Ruta Archivo',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:'100%'
		},
		tipo: 'TextArea',

		filterColValue:'METPRO.ruta_archivo',
		save_as:'txt_ruta_archivo',
		id_grupo:2
	};



	// txt descripcion
	Atributos[8]= {
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:false,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',

			width:'100%'
		},
		tipo: 'TextArea',

		filterColValue:'METPRO.descripcion',
		save_as:'txt_descripcion',
		id_grupo:0
	};

	// txt visible
	Atributos[9]= {
		validacion: {
			name:'visible',
			fieldLabel:'Visible',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data : [['si','si'],['no','no']]
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true
		},
		tipo:'ComboBox',
		filterColValue:'METPRO.visible',
		defecto:'no',
		save_as:'txt_visible',
		id_grupo:1
	};

	// txt habilitar_log
	Atributos[10]= {
		validacion: {
			name:'habilitar_log',
			fieldLabel:'Habilitar Log',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data : [['si','si'],['no','no']]
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true

		},
		tipo:'ComboBox',
		filterColValue:'METPRO.habilitar_log',
		defecto:'si',
		save_as:'txt_habilitar_log',
		id_grupo:0
	};

	// txt orden_logico
	Atributos[11]= {
		validacion:{
			name:'orden_logico',
			fieldLabel:'Orden Lógico',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision :2,//para numeros float
			allowNegative: false,
			minValue:0,
			vtype:'texto'
		},
		tipo: 'NumberField',
		defecto:'0',
		filterColValue:'METPRO.orden_logico',
		save_as:'txt_orden_logico',
		id_grupo:1
	};

	// txt icono
	Atributos[12]= {
		validacion:{
			name:'icono',
			fieldLabel:'Icono',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',

			width:'100%'
		},
		tipo: 'TextArea',
		filterColValue:'METPRO.icono',
		save_as:'txt_icono',
		id_grupo:1
	};

	// txt nombre_tabla
	Atributos[13]= {
		validacion:{
			name:'nombre_tabla',
			fieldLabel:'Nombre de la Tabla',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',


			width:'80%'
		},
		tipo: 'TextField',

		filterColValue:'METPRO.nombre_tabla',
		save_as:'txt_nombre_tabla',
		id_grupo:0
	};

	// txt prefijo
	Atributos[14]= {
		validacion:{
			name:'prefijo',
			fieldLabel:'Prefijo',
			allowBlank:false,
			maxLength:7,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:'80%'
		},
		tipo: 'TextField',
		filterColValue:'METPRO.prefijo',
		save_as:'txt_prefijo',
		id_grupo:0
	};

	// txt codigo_base
	Atributos[15]= {
		validacion:{
			name:'codigo_base',
			fieldLabel:'Codigo Base',
			allowBlank:true,
			maxLength:10,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:'80%'
		},
		tipo: 'TextField',
		filterColValue:'METPRO.codigo_base',
		save_as:'txt_codigo_base',
		id_grupo:0
	};

	// txt tipo_vista
	Atributos[16]={
		validacion: {
			name:'tipo_vista',
			fieldLabel:'Tipo Vista',
			allowBlank:true,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data : [['padre','padre'],['hijo','hijo'],['padre_hijo','padre_hijo'],['reporte','reporte'],['arbol','arbol'],['ninguno','ninguno']]
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true

		},
		tipo:'ComboBox',
		filterColValue:'METPRO.tipo_vista',
		defecto:'ninguno',
		save_as:'txt_tipo_vista',
		id_grupo:1
	};

	// txt con_ep
	Atributos[17]={
		validacion: {
			name:'con_ep',
			fieldLabel:'Con EP',
			allowBlank:true,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data : [['si','si'],['no','no']]
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true

		},
		tipo:'ComboBox',

		filterColValue:'METPRO.con_ep',
		defecto:'no',
		save_as:'txt_con_ep',
		id_grupo:1
	};

	// txt con_interfaz
	Atributos[18]= {
		validacion: {
			name:'con_interfaz',
			fieldLabel:'Con Interfaz',
			allowBlank:true,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data : [['si','si'],['no','no']]
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true

		},
		tipo:'ComboBox',

		filterColValue:'METPRO.con_interfaz',
		defecto:'no',
		save_as:'txt_con_interfaz',
		id_grupo:1
	};

	// txt num_datos_hijo
	Atributos[19]={
		validacion:{
			name:'num_datos_hijo',
			fieldLabel:'Numero datos de Hijo',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision :2,//para numeros float
			allowNegative: false,
			minValue:0,
			vtype:'texto',

			width:'80%'
		},
		tipo: 'NumberField',

		filterColValue:'METPRO.num_datos_hijo',
		save_as:'txt_num_datos_hijo',
		id_grupo:1
	};

	
	/////////////////para procedimiento DB
	
	// txt nombre
	Atributos[20]={
		validacion:{
			name:'nombre_funcion',
			fieldLabel:'Nombre Funcion',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:200,
			width:'100%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PROCDB.nombre_funcion',
		save_as:'nombre_funcion'
	};



	//datos extra a los Atributos declarados se manejaran en las operaciones basicas que maneja en las operacion
	var DatosNodo=new Array('id','id_p','tipo');
	//datos por defecto para los nuevos nodos que se creen en la vista
	var DatosDefecto={
		raiz:{
			text:4,//indice del atributo
			icon:"../../../lib/imagenes/etucr.png",
			allowDrag:false,
			allowDelete:false,
			allowEdit:true

		},
		rama:{
			text:4,//indice del atributo
			allowDrag:false,
			allowDrop:true,
			allowDelte:true,
			allowEdit:true
		},
		item:{
			text:4,//indice del atributo
			icon:"../../../lib/imagenes/page_white_gear.png",
			allowDrag:false,
			allowDelete:true,
			allowEdit:false
		}


	};

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT ARBOL     -----------//
	//////////////////////////////////////////////////////////////
	//Inicia Layout


	var config={
		titulo:'Metaprocesos'
	};
	var layout_meta=new DocsLayoutArb(idContenedor);
	layout_meta.init(config);
	
	
	var _xpanel=Ext.DomHelper.append('layout-'+idContenedor,{tag:'div',id:'ceast-'+idContenedor});
	var tb = new Ext.Toolbar('ceast-'+idContenedor);
	
	var filtro_tuc=new Ext.form.TextField({
	id:'tuc_filtro_'+idContenedor,
	width:80
	});
	
	
	
	tb.add('Filtrar por: ','',filtro_tuc,'->',{

		icon:'../../../lib/imagenes/actualizar.jpg',
		cls: 'x-btn-icon',
		//cls:'remove',
		tooltip:'Actualizar Biblioteca',
		handler:btn_actualizar_pdb
	}
	);



	layout_meta.getLayout().addRegion("east",{
		//toolbar: tb,
		split:true,
		initialSize:250,
		autoScroll:true,
		minSize:175,
		maxSize:400,
		titlebar:false,
		collapsible:false,
		animate:false,
		useShim:true
	});


	layout_meta.getLayout().add('east',new Ext.ContentPanel(_xpanel,{closable:false,toolbar:tb}));




	/******************************
	*  ARBOL DE PRocedimientos DB *
	*******************************/
	// this is the source code tree

	var iloader=new Ext.tree.TreeLoader({dataUrl:direccion+'../../../../sis_seguridad/control/procedimiento_db/ActionListarProcedimiento_dbArb.php'});

	//para mandar parametros extras
	iloader.on("beforeload", function(treeLoader, node){
		
		if(filtro_tuc.getValue()&&filtro_tuc.getValue()!=''){
			
			treeLoader.baseParams.filtro=filtro_tuc.getValue();
			treeLoader.baseParams.filtrar=true;
			
			
		}
		else{
			treeLoader.baseParams.filtrar=false;
		
		}
		
		
		if(node.attributes.tipo){
			treeLoader.baseParams.tipo=node.attributes.tipo;
			
		}
	}, this);


	var itree = new Ext.tree.TreePanel('ceast-'+idContenedor, {
		animate:false,
		rootVisible:false,
		loader:iloader,
		enableDrag:true,
		containerScroll: true
	});
	var ism = itree.getSelectionModel();

	itree.on('contextmenu', prepareCtxSec);
	// new Ext.tree.TreeSorter(itree, {folderSort:true});

	var iroot = new Ext.tree.AsyncTreeNode({
		text: 'Items',
		draggable:false,
		id:'id'
	});
	itree.setRootNode(iroot);
	itree.render();

	//itree.expand(false, false);
	//itree.expand(false, false);
	var ctxMenu = new Ext.menu.Menu({
		id:'copyCtx',
		items: [{
			id:'expand',
			handler:expandAll,
			cls:'expand-all',
			text:'Expandir todos'
		},{
			id:'collapse',
			handler:collapseAll,
			cls:'collapse-all',
			text:'Colapsar todos'
		},{
			id:'reload',
			handler:actualizarNodo,
			icon:'../../../lib/imagenes/act.png',
			text:'Actualizar nodo'

		}
		]
	});

	function prepareCtxSec(node, e){node.select();ctxMenu.showAt(e.getXY())}
	function actualizarNodo(){
		ctxMenu.hide();
		setTimeout(function(){
			var n = itree.getSelectionModel().getSelectedNode();
			if(!n.leaf){n.reload()}
		}, 10);
	}

	function collapseAll(){

		ctxMenu.hide();
		setTimeout(function(){
			iroot.eachChild(function(n){
				n.collapse(false, false);

			});
		}, 10);
	}

	function expandAll(){
		var n = ism.getSelectedNode();
		ctxMenu.hide();
		setTimeout(function(){
			//iroot.eachChild(function(n){
			//n.expand(false, false);
			n.expand(true);
			//});
		}, 10);
	}


	function save(){
	
		var n = getSm().getSelectedNode();
		var count=0;
		
		//btnNew();
		var pre='';
		if(n){
			var  naux=n;
			while(naux.parentNode){
				count++;
				pre=naux.attributes.prefijo
				naux=naux.parentNode	
			}
		cmpNivel.setValue(count+1);
		cmpDhijo.setValue(2);
		cmpCon_ep.setValue('no');
		cmpOlogico.setValue(0);
		cmpPrefijo.setValue(pre)
		cmpCP.setValue(n.attributes.codigo_procedimiento)
		cmpNT.setValue(n.attributes.nombre_tabla)
		cmpCB.setValue(n.attributes.codigo_procedimiento)
		}
		
		
	};


	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	this.pagina = PaginaArb;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,layout_meta,idContenedor,DatosNodo,DatosDefecto);


	//----------   herencia de la clase madre -------//
	var getTreePanel = this.getTreePanel;
	var getTreeRaiz = this.getTreeRaiz;
	var getLoader= this.getLoader;
	var conexionFailure=this.conexionFailure;
	var btnEliminar=this.btnEliminar;
	var btnEdit=this.btnEdit;
	var btnNew=this.btnNew;
	var btnNewRaiz=this.btnNewRaiz;
	var getComponente=this.getComponente;
	var getSm=this.getSm;
	var ocultarComponente=this.ocultarComponente;
	var ocultarTodosComponente=this.ocultarTodosComponente;
	var ocultarGrupo=this.ocultarGrupo;
	var mostrarGrupo=this.mostrarGrupo;
	var mostrarComponente=this.mostrarComponente;
	var btnActualizar=this.btnActualizar;
	var setValuesBasicos=this.setValuesBasicos;
	var getDialog=this.getDialog;
	var getFormulario=this.getFormulario;
	var prepareCtx=this.prepareCtx;
	var getCtxMenu=this.getCtxMenu;
	var onBeforeMove=this.onBeforeMove;
	var guardarSuccess=this.guardarSuccess;


	/////////////////////////////
	// parametros las funciones//
	////////////////////////////


	var paramFunciones = {
		Basicas:{
			url:direccion+'../../../control/metaproceso/ActionGuardarMetaArb.php'
			//add_success:guardarSuccessSc,
			//upd_success:guardarSuccessSc,
			//edit:sEdit
		},
		Formulario:{
			titulo:'Metaproceso',
			//html_apply:"dlgInfo-"+idContenedor,
			width:'70%',
			height:'93%',
			minWidth:200,
			minHeight:150,
			columnas:[300,300],
			closable:true,
			grupos:[
			{
				tituloGrupo:'Datos Lógicos',
				columna:0,
				id_grupo:0
			},
			{
				tituloGrupo:'Datos Vista',
				columna:1,
				id_grupo:1
			},
			{
				tituloGrupo:'Datos Archivo',
				columna:1,
				id_grupo:2
			}
			]
		},
		Listar:{
			url:direccion+'../../../control/metaproceso/ActionListarMetaprocesoArb.php',
			raiz:'agrupador',
			baseParams:{id_subsistema:maestro.id_subsistema,codigo_raiz:maestro.nombre_corto},
			clearOnLoad:true,
			enableDD:true,		
			lines:true
		}
	};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		
		maestro.id_subsistema=datos.m_id_subsistema;
	    maestro.nombre_corto=datos.m_nombre_corto;
	    maestro.descripcion=datos.m_descripcion;
	    
	    
	    gridMaestro.getDataSource().removeAll()
		gridMaestro.getDataSource().loadData([['Subsistema',maestro.id_subsistema],['Nombre Corto',maestro.nombre_corto],['Descripción',maestro.descripcion]]);
		
		paramFunciones.Listar.baseParams={id_subsistema:maestro.id_subsistema,codigo_raiz:maestro.nombre_corto};
		this.InitFunciones(paramFunciones);
		this.getLoader().baseParams.id_subsistema=maestro.id_subsistema;
		this.getLoader().baseParams.codigo_raiz=maestro.nombre_corto;
		this.btnActualizar()
		
	};
	


	function iniciarEventos(){
		filtro_tuc.el.addKeyListener(13, btn_actualizar_pdb)//enter para iniciar el filtro
		cmpNombre=getComponente('nombre');
		cmpNivel=getComponente('nivel');
		cmpDhijo=getComponente('num_datos_hijo');
		cmpCon_ep=getComponente('con_ep');
		cmpOlogico=getComponente('orden_logico')
		cmpPrefijo=getComponente('prefijo');
		cmpCP=getComponente('codigo_procedimiento');
		cmpNT=getComponente('nombre_tabla');
		cmpCB=getComponente('codigo_base');
		cmpSubsistema=getComponente('id_subsistema');
		var dialog= getDialog();
		
		var CtxMenuP=getCtxMenu();
		  CtxMenuP.add({
			id:'save',
			handler:save,
			icon:'../../../lib/imagenes/nuevo.png',
			text:'Nueva Vista'

		},{
			id:'save_db',
			handler:save_db,
			icon:'../../../lib/imagenes/nuevo_lugar.gif',
			text:'Nuevo Procedimiento'

		}
		);
		
		getTreePanel().on('beforenodedrop', ramaDrop);
		//getLoader().on('load', ramaDrag)
//

	}

//	function ramaDrag(e){
//	var n = e.dropNode;
//	alert(n);
//}

	
	function save_db(){
		getDialog().setTitle("Procedimiento DB");
		ocultarGrupo('Datos Vista');
		ocultarGrupo('Datos Archivo');
		ocultarComponente(cmpNombre);
		ocultarComponente(cmpNT);
		ocultarComponente(cmpCB);
		ocultarComponente(cmpPrefijo);
		btnNew();
	}
	
	this.btnNew=function(){
			
		var n = getSm().getSelectedNode();
		
		var count=0;
		
		btnNew();
		var pre='';
		if(n){
			var  naux=n;
			while(naux.parentNode){
				count++;
				pre=naux.attributes.prefijo
				naux=naux.parentNode	
			}
			
			
		cmpNivel.setValue(count+1);
		cmpDhijo.setValue(2);
		cmpCon_ep.setValue('no');
		cmpOlogico.setValue(0);
		cmpSubsistema.setValue(n.attributes.id_subsistema);
		cmpPrefijo.setValue(pre)
		cmpCP.setValue(n.attributes.codigo_procedimiento)
		cmpNT.setValue(n.attributes.nombre_tabla)
		cmpCB.setValue(n.attributes.codigo_procedimiento)
		}
		
		
	};
	
	function btnGenerador(){
		var n = getSm().getSelectedNode();
		if(n){
			
			if(n.attributes.con_interfaz=='si'){
				var data = "";
				data = data + "&m_id_metaproceso=" + n.attributes.id_metaproceso;
				data = data + "&m_nombre=" + n.attributes.nombre;
				data = data + "&m_descripcion=" + n.attributes.descripcion;
				

				var paramVentana={
							Ventana:{
								width:'60%',
					            height:'70%'
							}
						};
				layout_meta.loadWindows(direccion+'../../tabla/tabla.php?'+data, "Descripción Tabla",paramVentana);
				layout_meta.getVentana().on('resize',function(){
			    layout_meta.getLayout().layout();
				});
			}
			else{
				Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
			}
		}
		else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
		
	}

	
		function btn_actualizar_pdb(){

		iloader.baseParams.filtrar=false
		if(filtro_tuc.getValue()!=''){
		iloader.baseParams.filtrar=true
		}
		
		iroot.reload()
	}
	
	//funciones drag an drop procesos db
	
	 function ramaDrop(e){
	 	
			var n = e.dropNode;
			// copy node from source tree
			//var ttt = isSourceCopy(e, n)
			if(n.getOwnerTree()==itree){//proviene del arbol de items ??
				//e.target.expand();//expandimos el nodo antes de buscar elementos repetidos
				if(!e.target.findChild('codigo_procedimiento',n.attributes.codigo_procedimiento)&&e.point=='append'){
					var copy = new Ext.tree.AsyncTreeNode(

					Ext.apply({allowDelete:true,expanded:true}, n.attributes));
					copy.loader = undefined;
					copy.attributes.allowDelete=true;
					e.dropNode=copy;
					//mandamos los datos del item al servidor

					var  nodo={};
					nodo['codigo_procedimiento']=copy.attributes.id;
					nodo['id_p']= e.target.id;
					copy.attributes.id_p=e.target.id;
					nodo['tipo']='item';				
					

					Ext.MessageBox.show({
						title: 'Espere Por Favor...',
						msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Guardando...</div>",
						width:150,
						height:200,
						closable:false
					});
					var postData='datos='+encodeURIComponent(Ext.encode(nodo))+'&proc=add';


					Ext.Ajax.request({
						url:direccion+'../../../../sis_seguridad/control/metaproceso/ActionGuardarMetaArb.php',
						params: postData,
						method:'POST',
						success:guardarSuccessDrop,
						argument:{nodo:e.dropNode,parent:e.target},
						failure:fallaDropItem,
						timeout:paramConfig.TiempoEspera
					}

					);

					return false

				}
				else{
					return false
				}
			}
			//return isReorder(e, n);
			return true
	 
	 
	 
	 }
	
	
	function guardarSuccessDrop(resp){
		var nodo=resp.argument.nodo;
		Ext.MessageBox.hide();
		var regreso = Ext.util.JSON.decode(resp.responseText)
		
		if(regreso.success=='true'){
			nodo.id=regreso.id;				
			nodo.attributes.id=regreso.id;				
			resp.argument.parent.appendChild(nodo)
			
		}
		resp.argument.parent.expand()
	}

	function fallaDropItem(resp,b,c){
		conexionFailure(resp,b,c);
	}
	



	/////////////////////////
	// parametros del menu //
	/////////////////////////

	var paramMenu={
		nuevo:{crear:true,separador:false,tip:'Nuevo Nodo',img:'add.gif'},
		editar:{crear:true,separador:false,tip:'Editar',img:'nodo_edit.png'},
		eliminar:{crear:true,separador:false,tip:'Eliminar',img:'delete.gif'},
		actualizar:{crear:true,separador:false}
	};


	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_meta.getLayout();
	};


	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	this.Init(); //iniciamos la clase madre
	this.iniciaFormulario();
	//this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Descripción campos',btnGenerador,true, 'btngen','Descripción Campos');
	this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Tabla',btnGenerador,true,'tabla','');
	iniciarEventos();	
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);

}

