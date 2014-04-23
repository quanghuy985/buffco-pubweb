@extends("templateadmin2.mainfire")
@section("contentadmin")
<script>
    jQuery(document).ready(function() {
        
        <?php
if (isset($dataimg)) {
    foreach ($dataimg as $item) {
        ?>
            var urlImg = '<div style="padding-top:10px" id="image-' + <?php echo $item->id; ?> + '"><img src="<?php echo $item->attachmentURL; ?>" width="100" height="100"/><a href="javascript:void(0);" onclick="xoaanhthum(\'image-' + <?php echo $item->id; ?> + '\');" class="delete" title="Delete image">x</a></div>';
                    document.getElementById('thumbnails1').innerHTML += urlImg;
    <?php }
    ?>
        returnurlimg();
<?php }
?>


    jQuery("#addProjectForm").validate({
    rules: {
    projectName: {
    required: true
    },
            description: {
    required: true
    },
            content: {
    required: true
    }

    },
            messages: {
    projectName: {
    required: 'Tên dự án là trường bắt buộc',
    },
            description: {
    required: 'Vui lòng nhập mô tả'
    },
            content: {
    required: 'Vui lòng nhập nội dung '
    }
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

    function SetFileField(fileUrl, data)
    {
        
        var sFileName = this.getSelectedFile().name;
        var urlImg = '<div style="padding-top:10px" id="image-' + sFileName + '">'+
        '<img src="{{Asset('timthumb.php')}}?src=http://' + window.location.hostname + fileUrl + '&w=100&h=100&zc=0&q=100" width="100" height="100"/>'+
        '<a href="javascript:void(0);" onclick="xoaanhthum(\'image-' + sFileName + '\');" class="delete" title="Delete image">x</a></div>';
                document.getElementById('thumbnails1').innerHTML += urlImg;
        returnurlimg();
        //   document.getElementById(data["selectActionData"]).value = fileUrl;
    }

    function xoaanhthum(id) {
        document.getElementById(id).remove();
        returnurlimg();
    }

    function returnurlimg() {
        var images = jQuery("#thumbnails1").find("img").map(function() {
            return this.src;
        }).get();
        jQuery("#xImagePath").val(images);
    }
    </script>
<script>
  

    


</script>


<div class="contenttitle2" id="editProject">
    <h3>Thêm/Sửa dự án</h3>
</div>


<form class="stdform stdform2" id="addProjectForm" method="post" action="@if(isset($dataProject)) {{URL::action('ProjectController@postUpdateProject')}} @else {{URL::action('ProjectController@postAddProject')}}@endif">

    <p>
        <input type="hidden" name="idproject" id="idproject" value="@if(isset($dataProject)){{$dataProject->id}}@endif"/>
        <input type="hidden" name="status" id="status" value="@if(isset($dataProject)){{$dataProject->status}}@endif"/>

    </p>
    <p>
        <label>Tên dự án</label>
        <span class="field">
            <input type="text" value="@if(isset($dataProject)){{$dataProject->projectName}}@endif" id='projectName' name='projectName'/>

        </span>
    </p>
    <p>
        <label>Ngày bắt đầu</label>
        <span class="field">
            <input type="text" id="datepicker" name="from" placeholder="From" value="@if(isset($dataProject)){{date('Y-m-d', $dataProject->from)}}@endif" width="100px"/>
        </span>
    </p>

    <p>
        <label>Ngày kết thúc</label>
        <span class="field"><input type="text" id="datepicker1" name="to" placeholder="To" value="@if(isset($dataProject)){{date('Y-m-d', $dataProject->to)}}@endif" width="100px"></span>
    </p>

    <p>
        <label>Mô tả dự án</label>
        <span class="field"><textarea cols="80" rows="5" id="description" class="ckeditor" name="description" placeholder="Mô tả dự án">@if(isset($dataProject)){{$dataProject->projectDescription}}@endif</textarea></span>
    </p>

    <p>
        <label>Nội dung dự án</label>
        <span class="field"><textarea cols="80" rows="5" id="content" class="ckeditor" name="content" placeholder="Nội dung dự án">@if(isset($dataProject)){{$dataProject->projectContent}}@endif</textarea></span>
    </p>          

    <p>
        <label>Trạng thái</label>
        <span class="field">
            <select name="status">
                <option value="0" @if(isset($dataProject)&& $dataProject->status==0)selected@endif >Chờ kích hoạt</option>
                <option value="1" @if(isset($dataProject)&& $dataProject->status==1)selected@endif>Kích hoạt</option>
                <option value="2" @if(isset($dataProject)&& $dataProject->status==2)selected@endif>Xóa</option>
            </select>
        </span>
    </p>


    <p>
        <label>Thêm ảnh</label>

        <span class="field">
            <input type="button" value="Thêm ảnh" class="stdbtn btn_orange" onclick="BrowseServer('Images:/', 'xImagePath');" />
            <input id="xImagePath" name="ImagePath" type="hidden" />
            <span id="thumbnails1"></span>

        </span>
    </p>
    <p class="stdformbutton">
        <button class="submit radius2">@if(isset($dataProject))Cập nhật @else Thêm mới @endif</button>
        <input type="reset" class="reset radius2" value="Làm lại">
    </p>
</form>
@endsection