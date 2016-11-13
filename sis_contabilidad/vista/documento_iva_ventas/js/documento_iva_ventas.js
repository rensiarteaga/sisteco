function documento_iva_ventas(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array();
	var txt_fecha_inicio,txt_fecha_fin,txt_id_moneda,txt_id_depto;
		
	//DATA STORE
	//aqui para clase comprobante
               var ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			   reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
	           });
	        	
				function render_id_moneda(value,p,record){return String.format('{0}', record.data['desc_moneda'])}

				var tpl_id_clase_cbte=new Ext.Template('<div class="search-item">','<b><i>{desc_clase}</i></b>','<br><FONT COLOR="#B5A642"><b>Documento: </b>{desc_documento}</FONT>','</div>');
			    var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
	
	 
	        	var ds_depto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamento.php'}),
				reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_depto',totalRecords:'TotalCount'},['id_depto','codigo_depto','nombre_depto','estado','id_subsistema','nombre_corto','nombre_largo']),baseParams:{m_id_subsistema:9}});
				
				function render_id_depto(value, p, record){return String.format('{0}', record.data['nombre_depto']);}
				var tpl_id_depto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642"><b>Departamento Contable: </b></FONT"><br><FONT COLOR="#000000">{nombre_depto}</FONT>','</div>');				
				
	
	// txt fecha_inicio
	
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
	vectorAtributos[1]={
			validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			allowBlank:false,			
			emptyText:'Moneda...',
			desc: 'desc_moneda', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_moneda,
			valueField: 'id_moneda',
			displayField: 'nombre',
			queryParam: 'filterValue_0',
			filterCol:'MONEDA.nombre',
			typeAhead:false,
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
			width_grid:150,
			width:'50%',
			disable:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'MONEDA.nombre',
		save_as:'id_moneda'
	};					    
			    
			    
			    
	// txt fecha_inicio
	vectorAtributos[2]= {
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
	vectorAtributos[3]= {
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
			
	 
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	// ---------- Inicia Layout ---------------//
	var config={
		titulo_maestro:"Documento IVA"
	};
	layout_documento_iva_ventas=new DocsLayoutProceso(idContenedor);
	layout_documento_iva_ventas.init(config);
	//---------         INICIAMOS HERENCIA           -----------//
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,documento_iva_ventas,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var ClaseMadre_conexionFailure = this.conexionFailure; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_getComponente = this.getComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios(){
	 	txt_fecha_inicio = ClaseMadre_getComponente('fecha_inicio');
		txt_fecha_fin = ClaseMadre_getComponente('fecha_fin');
		txt_id_moneda = ClaseMadre_getComponente('id_moneda');
		txt_id_depto = ClaseMadre_getComponente('id_depto');
		
				txt_id_moneda = ClaseMadre_getComponente('id_moneda');
		
		
		function set_desc_moneda(combo,record, index){txt_desc_moneda=record.data.nombre}
		function set_codigo_depto(combo,record, index){txt_codigo_depto=record.data.codigo_depto}
		txt_id_moneda.on('select',set_desc_moneda);
		txt_id_depto.on('select',set_codigo_depto)
		
	}
    //----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	var paramFunciones = {
		Formulario:{
			labelWidth: 75, //ancho del label
			abrir_pestana:true, //abrir pestana
			titulo_pestana:'Detalle Facturación',
			fileUpload:false,
			columnas:[305,305],
			grupos:[
			{	tituloGrupo:'Datos para obtener Libro Compras',
				columna:0,
				id_grupo:0
			}
			],
			parametros: '',
		submit:function (){	
			
			        var data ='&m_id_moneda='+txt_id_moneda.getValue(); 		
					var mensaje="";
					if(txt_id_moneda.getValue()==""){mensaje+=" Debe elegir una moneda";};
					if(txt_fecha_inicio.getValue()==""){mensaje+=" Debe elegir fecha inicio";};
					if(txt_fecha_fin.getValue()==""){mensaje+=" Debe elegir fecha fin";};
					if(txt_id_depto.getValue()==""){mensaje+=" Debe elegir deprtamento contable";};
					if(mensaje=="")
					{
					data +='&m_id_moneda='+txt_id_moneda.getValue();
					data +='&m_fecha_inicio='+txt_fecha_inicio.getValue().dateFormat('m/d/Y');
					data +='&m_fecha_fin='+txt_fecha_fin.getValue().dateFormat('m/d/Y');
					data +='&m_desc_moneda='+txt_desc_moneda;
					data +='&m_id_depto='+txt_id_depto.getValue();
					data +='&m_codigo_depto='+txt_codigo_depto;
					      
	 		var ParamVentana={Ventana:{width:'90%',height:'70%'}}
				 layout_documento_iva_ventas.loadWindows(direccion+'../../../../sis_contabilidad/vista/documento_iva_ventas/documento_iva_ventas_det.php?'+data,'Detalle Doc Compras',ParamVentana);
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

