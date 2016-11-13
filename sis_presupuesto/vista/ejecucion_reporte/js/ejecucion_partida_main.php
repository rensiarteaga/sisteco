//<script>


function main(){
	 <?php
	//obtenemos la ruta absoluta
	$host   = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir  = "http://$host$uri/";
	echo "\nvar direccion =\"$dir\";";
	echo "var idContenedor ='$idContenedor';";
	?>

	
	
var paramConfig ={TiempoEspera:10000};
var configConsolidacion ={sw_vista:'<?php echo utf8_decode($sw_vista);?>'};

var elemento ={pagina:new EjecucionPartida(idContenedor,direccion,paramConfig,configConsolidacion),idContenedor:idContenedor};

ContenedorPrincipal.setPagina(elemento);

}
Ext.onReady(main,main);
function EjecucionPartida(idContenedor,direccion,paramConfig,configConsolidacion)
{   
	var vectorAtributos=new Array();
	//var parametro;
	//var gestion;
	//var periodo;
	var componentes=new Array();
	var id_moneda; 
	var id_parametro; 
	var id_presupuesto; 
	var id_tipo_pres; 
	var f_f,e_p_e,u_o;
	var fecha_fin;		
	var fecha_ini;
	var combo_tipo_pres;
	var combo_partida;
	var id; 
			
	var	g_id_tipo_pres='';
	var	g_id_parametro='';
	var	g_id_moneda='';
	var	g_id_partida='';
	
	//var g_colectivo='';
	var g_desc_moneda='';
	var g_desc_pres='';
	var g_desc_estado_gral='';
	var g_gestion_pres='';
	//var g_fecha_fin='';
	var g_desc_partida='';
	var g_tipo_reporte='';
	
	var g_id_categoria_prog = '';
	var g_desc_categoria_prog = '';
	
	//DATA STORE 		
 	var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','gestion_pres','estado_gral','cod_institucional','porcentaje_sobregiro','cantidad_niveles','desc_estado_gral'])
	});
	
	var ds_tipo_pres_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/tipo_pres_gestion/ActionListarTipoPresGestion.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_pres',totalRecords: 'TotalCount'},['id_tipo_pres_gestion','id_tipo_pres','desc_tipo_pres','id_parametro','desc_parametro','estado','doble'])
	});
	
	var ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),
			baseParams:{sw_comboPresupuesto:'si'}
	});
	
	var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/presupuesto/ActionListarPresupuesto.php?'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','tipo_pres','estado_pres','id_fina_regi_prog_proy_acti','desc_fina_regi_prog_proy_acti','id_unidad_organizacional','desc_unidad_organizacional',
						'id_fuente_financiamiento','denominacion','id_parametro','desc_parametro','id_financiador','id_regional','id_programa','id_proyecto','id_actividad','nombre_financiador','nombre_regional','nombre_programa','nombre_proyecto','nombre_actividad',
						'codigo_financiador','codigo_regional','codigo_programa','codigo_proyecto','codigo_actividad','id_concepto_colectivo','desc_colectivo','sigla','desc_presupuesto'])
	});	
	
	var ds_partida = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/partida/ActionListarPartida.php?'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_partida',totalRecords:'TotalCount'},[	'id_partida','codigo_partida','nombre_partida','desc_par','nivel_partida','sw_transaccional','tipo_partida','id_parametro','desc_parametro','id_partida_padre','tipo_memoria','desc_partida'])
    });	//render
	
	var ds_categoria_prog = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/categoria_prog/ActionListarCategoriaProg.php?oc=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_categoria_prog',totalRecords: 'TotalCount'},['id_categoria_prog','cod_categoria_prog','desc_parametro','cod_programa','desc_programa','cod_proyecto','desc_proyecto','cod_actividad','desc_actividad',																																		 'cod_organismo_fin','desc_organismo_fin','cod_fuente_financiamiento','desc_fuente_financiamiento','id_fuente_financiamiento','descripcion_cp','codigo_sisin'])  //, baseParams:{tipo_vista:'formulacion'}
	});
	
	function renderTipoPresupuesto(value, p, record){						
		if(value == 1)
		{return "Recurso"}
		if(value == 2)
		{return "Gasto"}
		if(value == 3)
		{return "Inversión"}
		if(value == 4)
		{return "PNO - Recurso"}
		if(value == 5)
		{return "PNO - Gasto"}
		if(value == 6)
		{return "PNO - Inversión"}
		
		return '';
	}	

	function render_id_parametro(value,cell,record,row,colum,store){return String.format('{0}', record.data['desc_parametro']);}
	function render_id_moneda(value,p,record){return String.format('{0}', record.data['desc_moneda'])}
	function render_id_tipo_pres_gestion(value,cell,record,row,colum,store){return String.format('{0}', record.data['desc_tipo_pres']);}
				
	var tpl_id_parametro=new Ext.Template('<div class="search-item">','<b><i>{gestion_pres}</i></b>','<br><FONT COLOR="#B5A642"><b>Estado Gral: </b>{desc_estado_gral}</FONT>','</div>');
	var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
	var tpl_id_tipo_pres_gestion=new Ext.Template('<div class="search-item">','<b><i>{desc_tipo_pres}</i></b>','<br><FONT COLOR="#B5A642"><b>Gestión: </b>{desc_parametro}</FONT>','</div>');
	
	/*function render_id_presupuesto(value, p, record){return String.format('{0}', record.data['desc_presupuesto']);}
	var tpl_id_presupuesto=new Ext.Template('<div class="search-item">','<b><i>{desc_unidad_organizacional}</i></b>',
																		'<br><b>Gestión: </b><FONT COLOR="#B5A642">{desc_parametro}</FONT>',
																		'<br><b>Tipo Presupuesto: </b><FONT COLOR="#B50000">{sigla}</FONT>',
																		'<br><FONT COLOR="#B5A642"><b>Financiador: </b>{nombre_financiador}</FONT>',
																		'<br><FONT COLOR="#B5A642"><b>Regional: </b>{nombre_regional}</FONT>',
																		'<br><FONT COLOR="#B5A642"><b>Programa: </b>{nombre_programa}</FONT>',
																		'<br><FONT COLOR="#B5A642"><b>Proyecto: </b>{nombre_proyecto}</FONT>',
																		'<br><FONT COLOR="#B5A642"><b>Actividad: </b>{nombre_actividad}</FONT>',
																		'<br><FONT COLOR="#B5A642"><b>Fuente de Financiamiento: </b>{denominacion}</FONT>','</div>');*/
																											
    var tpl_id_partida=new Ext.Template('<div class="search-item">','<b><FONT COLOR="#000000">{codigo_partida} {nombre_partida}</FONT></b><br>',
                                                                  '<FONT COLOR="#B5A642">CODIGO: {codigo_partida}</FONT><br>',
                                                                  '<FONT COLOR="#B5A642">NOMBRE: {nombre_partida}</FONT>','</div>');

	function render_id_categoria_prog(value, p, record){return String.format('{0}', record.data['cod_categoria_prog']);}
	var tpl_id_categoria_prog=new Ext.Template('<div class="search-item">', '<b><i>{cod_categoria_prog}</i></b>',
																			'<br><FONT COLOR="#B50000"><b>Cod. Programa: </b>{desc_programa}</FONT>',
																			'<br><FONT COLOR="#B50000"><b>Cod. Proyecto: </b>{desc_proyecto}</FONT>',
																			'<br><FONT COLOR="#B50000"><b>Cod. Actividad: </b>{desc_actividad}</FONT>',
																			'<br><FONT COLOR="#B50000"><b>Cod. Fuente Financiamiento: </b>{desc_fuente_financiamiento}</FONT>',
																			'<br><FONT COLOR="#B50000"><b>Cod. Organismo Financiador: </b>{desc_organismo_fin}</FONT>',																												
																			'<br><FONT COLOR="#B5A642"><b>Gestión: </b>{desc_parametro}</FONT>',
																			'</div>');
				
	vectorAtributos[0]={
		validacion:{
			name:'id_parametro',
			fieldLabel:'Gestión',
			allowBlank:false,			
			//emptyText:'Parame...',
			desc: 'desc_parametro', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_parametro,
			valueField: 'id_parametro',
			displayField: 'gestion_pres',
			queryParam: 'filterValue_0',
			filterCol:'PARAMP.gestion_pres#PARAMP.estado_gral',
			typeAhead:true,
			tpl:tpl_id_parametro,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'50%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_parametro,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:150,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'PARAMP.gestion_pres',
		save_as:'id_parametro'
	}; 
	
	vectorAtributos[1]={
		validacion:{
			name:'id_tipo_pres',
			fieldLabel:'Tipo de Presupuesto',
			allowBlank:false,			
			//emptyText:'Parame...',
			desc: 'desc_tipo_pres', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_tipo_pres_gestion,
			valueField: 'id_tipo_pres',
			displayField: 'desc_tipo_pres',
			queryParam: 'filterValue_0',
			filterCol:'TIPREGES.desc_tipo_pres',
			typeAhead:true,
			tpl:tpl_id_tipo_pres_gestion,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'50%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_tipo_pres_gestion,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:150,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'TIPREGES.gestion_pres',
		save_as:'id_tipo_pres'
	}; 
	
	vectorAtributos[2]={
			validacion:{
 			name:'id_partida',
			fieldLabel:'Partida ',
			allowBlank:false,			
			//emptyText:'Partida... ',
			desc: 'desc_partida', 		
			store:ds_partida,
			valueField: 'id_partida',
			displayField: 'desc_par',
			queryParam: 'filterValue_0',
			filterCol:'PARTID.codigo_partida#PARTID.nombre_partida',
			typeAhead:false,
			triggerAction:'all',
			tpl:tpl_id_partida,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:20,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			minChars:1,
			editable:true,
			//renderer:render_id_partida_origen,
 			grid_visible:true,
 			grid_editable:true,
			width_grid:200,
			lazyRender:true,
      		width:350,
			disabled:false,
			grid_indice:9		
		}, 
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		//id_grupo:2,
		filterColValue:'PARTID.codigo_partida#PARTID.nombre_partida',
		save_as:'id_partida'
	};	

	vectorAtributos[3]={
			validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:false,			
			//emptyText:'Moneda...',
			desc: 'desc_moneda', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_moneda,
			valueField: 'id_moneda',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'MONEDA.nombre',
			typeAhead:true,
			tpl:tpl_id_moneda,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'50%',
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:false,
			grid_editable:true,
			width:150,			
			disable:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda'
	};	 
	
 	vectorAtributos[4]={
		validacion:{
			name:'fecha_ini',
			fieldLabel:'Fecha Inicio',
			allowBlank:false,
			format:'d/m/Y', 
			minValue:'01/01/1900',
			//disabledDays:[0, 7],
			disabledDaysText:'Día no válido',
			grid_visible:true, 
			grid_editable:false, 
			renderer:formatDate,
			width_grid:100, 
			width:'100%',
			align:'center',
			disabled:false
		},
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'cre.fecha_ini',
		filtro_1:true,
		save_as:'txt_fecha_ini',
		dateFormat:'m-d-Y', 
	};
	
	vectorAtributos[5]={
		validacion:{
			name:'fecha_fin',
			fieldLabel:'Fecha Final',
			allowBlank:false,
			format:'d/m/Y', 
			minValue:'01/01/1900',
			//disabledDays:[0, 7],
			disabledDaysText:'Día no válido',
			grid_visible:true, 
			grid_editable:false, 
			renderer:formatDate,
			width_grid:100, 
			width:'100%',
			align:'center',
			disabled:false
		},
		tipo:'DateField',
		filtro_0:true,
		filterColValue:'cre.fecha_fin',
		filtro_1:true,
		save_as:'txt_fecha_fin',
		dateFormat:'m-d-Y', 
	};
	
	vectorAtributos[6]=
	{
		validacion:{
			name: 'tipo_reporte',
			fieldLabel:'Tipo Reporte',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','PDF'],['2','Excel']]}),				
			valueField:'id',
			displayField:'valor',
			lazyRender:true,								
			forceSelection:true,
			//emptyText:'Seleccione una opción...',
			width:150		
		},
		tipo: 'ComboBox',
		filtro_0:true,			
		id_grupo:0,
		defecto:'no',
		save_as:'tipo_reporte'
	};
	
	vectorAtributos[7]={
			validacion:{
			name:'id_categoria_prog',
			fieldLabel:'Categoría Programática',
			allowBlank:true,			
			//emptyText:'Fuente Financiamiento...',
			desc: 'cod_categoria_prog', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_categoria_prog,
			valueField: 'id_categoria_prog',
			displayField: 'cod_categoria_prog',
			queryParam: 'filterValue_0',
			filterCol:'PROGRA.codigo#PROYEC.codigo#ACTIVI.codigo#ORGFIN.codigo#FUEFIN.codigo_fuente',
			typeAhead:true,
			tpl:tpl_id_categoria_prog,
			forceSelection:true,
			mode:'remote',
			queryDelay:300,
			pageSize:20,
			minListWidth:500,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_categoria_prog,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:350,
			disabled:false
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'PROGRA.codigo#PROYEC.codigo#ACTIVI.codigo#ORGFIN.codigo#FUEFIN.codigo_fuente',
		save_as:'id_categoria_prog'
		//id_grupo:2
	};
	

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////

	function formatDate(value){	return value ? value.dateFormat('d/m/Y'):''}
	
	// ---------- Inicia Layout ---------------//
	var config=
	{
		titulo_maestro:"Consolidación Presupuesto"
	};
	var layout_ejecucion_reporte=new DocsLayoutProceso(idContenedor);
	layout_ejecucion_reporte.init(config);

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS HERENCIA           -----------//
	//////////////////////////////////////////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,layout_ejecucion_reporte,idContenedor);

	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//

	var ClaseMadre_conexionFailure = this.conexionFailure; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_getComponente = this.getComponente;
	var CM_ocultarComponente=this.ocultarComponente;

	//ds_parametro.addListener('loadexception',  ClaseMadre_conexionFailure); //se recibe un error	
	
	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	var paramFunciones = {
		Formulario:{
			labelWidth: 75, //ancho del label
		 	url:direccion+'../../../../sis_presupuesto/vista/consolidacion_presupuesto/consolidacion_presupuesto.php',
			abrir_pestana:true, //abrir pestana
			titulo_pestana:'Ejecución Presupuestaria',
			fileUpload:false,
			columnas:[505,305],			
			grupos:[
			{
				tituloGrupo:'Asigne Datos Para Consultar la Ejecución ',
				columna:0,
				id_grupo:0
			}],
			parametros: '',
			submit:function (){					
				var mensaje="";
				
				if(id_parametro.getValue()==""){mensaje+=" El campo Gestión esta vacio";}; 
				if(id_tipo_pres.getValue()==""){mensaje+=" El campo Tipo Presupuesto esta vacio";};
			//	if(id_presupuesto.getValue()==""){mensaje+=" El campo Presupuesto esta vacio";};
				if(id_moneda.getValue()==""){mensaje+=" El campo Moneda esta vacio";};
				if(fecha_fin.getValue()==""){mensaje+=" El campo Fecha Final  esta vacio";};
				//if(cmbReporte.getValue()==""){mensaje+=" El campo Tipo Reporte esta vacio";};
				//if(periodo.getValue()==""){mensaje+=" El campo Periodo esta vacio";};
				if(mensaje==""){		//alert (g_id_partida);					
					var data='id_tipo_pres='+g_id_tipo_pres;	//listo
					 data+='&id_parametro='+g_id_parametro;	//listo
					 data+='&id_moneda='+g_id_moneda;	//listo
					 data+='&fecha_fin_pdf='+formatDate(fecha_fin.getValue());	//listo
					 data+='&fecha_ini_pdf='+formatDate(fecha_ini.getValue());	//listo
					 data+='&fecha_fin='+(fecha_fin.getValue());	//listo					 
					 data+='&fecha_ini='+(fecha_ini.getValue());	//listo	
				     data+='&desc_moneda='+g_desc_moneda;	//listo
				     data+='&desc_pres='+g_desc_pres;		//listo
					 data+='&gestion_pres='+g_gestion_pres;	//listo
					 data+='&id_partida='+g_id_partida;
					 data+='&desc_partida='+g_desc_partida;
					 data+='&tipo_reporte='+g_tipo_reporte;	//listo
					 
					 data+='&id_categoria_prog='+g_id_categoria_prog;
					 data+='&desc_categoria_prog='+g_desc_categoria_prog;
					
					// alert (data);
					window.open(direccion+'../../../control/ejecucion/ActionPDFEjecucionPartida.php?'+data);					
				}
				else{alert(mensaje);}
				//alert("mensaje2");
			}
		}
	}

	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	function iniciarEventosFormularios(){			
		id_parametro = ClaseMadre_getComponente('id_parametro');
		id_tipo_pres = ClaseMadre_getComponente('id_tipo_pres');
		id_presupuesto = ClaseMadre_getComponente('id_presupuesto');	
		id_moneda = ClaseMadre_getComponente('id_moneda');	
		fecha_fin = ClaseMadre_getComponente('fecha_fin');			
		fecha_ini = ClaseMadre_getComponente('fecha_ini');	
		combo_tipo_pres=ClaseMadre_getComponente('id_tipo_pres');
		combo_partida= ClaseMadre_getComponente('id_partida');		
		cmbReporte=ClaseMadre_getComponente('tipo_reporte');

		for(var i=0; i<vectorAtributos.length; i++){
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}
		
		var onTipoPresupuestoSelect = function(e){
			id = combo_tipo_pres.getValue();
			if(id !=undefined){
				ds_partida.baseParams.id_tipo_pres=id;
				ds_partida.baseParams.sw_vista_reporte='rep_ejecucion_partida';
				ds_partida.baseParams.rep_id_parametro=g_id_parametro;
			    combo_partida.modificado=true;
			    componentes[2].modificado=true;			
				componentes[2].setValue('');
			    g_id_tipo_pres=id;
			    g_desc_pres=renderTipoPresupuesto(id, '', '');
				
				//modificamos el stor de la categoria programatica
				componentes[7].store.baseParams={tipo_vista:'formulacion',m_id_parametro:componentes[0].getValue(),m_tipo_pres:componentes[1].getValue()}; 
				componentes[7].modificado=true;
				componentes[7].setValue('');			      
			}			
		};
		
		componentes[0].on('select',evento_parametro);		//parametro		
		//componentes[1].on('select',evento_tipo_presupuesto);	//tipo_pres	
		//componentes[2].on('select',evento_presupuesto);		//presupuesto
		componentes[3].on('select',evento_moneda);		//moneda
		componentes[2].on('select',evento_partida);		//partida
		
		combo_tipo_pres.on('select',onTipoPresupuestoSelect);
		componentes[6].on('select',evento_reporte);		//tipo reporte
		componentes[7].on('select',evento_categoria_prog);	//categoria
		//cmbPartida.on('change',onTipoPresupuestoSelect);
	}
	
	function evento_parametro( combo, record, index ){
		//Validación de fechas
		var id = componentes[0].getValue();
		if(componentes[0].store.getById(id)!=undefined){			
			var intGestion=componentes[0].store.getById(id).data.gestion_pres;
			var dte_fecha_ini_valid=new Date('01/01/'+intGestion+' 00:00:00');
			var dte_fecha_fin_valid=new Date('12/31/'+intGestion+' 00:00:00');
				
			//Aplica la validación en la fecha
			componentes[4].minValue=dte_fecha_ini_valid; //Fecha inicio
			componentes[4].maxValue=dte_fecha_fin_valid;
			componentes[5].minValue=dte_fecha_ini_valid;
			componentes[5].maxValue=dte_fecha_fin_valid;
				
			//Define un valor por defecto
			componentes[4].setValue(dte_fecha_ini_valid);
			componentes[5].setValue(dte_fecha_fin_valid);
			
			componentes[7].store.baseParams={m_id_parametro:componentes[0].getValue()};
			componentes[7].modificado=true;
			componentes[7].setValue('');
			componentes[7].setDisabled(false);			
		}
		
		g_id_parametro=record.data.id_parametro;
		g_gestion_pres=record.data.gestion_pres;
		g_desc_estado_gral=record.data.desc_estado_gral;
		//alert (g_id_parametro);		
		
		ds_partida.baseParams.id_tipo_pres=id;
		ds_partida.baseParams.sw_vista_reporte='rep_ejecucion_partida';
		ds_partida.baseParams.rep_id_parametro=g_id_parametro;
		combo_partida.modificado=true;
		
		componentes[1].store.baseParams={m_id_parametro:componentes[0].getValue(),m_incluir_dobles:'no'};
		componentes[1].modificado=true;
		componentes[1].setValue('');			
		
		componentes[2].modificado=true;			
		componentes[2].setValue('');
	}	
	
	function evento_categoria_prog( combo, record, index ){
		g_id_categoria_prog=record.data.id_categoria_prog;
		g_desc_categoria_prog=record.data.cod_categoria_prog;
		
		/*g_cod_programa=record.data.cod_programa;
		g_cod_proyecto=record.data.cod_proyecto;
		g_cod_actividad=record.data.cod_actividad;
		g_cod_fuente_financiamiento=record.data.cod_fuente_financiamiento;
		g_cod_organismo_financiador=record.data.cod_organismo_fin;
		g_descripcion_cp=record.data.descripcion_cp;
		g_codigo_sisin=record.data.codigo_sisin;	*/	
	}

	function evento_moneda( combo, record, index )
	{
		//alert (g_id_moneda);
		g_id_moneda=record.data.id_moneda;
		g_desc_moneda=record.data.nombre;
				
		componentes[6].modificado=true;			
		componentes[6].setValue('');
	}
	function evento_partida( combo, record, index )
	{
		//alert (g_id_partida);
		g_id_partida=record.data.id_partida;
		g_desc_partida=record.data.desc_par;
		//g_desc=record.data.nombre;
	}
	
	function evento_reporte( combo, record, index )
	{
		g_tipo_reporte=record.data.id;
	}
	
	//InitBarraMenu(array BOTONES DISPONIBLES);
	this.Init(); //iniciamos la clase madre
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
    //Se agrega el botón para la generación del reporte
	this.iniciaFormulario();
	iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
