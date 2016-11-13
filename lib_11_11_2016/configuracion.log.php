<?php 
/**
**********************************************************
Nombre del Archivo:	configuracion.log.php
Propósito:			Este archivo carga variable de activacion del registro de transacciones
             
autor:				Rensi Arteaga Copari
Fecha de Creación:	23-06-2006
Observaciones:		Debe incluirse en todos los scripts de CONTROL
**********************************************************
*/	$LOG = true;   //true activa log false desactiva
	$VER = false;   //si log activado y true activa el registro de vistas
	$ELIMINAR = true; //si log activado y true activa el registro de eliminaciones
	$INSERTAR = true;//si log activado y true activa el registro de inserciones
	$MODIFICAR = true;//si log activado y true activa el registro de modificaciones
	$EXTRA = true;//si log activado y true activa el registro de extras
/**
**********************************************************
Nombre del funcion:	captura_ip
Propósito:			Esta funcion captura  las ip de los clientes conectados
valor de retorno    realip-> la ip del cliente                    
autor:				Rensi Arteaga Copari
Fecha de Creación:	23-06-2006
Observaciones:		Debe incluirse en todos los scripts de CONTROL
**********************************************************
*/	
	function captura_ip()
	{
	/////////////captura ip usuario//////////
				if ($_SERVER) 
				{
					if ( $_SERVER[HTTP_X_FORWARDED_FOR] ) 
						{
							$realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
						} elseif ( $_SERVER["HTTP_CLIENT_IP"] )
						 {
							$realip = $_SERVER["HTTP_CLIENT_IP"];
							} 
							else
							 {
								$realip = $_SERVER["REMOTE_ADDR"];
							 }
				} 
				else
				 {
						if ( getenv( "HTTP_X_FORWARDED_FOR" ) ) 
						{
							$realip = getenv( "HTTP_X_FORWARDED_FOR" );
						} 
						elseif ( getenv( "HTTP_CLIENT_IP" ) ) 
						{
							$realip = getenv( "HTTP_CLIENT_IP" );
						} 
						else
						 {
							$realip = getenv( "REMOTE_ADDR" );
						}
				}

          	   ////////////////// fin captura $ip_ral///////////////////////
          	   return $realip;
         }?>