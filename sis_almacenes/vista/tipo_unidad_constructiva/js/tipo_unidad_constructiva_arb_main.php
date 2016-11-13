<?php 
/**
 * Nombre:		  	    tipo_unidad_constructiva_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-07 15:46:18
 *
 */
session_start();
?>
//<script>
var paginaTipoActivo;

function main(){
	 	<?php
		//obtenemos la ruta absoluta
		$host  = $_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$dir = "http://$host$uri/";
		echo "\nvar direccion='$dir';";
	    echo "var idContenedor='$idContenedor';";
	?>
var paramConfig={
	TamanoPagina:20,
	TiempoEspera:10000,
	CantFiltros:1,
	FiltroEstructura:false,
	FiltroAvanzado:<?php echo $_SESSION["ss_filtro_avanzado"];?>
};
var elemento={pagina:new pagina_tuc_arb(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
alert("llega al main de arb");
}
Ext.onReady(main,main);

function pagina_tuc_arb(idContenedor,direccion,paramConfig){
	var eliminados=[]; //declaracion de array
	var adicionados=[];
	var modificados=[];

	var xt = Ext.tree;
	// seeds for the new node suffix
	var cseed = 0, oseed = 0;

	// turn on quick tips
	Ext.QuickTips.init();                                            //mensajes

	var cview = Ext.DomHelper.append(idContenedor,
	{cn:[{id:'main-tb'},{id:'cbody'}]}
	);


	// create the primary toolbar

	/***********************************
	BARRA DE TAREAS

	***************************************/
	var tb = new Ext.Toolbar('main-tb');
	tb.add({
		id:'save',
		text:'Grabar',
		disabled:false,
		handler:guardar,
		cls:'x-btn-text-icon save',
		tooltip:'Grabar Cambios'
	},'-', {
		id:'add',
		text:'Component',
		handler:addComponent,
		cls:'x-btn-text-icon add-cmp',
		tooltip:'Agregar un Nuevo Componente'
	},{
		id:'option',
		text:'Option',
		disabled:true,
		handler:addOption,
		cls:'x-btn-text-icon add-opt',
		tooltip:'Agregar Dependencia'
	},'-',{
		id:'remove',
		text:'Remove',
		disabled:false,
		handler:removeNode,
		cls:'x-btn-text-icon remove',
		tooltip:'Remover el Item Seleccionado'
	},'-',{
		id:'actualizar',
		text:'Actualizar',
		disabled:false,
		handler:actualizar,
		cls:'x-btn-text-icon remove',
		tooltip:'Actualizar'
	},'-',{
		id:'prueba',
		text:'Prueba',
		disabled:false,
		handler:prueba,
		cls:'x-btn-text-icon remove',
		tooltip:'Prueba'
	});
	// for enabling and disabling
	var btns = tb.items.map;



	/***********************************
	LAYOUT

	***********************************/

	// create our layout
	var layout = new Ext.BorderLayout(idContenedor,{
		west: {
			split:true,
			initialSize: 200,
			minSize: 175,
			maxSize: 400,
			titlebar: true,
			margins:{left:5,right:0,bottom:5,top:5}
		},
		center: {
			title:'Unidades Contructivas',
			margins:{left:0,right:5,bottom:5,top:5}
		}
	},idContenedor);

	layout.batchAdd({
		west: {
			id: 'source-files',
			autoCreate:true,
			title:'UNIDADES CONSTRUCTIVAS',
			autoScroll:true,
			fitToFrame:true
		},
		center : {
			el: cview,
			autoScroll:true,
			fitToFrame:true,
			toolbar: tb,
			resizeEl:'cbody'
		}
	});



	/***********************************

	ARBOL IZQUIERDO

	***************************************/
	// this is the source code tree
	var stree = new xt.TreePanel('source-files', {
		animate:true,
		loader: new xt.TreeLoader({dataUrl:'../../../sis_almacenes/control/tipo_unidad_constructiva/ActionListaTucArb.php'}),
		enableDrag:true,
		containerScroll: true
	});

	new xt.TreeSorter(stree, {folderSort:true});

	var sroot = new xt.AsyncTreeNode({
		text: 'Unidades Constructivas',
		checked:true,
		draggable:false,
		id:'id'
	});
	stree.setRootNode(sroot);  //   nodo ROOT raiz
	stree.render();				//  Dibujar arbol
	sroot.expand(false, false);


	/***********************************

	ARBOL DERECHO

	***************************************/

	// the component tree
	var ctree = new xt.TreePanel('cbody',{
		animate:true,
		enableDD:true,
		containerScroll: true,
		lines:false,
		rootVisible:false,
		loader: new Ext.tree.TreeLoader()
	});

	var croot = new xt.AsyncTreeNode({
		allowDrag:false,
		allowDrop:true,
		id:'id',
		text:'Packages and Components',
		cls:'croot',
		loader:new Ext.tree.TreeLoader({
			//dataUrl:'../../../sis_almacenes/control/tipo_unidad_constructiva/dep-tree.json',
			dataUrl:'../../../sis_almacenes/control/tipo_unidad_constructiva/ActionListaTucArb.php'/*,
			createNode: readNode   //  se ejecuta al crear un nuevo nodo*/
		})
	});
	ctree.setRootNode(croot);
	ctree.render();
	croot.expand();

	// some functions to determine whether is not the drop is allowed
	function hasNode(t, n){
		return (t.attributes.type == 'fileCt' && t.findChild('id', n.id)) ||
		(t.leaf === true && t.parentNode.findChild('id', n.id));
	};

	function isSourceCopy(e, n){
		var a = e.target.attributes;
		return n.getOwnerTree() == stree && !hasNode(e.target, n) &&
		((e.point == 'append' && a.type == 'fileCt') || a.leaf === true);
	};

	function isReorder(e, n){
		return n.parentNode == e.target.parentNode && e.point != 'append';
	};

	// handle drag over and drag drop
	ctree.on('nodedragover', function(e){
		var n = e.dropNode;
		return isSourceCopy(e, n) || isReorder(e, n);
	});

	ctree.on('beforenodedrop', function(e){
		var n = e.dropNode;

		// copy node from source tree
		if(isSourceCopy(e, n)){
			var copy = new xt.TreeNode(
			Ext.apply({allowDelete:true,expanded:true}, n.attributes)
			);
			copy.loader = undefined;
			if(e.target.attributes.options){
				e.target = createOption(e.target, copy.text);
				//return false;
			}
			e.dropNode = copy;
			return true;
		}

		return isReorder(e, n);
	});



	// track whether save is allowed
	//  ctree.on('append', trackSave);
	// ctree.on('remove', trackSave);
	ctree.el.swallowEvent('contextmenu', true);
	ctree.el.on('keypress', function(e){
		if(e.isNavKeyPress()){
			e.stopEvent();
		}
	});
	// when the tree selection changes, enable/disable the toolbar buttons
	var sm = ctree.getSelectionModel();
	sm.on('selectionchange', function(){
		var n = sm.getSelectedNode();
		if(!n){
			// btns.remove.disable();
			//btns.option.disable();
			return;
		}
		var a = n.attributes;
		//  btns.remove.setDisabled(!a.allowDelete);
		btns.option.setDisabled(!a.cmpId);
	});



	// create the editor for the component tree
	var ge = new xt.TreeEditor(ctree,{
		allowBlank:false,
		blankText:'A name is required',
		selectOnFocus:true
	});

	ge.on('beforestartedit', function(){
		if(!ge.editNode.attributes.allowEdit){
			return false;
		}
	});


	// add component handler
	function addComponent(){
		var id = guid('c-');
		var text = 'Component '+(++cseed);
		var node = createComponent(id, text);
		node.expand(false, false);
		node.select();
		node.lastChild.ensureVisible();
		ge.triggerEdit(node);
	}

	/**************************

	CREACION DE COMPONENTES

	****************************/


	function readNode(o){
		createComponent(o.id,o.text,o.files,o.dep,o.options)

	}

	function createComponent(id, text, cfiles, cdep, coptions){

		alert("id "+id+"  text " + text + "  cfiles  " + cfiles + "  cdep "+cdep+" coptions  "+coptions)
		var node = new xt.TreeNode({
			text: text,
			iconCls:'cmp',
			cls:'cmp',
			type:'cmp',
			// id: id,
			cmpId:id,
			allowDelete:true,
			allowEdit:true
		});
		croot.appendChild(node);



		var options = new xt.AsyncTreeNode({
			text: 'Optional Dependencies',
			allowDrag:true,
			allowDrop:true,
			loader:new Ext.tree.TreeLoader({dataUrl:'../../../sis_almacenes/control/tipo_unidad_constructiva/ActionListaTucArb.php'}),
			iconCls:'folder',
			type:'fileCt',
			options:true,
			id:id,
			cmpId:id,
			allowDelete:false,
			//children:coptions||[],
			expanded:true,
			allowCopy:true
		});

		node.appendChild(options);
		return node;

	}
	/**********************/

	function actualizar(){

		var n = sm.getSelectedNode();
		var hide=layout.el.unmask.createDelegate(layout.el);
		hide();
		
		alert("actualizar    ->  " + sm.getSelectedNode())
		eliminados = [];

		croot.reload();
		



	}

	/***********************/




	// remove handler
	/**************************

	REMOVER NODOS

	****************************/
	ctree.el.addKeyListener(Ext.EventObject.DELETE, removeNode);  //Para la tecla delete


	function removeNode(){
		var n = sm.getSelectedNode();
	
		if(n && n.attributes.allowDelete){
			ctree.getSelectionModel().selectPrevious();
			n.parentNode.removeChild(n);
			var dat={
				id:n.attributes.id,
				id_p:n.attributes.id_p,
				tipo:n.attributes.tipo
			}
			alert(dat.id)
			alert(dat.id_p)
			alert(dat.tipo)
			eliminados.push(dat)
			alert("tamaño dat  "+dat.length)
			alert("eliminados  " +eliminados)


		}
	}


	// add option handler
	function addOption(){
		var n = sm.getSelectedNode();
		if(n){
			var node = createOption(n, 'Option'+(++oseed));
			node.select();
			ge.triggerEdit(node);
		}
	}

	function createOption(n, text){
		var cnode = ctree.getNodeById(n.attributes.cmpId);

		var node = new xt.TreeNode({
			text: text,
			cmpId:cnode.id,
			iconCls:'folder',
			type:'fileCt',
			allowDelete:true,
			allowEdit:true,
			id:guid('o-')
		});
		cnode.childNodes[2].appendChild(node);
		cnode.childNodes[2].expand(false, false);

		return node;
	}

	// semi unique ids across edits
	function guid(prefix){
		return prefix+(new Date().getTime());
	}


	function trackSave(){

		alert("TRACK SAVE :- ----> " +croot.hasChildNodes())
		btns.save.setDisabled(!croot.hasChildNodes());
	}




	function storeChildren(cmp, n, name){
		if(n.childrenRendered){
			cmp[name] = [];
			n.eachChild(function(f){
				cmp[name].push(f.attributes);
			});
		}else{
			cmp[name] = n.attributes.children || [];
		}
	}
	/************************************************
	// save to the server in a format usable in PHP

	GRABAR

	*************************************************/
	function save(){
		var ch = [];

		//recorre  todos los nodos ejecutando esta funcion haste que devuelva false
		croot.eachChild(function(c){
			var cmp = {
				text:c.text,
				id: c.id,
				options:[]
			};

			// storeChildren(cmp, c.childNodes[0], 'files');
			// storeChildren(cmp, c.childNodes[1], 'dep');

			alert(" H0  "+c.childNodes[0]+" H1  "+ c.childNodes[1]+" H2  "+ c.childNodes[2])


			var onode = c//.childNodes[0];


			if(!onode.childrenRendered){
				alert("opcion 1")
				cmp.options = onode.attributes.children || [];
			}else{
				onode.eachChild(function(o){

					alert("Opcion 2  "+o.attributes);

					var opt = Ext.apply({}, o.attributes);
					storeChildren(opt, o, 'children');
					cmp.options.push(opt);
				});
			}
			ch.push(cmp);
		});

		layout.el.mask('Sending data to server...', 'x-mask-loading');
		var hide = layout.el.unmask.createDelegate(layout.el);
		
		alert("CODIFICACION   "+Ext.encode(ch))
		alert("CODIFICACION URI   "+encodeURIComponent(Ext.encode(ch)))
		
		Ext.lib.Ajax.request(
		'POST',
		'../../../sis_almacenes/control/tipo_unidad_constructiva/save-dep.php',
		{success:hide,failure:hide},
		'data='+encodeURIComponent(Ext.encode(ch))
		);
	}
	
		/************************************************
	// save to the server in a format usable in PHP

	GRABAR

	*************************************************/
	function guardar(){
		layout.el.mask('Sending data to server...', 'x-mask-loading');
		//var hide = layout.el.unmask.createDelegate(layout.el);
		Ext.lib.Ajax.request(
		'POST',
		'../../../sis_almacenes/control/tipo_unidad_constructiva/ActionGuardarTucArb.php',
		{success:guardarSuccess,failure:conexionFailure},
		'eliminados='+encodeURIComponent(Ext.encode(eliminados))
		);
		
		
		
	}
	
	function guardarSuccess(){
		var hide=layout.el.unmask.createDelegate(layout.el);
		hide();
		eliminados = [];
		
		
	}
	function conexionFailure(resp1,resp2,resp3){
		var hide=layout.el.unmask.createDelegate(layout.el);
		hide();
		ContenedorPrincipal.conexionFailure(resp1,resp2,resp3)
	}
	



	/*************************************************/
	function prueba(){

		//recorre los nodos hijo
		croot.eachChild(function(c){
			alert("ID  "+c.id+"  TEXT "+c.text)
		});


	}



	// context menus

	/*************************

	MENU CONTEXTUAL

	**************************/

	ctree.on('contextmenu', prepareCtx);

	var ctxMenu = new Ext.menu.Menu({
		id:'copyCtx',
		items: [{
			id:'expand',
			handler:expandAll,
			cls:'expand-all',
			text:'Expand All'
		},{
			id:'collapse',
			handler:collapseAll,
			cls:'collapse-all',
			text:'Collapse All'
		},'-',{
			id:'remove',
			handler:removeNode,
			cls:'remove-mi',
			text: 'Remove Item'
		}]
	});

	function prepareCtx(node, e){
		node.select();
		ctxMenu.items.get('remove')[node.attributes.allowDelete ? 'enable' : 'disable']();
		ctxMenu.showAt(e.getXY());
	}

	function collapseAll(){
		ctxMenu.hide();
		setTimeout(function(){
			croot.eachChild(function(n){
				n.collapse(false, false);
			});
		}, 10);
	}

	function expandAll(){
		ctxMenu.hide();
		setTimeout(function(){
			croot.eachChild(function(n){
				n.expand(false, false);
			});
		}, 10);
	}


}