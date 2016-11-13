



Ext.form.ComboTrigger=function(config){
    Ext.form.ComboMultiple.superclass.constructor.call(this, config);
    
    
    this.triggerConfig={
				tag:'span', cls:'x-form-twin-triggers', style:'padding-right:2px',  
				cn:[{tag: "img", src: Ext.BLANK_IMAGE_URL, cls: "x-form-trigger",style:""},
				    {tag: "img", src: Ext.BLANK_IMAGE_URL, cls: "x-form-trigger x-form-search-trigger",style:""}
				]}
    
    
};

Ext.extend(Ext.form.ComboTrigger, Ext.form.ComboBox,{
	
	triggerClass:'x-form-search-trigger',
	venTrigguer:{
					modal:true,
					width:600,
					height:400,
					shadow:true,
					minWidth:300,
					minHeight:300,
					proxyDrag:true
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
	             } ,
	             
	             
	onTrigger1Click:function(){this.onTriggerClick()},   // pass to original combobox trigger handler

	onTrigger2Click:function(){
		if(!this.disabled){
			this.collapse();
			
			if(this.confTrigguer){
				
				
				
				
					_CP.loadWindows(this.confTrigguer.url+'?'+this.paramTri,this.confTrigguer.title,this.confTrigguer.param,this.confTrigguer.idContenedor,this.confTrigguer.clase_vista);
			}
			
		}
	} 
        
        

        
        
})