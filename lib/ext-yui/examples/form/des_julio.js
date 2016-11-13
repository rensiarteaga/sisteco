/*
 * Ext JS Library 1.1.1
 * Copyright(c) 2006-2007, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://www.extjs.com/license
 */
//<script>

function main(){
var comboOption;
	Ext.QuickTips.init();
var showBtn;
    // turn on validation errors beside the field globally
    Ext.form.Field.prototype.msgTarget = 'side';
  
    
  Ext.state.Manager.setProvider(new Ext.state.CookieProvider());
  
    Ext.namespace('Ext.tipo_presupuesto_combo');

   Ext.tipo_presupuesto_combo.combo= [
       
        ['1', 'General'],
        ['2', 'Seleción']
        ];   
 var form = new Ext.form.Form({
        labelAlign: 'right',
        labelWidth: 75
    });
/*creando el combo**/    
comboOption=	new Ext.form.ComboBox({
            fieldLabel: 'Opciones ',
            hiddenName:'Opciones',
            store: new Ext.data.SimpleStore({
                fields: ['ID', 'valor'],
                data : Ext.tipo_presupuesto_combo.combo // from states.js
            }),
            valueField:'ID',
           	displayField:'valor',
            typeAhead: true,
            mode: 'local',
            triggerAction: 'all',
            emptyText:'Opciones...',
            selectOnFocus:true,
            width:190
        })
/*introduciendo un evento al combo*/        
comboOption.on('select',selecionOtion);
		comboOption.on('change',selecionOtion);
/*creando un field set */      
 form.fieldset(
        {legend:'Selecione ', hideLabels:true} 
      );
/*añadiendo al formulario*/      
    form.add(comboOption);          
   form.end();    
 /*creando el menu  */
 var menu = new Ext.menu.Menu({
        id: 'mainMenu',
        items: [
            new Ext.menu.CheckItem({
                text: 'I like Ext',
                checked: true,
                checkHandler: onItemCheck
            }),
            new Ext.menu.CheckItem({
                text: 'Ext for jQuery',
                checked: true,
                checkHandler: onItemCheck
            }),
            new Ext.menu.CheckItem({
                text: 'I donated!',
                checked:false,
                checkHandler: onItemCheck
            })
        ]
    });
    
      form.add({legend:'Ceckbox  ', hideLabels:true},
      		new Ext.Toolbar.MenuButton({
            cls: 'x-btn-text-icon bmenu', // icon and text class
            text:'Button w/ Menu',
            menu: menu  // assign menu by instance
        })); 
    form.applyIfToFields({
        width:230
    });

 
     

   
/************/
            
   var ds_fuente_financiamiento = new Ext.data.Store(
   {proxy: new Ext.data.HttpProxy({url: '../../../../sis_presupuesto/control/fuente_financiamiento/ActionListarFuenteFinanciamiento.php'}),
	reader:new Ext.data.XmlReader(
	{record:'ROWS',id:'id_fuente_financiamiento',totalRecords: 'TotalCount'},
	['id_fuente_financiamiento','codigo_fuente','denominacion','descripcion','sigla'])
	,remoteSort:true});
 
	ds_fuente_financiamiento.load({
		params:{
			start:0,
			limit: 10000,
			CantFiltros:1
		},
	callback:ret
	});
	
	
	function  ret(r,option,success){
		var prueba=new componenteSelecion(ds_fuente_financiamiento,form);
	}
	function  selecionOtion(){
		alert("llega pinche boton");
		var prueba=new componenteSelecion(ds_fuente_financiamiento,form);
		form=form.reset();
		
		
	};
 function onItemCheck(item, checked){
        Ext.example.msg('Item Check', 'You {1} the "{0}" menu item.', item.text, checked ? 'checked' : 'unchecked');
    };	
function showResult(){};
/****************/
}
Ext.onReady(main,main);	
    
/************/
  
