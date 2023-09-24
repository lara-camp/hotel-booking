<script setup>
    import { Head, Link, useForm } from '@inertiajs/vue3';
    import Button from 'primevue/button';
    import InlineMessage from 'primevue/inlinemessage';
    import InputText from 'primevue/inputtext';
    import Password from 'primevue/password';
    import { ref } from "vue";

    const form = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        profile_image: ''
    });

    // Profile Picture
    const previewProfilePhoto = ref(null);
    const profilePictureInputRef = ref();
    function handleProfileInput(event) {
        const target = event.target;
        const file = target.files;

        previewProfilePhoto.value = URL.createObjectURL(file[0]);
        form.profile_image = file[0];
    }

    const submit = () => {
        form.post(route('register'), {
            onFinish: () => form.reset('password', 'password_confirmation'),
        });
    };
</script>

<template>
    <Head title="Register" />

    <form @submit.prevent="submit" class="">
        <div class="relative my-4">
            <div class="h-80 w-full" v-if="previewProfilePhoto">
                <img :src="previewProfilePhoto" class="object-cover w-full h-full rounded">
            </div>
            <Button class="absolute bottom-0 left-0 px-3 md:px-4 md:py-2.5 mt-1 !w-full "
                @click="() => profilePictureInputRef.click()" :icon="`pi ${form.profile_image ? 'pi-pencil' : 'pi-plus'}`"
                outlined label="Profile Picture">
            </Button>
            <input type="file" accept="image/jpeg,image/png" class="hidden" id="profilePicture" ref="profilePictureInputRef"
                @input="handleProfileInput">
        </div>
        <div class="flex flex-col mb-4">
            <InputText id="name" v-model="form.name" size="small" placeholder="Name" required autofocus />
            <InlineMessage v-if="form.errors.name" severity="error" class="mt-2">{{ form.errors.name }}</InlineMessage>
        </div>
        <div class="flex flex-col mb-4">
            <InputText id="email" v-model="form.email" size="small" placeholder="Email" required autofocus />
            <InlineMessage v-if="form.errors.email" severity="error" class="mt-2">{{ form.errors.email }}</InlineMessage>
        </div>
        <div class="flex flex-col mb-4">
            <Password v-model="form.password" toggle-mask :feedback="true" id="current_password" size="small" class="w-full"
                placeholder="Password" required />
            <InlineMessage v-if="form.errors.password" severity="error" class="mt-2">
                {{ form.errors.password }}
            </InlineMessage>
        </div>
        <div class="flex flex-col mb-4">
            <Password v-model="form.password_confirmation" toggle-mask :feedback="false" id="confirm_password" size="small"
                class="w-full" placeholder="Confirm Password" required />
            <InlineMessage v-if="form.errors.password_confirmation" severity="error" class="mt-2">
                {{ form.errors.password_confirmation }}
            </InlineMessage>
        </div>
        <div class="flex justify-between">
            <Button label="Register" outlined type="submit" :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing" :loading="form.processing" />
            <Link :href="route('login')">
            <Button label="Already Registered?" text />
            </Link>
        </div>
    </form>
</template>
<script>
    import AuthLayout from '@/Layouts/AuthLayout.vue';
    export default {
        layout: AuthLayout
    }
</script>
<style scoped>
    :deep(.p-password-input) {
        width: 100%;
        padding: 14px;
        border-radius: 4px;
    }
</style>