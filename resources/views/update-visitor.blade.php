@extends('Layout.Admin')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8" style="padding-top:10%">
        <div class="card mx-5">
        <div class="card-header">
                    <h3>Update Visitor Info</h3>
                </div>
                <div class="card-body">
                        <form action="{{ url('/Save-visitor-update/'.$update_visitor->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                            <label for="data">Visitor</label>
                            <input type="text" id="visitor" name="visitor" class="form-control" value="{{$update_visitor->visitor}}">
                            </div>

                            <div class="mb-3">
                            <label for="inmate">Inmate</label>
                            <select id="inmate" name="inmate" class="form-control">
                            <option >{!!$update_visitor->inmate!!}</option>  
                            <option value="none">-None-</option>
                            @foreach($inmates as $inmate)
                                <option value="{{ $inmate->Inmate }}">{{ $inmate->Inmate }}</option>
                            @endforeach
                            </select>
                            </div>

                            <div class="mb-3">
                            <label for="data">Contact</label>
                            <input type="text" id="contact" name="contact" class="form-control" value="{{$update_visitor->contact}}">
                            </div>

                            <div class="mb-3">
                                <label for="address">Address</label>
                                <input type="text" id="address" name="address" class="form-control" value="{{$update_visitor->address}}">
                            </div>

                            <div class="mb-3">
                                <label for="relationship">Relationship</label>
                                <select class="form-select" name="relationship" id="relationship">
                                <option>{!!$update_visitor->relationship!!}</option>  
                                <option value="none">-None-</option>  
                                    <option value="family">Family</option>
                                    <option value="relative">Relative</option>
                                    <option value="others">Others</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="status">Status</label>
                                <select class="form-select" name="status" id="status">
                                <option>{!!$update_visitor->status!!}</option>  
                                    <option value="active">Active</option>
                                    <option value="block">Block</option>
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