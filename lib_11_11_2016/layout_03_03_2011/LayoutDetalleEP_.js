/*
**********************************************************
Nombre de la función:	Ext.onReady()
Propósito:				Funcion que invoca la definicion del layout (las pantalas)
Tipo Detalle (tiene un norte reservado para los datos de un maestro)


Valores de Retorno:		 Doc - > objeto de funciones necesarias para el manejo de pantalla

Fecha de Creación:		25 - 04 - 07
Versión:				2.0.0
Autor:					Rensi Arteaga Copari
**********************************************************
*/

function DocsLayoutDetalleEP(idContenedor,idContenedorPadre){
	var layout,div_layout;
	this.center_detalle;
	var pestañas=Array();
	var config={
		titulo_maestro:"",
		titulo_detalle:"",
		grid_detalle:"",
		grid_maestro:""
	};
	var idVentana;
	var pagHijo=new Array();
	this.init=function(param){
		Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
		if(param.titulo_maestro){config.titulo_maestro=param.titulo_maestro}
		if(param.titulo_detalle){config.titulo_detalle=param.titulo_detalle}
		config.grid_detalle='grid_detalle-'+idContenedor;
		config.grid_maestro='grid-'+idContenedor;
		div_layout=Ext.DomHelper.append(idContenedor,{tag:'div',id:'layout-'+idContenedor});
		layout=new Ext.BorderLayout(div_layout,{
			north:{
				split:true,
				initialSize:110,
				minSize:100,
				maxSize:200,
				titlebar:true,
				collapsible:true,
				collapsedTitle:config.titulo_maestro,
				autoScroll:true,
				animate:false
			},
			center:{
				split:false,
				titlebar:true,
				autoTabs:true,
				autoScroll:true,
				resizeTabs:true,
				tabPosition:'top'
			},
			south:{
				split:false,
				initialSize:27,
				titlebar: false
			}
		});
		layout.beginUpdate();
		var div_grid_maestro=Ext.DomHelper.append(div_layout,{tag:'div',id:config.grid_maestro});
		var div_filtro=Ext.DomHelper.append(div_layout,{tag:'div',id:"filtro-"+idContenedor});
		layout.add('north',new Ext.ContentPanel(config.grid_detalle,{fitToFrame:true,title:config.titulo_maestro,closable: false}));
		layout.add('center',new Ext.ContentPanel(div_grid_maestro,{fitToFrame:true,closable:false,title:config.titulo_detalle}));
		layout.add('south', new Ext.ContentPanel(div_filtro, "Filtro"));
		this.center_detalle=layout.getRegion('center');
		layout.endUpdate()
	};
	
	//Cargar Pestaña Adicional
	this.loadTab=function(url,title){
		tabs=this.center_detalle.getTabs();
		var tam=0;
		if(tabs){tam= tabs.getCount()}
		var sw=false; //indica que no existe la pestaña
		var indice;// para capturar el indice de la pestaña
		if(tam>0){
			for(var i=0;i<tam;i++){
				if(pestañas[tabs.getTab(i).id]==title){
					sw=true;
					indice=i;
					break
				}
			}
		}
		if(!sw){ //si no exite la pestaña, abrimos una y la registramos
			var iframe=Ext.DomHelper.append(idContenedor,{tag:'iframe',frameBorder:0,src:url});
			layout.add('center',new  Ext.ContentPanel(iframe,{title:title,closable:true}));
			tabs=this.center.getTabs();
			if(tam==0){tam=1}
			pestañas[tabs.getTab(tam).id]=title
		}
		else{//si existe la pestaña le damos el foco
			tabs.activate(indice)
		}
	};
	
//Carga ventana Adicional
	this.loadWindows=function(url,title,param){
		var sw=false;var _url=url.split('?');
		for(var i=0;i<pagHijo.length;i++){
			if(pagHijo[i].url==_url[0]){				
				var paginaHijo = ContenedorPrincipal.getPagina(pagHijo[i].idContenedor)
				if(!paginaHijo){
				     paginaHijo=ContenedorPrincipal.getPagina(idContenedor).pagina.getPagina(pagHijo[i].idContenedor)				     
				}
				paginaHijo.pagina.reload(_url[1]);
				pagHijo[i].ventana.show();
				sw=true;
				idVentana=pagHijo[i].idContenedor;				
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

			var Win = Ext.DomHelper.append(div_layout,{tag:'div'},true);
			var contenedor_panel_hijo=new Ext.ContentPanel(Win,{title:title,fitToFrame:true,closable:true,background:true});
			contenedor_panel_hijo.load({
				url:url,
				method:'POST',
				params:{idContenedorPadre:idContenedor,idContenedor:contenedor_panel_hijo.getId()},
				scripts:true
			});
			var idVentaHij=contenedor_panel_hijo.getId();
			var marcas_html="<div class='x-dlg-hd'>"+title+"</div><div class='x-dlg-bd'><div id='ven-"+idVentaHij+"'></div></div>";
			var div_dlgInfo=Ext.DomHelper.append(document.body,{tag:'div',id:"v-"+idVentaHij,background:true,html:marcas_html});
			var ventana= new Ext.LayoutDialog('ven-'+idVentaHij,{
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
			ventana.addListener('beforehide',function(){/*ContenedorPrincipal.deletePagina(contenedor_panel_hijo.getId());Win.remove();contenedor_panel_hijo.destroy()*/});
			ventana.addKeyListener(27,ventana.hide,ventana);
			idVentana=contenedor_panel_hijo.getId();
			var params={url:_url[0],idContenedor:contenedor_panel_hijo.getId(),ventana:ventana};
			pagHijo.push(params)
		}
    };
	this.getVentana=function(){
		for(var i=0;i<pagHijo.length;i++){
			if(pagHijo[i].idContenedor==idVentana){
				return pagHijo[i].ventana;			
				break
			}
		}
	};
	this.getFoco=function(){return this.foco};
	this.getLayout=function(){return layout};
}