@extends("templateadmin2.mainfire")
@section("contentadmin")
<textarea id="editor1" class="ckeditor" name="editor1" rows="10" cols="80"></textarea>
<script type="text/javascript">
    var editor = CKEDITOR.replace('editor1');
</script>
@endsection