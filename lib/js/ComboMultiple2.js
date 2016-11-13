Ext.form.ComboMultiple2 = function(config){
   this.triggerConfig = {
       tag:'span', cls:'x-form-twin-triggers', style:'padding-right:2px',  // padding needed to prevent IE from clipping 2nd trigger button
       cn:[{tag: "img", src: Ext.BLANK_IMAGE_URL, cls: "x-form-trigger", style:config.hideComboTrigger?"display:none":""},
           {tag: "img", src: Ext.BLANK_IMAGE_URL, cls: "x-form-trigger x-form-clear-trigger", style: config.hideClearTrigger?"display:none":""}
    ]};
	Ext.form.ComboMultiple2.superclass.constructor.call(this, config);
};

Ext.extend(Ext.form.ComboMultiple2, Ext.form.ComboBox,{
	    displayField:'title',
	    selectOnFocus:false,
        typeAhead: false,
        forceSelection:false,
       	grow:true,
        loadingText:'buscando...',
        width:'100',
        height:'100',
        pageSize:50,
        editable:true,
        hideTrigger:false,
        // hideClearButton: false,
        type:'area',
        acumulador:'',
        valor_final:'',
        triggerClass:'x-form-search-trigger',
        select : function(index, scrollIntoView){
   	        Ext.form.ComboMultiple2.superclass.select.call(this, index, scrollIntoView);
        },
       onRender : function(ct, position){
     	var divFrom;
         if(!this.el){
            this.defaultAutoCreate = {
                tag: "textarea",
                style:"width:"+this.width+";height:"+this.height+";",
                autocomplete: "off"
            };
         }
    	 
         Ext.form.ComboMultiple2.superclass.onRender.call(this,ct, position); 
    },
    
   onSelect: function(record, index){
      if(this.fireEvent('beforeselect', this, record, index) !== false){
            this.setValue(record.data[this.valueField || this.displayField]);
            this.collapse();
            this.fireEvent('select', this, record, index);
       }
    },
    
     doQuery : function(q, forceAll){
     	
     	var filtro =  this.getRawValue().split(',');
    	var _fil = Ext.util.Format.trim(filtro[filtro.length-1]);
    	var tmp_acu='';

    	for(var k=0; k<filtro.length -1 ;k++){
    	  if(k==0){
        		tmp_acu = filtro[k]+ ', ';	
        	}
        	else{
        	    tmp_acu = tmp_acu + filtro[k]+ ', ';
        	}
    	}
    	this.acumulador = tmp_acu;
    	Ext.form.ComboMultiple2.superclass.doQuery.call(this,_fil,forceAll); 
    },
     defValor:function(val,rec){
    	return val
    },
    setValue : function(v, valVis){
     	 var text = v,ext_final,valor;
     	if(valVis==undefined){
    	      if(this.valueField){
		            var r = this.findRecord(this.valueField, v);
		            if(r){                
		            	text = r.data[this.displayField];
		            	valor = r.data[this.valueField];
		            	text=this.defValor(text,r.data);
		            
		            }else if(this.valueNotFoundText !== undefined){            
		            	text = this.valueNotFoundText;
		            	valor=undefined;            
		            }
		        }
		        
		        if(v != undefined && v!=''){        
				        if(this.getRawValue()!='' &&  this.acumulador){		            
				        	text_final=this.acumulador+text+',';		        	
				        	this.valor_final=this.valor_final+','+valor		        	
				        }
				        else{		        	
				           text_final= text+',';	
				           this.valor_final=valor
				        }		        
				  }
		        else{       	
		        	text_final=''
		        }
		        this.acumulador = text_final;
		        this.lastSelectionText = text_final;
		        if(this.hiddenField){
		            this.hiddenField.value = this.valor_final;
		        }
		        Ext.form.ComboMultiple2.superclass.setValue.call(this,text_final);        
		       
		        if(this.returnText){
		        	this.value = text_final;
		        }
		        else{		        
		            this.value = this.valor_final;
		        }
     }
     else{
     
     	this.acumulador=valVis;
     	this.lastSelectionText=valVis;
     	 if(this.hiddenField){
		            this.hiddenField.value = this.v;
		        }
     	Ext.form.ComboMultiple2.superclass.setValue.call(this,valVis);

     	if(v != undefined && v!=''){ 

     		this.value = v;
     	    this.valor_final=v      

     			        
		 }else{
		 	this.value = '';
     	    this.valor_final='';
		}
     	 
     	
     	
     }

    },
    getValue : function(){    
           return Ext.form.ComboMultiple2.superclass.getValue.call(this);
   },
    getTrigger : function(index){
		return this.triggers[index];
	},
   initTrigger:function(){
        var ts = this.trigger.select('.x-form-trigger', true);
        this.wrap.setStyle('overflow', 'hidden');
        var triggerField = this;
        ts.each(function(t, all, index){
            t.hide = function(){
                var w = triggerField.wrap.getWidth();
                this.dom.style.display = 'none';
                triggerField.el.setWidth(w-triggerField.trigger.getWidth());
            };
            t.show = function(){
                var w = triggerField.wrap.getWidth();
                this.dom.style.display = '';
                triggerField.el.setWidth(w-triggerField.trigger.getWidth());
            };
            var triggerIndex = 'Trigger'+(index+1);

            if(this['hide'+triggerIndex]){
                t.dom.style.display = 'none';
            }
            t.on("click", this['on'+triggerIndex+'Click'], this, {preventDefault:true});
            t.addClassOnOver('x-form-trigger-over');
            t.addClassOnClick('x-form-trigger-click');
        }, this);
        this.triggers = ts.elements;
    },
    
     onTrigger1Click:function(){
     	this.onTriggerClick()
     
     },   // pass to original combobox trigger handler
	onTrigger2Click:function(){
		  Ext.form.ComboMultiple2.superclass.clearValue.call(this);
		  
		  
		  //this.acumulador=valVis;
     	//this.lastSelectionText=valVis;
     	 if(this.hiddenField){
		            this.hiddenField.value=undefined;
		        }
     	
     	this.value = undefined;
     	this.valor_final=undefined
     	this.fireEvent('valueChange',"");
		  
		  
		  
		}     
})