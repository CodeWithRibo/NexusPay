<script setup>
import { Button } from "@/components/ui/button/index.js";
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from "@/components/ui/dialog";
import { Input } from "@/components/ui/input/index.js";
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from "@/components/ui/select";
import BaseInput from "@/Pages/components/base/BaseInput.vue";
import BaseDatePicker from "@/Pages/components/base/BaseDatePicker.vue";
import { Label } from "@/components/ui/label/index.js";

const emit = defineEmits(["submit"]);
defineProps({ form: Object });

const handleSubmit = () => {
    emit("submit");
};
</script>

<template>
    <Dialog>
        <DialogTrigger>
            <Button>Register Account</Button>
            <DialogContent>
                <DialogHeader>
                    <DialogTitle>Register Account</DialogTitle>
                    <DialogDescription>
                        <form @submit.prevent="handleSubmit">
                            <Label>Role</Label>
                            <Select class="w-full" v-model="form.role">
                                <SelectTrigger
                                    :error="form.errors.role"
                                    class="w-full"
                                >
                                    <SelectValue placeholder="Select role" />
                                </SelectTrigger>
                                <SelectContent>
                                    <SelectItem value="student"
                                        >Student</SelectItem
                                    >
                                    <SelectItem value="cashier"
                                        >Cashier</SelectItem
                                    >
                                    <SelectItem value="admin">Admin</SelectItem>
                                </SelectContent>
                            </Select>
                            <div v-if="form.role === 'student'">
                                <BaseInput
                                    label="Student ID"
                                    placeholder="02000411497"
                                    v-model="form.student_id"
                                    :error="form.errors.student_id"
                                />
                            </div>
                            <BaseInput
                                label="Email"
                                placeholder="zeamon@gmail.com"
                                v-model="form.email"
                                :error="form.errors.email"
                            />
                            <BaseInput
                                label="First Name"
                                placeholder="Zeamon"
                                v-model="form.first_name"
                                :error="form.errors.first_name"
                            />
                            <BaseInput
                                label="Last Name"
                                placeholder="Mabaog"
                                v-model="form.last_name"
                                :error="form.errors.last_name"
                            />
                            <BaseInput
                                label="Address"
                                placeholder="123 Samson Road"
                                v-model="form.address"
                                :error="form.errors.address"
                            />
                            <div class="flex flex-col">
                                <Label for="birth_date">Birth Date</Label>
                                <BaseDatePicker
                                    v-model="form.birth_date"
                                    :error="form.errors.birth_date"
                                />
                            </div>
                            <BaseInput
                                label="Phone Number (Optional)"
                                placeholder="09933404419"
                                v-model="form.phone_number"
                            />
                            <Button type="submit">Submit</Button>
                        </form>
                    </DialogDescription>
                </DialogHeader>
            </DialogContent>
        </DialogTrigger>
    </Dialog>
</template>
