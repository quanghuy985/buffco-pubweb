@if(isset($arrayUsers))
                @foreach($arrayUsers as $item)
                <tr> 
                    <td><input name="checkboxidfile" type="checkbox" value="{{$item->id}}"></td> 
                    <td><a href="javascript:void(0);" onclick="detail('{{$item->userEmail}}','{{$item->userFirstName}}','{{$item->userLastName}}','{{$item->userDOB}}','{{$item->userAddress}}','{{$item->userPhone}}')">{{str_limit( $item->userEmail, 10, '...')}}</a></td>                     
                    <td><label value="user">{{str_limit( $item->userAddress, 10, '...')}}</label></td>
                    <td><label value="user">{{str_limit($item->userPhone, 10, '...')}} </label></td> 
                    <td><label value="user"></label><?php echo date('d/m/Y h:i:s', $item->time); ?></td> 
                    <td><label value="user">
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
                        <a href="{{URL::action('UserController@getUserEdit')}}?id={{$item->id}}" class="btn btn4 btn_book" title="Sửa"></a>
                        @if($item->status=='2')
                        <a href="javascript: void(0)" onclick="kichhoat({{$item->id}}, 0)" class="btn btn4 btn_flag" title="Chờ kích hoạt"></a>
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
                @if($link!='')
                <tr>
                    <td colspan="9">{{$link}}</td>
                </tr>
                @endif
                
                @endif