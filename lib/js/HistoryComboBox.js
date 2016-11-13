Ext.form.HistoryComboBox = function(config) {
    Ext.form.HistoryComboBox.superclass.constructor.call(this, config);
    this.addEvents({
	valueChange : true
    });

    this.store = new Ext.data.SimpleStore({
        fields: ['query'],
	data: []
    });

    this.historyRecord = Ext.data.Record.create([
        {name: 'query', type: 'string'}
    ]);
};

Ext.extend(Ext.form.HistoryComboBox, Ext.form.ClearableComboBox, {
    store: undefined,
    displayField: 'query',
    typeAhead: false,
    mode: 'local',
    triggerAction: 'all',
    hideTrigger: false,
    hideClearButton: false,
    dummyData: false,
    
    historyRecord: undefined,
    maxInHistory: 10,
    rememberOn: 'enter',
    rememberDelay: 1000,
    
    forceSelection: false,
    
    clearClass: 'x-form-clear',

    onRender: function(ct) {
	Ext.form.HistoryComboBox.superclass.onRender.call(this, ct);
	if (this.dummyData==true) {
	    this.store.add(new this.historyRecord({query: "protein"}));
	    this.store.add(new this.historyRecord({query: "toxin"}));
	    this.store.add(new this.historyRecord({query: "foo"}));
	    this.store.add(new this.historyRecord({query: "bar"}));
	}
    },
    
    
    initEvents : function() {
	Ext.form.HistoryComboBox.superclass.initEvents.call(this);
	this.el.on("keyup", this.onHistoryKeyUp, this);
	if (this.rememberOn=="delay") {
	    this.el.on("keyup", this.onTypingStopped, this, {buffer: this.rememberDelay});
	}
    },

    pruneHistory : function(){
    	if (this.store.getCount()>this.maxInHistory) {
            var ssc = this.store.getCount();
            var overflow = this.store.getRange(ssc-(ssc-this.maxInHistory), ssc);
            for (var i=0; i<overflow.length; i++) {
                this.store.remove(overflow[i]);
            }
        }
    },

    historyChange : function(value) {
    	    var value = this.getValue().replace(/^\s+|\s+$/g, "");
    	    if (value.length==0)
		return;
            this.store.clearFilter();
            var vr_insert = true;
	    // TODO: hate this solution, clean and fix this
	    if (this.rememberOn=="all") {
        	this.store.each(function(r) {
            	    if (r.data['query'].indexOf(value)==0) {
            	        // backspace
            	        vr_insert = false;
            	        return false;
            	    } else if (value.indexOf(r.data['query'])==0) {
            	        // forward typing
                	this.store.remove(r);
            	    }
        	});
	    }
            if (vr_insert==true) {
                this.store.each(function(r) {
                    if (r.data['query']==value) {
                        vr_insert = false;
                    }
                });
            }
            if (vr_insert==true) {
                var vr = new this.historyRecord({query: value});
                this.store.insert(0, vr);
		this.pruneHistory();
            }
    },
    
    onHistoryKeyUp : function(e) {
	var keycode = e.getKey();
	/*
	if (keycode==8 && this.isExpanded() && this.getValue()=="") {
	    // hit backspace when expanded and without value
	    this.store.clearFilter();
	    this.collapse();
	} else if (keycode==38 || keycode==40) {
	    // arrow up and arrow down
	    this.expand();
	}*/
	
	if ( (this.rememberOn=="enter" && keycode==13) ||
	     (this.rememberOn=="all") ) {
	    this.historyChange(this.getValue());
	    this.fireEvent('valueChange', this.getValue());
	} else if (this.rememberOn=="delay") {
	    this.fireEvent('valueChange', this.getValue());
	}
	return true;
    },

    onTypingStopped : function(e) {
    	var value = this.getValue().replace(/^\s+|\s+$/g, "");
    	if(value.length==0){
	    return;
	}
        this.store.clearFilter();
	var record = this.store.data.find(function(item, key){
	    return (item.data.query==value);
	});
	if(record==null){
	    this.store.insert(0, new this.historyRecord({query: value}));
	    this.pruneHistory();
	}
    },
        
    setValue : function(v) {
	Ext.form.HistoryComboBox.superclass.setValue.call(this, v);
	this.fireEvent('valueChange', this.getValue());
    },
    
    clearValue : function(){
	Ext.form.HistoryComboBox.superclass.clearValue.call(this);
	this.fireEvent('valueChange', "");
    },
    
    EOJ : function(){}
});