/**
 * Nombre:		  	    pagina_detalle_partida_formulacion.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-07-18 11:04:06
 */
function paginaEstadoComprobacionSumasySaldos(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var	g_limit='';
	var	g_CantFiltros='';
	var	g_id_parametro=1;
	var	g_id_parametro_desc='Ninguno';
 
	var	g_id_depto=1;
	var	g_id_codigo_depto='Ninguno';
	var	g_fecha=new Date();
	var g_fecha_ini=new Date();
	
	var	g_id_moneda=1;
	var	g_id_moneda_desc='Ninguno';
	var	g_nivel=0;
	var g_des_nivel='Auxiliar';
	var	g_sw_actualizacion='si';
	var g_depto=""; 
	var	g_ids_depto='';
	var g_departamento='';

	var g_desc_estado_gral=maestro.desc_estado_gral;			
	var sw=0; 
	var g_mensaje='';

	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/eeff/ActionListarEEFFSumaSaldos.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'nro_cuenta',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'nro_cuenta',
		'nombre_cuenta',
		'importe_debe',
		'importe_haber',
		'saldo_debe',
		'saldo_haber'		 
		]),remoteSort:false});
 
	//carga datos XML
 	/*crea los data store*/
	var ds_depto = 	new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamento.php?m_id_subsistema=9'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_depto',totalRecords:'TotalCount'},['id_depto','codigo_depto','nombre_depto','estado','id_subsistema','nombre_corto','nombre_largo','despliegue_rep']),remoteSort:true});	
	 
	var tpl_id_depto=new Ext.Template('<div class="search-item">','<b><i>{codigo_depto}</i></b>','</div>');	
	
	var monedas_for=new Ext.form.MonedaField({
		name:'importe',
		fieldLabel:'valor',	
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
	
	config_depto={nombre:'Depto',descripcion:'despliegue_rep',id:'id_depto',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};	
	
	function menuBotones(){	 
	 	g_limit= paramConfig.TamanoPagina;
	 	g_CantFiltros=paramConfig.CantFiltros;
	 	
   		g_ids_depto=padre.getBotonMenuBotonNombre('Depto').menuBoton.getSelecion();
   		g_depto=padre.getBotonMenuBotonNombre('Depto').menuBoton.getSeleccionadosDesc();

		ds.baseParams={
			limit: g_limit,
			CantFiltros:g_CantFiltros,
			id_parametro:g_id_parametro,
			fecha_trans:g_fecha,
			fecha_trans_ini:g_fecha_ini,
			id_moneda:g_id_moneda,
			nivel:g_nivel,
			sw_actualizacion:g_sw_actualizacion,
			ids_depto:g_ids_depto
		};

		var data_maestro=[ ['Detalle Nivel',g_nivel,'Actualización',g_sw_actualizacion,'Moneda',g_id_moneda_desc],
		                   ['Gestión',g_id_parametro_desc, 'Fecha','Del: '+g_fecha_ini+tabular(5)+' Al: '+g_fecha],
		                   ['Dpto(s)', g_depto]
					    ];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));
	}
	//carga datos XML
	// DEFINICIÓN DATOS DEL MAESTRO
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
	
	function tabular(n){
		if (n>=0)	{return "  "+tabular(n-1)}
		else return "  "
	}

	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	
	var data_maestro=[ ['Detalle Nivel',g_nivel,'Actualización',g_sw_actualizacion,'Moneda',g_id_moneda_desc],
	                   ['Gestión',g_id_parametro_desc, 'Fecha','Del: '+g_fecha_ini+tabular(5)+' Al: '+g_fecha],
	                   ['Dpto(s)', g_depto]
					    ];	
 	   
	//DATA STORE COMBOS
    var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});

	//FUNCIONES RENDER
	function render_id_moneda(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{nombre}</FONT><br>','</div>');

	function render_total(value,cell,record,row,colum,store){
		if(value < 0){return '<span style="color:red;">' + monedas_for.formatMoneda(value)+'</span>'}	
		if(value >= 0){return monedas_for.formatMoneda(value)}
	}
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_partida_presupuesto
	//en la posición 0 siempre esta la llave primaria
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
			grid_editable:false,
			width_grid:200,
			width:'50%',
			//renderer: renderSwTranssacional,
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
			grid_editable:false,
			width_grid:400,
			width:'50%',
			//renderer: renderSwTranssacional,
			disable:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'nombre_cuenta',
		save_as:'nombre_cuenta'
	};
  
	Atributos[2]={
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
			renderer: render_total,
			width_grid:120,
			width:'80%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'importe_debe'
	}; 

	Atributos[3]={
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
			renderer: render_total,
			width_grid:120,
			width:'80%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: true,
		filtro_0:false,
		filterColValue:'importe_haber'
	};  
 
	Atributos[4]={
		validacion:{
			name:'saldo_debe',
			fieldLabel:'Saldo Debe',
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
		filterColValue:'saldo_debe'
	}; 

	// txt saldo_haber
	Atributos[5]={
		validacion:{
			name:'saldo_haber',
			fieldLabel:'Saldo Haber',
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
		filterColValue:'saldo_haber'
	};
	
	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Parametros (Maestro)',titulo_detalle:'Balance de Sumas y Saldos',grid_maestro:'grid-'+idContenedor};
	var layout_consolidacionPresupuesto = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_consolidacionPresupuesto.init(config);
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_consolidacionPresupuesto,idContenedor);
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getColumnNum=this.getColumnNum;
	var ClaseMadre_getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var ClaseMadre_getGrid=this.getGrid;

	//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={
		actualizar:{crear:true,separador:false},
		excel:{crear:true,separador:false}
	};
	
	this.btnActualizar=function(){
		g_mensaje="";
		if (g_id_parametro_desc=="Ninguno"){g_mensaje += ' -Gestión'};
		if (g_id_moneda_desc=="Ninguno"){g_mensaje += ' -Moneda'};
		if (g_ids_depto==""){g_mensaje += ' -Departamento(s)'};
		
		if (g_mensaje==""){
			if (sw==0){ 
				ds.load({params:ds.baseParams });
				sw =1;
				}
			else{ 
				ds.rejectChanges()//vacia el vector de records modificados
				ds.load(ds.lastOptions);//actualizar
				//ClaseMadre_btnActualizar(); 
			}
		}else{
			Ext.MessageBox.alert("Falta indicar: ", g_mensaje);
		}
	}

	//DEFINICIÓN DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));
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
		data+='&ids_depto='+g_ids_depto;
		data+='&fecha_trans='+g_fecha;
		data+='&fecha_trans_ini='+g_fecha_ini;
		data+='&id_moneda='+g_id_moneda;
		data+='&nivel='+g_nivel;
		data+='&sw_actualizacion='+g_sw_actualizacion;
		data+='&desc_moneda='+g_id_moneda_desc;
		data+='&departamento='+g_depto;	 
		data+='&fecha_rep='+g_fecha;
		data+='&fecha_rep_ini='+g_fecha_ini;
		
		if (g_depto!=''){
			if (g_id_parametro_desc!='Ninguno')
				window.open(direccion+'../../../control/eeff/ActionEEFFSumaSaldos.php?'+data);  
			else{
				Ext.MessageBox.alert('Estado', 'Debe seleccionar una Gestion.');
			}
		}else{
	 		Ext.MessageBox.alert('Estado', 'Debe seleccionar por lo menos un Departamento.');
		}		
	}

	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_consolidacionPresupuesto.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	padre=this;

	this.iniciaFormulario();
	iniciarEventosFormularios();
	ds_depto.load({
		params:{
		start:0,
		limit: paramConfig.TamanoPagina,
		CantFiltros:paramConfig.CantFiltros,
		},
		callback: function(){padre.AdicionarMenuBoton(ds_depto,config_depto);}
	});
	
	var ds_moneda_consulta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),baseParams:{estado:'activo'}});
	var tpl_id_moneda_reg=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
	var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php?tipo_vista=conta_parametro'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_parametro',totalRecords:'TotalCount'},['id_parametro','id_gestion','desc_gestion','cantidad_nivel','estado_gestion','gestion_conta','porcen_iva','porcen_it','porcen_servicio','porcen_bien','porcen_remesa','id_moneda','nombre_moneda'])});
	var tpl_id_parametro_reg=new Ext.Template('<div class="search-item">','<b><i>{desc_gestion}</i></b>','</div>');
	
	//monedas
	var monedas =new Ext.form.ComboBox({
		store: ds_moneda_consulta,
		displayField:'nombre',
		typeAhead: false,
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
		typeAhead: false,
		mode: 'local',
		triggerAction: 'all',
		emptyText:'gestión...',
		selectOnFocus:true,
		width:60,
		valueField: 'id_parametro',
		tpl:tpl_id_parametro_reg
	});
 	
	var fecha=	new Ext.form.DateField({
		name:'fecha',
		fieldLabel:'Fecha EEFF',
		allowBlank:false,
		format: 'd/m/Y', //formato para validacion
		minValue: '01/01/2009',
		//maxValue: '30/11/2008',
		disabledDaysText: 'Día no válido',
		grid_visible:true,
		grid_editable:false,
		renderer: formatDate,
		width_grid:55,
		disabled:false});		
	
	var fecha_ini=	new Ext.form.DateField({
		name:'fecha_ini',
		fieldLabel:'Fecha Inicial EEFF ',
		allowBlank:false,
		format: 'd/m/Y', //formato para validacion
		minValue: '01/01/2009',
		//maxValue: '30/11/2008',
		disabledDaysText: 'Día no válido',
		grid_visible:true,
		grid_editable:false,
		renderer: formatDate,
		width_grid:55,
		disabled:false});	
						
	var nivel =new Ext.form.ComboBox({store: new Ext.data.SimpleStore({fields:['ID','valor','filtro'],
		data:[['0','0-Auxiliar'],['1','1-Cuenta']]}),	typeAhead: false,mode: 'local',triggerAction: 'all',emptyText:'nivel...',selectOnFocus:true,width:70,valueField:'ID',displayField:'valor',mode:'local'});		

	var sw_actualizacion =new Ext.form.ComboBox({store: new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['si','C/Actualización'],['no','S/Actualización']]}),	typeAhead: false,mode: 'local',triggerAction: 'all',emptyText:'SW...',selectOnFocus:true,width:100,valueField:'ID',displayField:'valor',mode:'local'});		
	
	ds_parametro.load({params:{start:0,limit: 1000000}});
	ds_moneda_consulta.load({params:{start:0,limit: 1000000}});

	parametro.on('select', function (combo, record, index){
		g_id_parametro=parametro.getValue();
		g_id_parametro_desc=record.data['desc_gestion'];
		var dte_fecha_ini_valid=new Date('01/01/'+g_id_parametro_desc+' 00:00:00');
		var dte_fecha_fin_valid=new Date('12/31/'+g_id_parametro_desc+' 00:00:00');
		
		fecha_ini.minValue=dte_fecha_ini_valid; //Fecha inicio
		fecha_ini.maxValue=dte_fecha_fin_valid;
		fecha.minValue=dte_fecha_ini_valid;
		fecha.maxValue=dte_fecha_fin_valid;
			
		//Define un valor por defecto
		fecha_ini.setValue(dte_fecha_ini_valid);
		fecha.setValue(dte_fecha_fin_valid);
		g_fecha=fecha.getValue()?fecha.getValue().dateFormat('m/d/Y'):'';
		g_fecha_ini=fecha_ini.getValue()?fecha_ini.getValue().dateFormat('m/d/Y'):'';
		menuBotones()
	});
					
	fecha.on('change',function (){
		g_fecha=fecha.getValue()?fecha.getValue().dateFormat('m/d/Y'):'';
        menuBotones()}
	);
	
	fecha_ini.on('change',function (){
		g_fecha_ini=fecha_ini.getValue()?fecha_ini.getValue().dateFormat('m/d/Y'):'';
        menuBotones()}
	);
	
	monedas.on('select',function (combo, record, index){g_id_moneda=monedas.getValue();g_id_moneda_desc=record.data['nombre'];menuBotones()});
	nivel.on('select',function (combo, record, index){g_nivel=nivel.getValue();g_des_nivel_desc=record.data['valor'];menuBotones()});
	sw_actualizacion.on('select',function (combo, record, index){g_sw_actualizacion=sw_actualizacion.getValue();menuBotones()});

	parametro.setValue(1);

	fecha.setValue(new Date);
	fecha_ini.setValue(new Date);
	monedas.setValue(1);
	nivel.setValue(0);
	sw_actualizacion.setValue('C/Actualizacion');
								
	padre.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte ',btn_imprimir,true,'imprimir','');	
		
	this.AdicionarBotonCombo(parametro,'gestion');		
	this.AdicionarBotonCombo(fecha_ini,'Fecha Inicio');		
	this.AdicionarBotonCombo(fecha,'Fecha');		
	this.AdicionarBotonCombo(monedas,'monedas');														
	this.AdicionarBotonCombo(nivel,'nivel');														
	this.AdicionarBotonCombo(sw_actualizacion,'Actualización');																											
															
	layout_consolidacionPresupuesto.getLayout().addListener('layout',this.onResize);
	//layout_consolidacionPresupuesto.getVentana(idContenedor).on('resize',function(){layout_consolidacionPresupuesto.getLayout().layout()})	
}