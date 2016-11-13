Ext.form.ClearableTriggerField = function(config){
    Ext.form.ClearableTriggerField.superclass.constructor.call(this, config);
};

Ext.extend(Ext.form.ClearableTriggerField, Ext.form.TriggerField, {
    hideClearButton:true,

    setSize : function(w, h){
	Ext.form.ClearableTriggerField.superclass.setSize.call(this, w, h);
	var bias = 0;
	if (this.trigger){
	    bias += this.hideTrigger && 0 || this.trigger.getWidth();
	}
	if (this.clearButton){
	    bias += this.hideClearButton && 0 || this.clearButton.getWidth();
	}
	if(w){
	    var wrapWidth = w;
	    w = w - bias;
	    Ext.form.ClearableTriggerField.superclass.setSize.call(this, w, h);
	}else{
	    Ext.form.ClearableTriggerField.superclass.setSize.call(this, w, h);
	    this.wrap.setWidth(this.el.getWidth()+bias);
	}
    },
    
    onRender : function(ct){
	Ext.form.ClearableTriggerField.superclass.onRender.call(this, ct);
	//this.clearWrap = this.el.wrap({cls: "x-form-field-wrap"});
	this.clearButton = this.wrap.createChild({
	    tag: "img", src: Ext.BLANK_IMAGE_URL, cls: "x-form-clearbutton"
	});
	this.clearButton.on("click", this.onClearButtonClick, this, {preventDefault:true});
	this.clearButton.addClassOnOver('x-form-clearbutton-over');
	this.clearButton.addClassOnClick('x-form-clearbutton-click');
	if(this.hideClearButton){
	    this.clearButton.setDisplayed(false);
	}
	this.setSize(this.width||'', this.height||'');
    },
    
    onDestroy : function(){
	if(this.clearButton){
	    this.clearButton.removeAllListeners();
	    this.clearButton.remove();
	}
	if(this.clearWrap){
	    this.clearWrap.remove();
	}
	Ext.form.ClearableTriggerField.superclass.onDestroy.call(this);
    },
    
    onFocus : function(){
	Ext.form.ClearableTriggerField.superclass.onFocus.call(this);
    },
    
    onShow : function(){
	if(this.clearWrap){
	    this.clearWrap.dom.style.display = '';
	    this.clearWrap.dom.style.visibility = 'visible';
	}
    },
    
    onHide : function(){
	this.clearWrap.dom.style.display = 'none';
    },

    onClearButtonClick : Ext.emptyFn,
    
    eoext: function(){}
});
