<?php
interface IEmailStrategy{
    function enviar();
    function preview();
}