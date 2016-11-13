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
	
	//departamento//
	var	g_id_departamento=-1;
	var	g_departamento='Ninguno';
	//gestion//
	var g_id_gestion=-1;
	var g_gestion='Ninguno';
	//periodo//
	var	g_id_periodo=-1;
	var	g_periodo='Ninguno';
	// modena //
	var g_id_moneda=-1;
	var g_moneda='Ninguno'
	//usuario//
	var g_id_usuario=-1;
	var g_usuario='Ninguno';
	
	//tipo planilla //
	var g_id_tipo_planilla=-1;
	var g_tipo_planilla='Ninguno'
	
	//g_guion
	var g_guion='  ';
	
	var	g_fecha_ini=new Date();
    var	g_fecha_fin=new Date();		
	var	g_fecha_ini_ver='d/m/Y';
	var g_fecha_fin_ver='d/m/Y';
	
	// habilitar el boton actualizar	
	var sw =0;
	
	// tipo plantilla
	var g_id_tipo_plantilla=-1;
	var g_tipo_plantilla='Ninguno';
	
	var monedas_for=new Ext.form.MonedaField(
	{
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
	
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/documento/ActionListarDocRespaldo.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_documento',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_documento',
		'desc_comprobante',
		'fecha_documento',
		'nro_nit',
		'nro_documento',
		'nro_autorizacion',
		'codigo_control',
		'razon_social',
		'importe_total',
		'importe_ice',
		'importe_no_gravado',
		'importe_sujeto',
		'importe_credito',
		'importe_debito'		 
		]),remoteSort:true});
 
	/*crea los data store funcion Render, y los tpl de cada uno*/
	//Gestion //	
	var	ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_parametro',totalRecords: 'TotalCount'}, ['id_parametro','id_gestion','desc_gestion','estado_gestion','gestion_conta'])});
	
	function render_id_gestion(value, p, record){return String.format('{0}', record.data['desc_gestion']);}
	var tpl_id_gestion=new Ext.Template('<div class="search-item">','<b><i></i></b>','<br><FONT COLOR="#B5A642">{desc_gestion}</FONT>','</div>');
	
	//Periodo//
	var ds_periodo_subsis = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/periodo_subsistema/ActionListarPeriodoGestionSubsis.php?id_subsistema=9'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_periodo_subsistema',totalRecords: 'TotalCount'}, ['id_periodo_subsistema','id_periodo','desc_periodo','estado_periodo','periodo'])});
	function render_id_periodo(value, p, record){return String.format('{0}', record.data['desc_periodo']);}

	//Moneda
   
	var ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
	   								reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
   									});
   
	function render_id_moneda(value,p,record){return String.format('{0}', record.data['desc_moneda']);}
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');

   
	//usuario//   
	var ds_usuario=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/depto_usuario/ActionListarDepartamentoUsuario.php?dr=true'}),
	   								  reader:new Ext.data.XmlReader({record:'ROWS',id:'id_usuario',totalRecords:'TotalCount'},['id_depto_usuario','id_depto','desc_depto','id_usuario','desc_usuario','apellido_paterno_persona','apellido_materno_persona','nombre_persona','estado','doc_id'])
   									});   
	function render_usuario(value, p, record){return String.format('{0}', record.data['desc_usuario']);}                                     
	var tpl_id_usuario=new Ext.Template('<div class="search-item">','<b><i>Usuario:</i></b>','<br><FONT COLOR="#B5A642">{desc_usuario}</FONT>','</div>');
   
	//ds departamento//
    var ds_depto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamento.php'}),
					reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_depto',totalRecords:'TotalCount'},['id_depto','codigo_depto','nombre_depto','estado','id_subsistema','nombre_corto','nombre_largo']),baseParams:{m_id_subsistema:9}});
	function render_id_depto(value, p, record){return String.format('{0}', record.data['nombre_depto']);}
	
	var tpl_id_depto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642"><b>Departamento Contable: </b></FONT"><br><FONT COLOR="#000000">{nombre_depto}</FONT>','</div>');
	config_depto={nombre:'Departamento',descripcion:'nombre_depto',id:'id_depto',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};
	    
	// tipo planitilla menu de checkbox
	var ds_tipo_plantilla = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:direccion+'../../../control/plantilla/ActionListarPlantilla.php?tipo=1'}),
					  reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_plantilla',totalRecords:'TotalCount'},['id_plantilla','tipo_plantilla','nro_linea','desc_plantilla','tipo','sw_tesoro','sw_compro']),remoteSort:true});
	var tpl_tipo_plantilla=new Ext.Template('<div class="search-item">','<b><i>{desc_plantilla}</i></b>','</div>');	
	config_tipo_plantilla={nombre:'Documentos',descripcion:'desc_plantilla',id:'id_plantilla',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};	
	
	function render_total(value,cell,record,row,colum,store){
		if(value < 0){return  '<span style="color:red;">' + monedas_for.formatMoneda(value)+'</span>'}	
		if(value >= 0){return monedas_for.formatMoneda(value)}
	}
		
	function menuBotones()
	{
	 	g_limit= paramConfig.TamanoPagina;
	 	g_CantFiltros=paramConfig.CantFiltros;	
	 	//datos de departamento menu checkbox
	 	g_id_departamento=padre.getBotonMenuBotonNombre('Departamento').menuBoton.getSelecion();   		
	 	g_departamento=padre.getBotonMenuBotonNombre('Departamento').menuBoton.getSeleccionadosDesc();
	 	//datos del tipo_plantilla menu checkbox
	 	g_id_tipo_plantilla=padre.getBotonMenuBotonNombre('Documentos').menuBoton.getSelecion();   		
   		g_tipo_plantilla=padre.getBotonMenuBotonNombre('Documentos').menuBoton.getSeleccionadosDesc();
   		
	 	ds.baseParams={start:0,
				limit: g_limit,
				CantFiltros:g_CantFiltros,
				
				id_departamento:g_id_departamento,
				id_gestion:g_id_gestion,
				id_periodo:g_id_periodo,
				id_moneda:g_id_moneda,				
				id_usuario:g_id_usuario,
				fecha_ini:g_fecha_ini,
				fecha_fin:g_fecha_fin,
				id_plantilla:g_id_tipo_plantilla
			};
   		
	//datos en la cabecera (PARAMETROS MAESTRO)
	var data_maestro=[ 
	                   ['Departamento ',g_departamento],
					   ['Gestion',g_gestion] ,
					   ['Periodo',g_periodo ] ,
					   ['Moneda',g_moneda],
					   ['Usuario',g_usuario],
					   ['Fecha Inicio',g_fecha_ini_ver],
					   ['Fecha Fin',g_fecha_fin_ver],
					   ['Documentos ',g_tipo_plantilla]
					  ];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));
	}
	//carga datos XML
	
	// DEFINICIÓN DATOS DEL MAESTRO
	function MaestroJulio(data){					
		var  html="<table class='izquierda'>"; 
		html=html+"</tr>";
		html=html+"<tr class='gris'>";				
		html=html+"<td class='atributo'  >  <pre><font face='Arial'> "+data[1][0]+"</font></pre> </td> ";
		html=html+"<td class='izquierda'  >  <pre><font face='Arial'> "+data[1][1]+"</font></pre> </td> ";
		html=html+"<td class='blanco'> <pre><font face='Arial'>"+g_guion+"</font></pre>       </td>";
		html=html+"<td class='atributo'  >  <pre><font face='Arial'> "+data[0][0]+"</font></pre> </td> ";
		html=html+"<td class='izquierda'  >  <pre><font face='Arial'> "+data[0][1]+"</font></pre> </td> ";
		html=html+"</tr>";
		
		html=html+" <tr class='blanco'>";								
		html=html+"<td class='atributo'  >  <pre><font face='Arial'> "+data[2][0]+"</font></pre> </td> ";
		html=html+"<td class='izquierda'  >  <pre><font face='Arial'> "+data[2][1]+"</font></pre> </td> ";
		html=html+"<td class='blanco'> <pre><font face='Arial'>"+g_guion+"</font></pre>       </td>";
		html=html+"<td class='atributo'  >  <pre><font face='Arial'> "+data[3][0]+"</font></pre> </td> ";
		html=html+"<td class='izquierda'  >  <pre><font face='Arial'> "+data[3][1]+"</font></pre> </td> ";
		html=html+"</tr>";			
		
		html=html+"<tr class='gris'>";				
		html=html+"<td class='atributo'  >  <pre><font face='Arial'> "+data[4][0]+"</font></pre> </td> ";
		html=html+"<td class='izquierda'  >  <pre><font face='Arial'> "+data[4][1]+"</font></pre> </td> ";
		html=html+"<td class='blanco'> <pre><font face='Arial'>"+g_guion+"</font></pre>       </td>";
		html=html+"<td class='atributo'  >  <pre><font face='Arial'> "+data[5][0]+"</font></pre> </td> ";
		html=html+"<td class='izquierda'  >  <pre><font face='Arial'> "+data[5][1]+"</font></pre> </td> ";
		html=html+"</tr>"; 
		
		html=html+" <tr class='blanco'>";								
		html=html+"<td class='atributo'  >  <pre><font face='Arial'> "+data[6][0]+"</font></pre> </td> ";
		html=html+"<td class='izquierda'  >  <pre><font face='Arial'> "+data[6][1]+"</font></pre> </td> ";
		html=html+"<td class='blanco'> <pre><font face='Arial'>"+g_guion+"</font></pre>       </td>";
		html=html+"<td class='atributo'  >  <pre><font face='Arial'> "+data[7][0]+"</font></pre> </td> ";
		html=html+"<td class='izquierda'  >  <pre><font face='Arial'> "+data[7][1]+"</font></pre> </td> ";
		html=html+"</tr>";

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
	
	var data_maestro=[ 
	                   ['Departamento ',g_departamento],
					   ['Gestion',g_gestion] ,
					   ['Periodo',g_periodo ] ,
					   ['Moneda',g_moneda],
					   ['Usuario',g_usuario],
					   ['Fecha Inicio',g_fecha_ini_ver],
					   ['Fecha Fin',g_fecha_fin_ver],
					   ['Documentos ',g_tipo_plantilla]
					  ];      
		
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	//en la posición 0 siempre esta la llave primaria
 	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_documento',			
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_documento'
	} ; 
		
 	Atributos[1]={
		validacion:{
			labelSeparator:'',
			fieldLabel:'Nº Cbte.',
			name: 'desc_comprobante',
			width_grid:100,
			grid_visible:true, 
			grid_editable:false
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'desc_comprobante',
		save_as:'desc_comprobante'
	} ;
	
 	Atributos[2]={
		validacion:{
			name:'fecha_documento',
			fieldLabel:'Fecha',
			allowBlank:true,
			maxLength:50,
			minLength:0,			
			vtype:'texto',
			grid_visible:true,			
			width_grid:100,						
			disable:false		
		},
		tipo: 'TextField',
		form: true,
		filtro_0:true,
		filterColValue:'fecha_documento',
		save_as:'fecha_documento'
	};
	 
	Atributos[3]={
		validacion:{
			name:'nro_nit',
			fieldLabel:'NIT',
			allowBlank:false,						
			selectOnFocus:true,
			allowDecimals:true,			
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,			
			width_grid:100,			
			disabled:false		
		},
		tipo: 'NumberField',		
		filtro_0:true,
		filterColValue:'nro_nit',
		save_as:'nro_nit'
	};

	Atributos[4]={
		validacion:{
			name:'nro_documento',
			fieldLabel:'Nº Documento',
			align:'left', 
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,		
			width_grid:80,
			disabled:false		
		},
		tipo: 'NumberField',	
		filtro_0:true,
		filterColValue:'nro_documento',
		save_as:'nro_documento'
	};
	
	Atributos[5]={
		validacion:{
			name:'nro_autorizacion',
			fieldLabel:'Nº Autorización',
			align:'left', 
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,				
			width_grid:100,
			disabled:false		
		},
		tipo: 'NumberField',	
		filtro_0:true,
		filterColValue:'nro_autorizacion',
		save_as:'nro_autorizacion'
	};
	
	Atributos[6]={
		validacion:{
			name:'nro_autorizacion',
			fieldLabel:'Numero de Documento',
			align:'right', 
			allowNegative:false,
			minValue:0,
			grid_visible:false,
			grid_editable:false,		
			width_grid:60,
			disabled:false		
		},
		tipo: 'NumberField',	
		filtro_0:true,
		filterColValue:'nro_autorizacion',
		save_as:'nro_autorizacion'
	};
	
	Atributos[7]={
		validacion:{
			name:'codigo_control',
			fieldLabel:'Codigo de Control',
			align:'left', 
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,		
			width_grid:120			
		},
		tipo: 'NumberField',	
		filtro_0:true,
		filterColValue:'codigo_control',
		save_as:'codigo_control'
	};
	
	Atributos[8]={
		validacion:{
			name:'razon_social',
			fieldLabel:'Razon Social',				
			grid_visible:true,
			grid_editable:false,		
			width_grid:200,		
		},
		tipo: 'TextField',	
		filtro_0:true,
		filterColValue:'razon_social',
		save_as:'razon_social'
	};
	
	Atributos[9]={
		validacion:{
			name:'importe_total',
			fieldLabel:'Importe Total',				
			grid_visible:true,
			grid_editable:false,		
			width_grid:120,
			align:'right', 
			renderer: render_total
		},
		tipo: 'NumberField',	
		filtro_0:true,
		filterColValue:'importe_total',
		save_as:'importe_total'
	};
	
	Atributos[10]={
		validacion:{
			name:'importe_ice',
			fieldLabel:'Importe ICE',				
			grid_visible:true,
			grid_editable:false,		
			width_grid:120,
			align:'right', 
			renderer: render_total,		
		},
		tipo: 'NumberField',	
		filtro_0:true,
		filterColValue:'importe_ice',
		save_as:'importe_ice'
	};
	
	Atributos[11]={
		validacion:{
			name:'importe_no_gravado',
			fieldLabel:'Importe No Gravado',				
			grid_visible:true,
			grid_editable:false,		
			width_grid:120,
			align:'right', 
			renderer: render_total,		
		},
		tipo: 'NumberField',	
		filtro_0:true,
		filterColValue:'importe_no_gravado',
		save_as:'importe_no_gravado'
	};
	
	Atributos[12]={
		validacion:{
			name:'importe_sujeto',
			fieldLabel:'Importe Sujeto',				
			grid_visible:true,
			grid_editable:false,		
			width_grid:120,
			align:'right', 
			renderer: render_total,		
		},
		tipo: 'NumberField',	
		filtro_0:true,
		filterColValue:'importe_sujeto',
		save_as:'importe_sujeto'
	};
	
	Atributos[13]={
		validacion:{
			name:'importe_credito',
			fieldLabel:'Importe Credito',				
			grid_visible:true,
			grid_editable:false,		
			width_grid:120,
			align:'right', 
			renderer: render_total,		
		},
		tipo: 'NumberField',	
		filtro_0:true,
		filterColValue:'importe_credito',
		save_as:'importe_credito'
	};
	Atributos[14]={
		validacion:{
			name:'importe_debito',
			fieldLabel:'Importe Debito',				
			grid_visible:true,
			grid_editable:false,		
			width_grid:120,
			align:'right', 
			renderer: render_total,		
		},
		tipo: 'NumberField',	
		filtro_0:true,
		filterColValue:'importe_debito',
		save_as:'importe_debito'
	};
	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Parametros (Maestro)',titulo_detalle:'DOCUMENTOS (Detalle)',grid_maestro:'grid-'+idContenedor};
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
		
		actualizar:{crear:true,separador:false},
		excel:{crear:true,separador:false}
	};
	this.btnActualizar=function()
	{ 
		if(g_id_departamento!=-1)
		{	
			if(g_id_gestion!=-1)
			{
				if(g_id_moneda!=-1)
				{
					 
						 if(g_id_tipo_plantilla!=-1)
							 { 
								if (g_id_periodo!=-1)
								{
							 				if (sw==0)
												{ 
													ds.load({params:ds.baseParams});
													sw =1;
												}
												else
												{ //sw=0;
													ClaseMadre_btnActualizar(); 
													//CM_btnActualizar=this.btnActualizar;
												}
								}
								else
								{
									if (g_fecha_ini_ver!='d/m/Y' && g_fecha_fin_ver!='d/m/Y')
									{
									    if (g_fecha_ini>g_fecha_fin)
									    { 
									    	Ext.MessageBox.alert('Estado', 'Fecha Inicial no puede ser mayor que Fecha Final');
									    }
									    else
									    {
									    	if (sw==0)
											{  
												ds.load({params:ds.baseParams});
												sw =1;
											}
											else
											{ClaseMadre_btnActualizar(); 
											}
									    }
									}
									else
									{
									 Ext.MessageBox.alert('Estado','debe seleccionar fechas validas');
									}
								}
							 }
						 else
						 {
							 Ext.MessageBox.alert('Estado', 'Debe seleccionar  Tipo Planilla');
						 }
					 
				}				
				else
				{
					Ext.MessageBox.alert('Estado', 'Debe seleccionar una Moneda');
				}
			}
			else
			{
				Ext.MessageBox.alert('Estado', 'Debe seleccionar una Gestion');
			}
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Debe seleccionar un Departamento');
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

	//fin del procedimiento enviar
	/*******************/
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	}

	//fin de recargar la pagina
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
	
	//Iniciar eventos del Departamento menu check Box
	ds_depto.load({
		params:{
		start:0,
		limit: paramConfig.TamanoPagina,
		CantFiltros:paramConfig.CantFiltros,
 		},
		callback: function(){padre.AdicionarMenuBoton(ds_depto,config_depto);}
			});
	//iniciar eventos del tipo plantilla menu check box
	ds_tipo_plantilla.load({
		params:{
		start:0,
		limit: paramConfig.TamanoPagina,
		CantFiltros:paramConfig.CantFiltros,
 		},
		callback: function(){padre.AdicionarMenuBoton(ds_tipo_plantilla,config_tipo_plantilla);}
			});
	// iniciar los combos en la barra de menu

	// combo Gestion
	var gestion =new Ext.form.ComboBox({
		store: ds_gestion,
		displayField:'desc_gestion',
		typeAhead: false,
		mode: 'remote',
		triggerAction: 'all',
		emptyText:'gestión...',
		selectOnFocus:true,
		width:90,
		valueField: 'id_gestion',
		tpl:tpl_id_gestion		
	});
	gestion.on('select',
			function (combo, record, index)
			{
			 g_id_gestion=gestion.getValue();
		     g_gestion=record.data['desc_gestion'];		     
		     menuBotones()
		     });
	//combo Periodo
	var periodo =new Ext.form.ComboBox({
		store: new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['1','ENERO'],['2','FEBRERO'],['3','MARZO'],['4','ABRIL'],['5','MAYO'], ['6','JUNIO'], ['7','JULIO'], ['8','AGOSTO'],['9','SEPTIEMBRE'], ['10','OCTUBRE'], ['11','NOVIEMBRE'], ['12','DICIEMBRE']]}),
		displayField:'valor',
		typeAhead: false,
		mode: 'local',
		triggerAction: 'all',
		emptyText:'Perido...',
		selectOnFocus:true,
		width:90,
		valueField:'ID'
	//	tpl:tpl_id_periodo		
	});
	periodo.on('select',
			function (combo, record, index)
			{
			 g_id_periodo=periodo.getValue();
		     g_periodo=record.data['valor'];
		     g_fecha_ini='01/01/2006';
		     g_fecha_fin='12/31/2050';
		     g_fecha_fin_ver='d/m/Y';
		     g_fecha_ini_ver='d/m/Y';
		     fechainicio.reset();		     
		     fechafin.reset();
		     menuBotones();
		     });
	
	//	combo moneda
	var monedas = new Ext.form.ComboBox({
			store: ds_moneda,
			displayField:'nombre',
			typeAhead: false,
			mode: 'remote',
			triggerAction: 'all',
			emptyText:'Moneda...',
			selectOnFocus:true,
			width:90,
			valueField: 'id_moneda',
			tpl:tpl_id_moneda			
		});
	monedas.on('select',
		function (combo, record, index)
		{
		 g_id_moneda=monedas.getValue();
	     g_moneda=record.data['nombre'];	     
	     menuBotones()
	     });
	//combo usuario
	var usuario= new Ext.form.ComboBox({
			store: ds_usuario,
			displayField:'desc_usuario',
			typeAhead: false,
			mode: 'remote',
			triggerAction: 'all',
			emptyText:'Usuario...',
			selectOnFocus:true,
			width:170,
			valueField: 'id_usuario',
			filterCol:'PERSON_2.apellido_paterno_persona#PERSON_2.apellido_materno_persona#PERSON_2.nombre_persona',
			renderer:render_usuario,
			tpl:tpl_id_usuario
		}); 
	usuario.on('select',
		function (combo, record, index)
		{
		 g_id_usuario=usuario.getValue();
	     g_usuario=record.data['desc_usuario'];	     
	     menuBotones()
	     });

	// fecha inicio
	var fechainicio =	new Ext.form.DateField({
						name:'fecha_inicio',
						fieldLabel:'Fecha Inicio',			
						allowBlank:false,
						format: 'd/m/Y', //formato para validacion
						minValue: '31/01/2001',
						//maxValue: '30/11/2008',
						disabledDaysText: 'Día no válido',
						emptyText:'Fecha Inicial...',
						grid_visible:true,
						grid_editable:false,
						renderer: formatDate,
						width:90,
						disabled:false});	

	fechainicio.on('change',
		function (combo,record,index)
		{
		g_fecha_ini=fechainicio.getValue()?fechainicio.getValue().dateFormat('m/d/Y'):''; 
		g_fecha_ini_ver=fechainicio.getValue()?fechainicio.getValue().dateFormat('d/m/Y'):'';
		g_id_periodo=-1;
		g_periodo='Ninguno';
		periodo.reset();
		menuBotones();
		});

	// fecha fin
	var fechafin =	new Ext.form.DateField({
		name:'fecha_fin',
		fieldLabel:'Fecha Final',
		allowBlank:false,
		format: 'd/m/Y', //formato para validacion
		minValue: '31/01/2001',
		//maxValue: '30/11/2008',
		disabledDaysText: 'Día no válido',
		emptyText:'Fecha Final...',
		grid_visible:true,
		grid_editable:false,
		renderer: formatDate,
		width:90,
		disabled:false});	

	fechafin.on('change',
		function (combo,record,index)
		{
		g_fecha_fin=fechafin.getValue()?fechafin.getValue().dateFormat('m/d/Y'):'';
		g_fecha_fin_ver=fechafin.getValue()?fechafin.getValue().dateFormat('d/m/Y'):'';
		g_id_periodo=-1;
		g_periodo='Ninguno';
		periodo.reset();
		menuBotones();
		});

	ds.lastOptions={
		params:{					
			start:0,
			limit: paramConfig.TamanoPagina,
			//CantFiltros:paramConfig.CantFiltros,
			//tipo_pres:maestro.tipo_pres,
			//id_parametro:maestro.id_parametro,
			//id_moneda:maestro.id_moneda,
			//sw_vista:maestro.sw_vista,
			////fecha_ini:maestro.fecha_ini,
			//fecha_fin:maestro.fecha_fin
		}
	}
	//fin de lastOption// 
	
	//padre.AdicionarBoton('',' ',btn_enviar,true,'Enviar Datos','');
	//this.AdicionarBotonCombo(departamento,'Departamento');		
	this.AdicionarBotonCombo(gestion,'Gestion');
	this.AdicionarBotonCombo(periodo,'Periodo');		
	this.AdicionarBotonCombo(monedas,'Monedas');														
	this.AdicionarBotonCombo(usuario,'Usuario');
	this.AdicionarBotonCombo(fechainicio,'Fecha Inicio');
	this.AdicionarBotonCombo(fechafin,'Fecha Final');
	//this.AdicionarBotonCombo(tipoplanilla,'Tipo Planilla');
														
	layout_consolidacionPresupuesto.getLayout().addListener('layout',this.onResize);
	//layout_consolidacionPresupuesto.getVentana(idContenedor).on('resize',function(){layout_consolidacionPresupuesto.getLayout().layout()})
}