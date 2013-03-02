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
    const ENTITY_PROJECT = 'project';
    const ENTITY_RUBRIC  = 'rublric';
    const ENTITY_FILIAL  = 'filial';
    const ENTITY_FIRM    = 'firm';

    public static $table = 'row_entitys';
}