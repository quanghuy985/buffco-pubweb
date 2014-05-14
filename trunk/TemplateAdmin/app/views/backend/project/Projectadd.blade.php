@extends("templateadmin2.mainfire")
@section("titleAdmin")
@if(isset($dataProject))
{{Lang::get('backend/title.project.edit')}}
@else
{{Lang::get('backend/title.project.add')}}
@endif
@stop
@section("contentadmin")
<script>
    jQuery(document).ready(function () {
        <?php
if (isset($dataimg)) {
    foreach ($dataimg as $item) {
        ?>
        var urlImg = '<div style="padding-top:10px" id="image-{{$item->id}}">' +
            '<img src="{{$item->attachmentURL}}" width="100" height="100"/>' +
            '<a href="javascript:void(0);" ' +
            'onclick="xoaanhthum(\'image-{{$item->id}}\');" class="delete" title="{{Lang::get("button.delete")}}">x</a></div>';
        document.getElementById('thumbnails1').innerHTML += urlImg;
        <?php }
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
                projectContent: {required:  '<?php echo Lang::get('jquery.project.content'); ?>'}
            }
        });
    });
    function BrowseServer(startupPath, functionData) {
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

    function SetFileField(fileUrl, data) {

        var sFileName = this.getSelectedFile().name;
        var urlImg = '<div style="padding-top:10px" id="image-' + sFileName + '">' +
            '<img src="{{Asset('timthumb.php')}}?src=http://' + window.location.hostname + fileUrl + '&w=100&h=100&zc=0&q=100" width="100" height="100"/>' +
            '<a href="javascript:void(0);" onclick="xoaanhthum(\'image-' + sFileName + '\');" class="delete" title="{{Lang::get("button.delete")}}">x</a></div>';
        document.getElementById('thumbnails1').innerHTML += urlImg;
        returnurlimg();
        //   document.getElementById(data["selectActionData"]).value = fileUrl;
    }

    function xoaanhthum(id) {
        document.getElementById(id).remove();
        returnurlimg();
    }

    function returnurlimg() {
        var images = jQuery("#thumbnails1").find("img").map(function () {
            return this.src;
        }).get();
        jQuery("#xImagePath").val(images);
    }
</script>
<script>


</script>


<div class="contenttitle2" id="editProject">
    <h3 class="uppercase">
        @if(isset($dataProject))
        {{Lang::get('backend/title.project.edit')}}
        @else
        {{Lang::get('backend/title.project.add')}}
        @endif
    </h3>
</div>
@include('templateadmin2.alert')
@if(isset($dataProject))
{{Form::model($dataProject, array('action'=>'ProjectController@postUpdateProject', 'id'=>'addProjectForm', 'class'=>'stdform stdform2'))}}
<?php
$dataProject->from = date('m/d/Y', $dataProject->from);
$dataProject->to = date('m/d/Y', $dataProject->to);
?>
@else
{{Form::open(array('action'=>'ProjectController@postAddProject', 'id'=>'addProjectForm', 'class'=>'stdform stdform2'))}}
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
    <label>{{Lang::get('general.status')}}</label>
        <span class="field">
            <?php
            $selectData = Lang::get('general.data_status');
            unset($selectData['']);
            echo Form::select('status', $selectData);
            ?>
        </span>
</p>
<p>
    <label>{{Lang::get('general.image')}}</label>

        <span class="field">
            <input type="button" value="{{Lang::get('button.addImage')}}" class="stdbtn btn_orange"
                   onclick="BrowseServer('Images:/', 'xImagePath');"/>
            <input id="xImagePath" name="ImagePath" type="hidden"/>
            <span id="thumbnails1"></span>

        </span>
</p>
<p class="stdformbutton">
    <button class="submit radius2">@if(isset($dataProject)){{Lang::get('button.update')}} @else{{Lang::get('button.add')}} @endif</button>
    <input type="reset" class="reset radius2" value="{{Lang::get('button.reset')}}">
</p>
{{Form::close()}}
@endsection