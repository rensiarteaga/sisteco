/*
**********************************************************
Nombre de la función:	Ext.onReady()
Propósito:				Funcion que invoca la definicion del layout (las pantallas)
Tipo Maestro


Valores de Retorno:		 Doc - > objeto de funciones necesarias para el manejo de pantalla

Fecha de Creación:		25 - 04 - 07
Versión:				2.0.0
Autor:					Rensi Arteaga Copari
**********************************************************
*/
function DocsLayoutMaestroDetalle(idContenedor){
	var layout,layout_maestro;
	var div_layout,div_layout_maestro;
	this.center;
	this.foco; //esta variable nos indicara el id de la pestaña que tiene el foco
	var pestanas = Array();
	this.ventana;
	var config={
		titulo_maestro:"",
		grid_maestro:'grid-'+idContenedor,
		titulo_detalle:"",
		grid_detalle:'grid_det-'+idContenedor
	};
	this.init=function(param){
		if(param.titulo_maestro!=null){
			config.titulo_maestro = param.titulo_maestro;
		}
		if(param.titulo_detalle!= null){
			config.titulo_detalle= param.titulo_detalle;
		}
		div_layout=Ext.DomHelper.append(idContenedor,{tag:'div',id:'layout-'+idContenedor});
		layout = new Ext.BorderLayout(div_layout,{
			center: {
				split:false,
				titlebar: false,
				autoScroll:false,
				tabPosition:'top',
				alwaysShowTabs:false,
				fitToFrame:true,
				closeOnTab:true,
				autoTabs:true,
				resizeTabs:true,
				background:true

			}
		});
		
		
		
		div_layoutMD=Ext.DomHelper.append(idContenedor,{tag:'div',id:'layoutMD-'+idContenedor});
		layoutMD=new Ext.BorderLayout(div_layoutMD,{
			center:{
				split:false,
				titlebar: false,
				autoScroll:false,
				tabPosition:'top',
				alwaysShowTabs:false,
				fitToFrame:true,
				closeOnTab:true,
				autoTabs:true,
				resizeTabs:true,
				background:true

			},
			south: {
				split:true,
				autoScroll:false,
				initialSize:250,
				minSize:175,
				maxSize:400,
				titlebar:true,
				collapsible:true,
				animate:false,
				fitToFrame:true,
				collapsed:false
			}
		});
		
		div_layout_maestro=Ext.DomHelper.append(idContenedor,{tag:'div',id:'layout_maestro-'+idContenedor});
		layout_maestro=new Ext.BorderLayout(div_layout_maestro,{
			center:{
				split:false,
				titlebar: false,
				autoScroll:false,
				fitToFrame:true,
				autoTabs:true,
				resizeTabs: true,
				tabPosition: 'top'
			},
			south:{
				split:false,
				initialSize:27,
				titlebar: false
			}
		});
		layout.beginUpdate();
		layoutMD.beginUpdate();
		layout_maestro.beginUpdate();
		
		var div_grid=Ext.DomHelper.append(div_layout,{tag:'div',id:config.grid_maestro});
		var div_grid_det=Ext.DomHelper.append(div_layout_maestro,{tag:'div',id:config.grid_detalle});
		var div_filtro=Ext.DomHelper.append(div_layout,{tag:'div',id:"filtro-"+idContenedor});
		layout_maestro.add('center',new Ext.ContentPanel(div_grid,{closable:false,fitToFrame:true,title:config.titulo_maestro}));
		layout_maestro.add('south', new Ext.ContentPanel(div_filtro, "Filtro"));
		layoutMD.add('center', new Ext.NestedLayoutPanel(layout_maestro,{title:config.titulo_maestro}));
		layoutMD.add('south', new Ext.ContentPanel(div_grid_det,{closable:false,fitToFrame:true,title:config.titulo_detalle}));
		layout.add('center', new Ext.NestedLayoutPanel(layoutMD,{title:config.titulo_maestro}));
		this.center=layout.getRegion('center');
		layout.endUpdate();
		this.center = layout.getRegion('center');
		layout_maestro.restoreState();
		layout_maestro.endUpdate();
		layoutMD.restoreState();
		layoutMD.endUpdate();
		layout.restoreState();
		layout.endUpdate();
	};
	//Cargar Pestaña Adicional
	this.loadTab=function(url,title){
		tabs=this.center.getTabs();
		var tam=0;
		if(tabs!=undefined){tam=tabs.getCount();}
		var sw=false;//indica que no existe la pestaña
		var indice;// para capturar el indice de la pestaña
		if(tam>0){
			for(var i=0;i<tam;i++){
				if(pestanas[tabs.getTab(i).id]==title){
					sw=true;
					indice=i;
					break;
				}
			}
		}
		if(!sw){ //si no exite la pestaña, abrimos una y la registramos
			var frame = Ext.DomHelper.append(div_layout_maestro, {tag: 'div'});
			contenedor_panel_hijo=new Ext.ContentPanel(frame,{title:title,fitToFrame:true,closable:true});
			contenedor_panel_hijo.load({
				url:url,
				method:'POST',
				params:{idContenedorPadre:idContenedor,idContenedor:contenedor_panel_hijo.getId()},
				scripts:true
			});

			layout.beginUpdate();
			layout.add('center',contenedor_panel_hijo);
			layout.restoreState();
			layout.endUpdate();
			tabs=this.center.getTabs();
			if(tam==0){tam=1;}
			pestanas[tabs.getTab(tam).id]=title;
			this.foco=tabs.getTab(tam).id;

			////para acyualizar el contenido de la pestaña
			var foco=tabs.getTab(tam).id;
			//creamos el evento active para el cada pestaña nueva
			//cuando se activada (tome el foco) tenemos que actualizar el contenido
			tabs.getTab(foco).on('activate',function(){
				ContenedorPrincipal.getPagina(idContenedor).pagina.getPagina(foco).pagina.btnActualizar();
			});
		}
		else{//si existe la pestaña le damos el foco
			tabs.activate(indice);
		}
	};
		//abrir dialogo
	this.loadWindows=function(url,title,param,nombre_clase,init_pag){
	   _CP.loadWindows(url,title,param,idContenedor,nombre_clase,init_pag)		
	};
	
	//Cargar Pestaña Adicional
	this.getFoco=function(){
		return this.foco;
	};
	//Cargar Pestaña Adicional
	this.getLayout=function(){return layout;};
	this.getVentana=function(){return this.ventana;};
};