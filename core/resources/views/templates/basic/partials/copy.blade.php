@push('style')
    <style>
        .copied::after {
            background-color: #{{ $general->base_color }};
        }
    </style>
@endpush

@push('script')
    <script>
        (function($){
            "use strict";
            $('#copyBoard').click(function(){
                var copyText = document.getElementsByClassName("value-to-copy");
                copyText = copyText[0];
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                /*For mobile devices*/
                document.execCommand("copy");
                copyText.blur();
                this.classList.add('copied');
                setTimeout(() => this.classList.remove('copied'), 1500);
            });
        })(jQuery);
    </script>
@endpush
