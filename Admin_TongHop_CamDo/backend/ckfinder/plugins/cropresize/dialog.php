<?php
include('lib/Boot.php');

$image = new Image();
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
        <title>Chào mừng bạn đến với Pubweb.vn</title>
        <script src="jcrop/js/jquery.min.js" type="text/javascript"></script>
        <script src="jcrop/js/jquery.Jcrop.js" type="text/javascript"></script>
        <link rel="stylesheet" href="jcrop/css/jquery.Jcrop.css" type="text/css" />

        <style type="text/css" media="screen">

            body {
                font-family: Arial, Verdana;
                font-size: 12px;
            }

            #heading {
                font-family: Arial, Verdana;
                font-size: 16px;
                font-weight: bold;
                margin: 0 0 20px;
                border-bottom: 1px solid #dfdfdf;
                padding-bottom: 10px;
            }

            #left_col {
                float: left;
                width: auto;
                margin-right: 20px;
            }

            #right_col {
                float: left;
                width: 185px;
                height: 413px;
                border-left: 1px solid #dfdfdf;
                padding-left: 20px;
            }

            .setting_list,
            .setting_list li {
                margin: 0;
                padding: 0;
                list-style: none;
            }

            .setting_list li {
                margin-bottom: 10px;
            }

            .setting_list label {
                width: 90px;
                display: inline-block;
            }

            .setting_list .full_label {
                display: block;
                margin-bottom: 5px;
            }

            .setting_list .crop_input {
                width: 50px;
                border: 1px solid #a0a0a0;
                text-align: center;
            }

            .setting_list .full_input {
                width: 180px;
                border: 1px solid #a0a0a0;
            }

            .setting_list .field_hint {
                color: #8d8d8d;
            }

            .crop_note {
                color: #000;
                font-size: 11px;
                margin: 0 0 20px;
            }

            #crop_completed_value {
                font-weight: bold;
                font-size: 14px;
                color: darkgreen;
            }

        </style>

    </head>

    <body>

        <div id="left_col">
            <img src="<?php echo $image->getUrl(); ?>" id="target" alt="<?php echo $image->getName(); ?>" />
            <script type="text/javascript">
                jQuery(function($) {

                    var jcropApi;
                    var pos;

                    $('#target').Jcrop({
                        maxSize: 0,
                        boxWidth: 550,
                        boxHeight: 0,
                        onSelect: showCoords,
                        onChange: showCoords,
                        onRelease: clearDimensions
                    }, function() {
                        jcropApi = this;
                    });

                    function clearDimensions() {
                        $("#crop_width").val('');
                        $("#crop_height").val('');

                        jcropApi.setOptions({allowSelect: true});
                    }

                    function showCoords(c)
                    {
                        pos = c;

                        width = Math.round(pos.w);
                        width = (isNaN(width)) ? 0 : width;

                        height = Math.round(pos.h);
                        height = (isNaN(height)) ? 0 : height;

                        $("#crop_width").val(width);
                        $("#crop_height").val(height);

                        $("#x").val(pos.x);
                        $("#y").val(pos.y);
                        $("#w").val(width);
                        $("#h").val(height);

                    }
                    ;

                    $("#crop_width, #crop_height").bind("keyup", function() {

                        width = $("#crop_width").val();
                        width = (!isNaN(width)) ? width : 0;
                        x2 = (pos.x + parseInt(width, 10));

                        height = $("#crop_height").val();
                        height = (!isNaN(height)) ? height : 0;
                        y2 = (pos.y + parseInt(height, 10));

                        jcropApi.setSelect([pos.x, pos.y, Math.round(x2), Math.round(y2)]);

                        //console.log("Width: " + pos.x + " + " + width + " = " + Math.round(x2));
                        //console.log("Height: " + pos.y + " + " + height + " = " + Math.round(y2));
                        //console.log("----------------------------------------------------------");

                    });



                    $("#right_col").height($("#left_col").height());

                    $("#crop_submit").bind("submit", function(event) {

                        $("#image_quality").val($("#crop_image_quality").val());
                        /*$("#image_name").val( $("#crop_image_filename").val() );*/

                        event.preventDefault();

                        $.ajax({
                            url: './lib/Process.php',
                            global: false,
                            type: "POST",
                            dataType: "text",
                            data: $(this).serialize(),
                            beforeSend: function() {
                            },
                            success: function(response) {
                                $("#crop_completed_value").html(response);
                            }
                        });

                    });

                });
            </script>
            <form action="#" id="crop_submit" method="post">
                <input type="hidden" id="x" name="x" />
                <input type="hidden" id="y" name="y" />
                <input type="hidden" id="w" name="w" />
                <input type="hidden" id="h" name="h" />
                <input type="hidden" id="image_url" name="fileUrl" value="<?php echo $image->getUrl(); ?>" />
                <input type="hidden" id="image_name" name="fileName" value="<?php echo $image->getName(); ?>" />
                <input type="hidden" id="folder_name" name="folderName" value="<?php echo $image->getFolderName(); ?>" />
                <input type="hidden" id="image_quality" name="imageQuality" value="90" />
                <input type="submit" value="Thực hiện" style="float:left; width: 98px;" />
            </form>
        </div>

        <div id="right_col">
            <h2 id="heading">Tùy chỉnh</h2>
            <ul class="setting_list">
                <li><label for="crop_width" class="crop_label">Độ rộng:</label><input type="text" id="crop_width" class="crop_input"  name="img_width" value="" /> <span class="field_hint">pixels</span></li>
                <li><label for="crop_height" class="crop_label">Độ dài:</label><input type="text" id="crop_height" class="crop_input" name="img_height" value="" /> <span class="field_hint">pixels</span></li>
                <li><label for="crop_image_quality" class="crop_label">Chất lượng ảnh:</label><input type="text" id="crop_image_quality" class="crop_input" name="crop_image_quality" value="90" /> <span class="field_hint">%</span></li>
                <!--<li><label for="crop_image_filename" class="full_label">New Filename:</label><input type="text" id="crop_image_filename" class="full_input" name="crop_image_filename" value="<?php /* echo $image->getName(); */ ?>" /></li>-->
            </ul>
            <!--<p class="crop_note">Your new image will be saved in folder <strong><?php /* echo $image->getFolderName(); */ ?></strong>.</p>-->
            <p id="crop_completed_value"></p>

        </div>

    </body>
</html>

