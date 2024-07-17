@extends('layouts.app')

@section('content')

<section>
    <form id="usermanagerform" action="{{ route('savecompinfo') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="container mt-5">
            <div class="row" style="font-size: 18px;">
                <div class="col-md-6">
                    <h2>Add New Employee</h2>
                    <div class="dropdown-divider"></div>
                    <input type="hidden" id="input_eployee_code" name="input_eployee_code" class="form-control" value="">
                    <div class="form-group">
                        <label for="fullname">
                            First Name <span style="color: red;">(max: 40 characters)</span> *
                        </label>
                        <input type="text" class="form-control " id="input_first_name" name="input_first_name" required oninvalid="this.setCustomValidity('Fill First Name Field')" oninput="this.setCustomValidity('')" autocomplete="off" maxlength="40">
                    </div>
                    <div class="form-group">
                        <label for="fullname">
                            Last Name *
                        </label>
                        <input type="text" class="form-control " id="input_last_name" name="input_last_name" required oninvalid="this.setCustomValidity('Fill Last Name Field')" oninput="this.setCustomValidity('')" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="fullname">
                            Email *
                        </label>
                        <input type="email" class="form-control " id="input_email" name="input_email" required oninvalid="this.setCustomValidity('Fill Email Field')" oninput="this.setCustomValidity('')" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="fullname">
                            Date Of Birth *
                        </label>
                        <input type="date" class="form-control " id="input_email" name="input_email" autocomplete="off">
                    </div>
                    <div class="dropdown-divider"></div>
                    <div class="custom-control custom-switch mb-3">
                        <input type="checkbox" class="custom-control-input" id="input_social_status" name="input_social_status-switch">
                        <label class="custom-control-label" for="input_social_status">Married</label>
                    </div>
                    <div class="form-group">
                        <label for="nbkids">
                            Number Of Kids
                        </label>
                        <input type="text" class="form-control " id="input_nbkids" name="input_lnbkids" autocomplete="off" disabled>
                    </div>

                </div>
                <div class="col-md-6 text-center" id="profilePicture" data-path="{{ public_path('profile_picture') }}">
                    <h2>Add Profile Picture</h2>
                    <div class="dropdown-divider"></div>
                    <label class="btn btn-secondary btn-sm" style="font-size: 18px;">
                        <i class="fas fa-upload"></i> Upload Picture
                        <input type="file" id="profile_picture" name="profile_picture" style="display:none;" accept="image/*" onchange="previewImage(this)" />
                    </label>
                    <p class="mt-2">JPG، PNG، GIF</p>

                    <div id="image-preview" class="mt-3"></div>
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
                <button type="button" class="btn btn-secondary ml-2" onclick="clearForm()">Clear</button>
            </div>
        </div>
    </form>
</section>

@endsection
<script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
<script>
    document.getElementById('input_social_status').addEventListener('change', function() {
        document.getElementById('input_lnbkids').disabled = !this.checked;
    });
    //===========================================================================
   
    //========preview image when choosing logo
    function previewImage(input) {
        var preview = document.getElementById('image-preview');
        preview.innerHTML = '';

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                var img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'img-fluid';
                img.style.maxWidth = '200px';
                preview.appendChild(img);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    //========clear form
    function clearForm() {

        var form = document.getElementById('usermanagerform');
        form.reset();
        document.getElementById('image-preview').innerHTML = '';
        document.getElementById('input_last_name').value = '';

        $('#input_first_name').val('');
        $('#input_last_name').val('');

        $('#input_first_name').focus();
    }
</script>