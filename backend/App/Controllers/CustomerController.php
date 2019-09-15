<?php

namespace App\Controllers;

use App\DAO\CustomersDAO;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class CustomerController{

    public function getAllCustomers(Request $request, Response $response, array $args): Response
    {
        $customerDAO = new CustomersDAO();
        $customer = $customerDAO->getAllCustomers();

        $response = $response->withJson($customer);

        return $response;
    }
}