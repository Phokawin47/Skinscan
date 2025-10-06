<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo"><x-authentication-card-logo /></x-slot>

        <h1 class="text-xl font-semibold mb-4">Complete your profile</h1>

        <form method="POST" action="{{ route('onboarding.store') }}" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <x-label for="gender" value="Gender" />
                    <select id="gender" name="gender" required class="mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="" disabled selected>Select…</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                    <x-input-error for="gender" class="mt-1" />
                </div>

                <div>
                    <x-label for="age" value="Age" />
                    <x-input id="age" name="age" type="number" min="1" max="120" required class="block mt-1 w-full" />
                    <x-input-error for="age" class="mt-1" />
                </div>
            </div>

            <div>
                <x-label for="skin_type_id" value="Skin type" />
                <select id="skin_type_id" name="skin_type_id" required class="...">
                    <option value="" disabled selected>Select…</option>
                    @foreach($skinTypes as $st)
                    <option value="{{ $st->skin_type_id }}">{{ $st->name }}</option>
                    @endforeach
                </select>


                <x-input-error for="skin_type_id" class="mt-1" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <x-label value="Sensitive skin?" />
                    <label class="inline-flex items-center gap-2 mt-2">
                        <input type="radio" name="is_sensitive_skin" value="1"> <span>Yes</span>
                    </label>
                    <label class="inline-flex items-center gap-2 ms-6">
                        <input type="radio" name="is_sensitive_skin" value="0" checked> <span>No</span>
                    </label>
                    <x-input-error for="is_sensitive_skin" class="mt-1" />
                </div>

                <div>
                    <x-label for="allergies" value="Allergies (optional)" />
                    <x-input id="allergies" name="allergies" type="text" class="block mt-1 w-full" />
                    <x-input-error for="allergies" class="mt-1" />
                </div>
            </div>

            <x-button class="mt-4 w-full justify-center">Save & Continue</x-button>
        </form>
    </x-authentication-card>
</x-guest-layout>