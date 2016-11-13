
dialog = new Ext.BasicDialog("hello-dlg", {
        modal:true,
        autoTabs:true,
        width:500,
        height:300,
        shadow:true,
        minWidth:300,
        minHeight:300
});
dialog.addKeyListener(27, dialog.hide, dialog);
dialog.addButton('Close', dialog.hide, dialog);
dialog.addButton('Submit', dialog.hide, dialog).disable();
