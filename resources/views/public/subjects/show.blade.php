<x-guest-layout>
    <div id="content" role="main">

        <div class="max-w-7xl mx-auto px-4">


            <div class="blocks">
                <div class="grid grid-cols-12 py-12">
                    <div class="content col-span-12 px-8 py-6">
                        <h2>{{ $subject->name }}</h2>
                        <p>
                            {!! $subject->bio !!}
                        </p>
                    </div>
                    <div class="col-span-12 md:col-span-12 px-8">
                        <!--<h3 class="text-primary text-3xl font-serif mt-4 mb-8 pt-7 border-b border-gray-300">Pages</h3>-->
                        <div class="preview-block">

                            <ul class="divide-y divide-gray-200">

                                @foreach($subject->pages as $page)

                                    <x-page-summary :page="$page" />

                                @endforeach

                            </ul>


                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-guest-layout>
