@extends("backend.template")
@section('titleAdmin')
@if(isset($cateNewsData))
{{Lang::get('backend/title.cateNews.edit')}}
@else
{{Lang::get('backend/title.cateNews.title')}}
@endif
@stop
@section("contentadmin")
<style>
    .stdform label {
        float: left;
        padding: 5px 20px 0 0;
        text-align: right;
        width: 35%;
    }
    .stdform span.field, .stdform div.field {
        display: block;
        margin-left: 35%;
        position: relative;
    }
    .three_fifth {
        width: 55.9%;
    }
</style>
<script>
    function toSlug(e) {
        var str = e.value;
        if (str != '') {
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
            document.getElementById("catenewsSlug").value = str;
        }
    }
    jQuery(document).ready(function() {
        jQuery("#addCateForm").validate({
            rules: {
                catenewsName: {required: true, maxlength: 255},
                catenewsDescription: {required: true, maxlength: 255},
                catenewsSlug: {required: true, maxlength: 255}
            }
        });
    });</script>

<div class="pageheader notab">
    <h1 class="pagetitle">{{Lang::get('backend/title.cateNews.heading')}} </h1>
    <span class="pagedesc">{{Lang::get('backend/title.cateNews.description')}}</span>
</div>

<div class="contentwrapper">
    <div class="two_fifth">
        @include('backend.alert')
        <div class="contenttitle2">
            <h3>
                @if(isset($cateNewsData))
                {{Lang::get('backend/title.cateNews.edit')}}
                @else
                {{Lang::get('backend/title.cateNews.add')}}
                @endif
            </h3>
        </div>
        @if(isset($cateNewsData)) <a class="btn btn_orange btn_link" href="{{action('\BackEnd\NewsController@getCateNewsView')}}"><span>Thêm mới</span></a>        @endif
        @if(isset($cateNewsData))
        {{Form::model($cateNewsData, array('action'=>'\BackEnd\NewsController@postUpdateCateNews','class'=>'stdform', 'id'=>'addCateForm'))}}
        @else
        {{Form::open(array('action'=>'\BackEnd\NewsController@postAddCateNews','class'=>'stdform', 'id'=>'addCateForm'))}}
        @endif
        <P>
            {{Form::hidden('id')}}
        <p>
            <label>
                {{Lang::get('general.cate_name')}}</label>
            <span class="field">
                {{Form::text('catenewsName', null, array('id'=>'cateNewsName', 'class'=>'longinput', 'onchange'=>'toSlug(this)', 'onkeyup'=>'toSlug(this)'))}}
            </span>
        </p>       
        <p>
            <label>{{Lang::get('general.cate_parent')}}</label>
            <span class="field">
                <select name="catenewsParent" id="selection2">
                    <option value="0">{{Lang::get('general.parent')}}</option>

                    <?php
                    if (isset($arrayCateNewslist)) {
                        foreach ($arrayCateNewslist as $item) {
                            $selec = '';
                            if (isset($cateNewsData) && $item->id == $cateNewsData->catenewsParent) {
                                $selec = 'selected';
                            }
                            if (isset($cateNewsData) && $cateNewsData->id == $item->id) {
                                
                            } else {
                                echo '<option value="' . $item->id . '" ' . $selec . '> ' . $item->catenewsName . '</option>';
                            }
                        }
                    }
                    ?>

                </select>
            </span>
        </p>
        <p>
            <label>{{Lang::get('general.slug')}}</label>
            <span class="field">
                {{Form::text('catenewsSlug', null, array('id'=>'catenewsSlug', 'placeholder'=>Lang::get('placeholder.slug'), 'onchange'=>'toSlug(this)', 'class'=>'longinput'))}}
            </span>
        </p>
        <p>
            <label>{{Lang::get('general.description')}}</label>
            <span class="field">
                {{Form::textarea('catenewsDescription', null, array('id'=>'catenewsDescription', 'class'=>'longinput', 'cols'=>80, 'rows'=>4))}}
            </span>
        </p>
        <p class="stdformbutton">
            <button class="submit radius2">
                @if(isset($cateNewsData)){{Lang::get('button.update')}} @else {{Lang::get('button.add')}} @endif
            </button>
            <input type="reset" class="reset radius2" value="{{Lang::get('button.reset')}}">
        </p>
        {{Form::close()}}
    </div>
    <div class="three_fifth">
        <div class="contenttitle2">
            <h3>{{Lang::get('backend/title.cateNews.caption')}}</h3>
        </div>
        <table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb" style="margin-top: 20px;">
            <colgroup>
                <col style="width: 30%" class="con0">
                <col style="width: 25%" class="con1">
                <col style="width: 25%" class="con0">
                <col style="width: 20%" class="con1">
            </colgroup>
            <thead>
                <tr>

                    <th class="head0">{{Lang::get('general.cate_name')}}</th>
                    <th class="head1">{{Lang::get('general.description')}}</th>
                    <th class="head1">{{Lang::get('general.slug')}}</th>
                    <th class="head0">{{Lang::get('general.action')}}</th>
                </tr>
            </thead>

            <tbody id="tableproduct" class="tabledataajax">
                @include('backend.news.cateNewsAjax')
            </tbody>
        </table>

    </div>
</div>

@endsection
