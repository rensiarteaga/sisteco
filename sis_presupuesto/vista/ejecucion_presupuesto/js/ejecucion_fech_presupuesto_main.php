<?php
/**
 * Nombre:		  	    detalle_partida_formulacion_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-07-18 11:04:06
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
	    echo "var idSub='$idSub';";
	?>

	var fa=false;
	
	<?php if($_SESSION["ss_filtro_avanzado"]!=''){echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';}?>	
	
	var paramConfig={TamanoPagina:1000,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa,idSub:decodeURI(idSub)};
	
	var maestro={
				tipo_pres:'<?php echo utf8_decode($_GET['tipo_pres']);?>',
		     	id_parametro:'<?php echo utf8_decode($_GET['id_parametro']);?>',
		     	id_moneda:'<?php echo utf8_decode($_GET['id_moneda']);?>',
		     	desc_moneda:'<?php echo utf8_decode($_GET['desc_moneda']);?>',
		     	gestion_pres:'<?php echo utf8_decode($_GET['gestion_pres']);?>',
		     	desc_pres:'<?php echo utf8_decode($_GET['desc_pres']);?>',
		     	sw_vista:'<?php echo utf8_decode($_GET['sw_vista']);?>',
		     	desc_estado_gral:'<?php echo utf8_decode($_GET['desc_estado_gral']);?>',
		     	fecha_fin:'<?php echo utf8_decode($_GET['fecha_fin']);?>',
		     	fecha_ini:'<?php echo utf8_decode($_GET['fecha_ini']);?>'
	};
	
	idContenedorPadre='<?php echo utf8_decode($idContenedorPadre);?>';
	
	var elemento={idContenedor:idContenedor,pagina:new paginaEjecucionPresupuesto(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
	_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
* Nombre:		  	    pagina_detalle_partida_formulacion.js
* Propósito: 			pagina objeto principal
* Autor:				Generado Automaticamente
* Fecha creación:		2008-07-18 11:04:06
*/
function paginaEjecucionPresupuesto(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
	var	g_limit='';
	var	g_CantFiltros='';
	var	g_tipo_pres=maestro.tipo_pres;
	var	g_id_parametro=maestro.id_parametro;
	var	g_id_moneda=maestro.id_moneda;
	//var	g_ids_fuente_financiamiento='';
	var	g_ids_u_o='';
	var	g_ids_financiador='';
	var	g_ids_regional='';
	var	g_ids_programa='';
	var	g_ids_proyecto='';
	var	g_ids_actividad='';
	var	g_sw_vista=maestro.sw_vista;
	//var	g_ids_concepto_colectivo='';
	var g_regional='';
	var g_financiador='';
	var g_programa='';
	var g_proyecto='';
	var g_actividad='';
	var g_unidad_organizacional='';
	//var g_Fuente_financiamiento='';
	//var g_colectivo='';
	var g_desc_moneda=maestro.desc_moneda;
	var g_desc_pres=maestro.desc_pres;
	var g_desc_estado_gral=maestro.desc_estado_gral;
	var g_gestion_pres=maestro.gestion_pres;
	var g_fecha_fin=maestro.fecha_fin;
	var g_fecha_ini=maestro.fecha_ini;

	var v_regional='';
	var v_financiador='';
	var v_programa='';
	var v_proyecto='';
	var v_actividad='';
	var v_desc_unidad_organizacional='';

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

		var marcas_html,div_dlgFrm,dlgFrm;
		var marcas_html_ejecucion,div_dlgFrm_ejecucion,dlgFrmEjecucion;
		var Presupuesto,Moneda,tipoReporte;
		var id_presupuesto_rep,id_moneda_rep,tipoRep;

		var ds = new Ext.data.Store({
			// asigna url de donde se cargaran los datos
			proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/ejecucion/ActionListarEjecucionFech.php'}),
			// aqui se define la estructura del XML
			reader: new Ext.data.XmlReader({
				record: 'ROWS',
				id: 'id_partida_presupuesto',
				totalRecords: 'TotalCount'
			}, [
			// define el mapeo de XML a las etiquetas (campos)
			'id_partida',
			'desc_partida',
			'nombre_partida',
			'codigo_partida',
			'sw_transaccional',
			'traspaso',
			'reformulacion',
			'comprometido',
			'devengado',
			'pagado',
			]),remoteSort:true});

			//carga datos XML
			/*crea los data store*/
			//var ds_fuente_financiamiento = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/fuente_financiamiento/ActionListarFuenteFinanciamiento.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_fuente_financiamiento',totalRecords:'TotalCount'},['id_fuente_financiamiento','codigo_fuente','denominacion','descripcion','sigla']),remoteSort:true});
			var ds_unidad_organizacional= new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/usuario_autorizado/ActionListarAutorizacionPresupuesto.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_usuario_autorizado',totalRecords: 'TotalCount'},['id_usuario_autorizado','id_usuario','desc_usuario','id_unidad_organizacional','desc_unidad_organizacional']),remoteSort:true});
			var	ds_financiador=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/financiador/ActionListaFinanciadorEP.php'}),reader: new Ext.data.XmlReader({record:'ROWS',id: 'id_financiador',totalRecords: 'TotalCount'}, ['id_financiador','nombre_financiador','codigo_financiador']),remoteSort:true});
			var	ds_regional=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/regional/ActionListaRegionalEP.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_regional',totalRecords: 'TotalCount'}, ['id_regional','nombre_regional','codigo_regional']),remoteSort:true});
			var	ds_programa=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/programa/ActionListaProgramaEP.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_programa',totalRecords: 'TotalCount'}, ['id_programa','nombre_programa','codigo_programa']),remoteSort:true});
			var	ds_proyecto=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/proyecto/ActionListaProyectoEP.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_proyecto',totalRecords: 'TotalCount'}, ['id_proyecto','nombre_proyecto','codigo_proyecto']),remoteSort:true});
			var	ds_actividad=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/actividad/ActionListaActividadEP.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_actividad',totalRecords: 'TotalCount'}, ['id_actividad','nombre_actividad','codigo_actividad']),remoteSort:true});
			//var ds_colectivo = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/concepto_colectivo/ActionListarPresupuestoColectivo.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_concepto_colectivo',totalRecords:'TotalCount'},['id_concepto_colectivo','estado_colectivo','id_usuario','apellido_paterno_persona','apellido_materno_persona','nombre_persona','desc_usuario','desc_colectivo']),remoteSort:true});

			//config_fuente_financiamiento={id_menu:idContenedor+"-id_fuente_financiamiento" ,nombre:'Fuente de Financiamiento',descripcion:'denominacion',id:'id_fuente_financiamiento',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};
			config_unidad_organizacional={id_menu:idContenedor+"-id_unidad_organizacional",nombre:'Unidad Organizacional',descripcion:'desc_unidad_organizacional',id:'id_unidad_organizacional',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};
			config_financiador={id_menu:idContenedor+"-id_financiador", nombre:'Financiador',descripcion:'nombre_financiador',id:'id_financiador',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};
			config_regional={id_menu:idContenedor+"-id_regional",nombre:'Regional',descripcion:'nombre_regional',id:'id_regional',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};
			config_programa={id_menu:idContenedor+"-id_programa",nombre:'Programa',descripcion:'nombre_programa',id:'id_programa',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};
			config_proyecto={id_menu:idContenedor+"-id_proyecto",nombre:'SubPrograma',descripcion:'nombre_proyecto',id:'id_proyecto',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};
			config_actividad={id_menu:idContenedor+"-id_actividad",nombre:'Actividad',descripcion:'nombre_actividad',id:'id_actividad',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};
			//config_colectivo={id_menu:idContenedor+"-id_concepto_colectivo",nombre:'Concepto Colectivo',descripcion:'desc_colectivo',id:'id_concepto_colectivo',selectAceptar:true,selectTodo:true,selectLimpiar:false,funcion:menuBotones};

			function menuBotones()
			{
				g_limit= paramConfig.TamanoPagina;
				g_CantFiltros=paramConfig.CantFiltros;
				g_tipo_pres=maestro.tipo_pres;
				g_id_parametro=maestro.id_parametro;
				g_id_moneda=maestro.id_moneda;
				//g_ids_fuente_financiamiento=padre.getBotonMenuBotonNombre('Fuente de Financiamiento').menuBoton.getSelecion();
				g_ids_u_o=padre.getBotonMenuBotonNombre('Unidad Organizacional').menuBoton.getSelecion();
				g_ids_financiador=padre.getBotonMenuBotonNombre('Financiador').menuBoton.getSelecion();
				g_ids_regional=padre.getBotonMenuBotonNombre('Regional').menuBoton.getSelecion();
				g_ids_programa=padre.getBotonMenuBotonNombre('Programa').menuBoton.getSelecion();
				g_ids_proyecto=padre.getBotonMenuBotonNombre('SubPrograma').menuBoton.getSelecion();
				g_ids_actividad=padre.getBotonMenuBotonNombre('Actividad').menuBoton.getSelecion();
				g_sw_vista=maestro.sw_vista;
				g_fecha_fin=maestro.fecha_fin;
				//g_ids_concepto_colectivo=padre.getBotonMenuBotonNombre('Concepto Colectivo').menuBoton.getSelecion();
				g_regional=padre.getBotonMenuBotonNombre('Regional').menuBoton.getSeleccionadosDesc();
				g_financiador=padre.getBotonMenuBotonNombre('Financiador').menuBoton.getSeleccionadosDesc();
				g_programa=padre.getBotonMenuBotonNombre('Programa').menuBoton.getSeleccionadosDesc();
				g_proyecto=padre.getBotonMenuBotonNombre('SubPrograma').menuBoton.getSeleccionadosDesc();
				g_actividad=padre.getBotonMenuBotonNombre('Actividad').menuBoton.getSeleccionadosDesc();
				g_unidad_organizacional=padre.getBotonMenuBotonNombre('Unidad Organizacional').menuBoton.getSeleccionadosDesc();
				//g_Fuente_financiamiento=padre.getBotonMenuBotonNombre('Fuente de Financiamiento').menuBoton.getSeleccionadosDesc();
				//g_colectivo=padre.getBotonMenuBotonNombre('Concepto Colectivo').menuBoton.getSeleccionadosDesc();


				ds.baseParams={start:0,
				limit: g_limit,
				CantFiltros:g_CantFiltros,
				tipo_pres:g_tipo_pres,
				id_parametro:g_id_parametro,
				id_moneda:g_id_moneda,
				//ids_fuente_financiamiento:g_ids_fuente_financiamiento,
				ids_u_o:g_ids_u_o,
				ids_financiador:g_ids_financiador,
				ids_regional:g_ids_regional,
				ids_programa:g_ids_programa,
				ids_proyecto:g_ids_proyecto,
				ids_actividad:g_ids_actividad,
				sw_vista:g_sw_vista,
				fecha_fin:g_fecha_fin,
				fecha_ini:g_fecha_ini,
				//ids_concepto_colectivo:g_ids_concepto_colectivo
				};

				var epe=" ";
				if(g_regional){epe=epe+"<texto_em> REGIONAL: </texto_em>"+g_regional};
				if(g_financiador){epe=epe+"<texto_em>  FINANCIADOR:</texto_em>"+g_financiador};
				if(g_programa){epe=epe+"<texto_em>  PROGRAMA:</texto_em>"+g_programa};
				if(g_proyecto){epe=epe+"<texto_em>  SUBPROGRAMA:</texto_em>"+g_proyecto};
				if(g_actividad){epe=epe+"<texto_em>  ACTIVIDAD:</texto_em>"+g_actividad};
				if(epe==" "){epe="Todos"}
				if(g_unidad_organizacional==""){g_unidad_organizacional="Todos"}
				//if(g_Fuente_financiamiento==""){g_Fuente_financiamiento="Todos"}
				//if(g_colectivo==""){g_colectivo="Todos"}

				//maestro.desc_pres
				var data_maestro=[['Presupuesto de ',maestro.desc_pres+tabular(44-maestro.desc_pres.length),'Moneda',maestro.desc_moneda+tabular(20-maestro.desc_moneda.length),'Gestión',maestro.gestion_pres+" "+maestro.desc_estado_gral+tabular(20-maestro.gestion_pres.length-maestro.desc_estado_gral.length),'Del ',maestro.fecha_ini+tabular(20-maestro.fecha_ini.length),'Al ',maestro.fecha_fin+tabular(20-maestro.fecha_fin.length)],
				['Estructura Programatica',epe] ,
				['Estructura Organizacional',g_unidad_organizacional ]];
				//['Fuente de Financiamiento',g_Fuente_financiamiento],
				//['Concepto Colectivo',g_colectivo]];

				Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));
			}

			function MaestroJulio(data){
				var mayor=0;
				var j;
				var  html="<table class='izquierda'>";
				for(j=0;j<data.length;j++){if(mayor<=data[j].length){mayor=data[j].length }};
				html=html+"</tr>";

				for(j=0;j<data.length;j++){
					if(j%2==0){	html=html+"<tr class='gris'>";}
					else{html=html+" <tr class='blanco'>";}
					for(i=0;i<data[j].length;i++){
						if(data[j])
						{
							if(i%2!=0){html=html+"<td class='izquierda'  >  <pre><font face='Arial'> "+data[j][i]+"</font></pre> </td> ";}
							else{html=html+"<td class='atributo'  > <pre><font face='Arial'> "+data[j][i]+":</font></pre></td>";}
						}
					}
					html=html+"</tr>";
				}
				html=html+"</table>";
				return html
			};

			function tabular(n)
			{ 	if (n>=0)	{return "  "+tabular(n-1)}
			else return "  "
			}

			function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
			function italic(value){return '<i>'+value+'</i>';}
			var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
			Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');

			var data_maestro=[['Presupuesto de ',maestro.desc_pres+tabular(44-maestro.desc_pres.length),'Moneda',maestro.desc_moneda+tabular(20-maestro.desc_moneda.length),'Gestión',maestro.gestion_pres+" "+maestro.desc_estado_gral+tabular(20-maestro.gestion_pres.length-maestro.desc_estado_gral.length),'Del ',maestro.fecha_ini+tabular(20-maestro.fecha_ini.length),'Al ',maestro.fecha_fin+tabular(20-maestro.fecha_fin.length)],
			['Estructura Programatica','Todos'] ,
			['Estructura Organizacional','Todos' ] ,
			['Fuente de Financiamiento','Todos']
			//['Concepto Colectivo','Todos']
			];

			var ds_partida = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/partida/ActionListarPartida.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_partida',totalRecords: 'TotalCount'},['id_partida','codigo_partida','nombre_partida','desc_partida','nivel_partida','sw_transaccional','tipo_partida','id_parametro','id_partida_padre','tipo_memoria','sw_movimiento'])
			});

			var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/presupuesto/ActionListarPresupuesto.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'}
			,['id_presupuesto','tipo_pres','estado_pres','id_fina_regi_prog_proy_acti','desc_fina_regi_prog_proy_acti','id_unidad_organizacional','desc_unidad_organizacional',
			'id_fuente_financiamiento','denominacion','id_parametro','desc_parametro','id_financiador','id_regional','id_programa','id_proyecto','id_actividad',
			'nombre_financiador','nombre_regional','nombre_programa','nombre_proyecto','nombre_actividad',
			'codigo_financiador','codigo_regional','codigo_programa','codigo_proyecto','codigo_actividad','id_concepto_colectivo','desc_colectivo']),
			baseParams:{sw_traspaso:'si',m_id_parametro:maestro.id_parametro,m_tipo_pres:maestro.tipo_pres}	//,m_id_unidad_organizacional:4
			});

			var ds_partida_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/partida_presupuesto/ActionListarPartidaPresupuesto.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_partida_presupuesto',totalRecords: 'TotalCount'},['id_partida_presupuesto','codigo_formulario','fecha_elaboracion','id_partida','id_presupuesto'])
			});

			var ds_moneda = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad'])
			});

			//FUNCIONES RENDER
			function render_id_partida(value,cell,record,row,colum,store)
			{		if(store.getAt(row).data['sw_transaccional'] == 1){
				return  '<span style="color:green;"><pre><font face="Arial">'+record.data['nombre_partida']+'</font></pre></span>'
			}
			if(store.getAt(row).data['sw_transaccional'] == 2){return String.format('{0}','<pre><font face="Arial">'+record.data['nombre_partida']+'</font></pre>')}
			};

			var tpl_id_partida=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{nombre_partida}</FONT><br>','</div>');

			function render_id_presupuesto(value, p, record){return String.format('{0}', record.data['desc_presupuesto']);}
			var tpl_id_presupuesto=new Ext.Template('<div class="search-item">','<b><i>{desc_unidad_organizacional}</i></b>','<br><FONT COLOR="#B5A642"><b>Financiador: </b>{nombre_financiador}</FONT>',
			'<br><FONT COLOR="#B5A642"><b>Regional: </b>{nombre_regional}</FONT>',
			'<br><FONT COLOR="#B5A642"><b>Programa: </b>{nombre_programa}</FONT>',
			'<br><FONT COLOR="#B5A642"><b>Sub Programa: </b>{nombre_proyecto}</FONT>',
			'<br><FONT COLOR="#B5A642"><b>Actividad: </b>{nombre_actividad}</FONT>',
			'<br><FONT COLOR="#B5A642"><b>Fuente de Financiamiento: </b>{denominacion}</FONT>','</div>');


			function render_id_partida_presupuesto(value, p, record){return String.format('{0}', record.data['desc_partida_presupuesto']);}
			var tpl_id_partida_presupuesto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{}</FONT><br>','</div>');

			function render_id_moneda(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
			var tpl_id_moneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');

			function renderTipoMemoria(value, p, record){
				if(value == 1){return "Recursos"}
				if(value == 2){return "Gastos x Item"}
				if(value == 3){return "Inversión"}
				if(value == 4){return "Pasajes"}
				if(value == 5){return "Viajes"}
				if(value == 6){return "RRHH"}
				if(value == 7){return "Servicios"}
				if(value == 8){return "Otros Gastos"}
				if(value == 9){return "Combustibles"}
			}

			function renderSwTranssacional(value,cell,record,row,colum,store)
			{
				if(store.getAt(row).data['sw_transaccional'] == 1)
				{
					return  '<span style="color:green;">' +monedas_for.formatMoneda(value)+'</span>'
				}
				if(store.getAt(row).data['sw_transaccional'] == 2)
				{
					return monedas_for.formatMoneda(value)
				}
			}
			function renderSwTranssacionalText(value,cell,record,row,colum,store)
			{
				if(store.getAt(row).data['sw_transaccional'] == 1)
				{
					return  '<span style="color:green;">' +value+'</span>'
				}
				if(store.getAt(row).data['sw_transaccional'] == 2)
				{
					return (value)
				}
			}

			/////////////////////////
			// Definición de datos //
			/////////////////////////
			Atributos[0]={
				validacion:{
					labelSeparator:'',
					name: 'id_partida_presupuesto',
					inputType:'hidden',
					grid_visible:false,
					grid_editable:false
				},
				tipo: 'Field',
				filtro_0:false,
				save_as:'id_partida_presupuesto'
			} ;

			Atributos[1]={
				validacion:{
					name:'codigo_partida',
					fieldLabel:'Partida',
					allowBlank:true,
					maxLength:50,
					minLength:0,
					selectOnFocus:true,
					vtype:'texto',
					grid_visible:true,
					grid_editable:false,
					width_grid:60,
					width:'50%',
					renderer: renderSwTranssacionalText,
					grid_indice:1,
					disable:false
				},
				tipo: 'TextField',
				form: true,
				filtro_0:true,
				filterColValue:'codigo_partida',
				save_as:'codigo_partida'
			};

			// txt id_partida
			Atributos[2]={
				validacion:{
					name:'id_partida',
					fieldLabel:'Descripción',
					allowBlank:false,
					emptyText:'Partida...',
					store:ds_partida,
					valueField: 'id_partida',
					displayField: 'nombre_partida',
					queryParam: 'filterValue_0',
					filterCol:'PARTID.nombre_partida',
					typeAhead:true,
					tpl:tpl_id_partida,
					forceSelection:true,
					mode:'remote',
					queryDelay:250,
					pageSize:100,
					minListWidth:'100%',
					grow:true,
					resizable:true,
					queryParam:'filterValue_0',
					minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
					triggerAction:'all',
					editable:true,
					renderer:render_id_partida,
					grid_visible:true,
					grid_editable:false,
					width_grid:400,
					width:'100%',
					disabled:false
				},
				tipo:'ComboBox',
				form: true,
				filtro_0:true,
				filterColValue:'nombre_partida',
				save_as:'id_partida'
			};

			// txt id_presupuesto
			Atributos[3]={
				validacion:{
					name:'id_presupuesto',
					labelSeparator:'',
					inputType:'hidden',
					grid_visible:false,
					grid_editable:false,
					disabled:true
				},
				tipo:'Field',
				filtro_0:false,
				defecto:maestro.id_presupuesto,
				save_as:'id_presupuesto'
			};

			Atributos[4] = {
				validacion: {
					name:'sw_transaccional',
					fieldLabel:'Sw Transaccional',
					vtype:'texto',
					allowBlank: false,
					typeAhead: true,
					loadMask: true,
					triggerAction: 'all',
					store: new Ext.data.SimpleStore({
						fields: ['ID', 'valor'],
						data :[['1','Movimiento'],['2','Titular']]
					}),
					valueField:'ID',
					displayField:'valor',
					forceSelection:true,
					grid_visible:false, // se muestra en el grid
					grid_editable:false, //es editable en el grid,
					width_grid:100, // ancho de columna en el gris
					width:150,
					disabled:true
				},
				tipo:'ComboBox',
				defecto:'1',
				form: false,
				filtro_0:false,
				filterColValue:'PRESUP.estado_pres',
				save_as:'estado_pres'
			};

			Atributos[5]={
				validacion:{
					name:'traspaso',
					fieldLabel:'Traspaso',
					allowBlank:false,
					align:'right',
					maxLength:50,
					minLength:0,
					selectOnFocus:true,
					allowDecimals:true,
					decimalPrecision:2,//para numeros float
					allowNegative:false,
					minValue:0,
					grid_visible:true,
					grid_editable:false,
					renderer: renderSwTranssacional,
					width_grid:120,
					width:'100%',
					disabled:false
				},
				tipo: 'MonedaField',
				form: true,
				filtro_0:false,
				filterColValue:'PARDET.traspaso',
				save_as:'total'
			};

			Atributos[6]={
				validacion:{
					name:'reformulacion',
					fieldLabel:'Reformulación',
					allowBlank:false,
					align:'right',
					maxLength:50,
					minLength:0,
					selectOnFocus:true,
					allowDecimals:true,
					decimalPrecision:2,//para numeros float
					allowNegative:false,
					minValue:0,
					grid_visible:true,
					grid_editable:false,
					renderer: renderSwTranssacional,
					width_grid:120,
					width:'100%',
					disabled:false
				},
				tipo: 'MonedaField',
				form: true,
				filtro_0:false,
				filterColValue:'PARDET.reformulacion',
				save_as:'total'
			};

			Atributos[7]={
				validacion:{
					name:'comprometido',
					fieldLabel:'Comprometido',
					allowBlank:false,
					align:'right',
					maxLength:50,
					minLength:0,
					selectOnFocus:true,
					allowDecimals:true,
					decimalPrecision:2,//para numeros float
					allowNegative:false,
					minValue:0,
					grid_visible:true,
					grid_editable:false,
					renderer: renderSwTranssacional,
					width_grid:150,
					width:'100%',
					disabled:false
				},
				tipo: 'MonedaField',
				form: true,
				filtro_0:false,
				filterColValue:'PARDET.comprometido',
				save_as:'total'
			};
			if(maestro.tipo_pres==1){Atributos[7].validacion.grid_visible=false}

			Atributos[8]={
				validacion:{
					name:'devengado',
					fieldLabel:'Devengado',
					allowBlank:false,
					align:'right',
					maxLength:50,
					minLength:0,
					selectOnFocus:true,
					allowDecimals:true,
					decimalPrecision:2,//para numeros float
					allowNegative:false,
					minValue:0,
					grid_visible:true,
					grid_editable:false,
					renderer: renderSwTranssacional,
					width_grid:150,
					width:'100%',
					disabled:false
				},
				tipo: 'MonedaField',
				form: true,
				filtro_0:false,
				filterColValue:'PARDET.devengado',
				save_as:'devengado'
			};

			Atributos[9]={
				validacion:{
					name:'pagado',
					fieldLabel:'Pagado',
					allowBlank:false,
					align:'right',
					maxLength:50,
					minLength:0,
					selectOnFocus:true,
					allowDecimals:true,
					decimalPrecision:2,//para numeros float
					allowNegative:false,
					minValue:0,
					grid_visible:true,
					grid_editable:false,
					renderer: renderSwTranssacional,
					width_grid:150,
					width:'100%',
					disabled:false
				},
				tipo: 'MonedaField',
				form: true,
				filtro_0:false,
				filterColValue:'PARDET.pagado',
				save_as:'pagado'
			};
			if(maestro.tipo_pres==1){Atributos[9].validacion.fieldLabel='Ingresado'}

			//----------- FUNCIONES RENDER
			function formatDate(value){return value?value.dateFormat('d/m/Y'):''};
			function formatDateBase(value){return value?value.dateFormat('m/d/Y'):''};

			//---------- INICIAMOS LAYOUT DETALLE
			var config={titulo_maestro:'Parametros (Maestro)',titulo_detalle:'Ejecución Presupuesto (Detalle)',grid_maestro:'grid-'+idContenedor};
			var layout_consolidacionPresupuesto = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
			layout_consolidacionPresupuesto.init(config);

			//---------- INICIAMOS HERENCIA
			this.pagina = Pagina;
			this.pagina(paramConfig,Atributos,ds,layout_consolidacionPresupuesto,idContenedor);
			var getComponente=this.getComponente;
			var getSelectionModel=this.getSelectionModel;
			var EstehtmlMaestro=this.htmlMaestro;
			var CM_btnActualizar=this.btnActualizar;


			//DEFINICIÓN DE LA BARRA DE MENÚ
			var paramMenu={
				/*guardar:{crear:true,separador:false},
				nuevo:{crear:true,separador:true},
				editar:{crear:true,separador:false},
				eliminar:{crear:true,separador:false},*/
				actualizar:{crear:true,separador:false},
				excel:{crear:true,separador:false}
			};

			//DEFINICIÓN DE FUNCIONES
			Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));

			var paramFunciones={
				btnEliminar:{url:direccion+'../../../control/partida_presupuesto/ActionEliminarDetallePartidaFormulacion.php',parametros:'&m_id_presupuesto='+maestro.id_presupuesto},
				Save:{url:direccion+'../../../control/partida_presupuesto/ActionGuardarDetallePartidaFormulacion.php',parametros:'&m_id_presupuesto='+maestro.id_presupuesto},
				ConfirmSave:{url:direccion+'../../../control/partida_presupuesto/ActionGuardarDetallePartidaFormulacion.php',parametros:'&m_id_presupuesto='+maestro.id_presupuesto},
				Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Detalle Partida Formulación'}};

				//-------------- Sobrecarga de funciones --------------------//

				function btn_imprimir(){
					/*parametros reporte */
					var data='start=0';
					data+='&limit=1000';
					data+='&CantFiltros='+g_CantFiltros;
					data+='&tipo_pres='+g_tipo_pres;
					data+='&id_parametro='+g_id_parametro;
					data+='&id_moneda='+g_id_moneda;
					//data+='&ids_fuente_financiamiento='+g_ids_fuente_financiamiento;
					data+='&ids_u_o='+g_ids_u_o;
					data+='&ids_financiador='+g_ids_financiador;
					data+='&ids_regional='+g_ids_regional;
					data+='&ids_programa='+g_ids_programa;
					data+='&ids_proyecto='+g_ids_proyecto;
					data+='&ids_actividad='+g_ids_actividad;
					data+='&sw_vista='+g_sw_vista;
					//data+='&ids_concepto_colectivo='+g_ids_concepto_colectivo;
					
					//data+='&fecha_fin='+g_fecha_fin;
					//data+='&fecha_ini='+g_fecha_ini;
					
					data+='&fecha_fin='+maestro.fecha_fin;
					data+='&fecha_ini='+maestro.fecha_ini;

					if(g_unidad_organizacional==""){g_unidad_organizacional="Todos"}
					//if(g_Fuente_financiamiento==""){g_Fuente_financiamiento="Todos"}
					//if(g_colectivo==""){g_colectivo="Todos"}

					data+='&regional='+g_regional;
					data+='&financiador='+g_financiador;
					data+='&programa='+g_programa;
					data+='&proyecto='+g_proyecto;
					data+='&actividad='+g_actividad;
					data+='&unidad_organizacional='+g_unidad_organizacional;
					//data+='&Fuente_financiamiento='+g_Fuente_financiamiento;
					//data+='&colectivo='+g_colectivo;
					data+='&desc_moneda='+g_desc_moneda;
					data+='&desc_pres='+g_desc_pres;
					data+='&desc_estado_gral='+g_desc_estado_gral;
					data+='&gestion_pres='+g_gestion_pres;
					window.open(direccion+'../../../control/ejecucion/ActionReporteEjecucionFech.php?'+data);
				}

				function crearDialogMoneda()
				{
					marcas_html="<div class='x-dlg-hd'>"+'Parametros de Reporte'+"</div><div class='x-dlg-bd'><div id='form-ct2_"+idContenedor+"'></div></div>";
					div_dlgFrm=Ext.DomHelper.append(document.body,{tag:'div',id:'dlgFrm'+idContenedor,html:marcas_html});
					var Formulario=new Ext.form.Form({
						id:'frm_'+idContenedor,
						name:'frm_'+idContenedor,
						labelWidth:100
					});
					dlgFrm=new Ext.BasicDialog(div_dlgFrm,{
						modal:true,
						labelWidth:50,
						width:400,
						height:200,
						minWidth:paramFunciones.Formulario.minWidth,
						minHeight:paramFunciones.Formulario.minHeight,
						closable:paramFunciones.Formulario.closable
					});
					dlgFrm.addKeyListener(27,paramFunciones.Formulario.cancelar);

					//dlgFrm.addButton('Generar',btn_imprimir_memoria_calculo);
					//dlgFrm.addButton('Cancelar',ocultarFrm);

					Presupuesto=new Ext.form.ComboBox({
						name:'id_presupuesto',
						fieldLabel:'Presupuesto',
						allowBlank:false,
						emptyText:'Presupuesto...',
						store:ds_presupuesto,
						filterCol:'UNIORG.nombre_unidad',
						queryParam:'filterValue_0',
						valueField:'id_presupuesto',
						onSelect: function(record){v_financiador=record.data.nombre_financiador;
						v_regional=record.data.nombre_regional;
						v_programa=record.data.nombre_programa;
						v_proyecto=record.data.nombre_proyecto;
						v_actividad=record.data.nombre_actividad;
						v_desc_unidad_organizacional=record.data.desc_unidad_organizacional;
						Presupuesto.setValue(record.data.id_presupuesto);
						Presupuesto.collapse();},
						typeAhead:true,
						forceSelection:false,
						tpl:tpl_id_presupuesto,
						displayField:'desc_unidad_organizacional',
						triggerAction:'all',
						pageSize:100,
						minChars:3,
						mode:'remote',
						width:220
					});

					Moneda=new Ext.form.ComboBox({
						name:'id_moneda_reporte',
						fieldLabel:'Moneda',
						allowBlank:false,
						emptyText:'Moneda...',
						store:ds_moneda,
						filterCol:'MONEDA.nombre',
						queryParam:'filterValue_0',
						valueField:'id_moneda',
						typeAhead:true,
						forceSelection:false,
						tpl:tpl_id_moneda,
						displayField:'nombre',
						triggerAction:'all',
						minChars:1,
						mode:'remote',
						width:220
					});

					tipoReporte=new Ext.form.ComboBox({
						name:'tipo_reporte',
						fieldLabel:'Tipo Reporte',
						vtype:'texto',
						emptyText:'Tipo Reporte...',
						allowBlank:false,
						loadMask:true,
						triggerAction:'all',
						store:new Ext.data.SimpleStore({fields:['valor'],data:[['General'],['Periodo']]}),
						valueField:'valor',
						displayField:'valor',
						width:180
					});
					Formulario.fieldset({legend:'Parametros de Reporte'},Presupuesto,Moneda,tipoReporte);
					Formulario.render("form-ct2_"+idContenedor)
				}

				function ocultarFrm(){dlgFrm.hide()}

				function crearDialogEjecucion()
				{
					marcas_html_ejecucion="<div class='x-dlg-hd'>"+'Parametros de Reporte'+"</div><div class='x-dlg-bd'><div id='form-ct2_"+idContenedor+"'></div></div>";
					div_dlgFrm_ejecucion=Ext.DomHelper.append(document.body,{tag:'div',id:'dlgFrmEjecucion'+idContenedor,html:marcas_html});
					var FormularioEjec=new Ext.form.Form({
						id:'frm_'+idContenedor,
						name:'frm_'+idContenedor,
						labelWidth:150	//para aumentar el espacion del texto
					});
					dlgFrmEjecucion=new Ext.BasicDialog(div_dlgFrm_ejecucion,{
						modal:true,
						labelWidth:100,
						width:400,
						height:200,
						minWidth:paramFunciones.FormularioEjec.minWidth,
						minHeight:paramFunciones.FormularioEjec.minHeight,
						closable:paramFunciones.FormularioEjec.closable
					});
					dlgFrmEjecucion.addKeyListener(27,paramFunciones.FormularioEjec.cancelar);

					dlgFrmEjecucion.addButton('Generar',btn_imprimir_ejecucion);
					dlgFrmEjecucion.addButton('Cancelar',ocultarFrmEjecucion);

					Presupuesto=new Ext.form.ComboBox({
						name:'id_presupuesto',
						fieldLabel:'Presupuesto',
						allowBlank:false,
						emptyText:'Presupuesto...',
						store:ds_presupuesto,
						filterCol:'UNIORG.nombre_unidad',
						queryParam:'filterValue_0',
						valueField:'id_presupuesto',
						onSelect: function(record){v_financiador=record.data.nombre_financiador;
						v_regional=record.data.nombre_regional;
						v_programa=record.data.nombre_programa;
						v_proyecto=record.data.nombre_proyecto;
						v_actividad=record.data.nombre_actividad;
						v_desc_unidad_organizacional=record.data.desc_unidad_organizacional;
						Presupuesto.setValue(record.data.id_presupuesto);
						Presupuesto.collapse();},
						typeAhead:true,
						forceSelection:false,
						tpl:tpl_id_presupuesto,
						displayField:'desc_unidad_organizacional',
						triggerAction:'all',
						pageSize:100,
						minChars:3,
						mode:'remote',
						width:220
					});

					Moneda=new Ext.form.ComboBox({
						name:'id_moneda_reporte',
						fieldLabel:'Moneda',
						allowBlank:false,
						emptyText:'Moneda...',
						store:ds_moneda,
						filterCol:'MONEDA.nombre',
						queryParam:'filterValue_0',
						valueField:'id_moneda',
						typeAhead:true,
						forceSelection:false,
						tpl:tpl_id_moneda,
						displayField:'nombre',
						triggerAction:'all',
						minChars:1,
						mode:'remote',
						width:220
					});

					FormularioEjec.fieldset({legend:'Parametros de Reporte'},Presupuesto,Moneda/*,tipoReporte*/);
					FormularioEjec.render("form-ct2_"+idContenedor)
				}

				function ocultarFrmEjecucion(){dlgFrmEjecucion.hide()}

				function btnMemoria()
				{
					var sm=getSelectionModel();
					var filas=ds.getModifiedRecords();
					var cont=filas.length;
					var NumSelect=sm.getCount();
					var SelectionsRecord=sm.getSelected();
					var sw=false;

					if(NumSelect!=0)
					{
						if(SelectionsRecord.data.sw_transaccional==2){
							Ext.MessageBox.alert('...', 'La partida seleccionada no es una partida de movimiento.')
						}
						else{
							if(SelectionsRecord.data.total==0){
								Ext.MessageBox.alert('...', 'La partida seleccionada no tiene memorias de cálculo, el importe presupuestado es 0.')
							}
							else{
								dlgFrm.show()
							}
						}
					}
					else
					{
						Ext.MessageBox.alert('Estado','Antes debe seleccionar una partida de movimiento.')
					}
				}

				function btnEjecucion()
				{
					var sm=getSelectionModel();
					var filas=ds.getModifiedRecords();
					var cont=filas.length;
					var NumSelect=sm.getCount();
					var SelectionsRecord=sm.getSelected();
					var sw=false;

					if(NumSelect!=0)
					{
						if(SelectionsRecord.data.sw_transaccional==2){
							Ext.MessageBox.alert('...', 'La partida seleccionada no es una partida de movimiento.')
						}
						else{
							if(SelectionsRecord.data.total==0){
								Ext.MessageBox.alert('...', 'La partida seleccionada aun no fue ejecutada, el importe ejecutado es 0.')
							}
							else{
								//dlgFrmEjecucion.show()
							}
						}
					}
					else
					{
						Ext.MessageBox.alert('Estado','Antes debe seleccionar una partida de movimiento.')
					}
				}

				function btn_imprimir_ejecucion()
				{}

				//-------------- Sobrecarga de funciones --------------------//
				this.reload=function(params)
				{
					var datos=Ext.urlDecode(decodeURIComponent(params));					
					
				   	maestro.id_parametro=datos.m_id_parametro;
			       	maestro.fecha_inicio=datos.m_fecha_inicio;
			       	maestro.fecha_fin=datos.m_fecha_fin;
			       	maestro.id_moneda=datos.m_id_moneda;			       				       	
			       	
			       	maestro.desc_moneda=datos.m_desc_moneda;
					maestro.desc_pres=datos.m_desc_pres;
					maestro.desc_estado_gral=datos.m_desc_estado_gral;
					maestro.gestion_pres=datos.m_gestion_pres;
					maestro.fecha_fin=datos.m_fecha_fin;
					maestro.fecha_ini=datos.m_fecha_ini;
			       		       	       	       	     	
									   	
					ds.lastOptions={
						params:{
													
							start:0,
							limit: paramConfig.TamanoPagina,
							CantFiltros:paramConfig.CantFiltros,
							tipo_pres:maestro.tipo_pres,
							id_parametro:maestro.id_parametro,
							id_moneda:maestro.id_moneda,
							sw_vista:maestro.sw_vista,
							fecha_ini:maestro.fecha_ini,
							fecha_fin:maestro.fecha_fin
						}
					};
															
					menuBotones();										
					CM_btnActualizar()
				};
				
				//Para manejo de eventos
				function iniciarEventosFormularios(){
					//para iniciar eventos en el formulario
				}
				
				
				var sw =0;
				this.btnActualizar=function()
				{					
					//alert("ZZZZZZZZZZZ")
					if(sw==0)
					{
						ds.load({
							start:0,
							limit: paramConfig.TamanoPagina,
							CantFiltros:paramConfig.CantFiltros,
							tipo_pres:maestro.tipo_pres,
							id_parametro:maestro.id_parametro,
							id_moneda:maestro.id_moneda,
							desc_moneda:maestro.desc_moneda,							
							sw_vista:maestro.sw_vista,							
							fecha_fin: maestro.fecha_fin,
							fecha_ini: maestro.fecha_ini
						})						
						sw=1;
					}
					else
					{
						CM_btnActualizar();
					}
				}
				

				//para que los hijos puedan ajustarse al tamaño
				this.getLayout=function(){return layout_consolidacionPresupuesto.getLayout()};
				//para el manejo de hijos

				this.Init(); //iniciamos la clase madre
				this.InitBarraMenu(paramMenu);
				//alert(" creo la barra menu ");
				this.InitFunciones(paramFunciones);
				//para agregar botones
				padre=this;

				this.iniciaFormulario();
				iniciarEventosFormularios();

				/*ds_fuente_financiamiento.load({
				params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				},
				callback: function(){padre.AdicionarMenuBoton(ds_fuente_financiamiento,config_fuente_financiamiento);}
				});*/

				/*if(maestro.sw_vista=="unidad"){
				ds_unidad_organizacional.load({params:{start:0,limit: paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,filtroUsuario:'si'},
				callback: function(){padre.AdicionarMenuBoton(ds_unidad_organizacional,config_unidad_organizacional);}
				})}
				if(maestro.sw_vista=="general"){ */
				ds_unidad_organizacional.load({params:{start:0,limit: paramConfig.TamanoPagina,CantFiltros:paramConfig.CantFiltros,filtroUsuario:'no'},
				callback: function(){padre.AdicionarMenuBoton(ds_unidad_organizacional,config_unidad_organizacional);}
				})//}

				ds_financiador.load({
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros

					},
					callback: function(){padre.AdicionarMenuBoton(ds_financiador,config_financiador);
					}
				});
				ds_regional.load({
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros

					},
					callback: function(){padre.AdicionarMenuBoton(ds_regional,config_regional);}
				});
				ds_programa.load({
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros

					},
					callback: function(){padre.AdicionarMenuBoton(ds_programa,config_programa);}
				});
				ds_proyecto.load({
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros

					},
					callback: function(){padre.AdicionarMenuBoton(ds_proyecto,config_proyecto);}
				});
				ds_actividad.load({
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros

					},
					callback: function(){padre.AdicionarMenuBoton(ds_actividad,config_actividad);}
				});
				/*ds_colectivo.load({
				params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				estado_colectivo:1,
				sw_combo_consolidacion:'si'
				},
				callback: function(){padre.AdicionarMenuBoton(ds_colectivo,config_colectivo);}
				});	*/


				



				padre.AdicionarBoton('../../../lib/imagenes/print.gif','Imprime el listado de la pantalla',btn_imprimir,true,'imprimir','Imprimir');
				//	this.AdicionarBoton('../../../lib/imagenes/print.gif','Imprime el detalle de la Memoria de Cálculo',btnMemoria,true,'imp_mem_calculo','Memoria');
				crearDialogMoneda();
				layout_consolidacionPresupuesto.getLayout().addListener('layout',this.onResize);
}