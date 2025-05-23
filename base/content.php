<?php

$option=$_GET['op']??'01';//01 es la primera vez en entrar
if($user)
	switch($option){
		case '00':include('salir.php');break;
		case '10':include('../content/books_list.php');break;
		case '11':include('../content/book_new.php');break;
		case '12':include('../content/book_modify.php');break;
		case '13':include('../content/book_delete.php');break;
	}
?>
