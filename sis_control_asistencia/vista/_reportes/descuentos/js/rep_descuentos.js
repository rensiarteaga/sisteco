function GenerarReporteDescuentos(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	var ContPes=1;
	var componentes=new Array();
	var ds_empleado;
	var h_txt_fecha_ini;
	var	h_txt_fecha_fin;
   var txt_id_gerencia,txt_nombre,txt_descripcion_gerencia,txt_codigo,txt_button,combo_empleado,txt_rol;
	//////////////////////////////////////////////////////////////
	// ------------------  PARÁMETROS --------------------------//
	// Definición de todos los tipos de datos que se maneja    //
	//////////////////////////////////////////////////////////////

	/////////// hidden id_tipo_activo//////
	//en la posición 0 siempre tiene que estar la llave primaria
	/////DATA STORE////////////
	ds_empleado=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../../sis_kardex_personal/control/empleado/ActionListarFuncionario.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords:'TotalCount'},['id_empleado','id_persona','desc_persona'])
	});
	//Define las columnas a desplegar
	/////////// txt codigo//////
    /*var filterCols_funcionario=new Array();
	var filterValues_funcionario=new Array();
	filterCols_funcionario[0]='EMPEXT.id_gerencia';
	filterValues_funcionario[0]='%';*/
	vectorAtributos[0]={
		validacion:{
			fieldLabel:'Funcionario',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Funcionario...',
			name:'id_empleado',
			desc:'desc_persona',
			store:ds_empleado,
			valueField:'id_empleado',
			displayField:'desc_persona',
			queryParam:'filterValue_0',
			filterCol:'FUNCIO.desc_persona',
			/*filterCols:filterCols_funcionario,
			filterValues:filterValues_funcionario,*/
			typeAhead:false,
			forceSelection:true,
			//tpl:resultTplEmp,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			minChars:0,
			triggerAction:'all',
			editable:true
		},
		id_grupo:2,
		save_as:'txt_id_empleado',
		tipo:'ComboBox'
	};
///////// fecha_ini /////////
	vectorAtributos[1]={
		validacion:{
			name:'fecha_ini',
			fieldLabel:'Fecha',
			allowBlank:false,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDays:[0,2,3,4,5, 6],
			disabledDaysText:'Día no válido',
			grid_visible:true,// se muestra en el grid
			grid_editable:false,//es editable en el grid,
			renderer:formatDate,
			width_grid:120,// ancho de columna en el grid
			disabled:false
		},
		id_grupo:0,
		tipo:'DateField',
		save_as:'txt_fecha_ini',
		dateFormat:'m/d/Y'
	};
	///////// fecha /////////
	vectorAtributos[2]={
		validacion:{
			name:'fecha_fin',
			fieldLabel:'Fecha',
			allowBlank:false,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDays:[0,1,2,3,4, 6],
			disabledDaysText:'Día no válido',
			grid_visible:true,// se muestra en el grid
			grid_editable:false,//es editable en el grid,
			renderer:formatDate,
			width:85,// ancho de columna en el grid
			disabled:true
		},
		id_grupo:1,
		tipo:'TextField',
		save_as:'txt_fecha_fin',
		dateFormat:'m/d/Y', //formato de fecha que envía para guardar
		defecto:"" // valor por default para este campo
	};
	/////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};
	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////
	// ---------- Inicia Layout ---------------//
	var config={
		titulo_maestro:"Descuento Semanal"
	};
	layout_rep_descuentos=new DocsLayoutProceso(idContenedor);
	layout_rep_descuentos.init(config);
	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS HERENCIA           -----------//
	//////////////////////////////////////////////////////////////
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
    this.pagina(paramConfig,vectorAtributos,layout_rep_descuentos,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
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
	var ClaseMadre_btnEliminar=this.btnEliminar;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	ds_empleado.addListener('loadexception',  ClaseMadre_conexionFailure); //se recibe un error
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
		//Para manejo de eventos		
	function get_fecha(fecha)
	{
		var fecha=new Date(fecha);
		var dia;
		var mes;
		var anio;
		var fecha_res;
		dia=fecha.getDate();
		if(dia<10){dia="0"+dia;}
		mes=fecha.getMonth()+1;
		if(mes<10){mes="0"+mes;}
		anio=fecha.getFullYear();
		fecha_res=dia+"/"+mes+"/"+anio;
		return fecha_res;	
	}
function iniciarEventosFormularios()
	{
		h_txt_fecha_ini=ClaseMadre_getComponente('fecha_ini');
		h_txt_fecha_fin=ClaseMadre_getComponente('fecha_fin');
		combo_empleado=ClaseMadre_getComponente('id_empleado');
	function opcion_obs()
		{
          var fecha=componentes[0].getValue();
          var dt=new Date(fecha).add(Date.DAY,4);
          var fecha_fin=get_fecha(dt);
          componentes[1].setValue(fecha_fin);         
		}
		componentes[0].on('change',opcion_obs);
		componentes[0].on('select',opcion_obs);			
	}
	function eventosAjax(){
		Ext.lib.Ajax.request('POST','../../../sis_telefonico/control/_reportes/llamadas_gerencia/ActionGerencia.php?asistencia=si',
		                     {success:gerencia,failure:this.conexionFailure})
	}
	var InitFunciones=this.InitFunciones;
    //Se agrega el botón para la generación del reporte
	var iniciaFormulario=this.iniciaFormulario;		
//------  sobrecargo la clase madre obtenerTitulo  para las pestanas-----------------//
	function obtenerTitulo()
	{  //var combo_financiador = ClaseMadre_getComponente('id_financiador');
		var titulo="Descuento Semanal "+ContPes;
		ContPes ++;
		return titulo;
	}
	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	function gerencia(resp){
		var regreso=Ext.util.JSON.decode(resp.responseText);
		txt_id_gerencia=regreso.id_gerencia;
		txt_nombre=regreso.nombre_gerencia;
		txt_codigo=regreso.codigo;
		txt_descripcion_gerencia=regreso.descripcion;
		txt_rol=regreso.rol;
		var paramFunciones={
 		    Formulario:{
			labelWidth: 75, //ancho del label
			url:direccion+'../../../../../sis_control_asistencia/control/_reportes/descuentos/ActionRptDescuentos.php',
			abrir_pestana:true, //abrir pestana
			titulo_pestana:obtenerTitulo,
			fileUpload:false,
			columnas:[320,280],
			grupos:[
			{
				tituloGrupo:'Fecha Inicio',
				columna:0,
				id_grupo:0
			},
			{
				tituloGrupo:'Fecha Fin',
				columna:0,
				id_grupo:1
			},
			{
				tituloGrupo:'Funcionario',
				columna:1,
				id_grupo:2
			}],
			parametros: ''
		}
	};
		InitFunciones(paramFunciones);
		iniciaFormulario();
		iniciarReporteDescuentos();
		iniciarEventosFormularios();
		if(txt_codigo=='null'){
			Ext.Msg.show({
			title:'Estado',
			msg:'El Usuario no pertenece a ninguna Gerencia.',
			minWidth:300,
			maxWidth :800,
			buttons: Ext.Msg.OK
		})
		 txt_button=ClaseMadre_getForm();
		 txt_button.buttons[0].disable()
		}
		if(txt_codigo=='GGN' || txt_codigo=='GTI' || txt_rol==1){
			/*combo_empleado.filterValues[0]=txt_id_gerencia;
			combo_empleado.modificado=true;*/
			combo_empleado.enable()
		}
		else{
			combo_empleado.filterValues[0]=txt_id_gerencia;
			combo_empleado.modificado=true
		}
	}
	
function iniciarReporteDescuentos()
	{	
		for(i=0;i<vectorAtributos.length-1;i++){
	    componentes[i]=ClaseMadre_getComponente(vectorAtributos[i+1].validacion.name);
		}
	}

//InitBarraMenu(array BOTONES DISPONIBLES);

	this.Init(); //iniciamos la clase madre
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	eventosAjax();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);	
}
