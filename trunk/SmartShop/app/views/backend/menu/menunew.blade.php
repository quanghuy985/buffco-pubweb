@extends("backend.template")
@section('titleAdmin')
{{Lang::get('backend/title.menu.title')}}
@stop
@section("contentadmin")
<div class="pageheader notab">
    <h1 class="pagetitle">{{Lang::get('backend/title.menu.title')}}</h1>
    <span class="pagedesc">{{Lang::get('backend/title.menu.description')}}</span>
</div>
<div class="contentwrapper">
    <div class="subcontent">
        <div class="contenttitle2">
            <h3>{{Lang::get('backend/title.menu.caption')}}</h3>
        </div>
        <link rel="stylesheet" href="{{Asset('')}}backend/templates/css/style.css">
        <script>
            var _BASE_URL = '{{Asset('')}}';
                    var menuurrl = '{{action('\BackEnd\MenusController@getMenus')}}';
                    var urledit = '{{action('\BackEnd\MenusController@getEditMenu')}}';
                    var urladdgroup = '{{action('\BackEnd\MenusController@getAddGroupMenu')}}';
                    var urleditgroup = '{{action('\BackEnd\MenusController@postUpdateGroupMenu')}}';
                    var urldelgroup = '{{action('\BackEnd\MenusController@postDeleteGroupMenu')}}';
                    var urldelete = '{{action('\BackEnd\MenusController@postDeleteMenu')}}';
                    var current_group_id = {{ $menu['group_id'] }};
                    var langsave = "{{Lang::get('backend/title.menu.save')}}";
                    var langcancel = "{{Lang::get('backend/title.menu.cancel')}}";
                    var langyes = "{{Lang::get('backend/title.menu.yes')}}";</script>   
        <script src="{{Asset('')}}backend/templates/js/jquery.1.4.1.min.js"></script>
        <script type="text/javascript"  src="{{Asset('')}}backend/templates/js/interface-1.2.js"></script>
        <script type="text/javascript" src="{{Asset('')}}backend/templates/js/inestedsortable.js"></script>
        <script type="text/javascript" src="{{Asset('')}}backend/templates/js/menu.js"></script>
        <article>
            <section>
                <ul id="menu-group">
                    <?php foreach ($menu['menu_groups'] as $item) { ?>
                        <li id="group-<?php echo $item->id; ?>">
                            <a href="{{action('\BackEnd\MenusController@getMenus')}}/{{$item->id}}">
                                <?php echo $item->title; ?>
                            </a>
                        </li>
                    <?php } ?>
                    <li id="add-group"><a href="{{action('\BackEnd\MenusController@getAddGroupMenu')}}" title="Add Menu Group">+</a></li>
                </ul>
                <div class="clear"></div>
                <form method="post" id="form-menu" action="{{action('\BackEnd\MenusController@postUpdateMenu')}}">
                    <div class="ns-row" id="ns-header">
                        <div class="ns-actions">{{Lang::get('backend/title.menu.table-action')}}</div>
                        <div class="ns-class">{{Lang::get('backend/title.menu.table-class')}}</div>
                        <div class="ns-url">{{Lang::get('backend/title.menu.table-url')}}</div>
                        <div class="ns-title">{{Lang::get('backend/title.menu.table-title')}}</div>
                    </div>
                    <?php echo $menu['menu_ul']; ?>
                    <div id="ns-footer">
                        <button type="submit" class="button green small" id="btn-save-menu">{{Lang::get('backend/title.menu.update')}}</button>
                    </div>
                </form>
            </section>
        </article>
        <aside>
            <div class="box">
                <h2>{{Lang::get('backend/title.menu.title-edit-group-menu')}}</h2>
                <section>
                    <span id="edit-group-input"><?php echo $menu['group_title']; ?></span>
                    (ID: <b><?php echo $menu['group_id']; ?></b>)
                    <div>
                        <a id="edit-group" href="#">{{Lang::get('backend/title.menu.edit')}}</a>
                        <?php if ($menu['group_id'] > 1) : ?>
                            &middot; <a id="delete-group" href="#">{{Lang::get('backend/title.menu.delete')}}</a>
                        <?php endif; ?>
                    </div>
                </section>
            </div>
            <div class="box">
                <h2>{{Lang::get('backend/title.menu.title-add-menu')}}</h2>
                <section>
                    <form id="form-add-menu" method="post" action="{{action('\BackEnd\MenusController@postAddMenu')}}">
                        <p>
                            <label for="menu-title">{{Lang::get('backend/title.menu.table-title')}}</label>
                            <input type="text" name="title" id="menu-title">
                        </p>
                        <p>
                            <label for="menu-url">Chọn</label>
                            <select id="urlselectoption">
                                <optgroup label="Trang chủ">
                                    <option value="{{Asset('')}}">Trang chủ</option>
                                    <option value="volvo">Volvo</option>
                                    <option value="saab">Saab</option>
                                </optgroup>
                                <optgroup label="Chuyên mục sản phẩm">
                                    <option value="saab">Saab</option>
                                </optgroup>
                                <optgroup label="Trang tĩnh">
                                    <option value="saab">Saab</option>
                                </optgroup>  
                                <optgroup label="Chuyên mục tin tức">
                                    <option value="saab">Saab</option>
                                </optgroup>  
                            </select>
                        </p>
                        <p>
                            <label for="menu-url">{{Lang::get('backend/title.menu.table-url')}}</label>
                            <input type="text" name="url" id="menu-url" value="{{Asset('')}}">
                        </p>
                        <p>
                            <label for="menu-class">{{Lang::get('backend/title.menu.table-class')}}</label>
                            <input type="text" name="class" id="menu-class">
                        </p>
                        <p class="buttons">
                            <input type="hidden" name="group_id" value="<?php echo $menu['group_id']; ?>">
                            <button id="add-menu" type="submit" class="button green small">{{Lang::get('backend/title.menu.add')}}</button>
                        </p>
                    </form>
                </section>
            </div>

        </aside>
    </div>
</div>
@endsection

