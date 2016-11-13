/**
 * Nombre:		  	    pagina_detalle_partida_formulacion.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-07-18 11:04:06
 */
function paginaConsolidacionPresupuesto(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
 
	var	g_limit='';
	var	g_CantFiltros='';
	
	var	g_id_parametro=1;
	var	g_id_parametro_desc='Ninguno';
	var	g_id_eeff=1;
	var	g_id_eeff_desc='Ninguno';
	var	g_id_depto=1;
	var	g_id_codigo_depto='Ninguno';
	
	var	g_fecha=new Date();
	var	g_fecha_rep=new Date();
	
	var g_fecha_ini=new Date();
	var g_fecha_rep_ini =new Date();
	
	
	var	g_id_moneda=1;
	var	g_id_moneda_desc='Ninguno';
	var	g_nivel=2;
	var	g_sw_actualizacion='con_actualización';
	var g_id_eeff_desc ='Ninguno'
	
	var	g_ids_depto='';
	var	g_ids_fuente_financiamiento='';
	var	g_ids_u_o='';
	var	g_ids_financiador='';
	var	g_ids_regional='';
	var	g_ids_programa='';
	var	g_ids_proyecto='';
	var	g_ids_actividad='';

 	var g_depto='';
 	var g_regional='';
	var g_financiador='';
	var g_programa='';
	var g_proyecto='';
	var g_actividad='';
	var g_unidad_organizacional='';
	var g_Fuente_financiamiento='';

	var g_desc_moneda=maestro.desc_moneda;

	var g_desc_estado_gral=maestro.desc_estado_gral;
	var epe=" ";
	var g_departamento='';
	
	var sw=0;	
			
		 
		
 
	
	/****************/
	
	/****************/
	
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/eeff/ActionListarEEFF.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_cuenta',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_cuenta',
		'id_cuenta_padre',
		'nro_cuenta',
		'nombre_cuenta',
		'nivel_cuenta',
		'saldo'
		 
		]),remoteSort:true});
 
	//carga datos XML
 	/*crea los data store*/
	var ds_depto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamento.php?m_id_subsistema=9'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_depto',totalRecords:'TotalCount'},['id_depto','codigo_depto','nombre_depto','estado','id_subsistema','nombre_corto','nombre_largo','despliegue_rep']),remoteSort:true});	

	 
	
	var tpl_id_depto=new Ext.Template('<div class="search-item">','<b><i>{codigo_depto}</i></b>','</div>');	
	
	
	 
	config_depto={nombre:'Depto',descripcion:'despliegue_rep',id:'id_depto',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};	
	
	function menuBotones()
	{
		 
	 	g_limit= paramConfig.TamanoPagina;
	 	g_CantFiltros=paramConfig.CantFiltros;
	 	
	 
   		g_ids_depto=padre.getBotonMenuBotonNombre('Depto').menuBoton.getSelecion();
   		
   		g_depto=padre.getBotonMenuBotonNombre('Depto').menuBoton.getSeleccionadosDesc();
   		//alert (g_depto);

	 
   		
		ds.baseParams={//start:0,
			limit: g_limit,
			CantFiltros:g_CantFiltros,
			
			id_parametro:g_id_parametro,
			id_reporte_eeff:g_id_eeff,
			fecha_trans:g_fecha,
			fecha_trans_ini:g_fecha_ini,
			
			id_moneda:g_id_moneda,
			//id_depto:g_id_depto,
			nivel:g_nivel,
			sw_actualizacion:g_sw_actualizacion,
			
			ids_fuente_financiamiento:g_ids_fuente_financiamiento,
			ids_u_o:g_ids_u_o,
			ids_financiador:g_ids_financiador,
			ids_regional:g_ids_regional,
			ids_programa:g_ids_programa,
			ids_proyecto:g_ids_proyecto,
			ids_actividad:g_ids_actividad,
			ids_depto:g_ids_depto	
		};
		//ds.lastOptions={};
	 

	
	if(g_regional){epe=epe+"<texto_em> REGIONAL: </texto_em>"+g_regional};
	if(g_financiador){epe=epe+"<texto_em>  FINANCIADOR:</texto_em>"+g_financiador};
	if(g_programa){epe=epe+"<texto_em>  PROGRAMA:</texto_em>"+g_programa};
	if(g_proyecto){epe=epe+"<texto_em>  SUBPROGRAMA:</texto_em>"+g_proyecto};
	if(g_actividad){epe=epe+"<texto_em>  ACTIVIDAD:</texto_em>"+g_actividad};
	/***********/
 
	if(epe==" "){epe="Todos"}
	if(g_unidad_organizacional==""){g_unidad_organizacional="Todos"}
	if(g_Fuente_financiamiento==""){g_Fuente_financiamiento="Todos"}
	
	
	
	 
	
	
	 var data_maestro=[ ['EEFF ',g_id_eeff_desc+' Detalle Nivel:'+g_nivel+'; SW Actualización:'+g_sw_actualizacion,'Moneda',g_id_moneda_desc+tabular(44-g_id_moneda_desc.length),
	 					'Gestión',g_id_parametro_desc+'Fecha Inicio'+g_fecha_ini+' Fecha Fin'+g_fecha+tabular(44-g_id_parametro_desc.length+7+g_fecha.length+g_fecha_ini.length)],
					   ['Estructura Programatica',epe] ,
					   ['Estructura Organizacional',g_unidad_organizacional ] ,
					   ['Fuente Financiamiento',g_Fuente_financiamiento]
					    ];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));
	}
	//carga datos XML
	
	// DEFINICIÓN DATOS DEL MAESTRO
function 	 MaestroJulio(data){
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
	
		var data_maestro=[ ['EEFF ',g_id_eeff_desc+' Detalle Nivel:'+g_nivel+'; SW Actualización:'+g_sw_actualizacion,'Moneda',g_id_moneda_desc+tabular(44-g_id_moneda_desc.length),
	 					'Gestión',g_id_parametro_desc+' Fecha'+g_fecha+tabular(44-g_id_parametro_desc.length+7+g_fecha.length)],
					   ['Estructura Programatica',epe] ,
					   ['Estructura Organizacional',g_unidad_organizacional ] ,
					   ['Fuente Financiamiento',g_Fuente_financiamiento]
					    ];	
 
					   
	//DATA STORE COMBOS

    var ds_partida = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/partida/ActionListarPartida.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_partida',totalRecords: 'TotalCount'},['id_partida','codigo_partida','nombre_partida','desc_partida','nivel_partida','sw_transaccional','tipo_partida','id_parametro','id_partida_padre','tipo_memoria','sw_movimiento'])
			});

    var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/presupuesto/ActionListarPresupuesto.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','fecha_presentacion','tipo_pres','estado_pres','id_unidad_organizacional','id_fuente_financiamiento','id_parametro','id_fina_regi_prog_proy_acti'])
	});

    var ds_partida_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/partida_presupuesto/ActionListarPartidaPresupuesto.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_partida_presupuesto',totalRecords: 'TotalCount'},['id_partida_presupuesto','codigo_formulario','fecha_elaboracion','id_partida','id_presupuesto'])
	});

    var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	});

	//FUNCIONES RENDER
	
		function render_id_partida(value,cell,record,row,colum,store)
		{		if(store.getAt(row).data['sw_transaccional'] == 1){
			return  '<span style="color:green;"><pre><font face="Arial">'+record.data['nombre_partida']+'</font></pre></span>'
	 
		
		}	
		if(store.getAt(row).data['sw_transaccional'] == 2){return String.format('{0}','<pre><font face="Arial">'+record.data['nombre_partida']+'</font></pre>')}
		 
			 
		};
		
		 
		
		
		
		var tpl_id_partida=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{nombre_partida}</FONT><br>','</div>');

		function render_id_presupuesto(value, p, record){return String.format('{0}', record.data['desc_presupuesto']);}
		var tpl_id_presupuesto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{}</FONT><br>','</div>');

		function render_id_partida_presupuesto(value, p, record){return String.format('{0}', record.data['desc_partida_presupuesto']);}
		var tpl_id_partida_presupuesto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{}</FONT><br>','</div>');

		function render_id_moneda(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
		var tpl_id_moneda=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{nombre}</FONT><br>','</div>');

			function renderTipoMemoria(value, p, record){
		if(value == 1){return  "Recursos"}
		if(value == 2){return "Gastos"}
		if(value == 3){return "Inversiones"}
		if(value == 4){return "Viajes"}
		if(value == 5){return "RRHH"}
		if(value == 6){return "OTROS"}
		}		
		
		function renderSwTranssacional(value,cell,record,row,colum,store){
		if(store.getAt(row).data['sw_transaccional'] == 1){
			return  '<span style="color:green;">' +value+'</span>'}	
		if(store.getAt(row).data['sw_transaccional'] == 2){return value}
		 
		}	
		 
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_partida_presupuesto
	//en la posición 0 siempre esta la llave primaria

 

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
		Atributos[1]={
		validacion:{
			labelSeparator:'',
			name: 'id_cuenta_padre',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_cuenta_padre'
	} ;
 
	

	Atributos[2]={
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
			//renderer: renderSwTranssacional,
			disable:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'nro_cuenta',
		save_as:'nro_cuenta'
	};
		Atributos[3]={
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
			//renderer: renderSwTranssacional,
			disable:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'nombre_cuenta',
		save_as:'nombre_cuenta'
	};
 
	 
	 
		

// txt mes_01
	Atributos[4]={
		validacion:{
			name:'nivel_cuenta',
			fieldLabel:'Nivel',
			allowBlank:false,
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
			//renderer: renderSwTranssacional,
			width_grid:100,
			width:'80%',
			disabled:false		
		},
		tipo: 'NumberField',
		form: true,
		filtro_0:false,
		filterColValue:'nivel_cuenta',
		save_as:'nivel_cuenta'
	};
// txt mes_02
	Atributos[5]={
		validacion:{
			name:'saldo',
			desc:'saldo',
			fieldLabel:'Importe',
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
			grid_editable:true,
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
	var config={titulo_maestro:'Parametros (Maestro)',titulo_detalle:'Consolidación Presupuesto (Detalle)',grid_maestro:'grid-'+idContenedor};
	var layout_consolidacionPresupuesto = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_consolidacionPresupuesto.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_consolidacionPresupuesto,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	var ClaseMadre_btnActualizar=this.btnActualizar;
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={
		/*guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},*/
		actualizar:{crear:true,separador:false},
		excel:{crear:true,separador:false}
	};
	this.btnActualizar=function(){
		if (sw==0){ 
			ds.load({params:ds.baseParams});
			sw =1;
		}
		else{ 
			ClaseMadre_btnActualizar(); 
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
			 data+='&id_reporte_eeff='+g_id_eeff;
			 data+='&ids_depto='+g_ids_depto;
			 data+='&fecha_trans='+g_fecha;
			 data+='&fecha_trans_ini='+g_fecha_ini;
			 data+='&id_moneda='+g_id_moneda;
			 data+='&nivel='+g_nivel;
			 data+='&sw_actualizacion='+g_sw_actualizacion;
			 
			 
			 data+='&ids_fuente_financiamiento='+g_ids_fuente_financiamiento;
			 data+='&ids_u_o='+g_ids_u_o;
			 data+='&ids_financiador='+g_ids_financiador;
			 data+='&ids_regional='+g_ids_regional;
			 data+='&ids_programa='+g_ids_programa;
			 data+='&ids_proyecto='+g_ids_proyecto;
			 data+='&ids_actividad='+g_ids_actividad;
			 //data+='&fecha_rep='+g_fecha;
			 //data+='&fecha_rep='+g_fecha.dateFormat('d/m/Y');
			 data+='&fecha_rep='+g_fecha_rep;
			 data+='&fecha_rep_ini='+g_fecha_rep_ini;
			 
	if(g_unidad_organizacional==""){g_unidad_organizacional="Todos"}
	if(g_Fuente_financiamiento==""){g_Fuente_financiamiento="Todos"}
 
					   
	data+='&EEFF='+g_id_eeff_desc;					   
	data+='&nivel='+g_nivel;
	data+='&sw_actualizacion='+g_sw_actualizacion;
	data+='&desc_moneda='+g_id_moneda_desc;
	data+='&gestion='+g_id_parametro_desc;
	data+='&fecha='+g_fecha;
	data+='&regional='+g_regional;
	data+='&financiador='+g_financiador;
	data+='&programa='+g_programa;
	data+='&proyecto='+g_proyecto;
	data+='&actividad='+g_actividad;
	data+='&unidad_organizacional='+g_unidad_organizacional;
	data+='&Fuente_financiamiento='+g_Fuente_financiamiento;
	data+='&departamento='+g_depto;
	
	if (g_depto!=''){
		if (g_id_parametro_desc!='Ninguno')
		       if (g_id_eeff_desc!='Ninguno'){
				window.open(direccion+'../../../control/eeff/ActionEEFF.php?'+data);
		       }else{
		       	Ext.MessageBox.alert('Estado', 'Debe seleccionar tipo de reporte.');
		       }
		else{
			Ext.MessageBox.alert('Estado', 'Debe seleccionar una Gestion.');
		}
	}else
		{
	 		Ext.MessageBox.alert('Estado', 'Debe seleccionar por lo menos un Departamento.');
		}	
 	
	
	

	}
	/*******************/
	
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
var ds_eeff = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/reporte_eeff/ActionListarEeff.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_reporte_eeff',totalRecords:'TotalCount'},['id_reporte_eeff','nombre_eeff']),remoteSort:true});
var tpl_id_eeff=new Ext.Template('<div class="search-item">','<b><i>{nombre_eeff}</i></b>','</div>');

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
var eeff =new Ext.form.ComboBox({
			store: ds_eeff,
			displayField:'nombre_eeff',
			typeAhead: false,
			mode: 'local',
			triggerAction: 'all',
			emptyText:'EEFF...',
			selectOnFocus:true,
			width:100,
			valueField: 'id_reporte_eeff',
			tpl:tpl_id_eeff
			
		});		
 
var fecha=	new Ext.form.DateField({
			name:'fecha',
			fieldLabel:'Fecha EEFF',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '31/01/2009',
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
			minValue: '31/01/2009',
			//maxValue: '30/11/2008',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:55,
			disabled:false});	
						
var nivel =new Ext.form.ComboBox({store: new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['2','N - 2'],['3','N - 3'],['4','N - 4'],['5','N - 5'],['6','N - 6'],['7','N - 7'],['8','N - 8']]}),	typeAhead: false,mode: 'local',triggerAction: 'all',	emptyText:'nivel...',selectOnFocus:true,width:60,valueField:'ID',displayField:'valor',mode:'local'});		
var sw_actualizacion =new Ext.form.ComboBox({store: new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['si','Con Actualización'],['no','Sin Actualización']]}),	typeAhead: false,mode: 'local',triggerAction: 'all',	emptyText:'SW...',selectOnFocus:true,width:60,valueField:'ID',displayField:'valor',mode:'local'});		
		ds_parametro.load({params:{start:0,limit: 1000000}});
	 	ds_moneda_consulta.load({params:{start:0,limit: 1000000}});
	 	ds_eeff.load({params:{start:0,limit: 1000000}});

		
		parametro.on('select',function (combo, record, index){g_id_parametro=parametro.getValue();g_id_parametro_desc=record.data['desc_gestion'];menuBotones()});
		eeff.on('select',function (combo, record, index){g_id_eeff=eeff.getValue();g_id_eeff_desc=record.data['nombre_eeff'];menuBotones()});		
		//depto.on('select',function (combo, record, index){g_id_depto=depto.getValue();g_id_codigo_depto=record.data['codigo_depto'];menuBotones()});		
		fecha.on('change',function (){
								g_fecha=fecha.getValue()?fecha.getValue().dateFormat('m/d/Y'):'';
								g_fecha_rep=fecha.getValue()?fecha.getValue().dateFormat('d/m/Y'):'';
		                        menuBotones()}
		        );
		fecha_ini.on('change',function (){
								g_fecha_ini=fecha_ini.getValue()?fecha_ini.getValue().dateFormat('m/d/Y'):'';
								g_fecha_rep_ini=fecha_ini.getValue()?fecha_ini.getValue().dateFormat('d/m/Y'):'';
		                        menuBotones()}
		        );
		monedas.on('select',function (combo, record, index){g_id_moneda=monedas.getValue();g_id_moneda_desc=record.data['nombre'];menuBotones()});
		nivel.on('select',function (combo, record, index){g_nivel=nivel.getValue();menuBotones()});
		sw_actualizacion.on('select',function (combo, record, index){g_sw_actualizacion=sw_actualizacion.getValue();menuBotones()});
		

 
parametro.setValue(1);
eeff.setValue(1);
fecha.setValue(new Date);
fecha_ini.setValue(new Date);
monedas.setValue(1);
nivel.setValue(2);
sw_actualizacion.setValue('con_actualizacion');
		
	
								
padre.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte ',btn_imprimir,true,'imprimir','');	
this.AdicionarBotonCombo(parametro,'gestion');		
this.AdicionarBotonCombo(eeff,'EEFF');		
this.AdicionarBotonCombo(fecha_ini,'Fecha Inicio');		
this.AdicionarBotonCombo(fecha,'Fecha');		
this.AdicionarBotonCombo(monedas,'monedas');														
this.AdicionarBotonCombo(nivel,'nivel');														
this.AdicionarBotonCombo(sw_actualizacion,'Actualización');														
														
														
layout_consolidacionPresupuesto.getLayout().addListener('layout',this.onResize);
	//layout_consolidacionPresupuesto.getVentana(idContenedor).on('resize',function(){layout_consolidacionPresupuesto.getLayout().layout()})
	
}