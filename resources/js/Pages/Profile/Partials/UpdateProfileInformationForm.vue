<script setup>
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import TextInput from '@/Components/TextInput.vue';
    import { Link, useForm, usePage } from '@inertiajs/vue3';
    import { ref } from "vue"
    import Button from 'primevue/button';


    defineProps({
        mustVerifyEmail: {
            type: Boolean,
        },
        status: {
            type: String,
        },
    });

    const user = usePage().props.auth.user;

    const form = useForm({
        name: user.name,
        email: user.email,
        profile_img: user.profile_img
    });


    // Profile Picture
    const previewProfilePhoto = ref(null);
    const profilePictureInputRef = ref();
    function handleProfileInput(event) {
        const target = event.target;
        const file = target.files;

        previewProfilePhoto.value = URL.createObjectURL(file[0]);
        form.profile_img = file[0];
    }
</script>

<template>
    <section>
        <header class="mb-3">
            <h2 class="text-lg font-medium text-gray-900">Profile Information</h2>

            <p class="mt-1 text-sm text-gray-600">
                Update your account's profile information and email address.
            </p>
        </header>

        <form @submit.prevent="form.patch(route('profile.update'))" class="flex flex-col space-y-3">
            <div class="flex flex-col">
                <div class="w-full h-full" v-if="form.profile_img">
                    <img :src="form.profile_img" alt="">
                </div>
                <div class="" v-else>
                    No Profile Image
                </div>
                <Button class="!w-full " icon="pi pi-pencil" outlined @click="() => profilePictureInputRef.click()" />
                <input type="file" accept="image/jpeg,image/png" class="hidden" id="profilePicture"
                    ref="profilePictureInputRef" @input="handleProfileInput">
            </div>
            <div>
                <InputLabel for="name" value="Name" />

                <TextInput id="name" type="text" class="block w-full mt-1" v-model="form.name" required autofocus
                    autocomplete="name" />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="email" value="Email" />

                <TextInput id="email" type="email" class="block w-full mt-1" v-model="form.email" required
                    autocomplete="username" />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="mt-2 text-sm text-gray-800">
                    Your email address is unverified.
                    <Link :href="route('verification.send')" method="post" as="button"
                        class="hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 text-sm text-gray-600 underline rounded-md">
                    Click here to re-send the verification email.
                    </Link>
                </p>

                <div v-show="status === 'verification-link-sent'" class="mt-2 text-sm font-medium text-green-600">
                    A new verification link has been sent to your email address.
                </div>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
