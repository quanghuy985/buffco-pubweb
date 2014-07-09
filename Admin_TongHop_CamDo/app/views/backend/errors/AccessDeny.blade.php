@extends("backend.template")
@section('titleAdmin')
{{Lang::get('backend/title.feedback.title')}}
@endsection
@section("contentadmin")
<div class="contentwrapper padding10">
    <div class="errorwrapper error403">
        <div class="errorcontent">
            <h1>Không được quyền truy cập</h1>
            <h3>Bạn không có quyền truy cập trang này.</h3>

            <p>This is likely to be caused by one of the following</p>
            <ul>
                <li>The author of the page has intentionally limited access to it.</li>
                <li>The computer on which the page is stored is unreachable.</li>
                <li>You like this page.</li>
            </ul>
            <br />
            <button class="stdbtn btn_black" onclick="history.back()">Go Back to Previous Page</button> &nbsp; 
            <button onclick="location.href = '{{action('\BackEnd\HomeController@getHome')}}'" class="stdbtn btn_orange">Go Back to Dashboard</button>
        </div><!--errorcontent-->
    </div><!--errorwrapper-->
</div>  
@endsection