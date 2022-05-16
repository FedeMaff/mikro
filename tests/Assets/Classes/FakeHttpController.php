<?php

namespace MikroTest\Assets\Classes;

use Mikro\Controller\HttpController;

class FakeHttpController extends HttpController
{
    protected static string $method = 'POST';
    protected static string $path = '/microservizio/v1/customers';
}
