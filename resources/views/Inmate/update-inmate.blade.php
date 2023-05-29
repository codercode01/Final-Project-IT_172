@extends('Layout.Admin')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8" style="padding-top:5%">
        <div class="card mx-5">
        <div class="card-header">
                    <h3>Update Inmate</h3>
                </div>
                <div class="card-body">
                        <form action="{{ url('/Save-inmate-update/'.$update_inmate->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                            <label for="data">Inmate</label>
                            <input type="text" id="inmate" name="inmate" class="form-control" value="{{$update_inmate->Inmate}}">
                            </div>

                            <div class="mb-3">
                            <label for="data">Violation</label>
                            <input type="text" id="violation" name="violation" class="form-control" value="{{$update_inmate->violation}}">
                            </div>

                            <div class="mb-3">
                            <label for="data">Address</label>
                            <input type="text" id="address" name="address" class="form-control" value="{{$update_inmate->address}}">
                            </div>

                            <div class="mb-3">
                            <label for="data">Citizenship</label>
                            <input type="text" id="citizenship" name="citizenship" class="form-control" value="{{$update_inmate->citizenship}}">
                            </div>

                            <div class="mb-3">
                            <label for="status">Status</label>
                            <Select class="form-select" name="status" id="status">
                            <option>{!!$update_inmate->status!!}</option>  
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            </select>
                            </div>

                            <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection