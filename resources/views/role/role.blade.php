@extends('layouts.admin')

@section('content')

    <br>
    <section class="content">
        <div id="casedetailscard" class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header" style="font-family:Product Sans">
                            {{-- Dzonkhag List --}}
                            <div class="row" style="font-family:Product Sans">
                                <div class="col-sm">
                                    Role List
                                </div>
                                <div class="col-sm">
                                    <!-- Button trigger modal -->
                                    @if(@$add=="Y")
                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#exampleModa2">
                                        Add
                                    </button>
                                    @endif
                                </div>
                            </div>

                        </div>




                        <div class="card-body">
                            {{-- <h5>
                              <small>Dzonkhags related to the complaint (Only PDF files are allowed)</small>
                            </h5> --}}
                            <table id="maintableDz" class="table">
                                <thead>
                                    <tr>
                                        {{-- <th>#</th> --}}
                                        <th>Role Name</th>
                                        <th>Role Description</th>
                                        <th>Permission</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (@$data->isNotEmpty())
                                        @foreach (@$data as $att)
                                            <tr>
                                                <td>{{ $att->role_name   }}</td>
                                                <td>{{ $att->role_description   }}</td>
                                                
                                                <td><a href="{{route('manage.permission',['id'=>$att->id])}}" class="btn btn-warning">Permission</a></td>
                                                
                                                <td>
                                                
                                                    @if(@$edit=="Y")
                                                    <a type="button"
                                                        class="btn btn-xs btn-primary edit_button row-class-{{ @$att->dzoID }}"
                                                         data-name="{{$att->role_name}}" data-description="{{$att->role_description}}" data-id="{{$att->id}}"   data-toggle="modal"
                                                        >
                                                        <i
                                                            class="fa fa-edit"></i>
                                                    </a>
                                                    @endif

                                                    <a class="btn btn-xs btn-danger"
                                                        href="{{ route('manage.role.delete', ['id' => @$att->id]) }}"
                                                        onclick="return confirm('Are you sure , you want to delete this  ? ')"><i
                                                            class="fa fa-trash"></i>
                                                        
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>No Data Found</td>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Modal -->
            <div class="modal fade" id="exampleModa2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Role</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('manage.role.insert') }}">@csrf
                                

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Role Name</label>
                                    <input type="text" class="form-control"  name="role_name"
                                         placeholder="Role Name" required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Role Description</label>
                                    <textarea type="text" class="form-control"  name="role_description"
                                         placeholder="Role Description" required></textarea>
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
                            <h5 class="modal-title" id="exampleModalLabel">Edit Role</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('manage.role.update') }}">@csrf
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Role Name</label>
                                    <input type="text" class="form-control"  name="role_name"
                                         placeholder="Role Name" id="role_name" required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Role Description</label>
                                    <textarea type="text" class="form-control"  name="role_description"
                                         placeholder="Role Description" id="role_description" required></textarea>
                                </div>
                                <input type="hidden" name="id" id="id">

                               
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


        </div>
    </section>


    <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
    <script type="text/javascript" charset="utf8"
        src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
    <script>
        // $(function() {
        //     $("#maintableDz").dataTable();
        // });

        $(document).ready(function() {
            $('#maintableDz').DataTable({
                order: [
                    [0, 'desc']
                ],
            });
        });

// ;

        $('.edit_button').on('click',function(){
            $('#role_name').val($(this).data('name'));
            $('#role_description').val($(this).data('description'));
            $('#id').val($(this).data('id'));
            $('#exampleModaEdit').modal('show');
        })
        
    </script>




@endsection
