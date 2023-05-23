<x-admin-layout>
    <div class="mx-auto mt-4 max-w-7xl">
        <div class="py-4">

            <h1 class="mb-2 text-2xl font-semibold">
                Quote Tagging Report
            </h1>

            <div class="relative my-12">

                <table>
                    <thead>
                        <tr class="py-3.5 text-base font-semibold text-center text-white bg-black">
                            <td class="py-1.5 px-3 text-left">Month</td>
                            <td class="py-1.5 px-6">Quotes</td>
                            <td class="py-1.5 px-6">Pages</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($quotes as $key => $quote)
                            <tr class="py-3.5 text-base font-semibold text-center text-black bg-white">
                                <td class="py-1.5 px-3 text-left">{{ $now->subMonth($key)->monthName }}</td>
                                <td class="py-1.5 px-3">{{ $quote }}</td>
                                <td class="py-1.5 px-3">{{ $pages[$key] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </div>
</x-admin-layout>
