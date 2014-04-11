 @foreach($dataproduct as $item)
                <tr >
                    <td align="center"><input type="checkbox" name="checkboxidfile" value="{{$item->id}}" ></td>
                    <td>{{$item->id}}</td>
                    <td>{{$item->cateName}}  </td>
                    <td>{{$item->productName}}</td>                  
                    <td class="center">{{$item->productPrice}} </td>
                    <td class="center">
                        @if($item->status==0)
                        Chờ đăng
                        @endif
                        @if($item->status==1)
                        Đã đăng
                        @endif 
                        @if($item->status==2)
                       Đã xóa
                        @endif

                    </td>
                    <td class="center">
                          <a href="{{URL::action('ProductController@getEditProduct')}}?idedit={{$item->id}}" class="btn btn4 btn_book" title="Sửa"></a>
                            @if($item->status=='2')
                            <a href="javascript: void(0)" onclick="kichhoat({{$item->id}}, 0)" class="btn btn4 btn_flag" title="Khởi tạo"></a>
                            @endif
                            @if($item->status=='0')
                            <a href="javascript: void(0)" onclick="kichhoat({{$item->id}}, 1)" class="btn btn4 btn_world" title="Kích hoạt"></a>
                            @endif
                            @if($item->status!='2')
                            <a href="javascript: void(0)" onclick="xoasanpham({{$item->id}})" class="btn btn4 btn_trash" title="Xóa"></a>
                            @endif
                    </td>
                </tr>
                @endforeach
                @if($page!='')
                <tr>
                    <td colspan="10">
                        {{$page}}
                    </td>
                </tr>
                @endif