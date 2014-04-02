 @foreach($dataproduct as $item)
                <tr >
                    <td align="center"><input type="checkbox" name="checkboxidfile" value="{{$item->id}}" ></td>
                    <td>{{$item->id}}</td>
                    <td>{{$item->cateName}}  </td>
                    <td>{{$item->productName}}</td>                  
                    <td class="center">{{$item->productPrice}} </td>
                    <td class="center">{{str_limit( $item->promotionName, 35, '...')}}</td>                    
                    <td class="center">
                        @if($item->status==0)
                        chờ đăng
                        @endif
                        @if($item->status==1)
                        đã đăng
                        @endif 
                        @if($item->status==2)
                        xóa
                        @endif

                    </td>
                    <td class="center"><a href="{{URL::action('ProductController@getEditProduct')}}?idedit={{$item->id}}" >Chỉnh sửa</a> &nbsp; <a href="javascript: void(0)" onclick="xoasanpham({{$item->id}})">Xóa</a></td>
                </tr>
                @endforeach
                @if($page!='')
                <tr>
                    <td colspan="10">
                        {{$page}}
                    </td>
                </tr>
                @endif