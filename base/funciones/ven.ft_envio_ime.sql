CREATE OR REPLACE FUNCTION "ven"."ft_envio_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Sistema de Ventas
 FUNCION: 		ven.ft_envio_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ven.tenvio'
 AUTOR: 		 (admin)
 FECHA:	        21-11-2013 19:20:49
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:

 DESCRIPCION:	
 AUTOR:			
 FECHA:		
***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_envio	integer;
			    
BEGIN

    v_nombre_funcion = 'ven.ft_envio_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'VEN_ENVMER_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		21-11-2013 19:20:49
	***********************************/

	if(p_transaccion='VEN_ENVMER_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into ven.tenvio(
			fecha,
			id_persona_dest,
			codigo,
			observaciones,
			descripcion,
			estado_reg,
			id_sucursal,
			medio,
			id_persona_rmte,
			id_proveedor,
			id_usuario_reg,
			fecha_reg,
			id_usuario_mod,
			fecha_mod
          	) values(
			v_parametros.fecha,
			v_parametros.id_persona_dest,
			v_parametros.codigo,
			v_parametros.observaciones,
			v_parametros.descripcion,
			'activo',
			v_parametros.id_sucursal,
			v_parametros.medio,
			v_parametros.id_persona_rmte,
			v_parametros.id_proveedor,
			p_id_usuario,
			now(),
			null,
			null
							
			)RETURNING id_envio into v_id_envio;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Envío de Mercadería almacenado(a) con exito (id_envio'||v_id_envio||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_envio',v_id_envio::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'VEN_ENVMER_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		21-11-2013 19:20:49
	***********************************/

	elsif(p_transaccion='VEN_ENVMER_MOD')then

		begin
			--Sentencia de la modificacion
			update ven.tenvio set
			fecha = v_parametros.fecha,
			id_persona_dest = v_parametros.id_persona_dest,
			codigo = v_parametros.codigo,
			observaciones = v_parametros.observaciones,
			descripcion = v_parametros.descripcion,
			id_sucursal = v_parametros.id_sucursal,
			medio = v_parametros.medio,
			id_persona_rmte = v_parametros.id_persona_rmte,
			id_proveedor = v_parametros.id_proveedor,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now()
			where id_envio=v_parametros.id_envio;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Envío de Mercadería modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_envio',v_parametros.id_envio::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'VEN_ENVMER_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		21-11-2013 19:20:49
	***********************************/

	elsif(p_transaccion='VEN_ENVMER_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ven.tenvio
            where id_envio=v_parametros.id_envio;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Envío de Mercadería eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_envio',v_parametros.id_envio::varchar);
              
            --Devuelve la respuesta
            return v_resp;

		end;
         
	else
     
    	raise exception 'Transaccion inexistente: %',p_transaccion;

	end if;

EXCEPTION
				
	WHEN OTHERS THEN
		v_resp='';
		v_resp = pxp.f_agrega_clave(v_resp,'mensaje',SQLERRM);
		v_resp = pxp.f_agrega_clave(v_resp,'codigo_error',SQLSTATE);
		v_resp = pxp.f_agrega_clave(v_resp,'procedimientos',v_nombre_funcion);
		raise exception '%',v_resp;
				        
END;
$BODY$
LANGUAGE 'plpgsql' VOLATILE
COST 100;
ALTER FUNCTION "ven"."ft_envio_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
