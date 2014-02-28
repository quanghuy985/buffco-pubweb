@extends("templateadmin2.mainfire")
@section("contentadmin")
<div class="pageheader">
    <h1 class="pagetitle">QUẢN LÝ SẢN PHẨM</h1>
</div>
<div class="contentwrapper">
    <div class="subcontent">
        <div class="tableoptions">
            <button class="deletebutton radius3" title="table1">Delete Selected</button> &nbsp;
            <select class="radius3">
                <option value="">10</option>
                <option value="">20</option>
                <option value="">50</option>
            </select> 
            <select class="radius3">
                <option value="">Show All</option>
                <option value="">Delete</option>
                <option value="">Active</option>
            </select> &nbsp;
            <button class="radius3">Apply Filter</button>
        </div>
        <table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb">
            <colgroup>
                <col class="con0" style="width: 4%">
                <col class="con1">
                <col class="con0">
                <col class="con1">
                <col class="con0">
                <col class="con1">
                <col class="con0">
            </colgroup>
            <thead>
                <tr>
                    <th class="head0"><input type="checkbox" class="checkall" name="checkall" ></th>
                    <th class="head1">Rendering engine</th>
                    <th class="head0">Browser</th>
                    <th class="head1">Platform(s)</th>
                    <th class="head0">Engine version</th>
                    <th class="head1">CSS grade</th>
                    <th class="head0">&nbsp;</th>
                </tr>
            </thead>

            <tbody>
                @foreach($data as $item)
                <tr >
                    <td align="center"><input type="checkbox" name="checkboxidfile" ></td>
                    <td>{{$item->id}}</td>
                    <td>Internet Explorer 4.0</td>
                    <td>Win 95+</td>
                    <td class="center">4</td>
                    <td class="center">X</td>
                    <td class="center"><a href="#" class="edit">Edit</a> &nbsp; <a href="#" class="delete">Delete</a></td>
                </tr>
                @endforeach
                <tr>
                    <td colspan="7">
                        {{$page}}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection