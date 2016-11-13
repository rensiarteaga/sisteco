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

var elemento ={pagina:new ImpViatico(idContenedor,direccion,paramConfig,configConsolidacion),idContenedor:idContenedor};

   ContenedorPrincipal.setPagina(elemento);
  }
Ext.onReady(main,main);

//view added

function ImpViatico(idContenedor,direccion,paramConfig,configConsolidacion)
{
	var vectorAtributos=new Array();	
	var componentes=new Array(); 
	var	g_CantFiltros='';
	
	var g_fecha_fin='';
	var fecha_desde;
	var dteFechaDesde;
	var dteFechaHasta;
	
	var g_desc_empleado='';
	
	
	//DATA STORE 		
	
	
	var ds_empleado = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords: 'TotalCount'},['id_empleado','apellido_paterno','apellido_materno','nombre','desc_persona']),baseParams:{oc:'si'}});
	 
	function render_id_empleado(value, p, record){return String.format('{0}', record.data['desc_empleado']);}
	var tpl_id_empleado=new Ext.Template('<div class="search-item">','{desc_persona}<br>','<FONT COLOR="#B5A642">{codigo_empleado}</FONT>','</div>');
    
	
	vectorAtributos[0]= {
		validacion:{
			name:'fecha_inicio',
			fieldLabel:'Fecha Inicio',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'D�a no v�lido',
			grid_visible:true,
			grid_editable:true,
			grid_indice:8,
			renderer: formatDate,
			width_grid:85
		},
		tipo:'DateField',
		dateFormat:'m-d-Y',
		save_as:'fecha_inicio',
		id_grupo:0
	};

	// Definici�n de datos //
	vectorAtributos[1]= {
		validacion:{
			name:'fecha_fin',
			fieldLabel:'Fecha Fin',
			allowBlank:false,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'D�a no v�lido',
			grid_visible:true,
			grid_editable:true,
			grid_indice:8,
			renderer: formatDate,
			width_grid:85
		},
		tipo:'DateField',
		dateFormat:'m-d-Y',
		save_as:'fecha_fin',
		id_grupo:0
	};	
	
	vectorAtributos[2]={
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
			minChars:1, ///caracteres m�nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_empleado,
			grid_visible:true,
			grid_editable:false,
			width_grid:120,
			width:300,
			disabled:false,
			grid_indice:0		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue: 'CUDOC.desc_empleado',
		id_grupo:0		
	};
	vectorAtributos[3]={
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
				//emptyText:'Seleccione una opci�n...',
				width:250		
			},   
			tipo: 'ComboBox',
			filtro_0:true
		};
	vectorAtributos[4]={
			validacion:{
				name: 'tipo_reporte',
				fieldLabel:'Elija el Reporte',
				allowBlank:false,
				typeAhead:true,
				loadMask:true,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['viat_importe','Reporte: Importe de Viaticos'],['viat_dias','Reporte: Cant Dias Viaje']]}),
				valueField:'id',
				displayField:'valor',
				lazyRender:true,								
				forceSelection:true,
				//emptyText:'Seleccione una opci�n...',
				width:250		
			},   
			tipo: 'ComboBox',
			filtro_0:true
		};
	vectorAtributos[5]={
			validacion:{
				name: 'tipo_personal',
				fieldLabel:'Personal',
				allowBlank:false,
				typeAhead:true,
				loadMask:true,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['planta','Planta'],['consultor','Consultores']]}),
				valueField:'id',
				displayField:'valor',
				lazyRender:true,								
				forceSelection:true,
				//emptyText:'Seleccione una opci�n...',
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
		titulo_maestro:"Viaticos"
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
	//----------------------  DEFINICI�N DE FUNCIONES ------------------------- //
	//  aqu� se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	var paramFunciones = {

		Formulario:{
			labelWidth: 75, //ancho del label
		 	//url:direccion+'../../../control/ejecucion/ActionPDFEjecucion_x_fechas.php',
			abrir_pestana:true, //abrir pestana
			titulo_pestana:'Detalle de Estado de Rendiciones',
			fileUpload:false,
			columnas:[505,305],			
			grupos:[
				{
					tituloGrupo:'Datos Para Generar el Reporte',
					columna:0,
					id_grupo:0
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
										
					 data+='&id_empleado='+id_empleado.getValue();
					 data+='&fecha_inicio='+formatDate(fecha_inicio.getValue());
					 data+='&fecha_fin='+formatDate(fecha_fin.getValue());
					 data+='&empleado='+g_desc_empleado;
					 data+='&reporte='+reporte.getValue();
					 data+='&tipo_personal='+tipo_personal.getValue();
					// alert(tipo_reporte.getValue());
					 if (tipo_reporte.getValue()=='viat_importe'){
						 window.open(direccion+'../../../control/cuenta_doc/ActionPDFRepImpViatico.php?'+data);
					 }else{
					     window.open(direccion+'../../../control/cuenta_doc/ActionPDFRepImpViaticoDias.php?'+data);
					 }
				}
				else
				{
					alert(mensaje);
				}
			}	
		}
	};

	//-------------- DEFINICI�N DE FUNCIONES PROPIAS --------------//

	function iniciarEventosFormularios()
	{			
		id_empleado = ClaseMadre_getComponente('id_empleado');
		//desc_caja = ClaseMadre_getComponente('desc_caja');
		fecha_inicio=ClaseMadre_getComponente('fecha_inicio');
		fecha_fin=ClaseMadre_getComponente('fecha_fin');		
		reporte=ClaseMadre_getComponente('reporte');
		tipo_reporte=ClaseMadre_getComponente('tipo_reporte');
		tipo_personal=ClaseMadre_getComponente('tipo_personal');
		
		for(var i=0; i<vectorAtributos.length; i++)
		{
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}
		componentes[2].on('select',evento_empleado);
		
	}
	function evento_empleado( combo, record, index )
	{
		g_desc_empleado=record.data.desc_persona;
				
	}

	//InitBarraMenu(array BOTONES DISPONIBLES);
	this.Init(); //iniciamos la clase madre
	//InitBarraMenu(array DE PAR�METROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
    //Se agrega el bot�n para la generaci�n del reporte
	this.iniciaFormulario();
	iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
