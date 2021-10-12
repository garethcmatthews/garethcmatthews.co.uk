<div class="col-md-7 col-lg-8 mx-auto">
    @if ($message)
        <div class="alert alert-primary py-2 text-center">{!! $message !!}</div>
    @endif
    <form method="POST" action="{{ route('contact.store') }}" name="contact">
        {{ csrf_field() }}
        <div class="row g-3">
            <div class="col-sm-12">
                <label for="fullname" class="form-label">Full Name:</label>
                <input type="text" name="fullname" value="{{ old('fullname') }}" placeholder="Enter your fullname" maxLength="64" class="form-control" />
                @if ($errors->has('fullname'))
                    <span class="text-danger">{{ $errors->first('fullname') }}</span>
                @endif
            </div>
            <div class="col-sm-12">
                <label for="company" class="form-label">Company Name:</label>
                <input type="text" name="company" value="{{ old('company') }}" maxLength="128" class="form-control" />
            </div>
            <div class="col-12">
                <label for="email" class="form-label">Email:</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" maxLength="255" class="form-control" />
                @if ($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
            </div>
            <div class="col-12">
                <label for="reason" class="form-label">Reason for enquiry:</label>
                <input type="reason" name="reason" value="{{ old('reason') }}" placeholder="Enter details" maxLength="255" class="form-control" />
                @if ($errors->has('reason'))
                    <span class="text-danger">{{ $errors->first('reason') }}</span>
                @endif
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Message:</label>
                @if ($errors->has('message'))
                    <span class="text-danger">{{ $errors->first('message') }}</span>
                @endif
                <textarea name="message" rows="8" maxlength="2048" class="form-control">{{ old('message') }}</textarea>
            </div>
            <button class="btn btn-primary btn-md col-4 ms-auto" type="submit">Send</button>
    </form>
</div>
