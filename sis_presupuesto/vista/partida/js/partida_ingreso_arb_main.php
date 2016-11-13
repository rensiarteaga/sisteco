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
var elemento={pagina:new pagina_partida_ingreso_arb(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

function pagina_partida_ingreso_arb(idContenedor,direccion,paramConfig){
	var Atributos=[];
	var ds_parametro;
	var layout_partida_ingreso_arb;
	var cmpCodigoPartida,cmpNombrePartida;
	var	cmpDescPartida,cmpNivelPartida;
	var	cmpSwTransaccional,cmpTipoPartida;
	var	cmpIdParametro,cmpTipoMemoria,cmpSwMovimiento;
	var cmpIdConceptoColectivo,cmpCodigoPadre;
	var g_id_gestion='';
	var Dialog;
	var copiados;
	
	var ds_parametro=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/parametro/ActionListarParametro.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro',totalRecords:'TotalCount'},['id_parametro','gestion_pres','estado_gral','cod_institucional','porcentaje_sobregiro','cantidad_niveles'])
	});
	var ds_concepto_colectivo=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/concepto_colectivo/ActionListarPresupuestoColectivo.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_concepto_colectivo',totalRecords:'TotalCount'},['id_concepto_colectivo','desc_colectivo'])
	});
	var ds_oec=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_sigma/control/declaracion/ActionListarOec.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_oec',totalRecords:'TotalCount'},['id_oec','codigo_oec','desc_oec','sigla_oec'])
	});
	
	var resultTplParametro=new Ext.Template('<div class="search-item">','<b><i>{gestion_pres}</i></b>','<br><FONT COLOR="#B5A642"><b>Cantidad Niveles: </b>{cantidad_niveles}</FONT>','</div>');
	
	var tpl_id_oec=new Ext.Template('<div class="search-item">','<b><i>{codigo_oec}</i></b>','<br><FONT COLOR="#B5A642">{desc_oec}</FONT>','</div>');
	
	Atributos[0]={
		validacion:{
			name:'codigo_padre',
			fieldLabel:'Depende de:',
			allowBlank:true,
			width:'100%',
			maxLength:75,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto'
		},
		tipo:'TextField'
		};
	Atributos[1]={
		validacion:{
			name:'codigo_partida',
			fieldLabel:'Código de Partida',
			allowBlank:true,
			width:50,
			selectOnFocus:true,
			vtype:'texto'
		},
		tipo:'TextField'
		};
	Atributos[2]={
		validacion:{
			name:'nombre_partida',
			fieldLabel:'Nombre de Partida',
			allowBlank:false,
			width:300,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto'
		},
		tipo:'TextField'
		};
	Atributos[3]={
		validacion:{
			name:'desc_partida',
			fieldLabel:'Descripción',
			allowBlank:false,
			width:300,
			maxLength:1000,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto'
			},
		tipo:'TextArea'
		};
	Atributos[4]={
		validacion:{
			name:'nivel_partida',
			fieldLabel:'Nivel',
			allowBlank:true,
			maxLength:10,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto'
		},
		tipo:'TextField'
		};		
	Atributos[5]={
		validacion:{
			name:'sw_transaccional',
			fieldLabel:'Tipo de Partida',
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Movimiento'],['2','Titular']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			width:150
		},
		tipo:'ComboBox',
		defecto:'Titular'
		};
	Atributos[6]={
		validacion:{
			name:'sw_movimiento',
			fieldLabel:'Tipo de Movimiento',
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Presupuesto'],['2','Flujo']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			width:150
		},
		tipo:'ComboBox',
		defecto:'Presupuesto'
		};	
	Atributos[7]={
		validacion:{
			name:'tipo_partida',
			fieldLabel:'Partida',
			allowBlank:true,
			maxLength:1,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto'
		},
		tipo:'TextField'
		};
	Atributos[8]={
		validacion:{
			name:'id_parametro',
			fieldLabel:'Parámetro',
			allowBlank:true,
			emptyText:'Parametro ...',
			store:ds_parametro,
			desc:'gestion_pres',
			valueField:'id_parametro',
			displayField:'gestion_pres',
			filterCol:'PARAMP.gestion_pres',
			typeAhead:true,
			forceSelection:false,
			tpl:resultTplParametro,
			mode:'remote',
			queryDelay:50,
			pageSize:5,
			minListWidth:230,
			resizable:true,
			minChars:1,
			triggerAction:'all',
		},
		tipo:'ComboBox'
		};
	Atributos[9]={
		validacion:{
			name:'tipo_memoria',
			fieldLabel:'Memoria de Cálculo',
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Recurso']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			width:150
		},
		tipo:'ComboBox'
		};
	Atributos[10]={
		validacion:{
			name:'id_concepto_colectivo',
			fieldLabel:'Presupuesto Colectivo',
			emptyText:'Colectivo ...',
			store:ds_concepto_colectivo,
			allowBlank:true,
			desc:'desc_colectivo',
			valueField:'id_concepto_colectivo',
			displayField:'desc_colectivo',
			filterCol:'CONCOL.desc_colectivo',
			typeAhead:true,
			forceSelection:false,
			//tpl:resultTplParametro,
			mode:'remote',
			queryDelay:50,
			pageSize:20,
			width:150,
			minListWidth:130,
			resizable:true,
			minChars:1,
			triggerAction:'all'
		},
		tipo:'ComboBox'
		};
	Atributos[11]={
		validacion:{
			name:'id_oec_sigma',
			fieldLabel:'OEC Sigma',
			emptyText:'OEC ...',
			store:ds_oec,
			allowBlank:false,
			desc:'desc_oec',
			valueField:'id_oec',
			displayField:'desc_oec',
			queryParam: 'filterValue_0',
			filterCol:'OEC.codigo_oec#OEC.sigla_oec#OEC.desc_oec',
			typeAhead:false,
			forceSelection:false,
			tpl:tpl_id_oec,
			mode:'remote',
			queryDelay:50,
			pageSize:10,
			width:300,
			minListWidth:130,
			resizable:true,
			minChars:1,
			triggerAction:'all'
		},
		tipo:'ComboBox'
		};
		
	Atributos[12]={
		validacion:{
			name:'ent_trf',
			fieldLabel:'Entidad Transferencia',
			allowBlank:false,
			width:150,
			maxLength:4,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false
			//vtype:'texto'
		},
		tipo:'NumberField'
		};
	
	Atributos[13]={
		validacion:{
			name:'cod_ascii',
			fieldLabel:'Declara SIGMA',
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['si','Si declara'],['no','No declara']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			width:150
		},
		tipo:'ComboBox'
	};
		
	Atributos[14]={
		validacion:{
			name:'cod_excel',
			fieldLabel:'Pasajes',
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['si','Si - Pasajes'],['no','No - Otros']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			width:150
		},
		tipo:'ComboBox'
		};
	
	Atributos[15]={
		validacion:{
			name:'cod_trans',
			fieldLabel:'Finalidad',
			allowBlank:false,
			width:150,
			maxLength:4,
			minLength:0,
			selectOnFocus:true,
			allowDecimals:false
			//vtype:'texto'
		},
		tipo:'NumberField'
		};

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
	var config={titulo:'Clasificador Presupuestario'};
	layout_partida_ingreso_arb=new DocsLayoutArb(idContenedor);
	layout_partida_ingreso_arb.init(config);
	
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=PaginaArb;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,layout_partida_ingreso_arb,idContenedor,DatosNodo,DatosDefecto);
	
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
		Basicas:{url:direccion+'../../../../sis_presupuesto/control/partida/ActionGuardarPartidaArb.php',add_success:guardarSuccessSc,edit:sEdit},
		Formulario:{height:500,width:490,minWidth:150,minHeight:200,closable:true,titulo:'Clasificador Presupuestario'},
		Listar:{url:direccion+'../../../../sis_presupuesto/control/partida/ActionListarPartidaIngresoArb.php',raiz:'agrupador',baseParams:{},clearOnLoad:true,enableDD:true}
	};

	// parametros del menu //
	var paramMenu={
		nuevoRaiz:{crear:true,separador:false,tip:'Nuevo Clasificador',img:'tuc+.png'},
		nuevo:{crear:true,separador:false,tip:'Nueva Partida',img:'raiz+.png'},
		editar:{crear:true,separador:false,tip:'Editar',img:'etucr.png'},
		eliminar:{crear:true,separador:false,tip:'Eliminar',img:'tucr-.png'},
		actualizar:{crear:true,separador:false}
	};
	function isReorder(e, n){
		return n.parentNode == e.target.parentNode && e.point != 'append'
	}
	function iniciarEventos(){
		cmpCodigoPartida=getComponente('codigo_partida');
		cmpNombrePartida=getComponente('nombre_partida');
		cmpDescPartida=getComponente('desc_partida');
		cmpNivelPartida=getComponente('nivel_partida');
		cmpSwTransaccional=getComponente('sw_transaccional');
		cmpSwMovimiento=getComponente('sw_movimiento');
		cmpTipoPartida=getComponente('tipo_partida');
		cmpIdParametro=getComponente('id_parametro');
		cmpTipoMemoria=getComponente('tipo_memoria');
		cmpCodigoPadre=getComponente('codigo_padre');
		cmpIdConceptoColectivo=getComponente('id_concepto_colectivo');
		cmpIdOec=getComponente('id_oec_sigma');
		cmpEntTrf=getComponente('ent_trf');
		cmpCodAscii=getComponente('cod_ascii');
		cmpCodExcel=getComponente('cod_excel');
		
		var onSwTransaccionalSelect=function(e){
			var id=cmpSwTransaccional.getValue()
			if(id==1){
				mostrarComponente(cmpTipoMemoria);
				mostrarComponente(cmpIdConceptoColectivo);
				mostrarComponente(cmpIdOec);
				mostrarComponente(cmpEntTrf);
				mostrarComponente(cmpCodExcel);
				
				cmpTipoMemoria.allowBlank=false;
				cmpIdConceptoColectivo.allowBlank=true;
				cmpEntTrf.allowBlank=true;
				cmpCodAscii.allowBlank=true;
				cmpCodExcel.allowBlank=true;
				
				cmpTipoMemoria.setValue('');
				cmpIdConceptoColectivo.setValue('')
			}else{
				ocultarComponente(cmpTipoMemoria);
				ocultarComponente(cmpIdConceptoColectivo);
				ocultarComponente(cmpIdOec);
				ocultarComponente(cmpEntTrf);
				ocultarComponente(cmpCodExcel);
				
				cmpTipoMemoria.allowBlank=true;
				cmpIdConceptoColectivo.allowBlank=true;
				cmpEntTrf.allowBlank=true;
				cmpCodAscii.allowBlank=true;
				cmpCodExcel.allowBlank=true;
				
				cmpTipoMemoria.setValue('');
				cmpIdConceptoColectivo.setValue('')
			}
		};
		var treLoader=getLoader();
		Dialog=getDialog();
		
		///menu contextual principal
		var CtxMenuP=getCtxMenu();
		treLoader.on("beforeload",function(treeL,n){
			treeL.baseParams.codigo_partida=n.attributes.codigo_partida,
			treeL.baseParams.gestion=g_id_gestion
		}, this)
		cmpSwTransaccional.on('select',onSwTransaccionalSelect);
		cmpSwTransaccional.on('change',onSwTransaccionalSelect);
	}
	
	//copiar y pegar
	this.btnEliminar=function(){
		var n=getSm().getSelectedNode();
		if(!n){
			Ext.MessageBox.alert('...','Antes debe seleccionar una partida.');
		}
		else{
			if(n.attributes.estado_gral==0 || n.attributes.estado_gral==1){
				btnEliminar()
			}
			else{
				Ext.MessageBox.alert('...','Para eliminar la Partida, el estado de la Gestión debe ser de Formulación o Revisión.');
			}
		}
	};
	
	function sEdit(){
		var n=getSm().getSelectedNode();
		cmpCodigoPartida.fieldLabel= 'Código de Partida:';
		if (n){
		   if(n.attributes.estado_gral==0 || n.attributes.estado_gral==1){
	          ocultarComponente(cmpCodigoPadre);
		   	  if(n.attributes.nivel_partida==0){
				ocultarComponente(cmpCodigoPartida);
				ocultarComponente(cmpNivelPartida);
				ocultarComponente(cmpTipoPartida);
				ocultarComponente(cmpSwMovimiento);
				ocultarComponente(cmpTipoMemoria);
				ocultarComponente(cmpSwTransaccional);
				mostrarComponente(cmpIdParametro);
				ocultarComponente(cmpIdConceptoColectivo);
				cmpIdParametro.disable();
				ocultarComponente(cmpIdOec);
			    ocultarComponente(cmpEntTrf);
			    ocultarComponente(cmpCodAscii);
				ocultarComponente(cmpCodExcel);
				btnEdit()
			}else{
				if(n.attributes.sw_transaccional==1){
				   cmpTipoMemoria.allowBlank=false;
				   cmpIdConceptoColectivo.allowBlank=true;	
				   mostrarComponente(cmpTipoMemoria);
				   mostrarComponente(cmpIdConceptoColectivo)
				   mostrarComponente(cmpIdOec)
				   mostrarComponente(cmpEntTrf)
				   mostrarComponente(cmpCodAscii)
				   mostrarComponente(cmpCodExcel)
				}else{
					cmpTipoMemoria.allowBlank=true;
					cmpIdConceptoColectivo.allowBlank=true;
					ocultarComponente(cmpTipoMemoria);
					ocultarComponente(cmpIdConceptoColectivo)
					ocultarComponente(cmpIdOec)
				    ocultarComponente(cmpEntTrf)
				    ocultarComponente(cmpCodExcel)
				}
				mostrarComponente(cmpCodigoPartida);
				ocultarComponente(cmpNivelPartida);
				ocultarComponente(cmpTipoPartida);
				ocultarComponente(cmpIdParametro);
				mostrarComponente(cmpSwTransaccional);
				cmpCodigoPartida.disable();
				btnEdit()
			}
		   }
		    else{
		   	    Ext.MessageBox.alert('...','Para modificar los datos de la Partida, el estado de la Gestión debe ser de Formulación o Revisión.');
		   }
		}
		else{
			Ext.MessageBox.alert('...','Antes debe seleccionar una partida.');
		}	
	};
	
	this.btnNew=function(){
		var n=getSm().getSelectedNode();
		if(n){
			if(n.attributes.estado_gral==0 || n.attributes.estado_gral==1){
				if (n.attributes.sw_transaccional==2){
					if(n.attributes.dig_nivel){
						nodo={};
						nodo.id='null';
						nodo.id_p=n.id;	
						cmpCodigoPartida.maxLength=n.attributes.dig_nivel;
						cmpCodigoPartida.minLength=n.attributes.dig_nivel;
						cmpCodigoPartida.fieldLabel= 'Nivel ' + parseInt(++n.attributes.nivel_partida) + ' de '+ n.attributes.dig_nivel + ' dígito(s):';
						mostrarComponente(cmpCodigoPartida);
						mostrarComponente(cmpCodigoPadre);
						ocultarComponente(cmpNivelPartida);
						ocultarComponente(cmpTipoPartida);
						ocultarComponente(cmpIdParametro);
						mostrarComponente(cmpSwMovimiento);
						ocultarComponente(cmpTipoMemoria);
						mostrarComponente(cmpSwTransaccional);
						ocultarComponente(cmpIdConceptoColectivo);
						cmpCodigoPartida.enable();
						cmpCodigoPadre.disable();
						var tipo_partida=cmpSwTransaccional.getValue();
						if(tipo_partida==1){
							nodo.tipo='Movimiento'				
						}else{
							nodo.tipo='Titular'
						}
						setValuesBasicos(nodo,'add');
						getFormulario().reset();
						Dialog.show();
						cmpCodigoPadre.setValue(n.attributes.codigo_partida+" - "+n.attributes.nombre_partida)
					}else{
						Ext.MessageBox.alert('...','No se pueden adicionar más partidas debido a que se llego al Nivel Máximo.');
					}
				}else{
					Ext.MessageBox.alert('...','La Partida es de Movimiento y no puede tener partidas dependientes.');
				}
			}else{
				Ext.MessageBox.alert('...','Para adicionar partidas, el estado de la Gestión debe ser de Formulación o Revisión.');
			}
		}else{
			Ext.MessageBox.alert('...','Antes debe seleccionar una partida.');
		}
	};
	
	this.btnNewRaiz=function(){
		ocultarComponente(cmpSwTransaccional);
		ocultarComponente(cmpNivelPartida);
		ocultarComponente(cmpCodigoPartida);
		ocultarComponente(cmpTipoPartida);
		ocultarComponente(cmpSwMovimiento);
		ocultarComponente(cmpTipoMemoria);
		mostrarComponente(cmpIdParametro);
		ocultarComponente(cmpIdConceptoColectivo);
		ocultarComponente(cmpCodigoPadre);
		cmpIdParametro.enable();   
		nodo={};
		nodo.id='null';
		nodo.id_p='null';
		setValuesBasicos(nodo,'add');
		getFormulario().reset();
		Dialog.show();
		btnNewRaiz();
		cmpTipoPartida.setValue('1')
	};
		
	function fallaDropItem(resp,b,c){
		conexionFailure(resp,b,c)
	}
	
	function btn_concepto_ingas(){
		var n=getSm().getSelectedNode();
	   if(!n || n.attributes.nivel_partida==0){
			Ext.MessageBox.alert('Estado','Seleccione una partida de tipo Movimiento.')
		}else{
			if(n&&n.attributes.sw_transaccional==2){
				Ext.MessageBox.alert('Estado','Debe seleccionar una partida de tipo Movimiento.')
		    }else{
				var data='m_id_partida='+n.attributes.id;
				data=data+'&m_codigo_partida='+n.attributes.codigo_partida;
				data=data+'&m_nombre_partida='+n.attributes.nombre_partida;
				data=data+'&m_nivel_partida='+n.attributes.nivel_partida;
				data=data+'&m_tipo_partida='+n.attributes.tipo_partida;
				data=data+'&m_estado_gral='+n.attributes.estado_gral;
				var Param={Ventana:{width:'50%',height:'60%'}};
				var ven=layout_partida_ingreso_arb.loadWindows(direccion+'../../../../sis_presupuesto/vista/concepto_ingas/concepto_ingas_ingreso.php?'+data,'Conceptos de Ingreso',Param)
		    }
		}		
	}
	
	function guardarSuccessSc(r){
		var np=getSm().getSelectedNode();
		guardarSuccess(r);
		if(r.argument.proc=='upd'){
			var n=np.parentNode;
			np.setText(np.attributes.codigo_partida+" - "+np.attributes.nombre_partida);
			n.reload()
		}else{			
			if(np){			
				var n=np.lastChild;
		    	if(n){		    
		   			var aux=cmpCodigoPartida.getValue();
					n.setText(aux+" - "+cmpNombrePartida.getValue());
					np.reload()					
				}
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
		return layout_partida_ingreso_arb.getLayout()
	};
	
	var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/gestion/ActionListarGestion.php'}),
		reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_gestion',totalRecords:'TotalCount'},['id_gestion','gestion','estado_ges_gral','id_empresa','desc_empresa','id_moneda_base','desc_moneda'])}); 
    
	var tpl_gestion=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','</div>');
    
    var gestion =new Ext.form.ComboBox({
		store:ds_gestion,
		displayField:'gestion',
		typeAhead:true,
		mode:'remote',
		triggerAction:'all',
		emptyText:'gestion...',
		selectOnFocus:true,
		width:100,
		valueField:'id_gestion',
		tpl:tpl_gestion
	});
	gestion.on('select',function (combo, record, index){g_id_gestion=gestion.getValue();
       ds_parametro.load({
    	   params:{
		    start:0,
		    limit: paramConfig.TamanoPagina,
		    CantFiltros:paramConfig.CantFiltros,
		    m_id_gestion:g_id_gestion
	        }
       });
       btnActualizar()	
    });
	
	this.InitFunciones(paramFunciones);
	this.InitBarraMenu(paramMenu);
	this.Init(); //iniciamos la clase madre
	this.iniciaFormulario();
	this.AdicionarBotonCombo(gestion,'gestion');
	this.AdicionarBoton('../../../lib/imagenes/list-items.gif','Conceptos de Ingreso',btn_concepto_ingas,true,'concepto_in','Conceptos de Ingreso');
	iniciarEventos()
}