@extends("templatebackend.admin")
@section("titlepage")
SẢN PHẨM
@endsection
@section("contentadmin")
<article class="breadcrumbs"><a href="{{Asset('addpro')}}">+Thêm mới sản phảm</a>  </article>
<br/>
<article class="module width_full">
    <header>
        <h3>Danh sách sản phẩm</h3>
    </header>

    <table class="tablesorter" cellspacing="0"> 
        <thead> 
            <tr> 
                <th class="header"></th> 
                <th class="header">Entry Name</th> 
                <th class="header">Category</th> 
                <th class="header">Created On</th> 
                <th class="header">Actions</th> 
            </tr> 
        </thead> 
        <tbody> 
            <tr> 
                <td><input type="checkbox"></td> 
                <td>Lorem Ipsum Dolor Sit Amet</td> 
                <td>Articles</td> 
                <td>5th April 2011</td> 
                <td><input type="image" src="{{Asset('adminlib/images/icn_edit.png')}}" title="Edit"><input type="image" src="{{Asset('adminlib/images/icn_trash.png')}}" title="Trash"></td> 
            </tr> 
            <tr> 
                <td><input type="checkbox"></td> 
                <td>Ipsum Lorem Dolor Sit Amet</td> 
                <td>Freebies</td> 
                <td>6th April 2011</td> 
                <td><input type="image" src="{{Asset('adminlib/images/icn_edit.png')}}" title="Edit"><input type="image" src="{{Asset('adminlib/images/icn_trash.png')}}" title="Trash"></td> 
            </tr>
            <tr> 
                <td><input type="checkbox"></td> 
                <td>Sit Amet Dolor Ipsum</td> 
                <td>Tutorials</td> 
                <td>10th April 2011</td> 
                <td><input type="image" src="{{Asset('adminlib/images/icn_edit.png')}}" title="Edit"><input type="image" src="{{Asset('adminlib/images/icn_trash.png')}}" title="Trash"></td> 
            </tr> 
            <tr> 
                <td><input type="checkbox"></td> 
                <td>Dolor Lorem Amet</td> 
                <td>Articles</td> 
                <td>16th April 2011</td> 
                <td><input type="image" src="{{Asset('adminlib/images/icn_edit.png')}}" title="Edit"><input type="image" src="{{Asset('adminlib/images/icn_trash.png')}}" title="Trash"></td> 
            </tr>
            <tr> 
                <td><input type="checkbox"></td> 
                <td>Dolor Lorem Amet</td> 
                <td>Articles</td> 
                <td>16th April 2011</td> 
                <td><input type="image" src="{{Asset('adminlib/images/icn_edit.png')}}" title="Edit"><input type="image" src="{{Asset('adminlib/images/icn_trash.png')}}" title="Trash"></td> 
            </tr>  
        </tbody> 
    </table>
    <input type="button" class="btn-success" value="Delete"/>
</article>
@endsection