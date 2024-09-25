<?php session_start();
include 'db.php';
ob_start();

//error_reporting(E_ALL);
    
    spl_autoload_register(function ($class_name) {
        include $class_name . '.php';
    });

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReadnShare</title>
    <link href='https://fonts.googleapis.com/css?family=Allan' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

</head>
<body style="overflow-x:hidden;">

    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand mx-4" href="index.php">ReadnShare</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item mx-4">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item mx-4">
                        <a class="nav-link active" aria-current="page" href="#">Books</a>
                    </li>
                    <li class="nav-item dropdown mx-4">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Genre
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Novel</a></li>
                            <li><a class="dropdown-item" href="#">Poetry</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Romance</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown mx-4">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Category
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Children</a></li>
                            <li><a class="dropdown-item" href="#">Adults</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Academic</a></li>
                        </ul>
                    </li>
                    
                </ul>
                <div class="d-flex flex-column w-25" style="margin-right:80px;">
                    <form class="d-flex my-2" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                    <div class="d-flex justify-content-center">
                    <div class="dropdown mx-2 w-50">
                        <button type="button" class="btn btn-success dropdown-toggle w-100" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                            Sign In
                        </button>
                        <form class="dropdown-menu p-4 mt-2" style="width:250px;">
                            <div class="mb-3">
                            <label for="exampleDropdownFormEmail" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="exampleDropdownFormEmail" placeholder="email@example.com">
                            </div>
                            <div class="mb-3">
                            <label for="exampleDropdownFormPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="exampleDropdownFormPassword" placeholder="Password">
                            </div>
                            <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="dropdownCheck2">
                                <label class="form-check-label" for="dropdownCheck2">
                                Remember me
                                </label>
                            </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Sign in</button>
                        </form>
                    </div>
                    <div class="dropdown mx-2 w-50">
                        <button type="button" class="btn btn-success dropdown-toggle w-100" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
                            Sign Up
                        </button>
                        <form class="dropdown-menu p-4 mt-2" style="width:250px;">
                            <div class="mb-3">
                            <label for="exampleDropdownFormName2" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="exampleDropdownFormName2" placeholder="John">
                            </div>
                            <div class="mb-3">
                            <label for="exampleDropdownFormLastName2" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="exampleDropdownFormLastName2" placeholder="Doe">
                            </div>
                            <div class="mb-3">
                            <label for="exampleDropdownFormEmail2" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="exampleDropdownFormEmail2" placeholder="email@example.com">
                            </div>
                            <div class="mb-3">
                            <label for="exampleDropdownFormPassword2" class="form-label">Password</label>
                            <input type="password" class="form-control" id="exampleDropdownFormPassword2" placeholder="Password">
                            </div>
                            <button type="submit" class="btn btn-primary">Sign Up</button>
                        </form>
                    </div>


                    </div>
                    
                    
                </div>
                
                </div>
            </div>
        </nav>
    </header>
    