function SumFondoRotatorio(idContenedor,direccion,paramConfig,configConsolidacion)
{
	var vectorAtributos=new Array();	
	var componentes=new Array(); 
	var	g_CantFiltros='';
	
	var g_fecha_fin='';
	var fecha_desde;
	var dteFechaDesde;
	var dteFechaHasta;
	
	var g_desc_caja='';
	
	
	//DATA STORE 		
	
	
	var ds_caja = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/caja/ActionListarCaja.php?estado_repo=1'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_caja',totalRecords: 'TotalCount'},['id_caja','desc_moneda','tipo_caja','desc_unidad_organizacional','codigo_caja','desc_cajero','desc_caja'])
     });
	 
	function render_id_caja(value, p, record){return String.format('{0}', record.data['desc_caja']+'<br>'+record.data['desc_cajero']);}
	var tpl_id_caja=new Ext.Template('<div class="search-item">','<b><i>{codigo_caja} - {desc_unidad_organizacional}</i></b>','<br><FONT COLOR="#B5A642">{desc_cajero}</FONT>','</div>');

    
	vectorAtributos[0]= {
		validacion:{
			name:'fecha_inicio',
			fieldLabel:'Fecha Inicio',
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
		save_as:'fecha_inicio',
		id_grupo:0
	};

	// Definición de datos //
	vectorAtributos[1]= {
		validacion:{
			name:'fecha_fin',
			fieldLabel:'Fecha Fin',
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
		save_as:'fecha_fin',
		id_grupo:0
	};	
	
	vectorAtributos[2]={
			validacion:{
				name:'id_caja',
				fieldLabel:'Caja',
				allowBlank:false,			
				//emptyText:'Caja...',
				desc: 'desc_caja', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_caja,
				valueField: 'id_caja',
				displayField: 'desc_unidad_organizacional',
				queryParam: 'filterValue_0',
				filterCol:'MONEDA.nombre#UNIORG.nombre_unidad',
				typeAhead:true,
				tpl:tpl_id_caja,
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
				renderer:render_id_caja,
				grid_visible:true,
				grid_editable:false,
				width_grid:200,
				width:'100%',
				disabled:false
					
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'CUDOC.desc_caja',
			save_as:'id_caja',
			id_grupo:0
		};
	
	
	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////

	function formatDate(value){	return value ? value.dateFormat('d/m/Y'):''}
	
	// ---------- Inicia Layout ---------------//
	var config=
	{
		titulo_maestro:"Fondo Rotatorio"
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
										
					 data+='&id_caja='+id_caja.getValue();
					 data+='&fecha_inicio='+formatDate(fecha_inicio.getValue());
					 data+='&fecha_fin='+formatDate(fecha_fin.getValue());
					 data+='&caja='+g_desc_caja;
					
					 window.open(direccion+'../../../control/cuenta_doc/reportes/ActionPDFRepFondoRotatorio.php?'+data);					
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
		id_caja = ClaseMadre_getComponente('id_caja');
		//desc_caja = ClaseMadre_getComponente('desc_caja');
		fecha_inicio=ClaseMadre_getComponente('fecha_inicio');
		fecha_fin=ClaseMadre_getComponente('fecha_fin');		
		
		for(var i=0; i<vectorAtributos.length; i++)
		{
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name)
		}
		componentes[2].on('select',evento_caja);
	}
	function evento_caja( combo, record, index )
	{
		g_desc_caja=record.data.desc_caja;
				
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
