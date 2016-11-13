<?php 
/**
 * Nombre:		  	    libro_diario_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-09-16 17:55:38
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
    ?>
	var fa=false;
	<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>
	var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,
	TiempoEspera:_CP.getConfig().ss_tiempo_espera,
	CantFiltros:1,
	FiltroEstructura:false,
	FiltroAvanzado:fa,idSub:decodeURI(idSub)};
	var result = "";
	var pestana=_CP.getPestana(id);
	var maestro={
        id_cuenta_bancaria:'<?php echo $m_id_cuenta_bancaria;?>',
     	fecha_inicio:'<?php echo utf8_decode($m_fecha_inicio);?>',
     	fecha_fin:'<?php echo utf8_decode($m_fecha_fin);?>',
     	id_moneda:'<?php echo $m_id_moneda;?>',
     	desc_institucion:'<?php echo utf8_decode($m_desc_institucion);?>',
     	nro_cuenta_banco:'<?php echo utf8_decode($m_nro_cuenta_banco);?>',
     	nombre_moneda:'<?php echo utf8_decode($m_nombre_moneda);?>',
     	desc_cuenta:'<?php echo utf8_decode($m_desc_cuenta);?>',
     	sw_actualizacion:'<?php echo utf8_decode($m_sw_actualizacion);?>',
     	sw_estado:'<?php echo $m_sw_estado;?>'
    };
	idContenedorPadre='<?php echo $idContenedorPadre;?>';
	var elemento={idContenedor:idContenedor,pagina:new LibretaBancariaDet(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
	//ContenedorPrincipal.setPagina(elemento);
	_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
* Nombre:		  	    pagina_libreta_bancaria_det.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-09-16 17:55:38
*/
function LibretaBancariaDet(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var Atributos=new Array,sw=0;
	var filtro;
	var txt_nro_cheque,txt_nro_deposito;
	var	txt_fecha_cheque,txt_nombre_cheque;
	var	txt_estado_cheque,txt_fecha_cobro;
	var	txt_importe_cheque;
	var estado_grid;
	var g_id_moneda=maestro.id_moneda;
	var g_desc_moneda=maestro.nombre_moneda;
	var EstehtmlMaestro=this.htmlMaestro;
	
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
		minValue:-1000000000000}	
	);
	
	//---DATA STORE
	var ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_contabilidad/control/cheque/ActionListarLibretaBancaria.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',totalRecords:'TotalCount'
		},[
		'id_comprobante',
		{name: 'fecha_libreta',type:'date',dateFormat:'Y-m-d'},
		'comprobante',
		'nombre',
		'concepto',
		'num_cheque',
		'importe_deposito',
		'importe_cheque',
		'estado',
		'saldo'
		]),remoteSort:true});
	
	//carga datos XML
	ds.load({params:{start:0,limit: paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,
		m_id_cuenta_bancaria:maestro.id_cuenta_bancaria,
		m_fecha_inicio:maestro.fecha_inicio,
		m_fecha_fin:maestro.fecha_fin,
		m_id_moneda:maestro.id_moneda,
		m_desc_institucion:maestro.desc_institucion,
		m_nro_cuenta_banco:maestro.nro_cuenta_banco,
		m_nombre_moneda:maestro.nombre_moneda,
		m_sw_actualizacion:maestro.sw_actualizacion
	}});
		
		var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	    Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	    
	function menuBotones()
	{
		var data_maestro=[['Institución ',maestro.desc_institucion],
	                      ['  Del ',maestro.fecha_inicio],
							['N° Cuenta Banco ',maestro.nro_cuenta_banco],
	                      
	                      ['  Al ',maestro.fecha_fin],
	                      ['Cuenta en ',g_desc_moneda]];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroHTML(data_maestro));
	}
	    
	var data_maestro=[['Institución: ',maestro.desc_institucion],
	                      ['  Del: ',maestro.fecha_inicio],
						  ['No Cuenta Banco: ',maestro.nro_cuenta_banco],
	                      
	                      [' Al: ',maestro.fecha_fin],
	                      ['Cuenta en: ',g_desc_moneda]];
	                      
	function MaestroHTML(data){
		var mayor=0;		
		var j;
		var  html="<table class='izquierda'>";
		for(j=0;j<data.length;j++){if(mayor<=data[j].length){mayor=data[j].length }};
		html=html+"</tr>";
		
		for(j=0;j<data.length;j++){
			if(j%2==0){	html=html+"<tr class='gris'>";}
			else{html=html+" <tr class='blanco'>";}
		
			for(i=0;i<data[j].length;i++){
				if(data[j])
				{
					if(i%2!=0){html=html+"<td class='izquierda'  >  <pre><font face='Arial'> "+data[j][i]+"</font></pre> </td> ";}
					else{html=html+"<td class='atributo'  > <pre><font face='Arial'> "+data[j][i]+":</font></pre></td>";}
				}
			}
			html=html+"</tr>";
		}
		html=html+"</table>";
	 
		return html
	};

	function tabular(n)
	{ if (n>=0)	{return "  "+tabular(n-1)}
	else return "  "
	}
        
	//DATA STORE COMBOS
	var ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
		baseParams:{estado:'activo'}
		});
	
	function tabular(n){
			if (n>=0)	{return "  "+tabular(n-1)}
   	        else return "  "
	     }
	padre=this;
		
	//FUNCIONES RENDER
	function render_id_moneda_reg(value, p, record){return String.format('{0}',record.data['nombre_moneda']);}
	
	var tpl_id_moneda_reg=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
	
	function render_total(value,cell,record,row,colum,store){
		if(value < 0){
		return  '<span style="color:red;">' +monedas_for.formatMoneda(value)+'</span>'}	
		if(value >= 0){return monedas_for.formatMoneda(value)}
	}
	
	// hidden id_comprobante
	//en la posición 0 siempre esta la llave primaria
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_comprobante',
			inputType:'hidden'
		},
		tipo:'Field',
		filtro_0:false
	};	
	// txt fecha_inicio
	Atributos[1]={
		validacion:{
			name:'fecha_libreta',
			fieldLabel:'Fecha',
			allowBlank:false,
			align:'center',
			format:'d/m/Y', //formato para validacion
			renderer:formatDate,
			grid_visible:true,
			grid_editable:false,
			minValue:'01/01/1900',
			width_grid:90
		},
		tipo:'DateField',
		dateFormat:'m-d-Y'
		};
	
	//comprobante
	Atributos[2]={
		validacion:{
			name:'comprobante',
			fieldLabel:'N° Cbte.',
			grid_visible:true,
			grid_editable:false,
			width_grid:90
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'comprobante'
	};
	
	//nombre
	Atributos[3]={
		validacion:{
			name:'nombre',
			fieldLabel:'Beneficiario',
			grid_visible:true,
			grid_editable:false,
			width_grid:250
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'nombre'
	};
	
	//concepto
	Atributos[4]={
		validacion:{
			name:'concepto',
			fieldLabel:'Concepto',
			grid_visible:true,
			grid_editable:false,
			width_grid:250
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'concepto'
	};
		
	// txt num_cheque
	Atributos[5]={
		validacion:{
			name:'num_cheque',
			fieldLabel:'N° Cheque',
			allowBlank:false,
			align:'left',
			grid_visible:true,
			grid_editable:false,
			width_grid:80
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'num_cheque'
	};
	
	//estado_cheque
	Atributos[6]={
		validacion:{
			name:'estado',
			fieldLabel:'Estado',
			allowBlank:true,
			vtype:'texto',
			renderer:EstadoCheque,
			grid_visible:true,
			grid_editable:false,
			width_grid:100
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'estado'
	};
	
	// importe_deposito
	Atributos[7]={
		validacion:{
			name:'importe_deposito',
			fieldLabel:'Depósito',
			allowBlank:false,
			align:'right',
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:100
		},
		tipo:'NumberField',
		filtro_0:true,
		filterColValue:'importe_deposito'
	};
	
	// importe_cheque
	Atributos[8]={
		validacion:{
			name:'importe_cheque',
			fieldLabel:'Cheque',
			allowBlank:false,
			align:'right',
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:100
		},
		tipo:'NumberField',
		filtro_0:true,
		filterColValue:'importe_cheque'
	};
	
	// txt pedido
	Atributos[9]={
		validacion:{
			name:'saldo',
			fieldLabel:'Saldo',
			allowBlank:true,
			align:'right',
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			renderer: render_total,
			width_grid:120
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'saldo'
	};
	
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	
	function EstadoCheque(value){
			if(value==0)return "Transitorio";
			if(value==1)return "Cobrado";
			if(value==2)return "Depositado";
			if(value==3)return "Transitorio";
			if(value==4)return "Trans. Impreso";
			if(value==5)return "Anulado";
			if(value==9)return " ";
	}
	
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Conciliación Bancaria',grid_maestro:'grid-'+idContenedor};
	var layout_libreta_bancaria_det=new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_libreta_bancaria_det.init(config);
	
	// INICIAMOS HERENCIA //
	this.pagina=Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_libreta_bancaria_det,idContenedor);
	var getComponente=this.getComponente;
	var getComponenteGrid=this.getComponenteGrid;
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var CM_saveSuccess=this.saveSuccess;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var EstehtmlMaestro=this.htmlMaestro;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente= this.mostrarComponente;
	var Cm_conexionFailure=this.conexionFailure;
	var Cm_btnActualizar=this.btnActualizar;
	var getGrid=this.getGrid;
	var getDialog= this.getDialog;
	var cm_EnableSelect=this.EnableSelect;
	var getColumnNum=this.getColumnNum;
	var InitFunciones=this.InitFunciones;
	
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	var paramMenu={
		actualizar:{crear:true,separador:false},
		excel:{crear:true,separador:false}
	};
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//datos necesarios para el filtro
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
	var paramFunciones={
		//ConfirmSave:{url:direccion+'../../../../sis_contabilidad/control/cheque/ActionModificarCheque.php',parametros:'&vista_cheque='+g_vista_cheque+'&m_id_cuenta_bancaria='+maestro.id_cuenta_bancaria+'&m_fecha_inicio='+maestro.fecha_inicio+'&m_fecha_fin='+maestro.fecha_fin+'&m_id_moneda='+maestro.id_moneda}
	};
	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
	   	maestro.id_cuenta_bancaria=datos.m_id_cuenta_bancaria;
       	maestro.fecha_inicio=datos.m_fecha_inicio;
       	maestro.fecha_fin=datos.m_fecha_fin;
       	maestro.id_moneda=datos.m_id_moneda;
       	maestro.desc_institucion=datos.m_desc_institucion;
       	maestro.nro_cuenta_banco=datos.m_nro_cuenta_banco;
       	maestro.sw_actualizacion=datos.m_sw_actualizacion;
       	       	       	     	
		data_maestro=[['Institucion ',maestro.desc_institucion+tabular(70-maestro.desc_institucion.length)],['No Cuenta Banco ',maestro.nro_cuenta_banco+tabular(70-maestro.nro_cuenta_banco.length)],['Desde ',maestro.fecha_inicio+tabular(70-maestro.fecha_inicio.length)],['Hasta ',maestro.fecha_fin+tabular(70-maestro.fecha_fin.length)],['Cuenta en ',maestro.nombre_moneda+tabular(70-maestro.nombre_moneda.length)]];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,EstehtmlMaestro(data_maestro));
		//vectorAtributos[2].defecto=maestro.id_partida;
	   	
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_cuenta_bancaria:maestro.id_cuenta_bancaria,
		        m_fecha_inicio:maestro.fecha_inicio,
		        m_fecha_fin:maestro.fecha_fin,
		        m_id_moneda:maestro.id_moneda,
		        m_desc_institucion:maestro.desc_institucion,
		        m_nro_cuenta_banco:maestro.nro_cuenta_banco,
		        m_nombre_moneda:maestro.nombre_moneda,
		        m_sw_actualizacion:maestro.sw_actualizacion
			}
		};
		Cm_btnActualizar()
	};
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		txt_nombre=getComponente('nombre');
		txt_num_cheque=getComponente('num_cheque');
		txt_importe_deposito=getComponente('importe_deposito');
		txt_importe_cheque=getComponente('importe_cheque');
		txt_estado=getComponente('estado');
		txt_saldo=getComponente('saldo');
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_conciliacion_det.getLayout()};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	var prueba=new Ext.form.ComboBox({
		store: ds_moneda,
		displayField:'nombre',
		typeAhead:true,
		mode:'local',
		triggerAction:'all',
		emptyText:'Seleccionar moneda...',
		selectOnFocus:true,
		width:135,
		valueField:'id_moneda',
		tpl:tpl_id_moneda_reg
		
	});
	ds_moneda.load({
		params:{
			start:0,
			limit:1000000
		}
	}
	);

	//esto es para el combo y mandarle datos al hijo
	prueba.on('select',
	function(combo, record, index){
		ds.load({params:{start:0,limit: paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,
	             m_id_cuenta_bancaria:maestro.id_cuenta_bancaria,
	             m_fecha_inicio:maestro.fecha_inicio,
	             m_fecha_fin:maestro.fecha_fin,
	             m_id_moneda:prueba.getValue(),
				m_sw_actualizacion:maestro.sw_actualizacion}});
	    g_id_moneda=prueba.getValue();
	    g_desc_moneda=record.data['nombre'];
	    menuBotones()
	    
	});

	function btn_reporte_libreta_bancaria(){
		var data ='&m_id_cuenta_bancaria='+maestro.id_cuenta_bancaria;
			data +='&m_fecha_inicio='+maestro.fecha_inicio;
			data +='&m_fecha_fin='+maestro.fecha_fin;
			data +='&m_id_moneda='+g_id_moneda;
			data +='&m_desc_institucion='+maestro.desc_institucion;
			data +='&m_nro_cuenta_banco='+maestro.nro_cuenta_banco;
			data +='&m_nombre_moneda='+g_desc_moneda;
			data +='&m_desc_cuenta='+maestro.desc_cuenta;
			data +='&m_sw_actualizacion='+maestro.sw_actualizacion;
			
		window.open(direccion+'../../../control/comprobante/reporte/ActionPDFLibretaBancaria.php?'+data)
	}
		
	this.InitFunciones(paramFunciones);
	
	//para agregar botones
	this.iniciaFormulario();
	iniciarEventosFormularios();
	this.AdicionarBotonCombo(prueba,'prueba');
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte Libreta Bancaria',btn_reporte_libreta_bancaria,true,'reporte_libreta_bancaria','');
	
	layout_libreta_bancaria_det.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}