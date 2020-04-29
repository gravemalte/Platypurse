<?php


namespace Lemon\src\Compiler;


interface ICompiler {

    function compile(): void;

    function render(): void;

}