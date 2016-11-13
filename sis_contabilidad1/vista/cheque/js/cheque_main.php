<?php 
/**
 * Nombre:		  	    cheque_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-10-17 11:24:35
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
//var paramConfig={TiempoEspera:10000};
var maestro={
	id_transaccion:'<?php echo utf8_decode($m_id_transaccion);?>',
	desc_comprobante:'<?php echo utf8_decode($m_desc_comprobante);?>',
	concepto_tran:'<?php echo utf8_decode($m_concepto_tran);?>',
	desc_cuenta:'<?php echo utf8_decode($m_desc_cuenta);?>',
	desc_auxiliar:'<?php echo utf8_decode($m_desc_auxiliar);?>',
	desc_partida:'<?php echo utf8_decode($m_desc_partida);?>',
	id_moneda:'<?php echo utf8_decode($m_id_moneda);?>',
	id_cuenta:'<?php echo utf8_decode($m_id_cuenta);?>',
	id_auxiliar:'<?php echo utf8_decode($m_id_auxiliar);?>',
	desc_moneda:'<?php echo utf8_decode($m_desc_moneda);?>',
	tipo_plantilla:'<?php echo utf8_decode($m_tipo_plantilla);?>',
	desc_plantilla:'<?php echo utf8_decode($m_desc_plantilla);?>',
	importe_debe:'<?php echo utf8_decode($m_importe_debe);?>',
	importe_haber:'<?php echo utf8_decode($m_importe_haber);?>',
	fecha_trans:'<?php echo utf8_decode($m_fecha_trans);?>'

};
idContenedorPadre='<?php echo $idContenedorPadre;?>';             
//alert(idContenedorPadre);
var elemento={pagina:new pagina_cheque(idContenedor,direccion,paramConfig,maestro,idContenedorPadre),idContenedor:idContenedor};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

function pagina_cheque(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var Atributos=new Array,sw=0;
	var componentes=new Array();
	var var_id_cuenta_bancaria='';
	var var_tipo_cheque='';
	var var_nro_deposito='';
	var var_nro_cheque='';
	var var_nro_transaccion='';
	
	var var_id_transaccion='';
	var var_fecha_cheque='';
	var var_id_moneda='';
	var var_id_tipo_cambio='';
	var var_tipo_cambio='';
	//console.log(maestro);	 
	
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cheque/ActionListarCheque.php'}),
		reader: new Ext.data.XmlReader({
		record: 'ROWS',id:'id_cheque',totalRecords:'TotalCount'
		},['id_cheque',
		'id_transaccion',
		'id_moneda',
		'desc_transaccion',
		'nro_cheque',
		'nro_deposito',
		{name: 'fecha_cheque',type:'date',dateFormat:'Y-m-d'},
		'nombre_cheque',
		'id_cuenta_bancaria',
		'nro_cuenta_cuenta',
		'descripcion_cuenta',
		'nro_cuenta_banco_cuenta_bancaria',
		'nro_cuenta_banco',
		'nro_transaccion',
		'nombre_moneda',
		'tipo_cheque',
		'importe_cheque',
		'id_tipo_cambio',
		'tipo_cambio',
		'estado_cheque'
		]),remoteSort:true});

	//DATA STORE COMBOS

    var ds_transaccion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/transaccion/ActionListarTransaccion.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_transaccion',totalRecords: 'TotalCount'},['id_transaccion','id_comprobante','id_fuente_financiamiento','id_unidad_organizacional','id_cuenta','id_partida','id_auxiliar','id_orden_trabajo','id_oec','concepto_tran','id_fina_regi_prog_proy_acti'])
	});

    var ds_cuenta_bancaria = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_tesoreria/control/cuenta_bancaria/ActionListarCuentaBancaria.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta_bancaria',totalRecords: 'TotalCount'},
			['id_cuenta_bancaria','id_institucion','desc_institucion'
			,'id_cuenta','desc_cuenta','id_auxiliar'
			,'desc_auxiliar','nro_cheque','estado_cuenta'
			,'nro_cuenta_banco','id_moneda','nombre_moneda','gestion'
			]),baseParams:{m_vista_cheque:'registro_cheque_conta',m_id_cuenta:maestro.id_cuenta,m_id_auxiliar:maestro.id_auxiliar}});
	
    var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),baseParams:{sw_reg_comp:'si'}});
	
    var ds_tipo_cambioOCV = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/tipo_cambio/ActionListarTipoCambioOCV.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_tipo_cambio',totalRecords: 'TotalCount'},['id_tipo_cambio',{name: 'tc_origen', type: 'string'},{name: 'fecha', type: 'date', dateFormat: 'Y-m-d'},'tipo_cambio','id_moneda','desc_tc','des_moneda'])}); 
	
    //FUNCIONES RENDER
	function render_id_tipo_cambioOCV(value, p, record){rf = ds_tipo_cambioOCV.getById(value);	 
		if(rf!=null){record.data['id_tipo_cambio'] =rf.data['id_tipo_cambio'];record.data['desc_tc'] =rf.data['tipo_cambio'];}
		return String.format('{0}',record.data['desc_tc'])}
	var tpl_id_tipo_cambioOCV=new Ext.Template('<div class="search-item">','<b><i>{desc_tc}</i></b>', '</div>');	
	
	function render_id_moneda(value, p, record){return String.format('{0}', record.data['nombre_moneda']);}
	var tpl_id_moneda_reg=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
	
	function render_id_transaccion(value, p, record){return String.format('{0}', record.data['desc_transaccion']);}
	var tpl_id_transaccion=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{}</FONT><br>','</div>');
	
	function render_id_cuenta_bancaria(value, p, record){return String.format('{0}', record.data['nro_cuenta_banco']);}
	var tpl_id_cuenta_bancaria=new Ext.Template('<div class="search-item">'
		,'<b>Cuenta: </b><FONT COLOR="#B5A642">{nro_cuenta_banco}</FONT><br>',
		'<b>Banco: </b><FONT COLOR="#B5A642">{desc_institucion}</FONT><br>',
		'<b>Auxiliar: </b><FONT COLOR="#B5A642">{desc_auxiliar}</FONT><br>',
		'<b>Gestión: </b><FONT COLOR="#B5A642">{gestion}</FONT>','</div>');

	function render_tipo_cheque(value, p, record)
	{	if(value=='transferencia'){return 'Transferencia';}
		if(value=='cheque'){return 'Cheque';}
		if(value=='deposito'){return 'deposito';}		
	}
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	function render_estado_cheque(value){
		if(value==0){value='Borrador'}
		if(value==1){value='Transitorio'}
		if(value==2){value='Efectivamente Cobrado'}
		if(value==3){value='Ingresos'}
		if(value==4){value='Impreso'}
		if(value==5){value='Anulado'}
		return value
	}

	function render_tipo_cheque(value, p, record)
	{	if(value=='transferencia'){return 'Transferencia';}
		if(value=='cheque'){return 'Cheque';}
		if(value=='deposito'){return 'deposito';}		
	}
	// hidden id_cheque
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_cheque',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_cheque'
	};
	Atributos[1]={
		validacion:{
			labelSeparator:'',
			name: 'id_transaccion',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_transaccion'
	};
// txt id_cuenta_bancaria
	Atributos[2]={
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
		save_as:'id_cuenta_bancaria'
	};	

	// txt_tipo_movi9miento
	Atributos[3]={
		validacion:{
			name:'tipo_cheque',
			fieldLabel:'Tipo Transacción',
			allowBlank:false,
			align:'left', 
			emptyText:'Tranmsac...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['transferencia','Transferencia'],['cheque','Cheque'],['deposito','Deposito']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,			
			forceSelection:true,
			grid_visible:true,
			renderer:render_tipo_cheque,
			grid_editable:false,
			width_grid:200,
			minListWidth:200,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		save_as:'tipo_cheque'
	};

	// txt nro_cheque
	Atributos[4]={
		validacion:{
			name:'nro_cheque',			
			fieldLabel:'No de Cheque',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false,
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:true,
		filterColValue:'CHEQUE.nro_cheque',
		save_as:'nro_cheque'
	}; 

	// txt nro_deposito
	Atributos[5]={
		validacion:{
			name:'nro_deposito',	 
			fieldLabel:'No de Deposito',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'CHEQUE.nro_deposito',
		save_as:'nro_deposito'
	};
	
	// txt nro_deposito
	Atributos[6]={
		validacion:{
			name:'nro_transaccion',
			fieldLabel:'No de Transferencia',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'CHEQUE.nro_deposito',
		save_as:'nro_transaccion'
	};
	
	// txt fecha_cheque
	Atributos[7]= {
		validacion:{
			name:'fecha_cheque',
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
		form:true,
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'CHEQUE.fecha_cheque',
		dateFormat:'m-d-Y',
		defecto:maestro.fecha_trans,
		save_as:'fecha_cheque'
	};
	 
	Atributos[8]={
		validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:true,			
			emptyText:'Moneda...',
			desc: 'nombre_moneda', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_moneda,
			valueField: 'id_moneda',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'MONEDA.nombre',
			typeAhead:false,
			tpl:tpl_id_moneda_reg,
			forceSelection:true,
			mode:'remote',
			queryDelay:200,
			pageSize:10,
			minListWidth:200,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:200,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		defecto:maestro.id_moneda,
		filterColValue:'monedacbte.nombre',
		save_as:'id_moneda'
	};
		

	 Atributos[9]={
		validacion:{
			name:'id_tipo_cambio',
			fieldLabel:'T/C Origén',
			allowBlank:true,			
			emptyText:'T/C...',
			desc: 'desc_tc', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_tipo_cambioOCV,
			valueField: 'tc_origen',
			displayField: 'desc_tc',
			queryParam: 'filterValue_0',
			//filterCol:'MONEDA.nombre',
			typeAhead:false,
			tpl:tpl_id_tipo_cambioOCV,
			forceSelection:true,
			mode:'remote',
			queryDelay:200,
			pageSize:10,
			minListWidth:350,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_tipo_cambioOCV,
			grid_visible:false,
			grid_editable:true,
			width_grid:150,
			width:200,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
	 	filtro_0:false	
	};
	
	 Atributos[10]={
		validacion:{
			name:'tipo_cambio',
			fieldLabel:'Tipo Cambio',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:10,//para numeros float
			allowNegative:false,
			allowMil:true,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			//renderer:render_moneda_16,
			width_grid:100,
			width:100,
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
 		filtro_0:true,
		filterColValue:'COMPRO.tipo_cambio',
		save_as:'tipo_cambio'
	};

	 // txt nombre_cheque
	Atributos[11]={
		validacion:{
			name:'nombre_cheque',
			fieldLabel:'Nombre',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'CHEQUE.nombre_cheque',
		save_as:'nombre_cheque'
	}; 
 
	Atributos[12]={
		validacion:{
			name:'importe_cheque',
			fieldLabel:'Importe Cheque',
			allowBlank:true,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'100%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		defecto: eval(maestro.importe_debe)+eval(maestro.importe_haber),
		filtro_0:true,
		filterColValue:'CHEQUE.importe_cheque',
		save_as:'importe_cheque'
	};
	 
	
 	Atributos[13]={
		validacion:{
			name:'estado_cheque',
			fieldLabel:'Estado Cheque',
			allowBlank:false,
			align:'left', 
			emptyText:'Estado...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['5','Anular'],['0','Borrador']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,			
			forceSelection:true,
			grid_visible:true,
			renderer:render_estado_cheque,
			grid_editable:false,
			width_grid:60,
			minListWidth:60,
			disabled:false,
			grid_indice:11	,
			width:230
		},
		tipo:'ComboBox',
		form: true,
		defecto:0,
		filtro_0:true,
		save_as:'estado_cheque'
	};

	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	
	var data_maestro=[['Comprobante ',maestro.desc_comprobante],['Transacción ',maestro.concepto_tran],
	                  ['Cuenta - Partida ',maestro.desc_cuenta],['Auxiliar ',maestro.desc_auxiliar]];
	
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Transsacion (Maestro)',titulo_detalle:'Registro Cheque (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_cheque=new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_cheque.init(config);
	
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	
	this.pagina=Pagina;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,ds,layout_cheque,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_btnNew =this.btnNew;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente= this.mostrarComponente;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getFormulario=this.getFormulario;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_getComponenteGrid=this.getComponenteGrid;
	var ClaseMadre_save=this.Save;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_conexionFailure=this.conexionFailure
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

	this.btnNew=function(){
		ClaseMadre_btnNew();
		var_id_transaccion.setValue(maestro.id_transaccion);
	}
	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/cheque/ActionEliminarCheque.php'},
		Save:{url:direccion+'../../../control/cheque/ActionGuardarChequeRegTra.php'},
		ConfirmSave:{url:direccion+'../../../control/cheque/ActionGuardarChequeRegTra.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:400,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'cheque'}};
	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));
	
	function MaestroJulio(data){
		//var  html="<table class='tabla_maestro'>";
		var mayor=0;		
		var j;
		//var  html="<table class='izquierda'><tr>";
		var  html="<table class='izquierda'>";
		for(j=0;j<data.length;j++){if(mayor<=data[j].length){mayor=data[j].length }};
		//for(j=0;j<mayor;j++){html=html=+"<td>&nbsp;</td>";};
		html=html+"</tr>";
		
		for(j=0;j<data.length;j++){
			if(j%2==0){	html=html+"<tr class='gris'>";}
			else{html=html+" <tr class='blanco'>";}
			for(i=0;i<data[j].length;i++){
				if(data[j]){
					if(i%2!=0){html=html+"<td class='izquierda'  >  <pre><font face='Arial'> "+data[j][i]+"</font></pre> </td> ";}
					else{html=html+"<td class='atributo'  > <pre><font face='Arial'> "+data[j][i]+":</font></pre></td>";}
				}
			}
			html=html+"</tr>";
		}
		html=html+"</table>";
		return html
	};	
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
	//para iniciar eventos en el formulario
	}

	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_transaccion=datos.m_id_transaccion;
		maestro.tipo_plantilla=datos.m_tipo_plantilla;
		maestro.desc_plantilla=datos.m_desc_plantilla;
		maestro.desc_comprobante=datos.m_desc_comprobante;
		maestro.concepto_tran=datos.m_concepto_tran;
		maestro.desc_cuenta=datos.m_desc_cuenta;
		maestro.desc_auxiliar=datos.m_desc_auxiliar;
		maestro.desc_partida=datos.m_desc_partida;
		maestro.id_moneda=datos.m_id_moneda;
		maestro.desc_moneda=datos.m_desc_moneda;
		maestro.id_cuenta=datos.m_id_cuenta;
		maestro.id_auxiliar=datos.m_id_auxiliar;
		maestro.fecha_trans=datos.m_fecha_trans;
		
		maestro.importe_debe=datos.m_importe_debe;
		maestro.importe_haber=datos.m_importe_haber;
		
		var data_maestro=[['Comprobante ',maestro.desc_comprobante],['Transacción ',maestro.concepto_tran],
		                  ['Cuenta - Partida ',maestro.desc_cuenta],['Auxiliar ',maestro.desc_auxiliar]];
		
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));
		
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_transaccion:maestro.id_transaccion,
				m_id_moneda:maestro.id_moneda
			}
		};
		//console.log(params);
		var_id_cuenta_bancaria.store.baseParams={m_vista_cheque:'registro_cheque_conta',m_id_cuenta:maestro.id_cuenta,m_id_auxiliar:maestro.id_auxiliar};
		var_fecha_cheque.setValue(maestro.fecha_trans);			
			
		this.btnActualizar();
		paramFunciones.btnEliminar.parametros='&m_id_transaccion='+maestro.id_transaccion;
		paramFunciones.Save.parametros='&m_id_transaccion='+maestro.id_transaccion;
		paramFunciones.ConfirmSave.parametros='&m_sw_documento=si&id_transaccion='+maestro.id_transaccion
	
		this.InitFunciones(paramFunciones)
	};
	
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_cheque.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
	
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_transaccion:maestro.id_transaccion,
			m_id_moneda:maestro.id_moneda
		}
	});
	
	function InitRegistroCheque(){	
		grid=ClaseMadre_getGrid();
		dialog=ClaseMadre_getDialog();
		
		sm=getSelectionModel();
		formulario=ClaseMadre_getFormulario();
		
		var_id_cuenta_bancaria=ClaseMadre_getComponente('id_cuenta_bancaria');
		var_tipo_cheque=ClaseMadre_getComponente('tipo_cheque');
		var_nro_deposito=ClaseMadre_getComponente('nro_deposito');
		var_nro_cheque=ClaseMadre_getComponente('nro_cheque');
		var_nro_transaccion=ClaseMadre_getComponente('nro_transaccion');
		var_id_transaccion=ClaseMadre_getComponente('id_transaccion');
		var_fecha_cheque=ClaseMadre_getComponente('fecha_cheque');
		var_id_moneda=ClaseMadre_getComponente('id_moneda');
		var_id_tipo_cambio=ClaseMadre_getComponente('id_tipo_cambio');
		var_tipo_cambio=ClaseMadre_getComponente('tipo_cambio');
		
		var_tipo_cheque.on('select',f_filtrar_tipo_cheque);	
		
		var_id_moneda.on('select',f_filtrar_tipo_cambio);
		var_id_tipo_cambio.on('select',f_filtrar_tipo_cambio_valor);
	}
	
	function f_filtrar_tipo_cheque( combo, record, index ){
			if(combo.getValue()=='transferencia') {
			var_nro_transaccion.setDisabled(false);	
			var_nro_deposito.setDisabled(true);	
			var_nro_cheque.setDisabled(true);	
			}
			if(combo.getValue()=='cheque') {
			var_nro_transaccion.setDisabled(true);	
			var_nro_deposito.setDisabled(true);	
			var_nro_cheque.setDisabled(false);	
			}
	 		if(combo.getValue()=='deposito') {
			var_nro_transaccion.setDisabled(true);	
			var_nro_deposito.setDisabled(false);	
			var_nro_cheque.setDisabled(true);	
			}
	}
	
	function f_filtrar_tipo_cambio(combo, record, index ){
		var fecha =var_fecha_cheque.getValue()?var_fecha_cheque.getValue().dateFormat('m/d/Y'):'';
		var_id_tipo_cambio.store.baseParams={sw_reg_comp:'si',m_id_moneda:record.data.id_moneda,m_fecha:fecha};
		var_id_tipo_cambio.modificado=true;
		if(record.data.prioridad!=1){
			var_id_tipo_cambio.setDisabled(false);
			var_tipo_cambio.setDisabled(true);		

			var_id_tipo_cambio.setValue('');
			var_tipo_cambio.setValue('');	
		}
		if(record.data.prioridad==1){
			var_id_tipo_cambio.setDisabled(true);
			var_tipo_cambio.setDisabled(true);		

			var_id_tipo_cambio.setValue('');
			var_tipo_cambio.setValue('');	
		} 
	}
	
	function f_filtrar_tipo_cambio_valor(combo, record, index ){
		if(record.data.id_tipo_cambio==0){
			var_tipo_cambio.setDisabled(false);			
			var_tipo_cambio.setValue('');	
		}
		if(record.data.id_tipo_cambio!=0){
			var_tipo_cambio.setDisabled(true);			
			var_tipo_cambio.setValue(record.data.tipo_cambio);			
		}	  	 
	}
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	InitRegistroCheque();
	
	layout_cheque.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
 
 
