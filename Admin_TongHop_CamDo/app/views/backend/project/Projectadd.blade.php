@extends("backend.template")
@section("titleAdmin")
@if(isset($dataProject))
{{Lang::get('backend/title.project.edit')}}
@else
{{Lang::get('backend/title.project.add')}}
@endif
@stop
@section("contentadmin")
<script>
    jQuery(document).ready(function() {
<?php
if (isset($dataProject)) {
    $tag = explode(',', $dataProject->img);
    $i = 1;
    foreach ($tag as $item) {
        $urlimg = Timthumb::link($item, 100, 100, 0);
        ?>
                var urlImg = '<span style="padding-top:10px" id="image-{{$i}}">' +
                        '<img src="<?php echo Asset($urlimg); ?>" width="100" height="100"/>' +
                        '<a href="javascript:void(0);" ' +
                        'onclick="xoaanhthum(\'image-{{$i}}\');" class="delete" title="{{Lang::get("button.delete")}}">x</a></span>';
                var urlImgno = '<span style="padding-top:10px" id="n-image-{{$i}}">' +
                        '<a href="{{$item}}"></a></span>';
                document.getElementById('thumbnails').innerHTML += urlImg;
                document.getElementById('noThumb').innerHTML += urlImgno;
        <?php
        $i++;
    }
    ?>
            returnurlimg();
<?php }
?>
        jQuery("#addProjectForm").validate({
            rules: {
                projectName: {required: true},
                projectDescription: {required: true},
                projectContent: {required: true}
            },
            messages: {
                projectName: {required: '<?php echo Lang::get('jquery.project.name'); ?>'},
                projectDescription: {required: '<?php echo Lang::get('jquery.project.description'); ?>'},
                projectContent: {required: '<?php echo Lang::get('jquery.project.content'); ?>'}
            }
        });
    });
    function BrowseServer(startupPath, functionData)
    {
        // You can use the "CKFinder" class to render CKFinder in a page:
        var finder = new CKFinder();
        // The path for the installation of CKFinder (default = "/ckfinder/").
        // finder.basePath = '../';

        //Startup path in a form: "Type:/path/to/directory/"
        finder.startupPath = startupPath;
        // Name of a function which is called when a file is selected in CKFinder.
        finder.selectActionFunction = SetFileField;
        // Additional data to be passed to the selectActionFunction in a second argument.
        // We'll use this feature to pass the Id of a field that will be updated.
        finder.selectActionData = functionData;
        // Launch CKFinder
        finder.popup();
    }
    var i = 0;
// This is a sample function which is called when a file is selected in CKFinder.
    function SetFileField(fileUrl, data)
    {
        var sFileName = this.getSelectedFile().name + i;
        var urlImg = '<span id="image-' + sFileName + '"><img src="<?php echo Asset('pubweb.vn/100/100/0') ?>/' + fileUrl + '" width="100" height="100"/><a href="javascript:void(0); " onclick="xoaanhthum(\'image-' + sFileName + '\');" class="delete" title="Delete image">x</a></span>';
        document.getElementById('thumbnails').innerHTML += urlImg;
        var urlImgNoThumb = '<span id="n-image-' + sFileName + '"><a href="' + fileUrl + '"></a></span>';
        document.getElementById('noThumb').innerHTML += urlImgNoThumb;
        i++;
        returnurlimg();
        //   document.getElementById(data["selectActionData"]).value = fileUrl;
    }

    function xoaanhthum(id) {
        document.getElementById(id).remove();
        document.getElementById('n-' + id).remove();
        returnurlimg();
    }

    function returnurlimg() {
        var images = jQuery("#noThumb").find("a").map(function() {
            return this.href;
        }).get();
        jQuery("#xImagePath").val(images);
    }
</script>
<script>


</script>

<div class="contentwrapper">
    <div class="subcontent">
        <div class="contenttitle2" id="editProject">
            <h3 class="uppercase">
                @if(isset($dataProject))
                {{Lang::get('backend/title.project.edit')}}
                @else
                {{Lang::get('backend/title.project.add')}}
                @endif
            </h3>
        </div>
        @include('backend.alert')
        @if(isset($dataProject))
        {{Form::model($dataProject, array('action'=>array('\BackEnd\ProjectController@postUpdateProject', $dataProject->id), 'id'=>'addProjectForm', 'class'=>'stdform'))}}
        <?php
        $dataProject->from = date('m/d/Y', $dataProject->from);
        $dataProject->to = date('m/d/Y', $dataProject->to);
        ?>
        @else
        {{Form::open(array('action'=>'\BackEnd\ProjectController@postAddProject', 'id'=>'addProjectForm', 'class'=>'stdform'))}}
        @endif
        <p>
            {{Form::hidden('id', null, array('id'=>'idproject'))}}
            {{Form::hidden('status', null, array('id'=>'status'))}}
        </p>
        <p>
            <label>{{Lang::get('general.project_name')}}</label>
            <span class="field">
                {{Form::text('projectName', null, array('id'=>'projectName'))}}
            </span>
        </p>
        <p>
            <label>{{Lang::get('general.date_begin')}}</label>
            <span class="field">
                {{Form::text('from', null, array('id'=>'datepicker', 'width'=>'100px'))}}

            </span>
        </p>

        <p>
            <label>{{Lang::get('general.date_end')}}</label>
            <span class="field">
                {{Form::text('to', null, array('id'=>'datepicker1', 'width'=>'100px'))}}
            </span>
        </p>

        <p>
            <label>{{Lang::get('general.description')}}</label>
            <span class="field">
                {{Form::textarea('projectDescription', null, array('id'=>'description', 'rows'=>5, 'cols'=>80, 'class'=>'ckeditor'))}}
            </span>
        </p>

        <p>
            <label>{{Lang::get('general.content')}}</label>
            <span class="field">
                {{Form::textarea('projectContent', null, array('id'=>'content', 'rows'=>5, 'cols'=>80, 'class'=>'ckeditor'))}}
        </p>

        <p>
            <label>{{Lang::get('general.image')}}</label>

            <span class="field">           
                <input id="xImagePath" name="ImagePath" type="hidden"/>
                <span id="thumbnails"></span>
                <input type="button" value="{{Lang::get('button.addImage')}}" class="stdbtn btn_orange" onclick="BrowseServer('Images:/', 'xImagePath');"/>
            </span>
            <span hidden="true" id="noThumb">
            </span>
        </p>
        <p>
            <label>{{Lang::get('general.status')}}</label>
            <span class="field">
                <?php
                $selectData = Lang::get('general.data_status');
                unset($selectData['']);
                echo Form::select('status', $selectData);
                ?>
            </span>
        </p>
        <p class="stdformbutton">
            <button style="margin-left: 30px;" class="submit radius2">@if(isset($dataProject)){{Lang::get('button.update')}} @else{{Lang::get('button.add')}} @endif</button>
            <input type="reset" class="reset radius2" value="{{Lang::get('button.reset')}}">
        </p>
        {{Form::close()}}
    </div>
</div>
@endsection