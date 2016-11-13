/**
 * Nombre:		  	    pagina_usuario_rol_det_arb.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-01 08:36:14
 */
function pagina_usuario_rol_det_arb(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
	var xt = Ext.tree;
	var cmpId_metaproceso;
	var asignados= new Array();
	var cont=0;
	var existe=-1;
	var bool_existe=false;
	
	var Atributos=[];

	var Dialog;
	var layout;
	/////////////////
	//  DATA STORE //
	/////////////////

	// DEFINICIÓN DATOS DEL MAESTRO
	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Rol',maestro.id_usuario],['Nombre',maestro.apellido_paterno]]}),cm:cmMaestro});
	gridMaestro.render();
	
	
	
	/////////////////////
	//DATA STORE COMBOS//
	/////////////////////
 ds_rol = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/rol/ActionListarRol_det.php?txt_usuario='+maestro.id_usuario}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_rol',
			totalRecords: 'TotalCount'
		}, ['id_rol','nombre','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','descripcion'])
	});



	//FUNCIONES RENDER
	
	function render_id_rol(value, p, record){return String.format('{0}', record.data['desc_rol']);};
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	vectorAtributos[0]= {
		validacion:{
			labelSeparator:'',
			name: 'id_usuario_rol',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_usuario_rol',
		id_grupo:0
	};
	 
// txt id_rol
	vectorAtributos[1]= {
			validacion: {
			name:'id_rol',
			fieldLabel:'Rol',
			allowBlank:false,			
			emptyText:'Id Rol...',
			desc: 'desc_rol', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_rol,
			valueField: 'id_rol',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'RROOLL.nombre',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_rol,
			grid_visible:true,
			grid_editable:true,
			width_grid:200 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'RROOLL.nombre',
		defecto: '',
		save_as:'txt_id_rol',
		id_grupo:1
	};
	
// txt id_usuario
	vectorAtributos[2]= {
		validacion:{
			name:'id_usuario',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_usuario,
		save_as:'txt_id_usuario',
		id_grupo:0
	};
	

	vectorAtributos[3]= {
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:true,
			maxLength:1000000,
			minLength:0,
			selectOnFocus:true,
			grid_visible:false,
			grid_editable:true,
			width_grid:200,
			width:'100%'
		},
		tipo: 'TextArea',
		filtro_0:false,
		filtro_1:false,
		filterColValue:'RROOLL.descripcion',
		save_as:'txt_descripcion',
		id_grupo:2
	};
	
		
	
	var DatosNodo=new Array('id','id_p','tipo','id_reg');
	//datos por defecto para los nuevos nodos que se creen en la vista
	var DatosDefecto={
		raiz:{
			text:0,
			icon:"../../../lib/imagenes/item.png",
			allowDelete:false,
			allowEdit:true

		},
		rama:{
			text:0,//indice del atributo
			icon:"../../../lib/imagenes/tuc.png",
			allowDelte:true,
			allowEdit:true
		},
		hoja:{
			text:0,//indice del atributo
			icon:"../../../lib/imagenes/item.png",
			allowDelete:true,
			allowEdit:false
		}
	}
	
	//----------- FUNCIONES RENDER
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={
		titulo:'Rol (Maestro)'
	};
		layout_rol_metaproceso = new DocsLayoutArb(idContenedor);
		layout_rol_metaproceso.init(config);
	
	

	//---------- INICIAMOS HERENCIA
	this.pagina = PaginaArb;
	this.pagina(paramConfig,vectorAtributos,layout_rol_metaproceso,idContenedor,DatosNodo,DatosDefecto);


	
	//----------   herencia de la clase madre -------//
	var getTreePanel = this.getTreePanel;
	var getTreeRaiz = this.getTreeRaiz;
	var getLoader= this.getLoader;
	var conexionFailure=this.conexionFailure;
	var btnEdit=this.btnEdit;
	var btnNew=this.btnNew;
	var btnNewRaiz=this.btnNewRaiz;
	var btnEliminar=this.btnEliminar;
	var getComponente=this.getComponente;
	var getSm=this.getSm;
	var ocultarComponente=this.ocultarComponente;
	var mostrarComponente=this.mostrarComponente;
	var guardarSuccess=this.guardarSuccess;
	var getDialog=this.getDialog;
	var ocultarFormulario=this.ocultarFormulario;
	
	


	/////////////////////////////
	// parametros las funciones//
	////////////////////////////

	var paramFunciones = {
		
		Basicas:{
		},
		Formulario:{
			height:430,
			width:480,
			minWidth:150,
			minHeight:200,
			closable:true,
			titulo:'Rol'
		},
		Listar:{
			url:direccion+'../../../../sis_seguridad/control/rol/ActionListarRol_detArb.php',
			baseParams:{id_usuario:maestro.id_usuario},
			allowDrag:true,
			allowDrop:true,
			clearOnLoad:true,
			text:maestro.apellido_paterno,
			rootVisible:true,
			lines:true,
			cls:'root'
		}
	};

	
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_usuario=datos.id_usuario;
		maestro.apellido_paterno=datos.m_apellido_paterno;

		gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['Rol',maestro.id_usuario],['Nombre',maestro.apellido_paterno]]);
		paramFunciones.Listar.baseParams={id_usuario:maestro.id_usuario};
		this.getTreeRaiz().setText(maestro.apellido_paterno);
		getLoader().baseParams.id_usuario=maestro.id_usuario;
		
		this.InitFunciones(paramFunciones);
		this.btnActualizar()
};

	
	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//



	////////////////////////////////////////
	//  FUnciones Propias                 //
	////////////////////////////////////////

	var paramMenu={
		actualizar:{crear:true,separador:false}
	};

    // some functions to determine whether is not the drop is allowed
    function hasNode(t, n){
        return t.parentNode.findChild('id', n.id);
        
    };

	function isSourceCopy(e, n){
		var a = e.target.attributes;
		alert("e.point  " + e.point)
		return hasNode(e.target,n);
	};

	function isReorder(e, n){
        return n.parentNode == e.target.parentNode && e.point != 'append';
    };

	function iniciarEventos(){
		Dialog=getDialog();
		Dialog.addButton("Declinar",ocultarFormulario);
		Dialog.buttons[2].hide();
		var treLoader=getLoader();
	
		cmpId_metaproceso=getComponente("id_usuario");
				
				getTreePanel().on('checkchange', function(e,r){
				  existe=-1;	
				  bool_existe=false;
				  
				  if(r==true){
				   /*
				            var  nodo={};
				            if(e.attributes.tipo=='item'){
				              nodo['id_metaproceso_db']=e.attributes.id;
				            }
							nodo['id_metaproceso']=e.attributes.id;
							nodo['id_rol']=maestro.id_rol;
							
							
							var postData='datos='+encodeURIComponent(Ext.encode(nodo))+'&proc=add';
							
					
							Ext.Ajax.request({
							url:direccion+'../../../../sis_seguridad/control/rol_metaproceso/ActionGuardarRolMetaproceso.php?id_rol='+maestro.id_rol,
							
							params: postData,
							method:'POST',
							success:guardarSuccessDrop,
							
							failure:fallaDropItem,
							timeout:paramConfig.TiempoEspera
							});*/
				  	 	
				  }else{
				  if(r==false){
				  	
				  			/*var  nodo={};
				  			if(e.attributes.tipo=='item'){
				              nodo['id_metaproceso_db']=e.attributes.id;
				            }
							nodo['id_metaproceso']=e.attributes.id;
							nodo['id_rol']=maestro.id_rol;
														
				 		  var postData='datos='+encodeURIComponent(Ext.encode(nodo))+'&proc=del';
				 		  
					      Ext.Ajax.request({
						     url:direccion+'../../../../sis_seguridad/control/rol_metaproceso/ActionEliminarRolMetaproceso.php',
						 	 params: postData,
							 method:'POST',
							 success: gSuccess,
							 failure:fallaDropItem,
							 timeout:paramConfig.TiempoEspera
					});*/
						
						
						 
				  }	
				}
			   
				
				
			});
	}
	
	       

	function guardarSuccessDrop(resp){
		
		var n = getSm().getSelectedNode();
		var sm= getTreePanel().getSelectionModel();
		sm.reload;
	}
	
	function fallaDropItem(resp,b,c){
		conexionFailure(resp,b,c);
	}
	
	
	
	function gSuccess(r){
		var n = getSm().getSelectedNode();
		var sm= getTreePanel().getSelectionModel();
		sm.reload
	}

    this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	this.Init(); //iniciamos la clase madre
	this.iniciaFormulario();
	iniciarEventos()
}