@if(!empty($shortcodeData) && !empty($shortcodeData['image']))
    <div class="image-with-caption">
            <img
                class="image-with-caption__img"
                src="{{$shortcodeData['image']}}" alt=""/>
            @if(!empty($shortcodeData['caption']))
                <div class="image-with-caption__caption">
                    {{$shortcodeData['caption']}}
                </div>
            @endif
        </div>
    </div>
@endif
