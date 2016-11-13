<?php
/**
 * Nombre:		  	    departamento_conta_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2009-01-23 11:04:02
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
var maestro={id_depto:<?php echo $id_depto;?>,codigo_depto:decodeURIComponent('<?php echo $codigo_depto;?>'),nombre_depto:decodeURIComponent('<?php echo $nombre_depto;?>')};
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_departamento_conta(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_departamento_conta.js
 * Propï¿½sito: 			pagina objeto principal
 * Autor:				avq
 * Fecha creaciï¿½n:		2009-06-17 10:40:02
 */
function pagina_departamento_conta(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var componentes=new Array();
	var data_ep;
	var dialog;
	var form;
	/////////////////
	//  DATA STORE //
	/////////////////
	// DEFINICIï¿½N DATOS DEL MAESTRO
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/depto_conta/ActionListarDepartamentoConta.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_depto_conta',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_depto_conta',
		'id_depto',
		'id_fina_regi_prog_proy_acti',
		'id_unidad_organizacional',
		'sw_central',
		'sw_estado',
		'nombre_depto',
		'desc_ep',
		'nombre_unidad',
		'id_financiador',
		'id_regional',
		'id_programa',
		'id_programa',
		'id_programa',
		'id_proyecto',
		'id_actividad',
		'nombre_financiador',
		'nombre_regional',
		'nombre_programa',
		'nombre_proyecto',
		'nombre_actividad',
		'codigo_financiador',
		'codigo_regional',
		'codigo_programa',
		'codigo_proyecto',
		'codigo_actividad',
		'id_cuenta_auxiliar',
		'desc_cta_aux',
		'sw_rendicion',
		'sw_documento',
		'id_depto_conta_central',
		'id_depto_tesoro',
		'nombre_depto_conta',
		'nombre_depto_tesoro',
		'id_presupuesto',
		'desc_presupuesto',
		'id_partida_sueldos',
		'id_cuenta_sueldos',
		'id_auxiliar_sueldos',
		'id_cuenta_auxiliar_sueldos',
		'cuenta_aux_sueldo',
		'partida_sueldo',
		'id_sucursal',
		'nombre'
		
	]),remoteSort:true});
	
	//DATA STORE COMBOS
	var ds_departamento_conta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/depto/ActionListarDepartamento.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto',totalRecords: 'TotalCount'},
		['id_depto','codigo_depto','nombre_depto','estado','id_subsistema','nombre_corto','nombre_largo']),baseParams:{m_id_subsistema:9}
	});
    var ds_departamento_tesoro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/depto/ActionListarDepartamento.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto',totalRecords: 'TotalCount'},
		['id_depto','codigo_depto','nombre_depto','estado','id_subsistema','nombre_corto','nombre_largo']),baseParams:{m_id_subsistema:12}
	});
	 var ds_cuenta_auxiliar = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/cuenta_auxiliar/ActionListarVCuentaAuxiliar.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta_auxiliar',totalRecords: 'TotalCount'},
		['id_cuenta_auxiliar','id_cuenta','cuenta','id_auxiliar','auxiliar','desc_cta_aux','id_parametro','gestion_conta']),baseParams:{sw_transaccional:1,sw_ges_vigente:'si'}
	});
    var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/presupuesto/ActionListarPresupuestoDepto.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},
		['id_presupuesto','desc_presupuesto','tipo_pres','estado_pres','id_fuente_financiamiento','nombre_fuente_financiamiento','id_unidad_organizacional','nombre_unidad','id_fina_regi_prog_proy_acti','desc_epe','nombre_financiador', 'nombre_regional', 'nombre_programa', 'nombre_proyecto', 'nombre_actividad','id_parametro','gestion_pres' ]), baseParams:{sw_reg_depto_conta:'si',m_id_depto:maestro.id_depto}});
    
    // AGREGADO EN FECHA 02 FEBRERO DE 2011 POR WILLIAMS ESCOBAR
    var ds_partida_sueldos = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/partida/ActionListarPartida.php?sw_movimiento=1'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_partida_sueldos',totalRecords: 'TotalCount'},
		['id_partida','codigo_partida','nombre_partida','desc_par','nivel_partida','sw_transaccional','tipo_partida','id_parametro','desc_parametro','id_partida_padre','tipo_memoria','desc_partida' ]),baseParams:{sw_ges_vigente:'si'}
    });
    
    var ds_cuenta_auxiliar_sueldos = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/cuenta_auxiliar/ActionListarVCuentaAuxiliar.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta_auxiliar_sueldos',totalRecords: 'TotalCount'},				
		['id_cuenta_auxiliar','id_cuenta','cuenta','id_auxiliar','auxiliar','desc_cta_aux','id_parametro','gestion_conta']),baseParams:{sw_transaccional:1,sw_ges_vigente:'si'}
	});
	
    var ds_sucursal = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/sucursal/ActionListarSucursal.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_sucursal',totalRecords: 'TotalCount'},
		['id_sucursal','nombre','razon_social','nit','direccion','proyecto','usuario_reg','fecha_reg'])
	});
    
    //FUNCIONES RENDER
    function renderCuentaAuxSueldos(value, p, record){return String.format('{0}', record.data['desc_cta_aux']);}
	var tpl_id_cuenta_auxiliar_sueldos=new Ext.Template('<div class="search-item">','<b>{desc_cta_aux}</b>','<br><FONT COLOR="#0000ff"><b>Cuenta: </b>{cuenta}</FONT>','<br><FONT COLOR="#0000ff"><b>Auxiliar: </b>{auxiliar}</FONT>','<br><FONT COLOR="#0000ff"><b>Gestion: </b>{gestion_conta}</FONT>','</div>');
    
    function renderPartidaSueldos(value,p,record){return String.format('{0}',record.data['desc_par'])}
    var tpl_id_partida_sueldo=new Ext.Template('<div class="search-item">','<b>{desc_par}</b>','<br><FONT COLOR="#0000ff"><b>{desc_parametro}</b></FONT>','</div>');
       
    function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	
	var data_maestro=[['ID Depto.',maestro.id_depto],['Codigo Depto.',maestro.codigo_depto],['Departamento',maestro.nombre_depto]];
	
	function render_id_depto_conta(value, p, record){return String.format('{0}', record.data['nombre_depto_conta']);}
	
	function render_id_depto_tesoro(value, p, record){return String.format('{0}', record.data['nombre_depto_tesoro']);}
	var tpl_id_depto=new Ext.Template('<div class="search-item">','<b>{nombre_depto}</b>','<br><FONT COLOR="#0000ff"><b>Codigo: </b>{codigo_depto}</FONT>','<br><FONT COLOR="#0000ff"><b>Subsistema: </b>{nombre_corto}</FONT>','</div>');
	
	function render_id_cuenta_auxiliar(value, p, record){return String.format('{0}', record.data['desc_cta_aux']);}
	var tpl_id_cuenta_auxiliar=new Ext.Template('<div class="search-item">','<b>{desc_cta_aux}</b>','<br><FONT COLOR="#0000ff"><b>Cuenta: </b>{cuenta}</FONT>','<br><FONT COLOR="#0000ff"><b>Auxiliar: </b>{auxiliar}</FONT>','<br><FONT COLOR="#0000ff"><b>Gestion: </b>{gestion_conta}</FONT>','</div>');
	
	function render_id_sucursal(value, p, record){return String.format('{0}', record.data['nombre']);}
	var tpl_id_sucursal=new Ext.Template('<div class="search-item">','<b>{nombre}</b>','<br><FONT COLOR="#0000ff"><b>Proyecto: </b>{proyecto}</FONT>','</div>');

	function render_id_ep(value, p, record){return String.format('{0}', record.data['desc_ep']);}
	
	function render_sw_central(value){
		if(value==1){value='Si'	}
		else{	value='No'		}
		return value
	}
	function render_sw_estado(value){
		if(value==1){value='Activo'	}
		else{	value='Inactivo'}
		return value
	}
	function render_sw_documento(value){
		if(value=='si'){value='Si'	}
		else{	value='No'}
		return value
	}
	
	function render_id_presupuesto(value, p, record){if(record.get('estado_regis')=='2'){return '<span style="color:red;font-size:8pt">' + record.data['desc_presupuesto']+ '</span>';}else {return record.data['desc_presupuesto'];}}
	var tpl_id_presupuesto=new Ext.Template('<div class="search-item">',
		'<b>Gestion: </b> <FONT COLOR="#0000ff">{gestion_pres} </FONT> ',
		'<b>   Tipo Presupuesto: </b> <FONT COLOR="#0000ff">{tipo_pres} </FONT> ',
		'<br><b></b><FONT COLOR="#0000ff">{desc_presupuesto}</FONT>',
		'<br> <b>Unidad Organizacional: </b><FONT COLOR="#0000ff">{nombre_unidad}</FONT>',
		'<br> <b>Estructura Programatica:  </b><FONT COLOR="#B5A642">{desc_epe}</FONT></b>',
		'<br>  <FONT COLOR="#B5A642">{nombre_financiador}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_regional}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_programa}</FONT>',
		'<br>  <FONT COLOR="#0000ff">{nombre_proyecto}</FONT>',
		'<br>  <FONT COLOR="#0000ff">{nombre_actividad}</FONT>',
		'</div>');
		
	 
	/////////////////////////
	// Definiciï¿½n de datos //
	/////////////////////////
	// hidden id_depto_conta
	//en la posiciï¿½n 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_depto_conta',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false
	};
	
// txt id_depto
	Atributos[1]={
		validacion:{
			name:'id_depto',
			labelSeparator:'',
			inputType:'hidden',
			grid_visible:false,
			grid_editable:false,
			disabled:true
		},
		tipo: 'Field',
		filtro_0:false,
		defecto:maestro.id_depto
	};
		
	Atributos[2]={
		validacion:{
			name:'id_presupuesto',
			fieldLabel:'Presupuesto',
			allowBlank:false,			
			emptyText:'Presupuesto...',
			desc: 'desc_presupuesto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_presupuesto,
			valueField: 'id_presupuesto',
			displayField: 'desc_presupuesto',
			queryParam: 'filterValue_0',
			filterCol:'PRESUP.desc_presupuesto',
			typeAhead:true,
			tpl:tpl_id_presupuesto,
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
			renderer:render_id_presupuesto,
			width:300,
			width_grid:250,
			grid_visible:true,
			grid_editable:false,
			grid_indice:1,
			
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
 		filterColValue:'PRE.desc_presupuesto'
	}; 
	
	Atributos[3]={
		validacion:{
			name:'id_depto_conta_central',
			fieldLabel:'Departamento Contabilidad',
			allowBlank:true,
			emptyText:'Departamento Contabilidad...',
			desc: 'nombre_depto_conta', 
			store:ds_departamento_conta,
			valueField: 'id_depto',
			displayField: 'nombre_depto',
			queryParam: 'filterValue_0',
			filterCol:'DEPTO.codigo_depto#DEPTO.nombre_depto',
			typeAhead:false,
			tpl:tpl_id_depto,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, 
			triggerAction:'all',
			editable:true,
			renderer:render_id_depto_conta,
			width:300,
			width_grid:250,
			disable:false,
			grid_visible:true,
			grid_editable:false,
			grid_indice:2	
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'DEPTO.codigo_depto#DEPTO.nombre_depto',
		save_as:'id_depto_conta_central',
	 };
	 
	Atributos[4]={
		validacion:{
			name:'id_depto_tesoro',
			fieldLabel:'Departamento Tesoreria',
			allowBlank:true,
			emptyText:'Departamento Tesoreria...',
			desc: 'nombre_depto_tesoro', 
			store:ds_departamento_tesoro,
			valueField: 'id_depto',
			displayField: 'nombre_depto',
			queryParam: 'filterValue_0',
			filterCol:'DEPTO.codigo_depto#DEPTO.nombre_depto',
			typeAhead:false,
			tpl:tpl_id_depto,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, 
			triggerAction:'all',
			editable:true,
			renderer:render_id_depto_tesoro,
			width:300,
			width_grid:250,
			disable:false,
			grid_visible:true,
			grid_editable:false,
			grid_indice:3	
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'DEPTO.codigo_depto#DEPTO.nombre_depto',
		save_as:'id_depto_tesoro',
	};	 
	
	Atributos[5]={
		validacion:{
			name:'id_cuenta_auxiliar',
			fieldLabel:'Cuenta Auxiliar',
			allowBlank:false,			
			emptyText:'Cuenta Auxiliar...',
			desc: 'desc_cta_aux', 
			store:ds_cuenta_auxiliar,
			valueField: 'id_cuenta_auxiliar',
			displayField: 'desc_cta_aux',
			queryParam: 'filterValue_0',
			filterCol:'VCUAUX.desc_cta_aux#tparam.gestion_conta',
			typeAhead:false,
			tpl:tpl_id_cuenta_auxiliar,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, 
			triggerAction:'all',
			editable:true,
			renderer:render_id_cuenta_auxiliar,
			width:300,
			width_grid:250,
			disabled:false,
			grid_visible:true,
			grid_editable:false,
			grid_indice:4	
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'VCTAUX.desc_cta_aux',
		save_as:'id_cuenta_auxiliar',
	};

	// txt estado
	Atributos[6]= {
		validacion:{
			name:'sw_central',
			fieldLabel:'Es Central',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','Si - Depto Central'],['no','No - Depto Central']]}),
	        valueField:'ID',
	        displayField:'valor',
	     //   renderer:render_sw_central,
	        lazyRender:true,
	        mode:'remote',
	        forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width:150,
			width_grid:100,
			grid_indice:6
		},
		tipo: 'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:' depcon.sw_central',
		save_as:'sw_central'
	};
	
	Atributos[7]= {
		validacion:{
			name:'sw_estado',
			fieldLabel:'SW Estado',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['activo','Activo'],['inactivo','Inactivo']]}),
	        valueField:'ID',
	        displayField:'valor',
	 
	        lazyRender:true,
	        mode:'remote',
	        forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width:150,
			width_grid:100,
			grid_indice:5
		},
		tipo: 'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:' depcon.sw_estado',
		save_as:'sw_estado'
	};
	
	Atributos[8]= {
		validacion:{
			name:'sw_rendicion',
			fieldLabel:'Genera 1 Cbte.',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','Si - Genera 1 Cbte.'],['no','No - Genera 2 Cbtes.']]}),
	        valueField:'ID',
	        displayField:'valor',
	        lazyRender:true,
	        forceSelection:true,
			grid_visible:true,
			grid_editable:true,
			width:150,
			mode:'remote',
			width_grid:100,
			grid_indice:7
		},
		tipo: 'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:' depcon.sw_rendicion',
		save_as:'sw_rendicion'
	};
	
	Atributos[9]= {
		validacion:{
			name:'sw_documento',
			fieldLabel:'IVA en Depto.',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['si','Si - IVA en Depto.'],['no','No - IVA en Central']]}),
	        valueField:'ID',
	        displayField:'valor',
	        lazyRender:true,
	        forceSelection:true,
			grid_visible:true,
			mode:'remote',
			grid_editable:true,
			width:150,
			width_grid:100,
			grid_indice:8
		},
		tipo: 'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'depcon.sw_documento',
		save_as:'sw_documento'
	}; 
	
	Atributos[10]={
		validacion:{
			name:'id_cuenta_auxiliar_sueldos',
			fieldLabel:'Cuenta Sueldos',
			allowBlank:true,			
			emptyText:'Cuenta de Sueldos...',
			desc: 'cuenta_aux_sueldo', 
			store:ds_cuenta_auxiliar_sueldos,
			valueField: 'id_cuenta_auxiliar',
			displayField: 'desc_cta_aux',
			queryParam: 'filterValue_0',
			filterCol:'VCUAUX.desc_cta_aux#tparam.gestion_conta',
			typeAhead:false,
			tpl:tpl_id_cuenta_auxiliar_sueldos,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, 
			triggerAction:'all',
			editable:true,
			renderer:renderCuentaAuxSueldos,
			width:300,
			width_grid:250,
			disabled:false,
			grid_visible:false,
			grid_editable:false
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:false,				
		save_as:'id_cuenta_auxiliar_sueldos',
	};
		
	Atributos[11]={
		validacion:{
			name:'id_partida_sueldos',
			fieldLabel:'Partida Sueldos',
			allowBlank:true,			
			emptyText:'Partida...',
			desc: 'partida_sueldo', 
			store:ds_partida_sueldos,
			valueField: 'id_partida',
			displayField: 'desc_par',
			queryParam: 'filterValue_0',
			filterCol:'PARTID.nombre_partida#partid.codigo_partida',
			typeAhead:false,
			tpl:tpl_id_partida_sueldo,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, 
			triggerAction:'all',
			editable:true,
			renderer:renderPartidaSueldos,
			width:300,
			width_grid:250,
			disabled:false,
			grid_visible:false,
			grid_editable:false
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'parti.codigo_partida#parti.nombre_partida',
		save_as:'id_partida_sueldos',
	};
	
	Atributos[12]={
		validacion:{
			labelSeparator:'',
			name: 'cuenta_aux_sueldo',
			fieldLabel:'Cuenta Sueldos',
			inputType:'hidden',
			width:250,
			width_grid:250,
			grid_visible:true, 
			grid_editable:false,
			grid_indice:9
		},
		tipo: 'TextField',
		form:false,
		filtro_0:true,
		filterColValue:'vcaux2.desc_cta_aux'
		
	};
			
	Atributos[13]={
		validacion:{
			labelSeparator:'',
			name: 'partida_sueldo',
			fieldLabel:'Partida Sueldos',
			inputType:'hidden',
			width:250,
			width_grid:250,
			grid_visible:true, 
			grid_editable:false,
			grid_indice:10
		},
		tipo: 'TextField',
		form:false,
		filtro_0:false				
	};
	
	Atributos[14]={
		validacion:{
			name:'id_sucursal',
			fieldLabel:'Sucursal',
			allowBlank:false,			
			emptyText:'Sucursal ...',
			desc: 'nombre', 
			store:ds_sucursal,
			valueField: 'id_sucursal',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'SUCURS.nombre, SUCURS.proyecto',
			typeAhead:false,
			tpl:tpl_id_sucursal,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, 
			triggerAction:'all',
			editable:true,
			renderer:render_id_sucursal,
			width:300,
			width_grid:250,
			disabled:false,
			grid_visible:true,
			grid_editable:false,
			grid_indice:11	
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'SUCURS.nombre',
		save_as:'id_sucursal',
	};
	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Departamentos (Maestro)',titulo_detalle:'departamento_conta (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_departamento_conta = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_departamento_conta.init(config);
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_departamento_conta,idContenedor);
	
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getFormulario=this.getFormulario;
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	var ClaseMadre_getComponente=this.getComponente;
	
	//DEFINICIï¿½N DE LA BARRA DE MENï¿½
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};

	//DEFINICIï¿½N DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/depto_conta/ActionEliminarDepartamentoConta.php',parametros:'&id_depto='+maestro.id_depto},
		Save:{url:direccion+'../../../control/depto_conta/ActionGuardarDepartamentoConta.php',parametros:'&id_depto='+maestro.id_depto},
		ConfirmSave:{url:direccion+'../../../control/depto_conta/ActionGuardarDepartamentoConta.php',parametros:'&id_depto='+maestro.id_depto},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:430,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'departamento_conta'}
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		//para iniciar eventos en el formulario
		for(var i=0; i<Atributos.length; i++){
			componentes[i]=ClaseMadre_getComponente(Atributos[i].validacion.name)
		}
		
		componentes[2].on('select',evento_ppto);
		componentes[2].on('change',evento_ppto);
	}
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		//Ext.apply(maestro,Ext.urlDecode(decodeURIComponent(params)));
		var datos=Ext.urlDecode(decodeURIComponent(params));
			maestro.id_depto=datos.id_depto;
			maestro.codigo_depto=datos.codigo_depto;
			maestro.nombre_depto=datos.nombre_depto;
    	
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				id_depto:maestro.id_depto
			}
		}; 
		
	 	this.btnActualizar();
		data_maestro=[['ID Depto.',maestro.id_depto],['Codigo Depto.',maestro.codigo_depto],['Departamento',maestro.nombre_depto]];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		Atributos[1].defecto=maestro.id_depto;
		var_id_presupuesto.store.baseParams={sw_reg_depto_conta:'si',m_id_depto:maestro.id_depto};
		
		paramFunciones.btnEliminar.parametros='&id_depto='+maestro.id_depto;
		paramFunciones.Save.parametros='&id_depto='+maestro.id_depto;
		paramFunciones.ConfirmSave.parametros='&id_depto='+maestro.id_depto;
		this.InitFunciones(paramFunciones)
	};
	
	function InitDeptoConta(){
		grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		
		sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();
 		var_id_presupuesto=ClaseMadre_getComponente('id_presupuesto');
	};
	
	function btn_cierreapertura(){
		 var sm=getSelectionModel();
		 var filas=ds.getModifiedRecords();
		 var cont=filas.length;
		 var NumSelect=sm.getCount();
		 var SelectionsRecord=sm.getSelected();
		
		 if(NumSelect!=0&&SelectionsRecord.data.id_transaccion!=0){
			var data='&m_id_depto='+maestro.id_depto;
			data=data+'&m_codigo_depto='+maestro.codigo_depto;
			data=data+'&m_nombre_depto='+maestro.nombre_depto;
			data=data+'&m_id_depto_conta='+SelectionsRecord.data.id_depto_conta;
			//data=data+'&m_id_depto_conta='+'id_depto_conta';
				 
			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			layout_departamento_conta.loadWindows(direccion+'../../../../sis_contabilidad/vista/cierre_apertura/cierre_apertura.php?'+data,'Documentos',ParamVentana);			
			sm.clearSelections();
		}
		else{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item ya registrado');
		}
	}	 
	
	function evento_ppto(combo, record, index ){
		var g_gestion = record.data.gestion_pres;
		
		ds_cuenta_auxiliar.baseParams={sw_transaccional:1,m_gestion:g_gestion};	
		ds_cuenta_auxiliar_sueldos.baseParams={sw_transaccional:1,m_gestion:g_gestion};	
		ds_partida_sueldos.baseParams={m_gestion:g_gestion};	
 	}
	
	//para que los hijos puedan ajustarse al tamaï¿½o
	this.getLayout=function(){return layout_departamento_conta.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			id_depto:maestro.id_depto
		}
	});
	//para agregar botones
	this.iniciaFormulario();
	iniciarEventosFormularios();
	InitDeptoConta();
	this.AdicionarBoton('../../../lib/imagenes/a_table_gear.png','Cierre/Apertura',btn_cierreapertura,true,'departamentoConta','');
 	layout_departamento_conta.getLayout().addListener('layout',this.onResize);
	layout_departamento_conta.getVentana(idContenedor).on('resize',function(){layout_departamento_conta.getLayout().layout()})
}