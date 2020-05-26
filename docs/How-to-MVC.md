How to MVC 
=====

## Table of content

1. [Introduction](#1-introduction)
2. [What is the MVC-Pattern?](#2-what-is-the-mvc-pattern)
3. [How does it work in a technical view?]
4. [Building our own MVC-framework]


### 1. Introduction

This document will explain you the basics of the MVC pattern.
I will show you what exactly a MVC-Framework is, how it's working and finally
you will be able to build your own MVC-framework, as I introduce you to the process of
writing such an awesome framework.

You may question why you should read this document. The answer is simple,
if you want modern, stable and productive web applications or in general websites, you will have
to use a modern framework such as Laravel, Symphony, CakePHP or CodeIgniter in the perspective of PHP. All of them use
the MVC pattern. And if you don't know the pattern in the internals you won't be able to build
you're future projects right (if you choose a framework from above).

**I will assume that you have a basic understanding of OOP and PHP!
For the examples I will use the PHP 7.4 syntax e.g. strict types.**

So now let's dive right into it!



### 2. What is the MVC-Pattern?

**MVC** stands for **Model-View-Controller** is allows us developers to have a strict differentiation between, as the
name says, for the Model, View and the Controller. But what is the Model, View or the Controller, you may ask?

Lets split them up we will start with the Model.

The Model is a basicly data class with methods to manipulate the attributes of the class.

A simple example:

```php
<?php

class Motorcycle {
    // Properties of our Model
    private string $manufacture;
    private int $hp;
    private int $cc;
    private float $maxSpeed;
    private string $color;


    // Manipulation methods of our Model
    public function setManufacture(string $manufacture) {
        $this->manufacture = $manufacture;    
    }
    
    public  function getManufacture(): string {
        return $this->manufacture;
    }
}
```

Thats all, you define a data class and it have methods to manipulate the properties (later the properties will be saved in a database).
*Please note, thats a really basic example, in a complex application there is maybe some sort of buisness logic in there e.g. to manage the database connection.*

Next up is the **Controller**.

The controller is the part that will get our http request and decides what should be redirected to our model and maybe what should send to our view.

```php
<?php

class HomeController() {

    // this method is fired up if the user navigates to our root directory
    public function index() {
        // get some data from our model show the home view
    }
}
```

As you can see, the controller, controlls the applications request and responses.
