@extends("backend.template")
@section("contentadmin")
<form class="stdform" action="#" method="post">

    <p>
        <label>Small Input</label>
        <span class="field"><input type="text" name="input1" id="testinput" class="smallinput" onchange="searchajax(this.value);" onkeypress="searchajax(this.value);"></span>

    </p>
    <script>
        jQuery(document).ready(function() {
            jQuery('body').click(function() {
                jQuery('.search_div_ajax').css('display', 'none');
            });
        });
        function  addvaluebox(bien) {
            jQuery('#testinput').val(bien);
            jQuery('.search_div_ajax').css('display', 'none');
        }
        function  searchajax(bien) {
            jQuery('.search_div_ajax').css('display', 'block');
            var request = jQuery.ajax({
                url: '{{action('\BackEnd\UserController@postSearchUserByKeyword')}}',
                type: "POST",
                data: {keyword: bien},
                dataType: "html"
            });
            request.done(function(msg) {
                jQuery('..search_div_ajax > ul').html(msg);
            });
        }
    </script>
    <div class="search_div_ajax">
        <ul>

        </ul>

    </div>
    <p>
        <label>Medium Input</label>
        <span class="field"><input type="text" name="input2" class="mediuminput"></span>
    </p>

    <p>
        <label>Long Input</label>
        <span class="field"><input type="text" name="input3" class="longinput"></span>
    </p>

    <p>
        <label>Textarea</label>
        <span class="field"><textarea cols="80" rows="5" class="longinput"></textarea></span> 
    </p>

    <p>
        <label>Textarea with Character Count</label>
        <span class="field">
            <textarea cols="80" rows="5" id="textarea2" class="longinput"></textarea><span class="counter">Characters left: 120</span>
        </span> 
    </p>

    <p>
        <label>Select</label>
        <span class="field">
            <div class="selector" id="uniform-undefined"><span>Choose One</span><select name="select" style="opacity: 0;">
                    <option value="">Choose One</option>
                    <option value="">Selection One</option>
                    <option value="">Selection Two</option>
                    <option value="">Selection Three</option>
                    <option value="">Selection Four</option>
                </select></div>

        </span>
    </p>

    <p>
        <label>Disabled Select</label>
        <span class="field">
            <div class="selector disabled" id="uniform-undefined"><span>Choose One</span><select name="select" disabled="disabled" style="opacity: 0;">
                    <option value="">Choose One</option>
                    <option value="">Selection One</option>
                    <option value="">Selection Two</option>
                    <option value="">Selection Three</option>
                    <option value="">Selection Four</option>
                </select></div>
        </span>
    </p>

    <p>
        <label>Multiple Select</label>
        <span class="field">
            <select name="select2" multiple="multiple" size="5">
                <option value="">Selection One</option>
                <option value="">Selection Two</option>
                <option value="">Selection Three</option>
                <option value="">Selection Four</option>
                <option value="">Selection Five</option>
                <option value="">Selection Six</option>
                <option value="">Selection Seven</option>
                <option value="">Selection Eight</option>
            </select>
        </span>
    </p>

    <p>
        <label>Dual Select</label>
        <span id="dualselect" class="dualselect">
            <select name="select3" multiple="multiple" size="10">
                <option value="">Selection One</option>
                <option value="">Selection Two</option>
                <option value="">Selection Three</option>
                <option value="">Selection Four</option>
                <option value="">Selection Five</option>
                <option value="">Selection Six</option>
                <option value="">Selection Seven</option>
                <option value="">Selection Eight</option>
            </select>
            <span class="ds_arrow">
                <span class="arrow ds_prev">«</span>
                <span class="arrow ds_next">»</span>
            </span>
            <select name="select4" multiple="multiple" size="10"></select>
        </span>
    </p>

    <p>
        <label>Radio Buttons</label>
        <span class="formwrapper">
            <div class="radio" id="uniform-undefined"><span><input type="radio" name="radiofield" style="opacity: 0;"></span></div> Unchecked Radio &nbsp; &nbsp;
            <div class="radio" id="uniform-undefined"><span><input type="radio" name="radiofield" checked="checked" style="opacity: 0;"></span></div> Checked Radio &nbsp; &nbsp;
            <div class="radio disabled" id="uniform-undefined"><span><input type="radio" name="radiofield" disabled="disabled" style="opacity: 0;"></span></div> Disabled Radio  &nbsp; &nbsp;
            <div class="radio disabled" id="uniform-undefined"><span class="checked"><input type="radio" name="radiofield" checked="checked" disabled="disabled" style="opacity: 0;"></span></div> Disabled Radio 
        </span>
    </p>

    <p>
        <label>Checkboxes</label>
        <span class="formwrapper">
            <div class="checker" id="uniform-undefined"><span><input type="checkbox" name="check2" style="opacity: 0;"></span></div> Unchecked Checkbox<br>
            <div class="checker" id="uniform-undefined"><span class="checked"><input type="checkbox" name="check2" checked="checked" style="opacity: 0;"></span></div> Checked Checkbox <br>
            <div class="checker disabled" id="uniform-undefined"><span><input type="checkbox" name="check2" disabled="disabled" style="opacity: 0;"></span></div> Disabled Checkbox <br> 
            <div class="checker disabled" id="uniform-undefined"><span class="checked"><input type="checkbox" name="check2" disabled="disabled" checked="checked" style="opacity: 0;"></span></div> Disabled Checked Checkbox
        </span>
    </p>

    <p>
        <label>File Upload</label>
        <span class="field">
            <div class="uploader" id="uniform-undefined"><input type="file" name="filename" size="19" style="opacity: 0;"><span class="filename">No file selected</span><span class="action">Choose File</span></div>
        </span>
    </p>

    <p>
        <label>Input Tags</label>
        <span class="field">
            <input name="tags" id="tags" class="longinput" value="foo,bar,baz" style="display: none;"><div id="tags_tagsinput" class="tagsinput" style="width: 300px; height: 100px;"><span class="tag"><span>foo&nbsp;&nbsp;</span><a href="#" title="Removing tag">x</a></span><span class="tag"><span>bar&nbsp;&nbsp;</span><a href="#" title="Removing tag">x</a></span><span class="tag"><span>baz&nbsp;&nbsp;</span><a href="#" title="Removing tag">x</a></span><div id="tags_addTag"><input id="tags_tag" value="" data-default="add a tag" style="color: rgb(102, 102, 102); width: 80px;"></div><div class="tags_clear"></div></div>
        </span>
    </p>

    <p>
        <label>Spinner</label>
        <span class="field"><input type="text" id="spinner" name="" class="width50 noradiusright" maxlength="3" style="width: 34px; margin-right: 16px; text-align: right;"><span class="ui-spinner ui-widget"><div class="ui-spinner-buttons" style="height: 33px; left: -16px; top: -8px; width: 16px;"><div class="ui-spinner-up ui-spinner-button ui-state-default ui-corner-tr" style="width: 15px; height: 15.5px;"><span class="ui-icon ui-icon-triangle-1-n" style="margin-left: 6px; margin-top: 0.5px;">&nbsp;</span></div><div class="ui-spinner-down ui-spinner-button ui-state-default ui-corner-br" style="width: 15px; height: 15.5px;"><span class="ui-icon ui-icon-triangle-1-s" style="margin-left: 6px; margin-top: 0.5px;">&nbsp;</span></div></div></span></span>
        <small class="desc">Try to use mouse wheel.</small>
    </p>

    <br clear="all"><br>

    <p class="stdformbutton">
        <button class="submit radius2">Submit Button</button>
        <input type="reset" class="reset radius2" value="Reset Button">
    </p>


</form>
@endsection