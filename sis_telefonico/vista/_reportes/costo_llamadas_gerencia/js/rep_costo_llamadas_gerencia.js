function GenerarReporteCostoLlamadasGerencia(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
	var ContPes=1;
	var layout_rep_costo_llamadas_gerencia,h_txt_fecha_ini,h_txt_fecha_fin,cmb_gerencia,ds_gerencia,txt_id_gerencia,txt_nombre,txt_descripcion_gerencia,txt_codigo,txt_button;
	// ------------------  PARÁMETROS --------------------------//
	ds_gerencia=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../../sis_telefonico/control/gerencia/ActionListarGerencia.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_gerencia',totalRecords:'TotalCount'},['id_gerencia','codigo','nombre_gerencia','descripcion'])
	});
	var resultTplGerencia=new Ext.Template('<div class="search-item">','<b><i>{nombre_gerencia}</i></b>','<br><FONT COLOR="#B5A642">{codigo}</FONT>','</div>');
	/////////// txt gerencia//////
	vectorAtributos[0]={
		validacion:{
			fieldLabel:'Gerencia',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Gerencia...',
			name:'nombre_gerencia',
			desc:'nombre_gerencia',
			store:ds_gerencia,
			valueField:'id_gerencia',
			displayField:'nombre_gerencia',
			filterCol:'nombre_gerencia',
			typeAhead:false,
			forceSelection:true,
			tpl:resultTplGerencia,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:0,
			triggerAction:'all',
			editable:true,
			disabled:true
		},
		id_grupo:0,
		save_as:'txt_gerencia',
		tipo:'ComboBox'
	};
///////// fecha_ini /////////
	vectorAtributos[1]={
		validacion:{
			name:'fecha_ini',
			fieldLabel:'Fecha Inicio',
			allowBlank:false,
			format:'d/m/Y',
			minValue:'01/01/1900',
			renderer:formatDate,
			disabled:false
		},
		id_grupo:1,
		tipo:'DateField',
		save_as:'txt_fecha_ini',
		dateFormat:'m/d/Y',
		defecto:""
	};
	///////// fecha /////////
	vectorAtributos[2]={
		validacion:{
			name:'fecha_fin',
			fieldLabel:'Fecha Fin',
			allowBlank:false,
			format:'d/m/Y',
			minValue:'01/01/1900',
			renderer:formatDate,
			disabled:false
		},
		id_grupo:2,
		tipo:'DateField',
		save_as:'txt_fecha_fin',
		dateFormat:'m/d/Y',
		defecto:""
	};
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	var config={titulo_maestro:"Costo de Llamadas por Gerencia"};
	layout_rep_costo_llamadas_gerencia=new DocsLayoutProceso(idContenedor);
	layout_rep_costo_llamadas_gerencia.init(config);
	//---------         INICIAMOS HERENCIA           -----------//
	this.pagina=BaseParametrosReporte;
    this.pagina(paramConfig,vectorAtributos,layout_rep_costo_llamadas_gerencia,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_getForm=this.getForm;
	ds_gerencia.addListener('loadexception',ClaseMadre_conexionFailure);
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios(){
		h_txt_fecha_ini=ClaseMadre_getComponente('fecha_ini');
		h_txt_fecha_fin=ClaseMadre_getComponente('fecha_fin');
		var mes=new Date();
		mes=mes.getMonth();
		mes=mes+1;
		var primera_fecha=new Date();
		var fecha_actual=new Date();
		var dia=fecha_actual.getDate();
		if (mes<10){
		primera_fecha='01/0'+mes+'/'+primera_fecha.getFullYear();
		h_txt_fecha_ini.setValue(primera_fecha);
		  if(dia<10){
		   fecha_actual='0'+dia+'/0'+mes+'/'+fecha_actual.getFullYear();
		   h_txt_fecha_fin.setValue(fecha_actual)  	
		  }
		  else{
		  	fecha_actual=dia+'/0'+mes+'/'+fecha_actual.getFullYear();
		   h_txt_fecha_fin.setValue(fecha_actual)  	
		  }
		}
		else{
		  primera_fecha='01/'+mes+'/'+primera_fecha.getFullYear();
		  h_txt_fecha_ini.setValue(primera_fecha);
		  if(dia<10){
		   fecha_actual='0'+dia+'/'+mes+'/'+fecha_actual.getFullYear();
		   h_txt_fecha_fin.setValue(fecha_actual)  	
		  }
		  else{
		  	fecha_actual=dia+'/'+mes+'/'+fecha_actual.getFullYear();
		   h_txt_fecha_fin.setValue(fecha_actual)  	
		  }
		}
	}
	function eventosAjax(){
		Ext.lib.Ajax.request('POST','../../../sis_telefonico/control/_reportes/llamadas_gerencia/ActionGerencia.php',
		                     {success:gerencia,failure:this.conexionFailure})
	}
	var InitFunciones=this.InitFunciones;
	var iniciaFormulario=this.iniciaFormulario;
	//------  sobrecargo la clase madre obtenerTitulo  para las pestanas-----------------//
	function obtenerTitulo(){
		var titulo="Costo de Llamadas por Gerencia "+ContPes;
		ContPes ++;
		return titulo
	}
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	function gerencia(resp){
		var regreso=Ext.util.JSON.decode(resp.responseText);
		txt_id_gerencia=regreso.id_gerencia;
		txt_nombre=regreso.nombre_gerencia;
		txt_codigo=regreso.codigo;
		txt_descripcion_gerencia=regreso.descripcion;
		var paramFunciones={
		Formulario:{labelWidth:75,url:direccion+'../../../../../sis_telefonico/control/_reportes/costo_llamadas_gerencia/ActionRptCostoLlamadasGerencia.php',abrir_pestana:true,titulo_pestana:obtenerTitulo,fileUpload:false,columnas:[320,280],
			        grupos:[{tituloGrupo:'Gerencia',columna:0,id_grupo:0},{tituloGrupo:'Fecha Inicio',columna:1,id_grupo:1},{tituloGrupo:'Fecha Fin',columna:1,id_grupo:2}],parametros:'id_gerencia='+txt_id_gerencia+'&nombre_gerencia='+txt_nombre+'&descripcion='+txt_codigo}
	     };
		InitFunciones(paramFunciones);
		iniciaFormulario();
		iniciarEventosFormularios();
		cmb_gerencia=ClaseMadre_getComponente('nombre_gerencia');
		cmb_gerencia.setValue(txt_nombre);
		if(txt_codigo=='null'){
			Ext.Msg.show({
			title:'Estado',
			msg:'El Usuario no pertenece a ninguna Gerencia.',
			minWidth:300,
			maxWidth :800,
			buttons: Ext.Msg.OK
		})
		cmb_gerencia.setValue("");
		 txt_button=ClaseMadre_getForm();
		 txt_button.buttons[0].disable()
		 }
		if(txt_codigo=='GGN' || txt_codigo=='GTI'){
			cmb_gerencia.enable();
			cmb_gerencia.reset()
		}	
	}
	this.Init();
    eventosAjax();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}