<div>
    @if(! empty($description))
        <div class="mx-auto max-w-xl border border-gray-300 shadow-lg">
            <a href="https://www.familysearch.org/tree/person/details/KWNT-8NB"
               class="flex justify-between p-4"
               target="_blank">
                <div class="">
                    <div class="w-24 h-24 bg-top bg-cover aspect-w-3 aspect-h-2"
                         style="background-image: url('https://wilford-woodruff-papers.nyc3.digitaloceanspaces.com/media-library/225/conversions/CHL-PH-946b1fd3it006-WW-1888-by-CR-Savage-web.jpg')">
                    </div>
                </div>
                <div class="flex flex-col justify-between">
                    <div>
                        <div class="text-right">
                            Your relation to Wilford Woodruff:
                        </div>
                        <div class="text-lg font-semibold">
                            {{ $description }}
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <span class="inline-block px-2 pt-1 pb-2 text-sm bg-white rounded-md border border-gray-200">
                            <img src="https://wilford-woodruff-papers.test/img/familytree-logo.png"
                                 alt="FamilySearch"
                                 class="w-auto h-6"/>
                        </span>
                    </div>
                </div>
            </a>
        </div>
    @else
        <!-- No relation to Wilford Woodruff -->
    @endif
</div>
