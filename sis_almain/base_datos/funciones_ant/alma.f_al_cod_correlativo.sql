QL ---------------

CREATE OR REPLACE FUNCTION alma.f_al_cod_correlativo (
  al_cadena text
)
RETURNS text AS
$body$
/**************************************************************************
 AUTOR:           Elmer Velasquez Ovando
 FECHA:           04/07/2014
 DESCRIPCIO?N:     Dado un codigo de un movimiento cualquiera, le añ su crrelativo correspondiente
***************************************************************************/

DECLARE

 b		text[];
 aux	integer;
 tam	integer;
 res 	text;
 correlativo	integer;
BEGIN
	
        tam :=0;
		for aux IN 1..10
        loop
        	if (	(split_part(al_cadena,'-',aux) != '') AND (split_part(al_cadena,'-',aux) is not NULL)	) 
            then
            
        		b[aux] = split_part(al_cadena,'-',aux);
                tam = tam + 1;
                
            end if;
        end loop;
        
        if ( (length(b[tam])) >= 0 AND (length(b[tam])) <= 6  )
        then
        	res = al_cadena ||'01';
        else
        	correlativo = CAST(	substring(b[tam] from (length(b[tam])-1) for length(b[tam]))	AS  INT);
            correlativo = correlativo + 1;
            
            if correlativo < 10
            then
            		res = substring( al_cadena from 1 for length(al_cadena)-2 )||0||correlativo;
            else
            		res = substring( al_cadena from 1 for length(al_cadena)-2 )||correlativo;
            end if;

        end if;
        
        return res;
END;
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER;
