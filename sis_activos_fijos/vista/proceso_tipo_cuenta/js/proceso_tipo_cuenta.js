/**
* Nombre:		  	    pagina_cotizacion_det.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
*/
function pag_af_proceso_tipo_cuenta(idContenedor,direccion,paramConfig,idContenedorPadre){
	var Atributos=new Array;
	var maestro;

	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos

		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/proceso_tipo_cuenta/ActionListaProcesoTipoCuenta.php'}),

		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_proceso_tipo_cuenta',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiqutas (campos)
		'id_proceso_tipo_cuenta',
		'id_proceso',
		'id_tipo_cuenta',
		{name: 'descripcion', type: 'string'},
		'codigo',
		'debe_haber'
		]),
		remoteSort: true});


		var ds_tipo_cuenta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_activos_fijos/control/tipo_cuenta/ActionListarTipoCuenta.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_cuenta',totalRecords: 'TotalCount'},['id_tipo_cuenta','descripcion','codigo'])
		});
		
		

	function renderTipoCuenta(value, p, record){return String.format('{0}', record.data['descripcion']);}
	

	var tpl_id_tipo_cuenta=new Ext.Template('<div class="search-item">','<b>{descripcion}</b><br>','<FONT COLOR="#B5A642">{codigo}</FONT>','</div>');
	
	//////////////////////////////////////////////////////////////
	// ------------------  PARÁMETROS --------------------------//
	// Definición de todos los tipos de datos que se maneja    //
	//////////////////////////////////////////////////////////////

	/////////// hidden id_persona//////
	//en la posición 0 siempre tiene que estar la llave primaria

	Atributos[0] = {
		validacion:{
			//fieldLabel: 'Id',
			labelSeparator:'',
			name: 'id_proceso_tipo_cuenta',
			inputType:'hidden',
			grid_visible:false, // se muestra en el grid
			grid_editable:false //es editable en el grid

		},
		tipo: 'Field',
		filtro_0:false
	};
	
		
	Atributos[1] = {
		validacion:{
			name:'id_tipo_cuenta',
			fieldLabel:'Tipo Cuenta',
			allowBlank:false,
			emptyText:'Tipo Cuenta...',
			desc: 'descripcion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_tipo_cuenta,
			valueField: 'id_tipo_cuenta',
			displayField: 'descripcion',
			queryParam: 'filterValue_0',
			filterCol:'tic.descripcion',
			typeAhead:false,
			tpl:tpl_id_tipo_cuenta,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'80%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:renderTipoCuenta,
			grid_visible:true,
			grid_editable:false,
			width_grid:220,
			width:250,
			disabled:false,
			grid_indice:5
			
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,
		filtro_1:false,
		filterColValue:'tic.descripcion',
		save_as:'txt_des_proceso'
	};

	// txt descripcion
	Atributos[2]={
		validacion:{
			name:'descripcion',
			fieldLabel:'descripcion',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:100,
			disabled:false,
			grid_indice:2		
		},
		tipo: 'TextField',
		form: false,
		filtro_0:false,
		filterColValue:'descripcion'
		
	};
// txt codigo
	Atributos[3]={
		validacion:{
			name:'codigo',
			fieldLabel:'Código',
			allowBlank:true,
			maxLength:30,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:100,
			disabled:false,
			grid_indice:3		
		},
		tipo: 'TextField',
		form: false,
		filtro_0:false,
		filterColValue:'codigo'
		
	};
	Atributos[4] = {
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name: 'id_proceso',
				inputType:'hidden',
				grid_visible:false, // se muestra en el grid
				grid_editable:false //es editable en el grid

			},
			tipo: 'Field',
			filtro_0:false,
			
			save_as:'hidden_id_proceso'
		};
	// txt sw_contabilizar
	Atributos[5]={
			validacion: {
			name:'debe_haber',
			fieldLabel:'Debe-Haber',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['debe','debe'],['haber','haber']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			disabled:false,
			grid_indice:5		
		},
		tipo:'ComboBox',
		form: true,
		defecto:'debe'
	};
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){
		return value?value.dateFormat('d/m/Y') : '';
	};


	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////


		var config={titulo_maestro:'Tipo Cuenta ',grid_maestro:'grid-'+idContenedor};
		var layout_af_proceso_tipo_cuenta = new DocsLayoutMaestro(idContenedor,idContenedorPadre);
		layout_af_proceso_tipo_cuenta.init(config);

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS HERENCIA           -----------//
	//////////////////////////////////////////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_af_proceso_tipo_cuenta,idContenedor);

	
	var getDialog=this.getDialog;
		var getGrid=this.getGrid;
		var enableSelect=this.EnableSelect;
		var EstehtmlMaestro=this.htmlMaestro;
	//////////////////////////////////////////////////////////////
	// -----------   DEFINICIÓN DE LA BARRA DE MENÚ ----------- //
	//////////////////////////////////////////////////////////////

	var paramMenu = {
		guardar:{
			crear : true, //para ver si se creara el boton
			separador:false
		},
		nuevo: {
			crear : true, //para ver si se creara el boton
			separador:true
		},
		editar:{
			crear : true, //para ver si se creara el boton
			separador:false
		},
		eliminar:{
			crear : true, //para ver si se creara el boton
			separador:false
		},

		actualizar:{
			crear :true,
			separador:false
		}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/proceso_tipo_cuenta/ActionEliminaProcesoTipoCuenta.php'},
			Save:{url:direccion+'../../../control/proceso_tipo_cuenta/ActionGuardarProcesoTipoCuenta.php'},
			ConfirmSave:{url:direccion+'../../../control/proceso_tipo_cuenta/ActionGuardarProcesoTipoCuenta.php'},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:560,minHeight:222,	closable:true,titulo:'Tipo Cuenta'}};


	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	this.reload=function(m){
			    maestro=m;
				ds.lastOptions={
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						maestro_id_proceso:maestro.id_proceso
						
						
						
					}
				};
				this.btnActualizar();
				//iniciarEventosFormularios();


				Atributos[4].defecto=maestro.id_proceso;

				//paramFunciones.btnEliminar.parametros='&maestro_id_proceso='+maestro.id_proceso;
				paramFunciones.Save.parametros='&maestro_id_proceso='+maestro.id_proceso;
				paramFunciones.ConfirmSave.parametros='&maestro_id_proceso='+maestro.id_proceso;

				
				this.InitFunciones(paramFunciones)
			};
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.getLayout=function(){return layout_af_proceso_tipo_cuenta.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	
	this.iniciaFormulario();
	
	layout_af_proceso_tipo_cuenta.getLayout().addListener('layout',this.onResize);
	
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
}
