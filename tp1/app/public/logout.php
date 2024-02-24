<?php

require_once '../vendor/autoload.php';

    use App\Page;
    
    $page = new Page();

    $page->session->destroy();

    header('location: index.php');
   
