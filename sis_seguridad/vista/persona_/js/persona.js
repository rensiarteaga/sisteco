/**
 * Nombre:		  	    pagina_persona_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-25 17:19:23
 */
function pagina_persona(idContenedor,direccion,paramConfig, tipo)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var componentes=new Array();
	var sw=0;
	
	var dir_emp;
		dir_emp=direccion+'../../../control/persona/ActionListarPersona.php';
	if(tipo=='sel_per'){
		dir_emp=direccion+'../../../control/persona/ActionListarPersona.php?empleado=1';
	}
	
	function render_desplegar_imagen(value, p, record)
	{	
		momentoActual = new Date();
		
		hora = momentoActual.getHours();
		minuto = momentoActual.getMinutes();
		segundo = momentoActual.getSeconds();
		
		hora_actual = hora+":"+minuto+":"+segundo;
		
		return  '<img src = ../../../sis_seguridad/control/persona/archivo/'+ record.data['numero'] + '.' + record.data['extension'] + '?' + record.data['nombre_foto'] + hora_actual +'>';
		//return  '<img src = ../../../sis_seguridad/control/persona/archivo/imagen4.gif>';
	}	
	
	/////////////////
	//  DATA STORE //
	/////////////////


	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: dir_emp}),
		//proxy: new Ext.data.HttpProxy({url: direccion+m_dir}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_persona',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
				'id_persona',
		'apellido_paterno',
		'apellido_materno',
		'nombre',
		{name: 'fecha_nacimiento',type:'date',dateFormat:'Y-m-d'},
		'foto_persona',
		'doc_id',
		'genero',
		'casilla',
		'telefono1',
		'telefono2',
		'celular1',
		'celular2',
		'pag_web',
		'email1',
		'email2',
		'email3',
		{name: 'fecha_registro',type:'date',dateFormat:'Y-m-d'},
		'hora_registro',
		{name: 'fecha_ultima_modificacion',type:'date',dateFormat:'Y-m-d'},
		'hora_ultima_modificacion',
		'observaciones',
		'desc_tipo_doc_identificacion',
		'id_tipo_doc_identificacion','direccion','nro_registro','id_empleado'/*,
		'nombre_foto',
		'numero',
		'foto',
		'extension'*/

		]),remoteSort:true});


	//DATA STORE COMBOS

    ds_tipo_doc_identificacion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_doc_identificacion/ActionListarTipoDocIdentificacion.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_tipo_doc_identificacion',
			totalRecords: 'TotalCount'
		}, ['id_tipo_doc_identificacion','nombre_tipo_documento','descripcion','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion'])
	});

	//FUNCIONES RENDER
	
			function render_id_tipo_doc_identificacion(value, p, record){return String.format('{0}', record.data['desc_tipo_doc_identificacion']);}
	
	
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_persona
	//en la posición 0 siempre esta la llave primaria

	var param_id_persona = {
		validacion:{
			labelSeparator:'',
			name: 'id_persona',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'hidden_id_persona'
	};
	vectorAtributos[0] = param_id_persona;
// txt apellido_paterno
	var param_apellido_paterno= {
		validacion:{
			name:'apellido_paterno',
			fieldLabel:'Apellido Paterno',
			allowBlank:true,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'80%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PERSON.apellido_paterno',
		save_as:'txt_apellido_paterno',
		id_grupo:0
	};
	vectorAtributos[1] = param_apellido_paterno;
// txt apellido_materno
	var param_apellido_materno= {
		validacion:{
			name:'apellido_materno',
			fieldLabel:'Apellido Materno',
			allowBlank:true,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'80%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PERSON.apellido_materno',
		save_as:'txt_apellido_materno',
		id_grupo:0
	};
	vectorAtributos[2] = param_apellido_materno;
// txt nombre
	var param_nombre= {
		validacion:{
			name:'nombre',
			fieldLabel:'Nombre',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'80%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PERSON.nombre',
		save_as:'txt_nombre',
		id_grupo:0
	};
	vectorAtributos[3] = param_nombre;
// txt fecha_nacimiento
	var param_fecha_nacimiento= {
		validacion:{
			name:'fecha_nacimiento',
			fieldLabel:'Fecha Nacimiento',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:85,
			disabled:false
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PERSON.fecha_nacimiento',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_nacimiento',
		id_grupo:0
	};
	vectorAtributos[4] = param_fecha_nacimiento;

	// txt foto_persona
    var param_foto_persona= 
    {
		validacion:{
			name:'foto_persona',
			fieldLabel:'Foto Persona',
			allowBlank:true,
			maxLength:-5,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100
		},
		tipo: 'Field',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PERSON.foto_persona',
		save_as:'txt_foto_persona'
		
		/*validacion:{
			name:'foto',
			fieldLabel:'Foto persona',
			invalidText: 'Por favor seleccione un archivo',
			allowBlank:true,
			inputType:'file',			
			grid_visible:true,
			grid_editable:false,
			renderer: render_desplegar_imagen
		},
		tipo: 'Field',
		save_as:'txt_foto_persona'*/
	};
	vectorAtributos[5] = param_foto_persona;
	
    /*var param_foto_persona= {
		validacion:{
			name:'foto_persona',
			fieldLabel:'Foto Persona',
			allowBlank:false,
			selectOnFocus:true,
			inputType:'file',	
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:'80%'
		},
		tipo: 'Field',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PERSON.foto_persona',
		save_as:'txt_foto_persona',
		id_grupo:0
	};
	vectorAtributos[5] = param_foto_persona;*/
var param_id_tipo_doc_identificacion= {
			validacion: {
			name:'id_tipo_doc_identificacion',
			fieldLabel:'Tipo de Documento de Identificación',
			allowBlank:false,			
			emptyText:'Documento de Identificación...',
			desc: 'desc_tipo_doc_identificacion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_tipo_doc_identificacion,
			valueField: 'id_tipo_doc_identificacion',
			displayField: 'nombre_tipo_documento',
			queryParam: 'filterValue_0',
			filterCol:'TIDOID.nombre_tipo_documento',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			//grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_tipo_doc_identificacion,
			grid_visible:true,
			grid_editable:true,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TIDOID.nombre_tipo_documento',
		defecto: '',
		save_as:'txt_id_tipo_doc_identificacion',
		id_grupo:1
	};
	vectorAtributos[6] = param_id_tipo_doc_identificacion;

// txt genero
	var param_genero= {
			validacion: {
			name:'genero',
			fieldLabel:'Genero',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data : Ext.persona_combo.genero
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width_grid:60 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PERSON.genero',
		defecto:'varon',
		save_as:'txt_genero',
		id_grupo:0
	};
	vectorAtributos[8] = param_genero;
// txt casilla
	var param_casilla= {
		validacion:{
			name:'casilla',
			fieldLabel:'Casilla',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'80%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PERSON.casilla',
		save_as:'txt_casilla',
		id_grupo:3
	};
	vectorAtributos[9] = param_casilla;
// txt telefono1
	var param_telefono1= {
		validacion:{
			name:'telefono1',
			fieldLabel:'Telefono 1',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'80%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PERSON.telefono1',
		save_as:'txt_telefono1',
		id_grupo:2
	};
	vectorAtributos[10] = param_telefono1;
// txt telefono2
	var param_telefono2= {
		validacion:{
			name:'telefono2',
			fieldLabel:'Telefono2',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'80%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PERSON.telefono2',
		save_as:'txt_telefono2',
		id_grupo:2
	};
	vectorAtributos[11] = param_telefono2;
// txt celular1
	var param_celular1= {
		validacion:{
			name:'celular1',
			fieldLabel:'Celular 1',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'80%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PERSON.celular1',
		save_as:'txt_celular1',
		id_grupo:2
	};
	vectorAtributos[12] = param_celular1;
// txt celular2
	var param_celular2= {
		validacion:{
			name:'celular2',
			fieldLabel:'Celular 2',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'80%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PERSON.celular2',
		save_as:'txt_celular2',
		id_grupo:2
	};
	vectorAtributos[13] = param_celular2;
// txt pag_web
	var param_pag_web= {
		validacion:{
			name:'pag_web',
			fieldLabel:'Pagina Web',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'80%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PERSON.pag_web',
		save_as:'txt_pag_web',
		id_grupo:3
	};
	vectorAtributos[14] = param_pag_web;
// txt email1
	var param_email1= {
		validacion:{
			name:'email1',
			fieldLabel:'Email 1',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'email',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'80%',
			disabled:false
		},
		tipo: 'TextField',
		filtro_0:true,
		form:true,
		filtro_1:true,
		filterColValue:'PERSON.email1',
		save_as:'txt_email1',
		id_grupo:3
	};
	vectorAtributos[15] = param_email1;
// txt email2
	var param_email2= {
		validacion:{
			name:'email2',
			fieldLabel:'Email 2',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'email',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'80%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PERSON.email2',
		save_as:'txt_email2',
		id_grupo:3
	};
	vectorAtributos[16] = param_email2;
// txt email3
	var param_email3= {
		validacion:{
			name:'email3',
			fieldLabel:'Email 3',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'email',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'80%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PERSON.email3',
		save_as:'txt_email3',
		id_grupo:3
	};
	vectorAtributos[17] = param_email3;
// txt fecha_registro
	var param_fecha_registro= {
		validacion:{
			name:'fecha_registro',
			fieldLabel:'Fecha Registro',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:85,
			disabled:true
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PERSON.fecha_registro',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_registro',
		id_grupo:4
	};
	vectorAtributos[18] = param_fecha_registro;
// txt hora_registro
	var param_hora_registro= {
		validacion:{
			name:'hora_registro',
			fieldLabel:'Hora Registro',
			allowBlank:false,
			maxLength:8,
			minLength:0,
			selectOnFocus:true,
			vtype:'time',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			disabled:true
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PERSON.hora_registro',
		save_as:'txt_hora_registro',
		id_grupo:4
	};
	vectorAtributos[19] = param_hora_registro;
// txt fecha_ultima_modificacion
	var param_fecha_ultima_modificacion= {
		validacion:{
			name:'fecha_ultima_modificacion',
			fieldLabel:'Fecha Ultima Modificación',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			renderer: formatDate,
			width_grid:85,
			disabled:true
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PERSON.fecha_ultima_modificacion',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_ultima_modificacion',
		id_grupo:5
	};
	vectorAtributos[20] = param_fecha_ultima_modificacion;
// txt hora_ultima_modificacion
	var param_hora_ultima_modificacion= {
		validacion:{
			name:'hora_ultima_modificacion',
			fieldLabel:'Hora Ultima Modificación',
			allowBlank:true,
			maxLength:8,
			minLength:0,
			selectOnFocus:true,
			vtype:'time',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			disabled:true
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PERSON.hora_ultima_modificacion',
		save_as:'txt_hora_ultima_modificacion',
		id_grupo:5
	};
	vectorAtributos[21] = param_hora_ultima_modificacion;
// txt observaciones
var texto='';
if(tipo=='sel_per'){
  texto='Referencias';
  
  vectorAtributos[24]= {
		validacion:{
			name:'nro_registro',
			fieldLabel:'Nº Registro',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'80%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PERSON.nro_registro',
		save_as:'txt_nro_registro',
		id_grupo:0
	};
	
  
}else{
	texto='Observaciones';
}
	vectorAtributos[23]= {
		validacion:{
			name:'observaciones',
			fieldLabel:texto,
			allowBlank:true,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:200,
			width:'100%'
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PERSON.observaciones',
		save_as:'txt_observaciones',
		id_grupo:0
	};
	 
// txt doc_id
	vectorAtributos[7]= {
		validacion:{
			name:'doc_id',
			fieldLabel:'Documento de Identificación',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'80%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PERSON.doc_id',
		save_as:'txt_doc_id',
		id_grupo:1
	};

	// txt id_tipo_doc_identificacion
	
	
	vectorAtributos[24]= {
		validacion:{
			name:'direccion',
			fieldLabel:'Dirección',
			allowBlank:true,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'80%'
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PERSON.direccion',
		save_as:'txt_direccion',
		id_grupo:0
	};
	

	vectorAtributos[22] = {
		validacion:{
			labelSeparator:'',
			name: 'tipo',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		defecto:tipo,
		filtro_0:false,
		save_as:'tipo'
	};
	
	vectorAtributos[25]=
	{
		validacion:{
			name: 'numero',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false		
		},
		tipo: 'Field',
		form: true,
		filtro_0:false,
		save_as:'numero'
	};
	vectorAtributos[26]=
	{
		validacion:{
			name: 'extension',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false		
		},
		tipo: 'Field',
		form: true,
		filtro_0:false,
		save_as:'extension'
	};
	
	
	vectorAtributos[27]=
	{
		validacion:{
			name: 'empleado_modifica',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false		
		},
		tipo: 'Field',
		form: true,
		filtro_0:false,
		save_as:'empleado_modifica'
	};
	//vectorAtributos[25] = param_tipo;
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////
	//Inicia Layout
	var config = {
		titulo_maestro:'persona',
		grid_maestro:'grid-'+idContenedor
	};
	
	if(tipo=='sel_per'){
		var config={titulo_maestro:'Curriculum',grid_maestro:'grid-'+idContenedor,initialSize:'75%',urlHijo:'../../../sis_kardex_personal/vista/empleado_trabajo/empleado_trabajo.php',title_hijo:'Experiencia Laboral'};
		//var config={titulo_maestro:'Curriculum',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_kardex_personal/vista/empleado_capacitacion/empleado_capacitacion.php'};
		//var config={titulo_maestro:'Curriculum',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_kardex_personal/vista/empleado_trabajo/empleado_trabajo.php'};
		layout_persona=new DocsLayoutMaestroDeatalle(idContenedor);
	}else{

		if(tipo=='bus_per') {
			var config={titulo_maestro:'Curriculum',grid_maestro:'grid-'+idContenedor,initialSize:'50%',area:'east',urlHijo:'../../../sis_kardex_personal/vista/empleado_trabajo/empleado_trabajo.php?buscar=si', title_hijo:'Experiencia Laboral'};
			layout_persona=new DocsLayoutMaestroDeatalle(idContenedor);
		}else{
		
		   layout_persona=new DocsLayoutMaestro(idContenedor);
		}
	}
	layout_persona.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_persona,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var ClaseMadre_btnEdit=this.btnEdit;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var cm_EnableSelect=this.EnableSelect;
	var cm_DeselectRow=this.DeselectRow;
	var mGrid=this.getGrid;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////
 
	var paramMenu;
	if(tipo=='sel_per'){
		 paramMenu={
		 	//guardar:{crear:true,separador:false},
			//nuevo:{crear:true,separador:true},
			editar:{crear:true,separador:false},
			//eliminar:{crear:true,separador:false},
			actualizar:{crear:true,separador:false}
		 }
	}else{
		
	if(tipo=='bus_per'){
		paramMenu={
			actualizar:{crear:true,separador:false}
		};
		}else{
		
		paramMenu={
			guardar:{crear:true,separador:false},
			nuevo:{crear:true,separador:true},
			editar:{crear:true,separador:false},
			eliminar:{crear:true,separador:false},
			actualizar:{crear:true,separador:false}
		};
		}
	}
	
	
	
	var	ds_carrera=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+"../../../../sis_kardex_personal/control/tipo_capacitacion/ActionListarTipoCapacitacion.php?estado=activo&carrera=si&todos=1"}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_capacitacion',totalRecords:'TotalCount'},['id_tipo_capacitacion','nombre'])});
	
	var tpl_carrera=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','</div>');
var carrera =new Ext.form.ComboBox({
			store:ds_carrera,
			displayField:'nombre',
			typeAhead:true,
			mode:'remote',
			triggerAction:'all',
			emptyText:'Carrera...',
			selectOnFocus:true,
			width:100,
			valueField:'id_tipo_capacitacion',
			tpl:tpl_carrera
		});
    carrera.on('select',function (combo, record, index){id_carrera_per=carrera.getValue();
  	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			carrera:'si',
			id_carrera:id_carrera_per,
			
		}
	});	
   });
   
   
   
   var ds_unidad_organizacional = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarUnidadOrganizacional.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_organizacional',totalRecords: 'TotalCount'},
			['id_unidad_organizacional','nombre_unidad','nombre_cargo','centro','cargo_individual','descripcion','fecha_reg','id_nivel_organizacional','estado_reg','nombre_nivel']),
			baseParams:{gerencia:'si'}
	});
	
	function render_id_unidad_organizacional(value, p, record){return String.format('{0}', record.data['nombre_unidad']);}
		var tpl_id_unidad_organizacional=new Ext.Template('<div class="search-item">','<b>{nombre_unidad}</b>','<br><FONT COLOR="#B5A642"><b>Unidad de Aprobación: </b>{centro}</FONT>','<br><FONT COLOR="#B5A642"><b>Jerarquia: </b>{nombre_nivel}</FONT>','</div>');
		
		
		var uo =new Ext.form.ComboBox({
			store:ds_unidad_organizacional,
			displayField:'nombre_unidad',
			typeAhead:true,
			mode:'remote',
			triggerAction:'all',
			emptyText:'Gerencias...',
			selectOnFocus:true,
			width:220,
			valueField:'id_unidad_organizacional',
			tpl:tpl_id_unidad_organizacional
		});
    uo.on('select',function (combo, record, index){id_uo_per=uo.getValue();
  	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			id_uo:id_uo_per
			
			
		}
	});	
   });

	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	//datos necesarios para el filtro
	var paramFunciones = {
		btnEliminar:{url:direccion+'../../../control/persona/ActionEliminarPersona.php'},
		
		
		Save:{url:direccion+'../../../control/persona/ActionGuardarPersona.php'},
		
		//Save:{url:direccion+'../../../control/persona_2/ActionGuardarPersona.php'},
		ConfirmSave:{url:direccion+'../../../control/persona/ActionGuardarPersona.php'},
		
		Formulario:{
			titulo:'Persona',
			html_apply:"dlgInfo-"+idContenedor,
			width:'64%',
			height:'80%',
			minWidth:200,
			minHeight:150,
			columnas:['47%','47%'],
			closable:true,
			upload:false,
			grupos:[
			{
				tituloGrupo:'Datos Personales',
				columna:0,
				id_grupo:0
			},
			{
				tituloGrupo:'Documento de Identificación',
				columna:0,
				id_grupo:1
			},
			{
				tituloGrupo:'Dirección Telefono',
				columna:1,
				id_grupo:2
			},
			
			{
				tituloGrupo:'Dirección Correo - Web',
				columna:1,
				id_grupo:3
			},
			
			{
				tituloGrupo:'Hora y Fecha Registro',
				columna:1,
				id_grupo:4
			},
			{
				tituloGrupo:'Hora y Fecha Modificación',
				columna:1,
				id_grupo:5
			}
			]
		}
	
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	 this.btnNew = function()
	{
		//dialog.resizeTo('50%','70%');
		ClaseMadre_getComponente('email1').disable();
		CM_mostrarGrupo('Datos Personales');
		CM_mostrarGrupo('Documento de Identificación');
		CM_mostrarGrupo('Dirección Telefono');
		CM_mostrarGrupo('Dirección Correo - Web');
		CM_mostrarGrupo('Hora y Fecha Registro');
		CM_ocultarGrupo('Hora y Fecha Modificación');
		//CM_ocultarComponente(ClaseMadre_getComponente('email1'));
		if(tipo=='sel_per'){
			
			CM_ocultarComponente(ClaseMadre_getComponente('casilla'));
			CM_ocultarComponente(ClaseMadre_getComponente('telefono2'));
			CM_ocultarComponente(ClaseMadre_getComponente('celular2'));
			CM_ocultarComponente(ClaseMadre_getComponente('pag_web'));
			CM_ocultarComponente(ClaseMadre_getComponente('email2'));
			CM_ocultarComponente(ClaseMadre_getComponente('email3'));
			
		}
		
		
		ClaseMadre_btnNew();
		get_fecha_bd();
		get_hora_bd();
	};
	
	 this.btnEdit = function()
	{
		//dialog.resizeTo('50%','70%');
		ClaseMadre_getComponente('email1').enable();
		CM_mostrarGrupo('Datos Personales');
		CM_mostrarGrupo('Documento de Identificación');
		CM_mostrarGrupo('Dirección Telefono');
		CM_mostrarGrupo('Dirección Correo - Web');
		CM_ocultarGrupo('Hora y Fecha Registro');
		CM_mostrarGrupo('Hora y Fecha Modificación');
		CM_mostrarComponente(ClaseMadre_getComponente('email1'));
		if(tipo=='sel_per'){
			ClaseMadre_getComponente('email1').disable();
		}else{
			ClaseMadre_getComponente('email1').enable();
		}
		
		ClaseMadre_btnEdit();
				
	    /*cmp_foto = ClaseMadre_getComponente('foto');
	    cmp_foto.reset();*/
	    
		get_fecha_bd();
		get_hora_bd();
	};
    function get_fecha_bd()
	{
		Ext.Ajax.request({
			url:direccion+"../../../../lib/lib_control/action/ActionObtenerFechaBD.php",
			method:'GET',
			success:cargar_fecha_bd,
			failure:ClaseMadre_conexionFailure,
			timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
		});
	}
	function cargar_fecha_bd(resp)
	{   
		Ext.MessageBox.hide();
		if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
			var root = resp.responseXML.documentElement;
			if(ClaseMadre_getComponente('fecha_registro').getValue()=="")
			{
				ClaseMadre_getComponente('fecha_registro').setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
			}
		   	ClaseMadre_getComponente('fecha_ultima_modificacion').setValue(root.getElementsByTagName('fecha')[0].firstChild.nodeValue);
			
		}
	}
	function get_hora_bd()
		{
		Ext.Ajax.request({
			url:direccion+"../../../../lib/lib_control/action/ActionObtenerHoraBD.php",
			method:'GET',
			success:cargar_hora_bd,
			failure:ClaseMadre_conexionFailure,
			timeout:100000//TIEMPO DE ESPERA PARA DAR FALLO
			});
		}

	function cargar_hora_bd(resp)
		{
			Ext.MessageBox.hide();
			if(resp.responseXML != undefined && resp.responseXML != null && resp.responseXML.documentElement != null && resp.responseXML.documentElement != undefined){
				var root = resp.responseXML.documentElement;
			if(ClaseMadre_getComponente('hora_registro').getValue()==""){
				ClaseMadre_getComponente('hora_registro').setValue(root.getElementsByTagName('hora')[0].firstChild.nodeValue);
				}
				ClaseMadre_getComponente('hora_ultima_modificacion').setValue(root.getElementsByTagName('hora')[0].firstChild.nodeValue);
			}
		}
	
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
		for(i=0;i<vectorAtributos.length;i++){
				componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name);
		}
		sm=getSelectionModel();
		if(tipo=='sel_per' || tipo=='bus_per'){
			
			ClaseMadre_getComponente('empleado_modifica').setValue(1);
			var xx=mGrid();
			
			xx.getColumnModel().setHidden(4,true);
			xx.getColumnModel().setHidden(8,true);
			xx.getColumnModel().setHidden(10,true);
			xx.getColumnModel().setHidden(12,true);
			xx.getColumnModel().setHidden(13,true);
			xx.getColumnModel().setHidden(15,true);
			xx.getColumnModel().setHidden(16,true);
			xx.getColumnModel().setHidden(17,true);
			xx.getColumnModel().setHidden(18,true);
			xx.getColumnModel().setHidden(19,true);
			xx.getColumnModel().setHidden(20,true);
		
		}
		
		
	
	}
	
//rac: 16/02/2010	para utlizar combo trigguer 
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		//carga datos XML
				ds.load({
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros
					}
				});
		
	};
	

	this.EnableSelect=function(sm,row,rec){
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();	
		
		//enable(sm,row,rec);
		cm_EnableSelect(sm,row,rec); 
		if(tipo=='sel_per' || tipo=='bus_per'){
		   _CP.getPagina(layout_persona.getIdContentHijo()).pagina.reload(rec.data);
		   _CP.getPagina(layout_persona.getIdContentHijo()).pagina.desbloquearMenu();	
		   
		   
		   ////-------------------------------////
		   
		}
	}

	this.DeselectRow=function(sm,row){ 
		var sm=getSelectionModel();
		
		cm_DeselectRow(sm,row); 
		if(tipo=='sel_per'|| tipo=='bus_per'){ 
		  if(_CP.getPagina(layout_persona.getIdContentHijo()).pagina.limpiarStore()){
		   _CP.getPagina(layout_persona.getIdContentHijo()).pagina.bloquearMenu();	}
		}
	}
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_persona.getLayout();};
	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i];
			}
		}
	};
	
	function btn_relacion_familiar()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0)
		{
			var SelectionsRecord=sm.getSelected();
			var data='id_empleado='+SelectionsRecord.data.id_empleado;
			
			var ParamVentana={Ventana:{width:'60%',height:'70%'}}
			layout_persona.loadWindows(direccion+'../../../../sis_kardex_personal/vista/relacion_familiar/relacion_familiar.php?'+data,'Relacion Familiar',ParamVentana);
            layout_persona.getVentana().on('resize',function(){layout_persona.getLayout().layout()})
		}
		else
		{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un item.')
		}
	}
	function btn_curriculum_vitae(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					var data='m_id_persona='+SelectionsRecord.data.id_persona;
					data=data+ '&numero='+ClaseMadre_getComponente('numero').getValue()+'&extension='+ClaseMadre_getComponente('extension').getValue();
					
						//alert (ClaseMadre_getComponente('numero').getValue());	
					window.open(direccion+'../../../../sis_kardex_personal/control/empleado/ActionPDFEmpleadosCV.php?'+data)

				}
				else
				{
					Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
				}
			}

	
	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};

				//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
				this.Init(); //iniciamos la clase madre
				this.InitBarraMenu(paramMenu);
				//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
				this.InitFunciones(paramFunciones);
				//para agregar botones
				
				
				if(tipo=='sel_per'){
					this.AdicionarBoton('../../../lib/imagenes/print.gif','Curriculum Vitae',btn_curriculum_vitae,true,'curriculum_vitae','CurriculumVitae');
					this.AdicionarBoton('../../../lib/imagenes/user_div.png','Relacion Familiar',btn_relacion_familiar,true,'relacion_familiar','Relacion Familiar');
				}
				
				if(tipo=='bus_per'){
				this.AdicionarBotonCombo(carrera,'carrera');
				this.AdicionarBotonCombo(uo,'uo');
				}
				this.iniciaFormulario();
				iniciarEventosFormularios();

				layout_persona.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				
			    if (_CP.getVentana()){
			    	_CP.getVentana().on('resize',function(){layout_persona.getLayout().layout()})
			    }
			    
				
				
				_CP.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
				
					//carga datos XML
				ds.load({
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros
					}
				});
				
				
				
}