<script setup>
import BaseInput from "@/Pages/components/base/BaseInput.vue";

const emit = defineEmits(["submit"]);
defineProps({ form: Object });
const handleSubmit = () => {
    emit("submit");
};
</script>

<template>
    <div>
        <form @submit.prevent="handleSubmit">
            <fieldset
                class="fieldset bg-base-200 border-base-300 rounded-box w-xs border p-4"
            >
                <legend class="fieldset-legend">Register</legend>

                <select class="select" v-model="form.role">
                    <option disabled selected>Select Role</option>
                    <option value="student">Student</option>
                    <option value="cashier">Cashier</option>
                    <option value="admin">Admin</option>
                </select>
                <div v-if="form.errors.role">
                    {{ form.errors.role }}
                </div>

                <div v-if="form.role === 'student'">
                    <BaseInput
                        type="text"
                        label="Student ID"
                        placeholder="02000411496"
                        v-model="form.student_id"
                    />
                </div>
                <div v-if="form.errors.student_id">
                    {{ form.errors.student_id }}
                </div>
                <BaseInput
                    type="text"
                    label="First Name"
                    placeholder="Juan"
                    v-model="form.first_name"
                />
                <div v-if="form.errors.first_name">
                    {{ form.errors.first_name }}
                </div>
                <BaseInput
                    type="text"
                    label="Last Name"
                    placeholder="Dela Cruz"
                    v-model="form.last_name"
                />
                <div v-if="form.errors.last_name">
                    {{ form.errors.last_name }}
                </div>
                <BaseInput
                    type="email"
                    label="Email"
                    placeholder="juandelacruz@gmail.com"
                    v-model="form.email"
                />
                <div v-if="form.errors.email">
                    {{ form.errors.email }}
                </div>
                <BaseInput
                    type="text"
                    label="Address"
                    placeholder="123 Samson Road"
                    v-model="form.address"
                />
                <div v-if="form.errors.address">
                    {{ form.errors.address }}
                </div>
                <BaseInput
                    type="date"
                    label="Birth Date"
                    v-model="form.birth_date"
                />
                <div v-if="form.errors.birth_date">
                    {{ form.errors.birth_date }}
                </div>
                <BaseInput
                    type="text"
                    label="Phone Number"
                    placeholder="09933404219"
                    v-model="form.phone_number"
                />
                <div v-if="form.errors.phone_number">
                    {{ form.errors.phone_number }}
                </div>

                <button type="submit" class="btn btn-neutral mt-4">
                    Register
                </button>
            </fieldset>
        </form>
    </div>
</template>
