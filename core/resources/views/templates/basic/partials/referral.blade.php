<div class="col-lg-12">
    <label>@lang('Referral Link')</label>
    <div class="input-group">
        <input type="text" value="{{ route('user.register', [auth()->user()->username]) }}" class="form-control value-to-copy" readonly>
        <span class="input-group-text" type="button" id="copyBoard"> <i class="fa fa-copy"></i> </span>
    </div>
</div>
