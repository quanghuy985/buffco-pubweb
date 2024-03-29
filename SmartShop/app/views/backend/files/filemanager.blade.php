@extends("backend.template")

@section("contentadmin")

<div class="pageheader notab">
    <h1 class="pagetitle">File Manager</h1>
    <span class="pagedesc">To select an item, just click the thumbnail.</span>
</div>
<div id="contentwrapper" class="contentwrapper nopadding">
    <script type="text/javascript">

        // This is a sample function which is called when a file is selected in CKFinder.
        function showFileInfo(fileUrl, data, allFiles)
        {
            var msg = 'The last selected file is: <a href="' + fileUrl + '">' + fileUrl + '</a><br /><br />';
            // Display additional information available in the "data" object.
            // For example, the size of a file (in KB) is available in the data["fileSize"] variable.
            if (fileUrl != data['fileUrl'])
                msg += '<b>File url:</b> ' + data['fileUrl'] + '<br />';
            msg += '<b>File size:</b> ' + data['fileSize'] + 'KB<br />';
            msg += '<b>Last modified:</b> ' + data['fileDate'];

            if (allFiles.length > 1)
            {
                msg += '<br /><br /><b>Selected files:</b><br /><br />';
                msg += '<ul style="padding-left:20px">';
                for (var i = 0; i < allFiles.length; i++)
                {
                    // See also allFiles[i].url
                    msg += '<li>' + allFiles[i].data['fileUrl'] + ' (' + allFiles[i].data['fileSize'] + 'KB)</li>';
                }
                msg += '</ul>';
            }
            // this = CKFinderAPI object
            this.openMsgDialog("Selected file", msg);
        }

        // You can use the "CKFinder" class to render CKFinder in a page:
        var finder = new CKFinder();
        // The path for the installation of CKFinder (default = "/ckfinder/").
        finder.basePath = '../';
        // The default height is 400.
        finder.height = 600;
        // This is a sample function which is called when a file is selected in CKFinder.
        finder.selectActionFunction = showFileInfo;
        finder.create();

        // It can also be done in a single line, calling the "static"
        // create( basePath, width, height, selectActionFunction ) function:
        // CKFinder.create( '../', null, null, showFileInfo );

        // The "create" function can also accept an object as the only argument.
        // CKFinder.create( { basePath : '../', selectActionFunction : showFileInfo } );

    </script>
    <style>
        iframe {
            margin-bottom: -30px !important;
        }
    </style>

</div>
@endsection