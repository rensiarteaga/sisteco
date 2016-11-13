/*
**********************************************************
Nombre de la función:	DocsLayoutMaestro()
Propósito:				Funcion que invoca la definicion del layout para el manejo de arboles
Tipo Maestro
Valores de Retorno:		Doc - > objeto de funciones necesarias para el manejo de pantalla
Fecha de Creación:		10 - 12 - 07
Versión:				2.0.0
Autor:					Rensi Arteaga Copari
**********************************************************
*/
function DocsLayoutArb(idContenedor){
	this.center;
	var layout,div_layout;
	var innerLayout,div_innerLayout;
	var config={titulo:""};
	var idVentana;
	var pagHijo=new Array();
	var contenedores;
	var contenSur;

	this.init=function(param){
		if(!param.titulo){
			config.titulo=param.titulo
		}
		
		
		 contenedores = {
				north:{
				initialSize:27				
			},
			center:{
				titlebar:false,
				autoScroll:true,
				useShim:true,
				tabPosition:'top',
				alwaysShowTabs:false,
				closeOnTab:true,
				fitToFrame:true
			}
		};
		
		
		if(param.area=='east'){
			
		Ext.apply(contenedores,{east:{
										split:true,
										autoScroll:true,
										initialSize:param.initialSize?param.initialSize:'50%',										
										titlebar: true,
										collapsible: true,
										animate: false,
										fitToFrame:true,
										cmargins: {top:2,bottom:2,right:2,left:2},
										collapsed:false
									}});
				
			
		}
		if(param.area=='south'){
			
		Ext.apply(contenedores,{south:{
										split:true,
										autoScroll:true,
										initialSize:param.initialSize?param.initialSize:'50%',											
										titlebar: true,
										collapsible: true,
										animate: false,
										fitToFrame:true,
										cmargins: {top:2,bottom:2,right:2,left:2},
										collapsed:false
									}});
				
			
		}
		

		
		div_layout=Ext.DomHelper.append(idContenedor,{tag:'div',id:'layout-'+idContenedor});
		
		var div_grid_det=Ext.DomHelper.append(div_layout,{tag:'div'},true);	
		
		layout=new Ext.BorderLayout(div_layout,contenedores);
		
		layout.beginUpdate();
		
		var div_ctree=Ext.DomHelper.append(div_layout,{tag:'div',id:'ctree-'+idContenedor});
		layout.add('north', new Ext.ContentPanel(div_ctree,{closable:false}));
		var div_tree=Ext.DomHelper.append(div_layout,{tag:'div',id:'tree-'+idContenedor});
		layout.add('center', new Ext.ContentPanel(div_tree,{closable:false/*,fitToFrame:true*/,autoScroll:true,title:config.titulo_maestro}));
		
		
		//para contenedor adicional
		contenSur=new Ext.ContentPanel(div_grid_det,{closable:false,fitToFrame:true,background:true})
		//var contenedor_panel_hijo=new Ext.ContentPanel(Win,{title:title,fitToFrame:true,closable:true,background:true});
		
		
		//layout.restoreState();		
		//layout.endUpdate()		
		
		
		//alert(contenSur.getId()) 
		if(param.area=='east' || param.area=='south'){
			
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
			
				if(param.area=='east'){	
					layout.add('east',contenSur );
				}
				
				else{
						layout.add('south',contenSur );
				}
		
		}
		
		
		
		
		layout.restoreState();
		layout.endUpdate();
	};
		
	this.getIdContentHijo=function(){
		return contenSur.getId()
	}
			//Carga Ventana Adicional
	this.loadWindows=function(url,title,param,nombre_clase,init_pag){
		//_CP.loadWindows(url,title,param,idContenedor,idContenedor)		
		_CP.loadWindows(url,title,param,idContenedor,nombre_clase,init_pag)		
	};
	
	this.getVentana=function(){
		return _CP.getVentana()
	};
	
	this.getLayout=function(){return layout};

}