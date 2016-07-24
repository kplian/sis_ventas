CREATE OR REPLACE FUNCTION "ven"."ft_producto_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		Sistema de Ventas
 FUNCION: 		ven.ft_producto_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ven.tproducto'
 AUTOR: 		 (admin)
 FECHA:	        15-11-2013 23:40:58
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

	v_nombre_funcion = 'ven.ft_producto_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'VEN_PROD_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		15-11-2013 23:40:58
	***********************************/

	if(p_transaccion='VEN_PROD_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						prod.id_producto,
						prod.precio_unit,
						prod.altura,
						prod.ancho,
						prod.descripcion,
						prod.codigo,
						prod.largo,
						prod.procedencia,
						prod.nro_serie,
						prod.estado_reg,
						prod.id_unidad_medida_peso,
						prod.marca,
						prod.id_unidad_medida_long,
						prod.id_item,
						prod.peso,
						prod.fecha_reg,
						prod.id_usuario_reg,
						prod.id_usuario_mod,
						prod.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod	
						from ven.tproducto prod
						inner join segu.tusuario usu1 on usu1.id_usuario = prod.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = prod.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'VEN_PROD_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		15-11-2013 23:40:58
	***********************************/

	elsif(p_transaccion='VEN_PROD_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_producto)
					    from ven.tproducto prod
					    inner join segu.tusuario usu1 on usu1.id_usuario = prod.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = prod.id_usuario_mod
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
ALTER FUNCTION "ven"."ft_producto_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
