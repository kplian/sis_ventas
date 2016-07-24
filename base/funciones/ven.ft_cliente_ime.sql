CREATE OR REPLACE FUNCTION "ven"."ft_cliente_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Sistema de Ventas
 FUNCION: 		ven.ft_cliente_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ven.tcliente'
 AUTOR: 		 (admin)
 FECHA:	        05-11-2013 00:29:31
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
	v_id_cliente			integer;
	v_codigo_cli			varchar;
			    
BEGIN

    v_nombre_funcion = 'ven.ft_cliente_ime';
    v_parametros = pxp.f_get_record(p_tabla);
    v_codigo_cli = 'CL-';

	/*********************************    
 	#TRANSACCION:  'VEN_CLIENT_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		05-11-2013 00:29:31
	***********************************/

	if(p_transaccion='VEN_CLIENT_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into ven.tcliente(
			id_persona,
			nit_factura,
			estado,
			estado_reg,
			id_institucion,
			fecha_reg,
			id_usuario_reg,
			id_usuario_mod,
			fecha_mod
          	) values(
			v_parametros.id_persona,
			v_parametros.nit_factura,
			'activo',
			'activo',
			v_parametros.id_institucion,
			now(),
			p_id_usuario,
			null,
			null
			) RETURNING id_cliente into v_id_cliente;
			
			UPDATE ven.tcliente SET
			codigo = v_codigo_cli || pxp.f_llenar_ceros(v_id_cliente::numeric,6),
			codigo_hash = md5(v_id_cliente::varchar||random()::varchar)
			where id_cliente = v_id_cliente;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Cliente almacenado(a) con exito (id_cliente'||v_id_cliente||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_cliente',v_id_cliente::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'VEN_CLIENT_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		05-11-2013 00:29:31
	***********************************/

	elsif(p_transaccion='VEN_CLIENT_MOD')then

		begin
			--Sentencia de la modificacion
			update ven.tcliente set
			id_persona = v_parametros.id_persona,
			codigo_hash = v_parametros.codigo_hash,
			nit_factura = v_parametros.nit_factura,
			id_institucion = v_parametros.id_institucion,
			codigo = v_parametros.codigo,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now()
			where id_cliente=v_parametros.id_cliente;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Cliente modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_cliente',v_parametros.id_cliente::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'VEN_CLIENT_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		05-11-2013 00:29:31
	***********************************/

	elsif(p_transaccion='VEN_CLIENT_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ven.tcliente
            where id_cliente=v_parametros.id_cliente;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Cliente eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_cliente',v_parametros.id_cliente::varchar);
              
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
ALTER FUNCTION "ven"."ft_cliente_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
