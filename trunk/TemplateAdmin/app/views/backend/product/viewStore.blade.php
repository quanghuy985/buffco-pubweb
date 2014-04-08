<script type="text/javascript" src="{{Asset('adminlib/js/plugins/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="{{Asset('adminlib/js/custom/tables.js')}}"></script>
           <table cellpadding="0" cellspacing="0" border="0" class="stdtable" id="dyntable">
                        <colgroup>
                            <col class="con0" />
                            <col class="con1" />
                            <col class="con0" />
                            <col class="con1" />
                            <col class="con0" />
                            <col class="con1" />
                            <col class="con0" />
                        </colgroup>
                        <thead>
                            <tr>
                                <th class="head0">STT</th>
                                <th class="head1">Size</th>
                                <th class="head0">Màu sắc</th>
                                <th class="head1">Số lượng nhập</th>
                                <th class="head0">Số lượng bán</th>
                                <th class="head1">Tình trạng</th>
                                <th class="head0">Chức năng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            @if(isset($arrStore))
                            @foreach($arrStore as $item)
                            <tr class="gradeA">
                                <td>{{$i}}</td>
                                <td>{{$item->sizeName}}</td>
                                <td>{{$item->colorName}}</td>
                                <td>{{$item->soluongnhap}}</td>
                                <td>{{$item->soluongban}}</td>
                                <td><?php
                            if ($item->status == 0) {
                                echo "chờ kích hoạt";
                            } else if ($item->status == 1) {
                                echo "đã kích hoạt";
                            } else if ($item->status == 2) {
                                echo "đã xóa";
                            }
                            ?>                           
                                </td> 
                                <td><a href="javascript:void(0);" onclick="editStore('{{$item->id}}','{{$item->sizeName}}','{{$item->colorName}}','{{$item->soluongnhap}}','{{$item->soluongban}}','{{$item->status}}')">Sửa</a></td>
                                <?php $i++; ?>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>