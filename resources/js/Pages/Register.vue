<script setup>
import { useForm } from "@inertiajs/vue3";
import RegisterForm from "@/Pages/components/auth/RegisterForm.vue";

const form = useForm({
    student_id: null,
    first_name: null,
    last_name: null,
    email: null,
    address: null,
    birth_date: null,
    phone_number: null,
    role: null,
});

const submitForm = () => {
    form.post(route("register.store"), {
        onSuccess: () => form.reset(),
        onError: (error) => {},
    });
};
</script>

<template>
    <div class="text-5xl">Hello World</div>
    <div
        class="flex items-center justify-center mx-auto min-h-screen max-w-7xl"
    >
        <RegisterForm :form="form" @submit="submitForm" />
    </div>
</template>
