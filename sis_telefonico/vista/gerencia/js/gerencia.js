/**
 * Nombre:		  	    gerencia.js
 * Propósito: 			pagina gerencia
 * Autor:				Fernando Prudencio
 * Fecha creación:		2008-01-17 15:14:26
 */
function pagina_gerencia(idContenedor,direccion,paramConfig){
	var vectorAtributos=new Array;
	var ds,layout_gerencia;
	var elementos=new Array();
	var sw=0;
	//  DATA STORE //
	ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/gerencia/ActionListarGerencia.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_gerencia',totalRecords:'TotalCount'},
		['id_gerencia','codigo','nombre_gerencia','descripcion']),remoteSort:true});
	ds.load({params:{start:0,limit:paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros}});
	// hidden id_gerencia
	vectorAtributos[0]={
		validacion:{
			labelSeparator:'',
			name:'id_gerencia',
			inputType:'hidden'
		},
		tipo:'Field',
		filtro_0:false,
		save_as:'hidden_id_gerencia'
	};
// txt nombre_gerencia
	vectorAtributos[1]={
		validacion:{
			name:'codigo',
			fieldLabel:'Código',
			allowBlank:false,
			maxLength:4,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:'50%',
			grid_visible:true,
			grid_editable:true,
			width_grid:90
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'GERENC.codigo',
		save_as:'txt_codigo'
	};
// txt nombre_gerencia
	vectorAtributos[2]={
		validacion:{
			name:'nombre_gerencia',
			fieldLabel:'Nombre Gerencia',
			allowBlank:false,
			maxLength:60,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:'90%',
			grid_visible:true,
			grid_editable:true,
			width_grid:235
		},
		tipo:'TextField',
		filtro_0:true,
		filterColValue:'GERENC.nombre_gerencia',
		save_as:'txt_nombre_gerencia'
	};
// txt descripcion
	vectorAtributos[3]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripción',
			allowBlank:true,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:true,
			width_grid:200
		},
		tipo:'TextArea',
		filtro_0:true,
		filterColValue:'GERENC.descripcion',
		save_as:'txt_descripcion'
	};
	// ----------            FUNCIONES RENDER    ---------------//
	function formatDate(value){return value ? value.dateFormat('d/m/Y'):''}
	//---------         INICIAMOS LAYOUT MAESTRO     -----------//
	var config={titulo_maestro:'Gerencia',grid_maestro:'grid-'+idContenedor};
	layout_gerencia=new DocsLayoutMaestro(idContenedor);
	layout_gerencia.init(config);
	// INICIAMOS HERENCIA //
	this.pagina=Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_gerencia,idContenedor);
	//--------------- HERENCIA DE LA CLASE MADRE ---------------------//
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	// DEFINICIÓN DE LA BARRA DE MENÚ//
	var paramMenu={guardar:{crear:true,separador:false},nuevo:{crear:true,separador:true},editar:{crear:true,separador:false},eliminar:{crear:true,separador:false},actualizar:{crear:true,separador:false}};
	//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/gerencia/ActionEliminarGerencia.php'},
		Save:{url:direccion+'../../../control/gerencia/ActionGuardarGerencia.php'},
		ConfirmSave:{url:direccion+'../../../control/gerencia/ActionGuardarGerencia.php'},
		Formulario:{html_apply:'dlgInfo-'+idContenedor,height:240,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Gerencia'}
	};
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//
    function btn_empleado_extension(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){
			var SelectionsRecord=sm.getSelected();
			var data='m_id_gerencia='+SelectionsRecord.data.id_gerencia;
			data=data+'&m_nombre_gerencia='+SelectionsRecord.data.nombre_gerencia;
			data=data+'&m_descripcion='+SelectionsRecord.data.descripcion;
			var ParamVentana={Ventana:{width:'90%',height:'70%'}};
			layout_gerencia.loadWindows(direccion+'../../../../sis_kardex_personal/vista/empleado_extension/empleado_extension_det.php?'+data,'Funcionario',ParamVentana);
            layout_gerencia.getVentana().on('resize',function(){layout_gerencia.getLayout().layout()})
		}
	else{
		Ext.MessageBox.alert('Estado','Antes debe seleccionar un item.')
	}
	}
	this.getLayout=function(){
		return layout_gerencia.getLayout()
	};
	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(var i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i]
			}
		}
	};
	this.getElementos=function(){return elementos};
	this.setPagina=function(elemento){elementos.push(elemento)};
	//-------------- FIN DEFINICIÓN DE FUNCIONES PROPIAS --------------//
	this.Init();
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	this.AdicionarBoton('../../../lib/imagenes/user_add.png','Funcionarios',btn_empleado_extension,true,'empleado_extension','');
	this.iniciaFormulario();
	layout_gerencia.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario)
}