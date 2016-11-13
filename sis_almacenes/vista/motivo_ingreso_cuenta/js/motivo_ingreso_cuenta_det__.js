/**
 * Nombre:		  	    pagina_motivo_ingreso_cuenta_det.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-17 15:49:51
 */
function pagina_motivo_ingreso_cuenta_det(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/motivo_ingreso_cuenta/ActionListarMotivoIngresoCuenta_det.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_motivo_ingreso_cuenta',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_motivo_ingreso_cuenta',
		'id_motivo_ingreso',
		'desc_motivo_ingreso',
		'descripcion',
		'observaciones',
		{name:'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'id_cuenta',
		'desc_cuenta',
        'id_financiador',
		'id_regional',
		'id_programa',
		'id_proyecto',
		'id_actividad',
        'nombre_financiador',
		'nombre_regional',
		'nombre_programa',
		'nombre_proyecto',
		'nombre_actividad',
		'codigo_financiador',
		'codigo_regional',
		'codigo_programa',
		'codigo_proyecto',
		'codigo_actividad'
		]),remoteSort:true});
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_motivo_ingreso:maestro.id_motivo_ingreso
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO
    /*var dataMaestro=[
    	['Id Motivo Ingreso',maestro.id_motivo_ingreso],
    	['Nombre',maestro.nombre],
    	['Descripcion',maestro.descripcion]];
	var dsMaestro=new Ext.data.Store({
		proxy:new Ext.data.MemoryProxy(dataMaestro),
		reader: new Ext.data.ArrayReader({id:0},[{name:'atributo'},{name:'valor'}])});
	dsMaestro.load();*/
	
	var cmMaestro=new Ext.grid.ColumnModel([
		{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},
		{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){
		return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';
		}
	function italic(value){
		return '<i>'+value+'</i>';
		}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{
		ds:new Ext.data.SimpleStore({
			fields:['atributo','valor'],
			data:[['Id Motivo Ingreso',maestro.id_motivo_ingreso],
					['Nombre',maestro.nombre],
					['Descripcion',maestro.descripcion]]
		}),
		cm:cmMaestro
	});
	gridMaestro.render();
	//DATA STORE COMBOS
    ds_cuenta=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_contabilidad/control/cuenta/ActionListarCuenta.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta',totalRecords:'TotalCount'},['id_cuenta','nro_cuenta','descripcion','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion'])
	});
	//FUNCIONES RENDER
	function render_id_cuenta(value, p,record){return String.format('{0}',record.data['desc_cuenta']);}
	// Template combo
	var resultTplCuenta=new Ext.Template(
	'<div class="search-item">',
	'<b><i>{descripcion}</i></b>',
	'<br><FONT COLOR="#B5A642">{nro_cuenta}</FONT>',
	'</div>'
	);
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	// hidden id_motivo_ingreso_cuenta
	//en la posición 0 siempre esta la llave primaria
	var param_id_motivo_ingreso_cuenta = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name:'id_motivo_ingreso_cuenta',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_motivo_ingreso_cuenta'
	};
	vectorAtributos[0]=param_id_motivo_ingreso_cuenta;
// txt id_motivo_ingreso
	var param_id_motivo_ingreso={
		validacion:{
			name:'id_motivo_ingreso',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		defecto:maestro.id_motivo_ingreso,
		save_as:'txt_id_motivo_ingreso'
	};
	vectorAtributos[1]=param_id_motivo_ingreso;
// txt descripcion
	var param_descripcion={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripcion',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:200
		},
		tipo:'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'MINGCU.descripcion',
		save_as:'txt_descripcion'
	};
	vectorAtributos[3]=param_descripcion;
// txt id_cuenta
	var param_id_cuenta={
			validacion:{
			name:'id_cuenta',
			fieldLabel:'Cuenta',
			allowBlank:false,			
			emptyText:'Cuenta...',
			name:'id_cuenta',     //indica la columna del store principal ds del que proviane el id
			desc:'desc_cuenta', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_cuenta,
			valueField:'id_cuenta',
			displayField:'descripcion',
			queryParam:'filterValue_0',
			filterCol:'CUENTA.nro_cuenta#CUENTA.descripcion',
			typeAhead:true,
			forceSelection:true,
			tpl:resultTplCuenta,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:250,
			grow:true,
			width:200,
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_cuenta,
			grid_visible:true,
			grid_editable:true,
			grid_indice:1,
			width_grid:200 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'CUENTA.nro_cuenta#CUENTA.descripcion',
		defecto: '',
		save_as:'txt_id_cuenta'
	};
	vectorAtributos[2]=param_id_cuenta;
	var paramId_ep1={
			validacion:{
				fieldLabel:'EP',
				allowBlank:false,
				vtype:"texto",
				emptyText:'Estructura Programática',
				name:'id_ep',     //indica la columna del store principal "ds" del que proviane el id
				minChars:1,
				triggerAction:'all',
				editable:false,
				grid_visible:false,
				grid_editable:false,
				grid_visible:true,
				grid_indice:1,
				width:350
			},
			tipo: 'epField',
			save_as:'hidden_id_ep1',
			id_grupo:1
		}
		vectorAtributos[4]=paramId_ep1;
	// txt fecha_reg
	var param_fecha_reg={
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha de registro',
			allowBlank:true,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer:formatDate,
			width_grid:105,
			disabled:true
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'MINGCU.fecha_reg',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_reg'
	};
	vectorAtributos[5] = param_fecha_reg;
	//----------- FUNCIONES RENDER
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};
	//---------- INICIAMOS LAYOUT DETALLE
	var config={
		titulo_maestro:'Motivo de Ingreso (Maestro)',
		titulo_detalle:'Cuentas - Estructura Programática (Detalle)',
		grid_maestro:'grid-'+idContenedor
	};
	layout_motivo_ingreso_cuenta = new DocsLayoutDetalleEP(idContenedor,idContenedorPadre);
	layout_motivo_ingreso_cuenta.init(config);
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_motivo_ingreso_cuenta,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_save=this.Save;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_ocultarTodosComponente=this.ocultarTodosComponente;
	var CM_mostrarTodosComponente=this.mostrarTodosComponente;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_btnEliminar = this.btnEliminar;
	var ClaseMadre_btnActualizar = this.btnActualizar;
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
	btnEliminar:{url:direccion+'../../../control/motivo_ingreso_cuenta/ActionEliminarMotivoIngresoCuenta.php',parametros:'&m_id_motivo_ingreso='+maestro.id_motivo_ingreso},
	Save:{url:direccion+'../../../control/motivo_ingreso_cuenta/ActionGuardarMotivoIngresoCuenta.php',parametros:'&m_id_motivo_ingreso='+maestro.id_motivo_ingreso},
	ConfirmSave:{url:direccion+'../../../control/motivo_ingreso_cuenta/ActionGuardarMotivoIngresoCuenta.php',parametros:'&m_id_motivo_ingreso='+maestro.id_motivo_ingreso},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,
			columnas:['47%','47%'],
			grupos:[{tituloGrupo:'almacen_ep',columna:0,id_grupo:0},{tituloGrupo:'Estructura Programatica',	columna:1,id_grupo:1}],width:'90%',
	minWidth:150,minHeight:200,closable:true,titulo: 'Cuenta del Motivo de Ingreso'}
	}
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	//Para manejo de eventos
	function iniciarEventosFormularios()
	{	// EVENTOS EP
		cmb_ep=ClaseMadre_getComponente('id_ep');
		var onEpSelect = function(e){var ep=cmb_ep.getValue();data_ep='id_financiador='+ep['id_financiador']+'&id_regional='+ep['id_regional']+'&id_programa='+ep['id_programa']+'&id_proyecto='+ep['id_proyecto']+'&id_actividad='+ep['id_actividad'];};
		cmb_ep.on('change',onEpSelect);
	}
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_motivo_ingreso_cuenta.getLayout();
	};
   function iniciarPaginaMotIngCuenta()
	{	grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();
		for(i=0;i<vectorAtributos.length-1;i++){
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i+1].validacion.name);
		}
	}
    this.btnNew = function()
	{	CM_ocultarComponente(componentes[4]);
		ClaseMadre_btnNew();
	}
    this.btnEdit = function()
	{	CM_ocultarComponente(componentes[4]);
		ClaseMadre_btnEdit();
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
	iniciarPaginaMotIngCuenta();
	layout_motivo_ingreso_cuenta.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
}