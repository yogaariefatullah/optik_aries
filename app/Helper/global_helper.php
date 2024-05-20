<?php
use App\Models\Menu;
use App\Models\Permission;

if (!function_exists('getParentName')) {
    function getParentName($id)
    {
        $menu = Menu::find($id);
        if ($menu) {
            return $menu->name;
        }else{
            return "-";
        }
    }
}

if (!function_exists('getPermission')) {
    function getPermission($id_group,$id_menu)
    {
        $permission = Permission::where('menu_id',$id_menu)->where('group_id',$id_group)->first();
        return $permission;
    }
}

if (!function_exists('getAllMenu')) {
    function getAllMenu()
    {
        $menu = Menu::whereNull('deleted_at')->orderBY('urutan','asc')->get();
        return $menu;
    }
}

if (!function_exists('getChild')) {
    function getChild($parent_id)
    {
        $menu = Menu::where('parent_id',$parent_id)->whereNull('deleted_at')->orderBY('urutan','asc')->get();
        return $menu;
    }
}   