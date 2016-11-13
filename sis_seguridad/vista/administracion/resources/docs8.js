/**
* Nombre:		  	    docs6.php
* Propósito: 			Contenedor principal carga y arranac todas los archivos necesarios
* Autor:				Rensi Arteaga Copari
* Fecha creación:		8 de noviembre 2007
*/
var cp = new Ext.state.CookieProvider({
       //path: "/cgi-bin/",
       expires: new Date(new Date().getTime()+(1000*60*60*24*30))
     //  domain: "extjs.com"
   });
Ext.state.Manager.setProvider(cp);


var _CP=function(){
	var estilo_vista,layoutContenedorPrincipal;
	var elementos=new Array();
	var elementosDinamicos=new Array();
	var center,eventos="",errores="",llave=true,center_principal;//para el contenedor de sistema
	var foco; //esta variable nos indicara el id de la pestaña que tiene el foco
	var foco_principal; //esta variable nos indicara el id de la pestaña que tiene el foco
	var tab_eventos = false; //si es la primera vez que se crea la pestaña de eventos
	var myForm,dialogin,ds,nro_link,dlgAlarmas;
	var sw_auten=false;//para autentificar
	//responde a las accion de click sobre el menu//
	var pes=new Array();
	var pesPrin=new Array();
	var config=new Array();//vector que contiene los parametros de configuracion inicial pasados por el servidor en la autentificacion
	var nom_usu;
	var pagHijo=new Array(),idVentana;//para manejo de ventanas
	var subsistemaFoco;
	var SubSistemas = new Array();

	function onClick(nodo){
		//si es nodo hoja se procesa
		if(nodo.leaf){
			//si el nodo de salida
			var title=nodo.attributes.nombre;
			if(title=="Salir"){
				window.location.href=nodo.attributes.ruta
			}
			else{
				//sacasmos el nombre del subsistema subiendo a los nodos superiores
				naux=nodo;
				while(naux.parentNode){
					if(naux.parentNode.id=='id'){
						subsistemaFoco=naux.attributes.nombre
					}
					naux=naux.parentNode
				}
				//buscamos si la pestaña ya fue creada
				var  ppInd,sw=false;// pesPrin indice

				for(var i=0;i<pesPrin.length;i++){
					if(pesPrin[i].id=='content_'+subsistemaFoco){
						sw=true;
						ppInd=i;
						break;
					}
				}

				if(!sw){//La pestaña de sistema existe????
					//creacion de la pestaña para el subsistema
					var layout_centro=Ext.DomHelper.append(document.body,{tag:'div',id:'content_'+subsistemaFoco});
					
					
					
					var contenLayoutAux=new Ext.BorderLayout(layout_centro,{
						center:{
							split:false,
							titlebar:false,
							autoScroll:false,
							tabPosition:'top',
							alwaysShowTabs:true,
							preservePanels:true,//preserva los paneles
							//resizeTabs:true,
							closeOnTab:true
						}
					});

					/*adicionamos pestaña para el centro*/

					layoutContenedorPrincipal.add('center',new Ext.NestedLayoutPanel(contenLayoutAux,{title:subsistemaFoco,closable:true}))
					contenLayoutAux.on('beforeclose',function(x,e){alert('x '+x);alert('e ' +e)})


					var vecAux={id:'content_'+subsistemaFoco,panel:contenLayoutAux,vecP:new Array()};

					pesPrin.push(vecAux);
					ppInd=pesPrin.length-1

				}
				else{
					//si la pestaña existe solo recuperamos el contenedor
					layoutContenedorPrincipal.add('center',new Ext.NestedLayoutPanel(pesPrin[ppInd].panel,{title:subsistemaFoco,closable:true}))
	 			}
				//el titulo existe destro la pestaña de sistema??con el indice encontrado
				var  pInd,sw=false;// pesPrin indice

				for(var i=0;i<pesPrin[ppInd].vecP.length;i++){
					if(pesPrin[ppInd].vecP[i].title==title){
						sw=true;
						pInd=i;
						break
					}
				}

				//Existe el titulo dentro de la pesta de sistema
				if(!sw){
					//si no existe la creamos
					//var frame = Ext.DomHelper.append('content_'+subsistemaFoco,{tag: 'div'});
					var frame = Ext.DomHelper.append(document.body,{tag:'div'});
					//getElementsByTagName()	alert("se esta enviando el farme "+frame.get);

					var contenedor_panel=new Ext.ContentPanel(frame,{title:title,fitToFrame:true,closable:true});
					
                    contenedor_panel.load({
						url:'../../../'+nodo.attributes.ruta,
						method:'POST',
						params:{nodo:nodo.attributes,idContenedor:contenedor_panel.getId(),id:'content_'+subsistemaFoco,idSub:title},
						scripts:true,
						headers:{"Accept-Charset":"ISO-8859-15","charset":"ISO-8859-15","Content-Type":"application/x-javascript;"},
						"Accept-Charset":"ISO-8859-15",
						"charset":"ISO-8859-15",
						//nocache:false,
						callback:function(x,y,z){
							
							if(z.argument.params.nodo.clase_vista){
							    var paramConfig={TamanoPagina:30,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:_CP.getConfig().ss_filtro_avanzado};
							    eval("_CP.setPagina({pagina:new "+z.argument.params.nodo.clase_vista+"(z.argument.params.idContenedor,_CP.getConfig().ss_direccion,paramConfig),idContenedor:z.argument.params.idContenedor})");
							
							}
							
							
						},
						defaultUrl:true,
						text:"Cargando...",
                	});
					
						
					pesPrin[ppInd].panel.add('center',contenedor_panel);
					pesPrin[ppInd].vecP.push({id:contenedor_panel.getId(),title:title,frame:frame,panel:contenedor_panel})

					contenedor_panel.on('activate',function(x){
						//recarga los datos de la ventana con el id encontrado
						if( _CP.getPagina(x.getId()).pagina.btnActualizar){
							_CP.getPagina(x.getId()).pagina.btnActualizar()
						}
						//_CP.getPagina(contenedor_panel.getId()).pagina.btnActualizar()

					})
				}
				else{
					pesPrin[ppInd].panel.showPanel(pesPrin[ppInd].vecP[pInd].panel.getId())
					pesPrin[ppInd].panel.add('center',pesPrin[ppInd].vecP[pInd].panel);
					/*//recarga los datos de la ventana con el id encontrado
					var pasaux=_CP.getPagina(pesPrin[ppInd].vecP[pInd].id).pagina;
					if(pasaux.btnActualizar){pasaux.btnActualizar()}*/
				}
			}

		}
	}



	function entrar(){

		//dehabilita el menu contextual


		myForm.findField('_usuario').enable();
		var ajax={
			success: function(action){


				//				alert(action.result)


				Ext.apply(config,Ext.util.JSON.decode(action.responseText));//copia configuracion inicial recuperada


				if(config.success){
					dialogin.setTitle("ENDESIS");
					//alert(action)
					//alert(action.responseText)
					_CP.setEstiloVista(config.ss_estilo_vista);
					Ext.MessageBox.hide();
					myForm.reset();

					dialogin.hide();
					if(!sw_auten){
						init();
						sw_auten=true
					}
				}
				else{
					ajax.failure()

				}
			},
			failure:function(action){

				Ext.MessageBox.hide();//ocultamos el loading
				dialogin.setTitle("Error en los Datos");
				myForm.reset();

				Ext.get('_usuario').focus();
				if(sw_auten){
					form.findField('_usuario').setValue(nom_usu);
					myForm.findField('_usuario').disable()
				}
			}
		};
		if (myForm.isValid()){

			loadingShow();
			///*/////aqui entra lo de encriptar con md5 por javascript para el envio de contraseña hex_md5(myForm. )
			nom_usu=myForm.findField('_usuario').getValue();



			//			myForm.submit({
			//			//waitMsg:'Autenticando usuário...',
			//			reset:true,
			//			success: ajax.success,
			//			failure: ajax.failure
			//			});
			//

			///////

			var cad='{\"contrasena\":\"'+myForm.findField('contrasena').getValue()+'\",\"usuario\":\"'+myForm.findField('usuario').getValue()+"\"}";

			Ext.Ajax.request({



				url:'../../control/auten/control.php',
				params:'xph='+Base64.encode(cad),
				method:'POST',
				success:ajax.success,
				failure:ajax.failure
			});

			//	myForm.reset();




			////////



		}
	}

	function init(){
		// initialize state manager, we will use cookies
		loadingShow();
		Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
		// create the main layoutContenedorPrincipal
		layoutContenedorPrincipal=new Ext.BorderLayout(document.body,{
			north:{
				split:false,
				initialSize:32,
				titlebar:false
			},
			west:{
				split:false,
				initialSize:250,
				autoScroll:true,
				initialSize:250,
				minSize:175,
				maxSize:400,
				titlebar:true,
				collapsible:true,
				animate:false,
				useShim:false
			},
			center:{
				titlebar:false,
				autoScroll:false,
				tabPosition:'top',
				autoTabs:true,
				alwaysShowTabs:true,
				preservePanels:true,
				closeOnTab:true
			},
			south:{
				split:false,
				titlebar:false
			}
		});
		// tell the layoutContenedorPrincipal not to perform layouts until we're done adding everything
		layoutContenedorPrincipal.beginUpdate();
		//var d_header = new array();
		d_cabecera = Ext.DomHelper.append(document.body,{tag:'div',id:'header'});
		cabecera=new  Ext.ContentPanel(d_cabecera);
		cabecera.load({url:'layoutCabecera.php',scripts:true});
		//Armamos el menu
		//		layoutContenedorPrincipal.add('west',new Ext.ContentPanel(Ext.DomHelper.append(document.body,{tag:'div',id:'ceast-menu'}),{title:'Menú de Navegación',closable:false}))


		layoutContenedorPrincipal.add('west',new Ext.ContentPanel(Ext.DomHelper.append(document.body,{tag:'div',id:'ceast-menu'}),{title:'<b>Menú de navegación</b>',closable:false}));


		//////////////////


		var tbmenu = new Ext.Toolbar('ceast-menu');
		tbmenu.add('->',{
			icon:'../../../lib/imagenes/actualizar.jpg',
			cls: 'x-btn-icon',
			tooltip:'Actualizar Biblioteca',
			handler:actualizarNodo
		}
		);
		//////////////////
		var iloader=new Ext.tree.TreeLoader({dataUrl:'../../control/menu/ActionListaPermisoArb.php'});
		iloader.addListener('loadexception',_CP.conexionFailure); //se recibe un error


		//para mandar parametros extras
		iloader.on("beforeload", function(treeLoader, node){
			//alert("node.attributes.tipo " + node.attributes.tipo)
			if(node.attributes.tipo){
				treeLoader.baseParams.tipo = node.attributes.tipo
			}
		}, this);
		var itree = new Ext.tree.TreePanel('ceast-menu',{
			animate:true,
			rootVisible:false,
			loader:iloader,
			enableDrag:true,
			containerScroll: true
		});
		var ism=itree.getSelectionModel();

		itree.on('contextmenu', prepareCtxSec);
		itree.on('click',onClick);

		// new Ext.tree.TreeSorter(itree, {folderSort:true});

		var iroot = new Ext.tree.AsyncTreeNode({
			//text: 'Menú de navegación',
			draggable:false,
			id:'id'
		});
		itree.setRootNode(iroot);
		itree.render();

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
		function prepareCtxSec(node, e){node.select();ctxMenu.showAt(e.getXY())}
		function actualizarNodo(){

			var n = itree.getSelectionModel().getSelectedNode();
			if(n){
				ctxMenu.hide();
				setTimeout(function(){
					if(!n.leaf){n.reload()}}, 10);
			}
			else{
				iroot.reload()
			}
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


		//fin menu

		//	var d_menu = Ext.DomHelper.append(document.body, {tag: 'div',id:'classes'/*,class:'ylayout-inactive-content'*/});
		//	menu=new  Ext.ContentPanel(d_menu,{title:'Menú de Navegación',fitToFrame:true,closable:false});
		//	menu.load({url:'../../control/menu/ActionListaPermiso.php',scripts:true});



		var d_pie = Ext.DomHelper.append(document.body, {tag: 'div',id:'estado'/*,class:"x-layout-panel-hd"*/});
		pie=new  Ext.ContentPanel(d_pie ,"Estado");
		pie.load({url:'layoutPie.php',scripts:true});
		layoutContenedorPrincipal.add('north',cabecera);
		//layoutContenedorPrincipal.add('west',menu);
		layoutContenedorPrincipal.add('south',pie);

		center_principal=layoutContenedorPrincipal.getRegion('center');

		layoutContenedorPrincipal.restoreState();
		layoutContenedorPrincipal.endUpdate();
		var page = window.location.href.split('#')[1];
		if(!page){page='bienvenida.php';}
		Ext.MessageBox.hide();//ocultamos el loading
		//////////////////////////////
		
		////////////////////////////////
	}




	function mostrarAlarmas(r,options,success){
		var aux;
		aux=Ext.get('ext-grid');
		aux.on('click',onClick,null,{delegate:'a',stopEvent:true});
		if(r.length>0){dlgAlarmas.show();}//Dialogo de alertas dehabilitado temporalmente
	}this.mostrarAlarmas=mostrarAlarmas;


	function formatDate(value){
		var dat=value?value.dateFormat('d/m/Y'):'';
		return dat;
	}
	function formatURL(val,cell,record,row,colum,store) {
		if(val!="")
		{
			nro_link=nro_link+1;
			/*var x='<div id="link'+nro_link+'"><a href="'+record.get('enlace')+'">Facturación y Ventas (FACTUR)-Cobranza</a></div>';
			alert(x);*/
			return '<div id="link'+nro_link+'"><a href="'+record.get('enlace')+'">'+val+'</a></div>';
		}
	}
	function loadingShow(){
		Ext.MessageBox.show({
			title: 'Espere Por Favor...',
			msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Cargando...</div>",
			width:150,
			height:200,
			closable:false
		});
	}
	////////
	return{
		login:function(){
			Ext.QuickTips.init();
			Ext.form.Field.prototype.msgTarget = 'side';
			if(!Ext.isIE){
				var divImg = Ext.get('loginImg');
				divImg.insertHtml('afterBegin','<img style="widht:55px; height:55px;" src="images/logo_gti.png" />');
				divImg.removeClass('pngTransp');
				divImg.addClass('divPos');
			}
			myForm = new Ext.form.Form({
				labelAlign:'right',
				labelWidth:75,
				buttonAlign:'right',
				url:'../../control/auten/control.php'
			});
			var myForm_login = new Ext.form.TextField({
				fieldLabel:'Usuario',
				name:'usuario',
				id:'_usuario',
				width:100,
				allowBlank:false
			});
			var myForm_senha = new Ext.form.TextField({
				fieldLabel:'Contraseña',
				name:'contrasena',
				inputType:'password',
				width:100,
				allowBlank:false
			});
			myForm.add(
			myForm_login,
			myForm_senha
			);
			myForm.render('myForm');

			dialogin = new Ext.BasicDialog("loginDlg", {
				modal:true,
				width:300,
				height:160,
				shadow:true,
				closable:false,
				minWidth:300,
				minHeight:160,
				proxyDrag: true
			});
			dialogin.addButton('Entrar',entrar, dialogin);
			dialogin.addKeyListener(Ext.EventObject.ENTER, entrar, dialogin); // Tecla enter

			dialogin.show();
			Ext.get('_usuario').focus();
		},
		loadLogin:function(){
			myForm.findField('_usuario').setValue(nom_usu);
			myForm.findField('_usuario').disable();
			dialogin.show();
		}
		,
		loadDoc:function(url){
			Ext.get('main').dom.src = url;
		},
		//regresa el indice de la pestaña que tiene el foco
		getFoco:function(){
			return foco;
		},
		setFoco:function(i){
			foco=i;
		},
		
		//regresa el cotendor de las pestañas
		getCenter:function(){
			return center;
		},
		
		getContenedorPrincipal:function(){
			return layoutContenedorPrincipal;
		},
		
		
		getPagina:function(idContenedor){
			for(i=0;i<elementos.length;i++){
				if(elementos[i].idContenedor==idContenedor){
					return elementos[i]}
			}
			return undefined
		},
		getPaginaDinamica:function(idContenedor){
			for(i=0;i<elementosDinamicos.length;i++){
				if(elementosDinamicos[i].idContenedor==idContenedor){
					return elementosDinamicos[i]}
			}
			return undefined
		},
		
		getElementos:function(){
			return elementos;
		},
		
		
		setPagina:function(elemento){
			elementos.push(elemento);
		},
		
		setPaginaDinamica:function(el){
			elementosDinamicos.push(el);
		},
		
		setPaginaByIndice:function(elemento,idContenedor){
			
			for(i=0;i<elementos.length;i++){
				if(elementos[i].idContenedor==idContenedor){
				   Ext.apply(elementos[i],elemento);
				   break;
				}
			}
			
		},
		
		setEstiloVista:function(val){
			estilo_vista=val;
			Ext.util.CSS.removeStyleSheet('theme');
			Ext.util.CSS.refreshCache()
			Ext.util.CSS.swapStyleSheet('theme','../../../lib/ext-yui/resources/css/'+estilo_vista);
		},
		loadingShow:function(){
			loadingShow();
		},
		deletePagina:function(I){
			sw=false;
			for(i=0;i<elementos.length;i++){
				if(elementos[i].idContenedor==I){
					sw=true;
					break
				}
			}
			if(sw==true){
				elementos[i].pagina.Destroy();
				delete elementos[i];
				elementos.splice(i,1)

			}
			//limpiar elementos huerfanos
			Ext.Element.garbageCollect();
		},
		//regresa el vector de configuraciones
		getConfig:function(){
			return config
		},
		/*************/
		getPestana:function(id){
			var ppInd;
			for(var i=0;i<pesPrin.length;i++){
				if(pesPrin[i].id==id){
					sw=true;
					ppInd=i;
					break;
				}
			}
			return pesPrin[ppInd];
		},
		getSubPestana:function(id,idSub){
			var pInd;
			var ppInd;
			for(var i=0;i<pesPrin.length;i++){
				if(pesPrin[i].id==id){
					ppInd=i;
					for(var j=0;j<pesPrin[ppInd].vecP.length;j++){
						if(pesPrin[ppInd].vecP[j].title==idSub){
							sw=true;
							pInd=j;
							break
						}
					}
				}
			}

			return pesPrin[ppInd].vecP[pInd];
		},
		/**************/

		conexionFailure:function(resp1,resp2,resp3,resp4){
			Ext.MessageBox.hide();
			var mensaje='';
			resp = resp1;//error conexion
			if(resp3!=null){
				resp = resp3;
			}//error conexion en el ds de EXT
			var sw = false;
			if(resp.status==04&&!sw){
				//var mensaje="<p>HTTP status: " + resp.status +" <br/> Status: " + resp.statusText +"<br/> No se encontro el Action requerido</p>";

				 mensaje="<p> No se encontro el Action requerido</p>";

				Ext.Msg.show({

					title: 'ALERTA',
					msg: mensaje,
					minWidth:300,
					maxWidth :800,
					buttons: Ext.Msg.OK
					//width: 300,
				});
				sw=true;
				//-- registro de errores --//
				parametros_mensaje = {
					origen:'Servidor',
					mensaje:mensaje,
					nivel:'3'
				};
			}

			if(!sw&&resp.responseXML&& resp.responseXML.documentElement){
				var root = resp.responseXML.documentElement;
						
				if(root.getElementsByTagName('mensaje')[0]){
					var oMensaje=root.getElementsByTagName('mensaje')[0].firstChild.nodeValue;
					//var mensaje="HTTP status: " + resp.status +"<br/> Status: " + resp.statusText +"<br>"+ oMensaje;
					 mensaje="<p>"+oMensaje+"</p>";


				}
				else{
					//var mensaje="HTTP status: " + resp.status +"<br/> Status: " + resp.statusText +"<br>"+ resp.responseText;
					
					if(resp.responseText!=''){
					  mensaje="<p>" +resp.responseText+"</p>";
					}
					else{
 					  mensaje="<p>Error de sintaxis  no recnocido , revise el código XML</p>";
						
					}
				
					
					

				}

				if(resp.status==401){
					ContenedorPrincipal.loadLogin();
				}
				else{
					Ext.Msg.show({
						title: 'ALERTA',
						msg: "<pre><font face='Arial'> "+mensaje+"</font></pre>" ,
						//msg: mensaje ,
						minWidth:300,
						minHeight:200,
						maxWidth :800,
						minHeight:600,
						buttons: Ext.Msg.OK
						//width: 300,
					});
				}
				sw=true;
			}
			else{//respuesta sin formato XML
				
				
				if(resp.status==-1&&!sw){
					//var mensaje = "<p>HTTP status: " + resp.status +"<br/> Status: " + resp.statusText +"<br/> Tiempo de espera agotado</p>";
					 mensaje = "<p>Tiempo de espera agotado</p>";

					Ext.Msg.show({
						title: 'ALERTA',
						msg: mensaje,
						minWidth:300,
						maxWidth :800,
						buttons: Ext.Msg.OK
						//width: 300,
					});
					sw = true;

				}
				if (resp.status==0&&!sw){
					//var mensaje = "HTTP status: " + resp.status +"<br/> Status: " + resp.statusText +"<br/> Fallo en su conexión de Internet";
					 mensaje = "<p> Fallo en su conexión de Internet</p>";

					Ext.Msg.show({
						title: 'ALERTA',
						msg: mensaje,
						minWidth:300,
						maxWidth :800,
						buttons: Ext.Msg.OK
						//width: 300,
					});
					sw=true;

				}
				if(!sw){
					mensaje = "respuesta indefinida, error en la transmision <br> respuesta obtenida:<br>"+ resp.responseText;
					Ext.Msg.show({
						title: 'ALERTA',
						msg: mensaje,
						minWidth:300,
						maxWidth :800,
						buttons: Ext.Msg.OK
						//width: 300,
					});
				}
			}
		},
		

		
		HideLoding:function(){
		   Ext.MessageBox.hide();//ocultamos el loading
		},

	loadWindows:function(url,title,param,idContenedor,clase_vista,init_pag){
			
			

			var sw=false,_url=url.split('?');
			for(var i=0;i<pagHijo.length;i++){
				if(pagHijo[i].url==_url[0]){
					var paginaHijo=_CP.getPagina(pagHijo[i].idContenedor);
					//if(!paginaHijo){
					if(!paginaHijo && _CP.getPagina(idContenedor)){	//modificado 17nov14 para q funcione en los hijos de layout procesos, antes solo validaba if(!paginaHijo)
						paginaHijo=_CP.getPagina(idContenedor).pagina.getPagina(pagHijo[i].idContenedor)
					}
					//si el reload esta habilitado
					if(paginaHijo && paginaHijo.pagina.setReload!=false){ //modificado 17nov14 para q funcione en los hijos de layout procesos. antes solo validaba paginaHijo.pagina.setReload!=false
						
						paginaHijo.pagina.reload(_url[1]);
						pagHijo[i].ventana.show();
						sw=true;
						
						if(paginaHijo.pagina&&paginaHijo.pagina.postreload){
							paginaHijo.pagina.postreload();
						}

						idVentana=pagHijo[i].idContenedor;
						
					}
					else{
					//si el reload no esta habilidato creamos una nueva instancia del objeto			
						
						if(paginaHijo && paginaHijo.pagina){ //17nov14: adicion de validacion para q funcione reload de detalles para layout procesos
							paginaHijo.pagina.Destroy()	
						} // //17nov14: adicion de validacion para q funcione reload de detalles para layout procesos
						delete  eleLayout;							
						delete elefor;
						
						if(paginaHijo && paginaHijo.pagina){  //17nov14: adicion de validacion para q funcione reload de detalles para layout procesos
							delete paginaHijo.pagina;
						} //17nov14: adicion de validacion para q funcione reload de detalles para layout procesos
						sw=true;			           
						pagHijo[i].ventana.show();
						
						if(_CP.getPaginaDinamica(pagHijo[i].idContenedor)){	 //17nov14: adicion de validacion para q funcione reload de detalles para layout procesos
							_CP.getPaginaDinamica(pagHijo[i].idContenedor).pagina.carga_menu(_url[1],pagHijo[i].idContenedor);
						} //17nov14: adicion de validacion para q funcione reload de detalles para layout procesos
					}
						
					
					
					break
				}
			}
			if(!sw){
				var	Ventana={
					modal:true,
					width:600,
					height:400,
					shadow:true,
					minWidth:300,
					minHeight:300,
					proxyDrag:true
				};
				if(param.Ventana){
					if(param.Ventana.modal){Ventana.modal=param.Ventana.modal}
					if(param.Ventana.width){Ventana.width=param.Ventana.width}
					if(param.Ventana.height){Ventana.height=param.Ventana.height}
					if(param.Ventana.shadow){Ventana.shadow=param.Ventana.shadow}
					if(param.Ventana.minWidth){Ventana.minWidth=param.Ventana.minWidth}
					if(param.Ventana.minHeight){Ventana.minHeight=param.Ventana.minHeight}
					if(param.Ventana.proxyDrag){Ventana.proxyDrag=param.Ventana.proxyDrag}
				}

				var Win = Ext.DomHelper.append(document.body,{tag:'div'},true);
				var contenedor_panel_hijo=new Ext.ContentPanel(Win,{title:title,fitToFrame:true,closable:true,background:true});


				
				
				contenedor_panel_hijo.load({
					url:url,
					method:'POST',
					params:{idContenedorPadre:idContenedor,idContenedor:contenedor_panel_hijo.getId()},
					scripts:true,
					callback:function(x,y,z){
						
						
							
						if(clase_vista){
								var datos=Ext.urlDecode(_url[1]);
								var paramConfig={TamanoPagina:30,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:_CP.getConfig().ss_filtro_avanzado};
							
									if(init_pag=='false'){
											
										//elementosDinamicos
											eval('_CP.setPaginaDinamica({idContenedor:contenedor_panel_hijo.getId(),pagina:new '+clase_vista +'(contenedor_panel_hijo.getId(),_CP.getConfig().ss_direccion,paramConfig,datos,idContenedor)})');
									}
									else{
											eval('_CP.setPagina({idContenedor:contenedor_panel_hijo.getId(),pagina:new '+ clase_vista +'(contenedor_panel_hijo.getId(),_CP.getConfig().ss_direccion,paramConfig,datos,idContenedor)})');
									}
							
					      }
					      else{
					      	
					      	
					      	
					      	
					      }
					
					      
						}
				});
				
				var idVentaHij=contenedor_panel_hijo.getId();
				marcas_html="<div class='x-dlg-hd'>"+title+"</div><div class='x-dlg-bd'><div id='ven-"+idVentaHij+"'></div></div>";


				var div_dlgInfo=Ext.DomHelper.append(document.body,{tag:'div',id:"v-"+idVentaHij,background:true,html:marcas_html});
				
				var ventana= new Ext.LayoutDialog('ven-'+idVentaHij,{
					id:'xven-'+idVentaHij,
					xidContenedor:contenedor_panel_hijo.getId(),
					title:param.title,
					modal:Ventana.modal,
					width:Ventana.width,
					height:Ventana.height,
					shadow:Ventana.shadow,
					minWidth:Ventana.minWidth,
					minHeight:Ventana.minHeight,
					proxyDrag:Ventana.proxyDrag,
					fitToFrame:true,
					center:{
						titlebar:false,
						autoScroll:true,
						tabPosition:'top',
						alwaysShowTabs:false,
						closeOnTab:true,
						//resizeTabs:true,
						fitToFrame:true}
				});
				ventana.getLayout().beginUpdate();
				ventana.getLayout().add('center',contenedor_panel_hijo);
				//  new Ext.ContentPanel(Ext.id(),{autoCreate:true, title: 'Another Tab', background:true}));
				ventana.getLayout().endUpdate();
				ventana.show();
				ventana.addListener('beforehide',function(x){
					var paginaHijo=_CP.getPagina(x.xidContenedor);
					if(!paginaHijo && _CP.getPagina(idContenedor)){
					//if(_CP.getPagina(idContenedor)){//modificado 17nov2014 para cerrar hijos de layout procesos . antes estaba if(!paginaHijo){
						paginaHijo=_CP.getPagina(idContenedor).pagina.getPagina(x.xidContenedor)
					}
					if(paginaHijo && paginaHijo.pagina.limpiarStore){paginaHijo.pagina.limpiarStore()}; //modificado 17nov2014 para cerrar hijos de layout procesos . antes estaba: paginaHijo.pagina.limpiarStore

				});
				ventana.addKeyListener(27,ventana.hide,ventana);
				idVentana=contenedor_panel_hijo.getId();
				var params={url:_url[0],idContenedor:contenedor_panel_hijo.getId(),ventana:ventana};
				pagHijo.push(params)
			}
		},
		getVentana:function(x){
			if(!x){x=idVentana}
			for(var i=0;i<pagHijo.length;i++){
				if(pagHijo[i].idContenedor==x){
					return pagHijo[i].ventana;
					break
				}
			}
		}
	}
}();
ContenedorPrincipal=_CP;
Ext.onReady(ContenedorPrincipal.login,ContenedorPrincipal,true);  