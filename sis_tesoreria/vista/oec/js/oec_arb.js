function pagina_oec_arb(idContenedor,direccion,paramConfig){
	var Atributos=[];
	var ds_parametro;
	var layout_oec_arb;
	var cmpNroOec,cmpNombreOec;
	var	cmpDescOec,cmpNivelOec;
	var	cmpSwTransaccional,cmpTipoOec,cmpNombreRaiz;
	var	cmpIdParametro,cmpSwMovimiento;
	var cmpOecPadre;
	var g_id_gestion='';
	var Dialog;
	var copiados;
	var ds_parametro=new Ext.data.Store({
		proxy:new Ext.data.HttpProxy({url:direccion+'../../../control/parametro/ActionListarParametro.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro',totalRecords:'TotalCount'},['id_parametro','id_gestion','gestion','cantidad_nivel'])
	});
	var resultTplParametro=new Ext.Template('<div class="search-item">','<b><i>{gestion}</i></b>','<br><FONT COLOR="#B5A642"><b>Cantidad Niveles: </b>{cantidad_nivel}</FONT>','</div>');
	Atributos[0]={
		validacion:{
			name:'oec_padre',
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
			name:'nro_oec',
			fieldLabel:'Número de OEC',
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
			fieldLabel:'Nombre de OEC',
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			//store:new Ext.data.SimpleStore({fields:['valor'],data:Ext.oec_combo.nombre_raiz}),
			store:new Ext.data.SimpleStore({fields:['valor'],data:[['INGRESOS TOTALES'],['EGRESOS TOTALES'],['DEFICIT O SUPERAVIT'],['FINANCIAMIENTO']]}),
			valueField:'valor',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			width:130
		},
		tipo:'ComboBox',
		defecto:'INGRESOS TOTALES'
		};	
	Atributos[3]={
		validacion:{
			name:'nombre_oec',
			fieldLabel:'Nombre de OEC',
			allowBlank:true,
			width:'100%',
			maxLength:75,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto'
		},
		tipo:'TextField'
		};
	// txt centro
	Atributos[4]={
		validacion:{
			name:'desc_oec',
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
 // txt descripcion
	Atributos[5]={
		validacion:{
			name:'nivel_oec',
			fieldLabel:'Nivel',
			allowBlank:true,
			maxLength:10,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto'
		},
		tipo:'TextField'
		};
		// txt observaciones
	Atributos[6]={
		validacion:{
			name:'tipo_oec',
			fieldLabel:'OEC',
			allowBlank:true,
			maxLength:1,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto'
		},
		tipo:'TextField'
		};		
	// txt cargo_individual
	Atributos[7]={
		validacion:{
			name:'sw_transaccional',
			fieldLabel:'Tipo de OEC',
			typeAhead:true,
			loadMask:true,
			triggerAction:'all',
			//store:new Ext.data.SimpleStore({fields:['id','valor'],data:Ext.oec_combo.sw_transaccional}),
			store:new Ext.data.SimpleStore({fields:['id','valor'],data:[['1','Movimiento'],['2','Titular']][['1','Movimiento'],['2','Titular']]}),
			valueField:'id',
			displayField:'valor',
			lazyRender:true,
			forceSelection:true,
			width:100
		},
		tipo:'ComboBox',
		defecto:'Titular'
		};
	// txt id_nivel_organizacional
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
			typeAhead:true,
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
	var config={titulo:'OECs'};
	layout_oec_arb=new DocsLayoutArb(idContenedor);
	layout_oec_arb.init(config);
	/// HEREDAMOS DE LA CLASE MADRE
	this.pagina=PaginaArb;
	//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
	this.pagina(paramConfig,Atributos,layout_oec_arb,idContenedor,DatosNodo,DatosDefecto);
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
		Basicas:{url:direccion+'../../../../sis_tesoreria/control/oec/ActionGuardarOecArb.php',add_success:guardarSuccessSc,edit:sEdit},
		Formulario:{height:330,width:490,minWidth:150,minHeight:200,closable:true,titulo:'OECs'},
		Listar:{url:direccion+'../../../../sis_tesoreria/control/oec/ActionListarOecArb.php',raiz:'agrupador',baseParams:{},clearOnLoad:true,enableDD:true}
	};
// parametros del menu //
	var paramMenu={
		nuevoRaiz:{crear:true,separador:false,tip:'Nuevo Clasificador',img:'tuc+.png'},
		nuevo:{crear:true,separador:false,tip:'Nueva OEC',img:'raiz+.png'},
		editar:{crear:true,separador:false,tip:'Editar',img:'etucr.png'},
		eliminar:{crear:true,separador:false,tip:'Eliminar',img:'tucr-.png'},
		actualizar:{crear:true,separador:false}
	};
	function isReorder(e, n){
		return n.parentNode == e.target.parentNode && e.point != 'append'
	}
	
	function iniciarEventos(){
		cmpNroOec=getComponente('nro_oec');
		cmpNombreRaiz=getComponente('nombre_raiz');
		cmpNombreOec=getComponente('nombre_oec');
		cmpDescOec=getComponente('desc_oec');
		cmpNivelOec=getComponente('nivel_oec');
		cmpTipoOec=getComponente('tipo_oec');
		cmpSwTransaccional=getComponente('sw_transaccional');
		cmpIdParametro=getComponente('id_parametro');
		cmpOecPadre=getComponente('oec_padre');
		var onNombreRaizSelect=function(e){
			var id=cmpNombreRaiz.getValue()
			if(id=='INGRESOS TOTALES'){
				cmpNroOec.setValue('1')
			}
			else{
				if(id=='EGRESOS TOTALES'){
					cmpNroOec.setValue('2')
				}
				else{
					if(id=='DEFICIT O SUPERAVIT'){
						cmpNroOec.setValue('3')
					}
					else{
						if(id=='FINANCIAMIENTO'){
							cmpNroOec.setValue('4')
						}
						else{
							cmpNroOec.setValue('5')
						}
					}
				}
				
			}
		};
	
		var treLoader=getLoader();
		Dialog=getDialog();
		///menu contextual principal
		var CtxMenuP=getCtxMenu();
		treLoader.on("beforeload", function(treeL,n){
			treeL.baseParams.nro_oec=n.attributes.nro_oec,
			treeL.baseParams.gestion=g_id_gestion
		}, this);
		cmpNombreRaiz.on('select',onNombreRaizSelect);
	    cmpNombreRaiz.on('change',onNombreRaizSelect)
	}
	//copiar y pegar
	this.btnEliminar=function(){
		var n=getSm().getSelectedNode();
		if(!n){
			Ext.MessageBox.alert('ESTADO','Primero seleccione una OEC.')
		}
		else{
			if(n.attributes.estado_gestion!=3){
				btnEliminar()
			}
			else{
				Ext.MessageBox.alert('ESTADO', 'No se puede eliminar OECs debido a que la Gestión está Cerrada')
			}
		}
	};	
	function sEdit(){
		var n=getSm().getSelectedNode();
			cmpNroOec.fieldLabel= 'Número de OEC:';
			cmpNroOec.width = 150;
		if (n){
			if(n.attributes.estado_gestion!=3){
				ocultarComponente(cmpOecPadre);
				if(n.attributes.nivel_oec==1){
					cmpNroOec.disable();
					cmpNombreOec.disable();
					cmpIdParametro.disable();
					mostrarComponente(cmpIdParametro);
					ocultarComponente(cmpNombreRaiz);
					mostrarComponente(cmpNombreOec);
					mostrarComponente(cmpDescOec);
					ocultarComponente(cmpTipoOec);
					ocultarComponente(cmpNivelOec);
					ocultarComponente(cmpSwTransaccional);
					btnEdit()
				}
				else{
					cmpNroOec.disable();
					cmpNombreOec.enable();
					cmpIdParametro.disable();
					ocultarComponente(cmpIdParametro);
					ocultarComponente(cmpNombreRaiz);
					mostrarComponente(cmpNombreOec);
					ocultarComponente(cmpTipoOec);
					ocultarComponente(cmpNivelOec);
					mostrarComponente(cmpSwTransaccional);
					btnEdit()		    	
				}
			}
			else{		  	
				Ext.MessageBox.alert('ESTADO', 'No se puede Modificar los datos de la OEC debido a que la Gestión está Cerrada')
				}
		}
		else{
			Ext.MessageBox.alert('ESTADO', 'Primero seleccione una OEC')
		}	
	};
	
	this.btnNew=function(){
		var n=getSm().getSelectedNode();
		if(n){
		  if(n.attributes.estado_gestion!=3){
		  	if (n.attributes.sw_transaccional==2){
		  	 if(n.attributes.dig_nivel){
		  	 	nodo={};
			    nodo.id='null';
			    nodo.id_p=n.id;
			    cmpNroOec.fieldLabel= 'Nivel ' + parseInt(++n.attributes.nivel_oec) + ' de '+ n.attributes.dig_nivel + ' dígito(s):';	
		    	cmpNroOec.width = 50;
			    cmpNroOec.maxLength=n.attributes.dig_nivel;
			    cmpNroOec.minLength=n.attributes.dig_nivel;
			    mostrarComponente(cmpNombreOec);
			    mostrarComponente(cmpOecPadre);
		  	    ocultarComponente(cmpNombreRaiz);
		      	ocultarComponente(cmpTipoOec);
		    	ocultarComponente(cmpIdParametro);
		    	ocultarComponente(cmpNivelOec);
		    	mostrarComponente(cmpSwTransaccional);
		    	cmpNroOec.enable();
		    	cmpOecPadre.disable();
		    	setValuesBasicos(nodo,'add');
		    	getFormulario().reset();
		    	Dialog.show();
		    	cmpOecPadre.setValue(n.attributes.nro_oec+" - "+n.attributes.nombre_oec);
		  	 }
		  	 else{
		  	 	Ext.MessageBox.alert('ESTADO','No se pueden crear más OEC debido a que se llego al Nivel Máximo.')
		  	 }		  			 					
		  }
		   else{
		 	Ext.MessageBox.alert('ESTADO','La OEC es de Movimiento y no puede tener OEC dependientes.')
		    }
		  }
		  else{
		  	Ext.MessageBox.alert('ESTADO','No se puede crear OEC debido a que la Gestión está Cerrada.')
		  }
			
		}
		else{
			Ext.MessageBox.alert('ESTADO', 'Primero seleccione una OEC')
		}
	};
	
	this.btnNewRaiz=function(){
		nodo={};
		nodo.id='null';
		nodo.id_p='null';
		ocultarComponente(cmpNombreOec);
		ocultarComponente(cmpTipoOec);
		ocultarComponente(cmpNivelOec);
		ocultarComponente(cmpSwTransaccional);
		ocultarComponente(cmpOecPadre);
		mostrarComponente(cmpNombreRaiz);
		mostrarComponente(cmpDescOec);
		mostrarComponente(cmpIdParametro);
		cmpNroOec.disable();
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
			np.setText(np.attributes.nro_oec+" - "+np.attributes.nombre_oec);
			n.reload()
		}
		else{
			if(np){			
				var n=np.lastChild;
		    	if(n){		    
		   			var aux=cmpNroOec.getValue();
					n.setText(aux+" - "+cmpNombreOec.getValue());
					np.reload()					
				}				
			}
			else{
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
		return layout_oec_arb.getLayout()
	};
	  var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/gestion/ActionListarGestion.php'}),reader: new Ext.data.XmlReader({record: 'ROWS',id:'id_gestion',totalRecords:'TotalCount'},['id_gestion','gestion','estado_ges_gral','id_empresa','desc_empresa','id_moneda_base','desc_moneda'])}); 
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
			    m_id_gestion:g_id_gestion,
			    m_sw_cuenta_ejercicio:'si'
		        }
	         });
	      btnActualizar()	
         });
	this.InitFunciones(paramFunciones);
	this.InitBarraMenu(paramMenu);
	this.AdicionarBotonCombo(gestion,'gestion');
	this.Init(); //iniciamos la clase madre
	this.iniciaFormulario();
	iniciarEventos()
}