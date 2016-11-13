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

function DocsLayoutDetalle(idC,idCP){
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
		config.grid_detalle='grid_detalle-'+idC;
		config.grid_maestro='grid-'+idC;
		div_layout=Ext.DomHelper.append(idC,{tag:'div',id:'layout-'+idC},true);
		layout=new Ext.BorderLayout(div_layout,{
			north:{
				split:true,
				fitToFrame:true,
				autoScroll:true,
				initialSize:110,
				minSize:100,
				maxSize:200,
				titlebar:true,
				collapsible:true,
				animate:false
			},
			center:{
				titlebar:true,
				autoTabs:true,
				resizeTabs:true,
				syncHeightBeforeShow:true,
				tabPosition:'top'
			}
		});
		layout.beginUpdate();
		var div_grid_maestro=Ext.DomHelper.append(div_layout,{tag:'div',id:config.grid_maestro});
		layout.add('north',new Ext.ContentPanel(config.grid_detalle,{fitToFrame:true,title:config.titulo_maestro,closable: false}));
		layout.add('center',new Ext.ContentPanel(div_grid_maestro,{fitToFrame:true,closable:false,title:config.titulo_detalle}));
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
			var iframe = Ext.DomHelper.append(idC,{tag:'iframe',frameBorder:0,src:url});
			layout.add('center',new  Ext.ContentPanel(iframe,{title:title,closable:true}));
			tabs=this.center.getTabs();
			if(tam==0){tam=1}
			pestañas[tabs.getTab(tam).id]=title
		}
		else{//si existe la pestaña le damos el foco
			tabs.activate(indice)
		}
	};

//Carga Ventana Adicional
	this.loadWindows=function(url,title,param,nombre_clase,init_pag){
		_CP.loadWindows(url,title,param,idC,nombre_clase,init_pag)		
	};
	
	this.getVentana=function(x){
		return _CP.getVentana(x)
	};
	this.getLayout=function(){return layout}
}