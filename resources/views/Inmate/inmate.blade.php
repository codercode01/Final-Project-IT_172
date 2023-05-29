@extends('Layout.Admin')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10" style="padding-top:5%;">

            <div class="card mx-5">
            <h1 style="color: black;text-align: center;font-size:40px;padding-top:10px">List of Inmates </h1>
            </div>
            <div>
            <form action="" class="col-md-11" style="z-index:1; margin-left:44px;" >
               
                <div class="input-group mb-3">
                <input type="search" class="form-control" placeholder="Search Inmate" name="search" value="{{$search}}">
                <div class="input-group-append">
                <button style="background-color:green"><i class="material-icons" style="font-size:25px;color:white">search</i></button>
                </div>
            </div>
                
            </form>
            </div>
                <table style= "width:91%; margin-left:auto;margin-right:auto;">

                <tr>
                    <thead>
                        <th style="width:20%">Inmate</th>
                        <th>Violation</th>
                        <th>Address</th>
                        <th>Citizenship</th>
                        <th>Status</th>
                        <th style="width:15%">Action</th>
                    </thead>
                </tr> 
                <tbody>
                    <tr>
                    @foreach($inmates as $inmate)
                            <tr>
                                <td>{!!$inmate->Inmate!!}</td>
                                <td>{!!$inmate->violation!!}</td>
                                <td>{!!$inmate->address!!}</td>
                                <td>{!!$inmate->citizenship!!}</td>
                                <td>{!!$inmate->status!!}</td>
                                
                                
                                <td>
                                <button type="button" style="width: 54px; padding: 3px 15px;" class="btn btn-primary btn-sm"><a href="/Update-inmate/{{$inmate->id}}" Style="color:white;text-decoration:none;" >Edit</a></button>
                                <button type="button" class="btn btn-danger btn-sm" onclick="delete_inmate({{$inmate->id}})">Delete</button>
                                </td>

                            </tr>
                        
                    @endforeach
                    </tr>

                <td colspan="5"><a href="/inmate-registration" type='button' style="width: 300px; padding: 3px 15px; border-radius:5px; text-decoration:none; text-align:center; background-color:green;color:white; margin-left:5%;">Add Inmate</button></a></td>
                </tr>
                    
                </tbody>

                </table>

                </div>
        </div>
    </div>  
@endsection
@section('inline_script')
    <script>
        function delete_inmate(id){
            if(confirm("Are you sure to delete this data?")){
                $.post('/Delete-inmate',{id:id,_token:'{{csrf_token()}}'}).then((data)=> {               
                    if(data){
                        window.location.href='/inmate-info';
                    }
                });
            }
        }
</script>
@endsection
