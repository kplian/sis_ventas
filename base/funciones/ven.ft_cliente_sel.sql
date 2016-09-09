CREATE OR REPLACE FUNCTION "ven"."ft_cliente_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		Sistema de Ventas
 FUNCION: 		ven.ft_cliente_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ven.tcliente'
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

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
			    
BEGIN

	v_nombre_funcion = 'ven.ft_cliente_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'VEN_CLIENT_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		05-11-2013 00:29:31
	***********************************/

	if(p_transaccion='VEN_CLIENT_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						client.id_cliente,
						client.id_persona,
						client.codigo_hash,
						client.nit_factura,
						client.estado,
						client.estado_reg,
						client.id_institucion,
						client.codigo,
						client.fecha_reg,
						client.id_usuario_reg,
						client.id_usuario_mod,
						client.fecha_mod,
						client.usr_reg,
						client.usr_mod,
						client.nombre_completo1,
						client.nombre,
						client.persona_inst,
						client.doc_id,
						client.email,
						client.telefono1,
						client.telefono2,
						client.celular1,
						client.celular2,
						client.nombre_cliente
						from ven.vcliente client
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'VEN_CLIENT_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		05-11-2013 00:29:31
	***********************************/

	elsif(p_transaccion='VEN_CLIENT_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_cliente)
					    from ven.vcliente client
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
ALTER FUNCTION "ven"."ft_cliente_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
