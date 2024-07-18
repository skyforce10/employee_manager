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
                    <div class="form-row">
    <div class="form-group col-md-7">
        <label for="input_first_name">
            First Name <span style="color: red;">(max: 40 characters)</span> *
        </label>
        <input type="text" class="form-control" id="input_first_name" name="input_first_name" required oninvalid="this.setCustomValidity('Fill First Name Field')" oninput="this.setCustomValidity('')" autocomplete="off" maxlength="40">
    </div>
    <div class="form-group col-md-5">
        <label for="input_last_name">
            Last Name *
        </label>
        <input type="text" class="form-control" id="input_last_name" name="input_last_name" required oninvalid="this.setCustomValidity('Fill Last Name Field')" oninput="this.setCustomValidity('')" autocomplete="off">
    </div>
</div>

                    <div class="form-group">
                        <label for="fullname">
                            Email *
                        </label>
                        <input type="email" class="form-control " id="input_email" name="input_email" required oninvalid="this.setCustomValidity('Fill Email Field')" oninput="this.setCustomValidity('')" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="fullname">
                            Date Of Birth
                        </label>
                        <input type="date" class="form-control " id="input_email" name="input_email" autocomplete="off">
                    </div>
                    <div class="dropdown-divider"></div>
                    <div class="custom-control custom-switch mb-3">
                        <input type="checkbox" class="custom-control-input" id="input_social_status" 
                        name="input_social_status">
                        <label class="custom-control-label" for="input_social_status">Married</label>
                    </div>
                    <div class="form-group">
                        <label for="nbkids">
                            Number Of Kids
                        </label>
                        <input type="text" class="form-control " id="input_nbkids" name="input_lnbkids" autocomplete="off" disabled>
                    </div>
                    <div class="form-group">
                    <label for="example">Company</label>
        <select class="form-control select2" id="example" style="width: 100%;">
            @if($companies)
            @foreach ($companies as $company)
            <option value="{{ $company->id }}">{{$company->name}}</option>
            @endforeach
            @endif
        </select>
        </div>
        <div class="container_rounds mt-4">
                        <table id="phone_table" class="table table-borderless table-sm">
                            <thead>
                                <tr class="text-center" style="font-weight: bold;">
                                <td style="display:none;"></td>
                                    <th style="font-weight: bold;">Phone</th>
                                    <th style="font-weight: bold;">Number</th>
                                    <td class="p-2">
                                        <button type="button" class="btn btn-primary btn-sm m-1" id="add_phone_row">
                                            <i class="fas fa-add"></i></button>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                            <tr class="text-center" style="font-weight: bold;">
   <td style="display:none;"><input type="hidden" name="input_rounds_number[]"  value="1" /></th>
   <td>
      <div class="form-group">
      <select class="form-select form-control" aria-label="Default select example">
  <option selected>Select Phone Type</option>
  <option value="1" selected>Phone</option>
  <option value="2">Mobile</option>
  <option value="3">Fax</option>
  <option value="4">Work</option>
  <option value="5">Other</option>
</select>
      </div>
   </td>
   <td>
   <div class="input-group"> 
   <input type="text" class="form-control" placeholder="Ex: 00961 71771420">
   </div>
   </td>
   <td class="p-2">
   <button type="button" class="btn btn-danger btn-sm clear-btn m-1 removeRowBtn" >
   <i class="fas fa-trash"></i></button>
   </td>
</tr>
                            </tbody>
                        </table>
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

        $('#input_first_name').val('');
        $('#input_last_name').val('');

        $('#input_first_name').focus();
    }
    //=============================
    $(document).ready(function() {
    $('#input_social_status').on('change', function() {
    $('#input_lnbkids').prop('disabled', !this.checked);
     });
 //=========add phone row
     $('#add_phone_row').click(function() {
            var rowCount = $('#phone_table tbody tr').length + 1;
            var newRow = `
<tr class="text-center" style="font-weight: bold;">
    <td style="display:none;"><input type="hidden" name="input_rounds_number[]" value="1" /></td>
    <td>
        <div class="form-group">
           <select class="form-select form-control" aria-label="Default select example">
  <option selected>Select Phone Type</option>
  <option value="1" selected>Phone</option>
  <option value="2">Mobile</option>
  <option value="3">Fax</option>
  <option value="4">Work</option>
  <option value="5">Other</option>
</select>
        </div>
    </td>
    <td>
        <div class="input-group"> 
            <input type="text" class="form-control" placeholder="Ex: 00961 71771420">
        </div>
    </td>
    <td class="p-2">
        <button type="button" class="btn btn-danger btn-sm clear-btn m-1 removeRowBtn">
            <i class="fas fa-trash"></i>
        </button>
    </td>
</tr>
`;
                
                $('#phone_table tbody').append(newRow);
            
        });

        $('#phone_table').on('click', '.removeRowBtn', function() {
       var rowIndex = $(this).closest('tr').index();
       $(this).closest('tr').remove();
       
   });
    });
   
    
</script>