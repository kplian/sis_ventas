CREATE OR REPLACE FUNCTION "ven"."ft_pedido_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		Sistema de Ventas
 FUNCION: 		ven.ft_pedido_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ven.tpedido'
 AUTOR: 		 (admin)
 FECHA:	        05-11-2013 06:34:26
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:

 DESCRIPCION:	
 AUTOR:			
 FECHA:		
***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
			    
BEGIN

	v_nombre_funcion = 'ven.ft_pedido_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'VEN_PEDIDO_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		05-11-2013 06:34:26
	***********************************/

	if(p_transaccion='VEN_PEDIDO_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						pedido.id_pedido,
						pedido.id_sucursal,
						pedido.id_cliente,
						pedido.id_moneda,
						pedido.forma_pago,
						pedido.estado,
						pedido.fecha,
						pedido.codigo,
						pedido.tipo_pago,
						pedido.monto_pagado,
						pedido.precio_total,
						pedido.estado_reg,
						pedido.destinatario,
						pedido.direccion,
						pedido.fecha_reg,
						pedido.id_usuario_reg,
						pedido.id_usuario_mod,
						pedido.fecha_mod,
						pedido.usr_reg,
						pedido.usr_mod,
						pedido.desc_sucursal,
						pedido.desc_cliente,
						pedido.desc_moneda,
						pedido.id_sucursal_dest,
						pedido.id_lugar,
						pedido.telef_destinatario,
						pedido.obs_destinatario,
						pedido.desc_sucursal_dest,
						pedido.desc_lugar
						from ven.vpedido pedido
				        where ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'VEN_PEDIDO_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		05-11-2013 06:34:26
	***********************************/

	elsif(p_transaccion='VEN_PEDIDO_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_pedido)
					    from ven.vpedido pedido
					    where ';
			
			--Definicion de la respuesta		    
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;
					
	else
					     
		raise exception 'Transaccion inexistente';
					         
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
ALTER FUNCTION "ven"."ft_pedido_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
