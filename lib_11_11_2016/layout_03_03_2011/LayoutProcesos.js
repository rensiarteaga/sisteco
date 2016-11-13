/*
**********************************************************
Nombre de la función:	Ext.onReady()
Propósito:				Funcion que invoca la definicion del layout para los Procesos
Tipo Maestro


Valores de Retorno:		 Doc - > objeto de funciones necesarias para el manejo de pantalla de procesos

Fecha de Creación:		25 - 06 - 07
Versión:				2.0.0
Autor:					Rensi Arteaga Copari
**********************************************************
*/
function DocsLayoutProceso(idContenedor){
	
	var layout,div_layout;
	this.center;
	this.foco; //esta variable nos indicara el id de la pestaña que tiene el foco
	var pestanas=Array();
	var config={titulo_maestro:""};
	this.init=function(param){
		if(param.titulo_maestro!=null){config.titulo_maestro=param.titulo_maestro;}
		div_layout=Ext.DomHelper.append(idContenedor,{tag:'div',id:'layout-'+idContenedor});
		layout=new Ext.BorderLayout(div_layout,{
			center:{
				titlebar:false,
				closeOnTab:true,
				tabPosition:'top',
			    autoScroll:true
			}
		});
		layout.beginUpdate();
		
		var div_formulario=Ext.DomHelper.append(div_layout,{tag:'div',id:'container_formulario-'+idContenedor});
		layout.add('center',new Ext.ContentPanel(div_formulario,{fitToFrame:true,closable:false,title:"<b>"+config.titulo_maestro+"<b>"}));
		this.center=layout.getRegion('center');
		layout.restoreState();
		layout.endUpdate();
	};
	
	
		this.loadTab=function(url,title){
		tabs=this.center.getTabs();
		//numero de pestañas existentes en el contenedor se subsistemas
		var tam=0;
		if(tabs!=undefined){tam=tabs.getCount();}
		var sw=false;//indica que no existe la pestaña
		var indice;//para capturar el indice de la pestaña
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
			var frame=Ext.DomHelper.append(div_layout,{tag:'div'});
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
			})
		}
		else{//si existe la pestaña le damos el foco
			tabs.activate(indice);
		}
	};
	
	
	//Carga Ventana Adicional
	this.loadWindows=function(url,title,param){
		_CP.loadWindows(url,title,param,idContenedor,idContenedor)		
	};
	
	this.getFoco=function(){
		return this.foco;
	};
	//Cargar Pestaña Adicional
	this.getLayout=function(){
		return layout;
	};
}