/*
 * Ext JS Library 1.1.1
 * Copyright(c) 2006-2007, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://www.extjs.com/license
 */

Ext.onReady(function(){
    // shorthand
    alert("llega  XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX");
    
    var Tree = Ext.tree;
    
    var tree = new Tree.TreePanel('tree-div', {
        animate:true, 
        loader: new Tree.TreeLoader({
            dataUrl:'../../../sis_almacenes/control/tipo_unidad_constructiva/ActionListaTucArb.php'
        }),
        enableDD:true,
        containerScroll: true
    });

    // set the root node
    var root = new Tree.AsyncTreeNode({
        text: 'Unidades Constructivas',
        draggable:false,
        id:'id'
    });
    tree.setRootNode(root);

    // render the tree
    tree.render();
    root.expand();
});