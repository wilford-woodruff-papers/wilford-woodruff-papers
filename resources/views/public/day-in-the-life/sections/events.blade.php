@if(! empty($section['items']) && $section['items']->count() > 0)
    <div class="">
        <div class="relative">
            <div id="{{ str($section['name'])->slug() }}" class="absolute -top-32"></div>
            <h2 class="my-8 text-2xl font-semibold uppercase">
                {{ $section['name'] }}
            </h2>
        </div>
        <div class="">
            @foreach($section['items'] as $event)
                <article class="grid grid-cols-1 lg:grid-cols-2 py-4 gap-8 min-h-[250px] @if($loop->first)  @else -mt-32 @endif">
                    <div class="col-span-1 @if($loop->odd) order-0 @else order-1 @endif">
                        <div class="relative flex flex-col min-h-[250px] @if($loop->odd) text-left @else text-right @endif">
                            <div class="flex @if($loop->odd) justify-start @else justify-end @endif">
                                <img src="{{ $event->thumbnail_url }}"
                                     alt=""
                                     class="w-full sm:w-1/2 lg:w-1/3 h-auto  @if($loop->odd) order-0 @else order-1 @endif" />
                                {{--<div class="text-lg font-semibold flex-1 @if($loop->odd) order-1 text-right @else order-0 text-left @endif">
                                    {{ $event->start_at->toFormattedDateString() }}
                                </div>--}}
                            </div>
                            <div class="absolute z-10 bottom-4 text-xl bg-white shadow-xl px-3 py-1 @if($loop->odd) left-16 md:left-32 @else right-16 md:right-32 @endif">
                                <div class="text-lg font-semibold">
                                    <a href="{{ route('day-in-the-life', ['date' => $event->start_at?->toDateString()]) }}"
                                       class="text-secondary"
                                    >
                                        {{ $event->display_date }}
                                    </a>
                                </div>
                                <div class="pt-2 text-gray-900">
                                    {!!
                                        str($event->text)
                                            ->addScriptureLinks()
                                            ->addSubjectLinks()
                                    !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div></div>
                </article>
            @endforeach
        </div>
    </div>
@endif
