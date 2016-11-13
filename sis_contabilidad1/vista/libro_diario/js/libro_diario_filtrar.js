function LibroDiarioFiltrar(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array();
	var parametro;
	var gestion;
	var periodo;
	var nombre_depto;
	var id_moneda,id_parametro,tipo_pres,f_f,e_p_e,u_o;
	
//	var ds_cbte_clase = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/cbte_clase/ActionListarCbteClase.php'}),
//		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_clase_cbte',totalRecords: 'TotalCount'},['id_clase_cbte','desc_clase','estado_clase','id_documento','desc_documento'])
//	});
	
	var ds_depto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamento.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_depto',totalRecords:'TotalCount'},['id_depto','codigo_depto','nombre_depto','estado','id_subsistema','nombre_corto','nombre_largo']),baseParams:{m_id_subsistema:9}});
//   	function render_id_clase_cbte(value, p, record){return String.format('{0}', record.data['desc_clase']);}
	function render_id_moneda(value,p,record){return String.format('{0}', record.data['desc_moneda'])}

	//var tpl_id_clase_cbte=new Ext.Template('<div class="search-item">','<b><i>{desc_clase}</i></b>','<br><FONT COLOR="#B5A642"><b>Documento: </b>{desc_documento}</FONT>','</div>');
	var tpl_id_depto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642"><b>Departamento Contable: </b></FONT"><br><FONT COLOR="#000000">{nombre_depto}</FONT>','</div>');				
	function render_id_depto(value, p, record){return String.format('{0}', record.data['nombre_depto']);}
//	id_clase_cbte
//	vectorAtributos[0]  = {
//		validacion: {
//			name:'id_clase_cbte',
//			desc:'desc_clase',
//			fieldLabel:'Clase Comprobante',
//			vtype:'texto',
//			emptyText:'Clase Comprobante...',
//			onSelect: function(){getComponente('fecha_fin').minValue=getComponente('fecha_inicio')},
//			allowBlank: false,
//			typeAhead: true,
//			tpl:tpl_id_clase_cbte,
//			loadMask: false,
//			triggerAction: 'all',
//			store:ds_cbte_clase,
//			valueField:'id_clase_cbte',
//			displayField:'desc_clase',
//			renderer: render_id_clase_cbte,
//			forceSelection:true,
//			pageSize:100,
//			grid_visible:true, // se muestra en el grid
//			grid_editable:true, //es editable en el grid,
//			width_grid:100, // ancho de columna en el gris
//			width:'50%'
//			
//		},
//		tipo:'ComboBox',
//		filtro_0:true,
//		
//		save_as:'id_clase_cbte',
//		id_grupo: 0
//	};  
//
 vectorAtributos[0]={
			validacion:{
			name:'id_depto',
			fieldLabel:'Departamento',
			allowBlank:false,			
			emptyText:'Departamento...',
			desc: 'nombre_depto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_depto,
			valueField: 'id_depto',
			displayField: 'nombre_depto',
			queryParam: 'filterValue_0',
			//filterCol:'MONEDA.nombre',
			typeAhead:false,
			tpl:tpl_id_depto,
			forceSelection:true,
			mode:'remote',
			queryDelay:50,
			pageSize:50,
			minListWidth:'50%',
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_depto,
			grid_visible:false,
			grid_editable:true,
			width_grid:50,
			width:'30%',
			disable:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		//filterColValue:'MONEDA.nombre',
		save_as:'id_depto'
	};	
	// txt fecha_inicio
	vectorAtributos[1]= {
		validacion:{
			name:'fecha_inicio',
			fieldLabel:'Fecha Inicio',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue: '01/01/1900',
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:80,
			disabled:false
			
		},
		form:true,
		tipo:'DateField',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_inicio'
	};
	
	// txt fecha_fin
	vectorAtributos[2]= {
		validacion:{
			name:'fecha_fin',
			fieldLabel:'Fecha Fin',
			allowBlank:true,
			format: 'd/m/Y', //formato para validacion
			minValue:  '01/01/1900',
			onSelect: function(){getComponente('fecha_fin').minValue=getComponente('fecha_inicio')},
			forceSelection:true,
			disabledDaysText: 'Día no válido',
			grid_visible:true,
			grid_editable:false,
			renderer: formatDate,
			width_grid:80,
			disabled:false
			
		},
		form:true,
		tipo:'DateField',
		dateFormat:'m-d-Y',
		defecto:'',
		save_as:'txt_fecha_fin'
			};


	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////

	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	
	// ---------- Inicia Layout ---------------//
	var config={
		titulo_maestro:"Consolidación Presupuesto"
	};
	layout_libro_diario1=new DocsLayoutProceso(idContenedor);
	layout_libro_diario1.init(config);

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS HERENCIA           -----------//
	//////////////////////////////////////////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,layout_libro_diario1,idContenedor);

	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//

	var ClaseMadre_conexionFailure = this.conexionFailure; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_getComponente = this.getComponente;
	var CM_ocultarComponente=this.ocultarComponente;

	//ds_parametro.addListener('loadexception',  ClaseMadre_conexionFailure); //se recibe un error

	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	function iniciarEventosFormularios(){
	 
		id_moneda = ClaseMadre_getComponente('id_moneda');
		id_depto = ClaseMadre_getComponente('id_depto');
		fecha_inicio = ClaseMadre_getComponente('fecha_inicio');
		fecha_fin = ClaseMadre_getComponente('fecha_fin');
		 
		
		
		var f_nombre_depto = function(combo,record,index) {
						nombre_depto=record.data.codigo_depto;
		};
 
		id_depto.on('select',f_nombre_depto);
		
		
		
	}

	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////

	var paramFunciones = {
		Formulario:{
			labelWidth: 75, //ancho del label
		 	url:direccion+'../../../../sis_presupuesto/vista/consolidacion_presupuesto/consolidacion_presupuesto.php',
			abrir_pestana:true, //abrir pestana
			titulo_pestana:'Detalle Facturación',
			fileUpload:false,
			columnas:[305,305],
			grupos:[
			{
				tituloGrupo:'Datos para obtener libro Dia',
				columna:0,
				id_grupo:0
			}
			
			],
			parametros: '',
		
		submit:function (){	
			var data ='&m_id_depto='+id_depto.getValue(); 
			var mensaje="";
			if(id_depto.getValue()==""){mensaje+=" Debe elegir un departamento";};
				if(mensaje==""){
					
					data +='&m_fecha_inicio='+fecha_inicio.getValue().dateFormat('m/d/Y');
					data +='&m_fecha_fin='+fecha_fin.getValue().dateFormat('m/d/Y');
					data +='&m_nombre_depto='+nombre_depto;

	 				var ParamVentana={Ventana:{width:'90%',height:'90%'}}
				 	layout_libro_diario1.loadWindows(direccion+'../../../../sis_contabilidad/vista/libro_diario/libro_diario.php?'+data,'Detalle de Partida Gasto',ParamVentana);
			 	}
				else{alert(mensaje);}
			}
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

