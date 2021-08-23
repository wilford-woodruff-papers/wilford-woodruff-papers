

            <div class="min-w-0 flex-1">
                <div>
                    <div class="text-sm" x-on:mouseenter="flyoutOpen = 'wife_{{ $wife->id }}'" x-on:mouseleave="flyoutOpen = null"><a class="text-3xl text-primary font-medium" target="person" href="/subject/{{ $wife->person->slug }}">{{ $wife->person->name }}</a>

                        <div class="absolute z-10 left-12 mt-3 px-2 w-screen max-w-md sm:px-0" x-description="" x-show="flyoutOpen == 'wife_{{ $wife->id }}'" x-transition:enter="transition ease-out duration-200" x-transition:enter-end="opacity-100 translate-y-0" x-transition:enter-start="opacity-0 translate-y-1" x-transition:leave="transition ease-in duration-150" x-transition:leave-end="opacity-0 translate-y-1" x-transition:leave-start="opacity-100 translate-y-0"
                        x-cloak
                        >
                            <div class="shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden">
                                <div class="relative grid gap-2 bg-white px-5 py-6 sm:gap-2 sm:p-8"><a class="text-2xl text-primary font-medium border-b border-gray-200" target="person" href="/subject/{{ $wife->person->slug }}">{{ $wife->person->name }}</a>

                                    <div class="relative grid grid-cols-7">
                                        <div class="col-span-2 text-right text-gray-400 pr-2">Birth</div>

                                        <div class="col-span-5 text-left">
                                            <p>{{ $wife->birthdate }}</p>

                                            <p>{{ $wife->birthplace }}</p>
                                        </div>
                                    </div>

                                    <div class="relative grid grid-cols-7">
                                        <div class="col-span-2 text-right text-gray-400 pr-2">Death</div>

                                        <div class="col-span-5 text-left">
                                            <p>{{ $wife->deathdate }}</p>

                                            <p>{{ $wife->deathplace }}</p>
                                        </div>
                                    </div>

                                    <div class="relative grid grid-cols-7">
                                        <div class="col-span-2 text-right text-gray-400 pr-2">Parents</div>

                                        <div class="col-span-5 text-left"><span>{{ $wife->father }}</span> and <span>{{ $wife->mother }}</span></div>
                                    </div>

                                    <div class="relative grid grid-cols-7">
                                        <div class="col-span-2 text-right text-gray-400 pr-2">Relationship</div>

                                        <div class="col-span-5 text-left">
                                            <p>{{ $wife->relationship }}</p>
                                        </div>
                                    </div>

                                    <div class="relative grid grid-cols-7">
                                        <div class="col-span-2 text-right text-gray-400 pr-2">
                                            @if(! empty($wife->marriage) )
                                                <span>Marriage</span>
                                            @endif
                                            @if(! empty($wife->marriage ) && ! empty($wife->sealing) )
                                                <span>/</span>
                                            @endif
                                            @if(! empty($wife->sealing) )
                                                <span>Sealing</span>
                                            @endif
                                        </div>
                                        <div class="col-span-5 text-left">
                                            @if(! empty($wife->marriage) )
                                                <p>{{ $wife->marriage }}</p>
                                            @endif
                                            @if(! empty($wife->sealing) )
                                                <p>{{ $wife->sealing }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    @if(! empty($wife->prior_marriage) )
                                        <div class="relative grid grid-cols-7">
                                            <div class="col-span-2 text-right text-gray-400 pr-2">Prior Marriage</div>

                                            <div class="col-span-5 text-left">
                                                <p>{{ $wife->prior_marriage }}</p>
                                            </div>
                                        </div>
                                    @endif
                                    @if(! empty($wife->divorce) )
                                        <div class="relative grid grid-cols-7">
                                            <div class="col-span-2 text-right text-gray-400 pr-2">Divorced</div>

                                            <div class="col-span-5 text-left">
                                                <p>{{ $wife->divorce }}</p>
                                            </div>
                                        </div>
                                    @endif

                                    @if(! empty($wife->subsequent_marriage) )
                                        <div class="relative grid grid-cols-7">
                                            <div class="col-span-2 text-right text-gray-400 pr-2">Subsequent Marriage</div>

                                            <div class="col-span-5 text-left">
                                                <p>{{ $wife->subsequent_marriage }}</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <p class="mt-0.5 text-sm text-gray-500"><span>{{ $wife->birthdate }}</span> - <span>{{ $wife->deathdate }}</span></p>
                </div>

                <div class="mt-2 text-sm text-gray-700">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                        @foreach($wife->children as $child)
                            <x-child :child="$child" />
                        @endforeach
                    </div>
                </div>
            </div>
