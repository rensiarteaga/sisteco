/**
 * Nombre:		  	    balance_ss.js
 * Propósito: 			pagina objeto principal
 * Autor:				AVQ
 * Fecha creación:		2009-06-18 15:34:06
 */
function paginaBalanceSS(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
 
	var	g_limit='';
	var	g_CantFiltros='';
	
	var	g_id_parametro=1;
	var	g_id_parametro_desc='Ninguno';
	
	var	g_fecha='01/01/2008';
	var	g_id_moneda=1;
	var	g_id_moneda_desc='Ninguno';
	var	g_nivel=2;
	var g_departamento='Ninguno';
	var g_id_depto_conta=1;
	
	
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/balance_ss/ActionListarBalanceSS.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'nro_cuenta',
			totalRecords: 'TotalCount'

		}, [
		'nro_cuenta',
		'nombre_cuenta',
		'suma_debe',
		'suma_haber',
		'saldo',
		'sw_transaccional',
		'nivel_cuenta'
		 
		]),remoteSort:true});
 
	
	/*crea los data store*/
	function render_cambiarColor(value, p, record){
		if((record.data['sw_transaccional']==1)||(record.data['nivel_cuenta']==g_nivel)){
			return String.format('{0}', '<span style="color:blue">'+record.data['nombre_cuenta']+'</span>');
		}else{
		   return String.format('{0}', '<span style="color:black">'+record.data['nombre_cuenta']+'</span>');
	    }
	}
		function menuBotones()
	{
		 
	 	g_limit= paramConfig.TamanoPagina;
	 	g_CantFiltros=paramConfig.CantFiltros;
	 	
		ds.baseParams={start:0,
			limit: g_limit,
			CantFiltros:g_CantFiltros,
			
			id_parametro:g_id_parametro,
			id_moneda:g_id_moneda,
			nivel:g_nivel,
			fecha:g_fecha,
			id_depto_conta:g_id_depto_conta
			
	}
	
	
	 var data_maestro=[ ['Gestion ',g_id_parametro_desc,'Moneda',g_id_moneda_desc],
	                    ['Fecha Fin',g_fecha,'Nivel',g_nivel],['Departamento',g_departamento]];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroBalanceSS(data_maestro));
	
	
		}
	//carga datos XML
	
	// DEFINICIÓN DATOS DEL MAESTRO
function 	 MaestroBalanceSS(data){
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

	
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	 var data_maestro=[ ['Gestion ',g_id_parametro_desc,'Moneda',g_id_moneda_desc],
	                     ['Fecha Fin',g_fecha,'Nivel',g_nivel],['Departamento',g_departamento]];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroBalanceSS(data_maestro));
	
		
 
					   
	//DATA STORE COMBOS

    
    var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});

	//FUNCIONES RENDER
	
		function render_id_moneda(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
		var tpl_id_moneda=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{nombre}</FONT><br>','</div>');

	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	
	Atributos[0]={
		validacion:{
			name:'nro_cuenta',
			fieldLabel:'Código',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:100,
			width:'50%',
			disable:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'nro_cuenta',
		save_as:'nro_cuenta'
	};
		Atributos[1]={
		validacion:{
			name:'nombre_cuenta',
			fieldLabel:'Cuenta',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:400,
			width:'50%',
			disable:false,
			renderer:render_cambiarColor		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'nombre_cuenta',
		save_as:'nombre_cuenta'
	};
// suma_debe
	Atributos[2]={
		validacion:{
			name:'suma_debe',
			fieldLabel:'Suma Debe',
			allowBlank:false,
			align:'right', 
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'80%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'suma_debe',
		save_as:'suma_debe'
	};
Atributos[3]={
		validacion:{
			name:'suma_haber',
			fieldLabel:'Suma Haber',
			allowBlank:false,
			align:'right', 
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:'80%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'suma_haber',
		save_as:'suma_haber'
	};
	Atributos[4]={
		validacion:{
			name:'saldo',
			fieldLabel:'Saldo',
			allowBlank:false,
			align:'right', 
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			//renderer: renderSwTranssacional,
			width_grid:120,
			width:'80%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'saldo',
		save_as:'saldo'
	};
	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Parametros (Maestro)',titulo_detalle:'Balance Sumas y Saldos (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_BalanceSS = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_BalanceSS.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_BalanceSS,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
//	var ClaseMadre_btnActualizar=this.btnActualizar;
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={
		actualizar:{crear:true,separador:false}
	};
	
//DEFINICIÓN DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroBalanceSS(data_maestro));
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/partida_presupuesto/ActionEliminarDetallePartidaFormulacion.php',parametros:'&m_id_presupuesto='+maestro.id_presupuesto},
	Save:{url:direccion+'../../../control/partida_presupuesto/ActionGuardarDetallePartidaFormulacion.php',parametros:'&m_id_presupuesto='+maestro.id_presupuesto},
	ConfirmSave:{url:direccion+'../../../control/partida_presupuesto/ActionGuardarDetallePartidaFormulacion.php',parametros:'&m_id_presupuesto='+maestro.id_presupuesto},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Detalle Partida Formulación'}};
	
	//-------------- Sobrecarga de funciones --------------------//


function btn_imprimir(){
  			/*parametros reporte */	
			var data='start=0';
			 data+='&limit=1000';
			 data+='&CantFiltros='+g_CantFiltros;
			 data+='&id_parametro='+g_id_parametro;
			 data+='&id_moneda='+g_id_moneda;
			 data+='&nivel='+g_nivel;
   		 	 data+='&fecha='+g_fecha;
 	         data+='&desc_moneda='+g_id_moneda_desc;
 	         data+='&gestion='+g_id_parametro_desc;
	         data+='&desc_dpto_conta='+g_departamento;
	         data+='&id_depto_conta='+g_id_depto_conta;
	         
	window.open(direccion+'../../../control/balance_ss/reporte/ActionPDFBalanceSS.php?'+data);
	}
	/*******************/
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_BalanceSS.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	padre=this;

	this.iniciaFormulario();
	iniciarEventosFormularios();
	
	
var ds_moneda_consulta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),baseParams:{estado:'activo'}});
var tpl_id_moneda_reg=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php?tipo_vista=conta_parametro'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_parametro',totalRecords:'TotalCount'},['id_parametro','id_gestion','desc_gestion','cantidad_nivel','estado_gestion','gestion_conta','porcen_iva','porcen_it','porcen_servicio','porcen_bien','porcen_remesa','id_moneda','nombre_moneda'])});
var tpl_id_parametro_reg=new Ext.Template('<div class="search-item">','<b><i>{desc_gestion}</i></b>','</div>');

var ds_nivel = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/nivel_cuenta/ActionListarNivelCuenta.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_nivel_cuenta',totalRecords:'TotalCount'},['id_nivel_cuenta','id_parametro','desc_parametro','nivel','dig_nivel'])});
var tpl_id_nivel=new Ext.Template('<div class="search-item">','<FONT COLOR="#000000"><b>{nivel}</b></FONT><br>','<FONT COLOR="#B5A642">{desc_parametro}</FONT><br>','</div>');


function render_id_depto(value, p, record){return String.format('{0}', record.data['desc_depto']);}
var tpl_id_depto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{codigo_depto}</FONT><br>','<FONT COLOR="#B5A642">{nombre_depto}</FONT>','</div>');


var ds_departamento = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto_conta/ActionListarDepartamentoConta.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_depto_conta',totalRecords:'TotalCount'},['id_depto_conta','id_depto','nombre_depto','desc_ep','nombre_unidad','desc_cta_aux'])});

var tpl_id_departamento=new Ext.Template('<div class="search-item">','<b>{nombre_depto}</b><br>','<FONT COLOR="#B5A642">{nombre_unidad}</FONT><br>','<FONT COLOR="#B5A642">{desc_ep}</FONT><br>','<FONT COLOR="#B5A642">{desc_cta_aux}</FONT>','</div>');

//monedas
var monedas =new Ext.form.ComboBox({
			store: ds_moneda_consulta,
			displayField:'nombre',
			typeAhead: true,
			mode: 'local',
			triggerAction: 'all',
			emptyText:'moneda...',
			selectOnFocus:true,
			width:100,
			valueField: 'id_moneda',
			tpl:tpl_id_moneda_reg
			
		});
//parametro
var parametro =new Ext.form.ComboBox({
			store: ds_parametro,
			displayField:'gestion_conta',
			typeAhead: true,
			mode: 'local',
			triggerAction: 'all',
			emptyText:'gestión...',
			selectOnFocus:true,
			width:60,
			valueField: 'id_parametro',
			tpl:tpl_id_parametro_reg
			
		});
//departamento de contabilidad		
var departamento =new Ext.form.ComboBox({
			store: ds_departamento,
			displayField:'nombre_depto',
			typeAhead: false,
			mode: 'local',
			triggerAction: 'all',
			emptyText:'departamento...',
			selectOnFocus:true,
			width:250,
			queryDelay:250,
			valueField: 'id_depto_conta',
			tpl:tpl_id_departamento
		});

var fecha=	new Ext.form.DateField({
			name:'fecha',
			fieldLabel:'Fecha EEFF',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '31/01/2001',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:55,
			disabled:false});
					//new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['2','N - 2'],['3','N - 3'],['4','N - 4']]})
var nivel =new Ext.form.ComboBox({
	       store: ds_nivel,
	       displayField:'nivel',
	       typeAhead: false,
	       mode: 'local',
	       triggerAction: 'all',
	       emptyText:'nivel...',
	       selectOnFocus:true,
	       width:100,
	       valueField:'nivel',
	       tpl:tpl_id_nivel
});		
	       
		ds_parametro.load({params:{start:0,limit: 1000000}});
	 	ds_moneda_consulta.load({params:{start:0,limit: 1000000}});
	 	ds_departamento.load({params:{start:0,limit:1000000,tipo_vista:'rep_balance'}});
		ds_nivel.load({params:{start:0,limit:1000000}});
		
		parametro.on('select',function (combo, record, index){g_id_parametro=parametro.getValue();g_id_parametro_desc=record.data['desc_gestion'];menuBotones()});
		fecha.on('change',function (combo,record,index){g_fecha=fecha.getValue()?fecha.getValue().dateFormat('m/d/Y'):'';	menuBotones()});
		monedas.on('select',function (combo, record, index){g_id_moneda=monedas.getValue();g_id_moneda_desc=record.data['nombre'];menuBotones()});
		nivel.on('select',function (combo, record, index){g_nivel=nivel.getValue();menuBotones()});
		departamento.on('select',function(combo,record,index){g_departamento=record.data['nombre_depto'];g_id_depto_conta=departamento.getValue();menuBotones()})
		
		

 
parametro.setValue(1);
fecha.setValue('01/01/2008');
monedas.setValue(1);
nivel.setValue(2);
departamento.setValue(1);
		
	
								
padre.AdicionarBoton('../../../lib/imagenes/print.gif',' ',btn_imprimir,true,'imprimir','');	
this.AdicionarBotonCombo(parametro,'gestion');		
this.AdicionarBotonCombo(fecha,'Fecha');		
this.AdicionarBotonCombo(monedas,'monedas');														
this.AdicionarBotonCombo(nivel,'nivel');														
this.AdicionarBotonCombo(departamento,'departamento');														
														
layout_BalanceSS.getLayout().addListener('layout',this.onResize);
	
}