CREATE OR REPLACE FUNCTION "ven"."ft_venta_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Sistema de Ventas
 FUNCION: 		ven.ft_venta_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'ven.tventa'
 AUTOR: 		 (admin)
 FECHA:	        08-12-2013 03:17:19
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
	v_id_venta	integer;
			    
BEGIN

    v_nombre_funcion = 'ven.ft_venta_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'VEN_VEN_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		08-12-2013 03:17:19
	***********************************/

	if(p_transaccion='VEN_VEN_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into ven.tventa(
			id_cliente,
			id_moneda,
			fac_nit,
			id_factura,
			fac_nro_autoriz,
			fac_nro,
			estado_reg,
			nit_factura,
			estado,
			fecha,
			id_usuario_reg,
			fecha_reg,
			fecha_mod,
			id_usuario_mod
          	) values(
			v_parametros.id_cliente,
			v_parametros.id_moneda,
			v_parametros.fac_nit,
			v_parametros.id_factura,
			v_parametros.fac_nro_autoriz,
			v_parametros.fac_nro,
			'activo',
			v_parametros.nit_factura,
			v_parametros.estado,
			v_parametros.fecha,
			p_id_usuario,
			now(),
			null,
			null
							
			)RETURNING id_venta into v_id_venta;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Venta almacenado(a) con exito (id_venta'||v_id_venta||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_venta',v_id_venta::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'VEN_VEN_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		08-12-2013 03:17:19
	***********************************/

	elsif(p_transaccion='VEN_VEN_MOD')then

		begin
			--Sentencia de la modificacion
			update ven.tventa set
			id_cliente = v_parametros.id_cliente,
			id_moneda = v_parametros.id_moneda,
			fac_nit = v_parametros.fac_nit,
			id_factura = v_parametros.id_factura,
			fac_nro_autoriz = v_parametros.fac_nro_autoriz,
			fac_nro = v_parametros.fac_nro,
			nit_factura = v_parametros.nit_factura,
			estado = v_parametros.estado,
			fecha = v_parametros.fecha,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario
			where id_venta=v_parametros.id_venta;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Venta modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_venta',v_parametros.id_venta::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'VEN_VEN_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		08-12-2013 03:17:19
	***********************************/

	elsif(p_transaccion='VEN_VEN_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from ven.tventa
            where id_venta=v_parametros.id_venta;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Venta eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_venta',v_parametros.id_venta::varchar);
              
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
ALTER FUNCTION "ven"."ft_venta_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
