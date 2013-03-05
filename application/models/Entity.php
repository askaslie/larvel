<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mr. White
 * Date: 28.02.13
 * Time: 11:12
 * To change this template use File | Settings | File Templates.
 */
class Entity extends Eloquent
{
    const ENTITY_PROJECT = 1;
    const ENTITY_RUBRIC  = 2;
    const ENTITY_FILIAL  = 3;
    const ENTITY_FIRM    = 4;

    public static $table = 'row_entitys';
}