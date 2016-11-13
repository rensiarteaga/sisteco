/**
 * Nombre:		  	    pagina_solicitud_licencia.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-18 09:06:57
 */
function pagina_solicitud_licencia(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
	var ds,ds_gestion;
	var elementos=new Array();
	var layout_solicitud_licencia;
	var combo_gestion;
    var sw=0;
	var componentes=new Array;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/vacacion/ActionListarSolicitudLicencia.php'}),
		// aqui se define la estructura del XML
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_vacacion',
			totalRecords:'TotalCount'
		},[
		// define el mapeo de XML a las etiquetas (campos)
		'id_vacacion',
		'id_gestion',
		'desc_gestion',
		'id_empleado',
		'nombre_completo',
		'total_dias',
		'id_categoria_vacacion',
		'desc_categoria_vacacion',
		'dias_vacacion',		
		'dias_tomados',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},		
		'estado_reg',
		'dias_disponibles',		
		'dias_acumulados',
		'dias_adelantados',
		'id_empleado_aprobador',
		'dias_compensacion'
		]),remoteSort:true});		
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});
	//DATA STORE COMBOS
    var ds_gestion=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/gestion/ActionListarGestion.php?tipo_filtro=ultima_gestion_activa'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_gestion',
			totalRecords:'TotalCount'
		}, ['id_gestion','gestion','estado_ges_gral'])
	});   
	function render_estado_reg(value)
	{
		if(value=='activo'){value='Activo'	}
		else{	value='Inactivo'		}
		return value
	}    
	//FUNCIONES RENDER	
	// Definición de datos //
	function render_id_gestion(value,p,record){return String.format('{0}',record.data['desc_gestion'])}	
	var tpl_id_gestion=new Ext.Template('<div class="search-item">','{gestion}<br>','<b><FONT COLOR="#B5A642">{estado_ges_gral}</FONT></b>','</div>');	
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_vacacion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_vacacion'
	};
	vectorAtributos[1]={
			validacion: {
			name:'id_gestion',
			fieldLabel:'Gestion',
			allowBlank:false,			
			emptyText:'Gestion...',
			desc:'desc_gestion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_gestion,
			valueField:'id_gestion',
			displayField:'gestion',
			filterCol:'GESTIO.gestion',
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:15,
			minListWidth:200,
			grow:true,
			width:150,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:2, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_gestion,
			grid_visible:true,
			grid_editable:false,
			tpl:tpl_id_gestion,
			width_grid:130 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'GESTIO.gestion',
		save_as:'hidden_id_gestion'
	};
	
	vectorAtributos[2]={
		validacion:{
			labelSeparator:'',
			name:'id_empleado',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_empleado'
	};
	
	// txt codigo_empleado
	vectorAtributos[3]={
		validacion:{
			name:'nombre_completo',
			fieldLabel:'Funcionario',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			disabled:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:200
		},
		form:false,
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'EMPLEA.nombre_completo'	
	};
	vectorAtributos[4]={
		validacion:{
			labelSeparator:'',
			name:'id_categoria_vacacion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_categoria_vacacion'
	};
	// txt codigo_empleado
	vectorAtributos[5]={
		validacion:{
			name:'desc_categoria_vacacion',
			fieldLabel:'Categoria',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			disabled:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:150
		},
		form:false,
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'CATVAC.nombre'		
	};
	// txt codigo_empleado
	vectorAtributos[6]={
		validacion:{
			name:'dias_vacacion',
			fieldLabel:'Dias por Categoria',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		form:false,
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'CATVAC.dias_vacacion'
	};
	
	// txt tipo_documento
	vectorAtributos[7]={
		validacion:{
			name:'dias_acumulados',
			fieldLabel:'Dias Acumulados',
			allowBlank:true,
			selectOnFocus:true,
			//vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		form:false,
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'VACACI.dias_acumulados'
	};
	
	// txt doc_id
	vectorAtributos[8]={
		validacion:{
			name:'total_dias',
			fieldLabel:'Total Dias',
			allowBlank:true,
			selectOnFocus:true,
			//vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		form:false,
		tipo:'TextField',
		filtro_0:false,
		filtro_1:false
		};
	
	// txt email1
	vectorAtributos[9]={
		validacion:{
			name:'dias_tomados',
			fieldLabel:'Dias Tomados',
			allowBlank:true,
			selectOnFocus:true,
			//vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		form:false,
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'VACACI.dias_tomados'
	};
	vectorAtributos[10]={
		validacion:{
			name:'dias_disponibles',
			fieldLabel:'Dias Disponibles',
			allowBlank:true,
			selectOnFocus:true,
			//vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		form:false,
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'VACACI.dias_disponibles'
	};
	vectorAtributos[11]={
		validacion:{
			name:'dias_adelantados',
			fieldLabel:'Dias Adelantados',
			allowBlank:true,
			selectOnFocus:true,
			//vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		form:false,
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'VACACI.dias_adelantados'
	};	
	vectorAtributos[12]={
		validacion:{
			name:'dias_compensacion',
			fieldLabel:'Dias Disponibles Compensación',
			allowBlank:true,
			selectOnFocus:true,
			//vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:150
		},
		form:false,
		tipo:'TextField',
		filtro_0:false,
		filtro_1:false
		};	
	vectorAtributos[13]={
		validacion:{
			name:'estado_reg',			
			fieldLabel:'Estado',
			allowBlank:true,
			selectOnFocus:true,
			//vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		form:false,
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'VACACI.estado_reg'
	};
	vectorAtributos[14]= {	
		validacion:{
			name:'fecha_reg',
			fieldLabel:'Fecha Registro',
			allowBlank:true,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:true,
			grid_editable:false,
		    renderer:formatDate,
			width_grid:100
		},
		form:false,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'VACACI.fecha_reg',
		tipo:'DateField',
		dateFormat:'m-d-Y'	
	};
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};	
	
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//	
	var config={titulo_maestro:'Vacaciones',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_kardex_personal/vista/vacacion/solicitud_licencia_det.php'};
	layout_solicitud_licencia=new DocsLayoutMaestroDeatalle(idContenedor);
	layout_solicitud_licencia.init(config);
	
	// INICIAMOS HERENCIA //
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_solicitud_licencia,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_onResize=this.onResize;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var cm_EnableSelect=this.EnableSelect;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var ClaseMadre_clearSelections=this.clearSelections;
	
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	var paramMenu={
		//guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		//editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/vacacion/ActionEliminarSolicitudLicencia.php'},
		Save:{url:direccion+'../../../control/vacacion/ActionGuardarSolicitudLicencia.php'},
		ConfirmSave:{url:direccion+'../../../control/vacacion/ActionGuardarSolicitudLicencia.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:200,	//alto
		width:350,		
		closable:true,
		titulo:'Funcionario - Vacacion'}
	};	
		
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	
	//Para manejo de eventos
	function iniciarEventosFormularios()
	{
		for(var i=0; i<vectorAtributos.length; i++)
		{
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}
		//para iniciar eventos en el formulario
		getSelectionModel().on('rowdeselect',function()
		{
			if(_CP.getPagina(layout_solicitud_licencia.getIdContentHijo()).pagina.limpiarStore())
			{
				//_CP.getPagina(layout_solicitud_licencia.getIdContentHijo()).pagina.limpiarStore();
				_CP.getPagina(layout_solicitud_licencia.getIdContentHijo()).pagina.bloquearMenu()
			}
			
		} )	
	}
	
	this.EnableSelect=function(sm,row,rec)
	{
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();	
		
		//enable(sm,row,rec);
		cm_EnableSelect(sm,row,rec);
		
		if(rec.data.estado_reg=='activo'){
		  _CP.getPagina(layout_solicitud_licencia.getIdContentHijo()).pagina.desbloquearMenu();
			}
		else{
		  _CP.getPagina(layout_solicitud_licencia.getIdContentHijo()).pagina.bloquearMenu()
		  	}
		 if(rec.data.dias_disponibles <= 0 && rec.data.id_categoria_vacacion >= 1){
		  _CP.getPagina(layout_solicitud_licencia.getIdContentHijo()).pagina.BotonAdelanta(1);
			}
		else{
		  _CP.getPagina(layout_solicitud_licencia.getIdContentHijo()).pagina.BotonAdelanta(0);
		  	}
		_CP.getPagina(layout_solicitud_licencia.getIdContentHijo()).pagina.reload(rec.data);
				
	}
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_solicitud_licencia.getLayout()
	};
	
	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo)
	{
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++)
		{
			if(elementos[i].idContenedor==idContenedorHijo)
			{
				return elementos[i]
			}
		}
	};
	
	this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};
	
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	
	//para agregar botones
	//this.AdicionarBoton('../../../lib/imagenes/menu-show.gif','Asignación de EP',btn_empleado_tpm_frppa,true,'empleado_tpm_frppa','Asignar Estructura Programática');
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_solicitud_licencia.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}