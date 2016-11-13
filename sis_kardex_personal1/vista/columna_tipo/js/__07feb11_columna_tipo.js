/**
* Nombre:		  	    pagina_columna_tipo.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2010-08-10 17:59:45
*/
function pagina_columna_tipo(idContenedor,direccion,paramConfig)
{
	var Atributos=new Array,sw=0;
	var componentes=new Array();

	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_columna/ActionListarColumnaTipo.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'id_columna_tipo',totalRecords:'TotalCount'
		},[
		'id_columna_tipo',
		'id_parametro_kardex',
		'desc_parametro_kardex',
		'id_partida',
		'desc_partida',
		'nombre',
		'valor',
		'tipo_dato',
		'id_moneda',
		'desc_moneda',
		'tipo_aporte',
		'estado_reg',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		'cotizable',
		'descripcion',
		'descuento_incremento',
		'observacion',
		'formula',

		'id_tipo_descuento_bono',
		'desc_tipo_descuento_bono',
		'codigo',

		'compromete',
		'id_tipo_columna_base',
		'id_cuenta_pasivo',
		'id_auxiliar_pasivo',
		'desc_tipo_columna_base',
		'desc_cuenta_pasivo',
		'desc_auxiliar_pasivo','id_gestion'
		]),remoteSort:true});


		//DATA STORE COMBOS
		var ds_moneda = new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
		baseParams:{sw_combo_presupuesto:'si'}
		});


		var ds_parametro_kardex = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro_kardex/ActionListarParametroKardex.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro_kardex',totalRecords: 'TotalCount'},['id_parametro_kardex','id_gestion','desc_gestion'])
		});


		var ds_partida = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/partida/ActionListarPartida.php?'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_partida',totalRecords:'TotalCount'},[	'id_partida','codigo_partida','nombre_partida','desc_par','nivel_partida','sw_transaccional','tipo_partida','id_parametro','desc_parametro','id_partida_padre','tipo_memoria','desc_partida'])
		});

		var ds_tipo_descuento_bono=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+"../../../../sis_kardex_personal/control/tipo_descuento_bono/ActionListarTipoDescuentoBono.php"}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_descuento_bono',totalRecords:'TotalCount'},['id_tipo_descuento_bono','nombre','tipo','codigo','descripcion'])
		});



		var ds_tipo_columna_base=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+"../../../../sis_kardex_personal/control/tipo_columna/ActionListarColumnaTipo.php"}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_columna_tipo',totalRecords:'TotalCount'},['id_columna_tipo','desc_parametro_kardex','nombre','codigo','tipo_dato'])
		});


		var ds_cuenta=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/cuenta/ActionListarCuenta.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta',totalRecords: 'TotalCount'},['id_cuenta','nro_cuenta','nombre_cuenta','desc_cuenta','nivel_cuenta','tipo_cuenta','sw_transaccional','id_cuenta_padre','id_parametro','id_moneda','descripcion','sw_oec','sw_aux'])
		});



		var ds_auxiliar=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/auxiliar/ActionListarAuxiliar.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_persona',
			totalRecords:'TotalCount'
		},['id_auxiliar','codigo_auxiliar','nombre_auxiliar','estado_auxiliar'])
		});


		//FUNCIONES RENDER

		function render_id_moneda(value,p,record){return String.format('{0}', record.data['desc_moneda'])}
		var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');

		function render_id_parametro_kardex(value, p, record){return String.format('{0}', record.data['desc_parametro_kardex']);}
		var tpl_id_parametro_kardex=new Ext.Template('<div class="search-item">','<b><i>{desc_gestion}</i></b>','</div>');

		function render_id_partida(value, p, record){return String.format('{0}', record.data['desc_partida']);}
		var tpl_id_partida=new Ext.Template('<div class="search-item">','<b><i>{desc_partida}</i></b>','</div>');

		function render_id_tipo_descuento_bono(value,p,record){return String.format('{0}',record.data['desc_tipo_descuento_bono'])}


		function render_estado_reg(value)
		{
			if(value=='activo'){value='Activo'	}
			else if(value=='inactivo'){value='Inactivo'	}
			return value
		}

		function render_tipo_dato(value)
		{
			if(value=='constante'){value='Constante'}
			else if(value=='basico'){value='Básico'}
			else if(value=='formula'){value='Formula'}
			else if(value=='avariable'){value='Variable'}
			else if(value=='bono_desc'){value='Bono/Descuento'}
			return value
		}

		function render_tipo_aporte(value)
		{
			if(value=='laboral'){value='Laboral'	}
			else if(value=='patronal'){value='Patronal'	}
			return value
		}

		function render_descuento_incremento(value)
		{
			if(value=='descontar'){value='Descontar'	}
			else if(value=='aumentar'){value='Incrementar'	}
			else if(value=='ninguno'){value='Ninguno'	}
			return value
		}

		function renderHaber(value, p, record){return String.format('{0}', record.data['desc_cuenta_pasivo']);}
		function renderAux(value, p, record){return String.format('{0}', record.data['desc_auxiliar_pasivo']);}
		/////////////////////////
		// Definición de datos //
		/////////////////////////

		// hidden id_columna_tipo
		//en la posición 0 siempre esta la llave primaria

		Atributos[0]={
			validacion:{
				labelSeparator:'',
				name: 'id_columna_tipo',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false
		};

		// txt id_parametro
		Atributos[1]={
			validacion:{
				name:'id_parametro_kardex',
				fieldLabel:'Gestión',
				allowBlank:true,
				//emptyText:'Gestión...',
				desc: 'desc_parametro_kardex', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_parametro_kardex,
				valueField: 'id_parametro_kardex',
				displayField: 'desc_gestion',
				queryParam: 'filterValue_0',
				filterCol:'GESTIO.gestion',
				typeAhead:false,
				align:'center',
				tpl:tpl_id_parametro_kardex,
				forceSelection:false,
				mode:'remote',
				queryDelay:200,
				pageSize:100,
				minListWidth:200,
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_parametro_kardex,
				grid_visible:true,
				grid_editable:false,
				width_grid:60,
				width:200,
				disabled:false,
				grid_indice:1
			},
			tipo:'ComboBox',
			form: true,
			id_grupo:1,
			filtro_0:true,
			filterColValue:'GESTIO.gestion',
			save_as:'id_parametro_kardex'
		};


		Atributos[2]={
			validacion:{
				name:'codigo',
				fieldLabel:'Código',
				allowBlank:false,
				maxLength:255,
				minLength:1,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false,
				grid_indice:1
			},
			tipo: 'TextField',
			form: true,
			filtro_0:true,
			id_grupo:1,
			filterColValue:'COLTIP.codigo'
		};

		// txt nombre
		Atributos[3]={
			validacion:{
				name:'nombre',
				fieldLabel:'Nombre',
				allowBlank:false,
				maxLength:255,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width_grid:130,
				width:'100%',
				disabled:false,
				grid_indice:1
			},
			tipo: 'TextField',
			form: true,
			filtro_0:true,
			id_grupo:1,
			filterColValue:'COLTIP.nombre'

		};

		// txt descripcion
		Atributos[4]={
			validacion:{
				name:'descripcion',
				fieldLabel:'Descripción',
				allowBlank:true,
				maxLength:255,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width_grid:130,
				width:'100%',
				disabled:false,
				grid_indice:2
			},
			tipo: 'TextArea',
			form: true,
			id_grupo:1,
			filtro_0:true,
			filterColValue:'COLTIP.descripcion'
		};

		// txt observacion
		Atributos[5]={
			validacion:{
				name:'observacion',
				fieldLabel:'Observaciones',
				allowBlank:true,
				maxLength:255,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				width_grid:100,
				width:'100%',
				disabled:false
			},
			tipo: 'TextArea',
			form: true,
			filtro_0:true,
			id_grupo:1,
			filterColValue:'COLTIP.observacion'
		};


		Atributos[6]= {
			validacion: {
				name:'compromete',
				fieldLabel:'Compromete',
				allowBlank:true,
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
				width_grid:100,
				grid_indice:5
			},
			tipo:'ComboBox',
			filtro_0:true,
			id_grupo:1,
			filterColValue:'COLTIP.compromete'
		};

		Atributos[7]={
			validacion:{
				name:'id_partida',
				desc:'desc_partida',
				fieldLabel:'Partida',
				allowBlank:true,
				valueField: 'id_partida',
				tipo:'gasto',//determina el action a llamar
				maxLength:1000,
				minLength:0,
				selectOnFocus:true,
				//vtype:"texto",
				grid_visible:true,
				grid_editable:false,
				renderer:render_id_partida,
				width_grid:200,
				width:300,
				pageSize:10,
				disabled:true,
				direccion:direccion,
				grid_indice:6
			},
			tipo:'LovPartida',
			form: true,
			filtro_0:false,
			id_grupo:1
			//save_as:'id_partida_destino'
		};

		Atributos[8]= {
			validacion:{
				name:'id_cuenta_pasivo',
				desc:'desc_cuenta_pasivo',
				allowBlank:true,
				fieldLabel:'Cuenta',
				tipo:'ingreso',//determina el action a llamar
				gestion:1,
				maxLength:100,
				minLength:0,
				selectOnFocus:true,
				vtype:"texto",
				grid_visible:true,
				grid_editable:false,
				renderer:renderHaber,
				width_grid:300,
				width:'90%',
				pageSize:10,
				onSelect:function(record){
					//Ext.form.LovItemsAlm.superclass.setValue.call(this,v.desc)
					ClaseMadre_getComponente('id_auxiliar_pasivo').enable();
					componentes[8].setValue({id:record.data.id_cuenta,desc:record.data.desc_cuenta});
					componentes[8].collapse();
					ds_auxiliar.baseParams={cuenta:record.data.id_cuenta};
					componentes[9].modificado=true;
				},
				direccion:direccion,
				grid_indice:5,
				disabled:true

			},
			tipo:'LovCuenta',
			filtro_0:true,
			filterColValue:'CUENTA.nombre_cuenta',
			save_as:'id_cuenta_pasivo',
			id_grupo:1
		};

		Atributos[9]= {
			validacion: {
				name:'id_auxiliar_pasivo',
				fieldLabel:'Auxiliar',
				allowBlank:true,
				emptyText:'Auxiliar...',
				desc:'desc_cuenta_pasivo', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_auxiliar,
				valueField:'id_auxiliar',
				displayField:'nombre_auxiliar',
				queryParam:'filterValue_0',
				filterCol:'AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar',
				typeAhead:false,
				forceSelection:true,
				mode:'remote',
				queryDelay:250,
				pageSize:100,
				minListWidth:250,
				grow:true,
				renderer:renderAux,
				width:'100%',
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,

				grid_visible:true,
				grid_editable:false,
				width_grid:200, // ancho de columna en el grid
				grid_indice:5,
				disabled:true
			},
			tipo:'ComboBox',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'AUXILI.nombre_auxiliar',
			defecto: '',
			save_as:'id_auxiliar_pasivo',
			id_grupo:1
		};

		Atributos[10]= {
			validacion: {
				name:'tipo_dato',
				fieldLabel:'Tipo de Dato',
				allowBlank:false,
				typeAhead: true,
				loadMask: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['constante','Constante'],['basico','Básico'],['formula','Formula'],['avariable','Variable'],['bono_desc','Bono/Descuento']]}),
				valueField:'ID',
				displayField:'valor',
				onSelect:function(record)
				{
					componentes[10].setValue(record.data.ID);
					componentes[10].collapse();
					if(record.data.ID=='constante')
					{
						CM_ocultarGrupo('Concepto');
						CM_mostrarGrupo('Datos Generales');
						CM_mostrarGrupo('Datos Valor');
						CM_ocultarGrupo('Datos Formula');
						CM_ocultarGrupo('Descuento / Bono');
					}
					else if(record.data.ID=='formula')
					{
						CM_ocultarGrupo('Concepto');
						CM_mostrarGrupo('Datos Generales');
						CM_ocultarGrupo('Datos Valor');
						CM_mostrarGrupo('Datos Formula');
						CM_ocultarGrupo('Descuento / Bono');
					}
					else if(record.data.ID=='bono_desc')
					{
						CM_ocultarGrupo('Concepto');
						CM_mostrarGrupo('Datos Generales');
						CM_ocultarGrupo('Datos Valor');
						CM_ocultarGrupo('Datos Formula');
						CM_mostrarGrupo('Descuento / Bono');
					}
					else
					{
						CM_ocultarGrupo('Concepto');
						CM_mostrarGrupo('Datos Generales');
						CM_ocultarGrupo('Datos Valor');
						CM_ocultarGrupo('Datos Formula');
						CM_ocultarGrupo('Descuento / Bono');
					}
				},

				lazyRender:true,
				renderer:render_tipo_dato,
				forceSelection:true,
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				grid_indice:5
			},
			tipo:'ComboBox',
			filtro_0:true,

			id_grupo:1,
			filterColValue:'COLTIP.tipo_dato'
		};

		// txt valor
		Atributos[11]={
			validacion:{
				name:'valor',
				fieldLabel:'Valor',
				allowBlank:true,
				align:'right',
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision:6,//para numeros float
				allowNegative:false,
				minValue:0,
				grid_visible:true,
				grid_editable:true,
				width_grid:100,
				width:'100%',
				disabled:false
			},
			tipo: 'NumberField',
			form: true,
			filtro_0:true,
			id_grupo:2,
			filterColValue:'COLTIP.valor'
		};

		// txt id_moneda
		Atributos[12]={
			validacion:{
				name:'id_moneda',
				fieldLabel:'Moneda',
				allowBlank:true,
				//emptyText:'Moneda...',
				desc: 'desc_moneda', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_moneda,
				valueField: 'id_moneda',
				displayField: 'nombre',
				queryParam: 'filterValue_0',
				filterCol:'MONEDA.nombre',
				typeAhead:true,
				tpl:tpl_id_moneda,
				forceSelection:true,
				mode:'remote',
				queryDelay:200,
				pageSize:100,
				minListWidth:200,
				grow:true,
				resizable:true,
				minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_moneda,
				grid_visible:true,
				grid_editable:true,
				width_grid:100,
				width:200,
				disable:false
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			id_grupo:2,
			filterColValue:'MONEDA.nombre',
			save_as:'id_moneda'
		};


		Atributos[13]= {
			validacion: {
				name:'tipo_aporte',
				fieldLabel:'Tipo de Aporte',
				allowBlank:true,
				typeAhead: true,
				loadMask: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['laboral','Laboral'],['patronal','Patronal']]}),
				valueField:'ID',
				displayField:'valor',
				lazyRender:true,
				renderer:render_tipo_aporte,
				forceSelection:true,
				grid_visible:true,
				grid_editable:true,
				width_grid:100
			},
			tipo:'ComboBox',
			filtro_0:true,
			id_grupo:4,
			filterColValue:'COLTIP.tipo_aporte'
		};

		Atributos[14]= {
			validacion: {
				name:'estado_reg',
				fieldLabel:'Estado',
				allowBlank:false,
				typeAhead: true,
				loadMask: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','Activo'],['inactivo','Inactivo']]}),
				valueField:'ID',
				displayField:'valor',
				lazyRender:true,
				renderer:render_estado_reg,
				forceSelection:true,
				grid_visible:true,
				grid_editable:true,
				width_grid:100
			},
			tipo:'ComboBox',
			filtro_0:true,
			id_grupo:1,
			filterColValue:'COLTIP.estado_reg'
		};



		Atributos[15]= {
			validacion: {
				name:'cotizable',
				fieldLabel:'Cotizable',
				allowBlank:false,
				typeAhead: true,
				loadMask: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','si'],['no','no']]}),
				valueField:'ID',
				displayField:'valor',
				lazyRender:true,
				//renderer:render_estado_reg,
				forceSelection:true,
				grid_visible:true,
				grid_editable:true,
				width_grid:70
			},
			tipo:'ComboBox',
			filtro_0:true,
			id_grupo:1,
			filterColValue:'COLTIP.cotizable'
		};


		Atributos[16]={
			validacion:{
				name:'formula',
				fieldLabel:'Formula',
				allowBlank:true,
				maxLength:500,
				minLength:0,
				selectOnFocus:true,
				//vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:100,
				width:'100%',
				disabled:false,
				grid_indice:5
			},
			tipo: 'TextArea',
			form: true,
			filtro_0:true,
			id_grupo:3,
			filterColValue:'COLTIP.formula'
		};

		Atributos[17]= {
			validacion: {
				name:'descuento_incremento',
				fieldLabel:'Acción',
				allowBlank:false,
				typeAhead: true,
				loadMask: true,
				triggerAction: 'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['descontar','Descontar'],['aumentar','Incrementar'],['ninguno','Ninguno']]}),
				valueField:'ID',
				displayField:'valor',
				lazyRender:true,
				renderer:render_descuento_incremento,
				forceSelection:true,
				grid_visible:true,
				grid_editable:true,
				width_grid:70,
				grid_indice:5
			},
			tipo:'ComboBox',
			filtro_0:true,
			id_grupo:1,
			filterColValue:'COLTIP.descuento_incremento'
		};


		Atributos[18]={
			validacion:{
				fieldLabel:'Descuento / Bono',
				allowBlank:true,
				vtype:'texto',
				//emptyText:'Descuento / Bono...',
				name:'id_tipo_descuento_bono',
				desc:'desc_tipo_descuento_bono',
				store:ds_tipo_descuento_bono,
				valueField:'id_tipo_descuento_bono',
				displayField:'nombre',
				queryParam:'filterValue_0',
				filterCol:'DESBONO.nombre',
				typeAhead:true,
				forceSelection:true,
				renderer:render_id_tipo_descuento_bono,
				mode:'remote',
				queryDelay:50,
				pageSize:10,
				minListWidth:300,
				width:200,
				resizable:true,
				minChars:0,
				triggerAction:'all',
				editable:true,
				grid_visible:true,
				grid_editable:false,
				width_grid:200
			},
			save_as:'id_tipo_descuento_bono',
			tipo:'ComboBox',
			filtro_0:true,
			id_grupo:4,
			filterColValue:'TIDEBO.nombre'
		};



		// txt fecha_reg
		Atributos[19]= {
			validacion:{
				name:'fecha_reg',
				fieldLabel:'Fecha Registro',
				allowBlank:true,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Día no válido',
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width_grid:85,
				disabled:true
			},
			form:false,
			tipo:'DateField',
			filtro_0:true,
			filterColValue:'COLTIP.fecha_reg',
			dateFormat:'m-d-Y',
			defecto:''
		};


		//////////////////////////////////////////////////////////////
		// ----------            FUNCIONES RENDER    ---------------//
		//////////////////////////////////////////////////////////////
		function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

		//---------- INICIAMOS LAYOUT DETALLE
		var config={titulo_maestro:'Tipo de Columna',grid_maestro:'grid-'+idContenedor};
		var layout_columna_tipo=new DocsLayoutMaestro(idContenedor);
		layout_columna_tipo.init(config);

		////////////////////////
		// INICIAMOS HERENCIA //
		////////////////////////


		this.pagina=Pagina;
		//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
		this.pagina(paramConfig,Atributos,ds,layout_columna_tipo,idContenedor);
		var getComponente=this.getComponente;
		var getSelectionModel=this.getSelectionModel;
		var ClaseMadre_getComponente=this.getComponente;
		var CM_ocultarGrupo=this.ocultarGrupo;
		var CM_mostrarGrupo=this.mostrarGrupo;
		var CM_btnNew=this.btnNew;
		var CM_btnEdit=this.btnEdit;
		var CM_ocultarComponente=this.ocultarComponente;
		var CM_mostrarComponente=this.mostrarComponente;
		var CM_Save = this.Save;

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
			btnEliminar:{url:direccion+'../../../control/tipo_columna/ActionEliminarColumnaTipo.php'},
			Save:{url:direccion+'../../../control/tipo_columna/ActionGuardarColumnaTipo.php'},
			ConfirmSave:{url:direccion+'../../../control/tipo_columna/ActionGuardarColumnaTipo.php'},
			Formulario:{
				guardar:sSave,
				html_apply:'dlgInfo-'+idContenedor,
				height:500,
				width:480,
				minWidth:150,
				minHeight:200,
				closable:true,
				titulo:'Tipo de Columna',
				grupos:[
				{
					tituloGrupo:'Oculto',
					columna:0,
					id_grupo:0
				},
				{
					tituloGrupo:'Datos Generales',
					columna:0,
					id_grupo:1
				},
				{
					tituloGrupo:'Datos Valor',
					columna:0,
					id_grupo:2
				},
				{
					tituloGrupo:'Datos Formula',
					columna:0,
					id_grupo:3
				},
				{
					tituloGrupo:'Descuento / Bono',
					columna:0,
					id_grupo:4
				}]
			}};
			//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

			//Para manejo de eventos
			function iniciarEventosFormularios(){
				//para iniciar eventos en el formulario
			}

			function InitPaginaColumnaTipo()
			{
				for(var i=0; i<Atributos.length; i++)
				{
					componentes[i]=ClaseMadre_getComponente(Atributos[i].validacion.name)
				}

				ClaseMadre_getComponente('id_parametro_kardex').on('select',evento_parametro_kardex);
				ClaseMadre_getComponente('descuento_incremento').on('select',evento_accion);
				ClaseMadre_getComponente('compromete').on('select',onCompromete);
			}

			function onCompromete(e){
				if(e.value=='si'){
					ClaseMadre_getComponente('id_partida').enable();
					ClaseMadre_getComponente('id_cuenta_pasivo').enable();
					
					CM_mostrarComponente(ClaseMadre_getComponente('id_partida'));
					CM_mostrarComponente(ClaseMadre_getComponente('id_cuenta_pasivo'));
					CM_mostrarComponente(ClaseMadre_getComponente('id_auxiliar_pasivo'));
					
					ClaseMadre_getComponente('id_partida').allowBlank=false;
					ClaseMadre_getComponente('id_cuenta_pasivo').allowBlank=false;
					ClaseMadre_getComponente('id_auxiliar_pasivo').allowBlank=false;
										
				}else{
					ClaseMadre_getComponente('id_partida').disable();
					ClaseMadre_getComponente('id_cuenta_pasivo').disable();
					
					CM_ocultarComponente(ClaseMadre_getComponente('id_partida'));
					CM_ocultarComponente(ClaseMadre_getComponente('id_cuenta_pasivo'));
					CM_ocultarComponente(ClaseMadre_getComponente('id_auxiliar_pasivo'));
					
					ClaseMadre_getComponente('id_partida').allowBlank=true;
					ClaseMadre_getComponente('id_cuenta_pasivo').allowBlank=true;
					ClaseMadre_getComponente('id_auxiliar_pasivo').allowBlank=true;
					
					ClaseMadre_getComponente('id_partida').reset();
					ClaseMadre_getComponente('id_cuenta_pasivo').reset();
					ClaseMadre_getComponente('id_auxiliar_pasivo').reset();
				}
			}

			function evento_parametro_kardex( combo, record, index )
			{
				//alert('entra al evento');
				ClaseMadre_getComponente('id_partida').store.baseParams={m_sw_partida_cuenta:'si',m_id_gestion:record.data.id_gestion};
				ds_cuenta.baseParams={
					m_id_gestion:record.data.id_gestion
				};
				ds_cuenta.modificado=true;
				ClaseMadre_getComponente('id_cuenta_pasivo').enable();
				ClaseMadre_getComponente('id_partida').setDisabled(false);
				ClaseMadre_getComponente('id_partida').setValue('');
				ClaseMadre_getComponente('id_partida').modificado=true;
			}

			function evento_accion( combo, record, index )
			{
				//alert('entra al evento');
				ClaseMadre_getComponente('id_tipo_descuento_bono').store.baseParams={accion:componentes[18].getValue(),estado:'activo' };
				ClaseMadre_getComponente('id_tipo_descuento_bono').setValue('');
				ClaseMadre_getComponente('id_tipo_descuento_bono').modificado=true;
			}

			this.btnNew=function()
			{
				//var SelectionsRecord=sm.getSelected();
				CM_ocultarGrupo('Oculto');
				CM_mostrarGrupo('Datos Generales');
				CM_ocultarGrupo('Datos Valor');
				CM_ocultarGrupo('Datos Formula');
				CM_ocultarGrupo('Descuento / Bono');
				CM_ocultarComponente(ClaseMadre_getComponente('id_partida'));
				CM_ocultarComponente(ClaseMadre_getComponente('id_cuenta_pasivo'));
				CM_ocultarComponente(ClaseMadre_getComponente('id_auxiliar_pasivo'));
				CM_btnNew();
			}

			this.btnEdit=function()
			{
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					CM_ocultarGrupo('Oculto');
					CM_mostrarGrupo('Datos Generales');
					CM_ocultarGrupo('Datos Valor');
					CM_ocultarGrupo('Datos Formula');
					CM_ocultarGrupo('Descuento / Bono');
					//ClaseMadre_getComponente('compromete').disable();
					ClaseMadre_getComponente('id_partida').store.baseParams={m_sw_partida_cuenta:'si',m_id_gestion:SelectionsRecord.data.id_gestion};
					ClaseMadre_getComponente('id_cuenta_pasivo').store.baseParams={m_id_gestion:SelectionsRecord.data.id_gestion};
					
					ClaseMadre_getComponente('id_partida').modificado=true;
					ClaseMadre_getComponente('id_cuenta_pasivo').modificado=true;
					if(SelectionsRecord.data.compromete=='si'){
						CM_mostrarComponente(ClaseMadre_getComponente('id_partida'));
						CM_mostrarComponente(ClaseMadre_getComponente('id_cuenta_pasivo'));
						CM_mostrarComponente(ClaseMadre_getComponente('id_auxiliar_pasivo'));
					
						
					}else{
						CM_ocultarComponente(ClaseMadre_getComponente('id_partida'));
						CM_ocultarComponente(ClaseMadre_getComponente('id_cuenta_pasivo'));
						CM_ocultarComponente(ClaseMadre_getComponente('id_auxiliar_pasivo'));
					}
					CM_btnEdit();
				}else{
					alert('Antes debe seleccionar un item');
				}
			}




			function sSave(){
				//para codificar caracteres especiales como el simbolo de "+"
				ClaseMadre_getComponente('formula').setValue(encodeURIComponent(ClaseMadre_getComponente('formula').getValue()));
				CM_Save()

			}



			//para que los hijos puedan ajustarse al tamaño
			this.getLayout=function(){return layout_columna_tipo.getLayout()};
			this.Init(); //iniciamos la clase madre
			this.InitBarraMenu(paramMenu);
			//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
			this.InitFunciones(paramFunciones);
			//carga datos XML
			ds.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros
				}
			});

			//para agregar botones

			this.iniciaFormulario();
			iniciarEventosFormularios();
			InitPaginaColumnaTipo();
			layout_columna_tipo.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
			ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}