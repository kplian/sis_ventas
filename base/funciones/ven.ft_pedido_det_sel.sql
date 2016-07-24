CREATE OR REPLACE FUNCTION ven.ft_pedido_det_sel (
  p_administrador integer,
  p_id_usuario integer,
  p_tabla varchar,
  p_transaccion varchar
)
RETURNS varchar AS
$body$
/**************************************************************************
 SISTEMA:		Sistema de Ventas
 FUNCION: 		ven.ft_pedido_det_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'ven.tpedido_det'
 AUTOR: 		(admin)
 FECHA:	        05-11-2013 06:34:29
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

	v_nombre_funcion = 'ven.ft_pedido_det_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'VEN_DETPED_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		05-11-2013 06:34:29
	***********************************/

	if(p_transaccion='VEN_DETPED_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						detped.id_pedido_det,
						detped.id_pedido,
						detped.id_item,
						detped.id_proveedor,
						detped.id_envio,
						detped.codigo,
						detped.estado,
						detped.estado_reg,
						detped.cantidad_sol,
						detped.id_producto,
						detped.id_usuario_reg,
						detped.fecha_reg,
						detped.id_usuario_mod,
						detped.fecha_mod,
						detped.observaciones,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
						(item.codigo || '' - '' || item.nombre)::varchar as desc_item,
						prov.desc_proveedor,
						prod.descripcion,
						prod.precio_unit, 
						prod.nro_serie,
						prod.marca,
						prod.procedencia,
						prod.peso,
						prod.altura,
						prod.ancho,
						prod.largo,
						prod.id_unidad_medida_peso,	
						prod.id_unidad_medida_long,
						(umed.codigo || '' - '' || umed.descripcion)::varchar as desc_unidad_medida_peso,
						(umed1.codigo || '' - '' || umed1.descripcion)::varchar as desc_unidad_medida_long
						from ven.tpedido_det detped
						inner join segu.tusuario usu1 on usu1.id_usuario = detped.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = detped.id_usuario_mod
						left join alm.titem item on item.id_item = detped.id_item
						left join param.vproveedor prov on prov.id_proveedor = detped.id_proveedor
						left join ven.tproducto prod on prod.id_producto = detped.id_producto
						left join param.tunidad_medida umed on umed.id_unidad_medida = prod.id_unidad_medida_peso
						left join param.tunidad_medida umed1 on umed.id_unidad_medida = prod.id_unidad_medida_long
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'VEN_DETPED_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		05-11-2013 06:34:29
	***********************************/

	elsif(p_transaccion='VEN_DETPED_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_pedido_det)
					    from ven.tpedido_det detped
					    inner join segu.tusuario usu1 on usu1.id_usuario = detped.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = detped.id_usuario_mod
						left join alm.titem item on item.id_item = detped.id_item
						left join param.vproveedor prov on prov.id_proveedor = detped.id_proveedor
						left join ven.tproducto prod on prod.id_producto = detped.id_producto
						left join param.tunidad_medida umed on umed.id_unidad_medida = prod.id_unidad_medida_peso
						left join param.tunidad_medida umed1 on umed.id_unidad_medida = prod.id_unidad_medida_long
					    where ';
			
			--Definicion de la respuesta		    
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;
        
    /*********************************    
 	#TRANSACCION:  'VEN_PROD_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:			rcm
 	#FECHA:			22/11/2013
	***********************************/

	elsif(p_transaccion='VEN_PROD_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						detped.id_pedido_det,
						detped.id_pedido,
						detped.id_item,
						detped.id_proveedor,
						detped.id_envio,
						detped.codigo,
						detped.estado,
						detped.estado_reg,
						detped.cantidad_sol,
						detped.id_producto,
						detped.id_usuario_reg,
						detped.fecha_reg,
						detped.id_usuario_mod,
						detped.fecha_mod,
						detped.observaciones,
						(item.codigo || '' - '' || item.nombre)::varchar as desc_item,
						prov.desc_proveedor,
						prod.descripcion,
						prod.precio_unit, 
						prod.nro_serie,
						prod.marca,
						prod.procedencia,
						prod.peso,
						prod.altura,
						prod.ancho,
						prod.largo,
                        ped.codigo as pedido_codigo,
                        ped.desc_cliente,
                        ped.desc_sucursal,
                        ped.fecha	
						from ven.tpedido_det detped
						inner join alm.titem item on item.id_item = detped.id_item
						inner join ven.tproducto prod on prod.id_producto = detped.id_producto
                        inner join ven.vpedido ped on ped.id_pedido = detped.id_pedido
                        left join param.vproveedor prov on prov.id_proveedor = detped.id_proveedor
				        where detped.estado = ''adquirido'' 
                        and ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;
        
    /*********************************    
 	#TRANSACCION:  'VEN_PROD_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:			RCM	
 	#FECHA:			22/11/2013
	***********************************/

	elsif(p_transaccion='VEN_PROD_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_pedido_det)
					    from ven.tpedido_det detped
						inner join alm.titem item on item.id_item = detped.id_item
						inner join ven.tproducto prod on prod.id_producto = detped.id_producto
                        inner join ven.vpedido ped on ped.id_pedido = detped.id_pedido
                        left join param.vproveedor prov on prov.id_proveedor = detped.id_proveedor
				        where detped.estado = ''adquirido'' 
                        and ';
			
			--Definicion de la respuesta		    
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;
		
	/*********************************    
 	#TRANSACCION:  'VEN_PEDIDE_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:			rcm	
 	#FECHA:			22/11/2013
	***********************************/

	elsif(p_transaccion='VEN_PEDIDE_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						detped.id_pedido_det,
						detped.id_pedido,
						detped.id_item,
						detped.id_proveedor,
						detped.id_envio,
						detped.codigo,
						detped.estado,
						detped.estado_reg,
						detped.cantidad_sol,
						detped.id_producto,
						detped.id_usuario_reg,
						detped.fecha_reg,
						detped.id_usuario_mod,
						detped.fecha_mod,
						detped.observaciones,
						(item.codigo || '' - '' || item.nombre)::varchar as desc_item,
						prov.desc_proveedor,
						prod.descripcion,
						prod.precio_unit, 
						prod.nro_serie,
						prod.marca,
						prod.procedencia,
						prod.peso,
						prod.altura,
						prod.ancho,
						prod.largo,
						pedido.desc_sucursal_dest,
						pedido.desc_sucursal,
						pedido.destinatario,
						pedido.desc_cliente,
						pedido.codigo as nro_pedido,
						pedido.fecha	
						from ven.tpedido_det detped
						inner join alm.titem item on item.id_item = detped.id_item
						inner join ven.tproducto prod on prod.id_producto = detped.id_producto
						inner join ven.vpedido pedido on pedido.id_pedido = detped.id_pedido
						left join param.vproveedor prov on prov.id_proveedor = detped.id_proveedor
				        where detped.estado = ''solicitado'' 
                        and ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;
		
	/*********************************    
 	#TRANSACCION:  'VEN_PEDIDE_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:			RCM	
 	#FECHA:			22/11/2013
	***********************************/

	elsif(p_transaccion='VEN_PEDIDE_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_pedido_det)
					    from ven.tpedido_det detped
						inner join alm.titem item on item.id_item = detped.id_item
						inner join ven.tproducto prod on prod.id_producto = detped.id_producto
						inner join ven.vpedido pedido on pedido.id_pedido = detped.id_pedido
						left join param.vproveedor prov on prov.id_proveedor = detped.id_proveedor
				        where detped.estado = ''solicitado'' 
                        and ';
			
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
$body$
LANGUAGE 'plpgsql'
VOLATILE
CALLED ON NULL INPUT
SECURITY INVOKER
COST 100;