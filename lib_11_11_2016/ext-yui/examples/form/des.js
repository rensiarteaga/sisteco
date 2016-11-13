/*
 * Ext JS Library 1.1.1
 * Copyright(c) 2006-2007, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://www.extjs.com/license
 */

function componenteSelecion(ds,form){
	 
	var checkBox=new Array;
	var id_checkBox= new Array;
	var codigo_checkBox= new Array;
	var sigla_checkBox= new Array;
    Ext.QuickTips.init();

    // turn on validation errors beside the field globally
    Ext.form.Field.prototype.msgTarget = 'side';
  Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
      
 
    
    form.fieldset(
        {legend:'Seleccione las Fuentes de Financiamiento', hideLabels:true} 
      );

    
    	for(var i=0;i<ds.data.length;i++){
		checkBox[i]={
			
			id:ds.getAt(i).data['id_fuente_financiamiento'],
			codigo:ds.getAt(i).data['codigo_fuente'],
			sigla:ds.getAt(i).data['sigla'],
			
			checkbox_object : new Ext.form.Checkbox({
            boxLabel:ds.getAt(i).data['denominacion'],
            name:'extteam',
            checked:false,	
            width:'auto'
        	})
		};
		form.add(checkBox[i].checkbox_object);
    	};
 form.end(); 
 
     form.addButton('Cargar').on('click',showResult );
    form.addButton('Cancel');
    form.render('form-ct4');
    form.reset();
    
function showResult(){
var h;
	h=0;	
clearCheckBox();
    	for(var i=0;i<ds.data.length;i++){
			
    		if(checkBox[i].checkbox_object.checked){
			
			id_checkBox[h]=checkBox[i].id;			
			codigo_checkBox[h]= checkBox[i].codigo;
			sigla_checkBox[h]= checkBox[i].sigla;
			h++;
		}
        
    	};
       	
	alert(id_checkBox.toString());
								
	}
	function clearCheckBox()
	{
		id_checkBox=new Array;
	}
 
  	
};
   