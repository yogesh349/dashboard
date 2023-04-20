@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<div class="page-content">
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">Edit Profile</h4>
                    <form action="{{route('store.profile')}}" method="post" enctype="multipart/form-data">
                        @csrf
                    <div class="row mb-3">
                        <label for="example-text-input" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="text"  id="name" name="name" value="{{$editData->name}}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="example-text-input" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="email" id="email" name="email" value="{{$editData->email}}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="example-text-input" class="col-sm-2 col-form-label">Profile Image</label>
                        <div class="col-sm-10">
                            <input class="form-control" type="file" id="image" name="profile_image">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="example-text-input" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-10">
                            <img id="showImage" class="rounded avatar-lg" src="{{asset('backend/assets/images/small/img-5.jpg')}}" alt="Card image cap">
                        </div>
                    </div>
                    <input type="submit" value="Update" class="btn btn-info waves-effect waves-light">
                </form>
                </div>
            </div>
        </div> <!-- end col -->
    </div>




</div>
</div>

<script>
    $(document).ready(function () {
        $('#image').change(function (e) { 
            e.preventDefault();
            var reader=new FileReader();
            reader.onload=function(e){
                $('#showImage').attr('src',e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);  
            
        });
        
    });
</script>

@endsection