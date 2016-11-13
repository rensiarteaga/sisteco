/**
 * Nombre:		  	    pagina_empleado_capacitacion.js
 * Propósito: 			pagina objeto principal
 * Autor:				Mercedes Zambrana Meneses
 * Fecha creación:		02-09-2010
 */
function pagina_empleado_capacitacion(idContenedor,direccion,paramConfig,idContenedorPadre,busqueda){
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	
	var combo_persona,txt_codigo_empleado,txt_nombre_tipo_documento;
    var txt_doc_id,txt_email1;
    var maestro=new Array();
	var sw=0;
	var componentes=new Array;
	var dialog;
	var form;
	
	
	
	
	var j=0;
	
	/////////////////
	//  DATA STORE //
	/////////////////
	ds=new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/empleado_capacitacion/ActionListarEmpleadoCapacitacion.php'}),
		// aqui se define la estructura del XML
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_empleado_capacitacion',
			totalRecords:'TotalCount'
		},[
		// define el mapeo de XML a las etiquetas (campos)
		'id_empleado_capacitacion',
		'id_empleado',
		'id_tipo_capacitacion',
		'descripcion',
		'id_institucion',
		'nombre',
		'financiado',
		
		{name:'fecha_ini',type:'date',dateFormat:'Y-m-d'},
		{name:'fecha_fin',type:'date',dateFormat:'Y-m-d'},
		'desc_institucion','desc_empleado','desc_capacitacion','nombre_institucion','direccion_institucion', 'ano_graduacion','id_persona','lugar_capacitacion', 'id_carrera','carrera',
		{name:'fecha_titulo',type:'date',dateFormat:'Y-m-d'},'reg_profesional'
		]),remoteSort:true});

	//DATA STORE COMBOS   	
	ds_capacitacion=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+"../../../../sis_kardex_personal/control/tipo_capacitacion/ActionListarTipoCapacitacion.php?estado=activo"}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_capacitacion',totalRecords:'TotalCount'},['id_tipo_capacitacion','nombre'])});
	
	ds_carrera=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+"../../../../sis_kardex_personal/control/tipo_capacitacion/ActionListarTipoCapacitacion.php?estado=activo&carrera=si"}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_capacitacion',totalRecords:'TotalCount'},['id_tipo_capacitacion','nombre'])});
	
	
	ds_institucion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/institucion/ActionListarInstitucion.php'}),
	reader: new Ext.data.XmlReader({
		record: 'ROWS',
		id: 'id_institucion',
		totalRecords: 'TotalCount'
	}, ['id_institucion','tdoc_id','doc_id','nombre','casilla','telefono1','telefono2','celular1','celular2','fax','email1','email2','pag_web','observaciones','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','estado_institucion','id_persona'])
	});
	//FUNCIONES RENDER
	
	function render_id_institucion(value, p, record){return String.format('{0}', record.data['desc_institucion']);}
	
	function render_id_capacitacion(value,p,record){return String.format('{0}',record.data['desc_capacitacion'])}
	function render_id_carrera(value,p,record){return String.format('{0}',record.data['carrera'])}
	
	
	
	function render_financiado(value){
		if(value=='si'){value='Si'	}
		else if(value=='no'){	value='No'		}
		else if(value=='parcial'){value='Parcial'}
		return value
	}
	
	function render_tipo_institucion(value)
	{
		if(value=='privado'){value='Privado'	}
		else if(value=='publico'){value='Público'	}
		return value
	}
	
	

	
   vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_empleado_capacitacion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo:'Field',
		filtro_0:false
	};
// txt id_empleado
	vectorAtributos[1]={
		validacion:{
			name:'id_empleado',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		//defecto:maestro.id_empleado,
		save_as:'id_empleado'
	};
	vectorAtributos[2]={
		validacion:{
		fieldLabel:'Tipo Capacitación',
		allowBlank:false,
		vtype:'texto',
		emptyText:'Tipo Capacitación...',
		name:'id_tipo_capacitacion',
		desc:'desc_capacitacion',
		store:ds_capacitacion,
		valueField:'id_tipo_capacitacion',
		displayField:'nombre',
		queryParam:'filterValue_0',
		filterCol:'nombre',
		typeAhead:true,
		forceSelection:true,
		renderer:render_id_capacitacion,
		mode:'remote',
		queryDelay:50,
		pageSize:10,
		minListWidth:300,
		onSelect: function(record){getComponente('id_tipo_capacitacion').setValue(record.data.id_tipo_capacitacion); 
			if(record.data.nombre=='Licenciatura'){      
				CM_mostrarComponente(getComponente('id_carrera'));
				CM_mostrarComponente(getComponente('fecha_titulo'));
				CM_mostrarComponente(getComponente('reg_profesional'));
				getComponente('id_carrera').allowBlank=false;
				
				getComponente('nombre').reset();
				getComponente('nombre').allowBlank=true;
			}else{
				CM_ocultarComponente(getComponente('fecha_titulo'));
				CM_ocultarComponente(getComponente('id_carrera'));
				CM_ocultarComponente(getComponente('reg_profesional'));
				getComponente('id_carrera').allowBlank=true;
				
				getComponente('id_carrera').reset();
				getComponente('fecha_titulo').reset();
				getComponente('nombre').allowBlank=false;
			}
		
		getComponente('id_tipo_capacitacion').collapse(); },
		width:200,
		resizable:true,
		minChars:0,
		triggerAction:'all',
		editable:true,
		grid_visible:true,
		grid_editable:false,
		width_grid:140
	},
	save_as:'id_tipo_capacitacion',
	tipo:'ComboBox',
	filtro_0:true,
	grid_indice:3,
	filterColValue:'CAPACI.nombre'
};


	vectorAtributos[3]={
		validacion:{
		fieldLabel:'Carrera',
		allowBlank:false,
		vtype:'texto',
		emptyText:'Carrera...',
		name:'id_carrera',
		desc:'carrera',
		store:ds_carrera,
		valueField:'id_tipo_capacitacion',
		displayField:'nombre',
		queryParam:'filterValue_0',
		filterCol:'nombre',
		typeAhead:true,
		forceSelection:true,
		renderer:render_id_carrera,
		mode:'remote',
		queryDelay:50,
		pageSize:10,
		minListWidth:300,
		confTrigguer:{
						url:direccion+'../../../../sis_kardex_personal/vista/tipo_capacitacion/tipo_capacitacion.php?tipo=si',
					    paramTri:'prueba:XXX',		
					    title:'Carreras',
					    param:{width:800,height:800},
					    idContenedor:idContenedor
					   // baseParams={tipo:'si'}
					   // clase_vista:'pagina_persona'
				},
		width:200,
		resizable:true,
		minChars:0,
		triggerAction:'all',
		editable:true,
		grid_visible:true,
		grid_editable:false,
		width_grid:200
	},
	save_as:'id_carrera',
	tipo:'ComboTrigger',
	filtro_0:true,
	grid_indice:3,
	filterColValue:'CARRE.nombre'
};
	
    
	vectorAtributos[4]= {
		validacion:{
			name:'nombre',
			fieldLabel:'Titulo Obtenido',
			allowBlank:true,
		
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:200
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		grid_indice:1,
		//filterColValue:'UNIORG.nombre_cargo'	
		filterColValue:'EMPCAP.nombre'	
		};
	vectorAtributos[5]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Observaciones',
			allowBlank:true,
		
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			width:200,
			grid_editable:false,
			width_grid:150
		},
		tipo:'TextArea',
		filtro_0:true,
		filtro_1:true,
		grid_indice:4,
		//filterColValue:'UNIORG.nombre_cargo'	
		filterColValue:'EMPCAP.descripcion'	
	};
		vectorAtributos[7]= {
				validacion: {
				name:'id_institucion',
				fieldLabel:'Institución',
				allowBlank:false,
				emptyText:'Institución...',
				name: 'id_institucion',     //indica la columna del store principal ds del que proviane el id
				desc: 'desc_institucion', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_institucion,
				valueField: 'id_institucion',
				displayField: 'nombre',
				queryParam: 'filterValue_0',
				filterCol:'INSTIT.nombre#INSTIT.casilla',
				typeAhead:true,
				//forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:150,
				minListWidth:450,
				grow:true,
				width:200,confTrigguer:{
						url:direccion+'../../../../sis_parametros/vista/institucion/institucion.php?tipo=sel_per',
					    paramTri:'prueba:XXX',		
					    title:'Instituciones',
					    param:{width:800,height:800},
					    idContenedor:idContenedor
					   // baseParams={tipo:'si'}
					   // clase_vista:'pagina_persona'
				},
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_institucion,
				grid_visible:true,
				grid_editable:false,
				width_grid:150 // ancho de columna en el gris
	
			},
			tipo:'ComboTrigger',
			filtro_0:true,
			filtro_1:false,
			filterColValue:'INSTIT.nombre',
			defecto: '',
			form:true,
			grid_indice:2,
			save_as:'id_institucion'
			
		};
		
	vectorAtributos[6]= {
		validacion: {
			name:'lugar_capacitacion',
			emptyText:'Lugar de Capacitacion',
			fieldLabel:'Lugar de Capacitacion',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[
			['extranjero','Extranjero'],['local','Local']
			
			]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			//renderer:render_tipo_capacitacion,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:90,
			width:200
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:false,
		filterColValue:'EMPCAP.lugar_capacitacion',
		save_as:'lugar_capacitacion'
		};
	
		
	vectorAtributos[15]={
		validacion:{
			name:'nombre_institucion',
			fieldLabel:'Nombre Institución',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			width:200
		},
		tipo:'TextField',
		filtro_0:false,
		form:false,
		filtro_1:false,
		id_grupo:0
		
	};
	
	vectorAtributos[8]={
		validacion:{
			name:'direccion_institucion',
			fieldLabel:'Dirección Institución',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:false,
			grid_editable:false,
			width_grid:250,
			width:200
		},
		tipo:'TextField',
		form:false,
		filtro_0:false,
		filtro_1:false,
		//filterColValue:'UNIORG.nombre_cargo'	
		id_grupo:0
	};
		
	vectorAtributos[9]= {
		validacion: {
			name:'financiado',
			emptyText:'Financiado',
			fieldLabel:'Financiado',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[
			['si','Si'],['no','No'],
			['parcial','Parcial']
			]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			//renderer:render_tipo_capacitacion,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:80,
			width:200
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:false,
		filterColValue:'EMPCAP.financiado',
		save_as:'financiado'
		};
	
		

	// txt fecha_registro
	vectorAtributos[10]={
		validacion:{
			name:'fecha_ini',
			fieldLabel:'Fecha Inicio',
			allowBlank:true,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer:formatDate,
			width_grid:85,
			width:200,
			disabled:false
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'EMPCAP.fecha_ini',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_ini'
	};	
	
	vectorAtributos[11]={
		validacion:{
			name:'fecha_fin',
			fieldLabel:'Fecha Fin',
			allowBlank:true,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer:formatDate,
			width_grid:85,
			width:200,
			disabled:false
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'EMPCAP.fecha_fin',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_fin'
	};	

	/*vectorAtributos[11]={
			validacion:{
				name:'ano_graduacion',
				fieldLabel:'Año Graduación',
				allowBlank:true,
				align:'right',
				maxLength:4,
				minLength:4,
				selectOnFocus:true,
				allowDecimals:false,
				decimalPrecision:0,//para numeros float
				allowNegative:false,
				minValue:0,
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				grid_indice:11,
				width:'100%',
				disabled:false
			},
			tipo: 'NumberField',
			form: true,
			filtro_0:true,
			//id_grupo:2,
			filterColValue:'EMPCAP.ano_graduacion'
		};
		*/

		 
	/*vectorAtributos[11]= {
		validacion: {
			name:'ano_graduacion',
			emptyText:'Año Graduación',
			fieldLabel:'Año Graduación',
			allowBlank:false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:
			[
			['1940','1940'],['1941','1941'],['1942','1942'],['1943','1943'],['1944','1944'],['1945','1945'],['1946','1946'],['1947','1947'],['1948','1948'],['1949','1949'],
			['1950','1950'],['1951','1951'],['1952','1952'],['1953','1953'],['1954','1954'],['1955','1955'],['1956','1956'],['1957','1957'],['1958','1958'],['1959','1959'],
			['1960','1960'],['1961','1961'],['1962','1962'],['1963','1963'],['1964','1964'],['1965','1965'],['1966','1966'],['1967','1967'],['1968','1968'],['1969','1969'],
			['1970','1970'],['1971','1971'],['1972','1972'],['1973','1973'],['1974','1974'],['1975','1975'],['1976','1976'],['1977','1977'],['1978','1978'],['1979','1979'],
			['1980','1980'],['1981','1981'],['1982','1982'],['1983','1983'],['1984','1984'],['1985','1985'],['1986','1986'],['1987','1987'],['1988','1988'],['1989','1989'],
			['1990','1990'],['1991','1991'],['1992','1992'],['1993','1993'],['1994','1994'],['1995','1995'],['1996','1996'],['1997','1997'],['1998','1998'],['1999','1999'],
			['2000','2000'],['2001','2001'],['2002','2002'],['2003','2003'],['2004','2004'],['2005','2005'],['2006','2006'],['2007','2007'],['2008','2008'],['2009','2009'],
			['2010','2010'],['2011','2011']
			
			]
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			//renderer:render_gestion,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:90,
			width:200
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:false,
		filterColValue:'EMPCAP.ano_graduacion',
		save_as:'ano_graduacion'
		};*/
	
	
	vectorAtributos[12]={
		validacion:{
			name:'id_persona',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo:'Field',
		filtro_0:false,
		//defecto:maestro.id_persona,
		save_as:'id_persona'
	};
	
	
	
	
	
	vectorAtributos[13]={
		validacion:{
			name:'fecha_titulo',
			fieldLabel:'Fecha Titulacion',
			allowBlank:true,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer:formatDate,
			width_grid:95,
			width:200,
			disabled:false
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'EMPCAP.fecha_titulo',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_titulo'
	};
	
	vectorAtributos[14]= {
		validacion:{
			name:'reg_profesional',
			fieldLabel:'Reg. Profesional',
			allowBlank:true,
		
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:110,
			width:200
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		grid_indice:1,
		//filterColValue:'UNIORG.nombre_cargo'	
		filterColValue:'EMPCAP.reg_profesional'	
		};
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : '';
	};
	
	
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//Inicia Layout
	/*var config={
		titulo_maestro:'Empleado Cuenta',
		grid_maestro:'grid-'+idContenedor
	};*/
	//var config={titulo_maestro:'Empleado (Maestro)',titulo_detalle:'Trabajo (Detalle)',grid_maestro:'grid-'+idContenedor};
	
	var config={titulo_maestro:'Trabajo',grid_maestro:'grid-'+idContenedor};
		//var config={titulo_maestro:'Curriculum',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_kardex_personal/vista/empleado_capacitacion/empleado_capacitacion.php'};
		//var config={titulo_maestro:'Curriculum',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_kardex_personal/vista/empleado_capacitacion/empleado_capacitacion.php'};
		layout_empleado_capacitacion=new DocsLayoutMaestro(idContenedor,idContenedorPadre);
	
	
	//var layout_empleado_capacitacion=new DocsLayoutMaestro(idContenedor);
	layout_empleado_capacitacion.init(config);
	// INICIAMOS HERENCIA //
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_empleado_capacitacion,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	
	
	var getSelectionModel=this.getSelectionModel;
	var getComponente=this.getComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_btnEdit=this.btnEdit;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var ecGrid=this.getGrid;
	
	if(busqueda=='si'){
	   var paramMenu={
		
		actualizar:{crear:true,separador:false}
	};	
	}else{
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	}
	
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/empleado_capacitacion/ActionEliminarEmpleadoCapacitacion.php',parametros:'&m_id_empleado='+maestro.id_empleado+'&m_id_persona='+maestro.id_persona},
	Save:{url:direccion+'../../../control/empleado_capacitacion/ActionGuardarEmpleadoCapacitacion.php',parametros:'&m_id_empleado='+maestro.id_empleado+'&m_id_persona='+maestro.id_persona},
	ConfirmSave:{url:direccion+'../../../control/empleado_capacitacion/ActionGuardarEmpleadoCapacitacion.php',parametros:'&m_id_empleado='+maestro.id_empleado+'&m_id_persona='+maestro.id_persona},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,
		height:300,	//alto
		width:400,
		//minWidth:400,
		//minHeight:300,	
		closable:true,
		titulo:'Funcionario Capacitacion',
		}
	};	
	
	this.reload=function(m)
	{
			maestro=m;			
	
			ds.lastOptions={
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					m_id_empleado:maestro.id_empleado,
					m_id_persona:maestro.id_persona				
				}
			};			
				
			this.btnActualizar();
			vectorAtributos[1].defecto=maestro.id_empleado;
			vectorAtributos[12].defecto=maestro.id_persona;
			
			paramFunciones.btnEliminar.parametros='&m_id_empleado='+maestro.id_empleado+'&m_id_persona='+maestro.id_persona;
			paramFunciones.Save.parametros='&m_id_empleado='+maestro.id_empleado+'&m_id_persona='+maestro.id_persona;
			paramFunciones.ConfirmSave.parametros='&m_id_empleado='+maestro.id_empleado+'&m_id_persona='+maestro.id_persona;			
			
			this.InitFunciones(paramFunciones)
	};
		
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//		
	//Para manejo de eventos
	function iniciarEventosFormularios()
	{
		 var empcap_grid=ecGrid();
			if(busqueda=='si'){
			   empcap_grid.getColumnModel().setHidden(1,true);
			   empcap_grid.getColumnModel().setHidden(3,true);
			   empcap_grid.getColumnModel().setHidden(4,true);
			   empcap_grid.getColumnModel().setHidden(6,true);
			   empcap_grid.getColumnModel().setHidden(11,true);
			}
	}

	
	this.btnNew=function(){
		//getComponente('id_institucion').enable();
		/*CM_ocultarComponente(getComponente('nombre'));*/
		CM_ocultarComponente(getComponente('id_carrera'));
		CM_ocultarComponente(getComponente('fecha_titulo'));
		CM_ocultarComponente(getComponente('reg_profesional'));
		getComponente('id_carrera').allowBlank=true;
		
		//CM_ocultarComponente(getComponente('direccion_institucion'));
		//getComponente('nombre_institucion').allowBlank=true;
		//getComponente('direccion_institucion').allowBlank=true;
		getComponente('financiado').setValue('no');
		getComponente('financiado').modificado=true;
		ClaseMadre_btnNew()
	};
	this.btnEdit=function(){
		//getComponente('id_institucion').disable();
		//CM_mostrarComponente(getComponente('nombre_institucion'));
		//CM_mostrarComponente(getComponente('direccion_institucion'));
		//getComponente('nombre_institucion').allowBlank=false;
		//getComponente('direccion_institucion').allowBlank=false;
		ClaseMadre_btnEdit()
	};
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_empleado_capacitacion.getLayout()
	};
	//para el manejo de hijos
		this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
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
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_empleado_capacitacion.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	//ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
}