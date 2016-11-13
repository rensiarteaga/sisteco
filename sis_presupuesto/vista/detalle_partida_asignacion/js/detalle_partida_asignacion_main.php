<?php
/**
 * Nombre:		  	    rol_metaproceso_det_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-01 08:36:14
 *
 */
session_start();

?>
//<script>


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
	     	id_presupuesto:decodeURIComponent('<?php echo utf8_decode($id_presupuesto);?>'),
	     	nombre_financiador:decodeURIComponent('<?php echo utf8_decode($nombre_financiador);?>'),
	     	nombre_regional:decodeURIComponent('<?php echo utf8_decode($nombre_regional);?>'),
	     	nombre_programa:decodeURIComponent('<?php echo utf8_decode($nombre_programa);?>'),
	     	nombre_proyecto:decodeURIComponent('<?php echo utf8_decode($nombre_proyecto);?>'),
	     	nombre_actividad:decodeURIComponent('<?php echo utf8_decode($nombre_actividad);?>'),
	     	tipo_pres:decodeURIComponent('<?php echo utf8_decode($tipo_pres);?>'),
	     	tipo_presupuesto:decodeURIComponent('<?php echo utf8_decode($tipo_presupuesto);?>'),
	     	estado_gral:decodeURIComponent('<?php echo utf8_decode($estado_gral);?>'),
	     	id_parametro:decodeURIComponent('<?php echo utf8_decode($id_parametro);?>')
};
	     	
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_detalle_partida_asignacion(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};

ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_rol_metaproceso_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-01 08:36:14
 */
function pagina_detalle_partida_asignacion(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
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
	var cmMaestro = new Ext.grid.ColumnModel(
	[{header:" ",width:180,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo1'},
	 {header:" ",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor1'},
	 {header:" ",width:100,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo2'},
	 {header:" ",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor2'}
	 ]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo1','valor1','atributo2','valor2'],data:[ ['Presupues:to de:',maestro.tipo_pres,'Programa:',maestro.nombre_programa],
																																				['Regional:',maestro.nombre_regional,'Proyecto:',maestro.nombre_proyecto],
																																				['Organismo Financiador:',maestro.nombre_financiador,'Actividad:',maestro.nombre_actividad]]}),cm:cmMaestro});
																																				
	gridMaestro.render();

	/////////////////////
	//DATA STORE COMBOS//
	/////////////////////

	//FUNCIONES RENDER
	
	function render_id_metaproceso(value, p, record){return String.format('{0}', record.data['desc_metaproceso']);};
    function render_id_subsistema(value, p, record){return String.format('{0}', record.data['nombre_corto']);};
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	vectorAtributos[0]= {
		validacion:{
			
			labelSeparator:'',
			name: 'id_partida_presupuesto',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_partida_presupuesto'
	};
	// txt id_partida
	vectorAtributos[1]= {
		validacion:{
			name:'id_partida',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_partida'
	};
	vectorAtributos[2]= {
		validacion:{
			name:'id_presupuesto',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_presupuesto,
		save_as:'hidden_id_presupuesto'
	};
	
	//var DatosNodo=new Array('id','id_p','tipo','id_reg');
	var DatosNodo=new Array('id','id_p','tipo');
	//datos por defecto para los nuevos nodos que se creen en la vista
	/*var DatosDefecto={
				raiz:{text:0,icon:"../../../lib/imagenes/item.png",allowDelete:false,allowEdit:true},
				rama:{text:0,icon:"../../../lib/imagenes/tuc.png",allowDelte:true,allowEdit:true},
				hoja:{text:0,icon:"../../../lib/imagenes/item.png",allowDelete:true,allowEdit:false}
	}*/
	var DatosDefecto={
		agrupador:  {text:0,icon:"../../../lib/imagenes/tuc.png",allowDrag:false,allowDelete:true,allowEdit:true,terminado:'false'},
		Movimiento:{text:0,icon:"../../../lib/imagenes/tucr_.png",allowDrag:false,allowDelete:true,allowEdit:true,terminado:'false'},
		Titular:{	text:0,icon:"../../../lib/imagenes/tucr.png",allowDrag:false,allowDelete:true,allowEdit:true,terminado:'false'}
	}

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo:'Rol (Maestro)'};
	layout_partida_presupuesto_asignacion = new DocsLayoutArb(idContenedor);
	layout_partida_presupuesto_asignacion.init(config);
	
	//---------- INICIAMOS HERENCIA
	//alert(PaginaArb);
	this.pagina = PaginaArb;
	this.pagina(paramConfig,vectorAtributos,layout_partida_presupuesto_asignacion,idContenedor,DatosNodo,DatosDefecto);
	
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
			titulo:'Tipo Unidad Constructiva'
		},
		Listar:{
			url:direccion+'../../../../sis_presupuesto/control/partida_presupuesto/ActionListarDetallePartidaAsignacion.php',
			baseParams:{id_presupuesto:maestro.id_presupuesto,tipo_pres:maestro.tipo_presupuesto,estado_gral:maestro.estado_gral,id_parametro:maestro.id_parametro},
			allowDrag:true,
			allowDrop:true,
			clearOnLoad:true,
			text:maestro.nombre,
			rootVisible:true,
			lines:true,
			cls:'root'
		}
	};

	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		
		maestro.id_presupuesto=datos.m_id_presupuesto;
		maestro.tipo_pres=datos.m_tipo_pres;
		maestro.nombre_financiador=datos.m_nombre_financiador;
		maestro.nombre_regional=datos.m_nombre_regional;
		maestro.nombre_programa=datos.m_nombre_programa;
		maestro.nombre_proyecto=datos.m_nombre_proyecto;
		maestro.nombre_actividad=datos.m_nombre_actividad;
		maestro.tipo_presupuesto=datos.m_tipo_presupuesto;
		maestro.estado_gral=datos.m_estado_gral;
		maestro.id_parametro=datos.m_id_parametro;
		
		gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([ ['Presupuesto de ',maestro.tipo_pres,'Programa',maestro.nombre_programa],
												['Regional',maestro.nombre_regional ,'Proyecto',maestro.nombre_proyecto],
												['Financiador',maestro.nombre_financiador,'Actividad',maestro.nombre_actividad]]);
		paramFunciones.Listar.baseParams={id_presupuesto:maestro.id_presupuesto};
		getLoader().baseParams.id_presupuesto=maestro.id_presupuesto;
		getLoader().baseParams.tipo_pres=maestro.tipo_presupuesto;
		getLoader().baseParams.id_parametro=maestro.id_parametro;
		
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
		cmpId_partida=getComponente("id_partida");
		cmpSw_transaccional=getComponente("sw_transaccional");
		getTreePanel().on('checkchange',selecciones); 
				
		function   selecciones(e,r){
			existe=-1;	
			bool_existe=false;
			if(r==true){
	   			if(e.attributes.sw_transaccional==2&&e){
	  				Ext.MessageBox.confirm("Atención","Se asignara todas las partidas de movimiento dependientes ¿Continuar?",
					function(btn){if(btn=='yes'){
						var  nodo={};
			            if(e.attributes.tipo=='item'){
			            	nodo['id_partida']=e.attributes.id;
			            }
						nodo['id_partida']=e.attributes.id;
						nodo['id_presupuesto']=maestro.id_presupuesto;
						var postData='datos='+encodeURIComponent(Ext.encode(nodo))+'&proc=add';
					
						Ext.Ajax.request({
							url:direccion+'../../../../sis_presupuesto/control/partida_presupuesto/ActionGuardarDetallePartidaAsignacion.php?id_presupuesto_0='+maestro.id_presupuesto+'&id_partida_0='+e.attributes.id,
							
							params: postData,
							method:'POST',
							success:guardarSuccessDrop,
							
							failure:fallaDropItem,
							timeout:paramConfig.TiempoEspera
						});		
					} 
				else
				{   
					e.parentNode.reload();
				}});}
				
			else{var  nodo={};
	            if(e.attributes.tipo=='item'){
	            	nodo['id_partida']=e.attributes.id;
	            }
				nodo['id_partida']=e.attributes.id;
				nodo['id_presupuesto']=maestro.id_presupuesto;
				var postData='datos='+encodeURIComponent(Ext.encode(nodo))+'&proc=add';
				Ext.Ajax.request({
					url:direccion+'../../../../sis_presupuesto/control/partida_presupuesto/ActionGuardarDetallePartidaAsignacion.php?id_presupuesto_0='+maestro.id_presupuesto+'&id_partida_0='+e.attributes.id,
					
					params: postData,
					method:'POST',
					success:guardarSuccessDrop,
					
					failure:fallaDropItem,
					timeout:paramConfig.TiempoEspera
				});}
				  	 	
			}else{
				if(r==false){
					var  nodo={};
					if(e.attributes.tipo=='item'){
					nodo['id_partida']=e.attributes.id;
					}
					nodo['id_partida']=e.attributes.id;
					nodo['id_presupuesto']=maestro.id_presupuesto;
														
				 	var postData='datos='+encodeURIComponent(Ext.encode(nodo))+'&proc=del';
					Ext.Ajax.request({
						url:direccion+'../../../../sis_presupuesto/control/partida_presupuesto/ActionEliminarDetallePartidaAsignacion.php?id_presupuesto_0='+maestro.id_presupuesto+'&id_partida_0='+e.attributes.id,
						params: postData,
						method:'POST',
						success: gSuccess,
						failure:fallaDropItem,
						timeout:paramConfig.TiempoEspera
					});
				}	
			}
		}
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