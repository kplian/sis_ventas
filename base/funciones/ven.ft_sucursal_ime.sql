CREATE OR REPLACE FUNCTION "ven"."ft_sucursal_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Sistema de Ventas
 FUNCION: 		ven.ft_sucursal_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ven.tsucursal'
 AUTOR: 		 (admin)
 FECHA:	        05-11-2013 00:31:14
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
	v_id_sucursal	integer;
			    
BEGIN

    v_nombre_funcion = 'ven.ft_sucursal_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'VEN_VENRSUC_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		05-11-2013 00:31:14
	***********************************/

	if(p_transaccion='VEN_VENRSUC_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into ven.tsucursal(
			estado_reg,
			descripcion,
			codigo,
			id_usuario_reg,
			fecha_reg,
			id_usuario_mod,
			fecha_mod
          	) values(
			'activo',
			v_parametros.descripcion,
			v_parametros.codigo,
			p_id_usuario,
			now(),
			null,
			null
							
			)RETURNING id_sucursal into v_id_sucursal;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Sucursal almacenado(a) con exito (id_sucursal'||v_id_sucursal||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_sucursal',v_id_sucursal::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'VEN_VENRSUC_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		05-11-2013 00:31:14
	***********************************/

	elsif(p_transaccion='VEN_VENRSUC_MOD')then

		begin
			--Sentencia de la modificacion
			update ven.tsucursal set
			descripcion = v_parametros.descripcion,
			codigo = v_parametros.codigo,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now()
			where id_sucursal=v_parametros.id_sucursal;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Sucursal modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_sucursal',v_parametros.id_sucursal::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'VEN_VENRSUC_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		05-11-2013 00:31:14
	***********************************/

	elsif(p_transaccion='VEN_VENRSUC_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ven.tsucursal
            where id_sucursal=v_parametros.id_sucursal;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Sucursal eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_sucursal',v_parametros.id_sucursal::varchar);
              
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
ALTER FUNCTION "ven"."ft_sucursal_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
