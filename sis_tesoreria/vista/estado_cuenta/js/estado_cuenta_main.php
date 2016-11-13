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

	
	
var paramConfig ={TamanoPagina:20,TiempoEspera:10000};
var configConsolidacion ={sw_vista:'<?php echo utf8_decode($sw_vista);?>'};

var elemento ={pagina:new EstadoCuenta(idContenedor,direccion,paramConfig,configConsolidacion),idContenedor:idContenedor};

ContenedorPrincipal.setPagina(elemento);

}
Ext.onReady(main,main);

//view added

function EstadoCuenta(idContenedor,direccion,paramConfig,configConsolidacion)
{
	var vectorAtributos=new Array();	
	var componentes=new Array(); 
	var	g_CantFiltros='';
	
	var g_fecha_fin='';
	var fecha_desde;
	var dteFechaDesde;
	var dteFechaHasta;
	var tipo_reporte;
	
	var g_id_depto='';
	var g_desc_depto='';
	var g_id_empleado='';
	var g_estado='';
	var g_reporte='';
	var g_emp_dep='';
	
	
	//DATA STORE 		
	
	/*var ds_depto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamentoEPUsuario.php?subsistema=tesoro'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_depto',totalRecords: 'TotalCount'},['id_depto','codigo_depto','nombre_depto','estado','id_subsistema'])
	});*/	
 	
	var ds_depto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamento.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_depto',totalRecords:'TotalCount'},['id_depto','codigo_depto','nombre_depto','estado','id_subsistema','nombre_corto','nombre_largo']),baseParams:{m_id_subsistema:9}});

	var ds_empleado = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords: 'TotalCount'},['id_empleado','apellido_paterno','apellido_materno','nombre','desc_persona'])
	});
		
		
    /*function render_id_depto(value, p, record){return String.format('{0}', record.data['desc_depto']);}
	var tpl_id_depto=new Ext.Template('<div class="search-item">','{nombre_depto}<br>','<FONT COLOR="#B5A642">{codigo_depto}</FONT>','</div>');
*/
	function render_id_depto(value, p, record){return String.format('{0}', record.data['nombre_depto']);}
	var tpl_id_depto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642"><b>Departamento Contable: </b></FONT"><br><FONT COLOR="#000000">{nombre_depto}</FONT>','</div>');
	
	
	function render_id_empleado(value, p, record){return String.format('{0}', record.data['desc_empleado']);}
	var tpl_id_empleado=new Ext.Template('<div class="search-item">','{desc_persona}<br>','<FONT COLOR="#B5A642">{codigo_empleado}</FONT>','</div>');

	function renderEstado(value, p, record)
	{						
			if(value == 'en_rendicion')
			{return "En Rendición"}
			if(value == 'conta_rendicion')
			{return "Conta Rendición"}
			if(value == 'fin_rendicion')
			{return "Fin Rendición"}
			return '';
	}	
	
    vectorAtributos[0] = { 
		validacion: {
			name: 'tipo_reporte',
			fieldLabel: 'Tipo de Reporte',
			allowBlank: false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			//store: new Ext.data.SimpleStore({fields: ['ID', 'valor'],data : Ext.estado_cuenta_combo.tipo_reporte}),
			store: new Ext.data.SimpleStore({fields: ['ID', 'valor'],data : [
			                                                                 ['2', 'Por Empleado'],
			                                                         		['1', 'Por Departamento Contable']
			                                                                
			                                                         ]}),
			onSelect:function(record)
			{
				if(record.data.ID==1) //por departamento contable
				{
					ClaseMadre_getComponente('tipo_reporte').setValue(1);
					ClaseMadre_getComponente('id_depto').allowBlank=false;
					ClaseMadre_getComponente('id_empleado').allowBlank=true;					
					ClaseMadre_getComponente('id_empleado').reset();
					ClaseMadre_getComponente('id_empleado').setValue('');
					CM_mostrarGrupo('Departamento');
					CM_ocultarGrupo('Empleado');
					ClaseMadre_getComponente('tipo_reporte').collapse();
				}
				else if (record.data.ID==2) //por empleado
				{   
					ClaseMadre_getComponente('tipo_reporte').setValue(2);
					ClaseMadre_getComponente('id_depto').allowBlank=true;
					ClaseMadre_getComponente('id_empleado').allowBlank=false;					
					ClaseMadre_getComponente('id_depto').reset();
					ClaseMadre_getComponente('id_depto').setValue('');
					CM_ocultarGrupo('Departamento');
					CM_mostrarGrupo('Empleado');
					ClaseMadre_getComponente('tipo_reporte').collapse();				
				}
			},
			valueField:'ID',
			displayField:'valor',
			align: 'center',
			lazyRender:true,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:false, //es editable en el grid
			width_grid:60, // ancho de columna en el grid
			width:200
		},
		tipo:'ComboBox',
		id_grupo:0,
		save_as:'txt_tipo_reporte'
	};
	   																							

	vectorAtributos[1]  = {
		validacion: {
			name:'estado',			
			fieldLabel:'Estado',
			vtype:'texto',
			//emptyText:'Tipo Presupue...',
			allowBlank: false,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',
			//store: new Ext.data.SimpleStore({fields: ['ID', 'valor'],data :Ext.estado_cuenta_combo.estado /* from states.js*/}),
			store: new Ext.data.SimpleStore({fields: ['ID', 'valor'],data :[       
			                                                            	
			                                                        		//["'en_rendicion,conta_rendicion,fin_rendicion'", 'Todos'],
			                                                        		
			                                                        		//["Todos", 'Todos'],
			                                                        		//['"Todos"', 'Todos'],
			                                                        		//["'Todos'", 'Todos'],
			                                                                /*["'en_rendicion'", 'En Rendición'],
			                                                                ["'conta_rendicion'", 'Conta Rendición'],
			                                                                ["'fin_rendicion'", 'Fin Rendición'] */  
			                                                                    
			                                                                ['Todos', 'Todos'],       
			                                                                ['borrador', 'Borrador'],
			                                                                ['solicitud_pago', 'Solicitud Pago'],       
			                                                                ['conta_pago', 'Conta Pago'],
			                                                                ['pago_cheque', 'Pago Cheque'],
			                                                                ['pago_efectivo', 'Pago Efectivo'],
			                                                                ['pagado', 'Pagado'],
			                                                                
			                                                                ['en_finaliz', 'En Finalización'],
			                                                                ['conta_fin', 'Conta Finalización'],
			                                                                ['caja', 'Caja Finalización'],
			                                                                ['cheque_finalizacion', 'Cheque Finalización'],
			                                                                ['finalizado', 'Finalizado'],
			                                                                ['sin_finalizar', 'Sin Finalizar']    
			                                                        ] /* from states.js*/}),
			valueField:'ID',
			displayField:'valor',
			renderer: renderEstado,
			forceSelection:true,
			grid_visible:true, // se muestra en el grid
			grid_editable:true, //es editable en el grid,
			width_grid:100, // ancho de columna en el gris
			width:200			
		},
		tipo:'ComboBox',
		filtro_0:true,
		save_as:'txt_estado',
		id_grupo:0		
	};
	
	
	vectorAtributos[2]= {
		validacion:{
			name:'fecha_desde',
			fieldLabel:'Fecha Desde',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			grid_indice:8,
			renderer: formatDate,
			width_grid:85
		},
		tipo:'DateField',
		dateFormat:'m-d-Y',
		save_as:'txt_fecha_desde',
		id_grupo:0
	};

	// Definición de datos //
	vectorAtributos[3]= {
		validacion:{
			name:'fecha_hasta',
			fieldLabel:'Fecha Hasta',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:true,
			grid_indice:8,
			renderer: formatDate,
			width_grid:85
		},
		tipo:'DateField',
		dateFormat:'m-d-Y',
		save_as:'txt_fecha_hasta',
		id_grupo:0
	};
	
	
	vectorAtributos[4]={
		validacion:{
			name:'id_depto',
			fieldLabel:'Departamento de Contabilidad',
			allowBlank:false,			
			//emptyText:'Departamento...',
			desc: 'nombre_depto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_depto,
			valueField: 'id_depto',
			displayField: 'nombre_depto',
			queryParam: 'filterValue_0',
			typeAhead:false,
			tpl:tpl_id_depto,
			forceSelection:true,
			mode:'remote',
			queryDelay:50,
			pageSize:50,
			minListWidth:250,
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_depto,
			grid_visible:false,
			grid_editable:true,
			width_grid:50,
			width:300
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		save_as:'id_depto',
		id_grupo:1
	};
	
	vectorAtributos[5]={
			validacion:{
			name:'id_empleado',
			fieldLabel:'Empleado',
			allowBlank:false,			
			//emptyText:'Empleado...',
			desc: 'desc_empleado', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_empleado,
			//onSelect: function(record){ if(vista!='solicitud_efectivo'){  componentes[30].setValue(record.data.desc_persona)  ;} componentes[4].setValue(record.data.id_empleado);componentes[4].collapse(); },
			valueField: 'id_empleado',
			displayField: 'desc_persona',
			queryParam: 'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre#EMPLEA.codigo_empleado',
			typeAhead:false,
			tpl:tpl_id_empleado,
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
			renderer:render_id_empleado,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:300,
			disabled:false,
			grid_indice:4		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue: 'CUDOC.desc_empleado',
		id_grupo:2		
	};
	vectorAtributos[6]={
			validacion:{
				name: 'reporte',
				fieldLabel:'Reporte',
				allowBlank:false,
				typeAhead:true,
				loadMask:true,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','PDF'],['2','EXCEL']]}),
				valueField:'id',
				displayField:'valor',
				lazyRender:true,								
				forceSelection:true,
				//emptyText:'Seleccione una opción...',
				width:250		
			},   
			tipo: 'ComboBox',
			filtro_0:true
		};
	
	
	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////

	function formatDate(value){	return value ? value.dateFormat('d/m/Y'):''}
	
	// ---------- Inicia Layout ---------------//
	var config=
	{
		titulo_maestro:"Detalle del Estado de Cuentas"
	};
	layout_ejecucion_reporte=new DocsLayoutProceso(idContenedor);
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
	
	
	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	var paramFunciones = {

		Formulario:{
			labelWidth: 75, //ancho del label
		 	//url:direccion+'../../../control/ejecucion/ActionPDFEjecucion_x_fechas.php',
			abrir_pestana:true, //abrir pestana
			titulo_pestana:'Detalle de Estado de Cuentas',
			fileUpload:false,
			columnas:[505,305],			
			grupos:[
				{
					tituloGrupo:'Datos Para Generar el Reporte',
					columna:0,
					id_grupo:0
				},	
				{
					tituloGrupo:'Departamento',
					columna:0,
					id_grupo:1
				},	
				{
					tituloGrupo:'Empleado',
					columna:0,
					id_grupo:2
				}	
			],

			submit:function()
			{												
				var mensaje="";					
					
				if(mensaje=="")
				{							
					var data='start=0';
					 data+='&limit=1000';
					 data+='&CantFiltros='+g_CantFiltros;
					 
					 data+='&id_depto='+g_id_depto;	//listo
					 data+='&desc_depto='+g_desc_depto;	//listo
					 data+='&id_empleado='+g_id_empleado;	//listo	
					 data+='&estado='+g_estado;	//listo					 
					 				 
					 data+='&fecha_desde='+formatDate(dteFechaDesde.getValue());
					 data+='&fecha_hasta='+formatDate(dteFechaHasta.getValue());
					 data+='&tipo_reporte='+g_reporte;	
					data+='&dep_emp='+g_emp_dep;	
					// alert (g_reporte);
					 //alert(data);
					 window.open(direccion+'../../../control/estado_cuenta/ActionPDFEstadoCuenta.php?'+data);					
				}
				else
				{
					alert(mensaje);
				}
			}	
		}
	};

	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	function iniciarEventosFormularios()
	{			
		id_depto = ClaseMadre_getComponente('id_depto');
		desc_depto = ClaseMadre_getComponente('desc_depto');	
		id_empleado = ClaseMadre_getComponente('id_empleado');
		estado = ClaseMadre_getComponente('estado');		
		
		dteFechaDesde=ClaseMadre_getComponente('fecha_desde');
		dteFechaHasta=ClaseMadre_getComponente('fecha_hasta');	
		//tipo_reporte=ClaseMadre_getComponente('tipo_reporte');		
		
		
		for(var i=0; i<vectorAtributos.length; i++)
		{
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}
		
		componentes[1].on('select',evento_estado);	
		componentes[4].on('select',evento_departamento);		//departamento	
		componentes[5].on('select',evento_id_empleado);	
		componentes[6].on('select',evento_reporte);	
		CM_ocultarGrupo('Departamento');
		CM_ocultarGrupo('Empleado');	
	}
	
	function evento_departamento( combo, record, index )
	{
		g_id_depto=record.data.id_depto;		
		g_desc_depto=record.data.nombre_depto;
		g_CantFiltros=1;		
		g_emp_dep='1';//depto=1
	}
	
	function evento_id_empleado( combo, record, index )
	{
		g_id_empleado=componentes[5].getValue();
		g_emp_dep='2';
	}	
	
	function evento_estado( combo, record, index )
	{
		g_estado=componentes[1].getValue();
	}
	function evento_reporte( combo, record, index )
	{
		g_reporte=componentes[6].getValue();
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
