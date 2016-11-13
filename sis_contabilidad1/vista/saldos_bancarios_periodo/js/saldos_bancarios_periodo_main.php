<?php
/**
 * Nombre:		  	    saldos_bancarios_periodo_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista del Hijo
 * Autor:				José Mita
 * Fecha creación:		2011-05-31 11:04:06
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
var paramConfig={TamanoPagina:30,TiempoEspera:1000000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa,idSub:idSub};
var maestro={
			tipo_pres:'<?php echo utf8_decode( $tipo_pres) ;?>',
	     	id_parametro:'<?php echo utf8_decode($id_parametro);?>',
	     	id_moneda:'1',
	     	desc_moneda:'Bolivianos',
	     	gestion_pres:'<?php echo utf8_decode($gestion_pres);?>',
	     	desc_pres:'<?php echo utf8_decode($desc_pres);?>',
	     	sw_vista:'<?php echo utf8_decode($sw_vista);?>',
	     	desc_estado_gral:'<?php echo utf8_decode($desc_estado_gral);?>'
	     	
	     	
};
 
 
idContenedorPadre='<?php echo utf8_decode($idContenedorPadre);?>';
var elemento={idContenedor:idContenedor,pagina:new pagina_saldos_bancarios_periodo(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);

/**
 * Nombre:		  	    pagina_saldos_bancarios_periodo.js
 * Propósito: 			pagina objeto principal
 * Autor:				José Mita
 * Fecha creación:		2011-05-31 11:04:06
 */
function pagina_saldos_bancarios_periodo(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0;
 
	var	g_limit='';
	var	g_CantFiltros='';
	
	var	g_id_parametro=1;
	var	g_id_parametro_desc='Ninguno';
	var	g_id_eeff=1;
	var	g_id_eeff_desc='Ninguno';
	var	g_id_ctaban=1;
	var	g_id_codigo_depto='Ninguno';
	
	var	g_fecha=new Date();
	var	g_fecha_rep=new Date();
	
	var g_fecha_ini=new Date();
	var g_fecha_rep_ini =new Date();
	
	
	var	g_id_moneda=1;
	var	g_id_moneda_desc='Ninguno';
	var	g_gestion='2011';
	var	g_nivel=2;
	var	g_sw_actualizacion='con_actualizac';
	var g_id_eeff_desc ='Ninguno'
	
	var	g_ids_ctaban='';
	var g_ids_periodo='';
   	
	var	g_ids_fuente_financiamiento='';
	var	g_ids_u_o='';
	var	g_ids_financiador='';
	var	g_ids_regional='';
	var	g_ids_programa='';
	var	g_ids_proyecto='';
	var	g_ids_actividad='';

 	var g_ctaban='';
 	var	g_periodo='';
 	var g_regional='';
	var g_financiador='';
	var g_programa='';
	var g_proyecto='';
	var g_actividad='';
	var g_unidad_organizacional='';
	var g_Fuente_financiamiento='';

	var g_desc_moneda=maestro.desc_moneda;

	var g_desc_estado_gral=maestro.desc_estado_gral;
	var epe=" ";
	var g_ctabancaria='';
	
	var sw=0;	
	/****************/
	/****************/
 				
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/saldos_bancarios_periodo/ActionListarSaldosBancariosPeriodo.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'nro_cuenta',
			totalRecords: 'TotalCount'

		}, [
		// define el mapeo de XML a las etiquetas (campos)
		'id_reporte',
		'nombre_auxiliar',
		'periodo',
		'ingreso',
		'egreso',
		'saldo',
		'saldo_acumulado'
		 
		]),remoteSort:true});
 
	//carga datos XML
 	/*crea los data store*/
	var ds_ctaban = 	new Ext.data.Store({proxy: new Ext.data.HttpProxy({url:direccion+'../../../../sis_tesoreria/control/cuenta_bancaria/ActionListarCuentaBancaria.php?m_estado_cuenta=1'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_cuenta_bancaria',totalRecords:'TotalCount'},['id_cuenta_bancaria','id_institucion','desc_institucion','id_cuenta','desc_cuenta','id_auxiliar','desc_auxiliar','nro_cheque','estado_cuenta','nro_cuenta_banco','id_moneda','nombre_moneda','id_parametro','gestion']),remoteSort:true});	
	var ds_periodo = 	new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/periodo/ActionListarPeriodo.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id: 'id_periodo',	totalRecords: 'TotalCount'}, ['id_periodo','id_gestion','desc_gestion','periodo',{name: 'fecha_inicio',type:'date',dateFormat:'Y-m-d'},{name: 'fecha_final',type:'date',dateFormat:'Y-m-d'},'estado_peri_gral']),remoteSort:true});
	 
	
	var tpl_id_ctaban=new Ext.Template('<div class="search-item">','<b><i>{desc_auxiliar}</i></b>','</div>');	
	
	
	 
	config_ctaban={nombre:'CtaBancaria',descripcion:'desc_auxiliar',id:'id_cuenta_bancaria',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};	
	config_periodo={nombre:'Periodo',descripcion:'periodo',id:'periodo',selectAceptar:true,selectTodo:true,selectLimpiar:true,funcion:menuBotones};	
	
	function menuBotones()
	{
		 
	 	g_limit= paramConfig.TamanoPagina;
	 	g_CantFiltros=paramConfig.CantFiltros;
	 	
   		g_ids_ctaban=padre.getBotonMenuBotonNombre('CtaBancaria').menuBoton.getSelecion();
   		g_ctaban=padre.getBotonMenuBotonNombre('CtaBancaria').menuBoton.getSeleccionadosDesc();
   		
   		g_ids_periodo=padre.getBotonMenuBotonNombre('Periodo').menuBoton.getSelecion();
   		g_periodo=padre.getBotonMenuBotonNombre('Periodo').menuBoton.getSeleccionadosDesc();
   		//alert (g_depto);
   		
		ds.baseParams={//start:0,
			limit: g_limit,
			CantFiltros:g_CantFiltros,
			
			id_parametro:g_id_parametro,
			id_reporte_eeff:g_id_eeff,
			fecha_trans:g_fecha,
			fecha_trans_ini:g_fecha_ini,
			
			id_moneda:g_id_moneda,
			//id_depto:g_id_depto,
			//nivel:g_nivel,
			//sw_actualizacion:g_sw_actualizacion,
			
			ids_fuente_financiamiento:g_ids_fuente_financiamiento,
			ids_u_o:g_ids_u_o,
			ids_financiador:g_ids_financiador,
			ids_regional:g_ids_regional,
			ids_programa:g_ids_programa,
			ids_proyecto:g_ids_proyecto,
			ids_actividad:g_ids_actividad,
			ids_ctaban:g_ids_ctaban,	
			ids_periodo:g_ids_periodo	
		};
		//ds.lastOptions={};
	 

	
//	if(g_regional){epe=epe+"<texto_em> REGIONAL: </texto_em>"+g_regional};
//	if(g_financiador){epe=epe+"<texto_em>  FINANCIADOR:</texto_em>"+g_financiador};
//	if(g_programa){epe=epe+"<texto_em>  PROGRAMA:</texto_em>"+g_programa};
//	if(g_proyecto){epe=epe+"<texto_em>  SUBPROGRAMA:</texto_em>"+g_proyecto};
//	if(g_actividad){epe=epe+"<texto_em>  ACTIVIDAD:</texto_em>"+g_actividad};
	/***********/
 
/*	if(epe==" "){epe="Todos"}
	if(g_unidad_organizacional==""){g_unidad_organizacional="Todos"}
	if(g_Fuente_financiamiento==""){g_Fuente_financiamiento="Todos"}*/
	
	 var data_maestro=[ ['Gestión',g_id_parametro_desc,'Moneda',g_id_moneda_desc+tabular(44-g_id_moneda_desc.length)]
					    ];
		Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));
	}
	//carga datos XML
	
	// DEFINICIÓN DATOS DEL MAESTRO
function 	 MaestroJulio(data){
		//var  html="<table class='tabla_maestro'>";
		var mayor=0;		
		var j;
		//var  html="<table class='izquierda'><tr>";
		var  html="<table class='izquierda'>";
		for(j=0;j<data.length;j++){if(mayor<=data[j].length){mayor=data[j].length }};
		//for(j=0;j<mayor;j++){html=html=+"<td>&nbsp;</td>";};
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
{ if (n>=0)	{return "  "+tabular(n-1)}
else return "  "
}

	
	function negrita(value){return '<span style="color:red;font-size:10pt"><b>'+value+'</b></span>';}
	function italic(value){return '<i>'+value+'</i>';}
	var div_grid_detalle=Ext.DomHelper.append(idContenedor,{tag:'div',id:'grid_detalle-'+idContenedor});
	Ext.DomHelper.applyStyles(div_grid_detalle,'background-color:#FFFFFF');
	
	var data_maestro=[ ['Gestión',g_id_parametro_desc,'Moneda',g_id_moneda_desc+tabular(44-g_id_moneda_desc.length)]
					    ];
 
					   
	//DATA STORE COMBOS

    var ds_partida = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/partida/ActionListarPartida.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_partida',totalRecords: 'TotalCount'},['id_partida','codigo_partida','nombre_partida','desc_partida','nivel_partida','sw_transaccional','tipo_partida','id_parametro','id_partida_padre','tipo_memoria','sw_movimiento'])
			});

    var ds_presupuesto = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/presupuesto/ActionListarPresupuesto.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_presupuesto',totalRecords: 'TotalCount'},['id_presupuesto','fecha_presentacion','tipo_pres','estado_pres','id_unidad_organizacional','id_fuente_financiamiento','id_parametro','id_fina_regi_prog_proy_acti'])
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
		var tpl_id_presupuesto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{}</FONT><br>','</div>');

		function render_id_partida_presupuesto(value, p, record){return String.format('{0}', record.data['desc_partida_presupuesto']);}
		var tpl_id_partida_presupuesto=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{}</FONT><br>','</div>');

		function render_id_moneda(value, p, record){return String.format('{0}', record.data['desc_moneda']);}
		var tpl_id_moneda=new Ext.Template('<div class="search-item">','<FONT COLOR="#B5A642">{nombre}</FONT><br>','</div>');

				
		
		function renderSwTranssacional(value,cell,record,row,colum,store){
		if(store.getAt(row).data['sw_transaccional'] == 1){
			return  '<span style="color:green;">' +value+'</span>'}	
		if(store.getAt(row).data['sw_transaccional'] == 2){return value}
		 
		}	
		 
	
	/////////////////////////
	// Definición de datos //
	/////////////////////////
	
	// hidden id_partida_presupuesto
	//en la posición 0 siempre esta la llave primaria

  
	Atributos[0]={
		validacion:{
			name:'nombre_auxiliar',
			fieldLabel:'Cuenta Bancaria',
			allowBlank:true,
			maxLength:50,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:300,
			width:'50%',
			//renderer: renderSwTranssacional,
			disable:false		
		},
		tipo: 'TextField',
		form: false,
		filtro_0:true,
		filterColValue:'nombre_auxiliar',
		save_as:'nombre_auxiliar'
	};
		Atributos[1]={
		validacion:{
			name:'periodo',
			fieldLabel:'Periodo',
			allowBlank:true,
			maxLength:200,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:'50%',
			//renderer: renderSwTranssacional,
			disable:false		
		},
		tipo: 'TextField',
		form: false,
		filtro_0:true,
		filterColValue:'periodo',
		save_as:'periodo'
	};
 
	 
  
// txt mes_01
	Atributos[2]={
		validacion:{
			name:'ingreso',
			fieldLabel:'Ingreso',
			allowBlank:false,
			align:'right', 
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			//renderer: renderSwTranssacional,
			width_grid:120,
			width:'80%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: false,
		filtro_0:false,
		filterColValue:'ingreso'
	};
	//mes_2
	Atributos[3]={
		validacion:{
			name:'egreso',
			fieldLabel:'Egreso',
			allowBlank:false,
			align:'right', 
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			//renderer: renderSwTranssacional,
			width_grid:120,
			width:'80%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: false,
		filtro_0:false,
		filterColValue:'egreso'
	};
	//mes_3
	Atributos[4]={
		validacion:{
			name:'saldo',
			fieldLabel:'Saldo',
			allowBlank:false,
			align:'right', 
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:true,
			decimalPrecision:2,//para numeros float
			allowNegative:false,
			minValue:0,
			grid_visible:true,
			grid_editable:false,
			//renderer: renderSwTranssacional,
			width_grid:120,
			width:'80%',
			disabled:false		
		},
		tipo: 'MonedaField',
		form: false,
		filtro_0:false,
		filterColValue:'saldo'
	};
	
	Atributos[5]={
			validacion:{
				name:'saldo_acumulado',
				fieldLabel:'Saldo Acumulado',
				allowBlank:false,
				align:'right', 
				maxLength:100,
				minLength:0,
				selectOnFocus:true,
				allowDecimals:true,
				decimalPrecision:2,//para numeros float
				allowNegative:false,
				minValue:0,
				grid_visible:true,
				grid_editable:false,
				//renderer: renderSwTranssacional,
				width_grid:120,
				width:'80%',
				disabled:false		
			},
			tipo: 'MonedaField',
			form: false,
			filtro_0:false,
			filterColValue:'saldo'
		};
	
	//----------- FUNCIONES RENDER
	
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE
	var config={titulo_maestro:'Parametros (Maestro)',titulo_detalle:'Saldos Bancarios Periodo',grid_maestro:'grid-'+idContenedor};
	var layout_saldoBancarioPeriodo = new DocsLayoutDetalle(idContenedor,idContenedorPadre);
	layout_saldoBancarioPeriodo.init(config);
	
	
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout_saldoBancarioPeriodo,idContenedor);
	var getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	var EstehtmlMaestro=this.htmlMaestro;
	var ClaseMadre_btnActualizar=this.btnActualizar;
	var ClaseMadre_conexionFailure=this.conexionFailure;
//DEFINICIÓN DE LA BARRA DE MENÚ
	var paramMenu={
		/*guardar:{crear:true,separador:false},
		nuevo:{crear:true,separador:true},
		editar:{crear:true,separador:false},
		eliminar:{crear:true,separador:false},*/
		actualizar:{crear:true,separador:false},
		//excel:{crear:true,separador:false}
	};
	this.btnActualizar=function(){
		if (sw==0){ 
			ds.load({params:ds.baseParams});
			sw =1;
		}
		else{ 
			ClaseMadre_btnActualizar(); 
			}
	}

	
//DEFINICIÓN DE FUNCIONES
	Ext.DomHelper.overwrite('grid_detalle-'+idContenedor,MaestroJulio(data_maestro));
	var paramFunciones={
	btnEliminar:{url:direccion+'../../../control/partida_presupuesto/ActionEliminarDetallePartidaFormulacion.php',parametros:'&m_id_presupuesto='+maestro.id_presupuesto},
	Save:{url:direccion+'../../../control/partida_presupuesto/ActionGuardarDetallePartidaFormulacion.php',parametros:'&m_id_presupuesto='+maestro.id_presupuesto},
	ConfirmSave:{url:direccion+'../../../control/partida_presupuesto/ActionGuardarDetallePartidaFormulacion.php',parametros:'&m_id_presupuesto='+maestro.id_presupuesto},
	Formulario:{html_apply:'dlgInfo-'+idContenedor,height:340,width:480,minWidth:150,minHeight:200,	closable:true,titulo:'Saldo Bancario'}};
	
	//-------------- Sobrecarga de funciones --------------------//


function btn_imprimir(){
  			//parametros reporte 
			var data='start=0';
			 data+='&limit=1000';
			 data+='&CantFiltros='+g_CantFiltros;
			 
			 data+='&id_parametro='+g_id_parametro;
			 data+='&id_reporte_eeff='+g_id_eeff;
			 data+='&ids_ctaban='+g_ids_ctaban;
			 data+='&fecha_trans='+g_fecha;
			 data+='&fecha_trans_ini='+g_fecha_ini;
			 data+='&id_moneda='+g_id_moneda;
			 data+='&nivel='+g_nivel;
			 data+='&sw_actualizacion='+g_sw_actualizacion;
			 
			 
			 data+='&ids_fuente_financiamiento='+g_ids_fuente_financiamiento;
			 data+='&ids_u_o='+g_ids_u_o;
			 data+='&ids_financiador='+g_ids_financiador;
			 data+='&ids_regional='+g_ids_regional;
			 data+='&ids_programa='+g_ids_programa;
			 data+='&ids_proyecto='+g_ids_proyecto;
			 data+='&ids_actividad='+g_ids_actividad;
			 //data+='&fecha_rep='+g_fecha;
			 //data+='&fecha_rep='+g_fecha.dateFormat('d/m/Y');
			 data+='&fecha_rep='+g_fecha_rep;
			 data+='&fecha_rep_ini='+g_fecha_rep_ini;
			 
	if(g_unidad_organizacional==""){g_unidad_organizacional="Todos"}
	if(g_Fuente_financiamiento==""){g_Fuente_financiamiento="Todos"}
 
					   
	data+='&EEFF='+g_id_eeff_desc;					   
	 
	data+='&desc_moneda='+g_id_moneda_desc;
	data+='&gestion='+g_id_parametro_desc;
	data+='&ids_periodo='+g_ids_periodo;
	 
	data+='&regional='+g_regional;
	data+='&financiador='+g_financiador;
	data+='&programa='+g_programa;
	data+='&proyecto='+g_proyecto;
	data+='&actividad='+g_actividad;
	data+='&unidad_organizacional='+g_unidad_organizacional;
	data+='&Fuente_financiamiento='+g_Fuente_financiamiento;
	data+='&Cta_Bancaria='+g_ctaban;
	 
	window.open(direccion+'../../../control/saldos_bancarios_periodo/ActionSaldosBancariosPeriodo.php?'+data);
	
	}
	/*******************/
	
	//Para manejo de eventos
	function iniciarEventosFormularios(){	
	//para iniciar eventos en el formulario
	}

	//para que los hijos puedan ajustarse al tamaño
	this.getLayout=function(){return layout_saldoBancarioPeriodo.getLayout()};
	//para el manejo de hijos
	
	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	//para agregar botones
	padre=this;

	this.iniciaFormulario();
	iniciarEventosFormularios();
	ds_ctaban.load({
								params:{
								start:0,
								limit: paramConfig.TamanoPagina,
								CantFiltros:paramConfig.CantFiltros,
						 		},
								callback: function(){padre.AdicionarMenuBoton(ds_ctaban,config_ctaban);}
								});
	ds_periodo.load({
								params:{
								start:0,
								limit: paramConfig.TamanoPagina,
								CantFiltros:paramConfig.CantFiltros,
								id_gestion:1
						 		},
								callback: function(){padre.AdicionarMenuBoton(ds_periodo,config_periodo);}
								});
	
var ds_moneda_consulta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords: 'TotalCount'},['id_moneda','nombre','simbolo','estado','origen','prioridad']),baseParams:{estado:'activo'}});
var tpl_id_moneda_reg=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Abrev: </b>{simbolo}</FONT>','</div>');
var ds_parametro = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/parametro/ActionListarParametro.php?tipo_vista=conta_parametro'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_parametro',totalRecords:'TotalCount'},['id_parametro','id_gestion','desc_gestion','cantidad_nivel','estado_gestion','gestion_conta','porcen_iva','porcen_it','porcen_servicio','porcen_bien','porcen_remesa','id_moneda','nombre_moneda'])});
var tpl_id_parametro_reg=new Ext.Template('<div class="search-item">','<b><i>{desc_gestion}</i></b>','</div>');
var ds_eeff = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/reporte_eeff/ActionListarEeff.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_reporte_eeff',totalRecords:'TotalCount'},['id_reporte_eeff','nombre_eeff']),remoteSort:true});
var tpl_id_eeff=new Ext.Template('<div class="search-item">','<b><i>{nombre_eeff}</i></b>','</div>');

//monedas
var monedas =new Ext.form.ComboBox({
			store: ds_moneda_consulta,
			displayField:'nombre',
			typeAhead: false,
			mode: 'local',
			triggerAction: 'all',
			emptyText:'moneda...',
			selectOnFocus:true,
			width:100,
			valueField: 'id_moneda',
			tpl:tpl_id_moneda_reg
			
		});
//adicionamos eventos de los combos
monedas.on('select',function (combo, record, index){
	  g_id_moneda =monedas.getValue();
	  ds.baseParams.id_moneda=g_id_moneda;
	  ClaseMadre_btnActualizar();
  });
//para el combo box moneda
	function cargar_respuesta(resp){
		Ext.MessageBox.hide();
		if(resp.responseXML !=undefined && resp.responseXML !=null && resp.responseXML.documentElement !=null && resp.responseXML.documentElement !=undefined)
		{
			var root=resp.responseXML.documentElement;			
				g_id_moneda=(root.getElementsByTagName('id_moneda')[0].firstChild.nodeValue);
				monedas.setValue(1);
				parametro.setValue(3);
				monedas.setRawValue(root.getElementsByTagName('nombre')[0].firstChild.nodeValue);
				
				g_id_moneda_desc=monedas.getRawValue();
				ds.baseParams.id_moneda=1;
				ds.load({
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros
					}
				});	
		}
	}
  monedas.on("render",function(){
		 Ext.Ajax.request({
				url:direccion+"../../../../sis_parametros/control/moneda/ActionListarMoneda.php",
				method:'POST',
				params:{tipo_filtro:'id_moneda'},
				success:cargar_respuesta,
				failure:ClaseMadre_conexionFailure,
				timeout:100000000
		  });
	});
	


//parametro
var parametro =new Ext.form.ComboBox({
			store: ds_parametro,
			displayField:'gestion_conta',
			typeAhead: false,
			mode: 'local',
			triggerAction: 'all',
			emptyText:'gestión...',
			selectOnFocus:true,
			width:60,
			valueField: 'id_parametro',
			tpl:tpl_id_parametro_reg
			
		});
//adicionamos eventos de los combos
parametro.on('select',function (combo, record, index){
	  g_id_parametro =parametro.getValue();
	  ds.baseParams.id_parametro=g_id_parametro;
	  ClaseMadre_btnActualizar();
  });
//para el combo box parametro
	function cargar_respuestaP(resp){
		Ext.MessageBox.hide();
		if(resp.responseXML !=undefined && resp.responseXML !=null && resp.responseXML.documentElement !=null && resp.responseXML.documentElement !=undefined)
		{
			var root=resp.responseXML.documentElement;			
				parametro.setValue(3);
				monedas.setValue(1);
				parametro.setRawValue(root.getElementsByTagName('desc_gestion')[0].firstChild.nodeValue);
				g_id_parametro=parametro.getRawValue();
				ds.baseParams.id_parametro=3;
				ds.load({
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros
					}
				});	
		}
	}//control/_reportes/detalle_facturacion/PDFDetalleFactura.php
  parametro.on("render",function(){
		 Ext.Ajax.request({
				url:direccion+"../../../control/parametro/ActionListarParametro.php?tipo_vista=conta_parametro",
				method:'POST',
				params:{tipo_filtro:'id_parametro'},
				success:cargar_respuestaP,
				failure:ClaseMadre_conexionFailure,
				timeout:100000000
		  });
	});

var eeff =new Ext.form.ComboBox({
			store: ds_eeff,
			displayField:'nombre_eeff',
			typeAhead: false,
			mode: 'local',
			triggerAction: 'all',
			emptyText:'EEFF...',
			selectOnFocus:true,
			width:100,
			valueField: 'id_reporte_eeff',
			tpl:tpl_id_eeff
			
		});		
 						
//var nivel =new Ext.form.ComboBox({store: new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['2','N - 2'],['3','N - 3'],['4','N - 4'],['5','N - 5'],['6','N - 6'],['7','N - 7'],['8','N - 8']]}),	typeAhead: false,mode: 'local',triggerAction: 'all',	emptyText:'nivel...',selectOnFocus:true,width:60,valueField:'ID',displayField:'valor',mode:'local'});		
//var sw_actualizacion =new Ext.form.ComboBox({store: new Ext.data.SimpleStore({fields:['ID','valor','filtro'],data:[['si','Con Actualización'],['no','Sin Actualización']]}),	typeAhead: false,mode: 'local',triggerAction: 'all',	emptyText:'SW...',selectOnFocus:true,width:60,valueField:'ID',displayField:'valor',mode:'local'});		
		ds_parametro.load({params:{start:0,limit: 1000000}});
	 	ds_moneda_consulta.load({params:{start:0,limit: 1000000}});
	 	ds_eeff.load({params:{start:0,limit: 1000000}});

		
		parametro.on('select',function (combo, record, index){g_id_parametro=parametro.getValue();g_id_parametro_desc=record.data['desc_gestion'];menuBotones()});
		eeff.on('select',function (combo, record, index){g_id_eeff=eeff.getValue();g_id_eeff_desc=record.data['nombre_eeff'];menuBotones()});		
		//depto.on('select',function (combo, record, index){g_id_depto=depto.getValue();g_id_codigo_depto=record.data['codigo_depto'];menuBotones()});		
		/*fecha.on('change',function (){
								g_fecha=fecha.getValue()?fecha.getValue().dateFormat('m/d/Y'):'';
								g_fecha_rep=fecha.getValue()?fecha.getValue().dateFormat('d/m/Y'):'';
		                        menuBotones()}
		        );
		fecha_ini.on('change',function (){
								g_fecha_ini=fecha_ini.getValue()?fecha_ini.getValue().dateFormat('m/d/Y'):'';
								g_fecha_rep_ini=fecha_ini.getValue()?fecha_ini.getValue().dateFormat('d/m/Y'):'';
		                        menuBotones()}
		        );*/
		monedas.on('select',function (combo, record, index){g_id_moneda=monedas.getValue();g_id_moneda_desc=record.data['nombre'];menuBotones()});
		//nivel.on('select',function (combo, record, index){g_nivel=nivel.getValue();menuBotones()});
		//sw_actualizacion.on('select',function (combo, record, index){g_sw_actualizacion=sw_actualizacion.getValue();menuBotones()});
		

 
//parametro.setValue(1);
eeff.setValue(1);
//fecha.setValue(new Date);
//fecha_ini.setValue(new Date);
//monedas.setValue(1);
//nivel.setValue(2);
//sw_actualizacion.setValue('con_actualizacion');
///ds_periodo.setValue(1);
//ds_ctaban.setValue(1);
								
padre.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte ',btn_imprimir,true,'imprimir','');	
this.AdicionarBotonCombo(parametro,'gestion');		
//this.AdicionarBotonCombo(eeff,'EEFF');		
//this.AdicionarBotonCombo(fecha_ini,'Fecha Inicio');		
//this.AdicionarBotonCombo(fecha,'Fecha');		
this.AdicionarBotonCombo(monedas,'monedas');														
//this.AdicionarBotonCombo(nivel,'nivel');														
//this.AdicionarBotonCombo(sw_actualizacion,'Actualización');														
														
														
layout_saldoBancarioPeriodo.getLayout().addListener('layout',this.onResize);
	//layout_consolidacionPresupuesto.getVentana(idContenedor).on('resize',function(){layout_consolidacionPresupuesto.getLayout().layout()})
	
}