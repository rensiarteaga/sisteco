function LibroMayorPartidaFiltrar(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array();
	var componentes=new Array();
	var codigo_partida;
	var nombre_partida;
	var desc_moneda;
	var id_moneda,id_partida,fecha_inicio,fecha_fin;
	var desc_depto,id_depto,id_fina_regi_prog_proy_acti,desc_ep,id_presupuesto;
	var desc_presupuesto='No Definido';
	// Definición de todos los tipos de datos que se maneja
	// hidden id_tipo_activo
	//en la posición 0 siempre tiene que estar la llave primaria
	//DATA STORE
	//aqui para clase comprobante
  var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/gestion/ActionListarGestion.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_gestion',totalRecords: 'TotalCount'},['id_gestion','gestion','estado_ges_gral'])
	});
	var ds_depto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/depto/ActionListarDepartamento.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_depto',totalRecords:'TotalCount'},['id_depto','codigo_depto','nombre_depto','estado','id_subsistema','nombre_corto','nombre_largo']),baseParams:{m_id_subsistema:9,todos:'si'}});

 /* var ds_partida = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/partida/ActionListarParField.php'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_partida',totalRecords: 'TotalCount'},['id_partida','codigo_partida','nombre_partida','desc_par','nivel_partida','tipo_partida','sw_transaccional','id_partida_padre','id_parametro','desc_partida'])
	});
*/
	var ds_partida = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/partida/ActionListarPartida.php?'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_partida',totalRecords:'TotalCount'},[	'id_partida','codigo_partida','nombre_partida','desc_par','nivel_partida','sw_transaccional','tipo_partida','id_parametro','desc_parametro','id_partida_padre','tipo_memoria','desc_partida']),baseParams:{sw_transaccional:1}
    });
	
var ds_moneda=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
			
	});
	
	
	var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_presupuesto/control/presupuesto/ActionListarComboPresupuesto.php?m_sw_presupuesto=si&oc=si'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','tipo_pres','estado_pres','id_unidad_organizacional','nombre_unidad','id_fina_regi_prog_proy_acti','desc_epe','id_fuente_financiamiento','sigla','estado_gral','gestion_pres','id_parametro','id_gestion','desc_presupuesto','nombre_financiador', 'nombre_regional', 'nombre_programa', 'nombre_proyecto', 'nombre_actividad' ]),
	baseParams:{vista:'libro_mayor_partida',m_sw_rendicion:'no',sw_inv_gasto:'si'}
	});
	
	function render_id_presupuesto(value, p, record){if(record.get('estado_regis')=='2'){return '<span style="color:red;font-size:8pt">' + record.data['desc_presupuesto']+ '</span>';}else {return record.data['desc_presupuesto'];}}
		var tpl_id_presupuesto=new Ext.Template('<div class="search-item">',
		'<b>{nombre_unidad}</b>',
		'<br><b>Gestión: </b><FONT COLOR="#B5A642">{gestion_pres}</FONT>',
		'<br><b>Tipo Presupuesto: </b><FONT COLOR="#B50000">{tipo_pres}</FONT>',
		'<br><b>Fuente de Financiamiento: </b><FONT COLOR="#B5A642">{sigla}</FONT>',
		//'<br> <b>Unidad Organizacional: </b><FONT COLOR="#B5A642">{nombre_unidad}</FONT>',
		'<br>  <b>EP:  </b><FONT COLOR="#B5A642">{desc_epe}</FONT></b>',
		'<br>  <FONT COLOR="#B50000">{nombre_financiador}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_regional}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_programa}</FONT>',
		'<br>  <FONT COLOR="#B50000">{nombre_proyecto}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_actividad}</FONT>',		
		'</div>');
	
	
/*var tpl_id_presupuesto=new Ext.Template('<div class="search-item">',
		'<b>Estructura Programatica:  </b><FONT COLOR="#B5A642">{desc_epe}</FONT></b>',
		'<br>  <FONT COLOR="#B5A642">{nombre_financiador}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_regional}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_programa}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_proyecto}</FONT>',
		'<br>  <FONT COLOR="#B5A642">{nombre_actividad}</FONT>',		
		'</div>');	*/	
	
	var tpl_id_depto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642"><b>Departamento Contable: </b></FONT"><br><FONT COLOR="#000000">{nombre_depto}</FONT>','</div>');				
	function render_id_depto(value, p, record){return String.format('{0}', record.data['nombre_depto']);}

	
	//FUNCIONES RENDER
		 	
	
	//function render_id_partida(value, p, record){return String.format('{0}', record.data['desc_partida']);}
	function render_id_moneda(value,p,record){return String.format('{0}', record.data['desc_moneda'])}
    function render_id_gestion(value, p, record){return String.format('{0}', record.data['gestion']);}
			
   // function render_id_partida(value, p, record){return String.format('{0}', record.data['desc_partida_origen']);}
	var tpl_id_partida=new Ext.Template('<div class="search-item">','<b><FONT COLOR="#000000">{codigo_partida}{nombre_partida}</FONT></b><br>',
	                                                                  '<FONT COLOR="#B5A642">{codigo_partida}</FONT><br>',
	                                                                  '<FONT COLOR="#B5A642">{nombre_partida}</FONT>','</div>');

			//var tpl_id_partida=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{codigo_partida}</FONT><br>','<FONT COLOR="#B5A642">{desc_partida}</FONT>','</div>');
	var tpl_id_gestion=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','<br><FONT COLOR="#B5A642">{estado_ges_gral}</FONT>','</div>');
    var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
				// txt codigo
				
				
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
			queryDelay:100,
			pageSize:100,
			minListWidth:'50%',
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_gestion,
			grid_visible:false,
			grid_editable:true,
			width_grid:100,
			width:'50%',
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
 			name:'id_partida',
			fieldLabel:'Partida ',
			allowBlank:false,			
			emptyText:'Partida ',
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
      		width:'100%',
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
			queryDelay:150,
			pageSize:150,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_moneda,
			grid_visible:false,
			grid_editable:true,
			width_grid:150,
			width:'100%',
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
		//dateFormat:'m-d-Y',
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
			name:'id_presupuesto',
			fieldLabel:'Presupuesto',
			allowBlank:true,			
			emptyText:'Presupuesto....',
			desc:'desc_presupuesto', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_presupuesto,
			valueField:'id_presupuesto',
			displayField:'desc_presupuesto',
			queryParam:'filterValue_0',
			filterCol:'presup.desc_presupuesto',
			
			typeAhead:false,
			tpl:tpl_id_presupuesto,
			forceSelection:true,
			mode:'remote',
			queryDelay:360,
			pageSize:10,
			minListWidth:400,
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			width:200,
			disabled:true	
		},
		tipo:'ComboBox',
		filterColValue:'presup.desc_presupuesto',
		save_as:'id_presupuesto',
		id_grupo:0
	};			

	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////

function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	// ---------- Inicia Layout ---------------//
	var config={
		titulo_maestro:"Libro Mayor Partida"
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
	var cmbtnActualizar=this.btnActualizar;
	//ds_parametro.addListener('loadexception',  ClaseMadre_conexionFailure); //se recibe un error

	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	function iniciarEventosFormularios(){
	 
		combo_gestion = ClaseMadre_getComponente('id_gestion');
		
		id_moneda = ClaseMadre_getComponente('id_moneda');
		fecha_inicio = ClaseMadre_getComponente('fecha_inicio');
		fecha_fin = ClaseMadre_getComponente('fecha_fin');
		id_depto = ClaseMadre_getComponente('id_depto');
		combo_presupuesto = ClaseMadre_getComponente('id_presupuesto');
		combo_partida = ClaseMadre_getComponente('id_partida');
		//id_presupuesto = ClaseMadre_getComponente('id_presupuesto');
		
		
		var onGestion=function(e){
			combo_partida.reset();
			combo_presupuesto.reset();
			ds_partida.baseParams={'sw_transaccional':1,'id_gestion_reporte':e.value};
			combo_partida.modificado=true;
			
		if(parseFloat(id_depto.getValue())>0){
			   ds_presupuesto.baseParams={
					'id_depto':id_depto.getValue(),
					'vista':'libro_mayor_partida',
					'id_gestion_rlm':combo_gestion.getValue()};
					combo_presupuesto.modificado=true;
			}
		
			
				 var id = combo_gestion.getValue();
			if(combo_gestion.store.getById(id)!=undefined){
			    
				intGestion=combo_gestion.store.getById(id).data.gestion;
			
				dte_fecha_ini_valid = '01/01/'+intGestion+' 00:00:00';
				dte_fecha_fin_valid = '12/31/'+intGestion+' 00:00:00';
				dte_fecha_ini_valid=new Date(dte_fecha_ini_valid);
				dte_fecha_fin_valid=new Date(dte_fecha_fin_valid);
				
				//Aplica la validación en la fecha
				fecha_inicio.minValue=dte_fecha_ini_valid;
				fecha_inicio.maxValue=dte_fecha_fin_valid;
				fecha_fin.minValue=dte_fecha_ini_valid;
				fecha_fin.maxValue=dte_fecha_fin_valid;
				
				//Define un valor por defecto
				fecha_inicio.setValue(dte_fecha_ini_valid);
				fecha_fin.setValue(dte_fecha_fin_valid);
				}
			
			
		}
		
		combo_gestion.on('select',onGestion);
		//combo_gestion.on('change',onGestion);
		
		var onDepto=function(e){
			//if(parseFloat(e.value)>0){
				alert(e.value);
				
				combo_presupuesto.enable();
				ds_presupuesto.baseParams={
					'rlmp_id_depto':e.value,
					'vista':'libro_mayor_partida',
					'id_gestion_rlm':combo_gestion.getValue()};
					combo_presupuesto.modificado=true;
				//}
				var iddep=id_depto.getValue()
				
				desc_depto=id_depto.store.getById(iddep).data.codigo_depto+'-'+id_depto.store.getById(iddep).data.nombre_depto;
		}
		
		id_depto.on('select',onDepto);
		
		
		
		
		function f_get_departamento(combo,record,index){
	
			id_depto=record.data.id_depto;
			//alert (id_depto)
			desc_depto=record.data.codigo_depto+'-'+record.data.nombre_depto;
			/*combo_presupuesto.filterValues[1] =  record.data.id_depto;
			combo_presupuesto.filterValues[2] =  'libro_mayor_partida';*/
			combo_presupuesto.modificado = true;  
		
			/*id_presupuesto.store.baseParams={id_depto:record.data.id_depto,vista:'libro_mayor_partida',id_gestion_rlm:id_gestion.getValue()};
		      id_presupuesto.modificado=true;*/
	  }
	  
	    function f_get_ep(combo,record,index){
		/*id_partida.store.baseParams={sw_transaccional:1,id_gestion_reporte:record.data.id_gestion};
		id_partida.modificado=true;*/
			
		id_fina_regi_prog_proy_acti=record.data.id_fina_regi_prog_proy_acti;
		desc_ep=record.data.desc_epe;
		desc_presupuesto=record.data.desc_presupuesto;
			
		}
		function f_get_codigo_partida( combo, record, index ){
		
			codigo_partida=record.data.codigo_partida;
			nombre_partida=record.data.nombre_partida;
		}
		function f_get_moneda(combo,record,index){
			desc_moneda=record.data.nombre
		}
		
		
//		id_depto.on('select',f_get_departamento);
		combo_presupuesto.on('select',f_get_ep);
		combo_partida.on('select',f_get_codigo_partida);
        id_moneda.on('select',f_get_moneda);
	}
	




	//////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
  function iniciarPaginaLibroMayorFiltro()
	{
		for(var i=0;i<vectorAtributos.length-1;i++){

			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name);
			
		}
	 // componentes[2].on('select',f_get_codigo_partida);
     // componentes[3].on('select',f_get_moneda);
      //componentes[6].on('select',f_get_ep);
    //  componentes[1].on('select',f_get_departamento);
	}	
	
	
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
			}
			
			],
			parametros: '',
		    submit:function (){	
					var data ='id_partida='+combo_partida.getValue(); 
					    data+='&id_moneda='+id_moneda.getValue(); 
					    data+='&codigo_partida='+codigo_partida;
					    data+='&nombre_partida='+nombre_partida;
					    data+='&desc_moneda='+desc_moneda;
					    
					    data+='&fecha_inicio='+fecha_inicio.getValue();
					    data+='&fecha_fin='+fecha_fin.getValue();

					    data+='&desc_depto='+desc_depto;
					    data+='&id_depto='+id_depto.getValue();
					    if(id_fina_regi_prog_proy_acti=='%'){
					    	data+='&id_fina_regi_prog_proy_acti=0';
					    }
					    else{
					    	data+='&id_fina_regi_prog_proy_acti='+id_fina_regi_prog_proy_acti;
					    }
					   
					   data+='&desc_ep='+desc_ep;
					   if(combo_presupuesto.getValue()=='%'){
					    	data+='&id_presupuesto=0';
					    }
					    else{
					    	data+='&id_presupuesto='+combo_presupuesto.getValue();
					    }
					   
					    data+='&desc_presupuesto='+desc_presupuesto;
					    data+='&gestion='+combo_gestion.getValue();
					    
				  var mensaje="";
					if(combo_partida.getValue()==""){mensaje+=" Debe elegir una partida";};
					if(id_moneda.getValue()==""){mensaje+="Debe elegir una Moneda";};
					if(mensaje=="")
					{
				  var ParamVentana={Ventana:{width:'90%',height:'90%'}}

				  
				  layout_libro_mayor.loadWindows(direccion+'../../../../sis_contabilidad/vista/libro_mayor_partida/libro_mayor_partida.php?'+data,'Detalle de Libro Mayor Partida',ParamVentana);
			 
					
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
	iniciarPaginaLibroMayorFiltro();
	iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}

