/**
 * Nombre:		  	    pagina_registro_evento_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-10-26 16:05:03
 */
function pagina_registro_evento(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var sw=0;
	/////////////////
	//  DATA STORE //
	/////////////////
	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/registro_evento/ActionListarRegistroEvento.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_registro_eventos',
			totalRecords: 'TotalCount'

		}, [
			'id_registro_eventos',
			'id_usuario',
			'desc_usuario',
			'id_subsistema',
			'desc_subsistema',
			'id_lugar',
			'desc_lugar',
			{name: 'fecha',type:'date',dateFormat:'Y-m-d'},
			'hora',
			'numero_error',
			'descripcion',
			'ip_origen',
			'log_error',
			'codigo_procedimiento',
			'proc_almacenado',
			'mac_maquina'
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
    ds_usuario = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/usuario/ActionListarUsuario.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_usuario',
			totalRecords: 'TotalCount'
		}, ['id_usuario','id_persona','login','contrasenia','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','estado_usuario','estilo_usuario','filtro_avanzado'])
	});

    ds_subsistema = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/subsistema/ActionListarSubsistema.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_subsistema',
			totalRecords: 'TotalCount'
		}, ['id_subsistema','nombre_corto','nombre_largo','descripcion','version_desarrollo','desarrolladores','fecha_reg','hora_reg','fecha_ultima_modificacion','hora_ultima_modificacion','observaciones'])
	});

    ds_lugar = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/lugar/ActionListarLugar.php'}),
			reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_lugar',
			totalRecords: 'TotalCount'
		}, ['id_lugar','fk_id_lugar','nivel','codigo','nombre','ubicacion','telefono1','telefono2','fax','observacion'])
	});

	//FUNCIONES RENDER
	
			function render_id_usuario(value, p, record){return String.format('{0}', record.data['desc_usuario']);}
			function render_id_subsistema(value, p, record){return String.format('{0}', record.data['desc_subsistema']);}
			function render_id_lugar(value, p, record){return String.format('{0}', record.data['desc_lugar']);}
	
	
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	vectorAtributos[0]= {
		validacion:{
			labelSeparator:'',
			name: 'id_registro_eventos',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		
		save_as:'hidden_id_registro_eventos'
	};
	 
// txt id_usuario
	vectorAtributos[1]= {
			validacion: {
			name:'id_usuario',
			fieldLabel:'Usuario',
			allowBlank:false,			
			emptyText:'Usuario...',
			desc: 'desc_usuario', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_usuario,
			valueField: 'id_usuario',
			displayField: 'id_persona',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.nombre#PERSON.apellido_paterno#PERSON.apellido_materno',
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
			editable:false,
			renderer:render_id_usuario,
			grid_visible:true,
			grid_editable:false,
			width_grid:180 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'PERSON.nombre#PERSON.apellido_paterno#PERSON.apellido_materno',
		defecto: '',
		save_as:'txt_id_usuario'
	};
	
// txt id_subsistema
	vectorAtributos[2]= {
			validacion: {
			name:'id_subsistema',
			fieldLabel:'Subsistema',
			allowBlank:false,			
			emptyText:'Subsistema...',
			desc: 'desc_subsistema', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_subsistema,
			valueField: 'id_subsistema',
			displayField: 'nombre_corto',
			queryParam: 'filterValue_0',
			filterCol:'SUBSIS.nombre_corto#SUBSIS.descripcion',
			typeAhead:true,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_subsistema,
			grid_visible:true,
			grid_editable:false,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'SUBSIS.nombre_corto',
		defecto: '',
		save_as:'txt_id_subsistema'
	};
	
// txt id_lugar
	vectorAtributos[3]= {
			validacion: {
			name:'id_lugar',
			fieldLabel:'Lugar',
			allowBlank:false,			
			emptyText:'Lugar...',
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
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_lugar,
			grid_visible:true,
			grid_editable:false,
			width_grid:100 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'LUGARR.nombre',
		defecto: '',
		save_as:'txt_id_lugar'
	};
	
// txt fecha
	vectorAtributos[4]= {
		validacion:{
			name:'fecha',
			fieldLabel:'Fecha',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:85,
			disabled:false
		},
		tipo:'DateField',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'REGEVE.fecha',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha'
	};
	
// txt hora
	vectorAtributos[5]= {
		validacion:{
			name:'hora',
			fieldLabel:'Hora',
			allowBlank:false,
			maxLength:8,
			minLength:0,
			selectOnFocus:true,
			vtype:'time',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo:'TextField',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'REGEVE.hora',
		save_as:'txt_hora'
	};
	
// txt numero_error
	vectorAtributos[6]= {
		validacion:{
			name:'numero_error',
			fieldLabel:'Numero Error',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'REGEVE.numero_error',
		save_as:'txt_numero_error'
	};
	
// txt descripcion
	vectorAtributos[7]= {
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:true,
			maxLength:1000,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:400
		},
		tipo: 'Field',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'REGEVE.descripcion',
		save_as:'txt_descripcion'
	};
	
// txt ip_origen
	vectorAtributos[8]= {
		validacion:{
			name:'ip_origen',
			fieldLabel:'IP Origen',
			allowBlank:true,
			maxLength:40,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'REGEVE.ip_origen',
		save_as:'txt_ip_origen'
	};
	
// txt log_error
	vectorAtributos[9]= {
			validacion: {
			name:'log_error',
			fieldLabel:'Log Error',
			allowBlank:true,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			store: new Ext.data.SimpleStore({
				fields: ['ID','valor'],
				data : [['log','log'],['error','error'],['list','list']]
			}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:60 // ancho de columna en el gris
		},
		tipo:'ComboBox',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'REGEVE.log_error',
		defecto:'log',
		save_as:'txt_log_error'
	};
	
// txt codigo_procedimiento
	vectorAtributos[10]= {
		validacion:{
			name:'codigo_procedimiento',
			fieldLabel:'Codigo Procedimiento',
			allowBlank:true,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo: 'TextArea',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'REGEVE.codigo_procedimiento',
		save_as:'txt_codigo_procedimiento'
	};
	
// txt proc_almacenado
	vectorAtributos[11]= {
		validacion:{
			name:'proc_almacenado',
			fieldLabel:'Proceso Almacenado',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo: 'TextField',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'REGEVE.proc_almacenado',
		save_as:'txt_proc_almacenado'
	};
	
// txt mac_maquina
	vectorAtributos[12]= {
		validacion:{
			name:'mac_maquina',
			fieldLabel:'Consulta',
			allowBlank:true,
			maxLength:-5,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:500
		},
		tipo: 'Field',
		filtro_0:true,
		filtro_1:true,
		filtro_2:true,
		filterColValue:'REGEVE.mac_maquina',
		save_as:'txt_mac_maquina'
	};
	

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : ''
	};

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////
	//Inicia Layout
	var config = {
		titulo_maestro:'registro_evento',
		grid_maestro:'grid-'+idContenedor
	};
	layout_registro_evento=new DocsLayoutMaestro(idContenedor);
	layout_registro_evento.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_registro_evento,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_registro_evento.getLayout()};
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
				
				this.iniciaFormulario();
				layout_registro_evento.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}