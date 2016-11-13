<?php
/**
 * Nombre:		  	    interfaz_siet_cbte_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				A.V.Q.
 * Fecha creación:		01/11/2015
 *
 */
session_start();
?>
//<script>
function main(){
	 	<?php
		//obtenemos la ruta absoluta
		$host  = $_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$dir = "http://$host$uri/";
		echo "\nvar direccion='$dir';";
	    echo "var idContenedor='$idContenedor';";
	?>
var fa=false;
<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>	
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,
		         CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_siet_cbte(idContenedor,direccion,paramConfig,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
* Nombre:		  	    pag_descargo_detalle.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-05-16 09:53:33
*/
function pagina_siet_cbte(idContenedor,direccion,paramConfig,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var componentes=new Array();
	/*var tituloM,maestro,txt_sw_valida;
	var dialog;
	var tipoDeCambio;
	var importe_concepto;
	var importe_final;
	var sw_filtro;*/
	
	//DATA STORE//
	var ds=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/interfaz_siet/ActionListarSietCbte.php'}),
		reader:new Ext.data.XmlReader({
			record:'ROWS',
			id:'id_siet_cbte',
			totalRecords:'TotalCount'
		},[
		'id_siet_cbte',
		'id_siet_declara',
		'id_cbte',
		'id_subsistema',
		'id_transaccion',
		'fecha_reg'
		
		]),remoteSort:true});
		
	// Definición de datos //
	/*var ds_cbte = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/comprobante/ActionListarRegistroComprobante.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_comprobante',totalRecords: 'TotalCount'},['id_comprobante','nro_cbte','concepto_cbte','glosa_cbte'])
	});
	
	var ds_subsistema = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/subsistema/ActionListarSubsistema.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_subsistema',totalRecords: 'TotalCount'},['id_subsistema','codigo','nombre_corto','nombre_largo'])
			
	});
		
	function render_id_cbte(value, p, record){return String.format('{0}', record.data['concepto_cbte']);}
	var tpl_id_parametro=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5000">{concepto_cbte}</FONT>','</div>');
	
	function render_id_subsistema(value, p, record){return String.format('{0}', record.data['nombre_corto']);}
	var tpl_id_usuario_reg=new Ext.Template('<div class="search-item">','<b>{nombre_corto}</b></FONT>','</div>');
*/
	/*function render_estado(value,p,record)
	{
		//value=='alta'
		if(value=='Cerrado')
		{
			return String.format('{0}',"<div style='text-align:center'><img src='"+direccion+"../../../../lib/imagenes/lock.png' align='center' /></div>")
		}
		else
		{
			if(value=='Abierto')
			return String.format('{0}',"<div style='text-align:center'><img src='"+direccion+"../../../../lib/imagenes/pencil.png' align='center' /></div>");
		}	
	}	
	*/
	
	function renderSeparadorDeMil(value,cell,record,row,colum,store){		
		var monedas_for=new Ext.form.MonedaField();
		return monedas_for.formatMoneda(value)		 
	}
	
		
	
	
	//Sirve para mostrar los datos en el grid	
	/*function renderPeriodo(value, p, record){
		if(value == 1)
		{return "Enero"}
		if(value == 2)
		{return "Febrero"}
		if(value == 3)
		{return "Marzo"}
		if(value == 4)
		{return "Abril"}
		if(value == 5)
		{return "Mayo"}
		if(value == 6)
		{return "Junio"}
		if(value == 7)
		{return "Julio"}
		if(value == 8)
		{return "Agosto"}
		if(value == 9)
		{return "Septiembre"}
		if(value == 10)
		{return "Octubre"}
		if(value == 11)
		{return "Noviembre"}
		if(value == 12)
		{return "Diciembre"}
		else
		{return "T O T A L :"}
	}
	*/
	//en la posición 0 siempre esta la llave primaria
	Atributos[0]={
		validacion:{
			labelSeparator:'',
			name: 'id_siet_cbte',
			inputType:'hidden',
			grid_visible:false, 
			grid_editable:false
		},
		tipo: 'Field',
		filtro_0:false,
		save_as:'id_siet_cbte'
	};	
	Atributos[1]= {
			validacion:{
				name:'id_cbte',
				fieldLabel:'Comprobante',
				desc: 'id_cbte',
				displayField: 'id_cbte',
				
				allowBlank:false,
				maxLength:10,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				width:'55%',
				grid_visible:true,
				grid_editable:false,
				disabled:true,
				width_grid:90,
						
			},
			form:false,	
			tipo: 'TextField',
			filtro_0:true,
			filterColValue:'id_cbte',
			save_as:'txt_id_cbte',
			id_grupo:0
		};
	Atributos[2]= {
			validacion:{
				name:'id_subsistema',
				fieldLabel:'Subsistema',
				desc: 'id_subsistema',
				displayField: 'id_subsistema',
				
				allowBlank:false,
				maxLength:10,
				minLength:0,
				selectOnFocus:true,
				vtype:'texto',
				width:'55%',
				grid_visible:true,
				grid_editable:false,
				disabled:true,
				width_grid:90,
						
			},
			form:false,	
			tipo: 'TextField',
			filtro_0:true,
			filterColValue:'id_subsistema',
			save_as:'txt_id_subsistema',
			id_grupo:0
		};
		Atributos[3]= {
				validacion:{
					name:'id_transaccion',
					fieldLabel:'Transaccion',
					desc: 'id_transaccion',
					displayField: 'id_transaccion',
					
					allowBlank:false,
					maxLength:10,
					minLength:0,
					selectOnFocus:true,
					vtype:'texto',
					width:'55%',
					grid_visible:true,
					grid_editable:false,
					disabled:true,
					width_grid:90,
							
				},
				form:false,	
				tipo: 'TextField',
				filtro_0:true,
				filterColValue:'id_transaccion',
				save_as:'txt_id_transaccion',
				id_grupo:0
			};
		Atributos[4]= {
				validacion:{
					name:'fecha_reg',
					fieldLabel:'Fecha Cbte',
					desc: 'fecha_reg',
					displayField: 'fecha_reg',
					
					allowBlank:false,
					maxLength:10,
					minLength:0,
					selectOnFocus:true,
					vtype:'texto',
					width:'55%',
					grid_visible:true,
					grid_editable:false,
					disabled:true,
					width_grid:90,
							
				},
				form:false,	
				tipo: 'TextField',
				filtro_0:true,
				filterColValue:'fecha_re',
				save_as:'txt_fecha_reg',
				id_grupo:0
			};
	
	// txt id_parametro
	/*Atributos[1]={
			validacion:{
			name:'id_cbte',
			fieldLabel:'Comprobante',
			allowBlank:true,			
			//emptyText:'Parame...',
			desc: 'concepto_cbte', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_cbte,
			valueField: 'id_comprobante',
			displayField: 'concepto_cbte',
			queryParam: 'filterValue_0',
			filterCol:'concepto_cbte',
			typeAhead:true,
			tpl:tpl_id_parametro,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:'50%',
			grow:true,
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			editable:true,
			renderer:render_id_cbte,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'50%',
			disabled:false		
		},
		tipo:'ComboBox',
		//form: false,
		filtro_0:true,
		id_grupo:0,
		filterColValue:'concepto_cbte',
		save_as:'id_comprobante'
	};
	
	/*/	//----------- FUNCIONES RENDER
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
	
	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Proyecto (Maestro)',titulo_detalle:'Comprobantes',grid_maestro:'grid-'+idContenedor};
	var layout_siet_cbte= new DocsLayoutMaestro(idContenedor);
	layout_siet_cbte.init(config);
	
	//---------- INICIAMOS HERENCIA
	this.pagina=Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_siet_cbte,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;
	var CM_ocultarComponente=this.ocultarComponente;
	var CM_mostrarComponente=this.mostrarComponente;
	var CM_ocultarTodosComponente=this.ocultarTodosComponente;
	var CM_mostrarTodosComponente=this.motrarTodosComponente;
	var CM_btnNew=this.btnNew;
	var CM_btnEdit=this.btnEdit;
	var CM_btnEliminar=this.btnEliminar;
	var CM_btnActualizar=this.btnActualizar;
	//var CM_getBoton=this.getBoton;
	var CM_btnSave=this.Save;
	var CM_getDialog=this.getDialog; 
	var getGrid=this.getGrid;
	var Cm_conexionFailure=this.conexionFailure;
	var getFormulario=this.getFormulario;
	var enableSelect=this.EnableSelect;
	var ClaseMadre_clearSelections=this.clearSelections;
	var ClaseMadre_getComponente=this.getComponente; 
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var cm_EnableSelect=this.EnableSelect;
	
	//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={
		//guardar:{crear:true,separador:false},
		//nuevo:{crear:true,separador:true},
		//editar:{crear:true,separador:true},
		//eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}};
		
	//DEFINICIÓN DE FUNCIONES
	var paramFunciones={
		btnEliminar:{url:direccion+'../../../control/ejecucion_fisica/ActionEliminarEjecucionFisica.php'},
		Save:{url:direccion+'../../../control/ejecucion_fisica/ActionGuardarEjecucionFisica.php'},
		ConfirmSave:{url:direccion+'../../../control/ejecucion_fisica/ActionGuardarEjecucionFisica.php'},
		Formulario:{titulo:'CBTE SIET',html_apply:'dlgInfo-'+idContenedor,height:700,width:500,minWidth:150,minHeight:200,closable:true,
		grupos:[{
			tituloGrupo:'Datos',
			columna:0,
			id_grupo:0
		}
		]
		}};
		
	//-------------- Sobrecarga de funciones --------------------//
	this.reload=function(m)
	{
		/*var datos=Ext.urlDecode(decodeURIComponent(m));
		maestro=datos;*/
		maestro=m;
		ds.lastOptions={
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_siet_declara:maestro.id_siet_declara,
				m_id_parametro:maestro.id_parametro					
			}
		};
		
		this.btnActualizar();
		this.InitFunciones(paramFunciones);
	
	};

	
	
	/*function btn_cerrar()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		if(NumSelect!=0)
		{			
			if(componentes[5].getValue()=='Abierto' )	//estado ejecucion fisica
			{
				var sw=false;
				if(confirm('Esta seguro de bloquear la edición del porcentaje de ejcución física del periodo?'))
						{sw=true}
				if(sw)
				{
					var SelectionsRecord=sm.getSelections(); 			
		 			var arr_id_ejecucion_fisica = new Array;
		 			for(var i=0 ; i<NumSelect ; i++)
		 			{
					    arr_id_ejecucion_fisica[i]=SelectionsRecord[i].data.id_ejecucion_fisica;
					    	
						Ext.Ajax.request({
						//url:direccion+"../../../control/modificacion/ActionEstadoModificacion.php",
						url:direccion+"../../../control/ejecucion_fisica/ActionEstadoEjecucionFisica.php",
						method:'POST',
						params:{cantidad_ids:NumSelect,id_ejecucion_fisica:arr_id_ejecucion_fisica[i],accion:'Cerrado'},
						success:ejecucion_fisica_Success,
						failure:ClaseMadre_conexionFailure,
						timeout:100000000
						});	
		 			}			
				}				
			}
			else
			{
				Ext.MessageBox.alert('Atención', 'Solo periodos en estado Abierto pueden ser cerrados.');
			}
		}
		else
		{
			Ext.MessageBox.alert('Atención', 'Antes debe seleccionar un periodo.');
		}
	}	
	
	function ejecucion_fisica_Success(resp)
	{
		Ext.MessageBox.hide();
		
		if(resp.responseXML&&resp.responseXML.documentElement)
		{	
			//Ext.MessageBox.alert('Exito', 'Finalización exitosa, ahora puede imprimir la rendición.')	
			//btn_reporte_modificacion();							
			ClaseMadre_btnActualizar();
		}
		else
		{			
			ClaseMadre_conexionFailure();
		}
	}
	*/
	function btn_solicitud_compra_det(){
		var sm=getSelectionModel();var filas=ds.getModifiedRecords();
		var cont=filas.length;var NumSelect=sm.getCount();
		if(NumSelect!=0){

			var SelectionsRecord=sm.getSelected();
            //alert(maestro.id_parametro);
			var data='m_id_siet_cbte='+SelectionsRecord.data.id_siet_cbte;
			    data=data+'& m_id_siet_declara='+SelectionsRecord.data.id_siet_declara;		
			    data=data+'& m_id_parametro='+maestro.id_parametro;		
			    
			var ParamVentana={Ventana:{width:'90%',height:'70%'}}
			if(SelectionsRecord.data.id_subsistema==9){
					layout_siet_cbte.loadWindows(direccion+'../../../../sis_presupuesto/vista/interfaz_siet/siet_cbte_partida.php?'+data,'Detalle de Partidas',ParamVentana);
			    	layout_siet_cbte.getVentana().on('resize',function(){
					layout_siet_cbte.getLayout().layout();
				})
			}else{
				Ext.MessageBox.alert('Estado', 'Solo Cbtes de Contabilidad pueden acceder a esta función');
			}
		}
		else
		{
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un item.');
		}
	}
	
	
	
	/*
	this.btnNew=function()
	{
		sw_filtro="false";		
		CM_ocultarGrupo('Filtrar');
		CM_mostrarGrupo('Datos');
		CM_mostrarGrupo('Financiera');
		CM_mostrarGrupo('Física');
		CM_btnNew();		
	};
		
	this.Save=function(){	    	
		CM_btnSave()			
	};
	
		
	function filtro()
	{
		if (sw_filtro=="true")
		{	
			ds.baseParams={valor_filtro:parseFloat(h_id_parametro.getValue()),filtro:1}	
			ds.load({params:{start:0,limit:paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,m_id_proyecto:maestro.id_proyecto}});
			dialog.hide()
		}
		else
		{
			CM_btnSave();
		}
	}
	*/
	this.EnableSelect=function(sm,row,rec)
	{
		var sm=getSelectionModel();
		var NumSelect=sm.getCount();
		
		enable(sm,row,rec);
	}
	
	//Para manejo de eventos
	function iniciarEventosFormularios()
	{	
		
		for(var i=0; i<Atributos.length; i++)
		{
			componentes[i]=ClaseMadre_getComponente(Atributos[i].validacion.name)
		}
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_siet_cbte.getLayout()};
	//para el manejo de hijos
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	
	this.InitFunciones(paramFunciones);
	//para agregar botones
	this.AdicionarBoton('../../../lib/imagenes/detalle.png','Detalle de Solicitud',btn_solicitud_compra_det,true,'solicitud_compra_det','');
	
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprime el relacionamiento de cbtes y partidas',btn_reporte,true,'imp_ejecucion','Reporte');
//var CM_getBoton=this.getBoton;
	
	function enable(sm,row,rec)
	{	
		//var CM_getBoton=this.getBoton;	
		cm_EnableSelect(sm,row,rec);
		
		/*if(rec.data['id_subsistema']=='9')//Abierto
		{
			CM_getBoton('guardar-'+idContenedor).enable();
			CM_getBoton('editar-'+idContenedor).enable();
			CM_getBoton('eliminar-'+idContenedor).enable();	
			CM_getBoton('cerrar-'+idContenedor).enable();	
								
		}else
		{
			CM_getBoton('guardar-'+idContenedor).disable();
			CM_getBoton('editar-'+idContenedor).disable();
			CM_getBoton('eliminar-'+idContenedor).disable();
			CM_getBoton('cerrar-'+idContenedor).disable();	
		}*/
	}
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	
	layout_siet_cbte.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario)
}