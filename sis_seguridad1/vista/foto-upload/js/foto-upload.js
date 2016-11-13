/**
 * Nombre:		  	    
 * Propósito: 			
 * Autor:				MFLORES
 * Fecha creación:		29/06/2011
 */
function pagina_foto_upload(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{	
	var vectorAtributos=new Array;
    var Atributos=new Array;
    var componentes= new Array();
	
    vectorAtributos[0]=
    {
			validacion:
			{
				name:'foto',
				fieldLabel:'Foto persona',
				invalidText: 'Por favor seleccione un archivo',
				allowBlank:true,
				inputType:'file',			
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			save_as:'txt_foto_persona'
		};
	
	//////////////////////////////////////////////////////////////
	// ----------            FUNCIONES RENDER    ---------------//
	//////////////////////////////////////////////////////////////
	function formatDate(value){	return value ? value.dateFormat('d/m/Y') : ''; };
	//////////////////////////////////////////////////////////////
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	//////////////////////////////////////////////////////////////
	//Inicia Layout
	var config={ titulo_maestro:'Listar Documentos' };
	var layout_persona_foto = new DocsLayoutProceso(idContenedor);
	layout_persona_foto.init(config);
	////////////////////////
	// INICIAMOS HERENCIA //
	////////////////////////
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina = BaseParametrosReporte;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,vectorAtributos,layout_persona_foto,idContenedor);
	
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var ClaseMadre_getComponente = this.getComponente;
	///////////////////////////////////
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	///////////////////////////////////
	
    //////////////////////////////////////////////////////////////////////////////
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
	//////////////////////////////////////////////////////////////////////////////
	
	function obtenerTitulo()
	{	var titulo = "Listar Documento";	return titulo;	}
	
	function retorno(resp1,resp2,resp3,resp4){
		Ext.MessageBox.hide();
		var ventana = _CP.getVentana(idContenedor);
		ventana.hide();
		var paginaPadre = _CP.getPagina(idContenedorPadre);
		paginaPadre.pagina.btnActualizar();
	}
	
	function fallo(resp1,resp2,resp3,resp4){
		
	}
	//datos necesarios para el filtro
	var paramFunciones = {
		
		Formulario:{
			html_apply:'dlgInfo-'+idContenedor,
			height:70,
			url:direccion+'../../../control/persona/ActionSubirFoto.php?id_persona='+maestro.id_persona+'&vista_per='+maestro.vista_per,
		    abrir_pestana:false, //abrir pestana
			//titulo_pestana:obtenerTitulo,
			fileUpload:true,
			width:150,
			columnas:['90%'],
			minWidth:150,
			minHeight:100,
			closable:true,
			upload:true,
			success: retorno,
			failure: fallo,
			titulo:'Listar Documento',
			grupos:[
					{
						tituloGrupo:'Subir Foto',
						columna:0,
						id_grupo:0
					}
				]}
	};

	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.reload=function(params){
		componentes[0].reset();
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_persona=datos.id_persona;
   		paramFunciones.Formulario.url=direccion+'../../../control/persona/ActionSubirFoto.php?id_persona='+maestro.id_persona+'&vista_per='+maestro.vista_per;
		this.InitFunciones(paramFunciones);
	};

	
	//Para manejo de eventos

  	function iniciarEventosFormularios()
  	{
		for (var i=0;i<vectorAtributos.length;i++)
		{
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name);
		}
	}
	
	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};
			//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
			this.Init(); //iniciamos la clase madre
			
			
			this.InitFunciones(paramFunciones);
			//para agregar botones
			
			this.iniciaFormulario();
			iniciarEventosFormularios();
			ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
}
