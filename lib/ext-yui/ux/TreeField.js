
alert('xxxx')
/**
 * @class Ext.form.HiddenField
 * @extends Ext.form.Field
 * Single hidden field.
 * @author Gerosa Riccardo
 * @constructor
 * Creates a new HiddenField
 * @param {Object} config Configuration options
 */
Ext.form.HiddenField = function(){
    Ext.form.HiddenField.superclass.constructor.apply(this, arguments);
};
Ext.extend(Ext.form.HiddenField, Ext.form.Field, {
	/**
     * @cfg {String/Object} autoCreate A DomHelper element spec, or true for a default element spec (defaults to
     * {tag: "input", type: "hidden" })
     */
    defaultAutoCreate : { tag: "input", type: 'hidden' },
    inputType: 'hidden'
});


/**
 * @class Ext.form.TreeField
 * @extends Ext.form.HiddenField
 * A tree node selection field.
 * @author Gerosa Riccardo
 * @constructor
 * Creates a new TreeField
 * @param {Object} config Configuration options
 */
Ext.form.TreeField = function(){
    Ext.form.TreeField.superclass.constructor.apply(this, arguments);
};
Ext.extend(Ext.form.TreeField, Ext.form.HiddenField, {
	/**
     * @cfg {String} focusClass The CSS class to use when the tree receives focus (defaults to undefined)
     */
    focusClass : undefined,
    /**
     * @cfg {String} fieldClass The default CSS class for the tree (defaults to "x-form-field")
     */
    fieldClass: "x-form-field",
	/**
     * @cfg {String} fieldClass The default CSS class for the tree container (defaults to "x-form-tree")
     */
    containerClass: "x-form-tree",
	
	height: null,
	
	rootNode: null,
	
	// private
    onRender : function(ct, position){
		
        Ext.form.TreeField.superclass.onRender.call(this, ct, position);

		var innerContentPanelDivID = Ext.id();		    
		    
		var innerTreePanelDivID = Ext.id();
		
		var innerContentPanelDiv = this.el.insertSibling({
			tag: 'div', 
			id: innerContentPanelDivID
			}, 'after');
		innerContentPanelDiv.addClass(this.containerClass);
		innerContentPanelDiv.createChild({
			tag: 'div', 
			id: innerTreePanelDivID});
		
		var contentPanel = new Ext.ContentPanel(innerContentPanelDivID, {
			background: true,
			autoScroll: true});
			
		if (this.height) {
			contentPanel.el.setHeight(this.height);
		}
	    
	    tree = new Ext.tree.TreePanel(innerTreePanelDivID, {
	        animate: true, 
	        enableDD: false,
	        containerScroll: true,
            rootVisible: true
	    });
	
		if(this.rootNode) {
			tree.setRootNode(this.rootNode);
		}
		
	    tree.render();
		
		function onTreeNodeSelect(selectionModel, node) {
			Ext.form.TreeField.superclass.setValue.call(this, node.getPath());
		}
	
		tree.getSelectionModel().on('selectionchange', onTreeNodeSelect); 
	
		var selectedNodePath = Ext.form.TreeField.superclass.getValue.call(this);
		
		function onTreeNodeSelectCompleted(success, node) {
			if (!success) {
				window.alert('Node path not found [' + selectedNodePath);
			}
		}
		
		tree.selectPath(selectedNodePath, 'id', onTreeNodeSelectCompleted);
		
    },
	
	setValue: function(value){
		this.value = value;
	},
	
	getValue: function(){
		return this.value;
	}
	
});