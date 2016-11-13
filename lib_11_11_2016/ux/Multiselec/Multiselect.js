//
// Ext.ux.Multiselect/ItemSelector
// 
// ---------------------------------------------------------------------------------------
// Version History
// ---------------------------------------------------------------------------------------
//
// 2.2      Changes                      30 Oct 2007             Figtree Systems
//                                                               vtswingkid/Valcom Inc.
//                                                               paran01d/Grox Pty Ltd                                                                            
//         Fixes/Enhancements
//          - General
//            - can now add toolbars to Multiselect and ItemSelector lists
//            - can now change the delimiter for getValue()
//            - fieldset and legend support
//          - ItemSelector
//            - optional 'clear' button for selected list
//            - support for local sorting of the available and selected lists
//            - can now change the path for the navigation icons
//            - can now choose which navigation icons to display
//            - added 'change' and 'rowdblclick' events
//            - support for duplication in the selected list
//          - DDView
//            - modified to allow duplication
//
// 2.1     Fixes                                     27 Sept 2007          Figtree Systems 
//          - General
//            - draggable now spelt correctly in all places :)
//            - Queries to the store in setValue now match whole value correctly 
//              (rather than partial match)
//          - ItemSelector
//            - value now initialised onRender
//
// 2.0     Fixes/Enhancements                        19 Sept 2007          Figtree Systems
//          - General
//            - Now uses Animal's DDView
//          - ItemSelector
//            - Move to top/bottom navigation buttons
//            - When using navigation buttons items remain selected in destination list
//          - Multiselect
//            - Border dropped when marked invalid for better visuals (less jumping/popping)
//            - Validation for blank, min length and max length
//            - Ext.form.Field.getName() now returns correct name
//
// 1.3     Fixes/Enhancements                        24 Aug  2007          Figtree Systems
//          - Multiselect now clears when underlying datastore is cleared
//          - New silver (more Ext'ish) arrow buttons (thanks Galdaka)
//
// 1.2     Enhancements                              23 Aug  2007          Figtree Systems
//          - Added ItemSelector (beta)
// 
// 1.1     Fixes/Enhancements                        16 Aug  2007          Figtree Systems
//          - Can now bind to external data store
//          - List items are now unselectable (prevents text highlight/selection)
//          - Enabled/disabled now works correctly
//          - Reset now properly clears selections
//          - Click and Change events added 
// 
// 1.0     Release                                   14 Aug  2007          Figtree Systems
//
//

Ext.namespace("Ext.ux");


/**
 * @class Ext.ux.Multiselect
 * Ext implementation of the traditional HTML select/multiple widget
 * @param {Object} config The configuration properties. These include all the config options of
 * {@link Ext.form.Field} plus some specific to this class.<br>
 * 
 */

Ext.form.Multiselect = function(config){
	Ext.form.Multiselect.superclass.constructor.call(this, config);

	this.addEvents({
		'dblclick' : true,
		'click' : true,
		'change' : true,
		'drop' : true
	});
	
	this.on('valid', this.onValid);
	this.on('invalid', this.onInvalid);

};

Ext.extend(Ext.form.Multiselect, Ext.form.Field,  {
		
	store             :  null,
	dataFields        :  [],
	data              :  [],
	width             :  100,
	height            :  100,
	displayField      :  0,
	valueField        :  1,
	allowBlank        :  true,
	minLength         :  0,
	maxLength         :  Number.MAX_VALUE,
	blankText         :  Ext.form.TextField.prototype.blankText,
	minLengthText     : 'Minimum {0} item(s) required',
	maxLengthText     : 'Maximum {0} item(s) allowed',
	isFormField       :  true,
	copy              :  false,
	allowDup          :  false,
	enableToolbar     :  false,
	focusClass        :  undefined,
	delimiter         :  ',',
	legend            :  null,
	view              :  null,
	draggable         :  false,
	defaultAutoCreate :  {tag: "input", type: "hidden", value: ""},
    
    
    
	onRender : function(ct, position) {

		var fs, div, cls, lw, lh, toolbardiv, tpl;
	
		this.el = ct.createChild(); 
		this.el.dom.style.zoom = 1;
		this.el.addClass(this.fieldCls);
		this.el.setWidth(this.width);
		this.el.setHeight(this.height);
	
		if (this.legend && this.legend.length) {
			fs = new Ext.form.FieldSet({legend:this.legend, labelHide:true});
			fs.render(this.el);
			div = fs.getEl();
		} else {
			div = this.el.createChild({tag: div});
		}

		if (!this.store) {
			this.store = new Ext.data.SimpleStore({
				fields: this.dataFields,
				data : this.data
			});
		}
		
		this.store.on('clear', this.reset, this);
			
		cls = 'x-combo-list';
		
		this.list = new Ext.Layer({
			shadow: false, cls: [cls, 'ux-mselect-valid'].join(' '), constrain:false
		}, div);
		
		lw = this.width - this.el.getFrameWidth('lr');
		lh = this.height - this.el.getFrameWidth('tb');

		this.list.setWidth(lw);
		this.list.setHeight(lh);
		this.list.swallowEvent('mousewheel');

		if (fs) {
			lh = lh - 15;
			if (Ext.isIE7 || Ext.isIE) { lh = lh - 10; }
		}
		
		if(this.enableToolbar){
			toolbardiv = this.list.createChild({tag:'div'});
			this.toolbar=new Ext.Toolbar(toolbardiv);
			lh = lh - 27;
		}
		
		this.innerList = this.list.createChild({tag: 'div', cls: cls + '-inner'});
		this.innerList.setWidth(lw - this.list.getFrameWidth('lr'));
		this.innerList.setHeight(lh - this.list.getFrameWidth('tb'));
				
		if (Ext.isIE || Ext.isIE7) {
			tpl = '<div unselectable=on class="' + cls + '-item ux-mselect-pointer">{' + this.displayField + '}</div>';
		} else {
			tpl = '<div class="' + cls + '-item ux-mselect-pointer x-unselectable">{' + this.displayField + '}</div>';
		}

		if (this.draggable) {
			this.view = new Ext.ux.DDView(this.innerList, tpl, {
				multiSelect: true, store: this.store, selectedClass: 'x-combo-selected'
				, allowDup:this.allowDup, copy: this.copy, allowCopy: false, dragGroup: this.dragGroup, dropGroup: this.dragGroup, jsonRoot: 'collection'
			});
		} else {
			this.view = new Ext.ux.DDView(this.innerList, tpl, {
				multiSelect: true, store: this.store, selectedClass: 'x-combo-selected'
			});			
		}
		this.view.on('drop', function(ddView, n, dd, e, data, r){
	    	return this.fireEvent("drop", ddView, n, dd, e, data, r);
		}, this);
		
		this.view.on('click', this.onViewClick, this);
		this.view.on('beforeClick', this.onViewBeforeClick, this);
		this.view.on('dblclick', this.onViewDblClick, this);
		
		this.list.setStyle('position', '');
		this.list.show();
		
		this.hiddenName = this.name;
		this.defaultAutoCreate.name = this.name;
		if (this.isFormField) { 
			this.hiddenField = this.el.createChild(this.defaultAutoCreate);
		} else {
			this.hiddenField = Ext.get(document.body).createChild(this.defaultAutoCreate);
		}
	},

	onViewClick: function(vw, index, node, e) {
		var arrayIndex = this.preClickSelections.indexOf(index);
		if (arrayIndex  != -1)
		{
			this.preClickSelections.splice(arrayIndex, 1);
			this.view.clearSelections(true);
			this.view.select(this.preClickSelections);
		}
		this.fireEvent('change', this, this.getValue(), this.hiddenField.dom.value);
		this.hiddenField.dom.value = this.getValue();
		this.fireEvent('click', this, e);
		this.validate();
		
	},

	onViewBeforeClick: function(vw, index, node, e) {
		this.preClickSelections = this.view.getSelectedIndexes();
		if (this.disabled) {return false;}
	},

	onViewDblClick : function(vw, index, node, e) {
		return this.fireEvent('dblclick', vw, index, node, e);
	},

	getValue: function(valueField){
		var returnArray = [];
		var selectionsArray = this.view.getSelectedIndexes();
		if (selectionsArray.length == 0) {return '';}
		for (var i=0; i<selectionsArray.length; i++) {
			returnArray.push(this.store.getAt(selectionsArray[i]).get(((valueField != null)? valueField : this.valueField)));
		}
		return returnArray.join(this.delimiter);
	},

	setValue: function(values) {
		var index;
		var selections = [];
		this.view.clearSelections();
		this.hiddenField.dom.value = '';
		
		if (!values || (values == '')) { return; }
		
		if (!(values instanceof Array)) { values = values.split(this.delimiter); }
		for (var i=0; i<values.length; i++) {
			index = this.view.store.indexOf(this.view.store.query(this.valueField, 
				new RegExp('^' + values[i] + '$', "i")).itemAt(0));
			selections.push(index);
		}
		this.view.select(selections);
		this.hiddenField.dom.value = this.getValue();
		this.validate();
	},
	
	reset : function() {
		this.setValue('');
	},
	
	getRawValue: function(valueField) {
        var tmp = this.getValue(valueField);
        if (tmp.length) {
            tmp = tmp.split(this.delimiter);
        }
        else{
            tmp = [];
        }
        return tmp;
    },

    setRawValue: function(values){
        setValue(values);
    },

    validateValue : function(value){
        if (value.length < 1) { // if it has no value
             if (this.allowBlank) {
                 this.clearInvalid();
                 return true;
             } else {
                 this.markInvalid(this.blankText);
                 return false;
             }
        }
        if (value.length < this.minLength) {
            this.markInvalid(String.format(this.minLengthText, this.minLength));
            return false;
        }
        if (value.length > this.maxLength) {
            this.markInvalid(String.format(this.maxLengthText, this.maxLength));
            return false;
        }
        return true;
    },
	
	onValid : function() {
		this.list.addClass('ux-mselect-valid');
		this.list.removeClass('ux-mselect-invalid');
	},
	
	onInvalid : function() {
		this.list.addClass('ux-mselect-invalid');
		this.list.removeClass('ux-mselect-valid');
	}
});



/**
 * @class Ext.ux.ItemSelector
 * Ext implementation of widget that allows moving items from an "available" list to a "selected" list 
 * and vice-versa. Uses Ext.ux.Multiselect for the available and selected lists.
 * @param {Object} config The configuration properties. These include all the config options of
 * {@link Ext.form.Field} plus some specific to this class.<br>
 * 
 */

Ext.ux.ItemSelector = function(config) {
	Ext.ux.ItemSelector.superclass.constructor.call(this, config);
	this.addEvents({
		'rowdblclick' : true,
		'change' : true
	});	
}

Ext.extend(Ext.ux.ItemSelector, Ext.form.Field, {
	
	msWidth      : 200,
	msHeight     : 300,
	hideNavIcons : false,
	imagePath    : "",
	iconUp       : "up2.gif",
	iconDown     : "down2.gif",
	iconLeft     : "left2.gif",
	iconRight    : "right2.gif",
	iconTop      : "top2.gif",
	iconBottom   : "bottom2.gif",
	drawUpIcon   : true,
	drawDownIcon : true,
	drawLeftIcon : true,
	drawRightIcon: true,
	drawTopIcon  : true,
	drawBotIcon  : true,
	fromStore    : null,
	toStore      : null,
	fromData     : null, 
	toData       : null,
	displayField :  0,
	valueField   :  1,
	switchToFrom : false,
	allowDup     : false,
	enableToolbar: false,
	focusClass   : undefined,
	enableClear  : false,
	delimiter    : ',',
	readOnly	 : false,
	toLegend     : null,
	fromLegend   : null,
	toSortField  : null,
	fromSortField: null,
	toSortDir    : 'ASC',
	fromSortDir  : 'ASC',
	
	defaultAutoCreate : {tag: "input", type: "hidden", value: ""},
	
	onRender : function(ct, position) {
	
		var divFrom, divTo, table, tr, td, range;
		
		if (this.imagePath!="" && this.imagePath.charAt(this.imagePath.length-1)!="/") {
			this.imagePath+="/";
		}
		
		this.iconUp = this.imagePath + (this.iconUp || 'up2.gif');
		this.iconDown = this.imagePath + (this.iconDown || 'down2.gif');
		this.iconLeft = this.imagePath + (this.iconLeft || 'left2.gif');
		this.iconRight = this.imagePath + (this.iconRight || 'right2.gif');
		this.iconTop = this.imagePath + (this.iconTop || 'top2.gif');
		this.iconBottom = this.imagePath + (this.iconBottom || 'bottom2.gif');
		
		this.el = ct;
		divFrom = this.el.createChild({tag:'div', cls:'ux-mselect-from'});
		table = this.el.createChild({tag:'table', cls:'ux-mselect-icons'});
		table.setHeight(this.msHeight);
		divTo = this.el.createChild({tag:'div', cls:'ux-mselect-to'});
		tr = table.createChild({tag: 'tr'});
		if (tr.dom.tagName.toUpperCase() == 'TBODY') { tr = tr.child('tr'); }

		td = Ext.get(tr.dom.appendChild(document.createElement('td')));
		td.dom.vAlign='middle';

		this.fromMultiselect = new Ext.form.Multiselect({legend:this.fromLegend, delimiter:this.delimiter, 
			enableToolbar:this.enableToolbar, allowDup:this.allowDup, copy:this.allowDup, draggable: !this.readOnly, 
			dragGroup: this.el.dom.id, width: this.msWidth, height: this.msHeight, dataFields: this.dataFields, 
			data: this.fromData, displayField: this.displayField, valueField: this.valueField, store: this.fromStore, isFormField:false});
		this.fromMultiselect.on('drop', this.dropFrom, this);
		this.fromMultiselect.on('dblclick', this.onRowDblClick, this);

		if (!this.toSortField) {
			this.toTopIcon = td.createChild({tag:'img', src:this.iconTop, style:{cursor:'pointer', margin:'2px'}});
			td.createChild({tag: 'br'});
			this.upIcon = td.createChild({tag:'img', src:this.iconUp, style:{cursor:'pointer', margin:'2px'}});
			td.createChild({tag: 'br'});
		}
		this.addIcon = td.createChild({tag:'img', src:this.switchToFrom?this.iconLeft:this.iconRight, style:{cursor:'pointer', margin:'2px'}});
		td.createChild({tag: 'br'});
		this.removeIcon = td.createChild({tag:'img', src:this.switchToFrom?this.iconRight:this.iconLeft, style:{cursor:'pointer', margin:'2px'}});
		td.createChild({tag: 'br'});
		if (!this.toSortField) {
			this.downIcon = td.createChild({tag:'img', src:this.iconDown, style:{cursor:'pointer', margin:'2px'}});
			td.createChild({tag: 'br'});
			this.toBottomIcon = td.createChild({tag:'img', src:this.iconBottom, style:{cursor:'pointer', margin:'2px'}});
		}
		if (!this.readOnly) {
			if (!this.toSortField) {
				this.toTopIcon.on('click', this.toTop, this);
				this.upIcon.on('click', this.up, this);
				this.downIcon.on('click', this.down, this);
				this.toBottomIcon.on('click', this.toBottom, this);
			}
			this.addIcon.on('click', this.fromTo, this);6
			this.removeIcon.on('click', this.toFrom, this);
		}
		
		if (!this.drawUpIcon || this.hideNavIcons) { this.upIcon.dom.style.display='none'; }
		if (!this.drawDownIcon || this.hideNavIcons) { this.downIcon.dom.style.display='none'; }
		if (!this.drawLeftIcon || this.hideNavIcons) { this.addIcon.dom.style.display='none'; }
		if (!this.drawRightIcon || this.hideNavIcons) { this.removeIcon.dom.style.display='none'; }
		if (!this.drawTopIcon || this.hideNavIcons) { this.toTopIcon.dom.style.display='none'; }
		if (!this.drawBotIcon || this.hideNavIcons) { this.toBottomIcon.dom.style.display='none'; }
			
		if (!this.toStore) {
			this.toStore = new Ext.data.SimpleStore({
				fields: this.dataFields,
				data : this.toData
			});
		}
			
		this.toStore.on('add', this.valueChanged, this);
		this.toStore.on('remove', this.valueChanged, this);
		this.toStore.on('load', this.valueChanged, this);
		this.toMultiselect = new Ext.form.Multiselect({legend:this.toLegend, delimiter:this.delimiter, 
			enableToolbar:this.enableToolbar||this.enableClear, allowDup:this.allowDup, draggable: !this.readOnly, 
			dragGroup: this.el.dom.id, width: this.msWidth, height: this.msHeight, displayField: this.displayField, 
			valueField: this.valueField, store: this.toStore, isFormField:false});
		this.toMultiselect.on('drop', this.dropTo, this);
		this.toMultiselect.on('dblclick', this.onRowDblClick, this);
		
		this.fromMultiselect.render(this.switchToFrom ? divTo : divFrom);
		this.toMultiselect.render(this.switchToFrom ? divFrom : divTo);
		
		this.defaultAutoCreate.name = this.name;
		this.hiddenName = this.name;
		this.hiddenField = ct.createChild(this.defaultAutoCreate);
		this.valueChanged(this.toStore);
		
		if (this.enableClear) {
			this.toMultiselect.toolbar.addButton({text:'Clear', tooltip:"Remove All Entries", scope:this, handler:function(){
				range = this.toMultiselect.store.getRange();
				this.toMultiselect.store.removeAll();
				if (!this.allowDup) {
					this.fromMultiselect.store.add(range);
					this.fromMultiselect.store.sort(this.displayField,'ASC');
				}
				this.valueChanged(this.toMultiselect.store);
			}});
		}			
	},
	
	toTop : function() {
		var selectionsArray = this.toMultiselect.view.getSelectedIndexes();
		var records = [];
		if (selectionsArray.length > 0) {
			selectionsArray.sort();
			for (var i=0; i<selectionsArray.length; i++) {
				record = this.toMultiselect.view.store.getAt(selectionsArray[i]);
				records.push(record);
			}
			selectionsArray = [];
			for (var i=records.length-1; i>-1; i--) {
				record = records[i];
				this.toMultiselect.view.store.remove(record);
				this.toMultiselect.view.store.insert(0, record);
				selectionsArray.push(((records.length - 1) - i));
			}
		}
		this.toMultiselect.view.refresh();
		this.toMultiselect.view.select(selectionsArray);
	},

	toBottom : function() {
		var selectionsArray = this.toMultiselect.view.getSelectedIndexes();
		var records = [];
		if (selectionsArray.length > 0) {
			selectionsArray.sort();
			for (var i=0; i<selectionsArray.length; i++) {
				record = this.toMultiselect.view.store.getAt(selectionsArray[i]);
				records.push(record);
			}
			selectionsArray = [];
			for (var i=0; i<records.length; i++) {
				record = records[i];
				this.toMultiselect.view.store.remove(record);
				this.toMultiselect.view.store.add(record);
				selectionsArray.push((this.toMultiselect.view.store.getCount()) - (records.length - i));
			}
		}
		this.toMultiselect.view.refresh();
		this.toMultiselect.view.select(selectionsArray);
	},
	
	up : function() {
		var record = null;
		var selectionsArray = this.toMultiselect.view.getSelectedIndexes();
		selectionsArray.sort();
		var newSelectionsArray = [];
		if (selectionsArray.length > 0) {
			for (var i=0; i<selectionsArray.length; i++) {
				record = this.toMultiselect.view.store.getAt(selectionsArray[i]);
				if ((selectionsArray[i] - 1) >= 0) {
					this.toMultiselect.view.store.remove(record);
					this.toMultiselect.view.store.insert(selectionsArray[i] - 1, record);
					newSelectionsArray.push(selectionsArray[i] - 1);
				}
			}
			this.toMultiselect.view.refresh();
			this.toMultiselect.view.select(newSelectionsArray);
		}
	},

	down : function() {
		var record = null;
		var selectionsArray = this.toMultiselect.view.getSelectedIndexes();
		selectionsArray.sort();
		selectionsArray.reverse();
		var newSelectionsArray = [];
		if (selectionsArray.length > 0) {
			for (var i=0; i<selectionsArray.length; i++) {
				record = this.toMultiselect.view.store.getAt(selectionsArray[i]);
				if ((selectionsArray[i] + 1) < this.toMultiselect.view.store.getCount()) {
					this.toMultiselect.view.store.remove(record);
					this.toMultiselect.view.store.insert(selectionsArray[i] + 1, record);
					newSelectionsArray.push(selectionsArray[i] + 1);
				}
			}
			this.toMultiselect.view.refresh();
			this.toMultiselect.view.select(newSelectionsArray);
		}
	},
	
	fromTo : function() {
		var selectionsArray = this.fromMultiselect.view.getSelectedIndexes();
		var records = [];
		if (selectionsArray.length > 0) {
			for (var i=0; i<selectionsArray.length; i++) {
				record = this.fromMultiselect.view.store.getAt(selectionsArray[i]);
				records.push(record);
			}
			if(!this.allowDup)selectionsArray = [];
			for (var i=0; i<records.length; i++) {
				record = records[i];
				if(this.allowDup){
					var x=new Ext.data.Record();
					record.id=x.id;
					delete x;	
					this.toMultiselect.view.store.add(record);
				}else{
					this.fromMultiselect.view.store.remove(record);
					this.toMultiselect.view.store.add(record);
					selectionsArray.push((this.toMultiselect.view.store.getCount() - 1));
				}
			}
		}
		this.toMultiselect.view.refresh();
		this.fromMultiselect.view.refresh();
		if(this.toSortField)this.toMultiselect.store.sort(this.toSortField, this.toSortDir);
		if(this.allowDup)this.fromMultiselect.view.select(selectionsArray);
		else this.toMultiselect.view.select(selectionsArray);
	},
	
	toFrom : function() {
		var selectionsArray = this.toMultiselect.view.getSelectedIndexes();
		var records = [];
		if (selectionsArray.length > 0) {
			for (var i=0; i<selectionsArray.length; i++) {
				record = this.toMultiselect.view.store.getAt(selectionsArray[i]);
				records.push(record);
			}
			selectionsArray = [];
			for (var i=0; i<records.length; i++) {
				record = records[i];
				this.toMultiselect.view.store.remove(record);
				if(!this.allowDup){
					this.fromMultiselect.view.store.add(record);
					selectionsArray.push((this.fromMultiselect.view.store.getCount() - 1));
				}
			}
		}
		this.fromMultiselect.view.refresh();
		this.toMultiselect.view.refresh();
		if(this.fromSortField)this.fromMultiselect.store.sort(this.fromSortField, this.fromSortDir);
		this.fromMultiselect.view.select(selectionsArray);
	},
	
	dropTo: function(ddView, n, dd, e, data, r){
		if(this.toSortField){
			if(data.sourceView == ddView)return false;
			if(this.allowDup){
				var x=new Ext.data.Record();
				r.id=x.id;
				delete x;	
				ddView.store.add(r);
			}else{
				data.sourceView.store.remove(r);
				ddView.store.add(r);
			}
			ddView.store.sort(this.toSortField, this.toSortDir);
			return false;
		}
		return true;
	},

	dropFrom : function(ddView, n, dd, e, data, r){
		if(this.allowDup){
			if(data.sourceView != ddView){
				data.sourceView.isDirtyFlag = true;
				data.sourceView.store.remove(r);
			}
			return false;
		}
		if(data.sourceView != ddView){
			if(data.sourceView){
				data.sourceView.isDirtyFlag = true;
				data.sourceView.store.remove(r);
			}
			ddView.store.add(r);
			if(this.fromSortField)ddView.store.sort(this.fromSortField, this.fromSortDir);
		}		
		return false;
	},
	
	valueChanged: function(store) {
		var record = null;
		var values = [];
		for (var i=0; i<store.getCount(); i++) {
			record = store.getAt(i);
			values.push(record.get(this.valueField));
		}
		this.hiddenField.dom.value = values.join(this.delimiter);
		this.fireEvent('change', this, this.getValue(), this.hiddenField.dom.value);
	},
	
	getValue : function() {
		return this.hiddenField.dom.value;
	},
	
	onRowDblClick : function(vw, index, node, e) {
		return this.fireEvent('rowdblclick', vw, index, node, e);
	}
	
});


//Ext.form.Multiselect=Ext.ux.Multiselect;

