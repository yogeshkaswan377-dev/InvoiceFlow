{{-- resources/views/settings/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Settings')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">System Settings</h3>
                </div>
                <div class="card-body">
                    <!-- Tab Navigation -->
                    <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="basic-tab" data-toggle="tab" href="#basic" role="tab">
                                <i class="fas fa-building"></i> Basic Information
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="address-tab" data-toggle="tab" href="#address" role="tab">
                                <i class="fas fa-map-marker-alt"></i> Address Details
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="gst-tab" data-toggle="tab" href="#gst" role="tab">
                                <i class="fas fa-percent"></i> GST Settings
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="invoice-tab" data-toggle="tab" href="#invoice" role="tab">
                                <i class="fas fa-file-invoice"></i> Invoice Preferences
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="bank-tab" data-toggle="tab" href="#bank" role="tab">
                                <i class="fas fa-university"></i> Bank Details
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="branding-tab" data-toggle="tab" href="#branding" role="tab">
                                <i class="fas fa-paint-brush"></i> Branding
                            </a>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content mt-3" id="settingsTabsContent">
                        
                        <!-- Basic Information Tab -->
                        <div class="tab-pane fade show active" id="basic" role="tabpanel">
                            <form id="basicInfoForm" class="settings-form" data-section="basic">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Company Name <span class="text-danger">*</span></label>
                                            <input type="text" name="company_name" class="form-control" 
                                                   value="{{ $settings['company_name'] ?? '' }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>GSTIN</label>
                                            <input type="text" name="gstin" class="form-control" 
                                                   value="{{ $settings['gstin'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>PAN Number</label>
                                            <input type="text" name="pan" class="form-control" 
                                                   value="{{ $settings['pan'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>CIN Number</label>
                                            <input type="text" name="cin" class="form-control" 
                                                   value="{{ $settings['cin'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Phone Number</label>
                                            <input type="text" name="phone" class="form-control" 
                                                   value="{{ $settings['phone'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Website</label>
                                            <input type="url" name="website" class="form-control" 
                                                   value="{{ $settings['website'] ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save Basic Information
                                </button>
                                <div class="alert-message mt-2"></div>
                            </form>
                        </div>

                        <!-- Address Details Tab -->
                        <div class="tab-pane fade" id="address" role="tabpanel">
                            <form id="addressForm" class="settings-form" data-section="address">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Address Line 1</label>
                                            <input type="text" name="address_line1" class="form-control" 
                                                   value="{{ $settings['address_line1'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Address Line 2</label>
                                            <input type="text" name="address_line2" class="form-control" 
                                                   value="{{ $settings['address_line2'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>City</label>
                                            <input type="text" name="city" class="form-control" 
                                                   value="{{ $settings['city'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>State</label>
                                            <input type="text" name="state" class="form-control" 
                                                   value="{{ $settings['state'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Pincode</label>
                                            <input type="text" name="pincode" class="form-control" 
                                                   value="{{ $settings['pincode'] ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save Address Details
                                </button>
                                <div class="alert-message mt-2"></div>
                            </form>
                        </div>

                        <!-- GST Settings Tab -->
                        <div class="tab-pane fade" id="gst" role="tabpanel">
                            <form id="gstForm" class="settings-form" data-section="gst">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>GST Calculation Mode</label>
                                            <select name="gst_mode" class="form-control" id="gstMode">
                                                <option value="exclusive" {{ ($settings['gst_mode'] ?? '') == 'exclusive' ? 'selected' : '' }}>
                                                    Exclusive (GST added to price)
                                                </option>
                                                <option value="inclusive" {{ ($settings['gst_mode'] ?? '') == 'inclusive' ? 'selected' : '' }}>
                                                    Inclusive (GST included in price)
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-3">
                                    <h5>GST Rates</h5>
                                    <table class="table table-bordered" id="gstRatesTable">
                                        <thead>
                                            <tr>
                                                <th>Rate (%)</th>
                                                <th>CGST (%)</th>
                                                <th>SGST/UGST (%)</th>
                                                <th>IGST (%)</th>
                                                <th>Cess (%)</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="gstRatesBody">
                                            @foreach($settings['gst_rates'] ?? [] as $index => $rate)
                                            <tr>
                                                <td><input type="number" step="0.01" name="gst_rates[{{ $index }}][rate]" class="form-control" value="{{ $rate['rate'] }}"></td>
                                                <td><input type="number" step="0.01" name="gst_rates[{{ $index }}][cgst]" class="form-control" value="{{ $rate['cgst'] }}"></td>
                                                <td><input type="number" step="0.01" name="gst_rates[{{ $index }}][sgst]" class="form-control" value="{{ $rate['sgst'] }}"></td>
                                                <td><input type="number" step="0.01" name="gst_rates[{{ $index }}][igst]" class="form-control" value="{{ $rate['igst'] }}"></td>
                                                <td><input type="number" step="0.01" name="gst_rates[{{ $index }}][cess]" class="form-control" value="{{ $rate['cess'] }}"></td>
                                                <td><button type="button" class="btn btn-danger btn-sm remove-gst-row"><i class="fas fa-trash"></i></button></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <button type="button" class="btn btn-success btn-sm mb-3" id="addGstRow">
                                        <i class="fas fa-plus"></i> Add GST Rate
                                    </button>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save GST Settings
                                </button>
                                <div class="alert-message mt-2"></div>
                            </form>
                        </div>

                        <!-- Invoice Preferences Tab -->
                        <div class="tab-pane fade" id="invoice" role="tabpanel">
                            <form id="invoiceForm" class="settings-form" data-section="invoice">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Invoice Prefix</label>
                                            <input type="text" name="invoice_prefix" class="form-control" 
                                                   value="{{ $settings['invoice_prefix'] ?? 'INV-' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Invoice Starting Number</label>
                                            <input type="number" name="invoice_start_number" class="form-control" 
                                                   value="{{ $settings['invoice_start_number'] ?? 1001 }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Payment Terms (Days)</label>
                                            <input type="number" name="payment_terms" class="form-control" 
                                                   value="{{ $settings['payment_terms'] ?? 15 }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Due Date Reminder (Days before)</label>
                                            <input type="number" name="due_date_reminder" class="form-control" 
                                                   value="{{ $settings['due_date_reminder'] ?? 3 }}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Invoice Footer Notes</label>
                                            <textarea name="invoice_footer" class="form-control" rows="3">{{ $settings['invoice_footer'] ?? '' }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save Invoice Preferences
                                </button>
                                <div class="alert-message mt-2"></div>
                            </form>
                        </div>

                        <!-- Bank Details Tab -->
                        <div class="tab-pane fade" id="bank" role="tabpanel">
                            <form id="bankForm" class="settings-form" data-section="bank">
                                @csrf
                                <div id="bankAccountsContainer">
                                    @php $bankAccounts = $settings['bank_accounts'] ?? []; @endphp
                                    @foreach($bankAccounts as $index => $bank)
                                    <div class="bank-account-card card mb-3">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Bank Name</label>
                                                        <input type="text" name="bank_accounts[{{ $index }}][bank_name]" 
                                                               class="form-control" value="{{ $bank['bank_name'] }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Account Holder Name</label>
                                                        <input type="text" name="bank_accounts[{{ $index }}][account_holder]" 
                                                               class="form-control" value="{{ $bank['account_holder'] }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Account Number</label>
                                                        <input type="text" name="bank_accounts[{{ $index }}][account_number]" 
                                                               class="form-control" value="{{ $bank['account_number'] }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>IFSC Code</label>
                                                        <input type="text" name="bank_accounts[{{ $index }}][ifsc]" 
                                                               class="form-control" value="{{ $bank['ifsc'] }}" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-check">
                                                        <input type="checkbox" name="bank_accounts[{{ $index }}][is_default]" 
                                                               class="form-check-input set-default-bank" value="1" 
                                                               {{ ($bank['is_default'] ?? false) ? 'checked' : '' }}>
                                                        <label class="form-check-label">Set as Default Account</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-danger btn-sm remove-bank-account mt-2">
                                                <i class="fas fa-trash"></i> Remove Account
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                
                                <button type="button" class="btn btn-success mb-3" id="addBankAccount">
                                    <i class="fas fa-plus"></i> Add Bank Account
                                </button>
                                <br>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save Bank Details
                                </button>
                                <div class="alert-message mt-2"></div>
                            </form>
                        </div>

                        <!-- Branding Tab -->
                        <div class="tab-pane fade" id="branding" role="tabpanel">
                            <form id="brandingForm" class="settings-form" data-section="branding">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Company Logo</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="logoUpload" accept="image/*">
                                                <label class="custom-file-label" for="logoUpload">Choose file</label>
                                            </div>
                                            <div class="mt-3 text-center" id="logoPreviewContainer">
                                                @if(!empty($settings['logo']))
                                                    <img src="{{ asset('storage/' . $settings['logo']) }}" 
                                                         id="logoPreview" class="img-fluid mb-2" style="max-height: 150px;">
                                                    <button type="button" class="btn btn-danger btn-sm remove-media" data-type="logo">
                                                        Remove Logo
                                                    </button>
                                                @else
                                                    <img src="" id="logoPreview" class="img-fluid mb-2" style="max-height: 150px; display: none;">
                                                    <button type="button" class="btn btn-danger btn-sm remove-media" data-type="logo" style="display: none;">
                                                        Remove Logo
                                                    </button>
                                                    <p class="text-muted">No logo uploaded</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Signature</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="signatureUpload" accept="image/*">
                                                <label class="custom-file-label" for="signatureUpload">Choose file</label>
                                            </div>
                                            <div class="mt-3 text-center" id="signaturePreviewContainer">
                                                @if(!empty($settings['signature']))
                                                    <img src="{{ asset('storage/' . $settings['signature']) }}" 
                                                         id="signaturePreview" class="img-fluid mb-2" style="max-height: 100px;">
                                                    <button type="button" class="btn btn-danger btn-sm remove-media" data-type="signature">
                                                        Remove Signature
                                                    </button>
                                                @else
                                                    <img src="" id="signaturePreview" class="img-fluid mb-2" style="max-height: 100px; display: none;">
                                                    <button type="button" class="btn btn-danger btn-sm remove-media" data-type="signature" style="display: none;">
                                                        Remove Signature
                                                    </button>
                                                    <p class="text-muted">No signature uploaded</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="alert-message mt-2"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    
    // GST Dynamic Rows
    let gstRowIndex = {{ count($settings['gst_rates'] ?? []) }};
    
    $('#addGstRow').click(function() {
        let newRow = `
            <tr>
                <td><input type="number" step="0.01" name="gst_rates[${gstRowIndex}][rate]" class="form-control" placeholder="Rate"></td>
                <td><input type="number" step="0.01" name="gst_rates[${gstRowIndex}][cgst]" class="form-control" placeholder="CGST"></td>
                <td><input type="number" step="0.01" name="gst_rates[${gstRowIndex}][sgst]" class="form-control" placeholder="SGST"></td>
                <td><input type="number" step="0.01" name="gst_rates[${gstRowIndex}][igst]" class="form-control" placeholder="IGST"></td>
                <td><input type="number" step="0.01" name="gst_rates[${gstRowIndex}][cess]" class="form-control" placeholder="Cess"></td>
                <td><button type="button" class="btn btn-danger btn-sm remove-gst-row"><i class="fas fa-trash"></i></button></td>
            </tr>
        `;
        $('#gstRatesBody').append(newRow);
        gstRowIndex++;
    });
    
    $(document).on('click', '.remove-gst-row', function() {
        if($('#gstRatesBody tr').length > 1) {
            $(this).closest('tr').remove();
        } else {
            toastr.warning('At least one GST rate is required');
        }
    });
    
    // Bank Accounts Management
    let bankAccountIndex = {{ count($settings['bank_accounts'] ?? []) }};
    
    $('#addBankAccount').click(function() {
        let newAccount = `
            <div class="bank-account-card card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Bank Name</label>
                                <input type="text" name="bank_accounts[${bankAccountIndex}][bank_name]" 
                                       class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Account Holder Name</label>
                                <input type="text" name="bank_accounts[${bankAccountIndex}][account_holder]" 
                                       class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Account Number</label>
                                <input type="text" name="bank_accounts[${bankAccountIndex}][account_number]" 
                                       class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>IFSC Code</label>
                                <input type="text" name="bank_accounts[${bankAccountIndex}][ifsc]" 
                                       class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-check">
                                <input type="checkbox" name="bank_accounts[${bankAccountIndex}][is_default]" 
                                       class="form-check-input set-default-bank" value="1">
                                <label class="form-check-label">Set as Default Account</label>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger btn-sm remove-bank-account mt-2">
                        <i class="fas fa-trash"></i> Remove Account
                    </button>
                </div>
            </div>
        `;
        $('#bankAccountsContainer').append(newAccount);
        bankAccountIndex++;
    });
    
    $(document).on('click', '.remove-bank-account', function() {
        if($('.bank-account-card').length > 1) {
            $(this).closest('.bank-account-card').remove();
        } else {
            toastr.warning('At least one bank account is required');
        }
    });
    
    $(document).on('change', '.set-default-bank', function() {
        if($(this).is(':checked')) {
            $('.set-default-bank').not(this).prop('checked', false);
        }
    });
    
    // AJAX Form Submissions
    $('.settings-form').on('submit', function(e) {
        e.preventDefault();
        let form = $(this);
        let section = form.data('section');
        let formData = form.serialize();
        let submitBtn = form.find('button[type="submit"]');
        
        submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Saving...');
        
        $.ajax({
            url: '{{ route("settings.update") }}',
            type: 'POST',
            data: formData,
            success: function(response) {
                if(response.success) {
                    form.find('.alert-message').html('<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                        response.message + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                    setTimeout(() => {
                        form.find('.alert-message .alert').fadeOut();
                    }, 3000);
                }
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                let errorHtml = '<div class="alert alert-danger"><ul>';
                $.each(errors, function(key, value) {
                    errorHtml += '<li>' + value + '</li>';
                });
                errorHtml += '</ul></div>';
                form.find('.alert-message').html(errorHtml);
            },
            complete: function() {
                submitBtn.prop('disabled', false).html('<i class="fas fa-save"></i> Save ' + 
                    (section === 'basic' ? 'Basic Information' : 
                     section === 'address' ? 'Address Details' :
                     section === 'gst' ? 'GST Settings' :
                     section === 'invoice' ? 'Invoice Preferences' :
                     section === 'bank' ? 'Bank Details' : 'Settings'));
            }
        });
    });
    
    // Logo Upload AJAX
    $('#logoUpload').on('change', function(e) {
        let file = e.target.files[0];
        let formData = new FormData();
        formData.append('logo', file);
        formData.append('_token', '{{ csrf_token() }}');
        
        // Preview immediately
        let reader = new FileReader();
        reader.onload = function(e) {
            $('#logoPreview').attr('src', e.target.result).show();
            $('#logoPreviewContainer .remove-media[data-type="logo"]').show();
            $('#logoPreviewContainer p').hide();
        };
        reader.readAsDataURL(file);
        
        $.ajax({
            url: '{{ route("settings.upload.logo") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.success) {
                    toastr.success('Logo uploaded successfully');
                }
            },
            error: function() {
                toastr.error('Failed to upload logo');
            }
        });
    });
    
    // Signature Upload AJAX
    $('#signatureUpload').on('change', function(e) {
        let file = e.target.files[0];
        let formData = new FormData();
        formData.append('signature', file);
        formData.append('_token', '{{ csrf_token() }}');
        
        // Preview immediately
        let reader = new FileReader();
        reader.onload = function(e) {
            $('#signaturePreview').attr('src', e.target.result).show();
            $('#signaturePreviewContainer .remove-media[data-type="signature"]').show();
            $('#signaturePreviewContainer p').hide();
        };
        reader.readAsDataURL(file);
        
        $.ajax({
            url: '{{ route("settings.upload.signature") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.success) {
                    toastr.success('Signature uploaded successfully');
                }
            },
            error: function() {
                toastr.error('Failed to upload signature');
            }
        });
    });
    
    // Remove Logo/Signature
    $('.remove-media').on('click', function() {
        let type = $(this).data('type');
        let confirmMsg = type === 'logo' ? 'Are you sure you want to remove the logo?' : 'Are you sure you want to remove the signature?';
        
        if(confirm(confirmMsg)) {
            $.ajax({
                url: '{{ route("settings.remove.media") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    type: type
                },
                success: function(response) {
                    if(response.success) {
                        if(type === 'logo') {
                            $('#logoPreview').hide().attr('src', '');
                            $('#logoPreviewContainer .remove-media').hide();
                            $('#logoPreviewContainer p').show();
                        } else {
                            $('#signaturePreview').hide().attr('src', '');
                            $('#signaturePreviewContainer .remove-media').hide();
                            $('#signaturePreviewContainer p').show();
                        }
                        toastr.success(response.message);
                    }
                },
                error: function() {
                    toastr.error('Failed to remove ' + type);
                }
            });
        }
    });
    
    // Custom file input label update
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
});
</script>
@endpush

@push('styles')
<style>
.nav-tabs .nav-link {
    color: #495057;
    border: none;
    padding: 10px 15px;
}
.nav-tabs .nav-link.active {
    color: #007bff;
    border-bottom: 2px solid #007bff;
    background: transparent;
}
.settings-form {
    padding: 20px;
    background: #f8f9fa;
    border-radius: 5px;
}
.bank-account-card {
    border-left: 3px solid #007bff;
}
.alert-message .alert {
    margin-top: 10px;
    margin-bottom: 0;
}
</style>
@endpush
@endsection