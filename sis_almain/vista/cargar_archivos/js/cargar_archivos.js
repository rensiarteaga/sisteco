function CargarArchivos(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var vectorAtributos = new Array;
	var layout_carga,carga_archivo;
	var comp;
	var ContPes=1;
	
	 var componentes= new Array();
	vectorAtributos[0] = {
		validacion:{
			name:'txt_archivo',
			fieldLabel:'Archivo',
			allowBlank:false,
			width: '50%',
			inputType:'file',
			grid_visible:false,
			grid_editable:false
		},
		id_grupo:0,
		tipo:'Field',
		save_as:'txt_archivo'
	};
	vectorAtributos[1] ={
		validacion : {
			labelSeparator : '',
			name : 'id_proyecto',
			inputType : 'hidden',
			grid_visible : false,
			grid_editable : false
		},
		tipo : 'Field',
		save_as :'id_proyecto'
	};
 
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	var config = {
		titulo_maestro:"Carga Items Proyectos"
	};
	layout_carga=new DocsLayoutProceso(idContenedor);
	layout_carga.init(config);
	
	this.pagina=BaseParametrosReporte;
    this.pagina(paramConfig,vectorAtributos,layout_carga,idContenedor);

	

	var ClaseMadre_conexionFailure = this.conexionFailure; 
	var ClaseMadre_getComponente = this.getComponente;
	var ClaseMadre_Save=this.Save;
	var ClaseMadre_btnActualizar = this.btnActualizar;
	
	
	function obtenerTitulo(){
		var titulo="Carga de Archivos "+ContPes;
		ContPes ++;
		return titulo
	}	
	function retorno(resp)
	{
		Ext.MessageBox.hide();//ocultamos el loading
		//var ParamVentana={Ventana:{width:'90%',height:'70%'}}
		//layout_rep_carga.loadWindows(direccion+'../../../vista/lectura_depurada/lectura_depurada.php',"Depuración de Marcas",ParamVentana)	
		Ext.MessageBox.alert('Estado','Los registros se cargaron satisfactoriamente');	
				
	}
	 
	
	var paramFunciones = {
				Formulario:{
					labelWidth:75,
					url:direccion+'../../../../sis_almain/control/cargar_archivos/ActionSaveFiles.php',
					abrir_pestana:false,
					titulo_pestana:obtenerTitulo,
					argument:'',
					fileUpload:true,
					//success:retorno,
					columnas:[320,280],
					grupos:[{tituloGrupo:'Carga de Archivo',columna:0,id_grupo:0}],parametros:''}
	};
	
/*	this.reload=function(params)
	{  
		componentes[0].reset();
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_proyecto=datos.id_proyecto;
		var proy =datos.id_proyecto;
		alert(proy);
   		paramFunciones.Formulario.url=direccion+'../../../../sis_almain/control/cargar_archivos/ActionSaveFiles.php?id_proyecto='+maestro.id_proyecto;
		this.InitFunciones(paramFunciones);
	};*/
	 
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_proyecto=datos.id_proyecto;
		var proy =datos.id_proyecto;
		
		var paramFunciones = {
				Formulario:{
					labelWidth:75,
					url:direccion+'../../../../sis_almain/control/cargar_archivos/ActionSaveFiles.php',
					abrir_pestana:false,
					titulo_pestana:obtenerTitulo,
					argument:'',
					fileUpload:true,
					//success:retorno,
					columnas:[320,280],
					grupos:[{tituloGrupo:'Carga de Archivo',columna:0,id_grupo:0}],parametros:''}
		};	
		ClaseMadre_getComponente('id_proyecto').setValue(proy);
		//ClaseMadre_Save();
	};
	
	function iniciarEventosFormularios()
  	{
		for (var i=0;i<vectorAtributos.length;i++)
		{
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name);
		}
		ClaseMadre_getComponente('id_proyecto').setValue(maestro.id_proyecto);
	}
	
	
	this.Init(); 
	this.InitFunciones(paramFunciones);
	this.iniciaFormulario();
	iniciarEventosFormularios();
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
