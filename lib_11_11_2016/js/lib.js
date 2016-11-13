//////////// aGREGA VALOR AUN CAMPO SELECT////////////
function addOption(name,text,value)
{
	var elOptNew = document.createElement('option');
	elOptNew.text = text;
	elOptNew.value = value;
	var elSel = document.getElementById(name);
	try
	{
		elSel.add(elOptNew, null); // standards compliant; doesn't work in IE
	}
	catch(ex)
	{
		elSel.add(elOptNew); // IE only
	}


}
// ==========================================================================
// Fuctions to mimic LTrim, RTrim, and Trim...
// Author          Aurélien Tisné	(CS)
// Date            03 avr. 2003 23:11:39
// Last Update     $Date$
// Version         $Revision$
// ==========================================================================
// --------------------------------------------------------------------------
// Remove leading blanks from our string.
// I               str - the string we want to LTrim
// Return          the input string without any leading whitespace
// Date            03 avr. 2003 23:12:13
// Author          Aurélien Tisné	(CS)
// --------------------------------------------------------------------------
function LTrim(str)
{
	var whitespace = new String(" \t\n\r");

	var s = new String(str);

	if (whitespace.indexOf(s.charAt(0)) != -1)
	{// We have a string with leading blank(s)...
		var j=0, i = s.length;

		// Iterate from the far left of string until we
		// don't have any more whitespace...
		//sw = true
		while (j < i && whitespace.indexOf(s.charAt(j)) != -1){
			j++
		}
		// Get the substring from the first non-whitespace
		// character to the end of the string...
		s = s.substring(j, i)
	}
	return s
}

// --------------------------------------------------------------------------
// Remove trailing blanks from our string.

// I               str - the string we want to RTrim
// Return          the input string without any trailing whitespace

// Date            03 avr. 2003 23:13:50
// Author          Aurélien Tisné	(CS)
// --------------------------------------------------------------------------
function RTrim(str)
{
	// We don't want to trip JUST spaces, but also tabs,
	// line feeds, etc.  Add anything else you want to
	// "trim" here in Whitespace
	var whitespace = new String(" \t\n\r");
	var s = new String(str);
	if (whitespace.indexOf(s.charAt(s.length-1)) != -1) {
		// We have a string with trailing blank(s)...
		var i = s.length - 1;       // Get length of string

		// Iterate from the far right of string until we
		// don't have any more whitespace...
		while (i >= 0 && whitespace.indexOf(s.charAt(i)) != -1){
			i--
		}


		// Get the substring from the front of the string to
		// where the last non-whitespace character is...
		s = s.substring(0, i+1)
	}
	return s
}

// --------------------------------------------------------------------------
// Remove trailing and leading blanks from our string.

// I               str - the string we want to Trim
// Return          the trimmed input string

// Date            03 avr. 2003 23:15:09
// Author          Aurélien Tisné	(CS)
// --------------------------------------------------------------------------
function Trim(str){
	return RTrim(LTrim(str))
}

// EOF

/*
ejemplo

addOption("contactoId","Luis Miguel Espinoza",0)


*/

/////////////////////////////////////////////MENSAJESSSS

Ext.BLANK_IMAGE_URL = '../../../lib/ext-yui/resources/images/default/s.gif';

//Ext.onReady(Ext.mensajes.init, Ext.mensajes);
 Ext.mensajes = function() {
        var msgCt;
    
        function createBox(t, s){
            return ['<div class="msg">',
                    '<div class="x-box-tl"><div class="x-box-tr"><div class="x-box-tc"></div></div></div>',
                    '<div class="x-box-ml"><div class="x-box-mr"><div class="x-box-mc"><h3>', t,
                    '</h3>', s, '</div></div></div>',
                    '<div class="x-box-bl"><div class="x-box-br"><div class="x-box-bc"></div></div></div>',
                    '</div>'].join('');
        }
        return {
            msg : function(title, format){
                if(!msgCt){
                    msgCt = Ext.DomHelper.insertFirst(document.body, {id:'msg-div'}, true);
                }
              //  msgCt.alignTo(document, 'tr-tr', [-100,-300]);
                
                 msgCt.alignTo(document, 'tr-tr');
                var s = String.format.apply(String, Array.prototype.slice.call(arguments, 1));
                var m = Ext.DomHelper.append(msgCt, {html:createBox(title, s)}, true);
                m.slideIn('t').pause(4).ghost("t", {remove:true});
            }
        };
   }();



// old school cookie functions grabbed off the web
var Cookies = {};
Cookies.set = function(name, value){
	var argv = arguments;
	var argc = arguments.length;
	var expires = (argc > 2) ? argv[2] : null;
	var path = (argc > 3) ? argv[3] : '/';
	var domain = (argc > 4) ? argv[4] : null;
	var secure = (argc > 5) ? argv[5] : false;
	document.cookie = name + "=" + escape (value) +
	((expires == null) ? "" : ("; expires=" + expires.toGMTString())) +
	((path == null) ? "" : ("; path=" + path)) +
	((domain == null) ? "" : ("; domain=" + domain)) +
	((secure == true) ? "; secure" : "");
};

Cookies.get = function(name){
	var arg = name + "=";
	var alen = arg.length;
	var clen = document.cookie.length;
	var i = 0;
	var j = 0;
	while(i < clen){
		j = i + alen;
		if (document.cookie.substring(i, j) == arg){
			return Cookies.getCookieVal(j)
		}
		i = document.cookie.indexOf(" ", i) + 1;
		if(i == 0){
			break}
	}
	return null
};

Cookies.clear = function(name){
	if(Cookies.get(name)){
		document.cookie=name+"="+"; expires=Thu, 01-Jan-70 00:00:01 GMT"
	}
};

Cookies.getCookieVal = function(offset){
	var endstr = document.cookie.indexOf(";", offset);
	if(endstr == -1){
		endstr = document.cookie.length
	}
	return unescape(document.cookie.substring(offset, endstr))
};

////////////////////////////////

/*
**********************************************************
Nombre de la clase:	    Boton(grid)
Propósito:				La definicion de filtro y sus parametros

Metodos                 ClearFilter() - > Limpiar el filtro
FilterGrid(obj) - > iniciar el proceso de filtraje


Fecha de Creación:		26 - 04 - 07
Versión:				3.0.0
Autor:					Rensi Arteaga Copari
**********************************************************
*/
function Boton(gridHead,id){

	//abre espacio en la cabecera del grid
	Ext.QuickTips.init();// activa los mensajes que salen al pasar el mouse sobre el boton
	//var gridHead=grid.getView().getHeaderPanel(true);
	var tb_new=new Ext.Toolbar(gridHead);
	var tb=new Ext.Toolbar(gridHead);


	//var sufijo_id_boton=grid.id;
	var botones=[];
	var menuBotones=[];
	var botones_new=[];
	var dividir_new;
	var tab_new;

	
	this.AdicionarMenuBotonSimple = function(config){
		var botonesMenu=[];
		var	parametros;
	
	
	
		 var mBoton =  new Ext.menu.Menu({
			   id:config.nombre+'-'+id,
		
	        })
		 
	    botones.push({boton:mBoton,id:config.nombre+'-'+id});
		 
		 tb.add({
	           // cls:config.cls, // icon and text class
			    cls: 'x-btn-text-icon bmenu', // icon and text class
			    icon:config.icon,
	            text:config.text, 
	            menu: mBoton  // assign menu by instance
	        })
	        
	        
	    for (var k=0 ; k < config.items.length;k++){
				
	    		parametros = new Ext.menu.Item(config.items[k])
	    			
	    		mBoton.add(parametros)	
	    		//addItem
                botones.push({boton:parametros,id:config.items[k].nombre+'-'+id});
	    		
	    				
	    		}
	    		    
	        
		 
		}
   
		
		
		this.AdicionarToggleBoton = function(config){
		var botonesMenu=[];
		var	parametros;
	
		var conf={ id:config.nombre+'-'+id,
	                text: 'Toggle Me',
	                enableToggle:true,
	                toggleHandler:function(){alert('sobrecagar toggleHandler')},
		            pressed:false     
	     
	             }
	    Ext.apply(conf,config) 
	             
	    parametros = new Ext.Toolbar.Button(conf)            
		 
	   botones.push({boton:parametros,id:conf.nombre+'-'+id});
	   tb.add('-', parametros)
	 
		}
	
	this.AdicionarBoton=function(url_imagen,titulo,funcion,dividir,nombre,text,tab){
		dividir_new=dividir;
		tab_new=tab;
		var parametros;
		if(text){
			parametros = new Ext.Toolbar.Button({
				icon: url_imagen,
				cls:'x-btn-text-icon bmenu',
				tooltip: titulo,
				handler : funcion,
				text:text
			})}
			else{
				parametros = new Ext.Toolbar.Button({
					icon: url_imagen,
					cls: 'x-btn-icon',
					tooltip: titulo,
					handler : funcion
				})
			}

			botones.push({boton:parametros,id:nombre+'-'+id});
			if(dividir){
				if(tab){
					tb.add('->','-', parametros)
				}
				else{
					tb.add('-', parametros)
				}
			}
			else{
				if(tab){
					tb.add('->',parametros)
				}
				else{
					tb.add(parametros)
				}
			}
	};
	
	
	this.AdicionarBotonCombo=function(combo,nombre){
		//dividir_new=dividir;
		//alert(nombre);
		botones.push({boton:combo,id:nombre+'-'+id});
				tb.addField(combo)
				
	};
	/*{
	cls: 'x-btn-text-icon bmenu', // icon and text class
	text:'Button w/ Menu',
	menu: menu  // assign menu by instance
	}*/
	this.EliminarBoton = function(nombre)
	{
		for(i=0;i<botones.length;i++)
		{
			if(botones[i].id !=nombre+'-'+id){

				botones_new.push(botones[i]);
				if(dividir_new){

					if(tab_new){
						tb_new.add('->','-', botones[i].boton);}
						else{
							tb_new.add( '-', botones[i].boton);
						}
				}
				else{
					if(tab_new){
						tb_new.add('->', botones[i].boton);
					}
					else{
						tb_new.add( botones[i].boton);
					}
				}

			}
		}

		botones=botones_new;
		tb=tb_new;
	};

	this.AdicionarMenuBoton = function(ds,config)
	{	 	this.MenuBotones=MenuBoton;

	botones.push({menuBoton:new this.MenuBotones(ds,config,tb),id:config.nombre+'-'+id});
	};


	this.getMenuBoton=function(id){
		var sw=false;

		for(var i=0;i<botones.length;i++){if(botones[i].id==id){sw=true;break}}
		return  sw?botones[i]:undefined
	};

	this.getBotonMenuBotonNombre = function(nombre){

		return  this.getMenuBoton(nombre+'-'+id)
	};
	this.getBoton=function(id){
		var sw=false;

		for(var i=0;i<botones.length;i++){if(botones[i].id==id){sw=true;break}}
		return  sw?botones[i].boton:undefined
	};
    


	this.getBotonNombre = function(nombre){
 

	  return  this.getBoton(nombre+'-'+id)
	};

	this.getBarra=function (){
		return tb
	};

	this.BloquearMenu=function(){

		for(var i=0;i<botones.length;i++){botones[i].boton.disable()}
	}
	this.DesbloquearMenu=function(){

		for(var i=0;i<botones.length;i++){botones[i].boton.enable()}

	}


}


function MenuBoton(ds,config,tb){

	this.selectAceptar;
	this.selectTodo;
	this.selectLimpiar;
	var menu;
	var botonMenu;
	var seleccionados = new Array();
	var seleccionadosDesc = new Array();
	var items  = new Array();


	menu = new Ext.menu.Menu({id: config.id_menu});
	//menu = new Ext.menu.Menu({id: 'mainMenu'});
	//menu.on('itemclick',config.funcion);
	 //alert(config.id_menu+"  lega ");
	menu.on('beforehide',config.funcion);

	
	
	
	this.llenaMenu=function(ds2,config2){
		items  = new Array();
		
		if(config.selectAceptar){selectAceptar= menu.add({id:config.id_menu+"_sel", text: 'Aceptar'});
		selectAceptar.on('click', onItemClickSelectAceptar);};
		if(config2.selectTodo){selectTodo = menu.add({id:config2.id_menu+"_todo",text: 'Selecionar Todo'});selectTodo.on('click', onItemClickSelecTodo)};
		if(config2.selectLimpiar){selectLimpiar = menu.add({id:config2.id_menu+"_ltodo",text: 'Limpiar Todo'});selectLimpiar.on('click', onItemClickSelecLimpiar);};
		if(config2.separador){menu.addSeparator()};
	
		 for(var i=0;i<ds2.data.length;i++){
	
			if(parseFloat(ds2.getAt(i).data[config2.id])<0){
				items.push(new Ext.menu.CheckItem({
					text: ds2.getAt(i).data[config2.descripcion],
					id:ds2.getAt(i).data[config2.id],
					cls: 'x-btn-icon',
					checked:false,
					checkHandler:onItemCheckEspecial,
					hideOnClick:false
					//canActivate:true
				}) );
			}
			else{
				items.push(new Ext.menu.CheckItem({
					text: ds2.getAt(i).data[config2.descripcion],
					id:ds2.getAt(i).data[config2.id],
					cls: 'x-btn-icon',
					checked:false,
					checkHandler: onItemCheck,
					hideOnClick:false
					//canActivate:true
				}) );
			}
	
			menu.addItem(items[i]);}; 
	}
	
	
	this.llenaMenu(ds,config);

//alert('llega menu '+config.id_menu+'_menu');
		botonMenu=new Ext.Toolbar.MenuButton(
		 {
			cls: 'x-btn-text-icon bmenu', // icon and text class
			text:config.nombre,
			menu:  menu, // assign menu by instance
		 id:config.id_menu+'_menu'
		});
		//tb.add('-', botonMenu);
		tb.add('-', botonMenu);
		
		function onItemCheck(item, checked){


			if(checked)	{
				for(var i=0;i<items.length;i++){
					if(parseFloat(items[i].id)<0){
						items[i].setChecked(false);}
				}
				seleccionados.push(item.id);
				seleccionadosDesc.push(" "+item.text)}
				else{ var seleccionadosAux= new Array();
				var seleccionadosAuxDesc= new Array();
				for(var i=0;i<seleccionados.length;i++)
				{	if(item.id!=seleccionados[i])
				{seleccionadosAux.push(seleccionados[i]);
				seleccionadosAuxDesc.push(seleccionadosDesc[i])
				}
				}
				seleccionados=	seleccionadosAux;
				seleccionadosDesc=	seleccionadosAuxDesc;
				}
		}
		/****************/
		function onItemCheckEspecial(item, checked){

			if(checked)	{
				for(var i=0;i<items.length;i++){
					if(item.id!=items[i].id){
						items[i].setChecked(false);}
				}
				seleccionados.push(item.id);
				seleccionadosDesc.push(" "+item.text)}
				else{ var seleccionadosAux= new Array();
				var seleccionadosAuxDesc= new Array();
				for(var i=0;i<seleccionados.length;i++)
				{	if(item.id!=seleccionados[i])
				{seleccionadosAux.push(seleccionados[i]);
				seleccionadosAuxDesc.push(seleccionadosDesc[i])
				}
				}
				seleccionados=	seleccionadosAux;
				seleccionadosDesc=	seleccionadosAuxDesc;
				}

		}

		/*****************/
		this.getSelecion = function(){return seleccionados.toString()};
		this.getSeleccionadosDesc = function(){return seleccionadosDesc.toString()};
		function onItemClickSelectAceptar(item){};
		function onItemClickSelecTodo(item){for(var i=0;i<items.length;i++){if(parseFloat(items[i].id)>=0){items[i].setChecked(true)}}};
		function onItemClickSelecLimpiar(item){for(var i=0;i<items.length;i++){items[i].setChecked(false)}};

		this.menu=menu


}

/* FUNCION EQUIVALENTE A   --------  $  ------------ de prototype*/
function $(el){
	return document.getElementById(el)
}


/**
*  Nombre función:	redondear
*  Propósito:		Redondear un número real a una cantidad definida de decimales
*  Fecha creación:	06-07-2007
*  Autor:			Rodrigo Chumacero Moscoso
*
*  Variables de entrada:   cantidad     número real
*						   decimales	número entero
*  Salida:				   número real
*/

function redondear(cantidad, decimales){
	var cantidad = parseFloat(cantidad);
	var decimales = parseFloat(decimales);
	decimales = (!decimales ? 2 : decimales);
	return Math.round(cantidad * Math.pow(10, decimales)) / Math.pow(10, decimales);
}

/*
****************************************************************************************************
Nombre de la funcion:	    ProcesoQS
Propósito:				Ordenacion de un Array por el metodo quick sort
Versión:				1.0.0
Autor:					Rensi  Arteaga Copari
****************************************************************************************************
*/
function quickSort(objArray,aod) {
	procesoQS(objArray,aod,0,objArray.length-1)
}

function procesoQS(objArray,aod,ini,fin){
	var i=ini;
	var j=fin;
	var tmp;
	var c=objArray[Math.floor((i+j)/2)];
	do{
		if(aod=="A"){
			while((i<fin)&&(c>objArray[i]))i++;
			while((j>ini)&&(c<objArray[j]))j--

		}else{
			while((i<fin)&&(c<objArray[i]))i++;
			while((j>ini)&&(c>objArray[j]))j--
		}
		if(i<j){
			tmp = objArray[i];
			objArray[i] = objArray[j];
			objArray[j] = tmp
		}
		if(i<= j){
			i++;
			j--
		}
	}
	while(i<=j);
	if(ini<j){procesoQS(objArray,aod,ini,j)}
	if(i<fin){procesoQS(objArray,aod,i,fin)}
}