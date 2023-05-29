@extends('Layout.Admin')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10" style="padding-top:5%;">
            <div class="card mx-5">
                <h1 style="color: black; text-align: center; font-size: 40px; padding-top: 10px;">Attendance</h1>
            </div>
            <div>
                <form action="" class="col-md-11" style="z-index:1; margin-left:44px;">
                    <div class="input-group mb-3">
                        <input type="search" class="form-control" placeholder="Search by Visitor, Inmate, or Date" name="search" value="{{$search}}">
                        <div class="input-group-append">
                            <button style="background-color:green"><i class="material-icons" style="font-size:25px;color:white">search</i></button>
                        </div>
                    </div>
                </form>
            </div>
            <table style="width: 91%; margin-left: auto; margin-right: auto; text-align: center;">
                <thead>
                    <tr>
                        <th style="width: 25%;">Visitor</th>
                        <th style="width: 20%;">Inmate</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <th>Date</th>
                        
                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($attendances as $attendance)
                    <tr>
                        <td style="text-align:left;">{!! $attendance->visitor !!}</td>
                        <td style="text-align:left;">{!! $attendance->inmate_att!!}</td>
                        <td>{!! $attendance->time_in !!}</td>   
                        <td>{!! $attendance->time_out !!}</td>
                        <td>{!! $attendance->date !!}</td>
                        <td>
                        <button type="button" class="btn btn-danger btn-sm" onclick="delete_attendance({{$attendance->id}})">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="text-align: center; margin-top: 20px;">
                <button type="button" class="btn btn-primary" onclick="generatePDF()">Generate PDF</button>
            </div>
        </div>
    </div>
</div>

<script>
    function generatePDF() {
        const table = document.querySelector('table');
    const clonedTable = table.cloneNode(true);

    // Remove the delete buttons from the cloned table
    const deleteButtons = clonedTable.querySelectorAll('.btn-danger');
    deleteButtons.forEach(button => button.parentNode.removeChild(button));

    const html = clonedTable.outerHTML;
        
        const data = {
            html: html
        };

        fetch('/generate-attendance-pdf', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.blob())
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'attendance.pdf';
            a.click();
            window.URL.revokeObjectURL(url);
        });
    }
</script>

@endsection

@section('inline_script')
    <script>
        function delete_attendance(id){
            if(confirm("Are you sure to delete this data?")){
                $.post('/Delete-Attendance',{id:id,_token:'{{csrf_token()}}'}).then((data)=> {               
                    if(data){
                        window.location.href='/Attendance-info';
                    }
                });
            }
        }
</script>
@endsection



