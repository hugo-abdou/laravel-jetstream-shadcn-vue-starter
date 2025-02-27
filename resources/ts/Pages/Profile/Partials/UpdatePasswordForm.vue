<script setup lang="ts">
    import { ref } from 'vue';
    import { useForm } from '@inertiajs/vue3';

    const passwordInput = ref(null);
    const currentPasswordInput = ref(null);

    const form = useForm({
        current_password: '',
        password: '',
        password_confirmation: '',
    });

    const updatePassword = () => {
        form.put(route('user-password.update'), {
            errorBag: 'updatePassword',
            preserveScroll: true,
            onSuccess: () => form.reset(),
            onError: () => {
                if (form.errors.password) {
                    form.reset('password', 'password_confirmation');
                }

                if (form.errors.current_password) {
                    form.reset('current_password');
                }
            },
        });
    };
</script>

<template>
    <FormSection @submitted="updatePassword">
        <template #title> Update Password </template>

        <template #description> Ensure your account is using a long, random password to stay secure. </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <Label for="current_password">Current Password</Label>
                <Input
                    id="current_password"
                    ref="currentPasswordInput"
                    v-model="form.current_password"
                    type="password"
                    placeholder="********"
                    class="mt-1 block w-full"
                    autocomplete="current-password"
                />
                <InputError :message="form.errors.current_password" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <Label for="password">New Password</Label>
                <Input
                    id="password"
                    ref="passwordInput"
                    v-model="form.password"
                    type="password"
                    placeholder="********"
                    class="mt-1 block w-full"
                    autocomplete="new-password"
                />
                <InputError :message="form.errors.password" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <Label for="password_confirmation">Confirm Password</Label>
                <Input
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    placeholder="********"
                    class="mt-1 block w-full"
                    autocomplete="new-password"
                />
                <InputError :message="form.errors.password_confirmation" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <Button :class="{ 'opacity-25': form.processing }" :disabled="form.processing"> Save </Button>
            <ActionMessage :on="form.recentlySuccessful" class="me-3"> Saved. </ActionMessage>
        </template>
    </FormSection>
</template>
