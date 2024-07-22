@extends('layouts.app')

@section('content')

<section>
    <form id="employeemanager" action="{{ route('saveemployee') }}" method="post" enctype="multipart/form-data">
        @csrf
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        <div class="container mt-5">
            <div class="row" style="font-size: 18px;">
                <div class="col-md-6">
                    <h2>Add New Employee</h2>
                    <div class="dropdown-divider"></div>
                    <input type="hidden" id="input_employee_code" name="input_employee_code" class="form-control" value="">
                    <div class="form-row">
                        <div class="form-group col-md-7">
                            <label for="input_first_name">
                                First Name <span style="color: red;">(max: 40 characters)</span> *
                            </label>
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="input_first_name" name="input_first_name" required oninvalid="this.setCustomValidity('Fill First Name Field')" oninput="this.setCustomValidity('')" autocomplete="off" maxlength="40">
                            @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                        <input type="email" class="form-control @error('email_exists') is-invalid @enderror" id="input_email" name="input_email" required oninvalid="this.setCustomValidity('Fill Email Field')" oninput="this.setCustomValidity('')" autocomplete="off">
                        @error('email_exists')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="fullname">
                            Date Of Birth
                        </label>
                        <input type="date" class="form-control " id="input_bd" name="input_bd" autocomplete="off">
                    </div>
                    <div class="dropdown-divider"></div>
                    <div class="custom-control custom-switch mb-3">
                        <input type="checkbox" class="custom-control-input" id="input_social_status" name="input_social_status">
                        <label class="custom-control-label" for="input_social_status">Married</label>
                    </div>
                    <div class="form-group">
                        <label for="nbkids">
                            Number Of Kids
                        </label>
                        <input type="number" class="form-control " id="input_nbkids" name="input_nbkids" autocomplete="off" disabled>
                    </div>
                    <div class="form-group">
                        <label for="emp_comp">Company</label>
                        <select class="form-control select2" id="emp_comp" name="emp_comp" style="width: 100%;">
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

                                    <td>
                                        <div class="form-group">
                                            <select class="form-select form-control" name="phone_type[]">
                                                <option selected>Select Phone Type</option>
                                                <option value="Phone" selected>Phone</option>
                                                <option value="Mobile">Mobile</option>
                                                <option value="Fax">Fax</option>
                                                <option value="Work">Work</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <input type="text" class="form-control @error('phone_numbers') is-invalid @enderror" name="phone_numbers[]" placeholder="Ex: 00961 71771420">
                                        </div>
                                    </td>
                                    <td class="p-2">
                                        <button type="button" class="btn btn-danger btn-sm clear-btn m-1 removeRowBtn">
                                            <i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        @error('phone_numbers')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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
        $('#input_social_status').change(function() {
            $('#input_nbkids').prop('disabled', !this.checked);
        });

        //=========add phone row
        $('#add_phone_row').click(function() {

            var newRow = `
<tr class="text-center" style="font-weight: bold;">
   
    <td>
        <div class="form-group">
           <select class="form-select form-control" name="phone_type[]">
  <option selected>Select Phone Type</option>
 <option value="Phone" selected>Phone</option>
<option value="Mobile">Mobile</option>
<option value="Fax">Fax</option>
<option value="Work">Work</option>
 <option value="Other">Other</option>
</select>
        </div>
    </td>
    <td>
        <div class="input-group"> 
            <input type="text" class="form-control" name="phone_numbers[]" placeholder="Ex: 00961 71771420">
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
@if (isset($employee))
<script>
    $(document).ready(function() {
        $("#input_employee_code").val('{{$employee->id}}');
        $("#input_first_name").val('{{$employee->first_name}}');
        $("#input_last_name").val('{{$employee->last_name}}');
        $("#input_email").val('{{$employee->email}}');
        $('#emp_comp').val('{{$employee->company_id}}').trigger('change');
        var maried_var="{{$employee->married}}";
        if(maried_var==1){
           $('#input_social_status').prop('checked', true);
           $('#input_nbkids').prop('disabled', false);
        }else{
            $('#input_social_status').prop('checked', false);  
            $('#input_nbkids').prop('disabled', true);
        }
        $('#input_nbkids').val('{{$employee->number_of_kids}}');

        
        var imagePathvar = '{{$employee->profile_picture}}';
        var preview = document.getElementById('image-preview');
        preview.innerHTML = '';
        var img = document.createElement('img');
        img.src = "/storage/" + imagePathvar;
        img.className = 'img-fluid';
        img.style.maxWidth = '200px'; // Set the maximum width to 100px
        preview.appendChild(img);

        $('#phone_table tbody').empty();
    });
    
</script>
@if(isset($phone_numbers))
@foreach($phone_numbers as $index => $phone_number)
<script>
    $(document).ready(function() {
    var newRow = `
<tr class="text-center" style="font-weight: bold;">
    
    <td>
        <div class="form-group">
           <select class="form-select form-control" name="phone_type[]">
  <option selected>Select Phone Type</option>
 <option value="Phone" {{ $index == 'Phone' ? 'selected' : '' }}>Phone</option>
 <option value="Mobile" {{ $index == 'Mobile' ? 'selected' : '' }}>Mobile</option>
  <option value="Fax" {{ $index == 'Fax' ? 'selected' : '' }}>Fax</option>
   <option value="Work" {{ $index == 'Work' ? 'selected' : '' }}>Work</option>
   <option value="Other" {{ $index == 'Other' ? 'selected' : '' }}>Other</option>
</select>
        </div>
    </td>
    <td>
        <div class="input-group"> 
            <input type="text" class="form-control" name="phone_numbers[]" placeholder="Ex: 00961 71771420" value="{{$phone_number}}">
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
</script>
@endforeach
@endif
@endif