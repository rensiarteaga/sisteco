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
var maestro={ id_empleado:'<?php echo $m_id_empleado;?>',
				subsis:'<?php echo $m_subsis;?>',
				vista:'<?php echo $m_vista;?>',
				id_rol:'<?php echo $m_id_rol;?>',
				nom_usuario:'<?php echo $m_nom_usuario?>'
              };
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={pagina:new Suplente(idContenedor,direccion,paramConfig,maestro,idContenedorPadre),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);


function Suplente(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){
	var Atributos=new Array;
	var ContPes=1;
	var layout_suplente;
	
	var ds_doc;
	//var boolSubmit=1;//Variable que indica si se llama directamente al submit

	var ds_empleado = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php?filtro=1'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords: 'TotalCount'},['id_empleado','desc_persona','nombre_tipo_documento','doc_id','email1'])
	});

	var tpl_id_empleado=new Ext.Template('<div class="search-item">','<b>{desc_persona}</b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{nombre_tipo_documento}</FONT>','</div>');
	
	
	var ds_empleado_usuario = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/empleado/ActionListarEmpleado.php?filtro=1'}),
	reader:new Ext.data.XmlReader({record:'ROWS',id:'id_empleado',totalRecords: 'TotalCount'},['id_empleado','desc_persona','nombre_tipo_documento','doc_id','email1'])
	});

	var tpl_id_empleado_usuario=new Ext.Template('<div class="search-item">','<b>{desc_persona}</b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{nombre_tipo_documento}</FONT>','</div>');
	///////id tabla/////////
	
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_empleado_',
			inputType:'hidden'
		},
		tipo:'Field',
		save_as:'id_empleado_',
		defecto:maestro.id_empleado
	};


	
	
	Atributos[4]={
		validacion:{
			name:'id_empleado_suplente',
			fieldLabel:'Empleado Suplente',
			allowBlank:false,
			emptyText:'Empleado suplente...',
			store:ds_empleado,
			valueField:'id_empleado',
			displayField:'desc_persona',
			queryParam:'filterValue_0',
			filterCol:'PERSON.nombre#PERSON.apellido_paterno#PERSON.apellido_materno',
			//typeAhead:true,
			tpl:tpl_id_empleado,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			width:300
		},
		tipo:'ComboBox',
		save_as:'id_empleado_suplente'
	};
	
	Atributos[2]={
			validacion:{
				labelSeparator:'',
				name:'subsis',
				inputType:'hidden'
			},
			tipo:'Field',
			save_as:'subsis',
			defecto:maestro.subsis
		};

	Atributos[3]={
			validacion:{
				labelSeparator:'',
				name:'vista',
				inputType:'hidden'
			},
			tipo:'Field',
			save_as:'vista',
			defecto:maestro.vista
		};
		
		
	Atributos[1]={
		validacion:{
			name:'id_empleado',
			fieldLabel:'Aprobador',
			allowBlank:false,
			emptyText:'Empleado...',
			store:ds_empleado_usuario,
			valueField:'id_empleado',
			displayField:'desc_persona',
			queryParam:'filterValue_0',
			filterCol:'PERSON.nombre#PERSON.apellido_paterno#PERSON.apellido_materno',
			//typeAhead:true,
			tpl:tpl_id_empleado_usuario,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:10,
			minListWidth:'100%',
			grow:true,
			resizable:true,
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			width:300
		},
		tipo:'ComboBox',
		save_as:'id_empleado'
	};
	
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	var config={titulo_maestro:"Suplentes"};
	layout_suplente=new DocsLayoutProceso(idContenedor,idContenedorPadre);
	layout_suplente.init(config);
	//---------         INICIAMOS HERENCIA           -----------//
	this.pagina=BaseParametrosReporte;
	this.pagina(paramConfig,Atributos,layout_suplente,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var CM_conexionFailure=this.conexionFailure;
	var CM_getComponente=this.getComponente;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_btnActualizar=this.btnActualizar;
	var CM_conexionFailure=this.conexionFailure;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	//var CM_submit=this.submit;
	//------  sobrecargo la clase madre obtenerTitulo  para las pestanas-----------------//
	function obtenerTitulo(){
		var titulo="Suplentes"+ContPes;
		ContPes ++;
		return titulo
	}
	function retorno(resp){
		Ext.MessageBox.hide();
		_CP.getVentana(idContenedor).hide();

		var root = resp.responseXML.documentElement;
		var mensaje = root.getElementsByTagName('mensaje')[0].firstChild.nodeValue;

		Ext.Msg.show({
			title:'Estado',
			msg:mensaje,
			minWidth:300,
			maxWidth :800,
			buttons: Ext.Msg.OK
		});
		_CP.getPagina(idContenedorPadre).pagina.btnActualizar()
	}
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //

	//Define el Action para guardar los datos
	var paramFunciones;
	
		//Caso normal
		paramFunciones={
			Formulario:{labelWidth:75,
			url:direccion+'../../../../sis_kardex_personal/control/empleado/ActionGuardarEmpleadoSuplente.php',
			abrir_pestana:false,
			height:30,
			titulo_pestana:obtenerTitulo,
			fileUpload:false,
			success:retorno,
			columnas:[410],
			grupos:[{tituloGrupo:'Empleados',columna:0,id_grupo:0}],parametros:''}
		};
	

	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(params){
		
		var datos=Ext.urlDecode(decodeURIComponent(params));
		
		maestro.id_empleado=datos.m_id_empleado;
		maestro.subsis=datos.m_subsis;
		maestro.vista=datos.m_vista;
		maestro.id_rol=datos.m_id_rol;
		maestro.nom_usuario=datos.m_nom_usuario;
		
		//Define el Action para guardar los datos
		
			//Caso normal
			paramFunciones={
				Formulario:{labelWidth:75,
				url:direccion+'../../../../sis_kardex_personal/control/empleado/ActionGuardarEmpleadoSuplente.php',
				abrir_pestana:false,
				titulo_pestana:obtenerTitulo,
				fileUpload:false,
				success:retorno,
				columnas:[410],
				grupos:[{tituloGrupo:'Empleados',columna:0,id_grupo:0}],parametros:''}
			};


		this.InitFunciones(paramFunciones)
	};


	//Para manejo de eventos
	function iniciarEventosFormularios(){
		
		//ds_empleado.reload();
		
		CM_getComponente('id_empleado').setValue(maestro.id_empleado);
		CM_getComponente('subsis').setValue(maestro.subsis);
		CM_getComponente('vista').setValue(maestro.vista);
		
		if(parseFloat(maestro.id_rol)==1){
			
			CM_mostrarComponente(CM_getComponente('id_empleado'));
			CM_getComponente('id_empleado').setValue('');
		}else{
			
			CM_ocultarComponente(CM_getComponente('id_empleado'));
			CM_getComponente('id_empleado').setValue(CM_getComponente('id_empleado').getValue());
		}
		
	}



	_CP.getVentana(idContenedor).on('resize',this.onResizePrimario);


	this.Init();
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	iniciarEventosFormularios();
	//ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}