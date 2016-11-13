/*
 * Ext JS Library 1.1.1
 * Copyright(c) 2006-2007, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://www.extjs.com/license
 */

Ext.onReady(function(){
    Ext.QuickTips.init();
	var prueba;
	var ds;
	var checkBox=new Array;
	var id_checkBox= new Array;
	var codigo_checkBox= new Array;
	var sigla_checkBox= new Array;
	var config={id:'id_fuente_financiamiento',	
				descripcion:'denominacion',
				separador:true,
				selectTodo:true,
				selectCancel:true
				};
var tb ;
this.menu=Menus;
    // Menus can be prebuilt and passed by reference
    
 ds= new Ext.data.Store(
   {proxy: new Ext.data.HttpProxy({url: '../../../../sis_presupuesto/control/fuente_financiamiento/ActionListarFuenteFinanciamiento.php'}),
	reader:new Ext.data.XmlReader(
	{record:'ROWS',id:'id_fuente_financiamiento',totalRecords: 'TotalCount'},
	['id_fuente_financiamiento','codigo_fuente','denominacion','descripcion','sigla'])
	,remoteSort:true});
 
   		ds.load({
		params:{
			start:0,
			limit: 10000,
			CantFiltros:1
		},
	callback:function()
	{
		//this.menu(config,ds);   
		Menus(config,ds)
	
	}
	});

	function  Menus(config,ds)
	{
 
	
	
	checkBox = new Array();
	this.selectTodo;
	this.selectCancel;
	this.menu ;
	var botonMenu;
	var seleccionados = new Array();
	
	menu = new Ext.menu.Menu({id: 'mainMenu',minWidth :6, 	shadow : true});
	
		for(var i=0;i<ds.data.length;i++){
		checkBox[i]={id_checkBox:ds.getAt(i).data[config.id],
					 checkbox_object :   new Ext.menu.CheckItem({
										text: ds.getAt(i).data[config.descripcion],
										id:ds.getAt(i).data[config.id],
										checked:false,
										 checkHandler: onItemCheck
										}) 
					};
		menu.addItem(checkBox[i].checkbox_object);
		};
		if(config.separador){menu.addSeparator()};
		if(config.selectTodo){selectTodo = menu.add({text: 'Selecionar Todo'})};
		if(config.selectCancel){selectCancel= menu.add({text: 'Cancelar'})};
		
		tb = new Ext.Toolbar('toolbar');
		//new Ext.Toolbar.MenuButton(
     botonMenu= {
            cls: 'x-btn-text-icon bmenu', // icon and text class
            text:'Fuente de Financiamiento',
            menu: this.menu // assign menu by instance
        };
	tb.add( botonMenu);
		
		// Menus have a rich api for
		// adding and removing elements dynamically
		selectTodo.on('click', onItemClickSelecTodo);
		selectCancel.on('click', onItemClickSelectCancel);
	//	item.on('click', onItemClick);
		/*var prueba=new componenteSelecion(ds_fuente_financiamiento,form);*/
	/*	 	menu.on('itemclick',prueba)
	function prueba( baseItem,  e ){
        alert("llega pinche evento");
        
    };*/
	 
    function onItemCheck(item, checked){
    	 seleccionados.push(item.id) ;
        
  botonMenu.setVisible(true);
    botonMenu.show();
    }
    function onItemClickSelecTodo(item){
        alert("llego a todo"+seleccionados.toString ());
    	//Ext.example.msg('Menu Click', 'You clicked the "{0}" menu item.', item.text);
    };
    function onItemClickSelectCancel(item){
        //Ext.example.msg('Menu Click', 'You clicked the "{0}" menu item.', item.text);
        alert("llego cancel "+seleccionados.toString ());
    }
	
	}
	
        // functions to display feedback
    function onButtonClick(btn){
        Ext.example.msg('Button Click','You clicked the "{0}" button.', btn.text);
    }

   


    function onItemToggle(item, pressed){
        Ext.example.msg('Button Toggled', 'Button "{0}" was toggled to {1}.', item.text, pressed);
    }
 	
}
);
