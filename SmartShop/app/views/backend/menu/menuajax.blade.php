 @if(isset($arrMenu))
                @foreach($arrMenu as $item)
                <tr> 
                    <td><label value="page">{{$item->id}}</label></td> 
                    <td>@if($item->menuParent ==0) <strong> @endif <label value="page">@if($item->menuParent !=0) &nbsp;-&nbsp; @endif <a href="{{URL::action('MenuController@getMenuEdit')}}/{{$item->id}}">{{str_limit( $item->menuName, 30, '...')}}</a></label>@if($item->menuParent ==0) </strong> @endif</td>
                    <td><label value="page">{{str_limit($item->menuURL, 30, '...')}} </label></td> 
                    <td><label value="page">@if ($item->menuParent == 0 ) {{ 'Cha' }} @else {{str_limit($item->menuParentName , 30, '...')}} @endif </label></td> 
                    <td><label value="page">{{$item->menuPosition}} </label></td> 
                    <td><label value="page"></label><?php echo date('d/m/Y h:i:s', $item->time); ?></td> 
                    <td><label value="page">
                    <?php
                    if ($item->status == 0) {
                        echo "chờ kích hoạt";
                    } else if ($item->status == 1) {
                        echo "đã kích hoạt";
                    } else if ($item->status == 2) {
                        echo "đã xóa";
                    }
                    ?>
                        </label>
                    </td> 
                    <td>
                        
                        @if($item->status=='2')
                        <a href="javascript: void(0)" onclick="kichhoat({{$item -> id}}, 0)" class="btn btn4 btn_world" title="Chờ kích hoạt"></a>
                        @endif
                        @if($item->status=='0')
                        <a href="javascript: void(0)" onclick="kichhoat({{$item -> id}}, 1)" class="btn btn4 btn_flag" title="Kích hoạt"></a>
                        @endif
                        @if($item->status!='2')
                        <a href="javascript: void(0)" onclick="xoasanpham({{$item -> id}})" class="btn btn4 btn_trash" title="Xóa"></a>
                        @endif
                    </td> 
                </tr> 
                @endforeach
                @if($link!='')
                <tr>
                    <td colspan="8">{{$link}}</td>
                </tr>
                @endif

                @endif