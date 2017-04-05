<?php
/**
 * Return nav-here if current path begins with this path.
 *
 * @param string $path
 * @return string
 */
use Illuminate\Http\Request;
function setActive($path)
{
    return \Request::is($path . '*') ? ' class=active' :  '';
}

function setOpen($path)
{
    return \Request::is($path . '*') ? ' class=open' :  '';
}

function getAdminName($id)
{
    $result = \App\Admin::find($id);
    return $result['name'];
}

function reFormatDate($datetime, $format='d-m-Y H:i:s'){
    return (isset($datetime) & ($datetime != '0000-00-00 00:00:00'))? date($format, strtotime($datetime)) : '';
}