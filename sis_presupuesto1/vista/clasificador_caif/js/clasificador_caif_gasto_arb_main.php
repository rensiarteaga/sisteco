<?php 
/**
 * Nombre:		  	    clasificador_caif_main.php
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
var elemento={pagina:new pagina_clasificador_caif_arb(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);

function pagina_clasificador_caif_arb(idContenedor,direccion,paramConfig){
	var Atributos=[];
	var ds_parametro;
	var layout_clasificador_caif_arb;
	var cmpCodigoclasificador_caif,cmpNombreclasificador_caif;
	var	cmpDescclasificador_caif,cmpNivelclasificador_caif;
	var	cmpSwTransaccional,cmpTipoclasificador_caif;
	var	cmpIdParametro,cmpTipoMemoria,cmpSwMovimiento;
	var cmpIdConceptoColectivo,cmpCodigoPadre;
	var g_id_gestion='';
	var Dialog;
	var copiados;
	
	var ds_parametro=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/parametro/ActionListarParametro.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro',totalRecords:'TotalCount'},['id_parametro','gestion_pres','estado_gral','cod_institucional','porcentaje_sobregiro','cantidad_niveles'])
	});
	/*var ds_concepto_colectivo=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/concepto_colectivo/ActionListarPresupuestoColectivo.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_concepto_colectivo',totalRecords:'TotalCount'},['id_concepto_colectivo','desc_colectivo'])
	});
	var ds_oec=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../../sis_sigma/control/declaracion/ActionListarOec.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_oec',totalRecords:'TotalCount'},['id_oec','codigo_oec','desc_oec','sigla_oec'])
	});
	*/
	var resultTplParametro=new Ext.Template('<div class="search-item">','<b><i>{gestion_pres}</i></b>','<br><FONT COLOR="#B5A642"><b>Cantidad Niveles: </b>{cantidad_niveles}</FONT>','</div>');
	
//	var tpl_id_oec=new Ext.Template('<div class="search-item">','<b><i>{codigo_oec}</i></b>','<br><FONT COLOR="#B5A642">{desc_oec}</FONT>','</div>');
	
	Atributos[0]={
		validacion:{
			name:'codigo_padre',
			fieldLabel:'Depende de:',
			allowBlank:true,
			width:'100%',
			maxLength:120,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto'
		},
		tipo:'TextField'
	};
	
	Atributos[1]={
		validacion:{
			name:'codigo_caif',
			fieldLabel:'Código CAIF',
			allowBlank:true,
			width:50,
		    selectOnFocus:true,
			vtype:'texto'
		},
		tipo:'TextField'
	};	
	
	Atributos[2]={
		validacion:{
			name:'nombre_caif',
			fieldLabel:'Nombre CAIF',
			allowBlank:false,
			width:'100%',
			maxLength:150,
			minLength:0,
			selectOnFocus:true
			//vtype:'texto'
		},
		tipo:'TextField'
	};
	
	Atributos[3]={
		validacion:{
			name:'desc_caif',
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
	
	Atributos[4]={
		validacion:{
			name:'nivel_caif',
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
			fieldLabel:'Tipo de CAIF',
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
	
	
	/*Atributos[6]={
		validacion:{
			name:'tipo_caif',
			fieldLabel:'tipo_caif',
			allowBlank:true,
			maxLength:1,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto'
		},
		tipo:'TextField'
	};*/
	
	/*Atributos[7]={
		validacion:{
			name:'id_parametro',
			fieldLabel:'Parámetro',
			emptyText:'Parametro ...',
			store:ds_parametro,
			allowBlank:true,
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
			width:100,
			minListWidth:130,
			resizable:true,
			minChars:1,
			triggerAction:'all'
		},
		tipo:'ComboBox'
	};*/
	// txt_estado_reg
		
	/*	
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
	*/
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
	var config={titulo:'Clasificador CAIF'};
	layout_clasificador_caif_arb=new DocsLayoutArb(idContenedor);
	layout_clasificador_caif_arb.init(config);
	
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=PaginaArb;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,layout_clasificador_caif_arb,idContenedor,DatosNodo,DatosDefecto);
	
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
		//Basicas:{url:direccion+'../../../../sis_presupuesto/control/clasificador_caif/ActionGuardarCaifArb.php',add_success:guardarSuccessSc,edit:sEdit},
	    Basicas:{url:direccion+'../../../../sis_presupuesto/control/clasificador_caif/ActionGuardarCaifArb.php'},
		Formulario:{height:500,width:490,minWidth:150,minHeight:200,closable:true,titulo:'Clasificador CAIF'},
		Listar:{url:direccion+'../../../../sis_presupuesto/control/clasificador_caif/ActionListarCaifArb.php',raiz:'agrupador',baseParams:{},clearOnLoad:true,enableDD:false}
	};

	// parametros del menu //
	var paramMenu={
		nuevoRaiz:{crear:true,separador:false,tip:'Nuevo Clasificador',img:'tuc+.png'},
		nuevo:{crear:true,separador:false,tip:'Nueva Caif',img:'raiz+.png'},
		editar:{crear:true,separador:false,tip:'Editar',img:'etucr.png'},
		eliminar:{crear:true,separador:false,tip:'Eliminar',img:'tucr-.png'},
		actualizar:{crear:true,separador:false}
	};
	function isReorder(e, n){
		return n.parentNode == e.target.parentNode && e.point != 'append'
	}
	function iniciarEventos(){
		cmpCodigoclasificador_caif=getComponente('codigo_caif');
		cmpNombreclasificador_caif=getComponente('nombre_caif');
		cmpDescclasificador_caif=getComponente('desc_caif');
		cmpNivelclasificador_caif=getComponente('nivel_caif');
		cmpSwTransaccional=getComponente('sw_transaccional');
		//cmpSwMovimiento=getComponente('sw_movimiento');
		//cmpTipoclasificador_caif=getComponente('tipo_clasificador_caif');
		cmpIdParametro=getComponente('id_parametro');		
		//cmpTipoMemoria=getComponente('tipo_memoria');
		cmpCodigoPadre=getComponente('codigo_padre');
		/*cmpIdConceptoColectivo=getComponente('id_concepto_colectivo');
		cmpIdOec=getComponente('id_oec_sigma');
		cmpEntTrf=getComponente('ent_trf');
		cmpCodAscii=getComponente('cod_ascii');
		cmpCodExcel=getComponente('cod_excel');*/
		
		/*var onSwTransaccionalSelect=function(e)
		{
			var id=cmpSwTransaccional.getValue()
			if(id==1){
				mostrarComponente(cmpTipoMemoria);
				mostrarComponente(cmpIdConceptoColectivo);
				mostrarComponente(cmpIdOec);
				mostrarComponente(cmpEntTrf);
				mostrarComponente(cmpCodExcel);
				
				cmpTipoMemoria.allowBlank=false;
				cmpIdConceptoColectivo.allowBlank=true;
				cmpIdOec.allowBlank=true;
				cmpEntTrf.allowBlank=true;
				cmpCodAscii.allowBlank=true;
				cmpCodExcel.allowBlank=true;
				
				cmpTipoMemoria.setValue('');
				cmpIdConceptoColectivo.setValue('');
			}else{
				ocultarComponente(cmpTipoMemoria);
				ocultarComponente(cmpIdConceptoColectivo);
				ocultarComponente(cmpIdOec);
				ocultarComponente(cmpEntTrf);
				ocultarComponente(cmpCodExcel);
				
				cmpTipoMemoria.allowBlank=true;
				cmpIdConceptoColectivo.allowBlank=true;
				cmpIdOec.allowBlank=true;
				cmpEntTrf.allowBlank=true;
				cmpCodAscii.allowBlank=true;
				cmpCodExcel.allowBlank=true;
				
				cmpTipoMemoria.setValue('');
				cmpIdConceptoColectivo.setValue('')
			}
		};*/
		var treLoader=getLoader();
		Dialog=getDialog();
		
		///menu contextual principal
		var CtxMenuP=getCtxMenu();
		treLoader.on("beforeload", function(treeL,n){
			treeL.baseParams.codigo_caif=n.attributes.codigo_caif,
			treeL.baseParams.gestion=g_id_gestion
		}, this);
		//cmpSwTransaccional.on('select',onSwTransaccionalSelect);
		//cmpSwTransaccional.on('change',onSwTransaccionalSelect)
	}
	
	//copiar y pegar
	this.btnEliminar=function(){
		var n=getSm().getSelectedNode();
		if(!n){
			Ext.MessageBox.alert('...','Antes debe seleccionar una clasificador_caif.');
		}
		else{
			if(n.attributes.estado_gral==0 || n.attributes.estado_gral==1){
				btnEliminar()
			}
			else{
				Ext.MessageBox.alert('...','Para eliminar el caif, el estado de la Gestión debe ser de Formulación o Revisión.');
			}
		}
	};
	
	function sEdit(){
		var n=getSm().getSelectedNode();
		cmpCodigoclasificador_caif.fieldLabel= 'Código Caif:';
		if (n){
			if(n.attributes.estado_gral==0 || n.attributes.estado_gral==1){
				ocultarComponente(cmpCodigoPadre);
				if(n.attributes.nivel_caif==0){
				    ocultarComponente(cmpCodigoCaif);			    
				    ocultarComponente(cmpNivelCaif);
				    ocultarComponente(cmpTipoCaif);
				    //ocultarComponente(cmpSwMovimiento);
				    //ocultarComponente(cmpTipoMemoria);
				    ocultarComponente(cmpSwTransaccional);
				    mostrarComponente(cmpIdParametro);
				    //ocultarComponente(cmpIdConceptoColectivo);
				    cmpIdParametro.disable();
				    //ocultarComponente(cmpIdOec);
				    //ocultarComponente(cmpEntTrf);
				    //ocultarComponente(cmpCodAscii);
					//ocultarComponente(cmpCodExcel);
				    btnEdit()
			    }else{
			    	
				   mostrarComponente(cmpCodigoCaif);
				   ocultarComponente(cmpNivelCaif);
				   ocultarComponente(cmpTipoCaif);
				   ocultarComponente(cmpIdParametro);
				   mostrarComponente(cmpSwTransaccional);
				   cmpCodigoCaif.disable();
				   btnEdit()
			      }
			}else{
		   	    Ext.MessageBox.alert('...','Para modificar los datos de la clasificador_caif, el estado de la Gestión debe ser de Formulación o Revisión.');
		   }
		}else{
			Ext.MessageBox.alert('...','Antes debe seleccionar una clasificador_caif.');
		}	
	};
	
	/*this.btnNew=function(){
		var n=getSm().getSelectedNode();
		if(n){
			if(n.attributes.estado_gral==0 || n.attributes.estado_gral==1){
				if (n.attributes.sw_transaccional==2){
					if(n.attributes.dig_nivel){
						nodo={};
						nodo.id='null';
						nodo.id_p=n.id;	
						cmpCodigoclasificador_caif.maxLength=n.attributes.dig_nivel;
						cmpCodigoclasificador_caif.minLength=n.attributes.dig_nivel;
						cmpCodigoclasificador_caif.fieldLabel= 'Nivel ' + parseInt(++n.attributes.nivel_clasificador_caif) + ' de '+ n.attributes.dig_nivel + ' dígito(s):';
						mostrarComponente(cmpCodigoPadre);
						mostrarComponente(cmpCodigoclasificador_caif);
						ocultarComponente(cmpNivelclasificador_caif);
						ocultarComponente(cmpTipoclasificador_caif);
						ocultarComponente(cmpIdParametro);
						mostrarComponente(cmpSwMovimiento);
						ocultarComponente(cmpTipoMemoria);
						mostrarComponente(cmpSwTransaccional);
						ocultarComponente(cmpIdConceptoColectivo);
						cmpCodigoclasificador_caif.enable();
						cmpCodigoPadre.disable();
						var tipo_clasificador_caif=cmpSwTransaccional.getValue();
						if(tipo_clasificador_caif==1){
							nodo.tipo='Movimiento'				
						}else{
							nodo.tipo='Titular'
						}
						setValuesBasicos(nodo,'add');
						getFormulario().reset();
						Dialog.show();
						cmpCodigoPadre.setValue(n.attributes.codigo_clasificador_caif+" - "+n.attributes.nombre_clasificador_caif)
					}else{
						Ext.MessageBox.alert('...','No se pueden adicionar más clasificador_caifs debido a que se llego al Nivel Máximo.')
					}
				}else{
					Ext.MessageBox.alert('...','La clasificador_caif es de movimiento y no puede tener clasificador_caifs dependientes.')
				}
			}else{
				Ext.MessageBox.alert('...','Para adicionar clasificador_caifs el estado de la gestión debe ser de Formulación o Revisión')
			}
		}else{
			Ext.MessageBox.alert('...','Antes debe seleccionar una clasificador_caif.')
		}
	};*/
	
/*	this.btnNewRaiz=function(){		
		ocultarComponente(cmpSwTransaccional);
		ocultarComponente(cmpNivelclasificador_caif);
		ocultarComponente(cmpCodigoclasificador_caif);
		ocultarComponente(cmpCodigoPadre);
		ocultarComponente(cmpTipoclasificador_caif);
		ocultarComponente(cmpSwMovimiento);
		ocultarComponente(cmpTipoMemoria);
		mostrarComponente(cmpIdParametro);
		ocultarComponente(cmpIdConceptoColectivo);
		cmpCodigoPadre.disable();
		cmpIdParametro.enable();    
		nodo={};
		nodo.id='null';
		nodo.id_p='null';
		setValuesBasicos(nodo,'add');
		getFormulario().reset();
		Dialog.show();
		btnNewRaiz();
		cmpTipoclasificador_caif.setValue('2');
	};*/
		
	/*function fallaDropItem(resp,b,c){
		conexionFailure(resp,b,c)
	}
	
	function btn_concepto_ingas(){
		var n=getSm().getSelectedNode();
	   if(!n || n.attributes.nivel_clasificador_caif==0){
			Ext.MessageBox.alert('...','Seleccione una clasificador_caif de tipo Movimiento.')
		}else{
			if(n&&n.attributes.sw_transaccional==2){
				Ext.MessageBox.alert('...','Debe seleccionar una clasificador_caif de tipo Movimiento.')
		    }else{
				var data='m_id_clasificador_caif='+n.attributes.id;
				data=data+'&m_codigo_clasificador_caif='+n.attributes.codigo_clasificador_caif;
				data=data+'&m_nombre_clasificador_caif='+n.attributes.nombre_clasificador_caif;
				data=data+'&m_nivel_clasificador_caif='+n.attributes.nivel_clasificador_caif;
				data=data+'&m_tipo_clasificador_caif='+n.attributes.tipo_clasificador_caif;
				data=data+'&m_estado_gral='+n.attributes.estado_gral;
				data=data+'&m_tipo_memoria='+n.attributes.tipo_memoria;
				var Param={Ventana:{width:'50%',height:'60%'}};
				var ven=layout_clasificador_caif_arb.loadWindows(direccion+'../../../../sis_presupuesto/vista/concepto_ingas/concepto_ingas.php?'+data,'Conceptos de Gasto',Param)
		   }
		}		
	}*/
	/*function guardarSuccessSc(r){
		var np=getSm().getSelectedNode();
		guardarSuccess(r);
		if(r.argument.proc=='upd'){
			var n=np.parentNode;
			np.setText(np.attributes.codigo_clasificador_caif+" - "+np.attributes.nombre_clasificador_caif);
			n.reload()
		}
		else{			
			if(np){			
				var n=np.lastChild;
		    	if(n){		    
		   			var aux=cmpCodigoclasificador_caif.getValue();
					n.setText(aux+" - "+cmpNombreclasificador_caif.getValue());
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
	}*/
   this.getLayout=function(){
		return layout_clasificador_caif_arb.getLayout()
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
	 
    gestion.on('select',function (combo, record, index){
    	g_id_gestion=gestion.getValue();
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
	//this.AdicionarBoton('../../../lib/imagenes/list-items.gif','Conceptos de Gasto',btn_concepto_ingas,true,'concepto_gas','Conceptos de Gasto');
	iniciarEventos()
}