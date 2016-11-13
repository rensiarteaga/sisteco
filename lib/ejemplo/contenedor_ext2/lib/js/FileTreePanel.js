// vim: ts=2:sw=2:nu:fdc=4:nospell

// Create user extensions namespace (Ext.ux)
Ext.namespace('Ext.ux');

/**
  * Ext.ux.FileTreePanel Extension Class
  *
  * @author  Ing. Jozef Sakalos
  * @version $Id: Ext.ux.FileTreePanel.js 81 2007-07-27 20:26:57Z jozo $
  *
  * @class Ext.ux.FileTreePanel
  * @extends Ext.tree.TreePanel
  * @constructor
  * Creates new Ext.ux.FileTreePanel
	*
	* @cfg {String} collapseIcon file name of rename icon (iconPath is prepended to this file name)
	* @cfg {String} collapseText Text to use for menu item collapse (defaults to 'Collapse all')
	* @cfg {String} confirmText Text to use for confirmation 
	* @cfg {String} dataUrl url to get nodes from
	* @cfg {String} deleteIcon file name of rename icon (iconPath is prepended to this file name)
	* @cfg {String} deleteKeyName Delete key name
	* @cfg {String} deleteUrl url that handles deletes. dataUrl is used if not set
	* @cfg {Boolean} edit set to false to disable TreeEditor (defaults to true)
	* @cfg {Boolean} enableDD set to false to disable drag & drop
	* @cfg {Boolean} enableDelete set to false to disable deletes (defaults to true)
	* @cfg {Boolean} enableNewDir set to false to disable new folders creation (defaults to true)
	* @cfg {Boolean} enableRename set to false to disable renames (defaults to true)
	* @cfg {Boolean} enableUpload set to false to disable uploads (defaults to true)
	* @cfg {String} errorText Text to use for error message (defaults to 'Error')
	* @cfg {String} existsText Text to use for file exists message
	* @cfg {String} expandIcon file name of rename icon (iconPath is prepended to this file name)
	* @cfg {String} expandText Text to use for menu item expand (defaults to 'Expand all')
	* @cfg {String} fileCls css class used for leaf nodes and as prefix for file types css
	* @cfg {Boolean} focusPopup set to true to focus the popup after open (defaults to false)
	* @cfg {String} hrefPrefix String to be prepended to file href
	* @cfg {String} hrefSuffix String to be appended to file href
	* @cfg {String} iconPath Path to icons (relative or absolute)
	* @cfg {String} larrowKeyName Left arrow key name
	* @cfg {String} method method of submit 'get' or 'post' (defaults to 'post')
	* @cfg {String} newdirIcon file name of rename icon (iconPath is prepended to this file name)
	* @cfg {String} newdirText Text to use for menu item new folder
	* @cfg {String} newdirUrl url that handles new folder creations. dataUrl is used if not set
	* @cfg {String} openBlankIcon file name of rename icon (iconPath is prepended to this file name)
	* @cfg {String} openBlankText Text to use for menu item open in new window (defaults to 'Open in new window')
	* @cfg {String} openIcon file name of rename icon (iconPath is prepended to this file name)
	* @cfg {String} openMode Open mode for files. 'popup', '_self' or '_blank' (defaults to 'popup')
	* @cfg {String} openPopupIcon file name of rename icon (iconPath is prepended to this file name)
	* @cfg {String} openPopupText Text to use for menu item open in popup (defaults to 'Open in popup')
	* @cfg {String} openSelfIcon file name of rename icon (iconPath is prepended to this file name)
	* @cfg {String} openSelfText Text to use for menu item open in this window (defaults to 'Open in this window')
	* @cfg {String} openText Text to use for menu item open (defaults to 'Open')
	* @cfg {String} overwriteText Text to use for overwrite confirmation 
	* @cfg {String} popupFeatures Features for the browser popup window. Used only if openMode === 'popup'
	* @cfg {String} rarrowKeyName Right arrow key name
	* @cfg {Boolean} readOnly set to true to make the tree read-only (defaults to false)
	* @cfg {String} reallyWantText Text to use for Really want? question
	* @cfg {String} reloadIcon file name of rename icon (iconPath is prepended to this file name)
	* @cfg {String} renameIcon file name of rename icon (iconPath is prepended to this file name)
	* @cfg {String} renameText Text to use for menu item rename (defaults to 'Rename')
	* @cfg {String} renameUrl url that handles renames. dataUrl is used if not set
	* @cfg {Boolean} sort set to false to disable TreeSorter (defaults to true)
	* @cfg {String} uploadFileText Text to use for menu item upload
	* @cfg {String} uploadText Text to use for menu upload message(s)
	* @cfg {String} uploadUrl url to upload to. dataUrl is used if not set
  */
Ext.ux.FileTreePanel = function(el, config) {

	// {{{
	// create tree loaeder if it doesn't exist in config
	if(config && !config.loader) {
		config.loader = new Ext.tree.TreeLoader({
			dataUrl: config.dataUrl
		});
		config.loader.baseParams.cmd = 'get';

		// do not rely on node.id attribute send path instead
		config.loader.on({
			beforeload:{
				scope: this
				, fn: function(loader, node) {
					loader.baseParams.path = this.getPath(node);
				}
		}});
	}
	// }}}
	// {{{
	// adjust drop configuration
	if(!config.dropConfig) {
		config.dropConfig = {
			ddGroup: config.ddGroup || "TreeDD"
			, appendOnly: config.ddAppendOnly === true
			, expandDelay: 3600000 // do not expand on drag over node
		};
	}
	// }}}
	// {{{
	// call parent constructor
	Ext.ux.FileTreePanel.superclass.constructor.call(this, el, config);
	// }}}
	// {{{
	// icons
	// iconPath
	this.iconPath = config && config.iconPath ? config.iconPath : '../img/silk/icons';

	// rename icon
	this.renameIcon = config && config.renameIcon ? config.renameIcon : 'pencil.png';
	this.renameIcon = this.iconPath + '/' + this.renameIcon;

	// delete icon
	this.deleteIcon = config && config.deleteIcon ? config.deleteIcon : 'cross.png';
	this.deleteIcon = this.iconPath + '/' + this.deleteIcon;

	// new directory icon
	this.newdirIcon = config && config.newdirIcon ? config.newdirIcon : 'folder_add.png';
	this.newdirIcon = this.iconPath + '/' + this.newdirIcon;

	// upload icon
	this.uploadIcon = config && config.uploadIcon ? config.uploadIcon : 'arrow_up.png';
	this.uploadIcon = this.iconPath + '/' + this.uploadIcon;

	// reload icon
	this.reloadIcon = config && config.reloadIcon ? config.reloadIcon : 'arrow_refresh.png';
	this.reloadIcon = this.iconPath + '/' + this.reloadIcon;

	// expand icon
	this.expandIcon = config && config.expandIcon ? config.expandIcon : 'arrow_right.png';
	this.expandIcon = this.iconPath + '/' + this.expandIcon;

	// collapse icon
	this.collapseIcon = config && config.collapseIcon ? config.collapseIcon : 'arrow_left.png';
	this.collapseIcon = this.iconPath + '/' + this.collapseIcon;

	// open icon
	this.openIcon = config && config.openIcon ? config.openIcon : 'application_go.png';
	this.openIcon = this.iconPath + '/' + this.openIcon;

	// open in popup icon
	this.openPopupIcon = config && config.openPopupIcon ? config.openPopupIcon : 'application_double.png';
	this.openPopupIcon = this.iconPath + '/' + this.openPopupIcon;

	// open in this window icon
	this.openSelfIcon = config && config.openSelfIcon ? config.openSelfIcon : 'application.png';
	this.openSelfIcon = this.iconPath + '/' + this.openSelfIcon;

	// open in new window icon
	this.openBlankIcon = config && config.openBlankIcon ? config.openBlankIcon : 'application_cascade.png';
	this.openBlankIcon = this.iconPath + '/' + this.openBlankIcon;
	// }}}
	// {{{
	// tree editor
	if(this.edit) {
		// create tree editor
		this.treeEditor = new Ext.tree.TreeEditor(this, {allowBlank:false});

		// install default handling of edit complete
		this.treeEditor.on({
			complete: {scope:this, fn:this.onEditComplete}
			, beforecomplete: {scope:this, fn:this.onBeforeEditComplete}
		});
	}
	// }}}
	// {{{
	// tree sorter
	if(this.sort) {
		this.treeSorter = new Ext.tree.TreeSorter(this, {folderSort:true});
	}
	// }}}
	// {{{
	// install event handlers
	this.on({
		contextmenu: {scope:this, fn:this.onContextMenu}
		, beforenodedrop: {scope:this, fn:this.onBeforeNodeDrop}
		, dblclick: {scope:this, fn:this.openNode}
		, nodedrop: {scope:this, fn:this.onNodeDrop}
		, nodedragover: {scope:this, fn:this.onNodeDragOver}
		, render: {scope:this, fn:function() {
			this.setReadOnly(this.readOnly);
			this.setRenameDisabled(!this.enableRename);
		}}
	});
	// }}}
	// {{{
	// install keymap
	this.installKeyMap();
	// }}}
	// {{{
	// add events
	this.addEvents({
		// {{{
		/**
			* Fires after tree render
			* @event render
			* @param {Ext.ux.FileTreePanel} this
			*/
		render: true
		// }}}
		// {{{
		/**
			* Fires before context menu is displayed
			* return false to cancel the event
			* @event beforecontextmenu
			* @param {Ext.ux.FileTreePanel} this
			* @param {AsyncTreeNode} node right-clicked
			*/
		, beforecontextmenu: true
		// }}}
		// {{{
		/**
			* Fires after context menu is displayed
			* @event aftercontextmenu
			* @param {Ext.ux.FileTreePanel} this
			* @param {Menu} context menu reference
			* @param {AsyncTreeNode} node right-clicked
			*/
		, aftercontextmenu: true
		// }}}
		// {{{
		/**
			* Fires before context menu item is executed
			* return false to cancel the event
			* @event beforecontextmenuitem
			* @param {Ext.ux.FileTreePanel} this
			* @param {MenuItem} context menu item 
			* @param {AsyncTreeNode} node right-clicked
			*/
		, beforecontextmenuitem: true
		// }}}
		// {{{
		/**
			* Fires before new directory is created
			* return false to cancel the event
			* @event beforenewdir
			* @param {Ext.ux.FileTreePanel} this
			* @param {AsyncTreeNode} node 
			*/
		, beforenewdir: true
		// }}}
		// {{{
		/**
			* Fires after new directory successfuly created
			* @event newdirsuccess
			* @param {Ext.ux.FileTreePanel} this
			* @param {AsyncTreeNode} new directory node that has been created
			*/
		, newdirsuccess: true
		// }}}
		// {{{
		/**
			* Fires after new directory creation failed
			* return false to suppress default error message box
			* @event newdirfailure
			* @param {Ext.ux.FileTreePanel} this
			* @param {String} server error message
			* @param {String} new directory full path
			*/
		, newdirfailure: true
		// }}}
		// {{{
		/**
			* Fires before delete
			* return false to cancel the event
			* @event beforedelete
			* @param {Ext.ux.FileTreePanel} this
			* @param {AsyncTreeNode} node 
			*/
		, beforedelete: true
		// }}}
		// {{{
		/**
			* Fires after successful delete
			* @event deletesuccess
			* @param {Ext.ux.FileTreePanel} this
			* @param {String} full path of file deleted
			*/
		, deletesuccess: true
		// }}}
		// {{{
		/**
			* Fires after delete failed
			* return false to suppress default error message box
			* @event deletefailure
			* @param {Ext.ux.FileTreePanel} this
			* @param {String} server error message
			* @param {AsyncTreeNode} node delete of which failed
			*/
		, deletefailure: true
		// }}}
		// {{{
		/**
			* Fires before open node
			* return false to cancel the event
			* @event beforeopen
			* @param {Ext.ux.FileTreePanel} this
			* @param {AsyncTreeNode} node 
			* @param {String} openMode
			*/
		, beforeopen: true

		// }}}
		// {{{
		/**
			* Fires after node is opened
			* @event open
			* @param {Ext.ux.FileTreePanel} this
			* @param {AsyncTreeNode} node 
			* @param {String} openMode
			*/
		, open: true

		// }}}
		// {{{
		/**
			* Fires before node rename
			* return false to cancel the event
			* @event beforeopen
			* @param {Ext.ux.FileTreePanel} this
			* @param {AsyncTreeNode} node 
			* @param {String} old name
			* @param {String} new name
			*/
		, beforerename: true
		// }}}
		// {{{
		/**
			* Fires after node has been successfuly renamed
			* @event beforeopen
			* @param {Ext.ux.FileTreePanel} this
			* @param {AsyncTreeNode} node 
			* @param {String} old name
			* @param {String} new name
			*/
		, renamesuccess: true
		// }}}
		// {{{
		/**
			* Fires after node rename failed
			* return false to suppress default error message box
			* @event newdirfailure
			* @param {Ext.ux.FileTreePanel} this
			* @param {String} server error message
			* @param {AsyncTreeNode} node rename of which failed
			* @param {String} oldname
			* @param {String} newname
			*/
		, renamefailure: true
		// }}}

	});
	// }}}

}; // end of Ext.ux.FileTreePanel constructor

// extend
Ext.extend(Ext.ux.FileTreePanel, Ext.tree.TreePanel, {

	// {{{
	// defaults
	collapseText: 'Collapse all'
	, confirmText: 'Confirm'
	, deleteKeyName: 'Delete Key'
	, deleteText: 'Delete'
	, edit: true
	, enableDD: true
	, enableDelete: true
	, enableNewDir: true
	, enableRename: true
	, enableUpload: true
	, errorText: 'Error'
	, existsText: 'File <b>{0}</b> already exists'
	, expandText: 'Expand all'
	, fileCls: 'file'
	, focusPopup: false
	, hrefPrefix: '/'
	, hrefSuffix: ''
	, larrowKeyName: 'Left Arrow'
	, method: 'post'
	, newdirText: 'New folder'
	, openBlankText: 'Open in new window'
	, openMode: 'popup' // or _self or _blank
	, openPopupText: 'Open in popup'
	, openSelfText: 'Open in this window'
	, openText: 'Open'
	, overwriteText: 'Do you want to overwrite it?'
	, popupFeatures: 'width=640,height=480,dependent=1,scrollbars=1,resizable=1,toolbar=1'
	, rarrowKeyName: 'Right Arrow'
	, readOnly: false
	, reallyWantText: 'Do you really want to'
	, reloadText: 'R<span style="text-decoration:underline">e</span>load'
	, renameText: 'Rename'
	, sort: true
	, uploadFileText: '<span style="text-decoration:underline">U</span>pload file'
	, uploadPosition: 'menu' // or 'floating'
	, uploadText: 'Upload'
	// }}}

	// event handlers
	// {{{
	/**
		* runs after an ajax requested command is completed/failed
		* @param {Object} options Options used for the request
		* @param {Boolean} bSuccess true if ajax call was successful (cmd may have failed)
		* @param {Object} response ajax call response object
		*/
	, cmdCallback: function(options, bSuccess, response) {
		var i, o, node;
		var showMsg = true;
		if(true === bSuccess) {
			o = Ext.decode(response.responseText);

			// {{{
			// handle success
			if(true === o.success) {

				switch(options.params.cmd) {
					case 'delete':
						options.node.parentNode.removeChild(options.node);
						this.fireEvent('deletesuccess', this, options.params.file);
					break;

					case 'newdir':
						this.fireEvent('newdirsuccess', this, options.node);
					break;

					case 'rename':
						this.updateCls(options.node, options.params.oldname);
						this.fireEvent('renamesuccess', this, options.node, options.params.oldname, options.params.newname);
					break;
				}
			} // end of handle success
			// }}}
			// {{{
			// handle failure
			else {
				switch(options.params.cmd) {

					case 'rename':
						// handle drag & drop rename error
						if(options.oldParent) {
							options.oldParent.appendChild(options.node);
						}
						// handle simple rename error
						else {
							options.node.setText(options.oldName);
						}
						if(options.e) {
							options.e.failure = true;
						}
						showMsg = this.fireEvent('renamefailure', this, o.error, options.node, options.params.oldname, options.params.newname);
					break;

					case 'newdir':
						options.node.parentNode.removeChild(options.node);
						showMsg = this.fireEvent('newdirfailure', this, o.error, options.params.dir);
					break;

					case 'delete':
						showMsg = this.fireEvent('deletefailure', this, o.error, options.node);
					break;

					default:
						this.root.reload();
					break;
				}

				// show default message box with server error
				if(false !== showMsg) {
					Ext.Msg.alert(this.errorText, o.error);
				}
			} // end of handle failure
			// }}}

		}
	}
	// }}}
	// {{{
	/**
		* Calls before editing is completed - allows edit cancellation
		* private
		* @param {Ext.tree.TreeEditor} editor
		* @param {String} newName
		* @param {String} oldName
		*/
	, onBeforeEditComplete: function(editor, newName, oldName) {
		if(editor.cancellingEdit) {
			editor.cancellingEdit = false;
			return;
		}
		if(false === this.fireEvent('beforerename', this, editor.editNode, oldName, newName)) {
			editor.cancellingEdit = true;
			editor.cancelEdit();
			return false;
		}
	}
	// }}}
	// {{{
	/**
		* run before node is dropped
		* private
		* @param {Object} e dropEvent object
		*/
	, onBeforeNodeDrop: function(e) {

		// source node, node being dragged
		var s = e.dropNode;

		// destination node (dropping on this node)
		var d = e.target.leaf ? e.target.parentNode : e.target;

		// node has been dropped within the same parent
		if(s.parentNode === d) {
			return false;
		}

		// check if same name exists in the destination
		// this works only if destination node is loaded
		if(this.hasChild(d, s.text) && !e.confirmed) {
			this.confirmOverwrite(s.text, function() {
				e.confirmed = true;
				this.onBeforeNodeDrop(e);
			});
			return false;
		}
		e.confirmed = false;
		e.oldParent = s.parentNode;

		var oldName = this.getPath(s)
		var newName = this.getPath(d) + '/' + s.text;

		if(false === this.fireEvent('beforerename', this, s, oldName, newName)) {
			return false;
		}

		var options = {
			url: this.renameUrl || this.dataUrl
			, method: this.method
			, scope: this
			, callback: this.cmdCallback
			, node: s
			, oldParent: s.parentNode
			, e: e
			, params: {
				cmd: 'rename'
				, oldname: oldName
				, newname: newName
			}
		};
		var conn = new Ext.data.Connection().request(options);
		return true;
	}
	// }}}
	// {{{
	/**
		* context menu event handler
		* @param {TreeNode} node
		* @param {Event} e 
		*/
	, onContextMenu: function(node, e) {

		// do nothing if we're read only
		if(this.readOnly) {
			return;
		}
		if(false === this.fireEvent('beforecontextmenu', this, node)) {
			return;
		}

		e.stopEvent();
		e.preventDefault();

		// {{{
		// lazy create upload form
		this.createUploadForm();
		// }}}
		// {{{
		// lazy create context menu
		if(!this.contextMenu) {
			this.contextMenu = new Ext.menu.Menu({
				items: [
						// node name we're working with placeholder
					  { id:'nodename', disabled:true, cls:'x-filetree-nodename'}
					, {
						id: 'open'
						, text: this.openText + ' (Enter)'
						, icon: this.openIcon
						, scope: this
						, handler: this.onContextMenuItem
						, menu: {
							items: [
							  { id: 'open-self'
								, text: this.openSelfText
								, icon: this.openSelfIcon
								, scope: this
								, handler: this.onContextMenuItem
							}
							,	{ id: 'open-popup'
								, text: this.openPopupText
								, icon: this.openPopupIcon
								, scope: this
								, handler: this.onContextMenuItem
								}
							, { id: 'open-blank'
								, text: this.openBlankText
								, icon: this.openBlankIcon
								, scope: this
								, handler: this.onContextMenuItem
							}
							]
						}
					}

					, new Ext.menu.Separator({id:'sep-open'})
					, {	id:'reload'
						, text:this.reloadText + ' (Ctrl+E)'
						, icon:this.reloadIcon
						, scope:this
						, handler:this.onContextMenuItem
					}
					, {	id:'expand'
						, text:this.expandText + ' (Ctrl+' + this.rarrowKeyName + ')'
						, icon:this.expandIcon
						, scope:this
						, handler:this.onContextMenuItem
					}
					, {	id:'collapse'
						, text:this.collapseText + ' (Ctrl+' + this.larrowKeyName + ')'
						, icon:this.collapseIcon
						, scope:this
						, handler:this.onContextMenuItem
					}
					, new Ext.menu.Separator({id:'sep-collapse'})
					, {	id:'rename'
						, text:this.renameText + ' (F2)'
						, icon:this.renameIcon
						, scope:this
						, handler:this.onContextMenuItem
					}
					, {	id:'delete'
						, text:this.deleteText + ' (' + this.deleteKeyName + ')'
						, icon:this.deleteIcon
						, scope:this
						, handler:this.onContextMenuItem
					}
//					, new Ext.menu.Separator()
					, { id:'newdir'
						, text:this.newdirText + '... (Ctrl+N)'
						, icon:this.newdirIcon
						, scope:this
						, handler:this.onContextMenuItem
					}
					, new Ext.menu.Separator({id:'sep-upload'})
				]
			});

			switch(this.uploadPosition) {
				case 'menu':
					// add upload form at the end of context menu
					this.contextMenu.addElement(this.uploadForm.container).hideOnClick = false;

					// handle shadow on file add/remove to/from UploadForm
					var showShadow = this.contextMenu.getEl().shadow.show.createDelegate(this.contextMenu.getEl().shadow, [this.contextMenu.getEl()]);
					this.uploadForm.on({
						fileadded:{fn:showShadow}
						, fileremoved:{fn:showShadow}
						, clearqueue:{scope:this, fn:function() {
							this.uploadNode = null;
							showShadow();
						}}
					});
				break;

				case 'floating':
					this.contextMenu.add(new Ext.menu.Item({
						id:'upload'
						, text:this.uploadFileText + ' (Ctrl+U)'
						, icon:this.uploadIcon
						, scope:this
						, handler:this.onContextMenuItem
					}));
				break;
			}

		}
		// }}}

		// setup path for upload
		this.uploadForm.node = node === this.root ? this.root : node.isLeaf() ? node.parentNode : node;
		this.uploadForm.baseParams.path = this.getPath(this.uploadForm.node)
		this.uploadForm.reloadNode = this.uploadForm.node;

		// save current node to context menu and open submenu
		var menu = this.contextMenu;
		menu.node = node;
		menu.items.get('open').menu.node = node;

		// set menu item text to node text
		var itemNodename = menu.items.get('nodename');
		itemNodename.setText(Ext.util.Format.ellipsis(node.text, 25));

		// disable delete and rename for root node
		var itemDelete = menu.items.get('delete');
		itemDelete.setDisabled(node === this.root || node.disabled);

		var itemRename = menu.items.get('rename');
		itemRename.setDisabled(node === this.root || node.disabled);

		var itemNewDir = menu.items.get('newdir');
		itemNewDir.setDisabled(node.isLeaf() ? node.parentNode.disabled : node.disabled);

		menu.items.get('reload').setDisabled(node.isLeaf());
		menu.items.get('expand').setDisabled(node.isLeaf());
		menu.items.get('collapse').setDisabled(node.isLeaf());
		menu.items.get('open').setDisabled(!node.isLeaf());
		if(!this.uploadForm.uploading) {
			this.uploadForm.setDisabled(node.isLeaf() ? node.parentNode.disabled : node.disabled, true);
		}

		// hide/show logic
		// delete
		if(false === this.enableDelete) {
			itemDelete.hide();
		}

		// newdir
		if(false === this.enableNewDir) {
			itemNewDir.hide();
		}

		// rename
		if(false === this.enableRename) {
			itemRename.hide();
		}
		if(this.dragZone) {
			this.dragZone.locked = this.enableRename === false;
		}

		// separator
		if(this.enableDelete === false && this.enableRename === false & this.enableNewDir === false) {
			menu.items.get('sep-collapse').hide();
		}

		// upload
		if(false === this.enableUpload) {
			menu.items.get('uf-ct-' + this.id).hide();
			menu.items.get('sep-upload').hide();
		}

		node.select();

		// show context menu at right position
		menu.showAt(menu.getEl().getAlignToXY(node.getUI().getEl(), 'tl-tl?', [0, 18]));
		itemNodename.container.setStyle('opacity', 1);

		this.fireEvent('aftercontextmenu', this, menu, node);

	}
	// }}}
	// {{{
	/**
		* context menu item click handler
		* @param {MenuItem} item
		* @param {Event} e event
		*/
	, onContextMenuItem: function(item, e) {

		// get node for before event
		var node = item.parentMenu.node;

		if(false === this.fireEvent('beforecontextmenuitem', this, item, node)) {
			return;
		}

		// setup variables
		var appendNode, newNode;
		var options = {};
		var treeEditor = this.treeEditor;

		// menu item switch
		switch(item.id) {

			// {{{
			case 'rename':
				treeEditor.triggerEdit(node);
			break;
			// }}}
			// {{{
			case 'delete':
				this.deleteNode(node);
			break;
			// }}}
			// {{{
			case 'newdir':
				this.createNewDir(node);
			break;
			// }}}
			// {{{
			case 'reload':
				// just reload the node if it's not leaf
				if(!node.isLeaf()) {
					node.reload();
				}
			break;
			// }}}
			// {{{
			case 'expand':
				node.expand(true);
			break;
			// }}}
			// {{{
			case 'collapse':
				node.collapse(true);
			break;
			// }}}

			case 'upload':
				node = node.isLeaf() ? node.parentNode : node;
//				this.uploadForm.showAt([100, 100]);
				this.uploadForm.showAt(this.uploadForm.layer.getAlignToXY(node.getUI().getEl(), 'tl-tl?', [0, 18]));

			break;
			// {{{
			case 'open':
				this.openNode(node);
			break;
			// }}}
			// {{{
			case 'open-popup':
				this.openNode(node, null, 'popup');
			break;
			// }}}
			// {{{
			case 'open-self':
				this.openNode(node, null, '_self');
			break;
			// }}}
			// {{{
			case 'open-blank':
				this.openNode(node, null, '_blank');
			break;
			// }}}

		} // end of switch(item.id)
	}
	// }}}
	// {{{
	/**
		* runs when editing of a node (rename) is completed
		* private
		* @param {Ext.Editor} editor
		* @param {String} newName
		* @param {String} oldName
		*/
	, onEditComplete: function(editor, newName, oldName) {

		var node = editor.editNode;

		if(newName === oldName || editor.creatingNewDir) {
			editor.creatingNewDir = false;
			return;
		}
		var path = this.getPath(node.parentNode);
		var options = {
			url: this.renameUrl || this.dataUrl
			, method: this.method
			, scope: this
			, callback: this.cmdCallback
			, node: node
			, oldName: oldName
			, params: {
				cmd: 'rename'
				, oldname: path + '/' + oldName
				, newname: path + '/' + newName
			}
		};
		var conn = new Ext.data.Connection().request(options);
	}
	// }}}
	// {{{
	/**
		* Create new directory handler
		* runs after editing of new directory name is completed
		* private
		* @param {Ext.Editor} editor
		*/
	, onNewDir: function(editor) {
//		var path = editor.editNode.getPath('text').substr(1);
		var path = this.getPath(editor.editNode);
		var options = {
			url: this.newdirUrl || this.dataUrl
			, method: this.method
			, scope: this
			, node: editor.editNode
			, callback: this.cmdCallback
			, params: {
				cmd: 'newdir'
				, dir: path
			}
		};
		var conn = new Ext.data.Connection().request(options);
	}
	// }}}
	// {{{
	/**
		* Called while dragging over
		* decides if drop is allowed
		* private
		* @param {Object} dd event
		*/
	, onNodeDragOver: function(e) {

		if(e.target.disabled || e.dropNode.parentNode === e.target.parentNode && e.target.isLeaf()) {
			e.cancel = true;
		}
	}
	// }}}
	// {{{
	/**
		* Called when node is dropped
		* private
		* @param {Object} dd event
		*/
	, onNodeDrop: function(e) {

		// failure can be signalled by cmdCallback
		// put drop node to the original parent in that case
		if(true === e.failure) {
			e.oldParent.appendChild(e.dropNode);
			return;
		}

		// if we already have node with the same text, remove the duplicate
		var sameNode = e.dropNode.parentNode.findChild('text', e.dropNode.text);
		if(sameNode && sameNode !== e.dropNode) {
			sameNode.parentNode.removeChild(sameNode);
		}
	}
	// }}}
	// {{{
	/**
		* runs on upload file success
		* private
		* @param {Ext.form.Form} form
		* @param {Ext.form.Action} action
		*/
	, onUploadSuccess: function(form, action) {
		this.uploadNode = null;
		form.reloadNode.reload.defer(10, form.reloadNode);
		if(this.progressTip) {
			this.progressTip.hide();
		}
	}
	// }}}
	// {{{
	/**
		* runs on upload file failure
		* private
		* @param {Ext.form.Form} form
		* @param {Ext.form.Action} action
		*/
	, onUploadFailure: function(form, action) {
		// show context menu as it contains error messages
		this.contextMenu.showAt(this.contextMenu.getEl().getAlignToXY(this.contextMenu.node.getUI().getEl(), 'tl-tl?', [0, 18]));
		if(this.progressTip) {
			this.progressTip.hide();
		}
		form.reloadNode.reload.defer(10, form.reloadNode);
	}
	// }}}
	// {{{
	, onUploadStart: function() {
		this.uploadNode = this.uploadForm.node;
		this.contextMenu.hide();
		if(this.uploadForm.node) {
			this.uploadForm.node.ui.removeClass('folder');
			this.uploadForm.node.ui.addClass('folder-uploading');
		}
		if(!this.progressTip && 'object' === typeof this.pgCfg) {
			this.progressTip = new Ext.Layer({
				shadow:'sides'
				, dh: {
					tag:'div', cls:'x-layer x-pginfo', children:[
						{tag:'div', cls:'x-pg-ct', children:[
							{tag:'div', cls:'x-uf-progress-wrap', children:[
								{tag:'div', cls:'x-uf-progress', children:[
									{tag:'div', cls:'x-uf-progress-bar'}
								]}
							]}
							, {tag:'div', cls:'x-uf-pginfo-ct'}
						]}
					]
				}
			});
			this.progressTip.progressBar = this.progressTip.select('div.x-uf-progress-bar').item(0);
			this.progressTip.progressInfo = this.progressTip.select('div.x-uf-pginfo-ct').item(0);

			this.progressTip.show = function(node) {
				if(node) {
					this.shadow.hide();
					this.setXY(this.getAlignToXY(node.getUI().getTextEl(), 'tl-tl?', [0, 18]));
					this.fadeIn({
						duration:0.20
						, stopFx:true
						, scope:this
						, callback:function(){
							this.shadow.show(this);
						}}
					);
				}
			};

			this.progressTip.hide = function() {
				this.fadeOut({
					duration:0.30
					, stopFx:true
					, scope:this.shadow
					, callback:this.shadow.hide
				});

			};

			this.getEl().on({
				mouseover:{scope:this, fn:this.onMouseOver, delegate:'span'}
				, mouseout:{scope:this, fn:this.onMouseOut, delegate:'span'}
			});
			this.uploadForm.progressBar = this.progressTip.progressBar;
			this.uploadForm.progressTarget = this.progressTip.progressInfo;
		}
	}
	// }}}
	// {{{
	/**
		* mouseover event handler shows progressTip if we have one
		* private
		* @param {Event} e
		* @param {Element} target
		*/
	, onMouseOver: function(e, target) {
		if(!this.progressTip) {
			return;
		}
		var node = this.getOverNode(target.id);
//		this.progressTip.shadow.hide();
		if(node && this.uploadNode && node === this.uploadNode) {
			this.progressTip.show(node);
		}
	}
	// }}}
	// {{{
	/**
		* mouseout event handler hides progressTip if we have one
		* private
		* @param {Event} e
		* @param {Element} target
		*/
	, onMouseOut: function(e, target) {
		if(!this.progressTip) {
			return;
		}
		var node = this.getOverNode(target.id);
		this.progressTip.shadow.hide();
		if(null === node || node === this.uploadNode) {
			this.progressTip.hide();
		}
	}
	// }}}
	// {{{
	/** 
		* Find node the mouse is over
		* private
		* @param {String} id of the span element with node text
		* @return {Node} Node found or null
		*/
	, getOverNode: function(id) {
		var node = null;
		this.root.cascade(function(n) {
			if(n && n.getUI().getTextEl().id === id) {
				node = n;
				return false;
			}
			return true;
		});
		return node;
	}
	// }}}
	// {{{
	, onUploadStop: function() {
		if(this.uploadForm.node) {
			this.uploadForm.node.ui.removeClass('folder-uploading');
			this.uploadForm.node.ui.addClass('folder');
		}
	}
	// }}}
	// {{{
	/**
		* Event handler of upload form progress event
		* @param {Ext.ux.UploadForm} uploadForm
		* @param {Object} o Object with progress values
		* @param {Float} value Width of progress bar from 0 - 1
		*/
	, onUploadProgress: function(uploadForm, o, value) {
	}
	// }}}

	// commands
	// {{{
	/**
		* Create new directory (node)
		* private
		* @param {Ext.tree.Node} node
		*/
	, createNewDir: function(node) {

		if(false === this.fireEvent('beforenewdir', this, node)) {
			return;
		}

		var treeEditor = this.treeEditor;
		var newNode;

		// get node to append new directory to
		var appendNode = node.isLeaf() ? node.parentNode : node;

		// create new folder after the appendNode is expanded
		appendNode.expand(null, false, function(n) {

			// create new node
			newNode = n.appendChild(new Ext.tree.AsyncTreeNode({
				text: this.newdirText
				, cls: 'folder'
			}));

			// setup one-shot event handler for editing completed
			treeEditor.on({
				complete:{
					scope: this
					, single: true
					, fn: this.onNewDir
			}});

			// creating new directory flag
			treeEditor.creatingNewDir = true;

			// start editing after short delay
			(function(){treeEditor.triggerEdit(newNode);}.defer(10));

		// expand callback needs to run in this context
		}.createDelegate(this));

	}
	// }}}
	// {{{
	/**
		* deletes the passed node
		* private
		* @param {Ext.tree.Node} node
		*/
	, deleteNode: function(node) {
		if(false === this.fireEvent('beforedelete', this, node)) {
			return;
		}

		// display confirmation message
		Ext.Msg.confirm(this.deleteText
			, this.reallyWantText + ' ' + this.deleteText.toLowerCase() + ' <b>' + node.text + '</b>?'  
			, function(response) {

				var conn;
				// do nothing if answer is not yes
				if('yes' !== response) {
					this.getEl().dom.focus();
					return;
				}

				// answer is yes
				else {

					// setup request options
					options = {
						url: this.deleteUrl || this.dataUrl
						, method: this.method
						, scope: this
						, callback: this.cmdCallback
						, node: node
						, params: {
							cmd: 'delete'
							, file: this.getPath(node)
						}
					};

					// send request
					conn = new Ext.data.Connection().request(options);
				}
			}
			, this
		);

		// set focus to no button to avoid accidental deletions
		var msgdlg = Ext.Msg.getDialog();
		msgdlg.setDefaultButton(msgdlg.buttons[2]).focus();
	}
	// }}}
	// {{{
	/**
		* Opens node
		* @param {Ext.tree.AsyncTreeNode} node
		* @param {String} mode Can be "_self", "_blank", or "popup". Defaults to (this.openMode)
		*/
	, openNode: function(node, e, mode) {

		mode = mode || this.openMode;

		if(false === this.fireEvent('beforeopen', this, node, mode)) {
			return;
		}

		var url;
		if(node.isLeaf()) {
			url = this.hrefPrefix + this.getPath(node) + this.hrefSuffix;
			switch(mode) {
				case 'popup':
					if(!this.popup || this.popup.closed) {
						this.popup = window.open(url, this.hrefTarget, this.popupFeatures);
					}
					this.popup.location = url;
					if(this.focusPopup) {
						this.popup.focus();
					}
				break;

				case '_self':
					window.location = url;
				break;

				case '_blank':
					window.open(url);
				break;
			}
		}

		this.fireEvent('open', this, node, mode);
	}
	// }}}

	// utilities
	// {{{
	/**
		* displays overwrite confirm msg box and runs callback if response is yes
		* @param {String} filename File to overwrite
		* @param {Function} callback Function to call on yes response
		* @param {Object} scope Scope for callback (defaults to this)
		*/
	, confirmOverwrite: function(filename, callback, scope) {
		Ext.Msg.confirm(this.confirmText
		, String.format(this.existsText, filename) 
			+ '. ' + this.overwriteText
		, function(response) {
			if('yes' === response) {
				callback.call(scope || this);
			}	
		}
		, this);
		var msgdlg = Ext.Msg.getDialog();
		msgdlg.setDefaultButton(msgdlg.buttons[2]).focus();
		msgdlg.setZIndex(16000);
	}
	// }}}
	// {{{
	, createUploadForm: function() {
		
		// lazy create upload form
		var uploadFormCt, fname;
		if(!this.uploadForm) {
			
			// create container for upload form
			switch(this.uploadPosition) {
				case 'menu':
					uploadFormCt = Ext.DomHelper.append(document.body, {
						tag: 'div', id: 'uf-ct-' + this.id, style: 'margin-left:30px;margin-bottom:4px;width:154px'
						, children: [
							{tag:'div', html:this.uploadFileText + ' (Ctrl+U)'}
							, {tag:'br'}
						]
					}, true);
				break;

				case 'floating':
					uploadFormCt = Ext.DomHelper.append(document.body, {
						tag:'div', id:'uf-ct-' + this.id
					}, true);
					uploadFormCt.on({click:{stopEvent:true,fn:Ext.emptyFn}});
				break;
			}

			this.uploadForm = new Ext.ux.UploadForm(uploadFormCt, {
				url: this.uploadUrl || this.dataUrl
				, autoCreate: true
				, baseParams: {cmd: 'upload'}
				, maxFileSize: this.maxFileSize
				, iconPath: this.iconPath
				, pgCfg: this.pgCfg
				, floating: 'floating' === this.uploadPosition
			});

			// hide form on body click
			if(this.uploadForm.floating) {
				Ext.fly(document.body).on({
					click:{scope:this.uploadForm, fn:this.uploadForm.hide.createDelegate(this.uploadForm, [false])}
				});
			}

			// install event handlers on the form
			this.uploadForm.on({
				actioncomplete: {scope:this, fn:this.onUploadSuccess}
				, actionfailed: {scope:this, fn:this.onUploadFailure}
				, startupload: {scope:this, fn:this.onUploadStart}
				, stopupload: {scope:this, fn:this.onUploadStop}
//				, progress: {scope:this, fn:this.onUploadProgress}
			});
		}
	}
	// }}}
	// {{{
	/**
		* returns file class based on name extension
		* private
		* @param {String} name File name to get class of
		*/
	, getFileCls: function(name) {
		var atmp = name.split('.');
		if(1 === atmp.length) {
			return this.fileCls;
		}
		else {
			return this.fileCls + '-' + atmp.pop();
		}
	}
	// }}}
	// {{{
	, getPath: function(node) {
		var path, p, a;

		// get path for non-root node
		if(node !== this.root) {
			p = node.parentNode;
			a = [node.text];
			while(p && p !== this.root) {
				a.unshift(p.text);
				p = p.parentNode;
			}
			a.unshift(this.root.attributes['path'] || '');
			path = a.join(this.pathSeparator);
		}

		// path for root node is it's path attribute
		else {
			path = node.attributes['path'] || '';
		}

		// a little bit of security: strip leading / or .
		// full path security checking has to be implemented on server
		path = path.replace(/^[\/\.]*/, '');
		return path;
	}
	// }}}
	// {{{
	/**
		* returns true if node has child with the specified name (text)
		* private
		* @param {Ext.data.Node} node
		* @param {String} childName
		*/
	, hasChild: function(node, childName) {
		return (node.isLeaf() ? node.parentNode : node).findChild('text', childName) !== null;
	}
	// }}}
	// {{{
	/**
		* Install keyboard shortcuts
		* Override it if you want another shortcuts
		*/
	, installKeyMap: function() {
		
		// install keymap
		this.keymap = new Ext.KeyMap(this.getEl(), [

			// {{{
			// open
			{ 
				key: Ext.EventObject.ENTER // F2 key = edit
				, scope: this
				, fn: function(key, e) {
					var sm = this.getSelectionModel();
					var node = sm.getSelectedNode();
					if(node && 0 !== node.getDepth() && node.isLeaf()) {
						this.openNode(node);
					}
			}}
			// }}}
			// {{{
			// edit
			, { 
				key: 113 // F2 key = edit
				, scope: this
				, fn: function(key, e) {
					var sm = this.getSelectionModel();
					var node = sm.getSelectedNode();
					if(node && 0 !== node.getDepth() && this.enableRename && this.readOnly !== true) {
						this.treeEditor.triggerEdit(node);
					}
			}}
			// }}}
			// {{{
			// delete
			, {
				key: 46 // Delete key
				, stopEvent: true
				, scope: this
				, fn: function(key, e) {
					var sm = this.getSelectionModel();
					var node = sm.getSelectedNode();
					if(node && 0 !== node.getDepth() && this.enableDelete && this.readOnly !== true) {
						this.deleteNode(node);
					}
			}}
			// }}}
			// {{{
			// reload
			, {
				key: 69 // Ctrl + E = reload
				, ctrl: true
				, stopEvent: true
				, scope: this
				, fn: function(key, e) {
					var sm = this.getSelectionModel();
					var node = sm.getSelectedNode();
					if(node) {
						node = node.isLeaf() ? node.parentNode : node;
						sm.select(node);
						node.reload();
					}
			}}
			// }}}
			// {{{
			// expand deep
			, {
				key: 39 // Ctrl + Right arrow = expand deep
				, ctrl: true
				, stopEvent: true
				, scope: this
				, fn: function(key, e) {
					var sm = this.getSelectionModel();
					var node = sm.getSelectedNode();
					if(node && !node.isLeaf()) {
						sm.select(node);
						node.expand.defer(1, node, [true]);
					}
			}}
			// }}}
			// {{{
			// collapse deep
			, {
				key: 37 // Ctrl + Left arrow = collapse deep
				, ctrl: true
				, scope: this
				, stopEvent: true
				, fn: function(key, e) {
					var sm = this.getSelectionModel();
					var node = sm.getSelectedNode();
					if(node && !node.isLeaf()) {
						sm.select(node);
						node.collapse.defer(1, node, [true]);
					}
			}}
			// }}}
			// {{{
			// new directory
			, {
				key: 78 // Ctrl + N = New directory
				, ctrl: true
				, scope: this
				, stopEvent: true
				, fn: function(key, e) {
					var sm, node;
					sm = this.getSelectionModel();
					node = sm.getSelectedNode();
					if(node && this.enableNewDir && this.readOnly !== true) {
						node = node.isLeaf() ? node.parentNode : node;
						this.createNewDir(node);
					}
			}}
			// }}}
			// {{{
			// upload
			, {
				key: 85 // Ctrl + U = Upload file
				, ctrl: true
				, scope: this
				, fn: function(key, e) {
					var sm, node, fakeEvent;
					e.stopEvent();
					e.stopPropagation();
					sm = this.getSelectionModel();
					node = sm.getSelectedNode();
					if(node && this.enableUpload && this.readOnly !== true) {
						switch(this.uploadPosition) {
							case 'menu':
								fakeEvent = {
									stopEvent: Ext.emptyFn
									, preventDefault: Ext.emptyFn
								};
								this.onContextMenu(node, fakeEvent);
							break;

							case 'floating':
								node = node === this.root ? this.root : node.isLeaf() ? node.parentNode : node;
								this.createUploadForm();
								this.uploadForm.node = node;
								this.uploadForm.reloadNode = node;
								this.uploadForm.baseParams.path = this.getPath(node);
								this.uploadForm.showAt(this.uploadForm.layer.getAlignToXY(node.getUI().getEl(), 'tl-tl?', [0, 18]));
							break;
						}
					}
			}}
			// }}}

		]);
	}
	// }}}
	// {{{
	/**
		* Switch readOnly mode on/off at runtime
		*
		* @param {Boolean} true = read only, anyting = else read write 
		*/
	, setReadOnly: function(readOnly) {
		readOnly = readOnly === true;
		this.readOnly = readOnly;
		this.setRenameDisabled(readOnly);
	}
	// }}}
	// {{{
	/**
		* Set file renames disabled
		* @param {Boolean} true = disable, anything else = enable
		*/
	, setRenameDisabled: function(disable) {
		this.enableRename = disable !== true;
		if(this.dragZone) {
			this.dragZone.locked = !this.enableRename;
		}
	}
	// }}}
	// {{{
	/**
		* Set file deletes disabled
		* @param {Boolean} true = disable, anything else = enable
		*/
	, setDeleteDisabled: function(disable) {
		this.enableDelete = disable !== true;
	}
	// }}}
	// {{{
	/**
		* Set new directory disabled
		* @param {Boolean} true = disable, anything else = enable
		*/
	, setNewDirDisabled: function(disable) {
		this.enableNewDir = disable !== true;
	}
	// }}}
	// {{{
	/**
		* Set file uploads disabled
		* @param {Boolean} true = disable, anything else = enable
		*/
	, setUploadDisabled: function(disable) {
		this.enableUpload = disable !== true;
	}
	// }}}
	// {{{
	/**
		* update class of leaf after rename
		* private
		* @param {Ext.tree.TreeNode} node Node to update class of
		* @param {String} oldName Name the node had before
		*/
	, updateCls: function(node, oldName) {
		if(node.isLeaf()) {
			node.getUI().removeClass(this.getFileCls(oldName));
			node.getUI().addClass(this.getFileCls(node.text));
		}
	}
	// }}}

	// overrides
	// {{{
	/**
		* Tree render function (calls parent and fires render event afterwards)
		* private
		*/
	, render: function() {
		Ext.tree.TreePanel.prototype.render.call(this);
		this.fireEvent('render', this);
	}
	// }}}

});

// do not start editor on selected node click
Ext.override(Ext.tree.TreeEditor, {
	beforeNodeClick: function(node, e) {
		return true;
	}
});

// end of file
