function LibretaBancaria(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array();
	var componentes=new Array();
	var txt_id_cuenta_bancaria;
	var	txt_fecha_inicio;
	var	txt_fecha_fin;
	var txt_id_moneda;
	var txt_desc_institucion;
	var txt_nro_cuenta_banco;
	var txt_nombre_moneda;
	var txt_desc_cuenta;
	var g_reporte;
	
	g_reporte = 0;

	var ds_cuenta_bancaria=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_tesoreria/control/cuenta_bancaria/ActionListarCuentaBancaria.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta_bancaria',totalRecords: 'TotalCount'},['id_cuenta_bancaria','id_institucion','desc_institucion','id_cuenta','desc_cuenta','nro_cheque','estado_cuenta','nro_cuenta_banco','id_moneda','nombre_moneda','gestion'])
	});
	
	var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',
		id:'id_parametro',totalRecords: 'TotalCount'},['id_parametro','id_gestion','gestion','cantidad_nivel','estado_gestion','gestion_conta',
		'cantidad_nivel','estado_gestion']),
		baseParams:{m_estado:2}
	});
	
	function render_tipo(value, p, record)
	{	if(value=='rango'){return 'RANGO';}
		if(value=='detalle'){return 'DETALLE';}
		if(value=='cabecera'){return 'CABECERA';}
	}

	var tpl_cuenta_bancaria=new Ext.Template('<div class="search-item">','<b><i>{desc_institucion}</i></b>','<br><FONT COLOR="#B5A642"><b>Nro Cuenta: </b>{nro_cuenta_banco}</FONT>','<br><FONT COLOR="#B5A642"><b>Gestion: </b>{gestion}</FONT>','</div>');
	
	function render_id_parametro(value, p, record){return String.format('{0}', record.data['desc_parametro']);}
	var tpl_id_parametro=new Ext.Template('<div class="search-item">','<b>Gestion: </b><FONT COLOR="#B5A642">{gestion_conta}</FONT><br>','<b>Esatdo: </b><FONT COLOR="#B5A642">{estado_gestion}</FONT><br>','</div>');

	vectorAtributos[0]={
		validacion:{
			name:'id_parametro',
			fieldLabel:'Gestion',
			allowBlank:false,
			emptyText:'Gestion...',
			desc: 'desc_parametro', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_parametro,
			valueField: 'id_parametro',
			displayField: 'gestion_conta',
			queryParam: 'filterValue_0',
			filterCol:'GESTIO.gestion',
			typeAhead:true,
			tpl:tpl_id_parametro,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_parametro,
			pageSize:10,
			width:250
		},
		tipo:'ComboBox',
		save_as:'id_parametro',
		id_grupo: 0
	};
	
	 vectorAtributos[1]={
		validacion:{
			name:'id_cuenta_bancaria',
			fieldLabel:'Cuenta Bancaria',
			vtype:'texto',
			emptyText:'Cuenta Bancaria...',
			allowBlank:false,
			typeAhead:false,
			tpl:tpl_cuenta_bancaria,
			loadMask:true,
			triggerAction:'all',
			queryParam:'filterValue_0',
			filterCol :'INSTIT.nombre#CUEBAN.nro_cuenta_banco#GESTION.GESTION',
			store:ds_cuenta_bancaria,
			valueField:'id_cuenta_bancaria',
			displayField:'nro_cuenta_banco',
			forceSelection:true,
			pageSize:10,
			width:250
		},
		tipo:'ComboBox',
		save_as:'id_cuenta_bancaria',
		id_grupo: 0
	};  
	// txt fecha_inicio
	vectorAtributos[2]={
		validacion:{
			name:'fecha_inicio',
			fieldLabel:'Fecha Inicio',
			allowBlank:false,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900'
		},
		tipo:'DateField',
		dateFormat:'m-d-Y',
		save_as:'txt_fecha_inicio'
			};

	// txt fecha_fin 
	vectorAtributos[3]={
		validacion:{
			name:'fecha_fin',
			fieldLabel:'Fecha Fin',
			allowBlank:false,
			format:'d/m/Y', //formato para validacion
			minValue:'01/01/1900'
		},
		tipo:'DateField',
		dateFormat:'m-d-Y',
		save_as:'txt_fecha_fin'
		};
     
	vectorAtributos[4]={
		validacion:{
			labelSeparator:'',
			name:'id_moneda',
			inputType:'hidden'
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'id_moneda'
	};
		
     vectorAtributos[5]={
		validacion:{
			name:'sw_actualizacion',
			fieldLabel:'Actualización',
			allowBlank:false,
			align:'left',
			emptyText:'Actualiza...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['si','CON ACTUALIZACIÓN'],['no','SIN ACTUALIZACION']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,
			forceSelection:false,
			grid_visible:false,
			renderer:render_tipo,
			grid_editable:false,
			width_grid:200,
			minListWidth:200,
			disabled:false
		},
		tipo:'ComboBox',
		defecto:'si',
		form: true,
		save_as:'sw_actualizacion'
	 };		
     
     vectorAtributos[6]={
		validacion:{
			name:'sw_estado',
			fieldLabel:'Reporte',
			allowBlank:false,
			align:'left',
			emptyText:'Reporte de ...',
			loadMask:true,
			maxLength:50,
			minLength:0,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[[0,'Libreta Bancaria'],[5,'Cheques Anulados']]}),
			valueField:'ID',
			displayField:'valor',
			mode:'local',
			lazyRender:true,
			forceSelection:false,
			grid_visible:false,
			renderer:render_tipo,
			grid_editable:false,
			width_grid:200,
			minListWidth:200,
			disabled:false
		},
		tipo:'ComboBox',
		defecto:0,
		form: true,
		save_as:'sw_estado'
	 };
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
     function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
      
	// ---------- Inicia Layout ---------------//
	var config={
		titulo_maestro:"Conciliacion Bancaria"
	};
	layout_libreta_bancaria=new DocsLayoutProceso(idContenedor);
	layout_libreta_bancaria.init(config);
	
	//---------         INICIAMOS HERENCIA           -----------//
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=BaseParametrosReporte;
	
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,layout_libreta_bancaria,idContenedor);
	
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var ClaseMadre_conexionFailure=this.conexionFailure; // para heredar de la clase madre la funcion eliminarSucces de esta forma se encuentra disponible tambien para los metodos y no solo para el contructor
	var ClaseMadre_getComponente=this.getComponente;
	var CM_ocultarComponente=this.ocultarComponente;
	
	//-------------- DEFINICIï¿½N DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios(){
		txt_id_cuenta_bancaria=ClaseMadre_getComponente('id_cuenta_bancaria');
		txt_fecha_inicio=ClaseMadre_getComponente('fecha_inicio');
		txt_fecha_fin=ClaseMadre_getComponente('fecha_fin');
		txt_id_moneda=ClaseMadre_getComponente('id_moneda');
		txt_sw_actualizacion=ClaseMadre_getComponente('sw_actualizacion');
		txt_sw_estado=ClaseMadre_getComponente('sw_estado');
		
		componentes[0]=ClaseMadre_getComponente(vectorAtributos[0].validacion.name)
		componentes[1]=ClaseMadre_getComponente(vectorAtributos[1].validacion.name)
		componentes[2]=ClaseMadre_getComponente(vectorAtributos[6].validacion.name)
		
		var onCuentaBancariaSelect=function(combo,record,index){
			txt_id_moneda.setValue(record.data.id_moneda);
			txt_desc_institucion=record.data.desc_institucion;
	        txt_nro_cuenta_banco=record.data.nro_cuenta_banco;
	        txt_nombre_moneda=record.data.nombre_moneda;
	        txt_desc_cuenta=record.data.desc_cuenta;			   
		};
		txt_id_cuenta_bancaria.on('select',onCuentaBancariaSelect);
		componentes[0].on('select',evento_gestion);
		componentes[2].on('select',evento_reporte);
	}
	
	function evento_gestion( combo, record, index )
	{	
		//combo cuenta_bancaria						
		componentes[1].store.baseParams={m_id_gestion:record.data.id_gestion};
		componentes[1].modificado=true;
		componentes[1].setValue('');			
		componentes[1].setDisabled(false);	
 	}
	
	function evento_reporte( combo, record, index )
	{	
		//combo reporte						
		g_reporte = componentes[2].getValue();	
 	}
	//----------------------  DEFINICIï¿½N DE FUNCIONES ------------------------- //
	//  aquï¿½ se parametrizan las funciones que se ejecutan en la clase madre    //
	var paramFunciones={
		Formulario:{
			labelWidth:75, //ancho del label
			abrir_pestana:true, //abrir pestana
			titulo_pestana:'Conciliacion Bancaria',
			fileUpload:false,
			columnas:[450],
			grupos:[
			{
				tituloGrupo:'Datos de Cuenta Bancaria',
				columna:0,
				id_grupo:0
			}
			],
			parametros: '',
			submit:function (){	
					var data ='m_id_cuenta_bancaria='+txt_id_cuenta_bancaria.getValue();
					var mensaje="";
					
					if(txt_id_cuenta_bancaria.getValue()==""){mensaje+=" Debe elegir una cuenta bancaria";};
					//if(componentes[5].getValue==""){mensaje+=" Debe elegir reporte";};
					
					if(mensaje==""){
					   data +='&m_fecha_inicio='+txt_fecha_inicio.getValue().dateFormat('m-d-Y');
					   data +='&m_fecha_fin='+txt_fecha_fin.getValue().dateFormat('m-d-Y');
					   data +='&m_id_moneda='+txt_id_moneda.getValue();
					   data +='&m_desc_institucion='+txt_desc_institucion;
					   data +='&m_nro_cuenta_banco='+txt_nro_cuenta_banco;
					   data +='&m_nombre_moneda='+txt_nombre_moneda;
					   data +='&m_desc_cuenta='+txt_desc_cuenta;
					   data +='&m_sw_actualizacion='+txt_sw_actualizacion.getValue();
					   data +='&m_sw_estado='+txt_sw_estado.getValue();
					   
					   //alert (g_reporte);
					   if (g_reporte==0){
						   var ParamVentana={Ventana:{width:'80%',height:'70%'}}
					       layout_libreta_bancaria.loadWindows(direccion+'../../../../sis_contabilidad/vista/libreta_bancaria/libreta_bancaria_det.php?'+data,'Libreta Bancaria',ParamVentana)
					   }
					   else
					   {
						   window.open(direccion+'../../../../sis_contabilidad/control/comprobante/reporte/ActionPDFLibretaBancariaAnulado.php?'+data)
					   }
					}
		         else{alert(mensaje)}
			}
		}
	}
	//InitBarraMenu(array BOTONES DISPONIBLES);
	this.Init(); //iniciamos la clase madre
	//InitBarraMenu(array DE PARï¿½METROS PARA LAS FUNCIONES DE LA CLASE MADRE);
	this.InitFunciones(paramFunciones);
    //Se agrega el botï¿½n para la generaciï¿½n del reporte
	this.iniciaFormulario();
	iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}

