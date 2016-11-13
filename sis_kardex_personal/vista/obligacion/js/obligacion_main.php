<?php 
/**
 * Nombre:		  	    afp_main.php
 * Propósito: 			pagina que arranca la configuracion de la vista
 * Autor:				Mercedes Zambrana Meneses
 * Fecha creación:		11-08-2010
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
var paramConfig={TamanoPagina:_CP.getConfig().ss_tam_pag,TiempoEspera:_CP.getConfig().ss_tiempo_espera,CantFiltros:1,FiltroEstructura:false,FiltroAvanzado:fa};
var maestro={id_planilla:<?php if($id_planilla!='') {echo $id_planilla;} else {echo 0; }?>,id_gestion:<?php if($id_gestion!='') echo $id_gestion; else echo 0;?>,desc_periodo:<?php if($desc_periodo!='') echo $desc_periodo; else echo 0; ?>,gestion:<?php if($gestion!='') echo $gestion; else echo 0;?>};
idContenedorPadre='<?php echo $idContenedorPadre;?>';

var elemento={pagina:new pagina_obligacion(idContenedor,direccion,paramConfig,maestro,idContenedorPadre),idContenedor:idContenedor};
_CP.setPagina(elemento);


}
Ext.onReady(main,main);
/**
* Nombre:		  	    pagina_afp.js
* Propósito: 			pagina objeto principal
* Autor:				Mercedes Zambrana Meneses
* Fecha creación:		11-08-2010
*/
function pagina_obligacion(idContenedor,direccion,paramConfig,maestro,idContenedorPadre){ 
	var Atributos=new Array,sw=0, g_pago, m_bandera;
	var filterCols_obligacion=new Array();
	    				filterValues_obligacion=new Array();
	var mi_array=new Array;
	//---DATA STORE
	var ds = new Ext.data.Store({
		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/obligacion/ActionListarObligacion.php'}),
		reader: new Ext.data.XmlReader({
			record: 'ROWS',id:'id_obligacion',totalRecords:'TotalCount'
		},[
		'id_obligacion',
		'id_tipo_obligacion',
		'codigo',
		'nombre',
		'id_planilla',
		'id_comprobante',
		'monto',
		'estado_reg',
		{name: 'fecha_reg',type:'date',dateFormat:'Y-m-d'},
		
		'observaciones',
		'nro_cuenta_banco',
		'id_institucion',
		'desc_institucion','tipo_pago',
		{name: 'fecha_pago',type:'date',dateFormat:'Y-m-d'},
		'id_cuenta','desc_cuenta',
		'id_auxiliar','desc_auxiliar','id_cuenta_bancaria', 'obs_pago','acreedor','id_gestion','gestion'
		//06.2014
		,'id_institucion_acreedor','desc_institucion_acreedor','id_lugar','nombre_lugar','id_persona','desc_person'
		]),remoteSort:true});

		var ds_id_tipo_obligacion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/tipo_obligacion/ActionListarTipoObligacion.php'}),
		reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_obligacion',totalRecords: 'TotalCount'},
		['id_tipo_obligacion','codigo','nombre'])
		});
		
		var ds_id_cuenta = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/cuenta/ActionListarCuenta.php?m_id_gestion='+maestro.id_gestion}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta',totalRecords: 'TotalCount'},
			['id_cuenta','nro_cuenta','nombre_cuenta'])
			});
		
		var ds_id_auxiliar = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_contabilidad/control/auxiliar/ActionListarAuxiliar.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_tipo_obligacion',totalRecords: 'TotalCount'},
			['id_auxiliar','codigo_auxiliar','nombre_auxiliar'])
		});

 		var ds_cuenta_bancaria = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_tesoreria/control/cuenta_bancaria/ActionListarCuentaBancaria.php?estado=1'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_cuenta_bancaria',totalRecords: 'TotalCount'},
			['id_cuenta_bancaria','id_institucion','desc_institucion'
			,'id_cuenta','desc_cuenta','id_auxiliar'
			,'desc_auxiliar','nro_cheque','estado_cuenta'
			,'nro_cuenta_banco','id_moneda','nombre_moneda'
			])//,baseParams:{m_vista_cheque:'registro_cheque_conta',m_id_cuenta:maestro.id_cuenta,m_id_auxiliar:maestro.id_auxiliar}
 			});
 			
 			 var ds_gestion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_kardex_personal/control/parametro_kardex/ActionListarParametroKardex.php'}),
			reader:new Ext.data.XmlReader({record:'ROWS',id:'id_parametro_kardex',totalRecords: 'TotalCount'},['id_parametro_kardex','id_gestion','desc_gestion','estado_reg','fecha_inicio'])
	});
 			 
 			 
 			 
 			 //06.2014
 			var ds_institucion = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_parametros/control/institucion/ActionListarInstitucion.php'}),
 				reader: new Ext.data.XmlReader({
 					record: 'ROWS',
 					id: 'id_institucion',
 					totalRecords: 'TotalCount'
 				}, ['id_institucion','tdoc_id','doc_id','nombre','casilla','telefono1','telefono2','celular1','celular2','fax','email1','email2','pag_web','observaciones','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','estado_institucion','id_persona'])
 			});

 			 
 			 var ds_lugar=new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/lugar/ActionListarLugar_det.php?txt_municipio=si'}),
  				reader: new Ext.data.XmlReader({record:'ROWS',id:'id_lugar',totalRecords:'TotalCount'},['id_lugar','codigo','nombre','sigla_sigma'])
  			//,baseParams:{tipo_adq:maestro.tipo_adq, id_proceso_compra:maestro.id_proceso_compra
  				});
 			 
 			  var ds_persona = new Ext.data.Store({proxy: new Ext.data.HttpProxy({url: direccion+'../../../../sis_seguridad/control/persona/ActionListarPersona.php'}),
 					reader:new Ext.data.XmlReader({record:'ROWS',id:'id_persona',totalRecords: 'TotalCount'},['id_persona','apellido_paterno','apellido_materno','nombre','fecha_nacimiento','foto_persona','doc_id','genero','casilla','telefono1','telefono2','celular1','celular2','pag_web','email1','email2','email3','fecha_registro','hora_registro','fecha_ultima_modificacion','hora_ultima_modificacion','observaciones','id_tipo_doc_identificacion','direccion','nro_registro','desc_per'])
 			});
 			 

		function render_id_cuenta_bancaria(value, p, record){return String.format('{0}', record.data['nro_cuenta_banco']);}	
			var tpl_id_cuenta_bancaria=new Ext.Template('<div class="search-item">'
		,'<b>Cuenta: </b><FONT COLOR="#B5A642">{nro_cuenta_banco}</FONT><br>',
		'<b>Banco: </b><FONT COLOR="#B5A642">{desc_institucion}</FONT><br>',
		'<b>Auxiliar: </b><FONT COLOR="#B5A642">{desc_auxiliar}</FONT>','</div>');			
			

		//FUNCIONES RENDER


		function render_id_tipo_obligacion(value, p, record){return record.data['nombre']}
		var tpl_id_tipo_obligacion=new Ext.Template('<div class="search-item">',
		'<b>{codigo}</b>',
		'<br><FONT COLOR="#B5A642">{nombre}</FONT>',
		'</div>');

		function render_estado_reg(value)
		{
			if(value=='activo'){value='Activo'	}
			else if(value=='inactivo'){value='Inactivo'	}
			return value
		}

		function render_id_cuenta(value, p, record){return record.data['desc_cuenta']}
		function render_id_auxiliar(value, p, record){return record.data['desc_auxiliar']}
		function render_id_gestion(value, p, record){return String.format('{0}', record.data['gestion']);}
		
		function render_id_persona(value, p, record){return String.format('{0}', record.data['desc_person']);}
		var tpl_id_persona=new Ext.Template('<div class="search-item">','{nombre} ','{apellido_paterno} ','{apellido_materno}','</div>');
		
		function render_id_institucion(value, p, record){return String.format('{0}', record.data['desc_institucion_acreedor']);}
					
		function render_id_lugar(value, p, record){return String.format('{0}', record.data['nombre_lugar']);}
		var tpl_id_lugar=new Ext.Template('<div class="search-item">'
				,'<b>Nombre: </b><FONT COLOR="#B5A642">{nombre}</FONT><br>',
				'<b>Codigo: </b><FONT COLOR="#B5A642">{sigla_sigma}</FONT><br>',
				'</div>');			
			
		
		
		var tpl_id_cuenta_bancaria=new Ext.Template('<div class="search-item">'
	,'<b>Cuenta: </b><FONT COLOR="#B5A642">{nro_cuenta_banco}</FONT><br>',
	'<b>Banco: </b><FONT COLOR="#B5A642">{desc_institucion}</FONT><br>',
	'<b>Auxiliar: </b><FONT COLOR="#B5A642">{desc_auxiliar}</FONT>','</div>');			
		
		
		/*PARA PAGO UNICO DE OBLIGACIONES*/
		
		
   
	
	var tpl_id_gestion=new Ext.Template('<div class="search-item">','<b>{desc_gestion}</b><br>','</div>');
		/////////////////////////
		// Definición de datos //
		/////////////////////////

		// hidden id_columna_tipo
		//en la posición 0 siempre esta la llave primaria

		Atributos[0]={
			validacion:{
				labelSeparator:'',
				name: 'id_obligacion',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false
		};

		// txt id_empleado
		Atributos[1]={
			validacion:{
				name:'id_planilla',
				labelSeparator:'',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false,
				disabled:true
			},
			tipo:'Field',
			filtro_0:false,
			defecto:maestro.id_planilla
		};

		Atributos[2]={
			validacion:{
				name:'id_tipo_obligacion',
				fieldLabel:'Tipo Obligacion',
				allowBlank:false,
				//emptyText:'Presupuesto...',
				desc: 'nombre', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_id_tipo_obligacion,
				valueField: 'id_tipo_obligacion',
				displayField: 'nombre',
				queryParam: 'filterValue_0',
				filterCol:'nombre',
				typeAhead:false,
				tpl:tpl_id_tipo_obligacion,
				forceSelection:true,
				mode:'remote',
				queryDelay:360,
				pageSize:10,
				minListWidth:400,
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:3, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_tipo_obligacion,
				grid_visible:true,
				grid_editable:false,
				width_grid:400,
				grid_indice:1,
				width:'100%'
			},
			tipo:'ComboBox',
			form: true,
			filtro_0:true,
			filterColValue:'tob.codigo#tob.nombre',
			id_grupo:0
		};


		Atributos[3]= {
			validacion: {
				name:'estado_reg',
				fieldLabel:'Estado',displayField:'valor',
				lazyRender:true,
				renderer:render_estado_reg,
				forceSelection:true,
				grid_visible:true,
				grid_editable:false,
				width_grid:90,

			},
			tipo:'TextField',
			form: false,
			filtro_0:true,
			filterColValue:'TOB.estado_reg'
		};

		// txt fecha_reg
		Atributos[4]= {
			validacion:{
				name:'fecha_reg',
				fieldLabel:'Fecha Registro',
				allowBlank:true,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Día no válido',
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width_grid:100,
				disabled:true
			},
			form:false,
			tipo:'DateField',
			filtro_0:true,
			filterColValue:'TOB.fecha_reg',
			dateFormat:'m-d-Y',
			defecto:''

		};
		
		
	Atributos[10]={
			validacion:{
			name:'id_cuenta_bancaria',
			fieldLabel:'Cta Bancaria Origen',
			allowBlank:true,			
			emptyText:'Cuenta Bancaria...',
			desc: 'desc_institucion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_cuenta_bancaria,
			valueField: 'id_cuenta_bancaria',
			displayField: 'nro_cuenta_banco',
			queryParam: 'filterValue_0',
			filterCol:'CUENTA.nro_cuenta#CUENTA.descripcion#CUEBAN.nro_cuenta_banco#INSTIT.nombre',
			typeAhead:true,
			tpl:tpl_id_cuenta_bancaria,
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
			renderer:render_id_cuenta_bancaria,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:230,
			grid_indice:6,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filtro_1:true,
		id_grupo:1,
		filterColValue:'INS.nombre#CTA.nro_cuenta_banco',
		save_as:'id_cuenta_bancaria'
	};

	
	Atributos[6]={
		validacion:{
			name:'observaciones',
			fieldLabel:'Observaciones',
			allowBlank:true,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			grid_indice:2,
			width:'100%',
			disabled:false
		},
		tipo: 'TextArea',
		form: true,
		id_grupo:0,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ob.observaciones',
		save_as: 'observaciones'
	
	};

	
	Atributos[7]={
			validacion:{
				name:'accion_obli',
				
				labelSeparator:'',
				inputType:'hidden',
				grid_visible:false,
				grid_editable:false,
				disabled:true
			},
			tipo:'Field',
			filtro_0:false
		};
		
		
	Atributos[8]= {
		validacion: {
			name:'tipo_pago',			
			fieldLabel:'Tipo Pago',
			allowBlank:true,
			typeAhead: true,
			loadMask: true,
			triggerAction: 'all',			
			store:new Ext.data.SimpleStore({fields:['ID','valor'],data:[['cheque','cheque'],['transferencia','transferencia']]}),
			valueField:'ID',
			displayField:'valor',
			lazyRender:true,
			
			forceSelection:true,
			grid_visible:true,
			grid_editable:false,
			width_grid:90,
			width:150
			
		},
		tipo:'ComboBox',
		filtro_0:true,		
		id_grupo:1,
		filterColValue:'OB.tipo_pago'		
	};
	
	Atributos[9]={
			validacion:{
				labelSeparator:'',
				inputType:'hidden',
				name: 'monto',
				grid_visible:true,
				grid_indice:3,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false
		};
		
		Atributos[5]= {
			validacion:{
				name:'fecha_pago',
				fieldLabel:'Fecha Pago',
				allowBlank:true,
				format: 'd/m/Y', //formato para validacion
				minValue: '01/01/1900',
				disabledDaysText: 'Día no válido',
				grid_visible:true,
				grid_editable:false,
				renderer: formatDate,
				width_grid:100,
				disabled:false
			},
			form:true,
			id_grupo:1,
			tipo:'DateField',
			filtro_0:true,
			filterColValue:'OB.fecha_pago',
			dateFormat:'m-d-Y',
			defecto:''

		};
		
	
		
	Atributos[11]={
		validacion:{
			name:'id_cuenta',
			desc:'desc_cuenta',
			allowBlank:false,
			fieldLabel:'Cuenta',
			tipo:'ingreso',//determina el action a llamar
			maxLength:100,
			minLength:0,
			selectOnFocus:true,
			vtype:"texto",
			width:200,
			pageSize:10,
			direccion:direccion,
			grid_visible:true,
			width_grid:200,
			renderer:render_id_cuenta,
			filterCols:filterCols_obligacion,
				filterValues:filterValues_obligacion,
			disabled:false,
			onSelect:function(record){ 				
				//Ext.form.LovItemsAlm.superclass.setValue.call(this,v.desc)
				getComponente('id_cuenta').setValue({id:record.data.id_cuenta,desc:record.data.desc_cuenta});				
				getComponente('id_cuenta').collapse();				
				ds_id_auxiliar.baseParams={cuenta:record.data.id_cuenta};				
				getComponente('id_auxiliar').modificado=true;
				getComponente('id_auxiliar').setValue('');
				getComponente('id_auxiliar').setDisabled(false);	 	
			}	
		},
		tipo:'LovCuenta',
		id_grupo:0,
		save_as:'id_cuenta',
		form:true
	};

			Atributos[12]= {
			validacion: {
			name:'id_auxiliar',
			fieldLabel:'Auxiliar',
			allowBlank:false,			
			//emptyText:'Auxiliar...',
			desc: 'desc_auxiliar', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_id_auxiliar,
			valueField: 'id_auxiliar',
			displayField: 'nombre_auxiliar',
			queryParam: 'filterValue_0',
			filterCol:'AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar',
			typeAhead:false,
			forceSelection:true,
			mode:'remote',
			queryDelay:250,
			pageSize:100,
			minListWidth:450,
			grow:true,
			width:'100%',
			resizable:true,
			queryParam:'filterValue_0',
			minChars:1, ///caracteres mínimos requeridos para iniciar la busqueda
			triggerAction:'all',
			grid_visible:true,
			renderer:render_id_auxiliar,
			disabled:true,
			width_grid:200 // ancho de columna en el gris
			
		},
		tipo:'ComboBox',
		id_grupo:0,
		save_as:'id_auxiliar',
		filtro_0:true,
		filterColValue:'AUXILI.codigo_auxiliar#AUXILI.nombre_auxiliar'
	};
			
			
		Atributos[13]={
			validacion:{
				labelSeparator:'',
				inputType:'hidden',
				name: 'mi_array',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false
		};
		
		Atributos[14]={
			validacion:{
				labelSeparator:'',
				inputType:'hidden',
				name: 'cantidad_obligaciones',
				grid_visible:false,
				grid_editable:false
			},
			tipo: 'Field',
			filtro_0:false
		};
		
	Atributos[15]={
		validacion:{
			name:'obs_pago',
			fieldLabel:'Observaciones de Pago',
			allowBlank:true,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			grid_indice:14,
			width:'100%',
			disabled:false
		},
		tipo: 'TextArea',
		form: true,
		id_grupo:1,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ob.obs_pago',
		save_as: 'obs_pago'
	
	};
	
	Atributos[16]={
		validacion:{
			name:'acreedor',
			fieldLabel:'Acreedor',
			allowBlank:true,
			maxLength:500,
			minLength:0,
			selectOnFocus:true,
			vtype:'texto',
			grid_visible:true,
			grid_editable:false,
			width_grid:250,
			grid_indice:4,
			width:'100%',
			disabled:false
		},
		tipo: 'TextField',
		form: false,
		id_grupo:1,
		filtro_0:true,
		filtro_1:true,
		filterColValue:'ob.acreedor',
		save_as: 'acreedor'
	
	};
	Atributos[19]= {
			validacion: {
					name:'id_institucion_acreedor',
					fieldLabel:'Inst. Acreedor',
					allowBlank:true,
					emptyText:'Institucion...',
					desc: 'desc_institucion_acreedor', //indica la columna del store principal ds del que proviane la descripcion
					store:ds_institucion,
					valueField: 'id_institucion',
					displayField: 'nombre',
					queryParam: 'filterValue_0',
					filterCol:'INSTIT.nombre#INSTIT.casilla',
					forceSelection:false,
					mode:'remote',
					queryDelay:200,
					pageSize:150,
					minListWidth:'100%',
					grow:true,
					resizable:true,
					queryParam:'filterValue_0',
					minChars:3, ///caracteres minimos requeridos para iniciar la busqueda
					triggerAction:'all',
					editable:true,
					renderer:render_id_institucion,
					grid_visible:false,
					grid_editable:false,
					width_grid:150, // ancho de columna en el gris
					width:200,
					grid_indice:12,
					confTrigguer:{
						url:direccion+'../../../../sis_parametros/vista/institucion/institucion.php',
					    paramTri:'prueba:XXX',		
					    title:'Personas',
					    param:{width:800,height:800},
					    idContenedor:idContenedor,
					   // clase_vista:'pagina_persona'
					}	
		
				},
				tipo:'ComboTrigger',
				form:true,
				id_grupo:1,
				filtro_0:false,
				//filtro_1:true,
				filterColValue:'INSTIT.nombre#INSTIT2.nombre'
			};

	
		Atributos[17]={
			validacion:{
			name:'id_gestion',
			fieldLabel:'Gestión',
			allowBlank:false,			
			//emptyText:'id_gestion...',
			desc: 'gestion', //indica la columna del store principal ds del que proviane la descripcion
			store:ds_gestion,
			valueField: 'id_gestion',
			displayField: 'desc_gestion',
			queryParam: 'filterValue_0',
			filterCol:'GESTIO.gestion',
			typeAhead:true,
			tpl:tpl_id_gestion,
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
			renderer:render_id_gestion,
			grid_visible:true,
			grid_editable:false,
			width_grid:100,
			width:150,
			disabled:false		
		},
		tipo:'ComboBox',
		form: true,
		filtro_0:true,
		filterColValue:'GESTIO.gestion',
		id_grupo:1
		
	};
		Atributos[18]={
				validacion:{
				name:'id_persona',
				fieldLabel:'Pers. Acreedor',
				allowBlank:true,			
				emptyText:'Persona...',
				desc: 'desc_person', //indica la columna del store principal ds del que proviane la descripcion
				store:ds_persona,
				valueField: 'id_persona',
				displayField: 'desc_per',
				queryParam: 'filterValue_0',
				filterCol:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
				typeAhead:false,
				tpl:tpl_id_persona,
				forceSelection:false,
				mode:'remote',
				queryDelay:200,
				pageSize:100,
				minListWidth:'100%',
				grow:true,
				resizable:true,
				queryParam:'filterValue_0',
				minChars:1, ///caracteres minimos requeridos para iniciar la busqueda
				triggerAction:'all',
				editable:true,
				renderer:render_id_persona,
				grid_visible:false,
				grid_editable:false,
				width_grid:100,
				width:200,
				disabled:false,
				grid_indice:13,
				confTrigguer:{
						url:direccion+'../../../../sis_seguridad/vista/persona/persona.php',
					    paramTri:'prueba:XXX',		
					    title:'Personas',
					    param:{width:800,height:800},
					    idContenedor:idContenedor,
					   // clase_vista:'pagina_persona'
					}		
			},
			tipo:'ComboTrigger',
			form: true,
			filtro_0:false,
			//filtro_1:true,
			filterColValue:'PERSON.apellido_paterno#PERSON.apellido_materno#PERSON.nombre',
			id_grupo:1
			
		};
	
		Atributos[20]={
				validacion:{
					name:'id_lugar',
					fieldLabel:'Lugar Cobranza',
					allowBlank:false,
					//emptyText:'Presupuesto...',
					desc: 'nombre_lugar', //indica la columna del store principal ds del que proviane la descripcion
					store:ds_lugar,
					valueField: 'id_lugar',
					displayField: 'nombre',
					queryParam: 'filterValue_0',
					filterCol:'LUGARR.nombre',
					typeAhead:false,
					tpl:tpl_id_lugar,
					forceSelection:true,
					mode:'remote',
					queryDelay:360,
					pageSize:10,
					minListWidth:400,
					confTrigguer:{
						url:direccion+'../../../../sis_seguridad/vista/lugar/lugarMZM.php',
					    paramTri:'prueba:XXX',		
					    title:'Lugar Cobranza',
					    param:{width:800,height:800},
					    idContenedor:idContenedor,
					   // clase_vista:'pagina_persona'
				},
					grow:true,
					resizable:true,
					queryParam:'filterValue_0',
					minChars:3, ///caracteres mï¿½nimos requeridos para iniciar la busqueda
					triggerAction:'all',
					editable:true,
					renderer:render_id_lugar,
					grid_visible:true,
					grid_editable:false,
					width_grid:400,
					grid_indice:4,
					width:'100%'
				},
				tipo:'ComboTrigger',
				form: true,
				filtro_0:true,
				filterColValue:'LUGARR.nombre',
				id_grupo:1
			};
		


		//////////////////////////////////////////////////////////////
		// ----------            FUNCIONES RENDER    ---------------//
		//////////////////////////////////////////////////////////////
		function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

		//---------- INICIAMOS LAYOUT DETALLE
		var config={titulo_maestro:'obligacion',
		grid_maestro:'grid-'+idContenedor,
		urlHijo:'../../../sis_kardex_personal/vista/columna_partida_ejecucion/columna_partida_ejecucion.php'};
		var layout_obligacion=new DocsLayoutMaestroDeatalle(idContenedor,idContenedorPadre);
		layout_obligacion.init(config);

		////////////////////////
		// INICIAMOS HERENCIA //
		////////////////////////


		this.pagina=Pagina;
		//-- pagina (array PARAMETROS DE CONFIGURACION, array DEFINICION DE ATRIBUTOS, SELECTION MODEL, DATA STORE, COLUM MODEL)
		this.pagina(paramConfig,Atributos,ds,layout_obligacion,idContenedor);
		var getComponente=this.getComponente;
		var getSelectionModel=this.getSelectionModel;
		var cm_EnableSelect=this.EnableSelect;
		var CM_btnNew=this.btnNew;
		var CM_ocultarGrupo=this.ocultarGrupo;
		var CM_mostrarGrupo=this.mostrarGrupo;
		var CM_ocultarComponente=this.ocultarComponente;
		var CM_mostrarComponente=this.mostrarComponente;
		var ClaseMadre_conexionFailure=this.conexionFailure;
		var CM_btnEdit=this.btnEdit;
		var dialog= this.getDialog;
		///////////////////////////////////
		// DEFINICIÓN DE LA BARRA DE MENÚ//
		///////////////////////////////////

		var paramMenu={
			guardar:{crear:true,separador:false},
			nuevo:{crear:true,separador:true},
			editar:{crear:true,separador:false},
			eliminar:{crear:true,separador:false},
			actualizar:{crear:true,separador:false}
		};


		//////////////////////////////////////////////////////////////////////////////
		//----------------------  DEFINICIÓN DE FUNCIONES ------------------------- //
		//  aquí se parametrizan las funciones que se ejecutan en la clase madre    //
		//////////////////////////////////////////////////////////////////////////////

		//datos necesarios para el filtro
		var paramFunciones={
			btnEliminar:{url:direccion+'../../../control/obligacion/ActionEliminarObligacion.php'},
			Save:{url:direccion+'../../../control/obligacion/ActionGuardarObligacion.php'},
			ConfirmSave:{url:direccion+'../../../control/obligacion/ActionGuardarObligacion.php'},
			Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:400,minWidth:150,minHeight:200,	closable:true,titulo:'Obligacion',
			grupos:
			[{tituloGrupo:'Datos Fijos',columna:0,id_grupo:0},
			{tituloGrupo:'Datos Editables',columna:0,id_grupo:1}
			]
			}};
			//-------------- DEFINICIÓN DE FUNCIONES PROPIAS --------------//


			//funcion de reload

			this.EnableSelect=function(sm,row,rec){
				cm_EnableSelect(sm,row,rec);
				_CP.getPagina(layout_obligacion.getIdContentHijo()).pagina.reload(rec.data);
				_CP.getPagina(layout_obligacion.getIdContentHijo()).pagina.desbloquearMenu();
				enable(sm, row, rec);
			}


			this.reload=function(params){


				var datos=Ext.urlDecode(decodeURIComponent(params));
				maestro.id_planilla=datos.id_planilla;


				Atributos[1].defecto=maestro.id_planilla;
				/*
				paramFunciones={
				btnEliminar:{url:direccion+'../../../control/planilla_presupuesto/ActionEliminarPlanillaPresupuesto.php',parametros:'&m_id_planilla='+maestro.id_planilla},
				Save:{url:direccion+'../../../control/planilla_presupuesto/ActionGuardarPlanillaPresupuesto.php',parametros:'&m_id_planilla='+maestro.id_planilla},
				ConfirmSave:{url:direccion+'../../../control/planilla_presupuesto/ActionGuardarPlanillaPresupuesto.php',parametros:'&m_id_planilla='+maestro.id_planilla},
				Formulario:{html_apply:'dlgInfo-'+idContenedor,height:300,width:400,minWidth:150,minHeight:200,closable:true,titulo:'Presupuesto'}};

				*/



				this.InitFunciones(paramFunciones);

				ds.lastOptions={
					params:{
						start:0,
						limit: paramConfig.TamanoPagina,
						CantFiltros:paramConfig.CantFiltros,
						id_planilla:maestro.id_planilla
					}
				};

				this.btnActualizar()
			}

			this.btnNew=function(){  
				dialog().resizeTo(450,270);
				getComponente('id_tipo_obligacion').enable();
				CM_ocultarGrupo('Datos Editables');
				CM_mostrarGrupo('Datos Fijos');
				CM_ocultarComponente(getComponente('id_cuenta'));
				CM_ocultarComponente(getComponente('id_auxiliar'));
				
					
				getComponente('id_cuenta').allowBlank=true;
				getComponente('id_auxiliar').allowBlank=true;
				getComponente('id_cuenta_bancaria').allowBlank=true;
				if(maestro.id_planilla==0){ //pago de obligaciones con desembolso unico por gestion
					
					ds_id_tipo_obligacion.baseParams={
						pago_unico:'simple'
					}
					ds_id_tipo_obligacion.modificado=true;
					CM_mostrarComponente(getComponente('id_gestion'));
					getComponente('id_gestion').allowBlank=false;
					
				}else{
					CM_ocultarComponente(getComponente('id_gestion'));
					getComponente('id_gestion').allowBlank=true;
					getComponente('id_gestion').reset();
				}
				CM_ocultarComponente(getComponente('obs_pago'));
				CM_ocultarComponente(getComponente('id_institucion_acreedor'));
				CM_ocultarComponente(getComponente('id_persona'));
				CM_ocultarComponente(getComponente('id_lugar'));
				CM_btnNew();
			}

			
			this.btnEdit=function(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){
					var SelectionsRecord=sm.getSelected();
					getComponente('accion_obli').setValue('');
					CM_ocultarGrupo('Datos Editables');
					CM_mostrarGrupo('Datos Fijos');
					CM_mostrarComponente(getComponente('id_cuenta'));
					CM_mostrarComponente(getComponente('id_auxiliar'));
					CM_ocultarComponente(getComponente('obs_pago'));
					CM_ocultarComponente(getComponente('id_institucion_acreedor'));
					CM_ocultarComponente(getComponente('id_persona'));
					CM_ocultarComponente(getComponente('id_lugar'));
					getComponente('id_tipo_obligacion').disable();
					
					getComponente('id_cuenta').enable();
	    			filterCols_obligacion[0]='GESTION.id_gestion';
	    			filterValues_obligacion[0]=maestro.id_gestion;
	    			getComponente('id_cuenta_bancaria').allowBlank=true;
	    			
	    			if(maestro.id_planilla==0){ //pago de obligaciones con desembolso unico por gestion
						ds_id_tipo_obligacion.baseParams={
							pago_unico:'simple'
						}
						ds_id_tipo_obligacion.modificado=true;
						CM_mostrarComponente(getComponente('id_gestion'));
						getComponente('id_gestion').allowBlank=false;
					}else{
						CM_ocultarComponente(getComponente('id_gestion'));
						getComponente('id_gestion').allowBlank=true;
						getComponente('id_gestion').reset();
					}
	    			
					CM_btnEdit();
				}else{
					alert('Antes debe seleccionar un item');
				}
			}
			//Para manejo de eventos
			function iniciarEventosFormularios(){
				txt_fecha_pago=getComponente('fecha_pago');
				cmb_cta_bancaria=getComponente('id_cuenta_bancaria');
				cmb_institucion=getComponente('id_institucion_acreedor');
				cmb_persona=getComponente('id_persona');
				
				
				//para iniciar eventos en el formulario
				//evento de deselecion de una linea de grid
				getSelectionModel().on('rowdeselect',function(){
					if(_CP.getPagina(layout_obligacion.getIdContentHijo()).pagina.limpiarStore()){
						_CP.getPagina(layout_obligacion.getIdContentHijo()).pagina.bloquearMenu()
					}
				})
				
				
				
				var FechaPago=function(e){
					cmb_cta_bancaria.setValue('');
					ds_cuenta_bancaria.modificado=true;
					g_pago=parseFloat(e.value.substring(6,10));
					
					
					ds_cuenta_bancaria.baseParams={
						gestion:g_pago,
						tipo_vista:'tkp_obligacion'
					}
					ds_cuenta_bancaria.modificado=true;
				}
				
				txt_fecha_pago.on('change',FechaPago);
				
				
				var onInstitucion=function(e){
					if (e.value!=null && e.value!=undefined){
						getComponente('id_persona').reset();
					}
				}
				cmb_institucion.on('change',onInstitucion);
				
				
				var onPersona=function(e){
					if (e.value!=null && e.value!=undefined){
						getComponente('id_institucion_acreedor').reset();
					}
				}
				cmb_persona.on('change',onPersona);
			}
			
				
		function btn_solicitar_pago(){
				
				var sm=getSelectionModel();
				
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelectP=sm.getCount();
				var mm=sm.getSelections();
				var m;
				
				//[i].data[parametrosDatos[0].validacion.name];
				
				if(NumSelectP!=0){
					CM_mostrarComponente(getComponente('id_institucion_acreedor'));
					CM_mostrarComponente(getComponente('id_persona'));
					
					m_bandera='no';
					mi_array=new Array();
					for(m=0;m<NumSelectP;m++){
						
						mi_array[m]=mm[m].data['id_obligacion'];
						if(mm[m].data['id_cuenta']=='' || mm[m].data['id_cuenta']==undefined || mm[m].data['id_cuenta']==null){
							m_bandera='si';
						}
					}
					if(m_bandera=='no'){
							var SelectionsRecord=sm.getSelected(); //alert(SelectionsRecord.data.id_tipo_obligacion);
							getComponente('accion_obli').setValue('pago');
							getComponente('id_tipo_obligacion').setValue(SelectionsRecord.data.id_tipo_obligacion);
							getComponente('id_obligacion').setValue(SelectionsRecord.data.id_obligacion);
							getComponente('observaciones').setValue(SelectionsRecord.data.observaciones);
							
							CM_ocultarGrupo('Datos Fijos');
							CM_mostrarGrupo('Datos Editables');
							CM_ocultarComponente(getComponente('id_cuenta'));
							CM_ocultarComponente(getComponente('id_gestion'));
							getComponente('id_gestion').allowBlank=true;
							getComponente('id_cuenta_bancaria').allowBlank=false;
							
							CM_ocultarComponente(getComponente('id_auxiliar'));
							CM_mostrarComponente(getComponente('obs_pago')); //20jun11 - pago unico obligacion
							//CM_mostrarComponente(getComponente('id_institucion_acreedor')); // 20jun11
							//CM_mostrarComponente(getComponente('id_persona')); // 20jun11
							CM_mostrarComponente(getComponente('id_lugar')); // 20jun11
							
							getComponente('mi_array').setValue(mi_array);
							getComponente('cantidad_obligaciones').setValue(NumSelectP);
							CM_btnEdit();
							sm.clearSelections();
							NumSelectP=0;
							ds.rejectChanges();
						
							
					}else{
						alert('Es necesario registrar Cuenta/auxiliar para la obligacion que no cuente con ella');
					}
				}else{
					alert('Antes debe seleccionar un item');
				}
		}

		function btn_reporte_obligaciones(){
		
					var data='id_planilla='+maestro.id_planilla;
					window.open(direccion+'../../../control/obligacion/ActionPDFObligacionPlanilla.php?'+data)
				
			}
			
			var nombre='';
		function btn_archivo_pago(){
				
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					var data='id_planilla='+SelectionsRecord.data.id_planilla;
					var data=data+'&id_subsistema=5';
					var data=data+'&id_cuenta_bancaria='+SelectionsRecord.data.id_cuenta_bancaria;
					var data=data+'&codigo='+SelectionsRecord.data.codigo;
					if(SelectionsRecord.data.codigo=='AGUIN' || SelectionsRecord.data.codigo=='AGUIN2'){
						var data=data+'&nombre=pago_'+SelectionsRecord.data.id_planilla+'_'+SelectionsRecord.data.codigo+'_'+SelectionsRecord.data.codigo+'_'+SelectionsRecord.data.desc_institucion+'-'+maestro.desc_periodo+'-'+maestro.gestion+'.txt';
					}else{
					    var data=data+'&nombre=pago_'+SelectionsRecord.data.id_planilla+'_'+SelectionsRecord.data.codigo+'_'+SelectionsRecord.data.desc_institucion+'-'+maestro.desc_periodo+'-'+maestro.gestion+'.txt';
					}
					
					if(SelectionsRecord.data.codigo=='AGUIN' || SelectionsRecord.data.codigo=='AGUIN2'){
						nombre='pago_'+SelectionsRecord.data.id_planilla+'_'+SelectionsRecord.data.codigo+'_'+SelectionsRecord.data.codigo+'_'+SelectionsRecord.data.desc_institucion+'-'+maestro.desc_periodo+'-'+maestro.gestion+'.txt';
					}else{
						nombre='pago_'+SelectionsRecord.data.id_planilla+'_'+SelectionsRecord.data.codigo+'_'+SelectionsRecord.data.desc_institucion+'-'+maestro.desc_periodo+'-'+maestro.gestion+'.txt';
					}
					
					
						Ext.Ajax.request({
						url:direccion+"../../../../sis_kardex_personal/control/planilla/ActionGenerarRPrincipal.php?"+data,
						success:successGenerar,
						failure:ClaseMadre_conexionFailure,
						timeout:paramConfig.TiempoEspera
					});
					/*Ext.MessageBox.show({
					title: 'Espere Por Favor...',
					msg:"<div><img src='../../../../lib/ext-yui/resources/images/default/grid/loading.gif'/> Ejecutando...</div>",
					width:150,
					height:200,
					closable:false
				});*/
			}
			}
			
			function btn_sol_pago_obl(){
				var sm=getSelectionModel();
				var filas=ds.getModifiedRecords();
				var cont=filas.length;
				var NumSelect=sm.getCount();
				if(NumSelect!=0){

					var SelectionsRecord=sm.getSelected();
					var data='id_obligacion='+SelectionsRecord.data.id_obligacion;
					
					window.open(direccion+'../../../control/obligacion/ActionPDFSolicitudPagoObligacion.php?'+data)
				
						
			}else {
				alert ("Elija la obligación");
			}
					
					
			}
			
		function successGenerar(resp){ 
			
		  window.open(direccion+'../../../../sis_kardex_personal/control/planilla/archivos/planta/'+nombre);
	}
		
			
			//para que los hijos puedan ajustarse al tamaño
			this.getLayout=function(){return layout_obligacion.getLayout()};
			this.Init(); //iniciamos la clase madre
			this.InitBarraMenu(paramMenu);
			//InitBarraMenu(array DE PARÁMETROS PARA LAS FUNCIONES DE LA CLASE MADRE);
			this.InitFunciones(paramFunciones);
			//carga datos XML
			
 			var CM_getBoton=this.getBoton;
			//para agregar botones
			this.AdicionarBoton('../../../lib/imagenes/book_next.png','Solicitar Pago',btn_solicitar_pago,true,'solicitar_pago','');
	
			
			
			
			function  enable(sel,row,selected){
				var record=selected.data;
				
				var NumSelect = sel.getCount(); //recupera la cantidad de filas selecionadas
				var filas=ds.getModifiedRecords();

				if(selected&&record!=-1){
					if(record.estado_reg!='borrador'){
						CM_getBoton('solicitar_pago-'+idContenedor).disable();
					}else {
						CM_getBoton('solicitar_pago-'+idContenedor).enable();
					}
					
					if(record.codigo=='SUELLIQ' || record.codigo=='QUINCENA' || record.codigo=='AGUIN' || record.codigo=='ANTICIPADO' || record.codigo=='AGUIN2' || record.codigo=='REFRIGERIO'){// aguin adicionado 19dic11
						CM_getBoton('archivo_pago-'+idContenedor).enable();
					}else{
						CM_getBoton('archivo_pago-'+idContenedor).disable();
					}
					
				}
			}
			if(maestro.id_planilla>0){
				this.AdicionarBoton('../../../lib/imagenes/print.gif','Reporte de Obligaciones',btn_reporte_obligaciones,true,'ver_reporte_obligaciones','Reporte Obligaciones');
			
			
				this.AdicionarBoton('../../../lib/imagenes/copy.png','Archivo Pago',btn_archivo_pago,true,'archivo_pago','Archivo de Pago TXT');
				
				this.AdicionarBoton('../../../lib/imagenes/print.gif','Solicitud Pago Obligación',btn_sol_pago_obl,true,'archivo_pago','Solicitud Pago Obligación');
			} 
			
			this.iniciaFormulario();
			iniciarEventosFormularios();
			
			
			ds.load({
				params:{
					start:0,
					limit: paramConfig.TamanoPagina,
					CantFiltros:paramConfig.CantFiltros,
					id_planilla:maestro.id_planilla
				}
			});
			layout_obligacion.getLayout().addListener('layout',this.onResize);//aregla la forma en que se ve el grid dentro del layout
			if(maestro.id_planilla==0){
				ContenedorPrincipal.getContenedorPrincipal().addListener('layout',this.onResizePrimario);
			}else{
				_CP.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);
			}
}

