<?php
/**
 * Nombre:		  	    rol_metaproceso_det_main.php
 * Prop�sito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creaci�n:		2007-11-01 08:36:14
 *
 */
session_start();
?>
//<script>
var paginaTipoActivo;

	function main(){
	 	<?php
		//obtenemos la ruta absoluta
		$host  = $_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$dir = "http://$host$uri/";
		echo "\nvar direccion='$dir';";
	    echo "var idContenedor='$idContenedor';";
	?>
	var fa;
	<?php if($_SESSION["ss_filtro_avanzado"]!=''){
		echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}
	?>
var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var maestro={
		m_id_almacen:<?php echo $m_id_almacen;?>,
		m_id_item:<?php echo $m_id_item;?>,
		m_desc_item:'<?php echo $desc_item;?>',
		m_desc_almacen:'<?php echo $desc_almacen;?>'};

idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_ubicacion_item_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};

ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);


function pagina_ubicacion_item_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
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

	// DEFINICI�N DATOS DEL MAESTRO
	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Almacen',maestro.m_desc_almacen],['Item',maestro.m_desc_item]]}),cm:cmMaestro});
	gridMaestro.render();
	
	

	/////////////////////////
	// Definici�n de datos //
	/////////////////////////
	
	vectorAtributos[0]= {
		validacion:{
			
			labelSeparator:'',
			name: 'id_ubicacion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'h_id_ubicacion'
	};
	 
	vectorAtributos[1]= {
		validacion:{
			name:'id_ubicacion_fk',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_rol,
		save_as:'h_id_ubicacion_fk'
	};

	vectorAtributos[2]= {
		validacion:{
			name:'id_ubicacion_fk',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_rol,
		save_as:'h_id_ubicacion_fk'
	};
/*	
	// txt id_metaproceso
	vectorAtributos[2]= {
			validacion: {
			name:'id_subsistema',
			fieldLabel:'Subsistema',
			allowBlank:false,			
			emptyText:'Subsistema...',
			desc: 'nombre_corto',
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
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1,
			triggerAction:'all',
			editable:true,
			renderer: render_id_subsistema,
			grid_visible:true,
			grid_editable:true,
			width_grid:150 
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'SUBSIS.nombre_corto',
		defecto: '',
		save_as:'txt_id_subsistema',
		id_grupo:0
	};
	

// txt id_metaproceso
	vectorAtributos[3]= {
			validacion: {
			name:'id_metaproceso',
			fieldLabel:'Metaproceso',
			allowBlank:false,			
			emptyText:'Metaproceso...',
			desc: 'desc_metaproceso',
			store:ds_metaproceso,
			valueField: 'id_metaproceso',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'METPRO.nombre#METPRO.descripcion',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:300,
			grow:true,
			width:'100%',
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, 
			triggerAction:'all',
			editable:true,
			renderer:render_id_metaproceso,
			grid_visible:true,
			grid_editable:false,
			width_grid:300
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'METPRO.nombre',
		defecto: '',
		save_as:'txt_id_metaproceso',
		id_grupo:0
	};
	*/
		
	
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
	var btnActualizar=this.btnActualizar;
	
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
			titulo:'Ubicacion item'
		},
		Listar:{
			url:direccion+'../../../../sis_almain/control/ubicacion_item/ActionListarUbicacionItem.php',
			baseParams:{id_almacen:maestro.m_id_almacen,id_item:maestro.m_id_item},
			allowDrag:true,
			allowDrop:true,
			clearOnLoad:true,
			text:maestro.m_desc_almacen,
			rootVisible:true,
			lines:true,
			cls:'root'
		}
	};

	
	this.reload=function(params)
	{
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.m_id_almacen=datos.m_id_almacen;
		maestro.m_id_item=datos.m_id_item;
		maestro.m_desc_item=datos.m_desc_item;
		maestro.m_desc_almacen=datos.m_desc_almacen;

		gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['Almacen',maestro.m_desc_almacen],['Item',maestro.m_desc_item]]);
		paramFunciones.Listar.baseParams={id_almacen:maestro.m_id_almacen,id_item:maestro.m_id_item};
		this.getTreeRaiz().setText(maestro.m_desc_almacen);
		getLoader().baseParams.id_almacen=maestro.m_id_almacen;
		getLoader().baseParams.id_item=maestro.m_id_item;
		
		this.InitFunciones(paramFunciones);
		this.btnActualizar()
	};

	
	
	//-------------- DEFINICI�N DE FUNCIONES PROPIAS --------------//



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

	/*function isReorder(e, n){
        return n.parentNode == e.target.parentNode && e.point != 'append';
    };*/

	function iniciarEventos()
	{
		Dialog=getDialog();
		Dialog.addButton("Declinar",ocultarFormulario);
		Dialog.buttons[2].hide();
		var treLoader=getLoader();
	
		cmpId_metaproceso=getComponente("id_ubicacion");
				
				getTreePanel().on('checkchange', function(e,r){
				  existe=-1;	
				  bool_existe=false;
				  
				if(r==true)
				{
				   
				            var  nodo={};
				           
							nodo['id_ubicacion']=e.attributes.id;
							nodo['id_item']=maestro.m_id_item;
							nodo['id_almacen']=maestro.m_id_almacen;							
							nodo['tipo']=e.attributes.tipo;
							
							var postData='datos='+encodeURIComponent(Ext.encode(nodo))+'&proc=add';
							
					
							Ext.Ajax.request({
							url:direccion+'../../../../sis_almain/control/ubicacion_item/ActionGuardarUbicacionItem.php',
							
							params: postData,
							method:'POST',
							success: guardarSuccessDrop,
							failure:fallaDropItem,
							timeout:paramConfig.TiempoEspera
							});
				 }
				  else
				 {
					  if(r==false)
					  {
					  	
					  			var  nodo={};
					  		
					  			nodo['id_ubicacion']=e.attributes.id;
								nodo['id_item']=maestro.m_id_item;
								nodo['id_almacen']=maestro.m_id_almacen;							
								nodo['tipo']=e.attributes.tipo;
															
					 		  var postData='datos='+encodeURIComponent(Ext.encode(nodo))+'&proc=del';
					 		  
						      Ext.Ajax.request({
							     url:direccion+'../../../../sis_almain/control/ubicacion_item/ActionEliminarUbicacionItem.php',
							 	 params: postData,
								 method:'POST',
								 success: gSuccess,
								 failure:fallaDropItem,
								 timeout:paramConfig.TiempoEspera
						});							 
					  }	
				}
			   
				
				
			});
	}
	
	function guardarSuccessDrop(resp){
		
		var n = getSm().getSelectedNode();
		var sm= getTreePanel().getSelectionModel();
		sm.reload;

		var regreso=Ext.util.JSON.decode(resp.responseText)
		if(regreso.success == 'false')
		{
			Ext.MessageBox.alert('Estado','Error de inserci�n, verifique que los datos del nodo seleccionado para el registro.');
			btnActualizar();
		}
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
	iniciarEventos();
}