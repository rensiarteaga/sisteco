//////////////////////////////
//		CLASE MENU			//
//////////////////////////////

Menu=function(){



	Menu.superclass.constructor.call(this,{
		//id:'api-tree',
		region:'west',
		split:true,
		width: 280,
		minSize: 175,
		maxSize: 500,
		collapsible: true,
		collapseMode:'mini',
		animate:true,
		rootVisible:false,
		autoScroll: true,
		useArrows:true,
		tools:[{
			id:'refresh',
			// hidden:true,
			handler: function(event, toolEl, panel){
				// refresh logic
			}
		}],

		//loader:iloader,
		enableDrag:true,
		containerScroll: true,
		loader:new  Ext.tree.TreeLoader({url:'../../control/menu/ActionListaPermisoArb.php',
		preloadChildren:true,
		clearOnLoad:false

		}),

		root:new Ext.tree.AsyncTreeNode({
			text:'Menú de navegación',
			draggable:false,
			expanded:true,
			/*loader:new Ext.tree.TreeLoader({
			url:'../../control/menu/ActionListaPermisoArb.php',
			preloadChildren:false,
			clearOnLoad:false
			}),*/
			id:'id'
		}),
		collapseFirst:false
	});
	// no longer needed!
	//new Ext.tree.TreeSorter(this, {folderSort:true,leafAttr:'isClass'});

	/*this.getSelectionModel().on('beforeselect', function(sm, node){
	return node.isLeaf();
	});*/
};

Ext.extend(Menu,Ext.tree.TreePanel,{
	selectClass : function(cls){
		if(cls){
			this.selectPath('/id'+cls);
		}
	}

});


////////////////////////////////////////////
//   		CONTENEDOR PRINCIPAL  		 //
///////////////////////////////////////////

MainPanel = function(){
	MainPanel.superclass.constructor.call(this, {
		//id:'doc-body',
		region:'center',
		margins:'0 5 5 0',
		//resizeTabs: true,
		minTabWidth: 135,
		//tabWidth: 135,
		plugins: new Ext.ux.TabCloseMenu(),
		enableTabScroll: true,
		activeTab: 0,

		items: {
			id:'docs-endesis',
			closable:true,
			title: 'Endesis',
			cclass:'/endesis',
			autoLoad: {url: 'bienvenida.php'},
			iconCls:'icon-docs',
			autoScroll: true
		}
	});
};

Ext.extend(MainPanel, Ext.TabPanel,{

	loadClass : function(href, cls, title,icono,ruta){
		var id = 'docs-' + cls;
		var tab = this.getComponent(id);
		if(tab){
			this.setActiveTab(tab);

		}else{
			var iconCls='icon-folder';
			if(icono){
				Ext.util.CSS.createStyleSheet('.cls-'+cls+'{background-image: url('+icono+')!important;}');
				iconCls='cls-'+cls;
			}
			//var p = this.add(new Ext.layout.BorderLayout({
			var p = this.add(new Ext.Panel({
				id: id,
				title:title,
				cclass:ruta,
				iconCls:iconCls,
				layout:'fit',
				//layout:'border',
				autoShow :true,
				//autoScroll:true,
                //border:true,
                //xtype:'window',
				autoLoad: {url: href,params:{idContenedor:id},scripts :true},
				closable:true
			}));
			this.setActiveTab(p);
		
			
			
		}
	}

});


var _CP=function(){
	var menu,hd,mainPanel,win_login,form_login,sw_auten=false,estilo_vista;
	var config_ini=new Array();//vector que contiene los parametros de configuracion inicial pasados por el servidor en la autentificacion

	//para el filtro del  menu
	var filter,hiddenPkgs=[];

	return{
		init:function(){
			Ext.QuickTips.init();
			//definicion del menu
			menu=new Menu();
			menu.loader.addListener('loadexception',_CP.conexionFailure); //manejo de errores
			//           menu contextual
			var ctxMenu = new Ext.menu.Menu({
				id:'copyCtx',
				items: [{
					id:'expand',
					handler:expandAll,
					icon:'../../../lib/imagenes/arrow-down.gif',
					text:'Expandir todos'
				},{
					id:'collapse',
					handler:collapseAll,
					icon:'../../../lib/imagenes/arrow-up.gif',
					text:'Colapsar todos'
				},{
					id:'reload',
					handler:actualizarNodo,
					icon:'../../../lib/imagenes/act.png',
					text:'Actualizar nodo'

				}]
			});
			function actualizarNodo(){
				ctxMenu.hide();
				var n = menu.getSelectionModel().getSelectedNode();
				setTimeout(function(){
					if(!n.leaf){n.reload()}
				}, 10);
			}

			function collapseAll(){
				var n = menu.getSelectionModel().getSelectedNode();
				ctxMenu.hide();
				setTimeout(function(){
					n.collapseChildNodes(true)
				}, 10);
			}

			function expandAll(){
				var n = menu.getSelectionModel().getSelectedNode();
				ctxMenu.hide();
				setTimeout(function(){
					n.expand(true);
				}, 10);
			}



			menu.on('contextmenu', function (node, e){
				node.select();
				ctxMenu.showAt(e.getXY())
			});


			menu.on('click', function(node, e){
				if(node.isLeaf()){
					e.stopEvent();
					//sacasmos el nombre y la ruta del subsistema subiendo a los nodos superiores
					var naux=node,icono,ruta='';

					if(node.text=='Salir'){
						window.location.href=node.attributes.ruta
					}
					else{
						while(naux.parentNode){
							if(naux.parentNode.id=='id'){
								icono=naux.attributes.icon
							}
							ruta= '/'+naux.id+ruta;
							naux=naux.parentNode
						}
						mainPanel.loadClass('../../../'+node.attributes.ruta,node.id,node.attributes.nombre,icono,ruta)
					}
				}
			});

			//para filtra el menu
			filter = new Ext.tree.TreeFilter(menu,{
				clearBlank: true,
				autoClear: true
			});


			//definicion del panel principal
			mainPanel=new MainPanel();
			mainPanel.on('tabchange', function(tp, tab){
				menu.selectClass(tab.cclass);
			});

			hd = new Ext.Panel({
				border: false,
				layout:'anchor',
				region:'north',
				cls: 'docs-header',
				height:60,
				items:[{
					xtype:'box',
					el:'header',
					border:false,
					anchor: 'none -25'
				},
				new Ext.Toolbar({
					cls:'top-toolbar',
					items:[ ' ',
					new Ext.form.TextField({
						width: 200,
						emptyText:'Buscar ...',
						listeners:{
							render: function(f){
								f.el.on('keydown',_CP.filterTree, f, {buffer: 350});
							}
						}
					}), ' ', ' ',
					{
						iconCls: 'icon-expand-all',
						tooltip: 'Expand All',
						handler: function(){ menu.root.expand(true)}
					}, '-', {
						iconCls: 'icon-collapse-all',
						tooltip: 'Collapse All',
						handler: function(){ menu.root.collapse(true)}
					}, '->', {
						tooltip:'Salir',
						iconCls: 'icon-hide-inherited',
						handler : function(b, pressed){window.location.href='../../control/auten/cerrar.php'}
					}]
				})

				]
			});


			var viewport = new Ext.Viewport({
				id:'_CP',
				layout:'border',
				items:[hd,menu,mainPanel]
			});



			viewport.doLayout();
		},

		filterTree:function(e){
			var text = e.target.value.toLowerCase();
			Ext.each(hiddenPkgs, function(n){

				n.ui.show();
			});
			if(!text){
				filter.clear();
				return;
			}
			// menu.root.expand(true,false,function(){


			menu.expandAll();

			var re = new RegExp(Ext.escapeRe(text), 'i');
			// hide empty packages that weren't filtered
			hiddenPkgs = [];
			busquedaRecursiva(menu.root);
			function busquedaRecursiva(nodo){
				var  _sw_=false;
				nodo.eachChild(function(n){
					var sw1=false;


					if(n.isLeaf()){
						if(re.test(n.text)){
							sw1=true

						}
						else{
							n.ui.hide();
							hiddenPkgs.push(n)
						}
					}
					else{
						if(re.test(n.text.toLowerCase())){

							sw1=true
						}
						else{
							sw1=busquedaRecursiva(n)
						}
						if(!sw1){
							n.ui.hide();
							hiddenPkgs.push(n)
						}

					}
					if(!_sw_){
						_sw_=sw1;
					}
				})
				return _sw_
			}

		},

		login:function(){
			Ext.QuickTips.init();
			Ext.form.Field.prototype.msgTarget = 'side';
			//formulario
			form_login = new Ext.form.FormPanel({
				baseCls: 'x-plain',
				bodyStyle:'padding:30px 5px 50px 5px;border:none;background:#FFFFFF url(resources/logo_gti.png) no-repeat right center;',
				labelWidth: 65,
				labelAlign:'right',
				url:'../../control/auten/control.php',
				defaultType: 'textfield',
				defaults: {width: 100},
				items: [{
					fieldLabel: 'Usuario',
					allowBlank:false,
					align:'center',
					name:'usuario',
					id:'_usu'
				},{
					fieldLabel: 'Contraseña',
					name:'contrasena',
					allowBlank:false,
					align:'center',
					inputType: 'password'
				}]
			});



			//ventana para el login
			win_login = new Ext.Window({
				title: 'ENDESIS',
				baseCls: 'x-window',
				//iconCls: 'image_login',

				modal:true,
				width:320,
				height:180,
				shadow:true,
				closable:false,
				minWidth:300,
				minHeight:180,
				layout: 'fit',
				plain:true,
				bodyStyle:'padding:5px;',
				items: form_login,
				keys: [{
					key: Ext.EventObject.ENTER,
					fn:_CP.entrar}],
					buttons: [{
						text:'Entrar',
						handler:_CP.entrar
					}]
			});


			win_login.show();
			setTimeout(function(){
				Ext.get('loading').remove();
				Ext.get('loading-mask').fadeOut({remove:true});
				Ext.get('_usu').focus();
			}, 400);



		},
		loadLogin:function(){
			win_login.show();
		},

		entrar:function(){
			var ajax={
				success: function(form,action){
					Ext.apply(config_ini,action.result);//copia configuracion inicial recuperada
					_CP.setEstiloVista(config_ini.ss_estilo_vista);
					form_login.setTitle("ENDESIS");
					Ext.MessageBox.hide();
					win_login.hide();
					_CP.init();
					sw_auten=true;


				},
				failure:function(form,action){
					Ext.MessageBox.hide();//ocultamos el loading
					win_login.setTitle("Error en los Datos");
					form.reset();
					Ext.get('_usu').focus();
				}
			};
			if(form_login.getForm().isValid()){
				_CP.loadingShow();
				form_login.getForm().submit({
					//waitMsg:'Autenticando usuário...',
					reset:true,
					success: ajax.success,
					failure: ajax.failure
				});
			}
		}
		//manejo de errores
		,
		conexionFailure:function(resp1,resp2,resp3,resp4){
			Ext.MessageBox.hide();
			resp = resp1;//error conexion
			if(resp3!=null){
				resp = resp3;
			}//error conexion en el ds de EXT
			var mensaje;
			if(resp.status==401){
				//usuario no autentificado
				_CP.loadLogin();
				return
			}
			else if(resp.status==404){
				//No existe el archivo requerido
				mensaje="<p>HTTP status: " + resp.status +" <br/> Status: " + resp.statusText +"<br/> No se encontro el Action requerido</p>"
			}
			else if(resp.status==-1){
				//tiempo de espera agotado
				mensaje="<p>HTTP status: " + resp.status +"<br/> Status: " + resp.statusText +"<br/> Tiempo de espera agotado</p>"
			}
			else{
				//repuesta no reconocida
				mensaje = "respuesta indefinida, error en la transmision <br> respuesta obtenida:<br>"+ resp.responseText;
			}


			Ext.Msg.show({
				title: 'ERROR',
				msg:mensaje,
				minWidth:300,
				buttons: Ext.Msg.OK

			});


		},
		loadingShow:function(){
			Ext.MessageBox.show({
				title: 'Espere Por Favor...',
				msg:"<div><img src='../../../lib/ext2/resources/images/default/grid/loading.gif'/>  Cargando ...</div>",
				//msg:"<div><img src='../../../lib/imagenes/gti_3.gif'/>   Cargando ...</div>",
				minWidth:150,
				//height:200,
				closable:false
			});
		},
		//Para cambiar el estilo de la vista
		setEstiloVista:function(val){
			estilo_vista=val;
			Ext.util.CSS.removeStyleSheet('theme');
			Ext.util.CSS.refreshCache()
			Ext.util.CSS.swapStyleSheet('theme','../../../lib/ext2/resources/css/'+estilo_vista);
		},
		getMainPanel:function(){
			return mainPanel
		}
	}


}();
Ext.onReady(_CP.login);

Ext.Ajax.on('requestcomplete', function(ajax, xhr, o){
	if(typeof urchinTracker == 'function' && o && o.url){
		urchinTracker(o.url);
	}
});