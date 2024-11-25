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
                              Commission Directive Activity
                            </div>
                            @if(@$check->report_status!="A")
                            <div class="col-sm">
                              <!-- Button trigger modal -->
                              
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModa2">
                                    + Add Activty
                                </button>
                               
                            </div>
                            @endif
                          </div>
                          
                    </div>

                    


                        <div class = "card-body">
                            @include('tacktical.indi.navbar')
                            {{-- <h5>
                              <small>Dzonkhags related to the complaint (Only PDF files are allowed)</small>
                            </h5> --}}

                            <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                  <a class="nav-link @if(Route::is('tacktical.inteligence.autorization.individual.commission.directives.page')) active btn btn-success @endif"  href="{{route('tacktical.inteligence.autorization.individual.commission.directives.page',['id'=>@$id])}}"> Commission Directives</a>
                                </li>

                                
                                <li class="nav-item">
                                  <a class="nav-link @if(Route::is('tacktical.inteligence.autorization.individual.commission.directives.page.activity')) active btn btn-success @endif"  href="{{route('tacktical.inteligence.autorization.individual.commission.directives.page.activity',['id'=>@$id])}}">Commission Directive Activities</a>
                                </li>

                                
                            </ul>

                            <div class="row">
                                <div class="col-md-12">
                                    <form method="post" action="{{route('tacktical.inteligence.autorization.individual.commission.directives.page.activity',@$id)}}">
                                        @csrf
                                        <div class="row">
                                        <div class="col-md-6">
                                        <div class="form-group">
                                          <label for="exampleInputEmail1">Commission Directives</label>
                                          <select class="form-control" name="com_id" required>
                                              <option value="">Select</option>
                                              @foreach(@$directives as $value)
                                              <option value="{{@$value->id}}" @if(request('com_id')==@$value->id) selected @endif>{{@$value->description}}</option>
                                              @endforeach
                                          </select>
                                         </div>
                                         </div>
                                         <div class="col-md-6"><button type="submit" class="btn btn-primary mt-4">Search</button></div>
                                     </div>
                                    </form>
                                </div>
                            </div>                            

                            <table id  = "maintable" class="table" >
                                <thead>
                                    <tr>
                                        <th>Task / Information Needed</th>
                                        <th>Assignment Date</th>
                                        <th>Completion Date</th>
                                        <th>Created On (Date)</th>
                                        <th>Officer Assigned</th>
                                        <th>Source Information</th>
                                        <th>Collection Method</th>
                                        <th>Chief Status</th>
                                        <th>Action</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(@$decision->isNotEmpty())
                                    @foreach(@$decision as $att)
                                    <tr>
                                        <td>{{ $att->activity}}</td>
                                        <td>{{ $att->start_date }}</td>
                                        <td>{{ $att->end_date }}</td>
                                        <td>{{ $att->created_on }}</td>

                                        <td>
                                            @php
                                                $explode = explode(',',$att->members);
                                                $selected_user = DB::table('users')->whereIn('id',$explode)->get();
                                            @endphp

                                            @foreach(@$selected_user as $user)
                                                {{@$user->name}},
                                            @endforeach

                                        </td>
                                        <td>{{ $att->source_information }}</td>
                                        <td>{{ $att->collection_method }}</td>
                                        <td>@if(@$att->chief_decision=="AA") Awaiting @elseif(@$att->chief_decision=="A") Accept @else Reject @endif</td>
                                        <td>
                                                        
                                                            
                                                             <a type="button"
                                                                class="btn btn-xs btn-primary edit_button"
                                                                data-id="{{$att->id}}"
                                                                data-com_id="{{$att->com_id}}"
                                                                data-source_information="{{$att->source_information}}"
                                                                data-collection_method="{{$att->collection_method}}"
                                                                data-remarks="{{$att->remarks}}"
                                                                data-activity="{{$att->activity}}"
                                                                data-start_date="{{$att->start_date}}"
                                                                data-end_date="{{$att->end_date}}"
                                                                data-created_on="{{$att->created_on}}"
                                                                data-members="{{$att->members}}"
                                                                data-chief_decision="{{$att->chief_decision}}"
                                                                data-chief_remark="{{$att->chief_remark}}"
                                                                data-toggle="modal"
                                                                >
                                                                Edit / View More
                                                            </a>
                                                            
                                                            
                                                            @if(@$check->report_status!="A")
                                                            <a class="btn btn-xs btn-danger" href="{{route('member.get.information.report.assignment.intel.project.idiary.page.delete.data',['id'=>$att->id])}}" onclick="return confirm('Are you sure , you want to delete this  ? ')"><i class="fa fa-trash"></i>
                                                                Delete
                                                            </a>
                                                            @endif
                                                            
                                                            
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif

                                    
                                                  
                               </tbody>
                            </table>
                        </div>
                </div>
            </div>
        </div>


        <!-- Modal -->
<div class="modal fade" id="exampleModa2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Activity</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form method="post" action="{{route('tacktical.inteligence.autorization.individual.commission.directives.page.activity.insert.data')}}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="ip_id" value="{{@$id}}">

                <div class="form-group">
                  <label for="exampleInputEmail1">Commission Directives</label>
                  <select class="form-control" name="com_id" required>
                      <option value="">Select</option>
                      @foreach(@$directives as $value)
                      <option value="{{@$value->id}}">{{@$value->description}}</option>
                      @endforeach
                  </select>
                 </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">Source Of Information</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" name="source_information" aria-describedby="emailHelp" placeholder="Source Of Information">
                 </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">Collection Method</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" name="collection_method" aria-describedby="emailHelp" placeholder="Collection Method">
                 </div>


                <div class="form-group">
                  <label for="exampleInputEmail1">Task / Information Needed</label>
                  <input type="text" class="form-control" id="exampleInputEmail1" name="activity" aria-describedby="emailHelp" placeholder="Activity Name">
                 </div>


                 <div class="form-group">
                  <label for="exampleInputEmail1">Assignment Date</label>
                  <input type="date" class="form-control" id="exampleInputEmail1" name="start_date" aria-describedby="emailHelp">
                 </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">Completion Date</label>
                  <input type="date" class="form-control" id="exampleInputEmail1" name="end_date" aria-describedby="emailHelp">
                 </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">Created On</label>
                  <input type="date" class="form-control" id="exampleInputEmail1" value="{{date('Y-m-d')}}" name="created_on" aria-describedby="emailHelp">
                 </div>


                  <div class="form-group mb-3">
                  <label for="select2Multiple">Officer Assigned</label>
                  <br>
                  <select class="select2-multiple form-control" name="members[]" multiple="multiple"
                    id="select2Multiple">
                    @foreach(@$users as $val)
                    <option value="{{@$val->id}}">{{@$val->name}}</option>
                    @endforeach              
                  </select>
                </div>

                <div class="form-group">
                  <label for="exampleInputEmail1">Remarks</label>
                  <textarea type="text" class="form-control" id="exampleInputEmail1"  name="remarks" aria-describedby="emailHelp"></textarea>
                 </div>





                 

                 
        
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
        </div>
      </div>
    </div>
  </div>


<!--Edit Modal -->
            <div class="modal fade" id="exampleModaEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Activity</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" action="{{route('tacktical.inteligence.autorization.individual.commission.directives.page.activity.update.data')}}">@csrf

                                <div class="form-group">
                                  <label for="exampleInputEmail1">Commission Directives</label>
                                  <select class="form-control" name="com_id" id="com_id" disabled required>
                                      <option value="">Select</option>
                                      @foreach(@$directives as $value)
                                      <option value="{{@$value->id}}">{{@$value->description}}</option>
                                      @endforeach
                                  </select>
                                 </div>

                                 <div class="form-group">
                                  <label for="exampleInputEmail1">Source Of Information</label>
                                  <input type="text" class="form-control" id="source_information" name="source_information" aria-describedby="emailHelp" placeholder="Source Of Information">
                                 </div>

                                 <div class="form-group">
                                  <label for="exampleInputEmail1">Collection Method</label>
                                  <input type="text" class="form-control" id="collection_method" name="collection_method" aria-describedby="emailHelp" placeholder="Collection Method">
                                 </div>
                                
                               <div class="form-group">
                              <label for="exampleInputEmail1">Task / Information Needed</label>
                              <input type="text" class="form-control" id="activity" name="activity" aria-describedby="emailHelp" placeholder="Task / Information Needed">
                             </div>


                             <div class="form-group">
                              <label for="exampleInputEmail1">Assignment Date</label>
                              <input type="date" class="form-control" id="start_date" name="start_date" aria-describedby="emailHelp">
                             </div>

                             <div class="form-group">
                              <label for="exampleInputEmail1">Completation Date</label>
                              <input type="date" class="form-control" id="end_date" name="end_date" aria-describedby="emailHelp">
                             </div>

                             <div class="form-group">
                              <label for="exampleInputEmail1">Created On</label>
                              <input type="date" class="form-control" id="created_on" name="created_on" aria-describedby="emailHelp">
                             </div>


                              <div class="form-group mb-3">
                              <label for="select2Multiple">Completation Date</label>
                              <br>
                              <select class="select2-multiple form-control" name="members[]" multiple="multiple"
                                id="leaderMultiSelctdropdown">
                                @foreach(@$users as $val)
                                <option value="{{@$val->id}}">{{@$val->name}}</option>
                                @endforeach              
                              </select>
                            </div>

                            <div class="form-group">
                                  <label for="exampleInputEmail1">Remarks</label>
                                  <textarea type="text" class="form-control" id="remarks"  name="remarks" aria-describedby="emailHelp"></textarea>
                            </div>

                            <div class="form-group">
                              <label for="exampleInputEmail1">Chief Decision</label>
                              <input type="text" class="form-control" disabled id="chief_decision"  aria-describedby="emailHelp">
                            </div>

                            <div class="form-group">
                              <label for="exampleInputEmail1">Chief Remarks</label>
                              <textarea type="text" class="form-control" disabled id="chief_remark"  aria-describedby="emailHelp"></textarea>
                            </div>
                                 
                             <input type="hidden" name="id" id="id">
                             @if(@$check->report_status!="A")
                                <button type="submit" class="btn btn-primary">Submit</button>
                                @endif
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
</section>

<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $('.edit_button').on('click',function(){
            $('#activity').val($(this).data('activity'));
            $('#start_date').val($(this).data('start_date'));
            $('#end_date').val($(this).data('end_date'));
            $('#created_on').val($(this).data('created_on'));
            $('#remarks').val($(this).data('remarks'));
            $('#com_id').val($(this).data('com_id')).change();
            $('#source_information').val($(this).data('source_information'));
            $('#collection_method').val($(this).data('collection_method'));
            $('#remarks').val($(this).data('remarks'));

            $('#chief_decision').val($(this).data('chief_decision'));
            if($(this).data('chief_decision')=="AA")
            {
                $('#chief_decision').val('Awaiting');
            }else if($(this).data('chief_decision')=="A")
            {
                $('#chief_decision').val('Accept');
            }else{
                $('#chief_decision').val('Reject');
            }
            $('#chief_remark').val($(this).data('chief_remark'));

            let string = $(this).data('members');
            $('#id').val($(this).data('id'));
            // let arr = string.split(',');

            if (/,/.test(string)) {
                 let arr = string.split(',');
                 $("#leaderMultiSelctdropdown").val(arr);
                 $('#leaderMultiSelctdropdown').val(arr).change();
            }else{
                let arr = [string];
                 $("#leaderMultiSelctdropdown").val(arr);
                $("#leaderMultiSelctdropdown").val(arr);
                $('#leaderMultiSelctdropdown').val(arr).change();
            }
            

            
            
            
            $('#exampleModaEdit').modal('show');
        })
</script>

     <script>
        $(document).ready(function() {
            // Select2 Multiple
            $('.select2-multiple').select2({
                placeholder: "Select",
                allowClear: true
            });

        });

    </script>


@endsection