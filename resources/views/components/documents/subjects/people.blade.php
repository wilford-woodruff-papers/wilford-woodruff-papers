<div>
    <div x-data="people">

    </div>
    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('people', () => ({
                    docId: {{ $docId }},
                    type: 'people',
                    people: [],

                    init() {

                    },

                    async load() {
                        const search = await this.index.search(this.q, {
                            hitsPerPage: 100000,
                            filter: this.buildFilter(),
                        });
                    },

                    buildFilter(){
                        this.filters = [];
                        this.filters.push(
                            '_geoBoundingBox(['+this.preventOutOfBounds(geo._northEast.lat)+', '+this.preventOutOfBounds(geo._northEast.lng)+'], ['+this.preventOutOfBounds(geo._southWest.lat)+', '+this.preventOutOfBounds(geo._southWest.lng)+'])'
                        );
                        return this.filters;
                    },
                }))
            })
        </script>
    @endpush
</div>
