<h2>{{Lang::get('backend/title.menu.title-edit-menu')}}</h2>
<form method="post" action="{{action('\BackEnd\MenusController@postEditMenuEdit')}}">
    <p>
        <label for="edit-menu-title">{{Lang::get('backend/title.menu.table-title')}}</label>
        <input type="text" name="title" id="edit-menu-title" value="{{$menu_edit->title}}">
    </p>
    <p>
        <label for="edit-menu-url">{{Lang::get('backend/title.menu.table-url')}}</label>
        <input type="text" name="url" id="edit-menu-url" value="{{$menu_edit->url}}">
    </p>
    <p>
        <label for="edit-menu-class">{{Lang::get('backend/title.menu.table-class')}}</label>
        <input type="text" name="class" id="edit-menu-class" value="{{$menu_edit->class}}">
    </p>
    <input type="hidden" name="menu_id" value="{{$menu_edit->id}}">
</form>