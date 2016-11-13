/**
 * Nombre:		  	    pagina_deposito_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Williams Escobar
 * Fecha creación:		2011-01-07 11:43:08
 */
function pagina_deposito(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var sw=0;
	var dialog;
	var formulario;
	var componentes=new Array();
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/deposito/ActionListarDeposito.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_deposito',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
			'id_deposito',
			'nombre_deposito',
			'estado',			
			'id_empleado_responsable',
			'id_depto_af',
			{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
			'desc_persona',
			'nombre_depto'
			]),remoteSort:true});
			
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	///datos de los combos remotos
	//definicion del combo param.Departamento
	ds_empleado=new Ext.data.Store({ 
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php'}),		
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado_responsable',totalRecords:'TotalCount'},['id_empleado','desc_persona'])//,'codigo_depto'])
	});
	function renderEmpleado(value,p,record){return String.format('{0}',record.data['desc_persona'])}
	
	////definicion del combo param.Departamento
	ds_departamento=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamento.php?subsistema=actif'}),		
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto_af',totalRecords:'TotalCount'},['id_depto','nombre_depto','codigo_depto'])
	});
	function renderDepto(value,p,record){return String.format('{0}',record.data['nombre_depto'])}	
	///	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
//id_tipo_proceso
	vectorAtributos[0]= {
	validacion:{
		labelSeparator:'',
		name: 'id_deposito',
		inputType:'hidden',
		grid_visible:false,
		grid_editable:false
	},
	tipo: 'Field',
	filtro_0:false,
	save_as:'id_deposito'
};
		
	vectorAtributos[1]= {
			validacion:{
				labelSeparator:'',
				name:'nombre_deposito',
				fieldLabel:'Nombre Deposito',
				allowBlank:false,
				inputType:'',
				maxLength:100,
				grid_visible:true,
				grid_editable:false,
				width_grid:150,
				width:300,
				grid_indice:1
			},
			tipo: 'TextField',
			filtro_0:true,
			filterColValue:'nombre_deposito',
			save_as:'nombre_deposito'
		};
	//txt id_usuario_Reg
	vectorAtributos[2]= {
			validacion:{
				name:'estado',
				fieldLabel:'Estado',
				maxLength:4,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
					grid_visible:true,
					grid_editable:false,
					width_grid:80,
					width:40,
					disabled:false,
					grid_indice:2	
				},
			tipo: 'Field',
			form:false,
			filtro_0:false,
			save_as:'estado'
		};
	// txt fecha_reg
	vectorAtributos[3]= {
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha de Registro',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			renderer: formatDate,
			width_grid:105,
			disabled:true,
			grid_indice:3	
		},		form:false,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'DEPOSI.fecha_reg',
		dateFormat:'m/d/Y',
		save_as:'fecha_reg'			
	};	 
// txt codigo_actividad
	vectorAtributos[4]= {
			validacion:{		
		fieldLabel:'Nombre del Empleado',
		name:'id_empleado_responsable',
		vtype:"texto",
		emptyText:'Nombre del Empleado...',
		allowBlank:false,
		desc:'desc_persona',//es el nombre de la persona
		store:ds_empleado,//agregado
		selectOnFocus:true,
		valueField:'id_empleado',
		displayField:'desc_persona',//es el nombre de la persona',
		queryParam:'filterValue_0',				
		filterCol:'PERSON.nombre#PERSON.apellido_paterno#PERSON.apellido_materno',
		typeAhead:false,
		forceSelection:false,
		//tpl:resultTplDepto,
		mode:'remote',
		queryDelay:50,
		pageSize:10,
		minListWidth:300,
		resizable:true,
		minChars:1,
		triggerAction:'all',
		editable:true,
		renderer:renderEmpleado,
		grid_visible:true,
		grid_editable:false,
		width_grid:180,
		width:300,
		grid_indice:4	
		},
	tipo: 'ComboBox',
	form: true,
	filtro_0:true,			
	filterColValue:'tsgper.nombre#tsgper.apellido_paterno#tsgper.apellido_materno',
	save_as:'id_empleado_responsable'
	};
	vectorAtributos[5]= {
			validacion:{
				
				fieldLabel:'Nombre del Departamento',
				name:'id_depto_af',
				vtype:"texto",
				emptyText:'Nombre Departamento...',
				allowBlank:false,
				desc:'nombre_depto',//es el nombre del departamento
				store:ds_departamento,//agregado
				selectOnFocus:true,
				valueField:'id_depto',
				displayField:'nombre_depto',
				queryParam:'filterValue_0',
				//filterCol:'DEPTO.nombre_depto#DEPTO.id_depto',//filtra los datos del actionlistardatos
				filterCol:'DEPTO.nombre_depto',
				typeAhead:false,
				forceSelection:false,
				//tpl:resultTplDepto,
				mode:'remote',
				queryDelay:50,
				pageSize:10,
				minListWidth:300,
				resizable:true,
				minChars:1,
				triggerAction:'all',
				editable:true,
				renderer:renderDepto,
				grid_visible:true,
				grid_editable:false,
				width_grid:180,
				width:300,
				grid_indice:5	
				},
			tipo: 'ComboBox',
			form: true,
			filtro_0:true,			
			filterColValue:'tpmdep.nombre_depto',//#DEPTO.id_depto',
			save_as:'id_depto_af'
				
		};
	 
//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){
		return value?value.dateFormat('d/m/Y'):''};


		//---------- INICIAMOS LAYOUT DETALLE
		//var config={titulo_maestro:'tipo_accion',grid_maestro:'grid-'+idContenedor};
		var config={titulo_maestro:'Datos de Deposito',grid_maestro:'grid-'+idContenedor};
		
		//var layout_tipo_adq=new DocsLayoutMaestro(idContenedor);
		var layout_deposito=new DocsLayoutMaestro(idContenedor);
		layout_deposito.init(config);

		////////////////////////
		// INICIAMOS HERENCIA //
		////////////////////////

		
		this.pagina=Pagina;
		//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
		this.pagina(paramConfig,vectorAtributos,ds,layout_deposito,idContenedor);
		var getComponente=this.getComponente;
		var CM_ocultarComponente=this.ocultarComponente;
		var CM_mostrarComponente=this.mostrarComponente;
		var getSelectionModel=this.getSelectionModel;
		var CM_conexionFailure=this.conexionFailure;
		var CM_btnNew=this.btnNew;
		var CM_btnEdit=this.btnEdit;
		var Cm_getDialog=this.getDialog;
		var ClaseMadre_getComponente=this.getComponente;

		///////////////////////////////////
		// DEFINICIÓN DE LA BARRA DE MENÚ//
		///////////////////////////////////

		var paramMenu={
			guardar:{crear:true,separador:false},
			nuevo:{crear:true,separador:true},
			editar:{crear:true,separador:false},
			eliminar:{crear:true,separador:false},
			actualizar:{crear:true,separador:false}
		};


		//////////////////////////////////////////////////////////////////////////////
		//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
		//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
		//////////////////////////////////////////////////////////////////////////////
		
		//datos necesarios para el filtro
		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/deposito/ActionEliminarDeposito.php'},
			Save:{url:direccion+'../../../control/deposito/ActionGuardarDeposito.php'},
			ConfirmSave:{url:direccion+'../../../control/deposito/ActionGuardarDeposito.php'},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:450,minWidth:150,minHeight:200,	closable:true,titulo:'Datos de Deposito'}};
		
		//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

		//Para manejo de eventos
	
		
		//function iniciarEventosFormularios(){//para iniciar eventos en el formulario
		//xt_empleado_sel=ClaseMadre_getComponente('empleado_sel');
		// txt_criterio=ClaseMadre_getComponente('criterio');
		//var getComponente=this.getComponente;
		//  txt_empleado_sel.on('select',onEstadoSelect);
		//}
		
		ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
			}
		});
		
	///parametros de la pagina
		this.getLayout=function(){return layout_deposito.getLayout()};
		this.Init(); //iniciamos la clase madre
		this.InitBarraMenu(paramMenu);	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
		this.InitFunciones(paramFunciones);	//para agregar botones		
		this.iniciaFormulario();
		layout_deposito.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
		ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
	}