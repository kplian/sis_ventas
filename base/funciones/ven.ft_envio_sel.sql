CREATE OR REPLACE FUNCTION "ven"."ft_envio_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		Sistema de Ventas
 FUNCION: 		ven.ft_envio_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ven.tenvio'
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

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
			    
BEGIN

	v_nombre_funcion = 'ven.ft_envio_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'VEN_ENVMER_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		21-11-2013 19:20:49
	***********************************/

	if(p_transaccion='VEN_ENVMER_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						envmer.id_envio,
						envmer.fecha,
						envmer.id_persona_dest,
						envmer.codigo,
						envmer.observaciones,
						envmer.descripcion,
						envmer.estado_reg,
						envmer.id_sucursal,
						envmer.medio,
						envmer.id_persona_rmte,
						envmer.id_proveedor,
						envmer.id_usuario_reg,
						envmer.fecha_reg,
						envmer.id_usuario_mod,
						envmer.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
						pro.desc_proveedor,
						per.nombre_completo1 as desc_person_rmte,
						per1.nombre_completo1 as desc_person_dest,
						suc.descripcion as desc_sucursal	
						from ven.tenvio envmer
						inner join segu.tusuario usu1 on usu1.id_usuario = envmer.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = envmer.id_usuario_mod
						left join param.vproveedor pro on pro.id_proveedor = envmer.id_proveedor
						inner join segu.vpersona per on per.id_persona = envmer.id_persona_rmte
						inner join segu.vpersona per1 on per1.id_persona = envmer.id_persona_dest
						inner join ven.tsucursal suc on suc.id_sucursal = envmer.id_sucursal
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'VEN_ENVMER_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		21-11-2013 19:20:49
	***********************************/

	elsif(p_transaccion='VEN_ENVMER_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_envio)
					    from ven.tenvio envmer
					    inner join segu.tusuario usu1 on usu1.id_usuario = envmer.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = envmer.id_usuario_mod
						left join param.vproveedor pro on pro.id_proveedor = envmer.id_proveedor
						inner join segu.vpersona per on per.id_persona = envmer.id_persona_rmte
						inner join segu.vpersona per1 on per1.id_persona = envmer.id_persona_dest
						inner join ven.tsucursal suc on suc.id_sucursal = envmer.id_sucursal
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
ALTER FUNCTION "ven"."ft_envio_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
