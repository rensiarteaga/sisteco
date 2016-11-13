//<script>
function main(){
	 <?php
	//obtenemos la ruta absoluta
	$host  = $_SERVER['HTTP_HOST'];
	$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$dir = "http://$host$uri/";
	echo "\nvar direccion=\"$dir\";";
	echo "var idContenedor='$idContenedor';";
	?>
var paramConfig={TiempoEspera:10000};
var elemento={pagina:new GenerarReporteLlamadasFuncionario(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);
function GenerarReporteLlamadasFuncionario(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
	var ContPes=1;
	var layout_rep_llamadas_funcionario,combo_empleado,combo_tipo_llamada,combo_gerencia,h_txt_fecha_ini,h_txt_fecha_fin,ds_empleado,ds_gerencia,ds_numero,txt_id_gerencia,txt_nombre,txt_descripcion_gerencia,combo_numero,txt_codigo,txt_button;
	// ------------------  PARÁMETROS --------------------------//
	ds_empleado=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../../sis_kardex_personal/control/empleado_extension/ActionListarEmpleadoExtensionGerente_det.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords:'TotalCount'},['id_empleado_extension','codigo_telefonico','id_empleado','id_persona','desc_empleado','id_gerencia','desc_gerencia'])
	});
	ds_gerencia=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../../sis_telefonico/control/gerencia/ActionListarGerencia.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_gerencia',totalRecords:'TotalCount'},['id_gerencia','codigo','nombre_gerencia','descripcion'])
	});
	ds_numero=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../../sis_telefonico/control/llamada/ActionListarNumero.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'numero_marcado',totalRecords:'TotalCount'},['numero_marcado'])
	});
	var resultTplGerencia=new Ext.Template('<div class="search-item">','<b><i>{nombre_gerencia}</i></b>','<br><FONT COLOR="#B5A642">{codigo}</FONT>','</div>');
	var resultTplEmp=new Ext.Template('<div class="search-item">','<b><i>{desc_empleado}</i></b>','<br><FONT COLOR="#B5A642">Código:{codigo_telefonico}</FONT>','</div>');
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
	var filterCols_funcionario=new Array();
	var filterValues_funcionario=new Array();
	filterCols_funcionario[0]='EMPEXT.id_gerencia';
	filterValues_funcionario[0]='%';
	vectorAtributos[1]={
		validacion:{
			fieldLabel:'Funcionario',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Funcionario...',
			name:'desc_empleado',
			desc:'desc_empleado',
			store:ds_empleado,
			valueField:'id_empleado',
			displayField:'desc_empleado',
			queryParam:'filterValue_0',
			filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			filterCols:filterCols_funcionario,
			filterValues:filterValues_funcionario,
			typeAhead:false,
			forceSelection:true,
			tpl:resultTplEmp,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:300,
			resizable:true,
			minChars:0,
			triggerAction:'all',
			editable:true
		},
		id_grupo:0,
		save_as:'txt_codigo_empleado',
		tipo:'ComboBox'
	};
///////// fecha_ini /////////
	vectorAtributos[2]={
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
	vectorAtributos[3]={
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
		vectorAtributos[4]={
		validacion:{
			name:'tipo_llamada',
			fieldLabel:'Tipo de Llamada',
			vtype:'texto',
			emptyText:'Tipo de Llamada...',
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['valor'],data:[['Todas'],['Local'],['Celular'],['Nacional'],['Internacional']]}),
			valueField:'valor',
			displayField:'valor',
			forceSelection:true,
			width:100
		},
		tipo:'ComboBox',
		defecto:"",
		id_grupo:0,
		save_as:'txt_tipo_llamada'
	};
	var filterCols_numero=new Array();
	var filterValues_numero=new Array();
	filterCols_numero[0]='EMPEXT.id_gerencia';
	filterValues_numero[0]='%';
	filterCols_numero[1]='LLAMAD.id_empleado';
	filterValues_numero[1]='%';
	filterCols_numero[2]='TIPLLA.nombre_tipo_llamada';
	filterValues_numero[2]='%';
	vectorAtributos[5]={
		validacion:{
			fieldLabel:'Número Marcado',
			allowBlank:false,
			vtype:"texto",
			emptyText:'Número...',
			name:'numero_marcado',
			desc:'numero_marcado',
			store:ds_numero,
			valueField:'numero_marcado',
			displayField:'numero_marcado',
			filterCol:'LLAMAD.numero_marcado',
			filterCols:filterCols_numero,
			filterValues:filterValues_numero,
			queryParam:'filterValue_0',
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			minListWidth:150,
			resizable:true,
			minChars:0,
			triggerAction:'all',
			editable:true
		},
		id_grupo:0,
		save_as:'txt_numero',
		tipo:'ComboBox'
	};	
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	var config={titulo_maestro:"Llamadas por Funcionario"};
	layout_rep_llamadas_funcionario=new DocsLayoutProceso(idContenedor);
	layout_rep_llamadas_funcionario.init(config);
	//---------         INICIAMOS HERENCIA           -----------//
	this.pagina=BaseParametrosReporte;
    this.pagina(paramConfig,vectorAtributos,layout_rep_llamadas_funcionario,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_getForm=this.getForm;
	ds_empleado.addListener('loadexception',ClaseMadre_conexionFailure);
	ds_gerencia.addListener('loadexception',ClaseMadre_conexionFailure);
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	function iniciarEventosFormularios(){
		combo_empleado=ClaseMadre_getComponente('desc_empleado');
		combo_gerencia=ClaseMadre_getComponente('nombre_gerencia');
		combo_tipo_llamada=ClaseMadre_getComponente('tipo_llamada');
		combo_numero=ClaseMadre_getComponente('numero_marcado');
		h_txt_fecha_ini=ClaseMadre_getComponente('fecha_ini');
		h_txt_fecha_fin=ClaseMadre_getComponente('fecha_fin');
		combo_tipo_llamada.setValue('Todas'); 
		combo_numero.setValue('Todos');
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
		
           var onGerenciaSelect=function(e){
			var id=combo_gerencia.getValue();
			combo_empleado.filterValues[0]=id;
			combo_empleado.modificado=true;
			combo_empleado.setValue('');
			combo_numero.setValue('Todos');
			combo_tipo_llamada.setValue('Todas'); 
			combo_empleado.enable();
			combo_numero.filterValues[0]=id;
			combo_numero.filterValues[2]='%';
			combo_numero.modificado=true
			};
			var onEmpleadoSelect=function(e){
			var id=combo_empleado.getValue();
			combo_tipo_llamada.setValue('Todas');
			combo_numero.setValue('Todos');
			combo_numero.filterValues[1]=id;
			combo_numero.filterValues[2]='%';
			combo_numero.modificado=true
			};
			var onTipoLlamadaSelect=function(e){
			var id=combo_tipo_llamada.getValue();
			combo_numero.setValue('');
			if(id=='Todas'){
			combo_numero.filterValues[2]='%';
			combo_numero.modificado=true	
			}else{
			combo_numero.filterValues[2]=id;
			combo_numero.modificado=true
			}
			};
		combo_gerencia.on('select',onGerenciaSelect);
		combo_gerencia.on('change',onGerenciaSelect);
		combo_empleado.on('select',onEmpleadoSelect);
		combo_empleado.on('change',onEmpleadoSelect);
		combo_tipo_llamada.on('select',onTipoLlamadaSelect);
		combo_tipo_llamada.on('change',onTipoLlamadaSelect)
	}
	function eventosAjax(){
		Ext.lib.Ajax.request('POST','../../../sis_telefonico/control/_reportes/llamadas_gerencia/ActionGerencia.php',
		                     {success:gerencia,failure:this.conexionFailure})
	}
	var InitFunciones=this.InitFunciones;
	var iniciaFormulario=this.iniciaFormulario;
	function obtenerTitulo(){
		var titulo="Llamadas por Funcionario "+ContPes;
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
		Formulario:{labelWidth:75,url:direccion+'../../../../../sis_telefonico/control/_reportes/llamadas_funcionario/ActionRptLlamadasFuncionario.php',abrir_pestana:true,titulo_pestana:obtenerTitulo,fileUpload:false,columnas:[320,280],
			        grupos:[{tituloGrupo:'Datos Funcionario',columna:0,id_grupo:0},{tituloGrupo:'Fecha Inicio',columna:1,id_grupo:1},{tituloGrupo:'Fecha Fin',columna:1,id_grupo:2}],parametros:'id_gerencia='+txt_id_gerencia+'&nombre_gerencia='+txt_nombre+'&descripcion='+txt_codigo}
	};
		InitFunciones(paramFunciones);
		iniciaFormulario();
		iniciarEventosFormularios();
		combo_gerencia.setValue(txt_nombre);
		if(txt_codigo=='null'){
			Ext.Msg.show({
			title:'Estado',
			msg:'El Usuario no pertenece a ninguna Gerencia.',
			minWidth:300,
			maxWidth :800,
			buttons: Ext.Msg.OK
		})
		combo_gerencia.setValue("");
		txt_button=ClaseMadre_getForm();
		 txt_button.buttons[0].disable()
		}
		if(txt_codigo=='GGN' || txt_codigo=='GTI'){
			combo_gerencia.enable();
			combo_gerencia.reset();
			combo_empleado.disable()
		}
		else{
			combo_empleado.filterValues[0]=txt_id_gerencia;
			combo_empleado.modificado=true;
			combo_numero.filterValues[0]=txt_id_gerencia;
			combo_numero.modificado=true
		}
	}
	this.Init();
	eventosAjax();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}