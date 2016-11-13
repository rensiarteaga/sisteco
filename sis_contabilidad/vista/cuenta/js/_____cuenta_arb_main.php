<?php 
/**
 * Nombre:		  	    partida_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2008-07-07 11:38:59
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
var paramConfig={TamanoPagina:20,TiempoEspera:1000000,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var elemento={pagina:new pagina_cuenta_arb(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

function pagina_cuenta_arb(idContenedor,direccion,paramConfig){
	var Atributos=[];
	var ds_parametro;
	var layout_cuenta_arb;
	var cmpCodigoPartida,cmpNombrePartida;
	var	cmpDescPartida,cmpNivelPartida;
	var	cmpSwTransaccional,cmpTipoPartida,cmpNombreRaiz;
	var	cmpIdParametro,cmpTipoMemoria,cmpSwMovimiento;
	var cmpCuentaPadre,cmpSwOec;
	var g_id_gestion='';
	var Dialog;
	var copiados; 
	
	//DATA STORE COMBOS	
	var ds_parametro=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/parametro/ActionListarParametro.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro',totalRecords:'TotalCount'},['id_parametro','id_gestion','gestion','cantidad_nivel'])
	});
	
	var ds_moneda=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_parametros/control/moneda/ActionListarMoneda.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_moneda',totalRecords:'TotalCount'},['id_moneda','nombre','simbolo'])
	});
	
	var ds_cuenta=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/cuenta/ActionListarCuenta.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta',totalRecords: 'TotalCount'},['id_cuenta','desc_cuenta','desc_cta','nivel_cuenta','nombre_cuenta','nro_cuenta','sw_transaccional','tipo_cuenta','id_moneda','id_parametro','gestion'])
	});
	
	var ds_auxiliar=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/auxiliar/ActionListarAuxiliar.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_auxiliar',totalRecords: 'TotalCount'},['id_auxiliar','codigo_auxiliar','nombre_auxiliar','estado_auxiliar'])
	});
	
	var ds_csigma=new Ext.data.Store({proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/cuenta_sigma/ActionListarCuentaSigma.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta_sigma',totalRecords:'TotalCount'},['id_cuenta_sigma','nro_cuenta_sigma','nombre_cuenta_sigma','estado_cuenta_sigma','desc_sigma'], baseParams={m_estado_csigma:1})
	});
	
	//FUNCIONES RENDER
    var tpl_auxiliar=new Ext.Template('<div class="search-item">','<b><i>{nombre_auxiliar}</i></b>','<br><FONT COLOR="#B5A642"><b>Codigo Auxiliar: </b>{codigo_auxiliar}</FONT>','</div>');
 
    var tpl_cuenta=new Ext.Template('<div class="search-item">','<b><i>{desc_cta}</i></b>','<br><FONT COLOR="#B5A642"><b><b>- </b>{gestion}</FONT>','</div>');

	var resultTplParametro=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','<br><FONT COLOR="#B5A642"><b>Cantidad Niveles: </b>{cantidad_nivel}</FONT>','</div>');
	
	var resultTplMoneda=new Ext.Template('<div class="search-item">','<b><i>{nombre}</i></b>','<br><FONT COLOR="#B5A642"><b>Símbolo: </b>{simbolo}</FONT>','</div>');
	
	var tpl_csigma=new Ext.Template('<div class="search-item">','<b><i>{desc_sigma}</i></b>','</div>');

	/////////////////////////
	// Definición de datos //
	/////////////////////////
	Atributos[0]={
		validacion:{
			name:'cuenta_padre',
			fieldLabel:'Depende de:',
			allowBlank:true,
			width:'100%',
		    selectOnFocus:true,
			vtype:'texto'
		},
		tipo:'TextField'
	};
	
	Atributos[1]={
		validacion:{
			name:'nro_cuenta',
			fieldLabel:'Número de Cuenta',
			allowBlank:false,
			width:50,
		    selectOnFocus:true,
			vtype:'texto'
		},
		tipo:'TextField'
	};
	
	// txt nombre_raiz
	Atributos[2]={
		validacion:{
			name:'nombre_raiz',
			fieldLabel:'Nombre de Cuenta',
			typeAhead:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['valor'],data:[['ACTIVO'],['PASIVO'],['PATRIMONIO'],['INGRESOS'],['EGRESOS']]}),
			valueField:'valor',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			width:130
		},
		tipo:'ComboBox',
		defecto:'Titular'
	};	
	
	Atributos[3]={
		validacion:{
			name:'nombre_cuenta',
			fieldLabel:'Nombre de Cuenta',
			allowBlank:true,
			width:'100%',
			maxLength:75,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto'
		},
		tipo:'TextField'
	};
	
	Atributos[4]={
		validacion:{
			name:'desc_cuenta',
			fieldLabel:'Descripción',
			allowBlank:false,
			width:'100%',
			maxLength:1000,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto'
			},
		tipo:'TextArea'
	};
	
	Atributos[5]={
		validacion:{
			name:'nivel_cuenta',
			fieldLabel:'Nivel',
			allowBlank:true,
			maxLength:10,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto'
		},
		tipo:'TextField'
	};

	Atributos[6]={
		validacion:{
			name:'tipo_cuenta',
			fieldLabel:'Cuenta',
			allowBlank:true,
			maxLength:1,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto'
		},
		tipo:'TextField'
	};
	
	Atributos[7]={
		validacion:{
			name:'sw_transaccional',
			fieldLabel:'Tipo de Cuenta',
			typeAhead:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Movimiento'],['2','Titular']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			width:100
		},
		tipo:'ComboBox',
		defecto:2
	};
	
	Atributos[8]={
		validacion:{
			name:'id_parametro',
			fieldLabel:'Parámetro',
			emptyText:'Parametro ...',
			store:ds_parametro,
			allowBlank:true,
			desc:'cantidad_nivel',
			valueField:'id_parametro',
			displayField:'gestion',
			filterCol:'PARAME.cantidad_nivel',
			typeAhead:false,
			forceSelection:false,
			tpl:resultTplParametro,
			mode:'remote',
			queryDelay:50,
			pageSize:5,
			width:150,
			minListWidth:150,
			resizable:true,
			minChars:1,
			triggerAction:'all',
		},
		tipo:'ComboBox'
	};
	
	Atributos[9]={
		validacion:{
			name:'id_moneda',
			fieldLabel:'Moneda',
			emptyText:'Moneda...',
			store:ds_moneda,
			desc:'nombre_moneda',
			valueField:'id_moneda',
			displayField:'nombre',
			filterCol:'MONEDA.nombre',
			typeAhead:false,
			forceSelection:false,
			tpl:resultTplMoneda,
			mode:'remote',
			queryDelay:50,
			pageSize:5,
			width:200,
			minListWidth:230,
			resizable:true,
			minChars:1,
			triggerAction:'all',
		},
		tipo:'ComboBox'
	};
	
	Atributos[10]={
		validacion:{
			name:'sw_oec',
			fieldLabel:'Operación de Caja',
			typeAhead:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Si'],['2','No']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			width:100
		},
		tipo:'ComboBox',
		defecto:2
	};
	
	Atributos[11]={
		validacion:{
			name:'sw_aux',
			fieldLabel:'SW AUX',
			typeAhead:false,
			allowBlank:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Si'],['2','No']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			width:100
		},
		tipo:'ComboBox',
		defecto:2
	};
	
	Atributos[12]={
		validacion:{
			name:'sw_sistema_actualizacion',
			fieldLabel:'Sistema Actualizacion',
			typeAhead:false,
			loadMask:true,
			allowBlank:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['ACTIF','ACTIF'],['CONIN','CONIN'],['MANUAL','MANUAL'],['NOACTUALIZA','NO ACTUALIZA']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			width:150
		},
		tipo:'ComboBox',
		defecto:2
	};
	
	Atributos[13]={
		validacion:{
			name:'id_cuenta_actualizacion',
			fieldLabel:'Cuenta Actualizacion',
			vtype:'texto',
			emptyText:'Cuenta Actualizacion...',
			allowBlank:true,
			typeAhead:false,
			tpl:tpl_cuenta,
			loadMask:true,
			triggerAction:'all',
			store:ds_cuenta,
			mode:'remote',
			desc:'nombre_cuenta_actualizacion',
			valueField:'id_cuenta',
			displayField:'desc_cta',
			forceSelection:true,
			pageSize:10,
			queryParam:'filterValue_0',
			filterCol :'CUENTA.nro_cuenta#CUENTA.nombre_cuenta#GESTION.gestion',
			width:300
		},
		tipo:'ComboBox',
		save_as:'id_cuenta_actualizacion',
		id_grupo: 0
	};  
		
	Atributos[14]={
		validacion:{
			name:'id_auxiliar_actualizacion',
			fieldLabel:'Auxiliar Actualizacion',
			vtype:'texto',
			emptyText:'Auxiliar Actualizacion...',
			allowBlank:true,
			typeAhead:false,
			tpl:tpl_auxiliar,
			loadMask:true,
			triggerAction:'all',
			store:ds_auxiliar,
			mode:'remote',
			valueField:'id_auxiliar',
			displayField:'nombre_auxiliar',
			forceSelection:true,
			pageSize:10,
			queryParam:'filterValue_0',
			filterCol :' AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar',
			desc:'nombre_auxiliar_actualizacion',
			width:300
		},
		tipo:'ComboBox',
		save_as:'id_auxiliar_actualizacion',
		id_grupo: 0
	};  
		
	Atributos[15]={
		validacion:{
			name:'id_cuenta_dif',
			fieldLabel:'Cuenta Dif',
			vtype:'texto',
			emptyText:'Cuenta Dif...',
			allowBlank:true,
			typeAhead:false,
			tpl:tpl_cuenta,
			loadMask:true,
			triggerAction:'all',
			store:ds_cuenta,
			mode:'remote',
			valueField:'id_cuenta',
			displayField:'desc_cta',
			forceSelection:true,
			pageSize:10,
			queryParam:'filterValue_0',
			filterCol :'CUENTA.nro_cuenta#CUENTA.nombre_cuenta',
			desc:'nombre_cuenta_dif',
			width:300
		},
		tipo:'ComboBox',
		save_as:'id_cuenta_dif',
		id_grupo: 0
	};  
		
	Atributos[16]={
		validacion:{
			name:'id_auxiliar_dif',
			fieldLabel:'Auxiliar Dif',
			vtype:'texto',
			emptyText:'Auxiliar Dif...',
			allowBlank:true,
			typeAhead:false,
			tpl:tpl_auxiliar,
			loadMask:true,
			triggerAction:'all',
			store:ds_auxiliar,
			mode:'remote',
			valueField:'id_auxiliar',
			displayField:'nombre_auxiliar',
			forceSelection:true,
			pageSize:10,
			queryParam:'filterValue_0',
			filterCol :' AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar',
			desc:'nombre_auxiliar_dif',
			width:300
		},
		tipo:'ComboBox',
		save_as:'id_auxiliar_dif',
		id_grupo: 0
	}; 
	
	Atributos[17]={
		validacion:{
			name:'sw_sigma',
			fieldLabel:'SW Sigma',
			typeAhead:false,
			loadMask:true,
			allowBlank:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['si','Si'],['no','No']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			width:100
		},
		tipo:'ComboBox',
		defecto:2
	};
	
	Atributos[18]={
		validacion:{
			name:'id_cuenta_sigma',
			fieldLabel:'Cuenta Sigma',
			vtype:'texto',
			emptyText:'Cuenta Sigma...',
			allowBlank:true,
			typeAhead:false,
			tpl:tpl_csigma,
			loadMask:true,
			triggerAction:'all',
			store:ds_csigma,
			mode:'remote',
			valueField:'id_cuenta_sigma',
			displayField:'desc_sigma',
			forceSelection:true,
			pageSize:10,
			queryParam:'filterValue_0',
			filterCol :'CSIGMA.nro_cuenta_sigma#CSIGMA.nombre_cuenta_sigma',
			desc:'desc_sigma',
			width:300
		},
		tipo:'ComboBox',
		save_as:'id_cuenta_sigma',
		id_grupo: 0
	};
	
	Atributos[19]={
		validacion:{
			name:'cuenta_sigma',
			fieldLabel:'Cuenta Sigma',
			allowBlank:true,
			selectOnFocus:true,
			maxLength:1000,
			minLength:0,
			loadMask:true,
			triggerAction:'all',
			width:100
		},
		tipo:'TextField'
	};
	
	Atributos[20]={
		validacion:{
			name:'cuenta_flujo_sigma',
			fieldLabel:'Cuenta Flujo Sigma',
			allowBlank:true,
			selectOnFocus:true,
			maxLength:1000,
			minLength:0,
			loadMask:true,
			triggerAction:'all',
			width:100
		},
		tipo:'TextField'
	};	
	
	Atributos[21]={
		validacion:{
			name:'nota_eeff',
			fieldLabel:'Detalle de Nota',
			typeAhead:false,
			loadMask:true,
			allowBlank:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Auxiliar'],['2','Cuenta']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			width:100
		},
		tipo:'ComboBox',
		defecto:1
	}

	//---------- INICIAMOS LAYOUT DETALLE
	//datos extra a los Atributos declarados se manejaran en las operaciones basicas que maneja en las operacion
	var DatosNodo=new Array('id','id_p','tipo');
	var DatosDefecto={
		agrupador:{
			text:0,//indice del atributo
			icon:"../../../lib/imagenes/tuc.png",
			allowDrag:false,
			allowDelete:true,
			allowEdit:true,
			terminado:'false'
		},
		Movimiento:{
			text:0,//indice del atributo
			icon:"../../../lib/imagenes/tucr_.png",
			allowDrag:false,
			allowDelete:true,
			allowEdit:true,
			terminado:'false'
		},
		Titular:{
			text:0,//indice del atributo
			icon:"../../../lib/imagenes/tucr.png",
			allowDrag:false,
			allowDelete:true,
			allowEdit:true,
			terminado:'false'
		}
	}
	
	var config={titulo:'Plan de Cuentas'};
	layout_cuenta_arb=new DocsLayoutArb(idContenedor);
	layout_cuenta_arb.init(config);
	
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=PaginaArb;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,layout_cuenta_arb,idContenedor,DatosNodo,DatosDefecto);
	
	//----------   herencia de la clase madre -------//
	var getTreePanel=this.getTreePanel;
	var getTreeRaiz=this.getTreeRaiz;
	var getLoader=this.getLoader;
	var conexionFailure=this.conexionFailure;
	var btnEliminar=this.btnEliminar;
	var btnEdit=this.btnEdit;
	var btnNew=this.btnNew;
	var btnNewRaiz=this.btnNewRaiz;
	var getComponente=this.getComponente;
	var getSm=this.getSm;
	var ocultarComponente=this.ocultarComponente;
	var mostrarComponente=this.mostrarComponente;
	var btnActualizar=this.btnActualizar;
	var setValuesBasicos=this.setValuesBasicos;
	var getDialog=this.getDialog;
	var getFormulario=this.getFormulario;
	var prepareCtx=this.prepareCtx;
	var getCtxMenu=this.getCtxMenu;
	var onBeforeMove=this.onBeforeMove;
	var guardarSuccess=this.guardarSuccess;
	
	// parametros las funciones//
	var paramFunciones={
		Basicas:{url:direccion+'../../../../sis_contabilidad/control/cuenta/ActionGuardarCuentaArb.php',add_success:guardarSuccessSc,edit:sEdit},
		Formulario:{height:600,width:490,minWidth:150,minHeight:200,closable:true,titulo:'Plan de Cuentas'},
		Listar:{url:direccion+'../../../../sis_contabilidad/control/cuenta/ActionListarCuentaArb.php',raiz:'agrupador',baseParams:{gestion:-1},clearOnLoad:true,enableDD:true}
	};
	
	// parametros del menu //
	var paramMenu={
		nuevoRaiz:{crear:true,separador:false,tip:'Nuevo Clasificador',img:'tuc+.png'},
		nuevo:{crear:true,separador:false,tip:'Nueva Cuenta',img:'raiz+.png'},
		editar:{crear:true,separador:false,tip:'Editar',img:'etucr.png'},
		eliminar:{crear:true,separador:false,tip:'Eliminar',img:'tucr-.png'},
		actualizar:{crear:true,separador:false}
	};
	
	function isReorder(e, n){
		return n.parentNode == e.target.parentNode && e.point != 'append'
	}
	
	function iniciarEventos(){
		cmpNroCuenta=getComponente('nro_cuenta');
		cmpNombreRaiz=getComponente('nombre_raiz');
		cmpNombreCuenta=getComponente('nombre_cuenta');
		cmpDescCuenta=getComponente('desc_cuenta');
		cmpNivelCuenta=getComponente('nivel_cuenta');
		cmpTipoCuenta=getComponente('tipo_cuenta');
		cmpSwTransaccional=getComponente('sw_transaccional');
		cmpIdParametro=getComponente('id_parametro');
		cmpIdMoneda=getComponente('id_moneda');
		cmpSwOec=getComponente('sw_oec');
		cmpSwAux=getComponente('sw_aux');
		cmpCuentaSigma=getComponente('cuenta_sigma');
        cmpSwSigma=getComponente('sw_sigma');
        cmpIdCuentaActualizacion=getComponente('id_cuenta_actualizacion');
        cmpIdAuxiliarActualizacion=getComponente('id_auxiliar_actualizacion');
        cmpSwSistemaActualizacion=getComponente('sw_sistema_actualizacion');
        cmpIdCuentaDif=getComponente('id_cuenta_dif');
        cmpIdAuxiliarDif=getComponente('id_auxiliar_dif');
		cmpCuentaFlujoSigma=getComponente('cuenta_flujo_sigma');
		cmpCuentaPadre=getComponente('cuenta_padre');
		cmpNotaEeff=getComponente('nota_eeff');
		cmpIdCuentaSigma=getComponente('id_cuenta_sigma');
		
		var onNombreRaizSelect=function(e){
			var id=cmpNombreRaiz.getValue()
			if(id=='ACTIVO'){
				cmpNroCuenta.setValue('1')
			}else{
				if(id=='PASIVO'){
					cmpNroCuenta.setValue('2')
				}else{
					if(id=='PATRIMONIO'){
						cmpNroCuenta.setValue('3')
					}else{
						if(id=='INGRESOS'){
							cmpNroCuenta.setValue('4')
						}else{
							cmpNroCuenta.setValue('5')
						}
					}
				}
				
			}
		};
		
		var onSwTransaccionalSelect=function(e){
			var id=cmpSwTransaccional.getValue()
			if(id==1){
				mostrarComponente(cmpIdMoneda);
				cmpIdMoneda.allowBlank=false;
				cmpIdMoneda.setValue('');
				mostrarComponente(cmpSwOec);
				cmpSwOec.allowBlank=false;
				cmpSwOec.setValue('');
				mostrarComponente(cmpSwAux);
				cmpSwAux.allowBlank=false;
				cmpSwAux.setValue('');
				mostrarComponente(cmpCuentaSigma);
				cmpCuentaSigma.allowBlank=false;
				cmpCuentaSigma.setValue('');
				mostrarComponente(cmpSwSigma);
				cmpSwSigma.allowBlank=true;
				cmpSwSigma.setValue('');
				mostrarComponente(cmpIdCuentaActualizacion);
				cmpIdCuentaActualizacion.allowBlank=true;
				cmpIdCuentaActualizacion.setValue('');
				mostrarComponente(cmpIdAuxiliarActualizacion);
				cmpIdAuxiliarActualizacion.allowBlank=true;
				cmpIdAuxiliarActualizacion.setValue('');
				mostrarComponente(cmpSwSistemaActualizacion);
				cmpSwSistemaActualizacion.allowBlank=false;
				cmpSwSistemaActualizacion.setValue('');
				mostrarComponente(cmpIdCuentaDif);
				cmpIdCuentaDif.allowBlank=true;
				cmpIdCuentaDif.setValue('');
				mostrarComponente(cmpIdAuxiliarDif);
				cmpIdAuxiliarDif.allowBlank=true;
				cmpIdAuxiliarDif.setValue('');
				mostrarComponente(cmpCuentaFlujoSigma);
				cmpCuentaFlujoSigma.allowBlank=true;
				cmpCuentaFlujoSigma.setValue('');
				mostrarComponente(cmpNotaEeff);
				cmpNotaEeff.allowBlank=true;
				cmpNotaEeff.setValue('1');
				mostrarComponente(cmpIdCuentaSigma);
				cmpIdCuentaSigma.allowBlank=true;
				cmpIdCuentaSigma.setValue('');
			}
			else{
				ocultarComponente(cmpIdMoneda);
				cmpIdMoneda.allowBlank=true;
				cmpIdMoneda.setValue('');
				ocultarComponente(cmpSwOec);
				cmpSwOec.allowBlank=true;
				cmpSwOec.setValue('');
				ocultarComponente(cmpSwAux);
				cmpSwAux.allowBlank=true;
				cmpSwAux.setValue('2');
				ocultarComponente(cmpCuentaSigma);
				cmpCuentaSigma.allowBlank=true;
				cmpCuentaSigma.setValue('');
				ocultarComponente(cmpSwSigma);
				cmpSwSigma.allowBlank=true;
				cmpSwSigma.setValue('');
				ocultarComponente(cmpIdCuentaActualizacion);
				cmpIdCuentaActualizacion.allowBlank=true;
				cmpIdCuentaActualizacion.setValue('');
				ocultarComponente(cmpIdAuxiliarActualizacion);
				cmpIdAuxiliarActualizacion.allowBlank=true;
				cmpIdAuxiliarActualizacion.setValue('');
				ocultarComponente(cmpSwSistemaActualizacion);
				cmpSwSistemaActualizacion.allowBlank=true;
				cmpSwSistemaActualizacion.setValue('');
				ocultarComponente(cmpIdCuentaDif);
				cmpIdCuentaDif.allowBlank=true;
				cmpIdCuentaDif.setValue('');
				ocultarComponente(cmpIdAuxiliarDif);
				cmpIdAuxiliarDif.allowBlank=true;
				cmpIdAuxiliarDif.setValue('');
				ocultarComponente(cmpCuentaFlujoSigma);
				cmpCuentaFlujoSigma.allowBlank=true;
				cmpCuentaFlujoSigma.setValue('');
				ocultarComponente(cmpNotaEeff);
				cmpNotaEeff.allowBlank=true;
				cmpNotaEeff.setValue('1');
				ocultarComponente(cmpIdCuentaSigma);
				cmpIdCuentaSigma.allowBlank=true;
				cmpIdCuentaSigma.setValue('');
			}
		};
		
		var treLoader=getLoader();
		Dialog=getDialog();
		
		///menu contextual principal
		var CtxMenuP=getCtxMenu();
		treLoader.on("beforeload", function(treeL,n){
			treeL.baseParams.nro_cuenta=n.attributes.nro_cuenta,
			treeL.baseParams.gestion=g_id_gestion
		}, this);
		cmpNombreRaiz.on('select',onNombreRaizSelect);
	    cmpNombreRaiz.on('change',onNombreRaizSelect);
	    cmpSwTransaccional.on('select',onSwTransaccionalSelect);
	    cmpSwTransaccional.on('change',onSwTransaccionalSelect)
	}
	
	//copiar y pegar
	this.btnEliminar=function(){
		var n=getSm().getSelectedNode();
		if(!n){
			Ext.MessageBox.alert('...','Primero seleccione una Cuenta.')
		}else{
			if(n.attributes.estado_gestion!=3){
				btnEliminar()
			}else{
				Ext.MessageBox.alert('...', 'No se puede eliminar cuentas debido a que la Gestión está Cerrada')
			}
		}
	};
	
	function sEdit(){
		cmpSwTransaccional.store.reload();
		cmpSwOec.store.reload();
		cmpNombreRaiz.store.reload();
		var n=getSm().getSelectedNode();
			cmpNroCuenta.fieldLabel= 'Número de Cuenta:';
			cmpNroCuenta.width = 150;
		if (n){
			if(n.attributes.estado_gestion!=3){
				ocultarComponente(cmpCuentaPadre);
				if(n.attributes.nivel_cuenta==1){
					cmpNroCuenta.disable();
					cmpNombreCuenta.disable();
					cmpIdParametro.disable();
					mostrarComponente(cmpIdParametro);
					ocultarComponente(cmpNombreRaiz);
					mostrarComponente(cmpNombreCuenta);
					mostrarComponente(cmpDescCuenta);
					ocultarComponente(cmpTipoCuenta);
					ocultarComponente(cmpNivelCuenta);
					ocultarComponente(cmpSwTransaccional);
					ocultarComponente(cmpIdMoneda);
					ocultarComponente(cmpSwOec);
					ocultarComponente(cmpNotaEeff);
					ocultarComponente(cmpIdCuentaSigma);
					btnEdit()
				}else{
					if(n.attributes.sw_transaccional==1){
						mostrarComponente(cmpIdMoneda);
						mostrarComponente(cmpSwOec)
						mostrarComponente(cmpSwAux);
						mostrarComponente(cmpCuentaSigma);
						mostrarComponente(cmpSwSigma);
						mostrarComponente(cmpIdCuentaActualizacion);
						mostrarComponente(cmpIdAuxiliarActualizacion);
						mostrarComponente(cmpSwSistemaActualizacion);
						mostrarComponente(cmpIdCuentaDif);
						mostrarComponente(cmpIdAuxiliarDif);
						mostrarComponente(cmpCuentaFlujoSigma);
						mostrarComponente(cmpNotaEeff);
						mostrarComponente(cmpIdCuentaSigma);
					}else{
						ocultarComponente(cmpIdMoneda);
						ocultarComponente(cmpSwOec)
						ocultarComponente(cmpSwAux);
						ocultarComponente(cmpCuentaSigma);
						ocultarComponente(cmpSwSigma);
						ocultarComponente(cmpIdCuentaActualizacion);
						ocultarComponente(cmpIdAuxiliarActualizacion);
						ocultarComponente(cmpSwSistemaActualizacion);
						ocultarComponente(cmpIdCuentaDif);
						ocultarComponente(cmpIdAuxiliarDif);
						ocultarComponente(cmpCuentaFlujoSigma);
						ocultarComponente(cmpNotaEeff);
						ocultarComponente(cmpIdCuentaSigma);
					}
					cmpNroCuenta.disable();
					cmpNombreCuenta.enable();
					cmpIdParametro.disable();
					ocultarComponente(cmpIdParametro);
					ocultarComponente(cmpNombreRaiz);
					mostrarComponente(cmpNombreCuenta);
					ocultarComponente(cmpTipoCuenta);
					ocultarComponente(cmpNivelCuenta);
					mostrarComponente(cmpSwTransaccional);
					btnEdit()
				}
			}else{
				Ext.MessageBox.alert('...', 'No se puede Modificar los datos de la Cuenta debido a que la Gestión está Cerrada')
				}
		}else{
			Ext.MessageBox.alert('...', 'Primero seleccione una Cuenta')
		}	
	};
	
	this.btnNew=function(){
		cmpSwTransaccional.store.reload();
		cmpSwOec.store.reload();		
		cmpNombreRaiz.store.reload();
		var n=getSm().getSelectedNode();
		if(n){
			if(n.attributes.estado_gestion!=3){
				if (n.attributes.sw_transaccional==2){
					if(n.attributes.dig_nivel){
						nodo={};
						nodo.id='null';
						nodo.id_p=n.id;
						cmpNroCuenta.fieldLabel= 'Nivel ' + parseInt(++n.attributes.nivel_cuenta) + ' de '+ n.attributes.dig_nivel + ' dígito(s):';
						cmpNroCuenta.width = 50;
						cmpNroCuenta.maxLength=n.attributes.dig_nivel;
						cmpNroCuenta.minLength=n.attributes.dig_nivel;
						mostrarComponente(cmpNombreCuenta);
						mostrarComponente(cmpCuentaPadre);
						ocultarComponente(cmpNombreRaiz);
						ocultarComponente(cmpTipoCuenta);
						ocultarComponente(cmpIdParametro);
						ocultarComponente(cmpIdMoneda);
						ocultarComponente(cmpSwOec);
						ocultarComponente(cmpNivelCuenta);
						ocultarComponente(cmpSwAux);
						ocultarComponente(cmpCuentaSigma);
						ocultarComponente(cmpSwSigma);
						ocultarComponente(cmpIdCuentaActualizacion);
						ocultarComponente(cmpIdAuxiliarActualizacion);
						ocultarComponente(cmpSwSistemaActualizacion);
						ocultarComponente(cmpIdCuentaDif);
						ocultarComponente(cmpIdAuxiliarDif);
						ocultarComponente(cmpCuentaFlujoSigma);
						ocultarComponente(cmpNotaEeff);
						ocultarComponente(cmpIdCuentaSigma);
						mostrarComponente(cmpSwTransaccional);
						cmpNroCuenta.enable();
						cmpCuentaPadre.disable();
						setValuesBasicos(nodo,'add');
						getFormulario().reset();
						Dialog.show();
						cmpCuentaPadre.setValue(n.attributes.nro_cuenta+" - "+n.attributes.nombre_cuenta);
					}else{
						Ext.MessageBox.alert('...','No se pueden crear más cuentas debido a que se llego al Nivel Máximo.')
					}
				}else{
					Ext.MessageBox.alert('...','La Cuenta es de Movimiento y no puede tener cuentas dependientes.')
				}
			}else{
				Ext.MessageBox.alert('...','No se puede crear cuentas debido a que la Gestión está Cerrada.')
			}
		}else{
			Ext.MessageBox.alert('...', 'Primero seleccione una Cuenta')
		}
	};
	
	this.btnNewRaiz=function(){
		cmpSwTransaccional.store.reload();
		cmpNombreRaiz.store.reload();
		nodo={};
		nodo.id='null';
		nodo.id_p='null';
		ocultarComponente(cmpNombreCuenta);
		ocultarComponente(cmpTipoCuenta);
		ocultarComponente(cmpNivelCuenta);
		ocultarComponente(cmpSwTransaccional);
		ocultarComponente(cmpIdMoneda);
		ocultarComponente(cmpSwOec);
		ocultarComponente(cmpCuentaPadre);
		mostrarComponente(cmpNombreRaiz);
		mostrarComponente(cmpDescCuenta);
		mostrarComponente(cmpIdParametro);
		cmpNroCuenta.disable();
		cmpIdParametro.enable();
		setValuesBasicos(nodo,'add');
		getFormulario().reset();
		Dialog.show();
		btnNewRaiz();
	};
		
	function fallaDropItem(resp,b,c){
		conexionFailure(resp,b,c)
	}	
	
	function guardarSuccessSc(r){
		var np=getSm().getSelectedNode();
		guardarSuccess(r);
		if(r.argument.proc=='upd'){
			var n=np.parentNode;
			np.setText(np.attributes.nro_cuenta+" - "+np.attributes.nombre_cuenta);
			n.reload()
		}else{
			if(np){
				var n=np.lastChild;
				if(n){
					var aux=cmpNroCuenta.getValue();
					n.setText(aux+" - "+cmpNombreCuenta.getValue());
					np.reload()
				}
			}else{
				btnActualizar()
			}
		}
	}
	
	function terSuccess(resp){
		var regreso=Ext.util.JSON.decode(resp.responseText)
		if(regreso.success=='true'){
			Ext.MessageBox.hide();
			resp.argument.nodo.parentNode.reload()
		}
	}
	
	this.getLayout=function(){
		return layout_cuenta_arb.getLayout()
	};
	
	function btn_cuenta_auxiliar(){
		var n = getSm().getSelectedNode();
		if(!n || n.attributes.sw_transaccional==2){
			Ext.MessageBox.alert('...', 'Seleccione una Cuenta de Movimiento')
		}else{
			var data='maestro_id_padre='+n.attributes.id_p;
			data=data+'&maestro_id_cuenta='+n.attributes.id;
			data=data+'&maestro_nombre_cuenta='+n.attributes.nombre_cuenta;
			data=data+'&maestro_nro_cuenta='+n.attributes.nro_cuenta;
			data=data+'&maestro_estado_gestion='+n.attributes.estado_gestion;
			var Param={Ventana:{width:'50%',height:'60%'}};
			var ven=layout_cuenta_arb.loadWindows(direccion+'../../../vista/cuenta_auxiliar/cuenta_auxiliar_det.php?'+data,'Auxiliar de Cuentas',Param,idContenedor)
		}
	}
	
	function btn_plan_cuenta(){
		var data='id_gestion='+g_id_gestion;
		data=data+'&sw_rep=1';
		//alert (g_id_gestion);
		//window.open(direccion+'../../../control/cuenta/reporte/ActionPDFListaCuentasArbol.php?'+data)
		window.open(direccion+'../../../control/cuenta/reporte/ActionPDFPlanCtaJasper.php?'+data)
	}
	
	function btn_plan_cuenta_auxiliar(){
		var data='id_gestion='+g_id_gestion;
		data=data+'&sw_rep=2';
		//window.open(direccion+'../../../control/cuenta/reporte/ActionPDFListaCuentasArbolAuxiliar.php?'+data)
		window.open(direccion+'../../../control/cuenta/reporte/ActionPDFPlanCtaJasper.php?'+data)
	}

	function btn_plan_cuenta_sigma(){
		var data='id_gestion='+g_id_gestion;
		data=data+'&sw_rep=3';
		window.open(direccion+'../../../control/cuenta/reporte/ActionPDFPlanCtaJasper.php?'+data)
	}
	
	var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/gestion/ActionListarGestion.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_gestion',totalRecords:'TotalCount'},['id_gestion','gestion','estado_ges_gral','id_empresa','desc_empresa','id_moneda_base','desc_moneda'])}); 
	var tpl_gestion=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','</div>');

	var gestion =new Ext.form.ComboBox({
		store: ds_gestion,
		displayField:'gestion',
		typeAhead: true,
		mode: 'remote',
		triggerAction: 'all',
		emptyText:'gestion...',
		selectOnFocus:true,
		width:100,
		valueField: 'id_gestion',
		tpl:tpl_gestion
	});

	gestion.on('select',function (combo, record, index){
		g_id_gestion=gestion.getValue();
		ds_parametro.load({
			params:{
				start:0,
				limit: paramConfig.TamanoPagina,
				CantFiltros:paramConfig.CantFiltros,
				m_id_gestion:g_id_gestion,
				m_sw_cuenta_ejercicio:'si'
			}
		});
		ds_cuenta.baseParams={
			m_id_gestion:g_id_gestion,
			sw_transaccional:1
		}
		btnActualizar()	
	});
	
	this.InitFunciones(paramFunciones);
	this.InitBarraMenu(paramMenu);
	this.AdicionarBotonCombo(gestion,'gestion');	
	this.AdicionarBoton('../../../lib/imagenes/report.png','Auxiliar de Cuentas',btn_cuenta_auxiliar,true,'cuenta_auxiliar','Auxiliar de Cuenta');
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte del Plan de Cuentas',btn_plan_cuenta,true,'plan de cuenta','Plan');
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte del Plan de Cuentas y Auxiliares',btn_plan_cuenta_auxiliar,true,'plan de cuenta y auxiliar','Auxiliar');
	this.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte del Plan de Cuentas y SIGMA',btn_plan_cuenta_sigma,true,'plan de cuenta y auxiliar','Sigma');
	this.Init(); //iniciamos la clase madre
	this.iniciaFormulario();
	iniciarEventos()
}