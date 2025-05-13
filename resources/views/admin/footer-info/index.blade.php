@extends('admin.layouts.app')

@section('title', 'Footer Info')

@section('content')
    <div class="header">
        <h1><i class="fa fa-info-circle"></i> Footer Information Settings</h1>
        <p class="text-muted">Manage information displayed in the website footer</p>
    </div>

    <div class="content-section">
        @if(session('success'))
            <div class="alert alert-success" style="background: #d4edda; padding: 15px; margin-bottom: 20px; border-radius: 5px;">
                <i class="fa fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.footer-info.update', $footer->id ?? 1) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5><i class="fa fa-building"></i> About Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label><i class="fa fa-align-left"></i> About Text</label>
                                <textarea name="about" rows="3" class="form-control">{{ old('about', $footer->about) }}</textarea>
                                <small class="text-muted">Short description about your restaurant</small>
                            </div>

                            <div class="form-group">
                                <label><i class="fa fa-clock-o"></i> Working Hours</label>
                                <textarea name="working_hours" rows="3" class="form-control">{{ old('working_hours', $footer->working_hours) }}</textarea>
                                <small class="text-muted">Enter each day/time on a new line</small>
                            </div>

                            <div class="form-group">
                                <label><i class="fa fa-copyright"></i> Copyright Text</label>
                                <input type="text" name="copyright" class="form-control" value="{{ old('copyright', $footer->copyright) }}">
                                <small class="text-muted">Copyright message shown at the bottom</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5><i class="fa fa-address-book"></i> Contact Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label><i class="fa fa-map-marker"></i> Address</label>
                                <input type="text" name="address" class="form-control" value="{{ old('address', $footer->address) }}">
                            </div>

                            <div class="form-group">
                                <label><i class="fa fa-phone"></i> Phone</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $footer->phone) }}">
                            </div>

                            <div class="form-group">
                                <label><i class="fa fa-envelope"></i> Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $footer->email) }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5><i class="fa fa-share-alt"></i> Social Media Links</h5>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label><i class="fa fa-facebook"></i> Facebook</label>
                                <input type="url" name="facebook" class="form-control" value="{{ old('facebook', $footer->facebook) }}">
                                <small class="text-muted">Full URL to your Facebook page</small>
                            </div>

                            <div class="form-group">
                                <label><i class="fa fa-instagram"></i> Instagram</label>
                                <input type="url" name="instagram" class="form-control" value="{{ old('instagram', $footer->instagram) }}">
                                <small class="text-muted">Full URL to your Instagram profile</small>
                            </div>

                            <div class="form-group">
                                <label><i class="fa fa-whatsapp"></i> WhatsApp</label>
                                <input type="url" name="whatsapp" class="form-control" value="{{ old('whatsapp', $footer->whatsapp) }}">
                                <small class="text-muted">WhatsApp link (e.g. https://wa.me/962XXXXXXXX)</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions text-center mt-4">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fa fa-save"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
@endsection