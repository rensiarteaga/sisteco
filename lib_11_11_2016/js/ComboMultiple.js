



Ext.form.ComboMultiple = function(config){
    Ext.form.ComboMultiple.superclass.constructor.call(this, config);
};

Ext.extend(Ext.form.ComboMultiple, Ext.form.ComboBox,{

	    displayField:'title',
	    selectOnFocus:false,
        typeAhead: false,
        forceSelection:false,
        loadingText:'buscando...',
        width:'100',
        height:'100',
        pageSize:50,
        editable:true,
        hideTrigger:false,
        type:'area',
        acumulador:'',
  
   select : function(index, scrollIntoView){
   	
   Ext.form.ComboMultiple.superclass.select.call(this, index, scrollIntoView);
   
 
   
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
    	 
         Ext.form.ComboMultiple.superclass.onRender.call(this,ct, position); 
    },
    
   onSelect: function(record, index){
     	
    
     	
        if(this.fireEvent('beforeselect', this, record, index) !== false){
        	
            this.setValue(record.data[this.valueField || this.displayField]);
            
            this.collapse();
            
            this.fireEvent('select', this, record, index);
                        
            
        }
    },
    
     doQuery : function(q, forceAll){
    	
    	var filtro =  q.split(',');

     	
    	var _fil = Ext.util.Format.trim(filtro[filtro.length-1])
    	
    	
    	var tmp_acu='';
    	
        for(var k=0; k<filtro.length -1 ;k++){
    	  
        	if(k==0){
        		
        	tmp_acu = filtro[k];	
        	}
        	else{
        	tmp_acu = tmp_acu + ', ' + filtro[k];
        	}
    	  
    	}
    	 
    	this.acumulador = tmp_acu;
    	//console.log('for acumulador -> ', this.acumulador)
    	Ext.form.ComboMultiple.superclass.doQuery.call(this,_fil,forceAll); 
    	
    },
     defValor:function(val,rec){
    	return val
    },
      
     setValue : function(v){

		    var text = v;
		    var text_final;

      if(this.valueField){
            var r = this.findRecord(this.valueField, v);
            if(r){
                
            	text = r.data[this.displayField];
            	text=this.defValor(text,r.data);
            
            }else if(this.valueNotFoundText !== undefined){
            
            	text = this.valueNotFoundText;
            
            }
        }
        
        if(v !== undefined){
        
		        if(this.getRawValue()!='' &&  this.acumulador){
		            
		        	text_final=this.acumulador +', '+text;
		        	
		        }
		        else{
		           text_final= text;	
		        }
		        
		  }
        else{
        	
        	text_final=''
        }
        
        
        this.acumulador = text_final
        this.lastSelectionText = text_final;
        
        if(this.hiddenField){
            this.hiddenField.value = text_final;
        }
        
        Ext.form.ComboBox.superclass.setValue.call(this,text_final);
        
        this.value = text_final;
    },

    getValue : function(){
    
      //  if(this.valueField){
       //     return typeof this.value != 'undefined' ? this.value : '';
       // }else{
            return Ext.form.ComboBox.superclass.getValue.call(this);
       // }
    }
    
        
        
        
})