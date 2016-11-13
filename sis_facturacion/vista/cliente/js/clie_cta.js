/**
* Nombre:		  	    pagina_clie_cta.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2013-03-13 18:03:05
*/
function pagina_clie_cta(idContenedor,direccion,paramConfig,idContenedorPadre)
{        
	var Atributos=new Array,sw=0, maestro;
	var sw_grup=true;
	var comp_id_gestion, comp_id_cuenta, comp_id_auxiliar;

	/////////////////
	//  DATA STORE //
	/////////////////
	
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cliecta/ActionListarClieCta.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'id_clie_cta',totalRecords:'TotalCount'
		},[
		'id_clie_cta',
		'id_cliente',
		'id_gestion',
		'gestion',
		'id_cuenta',
		'descta',
		'id_auxiliar',
		'desaux',		
		'usuario_reg',
		'fecha_reg'
		]),remoteSort:true
	});
	
	var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/gestion/ActionListarGestion.php?tipo_vista=cobra_sis'}),
		reader: new Ext.data.XmlReader({record:'ROWS',id:'id_gestion',totalRecords:'TotalCount'},['id_gestion','id_empresa','desc_empresa','id_moneda_base','desc_moneda','gestion','estado_ges_gral'])
	});
	
	var ds_cuenta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/cuenta/ActionListarCuenta.php'}),
	    reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta',totalRecords: 'TotalCount'},
	    ['id_cuenta','nro_cuenta','nombre_cuenta','desc_cta2','desc_cuenta','nivel_cuenta','tipo_cuenta',
	    'sw_transaccional','id_cuenta_padre','id_parametro','id_moneda','descripcion',
	    'sw_oec','sw_aux'])});
	
	var ds_auxiliar = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/auxiliar/ActionListarAuxiliar.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_auxiliar',totalRecords: 'TotalCount'},['id_auxiliar','codigo_auxiliar','nombre_auxiliar','estado_auxiliar'])
	});
	
	//FUNCIONES RENDER
	function render_id_gestion(value, p, record){return String.format('{0}', record.data['gestion']);}
	var tpl_id_gestion=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','</div>');	
	
	function render_id_cuenta(value, p, record){return String.format('{0}', record.data['descta']);}
	var tpl_id_cuenta=new Ext.Template(
		'<div class="search-item">','<FONT COLOR="#000000">{nro_cuenta}</FONT> - <FONT COLOR="#000000">{nombre_cuenta}</FONT><br>','</div>');
	
	function render_id_auxiliar(value, p, record){return String.format('{0}', record.data['desaux']);}
	var tpl_id_auxiliar=new Ext.Template('<div class="search-item">','<b><i>{nombre_auxiliar}</b></i><br>','<FONT COLOR="#B5A642">{codigo_auxiliar}</FONT>','</div>');
	
	///////////////////////
	// Definicion de datos //
	/////////////////////////
	//en la posicion 0 siempre esta la llave primaria
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_clie_cta',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		id_grupo:0
	};
	
	Atributos[1]={
		validacion:{
			labelSeparator:'',
			name: 'id_cliente',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		id_grupo:0
	};
	
	Atributos[2]={
		validacion:{
			name:'id_gestion',
			fieldLabel:'Gestión',
			allowBlank:false,
			emptyText:'Gestión...',
			desc: 'gestion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_gestion,
			valueField: 'id_gestion',
			displayField: 'gestion',
			queryParam: 'filterValue_0',
			filterCol:'GES.gestion',
			typeAhead:false,
			tpl:tpl_id_gestion,
			forceSelection:true,
			mode:'remote',
			queryDelay:150,
			pageSize:100,
			minListWidth:150,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_gestion,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:150,
			align:'center',
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'GES.gestion',
		id_grupo:0
	};
	
	Atributos[3]={
		validacion:{
 			name:'id_cuenta',
			fieldLabel:'Cuenta',
			allowBlank:false,			
			emptyText:'Cuenta...',
			desc: 'descta', 		
			store:ds_cuenta,
			valueField: 'id_cuenta',
			displayField: 'desc_cta2',
			queryParam: 'filterValue_0',
			filterCol:'cuenta.nro_cuenta#cuenta.nombre_cuenta',
		 	typeAhead:false,
			triggerAction:'all',
			tpl:tpl_id_cuenta,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:15,
			minListWidth:300,
			//grow:true,
			resizable:true,
			minChars:1,
			editable:true,
			renderer:render_id_cuenta,
 			grid_visible:true,
 	 		grid_editable:false,
			width_grid:350,
			lazyRender:true,
      		width:300,
			disabled:false		
		}, 
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		id_grupo:0
	};
	
	Atributos[4]= {
		validacion: {
			name:'id_auxiliar',
			fieldLabel:'Auxiliar',
			allowBlank:false,			
			//emptyText:'Auxiliar...',
			desc: 'desaux', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_auxiliar,
			valueField: 'id_auxiliar',
			displayField: 'nombre_auxiliar',
			queryParam: 'filterValue_0',
			filterCol:'AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar',
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:350,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			grid_visible:true,
			renderer:render_id_auxiliar,
			disabled:false,
			width_grid:350,
			width:300
		},
		tipo:'ComboBox',
		id_grupo:0,
		filtro_0:true,
		filterColValue:'AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar'
	};

	Atributos[5]={
		validacion:{			
			name:'usuario_reg',
			fieldLabel:'Responsable Registro',
			grid_visible:true,
			grid_editable:false,
			width_grid:150		
		},
		tipo:'Field',
		filtro_0:false,
		form:false,		
		filterColValue:'CLIE.usuario_reg'
	};
	
	Atributos[6]={
		validacion:{			
			name:'fecha_reg',
			fieldLabel:'Fecha Registro',
			grid_visible:true,
			grid_editable:false,
			width_grid:110		
		},
		tipo:'Field',
		filtro_0:false,
		form:false,		
		filterColValue:'CLIE.fecha_reg'
	};
	
	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Cuenta',grid_maestro:'grid-'+idContenedor};
	layout_clie_cta= new DocsLayoutMaestro(idContenedor);
	layout_clie_cta.init(config);

	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_clie_cta,idContenedor);
	
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_getBoton=this.getBoton;
	var Cm_conexionFailure=this.conexionFailure;
	var CM_btnEliminar=this.btnEliminar;
	var CM_saveSuccess=this.saveSuccess;
	var getDialog=this.getDialog;
	var EstehtmlMaestro=this.htmlMaestro;
	var getGrid=this.getGrid;
	var cm_btnEdit=this.btnEdit;
	
	//DEFINICION DE LA BARRA DE MENU
	var paramMenu={
		//guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	
	//DEFINICION DE FUNCIONES
	 var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/cliecta/ActionEliminarClieCta.php'},
		Save:{url:direccion+'../../../control/cliecta/ActionGuardarClieCta.php'},
		ConfirmSave:{url:direccion+'../../../control/cliecta/ActionGuardarClieCta.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:250,width:500,minWidth:'25%',minHeight:222,columnas:['90%'],	
			closable:true,
			titulo:'Cuenta Auxiliar',
			grupos:[{
				tituloGrupo:'Datos de Cuenta',
					columna:0,
					id_grupo:0
			}]}
		};
	
	 function iniciarEventosFormularios() {
		comp_id_gestion=getComponente('id_gestion');
		comp_id_cuenta=getComponente('id_cuenta');
		comp_id_auxiliar=getComponente('id_auxiliar');
		
		comp_id_gestion.on('select',f_gestion);	
		comp_id_cuenta.on('select',f_cuenta);
	}
 
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(m){
		maestro=m;
		//Ext.MessageBox.alert('Estado', 'llega');
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_cliente:maestro.id_cliente
			}
		};
		
		this.btnActualizar();
		
		Atributos[1].defecto=maestro.id_cliente;
		
		paramFunciones.btnEliminar.parametros='&m_id_cliente='+maestro.id_cliente;
		paramFunciones.ConfirmSave.parametros='&m_id_cliente='+maestro.id_cliente;
		paramFunciones.Save.parametros='&m_id_cliente='+maestro.id_cliente;
	 
		this.InitFunciones(paramFunciones)
	};
	
	this.btnEdit = function(){
		comp_id_cuenta.store.baseParams={sw_transaccional:1, m_id_gestion:comp_id_gestion.getValue()};
		comp_id_auxiliar.store.baseParams={sw_reg_comp:'si', m_estado_aux:1, m_id_cuenta:comp_id_cuenta.getValue()};
		comp_id_cuenta.modificado=true;
		comp_id_auxiliar.modificado=true;
		
		cm_btnEdit();
	}
	
	function f_gestion(combo, record, index ){
		comp_id_cuenta.store.baseParams={sw_transaccional:1, m_id_gestion:record.data.id_gestion};
		comp_id_auxiliar.store.baseParams={sw_reg_comp:'si', m_estado_aux:1, m_id_cuenta:0};
		
		comp_id_cuenta.modificado=true;
		comp_id_auxiliar.modificado=true;
		
		comp_id_cuenta.setValue('');
		comp_id_auxiliar.setValue('');
	}
	
	function f_cuenta(combo, record, index ){
		comp_id_auxiliar.store.baseParams={sw_reg_comp:'si', m_estado_aux:1, m_id_cuenta:record.data.id_cuenta};
		comp_id_auxiliar.modificado=true;
		comp_id_auxiliar.setValue('');
	}
	
	ds.lastOptions={
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
	}};
	
	//para que los hijos puedan ajustarse al tamaï¿½o
	this.getLayout=function(){return layout_clie_cta.getLayout()};
	
	//para el manejo de hijos

	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_clie_cta.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
}