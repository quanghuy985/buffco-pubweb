@extends("backend.template")
@section("titleAdmin")
@if(!isset($arrayPage))
{{Lang::get('backend/title.page.add')}}
@else
{{Lang::get('backend/title.page.edit')}}
@endif
@stop
@section("contentadmin")
<script>
    jQuery(document).ready(function() {
        jQuery("#addPage").validate({
            rules: {
                pageName: {required: true},
                pageKeywords: {required: true},
                pageTag: {required: true},
                pageSlug: {required: true}
            },
            messages: {
                pageName: {required: '<?php echo Lang::get('jquery.page.name'); ?>'},
                pageKeywords: {required: '<?php echo Lang::get('jquery.page.keyword'); ?>'},
                pageTag: {required: '<?php echo Lang::get('jquery.page.tag'); ?>'},
                pageSlug: {required: '<?php echo Lang::get('jquery.page.slug'); ?>'}
            }
        });
    });
    function toSlug(e) {
        var str = e.value;
        str = str.toLowerCase(); // chuyển chuỗi sang chữ thường để xử lý
        /* tìm kiếm và thay thế tất cả các nguyên âm có dấu sang không dấu*/
        str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
        str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
        str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
        str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
        str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
        str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
        str = str.replace(/đ/g, "d");
        str = str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'| |\"|\&|\#|\[|\]|~|$|_/g, "-");
        /* tìm và thay thế các kí tự đặc biệt trong chuỗi sang kí tự - */
        str = str.replace(/-+-/g, "-"); //thay thế 2- thành 1-
        str = str.replace(/^\-+|\-+$/g, ""); //cắt bỏ ký tự - ở đầu và cuối chuỗi
        document.getElementById("pageSlug").value = str;
    }
</script>
<div class="contentwrapper">
    <div class="subcontent">

        @include('backend.alert')
        @if(!isset($arrayPage))
        {{Form::open(array('action'=>'\BackEnd\PageController@postAddPage', 'id'=>'addPage', 'class'=>'stdform'))}}
        @else
        {{Form::model($arrayPage, array('action'=>'\BackEnd\PageController@postUpdatePage', 'id'=>'addPage', 'class'=>'stdform'))}}
        @endif
        <div class="two_third photosharing_wrapper">
            <div class="contenttitle2" id="editPage">
                <h3>
                    @if(!isset($arrayPage))
                    {{Lang::get('backend/title.page.add')}}
                    @else
                    {{Lang::get('backend/title.page.edit')}}
                    @endif
                </h3>
            </div>
            <p>
                {{Form::hidden('id', null, array('id'=>'id'))}}
            </p>

            <p>
                <label>{{Lang::get('general.page_name')}}</label>
                <span class="field">
                    {{Form::text('pageName', null, array('id'=>'pageName', 'class'=>'longinput', 'onkeyup'=>'toSlug(this)', 'onchange'=>'toSlug(this)'))}}
                </span>
            </p>
            <p>
                <label>{{Lang::get('general.slug')}}</label>
                <span class="field">
                    {{Form::text('pageSlug', null, array('id'=>'pageSlug', 'class'=>'longinput', 'onchange'=>'toSlug(this)', 'placeholder'=>Lang::get('placeholder.slug')))}}
                </span>
            </p>
            <p>
                <label>{{Lang::get('general.content')}}</label>
                <span class="field">
                    {{Form::textarea('pageContent', null, array('id'=>'location2', 'class'=>'ckeditor'))}}
                </span>
            </p>

        </div>
        <div class="one_third last ps_sidebar">
            <div class="contenttitle3">
                <h3>Đăng</h3>
            </div>
            <?php
            $dataStatus = Lang::get('general.data_status');
            unset($dataStatus['']);
            echo Form::select('status', $dataStatus);
            ?>
            <button class="submit radius2">
                @if(isset($arrayPage)){{Lang::get('button.update')}} @else {{Lang::get('button.add')}} @endif
            </button>
            <br clear="all">
            <div class="contenttitle3">
                <h3>{{Lang::get('general.tag')}}</h3>
            </div>
            {{Form::text('pageTag', null, array('id'=>'tags', 'class'=>'longinput', 'placeholder'=>Lang::get('placeholder.tags')))}}
            <br clear="all">
            <div class="contenttitle3">
                <h3>{{Lang::get('general.keyword')}}</h3>
            </div>
            {{Form::text('pageKeywords', null, array('id'=>'tags1', 'class'=>'longinput', 'placeholder'=>Lang::get('placeholder.keywords')))}}
        </div>
        <style>
            div.tagsinput{
                width: 100% !important;
            }
        </style>
        {{Form::close()}}
    </div>
</div>
@endsection