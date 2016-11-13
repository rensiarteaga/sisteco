function pagina_pedido_uc_arb(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=[];

	var cmpCantidad,cmpRepeticion,cmpId_tuc_r,Dialog,layout,proc;


	//DATA STORE COMBOS

	ds_unidad_cons_reemp = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_unidad_constructiva/ActionListarTUCReemplazo.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_tipo_unidad_constructiva',
			totalRecords: 'TotalCount'

		}, ['id_tipo_unidad_constructiva','codigo','nombre','tipo','descripcion','observaciones','fecha_reg'])
	});

	var resultTpl = new Ext.Template(
	'<div class="search-item">',
	'<b><i>{codigo}</i></b>',
	'<b><br><i>{nombre}</i></b>',
	'<br><FONT COLOR="#B5A642">{descripcion}</FONT>',
	'</div>'
	);



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
		form:false,
		tipo: 'TextField'
	};


	Atributos[1]={
		validacion:{
			name:'cantidad',
			fieldLabel:'cantidad',
			allowBlank:false,
			maxLength:200,
			minLength:0,
			minValue:1,
			//allowDecimals:false,
			selectOnFocus:true,
			vtype:'texto'

		},
		//form:false,
		tipo: 'NumberField'
	};

	Atributos[2]={
		validacion:{
			name:'repeticion',
			fieldLabel:'Considerar Repeticion',
			checked:false,
			selectOnFocus:true
		},
		tipo:'Checkbox'
	};


	var fC=new Array();
	var fV=new Array();

	fC[0]='comtuc.id_composicion_tuc';
	fV[0]='%';
	Atributos[3]={
		validacion:{
			fieldLabel:'Tipo UC remplazo',
			emptyText:'Nombre TUC Reemp...',
			allowBlank:false,
			name:'id_tuc_r',
			desc: 'desc_tipo_unidad_constructiva', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_unidad_cons_reemp,
			valueField: 'id_tipo_unidad_constructiva',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'TIPOUC.nombre#TIPOUC.codigo#TIPOUC.descripcion',
			filterCols:fC,
			filterValues:fV,
			tpl:resultTpl,
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:15,
			minListWidth:450,
			grow:false,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:4,//caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true

		},
		tipo:'ComboBox'
	};


	//datos extra a los Atributos declarados se manejaran en las operaciones basicas que maneja en las operacion
	var DatosNodo=new Array('id','id_p','tipo','id_reg','id_composicion_tuc');
	//datos por defecto para los nuevos nodos que se creen en la vista
	var DatosDefecto={
		raiz:{
			text:0,//indice del atributo
			icon:"../../../lib/imagenes/tucr.png",
			allowDelete:false,
			allowEdit:true

		},
		rama:{
			text:0,//indice del atributo
			icon:"../../../lib/imagenes/tuc.png",
			allowDelte:true,
			allowEdit:true
		},
		item:{
			text:0,//indice del atributo
			icon:"../../../lib/imagenes/item.png",
			allowDelete:true,
			allowEdit:true
		}


	}

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT ARBOL     -----------//
	//////////////////////////////////////////////////////////////
	//Inicia Layout
	var config={
		titulo:'Pedido de Unidades Constructivas'
	};
	var layout_tuc=new DocsLayoutArb(idContenedor);
	layout_tuc.init(config);
	var layout=layout_tuc.getLayout();

	layout.addRegion("east",{
		split:true,
		initialSize:250,
		autoScroll:true,
		minSize:175,
		maxSize:400,
		titlebar:true,
		title:'Tipos de Unidades Constructivas',
		collapsible:false,
		animate:false,
		useShim:true
	});


	//var layout= layout
	layout.add('east', new Ext.ContentPanel(Ext.DomHelper.append('layout-'+idContenedor,{tag:'div',id:'ceast-'+idContenedor}),{closable:false}))


	/******************
	*  ARBOL DE ITEMS *
	*******************/
	// this is the source code tree

	var iloader=new Ext.tree.TreeLoader({dataUrl:direccion+'../../../../sis_almacenes/control/tipo_unidad_constructiva/ActionListaTucTerminadoArb.php'});

	//para mandar parametros extras
	iloader.on("beforeload", function(treeLoader, node){
		if(node.attributes.tipo){
			treeLoader.baseParams.tipo = node.attributes.tipo
		}
	}, this);


	var itree = new Ext.tree.TreePanel('ceast-'+idContenedor, {
		animate:true,
		rootVisible:false,
		loader:iloader,
		enableDrag:true,
		containerScroll: true
	});
	var ism = itree.getSelectionModel();
	itree.on('contextmenu', iprepareCtx);

	// new Ext.tree.TreeSorter(itree, {folderSort:true});

	var iroot = new Ext.tree.AsyncTreeNode({
		text: 'tuc',
		draggable:false,
		id:'id'
	});


	itree.setRootNode(iroot);
	itree.render();

	//itree.expand(false, false);
	ctxMenu = new Ext.menu.Menu({
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

	function iprepareCtx(node, e){node.select();ctxMenu.showAt(e.getXY())}
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
			n.expand(true);
			//});
		}, 10);
	}






	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = PaginaArb;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,layout_tuc,idContenedor,DatosNodo,DatosDefecto);


	//----------   herencia de la clase madre -------//
	var getTreePanel = this.getTreePanel;
	var getTreeRaiz = this.getTreeRaiz;
	var getLoader= this.getLoader;
	var conexionFailure=this.conexionFailure;
	var btnEdit=this.btnEdit;
	var btnNew=this.btnNew;
	var btnNewRaiz=this.btnNewRaiz;
	var btnEliminar=this.btnEliminar;
	var getComponente=this.getComponente;
	var getSm=this.getSm;
	var ocultarComponente=this.ocultarComponente;
	var mostrarComponente=this.mostrarComponente;
	var guardarSuccess=this.guardarSuccess;
	var getDialog=this.getDialog;
	var ocultarFormulario=this.ocultarFormulario;
	var prepareCtx=this.prepareCtx;
	var getCtxMenu=this.getCtxMenu;
	var getFormulario=this.getFormulario;





	/////////////////////////////
	// parametros las funciones//
	////////////////////////////


	var paramFunciones={
		Basicas:{
			url:direccion+'../../../../sis_almacenes/control/salida_detalle/ActionGuardarPedidoDetalleUcArb.php',
			add_success:gSuccess,
			edit:sEdit//edit sobrecargado
		},
		Formulario:{
			height:200,
			width:480,
			minWidth:150,
			minHeight:200,
			closable:true,
			titulo:'Cantidad a Pedir'
		},
		Listar:{
			url:direccion+'../../../../sis_almacenes/control/salida_detalle/ActionListaPedidoDetalleUcArb.php',
			baseParams:{id_salida:maestro.id_salida},
			enableDD:true,
			clearOnLoad:true,
			text:'Mi Pedido',
			rootVisible:true,
			lines:true,
			cls:'root'
		}
	};

	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_salida=datos.m_id_salida;
		maestro.descripcion=datos.m_descripcion;
		maestro.id_almacen_logico=datos.m_id_almacen_logico;

		paramFunciones.Listar.baseParams={id_salida:maestro.id_salida};
		this.InitFunciones(paramFunciones);
		this.getLoader().baseParams.id_salida=maestro.id_salida;
		this.btnActualizar()

	};



	/////////////////////////
	// parametros del menu //
	/////////////////////////

	var paramMenu={
		//nuevoRaiz:{crear:true,separador:false},
		//nuevo:{crear:true,separador:false},
		editar:{crear:true,separador:false,tip:'Establecer Cantidad',img:'nodo_edit.png',sobrecarga:sEdit},
		eliminar:{crear:true,separador:false,tip:'Quitar del pedido',img:'delete.gif'},
		actualizar:{crear:true,separador:false}
	};


	////////////////////////////////////////
	//  FUnciones Propias                 //
	/////////////////////////////////////////

	// some functions to determine whether is not the drop is allowed
	function hasNode(t,n){
		alert("busca el id " + n.id)
		return t.findChild('id', n.id);//busca si el nodo existe ya
	};

	function isSourceCopy(e, n){
		var a = e.target.attributes;
		alert("e.point  " + e.point)
		//return n.getOwnerTree() != itree && !hasNode(e.target, n);

		return hasNode(e.target,n)
	};

	function isReorder(e, n){
		return n.parentNode == e.target.parentNode && e.point != 'append';
	};


	function iniciarEventos(){


		Dialog=getDialog();
		Dialog.addButton("Remplazar",Remplazar);
		Dialog.addButton("Declinar",ocultarFormulario);
		Dialog.buttons[2].hide();
		Dialog.buttons[3].hide();
		var treLoader=getLoader();
		cmpCantidad=getComponente("cantidad");
		cmpRepeticion=getComponente("repeticion");
		cmpId_tuc_r=getComponente("id_tuc_r");


		//Armar elementos extras en el menu contextual
		var CtxMenuP=getCtxMenu();
		CtxMenuP.add({
			id:'orig',
			handler:btnOriginal,
			icon:'../../../lib/imagenes/tuc.png',
			text:'Invertir Reemplazo'
		},{
			id:'reemp',
			handler:btn_remplazar,
			icon:'../../../lib/imagenes/tucrem.png',
			text:'Reemplazar'
		},{
			id:'val',
			handler:btn_validar,
			cls:'validar-mi',
			text:'Validar existencias'
		}
		);




		treLoader.on("beforeload", function(treeLoader,naux){
			var id_reg;
			while(naux.parentNode){
				if(naux.parentNode.id=='id'){
					id_reg=naux.attributes.id_reg
				}
				naux=naux.parentNode
			}
			treeLoader.baseParams.id_reg=id_reg
		}, this);


		getTreePanel().on('beforenodedrop', function(e){
			var n = e.dropNode;

			if(!e.target.parentNode){
				var copy = new Ext.tree.AsyncTreeNode(
				Ext.apply({allowDelete:true,expanded:false}, n.attributes)
				);
				//copy.loader=undefined
				copy.loader=treLoader;
				copy.attributes.cantidad=1;
				if(copy.attributes.tipo=='item'){
					copy.setText(copy.attributes.nombre+" <b>[1.00]</b>")
				}else{
					copy.setText(copy.attributes.codigo+" <b>[1.00]</b>")
				}
				e.dropNode=copy;
				var nodo={};
				nodo.id=copy.attributes.id;
				nodo.id_p=e.target.id;
				nodo.tipo=copy.attributes.tipo;
				nodo.cantidad=1;
				
				var postData='datos='+encodeURIComponent(Ext.encode(nodo))+'&proc=add&id_salida='+maestro.id_salida;;


				Ext.MessageBox.show({
					title: 'Espere Por Favor...',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Guardando...</div>",
					width:150,
					height:200,
					closable:false
				});

				//Si es del tipo rama lo pone como raiz para que permite editar las cantidades
				if(copy.attributes.tipo=='rama'){
					tipo_aux='raiz';
				}
				else{
					tipo_aux=nodo.tipo;
				}

				Ext.Ajax.request({
					url:direccion+'../../../../sis_almacenes/control/salida_detalle/ActionGuardarPedidoDetalleUcArb.php',
					params: postData,
					method:'POST',
					success:guardarSuccessDD,
					argument:{nodo:e.dropNode,parent:e.target,tipo:tipo_aux},
					failure:fallaDropItem,
					timeout:paramConfig.TiempoEspera
				});

				//var noRep=e.target.findChild('id',n.id)//para buscar si existe el nodo repetido
				return false
			}
			return false
		});

	}
	//menu contextual
	//Verifica elementos del menu contextual antex de que se muestre
	this.prepareCtx= function(node,e){
		node.select();
		getCtxMenu().items.get('remove')[node.attributes.allowDelete ? 'enable' : 'disable']();
		getCtxMenu().items.get('reload')[!node.leaf ? 'enable' : 'disable']();
		getCtxMenu().items.get('reemp')[node.attributes.tipo!='item'&&node.attributes.id_composicion_tuc ? 'enable' : 'disable']();
		getCtxMenu().items.get('orig')[node.attributes.tipo!='item'&&node.attributes.id_composicion_tuc&&node.attributes.reemp=='si' ? 'enable' : 'disable']();
		getCtxMenu().showAt(e.getXY());
	};



	function guardarSuccessDD(resp){
		Ext.MessageBox.hide();
		var nodo=resp.argument.nodo;
		var regreso=Ext.util.JSON.decode(resp.responseText);

		if(regreso.success=='true'){
			var noRep=resp.argument.parent.findChild('id',nodo.id);//para buscar si existe el nodo repetido
			if(noRep&&noRep.attributes.tipo=='item'){
				noRep.attributes.cantidad= parseFloat(noRep.attributes.cantidad)+1;
				//alert(noRep.attributes.nombre + "<b>["+noRep.attributes.cantidad+"]</b>");
				noRep.setText(noRep.attributes.nombre + "<b>["+noRep.attributes.cantidad+"]</b>")
			}
			else{
				nodo.attributes.id_reg=regreso.id_reg;
				nodo.attributes.tipo=resp.argument.tipo;
				texto=nodo.attributes.codigo+' - '+nodo.attributes.nombre+' <b>['+nodo.attributes.cantidad+'.00]</b>'
				nodo.setText(texto);
				resp.argument.parent.appendChild(nodo);
				//nodo.parentNode.reload()
			}
		}
		resp.argument.parent.expand()
	}

	function fallaDropItem(resp,b,c){
		conexionFailure(resp,b,c)
	}

	//sobrecarga el boton de editar
	function sEdit(){
		Dialog.buttons[2].hide();
		Dialog.buttons[3].hide();
		Dialog.buttons[0].show();
		Dialog.buttons[1].show();
		ocultarComponente(cmpId_tuc_r);
		cmpId_tuc_r.disable();
		var n = getSm().getSelectedNode();
		if(n.parentNode&&(n.parentNode.id=='id'||(n.parentNode.id!='id'&&n.attributes.opcional=='true'))){
			if(n.parentNode.id!='id'&&n.attributes.opcional=='true'){
				cmpCantidad.minValue=0;
				ocultarComponente(cmpRepeticion)
				var id_reg;
				var naux=n;
				while(naux.parentNode){
					if(naux.parentNode.id=='id'){
						id_reg=naux.attributes.id_reg
					}
					naux=naux.parentNode
				}
				btnEdit({id_reg:id_reg,prueba:'jaja',ottra:'seeee'})
			}
			else{
				cmpCantidad.minValue=1;
				mostrarComponente(cmpRepeticion);
				btnEdit()
			}

		}
		else{
			alert("Seleccione un nodo editable")
		}
	};

	this.btnEliminar=function(){
		var n = getSm().getSelectedNode();
		if(n.parentNode&&n.parentNode.id=='id'){
			btnEliminar()
		}
		else{
			alert("Este nodo no puede eliminarse")
		}
	};


	function gSuccess(r){

		var n = getSm().getSelectedNode();
		guardarSuccess(r);
		var aux=cmpCantidad.getValue();
		if(n.attributes.tipo=='item'){
			n.setText(n.attributes.codigo+' - '+n.attributes.nombre+" <b>["+aux+"]</b>")
		}
		else{
			n.setText(n.attributes.codigo+' - '+n.attributes.nombre+" <b>["+aux+"]</b>")
		}
	}


	function btn_remplazar(){
		getCtxMenu().hide();
		var n = getSm().getSelectedNode();
		Dialog.buttons[0].hide();
		Dialog.buttons[1].hide();
		Dialog.buttons[2].show();
		Dialog.buttons[3].show();
		cmpCantidad.minValue=1;
		cmpId_tuc_r.filterValues[0] =n.attributes.id_composicion_tuc;
		cmpId_tuc_r.modificado = true;
		mostrarComponente(cmpId_tuc_r);
		cmpId_tuc_r.enable();
		ocultarComponente(cmpRepeticion);
		Dialog.show();
		Ext.form.Field.prototype.msgTarget='under';
		getFormulario().clearInvalid()
	}
	//funcion para remplazar nodos
	function Remplazar(){
		if(getFormulario().isValid()){
			var n = getSm().getSelectedNode();
			var  naux=n;
			var id_reg;
			while(naux.parentNode){
				if(naux.parentNode.id=='id'){
					id_reg=naux.attributes.id_reg
				}
				naux=naux.parentNode
			}


			var nodo={};
			nodo.id_composicion_tuc=n.attributes.id_composicion_tuc;
			nodo.id=n.attributes.id;
			nodo.id_p=n.attributes.id_p;
			nodo.tipo=n.attributes.tipo;
			nodo.id_reg=id_reg;
			nodo.cantidad=cmpCantidad.getValue();
			nodo.id_tuc=cmpId_tuc_r.getValue();


			if(nodo.id!=nodo.id_tuc){

				var postData='datos='+encodeURIComponent(Ext.encode(nodo))+'&id_salida='+maestro.id_salida+'&proc=reemp';
				Ext.MessageBox.show({
					title: 'Espere Por Favor...',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Guardando...</div>",
					width:150,
					height:200,
					closable:false
				});

				Ext.Ajax.request({
					url:direccion+'../../../../sis_almacenes/control/salida_detalle/ActionGuardarPedidoDetalleUcArb.php',
					params: postData,
					method:'POST',
					success:reempSuccess,
					argument:{nodo:n},
					failure:fallaDropItem,
					timeout:paramConfig.TiempoEspera
				});
			}else{
				Ext.MessageBox.alert('Estado', 'El tipo de unidad constructiva de reemplazo es igual al original, elija otro');
			}
		}
	}

	function reempSuccess(resp){
		var regreso = Ext.util.JSON.decode(resp.responseText)
		if(regreso.success=='true'){


			Dialog.hide();
			Ext.MessageBox.hide();
			resp.argument.nodo.parentNode.reload()
		}
	}
	/////FUNCION PARA QUE EL NODO VUELVA AL ORGINAL
	function btnOriginal(){

		var n = getSm().getSelectedNode();
		var  naux=n;
		var id_reg;
		while(naux.parentNode){
			if(naux.parentNode.id=='id'){
				id_reg=naux.attributes.id_reg
			}
			naux=naux.parentNode
		}


		var nodo={};
		nodo.id_composicion_tuc=n.attributes.id_composicion_tuc;
		nodo.id=n.attributes.id;
		nodo.id_p=n.attributes.id_p;
		nodo.tipo=n.attributes.tipo;
		nodo.id_reg=id_reg;
		var postData='datos='+encodeURIComponent(Ext.encode(nodo))+'&id_salida='+maestro.id_salida+'&proc=orig';
		Ext.MessageBox.show({
			title: 'Espere Por Favor...',
			msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Guardando...</div>",
			width:150,
			height:200,
			closable:false
		});

		Ext.Ajax.request({
			url:direccion+'../../../../sis_almacenes/control/salida_detalle/ActionGuardarPedidoDetalleUcArb.php',
			params: postData,
			method:'POST',
			success:reempSuccess,
			argument:{nodo:n},
			failure:fallaDropItem,
			timeout:paramConfig.TiempoEspera
		});
	}



	/////////VALIDAR

	function btn_validar(){
		getCtxMenu().hide();
		var n = getSm().getSelectedNode();
		var  naux=n;
		var id_reg;
		while(naux.parentNode){
			if(naux.parentNode.id=='id'){
				id_reg=naux.attributes.id_reg
			}
			naux=naux.parentNode
		}
		var nodo={};
		nodo.id_composicion_tuc=n.attributes.id_composicion_tuc;
		nodo.id=n.attributes.id;
		nodo.id_p=n.attributes.id_p;
		nodo.tipo=n.attributes.tipo;
		nodo.id_reg=id_reg;
		nodo.cantidad=n.attributes.cantidad;
		if(confirm("¿Esta Seguro de continuar con la validacion? \n¡Este proceso puede tardar varios minutos!")){
			var postData='datos='+encodeURIComponent(Ext.encode(nodo))+'&proc=validar&id_salida='+maestro.id_salida+'&id_almacen_logico='+maestro.id_almacen_logico;

			Ext.MessageBox.show({
				title: 'Espere Por Favor...',
				msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/>Verificando existencias...</div>",
				width:150,
				height:200,
				closable:false
			});

			Ext.Ajax.request({
				url:direccion+'../../../../sis_almacenes/control/salida_detalle/ActionVerificarExistenciasUcIndividual.php',
				params: postData,
				method:'POST',
				success:validarSuccess,
				argument:{nodo:n},
				failure:fallaDropItem,
				timeout:paramConfig.TiempoEspera
			});
		}
	}

	function validarSuccess(resp){
		Ext.MessageBox.hide();
		var regreso = Ext.util.JSON.decode(resp.responseText)
		if(regreso.mensaje=='true'){
			//alert("regreso.mensaje  " + regreso.mensaje)
			Ext.MessageBox.alert('Status', 'Todos los materiales necesarios para la construccion de esta unidad constructiva estan disponibles.');
		}
		else{
			alert("reporte de faltantes")
		}
	}
	function btn_actualizar_tuc(){
		iroot.reload();
	}



	this.getLayout=function(){
		return layout;
	};
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	this.Init(); //iniciamos la clase madre
	this.iniciaFormulario();
	iniciarEventos();
	this.AdicionarBoton('../../../lib/imagenes/actualizar.jpg','Actualizar Biblioteca',btn_actualizar_tuc,false,'tipo_unidad_cons_reemp','',true);
	//layout.addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
}