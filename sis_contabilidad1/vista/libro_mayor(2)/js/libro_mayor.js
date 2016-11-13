/**
 * Nombre:		  	    pagina_detalle_partida_formulacion.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-07-18 11:04:06
 */
function paginaLibroMayor(idContenedor,direccion,paramConfig,ma,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	//alert('id_gestion:'+maestro.id_gestion);
 	var maestro=new Array;
	maestro=ma;
	var	g_limit='';
	var	g_CantFiltros='';
	var	g_id_moneda=1;
	var	g_id_moneda_desc='Ninguno';
	var	g_nivel=2;
	
	var g_ids_auxiliar='';
	var g_auxiliar='';
	
	var g_desc_moneda=maestro.desc_moneda;
	var	g_id_moneda=maestro.id_moneda;
	
	var g_desc_estado_gral=maestro.desc_estado_gral;
	var epe=" ";
	
	//para las fechas
	var fi=new Date(maestro.fecha_inicio);
	var ff=new Date(maestro.fecha_fin);
	/*if(maestro.por_rango=='true'){
		alert('rango true:'+maestro.por_rango);
	} else{
		alert('rango false:'+maestro.por_rango);
	}
	//alert('rango:'+maestro.por_rango);*/
	
	var g_fecha_inicio=fi.getDate()+'/'+(fi.getMonth()+1)+'/'+fi.getFullYear();
	var g_fecha_fin=ff.getDate()+'/'+(ff.getMonth()+1)+'/'+ff.getFullYear();

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
	
	var ds = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/comprobante/ActionListarLibroMayor.php'}),
								reader: new Ext.data.XmlReader({record: 'ROWS',
															//id: 'id_cuenta',
															totalRecords: 'TotalCount'}, [
														//	{name: 'fecha_cbte',type:'date',dateFormat:'Y-m-d'},
														    'fecha_cbte',
															'prefijo','nro_cbte','concepto_cbte','tipo_cambio',
															'importe_debe','importe_haber','saldo','id_cuenta','desc_cuenta']),remoteSort:true});
 
	
	

	
	/*crea los data store*/
		
	var ds_auxiliar =new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/auxiliar/ActionListarAuxiliar.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_auxiliar',totalRecords:'TotalCount'},['id_auxiliar','codigo_auxiliar','nombre_auxiliar','estado_auxiliar']),remoteSort:true});
	
	var config_auxiliar={nombre:'Auxiliares',descripcion:'nombre_auxiliar',id:'id_auxiliar',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotonesAuxiliares};
	
	function menuBotonesAuxiliares(){
		g_ids_auxiliar=padre.getBotonMenuBotonNombre('Auxiliares').menuBoton.getSelecion();
		//alert(g_ids_auxiliar);
		g_auxiliar=padre.getBotonMenuBotonNombre('Auxiliares').menuBoton.getSeleccionadosDesc();
	}
		
	function menuBotones()
	{
	}
	//carga datos XML
	
	function MaestroJulio(data){
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
	
	var data_maestro=[ ['Cuenta ',maestro.nro_cuenta+' - '+ maestro.nombre_cuenta],
					   ['Moneda',g_desc_moneda, 'Departamento',maestro.nombre_depto],	
					   ['Fecha Inicio',g_fecha_inicio,'Fecha Fin',g_fecha_fin]
					    ];
					   
	//DATA STORE COMBOS
    var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});

	//FUNCIONES RENDER
	function render_id_moneda(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
	
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{nombre}</FONT><br>','</div>');

	function render_total(value,cell,record,row,colum,store){
		if(value < 0){
		return  '<span style="color:red;">' +monedas_for.formatMoneda(value)+'</span>'}	
		if(value >= 0){return monedas_for.formatMoneda(value)}
	}
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
 	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_cuenta',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_cuenta'
	} ; 
	// txt fecha_cbte
	/*Atributos[1]= {
		validacion:{
			name:'fecha_cbte',
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
		filterColValue:'COMPROB.fecha_cbte',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'fecha_cbte'
	};*/
	Atributos[1]={
		validacion:{
			name:'fecha_cbte',
			fieldLabel:'Fecha',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			align:'left',
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			disable:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'fecha_cbte',
		save_as:'fecha_cbte'
	};
	
	Atributos[2]={
		validacion:{
			name:'prefijo',
			fieldLabel:'Cbte. Nro.',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			align:'left',
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			disable:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'prefijo',
		save_as:'prefijo'
	};
	
	Atributos[3]={
		validacion:{
			name:'nro_cbte',
			fieldLabel:'Nro.',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:false,
			grid_editable:false,
			width_grid:50,
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'nro_cbte',
		save_as:'nro_cbte'
	};
	
	Atributos[4]={
		validacion:{
			name:'concepto_cbte',
			fieldLabel:'Concepto Comprobante',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:450,
			width:'50%',
			disable:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'concepto_cbte',
		save_as:'concepto_cbte'
	};
 
	Atributos[5]={
		validacion:{
			name:'tipo_cambio',
			fieldLabel:'Tipo de Cambio',
			allowBlank:false,
			align:'right', 
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:false,
			grid_editable:false,
			width_grid:100,
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'tipo_cambio',
		save_as:'tipo_cambio'
	};
	
// importe_debe
	Atributos[6]={
		validacion:{
			name:'importe_debe',
			fieldLabel:'Importe Debe',
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
			renderer: render_total,
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'importe_debe',
		save_as:'importe_debe'
	};

// importe_debe
	Atributos[7]={
		validacion:{
			name:'importe_haber',
			fieldLabel:'Importe Haber',
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
			renderer: render_total,
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'importe_haber',
		save_as:'importe_haber'
	};
	// importe_debe
	Atributos[8]={
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
			renderer: render_total,
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
	
	Atributos[9]={
			validacion:{
				name:'id_cuenta',
				fieldLabel:'id_cuenta',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			form: false,
			filtro_0:false
		};
	
	Atributos[10]={
			validacion:{
				name:'desc_cuenta',
				fieldLabel:'Cuenta',
				grid_visible:true,
				grid_editable:false,
				width_grid:350
			},
			tipo: 'Field',
			form: false,
			filtro_0:true,
			filterColValue:'desc_cuenta',
		};

	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Parametros (Maestro)',titulo_detalle:'Libro Mayor (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_LibroMayor = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_LibroMayor.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_LibroMayor,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	var getComponente=this.getComponente;
	var CM_btnActualizar=this.btnActualizar;
	
	//	var ClaseMadre_btnActualizar=this.btnActualizar;
	//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={
			actualizar:{crear:true,separador:false}
	};
	
	//DEFINICIÓN DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));
	var paramFunciones={
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Detalle Partida Formulación'}};
		
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro=datos;
		
		
		g_desc_moneda=maestro.desc_moneda;
		g_id_moneda=maestro.id_moneda;
		g_desc_estado_gral=maestro.desc_estado_gral;
		//para las fechas
		fi=new Date(maestro.fecha_inicio);
		ff=new Date(maestro.fecha_fin);
		g_fecha_inicio=fi.getDate()+'/'+(fi.getMonth()+1)+'/'+fi.getFullYear();
		g_fecha_fin=ff.getDate()+'/'+(ff.getMonth()+1)+'/'+ff.getFullYear();
		
		data_maestro=[ ['Cuenta ',maestro.nro_cuenta+' - '+ maestro.nombre_cuenta],
					   ['Moneda',g_desc_moneda, 'Departamento',maestro.nombre_depto],	
					   ['Fecha Inicio',g_fecha_inicio,'Fecha Fin',g_fecha_fin]
					    ];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));
		
		/*ds.lastOptions={
			params:{start:0,limit: paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,
					id_moneda:maestro.id_moneda,
					id_cuenta:maestro.id_cuenta,
					fecha_inicio:g_fecha_inicio,
					fecha_fin:g_fecha_fin,
					id_depto:maestro.id_depto,
					por_rango:maestro.por_rango,
					cuenta_ini:maestro.cuenta_ini,
					cuenta_fin:maestro.cuenta_fin,
					id_gestion:maestro.id_gestion }
		};*/
		
		g_ids_auxiliar='';
		
		var btnaux=padre.getMenuBoton('Auxiliares-'+idContenedor).menuBoton;
		btnaux.menu.removeAll();
		
		ds_auxiliar.load({
			params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_sw_rep_libro_mayor:'si',
			m_id_moneda:maestro.id_moneda,
			m_id_cuenta:maestro.id_cuenta,
			m_fecha_inicio:fi?fi.dateFormat('m/d/Y'):'',
			m_fecha_fin:ff?ff.dateFormat('m/d/Y'):'',
			cuenta_ini:maestro.cuenta_ini,
			cuenta_fin:maestro.cuenta_fin,
			m_id_depto:maestro.id_depto,
			por_rango:maestro.por_rango
			},
	 		callback: function(){btnaux.llenaMenu(ds_auxiliar,config_auxiliar);}
		});	
		
		
		
		
		this.btnActualizar();
		iniciarEventosFormularios();
		this.InitFunciones(paramFunciones)
	};
			
	
	//-------------- Sobrecarga de funciones --------------------//
	function btn_imprimir(){
		var data='start=0';
		//data+='&limit=1000';
		data+='&CantFiltros='+g_CantFiltros;		
		data+='&fecha_inicio='+g_fecha_inicio;
		data+='&fecha_fin='+g_fecha_fin;
		data+='&id_moneda='+g_id_moneda;
		data+='&id_cuenta='+maestro.id_cuenta;
		data+='&id_depto='+maestro.id_depto;
		data+='&desc_moneda='+g_desc_moneda;
		data+='&ids_auxiliar='+g_ids_auxiliar;
		data+='&cuenta_ini='+maestro.cuenta_ini;
		data+='&cuenta_fin='+maestro.cuenta_fin;
		data+='&por_rango='+maestro.por_rango;
		data+='&id_gestion='+maestro.id_gestion;
		data+='&nombre_depto='+maestro.nombre_depto;
		 
		if(g_ids_auxiliar==""){
			window.open(direccion+'../../../control/comprobante/reporte/ActionPDFLibroMayor.php?'+data);	
		}else{
			window.open(direccion+'../../../control/comprobante/reporte/ActionPDFLibroMayorPorAuxiliar.php?'+data);
		}	
	}
	
	function btn_imprimir_auxiliares(){
		var data='start=0';
		data+='&limit=1000';
		data+='&CantFiltros='+g_CantFiltros;		
		data+='&fecha_inicio='+g_fecha_inicio;
		data+='&fecha_fin='+g_fecha_fin;
		data+='&id_moneda='+g_id_moneda;
		data+='&id_cuenta='+maestro.id_cuenta;
		data+='&id_depto='+maestro.id_depto;
		data+='&desc_moneda='+g_desc_moneda;
		data+='&ids_auxiliar='+g_ids_auxiliar;
		data+='&cuenta_ini='+maestro.cuenta_ini;
		data+='&cuenta_fin='+maestro.cuenta_fin;
		data+='&por_rango='+maestro.por_rango;
		data+='&id_gestion='+maestro.id_gestion;
		data+='&nombre_depto='+maestro.nombre_depto;
		
		window.open(direccion+'../../../control/comprobante/reporte/ActionPDFLibroMayorAuxiliares.php?'+data);
	}
	
	function btn_imprimir_ot(){
		var data='start=0';
		data+='&limit=1000';
		data+='&CantFiltros='+g_CantFiltros;		
		data+='&fecha_inicio='+g_fecha_inicio;
		data+='&fecha_fin='+g_fecha_fin;
		data+='&id_moneda='+g_id_moneda;
		data+='&id_cuenta='+maestro.id_cuenta;
		data+='&id_depto='+maestro.id_depto;
		data+='&desc_moneda='+g_desc_moneda;
		data+='&ids_auxiliar='+g_ids_auxiliar;
		data+='&cuenta_ini='+maestro.cuenta_ini;
		data+='&cuenta_fin='+maestro.cuenta_fin;
		data+='&por_rango='+maestro.por_rango;
		data+='&id_gestion='+maestro.id_gestion;
		data+='&nombre_depto='+maestro.nombre_depto;
		
		window.open(direccion+'../../../control/comprobante/reporte/ActionPDFLibroMayorOT.php?'+data);	
	}
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	}
	
	this.btnActualizar = function()
	{
		
		ds.lastOptions={
			params:{start:0,limit: paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,
					id_moneda:maestro.id_moneda,
					id_cuenta:maestro.id_cuenta,
					fecha_inicio:g_fecha_inicio,
					fecha_fin:g_fecha_fin,
					id_depto:maestro.id_depto,
					por_rango:maestro.por_rango,
					cuenta_ini:maestro.cuenta_ini,
					cuenta_fin:maestro.cuenta_fin,
					id_gestion:maestro.id_gestion,
					ids_auxiliar:g_ids_auxiliar
			 }
		};
		CM_btnActualizar();
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_LibroMayor.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	
	//para agregar botones
	padre=this;

	this.iniciaFormulario();
	iniciarEventosFormularios();
	
 
	ds_auxiliar.load({
		params:{
		start:0,
		limit: paramConfig.TamanoPagina,
		CantFiltros:paramConfig.CantFiltros,
		m_sw_rep_libro_mayor:'si',
		m_id_moneda:maestro.id_moneda,
		m_id_cuenta:maestro.id_cuenta,
		m_fecha_inicio:fi?fi.dateFormat('m/d/Y'):'',
		m_fecha_fin:ff?ff.dateFormat('m/d/Y'):'',
		cuenta_ini:maestro.cuenta_ini,
		cuenta_fin:maestro.cuenta_fin,
		m_id_depto:maestro.id_depto,
		por_rango:maestro.por_rango
		},
 		callback: function(){padre.AdicionarMenuBoton(ds_auxiliar,config_auxiliar);}
	});	


	var ds_moneda_consulta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),baseParams:{estado:'activo'}});
	var tpl_id_moneda_reg=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
		
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

	ds_moneda_consulta.load({params:{start:0,limit: 1000000}});
	//monedas.on('select',function (combo, record, index){g_id_moneda=monedas.getValue();g_desc_moneda=record.data['nombre'];menuBotones()});
	
	monedas.on('select',
		function (combo, record, index){
			g_id_moneda=monedas.getValue();
		 	g_desc_moneda=record.data['nombre'];
		 	//paginaPadre.setMoneda(g_id_moneda,g_desc_moneda);
			
			ds.load({
				params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						id_moneda:record.data.id_moneda,
						id_cuenta:maestro.id_cuenta,
						fecha_inicio:g_fecha_inicio,
						fecha_fin:g_fecha_fin,
						id_depto:maestro.id_depto,
						cuenta_ini:maestro.cuenta_ini,
						cuenta_fin:maestro.cuenta_fin,
						por_rango:maestro.por_rango
						},
				callback : function ()
						{
							
						}
			});			
		});
		
	//monedas.setValue(g_id_moneda);
								
	padre.AdicionarBoton('../../../lib/imagenes/print.gif','Libros Mayor',btn_imprimir,true,'imprimir','Mayor');	
	padre.AdicionarBoton('../../../lib/imagenes/print.gif','Libros Mayor por Auxiliares',btn_imprimir_auxiliares,true,'imprimir','Auxiliares');
	padre.AdicionarBoton('../../../lib/imagenes/print.gif','Libros Mayor por OT',btn_imprimir_ot,true,'imprimir','OTs');
	this.AdicionarBotonCombo(monedas,'monedas');	
	ds.load({params:{start:0,limit: paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,
		id_moneda:maestro.id_moneda,
		id_cuenta:maestro.id_cuenta,
		fecha_inicio:g_fecha_inicio,
		fecha_fin:g_fecha_fin,
		id_depto:maestro.id_depto,
		por_rango:maestro.por_rango,
		cuenta_ini:maestro.cuenta_ini,
		cuenta_fin:maestro.cuenta_fin,
		id_gestion:maestro.id_gestion 
	}});
															
	layout_LibroMayor.getLayout().addListener('layout',this.onResize);
}