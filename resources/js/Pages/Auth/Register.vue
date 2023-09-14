<script setup>
    import InputError from '@/Components/InputError.vue';
    import InputLabel from '@/Components/InputLabel.vue';
    import TextInput from '@/Components/TextInput.vue';
    import GuestLayout from '@/Layouts/GuestLayout.vue';
    import { Head, Link, useForm } from '@inertiajs/vue3';
    import Button from 'primevue/button';
    import { ref } from "vue";

    const form = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        profile_img: ''
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

    const submit = () => {
        form.post(route('register'), {
            onFinish: () => form.reset('password', 'password_confirmation'),
        });
    };
</script>

<template>
    <GuestLayout>

        <Head title="Register" />

        <form @submit.prevent="submit">
            <div class="relative mt-4">
                <InputLabel for="profilePicture" value="Profile Picture" />
                <div class="h-80 w-full" v-if="previewProfilePhoto">
                    <img :src="previewProfilePhoto" class="object-cover w-full h-full rounded">
                </div>
                <Button class="absolute bottom-0 left-0 px-3 md:px-4 md:py-2.5 mt-1 !w-full "
                    @click="() => profilePictureInputRef.click()" :icon="`pi ${form.profile_img ? 'pi-pencil' : 'pi-plus'}`"
                    outlined>
                </Button>
                <input type="file" accept="image/jpeg,image/png" class="hidden" id="profilePicture"
                    ref="profilePictureInputRef" @input="handleProfileInput">
            </div>
            <div>
                <InputLabel for="name" value="Name" />

                <TextInput id="name" type="text" class="block w-full mt-1" v-model="form.name" required autofocus
                    autocomplete="name" />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />

                <TextInput id="email" type="email" class="block w-full mt-1" v-model="form.email" required
                    autocomplete="username" />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput id="password" type="password" class="block w-full mt-1" v-model="form.password" required
                    autocomplete="new-password" />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirm Password" />

                <TextInput id="password_confirmation" type="password" class="block w-full mt-1"
                    v-model="form.password_confirmation" required autocomplete="new-password" />

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link :href="route('login')"
                    class="hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 text-sm text-gray-600 underline rounded-md">
                Already registered?
                </Link>

                <Button label="Register" class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                    outlined type="submit" />
            </div>
        </form>
    </GuestLayout>
</template>
