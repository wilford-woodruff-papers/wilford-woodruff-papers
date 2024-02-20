<div x-data="relationshipChecker"
     @api.window="function(data){
        poolCalls(data);
     }"
>
    <x-banner-image :image="asset('img/banners/people.png')"
                    :text="'My Relatives'"
    />
    <div class="">
        <div class="py-4 mx-auto max-w-7xl">
            @if(session()->has('status'))
                <div class="py-6 px-8">
                    <div class="relative py-3 px-4 text-green-700 bg-green-100 rounded border border-green-400" role="alert">
                        <span class="">{{ session()->get('status') }}</span>
                    </div>
                </div>

            @endif
        </div>
        <livewire:wilford-woodruff-relationship />
        <div class="py-8 mx-auto max-w-7xl relative-finder">
            {{ $this->table }}
        </div>
    </div>
    @push('scripts')
        <script>

            document.addEventListener('alpine:init', () => {
                Alpine.data('relationshipChecker', () => ({
                    people: @entangle('people'),
                    results: [],
                    init () {
                        this.processRelationships();
                        this.$watch('people', value => this.processRelationships());
                        this.$watch('results', (value) => {
                            let clone = [...value];
                            //console.log(value.length);
                            if(clone.length >= this.people.length){
                                this.results = [];
                                //console.log(clone);
                                Livewire.dispatch('new-relationships', {data: clone});

                            }
                        });
                    },
                    poolCalls(data){
                        this.results.push({
                            id: data.detail.url,
                            data: data.detail.data
                        });
                    },
                    async processRelationships() {
                        for(i = 0; i < this.people.length; i++){
                            await new Promise((resolve) => setTimeout(resolve, 20));
                            await this.check(this.people[i]);
                        }
                        Livewire.dispatch('update-queue');
                    },
                    async check(person){
                        let alpine = this;
                        //console.log(person);
                        await fetch('{{ config('services.familysearch.base_uri') }}/platform/tree/persons/CURRENT/relationships/'+person.pid, {
                            headers: {
                                'Accept': 'application/json',
                                'Authorization': 'Bearer {{ auth()->user()->familysearch_token }}'
                            }
                        })
                            .then(async function(response){
                                if (response.status == 429) {
                                    await new Promise((resolve) => setTimeout(resolve, response.headers.get('Retry-After')*1000));
                                    await alpine.check(person);
                                } else if(response.status == 401 || response.status == 403){
                                    window.location.href = '{{ route('login.familysearch') }}';
                                }else if(response.status == 502){
                                    let json = { persons: [] };
                                    alpine.$dispatch('api', { data: json, url: person.id });
                                }else if(response.status == 204){
                                    let json = { persons: [] };
                                    alpine.$dispatch('api', { data: json, url: person.id });
                                    //Livewire.dispatch('new-relationship', { data: json, url: person.pid });
                                } else {
                                    let json = await response.json();
                                    alpine.$dispatch('api', { data: json, url: person.id });
                                    //Livewire.dispatch('new-relationship', { data: json, url: person.pid });
                                }
                            });
                    },
                    async fetchAndRetryIfNecessary (callAPIFn) {
                        const response = await callAPIFn();

                        if (response.status == 429) {
                            const retryAfter = response.headers.get('Retry-After')
                            await new Promise((resolve) => setTimeout(resolve, retryAfter*3000))
                            return this.fetchAndRetryIfNecessary(callAPIFn)
                        } else {
                            let url = response.url;

                            let json = { persons: [] };

                            if(response.status == 204){
                                json = { persons: [] };
                            } else {
                                json = await response.json();
                            }

                            Livewire.dispatch('new-relationship', { data: json, url: url });

                            return json;

                        }

                        //return response;
                    }
                }))
            })
        </script>
    @endpush
</div>
