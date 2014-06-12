<?php

namespace BackEnd;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use DB;

class Menu extends \Eloquent {

    protected $table = 'menu';
    public $timestamps = false;

    /**
     * Constructor. Check if user is logged in.
     */
    public function __construct() {
        if (!defined('MENU_TABLE')) {
            define('MENU_TABLE', 'menu');
            define('MENUGROUP_TABLE', 'menu_group');
            define('MENU_ID', 'id');
            define('MENU_PARENT', 'parent_id');
            define('MENU_TITLE', 'title');
            define('MENU_URL', 'url');
            define('MENU_CLASS', 'class');
            define('MENU_POSITION', 'position');
            define('MENU_GROUP', 'group_id');
            define('MENUGROUP_ID', 'id');
            define('MENUGROUP_TITLE', 'title');
        }
    }

    /**
     * Show menu manager
     */
    public function index($groupid) {
        $group_id = 1;
        if (isset($groupid)) {
            $group_id = (int) $groupid;
        }
        $menu = $this->get_menu($group_id);

        $data['menu_ul'] = '<ul id="easymm"></ul>';
        if ($menu) {
            $tree = new \BackEnd\Tree();
            foreach ($menu as $row) {
                $tree->add_row(
                        $row[MENU_ID], $row[MENU_PARENT], ' id="menu-' . $row[MENU_ID] . '" class="sortable"', $this->get_label($row)
                );
            }

            $data['menu_ul'] = $tree->generate_list('id="easymm"');
        }
        $data['group_id'] = $group_id;
        $data['group_title'] = $this->get_menu_group_title($group_id);
        $data['menu_groups'] = $this->get_menu_groups();
        return $data;
    }

    public function add_group($title_group) {
        $data[MENUGROUP_TITLE] = trim($title_group);
        if (!empty($data[MENUGROUP_TITLE])) {
            $check = DB::table('menu_group')->insertGetId(
                    array('title' => trim($title_group))
            );
            if ($check) {
                $response['status'] = 1;
                $response['id'] = $check;
            } else {
                $response['status'] = 2;
                $response['msg'] = 'Add menu group error.';
            }
        } else {
            $response['status'] = 3;
        }
        return $response;
    }

    public function edit_group($id, $title_group) {
        $id = (int) $id;
        $data[MENUGROUP_TITLE] = trim($title_group);
        $response['success'] = false;
        $check = DB::table('menu_group')
                ->where('id', $id)
                ->update(array('title' => trim($title_group)));
        if ($check) {
            $response['success'] = true;
        }
        return $response;
    }

    public function delete_group($id) {
        $id = (int) $id;
        if ($id == 1) {
            $response['success'] = false;
            $response['msg'] = 'Cannot delete Group ID = 1';
        } else {
            $delete = \DB::table('menu_group')->where('id', '=', $id)->delete();
            if ($delete) {
                \DB::table(MENU_TABLE)->where(MENU_GROUP, '=', $id)->delete();
                $response['success'] = true;
            } else {
                $response['success'] = false;
            }
        }
        return $response;
    }

    /**
     * Add menu action
     * For use with ajax
     * Return json data
     */
    public function add_menu($title, $url, $class, $group_id) {
        if (isset($title)) {
            $data[MENU_TITLE] = trim($title);
            if (!empty($data[MENU_TITLE])) {
                $data[MENU_URL] = $url;
                $data[MENU_CLASS] = $class;
                $data[MENU_GROUP] = $group_id;
                $data[MENU_POSITION] = $this->get_last_position($group_id) + 1;
                $check = DB::table('menu')->insertGetId(
                        array(
                            'title' => $data[MENU_TITLE],
                            'url' => $data[MENU_URL],
                            'class' => $data[MENU_CLASS],
                            'position' => $data[MENU_POSITION],
                            'group_id' => $data[MENU_GROUP]
                        )
                );
                if ($check) {
                    $data[MENU_ID] = $check;
                    $response['status'] = 1;
                    $li_id = 'menu-' . $check;
                    $response['li'] = '<li id="' . $li_id . '" class="sortable">' . $this->get_label($data) . '</li>';
                    $response['li_id'] = $li_id;
                } else {
                    $response['status'] = 2;
                    $response['msg'] = 'Add menu error.';
                }
            } else {
                $response['status'] = 3;
            }
            return $response;
        }
    }

    /**
     * Show edit menu form
     */
    public function edit($id) {
        if (isset($id)) {
            $id = (int) $id;
            $data = $this->where('id', '=', $id)->first();
            return $data;
        }
    }

    /**
     * Save menu
     * Action for edit menu
     * return json data
     */
    public function saveedit($title, $menu_id, $url, $class) {
        if (isset($title)) {
            $data[MENU_TITLE] = trim($title);
            if (!empty($data[MENU_TITLE])) {
                $data[MENU_ID] = $menu_id;
                $data[MENU_URL] = $url;
                $data[MENU_CLASS] = $class;
                $check = DB::table(MENU_TABLE)
                        ->where(MENU_ID, $menu_id)
                        ->update(array(MENU_TITLE => $title, MENU_URL => $url, MENU_CLASS => $class));
                if ($check) {
                    $response['status'] = 1;
                    $d['title'] = $data[MENU_TITLE];
                    $d['url'] = $data[MENU_URL];
                    $d['klass'] = $data[MENU_CLASS]; //klass instead of class because of an error in js
                    $response['menu'] = $d;
                } else {
                    $response['status'] = 2;
                    $response['msg'] = 'Edit menu error.';
                }
            } else {
                $response['status'] = 3;
            }
        }
        return $response;
    }

    /**
     * Delete menu action
     * Also delete all submenus under current menu
     * return json data
     */
    public function deletemenu($id) {
        if (isset($id)) {
            $id = (int) $id;
            $this->get_descendants($id);
            $delete = \DB::table(MENU_TABLE)->where('id', '=', $id)->delete();
            if ($delete) {
                $response['success'] = true;
            } else {
                $response['success'] = false;
            }
            return $response;
//            header('Content-type: application/json');
//            echo json_encode($response);
        }
    }

    /**
     * Save menu position
     */
    public function save_position($easymm) {
        if (isset($easymm)) {
            $easymm = $easymm;
            $this->update_position(0, $easymm);
        }
    }

    /**
     * Recursive function for save menu position
     */
    private function update_position($parent, $children) {
        $i = 1;
        foreach ($children as $k => $v) {
            $id = (int) $children[$k]['id'];
            $parent = $parent;
            $position = $i;
            DB::table(MENU_TABLE)
                    ->where('id', $id)
                    ->update(array('parent_id' => $parent, 'position' => $position));
            if (isset($children[$k]['children'][0])) {
                $this->update_position($id, $children[$k]['children']);
            }
            $i++;
        }
    }

    /**
     * Get items from menu table
     *
     * @param int $group_id
     * @return array
     */
    private function get_menu($group_id) {
        //    $sql = sprintf('SELECT * FROM %s WHERE %s = %s ORDER BY %s, %s', MENU_TABLE, MENU_GROUP, $group_id, MENU_PARENT, MENU_POSITION);
        return $this->where(MENU_GROUP, '=', $group_id)->orderBy(MENU_PARENT)->orderBy(MENU_POSITION)->get()->toArray();
    }

    /**
     * Get one item from menu table
     *
     * @param unknown_type $id
     * @return unknown
     */
//    private function get_row($id) {
//        $sql = sprintf(
//                'SELECT * FROM %s WHERE %s = %s', MENU_TABLE, MENU_ID, $id
//        );
//        return $this->db->GetRow($sql);
//    }

    /**
     * Recursive method
     * Get all descendant ids from current id
     * save to $this->ids
     *
     * @param int $id
     */
    private function get_descendants($id) {
//        $sql = sprintf(
//                'SELECT %s FROM %s WHERE %s = %s', MENU_ID, MENU_TABLE, MENU_PARENT, $id
//        );
//        $data = $this->db->GetCol($sql);
        $data = $this->where(MENU_PARENT, '=', $id)->select(MENU_ID)->get();
        if (!empty($data)) {
            foreach ($data as $v) {
                $delete = \DB::table(MENU_TABLE)->where('id', '=', $v->id)->delete();
                $this->get_descendants($v->id);
            }
        }
    }

    /**
     * Get the highest position number
     *
     * @param int $group_id
     * @return string
     */
    private function get_last_position($group_id) {
        $sql = $this->where('group_id', '=', $group_id)->where('parent_id', '=', 0)->count();
        return $sql;
    }

    /**
     * Get all items in menu group table
     *
     * @return array
     */
    public function get_menu_groups() {

        $resul = DB::table('menu_group')->get();
        return $resul;
    }

    /**
     * Get menu group title
     *
     * @param int $group_id
     * @return string
     */
    private function get_menu_group_title($group_id) {
        $resul = DB::table('menu_group')->where(MENUGROUP_ID, '=', $group_id)->first();
        return $resul->title;
    }

    /**
     * Get label for list item in menu manager
     * this is the content inside each <li>
     *
     * @param array $row
     * @return string
     */
    private function get_label($row) {
        $label = '<div class="ns-row">' .
                '<div class="ns-title">' . $row[MENU_TITLE] . '</div>' .
                '<div class="ns-url">' . $row[MENU_URL] . '</div>' .
                '<div class="ns-class">' . $row[MENU_CLASS] . '</div>' .
                '<div class="ns-actions">' .
                '<a href="#" class="edit-menu" title="' . \Lang::get('backend/title.menu.edit') . '">' .
                '<img src="' . asset('') . 'backend/templates/images/edit.png" alt="' . \Lang::get('backend/title.menu.edit') . '">' .
                '</a>' .
                '<a href="#" class="delete-menu" title="' . \Lang::get('backend/title.menu.delete') . '">' .
                '<img src="' . asset('') . 'backend/templates/images/cross.png" alt="' . \Lang::get('backend/title.menu.delete') . '">' .
                '</a>' .
                '<input type="hidden" name="menu_id" value="' . $row[MENU_ID] . '">' .
                '</div>' .
                '</div>';
        return $label;
    }

    public function easymenu($group_id, $attr = '') {
        $tree = new \BackEnd\Tree();

        $menu = $this->where('group_id', '=', $group_id)->orderBy(MENU_PARENT)->orderBy(MENU_POSITION)->get();
        foreach ($menu as $row) {
            $label = '<a href="' . $row->url . '">';
            $label .= $row->title;
            $label .= '</a>';

            $li_attr = '';
            if ($row->class) {
                $li_attr = ' class="' . $row->class . '"';
            }
            $tree->add_row($row->id, $row->parent_id, $li_attr, $label);
        }
        $menu = $tree->generate_list($attr);
        return $menu;
    }

}
