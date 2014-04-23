  <?php
                $i = 1;
                if (Input::get('page') > 1) {
                    $i = 10 * Input::get('page') - 9;
                }
                ?>
                @foreach($arrStore as $item)
                <tr id="{{$item->id}}" >  
                    <td class="center"><?php
                        echo $i;
                        $i++;
                        ?> </td>
                    <td>
                        @if(isset($arrColor))
                        <select id="color_{{$item->id}}" style="width: 100px;">
                            @foreach($arrColor as $mau)
                            <option value="{{$mau->id}}" @if($item->colorID == $mau->id) selected @endif >{{$mau->colorName}}</option>
                            @endforeach
                        </select>
                        @endif
                    </td>  
                    <td> 
                        @if(isset($arrSize))
                        <select id="size_{{$item->id}}" style="width: 100px;">
                            @foreach($arrSize as $size)
                            <option value="{{$mau->id}}" @if($item->sizeID == $size->id) selected @endif >{{$size->sizeName}}</option>
                            @endforeach
                        </select>
                        @endif
                    </td>                                      
                    <td class="center">
                        <input type="text" value="{{$item->soluongnhap}}" onkeypress="return event.charCode > 47 && event.charCode < 58;" pattern="[0-9]" id="soluongnhap_{{$item->id}}" /> 
                        <input type="hidden" value="{{$item->soluongban}}" id="soluongban_{{$item->id}}" /> 
                    </td>
                    <td class="center">{{$item->soluongban}} </td> 

                    <td ><a class="btn btn_orange btn_search radius50" href="javascript:updateStore('{{$item->id}}');" ><span>Cập nhật</span></a> &nbsp; &nbsp; <a href="javascript:deleteStore('{{$item->id}}');" class="btn btn_trash" ><span>Xóa</span></a></td>
                </tr>
                @endforeach
                @if($link!='')
                <tr>
                    <td colspan="6">
                        {{$link}}
                    </td>
                </tr>
                @endif
                @if(count($arrStore)==0)
                <tr>
                    <td colspan="6" style="text-align: center;"><span class="center">Không có dữ liệu trả về .</span></td>
                </tr>
                @endif