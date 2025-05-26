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
		//cases ajenos a mi parte xd 
		case '30':include('../content/provider.php');
		break;
		case '31':include('../content/provider_new.php');
		break;//funciones provedores NEW
		case '32':include('..//content/provider_modify.php');
		break;//funciones provedores MODIFICAR
		case '33':include('../content/provider_delete.php');
		break;//funciones provedores DELETE
	}
?>
