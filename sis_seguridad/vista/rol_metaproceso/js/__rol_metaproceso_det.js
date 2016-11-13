/**
 * Nombre:		  	    pagina_rol_metaproceso_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-01 08:36:14
 */
function pagina_rol_metaproceso_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
	var xt = Ext.tree;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/rol_metaproceso/ActionListarRolMetaproceso_det.php?m_id_rol='+maestro.id_rol}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_rol_metaproceso',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_rol_metaproceso',
		'id_rol',
		'desc_rol',
		'desc_metaproceso',
		'id_metaproceso',
		'nombre_corto'

		]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_rol:maestro.id_rol
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO
var dataMaestro=[['Rol',maestro.id_rol],['Nombre',maestro.nombre]];

	var dsMaestro = new Ext.data.Store({proxy: new Ext.data.MemoryProxy(dataMaestro),reader: new Ext.data.ArrayReader({id:0},[{name:'atributo'},{name:'valor'}])});
	dsMaestro.load();
	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:dsMaestro,cm:cmMaestro});
	gridMaestro.render();
	
	
//	function createXmlTree() {
//		alert("lega");
//    	var tree = new Ext.tree.TreePanel(idContenedor);
//    	//var postData=''
//		var p = new Ext.data.HttpProxy({url:direccion+'../../../control/metaproceso/ActionListarMetaproceso.php'},
//					{reader: new Ext.data.XmlReader({
//						record: 'ROWS',
//						id: 'id_metaproceso',
//						totalRecords: 'TotalCount'
//				}, ['id_metaproceso','id_subsistema','fk_id_metaproceso','nivel','nombre','codigo_procedimiento','nombre_achivo','ruta_archivo','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','descripcion','visible','habilitar_log','orden_logico','icono','nombre_tabla','prefijo','codigo_base','tipo_vista','con_ep','con_interfaz','num_datos_hijo'])
//	});
//		p.on("loadexception", function(o, response, e) {
//		if (e) throw e;
//	});
//		p.load(null, {
//		read: function(response) {
//			var doc = response.responseXML;
//			tree.setRootNode(treeNodeFromXml(doc.documentElement || doc));
//			alert("nodo"+tree.getRootNode());
//		}
//	}, tree.render, tree);
//		return tree;
//   }
// 
/**
	Create a TreeNode from an XML node
*/
//function treeNodeFromXml(XmlEl) {
////	Text is nodeValue to text node, otherwise it's the tag name
//	var t = ((XmlEl.nodeType == 3) ? XmlEl.nodeValue : XmlEl.tagName);
//
////	No text, no node.
//	if (t.replace("/\s/g,''").length == 0) {
//		return null;
//	}
//	var result = new Ext.tree.TreeNode({
//        text : t
//    });
//
////	For Elements, process attributes and children
//	if (XmlEl.nodeType == 1) {
//		Ext.each(XmlEl.attributes, function(a) {
//			var c = new Ext.tree.TreeNode({
//				text: a.nodeName
//			});
//			c.appendChild(new Ext.tree.TreeNode({
//				text: a.nodeValue
//			}));
//			result.appendChild(c);
//		});
//		Ext.each(XmlEl.childNodes, function(el) {
////		Only process Elements and TextNodes
//			if ((el.nodeType == 1) || (el.nodeType == 3)) {
//				var c = treeNodeFromXml(el);
//				if (c) {
//					result.appendChild(c);
//				}
//			}
//		});
//	}
//	return result;
//}
	
	
	
	
	
	
	
	
	
	
	
	
	/*var d_menu = Ext.DomHelper.append(idContenedor, {tag: 'div',id:'grid_detalle-'+idContenedor});
		menu=new  Ext.ContentPanel(d_menu,{title:'Menú de Navegación',fitToFrame:true,closable:false});
		menu.load({url:'../../control/menu/ActionListaPermiso.php',scripts:true});
		/*var gridMaestro= new Ext.grid.Grid(menu,{ds:dsMaestro,cm:cmMaestro});
		gridMaestro.render();
	*/
		
	
	/*var stree = new xt.TreePanel(idContenedor, {
        animate:true,
        loader: new xt.TreeLoader({proxy: new Ext.data.HttpProxy({url:direccion+'../../../control/metaproceso/ActionListarMetaproceso_det.php'})}),
        enableDrag:true,
        containerScroll: true
	} );

    new xt.TreeSorter(stree, {folderSort:true});

    var sroot = new xt.AsyncTreeNode({
        text: 'Prueba Arbol',
        draggable:false,
        id:'grid_detalle-'+idContenedor
    });
    stree.setRootNode(sroot);
    stree.render();
    sroot.expand(false, false);

    var ctree = new xt.TreePanel(idContenedor, {
        animate:true,
        enableDD:true,
        containerScroll: true,
        lines:false,
        rootVisible:false,
        loader: new Ext.tree.TreeLoader()
    });
    
    
    ctree.el.addKeyListener(Ext.EventObject.DELETE, removeNode);
    
       var croot = new xt.AsyncTreeNode({
        allowDrag:false,
        allowDrop:true,
        id:'croot',
        text:'Packages and Components',
        cls:'croot',
        /*loader:new Ext.tree.TreeLoader({
            dataUrl:'dep-tree.json',
            createNode: readNode
        })*/
   /* });
    ctree.setRootNode(croot);
    ctree.render();
    croot.expand();
	/***/
	
	
	/*function removeNode(){
        var n = sm.getSelectedNode();
        if(n && n.attributes.allowDelete){
            ctree.getSelectionModel().selectPrevious();
            n.parentNode.removeChild(n);
        }
    }
    
     function hasNode(t, n){
        return (t.attributes.type == 'fileCt' && t.findChild('id', n.id)) ||
            (t.leaf === true && t.parentNode.findChild('id', n.id));
    };

    function isSourceCopy(e, n){
        var a = e.target.attributes;
        return n.getOwnerTree() == stree && !hasNode(e.target, n) &&
           ((e.point == 'append' && a.type == 'fileCt') || a.leaf === true);
    };

    function isReorder(e, n){
        return n.parentNode == e.target.parentNode && e.point != 'append';
    };

    // handle drag over and drag drop
    ctree.on('nodedragover', function(e){
        var n = e.dropNode;
        return isSourceCopy(e, n) || isReorder(e, n);
    });
    
    var sm = ctree.getSelectionModel();
    sm.on('selectionchange', function(){
        var n = sm.getSelectedNode();
        if(!n){
			//btns.remove.disable();
            //btns.option.disable();
            alert("!nodo sin seleccionar");
            return;
        }
        var a = n.attributes;
        alert("nodo seleccionado");
        //btns.remove.setDisabled(!a.allowDelete);
        //btns.option.setDisabled(!a.cmpId);
    });

     ctree.on('beforenodedrop', function(e){
        var n = e.dropNode;

        ctree.on('nodedragover', function(e){
        var n = e.dropNode;
        return isSourceCopy(e, n) || isReorder(e, n);
    });
        
        // copy node from source tree
        if(isSourceCopy(e, n)){
            var copy = new xt.TreeNode(
                Ext.apply({allowDelete:true,expanded:true}, n.attributes)
            );
            copy.loader = undefined;
            if(e.target.attributes.options){
                e.target = createOption(e.target, copy.text);
                //return false;
            }
            e.dropNode = copy;
            return true;
        }

        return isReorder(e, n);
    });
    
    
     var layout = new Ext.BorderLayout(idContenedor, {
        west: {
            split:true,
            initialSize: 200,
            minSize: 175,
            maxSize: 400,
            titlebar: true,
            margins:{left:5,right:0,bottom:5,top:5}
        },
        center: {
            title:'Components',
            margins:{left:0,right:5,bottom:5,top:5}
        }
    }, idContenedor);
    
    */
    
    
	//layoutContenedorPrincipal.add('west',menu);
	
	///////////////////
	
	//DATA STORE COMBOS
  
    ds_metaproceso = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/metaproceso/ActionListarMetaproceso_det.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_metaproceso',
			totalRecords: 'TotalCount'
		}, ['id_metaproceso','id_subsistema','fk_id_metaproceso','nivel','nombre','codigo_procedimiento','nombre_achivo','ruta_archivo','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','descripcion','visible','habilitar_log','orden_logico','icono','nombre_tabla','prefijo','codigo_base','tipo_vista','con_ep','con_interfaz','num_datos_hijo'])
	});
	//ds_subsistema
	ds_subsistema = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/subsistema/ActionListarSubsistema.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_subsistema',
			totalRecords: 'TotalCount'
		}, ['id_subsistema','nombre_corto','nombre_largo','descripcion','version_desarrollo','desarrolladores','fecha_reg','hora_reg','fecha_ultima_modificacion','hora_ultima_modificacion','observaciones'])
	});


	//FUNCIONES RENDER
	
			function render_id_metaproceso(value, p, record){return String.format('{0}', record.data['desc_metaproceso']);};
	        function render_id_subsistema(value, p, record){return String.format('{0}', record.data['nombre_corto']);};
	
	        var resultTplMetaproceso=new Ext.Template(
				'<div class="search-item">',
				'<b><i>{nombre}</i></b>',
				'<br><FONT COLOR="#B5A642">{descripcion}</FONT>',
				'<br><FONT COLOR="#B5A642">{nivel}{codigo_procedimiento}</FONT>',
				'</div>'
			);
	        
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_rol_metaproceso
	//en la posición 0 siempre esta la llave primaria

	var param_id_rol_metaproceso = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_rol_metaproceso',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_rol_metaproceso'
	};
	vectorAtributos[0] = param_id_rol_metaproceso;
// txt id_rol
	var param_id_rol= {
		validacion:{
			name:'id_rol',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_rol,
		save_as:'txt_id_rol'
	};
	vectorAtributos[1] = param_id_rol;
	// txt id_metaproceso
	var param_id_subsistema= {
			validacion: {
			name:'id_subsistema',
			fieldLabel:'Subsistema',
			allowBlank:false,			
			emptyText:'Subsistema...',
			desc: 'nombre_corto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_subsistema,
			onSelect:function(record){
				componentes[2].setValue(record.data.id_subsistema);
				componentes[2].collapse();
				componentes[3].setValue(record.data.id_subsistema);
				onSelectSubsistema();
			},
			valueField: 'id_subsistema',
			displayField: 'nombre_corto',
			queryParam: 'filterValue_0',
			filterCol:'SUBSIS.nombre_corto',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:150,
			grow:true,
			width:'100%',
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_subsistema,
			grid_visible:true,
			grid_editable:true,
			width_grid:150 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SUBSIS.nombre_corto',
		defecto: '',
		save_as:'txt_id_subsistema',
		id_grupo:0
	};
	vectorAtributos[2] = param_id_subsistema;

// txt id_metaproceso
	var param_id_metaproceso= {
			validacion: {
			name:'id_metaproceso',
			fieldLabel:'Metaproceso',
			allowBlank:false,			
			emptyText:'Metaproceso...',
			desc: 'desc_metaproceso', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_metaproceso,
			valueField: 'id_metaproceso',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'METAPR.nombre#METAPR.nivel#METAPR.codigo_procedimiento',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:300,
			grow:true,
			width:'100%',
			tpl:resultTplMetaproceso,
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_metaproceso,
			grid_visible:true,
			grid_editable:false,
			width_grid:300 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.nombre#METPRO.codigo_procedimiento',
		defecto: '',
		save_as:'txt_id_metaproceso',
		id_grupo:0
	};
	vectorAtributos[3] = param_id_metaproceso;

	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={
		titulo_maestro:'Rol (Maestro)',
		titulo_detalle:'Rol Metaproceso (Detalle)',
		grid_maestro:'grid-'+idContenedor
	};
		layout_rol_metaproceso = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
		layout_rol_metaproceso.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_rol_metaproceso,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	//-------- DEFINICIÓN DE LA BARRA DE MENÚ
	

	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	
	//--------- DEFINICIÓN DE FUNCIONES
	//aquí se parametrizan las funciones que se ejecutan en la clase madre
	
	//datos necesarios para el filtro
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/rol_metaproceso/ActionEliminarRolMetaproceso.php',parametros:'&m_id_rol='+maestro.id_rol},
	Save:{url:direccion+'../../../control/rol_metaproceso/ActionGuardarRolMetaproceso.php',parametros:'&m_id_rol='+maestro.id_rol},
	ConfirmSave:{url:direccion+'../../../control/rol_metaproceso/ActionGuardarRolMetaproceso.php'},
	Formulario:{
			titulo:'Rol Metaproceso',
			html_apply:"dlgInfo-"+idContenedor,
			width:'40%',
			height:'30%',
			minWidth:100,
			minHeight:150,
			columnas:['95%'],
			closable:true,
			grupos:[
			{
				tituloGrupo:'Asignar Metaproceso',
				columna:0,
				id_grupo:0
			}
			]
		}
	};

	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	function iniciarEventosFormularios(){
		//combo_subsistema = ClaseMadre_getComponente('id_financiador');
		
	
		for(i=0;i<vectorAtributos.length;i++)
		{
			
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name);
			
		}
		sm=getSelectionModel();
		
		//createXmlTree();
		
		
		
	}
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_rol_metaproceso.getLayout();
	};

    function onSelectSubsistema(){
    ds_metaproceso.baseParams={
			m_id_subsistema:componentes[2].getValue()}
		;
      //m_id_subsistema=componentes[3].getValue();
      componentes[3].modificado=true;
      componentes[3].setValue('');
    }

	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i];
			}
		}
	};
	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	
	layout_rol_metaproceso.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}