/*
**********************************************************
Nombre de la función:	DocsLayoutMaestro()
Propósito:				Funcion que invoca la definicion del layout (las pantallas)
Tipo Maestro
Valores de Retorno:		 Doc - > objeto de funciones necesarias para el manejo de pantalla
Fecha de Creación:		25 - 04 - 07
Versión:				2.0.1
Autor:					Rensi Arteaga Copari
**********************************************************
*/
function DocsLayoutMaestroDeatalle(idContenedor){
	this.center;
	this.foco; //esta variable nos indicara el id de la pestaña que tiene el foco
	var layout,div_layout;
	var innerLayout,div_innerLayout;
	var pestanas=Array();
	var config={titulo_maestro:"",grid_maestro:'grid'};
	var idVentana;
	var contenSur;
	var pagHijo=new Array();
	
	
	
	
	this.init=function(param){
		if(param.titulo_maestro){config.titulo_maestro=param.titulo_maestro}
		config.grid_maestro='grid-'+idContenedor;
		
		//document.body
		div_layout=Ext.DomHelper.append(idContenedor,{tag:'div',id:'layout-'+idContenedor});
	
		var areaConfig= new Array();
		var _sizeVentana;
	
		if(param.initialSize!=''&&param.initialSize!=undefined&&param.initialSize!=null){
			_sizeVentana=param.initialSize;
		}else{
			_sizeVentana='50%';
		}
		
		var _title_hijo='';
		 
		if(param.title_hijo){
			
			 _title_hijo=param.title_hijo
		}
		
		
		if(param.area=='east'){
			
			areaConfig = {
					center:{
						titlebar:false,
						autoScroll:false,
						tabPosition:'top',
						alwaysShowTabs:false,
						syncHeightBeforeShow:true,
						closeOnTab:true,
						//resizeTabs:true,
						fitToFrame:true
					},
					east:{
							split:true,
							autoScroll:true,
							initialSize: '50%',
							minSize: 175,
							maxSize: 500,
							title:_title_hijo,
							titlebar: true,
							collapsible: true,
							animate: false,
							fitToFrame:true,
							cmargins: {top:2,bottom:2,right:2,left:2},
							collapsed:false
						}
				};
			
			
		}
		
		else{
		
				areaConfig = {
					center:{
						titlebar:false,
						autoScroll:false,
						tabPosition:'top',
						alwaysShowTabs:false,
						syncHeightBeforeShow:true,
						closeOnTab:true,
						
						//resizeTabs:true,
						fitToFrame:true
					},
					south: {
							split:true,
							autoScroll:true,
							initialSize:_sizeVentana,
							minSize: 175,
							maxSize: 500,
							titlebar: true,
							title:_title_hijo,
							collapsible: true,
							animate: false,
							fitToFrame:true,
							cmargins: {top:2,bottom:2,right:2,left:2},
							collapsed:false
						}
				};
		}
		
		
		layout=new Ext.BorderLayout(div_layout,areaConfig);

		//layout.beginUpdate();
		var div_grid=Ext.DomHelper.append(div_layout,{tag:'div',id:config.grid_maestro});
		var div_grid_det=Ext.DomHelper.append(div_layout,{tag:'div'},true);		
		
		layout.add('center', new Ext.ContentPanel(div_grid,{closable:false,fitToFrame:true,title:config.titulo_maestro}));
		
		contenSur=new Ext.ContentPanel(div_grid_det,{closable:false,fitToFrame:true,background:true})
		//var contenedor_panel_hijo=new Ext.ContentPanel(Win,{title:title,fitToFrame:true,closable:true,background:true});
		
		var _url=param.urlHijo.split('?');
				
		contenSur.load({
					url:param.urlHijo,
					method:'POST',
					
					//headers:{charset:'ISO-8859-15',Content-Type	application/x-javascript},
					params:{idContenedorPadre:idContenedor,idContenedor:contenSur.getId()},
					callback:function(x,y,z){
						if(param.clase_vista){
								var datos=Ext.urlDecode(_url[1]);
								var paramConfig={TamanoPagina:30,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:_CP.getConfig().ss_filtro_avanzado};
							    eval('_CP.setPagina({idContenedor:contenSur.getId(),pagina:new '+ param.clase_vista +'(contenSur.getId(),_CP.getConfig().ss_direccion,paramConfig,datos,idContenedor)})');
							}
						},
					scripts:true
				});
		//layout.restoreState();		
		//layout.endUpdate()		
		
		
		//alert(contenSur.getId()) 
		if(param.area=='east'){
			
			layout.add('east',contenSur );
		}
		
		else{
				layout.add('south',contenSur );
		}
		//layout.add('center', new Ext.ContentPanel(idContenedor,{closable:false,fitToFrame:true,title:config.titulo_maestro}));
		this.center=layout.getRegion('center');
		
		
	};
	
	this.getIdContentHijo=function(){
		return contenSur.getId()
	}
	//Carga Pestaña hijo
	this.loadTab=function(url,title){
		tabs=this.center.getTabs();
		//numero de pestañas existentes en el contenedor se subsistemas
		var tam=0;
		if(tabs){tam=tabs.getCount()}
		var sw=false;//indica que no existe la pestaña
		var indice;//para capturar el indice de la pestaña
		if(tam>0){
			for(var i=0;i<tam;i++){
				if(pestanas[tabs.getTab(i).id]==title){
					sw=true;
					indice=i;
					break
				}
			}
		}
		if(!sw){ //si no exite la pestaña, abrimos una y la registramos
			var frame=Ext.DomHelper.append(div_layout,{tag:'div'});
			var contenedor_panel_hijo=new Ext.ContentPanel(frame,{title:title,fitToFrame:true,closable:true});
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
			if(tam==0){tam=1}
			pestanas[tabs.getTab(tam).id]=title;
			this.foco=tabs.getTab(tam).id;
			////para acyualizar el contenido de la pestaña
			var foco=tabs.getTab(tam).id;
			//creamos el evento active para el cada pestaña nueva
			//cuando se activada (tome el foco) tenemos que actualizar el contenido
			tabs.getTab(foco).on('activate',function(){
				ContenedorPrincipal.getPagina(idContenedor).pagina.getPagina(foco).pagina.btnActualizar()
			})
		}
		else{//si existe la pestaña le damos el foco
			tabs.activate(indice)
		}
	};


	//Carga Ventana Adicional
	this.loadWindows=function(url,title,param,nombre_clase,init_pag){
		//_CP.loadWindows(url,title,param,idContenedor,idContenedor)	
		_CP.loadWindows(url,title,param,idContenedor,nombre_clase,init_pag)			
	};
	
	this.getVentana=function(){
		return _CP.getVentana()
	};
	this.getFoco=function(){return this.foco};
	this.getLayout=function(){return layout}
}








