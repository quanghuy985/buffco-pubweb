<h2>{{Lang::get('backend/title.menu.title-add-group-menu')}}</h2>
<form method="post" action="{{action('\BackEnd\MenusController@postAddGroupMenu')}}">
    <p>
        <label for="menu-group-title">{{Lang::get('backend/title.menu.group-title')}}</label>
        <input type="text" name="title" id="menu-group-title">
    </p>
</form>