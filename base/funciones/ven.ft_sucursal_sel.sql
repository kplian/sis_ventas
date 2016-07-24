CREATE OR REPLACE FUNCTION "ven"."ft_sucursal_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		Sistema de Ventas
 FUNCION: 		ven.ft_sucursal_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ven.tsucursal'
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

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
			    
BEGIN

	v_nombre_funcion = 'ven.ft_sucursal_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'VEN_VENRSUC_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		05-11-2013 00:31:14
	***********************************/

	if(p_transaccion='VEN_VENRSUC_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						venrsuc.id_sucursal,
						venrsuc.estado_reg,
						venrsuc.descripcion,
						venrsuc.codigo,
						venrsuc.id_usuario_reg,
						venrsuc.fecha_reg,
						venrsuc.id_usuario_mod,
						venrsuc.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod	
						from ven.tsucursal venrsuc
						inner join segu.tusuario usu1 on usu1.id_usuario = venrsuc.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = venrsuc.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'VEN_VENRSUC_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		05-11-2013 00:31:14
	***********************************/

	elsif(p_transaccion='VEN_VENRSUC_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_sucursal)
					    from ven.tsucursal venrsuc
					    inner join segu.tusuario usu1 on usu1.id_usuario = venrsuc.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = venrsuc.id_usuario_mod
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
ALTER FUNCTION "ven"."ft_sucursal_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
