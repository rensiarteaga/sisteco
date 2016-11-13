/**
* Nombre:		  	    ChequeAnulacion.js
* Propósito: 			pagina objeto principal
* Autor:				RCM
* Fecha creación:		11-02-2009
*/
function ChequeAnulacion(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;

	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cheque/ActionListarChequeAnulacion.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'id_cheque',totalRecords:'TotalCount'
		},[
		'id_cheque',
		'nro_cheque',
		'fecha_cheque',
		'nombre_cheque',
		'estado_cheque',
		'nro_cuenta_banco',
		'banco',
		'importe_cheque',
		'mon_simbolo',
		'moneda',
		'tipo',
		'id_tabla'
		]),remoteSort:true
	});
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	//DATA STORE COMBOS
	var ds_gestion = new Ext.data.Store({proxy:new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/gestion/ActionListarGestion.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_gestion',totalRecords:'TotalCount'},['id_gestion','id_empresa','id_moneda_base','gestion','estado_ges_gral'])
	});
	//FUNCIONES RENDER
	function render_id_gestion(value, p, record){return String.format('{0}', record.data['gestion']);}
	var tpl_id_gestion=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','<br><FONT COLOR="#B5A642"><b>Estado: </b>{estado_ges_gral}</FONT>','</div>');
	////////////////FUNCIONES RENDER ////////////

	/////////////////////////
	// Definición de datos //
	/////////////////////////
	// hidden id_parametro
	//en la posición 0 siempre esta la llave primaria
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_cheque',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'id_cheque'
	};

	Atributos[1]={
		validacion:{
			name:'nro_cheque',
			fieldLabel:'Nro.Cheque',
			grid_visible:true,
			grid_editable:false,
			grid_indice:10,
			width_grid:80
		},
		tipo:'Field',
		filtro_0:true,
		filterColValue:'CHEQUE.nro_cheque',
		save_as:'txt_nro_cheque'
	};
	Atributos[2]={
		validacion:{
			name:'fecha_cheque',
			fieldLabel:'Fecha Cheque',
			grid_visible:true,
			grid_editable:false,
			grid_indice:10,
			width_grid:80
		},
		tipo:'Field',
		filtro_0:true,
		filterColValue:'CHEQUE.fecha_cheque',
		save_as:'txt_fecha_cheque'
	};

	Atributos[3]={
		validacion:{
			name:'nombre_cheque',
			fieldLabel:'Nombre Cheque',
			grid_visible:true,
			grid_editable:false,
			grid_indice:10,
			width_grid:180
		},
		tipo:'Field',
		filtro_0:true,
		filterColValue:'CHEQUE.nombre_cheque',
		save_as:'txt_nombre_cheque'
	};

	Atributos[4]={
		validacion:{
			name:'importe_cheque',
			fieldLabel:'Importe',
			align:'right',
			grid_visible:true,
			grid_editable:false,
			grid_indice:10,
			width_grid:100
		},
		tipo:'Field',
		filtro_0:true,
		filterColValue:'CHEQUE.importe_cheque',
		save_as:'txt_importe_cheque'
	};

	Atributos[5]={
		validacion:{
			name:'mon_simbolo',
			fieldLabel:'Moneda',
			grid_visible:true,
			grid_editable:false,
			grid_indice:10,
			width_grid:60
		},
		tipo:'Field',
		filtro_0:true,
		filterColValue:'CHEQUE.mon_simbolo',
		save_as:'txt_mon_simbolo'
	};

	Atributos[6]={
		validacion:{
			name:'estado_cheque',
			fieldLabel:'Estado Cheque',
			grid_visible:true,
			grid_editable:false,
			grid_indice:10,
			width_grid:80
		},
		tipo:'Field',
		filtro_0:true,
		filterColValue:'CHEQUE.estado_cheque',
		save_as:'txt_estado_cheque'
	};

	Atributos[7]={
		validacion:{
			name:'banco',
			fieldLabel:'Banco',
			grid_visible:true,
			grid_editable:false,
			grid_indice:10,
			width_grid:180
		},
		tipo:'Field',
		filtro_0:true,
		filterColValue:'CHEQUE.banco',
		save_as:'txt_banco'
	};

	Atributos[8]={
		validacion:{
			name:'nro_cuenta_banco',
			fieldLabel:'Cuenta Bancaria',
			grid_visible:true,
			grid_editable:false,
			grid_indice:10,
			width_grid:180
		},
		tipo:'Field',
		filtro_0:true,
		filterColValue:'CHEQUE.nro_cuenta_banco',
		save_as:'txt_nro_cuenta_banco'
	};


	Atributos[9]={
		validacion:{
			name:'moneda',
			fieldLabel:'Moneda Descripción',
			grid_visible:false,
			grid_editable:false,
			grid_indice:10,
			width_grid:180
		},
		tipo:'Field',
		filtro_0:false,
		filterColValue:'CHEQUE.moneda',
		save_as:'txt_moneda'
	};
	Atributos[10]={
		validacion:{
			name:'tipo',
			fieldLabel:'Tipo',
			grid_visible:true,
			grid_editable:false,
			grid_indice:10,
			width_grid:70
		},
		tipo:'Field',
		filtro_0:false,
		filterColValue:'CHEQUE.tipo',
		save_as:'txt_tipo'
	};

	Atributos[11]={
		validacion:{
			name:'id_tabla',
			fieldLabel:'Id tabla',
			grid_visible:false,
			grid_editable:false,
			grid_indice:10,
			width_grid:70
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'txt_id_tabla'
	};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Anulación de Cheques',grid_maestro:'grid-'+idContenedor};
	var layout=new DocsLayoutMaestro(idContenedor);
	layout.init(config);
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEliminar=this.btnEliminar;
	var ClaseMadre_getComponente=this.getComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_btnActualizar = this.btnActualizar;
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////
	var paramMenu={
		actualizar:{crear:true,separador:false}
	};

	function btn_anu_cheque(){
		var sm=getSelectionModel();
		if(sm.getCount()!=0){

			if(confirm("¿Está seguro de Anular el Cheque?")){
				var id_cheque=sm.getSelected().data.id_cheque;
				var id_tabla=sm.getSelected().data.id_tabla;
				var tipo_cheque=sm.getSelected().data.tipo;
				var data='id_cheque='+id_cheque+'&id_tabla='+id_tabla+'&tipo_cheque='+tipo_cheque;
				Ext.Ajax.request({
					url:direccion+'../../../../sis_contabilidad/control/cheque/ActionAnularCheque.php?'+data,
					method:'GET',
					success:exito_cheque_anu,
					failure:falla_cheque_anu,
					timeout:100000
				})
			}

		}
		else{
			Ext.MessageBox.alert('Estado', 'Seleccione un Cheque')
		}
	}

	function exito_cheque_anu(resp){
		Ext.MessageBox.hide();
		var root = resp.responseXML.documentElement;
		var v_error = root.getElementsByTagName('error')[0].firstChild.nodeValue;
		var v_mensaje = root.getElementsByTagName('mensaje')[0].firstChild.nodeValue;
		if(v_error='true'){
			Ext.MessageBox.alert('Error', v_mensaje);
		}
		else{
			Ext.MessageBox.alert('Estado', v_mensaje);
			CM_btnActualizar()
		}

	}

	function falla_cheque_anu(resp){
		Ext.MessageBox.hide();
		var root = resp.responseXML.documentElement;
		var v_error = root.getElementsByTagName('error')[0].firstChild.nodeValue;
		var v_mensaje = root.getElementsByTagName('mensaje')[0].firstChild.nodeValue;
		if(v_error='true'){
			Ext.MessageBox.alert('Error', v_mensaje);
		}
		else{
			Ext.MessageBox.alert('Estado', v_mensaje);
			CM_btnActualizar()
		}

	}

	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/parametro/ActionEliminarParametro.php'},
		Save:{url:direccion+'../../../control/parametro/ActionGuardarParametro.php'},
		ConfirmSave:{url:direccion+'../../../control/parametro/ActionGuardarParametro.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Parámetro de Tesorería'}
	};

	//Para manejo de eventos
	function iniciarEventosFormularios(){
		//para iniciar eventos en el formulario

	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	this.iniciaFormulario();
	iniciarEventosFormularios();
	this.AdicionarBoton('../../../lib/imagenes/delete.gif','Anular Cheque',btn_anu_cheque,true,'anu_cheque','');
	layout.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}