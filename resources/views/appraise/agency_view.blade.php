@extends('layouts.admin')

@section('content')
    <style type="text/css">
        .dropdown-toggle{
            height: 40px;
            width: 400px !important;
        }
        .tox .tox-notification--warn, .tox .tox-notification--warning {
            display: none;
        }
            
        .card{
            padding: 25px;
        }

            </style>
<br>
<section class="content">
    <div id="casedetailscard" class="container-fluid">

        <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
       
      </ul>



        
            <div class="row">
              


                @include('appraise.details_component')


            

             

                
         <div class="col-sm-12">  
            
        <form method="post" id="agency_form" action="{{route('appraise.agency.review.list.decision.update')}}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{@$id}}">
            <div class="row">
                <div class="col-sm-12">
                    
                  <div class="form-group">
                    <label>Activity Type</label>
                    <select class="form-control"  name="agency_activity_type" required>
                        <option value="">Select</option>
                        <option value="Brief Agency" @if(@$data->brief_agency_status_assign!="IN") @if(@$data->agency_activity_type=="Brief Agency") selected @endif @endif>Brief Agency</option>
                        <option value="Appraise Comission" @if(@$data->brief_agency_status_assign!="IN") @if(@$data->agency_activity_type=="Appraise Comission") selected @endif @endif>Appraise Comission</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Letter Date</label>
                    <input type="date" name="letter_date" value="{{@$data->letter_date}}" required class="form-control">
                  </div>

                  <div class="form-group">
                    <label>Letter No</label>
                    <input type="text" name="letter_no" value="{{@$data->letter_no}}" required class="form-control">
                  </div>

                  <div class="form-group">
                    <label>Agency Remakrs</label>
                    <textarea class="form-control" required name="agency_remarks">{{@$data->agency_remarks}}</textarea>
                  </div> 

                  

                  <div class="form-group">
                    <label>Attachment</label>
                    <input type="file" name="agency_attachment"  class="form-control">
                  </div>

                  @if(@$data->agency_attachment!="")
                    <div class="form-group"> 
                        <a class="btn btn-xs btn-info"  href="{{URL::to('attachment/review_activity')}}/{{$data->agency_attachment}}" target="_blank"> <i class="fa fa-eye"></i>
                                                                View
                            </a> </div>
                   @endif


                    
                <div class="col-sm-12"></div>
                @if(@$data->brief_agency_status_assign=="IN")
                <div class="col-sm-6"><button type="submit" class="btn btn-info">Submit</button></div>
                @elseif(@$data->brief_agency_status_assign!="IN" && @$data->agency_activity_type!="Appraise Comission")
                <div class="col-sm-6"><button type="submit" class="btn btn-info">Submit</button></div>
                @endif
                <div class="col-sm-6"></div>
            </div>
        </form>

        
    </div>









                






               
    </div>
</section>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>   

    <script type="text/javascript">
        $('input[type=radio][name=evaluation]').on('change', function() {
          var evaluation =  $(this).val();
           if(evaluation=="Y")
           {
             $('.describe').show();
           }else{
            $('.describe').hide();
           } 
        });
    </script>

    {{-- <script type="text/javascript">
        $('#agency_form *').prop('disabled', true);
    </script> --}}


@endsection