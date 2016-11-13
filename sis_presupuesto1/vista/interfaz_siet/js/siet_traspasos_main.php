<?php
/**
 * Nombre:		  	    tipo_cambio_det_main.php
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
var maestro={ id_siet_declara:<?php echo $m_id_siet_declara;?>,
		      tipo_declara:<?php echo "'$m_tipo_declara'";?>,
		      periodo:<?php echo "'$m_periodo'";?>,
		      gestion:<?php echo $m_gestion;?>,
	     	id_moneda:<?php echo $m_id_moneda;?>,nombre:'<?php echo $m_nombre;?>'};
idContenedorPadre='<?php echo $idContenedorPadre;?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_traspasos(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
//ContenedorPrincipal.getPagina(idContenedorPadre).pagina.setPagina(elemento);
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_traspasos.js
 * Propósito: 			pagina objeto principal
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-06 20:48:43
 */
function pagina_traspasos(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
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
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/interfaz_siet/ActionListarSietTraspasos.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_siet_traspaso',
			totalRecords: 'TotalCount'

		}, [

		// define el mapeo de XML a las etiquetas (campos)
		'id_siet_traspaso',
		'id_siet_declara',
		'id_siet_cbte_origen',
		'id_siet_cbte_destion',
		 'nro_cbte_origen',
		 'nro_cbte_destino',
		 'nro_cuenta_bancaria_origen',
		 'nro_cuenta_bancaria_destino',
		'importe_origen',
		'importe_origen',
		'id_cbte'
	]),remoteSort:true});
	
	function renderSeparadorDeMil(value,cell,record,row,colum,store)
	{
		return monedas_for.formatMoneda(value)
	}
	
	//carga datos XML
	ds.load({
		params:{
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_siet_declara:maestro.id_siet_declara
		}
	});
	// DEFINICIÓN DATOS DEL MAESTRO
	var cmMaestro = new Ext.grid.ColumnModel([{header:"Atributo",width:150,sortable:false,renderer:negrita,locked:false,dataIndex:'atributo'},{header:"Valor",width: 300,sortable:false,renderer:italic,locked:false,dataIndex:'valor'}]);
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	var gridMaestro=new Ext.grid.Grid(div_grid_detalle,{ds:new Ext.data.SimpleStore({fields:['atributo','valor'],data:[['Periodo',maestro.periodo],['Tipo',maestro.tipo_declara],['Gestion',maestro.gestion]]}),cm:cmMaestro});
	gridMaestro.render();
	/////////////////////////
	// Definición de datos //
	/////////////////////////


	vectorAtributos[0]={
			validacion:{
				//fieldLabel: 'Id',
				labelSeparator:'',
				name: 'id_siet_traspaso',
				inputType:'hidden',
				grid_visible:false, 
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false,
			save_as:'id_siet_traspaso'
			
		};
	vectorAtributos[1]={
				validacion:{
					//fieldLabel: 'Id',
					labelSeparator:'',
					name: 'id_siet_declara',
					inputType:'hidden',
					grid_visible:false, 
					grid_editable:false
				},
				tipo: 'Field',
				filtro_0:false,
				save_as:'id_siet_declara',
				defecto:maestro.id_siet_declara
				
			};
	vectorAtributos[2]= {
			validacion:{
				name:'id_cbte',
				fieldLabel:'ID Cbte',
				allowBlank:false,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision :6,//para numeros float
				allowNegative: false,
				minValue:0,
				vtype:'texto',
				grid_visible:true,
				//renderer:render_tc,
				grid_editable:true,
				width_grid:100,
				width:'80%'
			},
			tipo: 'Field',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'SC.id_cbte',
			save_as:'id_cbte',
			id_grupo:0
		};
	
	vectorAtributos[3]= {
			validacion:{
				name:'nro_cbte_origen',
				fieldLabel:'Nro Cbte Origen',
				allowBlank:false,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision :6,//para numeros float
				allowNegative: false,
				minValue:0,
				vtype:'texto',
				grid_visible:true,
				//renderer:render_tc,
				grid_editable:true,
				width_grid:150,
				width:'80%'
			},
			tipo: 'Field',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'SC.nro_cbte',
			save_as:'nro_cbte_origen',
			id_grupo:0
		};
	vectorAtributos[4]= {
			validacion:{
				name:'nro_cbte_destino',
				fieldLabel:'Nro Cbte Destino',
				allowBlank:false,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision :6,//para numeros float
				allowNegative: false,
				minValue:0,
				vtype:'texto',
				grid_visible:true,
				//renderer:render_tc,
				grid_editable:true,
				width_grid:150,
				width:'80%'
			},
			tipo: 'Field',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'SC1.nro_cbte',
			save_as:'nro_cbte_destino',
			id_grupo:0
		};
	vectorAtributos[5]= {
			validacion:{
				name:'nro_cuenta_bancaria_origen',
				fieldLabel:'Cuenta Bancaria Origen',
				allowBlank:false,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision :6,//para numeros float
				allowNegative: false,
				minValue:0,
				vtype:'texto',
				grid_visible:true,
				//renderer:render_tc,
				grid_editable:true,
				width_grid:150,
				width:'80%'
			},
			tipo: 'Field',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'CB.nro_cuenta_banco',
			save_as:'nro_cuenta_bancaria_origen',
			id_grupo:0
		};
	vectorAtributos[6]= {
			validacion:{
				name:'nro_cuenta_bancaria_destino',
				fieldLabel:'Cuenta Bancaria Destino',
				allowBlank:false,
				maxLength:50,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision :6,//para numeros float
				allowNegative: false,
				minValue:0,
				vtype:'texto',
				grid_visible:true,
				//renderer:render_tc,
				grid_editable:true,
				width_grid:150,
				width:'80%'
			},
			tipo: 'Field',
			filtro_0:true,
			filtro_1:true,
			filterColValue:'CB1.nro_cuenta_banco',
			save_as:'nro_cuenta_bancaria_destino',
			id_grupo:0
		};
		
	


	

// txt oficial
	vectorAtributos[7]= {
		validacion:{
			name:'importe_origen',
			fieldLabel:'Importe Origen',
			allowBlank:false,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision :6,//para numeros float
			allowNegative: false,
			minValue:0,
			vtype:'texto',
			grid_visible:true,
			align:'right',
			renderer: renderSeparadorDeMil,
			grid_editable:true,
			width_grid:100,
			width:'80%'
		},
		tipo: 'NumberField',
		filtro_0:true,
		filtro_1:true,
		filterColValue:'TRASP.importe_origen',
		save_as:'importe_origen',
		id_grupo:0
	};
	

	//----------- FUNCIONES RENDER
	
	function formatDate(value){
		return value ? value.dateFormat('d/m/Y') : ''
	};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={
		titulo_maestro:'Declaración (Maestro)',
		titulo_detalle:'Traspasos (Detalle)',
		grid_maestro:'grid-'+idContenedor
	};
	layout_siet_traspaso = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_siet_traspaso.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,vectorAtributos,ds,layout_siet_traspaso,idContenedor);
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
		/*guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},*/
		eliminar:{crear:true,separador:false},
		actualizar:{crear:true,separador:false}
	};
	
	//--------- DEFINICIÓN DE FUNCIONES
	//datos necesarios para el filtro
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/interfaz_siet/ActionEliminarSietTraspaso.php',parametros:'&m_id_siet_declara='+maestro.id_siet_declara},
	Save:{url:direccion+'../../../control/tipo_cambio/ActionGuardarTipoCambio.php',parametros:'&m_id_moneda='+maestro.id_moneda},
	ConfirmSave:{url:direccion+'../../../control/tipo_cambio/ActionGuardarTipoCambio.php'},
	Formulario:{
			titulo:'Traspaso',
			html_apply:"dlgInfo-"+idContenedor,
			width:'25%',
			height:'40%',
			minWidth:100,
			minHeight:150,
			columnas:['95%'],
			closable:true,
			grupos:[
			{
				tituloGrupo:'Traspaso',
				columna:0,
				id_grupo:0
			}
			]
		}
	};

	this.reload=function(params){
		var datos=Ext.urlDecode(decodeURIComponent(params));
		
		maestro.id_siet_declara=datos.m_id_siet_declara;
		maestro.periodo=datos.m_periodo;
		maestro.tipo_declara=datos.m_tipo_declara;
		maestro.gestion=datos.m_gestion;
		ds.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				
				m_id_siet_declara:maestro.id_siet_declara
			}
		});
		
		gridMaestro.getDataSource().removeAll();
		gridMaestro.getDataSource().loadData([['Periodo',maestro.periodo],['Tipo',maestro.tipo_declara],['Gestion',maestro.gestion]]);
		vectorAtributos[1].defecto=maestro.id_siet_declara;
		var paramFunciones={
				btnEliminar:{url:direccion+'../../../control/interfaz_siet/ActionEliminarSietTraspaso.php',parametros:'&m_id_siet_declara='+maestro.id_siet_declara},
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
	function btn_gen_traspasos(){
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();

			if(confirm('Esta seguro de obtener Traspasos?')){
				
				Ext.MessageBox.show({
					title: 'Procesando',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Procesando...</div>",
					width:200,
					height:200,
					closable:false
				})};
				
				
	 			/*	var id_siet_declara=SelectionsRecord.data.id_siet_declara;
					var periodo_lite=SelectionsRecord.data.periodo_lite;
					var gestion=SelectionsRecord.data.gestion;
					*/
					alert(maestro.id_siet_declara);
	 				Ext.Ajax.request({
	 					url:direccion+"../../../control/interfaz_siet/ActionGenerarSietTraspasos.php",
	 						method:'POST',
							params:{cantidad_ids:1,id_siet_declara_0:maestro.id_siet_declara/*,periodo_lite:periodo_lite,gestion:gestion*/},
							success:function(resp){
						var root = resp.responseXML.documentElement;
						var error = root.getElementsByTagName('error')[0].firstChild.nodeValue;
						if(error=='1'){
							Ext.MessageBox.alert('Información',root.getElementsByTagName('mensaje_error')[0].firstChild.nodeValue);
							return;
						} else {
							Ext.MessageBox.alert('Información',root.getElementsByTagName('mensaje')[0].firstChild.nodeValue);
						}
					},
					failure:ClaseMadre_conexionFailure,
					timeout:100000000
					});				
	 			
			
}	
  /*	function btn_gen_traspasos()
	{
		var sm=getSelectionModel();
		var filas=ds.getModifiedRecords();
		var cont=filas.length;
		var NumSelect=sm.getCount();
		var SelectionsRecord=sm.getSelected();
		
		
			if(confirm('Esta seguro de obtener Traspasos?'))
				sw=true
				Ext.MessageBox.show({
					title: 'Procesando',
					msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Procesando...</div>",
					width:200,
					height:200,
					closable:false
				});
				
			
				var SelectionsRecord=sm.getSelections(); 			
	 			
	 			for(var i=0 ; i<NumSelect ; i++)
	 			{
					arr_id_siet_declara[i]=SelectionsRecord[i].data.id_siet_declara;
						
	 				Ext.Ajax.request({
					url:direccion+"../../../control/interfaz_siet/ActionGenerarSietTraspasos.php",
					method:'POST',
					params:{cantidad_ids:1,id_siet_declara_0:maestro.id_siet_declara},
					success:function(resp){
						var root = resp.responseXML.documentElement;
						var error = root.getElementsByTagName('error')[0].firstChild.nodeValue;
						if(error=='1'){
							Ext.MessageBox.alert('Información',root.getElementsByTagName('mensaje_error')[0].firstChild.nodeValue);
							return;
						} else {
							Ext.MessageBox.alert('Información',root.getElementsByTagName('mensaje')[0].firstChild.nodeValue);
						}
					},
					failure:ClaseMadre_conexionFailure,
					timeout:100000000
					});				
	 			
			

		}
	}	

	*/
	
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){
		
	//para iniciar eventos en el formulario
	for(i=0;i<vectorAtributos.length;i++)
		{
			
			componentes[i]=ClaseMadre_getComponente(vectorAtributos[i].validacion.name);
			
		}
		sm=getSelectionModel();
	}


	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){
		return layout_siet_traspaso.getLayout();
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
	this.AdicionarBoton('../../../lib/imagenes/copy.png','Procesa Traspasos',btn_gen_traspasos,true,'btn_gen_traspasos','Generar Traspasos');
	var CM_getBoton=this.getBoton;
    

	function  enable(sel,row,selected){
			var record=selected.data;
			
			if(selected&&record!=-1){
				if (maestro.tipo_declara=='recurso'){
					
					CM_getBoton('btn_gen_traspasos-'+idContenedor).disable();
					
				}else{
                	CM_getBoton('btn_gen_traspasos-'+idContenedor).enable();
              	}

            
			}

			
			//enableSelect(sel,row,selected);
		}
	this.iniciaFormulario();
	iniciarEventosFormularios();
	layout_siet_traspaso.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
	
}