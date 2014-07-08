@extends("backend.template")
@section('titleAdmin')
{{Lang::get('backend/title.news.add')}}
@stop
@section("contentadmin")
<script>
    function toSlug(e) {
        var str = e.value;
        str = str.toLowerCase();
        str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
        str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
        str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
        str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
        str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
        str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
        str = str.replace(/đ/g, "d");
        str = str.replace(/!|@|%|\^|\*|\(|\)|\+|\=|\<|\>|\?|\/|,|\.|\:|\;|\'| |\"|\&|\#|\[|\]|~|$|_/g, "-");
        str = str.replace(/-+-/g, "-");
        str = str.replace(/^\-+|\-+$/g, "");
        document.getElementById("newsSlug").value = str;
    }
    jQuery(document).ready(function() {
        jQuery("#newsAddFrom").validate({
            rules: {
                newsName: {required: true, maxlength: 255},
                newsImg: {required: true, maxlength: 255},
                newsDescription: {required: true, maxlength: 255},
                newsContent: {required: true},
                newsKeywords: {required: true, maxlength: 255},
                newsSlug: {required: true, maxlength: 255}
            }
        });
    });

</script>
<div class="pageheader notab">
    <h1 class="pagetitle">{{Lang::get('backend/title.news.heading')}}</h1>
</div>
<div class="contentwrapper">
    @if(isset($objNews))
    {{Form::model($objNews, array('action'=>'\BackEnd\NewsController@postUpdateNews', 'class'=>'stdform','id'=>'newsAddFrom' ))}}
    @else
    {{Form::open(array('action'=>'\BackEnd\NewsController@postAddNews', 'class'=>'stdform', 'id'=>'newsAddFrom'))}}
    @endif
    {{Form::hidden('id')}}
    <div class="two_third photosharing_wrapper">
        @include('backend.alert')
        <div class="contenttitle2">
            <h3> @if(isset($objNews)){{Lang::get('backend/title.news.update')}}@else{{Lang::get('backend/title.news.add')}}    @endif</h3>
        </div>
        <p>
            <label>{{Lang::get('general.news_name')}}</label>
            <span class="field">
                {{Form::text('newsName', null, array('onkeyup'=>'toSlug(this);', 'onchange'=>'toSlug(this);', 'class'=>'longinput'))}}
            </span>
        </p>
        <p>
            <label>{{Lang::get('general.slug')}}</label>
            <span class="field">
                {{Form::text('newsSlug', null, array('id'=>'newsSlug', 'class'=>'longinput', 'placeholder'=>Lang::get('placeholder.slug'), 'onchange'=>'toSlug(this);'))}}
            </span>
        </p>
        <script type="text/javascript">

            function BrowseServer() {
                var finder = new CKFinder();
                finder.basePath = '../';
                finder.selectActionFunction = SetFileField;
                finder.popup();
            }
            function SetFileField(fileUrl) {
                document.getElementById('xFilePath').value = fileUrl;
            }

        </script>
        <p>
            <label>{{Lang::get('general.avatar')}}</label>
            <span class="field">
                {{Form::text('newsImg', null, array('placeholder'=>Lang::get('placeholder.filePath'),'size'=>60,'id'=>'xFilePath', 'class'=>'smallinput'))}}
                <input type="button" class="stdbtn btn_orange" value="{{Lang::get('button.upload')}}" onclick="BrowseServer();" />
            </span>
        </p>
        <p>
            <label>{{Lang::get('general.description')}}</label>
            <span class="field">
                {{Form::textarea('newsDescription', null, array('class'=>'longinput', 'cols'=>80, 'rows'=>4))}}
            </span>
        </p>

        <p>
            <label>{{Lang::get('general.content')}}</label>
            <span class="field">
                {{Form::textarea('newsContent', null, array('class'=>'ckeditor', 'cols'=>80, 'rows'=>10))}}
            </span>
        </p>
    </div>
    <div class="one_third last ps_sidebar">
        <div class="contenttitle3">
            <h3>Đăng</h3>
        </div>
        <?php
        if (isset($objNews)) {
            $data_status = Lang::get('general.data_status_edit');
        } else {
            $data_status = Lang::get('general.data_status_add');
        }
        unset($data_status[3]);
        echo Form::select('status', $data_status);
        ?>
        <button class="submit radius2">@if(isset($objNews)){{Lang::get('button.update')}} @else{{Lang::get('button.add')}}@endif </button>

        <br clear="all">
        <div class="contenttitle3">
            <h3>{{Lang::get('general.select_cate')}}</h3>
        </div>
        <div id="scroll1" class="mousescroll">
            <ul class="cateaddproduct" id="cateaddproduct">
                @include('backend.news.listcateAjax')
            </ul>
        </div>
        <br clear="all">
        <a href="{{URL::action('\BackEnd\NewsController@getCateNewsView')}}" ><button type="button" class="stdbtn btn_orange">{{Lang::get('button.add')}}?</button></a>

        <br clear="all">
        <div class="contenttitle3">
            <h3>{{Lang::get('general.tag')}}</h3>
        </div>
        {{Form::text('newsTag', null, array('class'=>'longinput', 'id'=>'tags', 'placeholder'=>Lang::get('placeholder.tags')))}}
        <br clear="all">
        <div class="contenttitle3">
            <h3>{{Lang::get('general.keyword')}}</h3>
        </div>
        {{Form::text('newsKeywords', null, array('class'=>'longinput','id'=>'tags1', 'placeholder'=>Lang::get('placeholder.keywords')))}}
    </div>


    {{Form::close()}}
    <style>
        div.tagsinput{
            width: 100% !important;
        }
        .cateaddproduct {
            list-style: none outside none;
            padding-left: 15px;
        }

        .cateaddproduct ul {
            list-style: none outside none;
            padding-left: 20px;
        }
    </style>
    <script>
        jQuery('#scroll1').slimscroll({
            color: '#666',
            size: '10px',
            width: '100%',
            height: '200px',
            border: 'medium none'
        });
    </script>
</div>
@endsection
