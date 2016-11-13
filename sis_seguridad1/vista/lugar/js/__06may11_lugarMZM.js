/**
 * Nombre:		  	    pagina_lugar_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-25 16:40:31
 */
function pagina_lugar(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=[];
	var cmpCodigo;
	var cmpNombre;
	var cmpDescripcion;
	var cmpCantidad;
	var cmpOpcional;
	var cmpIdComposicionTuc;
	var Dialog;
	var copiados;

	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/lugar/ActionListarLugar.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_lugar',
			totalRecords: 'TotalCount'
		}, [
			'id_lugar',
			'fk_id_lugar',
			'desc_lugar',
			'nivel',
			'codigo',
			'nombre',
			'ubicacion',
			'telefono1',
			'telefono2',
			'fax',
			'observacion',
			'sw_municipio',
			'nombre_nivel',
			'sw_impuesto'
		]),remoteSort:true});
		
		ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			txt_usuario:0
			
		}
	});
	
    ds_lugar = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/lugar/ActionListarLugar.php?txt_usuario='+0}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_lugar',
			totalRecords: 'TotalCount'
		}, ['id_lugar','fk_id_lugar','nivel','codigo','nombre','ubicacion','telefono1','telefono2','fax','observacion'])
	});

	//FUNCIONES RENDER
	function render_fk_id_lugar(value, p, record){return String.format('{0}', record.data['desc_lugar']);}
		
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	vectorAtributos[0]= {
		validacion:{
			labelSeparator:'',
			name: 'id_lugar',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		save_as:'hidden_id_lugar',
		id_grupo:0
	};
	 
	// txt fk_id_lugar
	vectorAtributos[1]= {
			validacion: {
			labelSeparator:'',
			name:'fk_id_lugar',
			//fieldLabel:'Lugar Padre',
			allowBlank:true,			
			emptyText:'Id Lugar Padre...',
			desc: 'desc_lugar', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_lugar,
			valueField: 'id_lugar',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'LUGARR.nombre#LUGARR.ubicacion',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			inputType:'hidden',
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_fk_id_lugar,
			grid_visible:false,
			grid_editable:true,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'Field',
		defecto: '',
		form:false,
		save_as:'txt_fk_id_lugar',
		id_grupo:0
	};
	
// txt nivel
	vectorAtributos[2]= {
		validacion:{
			name:'nivel',
			fieldLabel:'Nivel',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			decimalPrecision :2,//para numeros float
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'NumberField',
		save_as:'txt_nivel',
		form:false,
		id_grupo:0
	};
	
// txt codigo
	vectorAtributos[3]= {
		validacion:{
			name:'codigo',
			fieldLabel:'Codigo',
			allowBlank:false,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextField',
		save_as:'txt_codigo',
		id_grupo:0
	};
	
// txt nombre
	vectorAtributos[4]= {
		validacion:{
			name:'nombre',
			fieldLabel:'Lugar',
			allowBlank:false,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextField',
		save_as:'txt_nombre',
		id_grupo:0
	};
	
// txt ubicacion
	vectorAtributos[5]= {
		validacion:{
			name:'ubicacion',
			fieldLabel:'Ubicación',
			allowBlank:true,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextArea',
		save_as:'txt_ubicacion',
		id_grupo:1
	};
	
// txt telefono1
	vectorAtributos[6]= {
		validacion:{
			name:'telefono1',
			fieldLabel:'Teléfono Principal',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextField',
		save_as:'txt_telefono1',
		id_grupo:1
	};
	
// txt telefono2
	vectorAtributos[7]= {
		validacion:{
			name:'telefono2',
			fieldLabel:'Teléfono Alternativo',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextField',
		save_as:'txt_telefono2',
		id_grupo:1
	};
	
// txt fax
	vectorAtributos[8]= {
		validacion:{
			name:'fax',
			fieldLabel:'Fax',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextField',
		save_as:'txt_fax',
		id_grupo:1
	};
	
// txt observacion
	vectorAtributos[9]= {
		validacion:{
			name:'observacion',
			fieldLabel:'Observacion',
			allowBlank:true,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextArea',
		save_as:'txt_observacion',
		id_grupo:2
	};
	

	//txt sw_municipio
	vectorAtributos[10]= {
			validacion: {
			name:'sw_municipio',
			fieldLabel:'Municipio',
			allowBlank:true,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data : Ext.lugar_combo.sw_municipio
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:60, // ancho de columna en el gris
			width: '100%',
			vtype:"texto"
		},
		tipo:'ComboBox',
		defecto:'no',
		form:true,
		save_as:'txt_sw_municipio',
		id_grupo:2
	};
	
	//nombre_nivel
	vectorAtributos[11]= {
		validacion:{
			name:'nombre_nivel',
			fieldLabel:'Tipo Lugar',
			allowBlank:true,
			maxLength:120,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'TextField',
		id_grupo:0
	};
	
	vectorAtributos[12]= {
			validacion: {
			name:'sw_impuesto',
			fieldLabel:'Impuesto',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','si'],['no','no']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:60, // ancho de columna en el gris
			width: '100%',
			vtype:"texto"
		},
		tipo:'ComboBox',
		defecto:'si',
		form:true,
		save_as:'txt_sw_impuesto',
		id_grupo:2
	};
	
	var DatosNodo=new Array('id','id_p','tipo');
	//datos por defecto para los nuevos nodos que se creen en la vista
	var DatosDefecto={
		agrupador:{
			text:0,//indice del atributo
			icon:"../../../lib/imagenes/ag.png",
			allowDrag:false,
			allowDelete:false,
			allowEdit:true

		},
		raiz:{
			text:0,//indice del atributo
			icon:"../../../lib/imagenes/etucr.png",
			allowDrag:true,
			allowDelete:true,
			allowEdit:true,
			terminado:'false'

		},
		rama:{
			text:0,//indice del atributo
			icon:"../../../lib/imagenes/etuc.png",
			allowDrag:true,
			allowDelte:true,
			allowEdit:true,
			terminado:'false'
		},
		item:{
			text:1,//indice del atributo
			icon:"../../../lib/imagenes/item.png",
			allowDrag:true,
			allowDelete:true,
			allowEdit:true
		}


	}

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT ARBOL     -----------//
	//////////////////////////////////////////////////////////////
	//Inicia Layout
	var config={
		titulo:'Tipo Unidad Constructiva'
	};
	layout_tuc=new DocsLayoutArb(idContenedor);
	layout_tuc.init(config);




	layout_tuc.getLayout().addRegion("east",{
		//toolbar: tb,
		split:true,
		initialSize:250,
		autoScroll:true,
		minSize:175,
		maxSize:400,
		titlebar:false,
		collapsible:false,
		animate:false,
		useShim:true
	});


	




	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=PaginaArb;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,layout_tuc,idContenedor,DatosNodo,DatosDefecto);


	//----------   herencia de la clase madre -------//
	var getTreePanel = this.getTreePanel;
	var getTreeRaiz = this.getTreeRaiz;
	var getLoader= this.getLoader;
	var conexionFailure=this.conexionFailure;
	var btnEliminar=this.btnEliminar;
	var btnEdit=this.btnEdit;
	var btnNew=this.btnNew;
	var btnNewRaiz=this.btnNewRaiz;
	var getComponente=this.getComponente;
	var getSm=this.getSm;
	var ocultarComponente=this.ocultarComponente;
	var mostrarComponente=this.mostrarComponente;
	var mostrarGrupo=this.mostrarGrupo;
	var ocultarGrupo=this.ocultarGrupo;
	var btnActualizar=this.btnActualizar;
	var setValuesBasicos=this.setValuesBasicos;
	var getDialog=this.getDialog;
	var getFormulario=this.getFormulario;
	var prepareCtx=this.prepareCtx;
	var getCtxMenu=this.getCtxMenu;
	var onBeforeMove=this.onBeforeMove;
	var guardarSuccess=this.guardarSuccess;




	/////////////////////////////
	// parametros las funciones//
	////////////////////////////


	var paramFunciones = {
		Basicas:{
			url:direccion+'../../../../sis_seguridad/control/lugar/ActionGuardarLugarArb.php',
			add_success:guardarSuccessSc,
			upd_success:guardarSuccessSc,
			edit:sEdit
		},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:'70%',
			height:380,
			width:480,
			minWidth:150,
			minHeight:200,
			closable:true,
			titulo:'Lugar',
			grupos:[
		
		{	tituloGrupo:'Datos Generales de Lugar',
			columna:0,
			id_grupo:0
		},
		{	tituloGrupo:'Datos de Ubicación',
			columna:0,
			id_grupo:1
		},
		{	tituloGrupo:'Observaciones de Lugar',
			columna:0,
			id_grupo:2
		}		
		]
		},
		
		
		Listar:{
			url:direccion+'../../../../sis_seguridad/control/lugar/ActionListarLugarArb.php',
			raiz:'agrupador',
			baseParams:{},
			clearOnLoad:true,
			allowDrag:false,
			allowDrop:true,
			checked:false/*,
			id:'id',
			text:'Packages and Components',
			cls:'croot'*/
		}
	};

	/////////////////////////
	// parametros del menu //
	/////////////////////////

	var paramMenu={
		nuevoRaiz:{crear:true,separador:false,tip:'Nuevo Pais',img:'nuevo_lugar.gif'},
		nuevo:{crear:true,separador:false,tip:'Nuevo Nodo',img:'add.gif'},
		editar:{crear:false,separador:false,tip:'Editar',img:'nodo_edit.png'},
		eliminar:{crear:true,separador:false,tip:'Eliminar',img:'delete.gif'},
		actualizar:{crear:true,separador:false}
	};


	////////////////////////////////////////
	//  FUnciones Propias                 //
	/////////////////////////////////////////

	// some functions to determine whether is not the drop is allowed
	function hasNode(t, n){
		return t.findChild('id', n.id);//busca si el nodo existe ya
	};

	function isSourceCopy(e, n){
		var a = e.target.attributes;

		//return n.getOwnerTree() != itree && !hasNode(e.target, n);
		return hasNode(e.target, n)
	};

	function isReorder(e, n){
		return n.parentNode == e.target.parentNode && e.point != 'append';
	};

	function iniciarEventos(){
		cmpIdLugar= getComponente('id_lugar');
		cmpLugarPadre= getComponente('fk_id_lugar');
		cmpNivel=getComponente('nivel');
		cmpCodigo=getComponente('codigo');
		cmpNombre=getComponente('nombre');
		cmpUbicacion= getComponente('ubicacion');
		cmpTelefono1=getComponente('telefono1');
		cmpTelefono2=getComponente('telefono2');
		cmpFax= getComponente('fax');
		cmpDescripcion=getComponente('observacion');
		cmpIdComposicionTuc=getComponente('id_composicion_tuc');
		cmpSwMunicipio=getComponente('sw_municipio');
		cmpTipo=getComponente('nombre_nivel');
		var treLoader=getLoader();
		Dialog=getDialog();
		
		
		///menu contextual principal

		var CtxMenuP=getCtxMenu();
		CtxMenuP.add({
			id:'copy',
			handler:btnCopy,
			cls:'copy-mi',
			text: 'Copiar'
		},{
			id:'paste',
			handler:btnPaste,
			cls:'paste-mi',
			text: 'Pegar'
		}
		);


					
		

	}
	


	//copiar y pegar

	function btnCopy(){

		copiados = getSm().getSelectedNode()
	}
	function btnPaste(){

		var n = getSm().getSelectedNode();
		var vec={};
		vec.id=copiados.id;
		vec.id_p=copiados.attributes.id_p;
		vec.id_pn=n.id;
		vec.opcional=n.attributes.opcional;
		vec.cantidad=n.attributes.cantidad;
		vec.tipo=copiados.attributes.tipo;
		var postData='datos='+encodeURIComponent(Ext.encode(vec))+'&proc=copy';

		Ext.MessageBox.show({
			title: 'Espere Por Favor...',
			msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Guardando...</div>",
			width:150,
			height:200,
			closable:false
		});


		Ext.Ajax.request(
		{
			url:direccion+'../../../../sis_seguridad/control/lugar/ActionGuardarLugarArb.php',
			params: postData,
			method:'POST',
			success:terSuccess,
			argument:{nodo:n},
			failure:fallaDropItem,
			timeout:paramConfig.TiempoEspera
		}

		);
	}

	this.onBeforeMove = function(tree,n,oldParent,newParent){
		
		
			return onBeforeMove(tree,n,oldParent,newParent)
		
	};
	
	
	this.prepareCtx= function(node,e){

		node.select();
		var sw=node.attributes.allowDelete ? 'enable' : 'disable';
		if(node.parentNode&&node.parentNode.attributes.terminado=='true'&&node.parentNode.attributes.tipo!='agrupador'){
			sw='disable'
		}

		getCtxMenu().items.get('remove')[sw]();


		sw=node.parentNode.id!='id'?'enable':'disable';
		getCtxMenu().items.get('copy')[sw]();

		//sw=copiados&&node.attributes.terminado=='false'? 'enable' : 'disable';
		sw='disable';
		if(copiados&&node.attributes.terminado=='false'){
			if(copiados.attributes.tipo=='item'||node.attributes.codigo=='Basurero'||node.attributes.codigo=='Obsoletos'){
				//if(copiados.attributes.tipo=='item'&&node.attributes.tipo=='agrupador'&&node.attributes.codigo=='Basurero'&&&node.attributes.codigo=='Obsoletos'){
				sw='disable'
			}
			else{
				sw='enable'
			}

		}

		getCtxMenu().items.get('paste')[sw]();


		sw=node.attributes.terminado=='false'&&node.attributes.tipo!='agrupador'?'enable':'disable';


		sw=(node.attributes.terminado=='true'&&node.parentNode.attributes.terminado=='false')||(node.attributes.terminado=='true'&&node.parentNode.attributes.tipo=='agrupador')? 'enable' : 'disable';
	



		getCtxMenu().items.get('reload')[!node.leaf ? 'enable' : 'disable']();
		getCtxMenu().showAt(e.getXY());
		

	};

	this.btnEliminar=function(){
		var n = getSm().getSelectedNode();
		if(!n){
			alert("Seleccione un nodo primero")
		}else{
			get_datos(n.attributes.id);
		}
	};
	
       	
	function get_datos(n){
			var postData;
			if(n != undefined && n != null && n != ""){
			  	  postData = "CantFiltros=1&filterCol_0=LUGARR.fk_id_lugar&filterValue_0="+n;				  
			}
			Ext.Ajax.request({url:'../../../sis_seguridad/control/lugar/ActionListarLugar.php?id_lugar='+n,
			params: postData,
			method:'POST',
			success:cargar_data,
			failure:conexionFailure,
			timeout:100000});
		}

		function cargar_data(resp){
			Ext.MessageBox.hide();
			if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
				var root = resp.responseXML.documentElement;
					var total=root.getElementsByTagName('TotalCount')[0].firstChild.nodeValue;
					
					if(total>0){
						alert("Este nodo no puede eliminarse,\npor que tiene lugares dependientes ")
					}else{
						btnEliminar();
					}
			}
		}
		
			
		
	function sEdit(){

		var n = getSm().getSelectedNode();
		//ocultarComponente('tipo_lugar');
		ocultarComponente(cmpTipo);

			//itemTipoAux();

			if(n.parentNode.attributes.tipo=='agrupador'){
				//ocultarComponente(cmpCantidad);
				//ocultarComponente(cmpOpcional)
			}
			btnEdit()
		
		

	};
	
	
	this.btnNew=function(){
		var n = getSm().getSelectedNode();
		if(n){
			//itemTipoAux();
			
			mostrarGrupo('Datos Generales de Lugar');
			mostrarGrupo('Datos de Ubicación');
			mostrarGrupo('Observaciones de Lugar');
			//ocultarComponente(cmpLugarPadre);
			//ocultarComponente(cmpNivel);
			ocultarComponente(cmpTipo);
			
			//cmpCantidad.setValue(1);
			nodo={};
			nodo.id=null;
			nodo.id_p=n.id;
			setValuesBasicos(nodo,'add')
			getFormulario().reset();
			Dialog.show()
            
		}
		else{
			
				alert("Seleccione un nodo primero")
			
		}

		//btnNew()
	};
	this.btnNewRaiz=function(){
		//itemTipoAux();
		
		mostrarGrupo('Datos Generales de Lugar');
		mostrarGrupo('Datos de Ubicación');
		mostrarGrupo('Observaciones de Lugar');
		/*ocultarComponente(cmpLugarPadre);
		ocultarComponente(cmpNivel);*/
		ocultarComponente(cmpTipo);
		nodo={};
		nodo.id='NULL';
		nodo.id_p='NULL';
		nodo.tipo='raiz';
				
		setValuesBasicos(nodo,'add');
		getFormulario().reset();
		Dialog.setTitle("Registro de País");
		Dialog.show()
	};

	function itemTipoAux(){
		cmpCodigo.enable();
		cmpNombre.enable();
		cmpDescripcion.enable()
//		cmpOpcional.el.up('.x-form-item').down('label').update('Opcional')
	}
	
	function guardarSuccessDrop(resp){
		
		var nodo=resp.argument.nodo;
		Ext.MessageBox.hide();
		var regreso = Ext.util.JSON.decode(resp.responseText)
		if(regreso.success=='true'){
			getTreeRaiz().reload();
		
			this.btnActualizar();
		}
		resp.argument.parent.expand();
		
	}

	function fallaDropItem(resp,b,c){
	
		conexionFailure(resp,b,c);
	}

	function guardarSuccessSc(r){
		
		var np = getSm().getSelectedNode();
		guardarSuccess(r);
		
		getTreeRaiz().reload();
				btnActualizar();
		
		if(r.argument.proc=='upd'){
				
		}
		else{ alert("entra aqui");
			getTreeRaiz().reload();
				this.btnActualizar();			
		}

	}
	
	this.btnEdit=function(){
		
	}


	function terSuccess(resp){

		var regreso = Ext.util.JSON.decode(resp.responseText)
		if(regreso.success=='true'){
			
			Ext.MessageBox.hide();
			}
	}
	
	function btn_actualizar_tuc(){

		iloader.baseParams.filtrar=false
		if(filtro_tuc.getValue()!=''){
		iloader.baseParams.filtrar=true
		}
		
		iroot.reload()
	}


	this.getLayout=function(){
		return layout_tuc.getLayout();
	};


	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	this.Init(); //iniciamos la clase madre
	this.iniciaFormulario();
	iniciarEventos();
	


}