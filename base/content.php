<?php

$option = $_GET['op'] ?? '01'; //01 es la primera vez en entrar
if ($user)
	switch ($option) {

		// Casos libros
		case '00': include('salir.php'); break;
		case '10': include('../content/libros/book_list.php');break;
		case '11': include('../content/libros/book_new.php'); break;
		case '12': include('../content/libros/book_modify.php'); break;
		case '13': include('../content/libros/book_delete.php'); break;

		// Casos clientes
		case '20': include('../content/clientes/client_list.php'); break;
		case '21': include('../content/clientes/client_new.php'); break;
		case '22': include('../content/clientes/client_modify.php'); break;
		case '23': include('../content/clientes/client_delete.php'); break;
		
		//Casos proveedores
		case '30': include('../content/proveedores/provider.php'); break;
		case '31': include('../content/proveedores/provider_new.php'); break; //funciones provedores NEW
		case '32': include('../content/proveedores/provider_modify.php'); break; //funciones provedores MODIFICAR
		case '33': include('../content/proveedores/provider_delete.php'); break; //funciones provedores DELETE

		// Casos compras
		case '40':include('../content/compras/compras_list.php');break;
		case '43':include('../content/compras/compras_new.php');break;
		case '44':include('../content/compras/compras_new_commit.php');break;
		case '45':include('../content/compras/compras_delete.php');break;
		case '46':include('../content/compras/detalles_compra.php');break;

		case '41': include('../content/paises/countries_new.php'); break;
		case '42': include('../content/paises/countries_modify.php'); break;
		
		// Casos ventas
		case '50':include('../content/ventas/ventas_list.php');break;
		case '53':include('../content/ventas/ventas_new.php');break;
		case '54':include('../content/ventas/ventas_new_commit.php');break;
		case '55':include('../content/ventas/ventas_delete.php');break;
		case '56':include('../content/ventas/detalles_venta.php');break;

		// Casos de lenguajes
		case '57': include('../content/lenguajes/lenguage_list.php'); break;
		case '51': include('../content/lenguajes/lenguage_new.php'); break;
		case '52': include('../content/lenguajes/lenguage_modify.php'); break;

		// Casos de editoriales
		case '61': include('../content/editoriales/editorial_new.php'); break;
		case '62': include('../content/editoriales/editorial_modify.php'); break;

		// Casos de autores
		case '71': include('../content/autores/autor_new.php'); break;
		case '72': include('../content/autores/autor_modify.php'); break;

		// Casos de usuarios
		case '80': include('../content/usuarios/user_list.php'); break;
		case '81': include('../content/usuarios/user_new.php'); break;
		case '82': include('../content/usuarios/user_modify.php'); break;
		case '83': include('../content/usuarios/user_delete.php');break;


		case '90': include('../content/paises/countries_list.php'); break;
	}