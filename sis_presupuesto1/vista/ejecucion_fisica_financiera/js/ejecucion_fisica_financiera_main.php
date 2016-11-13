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

var elemento ={pagina:new EjecucionFisicaFinanciera(idContenedor,direccion,paramConfig,configConsolidacion),idContenedor:idContenedor};

ContenedorPrincipal.setPagina(elemento);

}
Ext.onReady(main,main);

function EjecucionFisicaFinanciera(idContenedor,direccion,paramConfig,configConsolidacion)
{   
	var vectorAtributos=new Array();	
	var componentes=new Array();
	var id_moneda; 
	var id_parametro; 
	 
	var id_tipo_pres; 
	var f_f,e_p_e,u_o;
	var fecha_fin;		
	var fecha_ini;
	var combo_tipo_pres;	
	var id; 
			
	var	g_id_tipo_pres='';
	var	g_id_parametro='';
	var	g_id_moneda='';	
	var g_desc_moneda='';
	var g_desc_pres='';
	var g_desc_estado_gral='';
	var g_gestion_pres='';
	
	var g_trimestre='';
	var g_mes='';
	var g_tipo_reporte='';
	var g_formato_reporte='';
	
	
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
	
	var ds_partida = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/partida/ActionListarPartida.php?'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_partida',totalRecords:'TotalCount'},[	'id_partida','codigo_partida','nombre_partida','desc_par','nivel_partida','sw_transaccional','tipo_partida','id_parametro','desc_parametro','id_partida_padre','tipo_memoria','desc_partida'])
    });	       
    
    var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/presupuesto/ActionListarPresupuesto.php?oc=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','tipo_pres','estado_pres','id_fina_regi_prog_proy_acti','desc_fina_regi_prog_proy_acti','id_unidad_organizacional','desc_unidad_organizacional',
						'id_fuente_financiamiento','denominacion','id_parametro','desc_parametro','id_financiador','id_regional','id_programa','id_proyecto','id_actividad','nombre_financiador','nombre_regional','nombre_programa','nombre_proyecto','nombre_actividad',
						'codigo_financiador','codigo_regional','codigo_programa','codigo_proyecto','codigo_actividad','id_concepto_colectivo','desc_colectivo','sigla','desc_presupuesto'])
	});	
	
	var ds_unidad_organizacional = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarUnidadOrganizacional.php?oc=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_unidad_organizacional',totalRecords: 'TotalCount'},['id_unidad_organizacional',
			'nombre_unidad','nombre_cargo','centro','cargo_individual','descripcion','fecha_reg','id_nivel_organizacional','estado_reg','nombre_nivel'])
	});	
	
	var ds_proyecto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/proyecto/ActionListarProyecto.php?oc=si'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_proyecto',totalRecords: 'TotalCount'},['id_proyecto',
			'codigo_proyecto','nombre_proyecto','descripcion_proyecto','fecha_registro']), baseParams:{tipo_vista:'formulario_ejecucion'}
	});	
	
	
	
		function renderTipoPresupuesto(value, p, record)
		{						
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
		function render_id_presupuesto(value, p, record){return String.format('{0}', record.data['desc_presupuesto']);}
		var tpl_id_presupuesto=new Ext.Template('<div class="search-item">','<b><i>{desc_unidad_organizacional}</i></b>',
																													'<br><b>Gestión: </b><FONT COLOR="#B5A642">{desc_parametro}</FONT>',
																													'<br><b>Tipo Presupuesto: </b><FONT COLOR="#B50000">{sigla}</FONT>',
																													'<br><FONT COLOR="#B50000"><b>Financiador: </b>{nombre_financiador}</FONT>',
																													'<br><FONT COLOR="#B5A642"><b>Regional: </b>{nombre_regional}</FONT>',
																													'<br><FONT COLOR="#B5A642"><b>Programa: </b>{nombre_programa}</FONT>',
																													'<br><FONT COLOR="#B50000"><b>Sub Programa: </b>{nombre_proyecto}</FONT>',
																													'<br><FONT COLOR="#B50000"><b>Actividad: </b>{nombre_actividad}</FONT>',
																													'<br><FONT COLOR="#B5A642"><b>Fuente de Financiamiento: </b>{denominacion}</FONT>','</div>');																									
	
						
		var tpl_id_parametro=new Ext.Template('<div class="search-item">','<b><i>{gestion_pres}</i></b>','<br><FONT COLOR="#B5A642"><b>Estado Gral: </b>{desc_estado_gral}</FONT>','</div>');
		var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
		var tpl_id_tipo_pres_gestion=new Ext.Template('<div class="search-item">','<b><i>{desc_tipo_pres}</i></b>','<br><FONT COLOR="#B5A642"><b>Gestión: </b>{desc_parametro}</FONT>','</div>');
		var tpl_id_unidad_organizacional=new Ext.Template('<div class="search-item">','<b><i>{nombre_unidad}</b></i>','<br><FONT COLOR="#B50000"><b>{nombre_nivel}</b></FONT>','</div>');
		var tpl_proyecto=new Ext.Template('<div class="search-item">','<b><i>{nombre_proyecto}</b></i>','<br><FONT COLOR="#B50000"><b>{codigo_proyecto}</b></FONT>','</div>');

				
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
			width:250,
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
			width:250,
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
			width:250,			
			disable:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda'
	};	 	
 	
	vectorAtributos[3]=
	{
			validacion:{
				name: 'trimestre',
				fieldLabel:'Trimestre',
				allowBlank:true,
				typeAhead:true,
				loadMask:true,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['Enero - Febrero - Marzo','Enero - Febrero - Marzo'],['Abril - Mayo - Junio','Abril - Mayo - Junio'],['Julio - Agosto - Septiembre','Julio - Agosto - Septiembre'],['Octubre - Noviembre - Diciembre','Octubre - Noviembre - Diciembre']]}),				
				valueField:'id',
				displayField:'valor',
				lazyRender:true,								
				forceSelection:true,
				//emptyText:'Seleccione una opción...',
				width:250		
			},
			tipo: 'ComboBox',
			filtro_0:true,			
			id_grupo:4,
			//defecto:'no',
			save_as:'trimestre'
		};
	
	vectorAtributos[4]=
	{
			validacion:{
				name: 'tipo_reporte',
				fieldLabel:'Tipo Reporte',
				allowBlank:false,
				typeAhead:true,
				loadMask:true,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Anual']]}),   //,['2','Trimestral'],['3','Mensual']				
				valueField:'id',
				displayField:'valor',
				lazyRender:true,								
				forceSelection:true,
				//emptyText:'Seleccione una opción...',
				width:250		
			},
			tipo: 'ComboBox',
			filtro_0:true,			
			id_grupo:4,
			defecto:'1',
			save_as:'tipo_reporte'
		};
		
	vectorAtributos[5]={
		validacion:{
			name:'filtro',
			fieldLabel:'Filtrar por',
			vtype:'texto',			
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['Proyecto','Proyecto']]}),		//['Presupuesto','Presupuesto'],['Unidad Organizacional','Unidad Organizacional'],
			valueField:'ID',
			displayField:'valor',
			forceSelection:true,
			width:200
		}, 
		tipo:'ComboBox',
		id_grupo:4,
		defecto:'Proyecto',
		save_as:'filtro'
	};
	
	vectorAtributos[6]={
			validacion:{
			name:'id_presupuesto',
			fieldLabel:'Presupuesto',
			allowBlank:false,			
			//emptyText:'Presupue...',
			desc: 'desc_presupuesto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_presupuesto,
			valueField: 'id_presupuesto',
			displayField: 'desc_unidad_organizacional',
			queryParam: 'filterValue_0',
			filterCol:'PRESUP.nombre_unidad#PRESUP.nombre_fuente_financiamiento#PRESUP.nombre_financiador#PRESUP.nombre_regional#PRESUP.nombre_programa#PRESUP.nombre_proyecto#PRESUP.nombre_actividad',			
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
			minChars:3, //caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_presupuesto,
			grid_visible:true,
			grid_editable:false,
			width_grid:150,
			width:250,
			disabled:false,
			grid_indice:8		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,	
		id_grupo:1,	
		filterColValue:'PRESUP.nombre_unidad#PRESUP.nombre_fuente_financiamiento#PRESUP.nombre_financiador#PRESUP.nombre_regional#PRESUP.nombre_programa#PRESUP.nombre_proyecto#PRESUP.nombre_actividad',
		save_as:'id_presupuesto'
	};
	
	vectorAtributos[7]={
			validacion:{
			name:'id_uo',
			fieldLabel:'Unidad Organizacional',
			allowBlank:false,			
			//emptyText:'Unidad Organizacional...',
			desc:'desc_unidad_organizacional', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_unidad_organizacional,
			valueField:'id_unidad_organizacional',
			displayField:'nombre_unidad',
			queryParam:'filterValue_0',
			filterCol:'UNIORG.nombre_unidad',
			typeAhead:false,
			tpl:tpl_id_unidad_organizacional,
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
			width:250,
			disabled:false		
		},
		tipo:'ComboBox',
		save_as:'id_uo',
		id_grupo:2
	};
	
	vectorAtributos[8]={
			validacion:{
			name:'id_proyecto',
			fieldLabel:'Proyecto',
			allowBlank:false,			
			//emptyText:'Proyecto...',
			desc:'nombre_proyecto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_proyecto,
			valueField:'id_proyecto',
			displayField:'nombre_proyecto',
			queryParam:'filterValue_0',
		    filterCol:'PROYEC.codigo_proyecto#PROYEC.nombre_proyecto',
			typeAhead:false,
			tpl:tpl_proyecto,
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
			width:250,
			disabled:false		
		},
		tipo:'ComboBox',
		save_as:'id_proyecto',
		id_grupo:0
	};
	
	vectorAtributos[9]=
	{
		validacion:{
			name: 'formato_reporte',
			fieldLabel:'Formato Reporte',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','PDF']]}),	//,['2','Excel']			
			valueField:'id',
			displayField:'valor',
			lazyRender:true,								
			forceSelection:true,				
			width:250		
		},
		tipo: 'ComboBox',
		filtro_0:true,			
		id_grupo:0,
		defecto:'1',
		save_as:'formato_reporte'
	}; 
	
	vectorAtributos[10]=
	{
		validacion:{
			name: 'mes',
			fieldLabel:'Mes',
			allowBlank:false,
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['Enero','Enero'],['Febrero','Febrero'],['Marzo','Marzo'],['Abril','Abril'],['Mayo','Mayo'],['Junio','Junio'],['Julio','Julio'],['Agosto','Agosto'],['Septiembre','Septiembre'],['Octubre','Octubre'],['Noviembre','Noviembre'],['Diciembre','Diciembre']]}),				
			valueField:'id',
			displayField:'valor',
			lazyRender:true,								
			forceSelection:true,
			//emptyText:'Seleccione una opción...',
			width:250		
		},
		tipo: 'ComboBox',
		filtro_0:true,			
		id_grupo:5,
		//defecto:'no',
		save_as:'mes'
	};
		
	
	

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////

	function formatDate(value){	return value ? value.dateFormat('d/m/Y'):''}
	
	// ---------- Inicia Layout ---------------//
	var config=
	{
		titulo_maestro:"Ejecucion Fisica Financiera"
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
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;

	//ds_parametro.addListener('loadexception',  ClaseMadre_conexionFailure); //se recibe un error	
	
	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	var paramFunciones = {

		Formulario:{
			labelWidth: 75, //ancho del label
			abrir_pestana:true, //abrir pestana
			titulo_pestana:'Ejecución Física - Financiera',
			fileUpload:false,
			columnas:[405,405],			
			grupos:[
			{
				tituloGrupo:'Asigne Datos Para Consultar la Ejecución ',
				columna:0,
				id_grupo:0
			},
			{
				tituloGrupo:'Presupuesto',
				columna:1,
				id_grupo:1
			},
			{
				tituloGrupo:'Unidad Organizacional',
				columna:1,
				id_grupo:2
			},
			{
				tituloGrupo:'Proyecto',
				columna:1,
				id_grupo:3
			},
			{
				tituloGrupo:'Trimestre',
				columna:1,
				id_grupo:4
			},
			{
				tituloGrupo:'Mes',
				columna:1,
				id_grupo:5
			}
			
			],
			parametros: '',
			submit:function ()
			{					
				var mensaje="";
				
				if(id_parametro.getValue()==""){mensaje+=" El campo Gestión esta vacio";}; 
				if(id_tipo_pres.getValue()==""){mensaje+=" El campo Tipo Presupuesto esta vacio";};			
				if(id_moneda.getValue()==""){mensaje+=" El campo Moneda esta vacio";};
				
				
				if(mensaje=="")
				{	
					//alert (g_id_partida);					
					var data='tipo_pres='+id_tipo_pres.getValue();	//listo
					 data+='&id_parametro='+g_id_parametro;	//listo
					 data+='&id_moneda='+g_id_moneda;	//listo					 
				     data+='&desc_moneda='+g_desc_moneda;	//listo
				     data+='&desc_pres='+g_desc_pres;		//listo
					 data+='&gestion_pres='+g_gestion_pres;	//listo					
					 data+='&trimestre='+g_trimestre;
					 data+='&mes='+g_mes;
					 data+='&tipo_reporte='+g_tipo_reporte;	//listo
					 data+='&formato_reporte='+g_formato_reporte;	//listo
					 data+='&filtro='+filtro.getValue();
					 data+='&id_presupuesto='+id_presupuesto.getValue();
					 data+='&id_uo='+id_uo.getValue();
					 data+='&id_proyecto='+id_proyecto.getValue();
					
					if(g_mes=="")
					{ 
						window.open(direccion+'../../../control/_reportes/ejecucion_fisica_financiera/ActionPDFEjecucionFisicaFinanciera.php?'+data);
					}
					else
					{
						window.open(direccion+'../../../control/_reportes/ejecucion_fisica_financiera/ActionPDFEjecucionMensu.php?'+data);				
					}
				}
				else
				{
					alert(mensaje);
				}				
			}
		}
	}

	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	function iniciarEventosFormularios()
	{			
		id_parametro = ClaseMadre_getComponente('id_parametro');
		id_tipo_pres = ClaseMadre_getComponente('id_tipo_pres');		
		id_moneda = ClaseMadre_getComponente('id_moneda');	
		
		filtro = ClaseMadre_getComponente('filtro');
		id_presupuesto = ClaseMadre_getComponente('id_presupuesto');
		id_uo = ClaseMadre_getComponente('id_uo');
		id_proyecto = ClaseMadre_getComponente('id_proyecto');
		
		
		CM_ocultarGrupo('Presupuesto');
		CM_ocultarGrupo('Unidad Organizacional');
		CM_ocultarGrupo('Proyecto');
		CM_ocultarGrupo('Trimestre');
		CM_ocultarGrupo('Mes');

		for(var i=0; i<vectorAtributos.length; i++)
		{
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}		
		
		componentes[0].on('select',evento_parametro);		//parametro				
		componentes[2].on('select',evento_moneda);		//moneda
		componentes[3].on('select',evento_trimestre);
		componentes[10].on('select',evento_mes);//mes	
		componentes[4].on('select',evento_tipo_reporte);		//tipo reporte
		componentes[9].on('select',evento_formato_reporte);		//formato reporte
		ClaseMadre_getComponente('filtro').on('select',evento_filtro);
		ClaseMadre_getComponente('id_tipo_pres').on('select',evento_tipo_presupuesto);	//tipo_pres			
	}
	
	function evento_parametro( combo, record, index )
	{
		//Validación de fechas
		var id = componentes[0].getValue();
			
		g_id_parametro=record.data.id_parametro;
		g_gestion_pres=record.data.gestion_pres;
		g_desc_estado_gral=record.data.desc_estado_gral;
		
		componentes[1].store.baseParams={m_id_parametro:componentes[0].getValue(),m_incluir_dobles:'si'};
		componentes[1].modificado=true;
		componentes[1].setValue('');		
	}	
	
	function evento_tipo_presupuesto( combo, record, index )
	{
		
		ClaseMadre_getComponente('id_presupuesto').store.baseParams={vista:'rep_formulacion_ejecucion',m_tipo_pres_g:ClaseMadre_getComponente('id_tipo_pres').getValue(),m_id_parametro_g:ClaseMadre_getComponente('id_parametro').getValue()};
		ClaseMadre_getComponente('id_presupuesto').modificado=true;
		ClaseMadre_getComponente('id_presupuesto').setValue('');
		
		ClaseMadre_getComponente('id_proyecto').store.baseParams={oc:'si',tipo_vista:'formulario_ejecucion',m_tipo_pres:ClaseMadre_getComponente('id_tipo_pres').getValue(),m_id_parametro:ClaseMadre_getComponente('id_parametro').getValue()};
		ClaseMadre_getComponente('id_proyecto').modificado=true;
		
		ClaseMadre_getComponente('id_uo').store.baseParams={oc:'si',tipo_vista:'formulario_ejecucion',m_tipo_pres_g:ClaseMadre_getComponente('id_tipo_pres').getValue(),m_id_parametro_g:ClaseMadre_getComponente('id_parametro').getValue()};
		ClaseMadre_getComponente('id_uo').modificado=true;
		
		g_desc_pres=record.data.desc_tipo_pres;

	}
	
	function evento_moneda( combo, record, index )
	{
		//alert (g_id_moneda);
		g_id_moneda=record.data.id_moneda;
		g_desc_moneda=record.data.nombre;			
	}
	
	function evento_trimestre( combo, record, index )
	{
		g_trimestre=record.data.id;
	}
	
	function evento_mes( combo, record, index )
	{
		g_mes=record.data.id;
	}
	
	function evento_formato_reporte( combo, record, index )
	{
		g_formato_reporte=record.data.id;
	}
	
	function evento_tipo_reporte( combo, record, index )
	{
		g_tipo_reporte=record.data.id;
		
		
		switch (g_tipo_reporte)
		{
		case '1':			
			ClaseMadre_getComponente('trimestre').reset();
	  		ClaseMadre_getComponente('trimestre').allowBlank=true;	  			    	
		    CM_ocultarGrupo('Trimestre');
		    
		    ClaseMadre_getComponente('mes').reset();
	  		ClaseMadre_getComponente('mes').allowBlank=true;	  			    	
		    CM_ocultarGrupo('Mes');
		    break;
		case '2':
			//ClaseMadre_getComponente('trimestre').reset();
	  		ClaseMadre_getComponente('trimestre').allowBlank=false;	  			    	
		    //CM_ocultarGrupo('Trimestre');
		    CM_mostrarGrupo('Trimestre');
		    
		    ClaseMadre_getComponente('mes').reset();
	  		ClaseMadre_getComponente('mes').allowBlank=true;	  			    	
		    CM_ocultarGrupo('Mes');
		    break;
		case '3':
			ClaseMadre_getComponente('mes').allowBlank=false;
		    CM_mostrarGrupo('Mes');	
		    
		    ClaseMadre_getComponente('trimestre').reset();
	  		ClaseMadre_getComponente('trimestre').allowBlank=true;	  			    	
		    CM_ocultarGrupo('Trimestre');
		    break;		
		}		
	}
	
	function evento_filtro(combo,record,index)
	{	  	//alert(ClaseMadre_getComponente('reporte').getValue());
	  		//alert(record.data.ID);
	  	if (record.data.ID=='Presupuesto')
	  	{
	  		ClaseMadre_getComponente('id_uo').reset();
	  		ClaseMadre_getComponente('id_uo').allowBlank=true;
	  		ClaseMadre_getComponente('id_proyecto').reset();	
	  		ClaseMadre_getComponente('id_proyecto').allowBlank=true;	    	
		    CM_ocultarGrupo('Proyecto');
		    CM_mostrarGrupo('Presupuesto');
		    CM_ocultarGrupo('Unidad Organizacional');  		
	  		//CM_ocultarGrupo('Reporte');
	  		
		}else if (record.data.ID=='Unidad Organizacional')
		{
			ClaseMadre_getComponente('id_presupuesto').reset();
			ClaseMadre_getComponente('id_presupuesto').allowBlank=true;
	  		ClaseMadre_getComponente('id_proyecto').reset();
	  		ClaseMadre_getComponente('id_proyecto').allowBlank=true;			
			CM_ocultarGrupo('Proyecto');
		    CM_ocultarGrupo('Presupuesto');	 
		    CM_mostrarGrupo('Unidad Organizacional'); 		
	  		//CM_ocultarGrupo('Reporte');
	  		
		}else if (record.data.ID=='Proyecto')
		{
			ClaseMadre_getComponente('id_uo').reset();
			ClaseMadre_getComponente('id_uo').allowBlank=true;
	  		ClaseMadre_getComponente('id_presupuesto').reset();	
	  		ClaseMadre_getComponente('id_presupuesto').allowBlank=true;	  
		    CM_mostrarGrupo('Proyecto');
		    CM_ocultarGrupo('Presupuesto');
		    CM_ocultarGrupo('Unidad Organizacional');
		    //CM_ocultarGrupo('Reporte');
		}			
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
