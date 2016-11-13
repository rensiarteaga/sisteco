<?php

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
var maestro={id_grupo_depreciacion:<?php echo $m_id_grupo_depreciacion;?>,
		 		 ano_fin:<?php echo $m_ano_fin;?>,
				 mes_fin:<?php echo $m_mes_fin;?>};
idContenedorPadre='<?php echo $idContenedorPadre;?>';

var elemento={idContenedor:idContenedor,pagina:new pagina_depreciacion_cbte(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)};
_CP.setPagina(elemento);
}
Ext.onReady(main,main);


function pagina_depreciacion_cbte(idContenedor,direccion,paramConfig,maestro,idContenedorPadre)
{
	var Atributos=new Array,sw=0; 
	var componentes=new Array;

	var comb_id_periodo_subsis;
	/////////////////
	//  DATA STORE //
	/////////////////
	var ds = new Ext.data.Store({
		// asigna url de donde se cargaran los datos

		proxy: new Ext.data.HttpProxy({url: direccion+'../../../control/depreciacion_depto/ActionListarDepreciacionDepto.php'}),
		// aqui se define la estructura del XML
		reader: new Ext.data.XmlReader({
			record: 'ROWS',
			id: 'id_depreciacion_depto',
			totalRecords: 'TotalCount'
		}, [
		// define el mapeo de XML a las etiqutas (campos)
		'id_depreciacion_depto','estado','comprobantes','id_cbte_depto',
		'id_depto','desc_depto','id_grupo_depreciacion'

		]),

		remoteSort: true // metodo de ordenacion remoto
	});

	
    Atributos[0] = {
		validacion:{
			labelSeparator:'',
			name: 'id_depreciacion_depto',
			inputType:'hidden',
			grid_visible:false, // se muestra en el grid
			grid_editable:false
		},
		tipo: 'Field',
		save_as:'h_id_depreciacion_depto' 
	};
	 
    Atributos[1] = {
    		validacion:{
    			fieldLabel: 'Comprobantes',
    			name: 'comprobantes',
    			width_grid:160,
    			grid_visible:true, // se muestra en el grid
    			grid_editable:false
    		},
    		tipo: 'TextField',
    		form:false,
    		filtro_0:false
    	};
	
    Atributos[2] = {
    		validacion:{
    			fieldLabel: 'Estado',
    			name: 'estado',
    			width_grid:100,
    			grid_visible:true, // se muestra en el grid
    			grid_editable:false
    		},
    		tipo: 'TextField',
    		form:false,
    		filtro_0:true,
    		filterColValue:'dd.estado'
    	};

    Atributos[3] = {
    		validacion:{
    			fieldLabel: 'Departamento Contable',
    			name: 'desc_depto',
    			width_grid:350,
    			grid_visible:true, // se muestra en el grid
    			grid_editable:false
    		},
    		tipo: 'TextField',
    		form:false,
    		filtro_0:true,
    		filterColValue:'dep.nombre_depto',
    	};
	
		
	function formatDate(value){return value?value.dateFormat('d/m/Y'):''};

	//---------- INICIAMOS LAYOUT DETALLE

	var config={titulo_maestro:' (Maestro)',grid_maestro:'grid-'+idContenedor,urlHijo:'../../../sis_activos_fijos/vista/depreciacion_depto/depreciacion_depto_det.php'};
	layout = new DocsLayoutMaestroDeatalle(idContenedor,idContenedorPadre);
	layout.init(config);

	/*var config={titulo_maestro:'Componente(Maestro) ',grid_maestro:'grid-'+idContenedor};
	var layout = new DocsLayoutMaestro(idContenedor,idContenedorPadre);
	layout.init(config);*/
	
	//---------- INICIAMOS HERENCIA
	this.pagina = Pagina;
	this.pagina(paramConfig,Atributos,ds,layout,idContenedor);
	
	var ClaseMadre_getComponente=this.getComponente;
	var getSelectionModel=this.getSelectionModel;
	
	var CM_btnEdit=this.btnEdit;
	var CM_btnAct=this.btnActualizar;
	var CM_conexionFailure=this.conexionFailure;
	var cm_Save = this.Save;
	var enableSelect=this.EnableSelect;
	var getComponente=this.getComponente;
	//DEFINICIï¿½N DE LA BARRA DE MENï¿½
	
	var paramMenu={	actualizar:{crear:true,separador:false}	};
		

	
	var paramFunciones = {
			Save:{url:direccion+'../../../control/depreciacion_depto/ActionGuardarDepreciacionDepto.php',parametros:'&grupo_depreciacion='+maestro.id_grupo_depreciacion},
			ConfirmSave:{url:direccion+'../../../control/depreciacion_depto/ActionGuardarDepreciacionDepto.php'},
			
			Formulario:{html_apply:'dlgInfo-'+idContenedor,
				width:450,
					height:250,
					minWidth:150,
					minHeight:200,
					closable:true,
					columnas:[400],
					grupos:[
					{
						tituloGrupo:'Datos generales',
						columna:0,
						id_grupo:0
					}]
				}
		};
	
	
	//-------------- Sobrecarga de funciones --------------------//
	
	function btn_generar()
	{
		var sm=getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0)
		{
			var SelectionsRecord  = sm.getSelected(); //es el primer registro selecionado
		
			maestro.id_grupo_depreciacion = SelectionsRecord.data.id_grupo_depreciacion;

			//if(SelectionsRecord.data.estado == 'pendiente')
				cm_Save();	
				CM_btnAct();			
			//else
			//	Ext.MessageBox.alert('Estado','El registro seleccionado ya tiene comprobantes registrados !!!');
		}
		else
		{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un registro'); 
		}
			
	}
	function btn_respaldo()        
	{
		var sm=getSelectionModel();
		var filas = ds.getModifiedRecords();
		var cont = filas.length;
		var NumSelect=sm.getCount();
		if(NumSelect!=0)
		{
			var SelectionsRecord  = sm.getSelected(); //es el primer registro selecionado
			var id_grupo_depreciacion = maestro.id_grupo_depreciacion;
			var fecha_hasta = maestro.mes_fin+"/01/"+maestro.ano_fin;
			var id_dep_depto =  SelectionsRecord.data.id_depreciacion_depto;
			var desc_depto = SelectionsRecord.data.desc_depto;
			
			if(SelectionsRecord.data.estado == 'pendiente')
				Ext.MessageBox.alert('Estado','Se debe Generar comprobantes del proceso de depreciacion antes de tener el respaldo');
			else 
			{
				if(SelectionsRecord.data.estado == 'registrado')
					{
						window.open(direccion+'../../../../sis_activos_fijos/control/_reportes/depreciacion_depto/ActionPDFRespaldoDepreciacion.php?id_grupo_depreciacion='+id_grupo_depreciacion+"&fecha_hasta="+fecha_hasta+"&id_dep_depto="+id_dep_depto+"&depto="+desc_depto);
					}
			}
		}
		else
		{
			Ext.MessageBox.alert('Estado','Antes debe seleccionar un registro');
		}
	}
	
	
	function iniciarEventosFormularios()
	{
		for (var i=0;i<Atributos.length;i++){
			componentes[i]=getComponente(Atributos[i].validacion.name);
		}
	} 

	this.reload=function(params)
	{
		var datos = Ext.urlDecode(decodeURIComponent(params));

		maestro.id_grupo_depreciacion = datos.maestro_id_grupo_depreciacion;
		maestro.desc_depto = datos.maestro_desc_depto;
		maestro.mes_fin = datos.maestro_mes_fin;
		maestro.ano_fin = datos.maestro_ano_fin;

		ds.lastOptions = {
			params : {
				start : 0,
				limit : paramConfig.TamanoPagina,
				CantFiltros : paramConfig.CantFiltros,
				m_id_grupo : maestro.id_grupo_depreciacion,
				txt_mes_fin:maestro.mes_fin,
				txt_ano_fin:maestro.ano_fin	 

			}
		};
	//	_CP.getPagina(layout.getIdContentHijo()).pagina.limpiarStore();
		
		this.btnActualizar();
		this.InitFunciones(paramFunciones);
	};
	
	this.EnableSelect=function(sm,row,rec)
	{
		_CP.getPagina(layout.getIdContentHijo()).pagina.reload(rec.data);
		_CP.getPagina(layout.getIdContentHijo()).pagina.desbloquearMenu();
		enableSelect(sm,row,rec);		
	};
	
	this.getLayout=function(){return layout.getLayout()};
	//para el manejo de hijos 

	this.Init(); //iniciamos la clase madre
	this.InitBarraMenu(paramMenu);
	this.InitFunciones(paramFunciones);
	var CM_getBoton=this.getBoton;
	this.AdicionarBoton("../../../lib/imagenes/bricks.png",'<b>Generar<b>',btn_generar,true,'generar','Generar');
	
	this.AdicionarBoton("../../../lib/imagenes/print.gif",'<b>Respaldo<b>',btn_respaldo,true,'respaldo','Respaldo'); 
	this.iniciaFormulario();
	//carga datos XML
	ds.load({
		params:{ 
			start:0,
			limit: paramConfig.TamanoPagina,
			CantFiltros:paramConfig.CantFiltros,
			m_id_grupo:maestro.id_grupo_depreciacion,
			txt_mes_fin:maestro.mes_fin,
			txt_ano_fin:maestro.ano_fin
		}
	}); 
	iniciarEventosFormularios();
	layout.getLayout().addListener('layout',this.onResize);
	ContenedorPrincipal.getPagina(idContenedorPadre).pagina.getLayout().addListener('layout',this.onResizePrimario);	
}