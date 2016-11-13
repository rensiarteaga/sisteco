function LibroMayorFiltrar(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array();
	var componentes=new Array();
	var nro_cuenta;
	var nombre_cuenta;
	var desc_moneda;
	var nombre_depto,cmbCuentaIni,cmbCuentaFin,chkRango; 
	//var	d_parametro=1;
/*	var parametro;
	var gestion;
	var periodo;
*/	var id_moneda,id_cuenta,fecha_inicio,fecha_fin;
	// Definición de todos los tipos de datos que se maneja
	// hidden id_tipo_activo
	//en la posición 0 siempre tiene que estar la llave primaria
	//DATA STORE
	//aqui para clase comprobante
  var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/gestion/ActionListarGestion.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_gestion',totalRecords: 'TotalCount'},['id_gestion','gestion','estado_ges_gral'])
	});
   
	
var ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
			
	});
	
var ds_depto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamento.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_depto',totalRecords:'TotalCount'},['id_depto','codigo_depto','nombre_depto','estado','id_subsistema','nombre_corto','nombre_largo']),baseParams:{m_id_subsistema:9}});
	//FUNCIONES RENDER
		 	
	
	function render_id_cuenta(value, p, record){return String.format('{0}', record.data['desc_cuenta']);}
	function render_id_moneda(value,p,record){return String.format('{0}', record.data['desc_moneda'])}

    function render_id_gestion(value, p, record){return String.format('{0}', record.data['gestion']);}
					//function render_id_moneda(value,p,record){return String.format('{0}', record.data['gestion'])}
	function render_id_depto(value, p, record){return String.format('{0}', record.data['nombre_depto']);}

	
			var tpl_id_cuenta=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{nro_cuenta}</FONT><br>','<FONT COLOR="#B5A642">{descripcion}</FONT>','</div>');
			var tpl_id_gestion=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','<br><FONT COLOR="#B5A642">{estado_ges_gral}</FONT>','</div>');
       		var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
				// txt codigo
			var tpl_id_depto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642"><b>Departamento Contable: </b></FONT"><br><FONT COLOR="#000000">{nombre_depto}</FONT>','</div>');				
				
	 vectorAtributos[0]={
			validacion:{
			name:'id_gestion',
			fieldLabel:'Gestion',
			allowBlank:false,			
			emptyText:'Gestion...',
			desc: 'gestion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_gestion,
			valueField: 'id_gestion',
			displayField: 'gestion',
			queryParam: 'filterValue_0',
			//filterCol:'MONEDA.nombre',
			typeAhead:false,
			tpl:tpl_id_gestion,
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
			renderer:render_id_gestion,
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
		save_as:'id_gestion'
	};	
	 vectorAtributos[1]={
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
	
	vectorAtributos[2]={
		validacion:{
			name:'id_cuenta',
			desc:'desc_cuenta',
			fieldLabel:'Cuenta',
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			grid_visible:true,
			grid_editable:false,
			renderer:render_id_cuenta,
			width_grid:200,
			width:200,
			pageSize:30,
			direccion:direccion,
			allowBlank:false,
			filterCols:['sw_transaccional'],
			filterValues:['1']
		},
		tipo:'LovCuenta',
		save_as:'id_cuenta',
		id_grupo:1
	};
		
		
		 vectorAtributos[3]={
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
			pageSize:10,
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
	vectorAtributos[4]= {
		validacion:{
			name:'fecha_inicio',
			fieldLabel:'Fecha Inicio',
			allowBlank:false,
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
		save_as:'fecha_inicio'
			};
// txt fecha_fin
	vectorAtributos[5]= {
		validacion:{
			name:'fecha_fin',
			fieldLabel:'Fecha Fin',
			allowBlank:false,
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
		save_as:'fecha_fin'
			};
	
	vectorAtributos[6]={
			validacion:{
				labelSeparator:'',
				name:'por_rango',
				fieldLabel:'Por rango:',
				allowBlank:true,
				grid_visible:false,
				grid_editable:false
			},
			tipo:'Checkbox',
			filtro_0:false,
			save_as:'por_rango',
			id_grupo:0
		};
	
	vectorAtributos[7]={
			validacion:{
				name:'cuenta_ini',
				desc:'desc_cuenta',
				fieldLabel:'Cuenta Inicio',
				valueField: 'nro_cuenta',
				maxLength:100,
				minLength:0,
				selectOnFocus:true,
				vtype:"texto",
				grid_visible:true,
				grid_editable:false,
				//renderer:render_id_cuenta_ini,
				width_grid:200,
				width:200,
				pageSize:30,
				direccion:direccion,
				filterCols:['rango'],
				filterValues:['si']
			},
			tipo:'LovCuenta',
			id_grupo:2
		};
	
	filterCols_cuenta=new Array();
	filterValues_cuenta=new Array();
	filterCols_cuenta[0]='rango';
	filterValues_cuenta[0]='si';
	vectorAtributos[8]={
			validacion:{
				name:'cuenta_fin',
				desc:'desc_cuenta',
				fieldLabel:'Cuenta Fin',
				valueField: 'nro_cuenta',
				maxLength:100,
				minLength:0,
				selectOnFocus:true,
				vtype:"texto",
				grid_visible:true,
				grid_editable:false,
				//renderer:render_id_cuenta_fin,
				width_grid:200,
				width:200,
				pageSize:30,
				direccion:direccion,
				filterCols:filterCols_cuenta,
				filterValues:filterValues_cuenta
			},
			tipo:'LovCuenta',
			id_grupo:2
		};

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////

function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	// ---------- Inicia Layout ---------------//
	var config={
		titulo_maestro:"Libro Mayor"
	};
	layout_libro_mayor=new DocsLayoutProceso(idContenedor);
	layout_libro_mayor.init(config);

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS HERENCIA           -----------//
	//////////////////////////////////////////////////////////////

	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,layout_libro_mayor,idContenedor);

	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//

	var ClaseMadre_conexionFailure = this.conexionFailure; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_getComponente = this.getComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	var ClaseMadre_getDialog=this.getDialog;
	var ClaseMadre_getGrid=this.getGrid;
	var ClaseMadre_getFormulario=this.getFormulario;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_ValidarCampos=this.ValidarCampos;
	//ds_parametro.addListener('loadexception',  ClaseMadre_conexionFailure); //se recibe un error

	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	function iniciarEventosFormularios(){
	 
		id_gestion = ClaseMadre_getComponente('id_gestion');
		id_cuenta = ClaseMadre_getComponente('id_cuenta');
		id_moneda = ClaseMadre_getComponente('id_moneda');
		fecha_inicio = ClaseMadre_getComponente('fecha_inicio');
		fecha_fin = ClaseMadre_getComponente('fecha_fin');
		id_depto = ClaseMadre_getComponente('id_depto');
		chkRango=ClaseMadre_getComponente('por_rango');
		cmbCuentaIni = ClaseMadre_getComponente('cuenta_ini');
		cmbCuentaFin = ClaseMadre_getComponente('cuenta_fin');
		
		function f_filtrar_cuenta(combo,record,index)
		{
			id_cuenta.store.baseParams={m_id_gestion:record.data.id_gestion};
			id_cuenta.modificado=true;
			cmbCuentaIni.store.baseParams={m_id_gestion:record.data.id_gestion};
			cmbCuentaFin.store.baseParams={m_id_gestion:record.data.id_gestion};
			cmbCuentaIni.modificado=true;
			cmbCuentaFin.modificado=true;
		}
		function f_nombre_depto(combo,record,index)
		{		nombre_depto=record.data.nombre_depto;
		}
	 	function f_get_nro_cuenta( combo, record, index ){
			nro_cuenta=record.data.nro_cuenta;
			nombre_cuenta=record.data.nombre_cuenta;
	
		}
		function f_get_moneda(combo,record,index){
		desc_moneda=record.data.nombre		
		}
		
		function f_rango_cuentas(){
			if(chkRango.getValue()){
				//ocultar grupo de cuenta
				CM_ocultarGrupo('Cuenta Contable');
				//Mostrar grupo de rango de cuentas
				CM_mostrarGrupo('Rango de Cuentas');
				
				//Cambia la obligatoriedad de los campos
				id_cuenta.allowBlank=true;
				cmbCuentaIni.allowBlank=false;
				cmbCuentaFin.allowBlank=false;
			} else{
				//ocultar grupo de rango de cuentas
				CM_ocultarGrupo('Rango de Cuentas');
				//Mostrar grupo de cuenta
				CM_mostrarGrupo('Cuenta Contable');
				
				//Cambia la obligatoriedad de los campos
				id_cuenta.allowBlank=false;
				cmbCuentaIni.allowBlank=true;
				cmbCuentaFin.allowBlank=true;
			}
		}
		
		function f_filtarCuentas(){
			var numCuenta = cmbCuentaIni.getValue()=='' ? 'x':cmbCuentaIni.getValue();
			if(cmbCuentaFin.filterValues[0]!==numCuenta){
				cmbCuentaFin.filterValues[0] = numCuenta;
				cmbCuentaFin.modificado = true;
				cmbCuentaFin.setValue('');
			}
		}
		
		//Por defecto oculta el grupo de rango de cuentas
		CM_ocultarGrupo('Rango de Cuentas');
		
		id_gestion.on('select',f_filtrar_cuenta);
		id_depto.on('select',f_nombre_depto);
		id_cuenta.on('select',f_get_nro_cuenta);
		id_moneda.on('select',f_get_moneda);
		chkRango.on('check',f_rango_cuentas);
		cmbCuentaIni.on('valid',f_filtarCuentas);
		
		/*fecha_inicio = ClaseMadre_getComponente('fecha_inicio');
		fecha_fin = ClaseMadre_getComponente('fecha_fin');*/
	}
	


	//------  sobrecargo la clase madre obtenerTitulo  para las pestanas-----------------//
//	function obtenerTitulo()
//	{
//		var lov_empleado = ClaseMadre_getComponente('des_empleado');
//		var aux = lov_empleado.lov.recuperar_valoresSelecionados();
//
//		return aux["nombre"] + " " +aux["apellido_paterno"] + " " + aux["apellido_materno"];
//	}



	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
  function iniciarPaginaLibroMayorFiltro()
	{}	
		
	
	var paramFunciones = {

		Formulario:{
			labelWidth: 75, //ancho del label
		 //	url:direccion+'../../../../sis_presupuesto/vista/consolidacion_presupuesto/consolidacion_presupuesto.php',
			abrir_pestana:true, //abrir pestana
			//titulo_pestana:'Detalle Facturación',
			fileUpload:false,
			columnas:[305,305],
			grupos:[
			{
				tituloGrupo:'Datos para Obtener Libro Mayor',
				columna:0,
				id_grupo:0
			},
			{
				tituloGrupo:'Cuenta Contable',
				columna:0,
				id_grupo:1
			},
			{
				tituloGrupo:'Rango de Cuentas',
				columna:0,
				id_grupo:2
			}
			
			],
			parametros: '',
		submit:function (){	
					var data ='&id_cuenta='+id_cuenta.getValue(); 
					    data+='&id_moneda='+id_moneda.getValue(); 
					    data+='&nro_cuenta='+nro_cuenta;
					    data+='&nombre_cuenta='+nombre_cuenta;
					    data+='&desc_moneda='+desc_moneda;
					    data+='&fecha_inicio='+fecha_inicio.getValue();
					    data+='&fecha_fin='+fecha_fin.getValue();
					    data+='&id_depto='+id_depto.getValue();
					    data+='&nombre_depto='+nombre_depto;
					    data+='&cuenta_ini='+cmbCuentaIni.getValue();
					    data+='&cuenta_fin='+cmbCuentaFin.getValue();
					    data+='&por_rango='+chkRango.getValue();
					    data+='&id_gestion='+id_gestion.getValue();
					    //alert(data);
					 var mensaje="";
					/*if(id_cuenta.getValue()==""){mensaje+=" Debe elegir una cuenta";};
					if(id_moneda.getValue()==""){mensaje+="Debe elegir una Moneda";};*/
					/*if(mensaje=="")*/
					 //console.log(this.getFormulario);
					if(CM_ValidarCampos())
					{
				//		for(var i=0;i<id_moneda.store.data.length;i++){
					 	/*if(id_moneda.store.getAt(i).data['id_moneda']==id_moneda.getValue()) 
						{
						data+='&m_desc_moneda='+id_moneda.store.getAt(i).data['nombre']; 	
						};*/
					  
					/*for(var i=0;i<id_parametro.store.data.length;i++){
					 	if(id_parametro.store.getAt(i).data['id_parametro']==id_parametro.getValue()) 
						{
						data+='&m_gestion_pres='+id_parametro.store.getAt(i).data['gestion_pres']; 	
						data+='&m_desc_estado_gral='+id_parametro.store.getAt(i).data['desc_estado_gral']; 	
						};
					*/
					//}
					
					/*data +='&m_id_moneda='+id_moneda.getValue();
					*/
					//data +='&m_id_cuenta='+id_cuenta.getValue();
					//data +='&m_desc_cuenta='+desc_cuenta.getValue();
					/*data +='&m_fecha_fin='+fecha_fin.getValue().dateFormat('m/d/Y');
				*/	////data +='&m_sw_vista='+configConsolidacion.sw_vista;
		      //}
		      //vectorAtributos[1].on('select',function (combo, record, index){g_id_cuenta=cuenta.getValue();g_nombre_cuenta=record.data['nombre_cuenta'];g_nro_cuenta=record.data['nro_cuenta']});
	
		      // data+='&m_nro_cuenta'+g_nro_cuenta;
	 		var ParamVentana={Ventana:{width:'90%',height:'90%'}}
				 layout_libro_mayor.loadWindows(direccion+'../../../../sis_contabilidad/vista/libro_mayor/libro_mayor.php?'+data,'Detalle de Libro Mayor',ParamVentana);
			 }

			}
		}
	}
	
   
	//InitBarraMenu(array BOTONES DISPONIBLES);
	this.Init(); //iniciamos la clase madre
	//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
    //Se agrega el botón para la generación del reporte
	this.iniciaFormulario();
	iniciarPaginaLibroMayorFiltro();
	iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}

