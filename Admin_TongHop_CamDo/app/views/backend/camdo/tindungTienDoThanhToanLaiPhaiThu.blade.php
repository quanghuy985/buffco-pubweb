<script type="text/javascript" src="{{Asset('adminlib/js/custom/custom.js')}}"></script>
<div class="contenttitle2">
    <h3>Thông tin tiến độ</h3>
</div>
@if(isset($arrTienDo))

<table cellpadding="0" cellspacing="0" border="0" id="table2" class="stdtable stdtablecb">
    <colgroup>
        <col class="con0" style="width: 3%">
        <col class="con1" style="width: 12%">
        <col class="con0" style="width: 10%">
        <col class="con1" style="width: 10%">
        <col class="con0" style="width: 10%">
        <col class="con1" style="width: 15%">
        <col class="con0" style="width: 10%">
        <col class="con1" style="width: 10%">
        <col class="con0" style="width: 10%">
        <col class="con1" style="width: 15%">

    </colgroup>
    <thead>
        <tr>
            <th class="head0">STT</th> 
            <th class="head1">Họ tên</th>
            <th class="head0">Miêu tả</th>
            <th class="head1">Đợt</th>
            <th class="head0">Số tiền dự kiến</th>
            <th class="head1">Số tiền thực trả</th>
            <th class="head0">Ngày dự kiến</th>
            <th class="head1">Ngày thực tế</th>
            <th class="head0">Tình trạng</th>
            <th class="head1">Chức năng</th>
        </tr>  
    </thead>
    <tbody id="tableTienDo"> 

        <?php $i = 1 ?>
        @if(isset($arrTienDo))
        @foreach($arrTienDo as $itemTienDo)
        <tr> 
            <td>{{$i}}</td> 
            <td><label value="manuf">{{str_limit( $itemTienDo->userLastName.' '.$itemTienDo->userFirstName, 30, '...')}}</label></td> 
            <td><label value="manuf">{{str_limit( $itemTienDo->vaytienDescription, 30, '...')}}</label></td> 
            <td><label value="manuf">{{str_limit( $itemTienDo->name, 30, '...')}} </label></td> 


            <td><label value="manuf">{{number_format($itemTienDo->sotiendukien,0,'.', ',')}}</label></td> 
            <td> 
                <form class="stdform stdform2" method="post" action="javascript:void(0)">
                    {{Form::text('sotientra',number_format($itemTienDo->sotientra,0,'.', ','), array('id'=>'sotientra'.$i,'placeholder'=>'Nhập giá trị','onchange'=>"changemoney('sotientra$i', this.value)",'onkeyup'=>"changemoney('sotientra$i', this.value)"))}}
                </form>
            </td> 
            <td><label value="manuf"><?php echo date('m/d/Y', $itemTienDo->timedukien); ?></label></td> 
            <td>
                <form class="stdform stdform2" method="post" action="javascript:void(0)">
                    <?php
                    $timetra = '';
                    if (!$itemTienDo->timetra == '') {
                        $timetra = date('m/d/Y', $itemTienDo->timetra);
                    }
                    ?>
                    {{Form::text('timetra',$timetra , array('id'=>'datepicker-'.$i, 'class'=>"longinput"))}}
                    <script>
        jQuery("#datepicker-{{$i}}").datepicker();</script>
                </form>

            </td> 
            <td><label value="manuf">
                    <form class="stdform stdform2" method="post" action="javascript:void(0)">
                        <?php
                        $selectData = Lang::get('general.batho_tiendo_data_status');
                        unset($selectData['']);
                        echo Form::select('status', $selectData, $itemTienDo->status, array('id' => 'status-' . $i));
                        ?>
                    </form>
                </label>
            </td> 

            <td>
                <input type="button" onclick="capnhat({{$itemTienDo->id}}, jQuery('#datepicker-{{$i}}').val(),jQuery('#sotientra{{$i}}').val(),jQuery('#status-{{$i}}').val(),{{$itemTienDo->tindungid}})" id="btPrint" class="stdbtn btn_orange ui-button ui-widget ui-state-default ui-corner-all" value="Cập nhật" role="button" aria-disabled="false">
            </td>

        </tr> 
        <?php $i++ ?>

        @endforeach
        @endif
    <script>
                        function capnhat(id, timetra, sotientra, status, idbh){
                        var request = jQuery.ajax({
                        url: "{{URL::action('vaytienController@postUpdateTienDoLaiPhaiThu')}}",
                                type: "POST",
                                dataType: "html",
                                data: {id:id, timetra:timetra, sotientra:sotientra, status:status, idbh:idbh}
                        });
                                request.done(function(msg) {
                                jQuery('#tableTienDo').html(msg);
                                        jQuery.jGrowl("Đã tải dữ liệu thành công ...");
                                });
                        }
    </script>
</tbody>
</table>
@endif