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
var layout,innerLayout;
var Docs = function()
{
	//var layout;
	this.center;
	//center = this.center;
	this.foco; //esta variable nos indicara el id de la pestaña que tiene el foco
	//var innerLayout;
	var pestanas = Array();
	var config = {
		titulo_maestro:"",
		grid_maestro:'ext-grid'
	};

	return {
		init : function(param){
			////////////////


			if(param.titulo_maestro != null)
			config.titulo_maestro = param.titulo_maestro;

			if(param.grid_maestro != null)
			config.grid_maestro= param.grid_maestro;



			layout = new Ext.BorderLayout(document.body,
			{
				center: {
					split:false,
					titlebar: false,
					tabPosition: 'top',	
					autoScroll:false,				
					fitToFrame:true,
					closeOnTab: true,
					autoTabs:true,
					resizeTabs: true
					
				}
			});


			innerLayout = new Ext.BorderLayout('content', {
				center: {
					split:false,
					autoScroll:false,
					titlebar: false,
					fitToFrame:true,
					autoTabs:true,
					resizeTabs: true,
					tabPosition: 'top'
				}
				

			});


			layout.beginUpdate();
			/*innerLayout.add('center', new Ext.ContentPanel(config.grid_maestro,{fitToFrame:true,fitContainer:true, closable: false, title:"<b>"+config.titulo_maestro+"<b>"}));
			layout.add('center', new Ext.NestedLayoutPanel(innerLayout,{ title: "<b>"+config.titulo_maestro+"<b>"}));*/
			innerLayout.add('center', new Ext.ContentPanel(config.grid_maestro,{fitToFrame:true,fitContainer:true, closable: false, title:config.titulo_maestro}));
			layout.add('center', new Ext.NestedLayoutPanel(innerLayout,{ title: config.titulo_maestro}));
			this.center = layout.getRegion('center');


			layout.restoreState();
			layout.endUpdate();
		

		},
		//Cargar Pestaña Adicional
		loadTab : function(url,title){

			tabs = this.center.getTabs();
			var tam = tabs.getCount();
			var sw = false //indica que no existe la pestaña
			var indice// para capturar el indice de la pestaña
			if(tam > 0)
			{
				for(var i = 0; i< tam; i ++)
				{
					if(pestanas[tabs.getTab(i).id]==title)
					{
						sw = true;
						indice = i;
						break;
					}
				}

			}
			if(!sw) //si no exite la pestaña, abrimos una y la registramos
			{
				var iframe = Ext.DomHelper.append(document.body, {tag: 'iframe', frameBorder: 0, src: url});
				/*layout.add('center', new  Ext.ContentPanel(iframe, {title: "<b>"+title+"<b>", fitToFrame:true, closable:true}));*/
				layout.add('center', new  Ext.ContentPanel(iframe, {title: title, fitToFrame:true, closable:true}));
				pestanas[tabs.getTab(tam).id]=title;
				this.foco = tabs.getTab(tam).id

				////para acyualizar el contenido de la pestaña
				var foco = tabs.getTab(tam).id;
				//creamos el evento active para el cada pestaña nueva
				//cuando se activada (tome el foco) tenemos que actualizar el contenido
				tabs.getTab(foco).on('activate', function(){
					var puntero = null;
					for(var j=0;j< tabs.getCount();j++)
					{if(tabs.getTab(j).id == foco)
					{ puntero= j;
					break
					}
					}
					//para EXPLORER
					if (navigator.appName.indexOf("Explorer") != -1)
					{
						var k = frames.length - puntero -1
						if(frames[k]!= null)
						if(frames[k].obj_pagina != null)
						frames[k].obj_pagina.btnActualizar();
					}
					else
					{//para fireFOX
						if(frames[puntero]!=null)
						if(frames[puntero].obj_pagina != null)
						frames[puntero].obj_pagina.btnActualizar();
					}

				})
				////////////////////////////////////////////////
			}
			else
			{//si existe la pestaña le damos el foco
				tabs.activate(indice);
			}


		},
		//Cargar Pestaña Adicional
		getFoco : function(){
			return this.foco;
		}
		,
		//Cargar Pestaña Adicional
		getLayout : function(){
			return layout;
		},
		setEventoError : function(parametros){
			if(window.parent != undefined && window.parent != window)
			if(window.parent.Docs != undefined)
			window.parent.Docs.setEventoError(parametros);
			},
		setEventoLog: function(parametros){
			if(window.parent != undefined && window.parent != window)
			if(window.parent.Docs != undefined)
			window.parent.Docs.setEventoLog(parametros);
			}

	};
}();






