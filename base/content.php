<?php

$option=$_GET['op']??'01';//01 es la primera vez en entrar
if($user)
	switch($option){
		case '00':include('salir.php');
		break;
		case '10':include('../content/libros/book_list.php');
		break;
		case '11':include('../content/libros/book_new.php');
		break;
		case '12':include('../content/libros/book_modify.php');
		break;
		case '13':include('../content/libros/book_delete.php');
		break;

		case '20':include('../content/clientes/client_list.php');break;
		case '21':include('../content/clientes/client_new.php');break;
		case '22':include('../content/clientes/client_modify.php');break;
		case '23':include('../content/clientes/client_delete.php');break;
		//cases ajenos a mi parte xd 
		case '30':include('../content/proveedores/provider.php');
		break;
		case '31':include('../content/proveedores/provider_new.php');
		break;//funciones provedores NEW
		case '32':include('../content/proveedores/provider_modify.php');
		break;//funciones provedores MODIFICAR
		case '33':include('../content/proveedores/provider_delete.php');
		break;//funciones provedores DELETE

		case '61':include('../content/editoriales/editorial_new.php');break;
		case '62':include('../content/editoriales/editorial_modify.php');break;

		case '71':include('../content/autores/autor_new.php');break;
		case '72':include('../content/autores/autor_modify.php');break;
	}
?>
