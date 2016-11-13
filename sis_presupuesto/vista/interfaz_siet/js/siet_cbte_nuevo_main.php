<?php
/**
 * Nombre:		  	    siet_cbte_nuevo_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-06 20:48:42
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
var maestro={
	     id_siet_declara:<?php echo $id_siet_declara;?>,
	     id_gestion:<?php echo $id_gestion;?>,
         tipo_declara:'<?php echo $tipo_declara;?>'};

idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_siet_cbte_nuevo(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
//ContenedorPrincipal.getPagina(idContenedorPadre).pagina.setPagina(elemento);
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_siet_cbte_nuevo.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-06 20:48:43
 */
function pagina_siet_cbte_nuevo(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();  
	var componentes=new Array();
	var sw=0;
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
  				allowNegative:false,
  				minValue:0}
  				);
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/interfaz_siet/ActionListarSietCbteNuevo.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_siet_cbte_nuevo',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_comprobante',
		'nro_cbte',
		'fecha_salida_cb',
		'concepto_cbte',
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
              'id_cuenta_doc'
		
	]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
		    m_id_siet_declara:maestro.id_siet_declara
		}
	});
	/* var ds_nuevo = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/nuevo/ActionListarnuevo.php?sw_vista_reporte=rep_ejecucion_nuevo&id_tipo_pres='+tipo_declara+'&id_parametro='+maestro.id_parametro}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_nuevo',totalRecords:'TotalCount'},['id_nuevo','codigo_nuevo','nombre_nuevo','tipo_nuevo'])
			//baseParams:{sw_vista_reporte:'rep_ejecucion_nuevo',sid_tipo_pres:'2',$id_parametro:maestro.id_parametro}
	});
	
	 var ds_oec = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/oec/ActionListarOec.php?id_parametro='+maestro.id_parametro}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_oec',totalRecords:'TotalCount'},['id_oec','codigo_oec','nombre_oec','desc_oec'])
			//baseParams:{sw_vista_reporte:'rep_ejecucion_nuevo',sid_tipo_pres:'2',$id_parametro:maestro.id_parametro}
	});

	 var ds_entidad_transf = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/interfaz_siet/ActionListarEntidadTransf.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_siet_ent_ua_transf',totalRecords:'TotalCount'},['id_siet_ent_ua_transf','id_siet_entidad_transf','codigo','denominacion','sigla','codigo_ua','denominacion_ua','sigla_ua'])
			//baseParams:{sw_vista_reporte:'rep_ejecucion_nuevo',sid_tipo_pres:'2',$id_parametro:maestro.id_parametro}
	});*/

	var ds_cuenta_bancaria = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_tesoreria/control/cuenta_bancaria/ActionListarCuentaBancaria.php?id_gestion='+maestro.id_gestion+'&tipo_vista=extracto_bancario'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta_bancaria',totalRecords: 'TotalCount'},
		['id_cuenta_bancaria','id_institucion','desc_institucion'
		,'id_cuenta','desc_cuenta','id_auxiliar'
		,'desc_auxiliar','nro_cheque','estado_cuenta'
		,'nro_cuenta_banco','id_moneda','nombre_moneda','gestion'
		]),baseParams:{m_vista_cheque:'registro_cheque_conta'}});
  function render_id_cuenta_bancaria(value, p, record){return String.format('{0}', record.data['nro_cuenta_banco']);}
	var tpl_id_cuenta_bancaria=new Ext.Template('<div class="search-item">'
		,'<b>Cuenta: </b><FONT COLOR="#B5A642">{nro_cuenta_banco}</FONT><br>',
		'<b>Banco: </b><FONT COLOR="#B5A642">{desc_institucion}</FONT><br>',
		'<b>Auxiliar: </b><FONT COLOR="#B5A642">{desc_auxiliar}</FONT><br>',
		'<b>Gestión: </b><FONT COLOR="#B5A642">{gestion}</FONT>','</div>');
	
	

	
	//FUNCIONES RENDER
	 function renderSeparadorDeMil(value,cell,record,row,colum,store)
		{
			return monedas_for.formatMoneda(value)
		}
		
	function render_id_nuevo(value, p, record){return String.format('{0}', record.data['desc_nuevo']);}
	var tpl_id_nuevo=new Ext.Template('<div class="search-item">','<b><i>{codigo_nuevo}</i></b>','<br><FONT COLOR="#B5A642">{nombre_nuevo}:{tipo_nuevo}</FONT>','</div>');

	function render_id_siet_entidad_transf(value, p, record){return String.format('{0}', record.data['codigo']);}
	var tpl_id_siet_entidad_transf=new Ext.Template('<div class="search-item">','<b><i>Entidad Transferencia: {codigo}-{denominacion}</i></b>','<br><FONT COLOR="#B5A642">Unidad Administrativa: {codigo_ua}-{denominacion_ua}</FONT>','</div>');
	
	function render_id_oec(value, p, record){return String.format('{0}', record.data['desc_oec']);}
	var tpl_id_oec=new Ext.Template('<div class="search-item">','<b><i>{codigo_oec}</i></b>','<br><FONT COLOR="#B5A642">{desc_oec}</FONT>','</div>');
	
	// DEFINICIÓN DATOS DEL MAESTRO
	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Cbte',maestro.id_siet_cbte]]}),cm:cmMaestro});
	gridMaestro.render();
	/////////////////////////
	// Definición de datos //
	/////////////////////////
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
				defecto:maestro.id_siet_declara,
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
					name:'tipo',
					fieldLabel:'Tipo',
					
					allowBlank:true,
					maxLength:20,
					minLength:0,
					width:'55%',
		            typeAhead:true,
					loadMask:true,
		 				triggerAction:'all',
					store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['normal','Normal'],['fondo_avance','Fondo Avance']]}),
					valueField:'ID',
					displayField:'valor',
					lazyRender:true,
					forceSelection:true,
				
					grid_visible:false,
					grid_editable:false,
					disabled:false,
					width_grid:70
							
				},
				form:true,	
				tipo: 'ComboBox',
				id_grupo:0
				
			};	
		vectorAtributos[4]= {
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
					disabled:false,
					width_grid:50,
							
				},
				form:false,	
				tipo: 'TextField',
				filtro_0:true,
				filterColValue:'sc.nro_cbte',
				save_as:'txt_nro_cbte',
				id_grupo:0
			};
		
		vectorAtributos[5]= {
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
		vectorAtributos[6]= {
				validacion:{
					name:'concepto_cbte',
					fieldLabel:'Comprobante Concepto',
					desc: 'concepto_cbte',
					displayField: 'concepto_cbte',
					filterCol:'cbte.concepto_cbte',
					
					allowBlank:false,
					maxLength:500,
					minLength:0,
					selectOnFocus:true,
					vtype:'texto',
					width:'55%',
					grid_visible:true,
					grid_editable:false,
					disabled:false,
					width_grid:450,
							
				},
				form:true,	
				tipo: 'TextField',
				filtro_0:true,
				filterColValue:'cbte.concepto_cbte',
				save_as:'concepto_cbte',
				id_grupo:0
			};
	    vectorAtributos[7]= {
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
		
		
		vectorAtributos[8]={
				validacion:{
					labelSeparator:'',
					name: 'id_gestion',
					inputType:'hidden',
					grid_visible:false, 
					grid_editable:false
				},
				tipo: 'Field',
				filtro_0:false,
				save_as:'id_gestion'
			};	
		vectorAtributos[9]={
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
	      vectorAtributos[10]= {
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
		
	vectorAtributos[11]={
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
	vectorAtributos[12]={
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
	vectorAtributos[13]={
			validacion:{
			name:'id_cuenta_bancaria',
			fieldLabel:'Cuenta Bancaria',
			allowBlank:false,			
			emptyText:'Cuenta Bancaria...',
			desc: 'nro_cuenta_banco', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_cuenta_bancaria,
			valueField: 'id_cuenta_bancaria',
			displayField: 'nro_cuenta_banco',
			queryParam: 'filterValue_0',
			filterCol:'CUENTA.nro_cuenta#CUENTA.descripcion#CUEBAN.nro_cuenta_banco#INSTIT.nombre',
			typeAhead:false,
			tpl:tpl_id_cuenta_bancaria,
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
			editable:true,
			renderer:render_id_cuenta_bancaria,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'CUENTA_8.nro_cuenta#CUENTA_8.descripcion##CUEBAN_8.nro_cuenta_banco',
		save_as:'id_cuenta_bancaria',
		id_grupo:0
	};	
	/*vectorAtributos[12]={
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
			};*/
	vectorAtributos[14]= {
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
	vectorAtributos[15]={
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
	 vectorAtributos[16]= {
				validacion:{
					name:'id_siet_cbte',
					fieldLabel:'ID SIET CBTE',
					desc: 'id_siet_cbte',
					displayField: 'id_siet_cbte',
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
				filterColValue:'id_siet_cbte',
				
				id_grupo:0
			};

	vectorAtributos[17]= {
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
	vectorAtributos[18]= {
			validacion:{
				name:'importe',
				fieldLabel:'Importe',
				allowBlank:false,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision :2,//para numeros float
				allowNegative: true,
				//minValue:0,
				vtype:'texto',
				grid_visible:true,
				align:'right',
				renderer: renderSeparadorDeMil,
				grid_editable:true,
				width_grid:100,
				width:'80%'
			},
			form:true,	
			tipo: 'NumberField',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'importe',
			save_as:'importe',
			id_grupo:0
		};

	vectorAtributos[19]= {
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
	vectorAtributos[20]= {
			validacion:{
				name:'estado',
				fieldLabel:'Estado',
				desc: 'estado',
				displayField: 'estado',
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['solicitud','solicitud'],['rendicion','rendicion'],['devolucion','devolucion']]}),
				valueField:'ID',
				displayField:'valor',
				lazyRender:true,
				forceSelection:true,
				allowBlank:true,
				maxLength:10,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				width:'55%',
				grid_visible:true,
				grid_editable:false,
				disabled:false,
				width_grid:70,
				valign:'right'
						
			},
			form:true,	
			tipo: 'ComboBox',
			filtro_0:true,
			filterColValue:'sc.estado',
		       id_grupo:1
		};
	vectorAtributos[21]= {
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

	vectorAtributos[22]= {
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

		
	vectorAtributos[23]= {
			validacion:{
				name:'id_cuenta_doc',
				fieldLabel:'FA id_cuenta_doc',
				desc: 'id_cuenta_doc',
				displayField: 'id_cuenta_doc',
				allowBlank:true,
				maxLength:10,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				width:'55%',
				grid_visible:true,
				grid_editable:false,
				disabled:false,
				width_grid:50,
					   	
			},
			form:true,	
			tipo: 'TextField',
			filtro_0:true,
			filterColValue:'sc.id_cuenta_doc',
			save_as:'id_cuenta_doc',
			id_grupo:1
		};	
	
/*	vectorAtributos[24]= {
			validacion:{
				name:'estado',
				fieldLabel:'Estado',
				desc: 'estado',
				displayField: 'estado',
				
				allowBlank:false,
				maxLength:10,
				minLength:0,
				width:'55%',
	            typeAhead:true,
				loadMask:true,
	 				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['solicitud','solicitud'],['rendicion','rendicion'],['devolucion','devolucion']]}),
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
			filterColValue:'sc.estado',
			save_as:'estado',
			id_grupo:0
			
		};	*/
		
	//----------- FUNCIONES RENDER
	
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : ''
	};

	//---------- INICIAMOS LAYOUT DETALLE
	
	var config={
		titulo_maestro:'Cbte (Maestro)',
		titulo_detalle:'nuevos(Detalle)',
		grid_maestro:'grid-'+idContenedor
	};
	layout_siet_cbte_nuevo = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_siet_cbte_nuevo.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_siet_cbte_nuevo,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var ClaseMadre_btnEdit=this.btnEdit; 
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;

	//-------- DEFINICIÓN DE LA BARRA DE MENÚ
	

	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	
	//--------- DEFINICIÓN DE FUNCIONES
	//datos necesarios para el filtro
	var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/interfaz_siet/ActionEliminarSietCbte.php'},
			Save:{url:direccion+'../../../control/interfaz_siet/ActionGuardarSietCbteNuevo.php'},
			ConfirmSave:{url:direccion+'../../../control/interfaz_siet/ActionGuardarSietCbteNuevo.php'},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Detalle de nuevos',
		
			grupos:[{
				tituloGrupo:'Datos',
				columna:0,
				id_grupo:0
			},{
				tituloGrupo:'Fondos en Avance',
				columna:0,
				id_grupo:1
			}]
		}
	};
	
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		//maestro.id_siet_cbte=datos.m_id_siet_cbte;
		maestro.id_siet_declara=datos.m_id_siet_declara;
		//maestro.tipo_declara=datos.m_tipo_declara;
	
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_siet_declara:maestro.id_siet_declara
			}
		});
		//alert (datos.m_id_siet_declara);
		gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['Cbte',maestro.id_siet_cbte]]);
		vectorAtributos[1].defecto=maestro.id_siet_declara;
		var paramFunciones={
				btnEliminar:{url:direccion+'../../../control/interfaz_siet/ActionEliminarSietCbte.php'},
				Save:{url:direccion+'../../../control/interfaz_siet/ActionGuardarSietCbteNuevo.php'},
				ConfirmSave:{url:direccion+'../../../control/interfaz_siet/ActionGuardarSietCbteNuevo.php'},
				Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Detalle de nuevos',
				
				grupos:[{
							tituloGrupo:'Datos',
							columna:0,
							id_grupo:0
						},{
							tituloGrupo:'Fondos en Avance',
							columna:0,
							id_grupo:1
						}]
				
				}};
		this.InitFunciones(paramFunciones)
	};


	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	
	
		
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		
	//para iniciar eventos en el formulario
		tipo = ClaseMadre_getComponente('tipo');	
		CM_ocultarGrupo('Fondos en Avance');
	for(i=0;i<vectorAtributos.length;i++)
		{
			
		  componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name);
			
		}
		sm=getSelectionModel();
		ClaseMadre_getComponente('tipo').on('select',evento_tipo);		//parametro		
		
   	}

	function evento_tipo( combo, record, index )
	{    //alert (record.data.ID);
		if (record.data.ID=='normal'){
			
			CM_ocultarGrupo('Fondos en Avance');
		
		
		}else{
			CM_mostrarGrupo('Fondos en Avance');
			
		
		}
		
	}	
	
	

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_siet_cbte_nuevo.getLayout();
	};



	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i];
			}
		}
	};
	
	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_siet_cbte_nuevo.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);

	
	
}