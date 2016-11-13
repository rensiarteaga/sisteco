<?php
/**
 * Nombre:		  	    siet_cbte_partida_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-06 20:48:42
 *
 */
session_start();
?>
//<script>
//var paginaTipoActivo;

	function main(){
	 	<?php
		//obtenemos la ruta absoluta
		$host  = $_SERVER['HTTP_HOST'];
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$dir = "http://$host$uri/";
		echo "\nvar direccion='$dir';";
	    echo "var idContenedor='$idContenedor';";
	?>
	var fa;
	<?php if($_SESSION["ss_filtro_avanzado"]!=''){
		echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}
	?>
var paramConfig={TamanoPagina:20,TiempoEspera:10000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var maestro={id_siet_cbte:<?php echo $id_siet_cbte;?>,
	     id_siet_declara:<?php echo $id_siet_declara;?>,
	     id_parametro:<?php echo $id_parametro;?>,
         tipo_declara:<?php echo $tipo_declara;?>};

idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_siet_cbte_partida(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
//ContenedorPrincipal.getPagina(idContenedorPadre).pagina.setPagina(elemento);
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_siet_cbte_partida.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-06 20:48:43
 */
function pagina_siet_cbte_partida(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var vectorAtributos=new Array;
	var ds;
	var elementos=new Array();  
	var componentes=new Array();
	var sw=0;
    var monedas_for=new Ext.form.MonedaField(
  			{
  				name:'mes_01',
  				fieldLabel:'Enero',
  				allowBlank:false,
  				align:'right',
  				maxLength:50,
  				minLength:0,
  				selectOnFocus:true,
  				allowDecimals:true,
  				decimalPrecision:2,
  				allowNegative:false,
  				minValue:0}
  				);
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/interfaz_siet/ActionListarSietCbtePartida.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_siet_cbte_partida',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_siet_ent_ua_transf',
		'id_siet_cbte_partida',
		'id_siet_cbte',
		'id_partida',
		'codigo_partida',
		'id_oec',
		'codigo_oec',
		'importe',
		'desc_partida',
		'desc_oec',
		'codigo'
		
	]),remoteSort:true});

	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_siet_cbte:maestro.id_siet_cbte,
			m_id_siet_declara:maestro.id_siet_declara
		}
	});
	 var ds_partida = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/partida/ActionListarPartida.php?sw_vista_reporte=rep_ejecucion_partida&id_tipo_pres='+tipo_declara+'&id_parametro='+maestro.id_parametro}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_partida',totalRecords:'TotalCount'},['id_partida','codigo_partida','nombre_partida','tipo_partida'])
			//baseParams:{sw_vista_reporte:'rep_ejecucion_partida',sid_tipo_pres:'2',$id_parametro:maestro.id_parametro}
	});
	
	 var ds_oec = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/oec/ActionListarOec.php?id_parametro='+maestro.id_parametro}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_oec',totalRecords:'TotalCount'},['id_oec','codigo_oec','nombre_oec','desc_oec'])
			//baseParams:{sw_vista_reporte:'rep_ejecucion_partida',sid_tipo_pres:'2',$id_parametro:maestro.id_parametro}
	});

	 var ds_entidad_transf = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/interfaz_siet/ActionListarEntidadTransf.php'}),
			reader: new Ext.data.XmlReader({record:'ROWS',id:'id_siet_ent_ua_transf',totalRecords:'TotalCount'},['id_siet_ent_ua_transf','id_siet_entidad_transf','codigo','denominacion','sigla','codigo_ua','denominacion_ua','sigla_ua'])
			//baseParams:{sw_vista_reporte:'rep_ejecucion_partida',sid_tipo_pres:'2',$id_parametro:maestro.id_parametro}
	});
	
	//FUNCIONES RENDER
	 function renderSeparadorDeMil(value,cell,record,row,colum,store)
		{
			return monedas_for.formatMoneda(value)
		}
		
	function render_id_partida(value, p, record){return String.format('{0}', record.data['desc_partida']);}
	var tpl_id_partida=new Ext.Template('<div class="search-item">','<b><i>{codigo_partida}</i></b>','<br><FONT COLOR="#B5A642">{nombre_partida}:{tipo_partida}</FONT>','</div>');

	function render_id_siet_entidad_transf(value, p, record){return String.format('{0}', record.data['codigo']);}
	var tpl_id_siet_entidad_transf=new Ext.Template('<div class="search-item">','<b><i>Entidad Transferencia: {codigo}-{denominacion}</i></b>','<br><FONT COLOR="#B5A642">Unidad Administrativa: {codigo_ua}-{denominacion_ua}</FONT>','</div>');
	
	function render_id_oec(value, p, record){return String.format('{0}', record.data['desc_oec']);}
	var tpl_id_oec=new Ext.Template('<div class="search-item">','<b><i>{codigo_oec}</i></b>','<br><FONT COLOR="#B5A642">{desc_oec}</FONT>','</div>');
	
	// DEFINICIÓN DATOS DEL MAESTRO
	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Cbte',maestro.id_siet_cbte]]}),cm:cmMaestro});
	gridMaestro.render();
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	vectorAtributos[0]={
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name: 'id_siet_cbte_partida',
				inputType:'hidden',
				grid_visible:false, 
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'id_siet_cbte_partida'
			
		};
	vectorAtributos[1]={
				validacion:{
					//fieldLabel: 'Id',
					labelSeparator:'',
					name: 'id_siet_cbte',
					inputType:'hidden',
					grid_visible:false, 
					grid_editable:false
				},
				tipo: 'Field',
				filtro_0:false,
				save_as:'id_siet_cbte',
				defecto:maestro.id_siet_cbte
				
			};
		
	vectorAtributos[2]={
			validacion:{
				fieldLabel:'Partida',
				allowBlank:true,
				vtype:"texto",
				emptyText:'Partida...',
				name:'id_partida',
				desc:'codigo_partida',
				store:ds_partida,
				valueField:'id_partida',
				displayField:'codigo_partida',
				filterCol:'PARTID.nombre_partida#PARTID.codigo_partida',
				typeAhead:false,
				forceSelection:false,
				tpl:tpl_id_partida,
				mode:'remote',
				queryDelay:50,
				pageSize:10,
				minListWidth:200,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1,
				triggerAction:'all',
				editable:true,
				renderer:render_id_partida,
				grid_visible:true,
				grid_editable:false,
				width_grid:320,
				width:200
			},
			tipo:'ComboBox',
			filtro_0:true,
			filterColValue:'PARTID.nombre_partida#PARTID.codigo_partida'
		
		};
	vectorAtributos[3]={
			validacion:{
				fieldLabel:'OEC',
				allowBlank:true,
				vtype:"texto",
				emptyText:'OEC...',
				name:'id_oec',
				desc:'codigo_oec',
				store:ds_oec,
				valueField:'id_oec',
				displayField:'codigo_oec',
				filterCol:'OEC.nombre_oec#OEC.codigo_oec',
				typeAhead:false,
				forceSelection:false,
				tpl:tpl_id_oec,
				mode:'remote',
				queryDelay:50,
				pageSize:10,
				minListWidth:200,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1,
				triggerAction:'all',
				editable:true,
				renderer:render_id_oec,
				grid_visible:true,
				grid_editable:false,
				width_grid:320,
				width:200
			},
			tipo:'ComboBox',
			filtro_0:true,
			filterColValue:'OEC.nombre_oec#OEC.codigo_oec'
		
		};		
	// txt precio_referencial_estimado
	vectorAtributos[4]={
			validacion:{
				name:'importe',
				fieldLabel:'Importe Ejecutado',
				allowBlank:true,
				maxLength:20,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision:4,//para numeros float
				allowNegative:false,
				minValue:0,
				vtype:'texto',
				grid_visible:true,
				grid_editable:true,
				renderer: renderSeparadorDeMil,
				width_grid:95,
				align:'right',
				width:'40%',
				disable:false
			},
			tipo: 'NumberField',
			form: true,
			filtro_0:false,
			filterColValue:'importe',
			save_as:'importe'
			
		};
	
	vectorAtributos[5]={
			validacion:{
				fieldLabel:'Entidad Transf',
				allowBlank:true,
				vtype:"texto",
				emptyText:'Entidad Transf...',
				name:'id_siet_ent_ua_transf',
				desc:'codigo',
				store:ds_entidad_transf,
				valueField:'id_siet_ent_ua_transf',
				displayField:'codigo',
				filterCol:'ENTTRA.codigo#ENTTRA.denominacion',
				typeAhead:false,
				forceSelection:false,
				tpl:tpl_id_siet_entidad_transf,
				mode:'remote',
				queryDelay:50,
				pageSize:10,
				minListWidth:200,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1,
				triggerAction:'all',
				editable:true,
				renderer:render_id_siet_entidad_transf,
				grid_visible:true,
				grid_editable:false,
				width_grid:320,
				width:200
			},
			tipo:'ComboBox',
			filtro_0:true,
			filterColValue:'ENTTRA.codigo#ENTTRA.denominacion',
			save_as:'id_siet_ent_ua_transf'
		};	

	// txt precio_referencial_estimado
	/*vectorAtributos[6]={
			validacion:{
				name:'ua_transf',
				fieldLabel:'UA Transf',
				allowBlank:true,
				maxLength:20,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision:4,//para numeros float
				allowNegative:false,
				minValue:0.1,
				vtype:'texto',
				grid_visible:true,
				grid_editable:false,
				width_grid:95,
				align:'right',
				width:'40%',
				disable:false
			},
			tipo: 'NumberField',
			form: true,
			save_as:'ua_transf'
			
		};
		*/
	//----------- FUNCIONES RENDER
	
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : ''
	};

	//---------- INICIAMOS LAYOUT DETALLE
	
	var config={
		titulo_maestro:'Cbte (Maestro)',
		titulo_detalle:'Partidas(Detalle)',
		grid_maestro:'grid-'+idContenedor
	};
	layout_siet_cbte_partida = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_siet_cbte_partida.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_siet_cbte_partida,idContenedor);
	var getSelectionModel=this.getSelectionModel;
	var ClaseMadre_getComponente=this.getComponente;
	var ClaseMadre_conexionFailure=this.conexionFailure;
	var ClaseMadre_btnNew=this.btnNew;
	var ClaseMadre_onResize=this.onResize;
	var ClaseMadre_SaveAndOther=this.SaveAndOther;
	var ClaseMadre_btnEdit=this.btnEdit; 
	var CM_ocultarGrupo=this.ocultarGrupo;
	var CM_mostrarGrupo=this.mostrarGrupo;

	//-------- DEFINICIÓN DE LA BARRA DE MENÚ
	

	var paramMenu={
		guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	
	//--------- DEFINICIÓN DE FUNCIONES
	//datos necesarios para el filtro
	var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/interfaz_siet/ActionEliminarSietCbtePartida.php',parametros:'&id_siet_cbte='+maestro.id_siet_cbte},
			Save:{url:direccion+'../../../control/interfaz_siet/ActionGuardarSietCbtePartida.php',parametros:'&id_siet_cbte='+maestro.id_siet_cbte},
			ConfirmSave:{url:direccion+'../../../control/interfaz_siet/ActionGuardarSietCbtePartida.php',parametros:'&id_siet_cbte'+maestro.id_siet_cbte},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Detalle de Partidas',
		
			grupos:[{
				tituloGrupo:'Datos',
				columna:0,
				id_grupo:0
			}]
		}
	};
	
	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		maestro.id_siet_cbte=datos.m_id_siet_cbte;
		maestro.id_siet_declara=datos.m_id_siet_declara;
		maestro.tipo_declara=datos.m_tipo_declara;
	
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_siet_cbte:maestro.id_siet_cbte,
				m_id_siet_declara:maestro.id_siet_declara,
				m_tipo_declara:maestro.tipo_declara
			}
		});
		
		gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['Cbte',maestro.id_siet_cbte]]);
		vectorAtributos[1].defecto=maestro.id_siet_cbte;
		var paramFunciones={
				btnEliminar:{url:direccion+'../../../control/interfaz_siet/ActionEliminarSietCbtePartida.php',parametros:'&id_siet_cbte='+maestro.id_siet_cbte},
				Save:{url:direccion+'../../../control/interfaz_siet/ActionGuardarSietCbtePartida.php',parametros:'&id_siet_cbte='+maestro.id_siet_cbte},
				ConfirmSave:{url:direccion+'../../../control/interfaz_siet/ActionGuardarSietCbtePartida.php',parametros:'&id_siet_cbte'+maestro.id_siet_cbte},
				Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Detalle de Partidas',
				
				grupos:[{
							tituloGrupo:'Datos',
							columna:0,
							id_grupo:1
						}]
				
				}};
		this.InitFunciones(paramFunciones)
	};
	
	//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//

	
	
		
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		
	//para iniciar eventos en el formulario
	for(i=0;i<vectorAtributos.length;i++)
		{
			
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name);
			
		}
		sm=getSelectionModel();
		comp_id_partida = ClaseMadre_getComponente('id_partida');
		comp_id_oec = ClaseMadre_getComponente('id_oec');
		//comp_id_siet_ent_ua_transf = ClaseMadre_getComponente('id_siet_ent_ua_transf');
		
		comp_id_partida.on('select',f_evento_partida);	
		comp_id_oec.on('select',f_evento_oec);	
			
   	}

	function f_evento_partida(combo, record, index){
		componentes[3].store.baseParams={m_id_partida:componentes[2].getValue(),m_incluir_dobles:'no'};
		componentes[3].modificado=true;
		componentes[3].setValue('');
	}
	
	function f_evento_oec(combo, record, index){
		componentes[5].store.baseParams={m_id_partida:componentes[2].getValue(),m_id_oec:componentes[3].getValue()};
		componentes[5].modificado=true;
		componentes[5].setValue('');
	}

	

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_siet_cbte_partida.getLayout();
	};



	//para el manejo de hijos
	this.getPagina=function(idContenedorHijo){
		var tam_elementos=elementos.length;
		for(i=0;i<tam_elementos;i++){
			if(elementos[i].idContenedor==idContenedorHijo){
				return elementos[i];
			}
		}
	};
	
	this.getElementos=function(){return elementos;};
	this.setPagina=function(elemento){elementos.push(elemento);};
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_siet_cbte_partida.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}