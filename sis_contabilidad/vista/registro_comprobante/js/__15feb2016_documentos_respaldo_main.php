<?php 
/**
 * Nombre:		  	    documentos_respaldo_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				AVQ
 * Fecha creación:		2009-05- 11:32:38
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
	echo "var id='$id';";
	echo "var idSub='$idSub';";
	//echo "sadf".$m_nro_cuenta;
//exit

    ?>
var fa=false;

<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>

var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,
TiempoEspera:_CP.getConfig().ss_tiempo_espera,
CantFiltros:2,
FiltroEstructura:false,
FiltroAvanzado:fa};


  var result = "";
  //var pestana=_CP.getSubPestana(id,idSub);
  var pestana=_CP.getPestana(id);

var maestro={ // utf8_decode
	        id_moneda:'<?php echo $m_id_moneda;?>',
			id_comprobante:'<?php echo  $m_id_comprobante ;?>',
			desc_moneda:'<?php echo $m_desc_moneda;?>',
			acreedor:'<?php echo $m_acreedor;?>', 
	     	pedido:'<?php echo $m_pedido;?>', 
	     	concepto_cbte:'<?php echo $m_concepto_cbte;?>', 
	     	conformidad:'<?php echo $m_conformidad;?>', 
	     	aprobacion:'<?php echo $m_aprobacion;?>', 
	     	simbolo_moneda:'<?php echo m_simbolo_moneda;?>' 
};

 idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new paginaDocumentosRespaldo(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}

Ext.onReady(main,main);

/**
* Nombre:		  	    paginaDocumentosRespaldo.js
* Propósito: 			pagina objeto principal
* Autor:				AVQ
* Fecha creación:		18/05/2009 
*/
function paginaDocumentosRespaldo(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	
	var Atributos=new Array,sw=0;
	var	g_limit='';
	var	g_CantFiltros='';
	
	var	g_id_moneda_desc='Ninguno';
	var g_desc_moneda=maestro.simbolo_moneda;
	var	g_id_moneda=maestro.id_moneda;
	var filtro;
	// alert (maestro.id_comprobante);
	//---DATA STORE
	
		
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
		minValue:0
	}	
	); 	
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/documento/ActionListarDocumentosRespaldo.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'id_comprobante',totalRecords:'TotalCount'
		},[
		'nro_documento','tipo_documento',
        'razon_social',
        'nro_nit',
        'nro_autorizacion',
        'codigo_control',
        'poliza_dui',
        'formulario',
        'fecha_documento',
        'importe_total',
        'importe_ice',
        'importe_no_gravado',
        'importe_sujeto',
        'importe_credito',
        'importe_iue',
        'importe_it',
        'importe_debito',
        'id_documento',
        'id_transaccion',
        'id_documento_valor',
        'id_moneda',
        'tipo_retencion',
        'estado_documento '
		]),remoteSort:true});

		//carga datos XML
		ds.load({params:{start:0,limit: paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,
		m_id_moneda:maestro.id_moneda,
		m_id_comprobante:maestro.id_comprobante
		}});
		//DATA STORE COMBOS

	
	var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
		baseParams:{estado:'activo'}
	});

	 
	function render_id_moneda_reg(value, p, record){return String.format('{0}', record.data['desc_moneda']);}

	var tpl_id_moneda_reg=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
		
		
	function menuBotones(){
	 	g_limit= paramConfig.TamanoPagina;
	 	g_CantFiltros=paramConfig.CantFiltros;
	
		ds.baseParams={start:0,
			limit: g_limit,
			CantFiltros:g_CantFiltros,
			id_moneda:g_id_moneda,
			id_comprobante:maestro.id_comprobante,
			};
	
		var data_maestro=[ ['Acreedor',maestro.acreedor,'Pedido',maestro.pedido],
	                   ['Operación',maestro.concepto_cbte],['Conformidad',maestro.conformidad],
	                   ['Aprobación',maestro.aprobacion,'Expresado en',g_desc_moneda]];
	
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroDocumentosRespaldo(data_maestro));
	}
		
	//carga datos XML
	
	// DEFINICIÓN DATOS DEL MAESTRO
	function MaestroDocumentosRespaldo(data){
		var mayor=0;		
		var j;
			var  html="<table class='enc_documentos'>";
		for(j=0;j<data.length;j++){if(mayor<=data[j].length){mayor=data[j].length }};
		html=html+"</tr>";
		
		for(j=0;j<data.length;j++){
		if(j%2==0){	html=html+"<tr class='gris'>";}
		else{html=html+" <tr class='blanco'>";}
		for(i=0;i<data[j].length;i++){
			if(data[j])
				{
				if(i%2!=0){html=html+"<td class='enc_documentos'  >  <pre><font face='Arial'> "+data[j][i]+"</font></pre> </td> ";}
				else{html=html+"<td class='atributo'  > <pre><font face='Arial'> "+data[j][i]+":</font></pre></td>";}
				}
				}
		html=html+"</tr>";
		}
		html=html+"</table>";
		
		return html
	};

	function tabular(n){ 
		if (n>=0)	{return "  "+tabular(n-1)}
		else return "  "
	}

	function renderFormatNumber(value,cell,record,row,colum,store){		
		return monedas_for.formatMoneda(value)
	}

	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	
	var data_maestro=[ ['Acreedor',maestro.acreedor,'Pedido',maestro.pedido],
	                   ['Operación',maestro.concepto_cbte],['Conformidad',maestro.conformidad],
	                   ['Aprobación',maestro.aprobacion,'Expresado en',g_desc_moneda]];
		
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroDocumentosRespaldo(data_maestro));


	/////////////////////////
	// Definición de datos //
	/////////////////////////

	// hidden id_comprobante
	//en la posición 0 siempre esta la llave primaria

	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_documento',
			inputType:'hidden'
		},
		tipo:'Field',
		save_as:'id_documento'
	};

	Atributos[1]={
		validacion:{
			labelSeparator:'',
			name:'id_transaccion',
			inputType:'hidden'
		},
		tipo:'Field',
		save_as:'id_transaccion'
	};

	Atributos[2]={
		validacion:{
			labelSeparator:'',
			name:'id_documento_valor',
			inputType:'hidden'
		},
		tipo:'Field',
		save_as:'id_documento_valor'
	};
	
	Atributos[3]={
		validacion:{
			labelSeparator:'',
			name:'id_moneda',
			inputType:'hidden'
		},
		tipo:'Field',
		save_as:'id_moneda'
	};

	Atributos[4]={
		validacion:{
			name:'nro_documento',
			fieldLabel:'No Documento',
			allowBlank:false,
			allowDecimals:false,
			maxLength:50,
			minLength:0,
			width:'75%',
			grid_visible:true,
			grid_editable:false,
			grid_indice:1,
		},
		tipo:'NumberField',
		filtro_0:true,
		filterColValue:'docval.nro_documento',
		save_as:'nro_documento'
	};
	
	// txt tipo_documento
	Atributos[5]={
		validacion:{
			name:'tipo_documento',
			fieldLabel:'Tipo Documento',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			width:300,
			lazyRender:true,
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			grid_indice:3,
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'planti.desc_plantilla',
		save_as:'tipo_documento'
	};
	
	// txt razon_social
	Atributos[6]={
		validacion:{
			name:'razon_social',
			fieldLabel:'Razon Social',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			width:'100%',
			grid_visible:true,
			grid_editable:false,
			grid_indice:4,
		},
		tipo:'TextArea',
		filtro_0:true,
		filterColValue:'docval.razon_social',
	
		save_as:'razon_social'
	};
	
	// txt nro_nit
	Atributos[7]={
		validacion:{
			name:'nro_nit',
			fieldLabel:'NIT',
			allowBlank:false,
			maxLength:30,
			minLength:0,
			width:'100%',
			grid_visible:true,
			grid_editable:false,
			grid_indice:5
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'docval.nro_nit',
		save_as:'nro_nit'
	};

	// txt nro_autorizacion
	Atributos[8]={
		validacion:{
			name:'nro_autorizacion',
			fieldLabel:'No Autorización',
			allowBlank:false,
			maxLength:20,
			minLength:0,
			width:'100%',
			grid_visible:true,
			grid_editable:false,
			grid_indice:6
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'docval.nro_autorizacion',
		save_as:'nro_autorizacion'
	};
	
	// txt codigo_control
	Atributos[9]={
		validacion:{
			name:'codigo_control',
			fieldLabel:'Código de Control',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			width:'100%',
			grid_visible:true,
			grid_editable:false,
			grid_indice:7,
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'docval.codigo_control',
		save_as:'codigo_control'
	};
	
	// txt poliza_dui
	Atributos[10]={
		validacion:{
			name:'poliza_dui',
			fieldLabel:'Poliza D.U.I.',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			width:'100%',
			grid_visible:true,
			grid_editable:false,
			grid_indice:2,
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'docval.poliza_dui',
		save_as:'poliza_dui'
	};
	
	// txt formulario
	Atributos[11]={
		validacion:{
			name:'formulario',
			fieldLabel:'Formulario',
			allowBlank:true,
			maxLength:20,
			minLength:0,
			width:'100%',
			grid_visible:true,
			grid_editable:false,
			grid_indice:8,
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'docval.formulario',
		save_as:'formulario'
	};
	
	// txt fecha_documento
	Atributos[12]= {
		validacion:{
			name:'fecha_documento',
			fieldLabel:'Fecha Documento',
			allowBlank:false,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900',
			disabledDaysText:'Día no válido',
			grid_visible:true,
			grid_editable:false,
			grid_indice:9,
		},
		tipo:'DateField',
		dateFormat:'m-d-Y',
		defecto:'',
		filtro_0:true,
		filterColValue:'docval.fecha_documento',
	    save_as:'fecha_documento'
	};
	
	// importe total
	Atributos[13]={
		validacion:{
			name:'importe_total',
			fieldLabel:'Importe Total',
			allowBlank:false,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			align:'right',
			vtype:'texto',
			width:'50%',
			grid_visible:true,
			grid_editable:false,
			renderer: renderFormatNumber,
			grid_indice:10
		},
		tipo:'NumberField',
		filtro_1:true,
		filterColValue:'docval.importe_total',
		save_as:'importe_total'
	};
	
	// importe ice
	Atributos[14]={
		validacion:{
			name:'importe_ice',
			fieldLabel:'Importe I.C.E',
			allowBlank:false,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:'50%',
			grid_visible:true,
			grid_editable:false,
			align:'right',
			renderer: renderFormatNumber,
			grid_indice:11
		},
		tipo:'NumberField',
		filtro_1:true,
		filterColValue:'docval.importe_ice',
		save_as:'importe_ice'
	};
	
	// importe no gravado
	Atributos[15]={
		validacion:{
			name:'importe_no_gravado',
			fieldLabel:'Importe No Gravado',
			allowBlank:false,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:'50%',
			grid_visible:true,
			grid_editable:false,
			align:'right',
			renderer: renderFormatNumber,
			grid_indice:12
		},
		tipo:'NumberField',
		filtro_1:true,
		filterColValue:'docval.importe_no_gravado',
		save_as:'importe_no_gravado'
	};
	
	// importe sujeto
	Atributos[16]={
		validacion:{
			name:'importe_sujeto',
			fieldLabel:'Importe Sujeto',
			allowBlank:false,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:'50%',
			grid_visible:true,
			grid_editable:false,
			align:'right',
			renderer: renderFormatNumber,
			grid_indice:13
		},
		tipo:'NumberField',
		filtro_1:true,
		filterColValue:'docval.importe_sujeto',
		save_as:'importe_sujeto'
	};
	
	// importe crédito
	Atributos[17]={
		validacion:{
			name:'importe_credito',
			fieldLabel:'Crédito/Débito',
			allowBlank:false,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:'50%',
			grid_visible:true,
			grid_editable:false,
			align:'right',
			renderer: renderFormatNumber,
			grid_indice:14
		},
		tipo:'NumberField',
		filtro_1:true,
		filterColValue:'docval.importe_credito',
		save_as:'importe_crédito'
	};
	
	// importe iue
	Atributos[18]={
		validacion:{
			name:'importe_iue',
			fieldLabel:'Importe I.U.E',
			allowBlank:false,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:'50%',
			grid_visible:true,
			grid_editable:false,
			align:'right',
			renderer: renderFormatNumber,
			grid_indice:15
		},
		tipo:'NumberField',
		filtro_1:true,
		filterColValue:'docval.importe_iue',
		save_as:'importe_iue'
	};
	
	// importe it
	Atributos[19]={
		validacion:{
			name:'importe_it',
			fieldLabel:'Importe IT',
			allowBlank:false,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:'50%',
			grid_visible:true,
			grid_editable:false,
			align:'right',
			renderer: renderFormatNumber,
			grid_indice:16
		},
		tipo:'NumberField',
		filtro_1:true,
		filterColValue:'docval.importe_it',
		save_as:'importe_it'
	};
	
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
		
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Comprobante (Maestro)',titulo_detalle:'Documentos de Respaldo (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_documentos_respaldo = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_documentos_respaldo.init(config);
	
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_documentos_respaldo,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;

	//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={
		actualizar:{crear:true,separador:false}
	};
	
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		//var datos=params;
		maestro.id_comprobante=datos.m_id_comprobante;
		maestro.acreedor=datos.m_acreedor;
		maestro.pedido=datos.m_pedido;
		maestro.concepto_cbte=datos.m_concepto_cbte;
		maestro.conformidad=datos.m_conformidad;
		maestro.aprobacion=datos.m_aprobacion;
		maestro.simbolo_moneda=datos.m_simbolo_moneda;
		maestro.id_moneda=datos.m_id_moneda;
	
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_comprobante:maestro.id_comprobante,
				m_id_moneda:maestro.id_moneda,
				
			}
		};
		this.btnActualizar()
		var data_maestro=[ ['Acreedor',maestro.acreedor,'Pedido',maestro.pedido],
	                   ['Operación',maestro.concepto_cbte],['Conformidad',maestro.conformidad],
	                   ['Aprobación',maestro.aprobacion,'Expresado en',maestro.simbolo_moneda]];
	
		monedas_documento.setValue(maestro.id_moneda);
		
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroDocumentosRespaldo(data_maestro));
	};
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////
	
	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	//datos necesarios para el filtro
	var paramFunciones={
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Detalle Partida Formulación'}};

	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
     function btn_reporte_documentos_respaldo(){
    	 /*parametros reporte */	
    	 var data='start=0';
		 data+='&limit=1000';
		 data+='&CantFiltros='+g_CantFiltros;
		 
		 data+='&id_comprobante='+maestro.id_comprobante;
		 data+='&id_moneda='+g_id_moneda;
		 data+='&desc_moneda='+g_desc_moneda;
	
		 window.open(direccion+'../../../control/documento/reporte/ActionPDFDocumentosRespaldo.php?'+data);
	}
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){}
				
	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_documentos_respaldo.getLayout()};
	this.Init(); //iniciamos la clase madre
 	this.InitBarraMenu(paramMenu);
 	this.InitFunciones(paramFunciones);
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	//padre=this;

    this.iniciaFormulario();
    iniciarEventosFormularios();

	var ds_moneda_documento = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),baseParams:{estado:'activo'}});
	var tpl_id_moneda_documento=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
	var monedas_documento =new Ext.form.ComboBox({
		store: ds_moneda_documento,
		displayField:'nombre',
		typeAhead: true,
		mode: 'local',
		triggerAction: 'all',
		emptyText:'moneda...',
		selectOnFocus:true,
		width:100,
		valueField: 'id_moneda',
		tpl:tpl_id_moneda_documento
	});
		
    ds_moneda_documento.load({params:{start:0,limit: 1000000}});
	
    monedas_documento.on('select',function (combo, record, index){
		ds.load({params:{start:0,limit: paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,
			m_id_moneda:monedas_documento.getValue(),
			m_id_comprobante:maestro.id_comprobante
		}});
	
		g_id_moneda=monedas_documento.getValue();g_desc_moneda=record.data['simbolo'];menuBotones()
	});
    
	iniciarEventosFormularios();
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte Documentos Respaldo',btn_reporte_documentos_respaldo,true,'reporte_documentos_respaldo','');
	this.AdicionarBotonCombo(monedas_documento,'monedas');
	
	layout_documentos_respaldo.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
