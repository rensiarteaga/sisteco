<?php 
/**
 * Nombre:		  	    siet_cbte_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-06 20:48:38
 *
 */
session_start();
?>
//<script>
//var paginaTipoActivo;

	function main(){
	 	<?php
		//obtenemos la ruta absoluta
		$host  = $_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$dir = "http://$host$uri/";
		echo "\nvar direccion='$dir';";
	    echo "var idContenedor='$idContenedor';";
	?>
	var fa;
	<?php if($_SESSION["ss_filtro_avanzado"]!=''){
		echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}
	?>
var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var elemento={pagina:new pagina_siet_cbte(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_siet_cbte_main.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-06 20:48:38
 */
function pagina_siet_cbte(idContenedor,direccion,paramConfig)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();
	var sw=0;
	var	var_importe;
       var maestro;
       var grid;
       var monedas_for=new Ext.form.MonedaField(
      			{
      				name:'mes_01',
      				fieldLabel:'Enero',
      				allowBlank:false,
      				align:'right',
      				maxLength:50,
      				minLength:0,
      				selectOnFocus:true,
      				allowDecimals:true,
      				decimalPrecision:2,
      				allowNegative:true,
      				minValue:0}
      				);
var componentes=new Array();
	/////////////////
	//  DATA STORE //
	/////////////////
	

	ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/interfaz_siet/ActionListarSietCbte.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_siet_cbte',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_comprobante',
		'nro_cbte',
		'fecha_salida_cb',
		'concepto_cbte',
		//'nro_cuenta_banco',
		//'nombre_auxiliar',
		//'nro_cheque',
		'nombre_largo',
		'id_siet_cbte',
		'id_siet_declara',
		'id_subsistema',
              'periodo_lite',
              'sw_ingresa_declaracion',
              'id_extracto_bancario',
              'id_periodo_dec',
              'tipo_declara',
              'id_cuenta_bancaria',
              'nro_cuenta_banco',
              'importe',
              'sw_fa',
              'estado',
              'sw_reversion',
              'id_cbte_ant_rev',
              'id_cbte'
		]),remoteSort:true});

	//carga datos XML
	/*ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros
		}
	});*/
	function renderSeparadorDeMil(value,cell,record,row,colum,store)
	{
		return monedas_for.formatMoneda(value)
	}
	var ds_comprobante = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/interfaz_siet/ActionListarComprobanteFal.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_siet_cbte',totalRecords: 'TotalCount'},
	['id_siet_cbte','id_cbte','nro_cbte','concepto_cbte'
	,'desc_clase','glosa_cbte','desc_parametro'
	,'acreedor','desc_subsistema','id_cuenta_bancaria','tipo_declara','id_periodo_dec','importe',  'nro_cuenta_banco'
	])
	//,baseParams:{m_vista_siet:'siet_cbte',id_siet_declara:maestro.id_siet_declara}
	});

	function render_id_comprobante(value, p, record){return String.format('{0}', record.data['nro_cbte']);}
	var tpl_id_comprobante=new Ext.Template('<div class="search-item">'
		,'<b>ID SIET CBTE: </b><FONT COLOR="#B5A642">{id_siet_cbte} - {id_comprobante}</FONT><br>',
		'<b>Nro y Comprobante: </b><FONT COLOR="#B5A642">{nro_cbte} - {concepto_cbte}</FONT><br>',
		'<b>Acreedor: </b><FONT COLOR="#B5A642">{acreedor}</FONT><br>',
		'<b>Clase: </b><FONT COLOR="#B5A642">{desc_clase}</FONT><br>',
		'<b>Subsistema: </b><FONT COLOR="#B5A642">{desc_subsistema}</FONT><br>',
              '<b>Importe: </b><FONT COLOR="#B5A642">{importe}</FONT><br>',
              '<b>Nro Cuenta Banco:</b><FONT COLOR="#B5A642">{nro_cuenta_banco}</FONT><br>',
		'<b>Gestión: </b><FONT COLOR="#B5A642">{desc_parametro}</FONT>','</div>');
	
      var ds_extracto_bancario = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/extracto_bancario/ActionListarExtractoBancario.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_extracto_bancario',totalRecords: 'TotalCount'},
	['id_extracto_bancario','nro_cuenta_banco','fecha_movimiento','nro_documento'
	,'monto','id_cuenta_bancaria','desc_parametro','id_periodo_dec','tipo_declara'
	,'periodo'
	])
	
	});

	function render_id_extracto_bancario(value, p, record){return String.format('{0}', record.data['id_extracto_bancario']);}
	var tpl_id_extracto_bancario=new Ext.Template('<div class="search-item">'
		,'<b>ID: </b><FONT COLOR="#B5A642">{id_extracto_bancario}</FONT><b>Cuenta Bancaria: </b><FONT COLOR="#B5A642">{nro_cuenta_banco}</FONT><br>',
		'<b>Nro Documento: </b><FONT COLOR="#B5A642">{nro_documento}</FONT><br>',
		'<b>Monto: </b><FONT COLOR="#B5A642">{monto}</FONT><br>',
		'<b>Fecha_movimiento: </b><FONT COLOR="#B5A642">{fecha_movimiento}</FONT><br>',
		'<b>Gestión y Periodo: </b><FONT COLOR="#B5A642">{desc_parametro} {Periodo}</FONT>','</div>');

	 function render_moneda_17(value,cell,record,row,colum,store){
		 	//if(record.data['disponibilidad'] == 1){
			return  '<span style="color:blue;">' +var_importe.formatMoneda(value)+'</span>'}	
			//if(record.data['disponibilidad'] == 0){return '<span style="color:red;">' +var_importe.formatMoneda(value)+'</span>'}
	 	
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	//en la posición 0 siempre esta la llave primaria
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_siet_cbte',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_siet_cbte'
	};	
	vectorAtributos[1]={
			validacion:{
				labelSeparator:'',
				name: 'id_siet_declara',
				inputType:'hidden',
				grid_visible:false, 
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			//defecto:maestro.id_siet_declara,
			save_as:'id_siet_declara'
		};
    vectorAtributos[2]= {
			validacion:{
				name:'periodo_lite',
				fieldLabel:'Periodo CBTE',
				desc: 'periodo_lite',
				displayField: 'periodo_lite',
				
				allowBlank:false,
				maxLength:10,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				width:'55%',
				grid_visible:true,
				grid_editable:false,
				disabled:true,
				width_grid:50,
						
			},
			form:false,	
			tipo: 'TextField',
			filtro_0:true,
			filterColValue:'periodo_lite',
			
			id_grupo:0
		};	
	
	vectorAtributos[3]= {
			validacion:{
				name:'nro_cbte',
				fieldLabel:'Nro Cbte',
				desc: 'nro_cbte',
				displayField: 'nro_cbte',
				
				allowBlank:false,
				maxLength:10,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				width:'55%',
				grid_visible:true,
				grid_editable:false,
				disabled:true,
				width_grid:50,
						
			},
			form:false,	
			tipo: 'TextField',
			filtro_0:true,
			filterColValue:'sc.nro_cbte',
			save_as:'txt_nro_cbte',
			id_grupo:0
		};
	
	vectorAtributos[4]= {
				validacion:{
					name:'fecha_salida_cb',
					fieldLabel:'Fecha Salida',
					desc: 'fecha_salida_cb',
					displayField: 'fecha_salida_cb',
					
					allowBlank:false,
					maxLength:10,
					minLength:0,
					selectOnFocus:true,
					vtype:'texto',
					width:'55%',
					grid_visible:true,
					grid_editable:false,
					disabled:true,
					width_grid:90,
							
				},
				form:false,	
				tipo: 'TextField',
				filtro_0:true,
				filterColValue:'com.fecha_salida_cb',
				save_as:'txt_fecha_salida',
				id_grupo:0
			};
	vectorAtributos[5]= {
			validacion:{
				name:'concepto_cbte',
				fieldLabel:'Comprobante Concepto',
				desc: 'concepto_cbte',
				displayField: 'concepto_cbte',
				filterCol:'cbte.concepto_cbte',
				
				allowBlank:false,
				maxLength:10,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				width:'55%',
				grid_visible:true,
				grid_editable:false,
				disabled:true,
				width_grid:450,
						
			},
			form:false,	
			tipo: 'TextField',
			filtro_0:true,
			filterColValue:'cbte.concepto_cbte',
			save_as:'concepto_cbte',
			id_grupo:0
		};
    vectorAtributos[6]= {
			validacion:{
				name:'nombre_largo',
				fieldLabel:'Subsistema',
				desc: 'nombre_largo',
				displayField: 'nombre_largo',
				
				allowBlank:false,
				maxLength:10,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				width:'55%',
				grid_visible:true,
				grid_editable:false,
				disabled:true,
				width_grid:170,
						
			},
			form:false,	
			tipo: 'TextField',
			filtro_0:true,
			filterColValue:'sub.nombre_largo',
			save_as:'nombre_largo',
			id_grupo:0
		};
	/*vectorAtributos[7]={
			validacion:{
			name:'id_comprobante',
			fieldLabel:'Comprobante',
			allowBlank:false,			
			emptyText:'Comprobante...',
			desc: 'concepto_cbte', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_comprobante,
			valueField: 'id_comprobante',
			displayField: 'concepto_cbte',
			queryParam: 'filterValue_0',
			filterCol:'id_comprobante',
			typeAhead:false,
			tpl:tpl_id_comprobante,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:false,
			renderer:render_id_comprobante,
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:'50',
			disabled:false		
		},
		tipo:'ComboBox',
		form: false,
		filtro_0:false,
		filterColValue:'id_comprobante',
		save_as:'id_comprobante'
	};*/	
	
	vectorAtributos[7]={
			validacion:{
				labelSeparator:'',
				name: 'id_gestion',
				inputType:'hidden',
				grid_visible:false, 
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			//defecto:maestro.id_siet_declara,
			save_as:'id_gestion'
		};	
	vectorAtributos[8]={
			validacion:{
				labelSeparator:'',
				name: 'tipo_declara',
				inputType:'hidden',
				grid_visible:false, 
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:true,
			defecto:'gasto',
			save_as:'tipo_declara'
		};
      vectorAtributos[9]= {
			validacion:{
				name:'sw_ingresa_declaracion',
				fieldLabel:'Ing. Cbte',
				desc: 'sw_ingresa_declaracion',
				displayField: 'sw_ingresa_declaracion',
				
				allowBlank:false,
				maxLength:10,
				minLength:0,
				width:'55%',
                typeAhead:true,
				loadMask:true,
     				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','si'],['si-no','si-no'],['no','no']]}),
				valueField:'ID',
				displayField:'valor',
				lazyRender:true,
				forceSelection:true,
				grid_visible:true,
				grid_editable:true,
				disabled:false,
				width_grid:70,
						
			},
			form:false,	
			tipo: 'ComboBox',
			filtro_0:true,
			filterColValue:'sw_ingresa_declaracion',
			save_as:'sw_ingresa_declaracion',
			id_grupo:0,
			defecto:'si'
		};
		vectorAtributos[10]={
			validacion:{
			name:'id_siet_cbte_nuevo',
			fieldLabel:'Comprobante',
			allowBlank:false,			
			emptyText:'Comprobante...',
			desc: 'concepto_cbte', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_comprobante,
			valueField: 'id_siet_cbte',
			displayField: 'concepto_cbte',
			queryParam: 'filterValue_0',
			filterCol:'sc.id_cbte#sc.nro_cbte#sc.importe#sc.id_siet_cbte#cueban.nro_cuenta_banco',
            filterColValue:'sc.id_cbte#sc.nro_cbte#sc.importe#sc.id_siet_cbte#cueban.nro_cuenta_banco',
			typeAhead:false,
			tpl:tpl_id_comprobante,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:'50%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_comprobante,
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:'50%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'sc.id_cbte#sc.nro_cbte#sc.importe#cueban.nro_cuenta_banco',
		save_as:'id_siet_cbte_nuevo'
	};	
vectorAtributos[11]={
			validacion:{
			name:'id_extracto_bancario',
			fieldLabel:'EXTRACTO BANCARIO',
			allowBlank:false,			
			emptyText:'Extracto Bancario...',
			desc: 'id_extracto_bancario', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_extracto_bancario,
			valueField: 'id_extracto_bancario',
			displayField: 'id_extracto_bancario',
			queryParam: 'filterValue_0',
			filterCol:'EXTBAN.id_extracto_bancario#EXTBAN.monto',
			typeAhead:false,
			tpl:tpl_id_extracto_bancario,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_extracto_bancario,
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'EXTBAN.id_extracto_bancario#EXTBAN.monto',
		save_as:'id_extracto_bancario'
	};
vectorAtributos[12]={
			validacion:{
				name: 'id_periodo_dec',
				inputType:'hidden',
				grid_visible:false, 
				grid_editable:false
			},
			tipo: 'Field',
                     form: false,
			filtro_0:false,
			save_as:'id_periodo_dec'
		};
vectorAtributos[13]={
			validacion:{
				
				
				name: 'tipo_declara',
				inputType:'hidden',
				grid_visible:false, 
				grid_editable:false
			},
			tipo: 'Field',
                     form: false,
			filtro_0:false,
			save_as:'tipo_declara'
		};
vectorAtributos[14]={
			validacion:{
				
				
				name: 'id_cuenta_bancaria',
				inputType:'hidden',
				grid_visible:false, 
				grid_editable:false
			},
			tipo: 'Field',
                     form: false,
			filtro_0:false,
			save_as:'id_cuenta_bancaria'
		};
vectorAtributos[15]= {
			validacion:{
				name:'nro_cuenta_banco',
				fieldLabel:'Nro. Cuenta Banco',
				desc: 'nro_cuenta_banco',
				displayField: 'nro_cuenta_banco',
				
				allowBlank:false,
				maxLength:10,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				width:'55%',
				grid_visible:true,
				grid_editable:false,
				disabled:true,
				width_grid:100,
						
			},
			form:false,	
			tipo: 'TextField',
			filtro_0:true,
			filterColValue:'cueban.nro_cuenta_banco',
			save_as:'nro_cuenta_banco'
			
		};
vectorAtributos[16]={
			validacion:{
				labelSeparator:'',
				name: 'tipo_generacion',
				inputType:'hidden',
				grid_visible:false, 
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			defecto:'uno',
			save_as:'tipo_generacion'
		};
 vectorAtributos[17]= {
			validacion:{
				name:'id_siet_cbte',
				fieldLabel:'ID SIET CBTE',
				desc: 'id_siet_cbte',
				displayField: 'sc.id_siet_cbte',
				allowBlank:false,
				maxLength:10,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				width:'55%',
				grid_visible:true,
				grid_editable:false,
				disabled:true,
				width_grid:70,
						  
			},
			form:false,	
			tipo: 'TextField',
			filtro_0:true,
			filterColValue:'sc.id_siet_cbte',
			
			id_grupo:0
		};

vectorAtributos[18]= {
			validacion:{
				name:'id_extracto_bancario',
				fieldLabel:'ID Extracto B.',
				desc: 'id_extracto_bancario',
				displayField: 'id_extracto_bancario',
				
				allowBlank:false,
				maxLength:10,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				width:'55%',
				grid_visible:true,
				grid_editable:false,
				disabled:true,
				width_grid:70,
						
			},
			form:false,	
			tipo: 'TextField',
			filtro_0:true,
			filterColValue:'sc.id_extracto_bancario',
		       id_grupo:0
		};
vectorAtributos[19]= {
		validacion:{
			name:'importe',
			fieldLabel:'Importe',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision :6,//para numeros float
			allowNegative: true,
			//minValue:0,
			vtype:'texto',
			grid_visible:true,
			align:'right',
			renderer: renderSeparadorDeMil,
			//renderer:render_moneda_17,
			grid_editable:true,
			width_grid:100,
			width:'80%'
		},
		form:false,	
		tipo: 'NumberField',
		//tipo: 'MonedaField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'importe',
		save_as:'importe',
		id_grupo:0
	};


vectorAtributos[20]= {
		validacion:{
			name:'sw_fa',
			fieldLabel:'FA',
			desc: 'sw_fa',
			displayField: 'sw_fa',
			
			allowBlank:false,
			maxLength:10,
			minLength:0,
			width:'55%',
                        typeAhead:true,
			loadMask:true,
 				triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','si'],['no','no']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
		
			grid_visible:true,
			grid_editable:true,
			disabled:false,
			width_grid:70,
					
		},
		form:false,	
		tipo: 'ComboBox',
		filtro_0:true,
		filterColValue:'sc.sw_fa',
		save_as:'sw_fa',
		id_grupo:0
		
	};																		
vectorAtributos[21]= {
		validacion:{
			name:'estado',
			fieldLabel:'Estado',
			desc: 'estado',
			displayField: 'estado',
			
			allowBlank:false,
			maxLength:10,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:'55%',
			grid_visible:true,
			grid_editable:false,
			disabled:true,
			width_grid:70,
			valign:'right'
					
		},
		form:false,	
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'sc.estado',
	       id_grupo:0
	};
vectorAtributos[22]= {
		validacion:{
			name:'sw_reversion',
			fieldLabel:'REV.',
			desc: 'sw_reversion',
			displayField: 'sw_reversion',
			
			allowBlank:false,
			maxLength:10,
			minLength:0,
			width:'55%',
            typeAhead:true,
			loadMask:true,
 				triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','si'],['no','no']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
		
			grid_visible:true,
			grid_editable:true,
			disabled:false,
			width_grid:70,
					
		},
		form:false,	
		tipo: 'ComboBox',
		filtro_0:true,
		filterColValue:'sc.sw_reversion',
		save_as:'sw_reversion',
		id_grupo:0
		
	};	

vectorAtributos[23]= {
		validacion:{
			name:'id_cbte_ant_rev',
			fieldLabel:'ID CBTE REV',
			desc: 'id_cbte_ant_rev',
			displayField: 'id_cbte_ant_rev',
			
			allowBlank:false,
			maxLength:10,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:'55%',
			grid_visible:true,
			grid_editable:true,
			disabled:false,
			width_grid:70,
			valign:'right'
					
		},
		form:false,	
		tipo: 'TextField',
		filtro_0:true,
		filterColValue:'sc.id_cbte_ant_rev',
	       id_grupo:0
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
		titulo_maestro:'siet_cbte',
		grid_maestro:'grid-'+idContenedor
	};
	layout_siet_cbte=new DocsLayoutMaestro(idContenedor);
	layout_siet_cbte.init(config);

	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,ds,layout_siet_cbte,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var cm_btnEdit = this.btnEdit;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getFormulario=this.getFormulario;

	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////

	var paramMenu={
	       guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		//eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};


	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones = {
		btnEliminar:{url:direccion+'../../../control/interfaz_siet/ActionEliminarSietCbte.php'},
		Save:{url:direccion+'../../../control/interfaz_siet/ActionGuardarSietCbteMod.php'},
		ConfirmSave:{url:direccion+'../../../control/interfaz_siet/ActionGuardarSietCbteMod.php'},
		Formulario:{
			titulo:'siet_cbte',
			html_apply:"dlgInfo-"+idContenedor,
			width:'40%',
			height:'48%',   
			minWidth:100,
			minHeight:150,
			columnas:['95%'],
			closable:true,
			grupos:[{
				tituloGrupo:'Datos',
				columna:0,
				id_grupo:0
			}
			]
		}
	};
this.btnNew=function()
{
ClaseMadre_btnNew();
 //ClaseMadre_getComponente('id_comprobante').enable(true); 
}
	this.btnEdit=function()
	{
             // ClaseMadre_getComponente('id_comprobante').disable(true); 
		var sm=getSelectionModel();
		var SelectionsRecord=sm.getSelected();
		cm_btnEdit();
              ds_extracto_bancario.baseParams={
				  id_cuenta_bancaria1:SelectionsRecord.data.id_cuenta_bancaria,
                  tipo_declara:SelectionsRecord.data.tipo_declara,
                  id_periodo_dec:SelectionsRecord.data.id_periodo_dec,
		 		  m_vista:'siet_cbte'	
		}
             // ClaseMadre_getComponente('tipo_generacion').modificado=true;
              //ClaseMadre_getComponente('tipo_generacion').setValue('uno');
             // ClaseMadre_getComponente('id_extracto_bancario').modificado=true;
		//ClaseMadre_getComponente('id_extracto_bancario').setValue('ninguno');
	}
			    
function iniciarEventosFormularios()
	{		
			grid=ClaseMadre_getGrid();
			dialog=ClaseMadre_getDialog();
			
			sm=getSelectionModel();
			formulario=ClaseMadre_getFormulario();
	    	
		id_comprobante = ClaseMadre_getComponente('id_comprobante');
		id_siet_cbte_nuevo = ClaseMadre_getComponente('id_siet_cbte_nuevo');
		//id_cuenta_bancaria = ClaseMadre_getComponente('id_cuenta_bancaria');
		/*var sm=getSelectionModel();
		var SelectionsRecord=sm.getSelected();*/
		var id_periodo_dec=ClaseMadre_getComponente('id_periodo_dec');
		var tipo_declara=ClaseMadre_getComponente('tipo_declara');
		var id_cuenta_bancaria=ClaseMadre_getComponente('id_cuenta_bancaria');
		var sw_ingresa_declaracion=ClaseMadre_getComponente('sw_ingresa_declaracion');
		var sw_fa=ClaseMadre_getComponente('sw_fa');
		var sw_reversion=ClaseMadre_getComponente('sw_reversion');
		var_importe=ClaseMadre_getComponente('importe');
	    //  alert(id_periodo_dec);
		//ClaseMadre_getComponente('id_presupuesto').disabled=true;
		//ClaseMadre_getComponente('id_comprobante').disable(false); 
		for(var i=0; i<vectorAtributos.length; i++)
		{
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}

		ClaseMadre_getComponente('id_siet_cbte_nuevo').on('select',evento_comprobante);		//parametro		
		//var_importe.on('change',f_ha_de);
	
     }
     
    function f_ha_de(elemento, nuevo, antiguo){var_importe.setValue('')}
    
	function evento_comprobante( combo, record, index )
	{
		g_id_cuenta_bancaria=record.data.id_cuenta_bancaria;
		g_tipo_declara=record.data.tipo_declara;
		g_id_periodo_dec=record.data.id_periodo_dec;
		g_id_siet_cbte=record.data.id_siet_cbte;
		/*g_id_extracto_bancario=ClaseMadre_getComponente('id_extracto_bancario').getValue();
		g_sw_ingresa_declaracion=ClaseMadre_getComponente('sw_ingresa_declaracion').getValue();
		g_sw_fa=ClaseMadre_getComponente('sw_fa').getValue();
		g_sw_reversion=ClaseMadre_getComponente('sw_reversion').getValue();*/
	      alert(g_id_cuenta_bancaria);
	      
		ds_extracto_bancario.baseParams={
				id_cuenta_bancaria1:g_id_cuenta_bancaria,
                tipo_declara:g_tipo_declara,
                id_periodo_dec:g_id_periodo_dec,
		  m_vista:'siet_cbte'		
		}
        ClaseMadre_getComponente('id_extracto_bancario').modificado=true;
        
		ClaseMadre_getComponente('id_extracto_bancario').setValue('');
		ClaseMadre_getComponente('id_siet_cbte').setValue(g_id_siet_cbte);
		/*ClaseMadre_getComponente('sw_ingresa_declaracion').setValue(g_sw_ingresa_declaracion);
		ClaseMadre_getComponente('sw_fa').setValue(g_sw_fa);
		ClaseMadre_getComponente('sw_reversion').setValue(g_sw_reversion);*/
	}	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function btn_solicitud_compra_det(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();
		var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			 if (maestro.tipo_declara=='gasto'){
			      tipo_declara=2;
		     }else{
		    	 tipo_declara=1;
		     }
			var SelectionsRecord=sm.getSelected();
           var data='m_id_siet_cbte='+SelectionsRecord.data.id_siet_cbte;
		    data=data+'&m_id_siet_declara='+SelectionsRecord.data.id_siet_declara;		
			    data=data+'&m_id_parametro='+maestro.id_parametro;	
			    data=data+'&m_tipo_declara='+tipo_declara;		
			    
			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			//if(SelectionsRecord.data.id_subsistema==9){
					layout_siet_cbte.loadWindows(direccion+'../../../../sis_presupuesto/vista/interfaz_siet/siet_cbte_partida.php?'+data,'Detalle de Partidas',ParamVentana);
			    	layout_siet_cbte.getVentana().on('resize',function(){
					layout_siet_cbte.getLayout().layout();
				})
			/*}else{
				Ext.MessageBox.alert('Estado', 'Solo Cbtes de Contabilidad pueden acceder a esta función');
			}*/
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
/****************************esto es para validar todos los que estan en si-no para que de una vez ingresen a la declaración **********/
function btn_validar_sino()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		//var SelectionsRecord=sm.getSelected();
		//var id_siet_declara
		
			if(confirm('Esta seguro de Validar todos los que estan en estado si-no ?'))
				sw=true
				Ext.MessageBox.show({
					title: 'Procesando',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Procesando...</div>",
					width:200,
					height:200,
					closable:false
				});
				
			var SelectionsRecord=sm.getSelected();
	          		
	 			//var arr_id_siet_declara = new Array;
			//var data='m_id_siet_cbte='+SelectionsRecord.data.id_siet_cbte;
		    
					var id_siet_declara=maestro.id_siet_declara;
						
	 				Ext.Ajax.request({
					url:direccion+"../../../control/interfaz_siet/ActionGuardarSietCbte.php",
					method:'POST',
					params:{cantidad_ids:1,id_siet_declara_0:id_siet_declara,tipo_declara_0:'validar_sino'},
					success:function(resp){
						var root = resp.responseXML.documentElement;
						var error = root.getElementsByTagName('error')[0].firstChild.nodeValue;
						if(error=='1'){
							Ext.MessageBox.alert('Información',root.getElementsByTagName('mensaje_error')[0].firstChild.nodeValue);
							return;
						} else {
							Ext.MessageBox.alert('Información',root.getElementsByTagName('mensaje')[0].firstChild.nodeValue);
						}
					},
					failure:ClaseMadre_conexionFailure,
					timeout:100000000
					});				
	 		

		
	}	

	
/*************************************************/	
/**	function btn_reporte()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0)
		{
			var SelectionsRecord=sm.getSelected();
			var data='id_siet_cbte='+SelectionsRecord.data.id_siet_cbte;	
		        data=data+'&id_siet_declara='+SelectionsRecord.data.id_siet_declara;				
			
			Ext.MessageBox.show({
				title: 'Imprimiendo',
				msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Generando reporte ...</div>",
				width:300,
				height:200,
				closable:false
			});
			
			window.open(direccion+'../../../control/_reportes/interfaz_siet/ActionPDF_RepFlujoCaja.php?'+data);					
		
			Ext.MessageBox.hide();		
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
*/
/***********************************************************************REPORTE X oec*************************/
	/*function btn_reporte()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
		if(NumSelect!=0)
		{
			var SelectionsRecord=sm.getSelected();
			var data='id_siet_cbte='+SelectionsRecord.data.id_siet_cbte;	
		        data=data+'&id_siet_declara='+SelectionsRecord.data.id_siet_declara;				
			
			Ext.MessageBox.show({
				title: 'Imprimiendo',
				msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Generando reporte ...</div>",
				width:300,
				height:200,
				closable:false
			});
			
			window.open(direccion+'../../../control/_reportes/interfaz_siet/ActionPDF_RepFlujoCaja.php?'+data);					
		
			Ext.MessageBox.hide();		
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}*/
	/*******************************************FIN REPORTE X OEC*********************************/
	/***********************************************************************REPORTE Extractos Bancarios*************************/
	function btn_reporte_extracto_bancario()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
		
			var SelectionsRecord=sm.getSelected();
			var data='id_siet_declara='+maestro.id_siet_declara;
                         data=data+'&reporte=extracto_bancario';
                         data=data+'&periodo='+maestro.periodo_lite;	
                         data=data+'&gestion='+maestro.gestion;	
                         data=data+'&tipo_declara='+maestro.tipo_declara;
                   //      data=data+'&tipo_reporte='+tipo_reporte.getValue();	
		       // alert(data);
			Ext.MessageBox.show({
				title: 'Imprimiendo',
				msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Generando reporte ...</div>",
				width:300,
				height:200,
				closable:false
			});
			
			window.open(direccion+'../../../control/_reportes/interfaz_siet/ActionPDF_RepFlujoCaja.php?'+data);					
		
			Ext.MessageBox.hide();		
		
		
	}
	/*******************************************FIN REPORTE Extractos Bancarios*********************************/
	/***********************************************************************REPORTE Comprobantes*************************/
	function btn_reporte_comprobante()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
		
			var SelectionsRecord=sm.getSelected();
			var data='id_siet_declara='+maestro.id_siet_declara;
                data=data+'&reporte=comprobantes_dec';	
		        data=data+'&periodo='+maestro.periodo_lite;	
                data=data+'&gestion='+maestro.gestion;
                data=data+'&tipo_declara='+maestro.tipo_declara;	
             //   data=data+'&tipo_reporte='+tipo_reporte.getValue();	
			Ext.MessageBox.show({
				title: 'Imprimiendo',
				msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Generando reporte ...</div>",
				width:300,
				height:200,
				closable:false
			});
			  
			window.open(direccion+'../../../control/_reportes/interfaz_siet/ActionPDF_RepFlujoCaja.php?'+data);					
		
			Ext.MessageBox.hide();		
		
	}
	/***********************************************************************REPORTE Comprobantes que no tienen asociados a partidas*************************/
	function btn_cbte_no_asoc_partidas()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
		
			var SelectionsRecord=sm.getSelected();
			var data='id_siet_declara='+maestro.id_siet_declara;
                data=data+'&reporte=comprobantes_sin_partida';	
		        data=data+'&periodo='+maestro.periodo_lite;	
                data=data+'&gestion='+maestro.gestion;	
              //  data=data+'&tipo_reporte='+tipo_reporte.getValue();
			Ext.MessageBox.show({
				title: 'Imprimiendo',
				msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Generando reporte ...</div>",
				width:300,
				height:200,
				closable:false
			});
			
			window.open(direccion+'../../../control/_reportes/interfaz_siet/ActionPDF_RepFlujoCaja.php?'+data);					
		
			Ext.MessageBox.hide();		
		
	}
	/***********************************************************************REPORTE Comprobantes tienen partidas pero no se han asociados a OEC's*************************/
	function btn_partidas_no_asoc_oec()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
		
			var SelectionsRecord=sm.getSelected();
			var data='id_siet_declara='+maestro.id_siet_declara;
                data=data+'&reporte=partidas_sin_oec';	
		        data=data+'&periodo='+maestro.periodo_lite;	
                data=data+'&gestion='+maestro.gestion;
              //  data=data+'&tipo_reporte='+tipo_reporte.getValue();	
			Ext.MessageBox.show({
				title: 'Imprimiendo',
				msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Generando reporte ...</div>",
				width:300,
				height:200,
				closable:false
			});
			
			window.open(direccion+'../../../control/_reportes/interfaz_siet/ActionPDF_RepFlujoCaja.php?'+data);					
		
			Ext.MessageBox.hide();		
		
	}
	/*******************************************FIN REPORTE Comprobantes*********************************/
	/*********************************************EXCEL PARA CBTES QUE NO TIENEN PARTIDAS*****/
	function btn_cbte_no_asoc_partidas_excel(){ 
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
			var data='id_siet_declara='+maestro.id_siet_declara;
			
			
		
			window.open(direccion+'../../../control/interfaz_siet/ActionExcelCbtesPartidas.php?'+data);

		
	}
	/*********************************************FIN EXCEL PARA CBTES QUE NO TIENEN PARTIDAS*****/
	/*********************************************EXCEL PARA PARTIDAS QUE NO TIENEN ASOCIADOS OEC´S*****/
	function btn_partidas_no_asoc_oec_excel(){ 
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
			var data='id_siet_declara='+maestro.id_siet_declara;
			
			
		
			window.open(direccion+'../../../control/interfaz_siet/ActionExcelPartidasOEC.php?'+data);

		
	}
	/*********************************************EXCEL PARA PARTIDAS QUE NO TIENEN ASOCIADOS OEC´S*****/
/***********************************************************************REPORTE Conciliacion Fallida*************************/
	function btn_conc_fallida()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
		
			var SelectionsRecord=sm.getSelected();
			var data='id_siet_declara='+maestro.id_siet_declara;
                data=data+'&reporte=conc_fallida';	
		        data=data+'&periodo='+maestro.periodo_lite;	
                data=data+'&gestion='+maestro.gestion;
                data=data+'&tipo_declara='+maestro.tipo_declara;
             //   data=data+'&tipo_reporte='+tipo_reporte.getValue();	
			Ext.MessageBox.show({
				title: 'Imprimiendo',
				msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Generando reporte ...</div>",
				width:300,
				height:200,
				closable:false
			});
			  
			window.open(direccion+'../../../control/_reportes/interfaz_siet/ActionPDF_RepFlujoCaja.php?'+data);					
		
			Ext.MessageBox.hide();		
		
	}
	/*******************************************FIN REPORTE Comprobantes*********************************/
	/***********************************************************************REPORTE Conciliacion Fallida OEC*************************/
	function btn_conc_fallida_oec()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
		
			var SelectionsRecord=sm.getSelected();
			var data='id_siet_declara='+maestro.id_siet_declara;
                data=data+'&reporte=conc_fallida_oec';	
		        data=data+'&periodo='+maestro.periodo_lite;	
                data=data+'&gestion='+maestro.gestion;	
              //  data=data+'&tipo_reporte='+tipo_reporte.getValue();
			Ext.MessageBox.show({
				title: 'Imprimiendo',
				msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Generando reporte ...</div>",
				width:300,
				height:200,
				closable:false
			});
			  
			window.open(direccion+'../../../control/_reportes/interfaz_siet/ActionPDF_RepFlujoCaja.php?'+data);					
		
			Ext.MessageBox.hide();		
		
	}
	/*******************************************FIN REPORTE Comprobantes*********************************/
	/***********************************************************************REPORTE Conciliacion Fallida*************************/
	function btn_conc_fallida_partida()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
		
			var SelectionsRecord=sm.getSelected();
			var data='id_siet_declara='+maestro.id_siet_declara;
                data=data+'&reporte=conc_fallida_partida';	
		        data=data+'&periodo='+maestro.periodo_lite;	
                data=data+'&gestion='+maestro.gestion;	
              //  data=data+'&tipo_reporte='+tipo_reporte.getValue();
			Ext.MessageBox.show({
				title: 'Imprimiendo',
				msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Generando reporte ...</div>",
				width:300,
				height:200,
				closable:false
			});
			  
			window.open(direccion+'../../../control/_reportes/interfaz_siet/ActionPDF_RepFlujoCaja.php?'+data);					
		
			Ext.MessageBox.hide();		
		
	}
	/*******************************************FIN REPORTE Conciliación Fallida*********************************/
	

	/***********************************************************************REPORTE Conciliacion Fallida*************************/
	function btn_conc_banc_cbte()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		var data='id_siet_declara='+maestro.id_siet_declara;
                data=data+'&reporte=conc_banc_cbte';	
		        data=data+'&periodo='+maestro.periodo_lite;	
                data=data+'&gestion='+maestro.gestion;
                data=data+'&tipo_declara='+maestro.tipo_declara;
        //       data=data+'&tipo_reporte='+tipo_reporte.getValue();	
			Ext.MessageBox.show({
				title: 'Imprimiendo',
				msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Generando reporte ...</div>",
				width:300,
				height:200,
				closable:false
			});
			 
			window.open(direccion+'../../../control/_reportes/interfaz_siet/ActionPDF_RepFlujoCaja.php?'+data);					
		
			Ext.MessageBox.hide();		
		
	}
	/*******************************************FIN REPORTE Comprobantes*********************************/
	/***********************************************************************REPORTE Conciliacion Bancaria Partidas*************************/
	function btn_conc_banc_par()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
		
			var SelectionsRecord=sm.getSelected();
			var data='id_siet_declara='+maestro.id_siet_declara;
                data=data+'&reporte=conc_banc_par';	
		        data=data+'&periodo='+maestro.periodo_lite;	
                data=data+'&gestion='+maestro.gestion;	
                data=data+'&tipo_declara='+maestro.tipo_declara;	
               // data=data+'&tipo_reporte='+tipo_reporte.getValue();   
			Ext.MessageBox.show({
				title: 'Imprimiendo',
				msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Generando reporte ...</div>",
				width:300,
				height:200,
				closable:false
			});
			 
			window.open(direccion+'../../../control/_reportes/interfaz_siet/ActionPDF_RepFlujoCaja.php?'+data);					
		
			Ext.MessageBox.hide();		
		
	}
	/*******************************************FIN REPORTE Comprobantes*********************************/
	/***********************************************************************REPORTE Conciliacion Bancaria OEC*************************/
	function btn_conc_banc_oec()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
		
			var SelectionsRecord=sm.getSelected();
			var data='id_siet_declara='+maestro.id_siet_declara;
                data=data+'&reporte=conc_banc_oec';	
		        data=data+'&periodo='+maestro.periodo_lite;	
                data=data+'&gestion='+maestro.gestion;	
               // data=data+'&tipo_reporte='+tipo_reporte.getValue();
			Ext.MessageBox.show({
				title: 'Imprimiendo',
				msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Generando reporte ...</div>",
				width:300,
				height:200,
				closable:false
			});
			 
			window.open(direccion+'../../../control/_reportes/interfaz_siet/ActionPDF_RepFlujoCaja.php?'+data);					
		
			Ext.MessageBox.hide();		
		
	}
	/***********************************************************************REPORTE FA Faltantes (Recursos)*************************/
	function btn_rep_fa_faltantes()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
		
			var SelectionsRecord=sm.getSelected();
			var data='id_siet_declara='+maestro.id_siet_declara;
                data=data+'&reporte=fa_faltantes';	
		        data=data+'&periodo='+maestro.periodo_lite;	
                data=data+'&gestion='+maestro.gestion;	
                data=data+'&tipo_reporte='+tipo_reporte.getValue();
			Ext.MessageBox.show({
				title: 'Imprimiendo',
				msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Generando reporte ...</div>",
				width:300,
				height:200,
				closable:false
			});
			 
			window.open(direccion+'../../../control/_reportes/interfaz_siet/ActionPDF_RepFlujoCaja.php?'+data);					
		
			Ext.MessageBox.hide();		
		
	}
	/*******************************************FIN REPORTE Comprobantes*********************************/
	/***********************************************************************REPORTE Faltantes Depositos erroneos *************************/
	function btn_rep_dep_erroneo()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		
		
			var SelectionsRecord=sm.getSelected();
			var data='id_siet_declara='+maestro.id_siet_declara;
                data=data+'&reporte=dep_erroneo';	
		        data=data+'&periodo='+maestro.periodo_lite;	
                data=data+'&gestion='+maestro.gestion;
                data=data+'&tipo_declara='+maestro.tipo_declara;
                data=data+'&tipo_reporte='+tipo_reporte.getValue();	
			Ext.MessageBox.show({
				title: 'Imprimiendo',
				msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Generando reporte ...</div>",
				width:300,
				height:200,
				closable:false
			});
			 
			window.open(direccion+'../../../control/_reportes/interfaz_siet/ActionPDF_RepFlujoCaja.php?'+data);					
		
			Ext.MessageBox.hide();		
		
	}
	/*******************************************FIN REPORTE Comprobantes*********************************/
	function btn_repcbte(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_comprobante='+SelectionsRecord.data.id_comprobante;
			data=data+'&m_vista=plan_pagos';
			
			window.open(direccion+'../../../../sis_contabilidad/control/comprobante/reporte/ActionPDFComprobante.php?'+data)
		}
		else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	this.reload=function(m)
	{
		
		maestro=m;
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_siet_declara:maestro.id_siet_declara,
				m_id_parametro:maestro.id_parametro	,
				m_tipo_declara:maestro.tipo_declara				
			}
		};
		
		this.btnActualizar();
		this.InitFunciones(paramFunciones);

		

		ds_comprobante.baseParams={
				id_siet_declara:maestro.id_siet_declara,
				m_vista_siet:'siet_cbte'
		}
		
		vectorAtributos[1].defecto=maestro.id_siet_declara;
		vectorAtributos[8].defecto=maestro.id_gestion;
	};
		
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_siet_cbte.getLayout()};
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
	this.AdicionarBoton('../../../lib/imagenes/detalle.png','Detalle de Partidas',btn_solicitud_compra_det,true,'solicitud_compra_det','Detalle Partidas');
	this.AdicionarBoton('../../../lib/imagenes/print.gif',' ',btn_repcbte,true,'imprimir','Comprobante');
	
	this.AdicionarMenuBotonSimple({text:'Cbtes', 
           nombre:'Inf. Cbtes',
           icon:'../../../lib/imagenes/det.ico',
           cls: 'x-btn-text-icon bmenu', // icon and text class
           items:[{   text:'Conciliación Comprobantes',
		      	       nombre:'btn_conc_banc_cbte',
		      	       handler:btn_conc_banc_cbte,
		      	       icon:'../../../lib/imagenes/print.gif',
		      	       // cls:'x-btn-text-icon'
		      	       cls: 'x-btn-icon',
		      	    },
                  
                  { text:'Conciliación de Cbtes Detallada',
        	       nombre:'btn_reporte_extracto_bancario',
        	       handler:btn_reporte_extracto_bancario,
        	       icon:'../../../lib/imagenes/print.gif',
        	      // cls:'x-btn-text-icon'
        	       cls: 'x-btn-icon',
        	      },
        	       {   text:'Comprobantes No Asociados',
            	       nombre:'btn_reporte_comprobante',
            	       handler:btn_reporte_comprobante,
            	       icon:'../../../lib/imagenes/print.gif',
            	       // cls:'x-btn-text-icon'
            	       cls: 'x-btn-icon',
            	    },
            	    {   text:'Fondos en Avance con Dep. Erroneo',
              	       nombre:'btn_rep_fa_faltantes',
              	       handler:btn_rep_fa_faltantes,
              	       icon:'../../../lib/imagenes/print.gif',
              	       // cls:'x-btn-text-icon'
              	       cls: 'x-btn-icon',
              	    },
                	  {   text:'Cbtes. con Deposito Erroneo',
                	       nombre:'btn_rep_dep_erroneo',
                	       handler:btn_rep_dep_erroneo,
                	       icon:'../../../lib/imagenes/print.gif',
                	       // cls:'x-btn-text-icon'
                	       cls: 'x-btn-icon',
                	    },
            	    
                	  {   text:'Conciliación Fallida Cbtes',
                	       nombre:'btn_conc_fallida',
                	       handler:btn_conc_fallida,
                	       icon:'../../../lib/imagenes/print.gif',
                	       // cls:'x-btn-text-icon'
                	       cls: 'x-btn-icon',
                	    }/*,
                	  {   text:'Validar Si-No',
                	       nombre:'btn_validar_sino',
                	       handler:btn_validar_sino,
                	       icon:'../../../lib/imagenes/ok.png',
                	       // cls:'x-btn-text-icon'
                	       cls: 'x-btn-icon',
                	    }*/
        	   ] 
             });
	this.AdicionarMenuBotonSimple({text:'Partidas', 
        nombre:'Inf. Cbtes',
        icon:'../../../lib/imagenes/det.ico',
        cls: 'x-btn-text-icon bmenu', // icon and text class
        items:[{ text:'Cbtes. No Asociados a Partidas',
     	       nombre:'btn_cbte_no_asoc_partidas',
     	       handler:btn_cbte_no_asoc_partidas,
     	       icon:'../../../lib/imagenes/print.gif',
     	      // cls:'x-btn-text-icon'
     	       cls: 'x-btn-icon',
     	      },
     	       {   text:'Cbtes. No Asociados a Partidas Excel',
         	       nombre:'btn_cbte_no_asoc_partidas_excel',
         	       handler:btn_cbte_no_asoc_partidas_excel,
         	       icon:'../../../lib/imagenes/excel_16x16.gif',
         	       // cls:'x-btn-text-icon'
         	       cls: 'x-btn-icon',
         	    },
         	    {   text:'Conciliación Partida',
           	       nombre:'btn_conc_banc_par',
           	       handler:btn_conc_banc_par,
           	       icon:'../../../lib/imagenes/print.gif',
           	       // cls:'x-btn-text-icon'
           	       cls: 'x-btn-icon',
           	    },
             	  {   text:'Conciliación Fallida Partidas',
             	       nombre:'btn_conc_partidas',
             	       handler:btn_conc_fallida_partida,
             	       icon:'../../../lib/imagenes/print.gif',
             	       // cls:'x-btn-text-icon'
             	       cls: 'x-btn-icon',
             	    },
             	  {   text:'Validar Partidas',
             	       nombre:'btn_validar_sino',
             	       handler:btn_validar_sino,
             	       icon:'../../../lib/imagenes/ok.png',
             	       // cls:'x-btn-text-icon'
             	       cls: 'x-btn-icon',
             	    }
     	   ] 
          });
	this.AdicionarMenuBotonSimple({text:'OECs', 
        nombre:'Inf. Oecs',
        icon:'../../../lib/imagenes/det.ico',
        cls: 'x-btn-text-icon bmenu', // icon and text class
        items:[{ text:'OECs. No Asociados a Partidas',
     	       nombre:'btn_partidas_no_asoc_oec',
     	       handler:btn_partidas_no_asoc_oec,
     	       icon:'../../../lib/imagenes/print.gif',
     	      // cls:'x-btn-text-icon'
     	       cls: 'x-btn-icon',
     	      },
     	       {   text:'OECs. No Asociados a Partidas Excel',
         	       nombre:'btn_cbte_no_asoc_partidas',
         	       handler:btn_partidas_no_asoc_oec_excel,
         	       icon:'../../../lib/imagenes/excel_16x16.gif',
         	       // cls:'x-btn-text-icon'
         	       cls: 'x-btn-icon',
         	    },
         	    {   text:'Conciliación OEC',
           	       nombre:'btn_conc_banc_oec',
           	       handler:btn_conc_banc_oec,
           	       icon:'../../../lib/imagenes/print.gif',
           	       // cls:'x-btn-text-icon'
           	       cls: 'x-btn-icon',
           	    },
             	  {   text:'Conciliación Fallida OEC',
             	       nombre:'btn_conc_fallida_oec',
             	       handler:btn_conc_fallida_oec,
             	       icon:'../../../lib/imagenes/print.gif',
             	       // cls:'x-btn-text-icon'
             	       cls: 'x-btn-icon',
             	    },
             	  {   text:'Validar OEC',
             	       nombre:'btn_validar_sino',
             	       handler:btn_validar_sino,
             	       icon:'../../../lib/imagenes/ok.png',
             	       // cls:'x-btn-text-icon'
             	       cls: 'x-btn-icon',
             	    }
     	   ] 
          });
    
	var tipo_reporte=new Ext.form.ComboBox({
		
		name:'tipo_reporte',
		fieldLabel:'Tipo Reporte',
		allowBlank:true,
		emptyText:'Formato Reporte...',
		typeAhead:true,
		loadMask:true,
		triggerAction:'all',
		store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['pdf','PDF'],['xls','Excel']]}),
		valueField:'ID',
		displayField:'valor',
		lazyRender:true,
		forceSelection:true,
		grid_visible:false,
		grid_editable:false,
		width_grid:100,
		minListWidth:100,
		disable:false
	});
this.AdicionarBotonCombo(tipo_reporte,'tipo_reporte');
//	this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprime la asociación de Comprobantes y Extracto Bancario',btn_reporte_extracto_bancario,true,'btn_reporte_extracto_bancario','Asoc. Cbtes y E.B.');
//	this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprime Comprobantes que No Ingresan a la declaración',btn_reporte_comprobante,true,'btn_reporte_comprobante','Cbtes. No Ingresan');
	
	//this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprime Comprobantes que no estan asociados a partidas',btn_cbte_no_asoc_partidas,true,'imp_ejecucion','Cbtes. No Asoc a Partidas');
    //   this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprime Conciliacion Fallida ',btn_conc_fallida,true,'conciliacion_fallida','Conciliación Fallida');
      // this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprime Conciliacion Bancaria y CBTES ',btn_conc_banc_cbte,true,'conciliacion_ban_cbte','Conciliación Bancaria CBTE');
      // this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprime Conciliacion Bancaria y PARTIDAS ',btn_conc_banc_par,true,'conciliacion_ban_par','Conciliación Bancaria Partida'); 	
	//this.AdicionarBoton('../../../lib/imagenes/ok.png','Validar Si-No',btn_validar_sino,true,'','Validar Si-No');
	
	this.iniciaFormulario();
    iniciarEventosFormularios();
	layout_siet_cbte.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}