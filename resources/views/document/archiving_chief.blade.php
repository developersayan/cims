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

            @include('document.common_chief')



        
            <div class="row">
              
                




    {{-- table-showing --}}
    <div class="col-sm-12">

                        <div class = "card-body">
                            <h5>
                              Archiving
                              
                            </h5>
                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>File Name / No</th>
                                        <th>Accessed By</th>
                                        <th>Date & Time</th>
                                        
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$archiving->isNotEmpty())
                                    @foreach(@$archiving as $att)
                                    <tr>
                                        
                                        <td>{{ @$att->file_details->document_no }}</td>
                                        <td>{{ $att->accessed_by}}</td>
                                        <td>{{ $att->date}} - {{$att->time}}</td>
                                        
                                        
                                        <td>

                                                <a class="btn btn-xs btn-info edit_offence" data-id="{{@$att->id}}" data-file_id="{{@$att->file_id}}" data-particular="{{@$att->particular}}" 
                                                data-accessed_by="{{@$att->accessed_by}}" 
                                                data-date="{{@$att->date}}"
                                                data-time="{{@$att->time}}"
                                                data-purpose="{{@$att->purpose}}"
                                               
                                                href="javascript:void(0)" data-><i class="fa fa-eye"></i>
                                                                
                                                 </a>

                                                 
                                        
                                                
                                                            

                                                            
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr><td>No Data Found</td></tr>
                                    @endif
                                                  
                               </tbody>
                            </table>
                        </div>

 </div>






               <div class="modal fade" id="offence_model_edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Document Access Record</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('manage.seized.document.get.official.archiving.update')}}">@csrf
                        
                         <input type="hidden" name="id"  id="id">
                         
                        

                         <div class="form-group">
                          <label for="exampleInputEmail1">File/Document No</label>
                          <select class="form-control" name="file_id" id="file_id_edit" disabled>
                            <option value="">Select</option>
                            @foreach(@$receipt as $value)
                            <option value="{{@$value->id}}">{{@$value->document_no}}</option>
                            @endforeach
                           </select>
                         </div>

                         

                         <div class="form-group">
                          <label for="exampleInputEmail1">Accessed By</label>
                          <input type="text" class="form-control" name="accessed_by"  disabled id="accessed_by">
                         </div>

                        

                         <div class="form-group">
                          <label for="exampleInputEmail1">Access Date</label>
                          <input type="date" class="form-control" name="date" disabled  id="date">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Access Time</label>
                          <input type="time" class="form-control" name="time" disabled  id="time">
                         </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Purpose</label>
                          <textarea type="text" class="form-control" name="purpose" disabled  id="purpose"></textarea>
                         </div>

                         

                         

        
                        
                      </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                        </div>
                    </div>
                </div>
            </div> 


 
        </div>
    </div>
</section>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script> 


    <script type="text/javascript">
  $(document).ready(function(){
    $('#particular').on('change',function(e){
      
      e.preventDefault();
      var id = $(this).val();
      
      $.ajax({
        url:'{{route('get.receipt.detials.from-particular')}}',
        type:'GET',
        data:{id:id,case:'{{@$case_id}}'},
        success:function(data){
          console.log(data);
          $.each(data, function(index, value) {
                    // APPEND OR INSERT DATA TO SELECT ELEMENT.
                    console.log(value);
                    $('#file_id').append('<option value="' + value.id + '">' + value.document_no +
                        '</option>');
          });
         }
      })
    
   })
  })
</script>

    <script>


    $(document).ready(function() {
    $('#maintableEvalDec').DataTable({
        order: [
            [0, 'desc']
        ],

    });
});


</script>


<script type="text/javascript">
    $('#offences_add').on('click',function(){
            $('#offence_model').modal('show');
        })
</script>

<script type="text/javascript">
    $('.edit_offence').on('click',function(){
            $('#id').val($(this).data('id'));
            $('#particular_edit').val($(this).data('particular')).change();
            $('#file_id_edit').val($(this).data('file_id')).change();
            $('#accessed_by').val($(this).data('accessed_by'));
            
            
            $('#date').val($(this).data('date'));
            $('#time').val($(this).data('time'));
            $('#purpose').val($(this).data('purpose'));
            
            
           
            $('#offence_model_edit').modal('show');
        })
</script>


<script type="text/javascript">
    $('.return_offence').on('click',function(){
            $('#id_return').val($(this).data('id'));
            $('#particular_return').val($(this).data('particular')).change();
            $('#file_id_return').val($(this).data('file_id')).change();



            $('#accessed_by_return').val($(this).data('accessed_by'));
            
            
            $('#date_return').val($(this).data('date'));
            $('#time_return').val($(this).data('time'));
            $('#purpose_return').val($(this).data('purpose'));


            $('#return_by').val($(this).data('return_by'));
            $('#return_date').val($(this).data('return_date'));
            $('#return_time').val($(this).data('return_time'));

            
            $('#remarks').val($(this).data('remarks'));
            
            
            
           
            $('#offence_model_return').modal('show');
        })
</script>

@endsection