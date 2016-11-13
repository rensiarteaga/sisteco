<?php 
/**
 * Nombre:		  	    tipo_unidad_constructiva_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Generado Automaticamente
 * Fecha creación:		2007-11-07 15:46:18
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
	<?php if($_SESSION["ss_filtro_avanzado"]!=''){
		echo 'fa='.$_SESSION["ss_filtro_avanzado"].';';
	}
	?>
var paramConfig={TamanoPagina:20,TiempoEspera:1000000,CantFiltros:1,FiltroEstructura:fa};
var elemento={pagina:new pagina_unidad_organizacional_arb(idContenedor,direccion,paramConfig),idContenedor:idContenedor};
ContenedorPrincipal.setPagina(elemento);
}
Ext.onReady(main,main);
function pagina_unidad_organizacional_arb(idContenedor,direccion,paramConfig){
	var Atributos=[];
	var layout_unidad_organizacional_arb;
	var cmpNombreUnidad,cmpNombreCargo,cmpCentro;
	var cmpCargoIndividual,cmpDescripcion,cmpIdNivel;
	var cmpEstadoReg,cmpObservaciones,cmpRelacion;
	var cmpIdEstructuraOrganizacional,cmpIdUnidadOrganizacional;
	var Dialog;
	var copiados;
	var ds_nivel=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/nivel_organizacional/ActionListarNivelOrganizacional.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_nivel_organizacional',totalRecords:'TotalCount'},['id_nivel_organizacional','nombre_nivel','numero_nivel'])
	});
	var resultTplNivel=new Ext.Template('<div class="search-item">','<b><i>{nombre_nivel}</i></b>','<br><FONT COLOR="#B5A642"><b>Nivel: </b>{numero_nivel}</FONT>','</div>');
	Atributos[0]={
		validacion:{
			name:'nombre_unidad',
			fieldLabel:'Unidad',
			allowBlank:false,
			width:300,
			maxLength:300,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto'
		},
		tipo:'TextField'
		};
	Atributos[1]={
		validacion:{
			name:'codigo',
			fieldLabel:'Codigo',
			allowBlank:false,
			width:300,
			maxLength:4,
			grid_visible:true,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto'
		},
		tipo:'TextField',
		form:true
		};
	// txt centro
	Atributos[2]={
		validacion:{
			name:'centro',
			fieldLabel:'Centro',
			typeAhead:true,
			loadMask:true,
			allowBlank:false,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['pre','Preaprobador'],['apro','Aprobador'],['no','no']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			width:90
			},
		tipo:'ComboBox',
		defecto:'si',
		form:false
		};
	// txt cargo_individual
	Atributos[3]={
		validacion:{
			name:'cargo_individual',
			fieldLabel:'Cargo Individual',
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			allowBlank:false,
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['si','si'],['no','no']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			width:90
		},
		tipo:'ComboBox',
		defecto:'no'
		};
  // txt descripcion
	Atributos[4]={
		validacion:{
			name:'descripcion',
			fieldLabel:'Descripcion',
			allowBlank:false,
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto'
		},
		tipo:'TextArea'
		};
	// txt id_nivel_organizacional
	Atributos[5]={
		validacion:{
			name:'id_nivel_organizacional',
			fieldLabel:'Nivel',
			allowBlank:true,
			emptyText:'Nivel ...',
			store:ds_nivel,
			desc:'nombre_nivel',
			valueField:'id_nivel_organizacional',
			displayField:'nombre_nivel',
			filterCol:'NIVORG.nombre_nivel',
			typeAhead:true,
			forceSelection:false,
			tpl:resultTplNivel,
			allowBlank:false,
			mode:'remote',
			queryDelay:50,
			pageSize:5,
			minListWidth:230,
			resizable:true,
			minChars:1,
			triggerAction:'all',
		},
		tipo:'ComboBox',
		form:false
		};
	// txt_estado_reg
	Atributos[6]={
		validacion:{
			name:'estado_reg',
			fieldLabel:'Estado',
			typeAhead:true,
			allowBlank:false,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['activo','activo'],['inactivo','inactivo']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			width:90
		},
		tipo:'ComboBox'
		};
	// txt observaciones
	Atributos[7]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto'
		},
		tipo:'TextArea'
		};
    // txt relacion
	Atributos[8]={
		validacion:{
			name:'relacion',
			fieldLabel:'Relación',
			typeAhead:true,
			loadMask:true,
			allowBlank:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['dependiente','dependiente'],['no dependiente','no dependiente']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			width:90
		},
		tipo:'ComboBox'
	};  
	
	
	Atributos[9]={
		validacion:{
			name:'importe_max_apro',
			fieldLabel:'Importe Aprobación',
			typeAhead:true,
			loadMask:true,
			allowBlank:true,
			triggerAction:'all',
			lazyRender:true,
			forceSelection:true,
			width:90
		},
		tipo:'NumberField',
		form:false
	};  
	
	
	Atributos[10]={
		validacion:{
			name:'importe_max_pre',
			fieldLabel:'Importe Pre Aprobación',
			typeAhead:true,
			loadMask:true,
			allowBlank:true,
			triggerAction:'all',
			lazyRender:true,
			forceSelection:true,
			width:90
		},
		tipo:'NumberField',
		form:false
	}; 
	
	
	Atributos[11]={
		validacion:{
			name:'sw_presto',
			fieldLabel:'Presupuesta',
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Si'],['2', 'No']] }),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			width:90
			},
		tipo:'ComboBox',
		defecto:'si'
	};
	
	Atributos[12]={
		validacion:{
			name:'prioridad',
			fieldLabel:'Prioridad',
			allowBlank:true,
			maxLength:150,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			width:90
		},
		tipo:'TextField'
	};
	
	
	Atributos[13]={
		validacion:{
			name:'area',
			fieldLabel:'Area',
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['si','Si'],['no','No']] }),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			width:90
		},
		tipo:'ComboBox'
	};
	
	
	
	
	//Modificacion 28/03/2011 aayaviri
	Atributos[14]={
			validacion:{
				name:'correspondencia',
				fieldLabel:'Correspondencia',
				typeAhead:true,
				loadMask:true,
				triggerAction:'all',
				store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['si','Si'],['no','No']] }),
				valueField:'id',
				displayField:'valor',
				lazyRender:true,
				forceSelection:true,
				width:90
			},
			tipo:'ComboBox'
		};
	//---------------------------------
	
	
//datos extra a los Atributos declarados se manejaran en las operaciones basicas que maneja en las operacion
	var DatosNodo=new Array('id','id_p','tipo');
	var DatosDefecto={
		empresa:{
			text:0,//indice del atributo
			icon:"../../../lib/imagenes/org.png",
			allowDrag:false,
			allowDelete:true,
			allowEdit:true,
			terminado:'false'
		},
		general:{
			text:0,//indice del atributo
			icon:"../../../lib/imagenes/user_gg.png",
			allowDrag:false,
			allowDelete:true,
			allowEdit:true,
			terminado:'false'
		},
		area:{
			text:0,//indice del atributo
			icon:"../../../lib/imagenes/user_ga.png",
			allowDrag:false,
			allowDelete:true,
			allowEdit:true,
			terminado:'false'
		},
		departamento:{
			text:0,//indice del atributo
			icon:"../../../lib/imagenes/user_dep.png",
			allowDrag:false,
			allowDelete:true,
			allowEdit:true,
			terminado:'false'
		},
		division:{
			text:0,//indice del atributo
			icon:"../../../lib/imagenes/user_div.png",
			allowDrag:false,
			allowDelete:true,
			allowEdit:true,
			terminado:'false'
		},
		unidad:{
			text:0,//indice del atributo
			icon:"../../../lib/imagenes/user_unidad.png",
			allowDrag:false,
			allowDelete:true,
			allowEdit:true,
			terminado:'false'
		},
		base:{
			text:0,//indice del atributo
			icon:"../../../lib/imagenes/user_base.png",
			allowDrag:false,
			allowDelete:true,
			allowEdit:true,
			terminado:'false'
		},
		otro:{
			text:0,//indice del atributo
			icon:"../../../lib/imagenes/user_otro.png",
			allowDrag:false,
			allowDelete:true,
			allowEdit:true,
			terminado:'false'
		}
	}
	var config={titulo:'Unidad Organizacional'};
	layout_unidad_organizacional_arb=new DocsLayoutArb(idContenedor);
	layout_unidad_organizacional_arb.init(config);
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=PaginaArb;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,layout_unidad_organizacional_arb,idContenedor,DatosNodo,DatosDefecto);
	//----------   herencia de la clase madre -------//
	var getTreePanel = this.getTreePanel;
	var getTreeRaiz = this.getTreeRaiz;
	var getLoader= this.getLoader;
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
	var cm_EnableSelect=this.EnableSelect;
	// parametros las funciones//
	var paramFunciones={
		Basicas:{url:direccion+'../../../../sis_kardex_personal/control/unidad_organizacional/ActionGuardarUnidadOrganizacionalArb.php',add_success:guardarSuccess,edit:sEdit},
		Formulario:{height:415,width:480,minWidth:150,minHeight:200,closable:true,titulo:'Unidad Organizacional'},
		Listar:{url:direccion+'../../../../sis_kardex_personal/control/unidad_organizacional/ActionListarUnidadOrganizacionalArb.php',raiz:'empresa',baseParams:{},clearOnLoad:true,enableDD:true}
	};
// parametros del menu //
	var paramMenu={
		nuevoRaiz:{crear:true,separador:false,tip:'Nuevo Organigrama',img:'org_add.png'},
		nuevo:{crear:true,separador:false,tip:'Nueva Unidad',img:'tab_add.png'},
		editar:{crear:true,separador:false,tip:'Editar',img:'tab_edit.png'},
		eliminar:{crear:true,separador:false,tip:'Eliminar',img:'tab_delete.png'},
		actualizar:{crear:true,separador:false}
	};
	function isReorder(e, n){
		return n.parentNode == e.target.parentNode && e.point != 'append'
	}
	function iniciarEventos(){
		cmpNombreUnidad=getComponente('nombre_unidad');
		//cmpNombreCargo=getComponente('nombre_cargo');
		//cmpCentro=getComponente('centro');
		cmpCargoIndividual=getComponente('cargo_individual');
		cmpDescripcion=getComponente('descripcion');
		//cmpIdNivel=getComponente('id_nivel_organizacional');
		cmpEstadoReg=getComponente('estado_reg');
		cmpObservaciones=getComponente('observaciones');
		cmpRelacion=getComponente('relacion');
		cmpIdEstructuraOrganizacional=getComponente('id_estructura_organizacional');
		cmpIdUnidadOrganizacional=getComponente('id_unidad_organizacional');
		//cmpImporteMaxApro=getComponente('importe_max_apro');
		//cmpImporteMaxPre=getComponente('importe_max_pre');
		cmpArea=getComponente('area');
		var treLoader=getLoader();
		var trePanel=getTreePanel();
		Dialog=getDialog();
		///menu contextual principal
		var CtxMenuP=getCtxMenu();
		CtxMenuP.add({
			id:'copy',
			handler:btnCopy,
			cls:'copy-mi',
			text: 'Copiar'
		},{
			id:'paste',
			handler:btnPaste,
			cls:'paste-mi',
			text: 'Pegar'
		}
		);
		
		

		treLoader.on("beforeload", function(treeL,n){ 
			treeL.baseParams.centro=n.attributes.centro
		}, this);
		
		
	}
	//copiar y pegar
	function btnCopy(){
		copiados = getSm().getSelectedNode()
	}
	function btnPaste(){
		var n=getSm().getSelectedNode();
		var vec={};
		vec.id=copiados.id;
		vec.id_p=copiados.attributes.id_p;
		vec.id_pn=n.id;
		vec.nombre_unidad=n.attributes.nombre_unidad;
		//vec.nombre_cargo=n.attributes.nombre_cargo;
		vec.centro=copiados.attributes.centro;
		vec.cargo_individual=copiados.attributes.cargo_individual;
		vec.id_nivel_organizacional=copiados.attributes.id_nivel_organizacional;
		vec.estado_reg=copiados.attributes.estado_reg;
		var postData='datos='+encodeURIComponent(Ext.encode(vec))+'&proc=copy';
		Ext.MessageBox.show({
			title: 'Espere Por Favor...',
			msg:"<div><img src='../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Guardando...</div>",
			width:150,
			height:200,
			closable:false
		}); alert("paste");
		Ext.Ajax.request({
			url:direccion+'../../../../sis_kardex_personal/control/unidad_organizacional/ActionGuardarUnidadOrganizacionalArb.php',
			params: postData,
			method:'POST',
			success:terSuccess,
			argument:{nodo:n},
			failure:fallaDropItem,
			timeout:paramConfig.TiempoEspera
		});
	}
	this.btnEliminar=function(){
		var n=getSm().getSelectedNode();
		if(!n){
			alert("Seleccione un nodo primero")
		}
		else{
				btnEliminar()
		}
	};
	function sEdit(){ 
		var n=getSm().getSelectedNode();
	if (n){
		//mostrarComponente(cmpArea);
		if(n.attributes.numero_nivel==0){
			//ocultarComponente(cmpRelacion);
			//ocultarComponente(cmpObservaciones);
			//ocultarComponente(cmpImporteMaxApro);
			//ocultarComponente(cmpImporteMaxPre);
			btnEdit()
		}
		else{
			//mostrarComponente(cmpRelacion);
			//mostrarComponente(cmpObservaciones);
			//mostrarComponente(cmpImporteMaxApro);
			//mostrarComponente(cmpImporteMaxPre);
			btnEdit()
		}
	}
	else{
		alert("Seleccione un nodo primero")
	}	
	};
	this.btnNew=function(){
		var n=getSm().getSelectedNode();
		if(n){
			nodo={};
			nodo.id='null';
			nodo.id_p=n.id;
			mostrarComponente(cmpObservaciones);
		//	mostrarComponente(cmpImporteMaxApro);
		//	mostrarComponente(cmpImporteMaxPre);
			mostrarComponente(cmpArea);
			ocultarComponente(cmpRelacion);
		//	mostrarComponente(cmpIdNivel);
			
		//	mostrarComponente(getComponente('importe_max_apro'));
		//	mostrarComponente(getComponente('importe_max_pre'));
			mostrarComponente(getComponente('sw_presto'));
			mostrarComponente(getComponente('prioridad'));
			if(n.attributes.tipo=='empresa'){
				nodo.tipo='general'				
			}
			else{
				if(n.attributes.tipo=='general'){
					nodo.tipo='area'
				}
				else{
					if(n.attributes.tipo=='area'){
						nodo.tipo='departamento'
					}
					else{
						if (n.attributes.tipo=='departamento'){
							nodo.tipo='division'
						}
						else{
							if (n.attributes.tipo=='division'){
								nodo.tipo='unidad'
							}
							else{
								if (n.attributes.tipo=='unidad'){
									nodo.tipo='base'
								}
								else{
									nodo.tipo='otro'
								}								
							}
						}
					}
				}
			}
			setValuesBasicos(nodo,'add');
			getFormulario().reset();
			Dialog.show()
		}
		else{
			alert("Seleccione un nodo primero")
		}
	};
	this.btnNewRaiz=function(){
		ocultarComponente(cmpRelacion);
		ocultarComponente(cmpObservaciones);
		//ocultarComponente(cmpIdNivel);
		ocultarComponente(getComponente('sw_presto'));
	//	ocultarComponente(getComponente('importe_max_apro'));
	//	ocultarComponente(getComponente('importe_max_pre'));
		nodo={};
		nodo.id='null';
		nodo.id_p='null';
		setValuesBasicos(nodo,'add');
		getFormulario().reset();
		Dialog.show();
		btnNewRaiz()
		};
	function fallaDropItem(resp,b,c){
		conexionFailure(resp,b,c)
	}
	
	function guardarSuccess(r){ 
		var np=getSm().getSelectedNode();
		guardarSuccess(r);
		if(r.argument.proc=='upd'){
			np.setText(np.attributes.nombre_unidad)
		}
		else{		
			if(r.argument.proc=='dd'){ 
				var regreso=Ext.util.JSON.decode(r.responseText);
				resp.argument.nodo.parentNode.reload();
				resp.argument.nodo.reload();
				regreso.id_padre.reload();
			}else{
				if(np){			
				   var n=np.lastChild;
		    		if(n){		    
		   				var aux=cmpNombreCargo.getValue();
						n.setText(cmpNombreUnidad.getValue()+" - "+aux)					
					}
				}
			}
		}
	}
	function terSuccess(resp){ 
		var regreso=Ext.util.JSON.decode(resp.responseText)
		if(regreso.success=='true'){
			Ext.MessageBox.hide(); //alert(resp.argument.nodo.parentNode);
			resp.argument.nodo.parentNode.reload();
			
			resp.argument.nodo.reload();
			if(regreso.id_padre!=undefined && regreso.id_padre!=null){
				regreso.id_padre.reload();
			}
		}
	}
	function btn_historico_asignacion(){
		var n = getSm().getSelectedNode();
		if(n&&n.attributes.tipo=='empresa'){
			Ext.MessageBox.alert('Estado', 'Antes debe seleccionar un cargo, no la Empresa.')
		}
		else{
			var data='maestro_id_padre='+n.attributes.id_p;
			data=data+'&maestro_id_unidad_organizacional='+n.attributes.id;
			//data=data+'&maestro_nombre_cargo='+n.attributes.nombre_cargo;
			data=data+'&maestro_nombre_unidad='+n.attributes.nombre_unidad;
			data=data+'&maestro_cargo_individual='+n.attributes.cargo_individual;
			var Param={Ventana:{width:'90%',height:'60%'}};
			layout_unidad_organizacional_arb.loadWindows(direccion+'../../../vista/historico_asignacion/historico_asignacion_det.php?'+data,'Asignaci?n de Funcionarios',Param);
			
			
			
			
			layout_unidad_organizacional_arb.getVentana().on('resize',function(){
			layout_unidad_organizacional_arb.getLayout().layout();
			
			});
		}
	}
	
	
	//4may12: Mercedes Zambrana
	function btnSubirArchivo(){
		var n = getSm().getSelectedNode();
			
			
			var data='id_unidad_organizacional='+n.attributes.id+'&accion=upload';
			
			var ParamVentana={Ventana:{width:400,height:200}}
			
			layout_unidad_organizacional_arb.loadWindows(direccion+'../../../../sis_kardex_personal/vista/unidad_organizacional/uo-upload.php?'+data,'SubirArchivo',ParamVentana);
		
	}
	
	
	
    function btnVerAdjunto()
	{
		//obtiene el selection model del grid
		var n = getSm().getSelectedNode();
		
		
		
			if((n.attributes.url_archivo!=undefined)&&(n.attributes.url_archivo.length>0)){		
				var ParamVentana={Ventana:{width:'90%',height:'70%'}};				
				window.open(direccion+'../../../../sis_kardex_personal/control/unidad_organizacional/file_descripcion_cargos/'+n.attributes.url_archivo+'?ver=0');
			}
			else{
				Ext.MessageBox.alert('Estado', 'La correspondencia actual aï¿½n no ha sido digitalizada.');
			}
		
		
	}
    
	this.EnableSelect=function(sm,row,rec){
		enable(sm,row,rec);
		
	}
	
	
	function enable(sm, row, rec){
		if(row.attributes.url_archivo!='' && row.attributes.url_archivo!=null && row.attributes.url_archivo!=undefined){
				CM_getBoton('ver_adjunto-'+idContenedor).enable();
		}else{
				CM_getBoton('ver_adjunto-'+idContenedor).disable();
		}
				
				cm_EnableSelect(sm,row,rec);
	}
	
	
   this.getLayout=function(){
		return layout_unidad_organizacional_arb.getLayout()
	};	
	this.InitFunciones(paramFunciones);
	this.InitBarraMenu(paramMenu);
	this.Init(); //iniciamos la clase madre
	this.iniciaFormulario();
	
	var CM_getBoton=this.getBoton;
	this.AdicionarBoton('../../../lib/imagenes/user_otro.png','Asignaci?n de Funcionarios',btn_historico_asignacion,true,'hist_asig','Funcionarios');
	this.AdicionarBoton('../../../lib/imagenes/document_upload.png','Subir Archivo',btnSubirArchivo,true,'SubirArchivo','SubirArchivo');
	this.AdicionarBoton('../../../lib/imagenes/logo_pdf2.bmp','Ver Archivo',btnVerAdjunto,true,'ver_adjunto','Ver Archivo');
	
			//agregar filtro de busqueda en el arbol
	
	
 	var tb = this.getBarra()
	
	var filtro_tuc=new Ext.form.TextField({
	id:'uo_filtro_'+idContenedor,
	width:80
	});
	
	
	
	tb.add('->','Filtrar por: ','',filtro_tuc,'->',{

		icon:'../../../lib/imagenes/lupa2.png',
		cls: 'x-btn-icon',
		//cls:'remove',
		tooltip:'Aplicar el Filtro',
		handler:btn_actualizar_pdb
	}
	);
			
	
	function btn_actualizar_pdb(){
		getLoader().baseParams.filtrar=false
		
		if(filtro_tuc.getValue()!=''){
		  getLoader().baseParams.filtrar=true;
		  getLoader().baseParams.valor_filtro=filtro_tuc.getValue()
		
		  getTreeRaiz().reload()
		
		}else{
			
			btnActualizar();
			
		}
	}
	
	this.actualizaPadre = function(){
		
			var n = getSm().getSelectedNode();
			if(n  && n.parentNode){
				n.parentNode.reload();
			}
			
		
			
		
	}
	
	
	
	
	
	
	

	iniciarEventos()
}