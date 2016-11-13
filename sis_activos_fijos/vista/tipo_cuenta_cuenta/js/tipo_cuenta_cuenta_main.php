<?php
/**
 * Nombre:		  	    tipo_cuenta_cuenta_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-01 08:36:14
 *
 */
session_start();
?>
//<script>
var paginaTipoCuentaCuenta;

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
	     	id_tipo_cuenta:<?php echo $id_tipo_cuenta;?>,tipo_cuenta:'<?php echo $m_tipo_cuenta;?>'};
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_tipo_cuenta_cuenta(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};

ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);


/**
 * Nombre:		  	    pagina_tipo_cuenta_cuenta.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-01 08:36:14
 */
function pagina_tipo_cuenta_cuenta(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array;
	var ds;
	var componentes=new Array();
	var g_id_gestion;
	
	/////////////////
	//  DATA STORE //
	/////////////////

	// DEFINICIÓN DATOS DEL MAESTRO
	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Tipo de Cuenta',maestro.tipo_cuenta]]}),cm:cmMaestro});
	gridMaestro.render();
	
	
	/////////////////////
	//DATA STORE COMBOS//
	/////////////////////
  
   
	var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/presupuesto/ActionListarComboPresupuesto.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','tipo_pres','estado_pres','id_unidad_organizacional','nombre_unidad','id_fina_regi_prog_proy_acti','desc_epe','id_fuente_financiamiento','sigla','estado_gral','gestion_pres','id_parametro','id_gestion','desc_presupuesto','nombre_financiador', 'nombre_regional', 'nombre_programa', 'nombre_proyecto', 'nombre_actividad' ]),baseParams:{m_sw_rendicion:'si',sw_inv_gasto:'si'}
	});
	
	var ds_tipo_activo= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_activos_fijos/control/tipo_activo/ActionListaTipoActivo.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_activo',totalRecords:'TotalCount'},['id_tipo_activo','descripcion','codigo'])
	});
	
	var ds_sub_tipo_activo= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_activos_fijos/control/sub_tipo_activo/ActionListaSubtipoActivo.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_sub_tipo_activo',totalRecords:'TotalCount'},['id_sub_tipo_activo','descripcion','codigo'])
	});
	
	var ds_cuenta=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/cuenta/ActionListarCuenta.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta',totalRecords: 'TotalCount'},['id_cuenta','nro_cuenta','nombre_cuenta','desc_cuenta','nivel_cuenta','tipo_cuenta','sw_transaccional','id_cuenta_padre','id_parametro','id_moneda','descripcion','sw_oec','sw_aux'])
	});	
	
	var ds_auxiliar=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/auxiliar/ActionListarAuxiliar.php'}),
			reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_persona',
			totalRecords:'TotalCount'
		},['id_auxiliar','codigo_auxiliar','nombre_auxiliar','estado_auxiliar'])
	});
	
	//FUNCIONES RENDER
	
	function render_id_presupuesto(value, p, record){if(record.get('estado_regis')=='2'){return '<span style="color:red;font-size:8pt">' + record.data['desc_presupuesto']+ '</span>';}else {return record.data['desc_presupuesto'];}}
		var tpl_id_presupuesto=new Ext.Template('<div class="search-item">',
		'<b>{nombre_unidad}</b>',
		'<br><b>Gestión: </b><FONT COLOR="#B5A642">{gestion_pres}</FONT>',
		'<br><b>Tipo Presupuesto: </b><FONT COLOR="#B50000">{tipo_pres}</FONT>',
		'<br><b>Fuente de Financiamiento: </b><FONT COLOR="#B5A642">{sigla}</FONT>',
		//'<br> <b>Unidad Organizacional: </b><FONT COLOR="#B5A642">{nombre_unidad}</FONT>',
		'<br>  <b>EP:  </b><FONT COLOR="#B5A642">{desc_epe}</FONT></b>',
		'<br>  <FONT COLOR="#B50000">{nombre_financiador}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_regional}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_programa}</FONT>',
		'<br>  <FONT COLOR="#B50000">{nombre_proyecto}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_actividad}</FONT>',		
		'</div>');
	
	function render_id_tipo_activo(value, p, record){return String.format('{0}', record.data['desc_tipo_activo']);}
	function render_id_sub_tipo_activo(value, p, record){return String.format('{0}', record.data['desc_sub_tipo_activo']);}
	function renderHaber(value, p, record){return String.format('{0}', record.data['nombre_cuenta']);}
	function renderAuxiliar(value, p, record){return String.format('{0}', record.data['nombre_auxiliar']);}
	
	
	var tpl_id_tipo_activo=new Ext.Template('<div class="search-item">','<b><i>{descripcion}</i></b><br>','<FONT COLOR="#B5A642">{codigo}</FONT>','</div>');
	var tpl_id_sub_tipo_activo=new Ext.Template('<div class="search-item">','<b><i>{descripcion}</i></b><br>','<FONT COLOR="#B5A642">{codigo}</FONT>','</div>');
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	Atributos[0]= {
		validacion:{
			
			labelSeparator:'',
			name: 'id_tipo_cuenta_cuenta',
			inputType:'hidden'
		},
		tipo: 'Field'
	};
	 
	// txt id_rol
	Atributos[1]= {
		validacion:{
			name:'id_tipo_cuenta',
			labelSeparator:'',
			inputType:'hidden'
		},
		tipo:'Field',
		defecto:maestro.id_tipo_cuenta
	};
	
	// txt id_rol
	Atributos[2]= {
		validacion:{
			name:'id_gestion',
			labelSeparator:'',
			inputType:'hidden'
		},
		tipo:'Field',
		defecto:g_id_gestion
	};
	
	Atributos[3]={
			validacion:{
			name:'id_presupuesto',
			fieldLabel:'Presupuesto',
			allowBlank:false,			
			emptyText:'Presupuesto...',
			desc: 'desc_presupuesto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_presupuesto,
			valueField: 'id_presupuesto',
			displayField: 'desc_presupuesto',
			queryParam: 'filterValue_0',
			filterCol:'presup.desc_presupuesto',
			typeAhead:false,
			tpl:tpl_id_presupuesto,
			forceSelection:true,
			mode:'remote',
			queryDelay:360,
			pageSize:10,
			minListWidth:400,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_presupuesto,
			grid_visible:true,
			grid_editable:false,
			width_grid:400,
			width:'100%',
			disabled:false,
			grid_indice:11		
		},
		tipo:'ComboBox',
		id_grupo:0
		
	};
	
	Atributos[4]={
			validacion:{
				name:'id_tipo_activo',
				fieldLabel:'Tipo Activo',
				allowBlank:true,
				emptyText:'Tipo Activo...',
				desc: 'desc_tipo_activo', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_tipo_activo,
				valueField:'id_tipo_activo',
				displayField:'descripcion',
				queryParam: 'filterValue_0',
				filterCol:'TIP.codigo#TIP.descripcion',
				typeAhead:false,
				tpl:tpl_id_tipo_activo,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_tipo_activo,
				width:'100%',
				disabled:false
			},
			tipo:'ComboBox',
			id_grupo:1
		};
		
		Atributos[5]={
			validacion:{
				name:'id_sub_tipo_activo',
				fieldLabel:'Sub Tipo Activo',
				allowBlank:true,
				emptyText:'Sub Tipo Activo...',
				desc: 'desc_sub_tipo_activo', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_sub_tipo_activo,
				valueField:'id_sub_tipo_activo',
				displayField:'descripcion',
				queryParam: 'filterValue_0',
				filterCol:'SUB.codigo#SUB.descripcion',
				typeAhead:false,
				tpl:tpl_id_sub_tipo_activo,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_sub_tipo_activo,
				width:'100%',
				disabled:false
			},
			tipo:'ComboBox',
			id_grupo:2
		};
		
	Atributos[6]= {
		validacion:{
			name:'id_cuenta',
			desc:'nombre_cuenta',
			allowBlank:true,
			fieldLabel:'Cuenta',
			tipo:'ingreso',//determina el action a llamar
			gestion:1,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",			
			renderer:renderHaber,
			width:'90%',
			pageSize:10,
			onSelect:function(record){ 				
				
				componentes[6].setValue({id:record.data.id_cuenta,desc:record.data.desc_cuenta});				
				componentes[6].collapse();				
				ds_auxiliar.baseParams={cuenta:record.data.id_cuenta};
				componentes[7].reset();				
				componentes[7].modificado=true;		
			},	
			direccion:direccion
		},
		tipo:'LovCuenta',
		id_grupo:3
	};
	
	Atributos[7]= {
		validacion: {
			name:'id_auxiliar',
			fieldLabel:'Auxiliar',
			allowBlank:false,			
			emptyText:'Auxiliar...',
			name:'id_auxiliar',     //indica la columna del store principal ds del que proviane el id
			desc:'nombre_auxiliar', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_auxiliar,
			valueField:'id_auxiliar',
			displayField:'nombre_auxiliar',
			queryParam:'filterValue_0',
			filterCol:'AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar',
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:250,
			grow:true,
			width:'100%',
			resizable:true,
			queryParam:'filterValue_0',
			minChars:3, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:renderAuxiliar
			
		},
		tipo:'ComboBox',
		id_grupo:3
	};
		
	
	var DatosNodo=new Array('id','id_p','tipo');
	//aqui se definen los tipos y que imagenes van a tener
	
	var DatosDefecto={
		TipoRaiz:{
			text:0,//indice del atributo
			icon:"../../../lib/imagenes/ag.png",
			allowDrag:false,
			allowDelete:true,
			allowEdit:true,
			terminado:'false'
		},
		Presupuesto:{
			text:0,//indice del atributo
			icon:"../../../lib/imagenes/etucr.png",
			allowDrag:false,
			allowDelete:true,
			allowEdit:true,
			terminado:'false'
		},
		Tipo:{
			text:0,//indice del atributo
			icon:"../../../lib/imagenes/etuc.png",
			allowDrag:false,
			allowDelete:true,
			allowEdit:true,
			terminado:'false'
		},
		SubTipo:{
			text:0,//indice del atributo
			icon:"../../../lib/imagenes/item.png",
			allowDrag:false,
			allowDelete:true,
			allowEdit:true,
			terminado:'false'
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
		layout_tipo_cuenta_cuenta = new DocsLayoutArb(idContenedor);
		layout_tipo_cuenta_cuenta.init(config);
	
	

	//---------- INICIAMOS HERENCIA
	this.pagina = PaginaArb;
	this.pagina(paramConfig,Atributos,layout_tipo_cuenta_cuenta,idContenedor,DatosNodo,DatosDefecto);


	
	//----------   herencia de la clase madre -------//
	var getTreePanel = this.getTreePanel;
	var getTreeRaiz = this.getTreeRaiz;
	var getLoader= this.getLoader;
	var conexionFailure=this.conexionFailure;
	var btnEdit=this.btnEdit;
	var btnNew=this.btnNew;
	var btnNewRaiz=this.btnNewRaiz;
	var btnEliminar=this.btnEliminar;
	var btnActualizar=this.btnActualizar;
	var getComponente=this.getComponente;
	var getSm=this.getSm;
	var ocultarComponente=this.ocultarComponente;
	var ocultarFormulario=this.ocultarFormulario;
	var mostrarComponente=this.mostrarComponente;
	var guardarSuccess=this.guardarSuccess;
	var getDialog=this.getDialog;
	var ocultarFormulario=this.ocultarFormulario;
	var getLoader=this.getLoader;
	var getTreeRaiz=this.getTreeRaiz;
	
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	


	/////////////////////////////
	// parametros las funciones//
	////////////////////////////

	var paramFunciones = {
		
		Basicas:{url:direccion+'../../../../sis_activos_fijos/control/tipo_cuenta_cuenta/ActionGuardarTipoCuentaCuenta.php',edit:sEdit,add_success:miSuccess},
		Formulario:{
			height:330,
			width:480,
			minWidth:150,
			minHeight:200,
			closable:true,
			titulo:'Detalle de Tipo Cuenta',
			grupos:[
			{
				tituloGrupo:'Presupuesto',
				columna:0,
				id_grupo:0
			},
			{
				tituloGrupo:'Tipo Activo',
				columna:0,
				id_grupo:1
			},
			{
				tituloGrupo:'Sub-Tipo Activo',
				columna:0,
				id_grupo:2
			},
			{
				tituloGrupo:'Cuenta Auxiliar',
				columna:0,
				id_grupo:3
			}]
		},
		Listar:{
			url:direccion+'../../../../sis_activos_fijos/control/tipo_cuenta_cuenta/ActionListarTipoCuentaCuenta.php',
			baseParams:{id_tipo_cuenta:maestro.id_tipo_cuenta},
			allowDrag:false,
			allowDrop:false,
			clearOnLoad:true,
			raiz:'TipoRaiz'
			
		}
	};

	
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_tipo_cuenta=datos.id_tipo_cuenta;
		maestro.tipo_cuenta=datos.m_tipo_cuenta;

		gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['Tipo de Cuenta',maestro.tipo_cuenta]]);
		paramFunciones.Listar.baseParams={id_tipo_cuenta:maestro.id_tipo_cuenta};
		getLoader().baseParams.id_tipo_cuenta=maestro.id_tipo_cuenta;
		getLoader().baseParams.id_gestion=g_id_gestion;
		
		this.InitFunciones(paramFunciones);
		this.btnActualizar()
};

	
	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//



	////////////////////////////////////////
	//  FUnciones Propias                 //
	////////////////////////////////////////

	var paramMenu={
		nuevoRaiz:{crear:true,separador:false,tip:'Nueva Cuenta Base',img:'tuc+.png'},
		nuevo:{crear:true,separador:false,tip:'Nueva Cuenta',img:'raiz+.png'},
		editar:{crear:true,separador:false,tip:'Editar',img:'etucr.png'},
		eliminar:{crear:true,separador:false,tip:'Eliminar',img:'tucr-.png'},
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
		var treLoader=getLoader();
		treLoader.on("beforeload", function(treeL,n){
			treeL.baseParams.id_tipo_cuenta=maestro.id_tipo_cuenta,
			treeL.baseParams.id_gestion=g_id_gestion
		}, this);
		
		for (var i=0;i<Atributos.length;i++){
			
			componentes[i]=
			getComponente(Atributos[i].validacion.name);
		}
		
	}
	
	function miSuccess(r){ 
		Ext.MessageBox.hide();
		var np=getSm().getSelectedNode();
		var sm=getSm();
		if(r.argument.proc=='upd'){
			if(r.argument.nodo.attributes.tipo=='TipoRaiz'){
				getLoader().baseParams.id_tipo_cuenta=maestro.id_tipo_cuenta;
				getLoader().baseParams.id_gestion=g_id_gestion;
				btnActualizar();
			}
			else{
				
				r.argument.nodo.parentNode.reload();
				//r.argument.nodo.parentNode.expand();
			}
		}
		if(r.argument.proc=='add'){
			
			if(r.argument.nodo==undefined || r.argument.nodo==''){
				
				btnActualizar();
			}
			else{
				
				r.argument.nodo.reload();
				r.argument.nodo.expand();
			}
			
		}
		ocultarFormulario();
	}
	
	this.btnNewRaiz = function(){
		//Restituye los valores originales para almacenar los datos
		btnNewRaiz();
		componentes[2].setValue(g_id_gestion);
		componentes[1].setValue(maestro.id_tipo_cuenta);
		CM_ocultarGrupo('Presupuesto');
		CM_ocultarGrupo('Tipo Activo');
		CM_ocultarGrupo('Sub-Tipo Activo');
		SiBlancosGrupo(0);
		SiBlancosGrupo(1);
		SiBlancosGrupo(2);
	}
	
	this.btnNew = function(){
		//Restituye los valores originales para almacenar los datos
		var n = getSm().getSelectedNode();
		if(n=='' || n==undefined)
		{
			Ext.MessageBox.alert('Atención', 'Debe seleccionar un nodo del arbol para hacer la inserción');
		}
		else{
			
			var tipo_padre=n.attributes.tipo;
			if(tipo_padre!='SubTipo'){
				btnNew();
				manejarGrupos(tipo_padre,'new');
				componentes[2].setValue(g_id_gestion);
				componentes[1].setValue(maestro.id_tipo_cuenta);
			}
			else{
				Ext.MessageBox.alert('Alerta', 'No es posible crear una parametrización a este nivel.');
			}
		}
	}
	
	function sEdit(){
		//Restituye los valores originales para almacenar los datos
		var n = getSm().getSelectedNode();
		var tipo_padre=n.attributes.tipo;
		btnEdit();
		manejarGrupos(tipo_padre,'edit');
		ds_auxiliar.baseParams={cuenta:componentes[6].getValue()};
		componentes[7].modificado=true;	
		componentes[2].setValue(g_id_gestion);
		componentes[1].setValue(maestro.id_tipo_cuenta);
	}
	function manejarGrupos(tipo_nodo,accion){
		if(accion=='new'){
			if(tipo_nodo=='TipoRaiz'){
				componentes[3].store.baseParams={id_gestion:g_id_gestion};
				componentes[3].modificado=true;	
				CM_mostrarGrupo('Presupuesto');
				CM_ocultarGrupo('Tipo Activo');
				CM_ocultarGrupo('Sub-Tipo Activo');
				NoBlancosGrupo(0);
				SiBlancosGrupo(1);
				SiBlancosGrupo(2);
				
			}
			else if(tipo_nodo=='Presupuesto'){
				CM_ocultarGrupo('Presupuesto');
				CM_mostrarGrupo('Tipo Activo');
				CM_ocultarGrupo('Sub-Tipo Activo');
				SiBlancosGrupo(0);
				NoBlancosGrupo(1);
				SiBlancosGrupo(2);
				
			}
			else if(tipo_nodo=='Tipo'){
				CM_ocultarGrupo('Presupuesto');
				CM_ocultarGrupo('Tipo Activo');
				CM_mostrarGrupo('Sub-Tipo Activo');
				SiBlancosGrupo(0);
				SiBlancosGrupo(1);
				NoBlancosGrupo(2);
				
			}
			
		}
		if(accion=='edit'){
			if(tipo_nodo=='TipoRaiz'){
				CM_ocultarGrupo('Presupuesto');
				CM_ocultarGrupo('Tipo Activo');
				CM_ocultarGrupo('Sub-Tipo Activo');
				SiBlancosGrupo(0);
				SiBlancosGrupo(1);
				SiBlancosGrupo(2);
				
			}
			else if(tipo_nodo=='Presupuesto'){
				componentes[3].store.baseParams={id_gestion:g_id_gestion};
				componentes[3].modificado=true;	
				CM_mostrarGrupo('Presupuesto');
				CM_ocultarGrupo('Tipo Activo');
				CM_ocultarGrupo('Sub-Tipo Activo');
				NoBlancosGrupo(0);
				SiBlancosGrupo(1);
				SiBlancosGrupo(2);
				
			}
			else if(tipo_nodo=='Tipo'){
				CM_ocultarGrupo('Presupuesto');
				CM_mostrarGrupo('Tipo Activo');
				CM_ocultarGrupo('Sub-Tipo Activo');
				SiBlancosGrupo(0);
				NoBlancosGrupo(1);
				SiBlancosGrupo(2);
				
			}
			else if(tipo_nodo=='SubTipo'){
				CM_ocultarGrupo('Presupuesto');
				CM_ocultarGrupo('Tipo Activo');
				CM_mostrarGrupo('Sub-Tipo Activo');
				SiBlancosGrupo(0);
				SiBlancosGrupo(1);
				NoBlancosGrupo(2);
			}
		}
	}
	
	function SiBlancosGrupo(grupo){
		for (var i=0;i<componentes.length;i++){
			
			if(Atributos[i].id_grupo==grupo)
			componentes[i].allowBlank=true;
		}
	}
	function NoBlancosGrupo(grupo){
		for (var i=0;i<componentes.length;i++){
			if(Atributos[i].id_grupo==grupo)
				componentes[i].allowBlank=Atributos[i].validacion.allowBlank;
		}
	}
	
	
	       
	// para el combo de gestión de la cabecera
	   var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/gestion/ActionListarGestion.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_gestion',totalRecords:'TotalCount'},['id_gestion','gestion','estado_ges_gral','id_empresa','desc_empresa','id_moneda_base','desc_moneda'])}); 
      var tpl_gestion=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','</div>');
		var gestion =new Ext.form.ComboBox({
					store: ds_gestion,
					displayField:'gestion',
					typeAhead: true,
					mode: 'remote',
					triggerAction: 'all',
					emptyText:'gestion...',
					selectOnFocus:true,
					width:100,
					valueField: 'id_gestion',
					tpl:tpl_gestion
				});
		  gestion.on('select',function (combo, record, index){
		  	g_id_gestion=gestion.getValue();
		  	btnActualizar()	
		  });
		  
		  gestion.on('render',function(combo){
		  	Ext.Ajax.request({
					url:direccion+"../../../../sis_parametros/control/gestion/ActionListarGestion.php",
					method:'POST',
					params:{tipo_filtro:'ultima_gestion_activa'},
					success:cargar_respuesta,
					failure:conexionFailure,
					timeout:100000000
				});	
		  });
		  
		  function cargar_respuesta(resp){
		
				Ext.MessageBox.hide();
				if(resp.responseXML !=undefined && resp.responseXML !=null && resp.responseXML.documentElement !=null && resp.responseXML.documentElement !=undefined)
				{
					var root=resp.responseXML.documentElement;
					
					if(root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue=='1')
					{
						g_id_gestion=(root.getElementsByTagName('id_gestion')[0].firstChild.nodeValue);
						gestion.setValue(g_id_gestion);
						gestion.setRawValue(root.getElementsByTagName('gestion')[0].firstChild.nodeValue);
						getComponente('id_gestion').setValue(g_id_gestion);
					}
					else{ 
					
						Ext.MessageBox.alert('Alerta','No hay una gestión abierta');
					}								
				}
		  }
	this.InitFunciones(paramFunciones);
    this.InitBarraMenu(paramMenu);
    this.AdicionarBotonCombo(gestion,'gestion');	
	
	this.Init(); //iniciamos la clase madre
	
		//agregar filtro de busqueda en el arbol
	
	
 	var tb = this.getBarra()
	
	var filtro_tuc=new Ext.form.TextField({
	id:'tuc_filtro_'+idContenedor,
	width:80
	});
	
	
	
	tb.add('->','Filtrar por: ','',filtro_tuc,'->',{

		icon:'../../../lib/imagenes/actualizar.jpg',
		cls: 'x-btn-icon',
		//cls:'remove',
		tooltip:'Actualizar Biblioteca',
		handler:btn_actualizar_pdb
	}
	);
			
	
	function btn_actualizar_pdb(){
		getLoader().baseParams.filtrar=false
		
		if(filtro_tuc.getValue()!=''){
		  getLoader().baseParams.filtrar=true;
		  getLoader().baseParams.valor_filtro=filtro_tuc.getValue()
		  getLoader().baseParams.id_rol=maestro.id_rol;
		  getTreeRaiz().reload()
		
		}
		
		
	}
	
	
	
	
	this.iniciaFormulario();
	iniciarEventos()
}