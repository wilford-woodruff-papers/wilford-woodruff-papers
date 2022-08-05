<x-admin-layout>

    <div class="mt-4 max-w-7xl mx-auto">

        <div class="">

            @foreach($users as $user)

                <x-admin.supervisor.user-tasks :user="$user"></x-admin.supervisor.user-tasks>

            @endforeach

        </div>



    </div>

    @push('scripts')

    @endpush

</x-admin-layout>
