@extends('layouts.app')

@section('content')

<section>
  <form id="usermanagerform" action="{{ route('savecompinfo') }}" method="post" enctype="multipart/form-data">
    @csrf
    @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    <div class="container mt-5">
      <div class="row" style="font-size: 18px;">
        <div class="col-md-6">
          <h2>Add New Company</h2>
          <div class="dropdown-divider"></div>
          <input type="hidden" id="input_company_code" name="input_company_code" class="form-control"  value="">
          <div class="form-group">
            <label for="fullname">Company Name*</label>
            <input type="text" class="form-control @error('company_exists') is-invalid @enderror" id="input_company_name" name="input_company_name" 
             required oninvalid="this.setCustomValidity('Fill Company Name Field')" 
            oninput="this.setCustomValidity('')" autocomplete="off">
            @error('company_exists')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
          </div>

          <div class="form-group">
    <label for="input_company_name">Address*</label>
    <textarea class="form-control" id="input_company_address" name="input_company_address" 
        rows="4" cols="50" required oninvalid="this.setCustomValidity('Fill Address Field')" 
        oninput="this.setCustomValidity('')" autocomplete="off"></textarea>
</div>
<div class="form-group">
    <label for="input_company_website">Website</label>
    <input type="text" class="form-control @error('input_company_website') is-invalid @enderror" id="input_company_website" name="input_company_website"
    required oninvalid="validateURL(this)" oninput="setCustomValidity('')" autocomplete="off">
    @error('input_company_website')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
</div>
         

        </div>
        <div class="col-md-6 text-center" id="profilePicture" data-path="{{ public_path('company_logo') }}">
          <h2>Add Logo</h2>
          <div class="dropdown-divider"></div>
          <label class="btn btn-secondary btn-sm" style="font-size: 18px;">
            <i class="fas fa-upload"></i> Upload Picture
            <input type="file" id="company_logo" name="company_logo" style="display:none;" 
            accept="image/*" onchange="previewImage(this)" />
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

<script>
document.addEventListener('DOMContentLoaded', (event) => {
            const urlInput = document.getElementById('input_company_website');
            const defaultPrefix = "http://";
            urlInput.addEventListener('input', function() {
                if (!urlInput.value.startsWith('http://')) {
                    urlInput.value = defaultPrefix;
                }
            });
            //====for not deleting http
            urlInput.addEventListener('keydown', function(e) {
                if (urlInput.selectionStart < defaultPrefix.length && (e.key === "Backspace" || e.key === "Delete")) {
                    e.preventDefault();
                }
            });

            //=== set value to http if not empty
            if (!urlInput.value) {
                urlInput.value = defaultPrefix;
            }
        });
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
    var currentDate = new Date();

    // Format the date as "YYYY-MM-DD" (required by the date input)
    var formattedDate = currentDate.toISOString().split('T')[0];

    // Set the default date for the input
    $('#input_age').val(formattedDate);
    $('#input_fullname').focus();
  }
</script>