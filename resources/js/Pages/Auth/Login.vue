<script setup>
    import { useForm, Link } from '@inertiajs/vue3';
    import InlineMessage from 'primevue/inlinemessage';
    import InputText from 'primevue/inputtext';
    import Button from 'primevue/button';
    import Password from 'primevue/password';
    import Checkbox from 'primevue/checkbox';

    defineProps({
        canResetPassword: {
            type: Boolean,
        },
        status: {
            type: String,
        },
    });

    const form = useForm({
        email: '',
        password: '',
        remember: false,
    });

    const submit = () => {
        form.post(route('login'), {
            onFinish: () => form.reset('password'),
        });
    };
</script>

<template>
    <form class="" @submit.prevent="submit">
        <div class="flex flex-col mb-4">
            <InputText id="email" v-model="form.email" size="small" placeholder="Email" required autofocus />
            <InlineMessage v-if="form.errors.email" severity="error" class="mt-2">{{ form.errors.email }}</InlineMessage>
        </div>
        <div class="flex flex-col mb-4">
            <Password v-model="form.password" toggle-mask :feedback="false" id="current_password" size="small"
                class="w-full" ref="currentPasswordInput" placeholder="Password" required />
            <InlineMessage v-if="form.errors.password" severity="error" class="mt-2">
                {{ form.errors.password }}
            </InlineMessage>
        </div>
        <div class="flex items-center mb-4">
            <Checkbox v-model="form.remember" :binary="true" input-id="remember" name="remember" />
            <label for="remember" class="ml-2 text-gray-600 select-none">Remember me </label>
        </div>
        <div class="flex justify-between">
            <Button label="Login" outlined type="submit" :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing" />
            <div class="">
                <Link :href="route('register')">
                <Button label="Register" text />
                </Link>
                <Link :href="route('password.request')" v-if="canResetPassword">
                <Button label="Forgot Password?" text />
                </Link>
            </div>
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