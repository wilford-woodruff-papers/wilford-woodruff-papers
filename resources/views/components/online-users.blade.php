<div>
    <div x-data="{
        users: {},
    }"
         x-init="
            window.Echo.join('application')
                .here((members) => {
                    console.log(members);
                    for(member of members) {
                        users[member.email] = member;
                    }
                })
                .joining((member) => {
                    users[member.email] = member;
                })
                .leaving((member) => {
                    delete users[member.email];
                });
         "
    >
        <div class="">
            @hasanyrole('Admin|Super Admin')
                <ul class="flex gap-x-4 items-center"
                    x-cloak
                >
                    <div class="text-sm font-semibold">
                        Online now:
                    </div>
                    <template x-for="[id, user] in Object.entries(users)" :key="id">
                        <li class="flex gap-x-4 items-center">
                            <div class="py-1 px-2 text-sm text-black bg-gray-100">
                                <div x-text="user.name">

                                </div>
                            </div>
                        </li>
                    </template>
                </ul>
            @endhasanyrole
        </div>

    </div>
</div>
