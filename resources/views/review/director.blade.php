@extends('layouts.admin')

@section('content')

<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline card-outline-tabs">
                    <div class="card-header" style="font-family:Product Sans"> 
                        {{-- Embassy List --}}
                        <div class="row" style="font-family:Product Sans">
                            <div class="col-sm">
                                List Of Assigned Cases
                            </div>
                           </div>
                    </div>

                    


                        <div class = "card-body">
                            {{-- <h5>
                              <small>Dzonkhags related to the complaint (Only PDF files are allowed)</small>
                            </h5> --}}
                            <form method="post" id="form_submit" action="{{route('ces.cases.listing.availability.update')}}">
                                @csrf  
                                <input type="hidden"  class="id_value" name="id_value">
                                        <input type="hidden" name="optradio_value" class="optradio_value" >  
                            <table id  = "maintableEvalDec" class="table" >
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Complaint Registration No.</th>
                                        <th>Complaint Registration Date</th>
                                        <th>Complaint Brief</th>
                                        <th>Allgeation Name</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                    @if(@$data->isNotEmpty())
                                    
                                    @foreach(@$data as $key=> $att)
                                    <tr> 
                                        @php
                                         $check = DB::table('compalint_evaluation_review_team')->where('coi_status','Y')->first();
                                        @endphp
                                        <tr @if($check!="") style="background-color: red;color: white;" @endif>
                                        <td @if($check!="") style="background-color: red;color: white;" @endif>{{ $att->complaintID}}</td>
                                        <td>{{ $att->complaintRegNo}}</td>
                                        <td>{{ $att->complaintDateTime }}</td>
                                        <td>{!! substr($att->complaintDetails,0,350) !!}</td>
                                        <td>{{@$att->allegation_name}}</td>
                                        
                                        
                                        <td>
                                            
                                                

                                                
                                                <a href="{{route('asssign.review.team.evaluation',['id'=>@$att->complaintID])}}" class="btn btn-success">Assign Review Team</a>
                                                

                                           

                                        </td>
                                    </tr>
                                
                                    @endforeach
                                    @else
                                    <tr><td>No Data Found</td></tr>
                                    @endif
                                          
                               </tbody>
                            </table>
                            </form>        
                        </div>
                </div>
            </div>
        </div>


        
    </div>
</section>



<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
<script type="text/javascript" charset="utf8"
    src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
<script>


    $(document).ready(function() {
    $('#maintableEvalDec').DataTable({
        order: [
            [0, 'desc']
        ],

    });
});

$(".radio_option:radio").on('change',function(){
    
    $('.id_value').val($(this).data('id'));
    $('.optradio_value').val($(this).val());
    
    $('#form_submit').submit();
});
</script>


@endsection