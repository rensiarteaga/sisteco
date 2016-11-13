<?php 
/**
 * Nombre:		  	    cuenta_bancaria_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-16 15:11:34
 *
 */
session_start();
?>
//<script>
function main(){
 	<?php
	//obtenemos la ruta absoluta
	$host  = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir = "http://$host$uri/";
	echo "\nvar direccion='$dir';";
    echo "var idContenedor='$idContenedor';";
	?>
var fa=false;
<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var elemento={pagina:new pagina_cuenta_bancaria(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

//view added

/**
 * Nombre:		  	    pagina_cuenta_bancaria.js
 * Propï¿½sito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creaciï¿½n:		2008-10-16 15:11:34
 */
function pagina_cuenta_bancaria(idContenedor,direccion,paramConfig){
	var Atributos=new Array,sw=0;
	var maestro=new Array();
	var componentes=new Array();
	var combo_cuenta, combo_auxiliar;
	var g_id_gestion;
	var dialog;
	var form;
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cuenta_bancaria/ActionListarCuentaBancaria.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_cuenta_bancaria',totalRecords:'TotalCount'
		},[		
		'id_cuenta_bancaria',
		'id_parametro',
		'id_institucion',
		'desc_institucion',
		'id_cuenta',
		'desc_cuenta',
		'id_auxiliar',
		'desc_auxiliar',
		'nro_cheque',
		'estado_cuenta',
		'nro_cuenta_banco',
		'gestion'
		]),remoteSort:true});

	//DATA STORE COMBOS
	var ds_parametro=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/parametro/ActionListarParametro.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro',totalRecords:'TotalCount'},
		['id_parametro','id_gestion','gestion','cantidad_nivel','estado_gestion','gestion_tesoro'])
	});
	
  	var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/gestion/ActionListarGestion.php'}),
  		reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_gestion',totalRecords:'TotalCount'},
  				['id_gestion','gestion','estado_ges_gral','id_empresa','desc_empresa','id_moneda_base','desc_moneda']),baseParams:{m_id_gestion:-1}});
  	
	var tpl_gestion=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','</div>');
	
    var ds_institucion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/institucion/ActionListarInstitucion.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_institucion',totalRecords: 'TotalCount'},['id_institucion','doc_id','nombre','casilla','telefono1','telefono2','celular1','celular2','fax','email1','email2','pag_web','observaciones','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','estado_institucion','id_persona','direccion','id_tipo_doc_institucion'])
	});
    var ds_cuenta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cuenta/ActionListarCuenta.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta',totalRecords: 'TotalCount'},['id_cuenta','nro_cuenta','nombre_cuenta','desc_cuenta','nivel_cuenta','tipo_cuenta','sw_transaccional','id_cuenta_padre','id_parametro','id_moneda','descripcion'])
	});
	var ds_cuenta_auxiliar = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/cuenta_auxiliar/ActionListarCuentaAuxiliar.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta_auxiliar',totalRecords: 'TotalCount'},['id_cuenta_auxiliar','id_cuenta','nombre_cuenta','id_auxiliar','nombre_auxiliar','codigo_auxiliar'])
	});
	var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_tesoreria/control/parametro/ActionListarParametro.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','id_gestion','gestion','gestion_tesoro','estado_gestion'])
	});
   
	//FUNCIONES RENDER
	function render_id_institucion(value, p, record){return String.format('{0}', record.data['desc_institucion']);}
	var tpl_id_institucion=new Ext.Template('<div class="search-item">','<b>{nombre}</b>','<br><FONT COLOR="#B5A642"><b>Direccion: </b>{direccion}</FONT>','</div>'); 
		
	function render_id_cuenta(value, p, record){return String.format('{0}', record.data['desc_cuenta']);}
	var tpl_id_cuenta=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{nro_cuenta}</FONT><br>','<FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
	
	function render_id_auxiliar(value, p, record){return String.format('{0}', record.data['desc_auxiliar']);}
	var tpl_id_auxiliar=new Ext.Template('<div class="search-item">','<b>{codigo_auxiliar}</b>','<br><FONT COLOR="#B5A642"><b>Nombre: </b>{nombre_auxiliar}</FONT>','</div>'); 

	function render_cuenta_bancaria(value){
		if(value==1){value='Activo'	}
		else{value='Inactivo'		}
		return value
	}
	
	function render_id_parametro(value, p, record){return String.format('{0}', record.data['gestion']);}
	var tpl_id_parametro=new Ext.Template('<div class="search-item">','<FONT>Gestion: {gestion}</FONT><br>','</div>');
	//,'<FONT COLOR="#B5A642">Gestion Tesoro:{gestion_tesoro}</FONT>'
	
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_cuenta_bancaria',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_cuenta_bancaria'
	};

// txt id_parametro
	Atributos[1]={
		validacion:{
			name:'id_parametro',
			fieldLabel:'Gestion',
			allowBlank:false,
			align:'right', 
			emptyText:'Gestion...',
			desc: 'gestion', //indica la columna del store principal ds del que proviane la descripcion ///estore
			store:ds_parametro,
			loadMask:true,
			lazyRender:true,
			valueField: 'id_parametro',//combo
			displayField:'gestion',
			forceSelection:true,
			queryParam: 'filterValue_0',
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			filterCol:'gestion.gestion#parame.estado_gestion',
			tpl:tpl_id_parametro,
			renderer:render_id_parametro,
			grid_visible:true,
			grid_editable:false,
			width_grid:90,
			width:'60%',
			disabled:false		
		},
		tipo: 'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'gestion.gestion',
		save_as:'id_parametro'
	};
		
// txt id_institucion
	Atributos[2]={
			validacion:{
			name:'id_institucion',
			fieldLabel:'Institucion',
			allowBlank:false,			
			emptyText:'Institucion...',
			desc: 'desc_institucion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_institucion,
			valueField: 'id_institucion',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'INSTIT.nombre#INSTIT.casilla',
			typeAhead:true,
			tpl:tpl_id_institucion,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_institucion,
			grid_visible:true,
			grid_editable:false,
			width_grid:200,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'INSTIT.nombre',
		save_as:'id_institucion'
	};

	/*filterCols_cuenta=new Array();
    filterValues_cuenta=new Array();
    filterCols_cuenta[0]='PARAME.id_gestion';
    filterValues_cuenta[0]='%';*/
	Atributos[3]={
		validacion:{
			name:'id_cuenta',
			desc:'desc_cuenta',
			fieldLabel:'Cuenta',
			tipo:'ingreso',//determina el action a llamar
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true,
			grid_editable:false,
			renderer:render_id_cuenta,
			//filterCols:filterCols_cuenta,
			//filterValues:filterValues_cuenta,
			width_grid:250,
			width:200,
			pageSize:10,
			direccion:direccion
		},
		tipo:'LovCuenta',
		save_as:'id_cuenta'
		};
		
	filterCols=new Array();
	filterValues=new Array();
	filterCols[0]='CUEAUX.id_cuenta';
	filterValues[0]='%';
	Atributos[4]={
			validacion:{
			name:'id_auxiliar',//store
			fieldLabel:'Auxiliar',
			allowBlank:true,			
			emptyText:'Auxiliar...',
			desc: 'desc_auxiliar', //indica la columna del store principal ds del que proviane la descripcion ///estore
			store:ds_cuenta_auxiliar,
			valueField: 'id_auxiliar',//combo
			displayField: 'nombre_auxiliar',//combo
			queryParam: 'filterValue_0',
			filterCol:'AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar',
			typeAhead:true,
			tpl:tpl_id_auxiliar,
			forceSelection:true,
			filterCols:filterCols,
			filterValues:filterValues,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_auxiliar,
			grid_visible:true,
			grid_editable:false,
			width_grid:180,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'AUXILI.codigo_auxiliar',
		save_as:'id_auxiliar'
	};
	Atributos[5]={
		validacion:{
			name:'nro_cuenta_banco',
			fieldLabel:'Nro de Cuenta de Banco',
			allowBlank:false,
			maxLength:30,
			minLength:1,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:'60%',
			disabled:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'CUEBAN.nro_cuenta_banco',
		save_as:'nro_cuenta_banco'
	};
		
		
// txt nro_cheque
	Atributos[6]={
		validacion:{
			name:'nro_cheque',
			fieldLabel:'Nro Cheque',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'60%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'CUEBAN.nro_cheque',
		save_as:'nro_cheque'
	};

	Atributos[7]={
		validacion:{
			name:'estado_cuenta',
			fieldLabel:'Estado Cuenta',
			emptyText:'Estado Cuenta...',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			//store:new Ext.data.SimpleStore({fields:['id','valor'],data:Ext.cuenta_bancaria_combo.activo_inactivo}),
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Activo'],['2','Inactivo']]}),
			renderer:render_cuenta_bancaria,
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			grid_visible:true,
			grid_editable:false,
			forceSelection:true,
			width_grid:90,
			width:'50%'
		},
		tipo:'ComboBox',
		save_as:'estado_cuenta'
		};
	
	// ----------FUNCIONES RENDER---------------//
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE-------//
	var config={titulo_maestro:'cuenta_bancaria',grid_maestro:'grid-'+idContenedor};
	var layout_cuenta_bancaria=new DocsLayoutMaestro(idContenedor);
	layout_cuenta_bancaria.init(config);

	// INICIAMOS HERENCIA //
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_cuenta_bancaria,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	var ClaseMadre_getComponente=this.getComponente;
	var getDialog=this.getDialog;
	var getForm=this.getFormulario;

	// DEFINICIï¿½N DE LA BARRA DE MENï¿½//
	
	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};

	//----------------------  DEFINICIï¿½N DE FUNCIONES ------------------------- //
	//  aquï¿½ se parametrizan las funciones que se ejecutan en la clase madre    //
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/cuenta_bancaria/ActionEliminarCuentaBancaria.php'},
		Save:{url:direccion+'../../../control/cuenta_bancaria/ActionGuardarCuentaBancaria.php'},
		ConfirmSave:{url:direccion+'../../../control/cuenta_bancaria/ActionGuardarCuentaBancaria.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'cuenta_bancaria'}};
	//-------------- DEFINICIï¿½N DE FUNCIONES PROPIAS --------------//

	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
		combo_cuenta=getComponente('id_cuenta');
	    combo_auxiliar=getComponente('id_auxiliar');
     
    	var onCuentaSelect=function(e){
			var id=combo_cuenta.getValue();
			combo_auxiliar.filterValues[0]=id;
			combo_auxiliar.modificado=true;
			combo_auxiliar.allowBlank=true;
			combo_auxiliar.setValue('')
		};
		combo_cuenta.on('select',onCuentaSelect);
		combo_cuenta.on('change',onCuentaSelect);
		
		for(var i=0; i<Atributos.length; i++){
			componentes[i]=ClaseMadre_getComponente(Atributos[i].validacion.name)
		}

		componentes[1].on('select',evento_gestion);
		dialog=getDialog();
		form=getForm()
	}
	
	function evento_gestion( combo, record, index ){	
		//combo cuenta						
		componentes[3].store.baseParams={m_id_gestion:record.data.id_gestion};
		componentes[3].modificado=true;
		componentes[3].setValue('');			
		componentes[3].setDisabled(false);	
 	} 
	
	var gestion = new Ext.form.ComboBox({
			store: ds_gestion,
			displayField:'gestion',
			typeAhead: true,
			mode: 'remote',
			triggerAction: 'all',
			emptyText:'gestion...',
			selectOnFocus:true,
			width:100,
			valueField: 'id_gestion',
			tpl:tpl_gestion
		});

	gestion.on('select',function (combo, record, index){
		g_id_gestion=gestion.getValue();
		//ds_cuenta.baseParams={m_id_gestion:g_id_gestion};	
	
  		ds.load({
			params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			sw_tesoro:1,
			m_id_gestion:g_id_gestion
			}
		});
  	});
  	
	//para que los hijos puedan ajustarse al tamaï¿½o
	this.getLayout=function(){return layout_cuenta_bancaria.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	
	//InitBarraMenu(array DE PARï¿½METROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_gestion:-1
		}
	});
	
	//para agregar botones
	this.AdicionarBotonCombo(gestion,'gestion');
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_cuenta_bancaria.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}