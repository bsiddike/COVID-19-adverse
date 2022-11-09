@php use Illuminate\Database\Eloquent\Model; @endphp
@php use App\Supports\Constant; @endphp
@if($model instanceof Model)
    <input type="checkbox" class="toggle-class" data-toggle="toggle" data-size="sm"
           data-onstyle="outline-success" data-offstyle="outline-danger" data-model="{{ get_class($model) }}"
           data-id="{{ $model->id }}" data-width="72" data-style="ios"
           data-on="<i class='fas fa-check'></i> {{ Constant::ENABLED_OPTIONS[Constant::ENABLED_OPTION] }}"
           data-off="<i class='fas fa-times'></i> {{ Constant::ENABLED_OPTIONS[Constant::DISABLED_OPTION] }}"
           data-onvalue="{{ Constant::ENABLED_OPTION }}"
           data-offvalue="{{ Constant::DISABLED_OPTION }}"
           @if($model->enabled == Constant::ENABLED_OPTION) checked @endif
    >
    {{--@else
        @php throw new \Exception('Input must be instance of Eloquent Model'); @endphp--}}
@endif
