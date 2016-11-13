function pagina_tuc_arb(idContenedor,direccion,paramConfig)
{
	var Atributos=[];
	var cmpCodigo;
	var cmpNombre;
	var cmpDescripcion;
	var cmpCantidad;
	var cmpOpcional;
	var cmpIdComposicionTuc;
	var Dialog;
	var copiados;


	Atributos[0]={
		validacion:{
			name:'codigo',
			fieldLabel:'Código',
			allowBlank:false,
			width:300,
			maxLength:18,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto'
		},
		tipo: 'TextField'
	};


	Atributos[1]={
		validacion:{
			name:'nombre',
			fieldLabel:'Nombre',
			allowBlank:false,
			width:300,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto'
		},
		tipo: 'TextField'
	};


	// txt descripcion
	Atributos[2]= {
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripcion',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto'
		},
		tipo: 'TextArea',
		save_as:'descripcion'
	};


	// txt observaciones
	Atributos[3]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto'

		},
		tipo: 'TextArea'
	};

	// txt observaciones
	Atributos[4]={
		validacion:{
			name:'cantidad',
			fieldLabel:'cantidad',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			//allowDecimals:false,
			selectOnFocus:true,
			vtype:'texto'

		},
		tipo: 'NumberField'
	};

	// txt observaciones
	Atributos[5]={
		validacion:{
			name:'opcional',
			fieldLabel:'Opcional',
			checked:false,
			selectOnFocus:true
		},
		tipo:'Checkbox'
	};

	/*
	// txt id_composicion_tuc
	Atributos[5]={
	validacion:{
	name:'id_composicion_tuc',
	fieldLabel:'Composicion TUC',
	checked:false,
	selectOnFocus:true
	},
	tipo:'NumberField'
	};
	*/

	//datos extra a los Atributos declarados se manejaran en las operaciones basicas que maneja en las operacion
	var DatosNodo=new Array('id','id_p','tipo');
	//datos por defecto para los nuevos nodos que se creen en la vista
	var DatosDefecto={
		agrupador:{
			text:0,//indice del atributo
			icon:"../../../lib/imagenes/ag.png",
			allowDrag:false,
			allowDelete:false,
			allowEdit:true

		},
		raiz:{
			text:0,//indice del atributo
			icon:"../../../lib/imagenes/etucr.png",
			allowDrag:true,
			allowDelete:true,
			allowEdit:true,
			terminado:'false'

		},
		rama:{
			text:0,//indice del atributo
			icon:"../../../lib/imagenes/etuc.png",
			allowDrag:true,
			allowDelete:true,
			allowEdit:true,
			terminado:'false'
		},
		item:{
			text:1,//indice del atributo
			icon:"../../../lib/imagenes/item.png",
			allowDrag:true,
			allowDelete:true,
			allowEdit:true
		}


	}

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT ARBOL     -----------//
	//////////////////////////////////////////////////////////////
	//Inicia Layout
	var config={
		titulo:'Tipo Unidad Constructiva'
	};
	layout_tuc=new DocsLayoutArb(idContenedor);
	layout_tuc.init(config);


	//barra de tareas


	var _xpanel=Ext.DomHelper.append('layout-'+idContenedor,{tag:'div',id:'ceast-'+idContenedor});
	var tb = new Ext.Toolbar('ceast-'+idContenedor);

	var filtro_tuc=new Ext.form.TextField({
		id:'tuc_filtro_'+idContenedor,
		width:80
	});



	tb.add('Filtrar por: ','',filtro_tuc,'->',{

		icon:'../../../lib/imagenes/actualizar.jpg',
		cls: 'x-btn-icon',
		tooltip:'Actualizar Biblioteca',
		handler:btn_actualizar_tuc
	}
	);



	layout_tuc.getLayout().addRegion("east",{
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


	layout_tuc.getLayout().add('east',new Ext.ContentPanel(_xpanel,{closable:false,toolbar:tb}));

	/******************
	*  ARBOL DE ITEMS *
	*******************/
	// this is the source code tree

	var iloader=new Ext.tree.TreeLoader({dataUrl:direccion+'../../../../sis_almacenes/control/item/ActionListarItemArb.php'});

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

		}]
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




	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=PaginaArb;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,layout_tuc,idContenedor,DatosNodo,DatosDefecto);


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
			url:direccion+'../../../../sis_almacenes/control/tipo_unidad_constructiva/ActionGuardarTucArb.php',
			add_success:guardarSuccessSc,
			upd_success:guardarSuccessSc,
			edit:sEdit
		},
		Formulario:{
			height:350,
			width:480,
			minWidth:150,
			minHeight:200,
			closable:true,
			titulo:'Tipo Unidad Constructiva'
		},
		Listar:{
			url:direccion+'../../../../sis_almacenes/control/tipo_unidad_constructiva/ActionListaTucArb.php',
			raiz:'agrupador',
			baseParams:{},
			clearOnLoad:true,
			enableDD:true
		}
	};

	/////////////////////////
	// parametros del menu //
	/////////////////////////

	var paramMenu={
		nuevoRaiz:{crear:true,separador:false,tip:'Nuevo Agrupador',img:'ag+.png'},
		nuevo:{crear:true,separador:false,tip:'Nuevo Nodo',img:'add.gif'},
		editar:{crear:true,separador:false,tip:'Editar',img:'nodo_edit.png'},
		eliminar:{crear:true,separador:false,tip:'Eliminar',img:'delete.gif'},
		actualizar:{crear:true,separador:false}
	};


	////////////////////////////////////////
	//  FUnciones Propias                 //
	/////////////////////////////////////////

	// some functions to determine whether is not the drop is allowed
	function hasNode(t, n){
		return t.findChild('id', n.id);//busca si el nodo existe ya
	};

	function isSourceCopy(e, n){
		var a = e.target.attributes;

		//return n.getOwnerTree() != itree && !hasNode(e.target, n);
		return hasNode(e.target, n)
	};

	function isReorder(e, n){
		return n.parentNode == e.target.parentNode && e.point != 'append';
	};

	function iniciarEventos(){
		filtro_tuc.el.addKeyListener(13, btn_actualizar_tuc)//enter para iniciar el filtro
		cmpCodigo=getComponente('codigo');
		cmpNombre=getComponente('nombre');
		cmpDescripcion=getComponente('descripcion');
		cmpCantidad=getComponente('cantidad');
		cmpOpcional=getComponente('opcional');
		cmpIdComposicionTuc=getComponente('id_composicion_tuc');
		var treLoader=getLoader();
		Dialog=getDialog();

		///menu contextual principal

		var CtxMenuP=getCtxMenu();
		CtxMenuP.add({
			id:'copy',
			handler:btnCopy,
			cls:'copy-mi',
			text: 'Copiar'
		},{
			id:'paste',
			handler:btnPaste,
			cls:'paste-mi',
			text: 'Pegar'
		},{
			id:'lock',
			handler:btn_ttuc,
			cls:'lock-mi',
			text: 'Bloquear'
		},{
			id:'lock_open',
			handler:btn_dtuc,
			cls:'lock_open-mi',
			text: 'Desbloquear'
		}
		);





		treLoader.on("beforeload", function(treeL,n){
			treeL.baseParams.terminado=n.attributes.terminado;
			treeL.baseParams.tipo=n.attributes.tipo;
			//alert(n.attributes.id);
		}, this);


		getTreePanel().on('beforenodedrop', function(e){

			var n = e.dropNode;
			// copy node from source tree
			//var ttt = isSourceCopy(e, n)
			if(n.getOwnerTree()==itree){//proviene del arbol de items ??
				//e.target.expand();//expandimos el nodo antes de buscar elementos repetidos
				if(!e.target.findChild('id',n.id)&&e.point=='append'&&e.target.attributes.tipo!='agrupador'&&e.target.attributes.terminado=='false'){
					var copy = new Ext.tree.AsyncTreeNode(
					Ext.apply({allowDelete:true,expanded:true}, n.attributes)
					);
					copy.loader = undefined;
					copy.attributes.allowEdit=true;
					copy.attributes.allowDelete=true;
					e.dropNode=copy;
					//mandamos los datos del item al servidor

					var  nodo={};
					nodo['id']=copy.attributes.id;
					nodo['id_p']= e.target.id;
					copy.attributes.id_p=e.target.id;
					nodo['tipo']='item';
					nodo['cantidad']='1';
					nodo['observaciones']='';
					nodo['tipo']='item';
					nodo['opcional']=false;
					nodo['id_composicion_tuc']=e.target.id_composicion_tuc;

					Ext.MessageBox.show({
						title: 'Espere Por Favor...',
						msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Guardando...</div>",
						width:150,
						height:200,
						closable:false
					});
					var postData='datos='+encodeURIComponent(Ext.encode(nodo))+'&proc=add';


					Ext.Ajax.request({
						url:direccion+'../../../../sis_almacenes/control/tipo_unidad_constructiva/ActionGuardarTucArb.php',
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
		});

	}
	//copiar y pegar

	function btnCopy(){

		copiados = getSm().getSelectedNode()
	}
	function btnPaste(){

		var n = getSm().getSelectedNode();
		var vec={};
		vec.id=copiados.id;
		vec.id_p=copiados.attributes.id_p;
		vec.id_pn=n.id;
		vec.opcional=n.attributes.opcional;
		vec.cantidad=n.attributes.cantidad;
		vec.tipo=copiados.attributes.tipo;
		var postData='datos='+encodeURIComponent(Ext.encode(vec))+'&proc=copy';

		Ext.MessageBox.show({
			title: 'Espere Por Favor...',
			msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Guardando...</div>",
			width:150,
			height:200,
			closable:false
		});


		Ext.Ajax.request(
		{
			url:direccion+'../../../../sis_almacenes/control/tipo_unidad_constructiva/ActionGuardarTucArb.php',
			params: postData,
			method:'POST',
			success:terSuccess,
			argument:{nodo:n},
			failure:fallaDropItem,
			timeout:paramConfig.TiempoEspera
		}

		);
	}

	this.onBeforeMove = function(tree,n,oldParent,newParent){

		if((oldParent.attributes.tipo=='agrupador'||oldParent.attributes.terminado=='false')&&/*n.attributes.terminado=='true'&&*/newParent.attributes.terminado=='false'){
			return onBeforeMove(tree,n,oldParent,newParent)
		}
		else{
			return false
		}
	};

	this.prepareCtx= function(node,e){

		node.select();
		var sw=node.attributes.allowDelete ? 'enable' : 'disable';
		if(node.parentNode&&node.parentNode.attributes.terminado=='true'&&node.parentNode.attributes.tipo!='agrupador'){
			sw='disable'
		}
		getCtxMenu().items.get('remove')[sw]();

		if(node.parentNode.id=='id'||node.attributes.tipo=='item'){
			sw='disable'
		}
		else{
			sw='enable'
		}
		getCtxMenu().items.get('copy')[sw]();
		//sw=copiados&&node.attributes.terminado=='false'? 'enable' : 'disable';
		sw='disable';
		if(copiados&&node.attributes.terminado=='false'){
			if(copiados.attributes.tipo=='item'||node.attributes.codigo=='Basurero'||node.attributes.codigo=='Obsoletos'){
				//if(copiados.attributes.tipo=='item'&&node.attributes.tipo=='agrupador'&&node.attributes.codigo=='Basurero'&&&node.attributes.codigo=='Obsoletos'){
				sw='disable'
			}
			else{
				sw='enable'
			}

		}

		getCtxMenu().items.get('paste')[sw]();


		sw=node.attributes.terminado=='false'&&node.attributes.tipo!='agrupador'?'enable':'disable';
		getCtxMenu().items.get('lock')[sw]();

		sw=(node.attributes.terminado=='true'&&node.parentNode.attributes.terminado=='false')||(node.attributes.terminado=='true'&&node.parentNode.attributes.tipo=='agrupador')? 'enable' : 'disable';
		getCtxMenu().items.get('lock_open')[sw]();



		getCtxMenu().items.get('reload')[!node.leaf ? 'enable' : 'disable']();
		getCtxMenu().showAt(e.getXY());
		//getCtxMenu()

	};

	this.btnEliminar=function(){
		var n = getSm().getSelectedNode();
		if(!n){
			alert("Seleccione un nodo primero")
		}
		else{
			if(n.attributes.tipo=='agrupador'){
				btnEliminar()
			}
			else{
				if(n.parentNode.attributes.tipo=='agrupador'){
					btnEliminar()
				}
				else{
					if(n.parentNode.attributes.terminado=='false'){
						btnEliminar()
					}
					else{
						alert("Este nodo no puede eliminarse,\npor que su padre se encuentra terminado")
					}
				}
			}
		}
	};

	function sEdit(){

		var n = getSm().getSelectedNode();
		if(n.attributes.tipo=='item'&&n.parentNode.attributes.terminado!='true'){
			cmpCodigo.disable();
			cmpNombre.disable();
			cmpDescripcion.disable();
			mostrarComponente(cmpCantidad);
			mostrarComponente(cmpOpcional);
			cmpOpcional.el.up('.x-form-item').down('label').update('Considerar Repeticion');
			btnEdit()
		}
		if((n.attributes.tipo=='raiz'||n.attributes.tipo=='rama')&&n.attributes.terminado!='true'){
			itemTipoAux();

			mostrarComponente(cmpCantidad);
			mostrarComponente(cmpOpcional);
			if(n.parentNode.attributes.tipo=='agrupador'){
				ocultarComponente(cmpCantidad);
				ocultarComponente(cmpOpcional)
			}
			btnEdit()
		}
		if(n.attributes.tipo=='agrupador'){
			itemTipoAux();
			ocultarComponente(cmpCantidad);
			ocultarComponente(cmpOpcional);
			btnEdit()
		}
		if(n.attributes.terminado=='true'){
			alert("Este nodo se encuentra terminado, ya no se pueden realizar ningún cambio")
		}

	};
	this.btnNew=function(){
		var n = getSm().getSelectedNode();
		if(n&&!n.attributes.leaf&&n.attributes.terminado!='true'){
			itemTipoAux();
			cmpCantidad.setValue(1);
			nodo={};
			nodo.id=null;
			nodo.id_p=n.id;
			if(n.attributes.tipo=='agrupador'){
				nodo.tipo='raiz';
				ocultarComponente(cmpCantidad);
				ocultarComponente(cmpOpcional)
			}
			else{
				nodo.tipo='rama';
				mostrarComponente(cmpCantidad);
				mostrarComponente(cmpOpcional)
			}

			setValuesBasicos(nodo,'add')
			getFormulario().reset();
			Dialog.show()

		}
		else{
			if(n&&n.attributes.terminado=='true'){
				alert("Este nodo se encuentra terminado, ya no se pueden realizar ningún cambio")
			}
			else{
				alert("Seleccione un nodo primero")
			}
		}

		//btnNew()
	};
	this.btnNewRaiz=function(){
		itemTipoAux();
		ocultarComponente(cmpCantidad);
		ocultarComponente(cmpOpcional);
		nodo={};
		nodo.id='null';
		nodo.id_p='null';
		nodo.tipo='agrupador';
		setValuesBasicos(nodo,'add');

		getFormulario().reset();
		Dialog.show()
	};

	function itemTipoAux(){
		cmpCodigo.enable();
		cmpNombre.enable();
		cmpDescripcion.enable()
		cmpOpcional.el.up('.x-form-item').down('label').update('Opcional')
	}
	function guardarSuccessDrop(resp){

		var nodo=resp.argument.nodo;
		Ext.MessageBox.hide();
		var regreso = Ext.util.JSON.decode(resp.responseText)
		if(regreso.success=='true'){

			nodo.setText(nodo.attributes.nombre+" <b>[1]</b>")
			resp.argument.parent.appendChild(nodo)
		}
		resp.argument.parent.expand()
	}

	function fallaDropItem(resp,b,c){
		conexionFailure(resp,b,c);
	}
	function btn_tipo_unidad_cons_reemp(){
		var n = getSm().getSelectedNode();
		if(n&&n.attributes.tipo=='rama'){
			var data='maestro_id_composicion_tuc='+n.attributes.id_composicion_tuc;
			data=data+'&maestro_id_tipo_unidad_constructiva='+n.attributes.id;
			data=data+'&maestro_codigo='+n.attributes.codigo;
			data=data+'&maestro_nombre='+n.attributes.nombre;
			var Param={Ventana:{width:'90%',height:'60%'}};
			var ven=layout_tuc.loadWindows(direccion+'../../../vista/tipo_unidad_cons_reemp/tipo_unidad_cons_reemp_det.php?'+data,'Unidad Constructiva Reemplazo',Param,idContenedor);
			ven.on('resize',function(){layout_tuc.getLayout().layout()})
		}
		else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un nodo tipo rama.')
		}
	}
	function btn_reporte_tipo_unidad_cons(){
		var n = getSm().getSelectedNode();
		if(n&&(n.attributes.tipo=='raiz' || n.attributes.tipo=='rama')){
			var data='maestro_id_composicion_tuc='+n.attributes.id_composicion_tuc;
			data=data+'&maestro_id_tipo_unidad_constructiva='+n.attributes.id;
			data=data+'&maestro_codigo='+n.attributes.codigo;
			data=data+'&maestro_tipo='+n.attributes.tipo;
			data=data+'&maestro_terminado='+n.attributes.terminado;
			data=data+'&maestro_nombre='+n.attributes.nombre;
			data=data+'&maestro_nombre_padre='+n.attributes.nombre_p;
			window.open(direccion+'../../../control/_reportes/tuc/UnidadConstructiva.php?'+data)
		}
		else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un nodo tipo raíz o rama.')
		}
	}
	function btn_reporte_exist_sal(){
		var n = getSm().getSelectedNode();
		if(n&&(n.attributes.tipo=='raiz' || n.attributes.tipo=='rama')){
			var data='maestro_id_composicion_tuc='+n.attributes.id_composicion_tuc;
			data=data+'&maestro_id_tipo_unidad_constructiva='+n.attributes.id;
			data=data+'&maestro_codigo='+n.attributes.codigo;
			data=data+'&maestro_tipo='+n.attributes.tipo;
			data=data+'&maestro_terminado='+n.attributes.terminado;
			data=data+'&maestro_nombre='+n.attributes.nombre;
			data=data+'&maestro_nombre_padre='+n.attributes.nombre_p;
			window.open(direccion+'../../../control/_reportes/existencia_almacen/SalidasExistUnidadConstructiva.php?'+data)
		}
		else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un nodo tipo raíz o rama.')
		}
	}
	
	function btn_det_item_uc(){
		var n = getSm().getSelectedNode();
		if(n&&(n.attributes.tipo=='raiz' || n.attributes.tipo=='rama')){
			var data='maestro_id_composicion_tuc='+n.attributes.id_composicion_tuc;
			data=data+'&maestro_id_tipo_unidad_constructiva='+n.attributes.id;
			data=data+'&maestro_codigo='+n.attributes.codigo;
			data=data+'&maestro_tipo='+n.attributes.tipo;
			data=data+'&maestro_terminado='+n.attributes.terminado;
			data=data+'&maestro_nombre='+n.attributes.nombre;
			data=data+'&maestro_nombre_padre='+n.attributes.nombre_p;
			window.open(direccion+'../../../control/_reportes/existencia_almacen/DetalleIngresosUC.php?'+data)
		}
		else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un nodo tipo raíz o rama.')
		}
	}
	
	function btn_verif_exist_sal(){
		window.open(direccion+'../../../control/_reportes/existencia_almacen/VerificacionExistUC.php?')
	}

	function guardarSuccessSc(r){
		var np = getSm().getSelectedNode();
		guardarSuccess(r);
		if(r.argument.proc=='upd'){
			var aux=cmpCantidad.getValue();
			np.setText(np.attributes.nombre+" <b>["+aux+"]</b>")
		}
		else{
			if(np){
				var n=np.lastChild;
				if(n){
					var aux=cmpCantidad.getValue();
					if(np.attributes.tipo!='agrupador'){
						n.setText(n.attributes.nombre+" <b>["+aux+"]</b>")
					}

				}
			}
		}
	}
	////TERMINAR o DESBLOQUEAR

	function btn_ttuc(){
		getCtxMenu().hide();
		var n = getSm().getSelectedNode();
		if(confirm("¿Realmente desea Bloquear el Tipo de Unidad Constructiva? \n Ya no podrá realizar cambios a lis misma!!!")){
			var  nodo={};
			nodo['id']=n.id;
			Ext.MessageBox.show({
				title: 'Espere Por Favor...',
				msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Guardando...</div>",
				width:150,
				height:200,
				closable:false
			});
			var postData='datos='+encodeURIComponent(Ext.encode(nodo))+'&proc=ter';

			Ext.Ajax.request(
			{
				url:direccion+'../../../../sis_almacenes/control/tipo_unidad_constructiva/ActionGuardarTucArb.php',
				params: postData,
				method:'POST',
				success:terSuccess,
				argument:{nodo:n},
				failure:fallaDropItem,
				timeout:paramConfig.TiempoEspera
			}

			);
		}
	}


	function terSuccess(resp){

		var regreso = Ext.util.JSON.decode(resp.responseText)
		if(regreso.success=='true'){
			//Dialog.hide();
			Ext.MessageBox.hide();
			resp.argument.nodo.parentNode.reload()
			//btnActualizar();
		}
	}
	//DESBLOQUEAR


	function btn_dtuc(){
		getCtxMenu().hide();
		var n = getSm().getSelectedNode();
		if(confirm("¿Realmente desea Desbloquear la definición del Tipo de Unidad Constructiva? \n Solo podran ser desbloqueados los Tipo de UC de los que no se han hecho pedidos!!!")){

			var  nodo={};
			nodo['id']=n.id;
			Ext.MessageBox.show({
				title: 'Espere Por Favor...',
				msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Guardando...</div>",
				width:150,
				height:200,
				closable:false
			});
			var postData='datos='+encodeURIComponent(Ext.encode(nodo))+'&proc=des';

			Ext.Ajax.request(
			{
				url:direccion+'../../../../sis_almacenes/control/tipo_unidad_constructiva/ActionGuardarTucArb.php',
				params: postData,
				method:'POST',
				success:terSuccess,
				argument:{nodo:n},
				failure:fallaDropItem,
				timeout:paramConfig.TiempoEspera
			}

			);
		}
	}

	function btn_actualizar_tuc(){

		iloader.baseParams.filtrar=false
		if(filtro_tuc.getValue()!=''){
			iloader.baseParams.filtrar=true
		}

		iroot.reload()
	}


	this.getLayout=function(){
		return layout_tuc.getLayout();
	};



	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	this.Init(); //iniciamos la clase madre
	this.iniciaFormulario();
	iniciarEventos();
	this.AdicionarBoton('../../../lib/imagenes/tucrem.png','Reemplazo Unidad Constructiva',btn_tipo_unidad_cons_reemp,true,'tucr','Reemplazos');
	this.AdicionarBoton('../../../lib/imagenes/logo_pdf2.bmp','Lista de Materiales',btn_reporte_tipo_unidad_cons,true,'tucrep','Materiales')
	//this.AdicionarBoton('../../../lib/imagenes/logo_pdf2.bmp','Existencias y Salidas de Unidades Constructivas',btn_reporte_exist_sal,true,'tucrepexist','Existencias y Salidas')
	//this.AdicionarBoton('../../../lib/imagenes/logo_pdf2.bmp','Detalle Items UC',btn_det_item_uc,true,'detitemuc','Detalle Items')
	//this.AdicionarBoton('../../../lib/imagenes/logo_pdf2.bmp','Verificar Existencias de Unidades Constructivas',btn_verif_exist_sal,true,'verexist','Verificar Existencias')
	//this.AdicionarBoton('../../../lib/imagenes/actualizar.jpg','Actualizar Biblioteca',btn_actualizar_tuc,false,'tipo_unidad_cons_reemp','',true);
	//this.AdicionarBoton('../../../lib/imagenes/lock_open.png','Desbloquear TUC',btn_dtuc,true,'dtuc','Desbloquear');
}