<script setup>
    import { useForm } from '@inertiajs/vue3';
    import Button from 'primevue/button';
    import InlineMessage from "primevue/inlinemessage";
    import Password from "primevue/password";
    import Toast from 'primevue/toast';
    import { useToast } from 'primevue/usetoast';

    const toast = useToast()

    const form = useForm({
        current_password: '',
        password: '',
        password_confirmation: '',
    });

    const updatePassword = () => {
        form.put(route('password.update'), {
            preserveScroll: true,
            onSuccess: () => {
                form.reset();
                toast.add({
                    severity: "success",
                    summary: "Success",
                    detail: "Password is updated successfully",
                    life: 3000
                })
            },
        });
    };
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Update Password</h2>

            <p class=" mt-1 text-sm text-gray-600">
                Ensure your account is using a long, random password to stay secure.
            </p>
        </header>

        <form @submit.prevent="updatePassword" class="mt-6 space-y-6">
            <div class="flex flex-col mb-2">
                <label for="current_password">Current Password</label>
                <Password v-model="form.current_password" toggle-mask :feedback="false" id="current_password" size="small"
                    class="w-full" ref="currentPasswordInput" />
                <InlineMessage v-if="form.errors.current_password" severity="error" class="mt-2">
                    {{ form.errors.current_password }}
                </InlineMessage>
            </div>
            <div class="flex flex-col mb-2">
                <label for="password">New Password</label>
                <Password v-model="form.password" toggleMask id="password" size="small" class="w-full"
                    ref="passwordInput" />
                <InlineMessage v-if="form.errors.password" severity="error" class="mt-2">{{ form.errors.password }}
                </InlineMessage>
            </div>
            <div class="flex flex-col mb-2">
                <label for="password_confirmation">Confirm Password</label>
                <Password v-model="form.password_confirmation" toggleMask :feedback="false" id="password_confirmation"
                    size="small" class="w-full" />
                <InlineMessage v-if="form.errors.password_confirmation" severity="error" class="mt-2">
                    {{ form.errors.password_confirmation }}
                </InlineMessage>
            </div>
            <div class="">
                <Button label="Save" icon="pi pi-save" outlined="" :loading="form.processing" type="submit" />
            </div>
        </form>
        <Toast position="bottom-right" />
    </section>
</template>
<style scoped>
    :deep(.p-password-input) {
        width: 100%;
        padding: 14px;
        border-radius: 4px;
    }
</style>