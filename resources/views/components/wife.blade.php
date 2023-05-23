

            <div class="flex-1 min-w-0">
                <div>
                    <div class="text-sm" x-on:mouseenter="flyoutOpen = 'wife_{{ $wife->id }}'" x-on:mouseleave="flyoutOpen = null"><a class="text-3xl font-medium text-primary" target="person" href="/subjects/{{ $wife->person?->slug }}">{{ $wife->name }}</a>

                        <div class="absolute left-12 z-10 px-2 mt-3 w-screen max-w-md sm:px-0" x-description="" x-show="flyoutOpen == 'wife_{{ $wife->id }}'" x-transition:enter="transition ease-out duration-200" x-transition:enter-end="opacity-100 translate-y-0" x-transition:enter-start="opacity-0 translate-y-1" x-transition:leave="transition ease-in duration-150" x-transition:leave-end="opacity-0 translate-y-1" x-transition:leave-start="opacity-100 translate-y-0"
                        x-cloak
                        >
                            <div class="overflow-hidden ring-1 ring-black ring-opacity-5 shadow-lg">
                                <div class="grid relative gap-2 py-6 px-5 bg-white sm:gap-2 sm:p-8"><a class="text-2xl font-medium border-b border-gray-200 text-primary" target="person" href="/subjects/{{ $wife->person?->slug }}">{{ $wife->name }}</a>

                                    <div class="grid relative grid-cols-7">
                                        <div class="col-span-2 pr-2 text-right text-gray-400">Birth</div>

                                        <div class="col-span-5 text-left">
                                            <p>{{ $wife->birthdate }}</p>

                                            <p>{{ $wife->birthplace }}</p>
                                        </div>
                                    </div>

                                    <div class="grid relative grid-cols-7">
                                        <div class="col-span-2 pr-2 text-right text-gray-400">Death</div>

                                        <div class="col-span-5 text-left">
                                            <p>{{ $wife->deathdate }}</p>

                                            <p>{{ $wife->deathplace }}</p>
                                        </div>
                                    </div>

                                    <div class="grid relative grid-cols-7">
                                        <div class="col-span-2 pr-2 text-right text-gray-400">Parents</div>

                                        <div class="col-span-5 text-left"><span>{{ $wife->father }}</span> and <span>{{ $wife->mother }}</span></div>
                                    </div>

                                    <div class="grid relative grid-cols-7">
                                        <div class="col-span-2 pr-2 text-right text-gray-400">Relationship</div>

                                        <div class="col-span-5 text-left">
                                            <p>{{ $wife->relationship }}</p>
                                        </div>
                                    </div>

                                    <div class="grid relative grid-cols-7">
                                        <div class="col-span-2 pr-2 text-right text-gray-400">
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
                                        <div class="grid relative grid-cols-7">
                                            <div class="col-span-2 pr-2 text-right text-gray-400">Prior Marriage</div>

                                            <div class="col-span-5 text-left">
                                                <p>{{ $wife->prior_marriage }}</p>
                                            </div>
                                        </div>
                                    @endif
                                    @if(! empty($wife->divorce) )
                                        <div class="grid relative grid-cols-7">
                                            <div class="col-span-2 pr-2 text-right text-gray-400">Divorced</div>

                                            <div class="col-span-5 text-left">
                                                <p>{{ $wife->divorce }}</p>
                                            </div>
                                        </div>
                                    @endif

                                    @if(! empty($wife->subsequent_marriage) )
                                        <div class="grid relative grid-cols-7">
                                            <div class="col-span-2 pr-2 text-right text-gray-400">Subsequent Marriage</div>

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
