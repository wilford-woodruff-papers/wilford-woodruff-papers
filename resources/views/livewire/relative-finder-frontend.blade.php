<div x-data="relationshipChecker">
    <div class="">
        <div class="py-8 mx-auto max-w-7xl">
            @if(session()->has('status'))
                <div class="py-6 px-8">
                    <div class="relative py-3 px-4 text-green-700 bg-green-100 rounded border border-green-400" role="alert">
                        <span class="">{{ session()->get('status') }}</span>
                    </div>
                </div>

            @endif
        </div>
        <livewire:wilford-woodruff-relationship lazy />
        <div class="py-8 mx-auto max-w-7xl relative-finder">
            {{ $this->table }}
        </div>
    </div>
    @push('scripts')
        <script>

            document.addEventListener('alpine:init', () => {
                Alpine.data('relationshipChecker', () => ({
                    people: @json($people),
                    init () {
                        this.processRelationships();
                    },
                    async processRelationships() {
                        const promises = this.people.map((person) => (
                            this.fetchAndRetryIfNecessary(() => (
                                window.rateLimiter.acquireToken(() => this.check(person))
                            ))
                        ));
                        //const responses = await Promise.all(promises);
                        // responses.forEach((response, index) => {
                        //     if (response.status === 200) {
                        //         let url = response.url;
                        //         console.log(url);
                        //         response.json().then((data) => {
                        //             Livewire.dispatch('new-relationship', { data: data, url: url });
                        //         });
                        //     }
                        // });
                    },
                    async check(person){
                        const response = await fetch('{{ config('services.familysearch.base_uri') }}/platform/tree/persons/CURRENT/relationships/'+person.pid, {
                            headers: {
                                'Accept': 'application/json',
                                'Authorization': 'Bearer {{ auth()->user()->familysearch_token }}'
                            }
                        });

                        return response;
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
