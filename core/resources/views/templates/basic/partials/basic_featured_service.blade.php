<li class="small-single-item">
    <div class="thumb">
        <img src="{{ getImage(getFilePath('service').'/'.$fService->image, getFileSize('service')) }}" alt="@lang('service image')">
    </div>
    <div class="content">
        <h5 class="title">
            <a href="{{route('service.details', [slug($fService->name), $fService->id])}}">{{__($fService->name)}}</a>
        </h5>
        <div class="ratings">
            @php echo starRating($fService->total_review, $fService->total_rating) @endphp
            <span class="rating">({{$fService->total_review}})</span>
            <p class="author-like d-inline-flex flex-wrap align-items-center ms-2"><span class="las la-thumbs-up text--base"></span> ({{__($fService->likes)}})</p>
        </div>
    </div>
</li>
